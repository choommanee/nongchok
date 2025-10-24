<?php
/**
 * About Page Admin Management for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamAboutAdmin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'handle_form_submissions'));
        add_action('admin_init', array($this, 'handle_gallery_actions'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'จัดการหน้า About',
            'จัดการ About',
            'manage_options',
            'ayam-about-admin',
            array($this, 'admin_page'),
            'dashicons-building',
            30
        );
        
        // Sub menus
        add_submenu_page(
            'ayam-about-admin',
            'ข้อมูลบริษัท',
            'ข้อมูลบริษัท',
            'manage_options',
            'ayam-company-info',
            array($this, 'company_info_page')
        );
        
        add_submenu_page(
            'ayam-about-admin',
            'ประวัติความเป็นมา',
            'ประวัติความเป็นมา',
            'manage_options',
            'ayam-timeline',
            array($this, 'timeline_page')
        );
        
        add_submenu_page(
            'ayam-about-admin',
            'รางวัลและใบรับรอง',
            'รางวัลและใบรับรอง',
            'manage_options',
            'ayam-awards',
            array($this, 'awards_page')
        );
        
        add_submenu_page(
            'ayam-about-admin',
            'ทีมงาน',
            'ทีมงาน',
            'manage_options',
            'ayam-team',
            array($this, 'team_page')
        );
        
        add_submenu_page(
            'ayam-about-admin',
            'ค่านิยมองค์กร',
            'ค่านิยมองค์กร',
            'manage_options',
            'ayam-values',
            array($this, 'values_page')
        );

        add_submenu_page(
            'ayam-about-admin',
            'รูปภาพแกลเลอรี่ About',
            'รูปภาพแกลเลอรี่ About',
            'manage_options',
            'ayam-about-gallery',
            array($this, 'gallery_page')
        );

        add_submenu_page(
            'ayam-about-admin',
            'รูปภาพ Service',
            'รูปภาพ Service',
            'manage_options',
            'ayam-service-gallery',
            array($this, 'service_gallery_page')
        );

        add_submenu_page(
            'ayam-about-admin',
            'รูปภาพ Gallery',
            'รูปภาพ Gallery',
            'manage_options',
            'ayam-gallery-images',
            array($this, 'gallery_images_page')
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'ayam-') !== false) {
            // Remove non-existent CSS file that causes MIME type error
            // wp_enqueue_style('ayam-about-admin', AYAM_PLUGIN_URL . 'assets/css/about-admin.css', array(), AYAM_PLUGIN_VERSION);
            
            // Use inline styles instead
            wp_add_inline_style('wp-admin', '
                .ayam-admin-dashboard { margin-top: 20px; }
                .ayam-admin-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
                .ayam-admin-card { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .ayam-admin-card h3 { margin-top: 0; color: #0073aa; }
                .ayam-admin-content { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 20px; }
                .ayam-admin-form, .ayam-admin-list { background: white; border: 1px solid #ddd; border-radius: 8px; padding: 20px; }
                .ayam-lang-fields { display: grid; gap: 15px; }
                .ayam-lang-field label { font-weight: 600; display: block; margin-bottom: 5px; }
                .ayam-status.active { color: #46b450; }
                .ayam-status.inactive { color: #dc3232; }
            ');
            
            wp_enqueue_script('ayam-about-admin', AYAM_PLUGIN_URL . 'assets/js/about-admin.js', array('jquery'), AYAM_PLUGIN_VERSION, true);
            
            wp_localize_script('ayam-about-admin', 'ayam_about_admin', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ayam_about_nonce'),
                'strings' => array(
                    'confirm_delete' => 'คุณแน่ใจหรือไม่ที่จะลบรายการนี้?',
                    'saving' => 'กำลังบันทึก...',
                    'saved' => 'บันทึกเรียบร้อยแล้ว',
                    'error' => 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง'
                )
            ));
        }
    }
    
    /**
     * Handle form submissions
     */
    public function handle_form_submissions() {
        // Handle gallery save separately (uses different nonce)
        if (isset($_POST['action']) && $_POST['action'] === 'save_gallery_category') {
            if (!isset($_POST['ayam_gallery_nonce']) || !wp_verify_nonce($_POST['ayam_gallery_nonce'], 'ayam_gallery_save')) {
                wp_die('Security check failed');
            }
            if (!current_user_can('manage_options')) {
                wp_die('Unauthorized');
            }
            $this->save_gallery_category();
            return;
        }

        if (!isset($_POST['ayam_about_nonce']) || !wp_verify_nonce($_POST['ayam_about_nonce'], 'ayam_about_action')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        $action = isset($_POST['action']) ? sanitize_text_field($_POST['action']) : '';
        
        switch ($action) {
            case 'save_company_info':
                $this->save_company_info();
                break;
            case 'save_timeline':
                $this->save_timeline();
                break;
            case 'save_award':
                $this->save_award();
                break;
            case 'save_team_member':
                $this->save_team_member();
                break;
            case 'save_company_value':
                $this->save_company_value();
                break;
            case 'delete_timeline':
                $this->delete_timeline();
                break;
            case 'delete_award':
                $this->delete_award();
                break;
            case 'delete_team_member':
                $this->delete_team_member();
                break;
            case 'delete_company_value':
                $this->delete_company_value();
                break;
        }
    }
    
    /**
     * Main admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>จัดการหน้า About</h1>
            <div class="ayam-admin-dashboard">
                <div class="ayam-admin-cards">
                    <div class="ayam-admin-card">
                        <h3>ข้อมูลบริษัท</h3>
                        <p>จัดการข้อมูลพื้นฐานของบริษัท วิสัยทัศน์ และพันธกิจ</p>
                        <a href="<?php echo admin_url('admin.php?page=ayam-company-info'); ?>" class="button button-primary">จัดการ</a>
                    </div>
                    
                    <div class="ayam-admin-card">
                        <h3>ประวัติความเป็นมา</h3>
                        <p>จัดการไทม์ไลน์และเหตุการณ์สำคัญของบริษัท</p>
                        <a href="<?php echo admin_url('admin.php?page=ayam-timeline'); ?>" class="button button-primary">จัดการ</a>
                    </div>
                    
                    <div class="ayam-admin-card">
                        <h3>รางวัลและใบรับรอง</h3>
                        <p>จัดการรางวัลและใบรับรองต่างๆ ที่ได้รับ</p>
                        <a href="<?php echo admin_url('admin.php?page=ayam-awards'); ?>" class="button button-primary">จัดการ</a>
                    </div>
                    
                    <div class="ayam-admin-card">
                        <h3>ทีมงาน</h3>
                        <p>จัดการข้อมูลสมาชิกทีมงานและผู้บริหาร</p>
                        <a href="<?php echo admin_url('admin.php?page=ayam-team'); ?>" class="button button-primary">จัดการ</a>
                    </div>
                    
                    <div class="ayam-admin-card">
                        <h3>ค่านิยมองค์กร</h3>
                        <p>จัดการค่านิยมและหลักการทำงานขององค์กร</p>
                        <a href="<?php echo admin_url('admin.php?page=ayam-values'); ?>" class="button button-primary">จัดการ</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Company Info page
     */
    public function company_info_page() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ayam_company_info';
        $company_info = $wpdb->get_results("SELECT * FROM $table_name ORDER BY category, sort_order");
        
        ?>
        <div class="wrap">
            <h1>ข้อมูลบริษัท</h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('ayam_about_action', 'ayam_about_nonce'); ?>
                <input type="hidden" name="action" value="save_company_info">
                
                <table class="form-table">
                    <?php foreach ($company_info as $info): ?>
                    <tr>
                        <th scope="row">
                            <label for="<?php echo esc_attr($info->field_key); ?>_th">
                                <?php echo esc_html($this->get_field_label($info->field_key)); ?>
                            </label>
                        </th>
                        <td>
                            <div class="ayam-lang-fields">
                                <div class="ayam-lang-field">
                                    <label>ภาษาไทย</label>
                                    <?php if ($info->field_type === 'textarea'): ?>
                                        <textarea name="<?php echo esc_attr($info->field_key); ?>_th" 
                                                  id="<?php echo esc_attr($info->field_key); ?>_th" 
                                                  rows="4" 
                                                  class="large-text"><?php echo esc_textarea($info->field_value_th); ?></textarea>
                                    <?php else: ?>
                                        <input type="text" 
                                               name="<?php echo esc_attr($info->field_key); ?>_th" 
                                               id="<?php echo esc_attr($info->field_key); ?>_th" 
                                               value="<?php echo esc_attr($info->field_value_th); ?>" 
                                               class="regular-text">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="ayam-lang-field">
                                    <label>English</label>
                                    <?php if ($info->field_type === 'textarea'): ?>
                                        <textarea name="<?php echo esc_attr($info->field_key); ?>_en" 
                                                  id="<?php echo esc_attr($info->field_key); ?>_en" 
                                                  rows="4" 
                                                  class="large-text"><?php echo esc_textarea($info->field_value_en); ?></textarea>
                                    <?php else: ?>
                                        <input type="text" 
                                               name="<?php echo esc_attr($info->field_key); ?>_en" 
                                               id="<?php echo esc_attr($info->field_key); ?>_en" 
                                               value="<?php echo esc_attr($info->field_value_en); ?>" 
                                               class="regular-text">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                
                <?php submit_button('บันทึกข้อมูล'); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Timeline page
     */
    public function timeline_page() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ayam_company_timeline';
        $timeline_items = $wpdb->get_results("SELECT * FROM $table_name ORDER BY sort_order, year");
        
        $edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
        $edit_item = null;
        
        if ($edit_id) {
            $edit_item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $edit_id));
        }
        
        ?>
        <div class="wrap">
            <h1>ประวัติความเป็นมา</h1>
            
            <div class="ayam-admin-content">
                <div class="ayam-admin-form">
                    <h2><?php echo $edit_item ? 'แก้ไขเหตุการณ์' : 'เพิ่มเหตุการณ์ใหม่'; ?></h2>
                    
                    <form method="post" action="">
                        <?php wp_nonce_field('ayam_about_action', 'ayam_about_nonce'); ?>
                        <input type="hidden" name="action" value="save_timeline">
                        <?php if ($edit_item): ?>
                            <input type="hidden" name="timeline_id" value="<?php echo $edit_item->id; ?>">
                        <?php endif; ?>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="year">ปี</label></th>
                                <td>
                                    <input type="text" name="year" id="year" 
                                           value="<?php echo $edit_item ? esc_attr($edit_item->year) : ''; ?>" 
                                           class="regular-text" required>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="title_th">หัวข้อ (ไทย)</label></th>
                                <td>
                                    <input type="text" name="title_th" id="title_th" 
                                           value="<?php echo $edit_item ? esc_attr($edit_item->title_th) : ''; ?>" 
                                           class="regular-text" required>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="title_en">หัวข้อ (English)</label></th>
                                <td>
                                    <input type="text" name="title_en" id="title_en" 
                                           value="<?php echo $edit_item ? esc_attr($edit_item->title_en) : ''; ?>" 
                                           class="regular-text">
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="description_th">รายละเอียด (ไทย)</label></th>
                                <td>
                                    <textarea name="description_th" id="description_th" 
                                              rows="4" class="large-text" required><?php echo $edit_item ? esc_textarea($edit_item->description_th) : ''; ?></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="description_en">รายละเอียด (English)</label></th>
                                <td>
                                    <textarea name="description_en" id="description_en" 
                                              rows="4" class="large-text"><?php echo $edit_item ? esc_textarea($edit_item->description_en) : ''; ?></textarea>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="icon">ไอคอน (Font Awesome)</label></th>
                                <td>
                                    <input type="text" name="icon" id="icon" 
                                           value="<?php echo $edit_item ? esc_attr($edit_item->icon) : ''; ?>" 
                                           class="regular-text" placeholder="เช่น fas fa-seedling">
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="sort_order">ลำดับการแสดง</label></th>
                                <td>
                                    <input type="number" name="sort_order" id="sort_order" 
                                           value="<?php echo $edit_item ? esc_attr($edit_item->sort_order) : '0'; ?>" 
                                           class="small-text">
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row"><label for="is_active">สถานะ</label></th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                                               <?php echo (!$edit_item || $edit_item->is_active) ? 'checked' : ''; ?>>
                                        เปิดใช้งาน
                                    </label>
                                </td>
                            </tr>
                        </table>
                        
                        <?php submit_button($edit_item ? 'อัปเดต' : 'เพิ่มเหตุการณ์'); ?>
                        
                        <?php if ($edit_item): ?>
                            <a href="<?php echo admin_url('admin.php?page=ayam-timeline'); ?>" class="button">ยกเลิก</a>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="ayam-admin-list">
                    <h2>รายการเหตุการณ์</h2>
                    
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>ปี</th>
                                <th>หัวข้อ</th>
                                <th>สถานะ</th>
                                <th>ลำดับ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($timeline_items as $item): ?>
                            <tr>
                                <td><?php echo esc_html($item->year); ?></td>
                                <td><?php echo esc_html($item->title_th); ?></td>
                                <td>
                                    <span class="ayam-status <?php echo $item->is_active ? 'active' : 'inactive'; ?>">
                                        <?php echo $item->is_active ? 'เปิดใช้งาน' : 'ปิดใช้งาน'; ?>
                                    </span>
                                </td>
                                <td><?php echo esc_html($item->sort_order); ?></td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=ayam-timeline&edit=' . $item->id); ?>" 
                                       class="button button-small">แก้ไข</a>
                                    
                                    <form method="post" style="display: inline;" 
                                          onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบรายการนี้?')">
                                        <?php wp_nonce_field('ayam_about_action', 'ayam_about_nonce'); ?>
                                        <input type="hidden" name="action" value="delete_timeline">
                                        <input type="hidden" name="timeline_id" value="<?php echo $item->id; ?>">
                                        <button type="submit" class="button button-small button-link-delete">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Awards page
     */
    public function awards_page() {
        echo '<div class="wrap"><h1>รางวัลและใบรับรอง</h1><p>หน้านี้อยู่ระหว่างการพัฒนา</p></div>';
    }
    
    /**
     * Team page
     */
    public function team_page() {
        echo '<div class="wrap"><h1>ทีมงาน</h1><p>หน้านี้อยู่ระหว่างการพัฒนา</p></div>';
    }
    
    /**
     * Values page
     */
    public function values_page() {
        echo '<div class="wrap"><h1>ค่านิยมองค์กร</h1><p>หน้านี้อยู่ระหว่างการพัฒนา</p></div>';
    }

    /**
     * Gallery page - Manage About page gallery images
     */
    public function gallery_page() {
        $upload_dir = wp_upload_dir();
        $about_gallery_dir = $upload_dir['basedir'] . '/about-gallery/';
        $about_gallery_url = $upload_dir['baseurl'] . '/about-gallery/';

        // Create directory if it doesn't exist
        if (!file_exists($about_gallery_dir)) {
            wp_mkdir_p($about_gallery_dir);
        }

        // Handle file upload
        if (isset($_POST['upload_gallery_images']) && !empty($_FILES['gallery_images']['name'][0])) {
            if (wp_verify_nonce($_POST['gallery_upload_nonce'], 'gallery_upload_action')) {
                $files = $_FILES['gallery_images'];
                $uploaded_count = 0;

                foreach ($files['name'] as $key => $value) {
                    if ($files['name'][$key]) {
                        $file = array(
                            'name'     => $files['name'][$key],
                            'type'     => $files['type'][$key],
                            'tmp_name' => $files['tmp_name'][$key],
                            'error'    => $files['error'][$key],
                            'size'     => $files['size'][$key]
                        );

                        // Check file type
                        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png');
                        if (in_array($file['type'], $allowed_types)) {
                            $filename = sanitize_file_name($file['name']);
                            $target_file = $about_gallery_dir . $filename;

                            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                                $uploaded_count++;
                            }
                        }
                    }
                }

                if ($uploaded_count > 0) {
                    echo '<div class="notice notice-success"><p>อัปโหลดรูปภาพสำเร็จ ' . $uploaded_count . ' ไฟล์</p></div>';
                }
            }
        }

        // Handle delete
        if (isset($_POST['delete_image'])) {
            if (wp_verify_nonce($_POST['gallery_delete_nonce'], 'gallery_delete_action')) {
                $image_name = sanitize_file_name($_POST['image_name']);
                $image_path = $about_gallery_dir . $image_name;

                if (file_exists($image_path) && unlink($image_path)) {
                    echo '<div class="notice notice-success"><p>ลบรูปภาพเรียบร้อยแล้ว</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>ไม่สามารถลบรูปภาพได้</p></div>';
                }
            }
        }

        // Get all gallery images
        $gallery_images = array();
        if (is_dir($about_gallery_dir)) {
            $files = glob($about_gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
            foreach ($files as $file) {
                $gallery_images[] = basename($file);
            }
        }

        ?>
        <div class="wrap">
            <h1>จัดการรูปภาพแกลเลอรี่ About Page</h1>
            <p>อัปโหลดรูปภาพที่จะแสดงในแกลเลอรี่หน้า About Us (ไฟล์ .jpg, .jpeg, .png เท่านั้น)</p>

            <div class="ayam-admin-content" style="grid-template-columns: 1fr;">
                <!-- Upload Form -->
                <div class="ayam-admin-form" style="margin-bottom: 30px;">
                    <h2>อัปโหลดรูปภาพใหม่</h2>

                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field('gallery_upload_action', 'gallery_upload_nonce'); ?>

                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="gallery_images">เลือกรูปภาพ</label></th>
                                <td>
                                    <input type="file" name="gallery_images[]" id="gallery_images" multiple accept="image/jpeg,image/jpg,image/png">
                                    <p class="description">สามารถเลือกหลายไฟล์พร้อมกันได้</p>
                                </td>
                            </tr>
                        </table>

                        <p class="submit">
                            <button type="submit" name="upload_gallery_images" class="button button-primary">อัปโหลดรูปภาพ</button>
                        </p>
                    </form>
                </div>

                <!-- Gallery Images List -->
                <div class="ayam-admin-list">
                    <h2>รูปภาพในแกลเลอรี่ (<?php echo count($gallery_images); ?> รูป)</h2>

                    <?php if (!empty($gallery_images)): ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                            <?php foreach ($gallery_images as $image): ?>
                                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 10px; background: white;">
                                    <img src="<?php echo esc_url($about_gallery_url . $image); ?>"
                                         alt="<?php echo esc_attr($image); ?>"
                                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">

                                    <div style="font-size: 12px; margin-bottom: 10px; word-break: break-all;">
                                        <?php echo esc_html($image); ?>
                                    </div>

                                    <form method="post" style="margin: 0;" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบรูปภาพนี้?')">
                                        <?php wp_nonce_field('gallery_delete_action', 'gallery_delete_nonce'); ?>
                                        <input type="hidden" name="image_name" value="<?php echo esc_attr($image); ?>">
                                        <button type="submit" name="delete_image" class="button button-small button-link-delete" style="width: 100%;">ลบ</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="padding: 40px; text-align: center; background: #f9f9f9; border-radius: 8px; margin-top: 20px;">
                            ยังไม่มีรูปภาพในแกลเลอรี่ กรุณาอัปโหลดรูปภาพ
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
                <h3>คำแนะนำ</h3>
                <ul>
                    <li>แนะนำขนาดรูปภาพ: 1200 x 800 พิกเซลขึ้นไป</li>
                    <li>ไฟล์ที่รองรับ: JPG, JPEG, PNG</li>
                    <li>รูปภาพจะแสดงในหน้า About Us แบบ Grid 4 คอลัมน์</li>
                    <li>3 รูปแรกจะแสดงในส่วน Hero Section</li>
                    <li>รูปภาพทั้งหมดจะแสดงในส่วน Gallery</li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Service Gallery page - Manage Service page images
     */
    public function service_gallery_page() {
        $upload_dir = wp_upload_dir();
        $service_gallery_dir = $upload_dir['basedir'] . '/service-gallery/';
        $service_gallery_url = $upload_dir['baseurl'] . '/service-gallery/';

        if (!file_exists($service_gallery_dir)) {
            wp_mkdir_p($service_gallery_dir);
        }

        // Handle file upload
        if (isset($_POST['upload_service_images']) && !empty($_FILES['service_images']['name'][0])) {
            if (wp_verify_nonce($_POST['service_upload_nonce'], 'service_upload_action')) {
                $this->handle_image_upload($_FILES['service_images'], $service_gallery_dir, 'Service');
            }
        }

        // Handle delete
        if (isset($_POST['delete_image'])) {
            if (wp_verify_nonce($_POST['service_delete_nonce'], 'service_delete_action')) {
                $this->handle_image_delete($_POST['image_name'], $service_gallery_dir);
            }
        }

        $images = $this->get_gallery_images($service_gallery_dir);

        $this->render_gallery_page(
            'Service',
            'service',
            $images,
            $service_gallery_url,
            'รูปภาพจะแสดงในหน้า Service แบบกริด 3 คอลัมน์'
        );
    }

    /**
     * Gallery Images page - Manage Gallery page images
     */
    public function gallery_images_page() {
        global $wpdb;

        // Check if we're editing or adding
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'list';
        $category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($action === 'edit' && $category_id > 0) {
            $this->gallery_edit_page($category_id);
            return;
        } elseif ($action === 'add') {
            $this->gallery_add_page();
            return;
        }

        // List view
        $categories_table = $wpdb->prefix . 'gallery_categories';
        $images_table = $wpdb->prefix . 'gallery_images';

        $categories = $wpdb->get_results("
            SELECT c.*, COUNT(i.id) as total_images
            FROM {$categories_table} c
            LEFT JOIN {$images_table} i ON c.id = i.category_id
            GROUP BY c.id
            ORDER BY c.category_number ASC
        ");

        ?>
        <div class="wrap">
            <h1>
                จัดการ Gallery Categories
                <a href="<?php echo add_query_arg(array('page' => 'ayam-gallery-images', 'action' => 'add'), admin_url('admin.php')); ?>"
                   class="page-title-action">
                    <span class="dashicons dashicons-plus-alt"></span> เพิ่ม Category ใหม่
                </a>
            </h1>

            <?php if (isset($_GET['deleted']) && $_GET['deleted'] == '1'): ?>
                <div class="notice notice-success is-dismissible">
                    <p>✅ ลบ Category #<?php echo esc_html($_GET['category']); ?> เรียบร้อยแล้ว</p>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['saved']) && $_GET['saved'] == '1'): ?>
                <div class="notice notice-success is-dismissible">
                    <p>✅ บันทึกข้อมูลเรียบร้อยแล้ว</p>
                </div>
            <?php endif; ?>

            <div class="notice notice-info">
                <p><strong>📊 สรุป:</strong> มี <?php echo count($categories); ?> categories พร้อม <?php echo array_sum(array_column($categories, 'total_images')); ?> รูปภาพ</p>
                <p><strong>📂 Location:</strong> /wp-content/uploads/gallery/</p>
                <p><strong>🔗 Frontend:</strong> <a href="<?php echo home_url('/gallery'); ?>" target="_blank">ดูหน้า Gallery</a></p>
            </div>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th width="10%">Category</th>
                        <th width="15%">Thumbnail</th>
                        <th width="30%">Name</th>
                        <th width="10%">Images</th>
                        <th width="25%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr><td colspan="5">ยังไม่มี categories</td></tr>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><strong>#<?php echo esc_html($cat->category_number); ?></strong></td>
                                <td>
                                    <?php if ($cat->thumbnail_url): ?>
                                        <img src="<?php echo esc_url($cat->thumbnail_url); ?>"
                                             style="max-width: 80px; height: auto; border-radius: 4px;">
                                    <?php else: ?>
                                        <div style="width: 80px; height: 80px; background: #ddd; border-radius: 4px;"></div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html($cat->category_name); ?></td>
                                <td>
                                    <span class="dashicons dashicons-images-alt2"></span>
                                    <?php echo (int)$cat->total_images; ?> photos
                                </td>
                                <td>
                                    <a href="<?php echo add_query_arg('category', $cat->category_number, home_url('/gallery')); ?>"
                                       class="button button-small"
                                       target="_blank"
                                       title="ดูหน้า Gallery">
                                        <span class="dashicons dashicons-visibility"></span> View
                                    </a>
                                    <a href="<?php echo add_query_arg(array('page' => 'ayam-gallery-images', 'action' => 'edit', 'id' => $cat->id), admin_url('admin.php')); ?>"
                                       class="button button-small button-primary"
                                       title="แก้ไข Category">
                                        <span class="dashicons dashicons-edit"></span> Edit
                                    </a>
                                    <a href="<?php echo wp_nonce_url(add_query_arg(array('page' => 'ayam-gallery-images', 'action' => 'delete', 'id' => $cat->id), admin_url('admin.php')), 'delete_category_' . $cat->id); ?>"
                                       class="button button-small button-link-delete"
                                       onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบ Category #<?php echo esc_js($cat->category_number); ?>? รูปภาพทั้งหมด <?php echo (int)$cat->total_images; ?> รูปจะถูกลบด้วย');"
                                       title="ลบ Category">
                                        <span class="dashicons dashicons-trash"></span> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Handle gallery actions (delete, edit)
     */
    public function handle_gallery_actions() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'ayam-gallery-images') {
            return;
        }

        if (!isset($_GET['action']) || !isset($_GET['id'])) {
            return;
        }

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $action = sanitize_text_field($_GET['action']);
        $category_id = intval($_GET['id']);

        if ($action === 'delete') {
            // Verify nonce
            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'delete_category_' . $category_id)) {
                wp_die('Security check failed');
            }

            global $wpdb;
            $categories_table = $wpdb->prefix . 'gallery_categories';
            $images_table = $wpdb->prefix . 'gallery_images';

            // Get category info before deleting
            $category = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$categories_table} WHERE id = %d",
                $category_id
            ));

            if (!$category) {
                wp_die('Category not found');
            }

            // Delete all images for this category (CASCADE should handle this, but let's be safe)
            $wpdb->delete($images_table, array('category_id' => $category_id));

            // Delete the category
            $deleted = $wpdb->delete($categories_table, array('id' => $category_id));

            if ($deleted) {
                // Redirect with success message
                wp_redirect(add_query_arg(array(
                    'page' => 'ayam-gallery-images',
                    'deleted' => '1',
                    'category' => $category->category_number
                ), admin_url('admin.php')));
                exit;
            } else {
                wp_die('Failed to delete category');
            }
        }
    }

    /**
     * Gallery Add Page
     */
    private function gallery_add_page() {
        $this->gallery_form_page(null);
    }

    /**
     * Gallery Edit Page
     */
    private function gallery_edit_page($category_id) {
        global $wpdb;
        $categories_table = $wpdb->prefix . 'gallery_categories';
        $images_table = $wpdb->prefix . 'gallery_images';

        $category = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$categories_table} WHERE id = %d",
            $category_id
        ));

        if (!$category) {
            echo '<div class="wrap"><h1>Category not found</h1></div>';
            return;
        }

        // Get existing media for this category
        $existing_media = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$images_table} WHERE category_id = %d ORDER BY sort_order ASC",
            $category_id
        ), ARRAY_A);

        $this->gallery_form_page($category, $existing_media);
    }

    /**
     * Gallery Form Page (Add/Edit)
     */
    private function gallery_form_page($category = null, $existing_media = array()) {
        $is_edit = ($category !== null);
        $category_id = $is_edit ? $category->id : 0;

        // Prepare 6 media slots
        $media_slots = array(
            1 => array('label' => 'เอกสารรับไว้', 'media_type' => 'image', 'url' => ''),
            2 => array('label' => 'ภาพชั่งน้ำหนัก', 'media_type' => 'image', 'url' => ''),
            3 => array('label' => 'ภาพหน้าแซงไก่หน้า', 'media_type' => 'image', 'url' => ''),
            4 => array('label' => 'ภาพหน้าแซงไก่หลัง', 'media_type' => 'image', 'url' => ''),
            5 => array('label' => 'ภาพยิ่งสวยๆ', 'media_type' => 'image', 'url' => ''),
            6 => array('label' => 'วิดีโอไก่ต่ อยู่ฟาร์ม', 'media_type' => 'video', 'url' => ''),
        );

        // Fill with existing media if editing
        if ($is_edit && !empty($existing_media)) {
            foreach ($existing_media as $index => $media) {
                $slot_num = $index + 1;
                if ($slot_num <= 6) {
                    $media_slots[$slot_num]['url'] = $media['image_url'];
                    $media_slots[$slot_num]['media_type'] = $media['media_type'] ?? 'image';
                    if (!empty($media['title'])) {
                        $media_slots[$slot_num]['label'] = $media['title'];
                    }
                }
            }
        }
        ?>
        <div class="wrap">
            <h1><?php echo $is_edit ? 'แก้ไข Category' : 'เพิ่ม Category ใหม่'; ?></h1>

            <form method="post" action="<?php echo admin_url('admin.php?page=ayam-gallery-images'); ?>" enctype="multipart/form-data">
                <?php wp_nonce_field('ayam_gallery_save', 'ayam_gallery_nonce'); ?>
                <input type="hidden" name="action" value="save_gallery_category">
                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

                <style>
                .gallery-form-container {
                    display: grid;
                    grid-template-columns: 400px 1fr;
                    gap: 30px;
                    margin-top: 20px;
                }
                .category-info-section {
                    background: white;
                    padding: 20px;
                    border: 1px solid #ccd0d4;
                    box-shadow: 0 1px 1px rgba(0,0,0,.04);
                }
                .category-info-section h2 {
                    margin-top: 0;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 10px;
                }
                .form-field {
                    margin-bottom: 20px;
                }
                .form-field label {
                    display: block;
                    font-weight: 600;
                    margin-bottom: 5px;
                }
                .form-field input[type="text"],
                .form-field input[type="number"],
                .form-field textarea {
                    width: 100%;
                    padding: 8px;
                }
                .media-slots-section {
                    background: white;
                    padding: 20px;
                    border: 1px solid #ccd0d4;
                    box-shadow: 0 1px 1px rgba(0,0,0,.04);
                }
                .media-slots-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                    margin-top: 20px;
                }
                .media-slot-item {
                    border: 2px solid #ddd;
                    padding: 15px;
                    border-radius: 4px;
                    background: #f9f9f9;
                }
                .media-slot-item h4 {
                    margin-top: 0;
                    color: #2271b1;
                }
                .media-preview {
                    width: 100%;
                    aspect-ratio: 1;
                    background: #e0e0e0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 10px;
                    border-radius: 4px;
                    overflow: hidden;
                }
                .media-preview img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .media-preview iframe {
                    width: 100%;
                    height: 100%;
                    border: 0;
                }
                .media-type-selector {
                    margin-bottom: 10px;
                }
                .submit-section {
                    margin-top: 20px;
                    padding-top: 20px;
                    border-top: 1px solid #ddd;
                }
                </style>

                <div class="gallery-form-container">
                    <!-- Left: Category Info -->
                    <div class="category-info-section">
                        <h2>ข้อมูล Category</h2>

                        <div class="form-field">
                            <label for="category_number">Category Number <span style="color:red;">*</span></label>
                            <input type="text"
                                   id="category_number"
                                   name="category_number"
                                   value="<?php echo $is_edit ? esc_attr($category->category_number) : ''; ?>"
                                   placeholder="เช่น 001"
                                   required
                                   <?php echo $is_edit ? 'readonly' : ''; ?>>
                            <small>รูปแบบ: 001, 002, 003...</small>
                        </div>

                        <div class="form-field">
                            <label for="category_name">ชื่อ Category <span style="color:red;">*</span></label>
                            <input type="text"
                                   id="category_name"
                                   name="category_name"
                                   value="<?php echo $is_edit ? esc_attr($category->category_name) : ''; ?>"
                                   placeholder="เช่น Rooster Category 001"
                                   required>
                        </div>

                        <div class="form-field">
                            <label for="shipment_date">Shipment วันที่</label>
                            <input type="text"
                                   id="shipment_date"
                                   name="shipment_date"
                                   value="<?php echo $is_edit ? esc_attr($category->shipment_date) : ''; ?>"
                                   placeholder="เช่น 15 ตุลาคม 2025">
                        </div>

                        <div class="form-field">
                            <label for="owner">Owner</label>
                            <input type="text"
                                   id="owner"
                                   name="owner"
                                   value="<?php echo $is_edit ? esc_attr($category->owner) : ''; ?>"
                                   placeholder="เช่น Abdul Rahim">
                        </div>
                    </div>

                    <!-- Right: Media Slots -->
                    <div class="media-slots-section">
                        <h2>Media Slots (6 ช่อง)</h2>
                        <div class="media-slots-grid">
                            <?php foreach ($media_slots as $slot_num => $slot): ?>
                                <div class="media-slot-item">
                                    <h4>Slot #<?php echo $slot_num; ?></h4>

                                    <div class="form-field">
                                        <label>Label:</label>
                                        <input type="text"
                                               name="slot_<?php echo $slot_num; ?>_label"
                                               value="<?php echo esc_attr($slot['label']); ?>"
                                               placeholder="ชื่อช่อง">
                                    </div>

                                    <div class="media-type-selector">
                                        <label>ประเภท:</label>
                                        <label style="margin-right: 15px;">
                                            <input type="radio"
                                                   name="slot_<?php echo $slot_num; ?>_type"
                                                   value="image"
                                                   <?php checked($slot['media_type'], 'image'); ?>>
                                            รูปภาพ
                                        </label>
                                        <label>
                                            <input type="radio"
                                                   name="slot_<?php echo $slot_num; ?>_type"
                                                   value="video"
                                                   <?php checked($slot['media_type'], 'video'); ?>>
                                            วิดีโอ
                                        </label>
                                    </div>

                                    <div class="media-preview" id="preview_<?php echo $slot_num; ?>">
                                        <?php if (!empty($slot['url'])): ?>
                                            <?php if ($slot['media_type'] === 'video'): ?>
                                                <iframe src="<?php echo esc_url($slot['url']); ?>" allowfullscreen></iframe>
                                            <?php else: ?>
                                                <img src="<?php echo esc_url($slot['url']); ?>" alt="Slot <?php echo $slot_num; ?>">
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span style="color: #999;">ยังไม่มีไฟล์</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-field">
                                        <label>อัพโหลดรูป:</label>
                                        <input type="file"
                                               name="slot_<?php echo $slot_num; ?>_file"
                                               accept="image/*">
                                    </div>

                                    <div class="form-field">
                                        <label>หรือใส่ URL วิดีโอ:</label>
                                        <input type="url"
                                               name="slot_<?php echo $slot_num; ?>_url"
                                               value="<?php echo $slot['media_type'] === 'video' ? esc_attr($slot['url']) : ''; ?>"
                                               placeholder="https://youtube.com/...">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="submit-section">
                            <button type="submit" class="button button-primary button-large">
                                <span class="dashicons dashicons-saved"></span> บันทึกข้อมูล
                            </button>
                            <a href="<?php echo admin_url('admin.php?page=ayam-gallery-images'); ?>"
                               class="button button-large">
                                ยกเลิก
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Save Gallery Category
     */
    private function save_gallery_category() {
        global $wpdb;
        $categories_table = $wpdb->prefix . 'gallery_categories';
        $images_table = $wpdb->prefix . 'gallery_images';

        $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
        $category_number = sanitize_text_field($_POST['category_number']);
        $category_name = sanitize_text_field($_POST['category_name']);
        $shipment_date = isset($_POST['shipment_date']) ? sanitize_text_field($_POST['shipment_date']) : '';
        $owner = isset($_POST['owner']) ? sanitize_text_field($_POST['owner']) : '';

        $is_edit = ($category_id > 0);

        // Save or update category
        if ($is_edit) {
            $wpdb->update(
                $categories_table,
                array(
                    'category_name' => $category_name,
                    'shipment_date' => $shipment_date,
                    'owner' => $owner
                ),
                array('id' => $category_id)
            );
        } else {
            // Check if category number already exists
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$categories_table} WHERE category_number = %s",
                $category_number
            ));

            if ($exists) {
                wp_die('Category number already exists!');
            }

            $wpdb->insert(
                $categories_table,
                array(
                    'category_number' => $category_number,
                    'category_name' => $category_name,
                    'shipment_date' => $shipment_date,
                    'owner' => $owner,
                    'created_at' => current_time('mysql')
                )
            );
            $category_id = $wpdb->insert_id;
        }

        // Delete existing media for this category if editing
        if ($is_edit) {
            $wpdb->delete($images_table, array('category_id' => $category_id));
        }

        // Process 6 media slots
        $upload_dir = wp_upload_dir();
        $gallery_dir = $upload_dir['basedir'] . '/gallery/' . $category_number;

        if (!file_exists($gallery_dir)) {
            wp_mkdir_p($gallery_dir);
        }

        for ($slot_num = 1; $slot_num <= 6; $slot_num++) {
            $label = isset($_POST["slot_{$slot_num}_label"]) ? sanitize_text_field($_POST["slot_{$slot_num}_label"]) : '';
            $media_type = isset($_POST["slot_{$slot_num}_type"]) ? sanitize_text_field($_POST["slot_{$slot_num}_type"]) : 'image';
            $video_url = isset($_POST["slot_{$slot_num}_url"]) ? esc_url_raw($_POST["slot_{$slot_num}_url"]) : '';

            $image_url = '';

            // Handle file upload
            if (isset($_FILES["slot_{$slot_num}_file"]) && $_FILES["slot_{$slot_num}_file"]['error'] === 0) {
                $file = $_FILES["slot_{$slot_num}_file"];
                $filename = time() . '_' . $slot_num . '_' . basename($file['name']);
                $filepath = $gallery_dir . '/' . $filename;

                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $image_url = $upload_dir['baseurl'] . '/gallery/' . $category_number . '/' . $filename;
                    $media_type = 'image'; // Force image type when file is uploaded
                }
            } elseif (!empty($video_url)) {
                // Use video URL
                $image_url = $video_url;
                $media_type = 'video';
            }

            // Only insert if we have a URL
            if (!empty($image_url)) {
                $wpdb->insert(
                    $images_table,
                    array(
                        'category_id' => $category_id,
                        'image_url' => $image_url,
                        'media_type' => $media_type,
                        'title' => $label,
                        'sort_order' => $slot_num,
                        'created_at' => current_time('mysql')
                    )
                );
            }
        }

        // Redirect with success message
        wp_redirect(add_query_arg(array(
            'page' => 'ayam-gallery-images',
            'saved' => '1'
        ), admin_url('admin.php')));
        exit;
    }

    /**
     * Helper function to handle image upload
     */
    private function handle_image_upload($files, $upload_dir, $page_name) {
        $uploaded_count = 0;

        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name'     => $files['name'][$key],
                    'type'     => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error'    => $files['error'][$key],
                    'size'     => $files['size'][$key]
                );

                $allowed_types = array('image/jpeg', 'image/jpg', 'image/png');
                if (in_array($file['type'], $allowed_types)) {
                    $filename = sanitize_file_name($file['name']);
                    $target_file = $upload_dir . $filename;

                    if (move_uploaded_file($file['tmp_name'], $target_file)) {
                        $uploaded_count++;
                    }
                }
            }
        }

        if ($uploaded_count > 0) {
            echo '<div class="notice notice-success"><p>อัปโหลดรูปภาพ' . $page_name . 'สำเร็จ ' . $uploaded_count . ' ไฟล์</p></div>';
        }
    }

    /**
     * Helper function to handle image delete
     */
    private function handle_image_delete($image_name, $upload_dir) {
        $image_name = sanitize_file_name($image_name);
        $image_path = $upload_dir . $image_name;

        if (file_exists($image_path) && unlink($image_path)) {
            echo '<div class="notice notice-success"><p>ลบรูปภาพเรียบร้อยแล้ว</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>ไม่สามารถลบรูปภาพได้</p></div>';
        }
    }

    /**
     * Helper function to get gallery images
     */
    private function get_gallery_images($gallery_dir) {
        $images = array();
        if (is_dir($gallery_dir)) {
            $files = glob($gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
            foreach ($files as $file) {
                $images[] = basename($file);
            }
        }
        return $images;
    }

    /**
     * Helper function to render gallery management page
     */
    private function render_gallery_page($title, $slug, $images, $image_url, $display_note) {
        ?>
        <div class="wrap">
            <h1>จัดการรูปภาพ <?php echo $title; ?> Page</h1>
            <p>อัปโหลดรูปภาพที่จะแสดงในหน้า <?php echo $title; ?> (ไฟล์ .jpg, .jpeg, .png เท่านั้น)</p>

            <div class="ayam-admin-content" style="grid-template-columns: 1fr;">
                <div class="ayam-admin-form" style="margin-bottom: 30px;">
                    <h2>อัปโหลดรูปภาพใหม่</h2>

                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field($slug . '_upload_action', $slug . '_upload_nonce'); ?>

                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="<?php echo $slug; ?>_images">เลือกรูปภาพ</label></th>
                                <td>
                                    <input type="file" name="<?php echo $slug; ?>_images[]" id="<?php echo $slug; ?>_images" multiple accept="image/jpeg,image/jpg,image/png">
                                    <p class="description">สามารถเลือกหลายไฟล์พร้อมกันได้</p>
                                </td>
                            </tr>
                        </table>

                        <p class="submit">
                            <button type="submit" name="upload_<?php echo $slug; ?>_images" class="button button-primary">อัปโหลดรูปภาพ</button>
                        </p>
                    </form>
                </div>

                <div class="ayam-admin-list">
                    <h2>รูปภาพในแกลเลอรี่ (<?php echo count($images); ?> รูป)</h2>

                    <?php if (!empty($images)): ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                            <?php foreach ($images as $image): ?>
                                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 10px; background: white;">
                                    <img src="<?php echo esc_url($image_url . $image); ?>"
                                         alt="<?php echo esc_attr($image); ?>"
                                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">

                                    <div style="font-size: 12px; margin-bottom: 10px; word-break: break-all;">
                                        <?php echo esc_html($image); ?>
                                    </div>

                                    <form method="post" style="margin: 0;" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบรูปภาพนี้?')">
                                        <?php wp_nonce_field($slug . '_delete_action', $slug . '_delete_nonce'); ?>
                                        <input type="hidden" name="image_name" value="<?php echo esc_attr($image); ?>">
                                        <button type="submit" name="delete_image" class="button button-small button-link-delete" style="width: 100%;">ลบ</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="padding: 40px; text-align: center; background: #f9f9f9; border-radius: 8px; margin-top: 20px;">
                            ยังไม่มีรูปภาพในแกลเลอรี่ กรุณาอัปโหลดรูปภาพ
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div style="margin-top: 30px; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 8px;">
                <h3>คำแนะนำ</h3>
                <ul>
                    <li>แนะนำขนาดรูปภาพ: 1200 x 800 พิกเซลขึ้นไป</li>
                    <li>ไฟล์ที่รองรับ: JPG, JPEG, PNG</li>
                    <li><?php echo $display_note; ?></li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Get field label
     */
    private function get_field_label($field_key) {
        $labels = array(
            'company_name' => 'ชื่อบริษัท',
            'company_description' => 'คำอธิบายบริษัท',
            'vision' => 'วิสัยทัศน์',
            'mission' => 'พันธกิจ',
            'founded_year' => 'ปีที่ก่อตั้ง',
            'employees_count' => 'จำนวนพนักงาน',
            'address' => 'ที่อยู่',
            'phone' => 'เบอร์โทรศัพท์',
            'email' => 'อีเมล',
            'website' => 'เว็บไซต์'
        );
        
        return isset($labels[$field_key]) ? $labels[$field_key] : ucfirst(str_replace('_', ' ', $field_key));
    }
    
    /**
     * Save company info
     */
    private function save_company_info() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ayam_company_info';
        $company_info = $wpdb->get_results("SELECT * FROM $table_name");
        
        foreach ($company_info as $info) {
            $field_key = $info->field_key;
            $value_th = isset($_POST[$field_key . '_th']) ? sanitize_textarea_field($_POST[$field_key . '_th']) : '';
            $value_en = isset($_POST[$field_key . '_en']) ? sanitize_textarea_field($_POST[$field_key . '_en']) : '';
            
            $wpdb->update(
                $table_name,
                array(
                    'field_value_th' => $value_th,
                    'field_value_en' => $value_en,
                    'updated_at' => current_time('mysql')
                ),
                array('id' => $info->id),
                array('%s', '%s', '%s'),
                array('%d')
            );
        }
        
        wp_redirect(admin_url('admin.php?page=ayam-company-info&updated=1'));
        exit;
    }
    
    /**
     * Save timeline
     */
    private function save_timeline() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'ayam_company_timeline';
        $timeline_id = isset($_POST['timeline_id']) ? intval($_POST['timeline_id']) : 0;
        
        $data = array(
            'year' => sanitize_text_field($_POST['year']),
            'title_th' => sanitize_text_field($_POST['title_th']),
            'title_en' => sanitize_text_field($_POST['title_en']),
            'description_th' => sanitize_textarea_field($_POST['description_th']),
            'description_en' => sanitize_textarea_field($_POST['description_en']),
            'icon' => sanitize_text_field($_POST['icon']),
            'sort_order' => intval($_POST['sort_order']),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'updated_at' => current_time('mysql')
        );
        
        if ($timeline_id) {
            $wpdb->update($table_name, $data, array('id' => $timeline_id));
        } else {
            $data['created_at'] = current_time('mysql');
            $wpdb->insert($table_name, $data);
        }
        
        wp_redirect(admin_url('admin.php?page=ayam-timeline&updated=1'));
        exit;
    }
    
    /**
     * Delete timeline
     */
    private function delete_timeline() {
        global $wpdb;
        
        $timeline_id = isset($_POST['timeline_id']) ? intval($_POST['timeline_id']) : 0;
        
        if ($timeline_id) {
            $table_name = $wpdb->prefix . 'ayam_company_timeline';
            $wpdb->delete($table_name, array('id' => $timeline_id), array('%d'));
        }
        
        wp_redirect(admin_url('admin.php?page=ayam-timeline&deleted=1'));
        exit;
    }
    
    /**
     * Placeholder methods for other sections
     */
    private function save_award() {
        // TODO: Implement save award functionality
    }
    
    private function save_team_member() {
        // TODO: Implement save team member functionality
    }
    
    private function save_company_value() {
        // TODO: Implement save company value functionality
    }
    
    private function delete_award() {
        // TODO: Implement delete award functionality
    }
    
    private function delete_team_member() {
        // TODO: Implement delete team member functionality
    }
    
    private function delete_company_value() {
        // TODO: Implement delete company value functionality
    }
}