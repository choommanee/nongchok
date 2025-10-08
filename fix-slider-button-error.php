<?php
/**
 * Fix Slider Button Error - แก้ไขปัญหาปุ่ม slider ที่แสดง HTML code
 */

// Turn off error reporting to prevent PHP errors from showing in HTML
error_reporting(0);
ini_set('display_errors', 0);

// Add to wp-config.php to prevent errors from showing
$wp_config_path = __DIR__ . '/wp-config.php';
$wp_config_content = file_get_contents($wp_config_path);

// Check if debug settings already exist
if (strpos($wp_config_content, "define('WP_DEBUG_DISPLAY', false);") === false) {
    // Find the line with "That's all, stop editing!"
    $insert_before = "/* That's all, stop editing! Happy publishing. */";
    
    $debug_settings = "
// Disable error display to prevent HTML corruption
define('WP_DEBUG_DISPLAY', false);
define('WP_DEBUG_LOG', true);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

";
    
    $wp_config_content = str_replace($insert_before, $debug_settings . $insert_before, $wp_config_content);
    file_put_contents($wp_config_path, $wp_config_content);
    echo "✅ Updated wp-config.php to prevent error display\n";
} else {
    echo "✅ wp-config.php already has error display disabled\n";
}

// Create emergency CSS fix for buttons
$emergency_css = "
/* Emergency Button Fix */
.hero-slider .slide-buttons a {
    display: inline-block !important;
    padding: 12px 24px !important;
    background: rgba(255, 255, 255, 0.9) !important;
    color: #333 !important;
    text-decoration: none !important;
    border-radius: 5px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    border: 2px solid rgba(255, 255, 255, 0.9) !important;
    text-shadow: none !important;
    font-size: 16px !important;
    line-height: 1.4 !important;
}

.hero-slider .slide-buttons a:hover {
    background: rgba(255, 255, 255, 1) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
}

.hero-slider .slide-buttons a i {
    margin-left: 8px !important;
    font-size: 14px !important;
}

/* Hide any error text that might appear */
.hero-slider .slide-buttons a br,
.hero-slider .slide-buttons a b {
    display: none !important;
}

/* Force clean button text */
.hero-slider .slide-buttons a {
    font-family: inherit !important;
    white-space: nowrap !important;
    overflow: hidden !important;
}

/* Background image fix */
.hero-slider .swiper-slide {
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    min-height: 600px !important;
}

/* Ensure slide overlay works */
.hero-slider .slide-overlay {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background: rgba(0, 0, 0, 0.4) !important;
    z-index: 1 !important;
}

/* Ensure content is above overlay */
.hero-slider .slide-content {
    position: relative !important;
    z-index: 2 !important;
}
";

file_put_contents('wp-content/themes/ayam-bangkok/assets/css/emergency-button-fix.css', $emergency_css);
echo "✅ Created emergency button CSS fix\n";

// Add the CSS to functions.php
$functions_path = 'wp-content/themes/ayam-bangkok/functions.php';
$functions_content = file_get_contents($functions_path);

$css_enqueue = "
// Emergency button fix CSS
function ayam_emergency_button_fix() {
    wp_enqueue_style('ayam-emergency-button-fix', 
        get_template_directory_uri() . '/assets/css/emergency-button-fix.css', 
        array(), 
        '1.0.1'
    );
}
add_action('wp_enqueue_scripts', 'ayam_emergency_button_fix', 999);
";

if (strpos($functions_content, 'ayam_emergency_button_fix') === false) {
    $functions_content .= $css_enqueue;
    file_put_contents($functions_path, $functions_content);
    echo "✅ Added emergency CSS to functions.php\n";
} else {
    echo "✅ Emergency CSS already added to functions.php\n";
}

