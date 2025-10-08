<?php
/**
 * Debug ACF Plugin Status
 */

require_once('wp-config.php');

echo "<h1>🔍 ACF Plugin Debug</h1>\n";
echo "<pre>\n";

// Check if ACF plugin is active
$active_plugins = get_option('active_plugins', array());
$acf_active = in_array('advanced-custom-fields/acf.php', $active_plugins);

echo "ACF Plugin Status:\n";
echo $acf_active ? "✅ ACF Plugin is ACTIVE\n" : "❌ ACF Plugin is NOT ACTIVE\n";

if ($acf_active) {
    echo "\nChecking ACF Functions:\n";
    
    // Check if ACF functions exist
    if (function_exists('acf_add_options_page')) {
        echo "✅ acf_add_options_page() function EXISTS\n";
    } else {
        echo "❌ acf_add_options_page() function NOT FOUND\n";
    }
    
    if (class_exists('ACF')) {
        echo "✅ ACF class EXISTS\n";
        
        // Get ACF version
        if (defined('ACF_VERSION')) {
            echo "   - Version: " . ACF_VERSION . "\n";
        }
    } else {
        echo "❌ ACF class NOT FOUND\n";
    }
    
    // Check if our function is hooked
    echo "\nChecking WordPress Hooks:\n";
    
    global $wp_filter;
    if (isset($wp_filter['acf/init'])) {
        echo "✅ acf/init hook has callbacks\n";
        
        foreach ($wp_filter['acf/init']->callbacks as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                if (is_array($callback['function'])) {
                    $func_name = get_class($callback['function'][0]) . '::' . $callback['function'][1];
                } else {
                    $func_name = $callback['function'];
                }
                echo "   - Priority $priority: $func_name\n";
            }
        }
    } else {
        echo "❌ acf/init hook NOT FOUND\n";
    }
    
    // Test our function directly
    echo "\nTesting our function:\n";
    
    if (function_exists('ayam_add_company_options_page')) {
        echo "✅ ayam_add_company_options_page() function EXISTS\n";
        
        // Try to call it manually
        try {
            ayam_add_company_options_page();
            echo "✅ Function executed successfully\n";
        } catch (Exception $e) {
            echo "❌ Function execution failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "❌ ayam_add_company_options_page() function NOT FOUND\n";
    }
    
} else {
    echo "\nACF Plugin is not active. Available plugins:\n";
    foreach ($active_plugins as $plugin) {
        echo "   - $plugin\n";
    }
}

echo "\n</pre>";
?>