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