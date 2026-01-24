<?php
/**
 * Download all WordPress generated thumbnail sizes
 * Run: php download-thumbnails.php
 */

require_once __DIR__ . '/../wp-load.php';

global $wpdb;

echo "🔍 Finding all image thumbnails...\n\n";

$upload_dir = ABSPATH . 'wp-content/uploads';
$downloaded = 0;
$skipped = 0;
$failed = 0;

// Get all image attachments with metadata
$attachments = $wpdb->get_results("
    SELECT p.ID, p.guid, pm.meta_value as metadata
    FROM {$wpdb->prefix}posts p
    LEFT JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_wp_attachment_metadata'
    WHERE p.post_type = 'attachment' 
    AND p.post_mime_type LIKE 'image/%'
    AND pm.meta_value IS NOT NULL
    ORDER BY p.ID
");

echo "Found " . count($attachments) . " images with metadata\n\n";

foreach ($attachments as $attachment) {
    $metadata = maybe_unserialize($attachment->metadata);
    
    if (!$metadata || !isset($metadata['file'])) {
        continue;
    }
    
    $base_file = $metadata['file'];
    $base_dir = dirname($base_file);
    $base_name = basename($base_file, '.' . pathinfo($base_file, PATHINFO_EXTENSION));
    $extension = pathinfo($base_file, PATHINFO_EXTENSION);
    
    // Download all thumbnail sizes
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size_name => $size_data) {
            $thumb_file = $base_dir . '/' . $size_data['file'];
            $local_path = $upload_dir . '/' . $thumb_file;
            
            // Skip if exists
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
                'https://nongchokayambangkok.com/wp-content/uploads/' . $thumb_file,
                'https://nongchok-production.up.railway.app/wp-content/uploads/' . $thumb_file
            ];
            
            $success = false;
            
            foreach ($sources as $source) {
                $host = parse_url($source, PHP_URL_HOST);
                echo "↓ $thumb_file from $host ... ";
                
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
                    echo "✗\n";
                }
            }
            
            if (!$success && file_exists($local_path)) {
                unlink($local_path);
                $failed++;
            }
            
            usleep(30000); // 0.03 second
        }
    }
}

echo "\n";
echo "=====================================\n";
echo "✓ Downloaded: $downloaded thumbnails\n";
echo "⊘ Skipped (exists): $skipped thumbnails\n";
echo "✗ Failed: $failed thumbnails\n";
echo "=====================================\n";
