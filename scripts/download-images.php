<?php
/**
 * Script to download all images from Railway database
 * Run: php download-images.php
 */

// Database connection
$host = 'nozomi.proxy.rlwy.net';
$port = 42710;
$dbname = 'railway';
$username = 'root';
$password = 'jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to database\n\n";
    
    // Create downloads directory
    $download_dir = __DIR__ . '/railway_uploads';
    if (!is_dir($download_dir)) {
        mkdir($download_dir, 0755, true);
    }
    
    // Get all image URLs from posts
    $stmt = $pdo->query("
        SELECT DISTINCT 
            SUBSTRING_INDEX(SUBSTRING_INDEX(post_content, 'src=\"', -1), '\"', 1) as image_url
        FROM wp_posts 
        WHERE post_content LIKE '%/wp-content/uploads/%'
        AND post_status = 'publish'
    ");
    
    $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get images from postmeta
    $stmt = $pdo->query("
        SELECT meta_value 
        FROM wp_postmeta 
        WHERE meta_key = '_wp_attached_file'
    ");
    
    $attached_files = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get images from gallery tables
    $stmt = $pdo->query("
        SELECT image_url, thumbnail_url 
        FROM wp_gallery_images
    ");
    
    $gallery_images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $all_images = array_merge($images, $attached_files);
    
    foreach ($gallery_images as $img) {
        if (!empty($img['image_url'])) {
            $all_images[] = $img['image_url'];
        }
        if (!empty($img['thumbnail_url'])) {
            $all_images[] = $img['thumbnail_url'];
        }
    }
    
    $all_images = array_unique($all_images);
    $all_images = array_filter($all_images);
    
    echo "Found " . count($all_images) . " images\n\n";
    
    $downloaded = 0;
    $failed = 0;
    
    foreach ($all_images as $image) {
        // Clean up URL
        $image = trim($image);
        
        // Skip if not an image URL
        if (empty($image) || strpos($image, '/wp-content/uploads/') === false) {
            continue;
        }
        
        // Build full URL
        if (strpos($image, 'http') !== 0) {
            $image = 'https://nongchok-production.up.railway.app' . $image;
        }
        
        // Get relative path
        preg_match('#/wp-content/uploads/(.+)$#', $image, $matches);
        if (empty($matches[1])) {
            continue;
        }
        
        $relative_path = $matches[1];
        $local_path = $download_dir . '/' . $relative_path;
        
        // Create directory if needed
        $local_dir = dirname($local_path);
        if (!is_dir($local_dir)) {
            mkdir($local_dir, 0755, true);
        }
        
        // Skip if already downloaded
        if (file_exists($local_path)) {
            echo "⊘ Skip (exists): $relative_path\n";
            continue;
        }
        
        // Download image
        echo "↓ Downloading: $relative_path ... ";
        
        $ch = curl_init($image);
        $fp = fopen($local_path, 'wb');
        
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        fclose($fp);
        
        if ($result && $http_code == 200) {
            $size = filesize($local_path);
            echo "✓ (" . number_format($size / 1024, 2) . " KB)\n";
            $downloaded++;
        } else {
            echo "✗ (HTTP $http_code)\n";
            unlink($local_path);
            $failed++;
        }
        
        // Small delay to avoid overwhelming server
        usleep(100000); // 0.1 second
    }
    
    echo "\n";
    echo "=====================================\n";
    echo "✓ Downloaded: $downloaded files\n";
    echo "✗ Failed: $failed files\n";
    echo "📁 Location: $download_dir\n";
    echo "=====================================\n";
    
} catch (PDOException $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
    exit(1);
}
