<?php
/**
 * Debug Ayam Bangkok Plugin
 */

require_once('wp-config.php');

echo "<h1>🔍 Ayam Bangkok Plugin Debug</h1>\n";
echo "<pre>\n";

// Check if plugin is active
$active_plugins = get_option('active_plugins', array());
$plugin_active = in_array('ayam-bangkok-core/ayam-bangkok-core.php', $active_plugins);

echo "Plugin Status:\n";
echo $plugin_active ? "✅ Plugin is ACTIVE\n" : "❌ Plugin is NOT ACTIVE\n";

if ($plugin_active) {
    echo "\nChecking Post Types:\n";
    
    $expected_types = array('ayam_rooster', 'ayam_service', 'ayam_news', 'ayam_knowledge');
    
    foreach ($expected_types as $type) {
        if (post_type_exists($type)) {
            echo "✅ $type - EXISTS\n";
            
            // Get post type object
            $post_type_obj = get_post_type_object($type);
            if ($post_type_obj) {
                echo "   - Label: {$post_type_obj->labels->name}\n";
                echo "   - Menu Position: {$post_type_obj->menu_position}\n";
                echo "   - Show in Menu: " . ($post_type_obj->show_in_menu ? 'YES' : 'NO') . "\n";
                echo "   - Show UI: " . ($post_type_obj->show_ui ? 'YES' : 'NO') . "\n";
                echo "   - Public: " . ($post_type_obj->public ? 'YES' : 'NO') . "\n";
            }
        } else {
            echo "❌ $type - NOT EXISTS\n";
        }
        echo "\n";
    }
    
    echo "Checking Taxonomies:\n";
    $expected_taxonomies = array('rooster_breed', 'rooster_category', 'service_category', 'news_category', 'knowledge_category');
    
    foreach ($expected_taxonomies as $taxonomy) {
        if (taxonomy_exists($taxonomy)) {
            echo "✅ $taxonomy - EXISTS\n";
        } else {
            echo "❌ $taxonomy - NOT EXISTS\n";
        }
    }
    
    echo "\nChecking User Roles:\n";
    $expected_roles = array('ayam_manager', 'ayam_staff', 'premium_member', 'regular_member');
    
    foreach ($expected_roles as $role) {
        if (get_role($role)) {
            echo "✅ $role - EXISTS\n";
        } else {
            echo "❌ $role - NOT EXISTS\n";
        }
    }
    
    echo "\nChecking Database Tables:\n";
    global $wpdb;
    
    $expected_tables = array(
        'ayam_bookings',
        'ayam_inquiries',
        'ayam_export_records',
        'ayam_rooster_gallery',
        'ayam_user_preferences',
        'ayam_activity_log'
    );
    
    foreach ($expected_tables as $table) {
        $full_table = $wpdb->prefix . $table;
        $exists = $wpdb->get_var("SHOW TABLES LIKE '$full_table'");
        if ($exists) {
            echo "✅ $full_table - EXISTS\n";
        } else {
            echo "❌ $full_table - NOT EXISTS\n";
        }
    }
    
    echo "\nPlugin Files Check:\n";
    $plugin_files = array(
        'ayam-bangkok-core.php',
        'includes/class-ayam-post-types.php',
        'includes/class-ayam-taxonomies.php',
        'includes/class-ayam-user-roles.php',
        'includes/class-ayam-database.php'
    );
    
    foreach ($plugin_files as $file) {
        $file_path = WP_PLUGIN_DIR . '/ayam-bangkok-core/' . $file;
        if (file_exists($file_path)) {
            echo "✅ $file - EXISTS\n";
        } else {
            echo "❌ $file - NOT EXISTS\n";
        }
    }
    
    echo "\nWordPress Admin Menu Items:\n";
    global $menu, $submenu;
    
    if (is_array($menu)) {
        foreach ($menu as $item) {
            if (isset($item[0]) && (strpos($item[0], 'ไก่') !== false || strpos($item[0], 'Ayam') !== false)) {
                echo "✅ Found menu: {$item[0]} ({$item[2]})\n";
            }
        }
    }
    
} else {
    echo "\nTo activate the plugin, run:\n";
    echo "http://nongchok.local/activate-plugin.php\n";
}

echo "\nCurrent User Capabilities:\n";
$current_user = wp_get_current_user();
if ($current_user->ID) {
    echo "User: {$current_user->user_login}\n";
    echo "Roles: " . implode(', ', $current_user->roles) . "\n";
    echo "Can manage options: " . (current_user_can('manage_options') ? 'YES' : 'NO') . "\n";
} else {
    echo "No user logged in\n";
}

echo "\nWordPress Info:\n";
echo "WP Version: " . get_bloginfo('version') . "\n";
echo "Site URL: " . get_site_url() . "\n";
echo "Admin URL: " . admin_url() . "\n";

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #0073aa; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; line-height: 1.5; }
</style>