<?php
/**
 * WordPress URL Fix Script
 *
 * วิธีใช้:
 * 1. อัพโหลดไฟล์นี้ไปที่ root ของ WordPress (ระดับเดียวกับ wp-config.php)
 * 2. เรียกใช้ผ่าน browser: https://yourdomain.com/fix-wordpress-url.php
 * 3. ลบไฟล์นี้ทันทีหลังใช้งานเสร็จ
 */

// Load WordPress
require_once('wp-load.php');

// ตรวจสอบสิทธิ์ admin
if (!current_user_can('manage_options')) {
    die('คุณไม่มีสิทธิ์ในการใช้งาน script นี้ กรุณา login เป็น admin ก่อน');
}

// Get current URLs
$current_site_url = get_option('siteurl');
$current_home_url = get_option('home');

// แสดงค่าปัจจุบัน
echo "<h2>WordPress URL Settings</h2>";
echo "<p><strong>Current Site URL:</strong> " . $current_site_url . "</p>";
echo "<p><strong>Current Home URL:</strong> " . $current_home_url . "</p>";

// ถ้ามีการส่งฟอร์ม
if (isset($_POST['update_urls'])) {
    $new_url = rtrim($_POST['new_url'], '/');

    // Update URLs
    update_option('siteurl', $new_url);
    update_option('home', $new_url);

    // Update in database directly for safety
    global $wpdb;
    $wpdb->query("UPDATE {$wpdb->options} SET option_value = '{$new_url}' WHERE option_name = 'siteurl'");
    $wpdb->query("UPDATE {$wpdb->options} SET option_value = '{$new_url}' WHERE option_name = 'home'");

    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 10px; margin: 20px 0;'>";
    echo "✅ URLs อัพเดตเรียบร้อยแล้ว! กำลัง redirect...";
    echo "</div>";

    // Redirect to new admin URL
    echo "<script>setTimeout(function(){ window.location.href = '{$new_url}/wp-admin/'; }, 2000);</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fix WordPress URL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        input[type="url"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #0073aa;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #005a87;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 แก้ไข WordPress URLs</h1>

        <div class="info">
            <strong>URL ที่ควรจะเป็น:</strong><br>
            - Production: https://nongchokayambangkok.com<br>
            - Local: https://nongchok.local
        </div>

        <form method="post">
            <label for="new_url">
                <strong>กรอก URL ใหม่ (ไม่ต้องมี / ท้าย):</strong>
            </label>
            <input type="url"
                   id="new_url"
                   name="new_url"
                   placeholder="https://nongchokayambangkok.com"
                   required>

            <div class="warning">
                ⚠️ <strong>คำเตือน:</strong> การเปลี่ยน URL จะมีผลกับการเข้าถึง admin ทันที
            </div>

            <button type="submit" name="update_urls">อัพเดต URLs</button>
        </form>

        <hr style="margin: 30px 0;">

        <h3>📝 หรือแก้ไขใน wp-config.php</h3>
        <p>เพิ่มบรรทัดนี้ใน wp-config.php (ก่อนบรรทัด "That's all, stop editing!"):</p>
        <pre style="background: #f4f4f4; padding: 10px; border-radius: 5px;">
define('WP_HOME', 'https://nongchokayambangkok.com');
define('WP_SITEURL', 'https://nongchokayambangkok.com');</pre>

        <div class="warning">
            ⚠️ <strong>สำคัญ:</strong> ลบไฟล์นี้ทันทีหลังใช้งานเสร็จ!
        </div>
    </div>
</body>
</html>