<?php
/**
 * Activate Ayam Bangkok Core Plugin and Setup Data
 */

// Load WordPress
require_once('wp-config.php');
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

echo "<h1>🐓 Activating Ayam Bangkok Core Plugin</h1>\n";
echo "<pre>\n";

try {
    // Check if plugin files exist
    $plugin_file = 'ayam-bangkok-core/ayam-bangkok-core.php';
    $plugin_path = WP_PLUGIN_DIR . '/' . $plugin_file;
    
    if (!file_exists($plugin_path)) {
        throw new Exception("Plugin file not found: $plugin_path");
    }
    
    echo "✓ Plugin files found\n";
    
    // Activate the plugin
    echo "Activating plugin...\n";
    $result = activate_plugin($plugin_file);
    
    if (is_wp_error($result)) {
        throw new Exception("Plugin activation failed: " . $result->get_error_message());
    }
    
    echo "✓ Plugin activated successfully\n\n";
    
    // Load plugin to trigger activation hooks
    include_once($plugin_path);
    
    // Manually run database creation
    echo "Creating database tables...\n";
    require_once(WP_PLUGIN_DIR . '/ayam-bangkok-core/includes/class-ayam-database.php');
    require_once(WP_PLUGIN_DIR . '/ayam-bangkok-core/includes/class-ayam-user-roles.php');
    
    AyamDatabase::create_tables();
    echo "✓ Database tables created\n";
    
    AyamUserRoles::add_roles();
    echo "✓ User roles added\n";
    
    // Flush rewrite rules
    flush_rewrite_rules();
    echo "✓ Rewrite rules flushed\n\n";
    
    // Check if custom post types are registered
    echo "Checking custom post types...\n";
    $post_types = array('ayam_rooster', 'ayam_service', 'ayam_news', 'ayam_knowledge');
    
    foreach ($post_types as $post_type) {
        if (post_type_exists($post_type)) {
            echo "✓ Post type '$post_type' registered\n";
        } else {
            echo "❌ Post type '$post_type' NOT registered\n";
        }
    }
    
    echo "\n";
    
    // Check taxonomies
    echo "Checking taxonomies...\n";
    $taxonomies = array('rooster_breed', 'rooster_category', 'service_category', 'news_category', 'knowledge_category');
    
    foreach ($taxonomies as $taxonomy) {
        if (taxonomy_exists($taxonomy)) {
            echo "✓ Taxonomy '$taxonomy' registered\n";
        } else {
            echo "❌ Taxonomy '$taxonomy' NOT registered\n";
        }
    }
    
    echo "\n";
    
    // Check database tables
    echo "Verifying database tables...\n";
    global $wpdb;
    
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
            echo "✓ Table $full_table_name exists\n";
        } else {
            echo "❌ Table $full_table_name missing\n";
        }
    }
    
    echo "\n";
    
    // Check user roles
    echo "Checking user roles...\n";
    $custom_roles = array('ayam_manager', 'ayam_staff', 'premium_member', 'regular_member');
    
    foreach ($custom_roles as $role) {
        if (get_role($role)) {
            echo "✓ Role '$role' exists\n";
        } else {
            echo "❌ Role '$role' missing\n";
        }
    }
    
    echo "\n✅ Plugin activation completed!\n\n";
    
    echo "Next steps:\n";
    echo "1. Go to WordPress Admin: http://nongchok.local/wp-admin/\n";
    echo "2. You should see new menu items: ไก่ชน, บริการ, ข่าวสาร, ศูนย์ความรู้\n";
    echo "3. Try adding a new rooster to test the custom fields\n";
    echo "4. Install Advanced Custom Fields Pro for enhanced field management\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "\nTroubleshooting:\n";
    echo "1. Check if WordPress is properly installed\n";
    echo "2. Verify plugin files are in the correct location\n";
    echo "3. Check file permissions\n";
    echo "4. Look at WordPress error logs\n";
}

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #ff6b35; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; line-height: 1.5; }
</style>