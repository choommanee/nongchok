<?php
/**
 * Upload images to production via WordPress REST API
 */

$production_url = 'https://nongchok-production.up.railway.app';
$wp_user = 'admin';
$wp_pass = '$5Tgbvfr43edc';
$local_folder = '/Users/sakdachoommanee/Downloads/Shipment 6 Photo';

// Get auth token
echo "🔑 Authenticating...\n";
$auth_response = file_get_contents($production_url . '/wp-json/jwt-auth/v1/token', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode(['username' => $wp_user, 'password' => $wp_pass])
    ]
]));

if (!$auth_response) {
    echo "❌ Auth failed, using Basic Auth instead\n";
    $auth_header = 'Authorization: Basic ' . base64_encode($wp_user . ':' . $wp_pass);
} else {
    $auth = json_decode($auth_response);
    $auth_header = 'Authorization: Bearer ' . $auth->token;
}

$folders = scandir($local_folder);
$folders = array_diff($folders, ['.', '..', '.DS_Store']);
sort($folders);

$uploaded = 0;
$skipped = 0;

foreach ($folders as $category) {
    $cat_path = $local_folder . '/' . $category;
    if (!is_dir($cat_path)) continue;

    echo "\n📂 Category {$category}:\n";
    $images = glob($cat_path . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

    foreach ($images as $img) {
        $filename = basename($img);
        $remote_path = "/wp-content/uploads/gallery/{$category}/{$filename}";
        
        // Check if already exists
        $check_url = $production_url . $remote_path;
        $headers = @get_headers($check_url);
        if ($headers && strpos($headers[0], '200') !== false) {
            echo "  ⏭️  Skip: {$filename}\n";
            $skipped++;
            continue;
        }

        // Upload via curl
        echo "  ⬆️  Upload: {$filename} (" . round(filesize($img)/1024/1024, 1) . "MB)...";
        
        $ch = curl_init($production_url . '/wp-json/wp/v2/media');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                $auth_header,
                'Content-Disposition: attachment; filename="' . $filename . '"',
                'Content-Type: ' . mime_content_type($img)
            ],
            CURLOPT_POSTFIELDS => file_get_contents($img),
            CURLOPT_TIMEOUT => 300
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 201) {
            echo " ✅\n";
            $uploaded++;
        } else {
            echo " ❌ (HTTP {$http_code})\n";
        }
        
        usleep(100000); // 0.1s delay
    }
}

echo "\n✅ Upload complete: {$uploaded} uploaded, {$skipped} skipped\n";
