<?php
/**
 * Admin Page for Gallery Categories Management
 */

// Add admin menu with priority 99 to load after parent menu
add_action('admin_menu', 'ayam_gallery_categories_admin_menu', 99);

function ayam_gallery_categories_admin_menu() {
    // Check if parent menu exists, if not create standalone menu
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
        // Add as submenu under existing Gallery admin menu
        add_submenu_page(
            'ayam-about-admin',
            'จัดการประเภท Gallery',
            'ประเภท Gallery',
            'manage_options',
            'ayam-gallery-categories',
            'ayam_gallery_categories_admin_page'
        );
    } else {
        // Create standalone menu if parent doesn't exist
        add_menu_page(
            'จัดการ Gallery Categories',
            'Gallery Categories',
            'manage_options',
            'ayam-gallery-categories',
            'ayam_gallery_categories_admin_page',
            'dashicons-images-alt2',
            31
        );
    }
}

function ayam_gallery_categories_admin_page() {
    global $wpdb;
    $categories_table = $wpdb->prefix . 'gallery_categories';
    $shipments_table = $wpdb->prefix . 'ayam_shipments';

    // Get all active shipments
    $shipments = $wpdb->get_results("SELECT * FROM {$shipments_table} WHERE is_active = 1 ORDER BY sort_order ASC, shipment_number ASC");

    // Handle create new category
    if (isset($_POST['create_category']) && check_admin_referer('create_category_action')) {
        $category_number = sanitize_text_field($_POST['category_number']);
        $category_name = sanitize_text_field($_POST['category_name']);
        $category_type = sanitize_text_field($_POST['category_type']);
        $shipment_number = sanitize_text_field($_POST['shipment_number']);

        // Build shipment_date field
        $shipment_date = '';
        if ($category_type === 'ayam_list' && !empty($shipment_number)) {
            $shipment_date = 'Shipment ' . $shipment_number;
        }

        $result = $wpdb->insert(
            $categories_table,
            array(
                'category_number' => $category_number,
                'category_name' => $category_name,
                'category_type' => $category_type,
                'shipment_date' => $shipment_date,
                'image_count' => 0
            )
        );

        if ($result) {
            echo '<div class="notice notice-success"><p>Category created successfully!</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>Error creating category: ' . $wpdb->last_error . '</p></div>';
        }
    }

    // Handle update category
    if (isset($_POST['update_category_type']) && check_admin_referer('update_category_type_action')) {
        $category_id = intval($_POST['category_id']);
        $category_type = sanitize_text_field($_POST['category_type']);
        $shipment_number = sanitize_text_field($_POST['shipment_number']);

        // Build shipment_date field
        $shipment_date = '';
        if ($category_type === 'ayam_list' && !empty($shipment_number)) {
            $shipment_date = 'Shipment ' . $shipment_number;
        }

        $wpdb->update(
            $categories_table,
            array(
                'category_type' => $category_type,
                'shipment_date' => $shipment_date
            ),
            array('id' => $category_id)
        );

        echo '<div class="notice notice-success"><p>Category updated successfully!</p></div>';
    }

    // Get all categories
    $categories = $wpdb->get_results("SELECT * FROM {$categories_table} ORDER BY category_number ASC");
    
    ?>
    <div class="wrap">
        <h1>Gallery Categories Management</h1>

        <button class="button button-primary" id="show-create-form" style="margin-bottom: 20px;">
            <span class="dashicons dashicons-plus" style="margin-top: 3px;"></span> สร้าง Category ใหม่
        </button>

        <!-- Create Category Form -->
        <div id="create-category-form" style="display:none; background: white; padding: 20px; border: 1px solid #ccc; margin-bottom: 20px;">
            <h2>สร้าง Gallery Category ใหม่</h2>
            <form method="post">
                <?php wp_nonce_field('create_category_action'); ?>

                <table class="form-table">
                    <tr>
                        <th><label for="category_number">Category Number *</label></th>
                        <td>
                            <input type="text" name="category_number" id="category_number"
                                   placeholder="e.g., 051, BTS2" required
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="category_name">Category Name *</label></th>
                        <td>
                            <input type="text" name="category_name" id="category_name"
                                   placeholder="e.g., Rooster Category 051" required
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="category_type_new">Category Type *</label></th>
                        <td>
                            <select name="category_type" id="category_type_new" class="regular-text">
                                <option value="gallery">Gallery</option>
                                <option value="ayam_list">Ayam List</option>
                                <option value="behind_scene">Behind the Scene</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="shipment_row">
                        <th><label for="shipment_number">Shipment Number</label></th>
                        <td>
                            <select name="shipment_number" id="shipment_number" class="regular-text">
                                <option value="">-- Select Shipment --</option>
                                <?php foreach ($shipments as $ship): ?>
                                    <option value="<?php echo esc_attr($ship->shipment_number); ?>">
                                        Shipment <?php echo esc_html($ship->shipment_number); ?> - <?php echo esc_html($ship->shipment_name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description">เลือก Shipment สำหรับ Ayam List category</p>
                        </td>
                    </tr>
                </table>

                <p>
                    <button type="submit" name="create_category" class="button button-primary">สร้าง Category</button>
                    <button type="button" class="button" id="cancel-create">ยกเลิก</button>
                </p>
            </form>
        </div>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Category Number</th>
                    <th>Category Name</th>
                    <th>Category Type</th>
                    <th>Shipment Date</th>
                    <th>Image Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo esc_html($category->category_number); ?></td>
                    <td><?php echo esc_html($category->category_name); ?></td>
                    <td>
                        <strong>
                            <?php 
                            $type_labels = array(
                                'gallery' => 'Gallery',
                                'ayam_list' => 'Ayam List',
                                'behind_scene' => 'Behind the Scene'
                            );
                            echo isset($type_labels[$category->category_type]) ? $type_labels[$category->category_type] : 'Gallery';
                            ?>
                        </strong>
                    </td>
                    <td><?php echo esc_html($category->shipment_date ?: '-'); ?></td>
                    <td><?php echo esc_html($category->image_count); ?></td>
                    <td>
                        <button class="button button-small edit-category" 
                                data-id="<?php echo $category->id; ?>"
                                data-number="<?php echo esc_attr($category->category_number); ?>"
                                data-name="<?php echo esc_attr($category->category_name); ?>"
                                data-type="<?php echo esc_attr($category->category_type); ?>"
                                data-shipment="<?php echo esc_attr($category->shipment_date); ?>">
                            Edit
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Edit Modal -->
    <div id="edit-category-modal" style="display:none;">
        <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 100000;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; width: 500px; max-width: 90%;">
                <h2>Edit Category</h2>
                <form method="post">
                    <?php wp_nonce_field('update_category_type_action'); ?>
                    <input type="hidden" name="category_id" id="edit-category-id">
                    
                    <p>
                        <strong>Category:</strong> 
                        <span id="edit-category-display"></span>
                    </p>
                    
                    <p>
                        <label><strong>Category Type:</strong></label><br>
                        <select name="category_type" id="edit-category-type" style="width: 100%; padding: 8px;">
                            <option value="gallery">Gallery</option>
                            <option value="ayam_list">Ayam List</option>
                            <option value="behind_scene">Behind the Scene</option>
                        </select>
                    </p>

                    <p id="edit-shipment-row">
                        <label><strong>Shipment Number:</strong></label><br>
                        <select name="shipment_number" id="edit-shipment-number" style="width: 100%; padding: 8px;">
                            <option value="">-- Select Shipment --</option>
                            <?php foreach ($shipments as $ship): ?>
                                <option value="<?php echo esc_attr($ship->shipment_number); ?>">
                                    Shipment <?php echo esc_html($ship->shipment_number); ?> - <?php echo esc_html($ship->shipment_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small>เลือก Shipment สำหรับ Ayam List category</small>
                    </p>
                    
                    <p>
                        <button type="submit" name="update_category_type" class="button button-primary">Update</button>
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
            $('#create-category-form').slideToggle();
        });

        $('#cancel-create').on('click', function() {
            $('#create-category-form').slideUp();
        });

        // Show/hide shipment field in create form
        $('#category_type_new').on('change', function() {
            if ($(this).val() === 'ayam_list') {
                $('#shipment_row').show();
            } else {
                $('#shipment_row').hide();
                $('#shipment_number').val('');
            }
        }).trigger('change');

        // Edit category
        $('.edit-category').on('click', function() {
            var id = $(this).data('id');
            var number = $(this).data('number');
            var name = $(this).data('name');
            var type = $(this).data('type');
            var shipment = $(this).data('shipment');

            $('#edit-category-id').val(id);
            $('#edit-category-display').text(number + ' - ' + name);
            $('#edit-category-type').val(type || 'gallery');

            // Extract shipment number from "Shipment X" format
            var shipmentNum = '';
            if (shipment && shipment.match(/Shipment (\d+)/)) {
                shipmentNum = shipment.match(/Shipment (\d+)/)[1];
            }
            $('#edit-shipment-number').val(shipmentNum);

            // Show/hide shipment field
            if (type === 'ayam_list') {
                $('#edit-shipment-row').show();
            } else {
                $('#edit-shipment-row').hide();
            }

            $('#edit-category-modal').show();
        });

        // Show/hide shipment field in edit form
        $('#edit-category-type').on('change', function() {
            if ($(this).val() === 'ayam_list') {
                $('#edit-shipment-row').show();
            } else {
                $('#edit-shipment-row').hide();
                $('#edit-shipment-number').val('');
            }
        });

        $('.close-modal').on('click', function() {
            $('#edit-category-modal').hide();
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
