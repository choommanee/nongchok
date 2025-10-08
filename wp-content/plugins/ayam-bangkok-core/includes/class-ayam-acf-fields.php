<?php
/**
 * Advanced Custom Fields Configuration for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamACFFields {
    
    public function __construct() {
        add_action('acf/init', array($this, 'register_field_groups'));
        add_action('acf/init', array($this, 'register_options_pages'));
    }
    
    /**
     * Register all ACF field groups
     */
    public function register_field_groups() {
        if (function_exists('acf_add_local_field_group')) {
            $this->register_rooster_fields();
            $this->register_service_fields();
            $this->register_news_fields();
            $this->register_knowledge_fields();
            $this->register_company_info_fields();
        }
    }
    
    /**
     * Register ACF options pages
     */
    public function register_options_pages() {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => __('ตั้งค่าเว็บไซต์ Ayam Bangkok', 'ayam-bangkok'),
                'menu_title' => __('ตั้งค่าเว็บไซต์', 'ayam-bangkok'),
                'menu_slug' => 'ayam-site-settings',
                'capability' => 'manage_options',
                'icon_url' => 'dashicons-admin-settings',
                'position' => 30
            ));
            
            acf_add_options_sub_page(array(
                'page_title' => __('ข้อมูลบริษัท', 'ayam-bangkok'),
                'menu_title' => __('ข้อมูลบริษัท', 'ayam-bangkok'),
                'parent_slug' => 'ayam-site-settings',
            ));
            
            acf_add_options_sub_page(array(
                'page_title' => __('การติดต่อ', 'ayam-bangkok'),
                'menu_title' => __('การติดต่อ', 'ayam-bangkok'),
                'parent_slug' => 'ayam-site-settings',
            ));
        }
    }
    
    /**
     * Register rooster fields
     */
    private function register_rooster_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_rooster_basic_info',
            'title' => __('ข้อมูลพื้นฐานไก่ชน', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_rooster_number',
                    'label' => __('หมายเลขไก่', 'ayam-bangkok'),
                    'name' => 'rooster_number',
                    'type' => 'text',
                    'instructions' => __('หมายเลขประจำตัวไก่ชน (เช่น R001, R002)', 'ayam-bangkok'),
                    'required' => 0,
                    'placeholder' => 'R001',
                ),
                array(
                    'key' => 'field_rooster_price',
                    'label' => __('ราคา (บาท)', 'ayam-bangkok'),
                    'name' => 'rooster_price',
                    'type' => 'number',
                    'instructions' => __('ราคาขายไก่ชนเป็นบาท', 'ayam-bangkok'),
                    'required' => 0,
                    'min' => 0,
                    'step' => 100,
                    'prepend' => '฿',
                ),
                array(
                    'key' => 'field_rooster_age',
                    'label' => __('อายุ (เดือน)', 'ayam-bangkok'),
                    'name' => 'rooster_age',
                    'type' => 'number',
                    'instructions' => __('อายุของไก่ชนเป็นเดือน', 'ayam-bangkok'),
                    'required' => 0,
                    'min' => 0,
                    'max' => 120,
                    'append' => 'เดือน',
                ),
                array(
                    'key' => 'field_rooster_weight',
                    'label' => __('น้ำหนัก (กิโลกรัม)', 'ayam-bangkok'),
                    'name' => 'rooster_weight',
                    'type' => 'number',
                    'instructions' => __('น้ำหนักของไก่ชนเป็นกิโลกรัม', 'ayam-bangkok'),
                    'required' => 0,
                    'min' => 0,
                    'max' => 10,
                    'step' => 0.1,
                    'append' => 'กก.',
                ),
                array(
                    'key' => 'field_rooster_color',
                    'label' => __('สีขนไก่', 'ayam-bangkok'),
                    'name' => 'rooster_color',
                    'type' => 'select',
                    'instructions' => __('เลือกสีขนหลักของไก่ชน', 'ayam-bangkok'),
                    'choices' => array(
                        'red' => __('แดง', 'ayam-bangkok'),
                        'black' => __('ดำ', 'ayam-bangkok'),
                        'white' => __('ขาว', 'ayam-bangkok'),
                        'brown' => __('น้ำตาล', 'ayam-bangkok'),
                        'yellow' => __('เหลือง', 'ayam-bangkok'),
                        'mixed' => __('ผสม', 'ayam-bangkok'),
                        'other' => __('อื่นๆ', 'ayam-bangkok'),
                    ),
                    'allow_null' => 1,
                    'default_value' => '',
                ),
                array(
                    'key' => 'field_rooster_gender',
                    'label' => __('เพศ', 'ayam-bangkok'),
                    'name' => 'rooster_gender',
                    'type' => 'radio',
                    'instructions' => __('เพศของไก่', 'ayam-bangkok'),
                    'choices' => array(
                        'male' => __('ไก่ตัวผู้', 'ayam-bangkok'),
                        'female' => __('ไก่ตัวเมีย', 'ayam-bangkok'),
                    ),
                    'default_value' => 'male',
                    'layout' => 'horizontal',
                ),
                array(
                    'key' => 'field_rooster_status',
                    'label' => __('สถานะ', 'ayam-bangkok'),
                    'name' => 'rooster_status',
                    'type' => 'select',
                    'instructions' => __('สถานะปัจจุบันของไก่ชน', 'ayam-bangkok'),
                    'choices' => array(
                        'available' => __('พร้อมขาย', 'ayam-bangkok'),
                        'reserved' => __('จองแล้ว', 'ayam-bangkok'),
                        'sold' => __('ขายแล้ว', 'ayam-bangkok'),
                        'training' => __('กำลังฝึก', 'ayam-bangkok'),
                        'breeding' => __('ใช้ผสมพันธุ์', 'ayam-bangkok'),
                    ),
                    'default_value' => 'available',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_rooster',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
        ));
        
        // Rooster Fighting History Fields
        acf_add_local_field_group(array(
            'key' => 'group_rooster_fighting_history',
            'title' => __('ประวัติการแข่งขัน', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_rooster_fighting_record',
                    'label' => __('สถิติการแข่งขัน', 'ayam-bangkok'),
                    'name' => 'rooster_fighting_record',
                    'type' => 'textarea',
                    'instructions' => __('บันทึกประวัติการแข่งขัน ชนะ-แพ้-เสมอ', 'ayam-bangkok'),
                    'rows' => 4,
                ),
                array(
                    'key' => 'field_rooster_wins',
                    'label' => __('จำนวนครั้งที่ชนะ', 'ayam-bangkok'),
                    'name' => 'rooster_wins',
                    'type' => 'number',
                    'min' => 0,
                    'default_value' => 0,
                ),
                array(
                    'key' => 'field_rooster_losses',
                    'label' => __('จำนวนครั้งที่แพ้', 'ayam-bangkok'),
                    'name' => 'rooster_losses',
                    'type' => 'number',
                    'min' => 0,
                    'default_value' => 0,
                ),
                array(
                    'key' => 'field_rooster_draws',
                    'label' => __('จำนวนครั้งที่เสมอ', 'ayam-bangkok'),
                    'name' => 'rooster_draws',
                    'type' => 'number',
                    'min' => 0,
                    'default_value' => 0,
                ),
                array(
                    'key' => 'field_rooster_last_fight',
                    'label' => __('การแข่งขันครั้งล่าสุด', 'ayam-bangkok'),
                    'name' => 'rooster_last_fight',
                    'type' => 'date_picker',
                    'display_format' => 'd/m/Y',
                    'return_format' => 'Y-m-d',
                ),
                array(
                    'key' => 'field_rooster_fighting_style',
                    'label' => __('สไตล์การต่อสู้', 'ayam-bangkok'),
                    'name' => 'rooster_fighting_style',
                    'type' => 'checkbox',
                    'choices' => array(
                        'aggressive' => __('ดุร้าย', 'ayam-bangkok'),
                        'defensive' => __('รับมากกว่าจู่โจม', 'ayam-bangkok'),
                        'technical' => __('เทคนิค', 'ayam-bangkok'),
                        'endurance' => __('ความอดทน', 'ayam-bangkok'),
                        'speed' => __('ความเร็ว', 'ayam-bangkok'),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_rooster',
                    ),
                ),
            ),
            'menu_order' => 1,
            'position' => 'normal',
        ));
        
        // Rooster Pedigree Fields
        acf_add_local_field_group(array(
            'key' => 'group_rooster_pedigree',
            'title' => __('ข้อมูลพ่อแม่พันธุ์', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_rooster_pedigree_father',
                    'label' => __('ข้อมูลพ่อพันธุ์', 'ayam-bangkok'),
                    'name' => 'rooster_pedigree_father',
                    'type' => 'textarea',
                    'instructions' => __('ข้อมูลและประวัติของพ่อพันธุ์', 'ayam-bangkok'),
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_rooster_pedigree_mother',
                    'label' => __('ข้อมูลแม่พันธุ์', 'ayam-bangkok'),
                    'name' => 'rooster_pedigree_mother',
                    'type' => 'textarea',
                    'instructions' => __('ข้อมูลและประวัติของแม่พันธุ์', 'ayam-bangkok'),
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_rooster_bloodline',
                    'label' => __('สายเลือด', 'ayam-bangkok'),
                    'name' => 'rooster_bloodline',
                    'type' => 'text',
                    'instructions' => __('ชื่อสายเลือดหรือตระกูล', 'ayam-bangkok'),
                ),
                array(
                    'key' => 'field_rooster_breeder',
                    'label' => __('ผู้เพาะพันธุ์', 'ayam-bangkok'),
                    'name' => 'rooster_breeder',
                    'type' => 'text',
                    'instructions' => __('ชื่อผู้เพาะพันธุ์หรือฟาร์ม', 'ayam-bangkok'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_rooster',
                    ),
                ),
            ),
            'menu_order' => 2,
            'position' => 'normal',
        ));
        
        // Rooster Health & Export Fields
        acf_add_local_field_group(array(
            'key' => 'group_rooster_health_export',
            'title' => __('สุขภาพและการส่งออก', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_rooster_health_status',
                    'label' => __('สถานะสุขภาพ', 'ayam-bangkok'),
                    'name' => 'rooster_health_status',
                    'type' => 'select',
                    'choices' => array(
                        'excellent' => __('ดีเยี่ยม', 'ayam-bangkok'),
                        'good' => __('ดี', 'ayam-bangkok'),
                        'fair' => __('พอใช้', 'ayam-bangkok'),
                        'recovering' => __('กำลังฟื้นตัว', 'ayam-bangkok'),
                    ),
                    'default_value' => 'good',
                ),
                array(
                    'key' => 'field_rooster_vaccination',
                    'label' => __('การฉีดวัคซีน', 'ayam-bangkok'),
                    'name' => 'rooster_vaccination',
                    'type' => 'textarea',
                    'instructions' => __('บันทึกประวัติการฉีดวัคซีนและยา', 'ayam-bangkok'),
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_rooster_export_ready',
                    'label' => __('พร้อมส่งออก', 'ayam-bangkok'),
                    'name' => 'rooster_export_ready',
                    'type' => 'true_false',
                    'instructions' => __('ไก่ตัวนี้พร้อมสำหรับการส่งออกหรือไม่', 'ayam-bangkok'),
                    'default_value' => 0,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_rooster_health_certificate',
                    'label' => __('ใบรับรองสุขภาพ', 'ayam-bangkok'),
                    'name' => 'rooster_health_certificate',
                    'type' => 'file',
                    'instructions' => __('อัพโหลดใบรับรองสุขภาพจากสัตวแพทย์', 'ayam-bangkok'),
                    'return_format' => 'array',
                    'mime_types' => 'pdf,jpg,jpeg,png',
                ),
                array(
                    'key' => 'field_rooster_quarantine_date',
                    'label' => __('วันที่เข้ากักกัน', 'ayam-bangkok'),
                    'name' => 'rooster_quarantine_date',
                    'type' => 'date_picker',
                    'instructions' => __('วันที่เริ่มกักกันก่อนส่งออก', 'ayam-bangkok'),
                    'display_format' => 'd/m/Y',
                    'return_format' => 'Y-m-d',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_rooster',
                    ),
                ),
            ),
            'menu_order' => 3,
            'position' => 'normal',
        ));
        
        // Rooster Gallery Fields
        acf_add_local_field_group(array(
            'key' => 'group_rooster_gallery',
            'title' => __('แกลเลอรี่รูปภาพ', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_rooster_gallery',
                    'label' => __('รูปภาพเพิ่มเติม', 'ayam-bangkok'),
                    'name' => 'rooster_gallery',
                    'type' => 'gallery',
                    'instructions' => __('เพิ่มรูปภาพไก่ชนจากมุมต่างๆ', 'ayam-bangkok'),
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'insert' => 'append',
                    'library' => 'all',
                    'min' => 0,
                    'max' => 10,
                ),
                array(
                    'key' => 'field_rooster_video_url',
                    'label' => __('วิดีโอ YouTube', 'ayam-bangkok'),
                    'name' => 'rooster_video_url',
                    'type' => 'url',
                    'instructions' => __('ลิงก์วิดีโอ YouTube ของไก่ชนตัวนี้', 'ayam-bangkok'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_rooster',
                    ),
                ),
            ),
            'menu_order' => 4,
            'position' => 'side',
        ));
    }
    
    /**
     * Register service fields
     */
    private function register_service_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_service_details',
            'title' => __('รายละเอียดบริการ', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_service_price',
                    'label' => __('ราคาบริการ (บาท)', 'ayam-bangkok'),
                    'name' => 'service_price',
                    'type' => 'number',
                    'instructions' => __('ราคาบริการเป็นบาท', 'ayam-bangkok'),
                    'min' => 0,
                    'step' => 100,
                    'prepend' => '฿',
                ),
                array(
                    'key' => 'field_service_duration',
                    'label' => __('ระยะเวลา', 'ayam-bangkok'),
                    'name' => 'service_duration',
                    'type' => 'text',
                    'instructions' => __('ระยะเวลาในการให้บริการ เช่น "2-3 สัปดาห์"', 'ayam-bangkok'),
                ),
                array(
                    'key' => 'field_service_type',
                    'label' => __('ประเภทบริการ', 'ayam-bangkok'),
                    'name' => 'service_type',
                    'type' => 'select',
                    'choices' => array(
                        'training' => __('บริการฝึกไก่', 'ayam-bangkok'),
                        'healthcare' => __('บริการดูแลรักษา', 'ayam-bangkok'),
                        'consulting' => __('คอนซัลติ้ง', 'ayam-bangkok'),
                        'breeding' => __('ผสมพันธุ์', 'ayam-bangkok'),
                        'boarding' => __('ฝากเลี้ยง', 'ayam-bangkok'),
                        'export' => __('บริการส่งออก', 'ayam-bangkok'),
                    ),
                    'allow_null' => 1,
                ),
                array(
                    'key' => 'field_service_booking_available',
                    'label' => __('เปิดรับจอง', 'ayam-bangkok'),
                    'name' => 'service_booking_available',
                    'type' => 'true_false',
                    'instructions' => __('บริการนี้เปิดรับจองออนไลน์หรือไม่', 'ayam-bangkok'),
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_service_requirements',
                    'label' => __('ข้อกำหนดและเงื่อนไข', 'ayam-bangkok'),
                    'name' => 'service_requirements',
                    'type' => 'textarea',
                    'instructions' => __('ข้อกำหนดที่ลูกค้าต้องปฏิบัติตาม', 'ayam-bangkok'),
                    'rows' => 4,
                ),
                array(
                    'key' => 'field_service_includes',
                    'label' => __('สิ่งที่รวมในบริการ', 'ayam-bangkok'),
                    'name' => 'service_includes',
                    'type' => 'textarea',
                    'instructions' => __('รายการสิ่งที่รวมอยู่ในบริการนี้', 'ayam-bangkok'),
                    'rows' => 4,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_service',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
        ));
    }
    
    /**
     * Register news fields
     */
    private function register_news_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_news_details',
            'title' => __('รายละเอียดข่าวสาร', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_news_highlight',
                    'label' => __('ข่าวเด่น', 'ayam-bangkok'),
                    'name' => 'news_highlight',
                    'type' => 'true_false',
                    'instructions' => __('แสดงข่าวนี้ในหน้าแรกหรือไม่', 'ayam-bangkok'),
                    'default_value' => 0,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_news_gallery',
                    'label' => __('แกลเลอรี่ข่าว', 'ayam-bangkok'),
                    'name' => 'news_gallery',
                    'type' => 'gallery',
                    'instructions' => __('รูปภาพประกอบข่าว', 'ayam-bangkok'),
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'max' => 8,
                ),
                array(
                    'key' => 'field_news_video_url',
                    'label' => __('วิดีโอประกอบ', 'ayam-bangkok'),
                    'name' => 'news_video_url',
                    'type' => 'url',
                    'instructions' => __('ลิงก์วิดีโอ YouTube ประกอบข่าว', 'ayam-bangkok'),
                ),
                array(
                    'key' => 'field_news_event_date',
                    'label' => __('วันที่จัดกิจกรรม', 'ayam-bangkok'),
                    'name' => 'news_event_date',
                    'type' => 'date_picker',
                    'instructions' => __('วันที่จัดกิจกรรม (ถ้าเป็นข่าวกิจกรรม)', 'ayam-bangkok'),
                    'display_format' => 'd/m/Y',
                    'return_format' => 'Y-m-d',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_news',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
        ));
    }
    
    /**
     * Register knowledge fields
     */
    private function register_knowledge_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_knowledge_details',
            'title' => __('รายละเอียดบทความ', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_knowledge_difficulty',
                    'label' => __('ระดับความยาก', 'ayam-bangkok'),
                    'name' => 'knowledge_difficulty',
                    'type' => 'select',
                    'choices' => array(
                        'beginner' => __('เริ่มต้น', 'ayam-bangkok'),
                        'intermediate' => __('ปานกลาง', 'ayam-bangkok'),
                        'advanced' => __('ขั้นสูง', 'ayam-bangkok'),
                        'expert' => __('ผู้เชี่ยวชาญ', 'ayam-bangkok'),
                    ),
                    'default_value' => 'beginner',
                ),
                array(
                    'key' => 'field_knowledge_reading_time',
                    'label' => __('เวลาในการอ่าน (นาที)', 'ayam-bangkok'),
                    'name' => 'knowledge_reading_time',
                    'type' => 'number',
                    'instructions' => __('ประมาณเวลาในการอ่านบทความ', 'ayam-bangkok'),
                    'min' => 1,
                    'max' => 60,
                    'append' => 'นาที',
                ),
                array(
                    'key' => 'field_knowledge_video_url',
                    'label' => __('วิดีโอสอน', 'ayam-bangkok'),
                    'name' => 'knowledge_video_url',
                    'type' => 'url',
                    'instructions' => __('ลิงก์วิดีโอสอนใน YouTube', 'ayam-bangkok'),
                ),
                array(
                    'key' => 'field_knowledge_downloads',
                    'label' => __('ไฟล์ดาวน์โหลด', 'ayam-bangkok'),
                    'name' => 'knowledge_downloads',
                    'type' => 'repeater',
                    'instructions' => __('ไฟล์เสริมสำหรับดาวน์โหลด', 'ayam-bangkok'),
                    'sub_fields' => array(
                        array(
                            'key' => 'field_download_title',
                            'label' => __('ชื่อไฟล์', 'ayam-bangkok'),
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_download_file',
                            'label' => __('ไฟล์', 'ayam-bangkok'),
                            'name' => 'file',
                            'type' => 'file',
                            'return_format' => 'array',
                        ),
                    ),
                    'min' => 0,
                    'max' => 5,
                    'layout' => 'table',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ayam_knowledge',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
        ));
    }
    
    /**
     * Register company info fields
     */
    private function register_company_info_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_company_info',
            'title' => __('ข้อมูลบริษัท', 'ayam-bangkok'),
            'fields' => array(
                array(
                    'key' => 'field_company_name_th',
                    'label' => __('ชื่อบริษัท (ไทย)', 'ayam-bangkok'),
                    'name' => 'company_name_th',
                    'type' => 'text',
                    'default_value' => 'หนองจอก เอฟซีไอ',
                ),
                array(
                    'key' => 'field_company_name_en',
                    'label' => __('ชื่อบริษัท (อังกฤษ)', 'ayam-bangkok'),
                    'name' => 'company_name_en',
                    'type' => 'text',
                    'default_value' => 'Nongchok FCI',
                ),
                array(
                    'key' => 'field_company_description',
                    'label' => __('คำอธิบายบริษัท', 'ayam-bangkok'),
                    'name' => 'company_description',
                    'type' => 'textarea',
                    'rows' => 4,
                ),
                array(
                    'key' => 'field_company_address',
                    'label' => __('ที่อยู่บริษัท', 'ayam-bangkok'),
                    'name' => 'company_address',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_company_phone',
                    'label' => __('เบอร์โทรศัพท์', 'ayam-bangkok'),
                    'name' => 'company_phone',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_company_email',
                    'label' => __('อีเมล', 'ayam-bangkok'),
                    'name' => 'company_email',
                    'type' => 'email',
                ),
                array(
                    'key' => 'field_company_line_id',
                    'label' => __('Line ID', 'ayam-bangkok'),
                    'name' => 'company_line_id',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_company_facebook',
                    'label' => __('Facebook', 'ayam-bangkok'),
                    'name' => 'company_facebook',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_company_youtube',
                    'label' => __('YouTube', 'ayam-bangkok'),
                    'name' => 'company_youtube',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_company_map_embed',
                    'label' => __('Google Maps Embed Code', 'ayam-bangkok'),
                    'name' => 'company_map_embed',
                    'type' => 'textarea',
                    'instructions' => __('โค้ด embed จาก Google Maps', 'ayam-bangkok'),
                    'rows' => 3,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-ข้อมูลบริษัท',
                    ),
                ),
            ),
            'menu_order' => 0,
        ));
    }
}

new AyamACFFields();