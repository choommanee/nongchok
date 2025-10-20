<?php
/**
 * Gallery Image Upload Receiver
 * Place this on production to receive uploaded images
 */

// Security: Only allow from specific IP or with secret key
$secret = isset($_GET['secret']) ? $_GET['secret'] : '';
if ($secret !== 'nongchok2025gallery') {
    http_response_code(403);
    die('Forbidden');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method not allowed');
}

$category = isset($_POST['category']) ? preg_replace('/[^0-9]/', '', $_POST['category']) : '';
if (empty($category)) {
    http_response_code(400);
    die('Category required');
}

if (!isset($_FILES['image'])) {
    http_response_code(400);
    die('No image uploaded');
}

$upload_dir = __DIR__ . '/wp-content/uploads/gallery/' . $category;
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$file = $_FILES['image'];

// Check for upload errors
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Upload error: ' . $file['error']]));
}

$filename = basename($file['name']);
$target = $upload_dir . '/' . $filename;

// Skip if file already exists
if (file_exists($target)) {
    echo json_encode(['success' => true, 'file' => $filename, 'skipped' => true]);
    exit;
}

if (move_uploaded_file($file['tmp_name'], $target)) {
    chmod($target, 0644);
    echo json_encode(['success' => true, 'file' => $filename, 'size' => filesize($target)]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Move failed', 'tmp' => $file['tmp_name']]);
}
