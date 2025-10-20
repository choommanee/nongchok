<?php
/**
 * Upload remaining large images with compression
 */

$production_url = 'https://nongchok-production.up.railway.app/gallery-upload-receiver.php';
$secret_key = 'nongchok2025gallery';
$local_folder = '/Users/sakdachoommanee/Downloads/Shipment 6 Photo';

$folders = scandir($local_folder);
$folders = array_diff($folders, ['.', '..', '.DS_Store']);
sort($folders);

$total_uploaded = 0;
$total_skipped = 0;

echo "🚀 Uploading remaining images with optimization...\n\n";

foreach ($folders as $category) {
    $cat_path = $local_folder . '/' . $category;
    if (!is_dir($cat_path)) continue;

    $images = glob($cat_path . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    
    foreach ($images as $img_path) {
        $filename = basename($img_path);
        $filesize = filesize($img_path);
        
        // Skip files smaller than 2MB (already uploaded successfully)
        if ($filesize < 2 * 1024 * 1024) {
            continue;
        }
        
        echo "📸 {$category}/{$filename} (" . round($filesize/1024/1024, 1) . "MB) - ";
        
        // Resize large images
        $temp_file = '/tmp/' . $filename;
        $image = null;
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if ($ext == 'jpg' || $ext == 'jpeg') {
            $image = imagecreatefromjpeg($img_path);
        } elseif ($ext == 'png') {
            $image = imagecreatefrompng($img_path);
        }
        
        if ($image) {
            $width = imagesx($image);
            $height = imagesy($image);
            
            // Resize to max 2000px
            if ($width > 2000 || $height > 2000) {
                $ratio = min(2000/$width, 2000/$height);
                $new_width = round($width * $ratio);
                $new_height = round($height * $ratio);
                
                $resized = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                
                imagejpeg($resized, $temp_file, 85);
                imagedestroy($resized);
                imagedestroy($image);
                
                $upload_file = $temp_file;
                echo "resized → ";
            } else {
                $upload_file = $img_path;
            }
        } else {
            $upload_file = $img_path;
        }
        
        // Upload
        $ch = curl_init($production_url . '?secret=' . $secret_key);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'category' => $category,
                'image' => new CURLFile($upload_file, mime_content_type($upload_file), $filename)
            ],
            CURLOPT_TIMEOUT => 120
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if (file_exists($temp_file)) unlink($temp_file);
        
        if ($http_code == 200) {
            $data = json_decode($response, true);
            if (isset($data['skipped'])) {
                echo "⏭️  skipped\n";
                $total_skipped++;
            } else {
                echo "✅ uploaded\n";
                $total_uploaded++;
            }
        } else {
            echo "❌ failed (HTTP {$http_code})\n";
        }
        
        usleep(100000);
    }
}

echo "\n✅ Done! Uploaded: {$total_uploaded}, Skipped: {$total_skipped}\n";
