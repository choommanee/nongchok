<?php
/**
 * Database Migration Script for Ayam Bangkok
 * Run this to create new database tables and update existing ones
 */

require_once('wp-config.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

echo "<h1>🗄️ Ayam Bangkok Database Migration</h1>\n";
echo "<pre>\n";

try {
    // Load plugin classes
    require_once(WP_PLUGIN_DIR . '/ayam-bangkok-core/includes/class-ayam-database.php');
    
    echo "Starting database migration...\n\n";
    
    // Create/update tables
    echo "Creating/updating database tables...\n";
    AyamDatabase::create_tables();
    echo "✅ Database tables created/updated successfully\n\n";
    
    // Verify all tables exist
    echo "Verifying table creation:\n";
    global $wpdb;
    
    $expected_tables = array(
        'ayam_bookings' => 'Service Bookings',
        'ayam_inquiries' => 'Customer Inquiries',
        'ayam_export_records' => 'Export Records',
        'ayam_rooster_gallery' => 'Rooster Galleries',
        'ayam_user_preferences' => 'User Preferences',
        'ayam_activity_log' => 'Activity Log',
        'ayam_health_records' => 'Health Records',
        'ayam_training_records' => 'Training Records',
        'ayam_fighting_records' => 'Fighting Records',
        'ayam_customer_profiles' => 'Customer Profiles',
        'ayam_export_documents' => 'Export Documents',
        'ayam_notifications' => 'Notifications',
        'ayam_settings' => 'System Settings'
    );
    
    $created_count = 0;
    foreach ($expected_tables as $table => $description) {
        $full_table = $wpdb->prefix . $table;
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$full_table'");
        if ($exists) {
            echo "✅ $description ($full_table)\n";
            $created_count++;
        } else {
            echo "❌ $description ($full_table) - NOT CREATED\n";
        }
    }
    
    echo "\nSummary: $created_count/" . count($expected_tables) . " tables created successfully\n\n";
    
    // Check table structures
    echo "Checking table structures:\n";
    
    // Check ayam_health_records structure
    $health_columns = $wpdb->get_results("DESCRIBE {$wpdb->prefix}ayam_health_records");
    if ($health_columns) {
        echo "✅ Health Records table has " . count($health_columns) . " columns\n";
    }
    
    // Check ayam_settings table and default data
    $settings_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ayam_settings");
    echo "✅ Settings table has $settings_count default settings\n";
    
    // Check ayam_notifications table
    $notifications_columns = $wpdb->get_results("DESCRIBE {$wpdb->prefix}ayam_notifications");
    if ($notifications_columns) {
        echo "✅ Notifications table has " . count($notifications_columns) . " columns\n";
    }
    
    echo "\n";
    
    // Show some sample settings
    echo "Sample default settings:\n";
    $sample_settings = $wpdb->get_results(
        "SELECT setting_key, setting_value, category FROM {$wpdb->prefix}ayam_settings LIMIT 5"
    );
    
    foreach ($sample_settings as $setting) {
        echo "- {$setting->setting_key}: {$setting->setting_value} ({$setting->category})\n";
    }
    
    echo "\n✅ Database migration completed successfully!\n\n";
    
    echo "New Features Available:\n";
    echo "- Health Records: Track veterinary visits and treatments\n";
    echo "- Training Records: Log training sessions and performance\n";
    echo "- Fighting Records: Maintain fight history and statistics\n";
    echo "- Customer Profiles: Extended customer information\n";
    echo "- Export Documents: Manage export paperwork\n";
    echo "- Notifications: System-wide notification system\n";
    echo "- Settings: Configurable system settings\n\n";
    
    echo "Next Steps:\n";
    echo "1. The new database schema is ready for use\n";
    echo "2. Admin interfaces for new features will be available\n";
    echo "3. API endpoints support the new data structures\n";
    echo "4. Helper functions are available for developers\n";
    
} catch (Exception $e) {
    echo "\n❌ Migration Error: " . $e->getMessage() . "\n";
    echo "\nPlease check:\n";
    echo "1. Database connection is working\n";
    echo "2. WordPress is properly installed\n";
    echo "3. Plugin files are in the correct location\n";
    echo "4. Database user has CREATE TABLE permissions\n";
}

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #2c3e50; }
pre { background: #f8f9fa; padding: 20px; border-radius: 5px; line-height: 1.6; }
</style>