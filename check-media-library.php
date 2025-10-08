<?php
/**
 * Check Media Library Status
 */

require_once 'wp-config.php';

echo "<h1>📁 ตรวจสอบ Media Library</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #3b82f6; }</style>";

// ตรวจสอบจำนวนรูปภาพใน Media Library
echo "<div style='background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #1e40af; margin-top: 0;'>📊 สถานะ Media Library</h2>";

$attachments = get_posts(array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'numberposts' => -1
));

echo "<p><strong>จำนวนรูปภาพทั้งหมด:</strong> " . count($attachments) . "</p>";

if (count($attachments) > 0) {
    echo "<h3>รูปภาพใน Media Library:</h3>";
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;'>";
    
    foreach (array_slice($attachments, 0, 10) as $attachment) {
        $url = wp_get_attachment_url($attachment->ID);
        $title = get_the_title($attachment->ID);
        
        echo "<div style='background: white; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;'>";
        echo "<img src='" . esc_url($url) . "' style='width: 100%; height: 120px; object-fit: cover; border-radius: 4px;'>";
        echo "<p style='margin: 5px 0 0 0; font-size: 12px; color: #6b7280;'>" . esc_html($title) . "</p>";
        echo "</div>";
    }
    
    echo "</div>";
    
    if (count($attachments) > 10) {
        echo "<p style='color: #6b7280; font-style: italic;'>แสดง 10 รูปแรก จากทั้งหมด " . count($attachments) . " รูป</p>";
    }
} else {
    echo "<div style='background: #fef2f2; border: 2px solid #ef4444; border-radius: 8px; padding: 20px; margin: 15px 0;'>";
    echo "<h3 style='color: #dc2626; margin-top: 0;'>❌ ไม่มีรูปภาพใน Media Library</h3>";
    echo "<p>นี่คือสาเหตุที่ Media Library หมุนติ้วๆ</p>";
    echo "</div>";
}

echo "</div>";

// ตรวจสอบ upload directory
echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #92400e; margin-top: 0;'>📂 ตรวจสอบ Upload Directory</h2>";

$upload_dir = wp_upload_dir();
echo "<p><strong>Upload Path:</strong> " . esc_html($upload_dir['basedir']) . "</p>";
echo "<p><strong>Upload URL:</strong> " . esc_html($upload_dir['baseurl']) . "</p>";
echo "<p><strong>Directory Exists:</strong> " . (is_dir($upload_dir['basedir']) ? '✅ มีอยู่' : '❌ ไม่มี') . "</p>";
echo "<p><strong>Directory Writable:</strong> " . (is_writable($upload_dir['basedir']) ? '✅ เขียนได้' : '❌ เขียนไม่ได้') . "</p>";

// ตรวจสอบไฟล์ในโฟลเดอร์ uploads
if (is_dir($upload_dir['basedir'])) {
    $files = glob($upload_dir['basedir'] . '/*');
    echo "<p><strong>จำนวนไฟล์/โฟลเดอร์:</strong> " . count($files) . "</p>";
    
    if (count($files) > 0) {
        echo "<details style='margin: 10px 0;'>";
        echo "<summary style='cursor: pointer; font-weight: 600;'>ดูรายการไฟล์/โฟลเดอร์</summary>";
        echo "<ul style='margin: 10px 0; padding-left: 20px;'>";
        foreach (array_slice($files, 0, 20) as $file) {
            echo "<li>" . basename($file) . (is_dir($file) ? ' (โฟลเดอร์)' : '') . "</li>";
        }
        echo "</ul>";
        echo "</details>";
    }
}

echo "</div>";

// สร้างรูปภาพตัวอย่าง
echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #059669; margin-top: 0;'>🖼️ สร้างรูปภาพตัวอย่าง</h2>";

