<?php
/**
 * Custom Taxonomies for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamTaxonomies {
    
    public function __construct() {
        add_action('init', array($this, 'register_taxonomies'));
    }
    
    /**
     * Register all custom taxonomies
     */
    public function register_taxonomies() {
        $this->register_rooster_breed_taxonomy();
        $this->register_rooster_category_taxonomy();
        $this->register_service_category_taxonomy();
        $this->register_news_category_taxonomy();
        $this->register_knowledge_category_taxonomy();
    }
    
    /**
     * Register Rooster Breed Taxonomy
     */
    private function register_rooster_breed_taxonomy() {
        $labels = array(
            'name'                       => __('สายพันธุ์ไก่', 'ayam-bangkok'),
            'singular_name'              => __('สายพันธุ์', 'ayam-bangkok'),
            'menu_name'                  => __('สายพันธุ์ไก่', 'ayam-bangkok'),
            'all_items'                  => __('สายพันธุ์ทั้งหมด', 'ayam-bangkok'),
            'parent_item'                => __('สายพันธุ์หลัก', 'ayam-bangkok'),
            'parent_item_colon'          => __('สายพันธุ์หลัก:', 'ayam-bangkok'),
            'new_item_name'              => __('ชื่อสายพันธุ์ใหม่', 'ayam-bangkok'),
            'add_new_item'               => __('เพิ่มสายพันธุ์ใหม่', 'ayam-bangkok'),
            'edit_item'                  => __('แก้ไขสายพันธุ์', 'ayam-bangkok'),
            'update_item'                => __('อัพเดทสายพันธุ์', 'ayam-bangkok'),
            'view_item'                  => __('ดูสายพันธุ์', 'ayam-bangkok'),
            'separate_items_with_commas' => __('แยกสายพันธุ์ด้วยเครื่องหมายจุลภาค', 'ayam-bangkok'),
            'add_or_remove_items'        => __('เพิ่มหรือลบสายพันธุ์', 'ayam-bangkok'),
            'choose_from_most_used'      => __('เลือกจากที่ใช้บ่อยที่สุด', 'ayam-bangkok'),
            'popular_items'              => __('สายพันธุ์ยอดนิยม', 'ayam-bangkok'),
            'search_items'               => __('ค้นหาสายพันธุ์', 'ayam-bangkok'),
            'not_found'                  => __('ไม่พบสายพันธุ์', 'ayam-bangkok'),
            'no_terms'                   => __('ไม่มีสายพันธุ์', 'ayam-bangkok'),
            'items_list'                 => __('รายการสายพันธุ์', 'ayam-bangkok'),
            'items_list_navigation'      => __('นำทางรายการสายพันธุ์', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
            'rest_base'                  => 'rooster-breeds',
            'rewrite'                    => array('slug' => 'rooster-breed', 'with_front' => false),
        );
        
        register_taxonomy('rooster_breed', array('ayam_rooster'), $args);
    }
    
    /**
     * Register Rooster Category Taxonomy
     */
    private function register_rooster_category_taxonomy() {
        $labels = array(
            'name'                       => __('หมวดหมู่ไก่', 'ayam-bangkok'),
            'singular_name'              => __('หมวดหมู่', 'ayam-bangkok'),
            'menu_name'                  => __('หมวดหมู่ไก่', 'ayam-bangkok'),
            'all_items'                  => __('หมวดหมู่ทั้งหมด', 'ayam-bangkok'),
            'new_item_name'              => __('ชื่อหมวดหมู่ใหม่', 'ayam-bangkok'),
            'add_new_item'               => __('เพิ่มหมวดหมู่ใหม่', 'ayam-bangkok'),
            'edit_item'                  => __('แก้ไขหมวดหมู่', 'ayam-bangkok'),
            'update_item'                => __('อัพเดทหมวดหมู่', 'ayam-bangkok'),
            'view_item'                  => __('ดูหมวดหมู่', 'ayam-bangkok'),
            'separate_items_with_commas' => __('แยกหมวดหมู่ด้วยเครื่องหมายจุลภาค', 'ayam-bangkok'),
            'add_or_remove_items'        => __('เพิ่มหรือลบหมวดหมู่', 'ayam-bangkok'),
            'choose_from_most_used'      => __('เลือกจากที่ใช้บ่อยที่สุด', 'ayam-bangkok'),
            'popular_items'              => __('หมวดหมู่ยอดนิยม', 'ayam-bangkok'),
            'search_items'               => __('ค้นหาหมวดหมู่', 'ayam-bangkok'),
            'not_found'                  => __('ไม่พบหมวดหมู่', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
            'rest_base'                  => 'rooster-categories',
            'rewrite'                    => array('slug' => 'rooster-category', 'with_front' => false),
        );
        
        register_taxonomy('rooster_category', array('ayam_rooster'), $args);
    }
    
    /**
     * Register Service Category Taxonomy
     */
    private function register_service_category_taxonomy() {
        $labels = array(
            'name'                       => __('หมวดบริการ', 'ayam-bangkok'),
            'singular_name'              => __('หมวดบริการ', 'ayam-bangkok'),
            'menu_name'                  => __('หมวดบริการ', 'ayam-bangkok'),
            'all_items'                  => __('หมวดบริการทั้งหมด', 'ayam-bangkok'),
            'new_item_name'              => __('ชื่อหมวดบริการใหม่', 'ayam-bangkok'),
            'add_new_item'               => __('เพิ่มหมวดบริการใหม่', 'ayam-bangkok'),
            'edit_item'                  => __('แก้ไขหมวดบริการ', 'ayam-bangkok'),
            'update_item'                => __('อัพเดทหมวดบริการ', 'ayam-bangkok'),
            'view_item'                  => __('ดูหมวดบริการ', 'ayam-bangkok'),
            'search_items'               => __('ค้นหาหมวดบริการ', 'ayam-bangkok'),
            'not_found'                  => __('ไม่พบหมวดบริการ', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'show_in_rest'               => true,
            'rest_base'                  => 'service-categories',
            'rewrite'                    => array('slug' => 'service-category', 'with_front' => false),
        );
        
        register_taxonomy('service_category', array('ayam_service'), $args);
    }
    
    /**
     * Register News Category Taxonomy
     */
    private function register_news_category_taxonomy() {
        $labels = array(
            'name'                       => __('หมวดข่าว', 'ayam-bangkok'),
            'singular_name'              => __('หมวดข่าว', 'ayam-bangkok'),
            'menu_name'                  => __('หมวดข่าว', 'ayam-bangkok'),
            'all_items'                  => __('หมวดข่าวทั้งหมด', 'ayam-bangkok'),
            'new_item_name'              => __('ชื่อหมวดข่าวใหม่', 'ayam-bangkok'),
            'add_new_item'               => __('เพิ่มหมวดข่าวใหม่', 'ayam-bangkok'),
            'edit_item'                  => __('แก้ไขหมวดข่าว', 'ayam-bangkok'),
            'update_item'                => __('อัพเดทหมวดข่าว', 'ayam-bangkok'),
            'view_item'                  => __('ดูหมวดข่าว', 'ayam-bangkok'),
            'search_items'               => __('ค้นหาหมวดข่าว', 'ayam-bangkok'),
            'not_found'                  => __('ไม่พบหมวดข่าว', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
            'rest_base'                  => 'news-categories',
            'rewrite'                    => array('slug' => 'news-category', 'with_front' => false),
        );
        
        register_taxonomy('news_category', array('ayam_news'), $args);
    }
    
    /**
     * Register Knowledge Category Taxonomy
     */
    private function register_knowledge_category_taxonomy() {
        $labels = array(
            'name'                       => __('หมวดความรู้', 'ayam-bangkok'),
            'singular_name'              => __('หมวดความรู้', 'ayam-bangkok'),
            'menu_name'                  => __('หมวดความรู้', 'ayam-bangkok'),
            'all_items'                  => __('หมวดความรู้ทั้งหมด', 'ayam-bangkok'),
            'new_item_name'              => __('ชื่อหมวดความรู้ใหม่', 'ayam-bangkok'),
            'add_new_item'               => __('เพิ่มหมวดความรู้ใหม่', 'ayam-bangkok'),
            'edit_item'                  => __('แก้ไขหมวดความรู้', 'ayam-bangkok'),
            'update_item'                => __('อัพเดทหมวดความรู้', 'ayam-bangkok'),
            'view_item'                  => __('ดูหมวดความรู้', 'ayam-bangkok'),
            'search_items'               => __('ค้นหาหมวดความรู้', 'ayam-bangkok'),
            'not_found'                  => __('ไม่พบหมวดความรู้', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'show_in_rest'               => true,
            'rest_base'                  => 'knowledge-categories',
            'rewrite'                    => array('slug' => 'knowledge-category', 'with_front' => false),
        );
        
        register_taxonomy('knowledge_category', array('ayam_knowledge'), $args);
    }
}