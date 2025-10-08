<?php
/**
 * Test if site is working
 */

// Load WordPress
require_once('wp-config.php');

echo "<h1>✅ WordPress โหลดสำเร็จ!</h1>";
echo "<p>เว็บไซต์ทำงานได้ปกติแล้ว</p>";

echo "<h2>ข้อมูลเว็บไซต์:</h2>";
echo "<ul>";
echo "<li><strong>Site Name:</strong> " . get_bloginfo('name') . "</li>";
echo "<li><strong>Site URL:</strong> " . home_url() . "</li>";
echo "<li><strong>Theme:</strong> " . wp_get_theme()->get('Name') . "</li>";
echo "<li><strong>Theme Version:</strong> " . wp_get_theme()->get('Version') . "</li>";
echo "<li><strong>WordPress Version:</strong> " . get_bloginfo('version') . "</li>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "</ul>";

echo "<h2>ตรวจสอบ Post Types:</h2>";
$post_types = get_post_types(array('public' => true), 'objects');
echo "<ul>";
foreach ($post_types as $post_type) {
    $count = wp_count_posts($post_type->name);
    echo "<li><strong>{$post_type->label}:</strong> {$count->publish} posts</li>";
}
echo "</ul>";

echo "<h2>ลิงก์ที่สำคัญ:</h2>";
echo "<ul>";
echo "<li><a href='" . home_url() . "' target='_blank'>หน้าแรก</a></li>";
echo "<li><a href='" . admin_url() . "' target='_blank'>Admin Dashboard</a></li>";
echo "<li><a href='" . home_url('/about') . "' target='_blank'>About</a></li>";
echo "<li><a href='" . home_url('/news') . "' target='_blank'>News</a></li>";
echo "<li><a href='" . home_url('/gallery') . "' target='_blank'>Gallery</a></li>";
echo "<li><a href='" . home_url('/roosters') . "' target='_blank'>Roosters</a></li>";
echo "</ul>";

echo "<h2>🎉 พร้อมใช้งาน!</h2>";
echo "<p><a href='" . home_url() . "' class='button'>ไปที่หน้าแรก</a></p>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f1;
}
h1, h2 {
    color: #1E2950;
}
ul {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
li {
    margin: 10px 0;
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
</style>
