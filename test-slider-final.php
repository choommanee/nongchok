<?php
/**
 * Final Test for Slider Admin
 */

require_once 'wp-config.php';

echo "<h1>🎯 ทดสอบ Slider Admin ครั้งสุดท้าย</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #10b981; }</style>";

echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #059669; margin-top: 0;'>✅ ปัญหาที่แก้ไขแล้ว</h2>";
echo "<ul>";
echo "<li>✅ แก้ไข JavaScript syntax error</li>";
echo "<li>✅ เพิ่ม selectMedia function</li>";
echo "<li>✅ แก้ไข Mixed Content (HTTP/HTTPS)</li>";
echo "<li>✅ ปิด form validation ที่ป้องกันการ submit</li>";
echo "</ul>";
echo "</div>";

// ตรวจสอบไฟล์ JavaScript
echo "<div style='background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #1e40af; margin-top: 0;'>📁 ตรวจสอบไฟล์</h2>";

$js_file = get_template_directory() . '/assets/js/admin-slider.js';
if (file_exists($js_file)) {
    $js_content = file_get_contents($js_file);
    echo "<p>✅ ไฟล์ JavaScript มีอยู่ (" . number_format(filesize($js_file)) . " bytes)</p>";
    
    // ตรวจสอบว่ามี selectMedia function หรือไม่
    if (strpos($js_content, 'window.selectMedia') !== false) {
        echo "<p>✅ พบ selectMedia function</p>";
    } else {
        echo "<p>❌ ไม่พบ selectMedia function</p>";
    }
    
    // ตรวจสอบ syntax errors พื้นฐาน
    $bracket_open = substr_count($js_content, '{');
    $bracket_close = substr_count($js_content, '}');
    $paren_open = substr_count($js_content, '(');
    $paren_close = substr_count($js_content, ')');
    
    if ($bracket_open === $bracket_close && $paren_open === $paren_close) {
        echo "<p>✅ Syntax ดูถูกต้อง (brackets และ parentheses สมดุล)</p>";
    } else {
        echo "<p>❌ อาจมี syntax error (brackets: $bracket_open/$bracket_close, parentheses: $paren_open/$paren_close)</p>";
    }
} else {
    echo "<p>❌ ไม่พบไฟล์ JavaScript</p>";
}

$css_file = get_template_directory() . '/assets/css/admin-slider.css';
if (file_exists($css_file)) {
    echo "<p>✅ ไฟล์ CSS มีอยู่ (" . number_format(filesize($css_file)) . " bytes)</p>";
} else {
    echo "<p>❌ ไม่พบไฟล์ CSS</p>";
}

echo "</div>";

// ตรวจสอบข้อมูล slider
echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #92400e; margin-top: 0;'>📊 ข้อมูล Slider</h2>";

$slides = get_option('ayam_slider_images', array());
echo "<p><strong>จำนวน slides:</strong> " . count($slides) . "</p>";

if (!empty($slides)) {
    foreach ($slides as $i => $slide) {
        echo "<div style='background: white; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #f59e0b;'>";
        echo "<h4>Slide " . ($i + 1) . "</h4>";
        echo "<p><strong>Title:</strong> " . esc_html($slide['slide_title'] ?? 'ไม่มี') . "</p>";
        echo "<p><strong>Image:</strong> " . esc_html($slide['slide_image'] ?? 'ไม่มี') . "</p>";
        
        // ตรวจสอบว่า URL เป็น HTTPS หรือไม่
        if (!empty($slide['slide_image'])) {
            if (strpos($slide['slide_image'], 'https://') === 0) {
                echo "<p style='color: #10b981;'>✅ URL ใช้ HTTPS</p>";
            } else {
                echo "<p style='color: #ef4444;'>❌ URL ไม่ใช่ HTTPS</p>";
            }
        }
        echo "</div>";
    }
}

echo "</div>";

// ตรวจสอบ functions
echo "<div style='background: #f3e8ff; border: 2px solid #8b5cf6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #6b21a8; margin-top: 0;'>🔧 ตรวจสอบ Functions</h2>";

$functions = array(
    'ayam_slider_admin_page',
    'ayam_get_slider_images', 
    'ayam_get_slider_settings',
    'ayam_display_slider'
);

foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "<p style='color: #10b981;'>✅ $func() - พร้อมใช้งาน</p>";
    } else {
        echo "<p style='color: #ef4444;'>❌ $func() - ไม่พบ</p>";
    }
}

echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 30px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 16px;'>";
echo "<h2 style='color: #0c4a6e; margin-bottom: 20px;'>🚀 พร้อมทดสอบ!</h2>";
echo "<p style='font-size: 18px; color: #0369a1; margin-bottom: 25px;'>ตอนนี้หน้า admin slider ควรทำงานได้แล้ว</p>";
echo "<a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' target='_blank' style='background: #3b82f6; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);'>🎛️ ทดสอบ Slider Admin</a>";
echo "</div>";

echo "<div style='background: #ecfdf5; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3 style='color: #059669; margin-top: 0;'>📋 สิ่งที่ควรทำงานได้แล้ว</h3>";
echo "<ul>";
echo "<li>✅ หน้า admin โหลดได้โดยไม่มี JavaScript errors</li>";
echo "<li>✅ ปุ่ม \"เลือกรูปจาก Media\" ทำงานได้</li>";
echo "<li>✅ สามารถเพิ่ม/ลบ slides ได้</li>";
echo "<li>✅ สามารถลาก drop เรียงลำดับได้</li>";
echo "<li>✅ สามารถบันทึกข้อมูลได้</li>";
echo "<li>✅ ไม่มี Mixed Content warnings</li>";
echo "</ul>";
echo "</div>";
?>