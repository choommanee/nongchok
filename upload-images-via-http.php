<?php
/**
 * Upload all gallery images to production via HTTP
 */

$production_url = 'https://nongchok-production.up.railway.app/gallery-upload-receiver.php';
$secret_key = 'nongchok2025gallery';
$local_folder = '/Users/sakdachoommanee/Downloads/Shipment 6 Photo';

$folders = scandir($local_folder);
$folders = array_diff($folders, ['.', '..', '.DS_Store']);
sort($folders);

$total_uploaded = 0;
$total_skipped = 0;
$total_failed = 0;

echo "🚀 Starting upload to production...\n";
echo "Target: {$production_url}\n\n";

foreach ($folders as $category) {
    $cat_path = $local_folder . '/' . $category;
    if (!is_dir($cat_path)) continue;

    echo "📂 Category {$category}: ";
    
    $images = glob($cat_path . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    $uploaded = 0;
    $failed = 0;
    
    foreach ($images as $img_path) {
        $filename = basename($img_path);
        
        $ch = curl_init($production_url . '?secret=' . $secret_key);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'category' => $category,
                'image' => new CURLFile($img_path, mime_content_type($img_path), $filename)
            ],
            CURLOPT_TIMEOUT => 60
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $uploaded++;
            $total_uploaded++;
            echo ".";
        } else {
            $failed++;
            $total_failed++;
            echo "x";
        }
        
        usleep(50000); // 50ms delay between uploads
    }
    
    echo " ✅ {$uploaded} uploaded";
    if ($failed > 0) echo ", ❌ {$failed} failed";
    echo "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 Summary:\n";
echo "   ✅ Uploaded: {$total_uploaded}\n";
if ($total_failed > 0) echo "   ❌ Failed: {$total_failed}\n";
echo str_repeat("=", 50) . "\n";
