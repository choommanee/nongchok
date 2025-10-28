<?php
/**
 * Admin Page for Shipment Management
 */

// Add admin menu
add_action('admin_menu', 'ayam_shipment_admin_menu', 100);

function ayam_shipment_admin_menu() {
    global $menu;
    $parent_exists = false;

    if (is_array($menu)) {
        foreach ($menu as $item) {
            if (isset($item[2]) && $item[2] === 'ayam-about-admin') {
                $parent_exists = true;
                break;
            }
        }
    }

    if ($parent_exists) {
        add_submenu_page(
            'ayam-about-admin',
            'จัดการ Shipment',
            'จัดการ Shipment',
            'manage_options',
            'ayam-shipment-management',
            'ayam_shipment_admin_page'
        );
    }
}

function ayam_shipment_admin_page() {
    global $wpdb;
    $shipments_table = $wpdb->prefix . 'ayam_shipments';

    // Create table if not exists
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS {$shipments_table} (
        id int(11) NOT NULL AUTO_INCREMENT,
        shipment_number varchar(50) NOT NULL,
        shipment_name varchar(255) NOT NULL,
        description text,
        is_active tinyint(1) DEFAULT 1,
        sort_order int(11) DEFAULT 0,
        created_at timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY shipment_number (shipment_number)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Handle create shipment
    if (isset($_POST['create_shipment']) && check_admin_referer('create_shipment_action')) {
        $shipment_number = sanitize_text_field($_POST['shipment_number']);
        $shipment_name = sanitize_text_field($_POST['shipment_name']);
        $description = sanitize_textarea_field($_POST['description']);
        $sort_order = intval($_POST['sort_order']);

        $result = $wpdb->insert(
            $shipments_table,
            array(
                'shipment_number' => $shipment_number,
                'shipment_name' => $shipment_name,
                'description' => $description,
                'is_active' => 1,
                'sort_order' => $sort_order
            )
        );

        if ($result) {
            echo '<div class="notice notice-success"><p>✅ Shipment created successfully!</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>❌ Error: ' . $wpdb->last_error . '</p></div>';
        }
    }

    // Handle update shipment
    if (isset($_POST['update_shipment']) && check_admin_referer('update_shipment_action')) {
        $shipment_id = intval($_POST['shipment_id']);
        $shipment_name = sanitize_text_field($_POST['shipment_name']);
        $description = sanitize_textarea_field($_POST['description']);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $sort_order = intval($_POST['sort_order']);

        $wpdb->update(
            $shipments_table,
            array(
                'shipment_name' => $shipment_name,
                'description' => $description,
                'is_active' => $is_active,
                'sort_order' => $sort_order
            ),
            array('id' => $shipment_id)
        );

        echo '<div class="notice notice-success"><p>✅ Shipment updated successfully!</p></div>';
    }

    // Handle delete shipment
    if (isset($_POST['delete_shipment']) && check_admin_referer('delete_shipment_action')) {
        $shipment_id = intval($_POST['shipment_id']);

        // Check if shipment is in use
        $in_use = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}gallery_categories WHERE shipment_date LIKE CONCAT('Shipment ', (SELECT shipment_number FROM {$shipments_table} WHERE id = %d))",
            $shipment_id
        ));

        if ($in_use > 0) {
            echo '<div class="notice notice-error"><p>❌ Cannot delete! This shipment is used by ' . $in_use . ' categories.</p></div>';
        } else {
            $wpdb->delete($shipments_table, array('id' => $shipment_id));
            echo '<div class="notice notice-success"><p>✅ Shipment deleted successfully!</p></div>';
        }
    }

    // Get all shipments
    $shipments = $wpdb->get_results("SELECT * FROM {$shipments_table} ORDER BY sort_order ASC, shipment_number ASC");

    ?>
    <div class="wrap">
        <h1>Shipment Management</h1>
        <p>จัดการหมายเลข Shipment สำหรับระบบ Ayam List</p>

        <button class="button button-primary" id="show-create-form" style="margin: 20px 0;">
            <span class="dashicons dashicons-plus" style="margin-top: 3px;"></span> เพิ่ม Shipment ใหม่
        </button>

        <!-- Create Shipment Form -->
        <div id="create-shipment-form" style="display:none; background: white; padding: 20px; border: 1px solid #ccc; margin-bottom: 20px; border-radius: 4px;">
            <h2>เพิ่ม Shipment ใหม่</h2>
            <form method="post">
                <?php wp_nonce_field('create_shipment_action'); ?>

                <table class="form-table">
                    <tr>
                        <th><label for="shipment_number">Shipment Number * <small>(ตัวเลขเท่านั้น)</small></label></th>
                        <td>
                            <input type="number" name="shipment_number" id="shipment_number"
                                   placeholder="e.g., 6, 7, 8, ..." required
                                   class="regular-text" min="1">
                            <p class="description">ใส่เฉพาะตัวเลข เช่น 6, 7, 8 (ระบบจะเติม "Shipment" ให้อัตโนมัติ)</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="shipment_name">Shipment Name *</label></th>
                        <td>
                            <input type="text" name="shipment_name" id="shipment_name"
                                   placeholder="e.g., Shipment 6 - January 2025" required
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description">Description</label></th>
                        <td>
                            <textarea name="description" id="description" rows="3" class="large-text"
                                      placeholder="รายละเอียดเพิ่มเติมเกี่ยวกับ shipment นี้"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="sort_order">Sort Order</label></th>
                        <td>
                            <input type="number" name="sort_order" id="sort_order"
                                   value="0" class="small-text">
                            <p class="description">ลำดับการแสดง (เลขน้อยแสดงก่อน)</p>
                        </td>
                    </tr>
                </table>

                <p>
                    <button type="submit" name="create_shipment" class="button button-primary">
                        <span class="dashicons dashicons-saved" style="margin-top: 3px;"></span> สร้าง Shipment
                    </button>
                    <button type="button" class="button" id="cancel-create">ยกเลิก</button>
                </p>
            </form>
        </div>

        <!-- Shipments List -->
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th width="10%">Shipment #</th>
                    <th width="25%">Name</th>
                    <th width="30%">Description</th>
                    <th width="10%">Status</th>
                    <th width="10%">Sort Order</th>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($shipments)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                            ยังไม่มี Shipment กรุณาเพิ่ม Shipment ใหม่
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($shipments as $shipment):
                        // Count categories using this shipment
                        $usage_count = $wpdb->get_var($wpdb->prepare(
                            "SELECT COUNT(*) FROM {$wpdb->prefix}gallery_categories WHERE shipment_date = %s",
                            'Shipment ' . $shipment->shipment_number
                        ));
                    ?>
                    <tr>
                        <td><strong><?php echo esc_html($shipment->shipment_number); ?></strong></td>
                        <td><?php echo esc_html($shipment->shipment_name); ?></td>
                        <td><?php echo esc_html($shipment->description ?: '-'); ?></td>
                        <td>
                            <?php if ($shipment->is_active): ?>
                                <span style="color: #46b450;">● Active</span>
                            <?php else: ?>
                                <span style="color: #dc3232;">● Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo esc_html($shipment->sort_order); ?></td>
                        <td>
                            <button class="button button-small edit-shipment"
                                    data-id="<?php echo $shipment->id; ?>"
                                    data-number="<?php echo esc_attr($shipment->shipment_number); ?>"
                                    data-name="<?php echo esc_attr($shipment->shipment_name); ?>"
                                    data-description="<?php echo esc_attr($shipment->description); ?>"
                                    data-active="<?php echo $shipment->is_active; ?>"
                                    data-sort="<?php echo $shipment->sort_order; ?>">
                                <span class="dashicons dashicons-edit" style="margin-top: 3px;"></span> Edit
                            </button>

                            <?php if ($usage_count == 0): ?>
                                <form method="post" style="display: inline;"
                                      onsubmit="return confirm('Delete Shipment <?php echo esc_js($shipment->shipment_number); ?>?')">
                                    <?php wp_nonce_field('delete_shipment_action'); ?>
                                    <input type="hidden" name="shipment_id" value="<?php echo $shipment->id; ?>">
                                    <button type="submit" name="delete_shipment" class="button button-small button-link-delete">
                                        <span class="dashicons dashicons-trash" style="margin-top: 3px;"></span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="description" title="In use by <?php echo $usage_count; ?> categories">
                                    🔒 (<?php echo $usage_count; ?>)
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="edit-shipment-modal" style="display:none;">
        <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 100000;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; width: 600px; max-width: 90%;">
                <h2>Edit Shipment</h2>
                <form method="post">
                    <?php wp_nonce_field('update_shipment_action'); ?>
                    <input type="hidden" name="shipment_id" id="edit-shipment-id">

                    <table class="form-table">
                        <tr>
                            <th><label>Shipment Number:</label></th>
                            <td>
                                <strong id="edit-shipment-display" style="font-size: 1.2em;"></strong>
                                <p class="description">ไม่สามารถแก้ไขหมายเลข Shipment ได้</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-shipment-name">Shipment Name:</label></th>
                            <td>
                                <input type="text" name="shipment_name" id="edit-shipment-name" required
                                       class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-description">Description:</label></th>
                            <td>
                                <textarea name="description" id="edit-description" rows="3" class="large-text"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-sort-order">Sort Order:</label></th>
                            <td>
                                <input type="number" name="sort_order" id="edit-sort-order" class="small-text">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="edit-is-active">Status:</label></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="is_active" id="edit-is-active" value="1">
                                    Active
                                </label>
                            </td>
                        </tr>
                    </table>

                    <p style="margin-top: 20px;">
                        <button type="submit" name="update_shipment" class="button button-primary">
                            <span class="dashicons dashicons-saved" style="margin-top: 3px;"></span> Update
                        </button>
                        <button type="button" class="button close-modal" style="margin-left: 10px;">Cancel</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Toggle create form
        $('#show-create-form').on('click', function() {
            $('#create-shipment-form').slideToggle();
        });

        $('#cancel-create').on('click', function() {
            $('#create-shipment-form').slideUp();
        });

        // Edit shipment
        $('.edit-shipment').on('click', function() {
            var id = $(this).data('id');
            var number = $(this).data('number');
            var name = $(this).data('name');
            var description = $(this).data('description');
            var isActive = $(this).data('active');
            var sortOrder = $(this).data('sort');

            $('#edit-shipment-id').val(id);
            $('#edit-shipment-display').text(number);
            $('#edit-shipment-name').val(name);
            $('#edit-description').val(description);
            $('#edit-sort-order').val(sortOrder);
            $('#edit-is-active').prop('checked', isActive == 1);

            $('#edit-shipment-modal').show();
        });

        $('.close-modal').on('click', function() {
            $('#edit-shipment-modal').hide();
        });
    });
    </script>

    <style>
    .wp-list-table td {
        vertical-align: middle;
    }
    </style>
    <?php
}
