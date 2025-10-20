<?php
/**
 * Template Name: Rooster Gallery (With Categories)
 * Beautiful gallery with category landing page and detail view
 */

error_log('===== LOADING page-gallery-categories.php =====');
error_log('File: ' . __FILE__);

get_header();

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Get all categories
$categories = $wpdb->get_results("
    SELECT * FROM {$categories_table}
    ORDER BY category_number ASC
");

echo "<h1>DEBUG MODE</h1>";
echo "<p>Total categories: " . count($categories) . "</p>";
echo "<pre>";
print_r($categories);
echo "</pre>";

get_footer();
