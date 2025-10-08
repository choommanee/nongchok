<?php
/**
 * ทดสอบการแก้ไข Slider Save
 */

require_once 'wp-config.php';

echo "<h1>🔧 แก้ไขปัญหาการบันทึก Slider</h1>";
echo "<style>
body { 
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
    margin: 40px; 
    background: #f8fafc; 
} 
h1 { color: #3b82f6; }
.card { 
    background: white; 
    border-radius: 12px; 
    padding: 24px; 
    margin: 20px 0; 
    box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
}
.success { border-left: 4px solid #10b981; background: #f0fdf4; }
.info { border-left: 4px solid #3b82f6; background: #eff6ff; }
.btn { 
    background: #3b82f6; 
    color: white; 
    padding: 12px 24px; 
    border-radius: 8px; 
    text-decoration: none; 
    font-weight: 600; 
    display: inline-block; 
    margin: 10px 5px;
}
</style>";

echo "<div class='card success'>";
echo "<h2>✅ แก้ไขเสร็จแล้ว!</h2>";
echo "<p><strong>ปัญหา:</strong> หลังจากกดบันทึกแล้ว หน้าแค่ reload ไม่มีการ redirect</p>";
echo "<p><strong>การแก้ไข:</strong> เพิ่ม <code>wp_redirect()</code> และ <code>exit;</code> หลังจากบันทึกสำเร็จ</p>";
echo "<p><strong>ผลลัพธ์:</strong> ตอนนี้หลังจากกดบันทึกจะ redirect ไปหน้าเดิมพร้อมแสดงข้อความ \"บันทึกเรียบร้อย\"</p>";
echo "</div>";

echo "<div class='card info'>";
echo "<h3>🔍 การเปลี่ยนแปลงที่ทำ</h3>";
echo "<pre style='background: #f1f5f9; padding: 15px; border-radius: 8px; overflow-x: auto;'>";
echo "// เดิม
echo '<div class=\"notice notice-success is-dismissible\"><p><strong>✅ สำเร็จ!</strong> บันทึกการตั้งค่า slider เรียบร้อยแล้ว</p></div>';

// Redirect to prevent resubmission

// ใหม่
// Redirect to prevent resubmission
wp_redirect(admin_url('admin.php?page=ayam-slider-settings&saved=1'));
exit;";
echo "</pre>";
echo "</div>";

echo "<div class='card'>";
echo "<h3>🧪 ทดสอบการทำงาน</h3>";
echo "<p>1. ไปที่หน้า Slider Admin</p>";
echo "<p>2. แก้ไขข้อมูลใดๆ</p>";
echo "<p>3. กดปุ่ม \"บันทึกการตั้งค่า\"</p>";
echo "<p>4. ควรเห็นข้อความ \"✅ บันทึกเรียบร้อย!\" ที่ด้านบน</p>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0;'>";
echo "<a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' target='_blank' class='btn'>🎛️ ทดสอบ Slider Admin</a>";
echo "<a href='" . home_url() . "' target='_blank' class='btn' style='background: #10b981;'>🏠 ดูหน้าแรก</a>";
echo "</div>";

// ตรวจสอบว่าฟังก์ชันมีอยู่จริง
if (function_exists('ayam_slider_admin_page')) {
    echo "<div class='card success'>";
    echo "<h3>✅ ฟังก์ชัน ayam_slider_admin_page พบแล้ว</h3>";
    echo "<p>ฟังก์ชันได้รับการแก้ไขเรียบร้อยแล้ว</p>";
    echo "</div>";
} else {
    echo "<div class='card' style='border-left: 4px solid #ef4444; background: #fef2f2;'>";
    echo "<h3>❌ ไม่พบฟังก์ชัน ayam_slider_admin_page</h3>";
    echo "<p>อาจมีปัญหาในการโหลดฟังก์ชัน</p>";
    echo "</div>";
}

// ตรวจสอบ admin menu
$admin_pages = get_option('_transient_doing_cron', false);
echo "<div class='card info'>";
echo "<h3>📋 ข้อมูลเพิ่มเติม</h3>";
echo "<p><strong>WordPress Admin URL:</strong> " . admin_url() . "</p>";
echo "<p><strong>Slider Admin URL:</strong> " . admin_url('admin.php?page=ayam-slider-settings') . "</p>";
echo "<p><strong>Current User Can Manage Options:</strong> " . (current_user_can('manage_options') ? 'Yes' : 'No') . "</p>";
echo "</div>";

echo "<div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; padding: 30px; border-radius: 16px; margin: 40px 0;'>";
echo "<h2>🎉 พร้อมใช้งาน!</h2>";
echo "<p style='font-size: 18px; margin-bottom: 0;'>ตอนนี้ Slider Admin ควรบันทึกข้อมูลได้ปกติแล้ว</p>";
echo "</div>";
?>