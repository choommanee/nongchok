<?php
/**
 * Download missing gallery images from production site
 */

require_once __DIR__ . '/../wp-load.php';

global $wpdb;

$upload_dir = ABSPATH . 'wp-content/uploads';
$downloaded = 0;
$failed = 0;

// Get all gallery images that might be missing
$images = $wpdb->get_results("
    SELECT image_url 
    FROM {$wpdb->prefix}gallery_images
    ORDER BY id
");

echo "Checking " . count($images) . " gallery images...\n\n";

foreach ($images as $img) {
    $path = $img->image_url;
    
    // Remove leading slash if exists
    $path = ltrim($path, '/');
    
    $local_path = $upload_dir . '/' . $path;
    
    // Skip if exists
    if (file_exists($local_path)) {
        continue;
    }
    
    // Create directory
    $local_dir = dirname($local_path);
    if (!is_dir($local_dir)) {
        mkdir($local_dir, 0755, true);
    }
    
    // Try to download from production site
    $url = 'https://nongchokayambangkok.com/wp-content/uploads/' . $path;
    
    echo "↓ Downloading: $path ... ";
    
    $ch = curl_init($url);
    $fp = fopen($local_path, 'wb');
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    fclose($fp);
    
    if ($result && $http_code == 200 && filesize($local_path) > 0) {
        $size = filesize($local_path);
        echo "✓ (" . number_format($size / 1024, 2) . " KB)\n";
        $downloaded++;
    } else {
        echo "✗ (HTTP $http_code)\n";
        if (file_exists($local_path)) {
            unlink($local_path);
        }
        $failed++;
    }
    
    usleep(100000); // 0.1 second delay
}

echo "\n";
echo "=====================================\n";
echo "✓ Downloaded: $downloaded files\n";
echo "✗ Failed: $failed files\n";
echo "=====================================\n";
