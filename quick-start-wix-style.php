<?php
/**
 * Quick Start - Wix Style Website
 * รันทุกอย่างพร้อมกันเพื่อให้เว็บไซต์เหมือน Wix
 */

// Load WordPress
require_once('wp-config.php');

if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>🚀 Quick Start - สร้างเว็บไซต์แบบ Wix</h1>";
echo "<p>กำลังสร้างและตั้งค่าทุกอย่างให้เหมือนเว็บ Wix...</p>";

// Step 1: Flush Rewrite Rules
echo "<h2>Step 1: Flush Rewrite Rules</h2>";
flush_rewrite_rules();
echo "✅ Flush rewrite rules เสร็จแล้ว<br>";

// Step 2: Create Rooster Catalog Post Type
echo "<h2>Step 2: สร้าง Rooster Catalog</h2>";

$sample_roosters = array(
    array(
        'number' => 'A001',
        'title' => 'ไก่ชนอยัม A001',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1 ปี น้ำหนัก 2.5 กก. พร้อมส่งออก',
        'weight' => '2.5',
        'age' => '1',
        'status' => 'ready'
    ),
    array(
        'number' => 'A002',
        'title' => 'ไก่ชนอยัม A002',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1.5 ปี น้ำหนัก 2.8 กก. พร้อมส่งออก',
        'weight' => '2.8',
        'age' => '1.5',
        'status' => 'ready'
    ),
    array(
        'number' => 'A003',
        'title' => 'ไก่ชนอยัม A003',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 2 ปี น้ำหนัก 3.0 กก. พร้อมส่งออก',
        'weight' => '3.0',
        'age' => '2',
        'status' => 'ready'
    ),
    array(
        'number' => 'B001',
        'title' => 'ไก่ชนอยัม B001',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1 ปี น้ำหนัก 2.6 กก. กำลังเตรียมส่ง',
        'weight' => '2.6',
        'age' => '1',
        'status' => 'pending'
    ),
    array(
        'number' => 'B002',
        'title' => 'ไก่ชนอยัม B002',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1.5 ปี น้ำหนัก 2.9 กก. กำลังเตรียมส่ง',
        'weight' => '2.9',
        'age' => '1.5',
        'status' => 'pending'
    ),
    array(
        'number' => 'C001',
        'title' => 'ไก่ชนอยัม C001',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 2 ปี น้ำหนัก 3.2 กก. ส่งออกแล้ว',
        'weight' => '3.2',
        'age' => '2',
        'status' => 'exported'
    )
);

