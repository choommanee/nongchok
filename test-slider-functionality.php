<?php
/**
 * Test Slider Functionality
 */

require_once 'wp-config.php';

echo "<h1>🔧 Testing Slider Functionality</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #3b82f6; }</style>";

// Test 1: Check if slider admin menu exists
echo "<h2>1. ตรวจสอบ Admin Menu</h2>";
if (function_exists('ayam_slider_admin_page')) {
    echo "<p style='color: #10b981;'>✅ ฟังก์ชัน ayam_slider_admin_page มีอยู่</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ ฟังก์ชัน ayam_slider_admin_page ไม่พบ</p>";
}

// Test 2: Check current slider data
echo "<h2>2. ข้อมูล Slider ปัจจุบัน</h2>";
$slides = get_option('ayam_slider_images', array());
echo "<p>จำนวน slides: <strong>" . count($slides) . "</strong></p>";

if (!empty($slides)) {
    echo "<div style='background: #f8fafc; padding: 15px; border-radius: 8px; margin: 10px 0;'>";
    foreach ($slides as $i => $slide) {
        echo "<div style='border-bottom: 1px solid #e2e8f0; padding: 10px 0;'>";
        echo "<strong>Slide " . ($i + 1) . ":</strong><br>";
        echo "Title: " . esc_html($slide['slide_title'] ?? 'ไม่มี') . "<br>";
        echo "Image: " . esc_html($slide['slide_image'] ?? 'ไม่มี') . "<br>";
        echo "Description: " . esc_html($slide['slide_description'] ?? 'ไม่มี') . "<br>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p style='color: #f59e0b;'>⚠️ ไม่มีข้อมูล slides</p>";
}

// Test 3: Check slider settings
echo "<h2>3. การตั้งค่า Slider</h2>";
$settings = array(
    'autoplay' => get_option('ayam_slider_autoplay', true),
    'autoplay_speed' => get_option('ayam_slider_autoplay_speed', 5000),
    'show_navigation' => get_option('ayam_slider_show_navigation', true),
    'show_pagination' => get_option('ayam_slider_show_pagination', true),
    'height' => get_option('ayam_slider_height', '600px')
);

echo "<div style='background: #f1f5f9; padding: 15px; border-radius: 8px;'>";
foreach ($settings as $key => $value) {
    echo "<p><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> ";
    if (is_bool($value)) {
        echo $value ? 'เปิด' : 'ปิด';
    } else {
        echo esc_html($value);
    }
    echo "</p>";
}
echo "</div>";

// Test 4: Simulate form submission
echo "<h2>4. ทดสอบการบันทึกข้อมูล</h2>";

// Create test data
$test_slides = array(
    array(
        'image' => get_template_directory_uri() . '/assets/images/hero-export-1.jpg',
        'title' => 'ทดสอบ Slide 1',
        'description' => 'คำอธิบายทดสอบ',
        'button_text' => 'ดูเพิ่มเติม',
        'button_url' => '#test',
        'text_position' => 'center'
    )
);

// Simulate saving
$slider_data = array();
foreach ($test_slides as $slide) {
    if (!empty($slide['image']) || !empty($slide['title'])) {
        $slider_data[] = array(
            'slide_image' => sanitize_url($slide['image']),
            'slide_title' => sanitize_text_field($slide['title']),
            'slide_description' => sanitize_textarea_field($slide['description']),
            'slide_button_text' => sanitize_text_field($slide['button_text']),
            'slide_button_url' => sanitize_url($slide['button_url']),
            'slide_text_position' => sanitize_text_field($slide['text_position'])
        );
    }
}

$result = update_option('ayam_slider_images_test', $slider_data);

if ($result) {
    echo "<p style='color: #10b981;'>✅ การบันทึกข้อมูลทำงานปกติ</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ การบันทึกข้อมูลมีปัญหา</p>";
}

// Test 5: Check WordPress capabilities
echo "<h2>5. ตรวจสอบสิทธิ์ WordPress</h2>";

if (current_user_can('manage_options')) {
    echo "<p style='color: #10b981;'>✅ ผู้ใช้มีสิทธิ์ manage_options</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ ผู้ใช้ไม่มีสิทธิ์ manage_options</p>";
}

if (is_admin()) {
    echo "<p style='color: #10b981;'>✅ อยู่ในหน้า admin</p>";
} else {
    echo "<p style='color: #f59e0b;'>⚠️ ไม่ได้อยู่ในหน้า admin</p>";
}

// Test 6: Check nonce functionality
echo "<h2>6. ทดสอบ Nonce</h2>";
$nonce_action = 'ayam_slider_save';
$nonce = wp_create_nonce($nonce_action);
echo "<p>Nonce สร้างได้: <code>" . esc_html($nonce) . "</code></p>";

$verify = wp_verify_nonce($nonce, $nonce_action);
if ($verify) {
    echo "<p style='color: #10b981;'>✅ Nonce verification ทำงานปกติ</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ Nonce verification มีปัญหา</p>";
}

// Test 7: Check if scripts are enqueued properly
echo "<h2>7. ตรวจสอบ Scripts และ Styles</h2>";

$css_file = get_template_directory() . '/assets/css/admin-slider.css';
$js_file = get_template_directory() . '/assets/js/admin-slider.js';

if (file_exists($css_file)) {
    echo "<p style='color: #10b981;'>✅ ไฟล์ CSS มีอยู่: " . filesize($css_file) . " bytes</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ ไฟล์ CSS ไม่พบ</p>";
}

if (file_exists($js_file)) {
    echo "<p style='color: #10b981;'>✅ ไฟล์ JS มีอยู่: " . filesize($js_file) . " bytes</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ ไฟล์ JS ไม่พบ</p>";
}

echo "<div style='background: #e0f2fe; border-radius: 12px; padding: 20px; margin: 30px 0;'>";
echo "<h3 style='color: #0c4a6e; margin-top: 0;'>🔍 การแก้ไขปัญหา</h3>";
echo "<p>หากยังบันทึกไม่ได้ ให้ตรวจสอบ:</p>";
echo "<ol>";
echo "<li>เปิด Developer Tools (F12) และดู Console สำหรับ JavaScript errors</li>";
echo "<li>ตรวจสอบ Network tab เพื่อดูว่า form submit หรือไม่</li>";
echo "<li>ตรวจสอบว่าปุ่มบันทึกมี name='save_slider' หรือไม่</li>";
echo "<li>ตรวจสอบว่า nonce field ถูกส่งไปด้วยหรือไม่</li>";
echo "<li>ลองปิด JavaScript validation ชั่วคราว</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 30px 0;'>";
echo "<a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' style='background: #3b82f6; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;'>🎛️ ไปที่หน้า Slider Admin</a>";
echo "</div>";
?>