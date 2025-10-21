<?php
/**
 * Re-upload ALL gallery images to Railway production
 */

set_time_limit(0);
ini_set('memory_limit', '512M');

$production_url = 'https://nongchok-production.up.railway.app/gallery-upload-receiver.php';
$secret_key = 'nongchok2025gallery';
$source_folder = '/Users/sakdachoommanee/Downloads/Shipment 6 Photo';

// Database connection
$db_host = 'nozomi.proxy.rlwy.net:42710';
$db_user = 'root';
$db_pass = 'jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw';
$db_name = 'railway';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get all images from database
$stmt = $pdo->query("
    SELECT i.*, c.category_number
    FROM wp_gallery_images i
    JOIN wp_gallery_categories c ON i.category_id = c.id
    ORDER BY c.category_number ASC, i.sort_order ASC
");
$all_images = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Found " . count($all_images) . " images to upload\n\n";

$success = 0;
$failed = 0;
$skipped = 0;

foreach ($all_images as $index => $image) {
    $category_folder = $image['category_number'];
    $filename = basename($image['image_url']);
    $local_path = "$source_folder/$category_folder/$filename";

    echo sprintf("[%d/%d] Uploading %s... ", $index + 1, count($all_images), "$category_folder/$filename");

    // Check if file exists locally
    if (!file_exists($local_path)) {
        echo "❌ File not found locally\n";
        $failed++;
        continue;
    }

    // Check file size
    $file_size = filesize($local_path);
    if ($file_size > 10 * 1024 * 1024) { // > 10MB
        echo "⚠️  Too large ($file_size bytes), resizing... ";

        // Resize image
        $image_info = getimagesize($local_path);
        $mime_type = $image_info['mime'];

        if ($mime_type === 'image/jpeg') {
            $source = imagecreatefromjpeg($local_path);
        } elseif ($mime_type === 'image/png') {
            $source = imagecreatefrompng($local_path);
        } else {
            echo "❌ Unsupported format\n";
            $failed++;
            continue;
        }

        $width = imagesx($source);
        $height = imagesy($source);

        // Resize if needed
        if ($width > 2000 || $height > 2000) {
            $ratio = min(2000/$width, 2000/$height);
            $new_width = round($width * $ratio);
            $new_height = round($height * $ratio);

            $resized = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            $temp_file = sys_get_temp_dir() . '/' . $filename;
            imagejpeg($resized, $temp_file, 85);
            imagedestroy($resized);
            imagedestroy($source);

            $local_path = $temp_file;
            $file_size = filesize($local_path);
            echo "resized to {$file_size} bytes... ";
        }
    }

    // Upload via HTTP
    $ch = curl_init();
    $post_data = [
        'category' => $category_folder,
        'file' => new CURLFile($local_path, mime_content_type($local_path), $filename)
    ];

    // Add secret key to URL query string
    $upload_url = $production_url . '?secret=' . urlencode($secret_key);

    curl_setopt_array($ch, [
        CURLOPT_URL => $upload_url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Clean up temp file if created
    if (isset($temp_file) && file_exists($temp_file)) {
        unlink($temp_file);
        unset($temp_file);
    }

    if ($http_code === 200 && strpos($response, 'success') !== false) {
        echo "✅\n";
        $success++;
    } else {
        echo "❌ HTTP $http_code - $response\n";
        $failed++;
    }

    // Small delay to avoid overwhelming server
    usleep(100000); // 0.1 second
}

echo "\n=== UPLOAD SUMMARY ===\n";
echo "✅ Success: $success\n";
echo "❌ Failed: $failed\n";
echo "⏭️  Skipped: $skipped\n";
echo "Total: " . count($all_images) . "\n";
