<?php
/**
 * Custom Meta Boxes for Ayam Bangkok (Fallback when ACF is not available)
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamMetaBoxes {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        // Only add if ACF is not available
        if (function_exists('acf_add_local_field_group')) {
            return;
        }
        
        // Rooster meta boxes
        add_meta_box(
            'ayam_rooster_basic_info',
            __('ข้อมูลพื้นฐานไก่ชน', 'ayam-bangkok'),
            array($this, 'rooster_basic_info_callback'),
            'ayam_rooster',
            'normal',
            'high'
        );
        
        add_meta_box(
            'ayam_rooster_fighting_history',
            __('ประวัติการแข่งขัน', 'ayam-bangkok'),
            array($this, 'rooster_fighting_history_callback'),
            'ayam_rooster',
            'normal',
            'default'
        );
        
        add_meta_box(
            'ayam_rooster_health_export',
            __('สุขภาพและการส่งออก', 'ayam-bangkok'),
            array($this, 'rooster_health_export_callback'),
            'ayam_rooster',
            'side',
            'default'
        );
        
        // Service meta boxes
        add_meta_box(
            'ayam_service_details',
            __('รายละเอียดบริการ', 'ayam-bangkok'),
            array($this, 'service_details_callback'),
            'ayam_service',
            'normal',
            'high'
        );
        
        // News meta boxes
        add_meta_box(
            'ayam_news_details',
            __('รายละเอียดข่าวสาร', 'ayam-bangkok'),
            array($this, 'news_details_callback'),
            'ayam_news',
            'side',
            'default'
        );
    }
    
    /**
     * Rooster basic info meta box
     */
    public function rooster_basic_info_callback($post) {
        wp_nonce_field('ayam_rooster_meta_box', 'ayam_rooster_meta_box_nonce');
        
        $price = get_post_meta($post->ID, 'rooster_price', true);
        $age = get_post_meta($post->ID, 'rooster_age', true);
        $weight = get_post_meta($post->ID, 'rooster_weight', true);
        $color = get_post_meta($post->ID, 'rooster_color', true);
        $gender = get_post_meta($post->ID, 'rooster_gender', true);
        $status = get_post_meta($post->ID, 'rooster_status', true);
        
        ?>
        <div class="ayam-rooster-meta-box">
            <div class="ayam-field-group">
                <div class="ayam-field">
                    <label for="rooster_price"><?php _e('ราคา (บาท)', 'ayam-bangkok'); ?></label>
                    <input type="number" id="rooster_price" name="rooster_price" value="<?php echo esc_attr($price); ?>" min="0" step="100" />
                    <span class="field-description"><?php _e('ราคาขายไก่ชนเป็นบาท', 'ayam-bangkok'); ?></span>
                </div>
                
                <div class="ayam-field">
                    <label for="rooster_age"><?php _e('อายุ (เดือน)', 'ayam-bangkok'); ?></label>
                    <input type="number" id="rooster_age" name="rooster_age" value="<?php echo esc_attr($age); ?>" min="0" max="120" />
                    <span class="field-description"><?php _e('อายุของไก่ชนเป็นเดือน', 'ayam-bangkok'); ?></span>
                </div>
                
                <div class="ayam-field">
                    <label for="rooster_weight"><?php _e('น้ำหนัก (กิโลกรัม)', 'ayam-bangkok'); ?></label>
                    <input type="number" id="rooster_weight" name="rooster_weight" value="<?php echo esc_attr($weight); ?>" min="0" max="10" step="0.1" />
                    <span class="field-description"><?php _e('น้ำหนักของไก่ชนเป็นกิโลกรัม', 'ayam-bangkok'); ?></span>
                </div>
            </div>
            
            <div class="ayam-field-group">
                <div class="ayam-field">
                    <label for="rooster_color"><?php _e('สีขนไก่', 'ayam-bangkok'); ?></label>
                    <select id="rooster_color" name="rooster_color">
                        <option value=""><?php _e('เลือกสี', 'ayam-bangkok'); ?></option>
                        <option value="red" <?php selected($color, 'red'); ?>><?php _e('แดง', 'ayam-bangkok'); ?></option>
                        <option value="black" <?php selected($color, 'black'); ?>><?php _e('ดำ', 'ayam-bangkok'); ?></option>
                        <option value="white" <?php selected($color, 'white'); ?>><?php _e('ขาว', 'ayam-bangkok'); ?></option>
                        <option value="brown" <?php selected($color, 'brown'); ?>><?php _e('น้ำตาล', 'ayam-bangkok'); ?></option>
                        <option value="yellow" <?php selected($color, 'yellow'); ?>><?php _e('เหลือง', 'ayam-bangkok'); ?></option>
                        <option value="mixed" <?php selected($color, 'mixed'); ?>><?php _e('ผสม', 'ayam-bangkok'); ?></option>
                        <option value="other" <?php selected($color, 'other'); ?>><?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                    </select>
                </div>
                
                <div class="ayam-field">
                    <label for="rooster_gender"><?php _e('เพศ', 'ayam-bangkok'); ?></label>
                    <select id="rooster_gender" name="rooster_gender">
                        <option value="male" <?php selected($gender, 'male'); ?>><?php _e('ไก่ตัวผู้', 'ayam-bangkok'); ?></option>
                        <option value="female" <?php selected($gender, 'female'); ?>><?php _e('ไก่ตัวเมีย', 'ayam-bangkok'); ?></option>
                    </select>
                </div>
                
                <div class="ayam-field">
                    <label for="rooster_status"><?php _e('สถานะ', 'ayam-bangkok'); ?></label>
                    <select id="rooster_status" name="rooster_status">
                        <option value="available" <?php selected($status, 'available'); ?>><?php _e('พร้อมขาย', 'ayam-bangkok'); ?></option>
                        <option value="reserved" <?php selected($status, 'reserved'); ?>><?php _e('จองแล้ว', 'ayam-bangkok'); ?></option>
                        <option value="sold" <?php selected($status, 'sold'); ?>><?php _e('ขายแล้ว', 'ayam-bangkok'); ?></option>
                        <option value="training" <?php selected($status, 'training'); ?>><?php _e('กำลังฝึก', 'ayam-bangkok'); ?></option>
                        <option value="breeding" <?php selected($status, 'breeding'); ?>><?php _e('ใช้ผสมพันธุ์', 'ayam-bangkok'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Rooster fighting history meta box
     */
    public function rooster_fighting_history_callback($post) {
        $fighting_record = get_post_meta($post->ID, 'rooster_fighting_record', true);
        $wins = get_post_meta($post->ID, 'rooster_wins', true);
        $losses = get_post_meta($post->ID, 'rooster_losses', true);
        $draws = get_post_meta($post->ID, 'rooster_draws', true);
        $last_fight = get_post_meta($post->ID, 'rooster_last_fight', true);
        
        ?>
        <div class="ayam-rooster-meta-box">
            <div class="ayam-field">
                <label for="rooster_fighting_record"><?php _e('สถิติการแข่งขัน', 'ayam-bangkok'); ?></label>
                <textarea id="rooster_fighting_record" name="rooster_fighting_record" rows="4"><?php echo esc_textarea($fighting_record); ?></textarea>
                <span class="field-description"><?php _e('บันทึกประวัติการแข่งขัน ชนะ-แพ้-เสมอ', 'ayam-bangkok'); ?></span>
            </div>
            
            <div class="ayam-field-group">
                <div class="ayam-field">
                    <label for="rooster_wins"><?php _e('จำนวนครั้งที่ชนะ', 'ayam-bangkok'); ?></label>
                    <input type="number" id="rooster_wins" name="rooster_wins" value="<?php echo esc_attr($wins); ?>" min="0" />
                </div>
                
                <div class="ayam-field">
                    <label for="rooster_losses"><?php _e('จำนวนครั้งที่แพ้', 'ayam-bangkok'); ?></label>
                    <input type="number" id="rooster_losses" name="rooster_losses" value="<?php echo esc_attr($losses); ?>" min="0" />
                </div>
                
                <div class="ayam-field">
                    <label for="rooster_draws"><?php _e('จำนวนครั้งที่เสมอ', 'ayam-bangkok'); ?></label>
                    <input type="number" id="rooster_draws" name="rooster_draws" value="<?php echo esc_attr($draws); ?>" min="0" />
                </div>
            </div>
            
            <div class="ayam-field">
                <label for="rooster_last_fight"><?php _e('การแข่งขันครั้งล่าสุด', 'ayam-bangkok'); ?></label>
                <input type="date" id="rooster_last_fight" name="rooster_last_fight" value="<?php echo esc_attr($last_fight); ?>" />
            </div>
        </div>
        <?php
    }
    
    /**
     * Rooster health and export meta box
     */
    public function rooster_health_export_callback($post) {
        $health_status = get_post_meta($post->ID, 'rooster_health_status', true);
        $export_ready = get_post_meta($post->ID, 'rooster_export_ready', true);
        $vaccination = get_post_meta($post->ID, 'rooster_vaccination', true);
        $quarantine_date = get_post_meta($post->ID, 'rooster_quarantine_date', true);
        
        ?>
        <div class="ayam-rooster-meta-box">
            <div class="ayam-field">
                <label for="rooster_health_status"><?php _e('สถานะสุขภาพ', 'ayam-bangkok'); ?></label>
                <select id="rooster_health_status" name="rooster_health_status">
                    <option value="excellent" <?php selected($health_status, 'excellent'); ?>><?php _e('ดีเยี่ยม', 'ayam-bangkok'); ?></option>
                    <option value="good" <?php selected($health_status, 'good'); ?>><?php _e('ดี', 'ayam-bangkok'); ?></option>
                    <option value="fair" <?php selected($health_status, 'fair'); ?>><?php _e('พอใช้', 'ayam-bangkok'); ?></option>
                    <option value="recovering" <?php selected($health_status, 'recovering'); ?>><?php _e('กำลังฟื้นตัว', 'ayam-bangkok'); ?></option>
                </select>
            </div>
            
            <div class="ayam-field">
                <label>
                    <input type="checkbox" name="rooster_export_ready" value="1" <?php checked($export_ready, '1'); ?> />
                    <?php _e('พร้อมส่งออก', 'ayam-bangkok'); ?>
                </label>
                <span class="field-description"><?php _e('ไก่ตัวนี้พร้อมสำหรับการส่งออกหรือไม่', 'ayam-bangkok'); ?></span>
            </div>
            
            <div class="ayam-field">
                <label for="rooster_vaccination"><?php _e('การฉีดวัคซีน', 'ayam-bangkok'); ?></label>
                <textarea id="rooster_vaccination" name="rooster_vaccination" rows="3"><?php echo esc_textarea($vaccination); ?></textarea>
                <span class="field-description"><?php _e('บันทึกประวัติการฉีดวัคซีนและยา', 'ayam-bangkok'); ?></span>
            </div>
            
            <div class="ayam-field">
                <label for="rooster_quarantine_date"><?php _e('วันที่เข้ากักกัน', 'ayam-bangkok'); ?></label>
                <input type="date" id="rooster_quarantine_date" name="rooster_quarantine_date" value="<?php echo esc_attr($quarantine_date); ?>" />
                <span class="field-description"><?php _e('วันที่เริ่มกักกันก่อนส่งออก', 'ayam-bangkok'); ?></span>
            </div>
        </div>
        <?php
    }
    
    /**
     * Service details meta box
     */
    public function service_details_callback($post) {
        wp_nonce_field('ayam_service_meta_box', 'ayam_service_meta_box_nonce');
        
        $price = get_post_meta($post->ID, 'service_price', true);
        $duration = get_post_meta($post->ID, 'service_duration', true);
        $type = get_post_meta($post->ID, 'service_type', true);
        $booking_available = get_post_meta($post->ID, 'service_booking_available', true);
        $requirements = get_post_meta($post->ID, 'service_requirements', true);
        
        ?>
        <div class="ayam-rooster-meta-box">
            <div class="ayam-field-group">
                <div class="ayam-field">
                    <label for="service_price"><?php _e('ราคาบริการ (บาท)', 'ayam-bangkok'); ?></label>
                    <input type="number" id="service_price" name="service_price" value="<?php echo esc_attr($price); ?>" min="0" step="100" />
                </div>
                
                <div class="ayam-field">
                    <label for="service_duration"><?php _e('ระยะเวลา', 'ayam-bangkok'); ?></label>
                    <input type="text" id="service_duration" name="service_duration" value="<?php echo esc_attr($duration); ?>" />
                    <span class="field-description"><?php _e('เช่น "2-3 สัปดาห์"', 'ayam-bangkok'); ?></span>
                </div>
                
                <div class="ayam-field">
                    <label for="service_type"><?php _e('ประเภทบริการ', 'ayam-bangkok'); ?></label>
                    <select id="service_type" name="service_type">
                        <option value=""><?php _e('เลือกประเภท', 'ayam-bangkok'); ?></option>
                        <option value="training" <?php selected($type, 'training'); ?>><?php _e('บริการฝึกไก่', 'ayam-bangkok'); ?></option>
                        <option value="healthcare" <?php selected($type, 'healthcare'); ?>><?php _e('บริการดูแลรักษา', 'ayam-bangkok'); ?></option>
                        <option value="consulting" <?php selected($type, 'consulting'); ?>><?php _e('คอนซัลติ้ง', 'ayam-bangkok'); ?></option>
                        <option value="breeding" <?php selected($type, 'breeding'); ?>><?php _e('ผสมพันธุ์', 'ayam-bangkok'); ?></option>
                        <option value="boarding" <?php selected($type, 'boarding'); ?>><?php _e('ฝากเลี้ยง', 'ayam-bangkok'); ?></option>
                        <option value="export" <?php selected($type, 'export'); ?>><?php _e('บริการส่งออก', 'ayam-bangkok'); ?></option>
                    </select>
                </div>
            </div>
            
            <div class="ayam-field">
                <label>
                    <input type="checkbox" name="service_booking_available" value="1" <?php checked($booking_available, '1'); ?> />
                    <?php _e('เปิดรับจอง', 'ayam-bangkok'); ?>
                </label>
                <span class="field-description"><?php _e('บริการนี้เปิดรับจองออนไลน์หรือไม่', 'ayam-bangkok'); ?></span>
            </div>
            
            <div class="ayam-field">
                <label for="service_requirements"><?php _e('ข้อกำหนดและเงื่อนไข', 'ayam-bangkok'); ?></label>
                <textarea id="service_requirements" name="service_requirements" rows="4"><?php echo esc_textarea($requirements); ?></textarea>
                <span class="field-description"><?php _e('ข้อกำหนดที่ลูกค้าต้องปฏิบัติตาม', 'ayam-bangkok'); ?></span>
            </div>
        </div>
        <?php
    }
    
    /**
     * News details meta box
     */
    public function news_details_callback($post) {
        wp_nonce_field('ayam_news_meta_box', 'ayam_news_meta_box_nonce');
        
        $highlight = get_post_meta($post->ID, 'news_highlight', true);
        $video_url = get_post_meta($post->ID, 'news_video_url', true);
        $event_date = get_post_meta($post->ID, 'news_event_date', true);
        
        ?>
        <div class="ayam-rooster-meta-box">
            <div class="ayam-field">
                <label>
                    <input type="checkbox" name="news_highlight" value="1" <?php checked($highlight, '1'); ?> />
                    <?php _e('ข่าวเด่น', 'ayam-bangkok'); ?>
                </label>
                <span class="field-description"><?php _e('แสดงข่าวนี้ในหน้าแรกหรือไม่', 'ayam-bangkok'); ?></span>
            </div>
            
            <div class="ayam-field">
                <label for="news_video_url"><?php _e('วิดีโอประกอบ', 'ayam-bangkok'); ?></label>
                <input type="url" id="news_video_url" name="news_video_url" value="<?php echo esc_attr($video_url); ?>" />
                <span class="field-description"><?php _e('ลิงก์วิดีโอ YouTube', 'ayam-bangkok'); ?></span>
            </div>
            
            <div class="ayam-field">
                <label for="news_event_date"><?php _e('วันที่จัดกิจกรรม', 'ayam-bangkok'); ?></label>
                <input type="date" id="news_event_date" name="news_event_date" value="<?php echo esc_attr($event_date); ?>" />
                <span class="field-description"><?php _e('วันที่จัดกิจกรรม (ถ้าเป็นข่าวกิจกรรม)', 'ayam-bangkok'); ?></span>
            </div>
        </div>
        <?php
    }
    
    /**
     * Save meta box data
     */
    public function save_meta_boxes($post_id) {
        // Check if user has permission to edit
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Check nonce for security
        if (isset($_POST['ayam_rooster_meta_box_nonce']) && wp_verify_nonce($_POST['ayam_rooster_meta_box_nonce'], 'ayam_rooster_meta_box')) {
            $this->save_rooster_meta($post_id);
        }
        
        if (isset($_POST['ayam_service_meta_box_nonce']) && wp_verify_nonce($_POST['ayam_service_meta_box_nonce'], 'ayam_service_meta_box')) {
            $this->save_service_meta($post_id);
        }
        
        if (isset($_POST['ayam_news_meta_box_nonce']) && wp_verify_nonce($_POST['ayam_news_meta_box_nonce'], 'ayam_news_meta_box')) {
            $this->save_news_meta($post_id);
        }
    }
    
    /**
     * Save rooster meta data
     */
    private function save_rooster_meta($post_id) {
        $fields = array(
            'rooster_price' => 'floatval',
            'rooster_age' => 'intval',
            'rooster_weight' => 'floatval',
            'rooster_color' => 'sanitize_text_field',
            'rooster_gender' => 'sanitize_text_field',
            'rooster_status' => 'sanitize_text_field',
            'rooster_fighting_record' => 'sanitize_textarea_field',
            'rooster_wins' => 'intval',
            'rooster_losses' => 'intval',
            'rooster_draws' => 'intval',
            'rooster_last_fight' => 'sanitize_text_field',
            'rooster_health_status' => 'sanitize_text_field',
            'rooster_vaccination' => 'sanitize_textarea_field',
            'rooster_quarantine_date' => 'sanitize_text_field',
        );
        
        foreach ($fields as $field => $sanitize_function) {
            if (isset($_POST[$field])) {
                $value = $sanitize_function($_POST[$field]);
                update_post_meta($post_id, $field, $value);
            }
        }
        
        // Handle checkbox fields
        $export_ready = isset($_POST['rooster_export_ready']) ? '1' : '0';
        update_post_meta($post_id, 'rooster_export_ready', $export_ready);
    }
    
    /**
     * Save service meta data
     */
    private function save_service_meta($post_id) {
        $fields = array(
            'service_price' => 'floatval',
            'service_duration' => 'sanitize_text_field',
            'service_type' => 'sanitize_text_field',
            'service_requirements' => 'sanitize_textarea_field',
        );
        
        foreach ($fields as $field => $sanitize_function) {
            if (isset($_POST[$field])) {
                $value = $sanitize_function($_POST[$field]);
                update_post_meta($post_id, $field, $value);
            }
        }
        
        // Handle checkbox fields
        $booking_available = isset($_POST['service_booking_available']) ? '1' : '0';
        update_post_meta($post_id, 'service_booking_available', $booking_available);
    }
    
    /**
     * Save news meta data
     */
    private function save_news_meta($post_id) {
        $fields = array(
            'news_video_url' => 'esc_url_raw',
            'news_event_date' => 'sanitize_text_field',
        );
        
        foreach ($fields as $field => $sanitize_function) {
            if (isset($_POST[$field])) {
                $value = $sanitize_function($_POST[$field]);
                update_post_meta($post_id, $field, $value);
            }
        }
        
        // Handle checkbox fields
        $highlight = isset($_POST['news_highlight']) ? '1' : '0';
        update_post_meta($post_id, 'news_highlight', $highlight);
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        global $post_type;
        
        if (in_array($post_type, array('ayam_rooster', 'ayam_service', 'ayam_news', 'ayam_knowledge'))) {
            wp_enqueue_script('ayam-meta-boxes', AYAM_PLUGIN_URL . 'assets/js/meta-boxes.js', array('jquery'), AYAM_PLUGIN_VERSION, true);
        }
    }
}

new AyamMetaBoxes();