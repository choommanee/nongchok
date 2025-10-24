<?php
/**
 * Update Production Database - Add media_type field
 * Upload this file to Railway and run it via SSH or web browser
 */

// Load WordPress
require_once(__DIR__ . '/wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'gallery_images';

echo "🔧 Updating Production Database Schema\n\n";

// Check if column exists
$column_exists = $wpdb->get_results("
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '{$table_name}'
    AND COLUMN_NAME = 'media_type'
");

if (empty($column_exists)) {
    echo "📝 Adding media_type column to {$table_name}...\n";

    $result = $wpdb->query("
        ALTER TABLE {$table_name}
        ADD COLUMN media_type ENUM('image', 'video') DEFAULT 'image'
        AFTER image_url
    ");

    if ($result !== false) {
        echo "✅ Successfully added media_type column\n\n";
    } else {
        echo "❌ Error adding column: " . $wpdb->last_error . "\n";
        exit(1);
    }
} else {
    echo "ℹ️  Column media_type already exists\n\n";
}

// Show current structure
$columns = $wpdb->get_results("DESCRIBE {$table_name}");
echo "📋 Current table structure:\n";
echo str_repeat("-", 60) . "\n";
printf("%-20s %-30s %-10s\n", "Field", "Type", "Null");
echo str_repeat("-", 60) . "\n";
foreach ($columns as $column) {
    printf("%-20s %-30s %-10s\n", $column->Field, $column->Type, $column->Null);
}
echo str_repeat("-", 60) . "\n";

echo "\n✅ Database update completed successfully!\n";
