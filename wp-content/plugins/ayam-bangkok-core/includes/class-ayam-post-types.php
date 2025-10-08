<?php
/**
 * Custom Post Types for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamPostTypes {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_types'), 0);
        add_action('admin_init', array($this, 'check_post_types'));
    }
    
    /**
     * Check if post types are registered (for debugging)
     */
    public function check_post_types() {
        if (current_user_can('manage_options')) {
            $registered = post_type_exists('ayam_rooster');
            if (!$registered) {
                add_action('admin_notices', function() {
                    echo '<div class="notice notice-error"><p>Ayam Bangkok: Post types not registered!</p></div>';
                });
            }
        }
    }
    
    /**
     * Register all custom post types
     */
    public function register_post_types() {
        $this->register_rooster_post_type();
        $this->register_service_post_type();
        $this->register_news_post_type();
        $this->register_knowledge_post_type();
        
        // Debug log
        error_log('Ayam Bangkok: Post types registered');
    }
    
    /**
     * Register Rooster Post Type
     */
    private function register_rooster_post_type() {
        $labels = array(
            'name'                  => __('ไก่ชน', 'ayam-bangkok'),
            'singular_name'         => __('ไก่ชน', 'ayam-bangkok'),
            'menu_name'             => __('ไก่ชน', 'ayam-bangkok'),
            'name_admin_bar'        => __('ไก่ชน', 'ayam-bangkok'),
            'archives'              => __('รายการไก่ชน', 'ayam-bangkok'),
            'attributes'            => __('คุณสมบัติไก่ชน', 'ayam-bangkok'),
            'parent_item_colon'     => __('ไก่ชนหลัก:', 'ayam-bangkok'),
            'all_items'             => __('ไก่ชนทั้งหมด', 'ayam-bangkok'),
            'add_new_item'          => __('เพิ่มไก่ชนใหม่', 'ayam-bangkok'),
            'add_new'               => __('เพิ่มใหม่', 'ayam-bangkok'),
            'new_item'              => __('ไก่ชนใหม่', 'ayam-bangkok'),
            'edit_item'             => __('แก้ไขไก่ชน', 'ayam-bangkok'),
            'update_item'           => __('อัพเดทไก่ชน', 'ayam-bangkok'),
            'view_item'             => __('ดูไก่ชน', 'ayam-bangkok'),
            'view_items'            => __('ดูไก่ชน', 'ayam-bangkok'),
            'search_items'          => __('ค้นหาไก่ชน', 'ayam-bangkok'),
            'not_found'             => __('ไม่พบไก่ชน', 'ayam-bangkok'),
            'not_found_in_trash'    => __('ไม่พบไก่ชนในถังขยะ', 'ayam-bangkok'),
            'featured_image'        => __('รูปไก่ชนหลัก', 'ayam-bangkok'),
            'set_featured_image'    => __('ตั้งรูปไก่ชนหลัก', 'ayam-bangkok'),
            'remove_featured_image' => __('ลบรูปไก่ชนหลัก', 'ayam-bangkok'),
            'use_featured_image'    => __('ใช้เป็นรูปไก่ชนหลัก', 'ayam-bangkok'),
            'insert_into_item'      => __('แทรกลงในไก่ชน', 'ayam-bangkok'),
            'uploaded_to_this_item' => __('อัพโหลดไปยังไก่ชนนี้', 'ayam-bangkok'),
            'items_list'            => __('รายการไก่ชน', 'ayam-bangkok'),
            'items_list_navigation' => __('นำทางรายการไก่ชน', 'ayam-bangkok'),
            'filter_items_list'     => __('กรองรายการไก่ชน', 'ayam-bangkok'),
        );
        
        $args = array(
            'label'                 => __('ไก่ชน', 'ayam-bangkok'),
            'description'           => __('ข้อมูลไก่ชนสำหรับส่งออก', 'ayam-bangkok'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields'),
            'taxonomies'            => array('rooster_breed', 'rooster_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-pets',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'roosters',
            'rewrite'               => array('slug' => 'rooster', 'with_front' => false),
        );
        
        register_post_type('ayam_rooster', $args);
    }
    
    /**
     * Register Service Post Type
     */
    private function register_service_post_type() {
        $labels = array(
            'name'                  => __('บริการ', 'ayam-bangkok'),
            'singular_name'         => __('บริการ', 'ayam-bangkok'),
            'menu_name'             => __('บริการ', 'ayam-bangkok'),
            'name_admin_bar'        => __('บริการ', 'ayam-bangkok'),
            'archives'              => __('รายการบริการ', 'ayam-bangkok'),
            'attributes'            => __('คุณสมบัติบริการ', 'ayam-bangkok'),
            'all_items'             => __('บริการทั้งหมด', 'ayam-bangkok'),
            'add_new_item'          => __('เพิ่มบริการใหม่', 'ayam-bangkok'),
            'add_new'               => __('เพิ่มใหม่', 'ayam-bangkok'),
            'new_item'              => __('บริการใหม่', 'ayam-bangkok'),
            'edit_item'             => __('แก้ไขบริการ', 'ayam-bangkok'),
            'update_item'           => __('อัพเดทบริการ', 'ayam-bangkok'),
            'view_item'             => __('ดูบริการ', 'ayam-bangkok'),
            'search_items'          => __('ค้นหาบริการ', 'ayam-bangkok'),
            'not_found'             => __('ไม่พบบริการ', 'ayam-bangkok'),
            'not_found_in_trash'    => __('ไม่พบบริการในถังขยะ', 'ayam-bangkok'),
        );
        
        $args = array(
            'label'                 => __('บริการ', 'ayam-bangkok'),
            'description'           => __('บริการต่างๆ ของ Ayam Bangkok', 'ayam-bangkok'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
            'taxonomies'            => array('service_category'),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 21,
            'menu_icon'             => 'dashicons-admin-tools',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'services',
            'rewrite'               => array('slug' => 'service', 'with_front' => false),
        );
        
        register_post_type('ayam_service', $args);
    }
    
    /**
     * Register News Post Type
     */
    private function register_news_post_type() {
        $labels = array(
            'name'                  => __('ข่าวสาร', 'ayam-bangkok'),
            'singular_name'         => __('ข่าว', 'ayam-bangkok'),
            'menu_name'             => __('ข่าวสาร', 'ayam-bangkok'),
            'name_admin_bar'        => __('ข่าว', 'ayam-bangkok'),
            'archives'              => __('รายการข่าว', 'ayam-bangkok'),
            'all_items'             => __('ข่าวทั้งหมด', 'ayam-bangkok'),
            'add_new_item'          => __('เพิ่มข่าวใหม่', 'ayam-bangkok'),
            'add_new'               => __('เพิ่มใหม่', 'ayam-bangkok'),
            'new_item'              => __('ข่าวใหม่', 'ayam-bangkok'),
            'edit_item'             => __('แก้ไขข่าว', 'ayam-bangkok'),
            'update_item'           => __('อัพเดทข่าว', 'ayam-bangkok'),
            'view_item'             => __('ดูข่าว', 'ayam-bangkok'),
            'search_items'          => __('ค้นหาข่าว', 'ayam-bangkok'),
            'not_found'             => __('ไม่พบข่าว', 'ayam-bangkok'),
            'not_found_in_trash'    => __('ไม่พบข่าวในถังขยะ', 'ayam-bangkok'),
        );
        
        $args = array(
            'label'                 => __('ข่าวสาร', 'ayam-bangkok'),
            'description'           => __('ข่าวสารและกิจกรรมของ Ayam Bangkok', 'ayam-bangkok'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments'),
            'taxonomies'            => array('news_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 22,
            'menu_icon'             => 'dashicons-megaphone',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'news',
            'rewrite'               => array('slug' => 'news', 'with_front' => false),
        );
        
        register_post_type('ayam_news', $args);
    }
    
    /**
     * Register Knowledge Post Type
     */
    private function register_knowledge_post_type() {
        $labels = array(
            'name'                  => __('ความรู้', 'ayam-bangkok'),
            'singular_name'         => __('บทความ', 'ayam-bangkok'),
            'menu_name'             => __('ศูนย์ความรู้', 'ayam-bangkok'),
            'name_admin_bar'        => __('บทความ', 'ayam-bangkok'),
            'archives'              => __('รายการบทความ', 'ayam-bangkok'),
            'all_items'             => __('บทความทั้งหมด', 'ayam-bangkok'),
            'add_new_item'          => __('เพิ่มบทความใหม่', 'ayam-bangkok'),
            'add_new'               => __('เพิ่มใหม่', 'ayam-bangkok'),
            'new_item'              => __('บทความใหม่', 'ayam-bangkok'),
            'edit_item'             => __('แก้ไขบทความ', 'ayam-bangkok'),
            'update_item'           => __('อัพเดทบทความ', 'ayam-bangkok'),
            'view_item'             => __('ดูบทความ', 'ayam-bangkok'),
            'search_items'          => __('ค้นหาบทความ', 'ayam-bangkok'),
            'not_found'             => __('ไม่พบบทความ', 'ayam-bangkok'),
            'not_found_in_trash'    => __('ไม่พบบทความในถังขยะ', 'ayam-bangkok'),
        );
        
        $args = array(
            'label'                 => __('ความรู้', 'ayam-bangkok'),
            'description'           => __('บทความความรู้เกี่ยวกับไก่ชน', 'ayam-bangkok'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
            'taxonomies'            => array('knowledge_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 23,
            'menu_icon'             => 'dashicons-book-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'knowledge',
            'rewrite'               => array('slug' => 'knowledge', 'with_front' => false),
        );
        
        register_post_type('ayam_knowledge', $args);
    }
}