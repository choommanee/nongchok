<?php
/**
 * Delete all gallery images receiver (put this on Production)
 */

$secret_key = 'nongchok2025gallery';

if (!isset($_GET['secret']) || $_GET['secret'] !== $secret_key) {
    http_response_code(403);
    die('Forbidden');
}

$gallery_path = __DIR__ . '/wp-content/uploads/gallery';

if (!is_dir($gallery_path)) {
    die('Gallery folder not found');
}

echo "Gallery path: $gallery_path\n";
echo "Current contents:\n";
system("ls -la $gallery_path");

echo "\n\nDeleting all category folders...\n";
$dirs = glob($gallery_path . '/*', GLOB_ONLYDIR);
foreach ($dirs as $dir) {
    echo "Deleting: " . basename($dir) . "... ";
    system("rm -rf " . escapeshellarg($dir));
    echo "✅\n";
}

echo "\nDone! Current status:\n";
system("ls -la $gallery_path");
