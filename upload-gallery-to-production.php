<?php
/**
 * Upload Gallery Data to Production via MySQL Connection
 *
 * Usage: php upload-gallery-to-production.php
 */

// Production database credentials (from Railway)
$prod_host = 'junction.proxy.rlwy.net';  // Replace with actual Railway MySQL host
$prod_port = ''; // Replace with actual port if needed
$prod_user = getenv('PROD_MYSQL_USER') ?: 'root';
$prod_pass = getenv('PROD_MYSQL_PASSWORD') ?: '';
$prod_db = getenv('PROD_MYSQL_DATABASE') ?: 'railway';

// Local database
require_once('wp-load.php');
global $wpdb;

echo "🚀 Starting Production Upload...\n\n";

// Check if we have production credentials
if (empty($prod_pass)) {
    echo "⚠️  Production credentials not found!\n";
    echo "Please set environment variables:\n";
    echo "  export PROD_MYSQL_USER='your_user'\n";
    echo "  export PROD_MYSQL_PASSWORD='your_password'\n";
    echo "  export PROD_MYSQL_DATABASE='railway'\n";
    exit(1);
}

// Connect to production database
try {
    $prod_conn = new PDO(
        "mysql:host={$prod_host};port={$prod_port};dbname={$prod_db}",
        $prod_user,
        $prod_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "✓ Connected to production database\n\n";
} catch (PDOException $e) {
    echo "❌ Failed to connect to production: " . $e->getMessage() . "\n";
    exit(1);
}

// Get local data
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

$local_categories = $wpdb->get_results("SELECT * FROM {$categories_table}", ARRAY_A);
$local_images = $wpdb->get_results("SELECT * FROM {$images_table}", ARRAY_A);

echo "📊 Local Data:\n";
echo "   Categories: " . count($local_categories) . "\n";
echo "   Images: " . count($local_images) . "\n\n";

// Create tables on production
echo "📝 Creating tables on production...\n";

$prod_conn->exec("
    CREATE TABLE IF NOT EXISTS wp_gallery_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_code VARCHAR(50) NOT NULL,
        category_name VARCHAR(255) NOT NULL,
        description TEXT,
        thumbnail VARCHAR(500),
        image_count INT DEFAULT 0,
        display_order INT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY (category_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

$prod_conn->exec("
    CREATE TABLE IF NOT EXISTS wp_gallery_images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT NOT NULL,
        image_path VARCHAR(500) NOT NULL,
        image_url VARCHAR(500) NOT NULL,
        image_name VARCHAR(255),
        file_size INT,
        display_order INT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        KEY category_id (category_id),
        FOREIGN KEY (category_id) REFERENCES wp_gallery_categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

echo "✓ Tables created\n\n";

// Upload categories
echo "📤 Uploading categories...\n";
$cat_map = []; // Map local ID to production ID

$stmt = $prod_conn->prepare("
    INSERT INTO wp_gallery_categories
    (category_code, category_name, description, thumbnail, image_count, display_order)
    VALUES (?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    category_name = VALUES(category_name),
    description = VALUES(description),
    thumbnail = VALUES(thumbnail),
    image_count = VALUES(image_count),
    display_order = VALUES(display_order)
");

foreach ($local_categories as $cat) {
    $stmt->execute([
        $cat['category_code'],
        $cat['category_name'],
        $cat['description'],
        $cat['thumbnail'],
        $cat['image_count'],
        $cat['display_order']
    ]);

    // Get production ID
    $prod_id = $prod_conn->lastInsertId() ?: $prod_conn->query(
        "SELECT id FROM wp_gallery_categories WHERE category_code = '{$cat['category_code']}'"
    )->fetchColumn();

    $cat_map[$cat['id']] = $prod_id;
    echo "   ✓ {$cat['category_code']}\n";
}

echo "\n📤 Uploading images...\n";

$stmt = $prod_conn->prepare("
    INSERT INTO wp_gallery_images
    (category_id, image_path, image_url, image_name, file_size, display_order)
    VALUES (?, ?, ?, ?, ?, ?)
");

$uploaded = 0;
foreach ($local_images as $img) {
    if (!isset($cat_map[$img['category_id']])) {
        continue;
    }

    $stmt->execute([
        $cat_map[$img['category_id']],
        $img['image_path'],
        $img['image_url'],
        $img['image_name'],
        $img['file_size'],
        $img['display_order']
    ]);
    $uploaded++;
}

echo "   ✓ Uploaded {$uploaded} images\n\n";

echo "✅ Upload Complete!\n";
echo "📊 Summary:\n";
echo "   - Categories: " . count($local_categories) . "\n";
echo "   - Images: {$uploaded}\n";
echo "\n";
echo "⚠️  NOTE: Image files still need to be uploaded to production server!\n";
echo "Run this command to upload files via rsync/scp\n";