if (count($attachments) == 0) {
    echo "<p>ไม่มีรูปภาพใน Media Library ให้ฉันสร้างรูปตัวอย่างให้</p>";
    
    // สร้างรูปภาพตัวอย่างด้วย PHP
    $sample_images = array(
        array('name' => 'slider-sample-1.jpg', 'width' => 1920, 'height' => 800, 'color' => '#3b82f6', 'text' => 'Slider Sample 1'),
        array('name' => 'slider-sample-2.jpg', 'width' => 1920, 'height' => 800, 'color' => '#10b981', 'text' => 'Slider Sample 2'),
        array('name' => 'slider-sample-3.jpg', 'width' => 1920, 'height' => 800, 'color' => '#f59e0b', 'text' => 'Slider Sample 3')
    );
    
    foreach ($sample_images as $img) {
        $image_path = $upload_dir['basedir'] . '/' . $img['name'];
        
        if (!file_exists($image_path)) {
            // สร้างรูปภาพด้วย GD
            if (extension_loaded('gd')) {
                $image = imagecreate($img['width'], $img['height']);
                
                // แปลงสี hex เป็น RGB
                $hex = str_replace('#', '', $img['color']);
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                
                $bg_color = imagecolorallocate($image, $r, $g, $b);
                $text_color = imagecolorallocate($image, 255, 255, 255);
                
                imagefill($image, 0, 0, $bg_color);
                
                // เพิ่มข้อความ
                $font_size = 5;
                $text_width = imagefontwidth($font_size) * strlen($img['text']);
                $text_height = imagefontheight($font_size);
                $x = ($img['width'] - $text_width) / 2;
                $y = ($img['height'] - $text_height) / 2;
                
                imagestring($image, $font_size, $x, $y, $img['text'], $text_color);
                
                // บันทึกรูปภาพ
                imagejpeg($image, $image_path, 90);
                imagedestroy($image);
                
                // เพิ่มเข้า Media Library
                $attachment = array(
                    'guid' => $upload_dir['baseurl'] . '/' . $img['name'],
                    'post_mime_type' => 'image/jpeg',
                    'post_title' => $img['text'],
                    'post_content' => '',
                    'post_status' => 'inherit'
                );
                
                $attach_id = wp_insert_attachment($attachment, $image_path);
                
                if (!is_wp_error($attach_id)) {
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attach_id, $image_path);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                    
                    echo "<p style='color: #10b981;'>✅ สร้าง " . $img['name'] . " เรียบร้อย</p>";
                } else {
                    echo "<p style='color: #ef4444;'>❌ ไม่สามารถเพิ่ม " . $img['name'] . " เข้า Media Library</p>";
                }
            } else {
                echo "<p style='color: #ef4444;'>❌ GD extension ไม่ได้ติดตั้ง ไม่สามารถสร้างรูปภาพได้</p>";
                break;
            }
        } else {
            echo "<p style='color: #6b7280;'>ℹ️ " . $img['name'] . " มีอยู่แล้ว</p>";
        }
    }
} else {
    echo "<p style='color: #6b7280;'>ℹ️ มีรูปภาพใน Media Library แล้ว ไม่ต้องสร้างใหม่</p>";
}

echo "</div>";

// ตรวจสอบ JavaScript errors
echo "<div style='background: #f3e8ff; border: 2px solid #8b5cf6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #6b21a8; margin-top: 0;'>🔧 แก้ไข Media Library Loading</h2>";

echo "<p>หากยังมีปัญหา Media Library หมุนติ้วๆ อาจเป็นเพราะ:</p>";
echo "<ul>";
echo "<li>JavaScript errors ใน browser console</li>";
echo "<li>AJAX requests ถูก block</li>";
echo "<li>WordPress admin-ajax.php ไม่ทำงาน</li>";
echo "<li>Plugin conflicts</li>";
echo "</ul>";

// ทดสอบ AJAX
echo "<h3>ทดสอบ AJAX:</h3>";
$ajax_url = admin_url('admin-ajax.php');
echo "<p><strong>AJAX URL:</strong> " . esc_html($ajax_url) . "</p>";

// ทดสอบการเข้าถึง admin-ajax.php
$response = wp_remote_get($ajax_url . '?action=heartbeat');
if (!is_wp_error($response)) {
    echo "<p style='color: #10b981;'>✅ AJAX endpoint ทำงานได้</p>";
} else {
    echo "<p style='color: #ef4444;'>❌ AJAX endpoint มีปัญหา: " . $response->get_error_message() . "</p>";
}

echo "</div>";

// สรุปและแนะนำ
echo "<div style='text-align: center; margin: 40px 0; padding: 30px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 16px;'>";
echo "<h2 style='color: #0c4a6e; margin-bottom: 20px;'>🎯 แนะนำการแก้ไข</h2>";

if (count($attachments) == 0) {
    echo "<p style='font-size: 18px; color: #0369a1; margin-bottom: 25px;'>สร้างรูปภาพตัวอย่างแล้ว ลองรีเฟรชหน้าและทดสอบอีกครั้ง</p>";
} else {
    echo "<p style='font-size: 18px; color: #0369a1; margin-bottom: 25px;'>มีรูปภาพใน Media Library แล้ว ปัญหาอาจมาจาก JavaScript หรือ AJAX</p>";
}

echo "<div style='display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;'>";
echo "<a href='" . admin_url('upload.php') . "' target='_blank' style='background: #3b82f6; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600;'>📁 ดู Media Library</a>";
echo "<a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' target='_blank' style='background: #10b981; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600;'>🎛️ ทดสอบ Slider Admin</a>";
echo "</div>";

echo "</div>";

echo "<div style='background: #ecfdf5; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3 style='color: #059669; margin-top: 0;'>📋 ขั้นตอนต่อไป</h3>";
echo "<ol>";
echo "<li>รีเฟรชหน้า Slider Admin</li>";
echo "<li>ลองกดปุ่ม \"เลือกรูปจาก Media\" อีกครั้ง</li>";
echo "<li>หากยังหมุนติ้วๆ ให้เปิด Browser Console (F12) ดู errors</li>";
echo "<li>ลองปิด plugins อื่นๆ ชั่วคราวเพื่อทดสอบ</li>";
echo "</ol>";
echo "</div>";
?>