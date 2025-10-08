<?php
/**
 * Debug Slider Final Fix
 * ตรวจสอบและแก้ไขปัญหา slider ครั้งสุดท้าย
 */

// เช็คว่าไฟล์ที่จำเป็นมีอยู่หรือไม่
echo "<h1>🔧 Slider Debug & Fix Report</h1>";

$files_to_check = [
    'wp-content/themes/ayam-bangkok/style.css' => 'Main CSS File',
    'wp-content/themes/ayam-bangkok/assets/js/slider-fix.js' => 'Slider Fix JS',
    'wp-content/themes/ayam-bangkok/assets/css/slider-animations.css' => 'Slider Animations CSS',
    'wp-content/themes/ayam-bangkok/front-page.php' => 'Front Page Template'
];

echo "<h2>📁 File Check</h2>";
foreach ($files_to_check as $file => $description) {
    $exists = file_exists($file);
    $status = $exists ? '✅' : '❌';
    $size = $exists ? filesize($file) : 0;
    echo "<p>{$status} {$description}: {$file} (" . number_format($size) . " bytes)</p>";
}

// เช็ค WordPress functions
echo "<h2>🔧 WordPress Functions Check</h2>";
if (function_exists('wp_enqueue_style')) {
    echo "✅ wp_enqueue_style function exists<br>";
} else {
    echo "❌ wp_enqueue_style function missing<br>";
}

if (function_exists('wp_enqueue_script')) {
    echo "✅ wp_enqueue_script function exists<br>";
} else {
    echo "❌ wp_enqueue_script function missing<br>";
}

// เช็ค theme functions
echo "<h2>🎨 Theme Functions Check</h2>";
if (function_exists('ayam_get_slider_images')) {
    echo "✅ ayam_get_slider_images function exists<br>";
} else {
    echo "❌ ayam_get_slider_images function missing<br>";
}

if (function_exists('ayam_get_slider_settings')) {
    echo "✅ ayam_get_slider_settings function exists<br>";
} else {
    echo "❌ ayam_get_slider_settings function missing<br>";
}

// แสดงข้อมูล slider
echo "<h2>🖼️ Slider Data</h2>";
if (function_exists('ayam_get_slider_images')) {
    $slider_images = ayam_get_slider_images();
    echo "<p>Number of slides: " . count($slider_images) . "</p>";
    
    if (!empty($slider_images)) {
        echo "<h3>Slide Details:</h3>";
        foreach ($slider_images as $index => $slide) {
            echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0;'>";
            echo "<strong>Slide " . ($index + 1) . ":</strong><br>";
            echo "Title: " . ($slide['slide_title'] ?? 'No title') . "<br>";
            echo "Description: " . ($slide['slide_description'] ?? 'No description') . "<br>";
            echo "Image: " . ($slide['slide_image'] ?? 'No image') . "<br>";
            echo "Button Text: " . ($slide['slide_button_text'] ?? 'No button') . "<br>";
            echo "Button URL: " . ($slide['slide_button_url'] ?? 'No URL') . "<br>";
            echo "</div>";
        }
    } else {
        echo "<p>❌ No slides found</p>";
    }
}

if (function_exists('ayam_get_slider_settings')) {
    $slider_settings = ayam_get_slider_settings();
    echo "<h3>Slider Settings:</h3>";
    echo "<pre>" . print_r($slider_settings, true) . "</pre>";
}

// CSS Debug
echo "<h2>🎨 CSS Debug</h2>";
$style_file = 'wp-content/themes/ayam-bangkok/style.css';
if (file_exists($style_file)) {
    $css_content = file_get_contents($style_file);
    $hero_slider_count = substr_count($css_content, '.hero-slider-section');
    $swiper_count = substr_count($css_content, '.hero-swiper');
    $btn_modern_count = substr_count($css_content, '.btn-modern');
    
    echo "<p>✅ CSS file loaded</p>";
    echo "<p>Hero slider CSS rules: {$hero_slider_count}</p>";
    echo "<p>Swiper CSS rules: {$swiper_count}</p>";
    echo "<p>Button CSS rules: {$btn_modern_count}</p>";
} else {
    echo "<p>❌ CSS file not found</p>";
}

// JavaScript Debug
echo "<h2>📜 JavaScript Debug</h2>";
$js_file = 'wp-content/themes/ayam-bangkok/assets/js/slider-fix.js';
if (file_exists($js_file)) {
    $js_content = file_get_contents($js_file);
    $swiper_init_count = substr_count($js_content, 'new Swiper');
    $console_log_count = substr_count($js_content, 'console.log');
    
    echo "<p>✅ Slider fix JS file loaded</p>";
    echo "<p>Swiper initializations: {$swiper_init_count}</p>";
    echo "<p>Debug logs: {$console_log_count}</p>";
} else {
    echo "<p>❌ Slider fix JS file not found</p>";
}

// Generate fix recommendations
echo "<h2>🔧 Fix Recommendations</h2>";

if (!function_exists('ayam_get_slider_images')) {
    echo "<div style='background: #ffebee; padding: 10px; margin: 10px 0; border-left: 4px solid #f44336;'>";
    echo "<strong>❌ Critical:</strong> Slider functions missing. Check if plugin is activated.";
    echo "</div>";
}

if (function_exists('ayam_get_slider_images')) {
    $slider_images = ayam_get_slider_images();
    if (empty($slider_images)) {
        echo "<div style='background: #fff3e0; padding: 10px; margin: 10px 0; border-left: 4px solid #ff9800;'>";
        echo "<strong>⚠️ Warning:</strong> No slides configured. Add slides in admin panel.";
        echo "</div>";
    }
}

echo "<div style='background: #e8f5e8; padding: 10px; margin: 10px 0; border-left: 4px solid #4caf50;'>";
echo "<strong>✅ Applied Fixes:</strong><br>";
echo "• Added direct CSS overrides with !important<br>";
echo "• Created dedicated slider fix JavaScript<br>";
echo "• Added fallback slider mechanism<br>";
echo "• Enhanced text contrast with multiple shadows<br>";
echo "• Fixed button styling conflicts<br>";
echo "• Improved image positioning options<br>";
echo "</div>";

// Test HTML output
echo "<h2>🧪 Test Slider HTML</h2>";
echo "<div style='background: #f5f5f5; padding: 15px; border: 1px solid #ddd;'>";
echo "<p><strong>Expected HTML structure:</strong></p>";
echo "<pre style='background: white; padding: 10px; overflow-x: auto;'>";
echo htmlspecialchars('
<section class="hero-slider-section">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background-image: url(\'image.jpg\');">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <div class="container">
                        <div class="slide-inner">
                            <h1 class="slide-title">Title</h1>
                            <p class="slide-description">Description</p>
                            <div class="slide-buttons">
                                <a href="#" class="btn-modern primary">Button</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
');
echo "</pre>";
echo "</div>";

echo "<h2>🚀 Next Steps</h2>";
echo "<ol>";
echo "<li>Clear browser cache and refresh the page</li>";
echo "<li>Check browser console for JavaScript errors</li>";
echo "<li>Verify that Swiper library is loading</li>";
echo "<li>Test on different devices and browsers</li>";
echo "<li>If issues persist, check for theme/plugin conflicts</li>";
echo "</ol>";

echo "<style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; max-width: 1200px; margin: 0 auto; padding: 20px; }
h1 { color: #1e40af; }
h2 { color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem; }
pre { background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #3b82f6; overflow-x: auto; }
</style>";
?>