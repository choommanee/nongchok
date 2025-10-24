<?php
/**
 * Add shipment_date and owner fields to gallery_categories table
 * Run this on both local and production to update the database schema
 */

require_once(__DIR__ . '/wp-load.php');

global $wpdb;
$table_name = $wpdb->prefix . 'gallery_categories';

// Check and add shipment_date column
$shipment_exists = $wpdb->get_results("
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '{$table_name}'
    AND COLUMN_NAME = 'shipment_date'
");

if (empty($shipment_exists)) {
    $wpdb->query("
        ALTER TABLE {$table_name}
        ADD COLUMN shipment_date VARCHAR(100) DEFAULT NULL
        AFTER category_name
    ");
    echo "✅ Added shipment_date column\n";
} else {
    echo "ℹ️  Column shipment_date already exists\n";
}

// Check and add owner column
$owner_exists = $wpdb->get_results("
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = '{$table_name}'
    AND COLUMN_NAME = 'owner'
");

if (empty($owner_exists)) {
    $wpdb->query("
        ALTER TABLE {$table_name}
        ADD COLUMN owner VARCHAR(255) DEFAULT NULL
        AFTER shipment_date
    ");
    echo "✅ Added owner column\n";
} else {
    echo "ℹ️  Column owner already exists\n";
}

// Show current structure
$columns = $wpdb->get_results("DESCRIBE {$table_name}");
echo "\n📋 Current table structure:\n";
echo str_repeat("-", 60) . "\n";
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}
echo str_repeat("-", 60) . "\n";

echo "\n✅ Database update completed!\n";
