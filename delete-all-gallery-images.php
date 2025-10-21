<?php
/**
 * Delete ALL gallery images on Production via direct call
 */

$production_url = 'https://nongchok-production.up.railway.app';
$secret_key = 'nongchok2025gallery';

// Create a simple delete request
$url = $production_url . '/delete-gallery.php?secret=' . urlencode($secret_key) . '&action=delete_all';

echo "Calling: $url\n\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $http_code\n";
echo "Response:\n$response\n";
