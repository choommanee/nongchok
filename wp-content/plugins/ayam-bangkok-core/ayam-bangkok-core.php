<?php
/**
 * Plugin Name: Ayam Bangkok Core
 * Plugin URI: https://ayambangkok.com
 * Description: Core functionality for Ayam Bangkok website - Custom Post Types, Taxonomies, and Business Logic
 * Version: 1.0.0
 * Author: Ayam Bangkok Team
 * Text Domain: ayam-bangkok
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('AYAM_PLUGIN_VERSION', '1.0.0');
define('AYAM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AYAM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('AYAM_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Ayam Bangkok Core Class
 */
class AyamBangkokCore {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        
        // Activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load required files
        $this->load_includes();
        
        // Register custom post types
        $this->register_post_types();
        
        // Register custom taxonomies
        $this->register_taxonomies();
        
        // Add custom user roles
        $this->add_custom_roles();
        
        // Initialize About Admin
        if (is_admin() && class_exists('AyamAboutAdmin')) {
            new AyamAboutAdmin();
        }
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        
        // Debug: Check if post types are registered (remove this later)
        add_action('admin_notices', array($this, 'debug_post_types'));
    }
    
    /**
     * Debug function to check post types
     */
    public function debug_post_types() {
        if (current_user_can('manage_options')) {
            $post_types = get_post_types(array('public' => true), 'names');
            $ayam_types = array_filter($post_types, function($type) {
                return strpos($type, 'ayam_') === 0;
            });
            
            // Temporarily disabled to prevent headers already sent error
            // if (empty($ayam_types)) {
            //     echo '<div class="notice notice-warning"><p><strong>Ayam Bangkok:</strong> Custom post types not registered yet. Check plugin activation.</p></div>';
            // } else {
            //     echo '<div class="notice notice-success"><p><strong>Ayam Bangkok:</strong> Found post types: ' . implode(', ', $ayam_types) . '</p></div>';
            // }
        }
    }
    
    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain('ayam-bangkok', false, dirname(AYAM_PLUGIN_BASENAME) . '/languages');
    }
    
    /**
     * Load required files
     */
    private function load_includes() {
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-post-types.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-taxonomies.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-user-roles.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-database.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-about-database.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-about-admin.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-db-helpers.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-api.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-acf-fields.php';
        require_once AYAM_PLUGIN_PATH . 'includes/class-ayam-meta-boxes.php';
        require_once AYAM_PLUGIN_PATH . 'includes/ayam-functions.php';
    }
    
    /**
     * Register custom post types
     */
    private function register_post_types() {
        // Register directly to ensure they work
        $this->register_rooster_post_type();
        $this->register_service_post_type();
        $this->register_news_post_type();
        $this->register_knowledge_post_type();
        
        // Also instantiate the class if it exists
        if (class_exists('AyamPostTypes')) {
            new AyamPostTypes();
        }
    }
    
    /**
     * Register custom taxonomies
     */
    private function register_taxonomies() {
        // Register directly to ensure they work
        $this->register_rooster_taxonomies();
        
        // Also instantiate the class if it exists
        if (class_exists('AyamTaxonomies')) {
            new AyamTaxonomies();
        }
    }
    
    /**
     * Add custom user roles
     */
    private function add_custom_roles() {
        if (class_exists('AyamUserRoles')) {
            new AyamUserRoles();
        }
    }
    
    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_script('ayam-frontend', AYAM_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), AYAM_PLUGIN_VERSION, true);
        wp_enqueue_style('ayam-frontend', AYAM_PLUGIN_URL . 'assets/css/frontend.css', array(), AYAM_PLUGIN_VERSION);
        
        // Localize script for AJAX
        wp_localize_script('ayam-frontend', 'ayam_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ayam_nonce'),
            'strings' => array(
                'loading' => __('กำลังโหลด...', 'ayam-bangkok'),
                'error' => __('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'ayam-bangkok'),
                'success' => __('สำเร็จ', 'ayam-bangkok')
            )
        ));
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function admin_enqueue_scripts() {
        wp_enqueue_script('ayam-admin', AYAM_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), AYAM_PLUGIN_VERSION, true);
        wp_enqueue_style('ayam-admin', AYAM_PLUGIN_URL . 'assets/css/admin.css', array(), AYAM_PLUGIN_VERSION);
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Load required files first
        $this->load_includes();
        
        // Register post types and taxonomies first
        $this->register_post_types();
        $this->register_taxonomies();
        
        // Create custom database tables
        if (class_exists('AyamDatabase')) {
            AyamDatabase::create_tables();
        }
        
        // Create About page database tables
        if (class_exists('AyamAboutDatabase')) {
            AyamAboutDatabase::create_about_tables();
        }
        
        // Add custom user roles
        if (class_exists('AyamUserRoles')) {
            AyamUserRoles::add_roles();
        }
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Set plugin version
        update_option('ayam_plugin_version', AYAM_PLUGIN_VERSION);
        
        // Log activation
        error_log('Ayam Bangkok Core Plugin activated successfully');
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Register rooster post type directly
     */
    private function register_rooster_post_type() {
        $labels = array(
            'name' => __('ไก่ชน', 'ayam-bangkok'),
            'singular_name' => __('ไก่ชน', 'ayam-bangkok'),
            'menu_name' => __('ไก่ชน', 'ayam-bangkok'),
            'add_new' => __('เพิ่มใหม่', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มไก่ชนใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขไก่ชน', 'ayam-bangkok'),
            'new_item' => __('ไก่ชนใหม่', 'ayam-bangkok'),
            'view_item' => __('ดูไก่ชน', 'ayam-bangkok'),
            'search_items' => __('ค้นหาไก่ชน', 'ayam-bangkok'),
            'not_found' => __('ไม่พบไก่ชน', 'ayam-bangkok'),
            'all_items' => __('ไก่ชนทั้งหมด', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-pets',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'taxonomies' => array('rooster_breed', 'rooster_category'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'rooster'),
            'show_in_rest' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
        );
        
        register_post_type('ayam_rooster', $args);
    }
    
    /**
     * Register service post type directly
     */
    private function register_service_post_type() {
        $labels = array(
            'name' => __('บริการ', 'ayam-bangkok'),
            'singular_name' => __('บริการ', 'ayam-bangkok'),
            'menu_name' => __('บริการ', 'ayam-bangkok'),
            'add_new' => __('เพิ่มใหม่', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มบริการใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขบริการ', 'ayam-bangkok'),
            'all_items' => __('บริการทั้งหมด', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 21,
            'menu_icon' => 'dashicons-admin-tools',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'taxonomies' => array('service_category'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'service'),
            'show_in_rest' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
        );
        
        register_post_type('ayam_service', $args);
    }
    
    /**
     * Register news post type directly
     */
    private function register_news_post_type() {
        $labels = array(
            'name' => __('ข่าวสาร', 'ayam-bangkok'),
            'singular_name' => __('ข่าว', 'ayam-bangkok'),
            'menu_name' => __('ข่าวสาร', 'ayam-bangkok'),
            'add_new' => __('เพิ่มใหม่', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มข่าวใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขข่าว', 'ayam-bangkok'),
            'all_items' => __('ข่าวทั้งหมด', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 22,
            'menu_icon' => 'dashicons-megaphone',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields'),
            'taxonomies' => array('news_category'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'news'),
            'show_in_rest' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
        );
        
        register_post_type('ayam_news', $args);
    }
    
    /**
     * Register knowledge post type directly
     */
    private function register_knowledge_post_type() {
        $labels = array(
            'name' => __('ศูนย์ความรู้', 'ayam-bangkok'),
            'singular_name' => __('บทความ', 'ayam-bangkok'),
            'menu_name' => __('ศูนย์ความรู้', 'ayam-bangkok'),
            'add_new' => __('เพิ่มใหม่', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มบทความใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขบทความ', 'ayam-bangkok'),
            'all_items' => __('บทความทั้งหมด', 'ayam-bangkok'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 23,
            'menu_icon' => 'dashicons-book-alt',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields'),
            'taxonomies' => array('knowledge_category'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'knowledge'),
            'show_in_rest' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
        );
        
        register_post_type('ayam_knowledge', $args);
    }
    
    /**
     * Register rooster taxonomies directly
     */
    private function register_rooster_taxonomies() {
        // Rooster Breed Taxonomy
        $breed_labels = array(
            'name' => __('สายพันธุ์ไก่', 'ayam-bangkok'),
            'singular_name' => __('สายพันธุ์', 'ayam-bangkok'),
            'menu_name' => __('สายพันธุ์ไก่', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มสายพันธุ์ใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขสายพันธุ์', 'ayam-bangkok'),
        );
        
        register_taxonomy('rooster_breed', array('ayam_rooster'), array(
            'labels' => $breed_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'rooster-breed'),
        ));
        
        // Rooster Category Taxonomy
        $category_labels = array(
            'name' => __('หมวดหมู่ไก่', 'ayam-bangkok'),
            'singular_name' => __('หมวดหมู่', 'ayam-bangkok'),
            'menu_name' => __('หมวดหมู่ไก่', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มหมวดหมู่ใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขหมวดหมู่', 'ayam-bangkok'),
        );
        
        register_taxonomy('rooster_category', array('ayam_rooster'), array(
            'labels' => $category_labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'rooster-category'),
        ));
        
        // Service Category Taxonomy
        $service_labels = array(
            'name' => __('หมวดบริการ', 'ayam-bangkok'),
            'singular_name' => __('หมวดบริการ', 'ayam-bangkok'),
            'menu_name' => __('หมวดบริการ', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มหมวดบริการใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขหมวดบริการ', 'ayam-bangkok'),
        );
        
        register_taxonomy('service_category', array('ayam_service'), array(
            'labels' => $service_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'service-category'),
        ));
        
        // News Category Taxonomy
        $news_labels = array(
            'name' => __('หมวดข่าว', 'ayam-bangkok'),
            'singular_name' => __('หมวดข่าว', 'ayam-bangkok'),
            'menu_name' => __('หมวดข่าว', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มหมวดข่าวใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขหมวดข่าว', 'ayam-bangkok'),
        );
        
        register_taxonomy('news_category', array('ayam_news'), array(
            'labels' => $news_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'news-category'),
        ));
        
        // Knowledge Category Taxonomy
        $knowledge_labels = array(
            'name' => __('หมวดความรู้', 'ayam-bangkok'),
            'singular_name' => __('หมวดความรู้', 'ayam-bangkok'),
            'menu_name' => __('หมวดความรู้', 'ayam-bangkok'),
            'add_new_item' => __('เพิ่มหมวดความรู้ใหม่', 'ayam-bangkok'),
            'edit_item' => __('แก้ไขหมวดความรู้', 'ayam-bangkok'),
        );
        
        register_taxonomy('knowledge_category', array('ayam_knowledge'), array(
            'labels' => $knowledge_labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'knowledge-category'),
        ));
    }
}

// Initialize the plugin
new AyamBangkokCore();