<?php
/**
 * Force Refresh Plugin Registration
 */

require_once('wp-config.php');

echo "<h1>🔄 Force Refresh Ayam Bangkok Plugin</h1>\n";
echo "<pre>\n";

try {
    // Deactivate plugin first
    echo "Deactivating plugin...\n";
    deactivate_plugins('ayam-bangkok-core/ayam-bangkok-core.php');
    
    // Clear any cached data
    wp_cache_flush();
    
    // Wait a moment
    sleep(1);
    
    // Reactivate plugin
    echo "Reactivating plugin...\n";
    activate_plugin('ayam-bangkok-core/ayam-bangkok-core.php');
    
    // Flush rewrite rules
    echo "Flushing rewrite rules...\n";
    flush_rewrite_rules(true);
    
    echo "✅ Plugin refreshed successfully!\n\n";
    
    // Check post types
    echo "Checking post types:\n";
    $post_types = array('ayam_rooster', 'ayam_service', 'ayam_news', 'ayam_knowledge');
    
    foreach ($post_types as $type) {
        if (post_type_exists($type)) {
            echo "✅ $type - REGISTERED\n";
        } else {
            echo "❌ $type - NOT REGISTERED\n";
        }
    }
    
    echo "\nNow refresh your WordPress admin page!\n";
    echo "Admin URL: " . admin_url() . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #ff6b35; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; }
</style>