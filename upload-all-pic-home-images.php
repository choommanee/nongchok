<?php
/**
 * Upload All Pic Home Images
 * สคริปต์สำหรับอัปโหลดรูปภาพจากโฟลเดอร์ pic home ทั้งหมด
 */

// Load WordPress
require_once('wp-config.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

// Require WordPress file functions
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

echo "<h1>🖼️ อัปโหลดรูปภาพจาก Pic Home</h1>";
echo "<p>กำลังอัปโหลดรูปภาพจากโฟลเดอร์ pic home...</p>";

// กำหนด path ของโฟลเดอร์ pic home
$pic_home_path = dirname(__FILE__) . '/pic home/';

if (!file_exists($pic_home_path)) {
    echo "<div class='error'>❌ ไม่พบโฟลเดอร์ 'pic home' กรุณาตรวจสอบ path</div>";
    echo "<p>Path ที่ค้นหา: {$pic_home_path}</p>";
    exit;
}

echo "<div class='success'>✅ พบโฟลเดอร์ pic home</div>";

// สถิติการอัปโหลด
$stats = array(
    'slider' => 0,
    'about' => 0,
    'gallery' => 0,
    'roosters' => 0,
    'errors' => 0
);

/**
 * ฟังก์ชันอัปโหลดรูปภาพไปยัง WordPress Media Library
 */
function upload_image_to_media_library($file_path, $title = '', $alt_text = '') {
    // ตรวจสอบว่าไฟล์มีอยู่จริง
    if (!file_exists($file_path)) {
        return false;
    }
    
    // ตรวจสอบว่าเป็นไฟล์รูปภาพ
    $file_type = wp_check_filetype(basename($file_path));
    if (!in_array($file_type['type'], array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'))) {
        return false;
    }
    
    // อัปโหลดไฟล์
    $upload = wp_upload_bits(basename($file_path), null, file_get_contents($file_path));
    
    if ($upload['error']) {
        return false;
    }
    
    // สร้าง attachment
    $attachment = array(
        'post_mime_type' => $file_type['type'],
        'post_title' => $title ? $title : preg_replace('/\.[^.]+$/', '', basename($file_path)),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $upload['file']);
    
    if (!$attach_id) {
        return false;
    }
    
    // สร้าง metadata
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);
    
    // เพิ่ม alt text
    if ($alt_text) {
        update_post_meta($attach_id, '_wp_attachment_image_alt', $alt_text);
    }
    
    return $attach_id;
}

// 1. อัปโหลดรูป Slider จาก pic home/1/
echo "<h2>1️⃣ อัปโหลดรูป Hero Slider</h2>";
$slider_path = $pic_home_path . '1/';

if (file_exists($slider_path)) {
    $slider_files = glob($slider_path . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    
    echo "<p>พบรูปภาพ: " . count($slider_files) . " ไฟล์</p>";
    
    foreach ($slider_files as $index => $file) {
        $filename = basename($file);
        $title = "Ayam Bangkok Slider " . ($index + 1);
        $alt_text = "ไก่ชนอยัม กรุงเทพ - Slider Image " . ($index + 1);
        
        $attach_id = upload_image_to_media_library($file, $title, $alt_text);
        
        if ($attach_id) {
            // เพิ่มรูปเข้า Slider
            $slider_images = get_option('ayam_slider_images', array());
            $slider_images[] = array(
                'image_id' => $attach_id,
                'title' => 'ไก่ชนอยัม กรุงเทพ',
                'subtitle' => 'Thai Fighting Rooster Excellence',
                'button_text' => 'เรียนรู้เพิ่มเติม',
                'button_link' => home_url('/about')
            );
            update_option('ayam_slider_images', $slider_images);
            
            $stats['slider']++;
            echo "✅ อัปโหลด: {$filename}<br>";
        } else {
            $stats['errors']++;
            echo "❌ ไม่สามารถอัปโหลด: {$filename}<br>";
        }
    }
} else {
    echo "<p>⚠️ ไม่พบโฟลเดอร์ pic home/1/</p>";
}

// 2. อัปโหลดรูป About จาก pic home/2/
echo "<h2>2️⃣ อัปโหลดรูป About Section</h2>";
$about_path = $pic_home_path . '2/';

if (file_exists($about_path)) {
    $about_files = glob($about_path . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    
    echo "<p>พบรูปภาพ: " . count($about_files) . " ไฟล์</p>";
    
    foreach ($about_files as $index => $file) {
        $filename = basename($file);
        $title = "Ayam Bangkok About " . ($index + 1);
        $alt_text = "เกี่ยวกับไก่ชนอยัม กรุงเทพ - About Image " . ($index + 1);
        
        $attach_id = upload_image_to_media_library($file, $title, $alt_text);
        
        if ($attach_id) {
            $stats['about']++;
            echo "✅ อัปโหลด: {$filename}<br>";
        } else {
            $stats['errors']++;
            echo "❌ ไม่สามารถอัปโหลด: {$filename}<br>";
        }
    }
} else {
    echo "<p>⚠️ ไม่พบโฟลเดอร์ pic home/2/</p>";
}

// 3. อัปโหลดรูป Gallery จาก pic home/3/
echo "<h2>3️⃣ อัปโหลดรูป Gallery & News</h2>";
$gallery_path = $pic_home_path . '3/';

if (file_exists($gallery_path)) {
    $gallery_files = glob($gallery_path . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    
    echo "<p>พบรูปภาพ: " . count($gallery_files) . " ไฟล์</p>";
    
    foreach ($gallery_files as $index => $file) {
        $filename = basename($file);
        $title = "Ayam Bangkok Gallery " . ($index + 1);
        $alt_text = "แกลเลอรี่ไก่ชนอยัม กรุงเทพ - Gallery Image " . ($index + 1);
        
        $attach_id = upload_image_to_media_library($file, $title, $alt_text);
        
        if ($attach_id) {
            $stats['gallery']++;
            echo "✅ อัปโหลด: {$filename}<br>";
        } else {
            $stats['errors']++;
            echo "❌ ไม่สามารถอัปโหลด: {$filename}<br>";
        }
    }
    
    // ตรวจสอบวิดีโอ
    $video_file = $gallery_path . '4593265_Plane_Airplane_4096x2304.mov';
    if (file_exists($video_file)) {
        echo "<p>📹 พบไฟล์วิดีโอ: 4593265_Plane_Airplane_4096x2304.mov</p>";
        echo "<p>💡 คุณสามารถใช้วิดีโอนี้เป็น background video ได้</p>";
    }
} else {
    echo "<p>⚠️ ไม่พบโฟลเดอร์ pic home/3/</p>";
}

// 4. อัปโหลดรูปไก่ชนจาก pic home/gallery/
echo "<h2>4️⃣ อัปโหลดรูปไก่ชน (Rooster Gallery)</h2>";
$rooster_path = $pic_home_path . 'gallery/';

if (file_exists($rooster_path)) {
    $rooster_files = glob($rooster_path . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
    
    echo "<p>พบรูปภาพ: " . count($rooster_files) . " ไฟล์</p>";
    
    foreach ($rooster_files as $index => $file) {
        $filename = basename($file);
        $title = "Ayam Bangkok Rooster " . ($index + 1);
        $alt_text = "ไก่ชนอยัม กรุงเทพ - Rooster " . ($index + 1);
        
        $attach_id = upload_image_to_media_library($file, $title, $alt_text);
        
        if ($attach_id) {
            // สร้าง Rooster Post
            $rooster_post = array(
                'post_title' => 'ไก่ชนอยัม #' . ($index + 1),
                'post_content' => 'ไก่ชนพันธุ์แท้อยัม กรุงเทพ คุณภาพสูง',
                'post_status' => 'publish',
                'post_type' => 'ayam_rooster'
            );
            
            $rooster_id = wp_insert_post($rooster_post);
            
            if ($rooster_id) {
                // ตั้งเป็น Featured Image
                set_post_thumbnail($rooster_id, $attach_id);
                
                // เพิ่ม metadata
                update_post_meta($rooster_id, 'rooster_age', '1-2 ปี');
                update_post_meta($rooster_id, 'rooster_weight', '2.5-3 กก.');
                update_post_meta($rooster_id, 'rooster_price', '5000-10000');
                
                $stats['roosters']++;
                echo "✅ อัปโหลดและสร้าง Rooster Post: {$filename}<br>";
            } else {
                $stats['errors']++;
                echo "❌ ไม่สามารถสร้าง Rooster Post: {$filename}<br>";
            }
        } else {
            $stats['errors']++;
            echo "❌ ไม่สามารถอัปโหลด: {$filename}<br>";
        }
    }
} else {
    echo "<p>⚠️ ไม่พบโฟลเดอร์ pic home/gallery/</p>";
}

// สรุปผลการอัปโหลด
echo "<h2>✅ สรุปผลการอัปโหลด</h2>";
echo "<div class='summary'>";
echo "<table>";
echo "<tr><th>ประเภท</th><th>จำนวน</th></tr>";
echo "<tr><td>🏠 Hero Slider</td><td>{$stats['slider']} รูป</td></tr>";
echo "<tr><td>📖 About Section</td><td>{$stats['about']} รูป</td></tr>";
echo "<tr><td>🖼️ Gallery & News</td><td>{$stats['gallery']} รูป</td></tr>";
echo "<tr><td>🐓 Rooster Gallery</td><td>{$stats['roosters']} รูป</td></tr>";
echo "<tr><td>❌ Errors</td><td>{$stats['errors']} ไฟล์</td></tr>";
echo "<tr><th>รวมทั้งหมด</th><th>" . ($stats['slider'] + $stats['about'] + $stats['gallery'] + $stats['roosters']) . " รูป</th></tr>";
echo "</table>";
echo "</div>";

echo "<h2>🎉 เสร็จสิ้น!</h2>";
echo "<p><a href='" . admin_url('upload.php') . "' class='button button-primary'>ดู Media Library</a></p>";
echo "<p><a href='" . admin_url('edit.php?post_type=ayam_rooster') . "' class='button'>ดู Rooster Posts</a></p>";
echo "<p><a href='" . home_url() . "' class='button'>ดูหน้าแรก</a></p>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f1;
}
h1, h2 {
    color: #1E2950;
}
.success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 4px;
    margin: 20px 0;
}
.error {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 4px;
    margin: 20px 0;
}
.summary {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
th {
    background: #1E2950;
    color: white;
}
.button {
    display: inline-block;
    padding: 12px 24px;
    background: #CA4249;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    margin: 10px 5px;
}
.button-primary {
    background: #1E2950;
}
</style>
