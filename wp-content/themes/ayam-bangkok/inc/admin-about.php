<?php
/**
 * Admin page for About Us content
 */

if (!defined('ABSPATH')) exit;

function ayam_about_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_company_info';

    // Handle form submission
    if (isset($_POST['save_about']) && check_admin_referer('ayam_about_save', 'ayam_about_nonce')) {
        if (isset($_POST['about_data']) && is_array($_POST['about_data'])) {
            foreach ($_POST['about_data'] as $field_key => $field_value) {
                $existing = $wpdb->get_row($wpdb->prepare(
                    "SELECT id FROM $table_name WHERE field_key = %s",
                    $field_key
                ));

                if ($existing) {
                    $wpdb->update(
                        $table_name,
                        array('field_value_th' => sanitize_textarea_field($field_value)),
                        array('field_key' => $field_key),
                        array('%s'),
                        array('%s')
                    );
                } else {
                    $wpdb->insert(
                        $table_name,
                        array(
                            'field_key' => $field_key,
                            'field_value_th' => sanitize_textarea_field($field_value),
                            'category' => 'general',
                            'is_active' => 1
                        ),
                        array('%s', '%s', '%s', '%d')
                    );
                }
            }
            echo '<div class="notice notice-success is-dismissible"><p><strong>✓</strong> บันทึกข้อมูลเรียบร้อยแล้ว</p></div>';
        }
    }

    // Get current data
    $company_description = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'company_description'
    ));

    $about_description = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'about_description'
    ));

    $story_text_1 = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'story_text_1'
    ));

    $story_text_2 = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'story_text_2'
    ));

    $google_map_url = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'google_map_url'
    ));

    $address = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'address'
    ));

    $phone = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'phone'
    ));

    $email = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'email'
    ));
    ?>

    <div class="wrap">
        <h1>จัดการหน้า About Us</h1>
        <p>แก้ไขข้อมูลที่แสดงในหน้า About Us ตามลำดับ section</p>

        <form method="post" action="">
            <?php wp_nonce_field('ayam_about_save', 'ayam_about_nonce'); ?>

            <h2>📌 Hero Section</h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="company_description">คำอธิบายบริษัท (บรรทัดที่ 1)</label>
                    </th>
                    <td>
                        <textarea name="about_data[company_description]" id="company_description" rows="3" class="large-text"><?php echo esc_textarea($company_description); ?></textarea>
                        <p class="description">แสดงในส่วน "About Us" บรรทัดแรก</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="about_description">คำอธิบายเพิ่มเติม (บรรทัดที่ 2)</label>
                    </th>
                    <td>
                        <textarea name="about_data[about_description]" id="about_description" rows="3" class="large-text"><?php echo esc_textarea($about_description); ?></textarea>
                        <p class="description">แสดงในส่วน "About Us" บรรทัดที่สอง</p>
                    </td>
                </tr>
            </table>

            <h2>📖 Our Story Section</h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="story_text_1">Our Story ส่วนที่ 1</label>
                    </th>
                    <td>
                        <textarea name="about_data[story_text_1]" id="story_text_1" rows="5" class="large-text"><?php echo esc_textarea($story_text_1); ?></textarea>
                        <p class="description">เรื่องราวของบริษัท ส่วนแรก</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="story_text_2">Our Story ส่วนที่ 2</label>
                    </th>
                    <td>
                        <textarea name="about_data[story_text_2]" id="story_text_2" rows="5" class="large-text"><?php echo esc_textarea($story_text_2); ?></textarea>
                        <p class="description">เรื่องราวของบริษัท ส่วนที่สอง</p>
                    </td>
                </tr>
            </table>

            <h2>📞 Contact Section</h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="address">ที่อยู่</label>
                    </th>
                    <td>
                        <textarea name="about_data[address]" id="address" rows="3" class="large-text"><?php echo esc_textarea($address); ?></textarea>
                        <p class="description">ที่อยู่ของบริษัท (แสดงในส่วนติดต่อ)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="phone">เบอร์โทรศัพท์</label>
                    </th>
                    <td>
                        <input type="text" name="about_data[phone]" id="phone" value="<?php echo esc_attr($phone); ?>" class="regular-text">
                        <p class="description">เบอร์โทรศัพท์สำหรับติดต่อ</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="email">อีเมล</label>
                    </th>
                    <td>
                        <input type="email" name="about_data[email]" id="email" value="<?php echo esc_attr($email); ?>" class="regular-text">
                        <p class="description">อีเมลสำหรับติดต่อ (ใช้รับข้อความจากฟอร์มด้วย)</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="google_map_url">Google Map URL</label>
                    </th>
                    <td>
                        <input type="url" name="about_data[google_map_url]" id="google_map_url" value="<?php echo esc_attr($google_map_url); ?>" class="large-text">
                        <p class="description">URL ของ Google Maps Embed (สำหรับแผนที่ท้ายหน้า)</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <button type="submit" name="save_about" class="button button-primary button-large">
                    บันทึกข้อมูล
                </button>
            </p>
        </form>

        <hr style="margin: 40px 0;">

        <h2>รูปภาพแกลเลอรี่</h2>
        <p>อัพโหลดรูปภาพไปที่โฟลเดอร์: <code>/wp-content/uploads/about-gallery/</code></p>
        <p>รองรับไฟล์: .jpg, .jpeg, .png</p>

        <?php
        $upload_dir = wp_upload_dir();
        $about_gallery_dir = $upload_dir['basedir'] . '/about-gallery/';

        if (is_dir($about_gallery_dir)) {
            $files = glob($about_gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
            if (!empty($files)) {
                echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-top: 20px;">';
                foreach ($files as $file) {
                    $filename = basename($file);
                    $url = $upload_dir['baseurl'] . '/about-gallery/' . $filename;
                    echo '<div style="border: 1px solid #ddd; padding: 5px;">';
                    echo '<img src="' . esc_url($url) . '" style="width: 100%; height: auto; display: block;">';
                    echo '<small>' . esc_html($filename) . '</small>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>ยังไม่มีรูปภาพในแกลเลอรี่</p>';
            }
        } else {
            echo '<p><em>โฟลเดอร์ about-gallery ยังไม่ถูกสร้าง กรุณาอัพโหลดรูปภาพผ่าน FTP หรือ Media Library</em></p>';
        }
        ?>
    </div>
    <?php
}
