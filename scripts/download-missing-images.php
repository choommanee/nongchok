<?php
/**
 * Download missing images from database URLs
 * Run: php download-missing-images.php
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

global $wpdb;

echo "Downloading missing images...\n\n";

$upload_dir = ABSPATH . 'wp-content/uploads';
$downloaded = 0;
$failed = 0;
$skipped = 0;

// Get all gallery images
$gallery_images = $wpdb->get_results("
    SELECT id, category_id, image_url, thumbnail_url 
    FROM {$wpdb->prefix}gallery_images
");

echo "Processing " . count($gallery_images) . " gallery images...\n\n";

foreach ($gallery_images as $img) {
    $image_url = $img->image_url;
    
    // Parse URL to get path
    if (strpos($image_url, 'http') === 0) {
        // Full URL - extract path after /wp-content/uploads/
        preg_match('#/wp-content/uploads/(.+)$#', $image_url, $matches);
        if (empty($matches[1])) {
            echo "⊘ Skip (invalid URL): $image_url\n";
            continue;
        }
        $relative_path = $matches[1];
    } else {
        // Relative path
        $relative_path = ltrim($image_url, '/');
    }
    
    $local_path = $upload_dir . '/' . $relative_path;
    
    // Skip if already exists
    if (file_exists($local_path)) {
        $skipped++;
        continue;
    }
    
    // Create directory
    $local_dir = dirname($local_path);
    if (!is_dir($local_dir)) {
        mkdir($local_dir, 0755, true);
    }
    
    // Try multiple sources
    $sources = [
        $image_url, // Original URL
        'https://nongchok-production.up.railway.app/wp-content/uploads/' . $relative_path,
        'https://nongchokayambangkok.com/wp-content/uploads/' . $relative_path
    ];
    
    $success = false;
    
    foreach ($sources as $source) {
        echo "↓ Trying: $relative_path from " . parse_url($source, PHP_URL_HOST) . " ... ";
        
        $ch = curl_init($source);
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
            $success = true;
            break;
        } else {
            echo "✗ (HTTP $http_code)\n";
        }
    }
    
    if (!$success) {
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
echo "⊘ Skipped (exists): $skipped files\n";
echo "✗ Failed: $failed files\n";
echo "=====================================\n";
