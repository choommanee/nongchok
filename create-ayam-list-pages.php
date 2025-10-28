<?php
/**
 * Create WordPress Pages for Ayam List
 */

require_once('wp-load.php');

// Check if pages already exist
$ayam_list_page = get_page_by_path('ayam-list');
$ayam_list_detail_page = get_page_by_path('ayam-list-detail');

// Create Ayam List page
if (!$ayam_list_page) {
    $ayam_list_id = wp_insert_post(array(
        'post_title' => 'Ayam List',
        'post_name' => 'ayam-list',
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
        'page_template' => 'page-ayam-list.php'
    ));
    
    if ($ayam_list_id) {
        echo "✓ Created Ayam List page (ID: $ayam_list_id)\n";
        update_post_meta($ayam_list_id, '_wp_page_template', 'page-ayam-list.php');
    } else {
        echo "✗ Failed to create Ayam List page\n";
    }
} else {
    echo "• Ayam List page already exists (ID: {$ayam_list_page->ID})\n";
    update_post_meta($ayam_list_page->ID, '_wp_page_template', 'page-ayam-list.php');
    echo "  ✓ Updated template to page-ayam-list.php\n";
}

// Create Ayam List Detail page
if (!$ayam_list_detail_page) {
    $ayam_list_detail_id = wp_insert_post(array(
        'post_title' => 'Ayam List Detail',
        'post_name' => 'ayam-list-detail',
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'page',
        'page_template' => 'page-ayam-list-detail.php'
    ));
    
    if ($ayam_list_detail_id) {
        echo "✓ Created Ayam List Detail page (ID: $ayam_list_detail_id)\n";
        update_post_meta($ayam_list_detail_id, '_wp_page_template', 'page-ayam-list-detail.php');
    } else {
        echo "✗ Failed to create Ayam List Detail page\n";
    }
} else {
    echo "• Ayam List Detail page already exists (ID: {$ayam_list_detail_page->ID})\n";
    update_post_meta($ayam_list_detail_page->ID, '_wp_page_template', 'page-ayam-list-detail.php');
    echo "  ✓ Updated template to page-ayam-list-detail.php\n";
}

echo "\n✓ All done! You can now access:\n";
echo "  - Ayam List: " . home_url('/ayam-list/') . "\n";
echo "  - Ayam List Detail: " . home_url('/ayam-list-detail/?shipment=6') . "\n";
