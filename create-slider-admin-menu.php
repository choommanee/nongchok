<?php
/**
 * Create Slider Admin Menu
 * Add admin interface for managing slider
 */

require_once 'wp-config.php';

echo "<h1>🎛️ Creating Slider Admin Menu</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #1e40af; }</style>";

// Admin menu code to add
$admin_menu_code = '
// Slider Admin Menu
add_action(\'admin_menu\', function() {
    add_menu_page(
        \'จัดการ Slider\',
        \'Slider หน้าแรก\', 
        \'manage_options\',
        \'ayam-slider-settings\',
        \'ayam_slider_admin_page\',
        \'dashicons-images-alt2\',
        25
    );
});

function ayam_slider_admin_page() {
    if (isset($_POST[\'save_slider\'])) {
        $slider_data = array();
        if (isset($_POST[\'slides\'])) {
            foreach ($_POST[\'slides\'] as $slide) {
                if (!empty($slide[\'image\']) && !empty($slide[\'title\'])) {
                    $slider_data[] = array(
                        \'slide_image\' => sanitize_url($slide[\'image\']),
                        \'slide_title\' => sanitize_text_field($slide[\'title\']),
                        \'slide_description\' => sanitize_textarea_field($slide[\'description\']),
                        \'slide_button_text\' => sanitize_text_field($slide[\'button_text\']),
                        \'slide_button_url\' => sanitize_url($slide[\'button_url\']),
                        \'slide_text_position\' => sanitize_text_field($slide[\'text_position\'])
                    );
                }
            }
        }
        update_option(\'ayam_slider_images\', $slider_data);
        
        // Save slider settings
        update_option(\'ayam_slider_autoplay\', isset($_POST[\'autoplay\']));
        update_option(\'ayam_slider_autoplay_speed\', intval($_POST[\'autoplay_speed\']));
        update_option(\'ayam_slider_show_navigation\', isset($_POST[\'show_navigation\']));
        update_option(\'ayam_slider_show_pagination\', isset($_POST[\'show_pagination\']));
        update_option(\'ayam_slider_height\', sanitize_text_field($_POST[\'height\']));
        
        echo \'<div class="notice notice-success"><p>บันทึกการตั้งค่า slider เรียบร้อยแล้ว!</p></div>\';
    }
    
    $slides = get_option(\'ayam_slider_images\', array());
    $autoplay = get_option(\'ayam_slider_autoplay\', true);
    $autoplay_speed = get_option(\'ayam_slider_autoplay_speed\', 5000);
    $show_navigation = get_option(\'ayam_slider_show_navigation\', true);
    $show_pagination = get_option(\'ayam_slider_show_pagination\', true);
    $height = get_option(\'ayam_slider_height\', \'600px\');
    ?>
    <div class="wrap">
        <h1>🎛️ จัดการ Slider หน้าแรก</h1>
        
        <div style="background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 8px; padding: 15px; margin: 20px 0;">
            <h3>💡 วิธีใช้งาน</h3>
            <ol>
                <li>อัปโหลดรูปผ่าน <a href="<?php echo admin_url(\'upload.php\'); ?>">Media Library</a> แล้วคัดลอก URL มาใส่</li>
                <li>หรือใส่ URL รูปภาพจากแหล่งอื่น</li>
                <li>ตั้งหัวข้อและคำอธิบายสำหรับแต่ละ slide</li>
                <li>เพิ่มปุ่มและลิงก์ตามต้องการ</li>
                <li>คลิก "บันทึกการตั้งค่า" เมื่อเสร็จ</li>
            </ol>
        </div>
        
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">การตั้งค่าทั่วไป</th>
                    <td>
                        <label><input type="checkbox" name="autoplay" <?php checked($autoplay); ?>> เล่นอัตโนมัติ</label><br><br>
                        <label>ความเร็ว (มิลลิวินาที): <input type="number" name="autoplay_speed" value="<?php echo $autoplay_speed; ?>" min="1000" max="10000" step="500" style="width: 100px;"></label><br><br>
                        <label><input type="checkbox" name="show_navigation" <?php checked($show_navigation); ?>> แสดงปุ่มลูกศร</label><br><br>
                        <label><input type="checkbox" name="show_pagination" <?php checked($show_pagination); ?>> แสดงจุดนำทาง</label><br><br>
                        <label>ความสูง: <input type="text" name="height" value="<?php echo esc_attr($height); ?>" placeholder="600px" style="width: 100px;"></label>
                    </td>
                </tr>
            </table>
            
            <h2>รูปภาพ Slider</h2>
            <div id="slider-images">
                <?php 
                if (empty($slides)) {
                    $slides = array(array(
                        \'slide_image\' => get_template_directory_uri() . \'/assets/images/hero-export-1.jpg\',
                        \'slide_title\' => \'บริการส่งออกไก่ไทยคุณภาพสูง\',
                        \'slide_description\' => \'เชื่อมต่อฟาร์มไทยสู่ตลาดอินโดนีเซีย ด้วยกระบวนการส่งออกที่มีมาตรฐาน\',
                        \'slide_button_text\' => \'เรียนรู้เพิ่มเติม\',
                        \'slide_button_url\' => \'#export-process\',
                        \'slide_text_position\' => \'center\'
                    ));
                }
                foreach ($slides as $i => $slide): ?>
                <div class="slide-item" style="border: 1px solid #ddd; padding: 20px; margin: 15px 0; border-radius: 8px; background: white;">
                    <h3 style="margin-top: 0;">📸 Slide <?php echo $i + 1; ?></h3>
                    <table class="form-table">
                        <tr>
                            <th style="width: 150px;">รูปภาพ URL</th>
                            <td>
                                <input type="url" name="slides[<?php echo $i; ?>][image]" value="<?php echo esc_attr($slide[\'slide_image\'] ?? \'\'); ?>" style="width: 100%;" placeholder="https://example.com/image.jpg">
                                <?php if (!empty($slide[\'slide_image\'])): ?>
                                    <br><img src="<?php echo esc_url($slide[\'slide_image\']); ?>" style="max-width: 200px; height: auto; margin-top: 10px; border-radius: 4px;">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>หัวข้อ</th>
                            <td><input type="text" name="slides[<?php echo $i; ?>][title]" value="<?php echo esc_attr($slide[\'slide_title\'] ?? \'\'); ?>" style="width: 100%;" placeholder="หัวข้อของ slide"></td>
                        </tr>
                        <tr>
                            <th>คำอธิบาย</th>
                            <td><textarea name="slides[<?php echo $i; ?>][description]" rows="3" style="width: 100%;" placeholder="คำอธิบายรายละเอียด"><?php echo esc_textarea($slide[\'slide_description\'] ?? \'\'); ?></textarea></td>
                        </tr>
                        <tr>
                            <th>ข้อความปุ่ม</th>
                            <td><input type="text" name="slides[<?php echo $i; ?>][button_text]" value="<?php echo esc_attr($slide[\'slide_button_text\'] ?? \'\'); ?>" style="width: 100%;" placeholder="เช่น: เรียนรู้เพิ่มเติม"></td>
                        </tr>
                        <tr>
                            <th>ลิงก์ปุ่ม</th>
                            <td><input type="url" name="slides[<?php echo $i; ?>][button_url]" value="<?php echo esc_attr($slide[\'slide_button_url\'] ?? \'\'); ?>" style="width: 100%;" placeholder="https://example.com หรือ #section-id"></td>
                        </tr>
                        <tr>
                            <th>ตำแหน่งข้อความ</th>
                            <td>
                                <select name="slides[<?php echo $i; ?>][text_position]" style="width: 150px;">
                                    <option value="left" <?php selected($slide[\'slide_text_position\'] ?? \'center\', \'left\'); ?>>ซ้าย</option>
                                    <option value="center" <?php selected($slide[\'slide_text_position\'] ?? \'center\', \'center\'); ?>>กลาง</option>
                                    <option value="right" <?php selected($slide[\'slide_text_position\'] ?? \'center\', \'right\'); ?>>ขวา</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <?php if ($i > 0): ?>
                        <button type="button" class="button" onclick="this.parentElement.remove()" style="background: #dc3545; color: white; border-color: #dc3545;">ลบ Slide นี้</button>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            
            <p>
                <button type="button" class="button" onclick="addSlide()" style="background: #28a745; color: white; border-color: #28a745;">➕ เพิ่ม Slide</button>
                <input type="submit" name="save_slider" class="button-primary" value="💾 บันทึกการตั้งค่า" style="margin-left: 10px;">
            </p>
        </form>
        
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin: 20px 0;">
            <h3>📋 ตัวอย่าง URL รูปภาพ</h3>
            <p>คุณสามารถใช้รูปจาก Google Drive หรือ Media Library:</p>
            <ul>
                <li><code><?php echo get_template_directory_uri(); ?>/assets/images/hero-export-1.jpg</code></li>
                <li><code><?php echo get_template_directory_uri(); ?>/assets/images/hero-export-2.jpg</code></li>
                <li><code><?php echo get_template_directory_uri(); ?>/assets/images/hero-export-3.jpg</code></li>
            </ul>
        </div>
        
        <script>
        let slideCount = <?php echo count($slides); ?>;
        function addSlide() {
            const container = document.getElementById(\'slider-images\');
            const slideHtml = `
            <div class="slide-item" style="border: 1px solid #ddd; padding: 20px; margin: 15px 0; border-radius: 8px; background: white;">
                <h3 style="margin-top: 0;">📸 Slide ${slideCount + 1}</h3>
                <table class="form-table">
                    <tr><th style="width: 150px;">รูปภาพ URL</th><td><input type="url" name="slides[${slideCount}][image]" style="width: 100%;" placeholder="https://example.com/image.jpg"></td></tr>
                    <tr><th>หัวข้อ</th><td><input type="text" name="slides[${slideCount}][title]" style="width: 100%;" placeholder="หัวข้อของ slide"></td></tr>
                    <tr><th>คำอธิบาย</th><td><textarea name="slides[${slideCount}][description]" rows="3" style="width: 100%;" placeholder="คำอธิบายรายละเอียด"></textarea></td></tr>
                    <tr><th>ข้อความปุ่ม</th><td><input type="text" name="slides[${slideCount}][button_text]" style="width: 100%;" placeholder="เช่น: เรียนรู้เพิ่มเติม"></td></tr>
                    <tr><th>ลิงก์ปุ่ม</th><td><input type="url" name="slides[${slideCount}][button_url]" style="width: 100%;" placeholder="https://example.com หรือ #section-id"></td></tr>
                    <tr><th>ตำแหน่งข้อความ</th><td>
                        <select name="slides[${slideCount}][text_position]" style="width: 150px;">
                            <option value="left">ซ้าย</option>
                            <option value="center" selected>กลาง</option>
                            <option value="right">ขวา</option>
                        </select>
                    </td></tr>
                </table>
                <button type="button" class="button" onclick="this.parentElement.remove()" style="background: #dc3545; color: white; border-color: #dc3545;">ลบ Slide นี้</button>
            </div>`;
            container.insertAdjacentHTML(\'beforeend\', slideHtml);
            slideCount++;
        }
        </script>
    </div>
    <?php
}';

// เพิ่มโค้ดลงใน functions.php
$functions_path = get_template_directory() . '/functions.php';
$functions_content = file_get_contents($functions_path);

if (strpos($functions_content, 'ayam_slider_admin_page') === false) {
    file_put_contents($functions_path, $functions_content . PHP_EOL . $admin_menu_code);
    echo "<p>✅ เพิ่ม admin menu สำหรับ slider ลงใน functions.php แล้ว</p>";
} else {
    echo "<p>ℹ️ Admin menu สำหรับ slider มีอยู่แล้ว</p>";
}

echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3>🎉 Slider Admin Menu สร้างเสร็จแล้ว!</h3>";
echo "<p>ตอนนี้คุณสามารถแก้ไข slider ได้ที่:</p>";
echo "<ol>";
echo "<li>เข้า WordPress Admin</li>";
echo "<li>ดูที่เมนูซ้าย จะเห็น <strong>\"Slider หน้าแรก\"</strong> (ไอคอนรูปภาพ)</li>";
echo "<li>คลิกเข้าไปเพื่อจัดการ slider</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3>📋 คุณสมบัติ</h3>";
echo "<ul>";
echo "<li>✅ เพิ่ม/ลบ/แก้ไข slide ได้ไม่จำกัด</li>";
echo "<li>✅ อัปโหลดรูปผ่าน Media Library</li>";
echo "<li>✅ ตั้งหัวข้อ คำอธิบาย และปุ่ม</li>";
echo "<li>✅ เลือกตำแหน่งข้อความ</li>";
echo "<li>✅ ตั้งค่าการเล่นอัตโนมัติ</li>";
echo "<li>✅ ปรับความเร็วและความสูง</li>";
echo "<li>✅ เปิด/ปิดปุ่มนำทางและจุด</li>";
echo "<li>✅ ดูตัวอย่างรูปในหน้าแก้ไข</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 20px; background: #e0f2fe; border-radius: 12px;'>";
echo "<h3>🚀 พร้อมใช้งาน!</h3>";
echo "<p>ไปที่ WordPress Admin และหา <strong>\"Slider หน้าแรก\"</strong> ในเมนูซ้าย</p>";
echo "<p><a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' target='_blank' style='background: #3b82f6; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;'>เปิดหน้าจัดการ Slider</a></p>";
echo "</div>";
?>