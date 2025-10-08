<?php
/**
 * Fix All Errors
 * แก้ไขปัญหาทั้งหมดที่เกิดขึ้น
 */

require_once('wp-config.php');

if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>🔧 กำลังแก้ไขปัญหา...</h1>";

$theme_dir = get_template_directory();
$assets_dir = $theme_dir . '/assets';

// 1. สร้างรูปภาพ placeholder
echo "<h2>1. สร้างรูปภาพ Placeholder</h2>";

$images_to_create = [
    'about-1.jpg',
    'about-2.jpg',
    'about-3.jpg',
    'service-1.jpg',
    'service-2.jpg',
    'plane-bg.jpg',
    'hero-bg.jpg'
];

foreach ($images_to_create as $image) {
    $image_path = $assets_dir . '/images/' . $image;
    
    if (!file_exists($image_path)) {
        // สร้างรูป placeholder 800x600
        $img = imagecreatetruecolor(800, 600);
        $bg_color = imagecolorallocate($img, 200, 200, 200);
        $text_color = imagecolorallocate($img, 100, 100, 100);
        
        imagefill($img, 0, 0, $bg_color);
        
        $text = strtoupper(str_replace(['.jpg', '-'], [' ', ' '], $image));
        imagestring($img, 5, 300, 290, $text, $text_color);
        
        imagejpeg($img, $image_path, 80);
        imagedestroy($img);
        
        echo "✅ สร้าง $image<br>";
    } else {
        echo "⏭️ มี $image อยู่แล้ว<br>";
    }
}

// 2. ลบ JavaScript ที่ไม่จำเป็น
echo "<h2>2. แก้ไข functions.php</h2>";

$functions_file = $theme_dir . '/functions.php';
$functions_content = file_get_contents($functions_file);

// ลบ enqueue ของไฟล์ที่ไม่มี
$scripts_to_remove = [
    'price-calculator',
    'events-calendar',
    'live-chat'
];

foreach ($scripts_to_remove as $script) {
    $pattern = "/wp_enqueue_script\('ayam-" . $script . "'.*?\);/s";
    $functions_content = preg_replace($pattern, "// Removed: ayam-" . $script, $functions_content);
}

file_put_contents($functions_file, $functions_content);
echo "✅ แก้ไข functions.php แล้ว<br>";

// 3. แก้ไข theme.js
echo "<h2>3. แก้ไข theme.js</h2>";

$theme_js = $assets_dir . '/js/theme.js';
if (file_exists($theme_js)) {
    $js_content = file_get_contents($theme_js);
    
    // เพิ่ม null check
    $js_fix = <<<'JS'

// Fix: Add null checks
document.addEventListener('DOMContentLoaded', function() {
    // Wix Mobile Toggle - with null check
    const wixToggle = document.querySelector('.wix-mobile-toggle');
    const wixNav = document.querySelector('.wix-nav');
    
    if (wixToggle && wixNav) {
        wixToggle.addEventListener('click', function() {
            wixNav.classList.toggle('active');
            wixToggle.classList.toggle('active');
        });
    }
});

JS;
    
    file_put_contents($theme_js, $js_content . "\n" . $js_fix);
    echo "✅ แก้ไข theme.js แล้ว<br>";
}

// 4. Clear cache
echo "<h2>4. Clear Cache</h2>";

// WordPress cache
wp_cache_flush();
echo "✅ Clear WordPress cache<br>";

// Delete transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
echo "✅ Clear transients<br>";

echo "<h2>✅ เสร็จสิ้น!</h2>";
echo "<p><strong>กรุณารีเฟรชหน้าเว็บ (Cmd+Shift+R หรือ Ctrl+Shift+R)</strong></p>";
echo "<p><a href='https://nongchok.local/' target='_blank' class='btn'>ดูหน้าแรก</a></p>";

?>
<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 900px;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f1;
}
h1, h2 {
    color: #2B2B2B;
}
.btn {
    display: inline-block;
    padding: 15px 30px;
    background: #C4504A;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    margin: 10px 5px;
}
</style>
