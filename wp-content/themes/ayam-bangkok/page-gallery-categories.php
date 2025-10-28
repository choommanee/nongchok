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
$category_number = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

if (!empty($category_number)) {
    // Check category type to determine which view to use
    if ($category_number === 'BTS') {
        // BTS is a filter, show landing page
        include(locate_template('template-parts/gallery-categories-landing.php'));
    } else {
        // Get category info to check type
        $category = $wpdb->get_row($wpdb->prepare(
            "SELECT category_type FROM {$categories_table} WHERE category_number = %s",
            $category_number
        ));

        if ($category && $category->category_type === 'behind_scene') {
            // GRID VIEW - Show all images in grid for Behind the Scene
            include(locate_template('template-parts/gallery-category-grid.php'));
        } else {
            // DETAIL VIEW - Show 6 slots for regular gallery
            include(locate_template('template-parts/gallery-category-detail.php'));
        }
    }
} else {
    // LANDING PAGE - Show all categories
    include(locate_template('template-parts/gallery-categories-landing.php'));
}

get_footer();
