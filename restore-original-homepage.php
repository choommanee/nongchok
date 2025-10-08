<?php
/**
 * Restore Original Homepage
 * กู้คืนหน้าแรกกลับไปเป็นแบบเดิม
 */

require_once('wp-config.php');

if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>🔄 กำลังกู้คืนหน้าแรก...</h1>";

// Backup current files first
$theme_dir = get_template_directory();
$backup_dir = $theme_dir . '/backup-' . date('Y-m-d-His');

if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

// Backup current files
copy($theme_dir . '/front-page.php', $backup_dir . '/front-page.php');
copy($theme_dir . '/header.php', $backup_dir . '/header.php');
echo "✅ Backup ไฟล์เดิมแล้ว<br>";

// Check if we have git to restore
exec('cd ' . ABSPATH . ' && git status', $output, $return_var);

if ($return_var === 0) {
    echo "<h2>📦 พบ Git Repository</h2>";
    echo "<p>คุณสามารถใช้ git เพื่อ restore ไฟล์:</p>";
    echo "<pre>";
    echo "cd " . ABSPATH . "\n";
    echo "git checkout wp-content/themes/ayam-bangkok/front-page.php\n";
    echo "git checkout wp-content/themes/ayam-bangkok/header.php\n";
    echo "git checkout wp-content/themes/ayam-bangkok/assets/css/wix-exact-style.css\n";
    echo "</pre>";
} else {
    echo "<h2>⚠️ ไม่พบ Git</h2>";
    echo "<p>ให้ใช้ไฟล์ backup แทน</p>";
}

echo "<h2>📋 ขั้นตอนการแก้ไข:</h2>";
echo "<ol>";
echo "<li>ลบไฟล์ <code>wix-exact-style.css</code> ออก</li>";
echo "<li>แก้ไข <code>functions.php</code> ให้ไม่โหลด wix-exact-style.css</li>";
echo "<li>ใช้หน้าแรกแบบเดิม</li>";
echo "</ol>";

// Remove wix-exact-style.css from functions.php
$functions_file = $theme_dir . '/functions.php';
$functions_content = file_get_contents($functions_file);

$functions_content = preg_replace(
    '/\/\/ Wix Exact Style CSS.*?wp_enqueue_style\(\'wix-exact-style\'.*?\);/s',
    '// Wix Style removed',
    $functions_content
);

file_put_contents($functions_file, $functions_content);
echo "✅ แก้ไข functions.php แล้ว<br>";

echo "<h2>✅ เสร็จสิ้น!</h2>";
echo "<p><a href='https://nongchok.local/' target='_blank' class='btn'>ดูหน้าแรก</a></p>";
echo "<p><a href='https://nongchok.local/wp-admin' target='_blank' class='btn'>ไปที่ Admin</a></p>";

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
pre {
    background: #2d2d2d;
    color: #f8f8f2;
    padding: 20px;
    border-radius: 8px;
    overflow-x: auto;
}
code {
    background: #f0f0f1;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: monospace;
}
</style>
