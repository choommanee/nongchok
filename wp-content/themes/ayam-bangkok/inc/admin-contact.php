<?php
/**
 * Admin page for Contact content
 */

if (!defined('ABSPATH')) exit;

function ayam_contact_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_company_info';

    // Handle form submission
    if (isset($_POST['save_contact']) && check_admin_referer('ayam_contact_save', 'ayam_contact_nonce')) {
        if (isset($_POST['contact_data']) && is_array($_POST['contact_data'])) {
            foreach ($_POST['contact_data'] as $field_key => $field_value) {
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
                            'category' => 'contact',
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

    $line_id = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'line_id'
    ));

    $facebook_url = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'facebook_url'
    ));

    $operating_hours = $wpdb->get_var($wpdb->prepare(
        "SELECT field_value_th FROM $table_name WHERE field_key = %s",
        'operating_hours'
    ));
    ?>

    <div class="wrap">
        <h1>จัดการหน้า Contact</h1>
        <p>แก้ไขข้อมูลการติดต่อที่แสดงในหน้า Contact</p>

        <form method="post" action="">
            <?php wp_nonce_field('ayam_contact_save', 'ayam_contact_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="address">ที่อยู่</label>
                    </th>
                    <td>
                        <textarea name="contact_data[address]" id="address" rows="3" class="large-text"><?php echo esc_textarea($address); ?></textarea>
                        <p class="description">ที่อยู่ของบริษัท</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="phone">เบอร์โทรศัพท์</label>
                    </th>
                    <td>
                        <input type="text" name="contact_data[phone]" id="phone" value="<?php echo esc_attr($phone); ?>" class="regular-text">
                        <p class="description">เบอร์โทรศัพท์สำหรับติดต่อ</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="email">อีเมล</label>
                    </th>
                    <td>
                        <input type="email" name="contact_data[email]" id="email" value="<?php echo esc_attr($email); ?>" class="regular-text">
                        <p class="description">อีเมลสำหรับติดต่อ</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="line_id">LINE ID</label>
                    </th>
                    <td>
                        <input type="text" name="contact_data[line_id]" id="line_id" value="<?php echo esc_attr($line_id); ?>" class="regular-text">
                        <p class="description">LINE ID สำหรับติดต่อ</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="facebook_url">Facebook URL</label>
                    </th>
                    <td>
                        <input type="url" name="contact_data[facebook_url]" id="facebook_url" value="<?php echo esc_attr($facebook_url); ?>" class="large-text">
                        <p class="description">URL ของหน้า Facebook</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="operating_hours">เวลาทำการ</label>
                    </th>
                    <td>
                        <textarea name="contact_data[operating_hours]" id="operating_hours" rows="3" class="large-text"><?php echo esc_textarea($operating_hours); ?></textarea>
                        <p class="description">เวลาทำการของบริษัท</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <button type="submit" name="save_contact" class="button button-primary button-large">
                    บันทึกข้อมูล
                </button>
            </p>
        </form>
    </div>
    <?php
}
