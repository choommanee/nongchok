<?php
/**
 * Enhance Rooster Gallery System
 * เพิ่มฟีเจอร์วิดีโอและหมายเลขไก่ที่ชัดเจน
 */

require_once('wp-load.php');

echo "🐓 กำลังปรับปรุงระบบ Gallery ไก่ชน\n\n";

// 1. เพิ่ม Custom Fields สำหรับวิดีโอและหมายเลขไก่
function add_rooster_video_fields() {
    if (function_exists('acf_add_local_field_group')) {

        acf_add_local_field_group(array(
            'key' => 'group_rooster_media',
            'title' => 'ข้อมูลสื่อไก่ชน (รูปภาพและวิดีโอ)',
            'fields' => array(
                // หมายเลขไก่
                array(
                    'key' => 'field_rooster_number',
                    'label' => 'หมายเลขไก่',
                    'name' => 'rooster_number',
                    'type' => 'text',
                    'instructions' => 'ระบุหมายเลขไก่สำหรับแสดงในGallery',
                    'required' => 1,
                    'placeholder' => 'เช่น: #001, A-123',
                ),

                // แกลเลอรี่รูปภาพ
                array(
                    'key' => 'field_rooster_gallery_images',
                    'label' => 'รูปภาพไก่ (Gallery)',
                    'name' => 'rooster_gallery_images',
                    'type' => 'gallery',
                    'instructions' => 'อัพโหลดรูปภาพไก่หลายๆ รูป',
                    'min' => 1,
                    'max' => 20,
                    'insert' => 'append',
                    'library' => 'all',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                ),

                // วิดีโอหลัก (YouTube/Vimeo)
                array(
                    'key' => 'field_rooster_video_url',
                    'label' => 'ลิงก์วิดีโอหลัก (YouTube/Vimeo)',
                    'name' => 'rooster_video_url',
                    'type' => 'url',
                    'instructions' => 'วางลิงก์วิดีโอจาก YouTube หรือ Vimeo',
                    'placeholder' => 'https://www.youtube.com/watch?v=...',
                ),

                // วิดีโอเพิ่มเติม
                array(
                    'key' => 'field_rooster_additional_videos',
                    'label' => 'วิดีโอเพิ่มเติม',
                    'name' => 'rooster_additional_videos',
                    'type' => 'repeater',
                    'instructions' => 'เพิ่มวิดีโอเพิ่มเติมได้หลายคลิป',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_video_title',
                            'label' => 'ชื่อวิดีโอ',
                            'name' => 'video_title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_video_url',
                            'label' => 'ลิงก์วิดีโอ',
                            'name' => 'video_url',
                            'type' => 'url',
                        ),
                    ),
                    'button_label' => 'เพิ่มวิดีโอ',
                ),

                // ไฮไลท์วิดีโอ
                array(
                    'key' => 'field_rooster_highlight_video',
                    'label' => 'วิดีโอไฮไลท์',
                    'name' => 'rooster_highlight_video',
                    'type' => 'url',
                    'instructions' => 'วิดีโอแสดงความสามารถพิเศษของไก่',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_rooster',
                    ),
                ),
            ),
            'menu_order' => 1,
            'position' => 'normal',
            'style' => 'default',
        ));

        echo "✅ เพิ่ม Custom Fields สำหรับวิดีโอและหมายเลขไก่สำเร็จ\n";
    } else {
        echo "⚠️  ต้องติดตั้ง Advanced Custom Fields (ACF) ก่อน\n";
    }
}

// เรียกใช้ฟังก์ชัน
add_action('acf/init', 'add_rooster_video_fields');

// 2. อัพเดตไก่ชนที่มีอยู่ให้มีหมายเลขอัตโนมัติ
$roosters = get_posts(array(
    'post_type' => 'ayam_rooster',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));

echo "\n📝 กำลังเพิ่มหมายเลขให้กับไก่ชนที่มีอยู่...\n";

$count = 0;
foreach ($roosters as $index => $rooster) {
    $existing_number = get_post_meta($rooster->ID, 'rooster_number', true);

    if (empty($existing_number)) {
        $rooster_number = sprintf('AB%03d', $index + 1);
        update_post_meta($rooster->ID, 'rooster_number', $rooster_number);
        echo "  ✅ {$rooster->post_title} → หมายเลข: {$rooster_number}\n";
        $count++;
    }
}

if ($count > 0) {
    echo "\n📊 เพิ่มหมายเลขให้ไก่ชนสำเร็จ: {$count} ตัว\n";
} else {
    echo "\n✓ ไก่ชนทั้งหมดมีหมายเลขครบถ้วนแล้ว\n";
}

echo "\n🎬 สร้างตัวอย่างไก่ชนพร้อมวิดีโอ...\n";

// สร้างตัวอย่างไก่พร้อมวิดีโอ (ถ้ายังไม่มี)
$sample_rooster = array(
    'post_title' => 'ไก่ชนพันธุ์พรีเมียม AB001',
    'post_content' => 'ไก่ชนสายเลือดดี มีวิดีโอแสดงการต่อสู้และความแข็งแรง พร้อมส่งออกไปอินโดนีเซีย',
    'post_status' => 'publish',
    'post_type' => 'ayam_rooster',
);

$existing = get_page_by_title('ไก่ชนพันธุ์พรีเมียม AB001', OBJECT, 'ayam_rooster');

if (!$existing) {
    $post_id = wp_insert_post($sample_rooster);

    if ($post_id) {
        // เพิ่มข้อมูล meta
        update_post_meta($post_id, 'rooster_number', 'AB001');
        update_post_meta($post_id, 'rooster_price', '25000');
        update_post_meta($post_id, 'rooster_age', '18');
        update_post_meta($post_id, 'rooster_weight', '3.5');
        update_post_meta($post_id, 'rooster_color', 'น้ำตาลแดง');
        update_post_meta($post_id, 'rooster_status', 'available');

        // ตัวอย่างลิงก์วิดีโอ (ใช้วิดีโอตัวอย่าง)
        update_post_meta($post_id, 'rooster_video_url', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');

        echo "✅ สร้างตัวอย่างไก่ชนพร้อมวิดีโอสำเร็จ (ID: {$post_id})\n";
    }
} else {
    echo "ℹ️  มีตัวอย่างไก่ชนอยู่แล้ว\n";
}

echo "\n";
echo "==========================================\n";
echo "✨ สรุปการปรับปรุงระบบ Gallery\n";
echo "==========================================\n";
echo "✅ เพิ่ม Custom Fields สำหรับ:\n";
echo "   - หมายเลขไก่ (Rooster Number)\n";
echo "   - แกลเลอรี่รูปภาพ (Gallery Images)\n";
echo "   - วิดีโอหลัก (Main Video)\n";
echo "   - วิดีโอเพิ่มเติม (Additional Videos)\n";
echo "   - วิดีโอไฮไลท์ (Highlight Video)\n";
echo "\n";
echo "✅ อัพเดตไก่ชนที่มีอยู่ให้มีหมายเลข\n";
echo "✅ สร้างตัวอย่างไก่ชนพร้อมวิดีโอ\n";
echo "==========================================\n";

echo "\n📝 ขั้นตอนต่อไป:\n";
echo "1. เข้า WordPress Admin → ACF\n";
echo "2. ไปที่ ไก่ชน → แก้ไขไก่แต่ละตัว\n";
echo "3. เพิ่มรูปภาพและวิดีโอของไก่แต่ละตัว\n";
echo "4. ระบุหมายเลขไก่ที่ต้องการ\n";
echo "\n🎉 เสร็จสิ้น!\n";
