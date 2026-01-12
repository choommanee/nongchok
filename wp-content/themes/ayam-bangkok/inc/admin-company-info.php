<?php
/**
 * Company Info Admin Interface
 *
 * @package Ayam_Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu for Company Info
 */
function ayam_company_info_admin_menu() {
    add_menu_page(
        __('ข้อมูลบริษัท', 'ayam-bangkok'),
        __('ข้อมูลบริษัท', 'ayam-bangkok'),
        'manage_options',
        'ayam-company-info',
        'ayam_company_info_admin_page',
        'dashicons-building',
        25
    );
}
add_action('admin_menu', 'ayam_company_info_admin_menu');

/**
 * Enqueue media uploader scripts
 */
function ayam_company_info_enqueue_scripts($hook) {
    if ($hook !== 'toplevel_page_ayam-company-info') {
        return;
    }
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'ayam_company_info_enqueue_scripts');

/**
 * Display Company Info admin page
 */
function ayam_company_info_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_company_info';

    // Handle form submission
    if (isset($_POST['save_company_info']) && check_admin_referer('ayam_company_info_save', 'ayam_company_info_nonce')) {
        ayam_save_company_info($_POST);
        echo '<div class="notice notice-success is-dismissible"><p><strong>✓</strong> ' . __('บันทึกข้อมูลเรียบร้อยแล้ว', 'ayam-bangkok') . '</p></div>';
    }

    // Get all company info
    $company_info = $wpdb->get_results("SELECT * FROM $table_name ORDER BY category, sort_order ASC");

    // Debug - check if data is loaded
    if (isset($_GET['debug'])) {
        echo '<pre style="background: #f0f0f0; padding: 10px; margin: 10px 0;">';
        echo 'Total records: ' . count($company_info) . "\n";
        foreach ($company_info as $info) {
            echo $info->field_key . ' = ' . substr($info->field_value_th, 0, 50) . "...\n";
        }
        echo '</pre>';
    }

    ?>
    <div class="wrap">
        <h1><?php _e('จัดการข้อมูลบริษัท', 'ayam-bangkok'); ?></h1>
        <p><?php _e('จัดการข้อมูลที่แสดงในหน้า About, Service และ Contact', 'ayam-bangkok'); ?></p>

        <form method="post" action="">
            <?php wp_nonce_field('ayam_company_info_save', 'ayam_company_info_nonce'); ?>

            <!-- General Information Section -->
            <div class="ayam-section">
                <h2><?php _e('ข้อมูลทั่วไป', 'ayam-bangkok'); ?></h2>
                <table class="form-table">
                    <?php
                    $general_fields = array(
                        'company_name' => __('ชื่อบริษัท', 'ayam-bangkok'),
                        'company_description' => __('คำอธิบายบริษัท', 'ayam-bangkok'),
                        'address' => __('ที่อยู่', 'ayam-bangkok'),
                        'phone' => __('เบอร์โทรศัพท์', 'ayam-bangkok'),
                        'email' => __('อีเมล', 'ayam-bangkok'),
                        'google_map_url' => __('Google Map URL', 'ayam-bangkok'),
                    );

                    foreach ($general_fields as $field_key => $field_label) {
                        $value = ayam_get_company_info_value($field_key, $company_info);
                        // Debug: Show what value we got
                        if (isset($_GET['debug']) && !empty($value)) {
                            echo "<!-- Debug: $field_key = $value -->\n";
                        }
                        $type = in_array($field_key, array('company_description', 'address')) ? 'textarea' : 'text';
                        ayam_render_company_info_field($field_key, $field_label, $value, $type);
                    }
                    ?>
                </table>
            </div>

            <!-- About Us Section -->
            <div class="ayam-section">
                <h2><?php _e('หน้า About Us', 'ayam-bangkok'); ?></h2>
                <table class="form-table">
                    <?php
                    $about_fields = array(
                        'about_description' => __('คำอธิบายเพิ่มเติม (บรรทัดที่ 2)', 'ayam-bangkok'),
                        'story_text_1' => __('Our Story ส่วนที่ 1', 'ayam-bangkok'),
                        'story_text_2' => __('Our Story ส่วนที่ 2', 'ayam-bangkok'),
                    );

                    foreach ($about_fields as $field_key => $field_label) {
                        $value = ayam_get_company_info_value($field_key, $company_info);
                        ayam_render_company_info_field($field_key, $field_label, $value, 'textarea');
                    }
                    ?>
                </table>
            </div>

            <!-- Service Section -->
            <div class="ayam-section">
                <h2><?php _e('หน้า Service', 'ayam-bangkok'); ?></h2>

                <!-- Hero Section -->
                <h3><?php _e('Hero Section', 'ayam-bangkok'); ?></h3>
                <table class="form-table">
                    <?php
                    ayam_render_company_info_field('service_hero_subtitle', __('คำบรรยายย่อย', 'ayam-bangkok'), ayam_get_company_info_value('service_hero_subtitle', $company_info));
                    ayam_render_company_info_field('service_hero_title', __('หัวข้อหลัก', 'ayam-bangkok'), ayam_get_company_info_value('service_hero_title', $company_info));
                    ?>
                </table>

                <!-- 3 Services -->
                <?php for ($i = 1; $i <= 3; $i++) : ?>
                <h3><?php echo sprintf(__('บริการที่ %d', 'ayam-bangkok'), $i); ?></h3>
                <table class="form-table">
                    <?php
                    ayam_render_company_info_field("service_{$i}_title", __('หัวข้อ', 'ayam-bangkok'), ayam_get_company_info_value("service_{$i}_title", $company_info));
                    ayam_render_company_info_field("service_{$i}_desc", __('คำอธิบาย', 'ayam-bangkok'), ayam_get_company_info_value("service_{$i}_desc", $company_info), 'textarea');
                    ?>
                </table>
                <?php endfor; ?>

                <!-- 2 Videos -->
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                <h3><?php echo sprintf(__('วิดีโอที่ %d', 'ayam-bangkok'), $i); ?></h3>
                <table class="form-table">
                    <?php
                    ayam_render_company_info_field("video_{$i}_title", __('หัวข้อ', 'ayam-bangkok'), ayam_get_company_info_value("video_{$i}_title", $company_info));
                    ayam_render_company_info_field("video_{$i}_desc", __('คำอธิบาย', 'ayam-bangkok'), ayam_get_company_info_value("video_{$i}_desc", $company_info), 'textarea');
                    ?>
                </table>
                <?php endfor; ?>

                <!-- 4 Service Images -->
                <h3><?php _e('รูปภาพบริการ (4 รูป)', 'ayam-bangkok'); ?></h3>
                <table class="form-table">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <?php ayam_render_image_upload_field("service_image_{$i}", sprintf(__('รูปภาพที่ %d', 'ayam-bangkok'), $i), ayam_get_company_info_value("service_image_{$i}", $company_info)); ?>
                    <?php endfor; ?>
                </table>
            </div>

            <!-- Contact Section -->
            <div class="ayam-section">
                <h2><?php _e('หน้า Contact', 'ayam-bangkok'); ?></h2>
                <table class="form-table">
                    <?php
                    $contact_fields = array(
                        'contact_title' => __('หัวข้อ', 'ayam-bangkok'),
                        'contact_subtitle' => __('คำบรรยาย', 'ayam-bangkok'),
                        'contact_address' => __('ที่อยู่', 'ayam-bangkok'),
                        'contact_phone' => __('เบอร์โทรศัพท์', 'ayam-bangkok'),
                        'contact_email' => __('อีเมล', 'ayam-bangkok'),
                    );

                    foreach ($contact_fields as $field_key => $field_label) {
                        $value = ayam_get_company_info_value($field_key, $company_info);
                        $type = in_array($field_key, array('contact_address', 'contact_subtitle')) ? 'textarea' : 'text';
                        ayam_render_company_info_field($field_key, $field_label, $value, $type);
                    }
                    ?>
                </table>
            </div>

            <p class="submit">
                <button type="submit" name="save_company_info" class="button button-primary button-large">
                    <?php _e('บันทึกข้อมูลทั้งหมด', 'ayam-bangkok'); ?>
                </button>
            </p>
        </form>
    </div>

    <style>
        .wrap {
            max-width: 1200px;
        }
        .ayam-section {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            margin: 20px 0;
            padding: 20px;
        }
        .ayam-section h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #23282d;
        }
        .ayam-section h3 {
            color: #2271b1;
            margin: 25px 0 15px 0;
            padding: 10px;
            background: #f6f7f7;
            border-left: 4px solid #2271b1;
        }
        .form-table {
            margin-top: 0.5em;
        }
        .form-table th {
            padding: 15px 10px;
            font-weight: 400;
            width: 200px;
        }
        .form-table td {
            padding: 15px 10px;
        }
        .form-table textarea {
            width: 100%;
            max-width: 600px;
            min-height: 100px;
        }
        .form-table input[type="text"],
        .form-table input[type="email"],
        .form-table input[type="url"] {
            width: 100%;
            max-width: 400px;
        }
        .ayam-image-preview img {
            max-width: 300px;
            height: auto;
            display: block;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        p.submit {
            position: sticky;
            bottom: 0;
            background: #f0f0f1;
            padding: 20px;
            margin: 20px -20px -20px -20px;
            border-top: 1px solid #ccd0d4;
            text-align: left;
            z-index: 100;
        }
    </style>

    <script>
    jQuery(document).ready(function($) {
        // Smooth scroll to section when clicking on headings
        $('.ayam-section h2').css('cursor', 'pointer').on('click', function() {
            var $section = $(this).parent();
            $section.find('table, h3').slideToggle();
        });

        // Image upload
        var mediaUploader;

        $(document).on('click', '.ayam-upload-image-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetInput = button.data('target');
            var previewDiv = button.data('preview');

            // Reuse media uploader if available
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: 'เลือกรูปภาพ',
                button: {
                    text: 'ใช้รูปนี้'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#' + targetInput).val(attachment.url);
                $('#' + previewDiv).html('<img src="' + attachment.url + '" />');
            });

            mediaUploader.open();
        });

        // Remove image
        $(document).on('click', '.ayam-remove-image-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetInput = button.data('target');
            var previewDiv = button.data('preview');

            $('#' + targetInput).val('');
            $('#' + previewDiv).html('');
        });
    });
    </script>
    <?php
}

