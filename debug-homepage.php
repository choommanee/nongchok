<?php
/**
 * Debug Homepage Display
 */

require_once 'wp-config.php';

echo "<h1>🔍 Homepage Debug Information</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #1e40af; } .debug-section { background: #f8fafc; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #3b82f6; } .success { border-left-color: #10b981; } .error { border-left-color: #ef4444; }</style>";

// Check WordPress settings
echo "<div class='debug-section'>";
echo "<h2>📋 WordPress Settings</h2>";
echo "<p><strong>Show on front:</strong> " . get_option('show_on_front') . "</p>";
echo "<p><strong>Page on front:</strong> " . get_option('page_on_front') . "</p>";
echo "<p><strong>Current theme:</strong> " . get_option('stylesheet') . "</p>";
echo "<p><strong>Active theme:</strong> " . wp_get_theme()->get('Name') . "</p>";
echo "</div>";

// Check template files
echo "<div class='debug-section'>";
echo "<h2>📁 Template Files</h2>";
$template_dir = get_template_directory();
$files_to_check = [
    'front-page.php',
    'index.php', 
    'header.php',
    'footer.php',
    'style.css',
    'assets/js/theme.js'
];

foreach ($files_to_check as $file) {
    $file_path = $template_dir . '/' . $file;
    $exists = file_exists($file_path);
    $class = $exists ? 'success' : 'error';
    $status = $exists ? '✅ Exists' : '❌ Missing';
    
    if ($exists) {
        $size = filesize($file_path);
        $size_formatted = number_format($size) . ' bytes';
        echo "<p class='{$class}'><strong>{$file}:</strong> {$status} ({$size_formatted})</p>";
    } else {
        echo "<p class='{$class}'><strong>{$file}:</strong> {$status}</p>";
    }
}
echo "</div>";

// Check functions
echo "<div class='debug-section'>";
echo "<h2>🔧 Theme Functions</h2>";
$functions_to_check = [
    'ayam_get_slider_images',
    'ayam_get_slider_settings', 
    'ayam_get_welcome_content',
    'ayam_get_company_info'
];

foreach ($functions_to_check as $func) {
    $exists = function_exists($func);
    $class = $exists ? 'success' : 'error';
    $status = $exists ? '✅ Available' : '❌ Missing';
    echo "<p class='{$class}'><strong>{$func}():</strong> {$status}</p>";
}
echo "</div>";

// Test function calls
echo "<div class='debug-section'>";
echo "<h2>🧪 Function Test Results</h2>";

if (function_exists('ayam_get_slider_images')) {
    $slider_images = ayam_get_slider_images();
    echo "<p><strong>Slider images:</strong> " . (empty($slider_images) ? 'No data' : count($slider_images) . ' slides') . "</p>";
} else {
    echo "<p class='error'><strong>Slider images:</strong> Function not available</p>";
}

if (function_exists('ayam_get_welcome_content')) {
    $welcome_content = ayam_get_welcome_content();
    echo "<p><strong>Welcome content:</strong> " . (empty($welcome_content) || !$welcome_content['enable'] ? 'Disabled or no data' : 'Enabled') . "</p>";
} else {
    echo "<p class='error'><strong>Welcome content:</strong> Function not available</p>";
}
echo "</div>";

// Check plugins
echo "<div class='debug-section'>";
echo "<h2>🔌 Plugin Status</h2>";
$active_plugins = get_option('active_plugins');
$ayam_plugin_active = false;

foreach ($active_plugins as $plugin) {
    if (strpos($plugin, 'ayam-bangkok-core') !== false) {
        $ayam_plugin_active = true;
        break;
    }
}

$class = $ayam_plugin_active ? 'success' : 'error';
$status = $ayam_plugin_active ? '✅ Active' : '❌ Inactive';
echo "<p class='{$class}'><strong>Ayam Bangkok Core Plugin:</strong> {$status}</p>";

if (function_exists('get_field')) {
    echo "<p class='success'><strong>ACF (Advanced Custom Fields):</strong> ✅ Available</p>";
} else {
    echo "<p class='error'><strong>ACF (Advanced Custom Fields):</strong> ❌ Not available</p>";
}
echo "</div>";

// Check current page
echo "<div class='debug-section'>";
echo "<h2>📄 Current Page Info</h2>";
$front_page_id = get_option('page_on_front');
if ($front_page_id) {
    $front_page = get_post($front_page_id);
    if ($front_page) {
        echo "<p><strong>Front page title:</strong> " . $front_page->post_title . "</p>";
        echo "<p><strong>Front page status:</strong> " . $front_page->post_status . "</p>";
        echo "<p><strong>Front page ID:</strong> " . $front_page->ID . "</p>";
    } else {
        echo "<p class='error'><strong>Front page:</strong> Page not found (ID: {$front_page_id})</p>";
    }
} else {
    echo "<p><strong>Front page:</strong> Using front-page.php template</p>";
}
echo "</div>";

// Template hierarchy test
echo "<div class='debug-section'>";
echo "<h2>🎯 Template Hierarchy</h2>";
echo "<p>WordPress will look for templates in this order:</p>";
echo "<ol>";
echo "<li>front-page.php (for static front page)</li>";
echo "<li>home.php (for blog posts front page)</li>";
echo "<li>index.php (fallback)</li>";
echo "</ol>";

$template_hierarchy = [];
if (file_exists($template_dir . '/front-page.php')) {
    $template_hierarchy[] = '✅ front-page.php';
}
if (file_exists($template_dir . '/home.php')) {
    $template_hierarchy[] = '✅ home.php';
}
if (file_exists($template_dir . '/index.php')) {
    $template_hierarchy[] = '✅ index.php';
}

echo "<p><strong>Available templates:</strong> " . implode(', ', $template_hierarchy) . "</p>";
echo "</div>";

echo "<div class='debug-section success'>";
echo "<h2>🎉 Summary</h2>";
echo "<p>Based on the current settings, WordPress should be using <strong>front-page.php</strong> template.</p>";
echo "<p>If the homepage is still blank, the issue might be:</p>";
echo "<ul>";
echo "<li>Missing data for slider/welcome sections (causing empty output)</li>";
echo "<li>JavaScript/CSS not loading properly</li>";
echo "<li>PHP errors in the template (check error logs)</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 20px; background: #e0f2fe; border-radius: 12px;'>";
echo "<h3>🔧 Quick Fix</h3>";
echo "<p>The template has fallback content now, so the homepage should display something.</p>";
echo "<p>Visit your homepage to see the export business content!</p>";
echo "</div>";
?>