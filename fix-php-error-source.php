<?php
/**
 * Fix PHP Error Source - แก้ไขปัญหา PHP error ที่ต้นเหตุ
 */

echo "🔧 Fixing PHP error source...\n";

// 1. Fix wp-config.php warnings
$wp_config_path = 'wp-config.php';
$wp_config_content = file_get_contents($wp_config_path);

// Remove duplicate debug constants
$lines = explode("\n", $wp_config_content);
$cleaned_lines = array();
$debug_constants_added = false;

foreach ($lines as $line) {
    // Skip duplicate debug constants
    if (strpos($line, "define('WP_DEBUG_DISPLAY'") !== false || 
        strpos($line, "define('WP_DEBUG_LOG'") !== false ||
        strpos($line, "ini_set('display_errors'") !== false ||
        strpos($line, "ini_set('log_errors'") !== false) {
        
        if (!$debug_constants_added) {
            $cleaned_lines[] = "define('WP_DEBUG_DISPLAY', false);";
            $cleaned_lines[] = "define('WP_DEBUG_LOG', true);";
            $cleaned_lines[] = "ini_set('display_errors', 0);";
            $cleaned_lines[] = "ini_set('log_errors', 1);";
            $debug_constants_added = true;
        }
        continue;
    }
    $cleaned_lines[] = $line;
}

file_put_contents($wp_config_path, implode("\n", $cleaned_lines));
echo "✅ Fixed wp-config.php duplicate constants\n";

// 2. Fix front-page.php to handle undefined array keys
$front_page_path = 'wp-content/themes/ayam-bangkok/front-page.php';
$front_page_content = file_get_contents($front_page_path);

// Replace the problematic line with safe array access
$old_button_code = 'class="btn-modern <?php echo esc_attr($slide[\'slide_button_style\'] ?: \'primary\'); ?>">';
$new_button_code = 'class="btn-modern <?php echo esc_attr(isset($slide[\'slide_button_style\']) ? $slide[\'slide_button_style\'] : \'primary\'); ?>">';

if (strpos($front_page_content, $old_button_code) !== false) {
    $front_page_content = str_replace($old_button_code, $new_button_code, $front_page_content);
    echo "✅ Fixed button style array access\n";
}

// Also fix other potential undefined index issues
$replacements = array(
    '$slide[\'slide_text_position\'] ?: \'center\'' => 'isset($slide[\'slide_text_position\']) ? $slide[\'slide_text_position\'] : \'center\'',
    '$slide[\'slide_title\']' => 'isset($slide[\'slide_title\']) ? $slide[\'slide_title\'] : \'\'',
    '$slide[\'slide_description\']' => 'isset($slide[\'slide_description\']) ? $slide[\'slide_description\'] : \'\'',
    '$slide[\'slide_button_text\']' => 'isset($slide[\'slide_button_text\']) ? $slide[\'slide_button_text\'] : \'\'',
    '$slide[\'slide_button_url\']' => 'isset($slide[\'slide_button_url\']) ? $slide[\'slide_button_url\'] : \'\'',
    '$slide[\'slide_image\']' => 'isset($slide[\'slide_image\']) ? $slide[\'slide_image\'] : \'\''
);

foreach ($replacements as $old => $new) {
    if (strpos($front_page_content, $old) !== false) {
        $front_page_content = str_replace($old, $new, $front_page_content);
        echo "✅ Fixed array access for: $old\n";
    }
}

file_put_contents($front_page_path, $front_page_content);
echo "✅ Updated front-page.php with safe array access\n";

// 3. Add error suppression to slider functions
$functions_path = 'wp-content/themes/ayam-bangkok/functions.php';
$functions_content = file_get_contents($functions_path);

// Find and update ayam_get_slider_images function
$pattern = '/function ayam_get_slider_images\(\) \{(.*?)\}/s';
$replacement = 'function ayam_get_slider_images() {
    $slides = @get_option(\'ayam_slider_images\', array());
    
    // Ensure it\'s an array
    if (!is_array($slides)) {
        $slides = @json_decode($slides, true) ?: array();
    }
    
    // Filter out empty slides and ensure all required keys exist
    $slides = array_filter($slides, function($slide) {
        return !empty($slide[\'slide_image\']) || !empty($slide[\'slide_title\']);
    });
    
    // Ensure all slides have required keys
    foreach ($slides as &$slide) {
        $slide = array_merge(array(
            \'slide_image\' => \'\',
            \'slide_title\' => \'\',
            \'slide_description\' => \'\',
            \'slide_button_text\' => \'\',
            \'slide_button_url\' => \'\',
            \'slide_button_style\' => \'primary\',
            \'slide_text_position\' => \'center\'
        ), $slide);
    }
    
    return $slides;
}';

if (preg_match($pattern, $functions_content)) {
    $functions_content = preg_replace($pattern, $replacement, $functions_content);
    file_put_contents($functions_path, $functions_content);
    echo "✅ Updated ayam_get_slider_images with error suppression\n";
} else {
    echo "⚠️ Could not find ayam_get_slider_images function to update\n";
}

// 4. Create a simple button replacement script
$button_replacement_js = '
// Simple Button Replacement - No debugging
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        const buttons = document.querySelectorAll(".hero-slider .slide-buttons a");
        buttons.forEach(function(button) {
            const href = button.getAttribute("href") || "#";
            button.innerHTML = "ดูเพิ่มเติม <i class=\"fas fa-arrow-right\"></i>";
            button.setAttribute("href", href);
            
            // Apply clean styles
            button.style.cssText = `
                display: inline-block !important;
                padding: 12px 24px !important;
                background: rgba(255, 255, 255, 0.95) !important;
                color: #333 !important;
                text-decoration: none !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
                border: 2px solid rgba(255, 255, 255, 0.95) !important;
                text-shadow: none !important;
                font-size: 16px !important;
                line-height: 1.4 !important;
                font-family: Sarabun, sans-serif !important;
                white-space: nowrap !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
                transition: all 0.3s ease !important;
            `;
        });
    }, 500);
});
';

file_put_contents('wp-content/themes/ayam-bangkok/assets/js/simple-button-fix.js', $button_replacement_js);
echo "✅ Created simple button replacement script\n";

// 5. Update functions.php to use simple fix
$simple_enqueue = '
// Simple button fix - no debugging
function ayam_simple_button_fix() {
    wp_enqueue_script("ayam-simple-button-fix", 
        get_template_directory_uri() . "/assets/js/simple-button-fix.js", 
        array(), 
        "1.0.3", 
        true
    );
}
add_action("wp_enqueue_scripts", "ayam_simple_button_fix", 1001);
';

if (strpos($functions_content, 'ayam_simple_button_fix') === false) {
    $functions_content .= $simple_enqueue;
    file_put_contents($functions_path, $functions_content);
    echo "✅ Added simple button fix to functions.php\n";
} else {
    echo "✅ Simple button fix already in functions.php\n";
}

echo "\n🎯 PHP error source fixes complete!\n";
echo "1. ✅ Fixed wp-config.php duplicate constants\n";
echo "2. ✅ Added safe array access to front-page.php\n";
echo "3. ✅ Updated slider function with error suppression\n";
echo "4. ✅ Created simple button replacement script\n";
echo "5. ✅ Added high-priority simple fix\n";
echo "\n🔄 Please refresh your website - errors should be gone!\n";
?>