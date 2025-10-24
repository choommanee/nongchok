<?php
/**
 * Add media_type field to gallery_images table
 * Run this once to update the database schema
 */

require_once('wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'gallery_images';

// Check if column exists first
$column_exists = $wpdb->get_results("
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '{$table_name}'
    AND COLUMN_NAME = 'media_type'
");

if (empty($column_exists)) {
    // Add media_type column
    $result = $wpdb->query("
        ALTER TABLE {$table_name}
        ADD COLUMN media_type ENUM('image', 'video') DEFAULT 'image'
        AFTER image_url
    ");
} else {
    echo "ℹ️  Column media_type already exists\n";
    $result = true;
}

if ($result !== false) {
    echo "✅ Successfully added media_type field to {$table_name}\n";

    // Show current structure
    $columns = $wpdb->get_results("DESCRIBE {$table_name}");
    echo "\n📋 Current table structure:\n";
    foreach ($columns as $column) {
        echo "  - {$column->Field} ({$column->Type})\n";
    }
} else {
    echo "❌ Error: " . $wpdb->last_error . "\n";
}
