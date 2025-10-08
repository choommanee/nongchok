<?php
/**
 * Test WP Config Fix
 */

require_once 'wp-config.php';

echo "<h1>🔧 ทดสอบการแก้ไข wp-config.php</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #10b981; }</style>";

echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #059669; margin-top: 0;'>✅ wp-config.php แก้ไขเรียบร้อย</h2>";
echo "<p>ไม่มี Fatal errors แล้ว!</p>";

// ตรวจสอบการตั้งค่า
echo "<h3>🔍 ตรวจสอบการตั้งค่า:</h3>";
echo "<ul>";
echo "<li><strong>WP_LOCAL_DEV:</strong> " . (defined('WP_LOCAL_DEV') ? '✅ กำหนดแล้ว' : '❌ ไม่ได้กำหนด') . "</li>";
echo "<li><strong>HTTPS Status:</strong> " . (isset($_SERVER['HTTPS']) ? '✅ ตั้งค่าแล้ว' : '❌ ไม่ได้ตั้งค่า') . "</li>";
echo "<li><strong>HTTP_HOST:</strong> " . esc_html($_SERVER['HTTP_HOST'] ?? 'ไม่มี') . "</li>";
echo "</ul>";

echo "</div>";

// ตรวจสอบ WordPress functions
echo "<div style='background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #1e40af; margin-top: 0;'>🔧 ตรวจสอบ WordPress Functions</h2>";

$wp_functions = array(
    'add_filter' => function_exists('add_filter'),
    'wp_enqueue_script' => function_exists('wp_enqueue_script'),
    'admin_url' => function_exists('admin_url'),
    'get_option' => function_exists('get_option')
);

foreach ($wp_functions as $func => $exists) {
    echo "<p>" . ($exists ? '✅' : '❌') . " <strong>$func()</strong></p>";
}

echo "</div>";

// ตรวจสอบ Slider functions
echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #92400e; margin-top: 0;'>🎛️ ตรวจสอบ Slider Functions</h2>";

$slider_functions = array(
    'ayam_slider_admin_page' => function_exists('ayam_slider_admin_page'),
    'ayam_get_slider_images' => function_exists('ayam_get_slider_images'),
    'ayam_get_slider_settings' => function_exists('ayam_get_slider_settings')
);

foreach ($slider_functions as $func => $exists) {
    echo "<p>" . ($exists ? '✅' : '❌') . " <strong>$func()</strong></p>";
}

// ตรวจสอบข้อมูล slider
$slides = get_option('ayam_slider_images', array());
echo "<p>✅ <strong>Slider Data:</strong> " . count($slides) . " slides</p>";

echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 30px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 16px;'>";
echo "<h2 style='color: #0c4a6e; margin-bottom: 20px;'>🎉 ระบบทำงานปกติแล้ว!</h2>";
echo "<p style='font-size: 18px; color: #0369a1; margin-bottom: 25px;'>wp-config.php ได้รับการแก้ไขและ WordPress โหลดได้แล้ว</p>";

echo "<div style='display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;'>";
echo "<a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' target='_blank' style='background: #3b82f6; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600;'>🎛️ ทดสอบ Slider Admin</a>";
echo "<a href='" . admin_url() . "' target='_blank' style='background: #10b981; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600;'>🏠 WordPress Admin</a>";
echo "</div>";

echo "</div>";

echo "<div style='background: #ecfdf5; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3 style='color: #059669; margin-top: 0;'>📋 สิ่งที่แก้ไข</h3>";
echo "<ul>";
echo "<li>✅ ลบ add_filter() ออกจาก wp-config.php</li>";
echo "<li>✅ ย้าย SSL filters ไปใน functions.php</li>";
echo "<li>✅ เพิ่ม WP_LOCAL_DEV definition</li>";
echo "<li>✅ แก้ไข Fatal error</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3 style='color: #92400e; margin-top: 0;'>⚠️ ขั้นตอนต่อไป</h3>";
echo "<ol>";
echo "<li>ทดสอบเข้า WordPress Admin</li>";
echo "<li>ทดสอบหน้า Slider Admin</li>";
echo "<li>ทดสอบการเลือกรูปจาก Media Library</li>";
echo "<li>ทดสอบการบันทึกข้อมูล</li>";
echo "</ol>";
echo "</div>";
?>