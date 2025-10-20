<?php
/**
 * Fix Production URLs
 * Run this on production to fix wp_options URLs
 */

require_once('wp-load.php');

global $wpdb;

echo "🔧 Checking WordPress URLs...\n\n";

// Get current URLs
$home_url = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_name = 'home'");
$site_url = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_name = 'siteurl'");

echo "Current URLs:\n";
echo "  Home URL: {$home_url}\n";
echo "  Site URL: {$site_url}\n\n";

// Detect the correct URL
$correct_url = 'https://nongchok-production.up.railway.app';

if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $correct_url = $protocol . '://' . $_SERVER['HTTP_HOST'];
}

echo "Detected URL: {$correct_url}\n\n";

// Update if needed
if ($home_url !== $correct_url || $site_url !== $correct_url) {
    echo "🔄 Updating URLs...\n";

    $wpdb->update(
        'wp_options',
        array('option_value' => $correct_url),
        array('option_name' => 'home')
    );

    $wpdb->update(
        'wp_options',
        array('option_value' => $correct_url),
        array('option_name' => 'siteurl')
    );

    echo "✅ URLs updated successfully!\n";
    echo "  Home URL: {$correct_url}\n";
    echo "  Site URL: {$correct_url}\n\n";

    echo "Admin URL should now be:\n";
    echo "  {$correct_url}/wp-admin/\n";
} else {
    echo "✅ URLs are already correct!\n";
}

echo "\nTo access admin:\n";
echo "  {$correct_url}/wp-admin/admin.php?page=ayam-gallery-images\n";
