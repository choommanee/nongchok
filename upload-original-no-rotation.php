<?php
/**
 * Upload ALL images WITHOUT rotation - keep original orientation
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

// Get ALL images
$stmt = $pdo->query("
    SELECT i.*, c.category_number
    FROM wp_gallery_images i
    JOIN wp_gallery_categories c ON i.category_id = c.id
    ORDER BY c.category_number ASC, i.sort_order ASC
");
$all_images = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Found " . count($all_images) . " images to upload (NO rotation, resize only if needed)\n\n";

$success = 0;
$failed = 0;

foreach ($all_images as $index => $image) {
    $category_folder = $image['category_number'];
    $filename = basename($image['image_url']);
    $local_path = "$source_folder/$category_folder/$filename";

    echo sprintf("[%d/%d] Processing %s... ", $index + 1, count($all_images), "$category_folder/$filename");

    if (!file_exists($local_path)) {
        echo "❌ File not found\n";
        $failed++;
        continue;
    }

    $file_size = filesize($local_path);

    // Always resize large IMG files
    $needs_resize = (strpos($filename, 'IMG_') === 0 && $file_size > 5 * 1024 * 1024);

    if ($needs_resize) {
        echo "resize... ";

        $image_info = @getimagesize($local_path);
        if ($image_info === false) {
            echo "❌ Cannot read\n";
            $failed++;
            continue;
        }

        $mime_type = $image_info['mime'];
        $source = null;

        if ($mime_type === 'image/jpeg') {
            $source = @imagecreatefromjpeg($local_path);
        } elseif ($mime_type === 'image/png') {
            $source = @imagecreatefrompng($local_path);
        }

        if (!$source) {
            echo "❌ Cannot load\n";
            $failed++;
            continue;
        }

        // Fix EXIF orientation FIRST before getting dimensions
        if ($mime_type === 'image/jpeg') {
            $exif = @exif_read_data($local_path);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                echo "EXIF:$orientation... ";

                switch ($orientation) {
                    case 3:
                        $source = imagerotate($source, 180, 0);
                        break;
                    case 6:
                        $source = imagerotate($source, -90, 0);
                        break;
                    case 8:
                        $source = imagerotate($source, 90, 0);
                        break;
                }
            }
        }

        // NOW get correct dimensions after rotation
        $width = imagesx($source);
        $height = imagesy($source);

        // Resize to max 2000px
        $max_dimension = 2000;
        if ($width > $max_dimension || $height > $max_dimension) {
            $ratio = min($max_dimension/$width, $max_dimension/$height);
            $new_width = round($width * $ratio);
            $new_height = round($height * $ratio);

            echo "{$width}x{$height}→{$new_width}x{$new_height}... ";

            $resized = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            $temp_file = sys_get_temp_dir() . '/gallery_' . $filename;
            imagejpeg($resized, $temp_file, 90);
            imagedestroy($resized);
            imagedestroy($source);

            $upload_path = $temp_file;
        } else {
            imagedestroy($source);
            $upload_path = $local_path;
        }
    } else {
        // File small enough - use original
        $upload_path = $local_path;
    }

    // Upload via HTTP
    $ch = curl_init();
    $post_data = [
        'category' => $category_folder,
        'file' => new CURLFile($upload_path, mime_content_type($upload_path), $filename)
    ];

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

    // Clean up temp file
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

    usleep(100000);
}

echo "\n=== FINAL SUMMARY ===\n";
echo "✅ Success: $success\n";
echo "❌ Failed: $failed\n";
echo "Total: " . count($all_images) . "\n";
