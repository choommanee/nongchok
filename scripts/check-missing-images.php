<?php
/**
 * Check for missing images in localhost
 * Run: php check-missing-images.php
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

global $wpdb;

echo "Checking for missing images...\n\n";

$missing = [];
$found = 0;

// Check gallery images
$gallery_images = $wpdb->get_results("
    SELECT id, category_id, image_url, thumbnail_url 
    FROM {$wpdb->prefix}gallery_images
");

echo "Checking " . count($gallery_images) . " gallery images...\n";

foreach ($gallery_images as $img) {
    $image_path = ABSPATH . 'wp-content/uploads' . $img->image_url;
    
    if (!file_exists($image_path)) {
        $missing[] = [
            'type' => 'gallery',
            'id' => $img->id,
            'category_id' => $img->category_id,
            'path' => $img->image_url
        ];
        echo "✗ Missing: {$img->image_url}\n";
    } else {
        $found++;
    }
    
    // Check thumbnail
    if ($img->thumbnail_url) {
        $thumb_path = ABSPATH . 'wp-content/uploads' . $img->thumbnail_url;
        if (!file_exists($thumb_path)) {
            $missing[] = [
                'type' => 'thumbnail',
                'id' => $img->id,
                'path' => $img->thumbnail_url
            ];
            echo "✗ Missing thumbnail: {$img->thumbnail_url}\n";
        }
    }
}

echo "\n";
echo "=====================================\n";
echo "✓ Found: $found images\n";
echo "✗ Missing: " . count($missing) . " images\n";
echo "=====================================\n\n";

if (!empty($missing)) {
    echo "Missing images by category:\n";
    
    $by_category = [];
    foreach ($missing as $m) {
        if ($m['type'] === 'gallery') {
            $cat_id = $m['category_id'];
            if (!isset($by_category[$cat_id])) {
                $category = $wpdb->get_row("SELECT category_name FROM {$wpdb->prefix}gallery_categories WHERE id = $cat_id");
                $by_category[$cat_id] = [
                    'name' => $category ? $category->category_name : "Unknown ($cat_id)",
                    'count' => 0
                ];
            }
            $by_category[$cat_id]['count']++;
        }
    }
    
    foreach ($by_category as $cat) {
        echo "  - {$cat['name']}: {$cat['count']} missing\n";
    }
}

echo "\n";
