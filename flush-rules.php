<?php
/**
 * Flush WordPress Rewrite Rules
 */

require_once('wp-config.php');

echo "<h1>🔄 Flushing WordPress Rewrite Rules</h1>\n";
echo "<pre>\n";

// Flush rewrite rules
flush_rewrite_rules(true);

echo "✅ Rewrite rules flushed successfully!\n\n";

echo "This should help if:\n";
echo "- Custom post types are registered but not showing in admin\n";
echo "- Permalinks are not working\n";
echo "- 404 errors on custom post type pages\n\n";

echo "Now try refreshing your WordPress admin page.\n";

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #28a745; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; }
</style>