/**
 * Get company info value by field key
 */
function ayam_get_company_info_value($field_key, $company_info) {
    foreach ($company_info as $info) {
        if ($info->field_key === $field_key) {
            return $info->field_value_th;
        }
    }
    return '';
}

/**
 * Render company info field
 */
function ayam_render_company_info_field($field_key, $label, $value = '', $type = 'text') {
    ?>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr($field_key); ?>">
                <?php echo esc_html($label); ?>
            </label>
        </th>
        <td>
            <?php if ($type === 'textarea') : ?>
                <textarea
                    name="company_info[<?php echo esc_attr($field_key); ?>]"
                    id="<?php echo esc_attr($field_key); ?>"
                    rows="5"
                    class="large-text"
                ><?php echo esc_textarea($value); ?></textarea>
            <?php else : ?>
                <input
                    type="text"
                    name="company_info[<?php echo esc_attr($field_key); ?>]"
                    id="<?php echo esc_attr($field_key); ?>"
                    value="<?php echo esc_attr($value); ?>"
                    class="regular-text"
                />
            <?php endif; ?>
        </td>
    </tr>
    <?php
}

/**
 * Render image upload field with WordPress Media Library
 */
function ayam_render_image_upload_field($field_key, $label, $value = '') {
    $image_url = $value ?: '';
    ?>
    <tr>
        <th scope="row">
            <label><?php echo esc_html($label); ?></label>
        </th>
        <td>
            <div class="ayam-image-upload-wrapper">
                <input type="hidden"
                       name="company_info[<?php echo esc_attr($field_key); ?>]"
                       id="<?php echo esc_attr($field_key); ?>_url"
                       value="<?php echo esc_attr($image_url); ?>" />

                <button type="button"
                        class="button ayam-upload-image-button"
                        data-target="<?php echo esc_attr($field_key); ?>_url"
                        data-preview="<?php echo esc_attr($field_key); ?>_preview">
                    <?php _e('เลือกรูปภาพ', 'ayam-bangkok'); ?>
                </button>

                <button type="button"
                        class="button ayam-remove-image-button"
                        data-target="<?php echo esc_attr($field_key); ?>_url"
                        data-preview="<?php echo esc_attr($field_key); ?>_preview">
                    <?php _e('ลบรูปภาพ', 'ayam-bangkok'); ?>
                </button>

                <div id="<?php echo esc_attr($field_key); ?>_preview" class="ayam-image-preview">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        </td>
    </tr>
    <?php
}

/**
 * Save company info
 */
function ayam_save_company_info($post_data) {
    if (!isset($post_data['company_info']) || !is_array($post_data['company_info'])) {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_company_info';

    foreach ($post_data['company_info'] as $field_key => $field_value) {
        // Check if record exists
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM $table_name WHERE field_key = %s",
            $field_key
        ));

        if ($existing) {
            // Update existing record
            $wpdb->update(
                $table_name,
                array(
                    'field_value_th' => sanitize_textarea_field($field_value),
                    'updated_at' => current_time('mysql')
                ),
                array('field_key' => $field_key),
                array('%s', '%s'),
                array('%s')
            );
        } else {
            // Insert new record
            $wpdb->insert(
                $table_name,
                array(
                    'field_key' => $field_key,
                    'field_value_th' => sanitize_textarea_field($field_value),
                    'is_active' => 1,
                    'created_at' => current_time('mysql'),
                    'updated_at' => current_time('mysql')
                ),
                array('%s', '%s', '%d', '%s', '%s')
            );
        }
    }
}