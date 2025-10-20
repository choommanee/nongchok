<?php
/**
 * Template Name: Rooster Gallery (With Categories)
 * Beautiful gallery with category landing page and detail view
 */

get_header();

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Check if we're viewing a specific category
$category_code = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

if (!empty($category_code)) {
    // DETAIL VIEW - Show images for specific category
    include(locate_template('template-parts/gallery-category-detail.php'));
} else {
    // LANDING PAGE - Show all categories
    include(locate_template('template-parts/gallery-categories-landing.php'));
}

get_footer();
