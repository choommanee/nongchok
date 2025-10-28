<?php
/**
 * Admin Page for Gallery Categories Management
 */

// Add admin menu
add_action('admin_menu', 'ayam_gallery_categories_admin_menu');

function ayam_gallery_categories_admin_menu() {
    add_menu_page(
        'Gallery Categories',
        'Gallery Categories',
        'manage_options',
        'gallery-categories',
        'ayam_gallery_categories_admin_page',
        'dashicons-images-alt2',
        30
    );
}

function ayam_gallery_categories_admin_page() {
    global $wpdb;
    $categories_table = $wpdb->prefix . 'gallery_categories';
    
    // Handle form submissions
    if (isset($_POST['update_category_type']) && check_admin_referer('update_category_type_action')) {
        $category_id = intval($_POST['category_id']);
        $category_type = sanitize_text_field($_POST['category_type']);
        $shipment_date = sanitize_text_field($_POST['shipment_date']);
        
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
                    
                    <p>
                        <label><strong>Shipment Date/Info:</strong></label><br>
                        <input type="text" name="shipment_date" id="edit-shipment-date" 
                               placeholder="e.g., Shipment 6, Shipment 7" 
                               style="width: 100%; padding: 8px;">
                        <small>For Ayam List categories, enter shipment info (e.g., "Shipment 6")</small>
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
        $('.edit-category').on('click', function() {
            var id = $(this).data('id');
            var number = $(this).data('number');
            var name = $(this).data('name');
            var type = $(this).data('type');
            var shipment = $(this).data('shipment');
            
            $('#edit-category-id').val(id);
            $('#edit-category-display').text(number + ' - ' + name);
            $('#edit-category-type').val(type || 'gallery');
            $('#edit-shipment-date').val(shipment || '');
            
            $('#edit-category-modal').show();
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
