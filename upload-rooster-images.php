<?php
/**
 * Upload Rooster Images from pic home folder
 * อัพโหลดรูปภาพไก่จากโฟลเดอร์ pic home ไปยัง WordPress Media Library
 */

require_once('wp-load.php');
require_once('wp-admin/includes/image.php');
require_once('wp-admin/includes/file.php');
require_once('wp-admin/includes/media.php');

echo "📸 กำลังอัพโหลดรูปภาพไก่ชนจาก pic home\n\n";

// โฟลเดอร์ที่มีรูปภาพ
$pic_home_path = __DIR__ . '/pic home';

// ตรวจสอบว่าโฟลเดอร์มีอยู่จริง
if (!is_dir($pic_home_path)) {
    die("❌ ไม่พบโฟลเดอร์ pic home\n");
}

// รับรายการไก่ชนทั้งหมด
$roosters = get_posts(array(
    'post_type' => 'ayam_rooster',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'ID',
    'order' => 'ASC'
));

if (empty($roosters)) {
    die("❌ ไม่พบไก่ชนในระบบ\n");
}

echo "พบไก่ชนทั้งหมด: " . count($roosters) . " ตัว\n\n";

// ฟังก์ชันอัพโหลดรูปภาพ
function upload_image_to_media($file_path, $post_id, $set_as_featured = false) {
    if (!file_exists($file_path)) {
        return false;
    }

    $filename = basename($file_path);
    $upload_file = wp_upload_bits($filename, null, file_get_contents($file_path));

    if (!$upload_file['error']) {
        $wp_filetype = wp_check_filetype($filename, null);

        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attachment_id = wp_insert_attachment($attachment, $upload_file['file'], $post_id);

        if (!is_wp_error($attachment_id)) {
            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            if ($set_as_featured) {
                set_post_thumbnail($post_id, $attachment_id);
            }

            return $attachment_id;
        }
    }

    return false;
}

// อัพโหลดรูปภาพจากแต่ละโฟลเดอร์
$folders = array('1', '2', '3', 'gallery');
$uploaded_count = 0;

foreach ($folders as $folder) {
    $folder_path = $pic_home_path . '/' . $folder;

    if (!is_dir($folder_path)) {
        echo "⏭️  ข้ามโฟลเดอร์: {$folder} (ไม่มีอยู่)\n";
        continue;
    }

    echo "📁 กำลังประมวลผลโฟลเดอร์: {$folder}\n";

    $images = glob($folder_path . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

    if (empty($images)) {
        echo "   ⚠️  ไม่พบรูปภาพในโฟลเดอร์นี้\n\n";
        continue;
    }

    echo "   พบรูปภาพ: " . count($images) . " รูป\n";

    // สุ่มเลือกไก่ชน 2-3 ตัวสำหรับโฟลเดอร์นี้
    $random_roosters = array_rand(array_flip(array_keys($roosters)), min(3, count($roosters)));
    if (!is_array($random_roosters)) {
        $random_roosters = array($random_roosters);
    }

    foreach ($random_roosters as $rooster_index) {
        $rooster = $roosters[$rooster_index];

        // เลือกรูปภาพ 1-3 รูปจากโฟลเดอร์นี้
        $selected_images = array_slice($images, 0, min(3, count($images)));

        echo "   🐓 {$rooster->post_title}\n";

        foreach ($selected_images as $image_index => $image_path) {
            $set_featured = ($image_index === 0 && !has_post_thumbnail($rooster->ID));

            $attachment_id = upload_image_to_media($image_path, $rooster->ID, $set_featured);

            if ($attachment_id) {
                $filename = basename($image_path);
                if ($set_featured) {
                    echo "      ✅ อัพโหลด: {$filename} (รูปหลัก)\n";
                } else {
                    echo "      ✅ อัพโหลด: {$filename}\n";
                }
                $uploaded_count++;
            }
        }

        echo "\n";
    }

    echo "\n";
}

echo "==========================================\n";
echo "📊 สรุปผลการอัพโหลด\n";
echo "==========================================\n";
echo "✅ อัพโหลดรูปภาพสำเร็จ: {$uploaded_count} รูป\n";
echo "🐓 ไก่ชนทั้งหมด: " . count($roosters) . " ตัว\n";
echo "==========================================\n";

echo "\n📝 หมายเหตุ:\n";
echo "- รูปภาพถูกอัพโหลดไปยัง WordPress Media Library\n";
echo "- รูปแรกของแต่ละไก่ถูกตั้งเป็นรูปหลัก (Featured Image)\n";
echo "- สามารถเพิ่มรูปภาพเพิ่มเติมได้ใน WordPress Admin\n";

echo "\n🎉 เสร็จสิ้นการอัพโหลดรูปภาพ!\n";
