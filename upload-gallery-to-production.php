<?php
/**
 * Upload Gallery to Production Database
 */

$db_host = 'nozomi.proxy.rlwy.net';
$db_port = '42710';
$db_name = 'railway';
$db_user = 'root';
$db_pass = 'jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw';

$local_image_folder = '/Users/sakdachoommanee/Downloads/Shipment 6 Photo';

echo "🔌 Connecting to production database...\n";
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

if ($mysqli->connect_error) {
    die("❌ Connection failed: " . $mysqli->connect_error . "\n");
}

echo "✅ Connected\n\n📊 Creating tables...\n";

$mysqli->query("CREATE TABLE IF NOT EXISTS wp_gallery_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_number VARCHAR(10) NOT NULL UNIQUE,
    category_name VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail_url VARCHAR(500),
    image_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$mysqli->query("CREATE TABLE IF NOT EXISTS wp_gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    thumbnail_url VARCHAR(500),
    title VARCHAR(255),
    alt_text VARCHAR(255),
    file_size INT,
    width INT,
    height INT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES wp_gallery_categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo "✅ Tables ready\n\n📁 Processing images...\n";

$folders = scandir($local_image_folder);
$folders = array_diff($folders, array('.', '..', '.DS_Store'));
sort($folders);

$total_categories = 0;
$total_images = 0;

foreach ($folders as $folder) {
    $folder_path = $local_image_folder . '/' . $folder;
    if (!is_dir($folder_path)) continue;

    $category_number = $folder;
    $category_name = "Rooster Category " . $folder;

    echo "\n📂 {$category_number}: ";

    $stmt = $mysqli->prepare("SELECT id FROM wp_gallery_categories WHERE category_number = ?");
    $stmt->bind_param("s", $category_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category_id = $result->fetch_assoc()['id'];
        echo "exists (ID:{$category_id}) ";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO wp_gallery_categories (category_number, category_name, description) VALUES (?, ?, ?)");
        $desc = "Rooster category " . $folder;
        $stmt->bind_param("sss", $category_number, $category_name, $desc);
        $stmt->execute();
        $category_id = $stmt->insert_id;
        echo "created ";
        $total_categories++;
    }

    $images = glob($folder_path . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    $count = 0;

    foreach ($images as $image_path) {
        $filename = basename($image_path);
        $image_url = "/wp-content/uploads/gallery/{$category_number}/{$filename}";

        $stmt = $mysqli->prepare("SELECT id FROM wp_gallery_images WHERE category_id = ? AND image_url = ?");
        $stmt->bind_param("is", $category_id, $image_url);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) continue;

        $info = getimagesize($image_path);
        $width = $info[0] ?? 0;
        $height = $info[1] ?? 0;
        $size = filesize($image_path);
        $title = pathinfo($filename, PATHINFO_FILENAME);
        $alt = "Rooster {$category_number}";

        $stmt = $mysqli->prepare("INSERT INTO wp_gallery_images (category_id, image_url, thumbnail_url, title, alt_text, file_size, width, height, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssiiii", $category_id, $image_url, $image_url, $title, $alt, $size, $width, $height, $count);
        $stmt->execute();
        $count++;
        $total_images++;
    }

    if ($count > 0) {
        $first = glob($folder_path . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE)[0];
        $thumb = "/wp-content/uploads/gallery/{$category_number}/" . basename($first);
        $stmt = $mysqli->prepare("UPDATE wp_gallery_categories SET image_count = ?, thumbnail_url = ? WHERE id = ?");
        $stmt->bind_param("isi", $count, $thumb, $category_id);
        $stmt->execute();
        echo "+{$count} images";
    }
}

echo "\n\n✅ Database updated: {$total_categories} categories, {$total_images} images\n";
$mysqli->close();