// ลบไก่เก่าก่อน
$old_roosters = get_posts(array(
    'post_type' => 'rooster_catalog',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

foreach ($old_roosters as $rooster) {
    wp_delete_post($rooster->ID, true);
}

echo "✅ ลบไก่เก่า: " . count($old_roosters) . " ตัว<br>";

// สร้างไก่ใหม่
$created_count = 0;
foreach ($sample_roosters as $rooster) {
    $post_data = array(
        'post_title' => $rooster['title'],
        'post_content' => $rooster['description'],
        'post_status' => 'publish',
        'post_type' => 'rooster_catalog'
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        update_post_meta($post_id, 'rooster_number', $rooster['number']);
        update_post_meta($post_id, 'rooster_weight', $rooster['weight']);
        update_post_meta($post_id, 'rooster_age', $rooster['age']);
        update_post_meta($post_id, 'export_status', $rooster['status']);
        update_post_meta($post_id, 'export_date', date('Y-m-d'));

        $created_count++;
        echo "✅ สร้างไก่: {$rooster['number']}<br>";
    }
}

echo "<p><strong>สร้างไก่ใหม่: {$created_count} ตัว</strong></p>";

// Step 3: Create/Update Gallery Page
echo "<h2>Step 3: สร้างหน้า Gallery</h2>";

$existing_page = get_page_by_path('rooster-gallery');

if ($existing_page) {
    $page_id = $existing_page->ID;
    wp_update_post(array(
        'ID' => $page_id,
        'post_title' => 'Rooster Gallery',
        'post_content' => 'แกลเลอรี่ไก่ชนอยัม กรุงเทพ - คลิกหมายเลขเพื่อดูรายละเอียด'
    ));
    echo "✅ อัพเดทหน้า Gallery (ID: {$page_id})<br>";
} else {
    $gallery_page = array(
        'post_title' => 'Rooster Gallery',
        'post_content' => 'แกลเลอรี่ไก่ชนอยัม กรุงเทพ - คลิกหมายเลขเพื่อดูรายละเอียด',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'rooster-gallery'
    );

    $page_id = wp_insert_post($gallery_page);
    echo "✅ สร้างหน้า Gallery (ID: {$page_id})<br>";
}

update_post_meta($page_id, '_wp_page_template', 'page-rooster-gallery-wix.php');

// Step 4: Update Menu
echo "<h2>Step 4: อัพเดทเมนู</h2>";

$menu_name = 'เมนูหลัก';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
} else {
    $menu_id = $menu_exists->term_id;
}

// เพิ่ม Gallery เข้าเมนู
wp_update_nav_menu_item($menu_id, 0, array(
    'menu-item-title' => 'Gallery',
    'menu-item-object-id' => $page_id,
    'menu-item-object' => 'page',
    'menu-item-type' => 'post_type',
    'menu-item-status' => 'publish'
));

echo "✅ เพิ่ม Gallery เข้าเมนู<br>";

// Step 5: Summary
echo "<h2>✅ สรุปผลการสร้าง</h2>";
echo "<div class='summary'>";
echo "<ul>";
echo "<li>✅ Custom Post Type: rooster_catalog</li>";
echo "<li>✅ ไก่ตัวอย่าง: {$created_count} ตัว</li>";
echo "<li>✅ หน้า Gallery</li>";
echo "<li>✅ เมนู</li>";
echo "</ul>";
echo "</div>";

echo "<h2>🎉 เสร็จสิ้น!</h2>";
echo "<p><strong>เว็บไซต์พร้อมใช้งานแล้ว!</strong></p>";

echo "<div class='actions'>";
echo "<h3>ลิงก์สำคัญ:</h3>";
echo "<p><a href='https://nongchok.local/' class='btn btn-primary' target='_blank'>🏠 หน้าแรก</a></p>";
echo "<p><a href='https://nongchok.local/rooster-gallery/' class='btn btn-primary' target='_blank'>🐓 Gallery (Wix Style)</a></p>";
echo "<p><a href='https://nongchok.local/wp-admin/edit.php?post_type=rooster_catalog' class='btn btn-secondary' target='_blank'>⚙️ จัดการไก่</a></p>";
echo "<p><a href='https://nongchok.local/wp-admin/' class='btn btn-secondary' target='_blank'>📊 Admin Dashboard</a></p>";
echo "</div>";

echo "<h3>📝 ขั้นตอนถัดไป:</h3>";
echo "<ol>";
echo "<li>อัพโหลดรูปภาพไก่จาก pic home</li>";
echo "<li>เพิ่มวิดีโอ</li>";
echo "<li>อัพเดทข่าว 28 รายการ</li>";
echo "<li>เพิ่มระบบสองภาษา (ไทย-อินโดนีเซีย)</li>";
echo "</ol>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f1;
}
h1, h2, h3 {
    color: #1E2950;
}
h1 {
    border-bottom: 3px solid #CA4249;
    padding-bottom: 10px;
}
.summary {
    background: #fff;
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.actions {
    background: #fff;
    padding: 30px;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.btn {
    display: inline-block;
    padding: 15px 30px;
    background: #CA4249;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    margin: 5px;
}
.btn:hover {
    background: #1E2950;
    transform: translateY(-2px);
}
.btn-primary {
    background: #1E2950;
}
.btn-primary:hover {
    background: #CA4249;
}
.btn-secondary {
    background: #666;
}
.btn-secondary:hover {
    background: #1E2950;
}
ul, ol {
    line-height: 1.8;
}
</style>
