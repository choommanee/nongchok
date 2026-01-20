<?php
/**
 * Clear WordPress Cache
 * เรียกไฟล์นี้เพื่อเคลียร์ cache ทั้งหมด
 * URL: https://yourdomain.com/clear-cache.php
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
}

echo '<h1>Clear WordPress Cache</h1>';
echo '<div style="font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px;">';

// 1. Clear WordPress object cache
wp_cache_flush();
echo '<p>✅ WordPress Object Cache cleared</p>';

// 2. Clear transients
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_%'");
echo '<p>✅ Transients cleared</p>';

// 3. Clear rewrite rules
flush_rewrite_rules();
echo '<p>✅ Rewrite rules flushed</p>';

// 4. Clear theme cache
if (function_exists('wp_clean_themes_cache')) {
    wp_clean_themes_cache();
    echo '<p>✅ Theme cache cleared</p>';
}

// 5. Clear plugin cache
if (function_exists('wp_clean_plugins_cache')) {
    wp_clean_plugins_cache();
    echo '<p>✅ Plugin cache cleared</p>';
}

// 6. Clear opcache (if available)
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo '<p>✅ OPcache cleared</p>';
}

echo '<h2>Cache Cleared Successfully!</h2>';
echo '<p><strong>หมายเหตุ:</strong></p>';
echo '<ul>';
echo '<li>กด Ctrl+Shift+R (Windows) หรือ Cmd+Shift+R (Mac) เพื่อ Hard Refresh บน browser</li>';
echo '<li>หรือเปิด Developer Tools (F12) แล้วคลิกขวาที่ปุ่ม Refresh เลือก "Empty Cache and Hard Reload"</li>';
echo '<li>ถ้าใช้ CDN (Cloudflare, etc.) ต้องเคลียร์ cache ที่ CDN ด้วย</li>';
echo '</ul>';

echo '<p><a href="' . home_url() . '" style="display: inline-block; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;">กลับหน้าแรก</a></p>';

echo '</div>';

// Delete this file after use for security
echo '<hr>';
echo '<p style="color: red; text-align: center;"><strong>⚠️ แนะนำ: ลบไฟล์นี้ออกหลังใช้งานเพื่อความปลอดภัย</strong></p>';
