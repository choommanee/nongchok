<?php
/**
 * Add video_url column to wp_gallery_categories table
 */

require_once __DIR__ . '/wp-load.php';

global $wpdb;
$table_name = $wpdb->prefix . 'gallery_categories';

// Check if column exists
$column_exists = $wpdb->get_results(
    $wpdb->prepare(
        "SHOW COLUMNS FROM {$table_name} LIKE %s",
        'video_url'
    )
);

if (empty($column_exists)) {
    $wpdb->query("ALTER TABLE {$table_name} ADD COLUMN video_url VARCHAR(500) NULL AFTER category_number");
    echo "✅ Added video_url column to {$table_name}\n";
} else {
    echo "ℹ️  video_url column already exists in {$table_name}\n";
}

// Show table structure
echo "\nTable structure:\n";
$columns = $wpdb->get_results("SHOW COLUMNS FROM {$table_name}");
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}
