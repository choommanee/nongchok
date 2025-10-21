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
        echo '<div class="notice notice-success"><p>' . __('บันทึกข้อมูลเรียบร้อยแล้ว', 'ayam-bangkok') . '</p></div>';
    }

    // Get all company info
    $company_info = $wpdb->get_results("SELECT * FROM $table_name ORDER BY category, sort_order ASC");

    // Group by category
    $grouped_info = array();
    foreach ($company_info as $info) {
        $cat = $info->category ?: 'general';
        if (!isset($grouped_info[$cat])) {
            $grouped_info[$cat] = array();
        }
        $grouped_info[$cat][] = $info;
    }

    ?>
    <div class="wrap">
        <h1><?php _e('จัดการข้อมูลบริษัท', 'ayam-bangkok'); ?></h1>
        <p><?php _e('จัดการข้อมูลที่แสดงในหน้า About, Service และ Contact', 'ayam-bangkok'); ?></p>

        <form method="post" action="">
            <?php wp_nonce_field('ayam_company_info_save', 'ayam_company_info_nonce'); ?>

            <div class="ayam-admin-tabs">
                <nav class="nav-tab-wrapper">
                    <a href="#general" class="nav-tab nav-tab-active"><?php _e('ข้อมูลทั่วไป', 'ayam-bangkok'); ?></a>
                    <a href="#about" class="nav-tab"><?php _e('About Us', 'ayam-bangkok'); ?></a>
                    <a href="#service" class="nav-tab"><?php _e('Service', 'ayam-bangkok'); ?></a>
                    <a href="#contact" class="nav-tab"><?php _e('Contact', 'ayam-bangkok'); ?></a>
                </nav>

                <!-- General Tab -->
                <div id="general" class="tab-content active">
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
                            ayam_render_company_info_field($field_key, $field_label, $value);
                        }
                        ?>
                    </table>
                </div>

                <!-- About Tab -->
                <div id="about" class="tab-content">
                    <h2><?php _e('หน้า About Us', 'ayam-bangkok'); ?></h2>
                    <table class="form-table">
                        <?php
                        $about_fields = array(
                            'about_description' => __('คำอธิบาย', 'ayam-bangkok'),
                            'story_text_1' => __('เรื่องราวส่วนที่ 1', 'ayam-bangkok'),
                            'story_text_2' => __('เรื่องราวส่วนที่ 2', 'ayam-bangkok'),
                        );

                        foreach ($about_fields as $field_key => $field_label) {
                            $value = ayam_get_company_info_value($field_key, $company_info);
                            ayam_render_company_info_field($field_key, $field_label, $value, 'textarea');
                        }
                        ?>
                    </table>
                </div>

                <!-- Service Tab -->
                <div id="service" class="tab-content">
                    <h2><?php _e('หน้า Service', 'ayam-bangkok'); ?></h2>
                    <table class="form-table">
                        <?php
                        // Service Hero
                        echo '<tr><th colspan="2"><h3>' . __('Hero Section', 'ayam-bangkok') . '</h3></th></tr>';
                        ayam_render_company_info_field('service_hero_subtitle', __('คำบรรยายย่อย', 'ayam-bangkok'), ayam_get_company_info_value('service_hero_subtitle', $company_info));
                        ayam_render_company_info_field('service_hero_title', __('หัวข้อหลัก', 'ayam-bangkok'), ayam_get_company_info_value('service_hero_title', $company_info));

                        // 3 Services
                        for ($i = 1; $i <= 3; $i++) {
                            echo '<tr><th colspan="2"><h3>' . sprintf(__('บริการที่ %d', 'ayam-bangkok'), $i) . '</h3></th></tr>';
                            ayam_render_company_info_field("service_{$i}_title", __('หัวข้อ', 'ayam-bangkok'), ayam_get_company_info_value("service_{$i}_title", $company_info));
                            ayam_render_company_info_field("service_{$i}_desc", __('คำอธิบาย', 'ayam-bangkok'), ayam_get_company_info_value("service_{$i}_desc", $company_info), 'textarea');
                        }

                        // 2 Videos
                        for ($i = 1; $i <= 2; $i++) {
                            echo '<tr><th colspan="2"><h3>' . sprintf(__('วิดีโอที่ %d', 'ayam-bangkok'), $i) . '</h3></th></tr>';
                            ayam_render_company_info_field("video_{$i}_title", __('หัวข้อ', 'ayam-bangkok'), ayam_get_company_info_value("video_{$i}_title", $company_info));
                            ayam_render_company_info_field("video_{$i}_desc", __('คำอธิบาย', 'ayam-bangkok'), ayam_get_company_info_value("video_{$i}_desc", $company_info), 'textarea');
                        }

                        // 4 Service Images
                        echo '<tr><th colspan="2"><h3>' . __('รูปภาพบริการ (4 รูป)', 'ayam-bangkok') . '</h3></th></tr>';
                        for ($i = 1; $i <= 4; $i++) {
                            ayam_render_company_info_field("service_image_{$i}", sprintf(__('รูปภาพที่ %d (URL)', 'ayam-bangkok'), $i), ayam_get_company_info_value("service_image_{$i}", $company_info));
                            ayam_render_image_upload_field("service_image_{$i}", sprintf(__('อัพโหลดรูปภาพที่ %d', 'ayam-bangkok'), $i), ayam_get_company_info_value("service_image_{$i}", $company_info));
                        }
                        ?>
                    </table>
                </div>

                <!-- Contact Tab -->
                <div id="contact" class="tab-content">
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
                            $type = in_array($field_key, array('contact_address')) ? 'textarea' : 'text';
                            ayam_render_company_info_field($field_key, $field_label, $value, $type);
                        }
                        ?>
                    </table>
                </div>
            </div>

            <p class="submit">
                <button type="submit" name="save_company_info" class="button button-primary button-large">
                    <?php _e('บันทึกข้อมูล', 'ayam-bangkok'); ?>
                </button>
            </p>
        </form>
    </div>

    <style>
        .ayam-admin-tabs {
            margin-top: 20px;
        }
        .nav-tab-wrapper {
            border-bottom: 1px solid #ccc;
            margin-bottom: 0;
        }
        .tab-content {
            display: none;
            background: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-top: none;
        }
        .tab-content.active {
            display: block;
        }
        .tab-content h2 {
            margin-top: 0;
        }
        .tab-content h3 {
            color: #CA4249;
            margin-bottom: 10px;
        }
        .form-table textarea {
            width: 100%;
            min-height: 100px;
        }
    </style>

    <script>
    jQuery(document).ready(function($) {
        // Tab switching
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');

            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');

            $('.tab-content').removeClass('active');
            $(target).addClass('active');
        });

        // Image upload
        var mediaUploader;

        $('.ayam-upload-image-button').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetInput = button.data('target');
            var previewDiv = button.data('preview');

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
                $('#' + previewDiv).html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; display: block;" />');
            });

            mediaUploader.open();
        });

        // Remove image
        $('.ayam-remove-image-button').on('click', function(e) {
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
                <input type="hidden" name="company_info[<?php echo esc_attr($field_key); ?>]" id="<?php echo esc_attr($field_key); ?>_url" value="<?php echo esc_attr($image_url); ?>" />
                <button type="button" class="button ayam-upload-image-button" data-target="<?php echo esc_attr($field_key); ?>_url" data-preview="<?php echo esc_attr($field_key); ?>_preview">
                    <?php _e('เลือกรูปภาพ', 'ayam-bangkok'); ?>
                </button>
                <button type="button" class="button ayam-remove-image-button" data-target="<?php echo esc_attr($field_key); ?>_url" data-preview="<?php echo esc_attr($field_key); ?>_preview">
                    <?php _e('ลบรูปภาพ', 'ayam-bangkok'); ?>
                </button>
                <div id="<?php echo esc_attr($field_key); ?>_preview" class="ayam-image-preview" style="margin-top: 10px;">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; height: auto; display: block;" />
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

    foreach ($post_data['company_info'] as $field_key => $value) {
        // Check if field exists
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE field_key = %s",
            $field_key
        ));

        $data = array(
            'field_value_th' => sanitize_textarea_field($value),
            'field_value_en' => '', // For future use
            'is_active' => 1,
        );

        if ($existing) {
            // Update existing
            $wpdb->update(
                $table_name,
                $data,
                array('field_key' => $field_key),
                array('%s', '%s', '%d'),
                array('%s')
            );
        } else {
            // Insert new
            $data['field_key'] = $field_key;
            $data['category'] = ayam_get_field_category($field_key);
            $data['sort_order'] = 0;

            $wpdb->insert(
                $table_name,
                $data,
                array('%s', '%s', '%s', '%s', '%d', '%d')
            );
        }
    }
}

/**
 * Get field category from field key
 */
function ayam_get_field_category($field_key) {
    if (strpos($field_key, 'service_') === 0 || strpos($field_key, 'video_') === 0) {
        return 'service';
    } elseif (strpos($field_key, 'about_') === 0 || strpos($field_key, 'story_') === 0) {
        return 'about';
    } elseif (strpos($field_key, 'contact_') === 0) {
        return 'contact';
    }
    return 'general';
}
