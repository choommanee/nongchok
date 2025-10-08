<?php
/**
 * Activate Polylang Plugin
 */

require_once('wp-load.php');
require_once('wp-admin/includes/plugin.php');

$plugin = 'polylang/polylang.php';

if (file_exists(WP_PLUGIN_DIR . '/' . $plugin)) {
    if (!is_plugin_active($plugin)) {
        activate_plugin($plugin);
        echo "✅ Polylang plugin activated successfully!\n";
        echo "📝 Next steps:\n";
        echo "1. Go to WordPress Admin > Languages\n";
        echo "2. Add Thai (ไทย) and Indonesian (Bahasa Indonesia)\n";
        echo "3. Set Thai as default language\n";
    } else {
        echo "ℹ️ Polylang plugin is already active.\n";
    }
} else {
    echo "❌ Polylang plugin not found at: " . WP_PLUGIN_DIR . '/' . $plugin . "\n";
}
