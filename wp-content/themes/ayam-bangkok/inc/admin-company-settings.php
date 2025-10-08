<?php
/**
 * Admin Company Settings Page
 * จัดการข้อมูลบริษัทในรูปแบบ tabs
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamCompanySettings {
    
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
            'จัดการข้อมูลบริษัท',
            'ข้อมูลบริษัท',
            'manage_options',
            'ayam-company-settings',
            array($this, 'admin_page'),
            'dashicons-building',
            30
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'toplevel_page_ayam-company-settings') {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-sortable');
        
        wp_enqueue_style('ayam-admin-tabs', get_template_directory_uri() . '/assets/css/admin-tabs.css', array(), '1.0.0');
        wp_enqueue_script('ayam-admin-tabs', get_template_directory_uri() . '/assets/js/admin-tabs.js', array('jquery', 'jquery-ui-tabs', 'jquery-ui-sortable'), '1.0.0', true);
    }
    
    /**
     * Handle form submissions
     */
    public function handle_form_submissions() {
        if (!isset($_POST['ayam_company_nonce']) || !wp_verify_nonce($_POST['ayam_company_nonce'], 'ayam_company_settings')) {
            return;
        }
        
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $tab = sanitize_text_field($_POST['active_tab']);
        
        switch ($tab) {
            case 'company_info':
                $this->save_company_info();
                break;
            case 'timeline':
                $this->save_timeline();
                break;
            case 'awards':
                $this->save_awards();
                break;
            case 'team':
                $this->save_team();
                break;
            case 'values':
                $this->save_values();
                break;
        }
        
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>บันทึกข้อมูลเรียบร้อยแล้ว</p></div>';
        });
    }
    
    /**
     * Save company info
     */
    private function save_company_info() {
        $fields = array(
            'company_name' => 'sanitize_text_field',
            'company_description' => 'sanitize_textarea_field',
            'company_vision' => 'sanitize_textarea_field',
            'company_mission' => 'sanitize_textarea_field',
            'company_main_image' => 'esc_url_raw'
        );
        
        foreach ($fields as $field => $sanitize_func) {
            if (isset($_POST[$field])) {
                update_option('ayam_' . $field, $sanitize_func($_POST[$field]));
            }
        }
    }
    
    /**
     * Save timeline data
     */
    private function save_timeline() {
        $timeline = array();
        
        if (isset($_POST['timeline_year']) && is_array($_POST['timeline_year'])) {
            for ($i = 0; $i < count($_POST['timeline_year']); $i++) {
                if (!empty($_POST['timeline_year'][$i]) && !empty($_POST['timeline_title'][$i])) {
                    $timeline[] = array(
                        'year' => sanitize_text_field($_POST['timeline_year'][$i]),
                        'title' => sanitize_text_field($_POST['timeline_title'][$i]),
                        'description' => sanitize_textarea_field($_POST['timeline_description'][$i] ?? '')
                    );
                }
            }
        }
        
        update_option('ayam_company_timeline', $timeline);
    }
    
    /**
     * Save awards data
     */
    private function save_awards() {
        $awards = array();
        
        if (isset($_POST['award_title']) && is_array($_POST['award_title'])) {
            for ($i = 0; $i < count($_POST['award_title']); $i++) {
                if (!empty($_POST['award_title'][$i])) {
                    $awards[] = array(
                        'title' => sanitize_text_field($_POST['award_title'][$i]),
                        'year' => sanitize_text_field($_POST['award_year'][$i] ?? ''),
                        'description' => sanitize_textarea_field($_POST['award_description'][$i] ?? ''),
                        'image' => esc_url_raw($_POST['award_image'][$i] ?? '')
                    );
                }
            }
        }
        
        update_option('ayam_company_awards', $awards);
    }
    
    /**
     * Save team data
     */
    private function save_team() {
        $team = array();
        
        if (isset($_POST['member_name']) && is_array($_POST['member_name'])) {
            for ($i = 0; $i < count($_POST['member_name']); $i++) {
                if (!empty($_POST['member_name'][$i])) {
                    $team[] = array(
                        'name' => sanitize_text_field($_POST['member_name'][$i]),
                        'position' => sanitize_text_field($_POST['member_position'][$i] ?? ''),
                        'bio' => sanitize_textarea_field($_POST['member_bio'][$i] ?? ''),
                        'image' => esc_url_raw($_POST['member_image'][$i] ?? ''),
                        'email' => sanitize_email($_POST['member_email'][$i] ?? ''),
                        'phone' => sanitize_text_field($_POST['member_phone'][$i] ?? '')
                    );
                }
            }
        }
        
        update_option('ayam_team_members', $team);
    }
    
    /**
     * Save company values
     */
    private function save_values() {
        $values = array();
        
        if (isset($_POST['value_title']) && is_array($_POST['value_title'])) {
            for ($i = 0; $i < count($_POST['value_title']); $i++) {
                if (!empty($_POST['value_title'][$i])) {
                    $values[] = array(
                        'title' => sanitize_text_field($_POST['value_title'][$i]),
                        'description' => sanitize_textarea_field($_POST['value_description'][$i] ?? ''),
                        'icon' => sanitize_text_field($_POST['value_icon'][$i] ?? '')
                    );
                }
            }
        }
        
        update_option('ayam_company_values', $values);
    }
    
    /**
     * Main admin page
     */
    public function admin_page() {
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'company_info';
        ?>
        <div class="wrap">
            <h1>จัดการข้อมูลบริษัท</h1>
            
            <div id="ayam-company-tabs">
                <ul class="nav-tab-wrapper">
                    <li><a href="#tab-company-info" class="nav-tab <?php echo $active_tab === 'company_info' ? 'nav-tab-active' : ''; ?>">ข้อมูลบริษัท</a></li>
                    <li><a href="#tab-timeline" class="nav-tab <?php echo $active_tab === 'timeline' ? 'nav-tab-active' : ''; ?>">ประวัติความเป็นมา</a></li>
                    <li><a href="#tab-awards" class="nav-tab <?php echo $active_tab === 'awards' ? 'nav-tab-active' : ''; ?>">รางวัลและใบรับรอง</a></li>
                    <li><a href="#tab-team" class="nav-tab <?php echo $active_tab === 'team' ? 'nav-tab-active' : ''; ?>">ทีมงาน</a></li>
                    <li><a href="#tab-values" class="nav-tab <?php echo $active_tab === 'values' ? 'nav-tab-active' : ''; ?>">ค่านิยมองค์กร</a></li>
                </ul>
                
                <form method="post" action="">
                    <?php wp_nonce_field('ayam_company_settings', 'ayam_company_nonce'); ?>
                    <input type="hidden" name="active_tab" id="active_tab" value="<?php echo esc_attr($active_tab); ?>">
                    
                    <div id="tab-company-info" class="tab-content">
                        <?php $this->render_company_info_tab(); ?>
                    </div>
                    
                    <div id="tab-timeline" class="tab-content">
                        <?php $this->render_timeline_tab(); ?>
                    </div>
                    
                    <div id="tab-awards" class="tab-content">
                        <?php $this->render_awards_tab(); ?>
                    </div>
                    
                    <div id="tab-team" class="tab-content">
                        <?php $this->render_team_tab(); ?>
                    </div>
                    
                    <div id="tab-values" class="tab-content">
                        <?php $this->render_values_tab(); ?>
                    </div>
                    
                    <p class="submit">
                        <input type="submit" name="submit" class="button-primary" value="บันทึกข้อมูล">
                    </p>
                </form>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render company info tab
     */
    private function render_company_info_tab() {
        $company_name = get_option('ayam_company_name', 'Ayam Bangkok');
        $company_description = get_option('ayam_company_description', '');
        $company_vision = get_option('ayam_company_vision', '');
        $company_mission = get_option('ayam_company_mission', '');
        $company_main_image = get_option('ayam_company_main_image', '');
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">ชื่อบริษัท</th>
                <td>
                    <input type="text" name="company_name" value="<?php echo esc_attr($company_name); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">คำอธิบายบริษัท</th>
                <td>
                    <textarea name="company_description" rows="4" cols="50"><?php echo esc_textarea($company_description); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">วิสัยทัศน์</th>
                <td>
                    <textarea name="company_vision" rows="3" cols="50"><?php echo esc_textarea($company_vision); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">พันธกิจ</th>
                <td>
                    <textarea name="company_mission" rows="4" cols="50"><?php echo esc_textarea($company_mission); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">รูปภาพหลักบริษัท</th>
                <td>
                    <input type="url" name="company_main_image" value="<?php echo esc_url($company_main_image); ?>" class="regular-text">
                    <button type="button" class="button upload-image-button">เลือกรูปภาพ</button>
                    <?php if ($company_main_image): ?>
                        <div class="image-preview">
                            <img src="<?php echo esc_url($company_main_image); ?>" style="max-width: 200px; height: auto;">
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        <?php
    }
    
    /**
     * Render timeline tab
     */
    private function render_timeline_tab() {
        $timeline = get_option('ayam_company_timeline', array());
        ?>
        <div class="timeline-section">
            <h3>ประวัติความเป็นมา</h3>
            <div id="timeline-items" class="sortable-items">
                <?php if (!empty($timeline)): ?>
                    <?php foreach ($timeline as $index => $item): ?>
                        <div class="timeline-item" data-index="<?php echo $index; ?>">
                            <table class="form-table">
                                <tr>
                                    <th>ปี</th>
                                    <td><input type="text" name="timeline_year[]" value="<?php echo esc_attr($item['year']); ?>" class="small-text"></td>
                                </tr>
                                <tr>
                                    <th>หัวข้อ</th>
                                    <td><input type="text" name="timeline_title[]" value="<?php echo esc_attr($item['title']); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th>รายละเอียด</th>
                                    <td><textarea name="timeline_description[]" rows="3" cols="50"><?php echo esc_textarea($item['description'] ?? ''); ?></textarea></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-item">ลบรายการ</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button add-timeline-item">เพิ่มรายการใหม่</button>
        </div>
        <?php
    }
    
    /**
     * Render awards tab
     */
    private function render_awards_tab() {
        $awards = get_option('ayam_company_awards', array());
        ?>
        <div class="awards-section">
            <h3>รางวัลและใบรับรอง</h3>
            <div id="awards-items" class="sortable-items">
                <?php if (!empty($awards)): ?>
                    <?php foreach ($awards as $index => $award): ?>
                        <div class="award-item" data-index="<?php echo $index; ?>">
                            <table class="form-table">
                                <tr>
                                    <th>ชื่อรางวัล</th>
                                    <td><input type="text" name="award_title[]" value="<?php echo esc_attr($award['title']); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th>ปี</th>
                                    <td><input type="text" name="award_year[]" value="<?php echo esc_attr($award['year'] ?? ''); ?>" class="small-text"></td>
                                </tr>
                                <tr>
                                    <th>รายละเอียด</th>
                                    <td><textarea name="award_description[]" rows="3" cols="50"><?php echo esc_textarea($award['description'] ?? ''); ?></textarea></td>
                                </tr>
                                <tr>
                                    <th>รูปภาพ</th>
                                    <td>
                                        <input type="url" name="award_image[]" value="<?php echo esc_url($award['image'] ?? ''); ?>" class="regular-text">
                                        <button type="button" class="button upload-image-button">เลือกรูปภาพ</button>
                                    </td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-item">ลบรายการ</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button add-award-item">เพิ่มรางวัลใหม่</button>
        </div>
        <?php
    }
    
    /**
     * Render team tab
     */
    private function render_team_tab() {
        $team = get_option('ayam_team_members', array());
        ?>
        <div class="team-section">
            <h3>ทีมงาน</h3>
            <div id="team-items" class="sortable-items">
                <?php if (!empty($team)): ?>
                    <?php foreach ($team as $index => $member): ?>
                        <div class="team-item" data-index="<?php echo $index; ?>">
                            <table class="form-table">
                                <tr>
                                    <th>ชื่อ</th>
                                    <td><input type="text" name="member_name[]" value="<?php echo esc_attr($member['name']); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th>ตำแหน่ง</th>
                                    <td><input type="text" name="member_position[]" value="<?php echo esc_attr($member['position'] ?? ''); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th>ประวัติ</th>
                                    <td><textarea name="member_bio[]" rows="3" cols="50"><?php echo esc_textarea($member['bio'] ?? ''); ?></textarea></td>
                                </tr>
                                <tr>
                                    <th>รูปภาพ</th>
                                    <td>
                                        <input type="url" name="member_image[]" value="<?php echo esc_url($member['image'] ?? ''); ?>" class="regular-text">
                                        <button type="button" class="button upload-image-button">เลือกรูปภาพ</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>อีเมล</th>
                                    <td><input type="email" name="member_email[]" value="<?php echo esc_attr($member['email'] ?? ''); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th>เบอร์โทร</th>
                                    <td><input type="text" name="member_phone[]" value="<?php echo esc_attr($member['phone'] ?? ''); ?>" class="regular-text"></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-item">ลบสมาชิก</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button add-team-item">เพิ่มสมาชิกใหม่</button>
        </div>
        <?php
    }
    
    /**
     * Render values tab
     */
    private function render_values_tab() {
        $values = get_option('ayam_company_values', array());
        ?>
        <div class="values-section">
            <h3>ค่านิยมองค์กร</h3>
            <div id="values-items" class="sortable-items">
                <?php if (!empty($values)): ?>
                    <?php foreach ($values as $index => $value): ?>
                        <div class="value-item" data-index="<?php echo $index; ?>">
                            <table class="form-table">
                                <tr>
                                    <th>หัวข้อ</th>
                                    <td><input type="text" name="value_title[]" value="<?php echo esc_attr($value['title']); ?>" class="regular-text"></td>
                                </tr>
                                <tr>
                                    <th>รายละเอียด</th>
                                    <td><textarea name="value_description[]" rows="3" cols="50"><?php echo esc_textarea($value['description'] ?? ''); ?></textarea></td>
                                </tr>
                                <tr>
                                    <th>ไอคอน (CSS Class)</th>
                                    <td><input type="text" name="value_icon[]" value="<?php echo esc_attr($value['icon'] ?? ''); ?>" class="regular-text" placeholder="เช่น fas fa-heart"></td>
                                </tr>
                            </table>
                            <button type="button" class="button remove-item">ลบค่านิยม</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" class="button add-value-item">เพิ่มค่านิยมใหม่</button>
        </div>
        <?php
    }
}

// Initialize the class
new AyamCompanySettings();