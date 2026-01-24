<?php
/**
 * Download ALL media files from Railway to localhost
 * Run: php download-all-media.php
 */

require_once __DIR__ . '/../wp-load.php';

global $wpdb;

echo "🔍 Finding all media files in database...\n\n";

$upload_dir = ABSPATH . 'wp-content/uploads';
$downloaded = 0;
$skipped = 0;
$failed = 0;

// Get all attachment posts (media files)
$attachments = $wpdb->get_results("
    SELECT ID, guid, post_mime_type
    FROM {$wpdb->prefix}posts 
    WHERE post_type = 'attachment'
    ORDER BY ID
");

echo "Found " . count($attachments) . " media files in database\n\n";

foreach ($attachments as $attachment) {
    $guid = $attachment->guid;
    
    // Skip if not an image/media URL
    if (strpos($guid, '/wp-content/uploads/') === false) {
        continue;
    }
    
    // Extract path after /wp-content/uploads/
    preg_match('#/wp-content/uploads/(.+)$#', $guid, $matches);
    if (empty($matches[1])) {
        continue;
    }
    
    $relative_path = $matches[1];
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
        $guid, // Original URL
        'https://nongchok-production.up.railway.app/wp-content/uploads/' . $relative_path,
        'https://nongchokayambangkok.com/wp-content/uploads/' . $relative_path
    ];
    
    $success = false;
    
    foreach ($sources as $source) {
        $host = parse_url($source, PHP_URL_HOST);
        echo "↓ Downloading: $relative_path from $host ... ";
        
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
    
    // Small delay
    usleep(50000); // 0.05 second
}

echo "\n";
echo "=====================================\n";
echo "✓ Downloaded: $downloaded files\n";
echo "⊘ Skipped (exists): $skipped files\n";
echo "✗ Failed: $failed files\n";
echo "=====================================\n";
