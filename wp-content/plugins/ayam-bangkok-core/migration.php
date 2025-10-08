<?php
/**
 * Database Migration Script for Ayam Bangkok
 * Run this file directly to create database tables and initial data
 */

// Load WordPress
require_once('../../../wp-config.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// Include our database class
require_once('includes/class-ayam-database.php');
require_once('includes/class-ayam-user-roles.php');

echo "<h1>Ayam Bangkok Database Migration</h1>\n";
echo "<pre>\n";

try {
    // Test database connection first
    echo "Testing database connection...\n";
    global $wpdb;
    
    $result = $wpdb->get_var("SELECT 1");
    if ($result !== '1') {
        throw new Exception("Database connection failed");
    }
    echo "✓ Database connection successful\n\n";
    
    // Check if WordPress tables exist
    echo "Checking WordPress installation...\n";
    $wp_tables = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}posts'");
    if (!$wp_tables) {
        echo "⚠ WordPress tables not found. Please run WordPress installation first.\n";
        echo "Go to: http://nongchok.local/wp-admin/install.php\n\n";
    } else {
        echo "✓ WordPress tables found\n\n";
    }
    
    // Create custom tables
    echo "Creating Ayam Bangkok custom tables...\n";
    AyamDatabase::create_tables();
    echo "✓ Custom tables created successfully\n\n";
    
    // Add custom user roles
    echo "Adding custom user roles...\n";
    AyamUserRoles::add_roles();
    echo "✓ Custom user roles added successfully\n\n";
    
    // Verify tables were created
    echo "Verifying table creation...\n";
    $custom_tables = array(
        'ayam_bookings',
        'ayam_inquiries', 
        'ayam_export_records',
        'ayam_rooster_gallery',
        'ayam_user_preferences',
        'ayam_activity_log'
    );
    
    foreach ($custom_tables as $table) {
        $full_table_name = $wpdb->prefix . $table;
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$full_table_name'");
        if ($exists) {
            echo "✓ Table $full_table_name created\n";
        } else {
            echo "✗ Table $full_table_name NOT created\n";
        }
    }
    
    echo "\n";
    
    // Check taxonomies and terms
    echo "Checking default taxonomies and terms...\n";
    
    $taxonomies_to_check = array(
        'rooster_breed' => 'Rooster Breeds',
        'rooster_category' => 'Rooster Categories', 
        'service_category' => 'Service Categories',
        'knowledge_category' => 'Knowledge Categories'
    );
    
    foreach ($taxonomies_to_check as $taxonomy => $label) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ));
        
        if (is_wp_error($terms)) {
            echo "⚠ Taxonomy $taxonomy not registered yet (will be created when plugin is activated)\n";
        } else {
            echo "✓ Taxonomy $taxonomy has " . count($terms) . " terms\n";
        }
    }
    
    echo "\n";
    
    // Show database info
    echo "Database Information:\n";
    echo "Database Name: " . DB_NAME . "\n";
    echo "Database Host: " . DB_HOST . "\n";
    echo "Database User: " . DB_USER . "\n";
    echo "Table Prefix: " . $wpdb->prefix . "\n";
    echo "WordPress Version: " . get_bloginfo('version') . "\n";
    
    echo "\n=== Migration Completed Successfully! ===\n";
    echo "\nNext Steps:\n";
    echo "1. Go to WordPress Admin: http://nongchok.local/wp-admin/\n";
    echo "2. Activate the 'Ayam Bangkok Core' plugin\n";
    echo "3. Check that custom post types appear in the admin menu\n";
    echo "4. Install and activate Advanced Custom Fields Pro plugin\n";
    
} catch (Exception $e) {
    echo "\n❌ Migration Error: " . $e->getMessage() . "\n";
    echo "\nPlease check:\n";
    echo "1. Database server is running\n";
    echo "2. Database 'nongchok' exists\n";
    echo "3. Database credentials are correct\n";
    echo "4. WordPress is properly installed\n";
}

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #ff6b35; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; }
</style>