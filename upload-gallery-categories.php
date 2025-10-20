<?php
/**
 * Upload Gallery with Categories
 * Uploads images from Shipment 6 Photo folder to database with category support
 */

require_once('wp-load.php');

global $wpdb;

// Source folder
$source_folder = '/Users/sakdachoommanee/Downloads/Shipment 6 Photo';

// Database table for gallery categories
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Create tables if not exist
$wpdb->query("
    CREATE TABLE IF NOT EXISTS {$categories_table} (
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

$wpdb->query("
    CREATE TABLE IF NOT EXISTS {$images_table} (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT NOT NULL,
        image_path VARCHAR(500) NOT NULL,
        image_url VARCHAR(500) NOT NULL,
        image_name VARCHAR(255),
        file_size INT,
        display_order INT DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        KEY category_id (category_id),
        FOREIGN KEY (category_id) REFERENCES {$categories_table}(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

echo "📦 Starting Gallery Upload...\n\n";

// Get all category folders
$folders = glob($source_folder . '/*', GLOB_ONLYDIR);
sort($folders);

$upload_dir = wp_upload_dir();
$gallery_base = $upload_dir['basedir'] . '/gallery-categories/';
$gallery_base_url = $upload_dir['baseurl'] . '/gallery-categories/';

// Create base gallery directory
if (!file_exists($gallery_base)) {
    wp_mkdir_p($gallery_base);
}

$total_categories = 0;
$total_images = 0;

foreach ($folders as $folder) {
    $category_code = basename($folder);

    // Skip hidden folders
    if (strpos($category_code, '.') === 0) {
        continue;
    }

    echo "📁 Processing category: {$category_code}\n";

    // Create category directory
    $category_dir = $gallery_base . $category_code . '/';
    if (!file_exists($category_dir)) {
        wp_mkdir_p($category_dir);
    }

    // Get all images in folder (skip videos)
    $images = glob($folder . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);

    if (empty($images)) {
        echo "   ⚠️  No images found\n";
        continue;
    }

    // Insert or update category
    $existing_cat = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$categories_table} WHERE category_code = %s",
        $category_code
    ));

    if ($existing_cat) {
        $category_id = $existing_cat->id;
        echo "   ✓ Category exists (ID: {$category_id})\n";
    } else {
        $wpdb->insert($categories_table, array(
            'category_code' => $category_code,
            'category_name' => 'Rooster ' . $category_code,
            'description' => 'Photo collection for rooster ' . $category_code,
            'image_count' => 0,
            'display_order' => (int)$category_code
        ));
        $category_id = $wpdb->insert_id;
        $total_categories++;
        echo "   ✓ Category created (ID: {$category_id})\n";
    }

    // Upload images
    $image_count = 0;
    $first_image = null;

    foreach ($images as $index => $image) {
        $filename = basename($image);
        $destination = $category_dir . $filename;

        // Copy image
        if (!file_exists($destination)) {
            if (copy($image, $destination)) {
                $file_size = filesize($destination);
                $image_url = $gallery_base_url . $category_code . '/' . $filename;

                // Save first image as thumbnail
                if ($index === 0) {
                    $first_image = $image_url;
                }

                // Insert into database
                $wpdb->insert($images_table, array(
                    'category_id' => $category_id,
                    'image_path' => $destination,
                    'image_url' => $image_url,
                    'image_name' => $filename,
                    'file_size' => $file_size,
                    'display_order' => $index
                ));

                $image_count++;
                $total_images++;
            }
        } else {
            $image_count++;
            if ($index === 0 && !$first_image) {
                $first_image = $gallery_base_url . $category_code . '/' . $filename;
            }
        }
    }

    // Update category image count and thumbnail
    $wpdb->update(
        $categories_table,
        array(
            'image_count' => $image_count,
            'thumbnail' => $first_image
        ),
        array('id' => $category_id)
    );

    echo "   ✓ Uploaded {$image_count} images\n\n";
}

echo "✅ Upload Complete!\n";
echo "📊 Summary:\n";
echo "   - Categories: {$total_categories} new\n";
echo "   - Images: {$total_images} uploaded\n";
echo "   - Location: {$gallery_base}\n";
