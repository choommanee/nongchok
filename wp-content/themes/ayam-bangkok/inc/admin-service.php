<?php
/**
 * Admin page for Service content
 */

if (!defined('ABSPATH')) exit;

function ayam_service_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_company_info';

    // Handle form submission
    if (isset($_POST['save_service']) && check_admin_referer('ayam_service_save', 'ayam_service_nonce')) {
        if (isset($_POST['service_data']) && is_array($_POST['service_data'])) {
            foreach ($_POST['service_data'] as $field_key => $field_value) {
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
                            'category' => 'service',
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
    $data_fields = array(
        'service_hero_subtitle', 'service_hero_title',
        'service_1_title', 'service_1_desc',
        'service_2_title', 'service_2_desc',
        'service_3_title', 'service_3_desc',
        'service_image_1', 'service_image_2', 'service_image_3', 'service_image_4',
        'video_1_title', 'video_1_desc', 'video_1_url',
        'video_2_title', 'video_2_desc', 'video_2_url'
    );

    $data = array();
    foreach ($data_fields as $field) {
        $data[$field] = $wpdb->get_var($wpdb->prepare(
            "SELECT field_value_th FROM $table_name WHERE field_key = %s",
            $field
        ));
    }

    wp_enqueue_media();
    ?>

    <div class="wrap">
        <h1>จัดการหน้า Service</h1>
        <p>แก้ไขข้อมูลที่แสดงในหน้า Service</p>

        <form method="post" action="">
            <?php wp_nonce_field('ayam_service_save', 'ayam_service_nonce'); ?>

            <h2>ส่วน Hero</h2>
            <table class="form-table">
                <tr>
                    <th><label for="service_hero_subtitle">Hero Subtitle</label></th>
                    <td>
                        <input type="text" name="service_data[service_hero_subtitle]" id="service_hero_subtitle" value="<?php echo esc_attr($data['service_hero_subtitle']); ?>" class="regular-text">
                        <p class="description">เช่น "Get to Know"</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="service_hero_title">Hero Title</label></th>
                    <td>
                        <input type="text" name="service_data[service_hero_title]" id="service_hero_title" value="<?php echo esc_attr($data['service_hero_title']); ?>" class="regular-text">
                        <p class="description">เช่น "Our Service"</p>
                    </td>
                </tr>
            </table>

            <h2>บริการทั้ง 3 รายการ</h2>
            <table class="form-table">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                <tr>
                    <th colspan="2"><h3>บริการที่ <?php echo $i; ?></h3></th>
                </tr>
                <tr>
                    <th><label for="service_<?php echo $i; ?>_title">ชื่อบริการที่ <?php echo $i; ?></label></th>
                    <td>
                        <input type="text" name="service_data[service_<?php echo $i; ?>_title]" id="service_<?php echo $i; ?>_title" value="<?php echo esc_attr($data["service_{$i}_title"]); ?>" class="large-text">
                    </td>
                </tr>
                <tr>
                    <th><label for="service_<?php echo $i; ?>_desc">คำอธิบายบริการที่ <?php echo $i; ?></label></th>
                    <td>
                        <textarea name="service_data[service_<?php echo $i; ?>_desc]" id="service_<?php echo $i; ?>_desc" rows="4" class="large-text"><?php echo esc_textarea($data["service_{$i}_desc"]); ?></textarea>
                    </td>
                </tr>
                <?php endfor; ?>
            </table>

            <h2>รูปภาพ 4 รูป</h2>
            <table class="form-table">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                <tr>
                    <th><label for="service_image_<?php echo $i; ?>">รูปภาพที่ <?php echo $i; ?></label></th>
                    <td>
                        <input type="text" name="service_data[service_image_<?php echo $i; ?>]" id="service_image_<?php echo $i; ?>" value="<?php echo esc_attr($data["service_image_{$i}"]); ?>" class="large-text">
                        <button type="button" class="button upload-image-btn" data-target="service_image_<?php echo $i; ?>">เลือกรูปภาพ</button>
                        <?php if ($data["service_image_{$i}"]): ?>
                            <br><img src="<?php echo esc_url($data["service_image_{$i}"]); ?>" style="max-width: 200px; margin-top: 10px;">
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endfor; ?>
            </table>

            <h2>วิดีโอ 2 รายการ</h2>
            <table class="form-table">
                <?php for ($i = 1; $i <= 2; $i++): ?>
                <tr>
                    <th colspan="2"><h3>วิดีโอที่ <?php echo $i; ?></h3></th>
                </tr>
                <tr>
                    <th><label for="video_<?php echo $i; ?>_title">ชื่อวิดีโอที่ <?php echo $i; ?></label></th>
                    <td>
                        <input type="text" name="service_data[video_<?php echo $i; ?>_title]" id="video_<?php echo $i; ?>_title" value="<?php echo esc_attr($data["video_{$i}_title"]); ?>" class="large-text">
                    </td>
                </tr>
                <tr>
                    <th><label for="video_<?php echo $i; ?>_desc">คำอธิบายวิดีโอที่ <?php echo $i; ?></label></th>
                    <td>
                        <textarea name="service_data[video_<?php echo $i; ?>_desc]" id="video_<?php echo $i; ?>_desc" rows="3" class="large-text"><?php echo esc_textarea($data["video_{$i}_desc"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="video_<?php echo $i; ?>_url">URL วิดีโอที่ <?php echo $i; ?></label></th>
                    <td>
                        <input type="url" name="service_data[video_<?php echo $i; ?>_url]" id="video_<?php echo $i; ?>_url" value="<?php echo esc_attr($data["video_{$i}_url"]); ?>" class="large-text">
                        <p class="description">URL ของวิดีโอ (YouTube, Vimeo, etc.)</p>
                    </td>
                </tr>
                <?php endfor; ?>
            </table>

            <p class="submit">
                <button type="submit" name="save_service" class="button button-primary button-large">
                    บันทึกข้อมูล
                </button>
            </p>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('.upload-image-btn').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetId = button.data('target');
            var targetInput = $('#' + targetId);

            var frame = wp.media({
                title: 'เลือกรูปภาพ',
                button: { text: 'ใช้รูปภาพนี้' },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                targetInput.val(attachment.url);
                if (targetInput.next('br').length) {
                    targetInput.next('br').next('img').attr('src', attachment.url);
                } else {
                    targetInput.parent().append('<br><img src="' + attachment.url + '" style="max-width: 200px; margin-top: 10px;">');
                }
            });

            frame.open();
        });
    });
    </script>
    <?php
}
