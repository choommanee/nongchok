<?php
/**
 * Check Slider Database Storage
 */

require_once 'wp-config.php';

echo "<h1>🗄️ ตรวจสอบข้อมูล Slider ในฐานข้อมูล</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #3b82f6; } .code { background: #f8fafc; padding: 15px; border-radius: 8px; font-family: monospace; border: 1px solid #e2e8f0; margin: 10px 0; }</style>";

echo "<div style='background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #1e40af; margin-top: 0;'>📊 ข้อมูล Slider ใน WordPress Options</h2>";

// ตรวจสอบข้อมูลใน wp_options
global $wpdb;

echo "<h3>🔍 ค้นหาข้อมูล Slider ใน wp_options</h3>";

$slider_options = $wpdb->get_results("
    SELECT option_name, option_value 
    FROM {$wpdb->options} 
    WHERE option_name LIKE '%slider%' 
    ORDER BY option_name
");

if ($slider_options) {
    echo "<table style='width: 100%; border-collapse: collapse; margin: 15px 0;'>";
    echo "<tr style='background: #f1f5f9;'>";
    echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Option Name</th>";
    echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Value Preview</th>";
    echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Size</th>";
    echo "</tr>";
    
    foreach ($slider_options as $option) {
        echo "<tr>";
        echo "<td style='border: 1px solid #e2e8f0; padding: 10px; font-weight: 600; color: #1e40af;'>" . esc_html($option->option_name) . "</td>";
        
        $value_preview = strlen($option->option_value) > 100 ? 
            substr($option->option_value, 0, 100) . '...' : 
            $option->option_value;
        
        echo "<td style='border: 1px solid #e2e8f0; padding: 10px; font-family: monospace; font-size: 12px;'>" . esc_html($value_preview) . "</td>";
        echo "<td style='border: 1px solid #e2e8f0; padding: 10px;'>" . strlen($option->option_value) . " chars</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: #f59e0b;'>⚠️ ไม่พบข้อมูล slider ใน wp_options</p>";
}

echo "</div>";

// แสดงข้อมูล slider แบบละเอียด
echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #059669; margin-top: 0;'>🖼️ ข้อมูล Slider แบบละเอียด</h2>";

$slides = get_option('ayam_slider_images', array());
$settings = array(
    'ayam_slider_autoplay' => get_option('ayam_slider_autoplay', 1),
    'ayam_slider_autoplay_speed' => get_option('ayam_slider_autoplay_speed', 5000),
    'ayam_slider_show_navigation' => get_option('ayam_slider_show_navigation', 1),
    'ayam_slider_show_pagination' => get_option('ayam_slider_show_pagination', 1),
    'ayam_slider_height' => get_option('ayam_slider_height', '600px')
);

echo "<h3>📸 Slides Data (ayam_slider_images)</h3>";
if (!empty($slides)) {
    echo "<div class='code'>";
    echo "<pre>" . htmlspecialchars(print_r($slides, true)) . "</pre>";
    echo "</div>";
    echo "<p><strong>จำนวน slides:</strong> " . count($slides) . "</p>";
} else {
    echo "<p style='color: #f59e0b;'>⚠️ ไม่มีข้อมูล slides</p>";
}

echo "<h3>⚙️ Settings Data</h3>";
echo "<div class='code'>";
echo "<pre>" . htmlspecialchars(print_r($settings, true)) . "</pre>";
echo "</div>";

echo "</div>";

// แสดงโครงสร้างตาราง wp_options
echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #92400e; margin-top: 0;'>🏗️ โครงสร้างตาราง wp_options</h2>";

$table_structure = $wpdb->get_results("DESCRIBE {$wpdb->options}");

echo "<table style='width: 100%; border-collapse: collapse; margin: 15px 0;'>";
echo "<tr style='background: #f1f5f9;'>";
echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Field</th>";
echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Type</th>";
echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Null</th>";
echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Key</th>";
echo "<th style='border: 1px solid #e2e8f0; padding: 10px; text-align: left;'>Default</th>";
echo "</tr>";

foreach ($table_structure as $field) {
    echo "<tr>";
    echo "<td style='border: 1px solid #e2e8f0; padding: 10px; font-weight: 600;'>" . esc_html($field->Field) . "</td>";
    echo "<td style='border: 1px solid #e2e8f0; padding: 10px;'>" . esc_html($field->Type) . "</td>";
    echo "<td style='border: 1px solid #e2e8f0; padding: 10px;'>" . esc_html($field->Null) . "</td>";
    echo "<td style='border: 1px solid #e2e8f0; padding: 10px;'>" . esc_html($field->Key) . "</td>";
    echo "<td style='border: 1px solid #e2e8f0; padding: 10px;'>" . esc_html($field->Default ?? 'NULL') . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "</div>";

// แสดงคำสั่ง SQL สำหรับดูข้อมูล
echo "<div style='background: #f3e8ff; border: 2px solid #8b5cf6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #6b21a8; margin-top: 0;'>💻 คำสั่ง SQL สำหรับดูข้อมูล</h2>";

echo "<h3>ดูข้อมูล Slider ทั้งหมด:</h3>";
echo "<div class='code'>";
echo "SELECT * FROM wp_options WHERE option_name LIKE '%slider%';";
echo "</div>";

echo "<h3>ดูเฉพาะข้อมูล Slides:</h3>";
echo "<div class='code'>";
echo "SELECT option_value FROM wp_options WHERE option_name = 'ayam_slider_images';";
echo "</div>";

echo "<h3>ลบข้อมูล Slider (ระวัง!):</h3>";
echo "<div class='code'>";
echo "DELETE FROM wp_options WHERE option_name LIKE 'ayam_slider%';";
echo "</div>";

echo "<h3>อัปเดตข้อมูล Slider:</h3>";
echo "<div class='code'>";
echo "UPDATE wp_options SET option_value = 'new_value' WHERE option_name = 'ayam_slider_images';";
echo "</div>";

echo "</div>";

// แสดงวิธีการเข้าถึงข้อมูลใน PHP
echo "<div style='background: #ecfdf5; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #059669; margin-top: 0;'>🐘 วิธีการเข้าถึงข้อมูลใน PHP</h2>";

echo "<h3>ดึงข้อมูล Slides:</h3>";
echo "<div class='code'>";
echo htmlspecialchars('$slides = get_option("ayam_slider_images", array());');
echo "</div>";

echo "<h3>บันทึกข้อมูล Slides:</h3>";
echo "<div class='code'>";
echo htmlspecialchars('update_option("ayam_slider_images", $slides_data);');
echo "</div>";

echo "<h3>ลบข้อมูล Slides:</h3>";
echo "<div class='code'>";
echo htmlspecialchars('delete_option("ayam_slider_images");');
echo "</div>";

echo "<h3>ตรวจสอบว่ามีข้อมูลหรือไม่:</h3>";
echo "<div class='code'>";
echo htmlspecialchars('$exists = get_option("ayam_slider_images") !== false;');
echo "</div>";

echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 30px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 16px;'>";
echo "<h2 style='color: #0c4a6e; margin-bottom: 20px;'>📋 สรุป</h2>";
echo "<p style='font-size: 18px; color: #0369a1; margin-bottom: 25px;'>ข้อมูล Slider เก็บใน <strong>wp_options table</strong> ไม่ใช่ตารางแยก</p>";
echo "<div style='background: white; padding: 20px; border-radius: 12px; margin: 20px 0;'>";
echo "<h3 style='color: #1e40af; margin-top: 0;'>🗂️ Option Names ที่ใช้:</h3>";
echo "<ul style='text-align: left; color: #374151;'>";
echo "<li><code>ayam_slider_images</code> - ข้อมูล slides ทั้งหมด</li>";
echo "<li><code>ayam_slider_autoplay</code> - การเล่นอัตโนมัติ</li>";
echo "<li><code>ayam_slider_autoplay_speed</code> - ความเร็วการเล่น</li>";
echo "<li><code>ayam_slider_show_navigation</code> - แสดงปุ่มนำทาง</li>";
echo "<li><code>ayam_slider_show_pagination</code> - แสดงจุดนำทาง</li>";
echo "<li><code>ayam_slider_height</code> - ความสูง slider</li>";
echo "</ul>";
echo "</div>";
echo "</div>";
?>