// Create JavaScript fix for buttons
$button_fix_js = "
// Emergency Button Fix JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Emergency Button Fix: Starting...');
    
    // Fix button HTML entities and errors
    function fixButtonHTML() {
        const buttons = document.querySelectorAll('.hero-slider .slide-buttons a');
        console.log('Found buttons:', buttons.length);
        
        buttons.forEach((button, index) => {
            console.log('Button ' + (index + 1) + ' HTML:', button.innerHTML);
            
            // Clean up the button content
            let cleanText = button.innerHTML;
            
            // Remove PHP error messages and paths
            cleanText = cleanText.replace(/\/[^<]*\.php[^<]*<b>[^<]*<\/b>[^<]*/gi, '');
            
            // Remove HTML entities and fix encoding
            cleanText = cleanText.replace(/&gt;/g, '>');
            cleanText = cleanText.replace(/&lt;/g, '<');
            cleanText = cleanText.replace(/&quot;/g, '\"');
            cleanText = cleanText.replace(/&amp;/g, '&');
            
            // Extract just the button text and icon
            const textMatch = cleanText.match(/([^<]*ดูเพิ่มเติม[^<]*)/);
            const iconMatch = cleanText.match(/<i[^>]*fas fa-arrow-right[^>]*><\/i>/);
            
            if (textMatch) {
                let buttonText = textMatch[1].trim();
                let iconHTML = iconMatch ? iconMatch[0] : '<i class=\"fas fa-arrow-right\"></i>';
                
                // Clean button text
                buttonText = buttonText.replace(/[^ก-๙a-zA-Z0-9\\s]/g, '').trim();
                if (!buttonText) buttonText = 'ดูเพิ่มเติม';
                
                button.innerHTML = buttonText + ' ' + iconHTML;
                console.log('Fixed HTML entities for button ' + (index + 1));
            }
            
            // Ensure proper styling
            button.style.display = 'inline-block';
            button.style.padding = '12px 24px';
            button.style.background = 'rgba(255, 255, 255, 0.9)';
            button.style.color = '#333';
            button.style.textDecoration = 'none';
            button.style.borderRadius = '5px';
            button.style.fontWeight = '600';
            button.style.border = '2px solid rgba(255, 255, 255, 0.9)';
            button.style.textShadow = 'none';
            button.style.fontSize = '16px';
            button.style.lineHeight = '1.4';
        });
    }
    
    // Fix background images
    function fixBackgroundImages() {
        const slides = document.querySelectorAll('.hero-slider .swiper-slide');
        slides.forEach((slide, index) => {
            const style = window.getComputedStyle(slide);
            const bgImage = style.backgroundImage;
            console.log('Slide ' + (index + 1) + ' style:', bgImage);
            
            if (bgImage && bgImage !== 'none') {
                slide.style.backgroundSize = 'cover';
                slide.style.backgroundPosition = 'center';
                slide.style.backgroundRepeat = 'no-repeat';
                slide.style.minHeight = '600px';
                console.log('Fixed background for slide ' + (index + 1));
            }
        });
    }
    
    // Run fixes
    fixButtonHTML();
    fixBackgroundImages();
    
    // Run fixes again after a delay to catch dynamic content
    setTimeout(() => {
        fixButtonHTML();
        fixBackgroundImages();
    }, 1000);
    
    console.log('Emergency Button Fix: Complete');
});
";

file_put_contents('wp-content/themes/ayam-bangkok/assets/js/emergency-button-fix.js', $button_fix_js);
echo "✅ Created emergency button JavaScript fix\n";

// Add JavaScript to functions.php
$js_enqueue = "
// Emergency button fix JavaScript
function ayam_emergency_button_fix_js() {
    wp_enqueue_script('ayam-emergency-button-fix-js', 
        get_template_directory_uri() . '/assets/js/emergency-button-fix.js', 
        array('jquery'), 
        '1.0.1', 
        true
    );
}
add_action('wp_enqueue_scripts', 'ayam_emergency_button_fix_js', 999);
";

if (strpos($functions_content, 'ayam_emergency_button_fix_js') === false) {
    $functions_content = file_get_contents($functions_path); // Re-read in case it was updated
    $functions_content .= $js_enqueue;
    file_put_contents($functions_path, $functions_content);
    echo "✅ Added emergency JavaScript to functions.php\n";
} else {
    echo "✅ Emergency JavaScript already added to functions.php\n";
}

echo "\n🎯 Emergency fixes applied:\n";
echo "1. ✅ Disabled PHP error display in wp-config.php\n";
echo "2. ✅ Created emergency CSS for button styling\n";
echo "3. ✅ Created JavaScript to clean button HTML\n";
echo "4. ✅ Added background image fixes\n";
echo "5. ✅ Enqueued both CSS and JS files\n";
echo "\n🔄 Please refresh your website to see the fixes!\n";
?>