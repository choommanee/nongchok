<?php
/**
 * Ayam Bangkok Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('AYAM_THEME_VERSION', '1.3.3');
define('AYAM_THEME_URI', get_template_directory_uri());
define('AYAM_THEME_PATH', get_template_directory());

/**
 * Theme setup
 */
function ayam_theme_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));
    add_theme_support('custom-header');
    add_theme_support('custom-background');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Add image sizes
    add_image_size('rooster-card', 400, 300, true);
    add_image_size('rooster-hero', 800, 600, true);
    add_image_size('news-card', 350, 250, true);
    add_image_size('service-card', 300, 200, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('เมนูหลัก', 'ayam-bangkok'),
        'footer' => __('เมนูท้ายเพจ', 'ayam-bangkok'),
        'mobile' => __('เมนูมือถือ', 'ayam-bangkok'),
    ));

    // Load text domain
    load_theme_textdomain('ayam-bangkok', AYAM_THEME_PATH . '/languages');
}
add_action('after_setup_theme', 'ayam_theme_setup');

/**
 * Enqueue scripts and styles
 */
function ayam_theme_scripts()
{
    // Styles - Don't load main style.css on About, Service, News, and Gallery pages (it conflicts with Wix design)
    if (!is_page('about') && !is_page(27) && !is_page('service') && !is_page(251) && !is_page('news-1') && !is_page(168) && !is_page('gallery') && !is_page(253)) {
        wp_enqueue_style('ayam-style', get_stylesheet_uri(), array(), AYAM_THEME_VERSION);
    }
    // Don't load Google Fonts on About, Service, News, and Gallery pages (they use Avenir/Helvetica)
    if (!is_page('about') && !is_page(27) && !is_page('service') && !is_page(251) && !is_page('news-1') && !is_page(168) && !is_page('gallery') && !is_page(253)) {
        wp_enqueue_style('ayam-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Serif:wght@300;400;500;600;700;800&family=Prompt:wght@300;400;500;600;700;800&family=Kanit:wght@300;400;500;600;700;800&display=swap', array(), null);
    }

    // Inter Font (Helvetica alternative for Wix-style pages)
    wp_enqueue_style('inter-font', AYAM_THEME_URI . '/assets/fonts/inter.css', array(), AYAM_THEME_VERSION);

    // Font Awesome - Load from local file
    wp_enqueue_style('font-awesome', AYAM_THEME_URI . '/assets/fonts/fontawesome.css', array(), AYAM_THEME_VERSION . '.' . time());

    // Modern Frontend Libraries
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), '8.4.7');
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');

    // Enhanced Slider Styles
    wp_enqueue_style('ayam-slider-animations', AYAM_THEME_URI . '/assets/css/slider-animations.css', array('ayam-style'), AYAM_THEME_VERSION);

    // Emergency Slider Fix - High Priority
    wp_enqueue_style('ayam-slider-emergency-fix', AYAM_THEME_URI . '/assets/css/slider-emergency-fix.css', array(), AYAM_THEME_VERSION, 'all');

    // Responsive CSS - Mobile First Approach
    wp_enqueue_style('ayam-responsive', AYAM_THEME_URI . '/assets/css/responsive.css', array('ayam-style'), AYAM_THEME_VERSION, 'all');

    // Advanced Rooster Catalog Styles
    wp_enqueue_style('ayam-roosters-advanced', AYAM_THEME_URI . '/assets/css/roosters-advanced.css', array('ayam-style'), AYAM_THEME_VERSION);

    // Scripts
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), '8.4.7', true);
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);
    wp_enqueue_script('ayam-theme-js', AYAM_THEME_URI . '/assets/js/theme.js', array('jquery', 'swiper-js', 'aos-js'), AYAM_THEME_VERSION . '.' . time(), true);

    // Advanced Rooster Catalog JavaScript
    wp_enqueue_script('ayam-roosters-advanced', AYAM_THEME_URI . '/assets/js/roosters.js', array('jquery'), AYAM_THEME_VERSION . '.' . time(), true);
    // Gallery Page JavaScript and CSS
    if (is_page_template('page-gallery.php')) {
        wp_enqueue_style('ayam-gallery', AYAM_THEME_URI . '/assets/css/gallery.css', array('ayam-style'), AYAM_THEME_VERSION);
        wp_enqueue_script('ayam-gallery', AYAM_THEME_URI . '/assets/js/gallery.js', array('jquery'), AYAM_THEME_VERSION, true);
    }
    
    // Rooster Gallery Wix Style CSS
    if (is_page_template('page-rooster-gallery-wix.php') || is_singular('rooster_catalog')) {
        wp_enqueue_style('rooster-gallery-wix', AYAM_THEME_URI . '/assets/css/rooster-gallery-wix.css', array('ayam-style'), AYAM_THEME_VERSION);
    }
    
    // Wix Style Homepage CSS - Complete redesign (also load on About, Service, News, Gallery, Contact, Knowledge, Single News, News archive, Rooster archive and single rooster pages for consistent header/footer)
    if (is_front_page() || is_page('about') || is_page(27) || is_page('service') || is_page(251) || is_page('news-1') || is_page(168) || is_page('gallery') || is_page(253) || is_page_template('page-contact-wix.php') || is_page('contact') || is_page_template('page-knowledge.php') || is_singular('ayam_news') || is_post_type_archive('ayam_news') || is_post_type_archive('ayam_rooster') || is_singular('ayam_rooster')) {
        wp_enqueue_style('wix-homepage-complete', AYAM_THEME_URI . '/assets/css/wix-homepage-complete.css', array(), AYAM_THEME_VERSION);
        wp_enqueue_script('wix-homepage-js', AYAM_THEME_URI . '/assets/js/wix-homepage.js', array('jquery', 'swiper-js', 'aos-js'), AYAM_THEME_VERSION, true);
    }

    // Rooster Archive Wix Style CSS
    if (is_post_type_archive('ayam_rooster')) {
        wp_enqueue_style('rooster-wix-style', AYAM_THEME_URI . '/assets/css/rooster-wix-style.css', array('wix-homepage-complete'), AYAM_THEME_VERSION);
    }

    // Single Rooster Wix Style CSS
    if (is_singular('ayam_rooster')) {
        wp_enqueue_style('single-rooster-wix', AYAM_THEME_URI . '/assets/css/single-rooster-wix.css', array('wix-homepage-complete'), AYAM_THEME_VERSION);
    }

    // About Page CSS
    if (is_page_template('page-about.php') || is_page('about') || is_page('about-us') || is_page(27)) {
        wp_enqueue_style('wix-all-pages', AYAM_THEME_URI . '/assets/css/wix-all-pages.css', array(), AYAM_THEME_VERSION);
        wp_enqueue_style('about-page', AYAM_THEME_URI . '/assets/css/about.css', array(), AYAM_THEME_VERSION);
    }

    // Service Page CSS - Load after wix-homepage-complete to ensure font overrides work
    // Also use for News, Gallery, Contact, and Single News pages since they share the same design
    if (is_page_template('page-service.php') || is_page('service') || is_page_template('page-news-wix.php') || is_page('news-1') || is_page(168) || is_page_template('page-gallery-wix.php') || is_page('gallery') || is_page(253) || is_page_template('page-contact-wix.php') || is_page('contact') || is_singular('ayam_news')) {
        wp_enqueue_style('wix-all-pages', AYAM_THEME_URI . '/assets/css/wix-all-pages.css', array(), AYAM_THEME_VERSION . '.' . time());
        wp_enqueue_style('service-page', AYAM_THEME_URI . '/assets/css/service.css', array('wix-homepage-complete'), AYAM_THEME_VERSION . '.' . time());
    }

    // News System CSS and JS
    if (is_post_type_archive('ayam_news') || is_singular('ayam_news')) {
        wp_enqueue_style('ayam-news', AYAM_THEME_URI . '/assets/css/news.css', array('ayam-style'), AYAM_THEME_VERSION);
        wp_enqueue_script('ayam-news', AYAM_THEME_URI . '/assets/js/news.js', array('jquery'), AYAM_THEME_VERSION, true);
    }

    // Slider Fix Script - TEMPORARILY DISABLED FOR TESTING
    // wp_enqueue_script('ayam-slider-fix', AYAM_THEME_URI . '/assets/js/slider-fix.js', array('swiper-js'), AYAM_THEME_VERSION, true);

    // Localize script
    wp_localize_script('ayam-theme-js', 'ayam_theme', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ayam_theme_nonce'),
        'strings' => array(
            'loading' => __('กำลังโหลด...', 'ayam-bangkok'),
            'error' => __('เกิดข้อผิดพลาด', 'ayam-bangkok'),
            'success' => __('สำเร็จ', 'ayam-bangkok'),
            'close' => __('ปิด', 'ayam-bangkok'),
            'more' => __('ดูเพิ่มเติม', 'ayam-bangkok'),
        )
    ));

    // Localize advanced rooster catalog script
    wp_localize_script('ayam-roosters-advanced', 'rooster_catalog_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('rooster_catalog_nonce'),
        'strings' => array(
            'loading' => __('กำลังโหลด...', 'ayam-bangkok'),
            'no_results' => __('ไม่พบผลลัพธ์', 'ayam-bangkok'),
            'error' => __('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'ayam-bangkok'),
            'added_to_compare' => __('เพิ่มในรายการเปรียบเทียบแล้ว', 'ayam-bangkok'),
            'removed_from_compare' => __('ลบออกจากรายการเปรียบเทียบแล้ว', 'ayam-bangkok'),
            'max_compare_reached' => __('สามารถเปรียบเทียบได้สูงสุด 3 รายการ', 'ayam-bangkok'),
            'added_to_favorites' => __('เพิ่มในรายการโปรดแล้ว', 'ayam-bangkok'),
            'removed_from_favorites' => __('ลบออกจากรายการโปรดแล้ว', 'ayam-bangkok'),
            'share_success' => __('คัดลอกลิงก์แล้ว', 'ayam-bangkok'),
            'confirm_clear_filters' => __('ต้องการล้างตัวกรองทั้งหมดหรือไม่?', 'ayam-bangkok')
        )
    ));

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ayam_theme_scripts');

/**
 * Register widget areas
 */
function ayam_widgets_init()
{
    register_sidebar(array(
        'name' => __('แถบข้าง', 'ayam-bangkok'),
        'id' => 'sidebar-1',
        'description' => __('แถบข้างหลัก', 'ayam-bangkok'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('ท้ายเพจ 1', 'ayam-bangkok'),
        'id' => 'footer-1',
        'description' => __('พื้นที่วิดเจ็ตท้ายเพจ คอลัมน์ที่ 1', 'ayam-bangkok'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('ท้ายเพจ 2', 'ayam-bangkok'),
        'id' => 'footer-2',
        'description' => __('พื้นที่วิดเจ็ตท้ายเพจ คอลัมน์ที่ 2', 'ayam-bangkok'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('ท้ายเพจ 3', 'ayam-bangkok'),
        'id' => 'footer-3',
        'description' => __('พื้นที่วิดเจ็ตท้ายเพจ คอลัมน์ที่ 3', 'ayam-bangkok'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('ท้ายเพจ 4', 'ayam-bangkok'),
        'id' => 'footer-4',
        'description' => __('พื้นที่วิดเจ็ตท้ายเพจ คอลัมน์ที่ 4', 'ayam-bangkok'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'ayam_widgets_init');

/**
 * Custom excerpt length
 */
function ayam_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'ayam_excerpt_length');

/**
 * Custom excerpt more
 */
function ayam_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'ayam_excerpt_more');

/**
 * Add custom body classes
 */
function ayam_body_classes($classes)
{
    // Add page slug class
    if (is_page()) {
        global $post;
        $classes[] = 'page-' . $post->post_name;
    }

    // Add post type class
    if (is_singular()) {
        global $post;
        $classes[] = 'single-' . $post->post_type;
    }

    // Add archive class for custom post types
    if (is_post_type_archive()) {
        $classes[] = 'archive-' . get_post_type();
    }

    return $classes;
}
add_filter('body_class', 'ayam_body_classes');

/**
 * Customize login page
 */
function ayam_login_logo()
{
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        ?>
        <style type="text/css">
            #login h1 a,
            .login h1 a {
                background-image: url(<?php echo esc_url($logo[0]); ?>);
                height: 80px;
                width: 200px;
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 30px;
            }
        </style>
        <?php
    }
}
add_action('login_enqueue_scripts', 'ayam_login_logo');

/**
 * Change login logo URL
 */
function ayam_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'ayam_login_logo_url');

/**
 * Change login logo title
 */
function ayam_login_logo_url_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'ayam_login_logo_url_title'); // Updated from login_headertitle (deprecated in WP 5.2)

/**
 * Add custom CSS for admin area
 */
function ayam_admin_styles()
{
    wp_enqueue_style('ayam-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css', array(), AYAM_THEME_VERSION);
}
add_action('admin_enqueue_scripts', 'ayam_admin_styles');

/**
 * Optimize database queries
 */
function ayam_optimize_queries()
{
    // Remove unnecessary queries
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // Disable emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'ayam_optimize_queries');

/**
 * Add security headers
 */
function ayam_security_headers()
{
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'ayam_security_headers');

/**
 * Add custom post states
 */
function ayam_custom_post_states($post_states, $post)
{
    if (get_option('page_on_front') == $post->ID) {
        $post_states['front_page'] = 'หน้าแรก';
    }

    if (get_option('page_for_posts') == $post->ID) {
        $post_states['posts_page'] = 'หน้าบล็อก';
    }

    return $post_states;
}
add_filter('display_post_states', 'ayam_custom_post_states', 10, 2);

/**
 * Add custom mime types
 */
function ayam_custom_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'ayam_custom_mime_types');

/**
 * Add theme update checker (if needed)
 */
function ayam_check_for_updates()
{
    $current_version = wp_get_theme()->get('Version');
    $remote_version = wp_remote_get('https://api.ayam-bangkok.com/theme-version');

    if (!is_wp_error($remote_version)) {
        $version_data = json_decode(wp_remote_retrieve_body($remote_version), true);
        if (version_compare($current_version, $version_data['version'], '<')) {
            add_action('admin_notices', function () use ($version_data) {
                echo '<div class="notice notice-info"><p>มีเวอร์ชันใหม่ของธีม Ayam Bangkok (' . $version_data['version'] . ') พร้อมให้อัปเดต</p></div>';
            });
        }
    }
}
// Uncomment the line below to enable update checking
// add_action('admin_init', 'ayam_check_for_updates');

/**
 * Final theme initialization
 */
function ayam_theme_final_init()
{
    // Flush rewrite rules if needed
    if (get_option('ayam_flush_rewrite_rules')) {
        flush_rewrite_rules();
        delete_option('ayam_flush_rewrite_rules');
    }

    // Set default options if not set
    $default_options = array(
        'ayam_slider_autoplay' => 1,
        'ayam_slider_autoplay_speed' => 5000,
        'ayam_slider_show_navigation' => 1,
        'ayam_slider_show_pagination' => 1,
        'ayam_slider_height' => '100vh'
    );

    foreach ($default_options as $option => $default_value) {
        if (get_option($option) === false) {
            update_option($option, $default_value);
        }
    }
}
add_action('init', 'ayam_theme_final_init', 999);

/**
 * Theme deactivation cleanup
 */
function ayam_theme_deactivation()
{
    // Clean up temporary options
    delete_option('ayam_pages_created');
    delete_option('ayam_flush_rewrite_rules');

    // Flush rewrite rules
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'ayam_theme_deactivation');

/**
 * Add theme customizer options
 */
function ayam_customize_register($wp_customize)
{
    // Company Info Section
    $wp_customize->add_section('ayam_company_info', array(
        'title' => __('ข้อมูลบริษัท', 'ayam-bangkok'),
        'priority' => 30,
    ));

    // Phone Number
    $wp_customize->add_setting('ayam_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('ayam_phone', array(
        'label' => __('เบอร์โทรศัพท์', 'ayam-bangkok'),
        'section' => 'ayam_company_info',
        'type' => 'text',
    ));

    // Email
    $wp_customize->add_setting('ayam_email', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('ayam_email', array(
        'label' => __('อีเมล', 'ayam-bangkok'),
        'section' => 'ayam_company_info',
        'type' => 'email',
    ));

    // Line ID
    $wp_customize->add_setting('ayam_line_id', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('ayam_line_id', array(
        'label' => __('Line ID', 'ayam-bangkok'),
        'section' => 'ayam_company_info',
        'type' => 'text',
    ));

    // Facebook URL
    $wp_customize->add_setting('ayam_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('ayam_facebook', array(
        'label' => __('Facebook URL', 'ayam-bangkok'),
        'section' => 'ayam_company_info',
        'type' => 'url',
    ));

    // YouTube URL
    $wp_customize->add_setting('ayam_youtube', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('ayam_youtube', array(
        'label' => __('YouTube URL', 'ayam-bangkok'),
        'section' => 'ayam_company_info',
        'type' => 'url',
    ));

    // Hero section
    $wp_customize->add_section('ayam_hero_section', array(
        'title' => __('ส่วน Hero', 'ayam-bangkok'),
        'priority' => 35,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default' => __('ยินดีต้อนรับสู่ Ayam Bangkok', 'ayam-bangkok'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label' => __('หัวข้อหลัก', 'ayam-bangkok'),
        'section' => 'ayam_hero_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default' => __('ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย', 'ayam-bangkok'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('หัวข้อรอง', 'ayam-bangkok'),
        'section' => 'ayam_hero_section',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('hero_background_image', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('รูปพื้นหลัง Hero', 'ayam-bangkok'),
        'section' => 'ayam_hero_section',
    )));
}
add_action('customize_register', 'ayam_customize_register');

// Removed duplicate function - using the more complete version below

/**
 * Add admin bar menu for quick access
 */
function ayam_admin_bar_menu($wp_admin_bar)
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $wp_admin_bar->add_menu(array(
        'id' => 'ayam-quick-links',
        'title' => '🐓 Ayam Bangkok',
        'href' => admin_url('edit.php?post_type=ayam_rooster'),
    ));

    $wp_admin_bar->add_menu(array(
        'parent' => 'ayam-quick-links',
        'id' => 'ayam-roosters',
        'title' => 'ไก่ชน',
        'href' => admin_url('edit.php?post_type=ayam_rooster'),
    ));

    $wp_admin_bar->add_menu(array(
        'parent' => 'ayam-quick-links',
        'id' => 'ayam-services',
        'title' => 'บริการ',
        'href' => admin_url('edit.php?post_type=ayam_service'),
    ));

    $wp_admin_bar->add_menu(array(
        'parent' => 'ayam-quick-links',
        'id' => 'ayam-news',
        'title' => 'ข่าวสาร',
        'href' => admin_url('edit.php?post_type=ayam_news'),
    ));
}
add_action('admin_bar_menu', 'ayam_admin_bar_menu', 999);

/**
 * Include template parts
 */
require_once AYAM_THEME_PATH . '/inc/template-functions.php';

/**
 * Customizer additions
 */
require_once AYAM_THEME_PATH . '/inc/customizer.php';

/**
 * Company Info Admin Interface
 */
require_once AYAM_THEME_PATH . '/inc/admin-company-info.php';

/**
 * Load theme modules
 */
if (file_exists(AYAM_THEME_PATH . '/inc/rooster-functions.php')) {
    require_once AYAM_THEME_PATH . '/inc/rooster-functions.php';
}

if (file_exists(AYAM_THEME_PATH . '/inc/ajax-handlers.php')) {
    require_once AYAM_THEME_PATH . '/inc/ajax-handlers.php';
}/**

* Homepage helper functions
*/

// AJAX handler for quick contact form
function ayam_handle_quick_contact()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['quick_contact_nonce'], 'ayam_quick_contact')) {
        wp_die(__('Security check failed', 'ayam-bangkok'));
    }

    // Sanitize input
    $name = sanitize_text_field($_POST['contact_name']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $email = sanitize_email($_POST['contact_email']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(__('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok'));
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(__('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok'));
    }

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_inquiries';

    $result = $wpdb->insert(
        $table_name,
        array(
            'inquiry_type' => 'quick_contact',
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => 'new',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(__('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'ayam-bangkok'));
    }

    // Send email notification
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = sprintf('[%s] ข้อความใหม่จาก %s', $site_name, $name);
    $email_message = sprintf(
        "มีข้อความใหม่จากเว็บไซต์\n\n" .
        "ชื่อ: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n" .
        "หัวข้อ: %s\n\n" .
        "ข้อความ:\n%s\n\n" .
        "เวลา: %s",
        $name,
        $email,
        $phone,
        $subject,
        $message,
        current_time('Y-m-d H:i:s')
    );

    wp_mail($admin_email, $email_subject, $email_message);

    wp_send_json_success(__('ส่งข้อความสำเร็จ เราจะติดต่อกลับโดยเร็วที่สุด', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_quick_contact', 'ayam_handle_quick_contact');
add_action('wp_ajax_nopriv_ayam_quick_contact', 'ayam_handle_quick_contact');

// AJAX handler for rooster inquiry
function ayam_handle_rooster_inquiry()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_theme_nonce')) {
        wp_send_json_error(__('Security check failed', 'ayam-bangkok'));
    }

    // Sanitize input
    $rooster_id = intval($_POST['rooster_id']);
    $name = sanitize_text_field($_POST['inquiry_name']);
    $phone = sanitize_text_field($_POST['inquiry_phone']);
    $email = sanitize_email($_POST['inquiry_email']);
    $message = sanitize_textarea_field($_POST['inquiry_message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message) || empty($rooster_id)) {
        wp_send_json_error(__('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok'));
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(__('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok'));
    }

    // Check if rooster exists
    $rooster = get_post($rooster_id);
    if (!$rooster || $rooster->post_type !== 'ayam_rooster') {
        wp_send_json_error(__('ไม่พบข้อมูลไก่ชนที่ระบุ', 'ayam-bangkok'));
    }

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_inquiries';

    $result = $wpdb->insert(
        $table_name,
        array(
            'inquiry_type' => 'rooster_inquiry',
            'rooster_id' => $rooster_id,
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'subject' => sprintf(__('สอบถามไก่ชน: %s', 'ayam-bangkok'), $rooster->post_title),
            'message' => $message,
            'status' => 'new',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(__('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'ayam-bangkok'));
    }

    // Send email notification
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = sprintf('[%s] สอบถามไก่ชน: %s', $site_name, $rooster->post_title);
    $email_message = sprintf(
        "มีการสอบถามไก่ชนใหม่\n\n" .
        "ไก่ชน: %s\n" .
        "ลิงก์: %s\n\n" .
        "ผู้สอบถาม: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n\n" .
        "ข้อความ:\n%s\n\n" .
        "เวลา: %s",
        $rooster->post_title,
        get_permalink($rooster_id),
        $name,
        $email,
        $phone,
        $message,
        current_time('Y-m-d H:i:s')
    );

    wp_mail($admin_email, $email_subject, $email_message);

    wp_send_json_success(__('ส่งข้อความสำเร็จ เราจะติดต่อกลับโดยเร็วที่สุด', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_rooster_inquiry', 'ayam_handle_rooster_inquiry');
add_action('wp_ajax_nopriv_ayam_rooster_inquiry', 'ayam_handle_rooster_inquiry');

// Removed duplicate customizer function - merged with the main one above

/**
 * About page helper functions
 */



// Add ACF fields for About page
function ayam_add_about_page_fields()
{
    if (function_exists('acf_add_local_field_group')) {

        // Company Information Fields
        acf_add_local_field_group(array(
            'key' => 'group_company_info',
            'title' => 'ข้อมูลบริษัท',
            'fields' => array(
                array(
                    'key' => 'field_company_name',
                    'label' => 'ชื่อบริษัท',
                    'name' => 'company_name',
                    'type' => 'text',
                    'default_value' => 'Ayam Bangkok',
                ),
                array(
                    'key' => 'field_company_description',
                    'label' => 'คำอธิบายบริษัท',
                    'name' => 'company_description',
                    'type' => 'textarea',
                    'rows' => 4,
                ),
                array(
                    'key' => 'field_company_main_image',
                    'label' => 'รูปภาพหลักบริษัท',
                    'name' => 'company_main_image',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_company_vision',
                    'label' => 'วิสัยทัศน์',
                    'name' => 'company_vision',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_company_mission',
                    'label' => 'พันธกิจ',
                    'name' => 'company_mission',
                    'type' => 'textarea',
                    'rows' => 4,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-company-settings',
                    ),
                ),
            ),
        ));

        // Timeline Fields
        acf_add_local_field_group(array(
            'key' => 'group_company_timeline',
            'title' => 'ประวัติบริษัท',
            'fields' => array(
                array(
                    'key' => 'field_timeline_items',
                    'label' => 'เหตุการณ์สำคัญ',
                    'name' => 'timeline_items',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_timeline_year',
                            'label' => 'ปี',
                            'name' => 'year',
                            'type' => 'text',
                            'wrapper' => array('width' => '20'),
                        ),
                        array(
                            'key' => 'field_timeline_title',
                            'label' => 'หัวข้อ',
                            'name' => 'title',
                            'type' => 'text',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_timeline_description',
                            'label' => 'รายละเอียด',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 2,
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_timeline_image',
                            'label' => 'รูปภาพ',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'url',
                        ),
                    ),
                    'button_label' => 'เพิ่มเหตุการณ์',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-company-settings',
                    ),
                ),
            ),
        ));

        // Awards Fields
        acf_add_local_field_group(array(
            'key' => 'group_company_awards',
            'title' => 'รางวัลและความสำเร็จ',
            'fields' => array(
                array(
                    'key' => 'field_awards_items',
                    'label' => 'รางวัล',
                    'name' => 'awards_items',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_award_title',
                            'label' => 'ชื่อรางวัล',
                            'name' => 'title',
                            'type' => 'text',
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_award_year',
                            'label' => 'ปี',
                            'name' => 'year',
                            'type' => 'text',
                            'wrapper' => array('width' => '20'),
                        ),
                        array(
                            'key' => 'field_award_description',
                            'label' => 'รายละเอียด',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 2,
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_award_image',
                            'label' => 'รูปภาพรางวัล',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'url',
                        ),
                    ),
                    'button_label' => 'เพิ่มรางวัล',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-company-settings',
                    ),
                ),
            ),
        ));

        // Team Members Fields
        acf_add_local_field_group(array(
            'key' => 'group_team_members',
            'title' => 'ทีมงาน',
            'fields' => array(
                array(
                    'key' => 'field_team_members',
                    'label' => 'สมาชิกทีม',
                    'name' => 'team_members',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_member_name',
                            'label' => 'ชื่อ',
                            'name' => 'name',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_member_position',
                            'label' => 'ตำแหน่ง',
                            'name' => 'position',
                            'type' => 'text',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_member_description',
                            'label' => 'รายละเอียด',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 2,
                            'wrapper' => array('width' => '40'),
                        ),
                        array(
                            'key' => 'field_member_image',
                            'label' => 'รูปภาพ',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'url',
                        ),
                        array(
                            'key' => 'field_member_email',
                            'label' => 'อีเมล',
                            'name' => 'email',
                            'type' => 'email',
                            'wrapper' => array('width' => '50'),
                        ),
                        array(
                            'key' => 'field_member_phone',
                            'label' => 'เบอร์โทร',
                            'name' => 'phone',
                            'type' => 'text',
                            'wrapper' => array('width' => '50'),
                        ),
                    ),
                    'button_label' => 'เพิ่มสมาชิก',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-company-settings',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'ayam_add_about_page_fields');

// Add options page for company settings
function ayam_add_company_options_page()
{
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'ตั้งค่าข้อมูลบริษัท',
            'menu_title' => 'ข้อมูลบริษัท',
            'menu_slug' => 'ayam-company-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-building',
            'position' => 30,
        ));

        // Add Contact Page Options
        acf_add_options_page(array(
            'page_title' => 'ตั้งค่าหน้าติดต่อเรา',
            'menu_title' => 'การติดต่อ',
            'menu_slug' => 'ayam-contact-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-phone',
            'position' => 31,
        ));
    }
}
add_action('acf/init', 'ayam_add_company_options_page');

// Fallback: Add Custom Admin Menu if ACF PRO is not available
function ayam_add_company_admin_menu()
{
    // Only add if ACF Options Page is not available
    if (!function_exists('acf_add_options_page')) {
        add_menu_page(
            'ข้อมูลบริษัท',           // Page title
            'ข้อมูลบริษัท',           // Menu title
            'manage_options',         // Capability
            'ayam-company-settings',  // Menu slug
            'ayam_company_settings_page', // Callback function
            'dashicons-building',     // Icon
            30                        // Position
        );

        add_menu_page(
            'การติดต่อ',              // Page title
            'การติดต่อ',              // Menu title
            'manage_options',         // Capability
            'ayam-contact-settings',  // Menu slug
            'ayam_contact_settings_page', // Callback function
            'dashicons-phone',        // Icon
            31                        // Position
        );
    }
}
add_action('admin_menu', 'ayam_add_company_admin_menu');

// Callback functions for admin pages
function ayam_company_settings_page()
{
    // Enqueue admin styles
    wp_enqueue_style('ayam-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css', array(), AYAM_THEME_VERSION);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

    // Handle form submission
    $message = '';
    $message_type = '';

    if (isset($_POST['submit_company_data'])) {
        if (wp_verify_nonce($_POST['company_nonce'], 'save_company_data')) {
            // Save company data
            $company_data = array(
                'company_name' => sanitize_text_field($_POST['company_name']),
                'company_description' => wp_kses_post($_POST['company_description']),
                'company_vision' => wp_kses_post($_POST['company_vision']),
                'company_mission' => wp_kses_post($_POST['company_mission']),
                'company_main_image' => esc_url_raw($_POST['company_main_image']),
                'company_established_year' => sanitize_text_field($_POST['company_established_year']),
                'company_address' => sanitize_textarea_field($_POST['company_address'])
            );

            update_option('ayam_company_data', $company_data);
            $message = 'บันทึกข้อมูลบริษัทเรียบร้อยแล้ว';
            $message_type = 'success';
        }
    }

    if (isset($_POST['import_about_data'])) {
        if (wp_verify_nonce($_POST['import_nonce'], 'import_about_data')) {
            // Import default data from about page
            $default_data = array(
                'company_name' => 'Ayam Bangkok',
                'company_description' => 'เราเป็นบริษัทชั้นนำในการส่งออกไก่ชนคุณภาพสูงจากประเทศไทยไปยังประเทศอินโดนีเซีย ด้วยประสบการณ์กว่า 10 ปีในธุรกิจนี้ เราได้สร้างความเชื่อมั่นและความไว้วางใจจากลูกค้าทั้งในประเทศและต่างประเทศ',
                'company_vision' => 'เป็นผู้นำในการส่งออกไก่ชนคุณภาพสูงจากประเทศไทยไปยังตลาดโลก โดยยึดมั่นในคุณภาพ ความปลอดภัย และการบริการที่เป็นเลิศ',
                'company_mission' => 'ส่งมอบไก่ชนคุณภาพสูงที่ผ่านการคัดเลือกอย่างเข้มงวด พร้อมบริการครบวงจรตั้งแต่การเลือกสรร การดูแลรักษา ไปจนถึงการส่งมอบที่ปลอดภัย เพื่อสร้างความพึงพอใจสูงสุดให้กับลูกค้า',
                'company_main_image' => '',
                'company_established_year' => '2014',
                'company_address' => 'กรุงเทพมหานคร ประเทศไทย'
            );

            update_option('ayam_company_data', $default_data);
            $message = 'นำเข้าข้อมูลจากหน้า About เรียบร้อยแล้ว';
            $message_type = 'success';
        }
    }

    // Get current data
    $company_data = get_option('ayam_company_data', array());

    ?>
    <div class="ayam-admin-page">
        <div class="ayam-admin-header">
            <h1><i class="fas fa-building"></i> จัดการข้อมูลบริษัท</h1>
            <p>จัดการข้อมูลบริษัทที่แสดงในหน้า About และส่วนต่างๆ ของเว็บไซต์</p>
        </div>

        <?php if ($message): ?>
            <div class="ayam-message ayam-message-<?php echo $message_type; ?>">
                <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Import Section -->
        <div class="ayam-import-section">
            <h3><i class="fas fa-download"></i> นำเข้าข้อมูลจากหน้า About</h3>
            <p>คลิกปุ่มด้านล่างเพื่อนำเข้าข้อมูลเริ่มต้นจากหน้า About ที่ได้ออกแบบไว้</p>
            <form method="post" style="display: inline;">
                <?php wp_nonce_field('import_about_data', 'import_nonce'); ?>
                <button type="submit" name="import_about_data" class="ayam-btn ayam-btn-secondary ayam-btn-large">
                    <i class="fas fa-download"></i> นำเข้าข้อมูล
                </button>
            </form>
        </div>

        <div class="ayam-admin-content">
            <!-- Company Information Form -->
            <div class="ayam-admin-card">
                <h2><i class="fas fa-info-circle"></i> ข้อมูลพื้นฐาน</h2>

                <form method="post">
                    <?php wp_nonce_field('save_company_data', 'company_nonce'); ?>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_name">ชื่อบริษัท</label>
                        <input type="text" id="company_name" name="company_name" class="ayam-form-input"
                            value="<?php echo esc_attr($company_data['company_name'] ?? ''); ?>" placeholder="ชื่อบริษัท">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_description">คำอธิบายบริษัท</label>
                        <textarea id="company_description" name="company_description" class="ayam-form-textarea"
                            placeholder="คำอธิบายเกี่ยวกับบริษัท"><?php echo esc_textarea($company_data['company_description'] ?? ''); ?></textarea>
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_main_image">รูปภาพหลัก</label>
                        <input type="url" id="company_main_image" name="company_main_image" class="ayam-form-input"
                            value="<?php echo esc_attr($company_data['company_main_image'] ?? ''); ?>"
                            placeholder="URL รูปภาพ">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_established_year">ปีที่ก่อตั้ง</label>
                        <input type="text" id="company_established_year" name="company_established_year"
                            class="ayam-form-input"
                            value="<?php echo esc_attr($company_data['company_established_year'] ?? ''); ?>"
                            placeholder="เช่น 2014">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_address">ที่อยู่บริษัท</label>
                        <textarea id="company_address" name="company_address" class="ayam-form-textarea"
                            placeholder="ที่อยู่บริษัท"><?php echo esc_textarea($company_data['company_address'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" name="submit_company_data" class="ayam-btn ayam-btn-primary ayam-btn-large">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </form>
            </div>

            <!-- Vision & Mission Form -->
            <div class="ayam-admin-card">
                <h2><i class="fas fa-eye"></i> วิสัยทัศน์และพันธกิจ</h2>

                <form method="post">
                    <?php wp_nonce_field('save_company_data', 'company_nonce'); ?>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_vision">วิสัยทัศน์</label>
                        <textarea id="company_vision" name="company_vision" class="ayam-form-textarea"
                            placeholder="วิสัยทัศน์ของบริษัท"><?php echo esc_textarea($company_data['company_vision'] ?? ''); ?></textarea>
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="company_mission">พันธกิจ</label>
                        <textarea id="company_mission" name="company_mission" class="ayam-form-textarea"
                            placeholder="พันธกิจของบริษัท"><?php echo esc_textarea($company_data['company_mission'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" name="submit_company_data" class="ayam-btn ayam-btn-primary ayam-btn-large">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </form>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="ayam-admin-card">
            <h2><i class="fas fa-eye"></i> ตัวอย่างการแสดงผล</h2>
            <p>ข้อมูลที่บันทึกจะแสดงในหน้า About และส่วนต่างๆ ของเว็บไซต์</p>

            <?php if (!empty($company_data)): ?>
                <div
                    style="background: var(--bg-section); padding: var(--space-6); border-radius: var(--radius-lg); margin-top: var(--space-4);">
                    <h3 style="color: var(--primary); margin-bottom: var(--space-3);">
                        <?php echo esc_html($company_data['company_name'] ?? 'ชื่อบริษัท'); ?></h3>
                    <p style="margin-bottom: var(--space-4);">
                        <?php echo esc_html($company_data['company_description'] ?? 'คำอธิบายบริษัท'); ?></p>

                    <?php if (!empty($company_data['company_vision'])): ?>
                        <div style="margin-bottom: var(--space-4);">
                            <strong style="color: var(--primary);">วิสัยทัศน์:</strong>
                            <p style="margin-top: var(--space-2);"><?php echo esc_html($company_data['company_vision']); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($company_data['company_mission'])): ?>
                        <div>
                            <strong style="color: var(--primary);">พันธกิจ:</strong>
                            <p style="margin-top: var(--space-2);"><?php echo esc_html($company_data['company_mission']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p style="color: var(--text-secondary); font-style: italic;">ยังไม่มีข้อมูลที่บันทึก
                    กรุณาเพิ่มข้อมูลหรือนำเข้าข้อมูลจากหน้า About</p>
            <?php endif; ?>
        </div>
    </div>

    <style>
        /* Override WordPress admin styles */
        .ayam-admin-page * {
            box-sizing: border-box;
        }

        .ayam-admin-page {
            margin: -20px -20px -10px -2px;
        }
    </style>
    <?php
}

function ayam_contact_settings_page()
{
    // Enqueue admin styles
    wp_enqueue_style('ayam-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css', array(), AYAM_THEME_VERSION);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

    // Handle form submission
    $message = '';
    $message_type = '';

    if (isset($_POST['submit_contact_data'])) {
        if (wp_verify_nonce($_POST['contact_nonce'], 'save_contact_data')) {
            // Save contact data
            $contact_data = array(
                'phone' => sanitize_text_field($_POST['phone']),
                'email' => sanitize_email($_POST['email']),
                'line_id' => sanitize_text_field($_POST['line_id']),
                'facebook' => esc_url_raw($_POST['facebook']),
                'address' => sanitize_textarea_field($_POST['address']),
                'business_hours' => sanitize_text_field($_POST['business_hours']),
                'contact_person' => sanitize_text_field($_POST['contact_person']),
                'whatsapp' => sanitize_text_field($_POST['whatsapp'])
            );

            update_option('ayam_contact_data', $contact_data);
            $message = 'บันทึกข้อมูลการติดต่อเรียบร้อยแล้ว';
            $message_type = 'success';
        }
    }

    if (isset($_POST['import_contact_data'])) {
        if (wp_verify_nonce($_POST['import_nonce'], 'import_contact_data')) {
            // Import default contact data
            $default_data = array(
                'phone' => '+66 2 123 4567',
                'email' => 'info@ayambangkok.com',
                'line_id' => '@ayambangkok',
                'facebook' => 'https://facebook.com/ayambangkok',
                'address' => 'กรุงเทพมหานคร ประเทศไทย',
                'business_hours' => 'จันทร์-ศุกร์ 8:00-17:00 น.',
                'contact_person' => 'คุณสมชาย ใจดี',
                'whatsapp' => '+66 81 234 5678'
            );

            update_option('ayam_contact_data', $default_data);
            $message = 'นำเข้าข้อมูลการติดต่อเริ่มต้นเรียบร้อยแล้ว';
            $message_type = 'success';
        }
    }

    // Get current data
    $contact_data = get_option('ayam_contact_data', array());

    ?>
    <div class="ayam-admin-page">
        <div class="ayam-admin-header">
            <h1><i class="fas fa-phone"></i> จัดการข้อมูลการติดต่อ</h1>
            <p>จัดการข้อมูลการติดต่อที่แสดงในหน้าติดต่อและส่วนต่างๆ ของเว็บไซต์</p>
        </div>

        <?php if ($message): ?>
            <div class="ayam-message ayam-message-<?php echo $message_type; ?>">
                <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Import Section -->
        <div class="ayam-import-section">
            <h3><i class="fas fa-download"></i> นำเข้าข้อมูลการติดต่อเริ่มต้น</h3>
            <p>คลิกปุ่มด้านล่างเพื่อนำเข้าข้อมูลการติดต่อเริ่มต้น</p>
            <form method="post" style="display: inline;">
                <?php wp_nonce_field('import_contact_data', 'import_nonce'); ?>
                <button type="submit" name="import_contact_data" class="ayam-btn ayam-btn-secondary ayam-btn-large">
                    <i class="fas fa-download"></i> นำเข้าข้อมูล
                </button>
            </form>
        </div>

        <div class="ayam-admin-content">
            <!-- Contact Information Form -->
            <div class="ayam-admin-card">
                <h2><i class="fas fa-address-book"></i> ข้อมูลการติดต่อ</h2>

                <form method="post">
                    <?php wp_nonce_field('save_contact_data', 'contact_nonce'); ?>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="phone">เบอร์โทรศัพท์</label>
                        <input type="text" id="phone" name="phone" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['phone'] ?? ''); ?>" placeholder="+66 2 123 4567">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="email">อีเมล</label>
                        <input type="email" id="email" name="email" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['email'] ?? ''); ?>"
                            placeholder="info@ayambangkok.com">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="line_id">Line ID</label>
                        <input type="text" id="line_id" name="line_id" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['line_id'] ?? ''); ?>" placeholder="@ayambangkok">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="whatsapp">WhatsApp</label>
                        <input type="text" id="whatsapp" name="whatsapp" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['whatsapp'] ?? ''); ?>" placeholder="+66 81 234 5678">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="facebook">Facebook</label>
                        <input type="url" id="facebook" name="facebook" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['facebook'] ?? ''); ?>"
                            placeholder="https://facebook.com/ayambangkok">
                    </div>

                    <button type="submit" name="submit_contact_data" class="ayam-btn ayam-btn-primary ayam-btn-large">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </form>
            </div>

            <!-- Business Information Form -->
            <div class="ayam-admin-card">
                <h2><i class="fas fa-building"></i> ข้อมูลธุรกิจ</h2>

                <form method="post">
                    <?php wp_nonce_field('save_contact_data', 'contact_nonce'); ?>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="address">ที่อยู่</label>
                        <textarea id="address" name="address" class="ayam-form-textarea"
                            placeholder="ที่อยู่บริษัท"><?php echo esc_textarea($contact_data['address'] ?? ''); ?></textarea>
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="business_hours">เวลาทำการ</label>
                        <input type="text" id="business_hours" name="business_hours" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['business_hours'] ?? ''); ?>"
                            placeholder="จันทร์-ศุกร์ 8:00-17:00 น.">
                    </div>

                    <div class="ayam-form-group">
                        <label class="ayam-form-label" for="contact_person">ผู้ติดต่อ</label>
                        <input type="text" id="contact_person" name="contact_person" class="ayam-form-input"
                            value="<?php echo esc_attr($contact_data['contact_person'] ?? ''); ?>"
                            placeholder="คุณสมชาย ใจดี">
                    </div>

                    <button type="submit" name="submit_contact_data" class="ayam-btn ayam-btn-primary ayam-btn-large">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                </form>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="ayam-admin-card">
            <h2><i class="fas fa-eye"></i> ตัวอย่างการแสดงผล</h2>
            <p>ข้อมูลที่บันทึกจะแสดงในหน้าติดต่อและส่วนต่างๆ ของเว็บไซต์</p>

            <?php if (!empty($contact_data)): ?>
                <div
                    style="background: var(--bg-section); padding: var(--space-6); border-radius: var(--radius-lg); margin-top: var(--space-4); display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-4);">
                    <?php if (!empty($contact_data['phone'])): ?>
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <i class="fas fa-phone" style="color: var(--primary);"></i>
                            <span><?php echo esc_html($contact_data['phone']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact_data['email'])): ?>
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <i class="fas fa-envelope" style="color: var(--primary);"></i>
                            <span><?php echo esc_html($contact_data['email']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact_data['line_id'])): ?>
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <i class="fab fa-line" style="color: var(--primary);"></i>
                            <span><?php echo esc_html($contact_data['line_id']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($contact_data['whatsapp'])): ?>
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <i class="fab fa-whatsapp" style="color: var(--primary);"></i>
                            <span><?php echo esc_html($contact_data['whatsapp']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($contact_data['address']) || !empty($contact_data['business_hours'])): ?>
                    <div
                        style="background: var(--bg-section); padding: var(--space-6); border-radius: var(--radius-lg); margin-top: var(--space-4);">
                        <?php if (!empty($contact_data['address'])): ?>
                            <div style="margin-bottom: var(--space-3);">
                                <strong style="color: var(--primary);">ที่อยู่:</strong>
                                <p style="margin-top: var(--space-1);"><?php echo esc_html($contact_data['address']); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contact_data['business_hours'])): ?>
                            <div>
                                <strong style="color: var(--primary);">เวลาทำการ:</strong>
                                <p style="margin-top: var(--space-1);"><?php echo esc_html($contact_data['business_hours']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p style="color: var(--text-secondary); font-style: italic;">ยังไม่มีข้อมูลที่บันทึก
                    กรุณาเพิ่มข้อมูลหรือนำเข้าข้อมูลเริ่มต้น</p>
            <?php endif; ?>
        </div>
    </div>

    <style>
        /* Override WordPress admin styles */
        .ayam-admin-page * {
            box-sizing: border-box;
        }

        .ayam-admin-page {
            margin: -20px -20px -10px -2px;
        }
    </style>
    <?php
}



// Create shortcodes for company info



/**
 * Get company field data
 */
function ayam_get_company_field($field, $default = '')
{
    $company_data = get_option('ayam_company_data', array());
    return isset($company_data[$field]) ? $company_data[$field] : $default;
}

/**
 * Helper function to get company info (for backward compatibility)
 */
function ayam_get_company_info($field, $default = '')
{
    return ayam_get_company_field($field, $default);
}

/**
 * Get contact field data
 */
function ayam_get_contact_field($field, $default = '')
{
    $contact_data = get_option('ayam_contact_data', array());
    return isset($contact_data[$field]) ? $contact_data[$field] : $default;
}

/**
 * Get company timeline data
 */
function ayam_get_company_timeline()
{
    // Check new option first, then fallback to old option
    $timeline_data = get_option('ayam_company_timeline', array());
    if (empty($timeline_data)) {
        $timeline_data = get_option('ayam_timeline_data', array());
    }

    // Return default timeline if no data saved
    if (empty($timeline_data)) {
        return array(
            array(
                'year' => '2014',
                'title' => __('ก่อตั้งบริษัท', 'ayam-bangkok'),
                'description' => __('เริ่มต้นธุรกิจการส่งออกไก่ชนด้วยความมุ่งมั่นในคุณภาพ', 'ayam-bangkok'),
                'image' => ''
            ),
            array(
                'year' => '2016',
                'title' => __('ขยายตลาด', 'ayam-bangkok'),
                'description' => __('เริ่มส่งออกไปยังประเทศอินโดนีเซียอย่างเป็นทางการ', 'ayam-bangkok'),
                'image' => ''
            ),
            array(
                'year' => '2018',
                'title' => __('ได้รับใบรับรอง', 'ayam-bangkok'),
                'description' => __('ได้รับใบรับรองมาตรฐานการส่งออกจากกรมปศุสัตว์', 'ayam-bangkok'),
                'image' => ''
            ),
            array(
                'year' => '2020',
                'title' => __('เทคโนโลยีใหม่', 'ayam-bangkok'),
                'description' => __('นำเทคโนโลยีสมัยใหม่มาใช้ในการดูแลและขนส่งไก่ชน', 'ayam-bangkok'),
                'image' => ''
            ),
            array(
                'year' => '2024',
                'title' => __('ผู้นำในตลาด', 'ayam-bangkok'),
                'description' => __('กิจการเติบโตเป็นผู้นำในการส่งออกไก่ชนไปอินโดนีเซีย', 'ayam-bangkok'),
                'image' => ''
            )
        );
    }

    return $timeline_data;
}

/**
 * Get company awards data
 */
function ayam_get_company_awards()
{
    // Check new option first, then fallback to old option
    $awards_data = get_option('ayam_company_awards', array());
    if (empty($awards_data)) {
        $awards_data = get_option('ayam_awards_data', array());
    }

    // Return default awards if no data saved
    if (empty($awards_data)) {
        return array(
            array(
                'title' => __('รางวัลผู้ส่งออกดีเด่น', 'ayam-bangkok'),
                'year' => '2023',
                'description' => __('จากกรมการค้าต่างประเทศ กระทรวงพาณิชย์', 'ayam-bangkok'),
                'image' => ''
            ),
            array(
                'title' => __('ใบรับรองมาตรฐาน ISO', 'ayam-bangkok'),
                'year' => '2022',
                'description' => __('มาตรฐานการจัดการคุณภาพระดับสากล', 'ayam-bangkok'),
                'image' => ''
            ),
            array(
                'title' => __('รางวัลพันธมิตรทางการค้าดีเด่น', 'ayam-bangkok'),
                'year' => '2021',
                'description' => __('จากสถานเอกอัครราชทูตอินโดนีเซีย', 'ayam-bangkok'),
                'image' => ''
            )
        );
    }

    return $awards_data;
}

/**
 * Get company values data
 */
function ayam_get_company_values()
{
    $values_data = get_option('ayam_company_values', array());

    // Return default values if no data saved
    if (empty($values_data)) {
        return array(
            array(
                'title' => __('ความใส่ใจ', 'ayam-bangkok'),
                'description' => __('เราใส่ใจในทุกรายละเอียดของการดูแลไก่ชน ตั้งแต่การเลือกสรร การเลี้ยงดู ไปจนถึงการขนส่ง', 'ayam-bangkok'),
                'icon' => 'fas fa-heart'
            ),
            array(
                'title' => __('ความน่าเชื่อถือ', 'ayam-bangkok'),
                'description' => __('สร้างความไว้วางใจด้วยการส่งมอบสินค้าคุณภาพสูงตรงเวลาและตรงตามข้อตกลง', 'ayam-bangkok'),
                'icon' => 'fas fa-handshake'
            ),
            array(
                'title' => __('นวัตกรรม', 'ayam-bangkok'),
                'description' => __('นำเทคโนโลยีและวิธีการใหม่ๆ มาใช้เพื่อพัฒนาคุณภาพและประสิทธิภาพอย่างต่อเนื่อง', 'ayam-bangkok'),
                'icon' => 'fas fa-lightbulb'
            ),
            array(
                'title' => __('ความซื่อสัตย์', 'ayam-bangkok'),
                'description' => __('ดำเนินธุรกิจด้วยความโปร่งใส ยุติธรรม และเป็นธรรมต่อทุกฝ่าย', 'ayam-bangkok'),
                'icon' => 'fas fa-balance-scale'
            )
        );
    }

    return $values_data;
}

/**
 * Get team members data
 */
function ayam_get_team_members()
{
    $team_data = get_option('ayam_team_data', array());

    // Return default team if no data saved
    if (empty($team_data)) {
        return array(
            array(
                'name' => __('คุณสมชาย ใจดี', 'ayam-bangkok'),
                'position' => __('ผู้อำนวยการ', 'ayam-bangkok'),
                'description' => __('ประสบการณ์กว่า 15 ปีในธุรกิจการส่งออกไก่ชน', 'ayam-bangkok'),
                'image' => '',
                'social' => array()
            ),
            array(
                'name' => __('คุณสมหญิง รักษ์ดี', 'ayam-bangkok'),
                'position' => __('ผู้จัดการฝ่ายขาย', 'ayam-bangkok'),
                'description' => __('เชี่ยวชาญด้านการตลาดและการขายระหว่างประเทศ', 'ayam-bangkok'),
                'image' => '',
                'social' => array()
            ),
            array(
                'name' => __('คุณสมศักดิ์ เก่งมาก', 'ayam-bangkok'),
                'position' => __('ผู้เชี่ยวชาญด้านไก่ชน', 'ayam-bangkok'),
                'description' => __('ความรู้เชิงลึกเกี่ยวกับการเลี้ยงและดูแลไก่ชน', 'ayam-bangkok'),
                'image' => '',
                'social' => array()
            )
        );
    }

    return $team_data;
}

// Create shortcodes for company info
function ayam_company_info_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'field' => 'company_name',
        'default' => '',
    ), $atts);

    return ayam_get_company_field($atts['field'], $atts['default']);
}
add_shortcode('company_info', 'ayam_company_info_shortcode');

function ayam_company_timeline_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => -1,
    ), $atts);

    $timeline = ayam_get_company_timeline();

    if (empty($timeline)) {
        return '';
    }

    if ($atts['limit'] > 0) {
        $timeline = array_slice($timeline, 0, intval($atts['limit']));
    }

    ob_start();
    ?>
    <div class="company-timeline-shortcode">
        <?php foreach ($timeline as $item): ?>
            <div class="timeline-item-shortcode">
                <div class="timeline-year"><?php echo esc_html($item['year']); ?></div>
                <h4><?php echo esc_html($item['title']); ?></h4>
                <p><?php echo esc_html($item['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('company_timeline', 'ayam_company_timeline_shortcode');

function ayam_team_members_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => -1,
        'columns' => 3,
    ), $atts);

    $team = ayam_get_team_members();

    if (empty($team)) {
        return '';
    }

    if ($atts['limit'] > 0) {
        $team = array_slice($team, 0, intval($atts['limit']));
    }

    ob_start();
    ?>
    <div class="team-members-shortcode"
        style="display: grid; grid-template-columns: repeat(<?php echo intval($atts['columns']); ?>, 1fr); gap: 2rem;">
        <?php foreach ($team as $member): ?>
            <div class="team-member-shortcode" style="text-align: center;">
                <?php if (!empty($member['image'])): ?>
                    <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>"
                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem;">
                <?php endif; ?>
                <h4><?php echo esc_html($member['name']); ?></h4>
                <p><strong><?php echo esc_html($member['position']); ?></strong></p>
                <p><?php echo esc_html($member['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('team_members', 'ayam_team_members_shortcode');

// Enqueue admin styles for company settings
function ayam_admin_company_styles($hook)
{
    // Only load on our company settings page
    if ($hook !== 'toplevel_page_ayam-company-settings') {
        return;
    }

    wp_enqueue_style(
        'ayam-admin-company',
        get_template_directory_uri() . '/assets/css/admin-company.css',
        array(),
        '1.0.0'
    );

    // Add custom header
    add_action('acf/admin_head', 'ayam_add_company_admin_header');
}
add_action('admin_enqueue_scripts', 'ayam_admin_company_styles');

// Add custom header to company settings page
function ayam_add_company_admin_header()
{
    if (get_current_screen()->id === 'toplevel_page_ayam-company-settings') {
        echo '<div class="company-admin-header">';
        echo '<h1><span class="dashicons dashicons-building"></span>ตั้งค่าข้อมูลบริษัท</h1>';
        echo '<p class="company-admin-subtitle">จัดการข้อมูลบริษัท ประวัติ รางวัล และทีมงานของคุณ</p>';
        echo '</div>';
    }
}

// Include template functions
require_once AYAM_THEME_PATH . '/inc/template-functions.php';

/**

 * Pricing and Quote System
 */

// AJAX handler for quote request
function ayam_handle_quote_request()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_theme_nonce')) {
        wp_send_json_error(__('Security check failed', 'ayam-bangkok'));
    }

    // Sanitize input
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_phone = sanitize_text_field($_POST['customer_phone']);
    $customer_email = sanitize_email($_POST['customer_email']);
    $customer_company = sanitize_text_field($_POST['customer_company']);
    $message = sanitize_textarea_field($_POST['message']);

    $rooster_count = intval($_POST['rooster_count']);
    $rooster_breed = sanitize_text_field($_POST['rooster_breed']);
    $service_package = sanitize_text_field($_POST['service_package']);
    $shipping_method = sanitize_text_field($_POST['shipping_method']);
    $total_price = floatval($_POST['total_price']);

    $health_certificate = isset($_POST['health_certificate']) ? 1 : 0;
    $insurance = isset($_POST['insurance']) ? 1 : 0;
    $express_service = isset($_POST['express_service']) ? 1 : 0;

    $breakdown = isset($_POST['breakdown']) ? $_POST['breakdown'] : array();

    // Validate required fields
    if (empty($customer_name) || empty($customer_email) || empty($rooster_count)) {
        wp_send_json_error(__('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok'));
    }

    // Validate email
    if (!is_email($customer_email)) {
        wp_send_json_error(__('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok'));
    }

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_inquiries';

    $quote_data = array(
        'rooster_count' => $rooster_count,
        'rooster_breed' => $rooster_breed,
        'service_package' => $service_package,
        'shipping_method' => $shipping_method,
        'health_certificate' => $health_certificate,
        'insurance' => $insurance,
        'express_service' => $express_service,
        'total_price' => $total_price,
        'breakdown' => json_encode($breakdown)
    );

    $result = $wpdb->insert(
        $table_name,
        array(
            'inquiry_type' => 'quote_request',
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'customer_company' => $customer_company,
            'subject' => sprintf(__('ขอใบเสนอราคา - %d ตัว', 'ayam-bangkok'), $rooster_count),
            'message' => $message,
            'quote_data' => json_encode($quote_data),
            'status' => 'new',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(__('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'ayam-bangkok'));
    }

    // Send email notification to admin
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = sprintf('[%s] คำขอใบเสนอราคาใหม่', $site_name);
    $email_message = sprintf(
        "มีคำขอใบเสนอราคาใหม่\n\n" .
        "ลูกค้า: %s\n" .
        "บริษัท: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n\n" .
        "รายละเอียดคำสั่งซื้อ:\n" .
        "จำนวนไก่ชน: %d ตัว\n" .
        "สายพันธุ์: %s\n" .
        "แพ็กเกจบริการ: %s\n" .
        "วิธีขนส่ง: %s\n" .
        "ราคารวม: %s บาท\n\n" .
        "บริการเสริม:\n" .
        "- ใบรับรองสุขภาพ: %s\n" .
        "- ประกันภัย: %s\n" .
        "- บริการด่วนพิเศษ: %s\n\n" .
        "ข้อความเพิ่มเติม:\n%s\n\n" .
        "เวลา: %s",
        $customer_name,
        $customer_company ?: 'ไม่ระบุ',
        $customer_email,
        $customer_phone ?: 'ไม่ระบุ',
        $rooster_count,
        $rooster_breed,
        $service_package,
        $shipping_method,
        number_format($total_price),
        $health_certificate ? 'ใช่' : 'ไม่',
        $insurance ? 'ใช่' : 'ไม่',
        $express_service ? 'ใช่' : 'ไม่',
        $message ?: 'ไม่มี',
        current_time('Y-m-d H:i:s')
    );

    wp_mail($admin_email, $email_subject, $email_message);

    // Send confirmation email to customer
    $customer_subject = sprintf('[%s] ยืนยันการรับคำขอใบเสนอราคา', $site_name);
    $customer_message = sprintf(
        "เรียน คุณ%s\n\n" .
        "ขอบคุณที่ส่งคำขอใบเสนอราคามายัง %s\n\n" .
        "เราได้รับคำขอของท่านเรียบร้อยแล้ว และจะดำเนินการจัดทำใบเสนอราคาส่งให้ท่านภายใน 24 ชั่วโมง\n\n" .
        "รายละเอียดคำขอ:\n" .
        "- จำนวนไก่ชน: %d ตัว\n" .
        "- แพ็กเกจบริการ: %s\n" .
        "- ราคาประมาณการ: %s บาท\n\n" .
        "หากมีคำถามเพิ่มเติม กรุณาติดต่อเราได้ที่:\n" .
        "โทร: %s\n" .
        "อีเมล: %s\n\n" .
        "ขอบคุณครับ\n" .
        "ทีมงาน %s",
        $customer_name,
        $site_name,
        $rooster_count,
        $service_package,
        number_format($total_price),
        ayam_get_company_info('phone') ?: get_option('admin_email'),
        get_option('admin_email'),
        $site_name
    );

    wp_mail($customer_email, $customer_subject, $customer_message);

    wp_send_json_success(__('ส่งคำขอใบเสนอราคาสำเร็จ เราจะติดต่อกลับภายใน 24 ชั่วโมง', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_request_quote', 'ayam_handle_quote_request');
add_action('wp_ajax_nopriv_ayam_request_quote', 'ayam_handle_quote_request');

// Get pricing packages
function ayam_get_pricing_packages()
{
    $packages = array(
        'basic' => array(
            'name' => __('แพ็กเกจพื้นฐาน', 'ayam-bangkok'),
            'price' => 2000,
            'features' => array(
                __('การตรวจสุขภาพเบื้องต้น', 'ayam-bangkok'),
                __('เอกสารส่งออกพื้นฐาน', 'ayam-bangkok'),
                __('การขนส่งมาตรฐาน', 'ayam-bangkok'),
                __('การติดตามสถานะ', 'ayam-bangkok')
            )
        ),
        'standard' => array(
            'name' => __('แพ็กเกจมาตรฐาน', 'ayam-bangkok'),
            'price' => 3500,
            'features' => array(
                __('การตรวจสุขภาพครบถ้วน', 'ayam-bangkok'),
                __('เอกสารส่งออกครบชุด', 'ayam-bangkok'),
                __('การขนส่งปลอดภัย', 'ayam-bangkok'),
                __('การติดตามแบบ Real-time', 'ayam-bangkok'),
                __('ประกันภัยพื้นฐาน', 'ayam-bangkok'),
                __('บริการหลังการขาย 30 วัน', 'ayam-bangkok')
            )
        ),
        'premium' => array(
            'name' => __('แพ็กเกจพรีเมียม', 'ayam-bangkok'),
            'price' => 5000,
            'features' => array(
                __('การตรวจสุขภาพแบบพิเศษ', 'ayam-bangkok'),
                __('เอกสารส่งออกพรีเมียม', 'ayam-bangkok'),
                __('การขนส่งแบบพิเศษ', 'ayam-bangkok'),
                __('การติดตาม 24/7', 'ayam-bangkok'),
                __('ประกันภัยครอบคลุม', 'ayam-bangkok'),
                __('บริการหลังการขาย 90 วัน', 'ayam-bangkok'),
                __('คำปรึกษาฟรี', 'ayam-bangkok')
            ),
            'popular' => true
        ),
        'vip' => array(
            'name' => __('แพ็กเกจ VIP', 'ayam-bangkok'),
            'price' => 8000,
            'features' => array(
                __('การตรวจสุขภาพแบบ VIP', 'ayam-bangkok'),
                __('เอกสารส่งออกแบบ VIP', 'ayam-bangkok'),
                __('การขนส่งแบบ VIP', 'ayam-bangkok'),
                __('ผู้จัดการส่วนตัว', 'ayam-bangkok'),
                __('ประกันภัยเต็มจำนวน', 'ayam-bangkok'),
                __('บริการหลังการขายตลอดชีพ', 'ayam-bangkok'),
                __('คำปรึกษาและฝึกอบรม', 'ayam-bangkok'),
                __('บริการรับซื้อคืน', 'ayam-bangkok')
            )
        )
    );

    return apply_filters('ayam_pricing_packages', $packages);
}

// Calculate discount based on quantity and membership
function ayam_calculate_discount($subtotal, $quantity, $package_type = '', $user_id = 0)
{
    $discount = 0;

    // Volume discount
    if ($quantity >= 10) {
        $discount += $subtotal * 0.15; // 15% for 10+
    } elseif ($quantity >= 5) {
        $discount += $subtotal * 0.10; // 10% for 5+
    } elseif ($quantity >= 3) {
        $discount += $subtotal * 0.05; // 5% for 3+
    }

    // Premium package discount
    if ($package_type === 'premium' && $quantity >= 2) {
        $discount += 500; // Additional 500 baht discount
    }

    // Member discount
    if ($user_id > 0) {
        $user = get_userdata($user_id);
        if ($user && in_array('premium_member', $user->roles)) {
            $discount += $subtotal * 0.15; // 15% member discount
        } elseif ($user && in_array('regular_member', $user->roles)) {
            $discount += $subtotal * 0.05; // 5% member discount
        }
    }

    return round($discount);
}

// Shortcode for pricing calculator
function ayam_pricing_calculator_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'title' => __('เครื่องคำนวณราคา', 'ayam-bangkok'),
        'show_packages' => 'true'
    ), $atts);

    ob_start();

    // Include the calculator template
    if (file_exists(get_template_directory() . '/template-parts/pricing-calculator.php')) {
        include get_template_directory() . '/template-parts/pricing-calculator.php';
    } else {
        echo '<div class="pricing-calculator-shortcode">';
        echo '<h3>' . esc_html($atts['title']) . '</h3>';
        echo '<p>' . __('เครื่องคำนวณราคาจะแสดงที่นี่', 'ayam-bangkok') . '</p>';
        echo '</div>';
    }

    return ob_get_clean();
}
add_shortcode('pricing_calculator', 'ayam_pricing_calculator_shortcode');

/**
 * Achievements page helper functions
 */

// Get achievement statistics
function ayam_get_achievement_stats()
{
    $stats = array(
        'total_awards' => get_option('ayam_total_awards', 15),
        'total_exports' => get_option('ayam_total_exports', 2500),
        'satisfied_customers' => get_option('ayam_satisfied_customers', 150),
        'years_experience' => get_option('ayam_years_experience', 10)
    );

    return apply_filters('ayam_achievement_stats', $stats);
}

// Get export history
function ayam_get_export_history()
{
    $history = get_option('ayam_export_history', array());

    if (empty($history)) {
        return array();
    }

    // Sort by date (newest first)
    usort($history, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $history;
}

// Get customer testimonials
function ayam_get_testimonials()
{
    $testimonials = get_option('ayam_testimonials', array());

    if (empty($testimonials)) {
        return array();
    }

    // Sort by date (newest first)
    usort($testimonials, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $testimonials;
}

// Get awards gallery
function ayam_get_awards_gallery()
{
    $gallery = get_option('ayam_awards_gallery', array());

    if (empty($gallery)) {
        return array();
    }

    // Sort by date (newest first)
    usort($gallery, function ($a, $b) {
        return strcmp($b['date'], $a['date']);
    });

    return $gallery;
}

// Add testimonial
function ayam_add_testimonial($testimonial_data)
{
    $testimonials = ayam_get_testimonials();

    $new_testimonial = array(
        'id' => uniqid(),
        'name' => sanitize_text_field($testimonial_data['name']),
        'company' => sanitize_text_field($testimonial_data['company']),
        'message' => sanitize_textarea_field($testimonial_data['message']),
        'rating' => intval($testimonial_data['rating']),
        'avatar' => esc_url_raw($testimonial_data['avatar']),
        'date' => current_time('Y-m-d'),
        'status' => 'pending'
    );

    $testimonials[] = $new_testimonial;
    update_option('ayam_testimonials', $testimonials);

    return $new_testimonial['id'];
}

// AJAX handler for testimonial submission
function ayam_handle_testimonial_submission()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_theme_nonce')) {
        wp_send_json_error(__('Security check failed', 'ayam-bangkok'));
    }

    // Sanitize input
    $name = sanitize_text_field($_POST['testimonial_name']);
    $company = sanitize_text_field($_POST['testimonial_company']);
    $message = sanitize_textarea_field($_POST['testimonial_message']);
    $rating = intval($_POST['testimonial_rating']);
    $email = sanitize_email($_POST['testimonial_email']);

    // Validate required fields
    if (empty($name) || empty($message) || empty($rating) || empty($email)) {
        wp_send_json_error(__('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok'));
    }

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        wp_send_json_error(__('กรุณาให้คะแนนระหว่าง 1-5', 'ayam-bangkok'));
    }

    // Add testimonial
    $testimonial_id = ayam_add_testimonial(array(
        'name' => $name,
        'company' => $company,
        'message' => $message,
        'rating' => $rating,
        'email' => $email,
        'avatar' => ''
    ));

    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = sprintf('[%s] คำชมใหม่จากลูกค้า', $site_name);
    $email_message = sprintf(
        "มีคำชมใหม่จากลูกค้า\n\n" .
        "ชื่อ: %s\n" .
        "บริษัท: %s\n" .
        "อีเมล: %s\n" .
        "คะแนน: %d/5\n\n" .
        "ข้อความ:\n%s\n\n" .
        "เวลา: %s\n\n" .
        "กรุณาเข้าไปอนุมัติในหน้าจัดการ",
        $name,
        $company,
        $email,
        $rating,
        $message,
        current_time('Y-m-d H:i:s')
    );

    wp_mail($admin_email, $email_subject, $email_message);

    wp_send_json_success(__('ส่งคำชมสำเร็จ ขอบคุณสำหรับความคิดเห็น', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_submit_testimonial', 'ayam_handle_testimonial_submission');
add_action('wp_ajax_nopriv_ayam_submit_testimonial', 'ayam_handle_testimonial_submission');

// Shortcode for testimonials
function ayam_testimonials_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => 3,
        'show_rating' => 'true',
        'show_form' => 'false'
    ), $atts);

    $testimonials = ayam_get_testimonials();

    if ($atts['limit'] > 0) {
        $testimonials = array_slice($testimonials, 0, intval($atts['limit']));
    }

    ob_start();
    ?>
    <div class="testimonials-shortcode">
        <?php if (!empty($testimonials)): ?>
            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                    <?php if (isset($testimonial['status']) && $testimonial['status'] !== 'approved')
                        continue; ?>
                    <div class="testimonial-item">
                        <?php if ($atts['show_rating'] === 'true'): ?>
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'active' : ''; ?>"></i>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>

                        <blockquote>"<?php echo esc_html($testimonial['message']); ?>"</blockquote>

                        <div class="testimonial-author">
                            <strong><?php echo esc_html($testimonial['name']); ?></strong>
                            <?php if (!empty($testimonial['company'])): ?>
                                <span><?php echo esc_html($testimonial['company']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p><?php _e('ยังไม่มีคำชมจากลูกค้า', 'ayam-bangkok'); ?></p>
        <?php endif; ?>

        <?php if ($atts['show_form'] === 'true'): ?>
            <div class="testimonial-form-container">
                <h4><?php _e('แบ่งปันประสบการณ์ของคุณ', 'ayam-bangkok'); ?></h4>
                <form class="testimonial-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="testimonial_name"><?php _e('ชื่อ-นามสกุล', 'ayam-bangkok'); ?> *</label>
                            <input type="text" id="testimonial_name" name="testimonial_name" required>
                        </div>
                        <div class="form-group">
                            <label for="testimonial_company"><?php _e('บริษัท', 'ayam-bangkok'); ?></label>
                            <input type="text" id="testimonial_company" name="testimonial_company">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="testimonial_email"><?php _e('อีเมล', 'ayam-bangkok'); ?> *</label>
                        <input type="email" id="testimonial_email" name="testimonial_email" required>
                    </div>

                    <div class="form-group">
                        <label><?php _e('ให้คะแนน', 'ayam-bangkok'); ?> *</label>
                        <div class="rating-input">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" id="rating_<?php echo $i; ?>" name="testimonial_rating"
                                    value="<?php echo $i; ?>" required>
                                <label for="rating_<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="testimonial_message"><?php _e('ข้อความ', 'ayam-bangkok'); ?> *</label>
                        <textarea id="testimonial_message" name="testimonial_message" rows="4" required
                            placeholder="<?php _e('แบ่งปันประสบการณ์การใช้บริการของเรา...', 'ayam-bangkok'); ?>"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <?php _e('ส่งคำชม', 'ayam-bangkok'); ?>
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('testimonials', 'ayam_testimonials_shortcode');

// Shortcode for achievement stats
function ayam_achievement_stats_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'style' => 'horizontal', // horizontal, vertical, grid
        'animate' => 'true'
    ), $atts);

    $stats = ayam_get_achievement_stats();

    ob_start();
    ?>
    <div class="achievement-stats-shortcode <?php echo esc_attr($atts['style']); ?>"
        data-animate="<?php echo esc_attr($atts['animate']); ?>">
        <div class="stat-item">
            <div class="stat-number" data-target="<?php echo esc_attr($stats['total_awards']); ?>">0</div>
            <div class="stat-label"><?php _e('รางวัลที่ได้รับ', 'ayam-bangkok'); ?></div>
        </div>

        <div class="stat-item">
            <div class="stat-number" data-target="<?php echo esc_attr($stats['total_exports']); ?>">0</div>
            <div class="stat-label"><?php _e('ไก่ชนที่ส่งออก', 'ayam-bangkok'); ?></div>
        </div>

        <div class="stat-item">
            <div class="stat-number" data-target="<?php echo esc_attr($stats['satisfied_customers']); ?>">0</div>
            <div class="stat-label"><?php _e('ลูกค้าที่พึงพอใจ', 'ayam-bangkok'); ?></div>
        </div>

        <div class="stat-item">
            <div class="stat-number" data-target="<?php echo esc_attr($stats['years_experience']); ?>">0</div>
            <div class="stat-label"><?php _e('ปีประสบการณ์', 'ayam-bangkok'); ?></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('achievement_stats', 'ayam_achievement_stats_shortcode');/**

* Roosters archive customizations
*/

// Modify rooster archive query
function ayam_modify_rooster_archive_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('ayam_rooster')) {

        // Set posts per page
        $query->set('posts_per_page', 12);

        // Handle search
        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $query->set('s', sanitize_text_field($_GET['s']));
        }

        // Handle taxonomy filters
        $tax_query = array();

        if (isset($_GET['rooster_breed']) && !empty($_GET['rooster_breed'])) {
            $tax_query[] = array(
                'taxonomy' => 'rooster_breed',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['rooster_breed'])
            );
        }

        if (isset($_GET['rooster_category']) && !empty($_GET['rooster_category'])) {
            $tax_query[] = array(
                'taxonomy' => 'rooster_category',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['rooster_category'])
            );
        }

        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';
            $query->set('tax_query', $tax_query);
        }

        // Handle meta filters
        $meta_query = array();

        // Price range filter
        if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
            $price_range = sanitize_text_field($_GET['price_range']);

            switch ($price_range) {
                case '0-5000':
                    $meta_query[] = array(
                        'key' => 'rooster_price',
                        'value' => array(0, 5000),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    );
                    break;
                case '5000-10000':
                    $meta_query[] = array(
                        'key' => 'rooster_price',
                        'value' => array(5000, 10000),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    );
                    break;
                case '10000-20000':
                    $meta_query[] = array(
                        'key' => 'rooster_price',
                        'value' => array(10000, 20000),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    );
                    break;
                case '20000+':
                    $meta_query[] = array(
                        'key' => 'rooster_price',
                        'value' => 20000,
                        'type' => 'NUMERIC',
                        'compare' => '>='
                    );
                    break;
            }
        }

        // Status filter
        if (isset($_GET['rooster_status']) && !empty($_GET['rooster_status'])) {
            $meta_query[] = array(
                'key' => 'rooster_status',
                'value' => sanitize_text_field($_GET['rooster_status']),
                'compare' => '='
            );
        }

        if (!empty($meta_query)) {
            $meta_query['relation'] = 'AND';
            $query->set('meta_query', $meta_query);
        }

        // Handle sorting
        if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
            $orderby = sanitize_text_field($_GET['orderby']);

            switch ($orderby) {
                case 'title':
                    $query->set('orderby', 'title');
                    $query->set('order', 'ASC');
                    break;
                case 'price_low':
                    $query->set('meta_key', 'rooster_price');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'ASC');
                    break;
                case 'price_high':
                    $query->set('meta_key', 'rooster_price');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;
                default:
                    $query->set('orderby', 'date');
                    $query->set('order', 'DESC');
                    break;
            }
        }
    }
}
add_action('pre_get_posts', 'ayam_modify_rooster_archive_query');

// Add custom image sizes for roosters
function ayam_add_rooster_image_sizes()
{
    add_image_size('rooster-card', 400, 300, true);
    add_image_size('rooster-hero', 800, 600, true);
    add_image_size('rooster-gallery', 600, 450, true);
}
add_action('after_setup_theme', 'ayam_add_rooster_image_sizes');

// Enqueue rooster-specific scripts
function ayam_enqueue_rooster_scripts()
{
    if (is_post_type_archive('ayam_rooster') || is_singular('ayam_rooster')) {
        wp_enqueue_script('ayam-roosters', get_template_directory_uri() . '/assets/js/roosters.js', array('jquery'), '1.0.0', true);

        wp_localize_script('ayam-roosters', 'ayam_roosters', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ayam_roosters_nonce'),
            'strings' => array(
                'added_to_favorites' => __('เพิ่มในรายการโปรดแล้ว', 'ayam-bangkok'),
                'removed_from_favorites' => __('ลบออกจากรายการโปรดแล้ว', 'ayam-bangkok'),
                'added_to_compare' => __('เพิ่มในรายการเปรียบเทียบแล้ว', 'ayam-bangkok'),
                'compare_limit' => __('สามารถเปรียบเทียบได้สูงสุด 3 ตัว', 'ayam-bangkok'),
                'link_copied' => __('คัดลอกลิงก์แล้ว', 'ayam-bangkok')
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_enqueue_rooster_scripts');

// Add rooster archive title
function ayam_rooster_archive_title($title)
{
    if (is_post_type_archive('ayam_rooster')) {
        $title = __('ไก่ชนของเรา', 'ayam-bangkok');
    }
    return $title;
}
add_filter('get_the_archive_title', 'ayam_rooster_archive_title');

// Add rooster post class
function ayam_rooster_post_class($classes, $class, $post_id)
{
    if (get_post_type($post_id) == 'ayam_rooster') {
        $status = ayam_get_field('rooster_status', $post_id);
        if ($status) {
            $classes[] = 'rooster-status-' . $status;
        }

        $featured = ayam_get_field('rooster_featured', $post_id);
        if ($featured) {
            $classes[] = 'rooster-featured';
        }
    }
    return $classes;
}
add_filter('post_class', 'ayam_rooster_post_class', 10, 3);

// Add structured data for roosters
function ayam_rooster_structured_data()
{
    if (is_singular('ayam_rooster')) {
        global $post;

        $price = ayam_get_field('rooster_price');
        $age = ayam_get_field('rooster_age');
        $weight = ayam_get_field('rooster_weight');
        $color = ayam_get_field('rooster_color');

        $structured_data = array(
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => get_the_title(),
            'description' => get_the_excerpt(),
            'url' => get_permalink(),
            'category' => 'Fighting Rooster'
        );

        if (has_post_thumbnail()) {
            $structured_data['image'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }

        if ($price) {
            $structured_data['offers'] = array(
                '@type' => 'Offer',
                'price' => $price,
                'priceCurrency' => 'THB',
                'availability' => 'https://schema.org/InStock'
            );
        }

        if ($age || $weight || $color) {
            $structured_data['additionalProperty'] = array();

            if ($age) {
                $structured_data['additionalProperty'][] = array(
                    '@type' => 'PropertyValue',
                    'name' => 'Age',
                    'value' => $age . ' months'
                );
            }

            if ($weight) {
                $structured_data['additionalProperty'][] = array(
                    '@type' => 'PropertyValue',
                    'name' => 'Weight',
                    'value' => $weight . ' kg'
                );
            }

            if ($color) {
                $structured_data['additionalProperty'][] = array(
                    '@type' => 'PropertyValue',
                    'name' => 'Color',
                    'value' => $color
                );
            }
        }

        echo '<script type="application/ld+json">' . json_encode($structured_data) . '</script>';
    }
}
add_action('wp_head', 'ayam_rooster_structured_data');

// Add rooster breadcrumb support
function ayam_rooster_breadcrumb_items($items)
{
    if (is_singular('ayam_rooster')) {
        $archive_link = get_post_type_archive_link('ayam_rooster');
        $archive_title = __('ไก่ชน', 'ayam-bangkok');

        // Insert archive link before the current post
        array_splice($items, -1, 0, array(
            '<a href="' . $archive_link . '">' . $archive_title . '</a>'
        ));
    }

    return $items;
}
add_filter('ayam_breadcrumb_items', 'ayam_rooster_breadcrumb_items');/**

* Homepage Slider ACF Fields
*/
function ayam_add_homepage_slider_fields()
{
    if (function_exists('acf_add_local_field_group')) {

        // Homepage Slider Fields
        acf_add_local_field_group(array(
            'key' => 'group_homepage_slider',
            'title' => 'Homepage Slider Settings',
            'fields' => array(
                array(
                    'key' => 'field_slider_images',
                    'label' => 'Slider Images',
                    'name' => 'slider_images',
                    'type' => 'repeater',
                    'instructions' => 'เพิ่มรูปภาพสำหรับ slider หน้าแรก',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_slide_image',
                            'label' => 'รูปภาพ',
                            'name' => 'slide_image',
                            'type' => 'image',
                            'return_format' => 'url',
                            'preview_size' => 'medium',
                            'wrapper' => array('width' => '30'),
                        ),
                        array(
                            'key' => 'field_slide_title',
                            'label' => 'หัวข้อ',
                            'name' => 'slide_title',
                            'type' => 'text',
                            'wrapper' => array('width' => '35'),
                        ),
                        array(
                            'key' => 'field_slide_description',
                            'label' => 'คำอธิบาย',
                            'name' => 'slide_description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'wrapper' => array('width' => '35'),
                        ),
                        array(
                            'key' => 'field_slide_button_text',
                            'label' => 'ข้อความปุ่ม',
                            'name' => 'slide_button_text',
                            'type' => 'text',
                            'default_value' => 'ดูเพิ่มเติม',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_slide_button_url',
                            'label' => 'ลิงก์ปุ่ม',
                            'name' => 'slide_button_url',
                            'type' => 'url',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_slide_button_style',
                            'label' => 'สไตล์ปุ่ม',
                            'name' => 'slide_button_style',
                            'type' => 'select',
                            'choices' => array(
                                'primary' => 'Primary (สีหลัก)',
                                'secondary' => 'Secondary (สีรอง)',
                                'outline' => 'Outline (กรอบ)',
                            ),
                            'default_value' => 'primary',
                            'wrapper' => array('width' => '25'),
                        ),
                        array(
                            'key' => 'field_slide_text_position',
                            'label' => 'ตำแหน่งข้อความ',
                            'name' => 'slide_text_position',
                            'type' => 'select',
                            'choices' => array(
                                'center' => 'กึ่งกลาง',
                                'left' => 'ซ้าย',
                                'right' => 'ขวา',
                            ),
                            'default_value' => 'center',
                            'wrapper' => array('width' => '25'),
                        ),
                    ),
                    'button_label' => 'เพิ่มสไลด์',
                    'min' => 1,
                    'max' => 10,
                ),
                array(
                    'key' => 'field_slider_settings_tab',
                    'label' => 'การตั้งค่า Slider',
                    'type' => 'tab',
                ),
                array(
                    'key' => 'field_slider_autoplay',
                    'label' => 'เล่นอัตโนมัติ',
                    'name' => 'slider_autoplay',
                    'type' => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_slider_autoplay_speed',
                    'label' => 'ความเร็วการเล่น (มิลลิวินาที)',
                    'name' => 'slider_autoplay_speed',
                    'type' => 'number',
                    'default_value' => 5000,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 500,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_slider_autoplay',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_slider_show_navigation',
                    'label' => 'แสดงปุ่มนำทาง',
                    'name' => 'slider_show_navigation',
                    'type' => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_slider_show_pagination',
                    'label' => 'แสดงจุดนำทาง',
                    'name' => 'slider_show_pagination',
                    'type' => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_slider_effect',
                    'label' => 'เอฟเฟกต์การเปลี่ยน',
                    'name' => 'slider_effect',
                    'type' => 'select',
                    'choices' => array(
                        'fade' => 'Fade (จางหาย)',
                        'slide' => 'Slide (เลื่อน)',
                        'cube' => 'Cube (ลูกบาศก์)',
                        'coverflow' => 'Coverflow (ปก)',
                    ),
                    'default_value' => 'fade',
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_slider_loop',
                    'label' => 'เล่นวนซ้ำ',
                    'name' => 'slider_loop',
                    'type' => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => array('width' => '25'),
                ),
                array(
                    'key' => 'field_slider_height',
                    'label' => 'ความสูง Slider',
                    'name' => 'slider_height',
                    'type' => 'select',
                    'choices' => array(
                        '100vh' => 'เต็มหน้าจอ (100vh)',
                        '80vh' => '80% ของหน้าจอ (80vh)',
                        '70vh' => '70% ของหน้าจอ (70vh)',
                        '60vh' => '60% ของหน้าจอ (60vh)',
                        '500px' => '500 พิกเซล',
                        '400px' => '400 พิกเซล',
                    ),
                    'default_value' => '100vh',
                    'wrapper' => array('width' => '25'),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-homepage-settings',
                    ),
                ),
            ),
        ));

        // Welcome Section Fields
        acf_add_local_field_group(array(
            'key' => 'group_welcome_section',
            'title' => 'Welcome Section Settings',
            'fields' => array(
                array(
                    'key' => 'field_welcome_enable',
                    'label' => 'เปิดใช้งาน Welcome Section',
                    'name' => 'welcome_enable',
                    'type' => 'true_false',
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_welcome_title',
                    'label' => 'หัวข้อ Welcome',
                    'name' => 'welcome_title',
                    'type' => 'text',
                    'default_value' => 'ยินดีต้อนรับสู่ Ayam Bangkok',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_welcome_enable',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_welcome_description',
                    'label' => 'คำอธิบาย Welcome',
                    'name' => 'welcome_description',
                    'type' => 'textarea',
                    'rows' => 4,
                    'default_value' => 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_welcome_enable',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_welcome_background_color',
                    'label' => 'สีพื้นหลัง Welcome Section',
                    'name' => 'welcome_background_color',
                    'type' => 'select',
                    'choices' => array(
                        'light' => 'สีอ่อน (Light)',
                        'white' => 'สีขาว (White)',
                        'gradient' => 'ไล่สี (Gradient)',
                    ),
                    'default_value' => 'gradient',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_welcome_enable',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-homepage-settings',
                    ),
                ),
            ),
        ));
    }
}
add_action('acf/init', 'ayam_add_homepage_slider_fields');

/**
 * Add Homepage Settings Options Page
 */
function ayam_add_homepage_options_page()
{
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'ตั้งค่าหน้าแรก',
            'menu_title' => 'หน้าแรก',
            'menu_slug' => 'ayam-homepage-settings',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-admin-home',
            'position' => 25,
        ));
    }
}
add_action('acf/init', 'ayam_add_homepage_options_page');

/**
 * Helper functions for getting slider data
 */
// Get slider images from database
function ayam_get_slider_images()
{
    $slides = @get_option('ayam_slider_images', array());

    // Ensure it's an array
    if (!is_array($slides)) {
        $slides = @json_decode($slides, true) ?: array();
    }

    // Filter out empty slides and ensure all required keys exist
    $slides = array_filter($slides, function ($slide) {
        return !empty($slide['slide_image']) || !empty($slide['slide_title']);
    });

    // Ensure all slides have required keys
    foreach ($slides as &$slide) {
        $slide = array_merge(array(
            'slide_image' => '',
            'slide_title' => '',
            'slide_description' => '',
            'slide_button_text' => '',
            'slide_button_url' => '',
            'slide_button_style' => 'primary',
            'slide_text_position' => 'center'
        ), $slide);
    }

    return $slides;
}

function ayam_get_slider_settings()
{
    return array(
        'autoplay' => get_option('ayam_slider_autoplay', 1) ? true : false,
        'autoplay_speed' => intval(get_option('ayam_slider_autoplay_speed', 5000)),
        'show_navigation' => get_option('ayam_slider_show_navigation', 1) ? true : false,
        'show_pagination' => get_option('ayam_slider_show_pagination', 1) ? true : false,
        'height' => get_option('ayam_slider_height', '600px'),
        'loop' => true,
        'effect' => 'slide'
    );
}

// Display slider on frontend
function ayam_display_slider()
{
    $slides = ayam_get_slider_images();
    $settings = ayam_get_slider_settings();

    if (empty($slides)) {
        return;
    }

    ?>
    <div class="ayam-slider-container" style="height: <?php echo esc_attr($settings['height']); ?>;">
        <div class="swiper ayam-slider">
            <div class="swiper-wrapper">
                <?php foreach ($slides as $slide): ?>
                    <div class="swiper-slide">
                        <?php if (!empty($slide['slide_image'])): ?>
                            <div class="slide-background">
                                <img src="<?php echo esc_url($slide['slide_image']); ?>"
                                    alt="<?php echo esc_attr($slide['slide_title'] ?? ''); ?>"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($slide['slide_title']) || !empty($slide['slide_description'])): ?>
                            <div class="slide-content text-<?php echo esc_attr($slide['slide_text_position'] ?? 'center'); ?>">
                                <div class="container">
                                    <?php if (!empty($slide['slide_title'])): ?>
                                        <h2 class="slide-title"><?php echo esc_html($slide['slide_title']); ?></h2>
                                    <?php endif; ?>

                                    <?php if (!empty($slide['slide_description'])): ?>
                                        <p class="slide-description"><?php echo esc_html($slide['slide_description']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($slide['slide_button_text']) && !empty($slide['slide_button_url'])): ?>
                                        <a href="<?php echo esc_url($slide['slide_button_url']); ?>"
                                            class="slide-button btn btn-primary">
                                            <?php echo esc_html($slide['slide_button_text']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($settings['show_navigation']): ?>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            <?php endif; ?>

            <?php if ($settings['show_pagination']): ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.ayam-slider', {
                    loop: <?php echo $settings['loop'] ? 'true' : 'false'; ?>,
                    autoplay: <?php echo $settings['autoplay'] ? '{delay: ' . $settings['autoplay_speed'] . '}' : 'false'; ?>,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    effect: 'slide',
                    speed: 800,
                });
            }
        });
    </script>
    <?php
}

function ayam_get_welcome_content()
{
    if (function_exists('get_field')) {
        return array(
            'enable' => get_field('welcome_enable', 'option') ? true : false,
            'title' => get_field('welcome_title', 'option') ?: 'ยินดีต้อนรับสู่ Ayam Bangkok',
            'description' => get_field('welcome_description', 'option') ?: 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย',
            'background_color' => get_field('welcome_background_color', 'option') ?: 'gradient',
        );
    } else {
        return array(
            'enable' => get_option('ayam_welcome_enable', 1) ? true : false,
            'title' => get_option('ayam_welcome_title', 'ยินดีต้อนรับสู่ Ayam Bangkok'),
            'description' => get_option('ayam_welcome_description', 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย'),
            'background_color' => get_option('ayam_welcome_background_color', 'gradient'),
        );
    }
}

/**
 * Helper Functions for Sample Data
 * Note: Main helper functions are defined in the plugin
 */
// Enqueue Compiled SCSS CSS
function ayam_enqueue_compiled_css()
{
    // Don't load compiled.css on About and Service pages (conflicts with Wix design)
    if (is_page('about') || is_page(27) || is_page('service') || is_page(251) || is_page('news-1') || is_page(168)) {
        return;
    }

    wp_enqueue_style(
        'ayam-compiled-css',
        get_template_directory_uri() . '/assets/css/compiled.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/compiled.css')
    );
}
add_action('wp_enqueue_scripts', 'ayam_enqueue_compiled_css', 5);

// Background Image Fix CSS - Final version
function ayam_background_image_fix()
{
    wp_enqueue_style(
        'ayam-background-fix',
        get_template_directory_uri() . '/assets/css/background-image-fix.css',
        array(),
        '1.0.5'
    );
}
add_action('wp_enqueue_scripts', 'ayam_background_image_fix', 1002);

// Remove conflicting JavaScript fixes
function ayam_remove_conflicting_scripts()
{
    wp_dequeue_script('ayam-ultimate-button-fix-js');
    wp_dequeue_script('ayam-emergency-button-fix-js');
    wp_dequeue_script('ayam-simple-button-fix');
}
add_action('wp_enqueue_scripts', 'ayam_remove_conflicting_scripts', 1003);

// Final Slider Fix CSS - highest priority
function ayam_final_slider_fix()
{
    wp_enqueue_style(
        'ayam-final-slider-fix',
        get_template_directory_uri() . '/assets/css/final-slider-fix.css',
        array(),
        '1.0.6'
    );
}
add_action('wp_enqueue_scripts', 'ayam_final_slider_fix', 1004);


// Slider Admin Menu
add_action('admin_menu', function () {
    add_menu_page(
        'จัดการ Slider',
        'Slider หน้าแรก',
        'manage_options',
        'ayam-slider-settings',
        'ayam_slider_admin_page',
        'dashicons-images-alt2',
        25
    );

    // Add About Page Management
    add_menu_page(
        'จัดการหน้า About',
        'จัดการหน้า About',
        'manage_options',
        'ayam-about-settings',
        'ayam_about_admin_page',
        'dashicons-info-outline',
        26
    );
});

// Enqueue admin scripts and styles for slider page
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook === 'toplevel_page_ayam-slider-settings' || $hook === 'toplevel_page_ayam-about-settings') {
        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        // Enqueue custom admin slider styles
        wp_enqueue_style(
            'ayam-admin-slider',
            get_template_directory_uri() . '/assets/css/admin-slider.css',
            array(),
            '1.0.0'
        );

        // Enqueue custom admin slider script
        wp_enqueue_script(
            'ayam-admin-slider',
            get_template_directory_uri() . '/assets/js/admin-slider.js',
            array('jquery', 'jquery-ui-sortable', 'wp-color-picker'),
            '1.0.0',
            true
        );

        // Enqueue About admin script only for About page
        if ($hook === 'toplevel_page_ayam-about-settings') {
            wp_enqueue_script(
                'ayam-about-admin',
                get_template_directory_uri() . '/assets/js/about-admin.js',
                array('jquery', 'media-editor', 'wp-util'),
                '1.0.0',
                true
            );
        }
    }
});

function ayam_slider_admin_page()
{
    // Start output buffering to prevent headers already sent
    if (!headers_sent()) {
        ob_start();
    }

    if (!empty($_POST)) {
        error_log('Debug: Form submitted with POST data: ' . print_r($_POST, true));
    }

    // Add nonce for security
    $nonce_action = 'ayam_slider_save';

    // Handle form submission FIRST before any output
    if (isset($_POST['save_slider'])) {
        // Check nonce
        if (!wp_verify_nonce($_POST['ayam_slider_nonce'], $nonce_action)) {
            // Clean any output buffer and redirect
            if (ob_get_level())
                ob_end_clean();
            wp_safe_redirect(admin_url('admin.php?page=ayam-slider-settings&error=nonce'));
            exit;
        } else {
            $slider_data = array();
            if (isset($_POST['slides']) && is_array($_POST['slides'])) {
                foreach ($_POST['slides'] as $slide) {
                    // Allow slides with just title or just image
                    if (!empty($slide['image']) || !empty($slide['title'])) {
                        $slider_data[] = array(
                            'slide_image' => sanitize_url($slide['image']),
                            'slide_title' => sanitize_text_field($slide['title']),
                            'slide_description' => sanitize_textarea_field($slide['description']),
                            'slide_button_text' => sanitize_text_field($slide['button_text']),
                            'slide_button_url' => sanitize_url($slide['button_url']),
                            'slide_text_position' => sanitize_text_field($slide['text_position'])
                        );
                    }
                }
            }

            // Save slides data
            $slides_saved = update_option('ayam_slider_images', $slider_data);

            // Save slider settings
            update_option('ayam_slider_autoplay', isset($_POST['autoplay']) ? 1 : 0);
            update_option('ayam_slider_autoplay_speed', intval($_POST['autoplay_speed']));
            update_option('ayam_slider_show_navigation', isset($_POST['show_navigation']) ? 1 : 0);
            update_option('ayam_slider_show_pagination', isset($_POST['show_pagination']) ? 1 : 0);
            update_option('ayam_slider_height', sanitize_text_field($_POST['height']));

            // Clean any output buffer and redirect
            if (ob_get_level())
                ob_end_clean();
            wp_safe_redirect(admin_url('admin.php?page=ayam-slider-settings&saved=1'));
            exit;

        }
    }

    // Enqueue media scripts after form handling
    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');

    // Show messages if redirected
    if (isset($_GET['saved']) && $_GET['saved'] == '1') {
        echo '<div class="notice notice-success is-dismissible"><p><strong>✅ บันทึกเรียบร้อย!</strong> การตั้งค่า slider ได้รับการบันทึกแล้ว</p></div>';
    }

    if (isset($_GET['error']) && $_GET['error'] == 'nonce') {
        echo '<div class="notice notice-error is-dismissible"><p><strong>❌ ข้อผิดพลาด!</strong> Security check failed. กรุณาลองใหม่อีกครั้ง</p></div>';
    }

    $slides = get_option('ayam_slider_images', array());
    $autoplay = get_option('ayam_slider_autoplay', true);
    $autoplay_speed = get_option('ayam_slider_autoplay_speed', 5000);
    $show_navigation = get_option('ayam_slider_show_navigation', true);
    $show_pagination = get_option('ayam_slider_show_pagination', true);
    $height = get_option('ayam_slider_height', '600px');
    ?>


    <div class="wrap ayam-slider-admin">
        <div class="ayam-slider-header">
            <div class="ayam-slider-icon">🎛️</div>
            <div>
                <h1 class="ayam-slider-title">จัดการ Slider หน้าแรก</h1>
                <p class="ayam-slider-subtitle">สร้างและจัดการ slider สำหรับหน้าแรกของเว็บไซต์</p>
            </div>
        </div>

        <div class="ayam-card">
            <h3>💡 วิธีใช้งาน</h3>
            <div class="usage-guide">
                <div class="usage-item">
                    <h4 style="color: #10b981;">📸 เลือกรูปภาพ</h4>
                    <p>คลิกปุ่ม "เลือกรูปจาก Media" เพื่อเลือกรูปจาก Media Library หรือใส่ URL โดยตรง</p>
                </div>
                <div class="usage-item">
                    <h4 style="color: #3b82f6;">✏️ เพิ่มเนื้อหา</h4>
                    <p>ตั้งหัวข้อ คำอธิบาย และปุ่มสำหรับแต่ละ slide</p>
                </div>
                <div class="usage-item">
                    <h4 style="color: #f59e0b;">🎨 จัดเรียง</h4>
                    <p>ลากไอคอน ⋮⋮ เพื่อเปลี่ยนลำดับ slide</p>
                </div>
            </div>
        </div>

        <form method="post" action="">
            <?php wp_nonce_field($nonce_action, 'ayam_slider_nonce'); ?>
            <div class="ayam-card">
                <h3>⚙️ การตั้งค่าทั่วไป</h3>
                <div class="settings-grid">
                    <div class="setting-item">
                        <input type="checkbox" name="autoplay" id="autoplay" <?php checked($autoplay); ?>>
                        <label for="autoplay"><strong>เล่นอัตโนมัติ</strong></label>
                    </div>
                    <div class="setting-item">
                        <label for="autoplay_speed"><strong>ความเร็ว:</strong></label>
                        <input type="number" name="autoplay_speed" id="autoplay_speed"
                            value="<?php echo $autoplay_speed; ?>" min="1000" max="10000" step="500" style="width: 100px;">
                        <span style="color: #6b7280;">ms</span>
                    </div>
                    <div class="setting-item">
                        <input type="checkbox" name="show_navigation" id="show_navigation" <?php checked($show_navigation); ?>>
                        <label for="show_navigation"><strong>แสดงปุ่มลูกศร</strong></label>
                    </div>
                    <div class="setting-item">
                        <input type="checkbox" name="show_pagination" id="show_pagination" <?php checked($show_pagination); ?>>
                        <label for="show_pagination"><strong>แสดงจุดนำทาง</strong></label>
                    </div>
                    <div class="setting-item">
                        <label for="height"><strong>ความสูง:</strong></label>
                        <input type="text" name="height" id="height" value="<?php echo esc_attr($height); ?>"
                            placeholder="600px" style="width: 100px;">
                    </div>
                </div>
            </div>

            <div class="ayam-card">
                <h3>🖼️ รูปภาพ Slider</h3>
                <div id="slider-images" class="sortable">
                    <?php
                    if (empty($slides)) {
                        $slides = array(
                            array(
                                'slide_image' => esc_url(get_template_directory_uri() . '/assets/images/hero-export-1.jpg'),
                                'slide_title' => 'บริการส่งออกไก่ไทยคุณภาพสูง',
                                'slide_description' => 'เชื่อมต่อฟาร์มไทยสู่ตลาดอินโดนีเซีย ด้วยกระบวนการส่งออกที่มีมาตรฐาน',
                                'slide_button_text' => 'เรียนรู้เพิ่มเติม',
                                'slide_button_url' => '#export-process',
                                'slide_text_position' => 'center'
                            )
                        );
                    }
                    foreach ($slides as $i => $slide): ?>
                        <div class="slide-item" data-slide="<?php echo $i; ?>">
                            <div class="slide-header">
                                <div style="display: flex; align-items: center;">
                                    <span class="drag-handle">⋮⋮</span>
                                    <h3 class="slide-title">📸 Slide <?php echo $i + 1; ?></h3>
                                </div>
                                <div class="slide-actions">
                                    <?php if ($i > 0): ?>
                                        <button type="button" class="button delete-slide" onclick="removeSlide(this)">🗑️
                                            ลบ</button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <label>รูปภาพ</label>
                                <div>
                                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                                        <button type="button" class="button media-upload-btn"
                                            onclick="selectMedia(<?php echo $i; ?>)">
                                            📁 เลือกรูปจาก Media
                                        </button>
                                        <input type="url" name="slides[<?php echo $i; ?>][image]"
                                            id="slide_image_<?php echo $i; ?>"
                                            value="<?php echo esc_attr($slide['slide_image'] ?? ''); ?>"
                                            placeholder="หรือใส่ URL รูปภาพ" style="flex: 1;">
                                    </div>
                                    <?php if (!empty($slide['slide_image'])): ?>
                                        <img src="<?php echo esc_url($slide['slide_image']); ?>" class="image-preview"
                                            id="preview_<?php echo $i; ?>">
                                    <?php else: ?>
                                        <img src="" class="image-preview" id="preview_<?php echo $i; ?>" style="display: none;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <label>หัวข้อ</label>
                                <input type="text" name="slides[<?php echo $i; ?>][title]"
                                    value="<?php echo esc_attr($slide['slide_title'] ?? ''); ?>" placeholder="หัวข้อของ slide"
                                    required>
                            </div>

                            <div class="form-row">
                                <label>คำอธิบาย</label>
                                <textarea name="slides[<?php echo $i; ?>][description]" rows="3"
                                    placeholder="คำอธิบายรายละเอียด"><?php echo esc_textarea($slide['slide_description'] ?? ''); ?></textarea>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-row">
                                    <label>ข้อความปุ่ม</label>
                                    <input type="text" name="slides[<?php echo $i; ?>][button_text]"
                                        value="<?php echo esc_attr($slide['slide_button_text'] ?? ''); ?>"
                                        placeholder="เช่น: เรียนรู้เพิ่มเติม">
                                </div>

                                <div class="form-row">
                                    <label>ลิงก์ปุ่ม</label>
                                    <input type="url" name="slides[<?php echo $i; ?>][button_url]"
                                        value="<?php echo esc_attr($slide['slide_button_url'] ?? ''); ?>"
                                        placeholder="https://example.com">
                                </div>
                            </div>

                            <div class="form-row">
                                <label>ตำแหน่งข้อความ</label>
                                <select name="slides[<?php echo $i; ?>][text_position]" style="width: 200px;">
                                    <option value="left" <?php selected($slide['slide_text_position'] ?? 'center', 'left'); ?>>
                                        ซ้าย</option>
                                    <option value="center" <?php selected($slide['slide_text_position'] ?? 'center', 'center'); ?>>กลาง</option>
                                    <option value="right" <?php selected($slide['slide_text_position'] ?? 'center', 'right'); ?>>ขวา</option>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="text-align: center; padding: 30px 0;">
                <button type="button" class="button add-slide-btn" onclick="addSlide()">
                    ➕ เพิ่ม Slide ใหม่
                </button>
                <input type="submit" name="save_slider" class="button-primary save-btn" value="💾 บันทึกการตั้งค่า">
            </div>
        </form>

        <div class="ayam-card tips-card">
            <h3>📋 เคล็ดลับการใช้งาน</h3>
            <div class="tips-grid">
                <div class="tip-item">
                    <h4>🖼️ ขนาดรูปที่แนะนำ</h4>
                    <p>1920x800px หรือ 16:9 ratio สำหรับผลลัพธ์ที่ดีที่สุด</p>
                </div>
                <div class="tip-item">
                    <h4>📱 รองรับ Responsive</h4>
                    <p>Slider จะปรับขนาดอัตโนมัติบนอุปกรณ์ต่างๆ</p>
                </div>
                <div class="tip-item">
                    <h4>⚡ ประสิทธิภาพ</h4>
                    <p>ใช้รูปขนาดไม่เกิน 500KB เพื่อความเร็วในการโหลด</p>
                </div>
            </div>
        </div>

        <script>
            // Pass slide count to external JS
            window.ayamSliderConfig = {
                slideCount: <?php echo count($slides); ?>
            };
        </script>
    </div>
    <?php
}
// Force HTTPS for all URLs
add_filter('template_directory_uri', 'force_https_urls');
add_filter('stylesheet_directory_uri', 'force_https_urls');
add_filter('home_url', 'force_https_urls');
add_filter('site_url', 'force_https_urls');

function force_https_urls($url)
{
    return str_replace('http://', 'https://', $url);
}

add_action('wp_enqueue_scripts', 'fix_media_library_ajax');
add_action('admin_enqueue_scripts', 'fix_media_library_ajax');

function fix_media_library_ajax()
{
    // Disable SSL verification for AJAX requests
    add_filter('https_ssl_verify', '__return_false');
    add_filter('https_local_ssl_verify', '__return_false');


    if (is_admin()) {
        wp_add_inline_script('jquery', 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";', 'before');
    }
}

add_filter('http_request_args', function ($args, $url) {
    if (strpos($url, 'nongchok.local') !== false) {
        $args['sslverify'] = false;
        $args['timeout'] = 30;
    }
    return $args;
}, 10, 2);

// Ensure media library works properly
add_action('wp_enqueue_media', function () {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('media-views');
    wp_enqueue_script('media-editor');
    wp_enqueue_script('media-audiovideo');
});

// Simple test admin page
add_action("admin_menu", function () {
    add_menu_page(
        "Test Slider",
        "Test Slider",
        "manage_options",
        "test-slider",
        "test_slider_page",
        "dashicons-images-alt2",
        26
    );
});

function test_slider_page()
{
    // Handle form submission
    if (isset($_POST["save_test"]) && wp_verify_nonce($_POST["test_nonce"], "test_save")) {
        echo "<div class=\"notice notice-success\"><p>✅ Form submitted successfully!</p></div>";
        echo "<div class=\"notice notice-info\"><p>POST data: " . print_r($_POST, true) . "</p></div>";
    }

    ?>
    <div class="wrap">
        <h1>🧪 Test Slider Form</h1>

        <form method="post" action="">
            <?php wp_nonce_field("test_save", "test_nonce"); ?>

            <table class="form-table">
                <tr>
                    <th>Test Input</th>
                    <td><input type="text" name="test_input" value="test value" /></td>
                </tr>
            </table>

            <p>
                <input type="submit" name="save_test" class="button-primary" value="🧪 Test Submit" />
            </p>
        </form>

        <script>
            console.log("Test page loaded");
            jQuery(document).ready(function ($) {
                $("form").on("submit", function () {
                    console.log("Test form submitted");
                    return true;
                });
            });
        </script>
    </div>
    <?php
}

/**
 * Estimate reading time for content
 */
function ayam_estimate_reading_time($content)
{
    // Remove HTML tags and get word count
    $word_count = str_word_count(strip_tags($content));

    // Average reading speed is 200 words per minute for Thai text
    $reading_speed = 200;

    // Calculate reading time in minutes
    $reading_time = ceil($word_count / $reading_speed);

    // Minimum 1 minute
    return max(1, $reading_time);
}

/**
 * DEBUG: Check what's in the slider data
 */
function ayam_debug_slider_data()
{
    if (isset($_GET['debug_slider'])) {
        $slides = get_option('ayam_slider_images', array());
        echo '<pre>Slider Data: ' . print_r($slides, true) . '</pre>';

        if (!empty($slides)) {
            foreach ($slides as $index => $slide) {
                echo '<h3>Slide ' . ($index + 1) . ':</h3>';
                echo '<p>Image URL: ' . ($slide['slide_image'] ?? 'No image') . '</p>';
                if (!empty($slide['slide_image'])) {
                    echo '<img src="' . $slide['slide_image'] . '" style="max-width: 200px; height: auto;" />';
                }
            }
        }
        exit;
    }
}
add_action('init', 'ayam_debug_slider_data');

/**

 * Add JavaScript to fix image loading issues
 */
function ayam_slider_image_fix_js()
{
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slides = document.querySelectorAll('.swiper-slide');
            slides.forEach(function (slide, index) {
                const style = slide.getAttribute('style');
                console.log('Slide ' + (index + 1) + ' style:', style);

                // If no background image or empty URL, add fallback
                if (!style || !style.includes('background-image') || style.includes("url('')") || style.includes('url()')) {
                    console.log('Adding fallback background for slide ' + (index + 1));
                    slide.style.background = 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)';
                }
            });

            // Force button styles
            const buttons = document.querySelectorAll('.hero-slider-section .btn-modern, .slide-buttons .btn-modern');
            buttons.forEach(function (button) {
                button.style.backgroundColor = '#ffffff';
                button.style.color = '#3b82f6';
                button.style.borderColor = '#ffffff';
                button.style.border = '3px solid #ffffff';
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'ayam_slider_image_fix_js');/**
* E
mergency JavaScript fix for slider
*/
function ayam_emergency_slider_fix_js()
{
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Emergency Slider Fix: Starting...');

            const slides = document.querySelectorAll('.swiper-slide');
            slides.forEach(function (slide, index) {
                const style = slide.getAttribute('style');
                console.log('Slide ' + (index + 1) + ' style:', style);

                if (style && style.includes('background-image')) {
                    // Force background properties for existing images
                    slide.style.setProperty('background-size', 'cover', 'important');
                    slide.style.setProperty('background-position', 'center center', 'important');
                    slide.style.setProperty('background-repeat', 'no-repeat', 'important');
                    console.log('Fixed background for slide ' + (index + 1));
                }
            });

            setTimeout(function () {
                const buttons = document.querySelectorAll('.hero-slider-section .btn-modern, .slide-buttons .btn-modern, .hero-swiper .btn-modern');
                console.log('Found buttons:', buttons.length);

                buttons.forEach(function (button, index) {
                    console.log('Button ' + (index + 1) + ' HTML:', button.innerHTML);


                    if (button.innerHTML.includes('&lt;') || button.innerHTML.includes('&gt;')) {
                        button.innerHTML = button.innerHTML.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&amp;/g, '&');
                        console.log('Fixed HTML entities for button ' + (index + 1));
                    }

                    // Force button styles
                    button.style.setProperty('background-color', '#ffffff', 'important');
                    button.style.setProperty('color', '#3b82f6', 'important');
                    button.style.setProperty('border', '3px solid #ffffff', 'important');
                    button.style.setProperty('border-radius', '50px', 'important');
                    button.style.setProperty('padding', '1rem 2rem', 'important');
                    button.style.setProperty('text-decoration', 'none', 'important');
                    button.style.setProperty('display', 'inline-flex', 'important');
                    button.style.setProperty('align-items', 'center', 'important');
                    button.style.setProperty('justify-content', 'center', 'important');
                    button.style.setProperty('font-weight', '700', 'important');
                    button.style.setProperty('font-size', '1.1rem', 'important');
                });
            }, 1000);

            console.log('Emergency Slider Fix: Complete');
        });
    </script>
    <?php
}
add_action('wp_footer', 'ayam_emergency_slider_fix_js', 999);
// Emergency button fix CSS
function ayam_emergency_button_fix()
{
    wp_enqueue_style(
        'ayam-emergency-button-fix',
        get_template_directory_uri() . '/assets/css/emergency-button-fix.css',
        array(),
        '1.0.1'
    );
}
add_action('wp_enqueue_scripts', 'ayam_emergency_button_fix', 999);

// Emergency button fix JavaScript
function ayam_emergency_button_fix_js()
{
    wp_enqueue_script(
        'ayam-emergency-button-fix-js',
        get_template_directory_uri() . '/assets/js/emergency-button-fix.js',
        array('jquery'),
        '1.0.1',
        true
    );
}
add_action('wp_enqueue_scripts', 'ayam_emergency_button_fix_js', 999);

// Ultimate button and slider fixes
function ayam_ultimate_slider_fixes()
{
    wp_enqueue_style(
        "ayam-ultimate-button-fix",
        get_template_directory_uri() . "/assets/css/ultimate-button-fix.css",
        array(),
        "1.0.2"
    );
    wp_enqueue_script(
        "ayam-ultimate-button-fix-js",
        get_template_directory_uri() . "/assets/js/ultimate-button-fix.js",
        array(),
        "1.0.2",
        true
    );
}
add_action("wp_enqueue_scripts", "ayam_ultimate_slider_fixes", 1000);

// Simple button fix - no debugging
function ayam_simple_button_fix()
{
    wp_enqueue_script(
        "ayam-simple-button-fix",
        get_template_directory_uri() . "/assets/js/simple-button-fix.js",
        array(),
        "1.0.3",
        true
    );
}
add_action("wp_enqueue_scripts", "ayam_simple_button_fix", 1001);

// ========================================
// คุณสมบัติพิเศษ (Special Features)
// ========================================

// 1. เครื่องคำนวณราคาไก่ชน (Rooster Price Calculator)
function ayam_rooster_price_calculator()
{
    wp_enqueue_style(
        'ayam-price-calculator',
        get_template_directory_uri() . '/assets/css/price-calculator.css',
        array(),
        '1.0.0'
    );
    wp_enqueue_script(
        'ayam-price-calculator-js',
        get_template_directory_uri() . '/assets/js/price-calculator.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Localize script สำหรับ AJAX
    wp_localize_script('ayam-price-calculator-js', 'ayam_calculator_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ayam_calculator_nonce'),
        'currency' => 'THB',
        'currency_symbol' => '฿'
    ));
}
// add_action('wp_enqueue_scripts', 'ayam_rooster_price_calculator'); // Disabled - files not created yet

// AJAX handler สำหรับการคำนวณราคา
function ayam_calculate_rooster_price()
{
    // ตรวจสอบ nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_calculator_nonce')) {
        wp_die('Security check failed');
    }

    $breed = sanitize_text_field($_POST['breed'] ?? '');
    $age_months = intval($_POST['age_months'] ?? 0);
    $weight = floatval($_POST['weight'] ?? 0);
    $quality = sanitize_text_field($_POST['quality'] ?? 'standard');
    $training_level = sanitize_text_field($_POST['training_level'] ?? 'none');
    $bloodline = sanitize_text_field($_POST['bloodline'] ?? 'local');

    // ราคาฐานตามสายพันธุ์
    $base_prices = array(
        'thai-asil' => 15000,
        'shamo' => 12000,
        'malay' => 10000,
        'kelso' => 18000,
        'hatch' => 16000,
        'sweater' => 14000,
        'roundhead' => 13000,
        'grey' => 11000,
        'local' => 5000
    );

    $base_price = $base_prices[$breed] ?? 8000;

    // คำนวณราคาตามปัจจัยต่างๆ
    $price = $base_price;

    // ปรับราคาตามอายุ (อายุ 8-18 เดือนราคาสูงสุด)
    if ($age_months >= 8 && $age_months <= 18) {
        $price *= 1.2;
    } elseif ($age_months > 18 && $age_months <= 24) {
        $price *= 1.1;
    } elseif ($age_months > 24) {
        $price *= 0.9;
    } elseif ($age_months < 8) {
        $price *= 0.8;
    }

    // ปรับราคาตามน้ำหนัก
    if ($weight >= 2.5 && $weight <= 3.5) {
        $price *= 1.15;
    } elseif ($weight > 3.5) {
        $price *= 1.1;
    } elseif ($weight < 2.0) {
        $price *= 0.9;
    }

    // ปรับราคาตามคุณภาพ
    $quality_multipliers = array(
        'champion' => 2.5,
        'premium' => 1.8,
        'high' => 1.4,
        'standard' => 1.0,
        'basic' => 0.7
    );
    $price *= $quality_multipliers[$quality] ?? 1.0;

    // ปรับราคาตามระดับการฝึก
    $training_multipliers = array(
        'professional' => 1.5,
        'advanced' => 1.3,
        'intermediate' => 1.2,
        'basic' => 1.1,
        'none' => 1.0
    );
    $price *= $training_multipliers[$training_level] ?? 1.0;

    // ปรับราคาตามสายเลือด
    $bloodline_multipliers = array(
        'imported' => 1.8,
        'champion_line' => 1.6,
        'premium_local' => 1.3,
        'local' => 1.0
    );
    $price *= $bloodline_multipliers[$bloodline] ?? 1.0;

    // คำนวณช่วงราคา (±20%)
    $min_price = $price * 0.8;
    $max_price = $price * 1.2;

    wp_send_json_success(array(
        'estimated_price' => round($price),
        'min_price' => round($min_price),
        'max_price' => round($max_price),
        'factors' => array(
            'breed' => $breed,
            'age_months' => $age_months,
            'weight' => $weight,
            'quality' => $quality,
            'training_level' => $training_level,
            'bloodline' => $bloodline
        )
    ));
}
add_action('wp_ajax_calculate_rooster_price', 'ayam_calculate_rooster_price');
add_action('wp_ajax_nopriv_calculate_rooster_price', 'ayam_calculate_rooster_price');

// 2. ปฏิทินกิจกรรม (Events Calendar)
function ayam_events_calendar()
{
    wp_enqueue_style(
        'ayam-events-calendar',
        get_template_directory_uri() . '/assets/css/events-calendar.css',
        array(),
        '1.0.0'
    );
    wp_enqueue_script(
        'ayam-events-calendar-js',
        get_template_directory_uri() . '/assets/js/events-calendar.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Localize script
    wp_localize_script('ayam-events-calendar-js', 'ayam_calendar_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ayam_calendar_nonce'),
        'months' => array(
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
        ),
        'days' => array('อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส')
    ));
}
// add_action('wp_enqueue_scripts', 'ayam_events_calendar'); // Disabled - files not created yet

// AJAX handler สำหรับดึงข้อมูลกิจกรรม
function ayam_get_calendar_events()
{
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_calendar_nonce')) {
        wp_die('Security check failed');
    }

    $month = intval($_POST['month'] ?? date('n'));
    $year = intval($_POST['year'] ?? date('Y'));

    // ดึงข้อมูลกิจกรรมจากฐานข้อมูล
    $events = array();

    // ตัวอย่างกิจกรรม (ในการใช้งานจริงควรดึงจากฐานข้อมูล)
    $sample_events = array(
        array(
            'date' => $year . '-' . sprintf('%02d', $month) . '-15',
            'title' => 'การแข่งขันไก่ชนประจำเดือน',
            'type' => 'competition',
            'location' => 'สนามแข่งขันหลัก'
        ),
        array(
            'date' => $year . '-' . sprintf('%02d', $month) . '-22',
            'title' => 'อบรมการเลี้ยงไก่ชน',
            'type' => 'training',
            'location' => 'ศูนย์ฝึกอบรม'
        )
    );

    wp_send_json_success(array(
        'events' => $sample_events,
        'month' => $month,
        'year' => $year
    ));
}
add_action('wp_ajax_get_calendar_events', 'ayam_get_calendar_events');
add_action('wp_ajax_nopriv_get_calendar_events', 'ayam_get_calendar_events');

// 3. ระบบแชทสด (Live Chat)
function ayam_live_chat()
{
    wp_enqueue_style(
        'ayam-live-chat',
        get_template_directory_uri() . '/assets/css/live-chat.css',
        array(),
        '1.0.0'
    );
    wp_enqueue_script(
        'ayam-live-chat-js',
        get_template_directory_uri() . '/assets/js/live-chat.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Localize script
    wp_localize_script('ayam-live-chat-js', 'ayam_chat_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ayam_chat_nonce'),
        'user_id' => get_current_user_id(),
        'user_name' => wp_get_current_user()->display_name ?: 'ผู้เยี่ยมชม',
        'messages' => array(
            'welcome' => 'สวัสดีครับ! มีอะไรให้ช่วยเหลือไหมครับ?',
            'offline' => 'ขณะนี้เจ้าหน้าที่ไม่อยู่ กรุณาฝากข้อความไว้ครับ',
            'connecting' => 'กำลังเชื่อมต่อ...',
            'send_placeholder' => 'พิมพ์ข้อความ...'
        )
    ));
}
add_action('wp_enqueue_scripts', 'ayam_live_chat');

// AJAX handler สำหรับส่งข้อความแชท
function ayam_send_chat_message()
{
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_chat_nonce')) {
        wp_die('Security check failed');
    }

    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $user_id = get_current_user_id();
    $user_name = wp_get_current_user()->display_name ?: 'ผู้เยี่ยมชม';
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');

    if (empty($message)) {
        wp_send_json_error('ข้อความไม่สามารถว่างได้');
    }

    // บันทึกข้อความลงฐานข้อมูล (ตัวอย่าง)
    global $wpdb;

    $table_name = $wpdb->prefix . 'ayam_chat_messages';

    $result = $wpdb->insert(
        $table_name,
        array(
            'session_id' => $session_id,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'message' => $message,
            'message_type' => 'user',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%d', '%s', '%s', '%s', '%s')
    );

    if ($result) {
        // ส่งการตอบกลับอัตโนมัติ (ตัวอย่าง)
        $auto_reply = ayam_get_auto_reply($message);
        if ($auto_reply) {
            $wpdb->insert(
                $table_name,
                array(
                    'session_id' => $session_id,
                    'user_id' => 0,
                    'user_name' => 'ระบบอัตโนมัติ',
                    'message' => $auto_reply,
                    'message_type' => 'system',
                    'created_at' => current_time('mysql')
                ),
                array('%s', '%d', '%s', '%s', '%s', '%s')
            );
        }

        wp_send_json_success(array(
            'message' => 'ส่งข้อความสำเร็จ',
            'auto_reply' => $auto_reply
        ));
    } else {
        wp_send_json_error('เกิดข้อผิดพลาดในการส่งข้อความ');
    }
}
add_action('wp_ajax_send_chat_message', 'ayam_send_chat_message');
add_action('wp_ajax_nopriv_send_chat_message', 'ayam_send_chat_message');

// ฟังก์ชันสำหรับการตอบกลับอัตโนมัติ
function ayam_get_auto_reply($message)
{
    $message = strtolower($message);

    $replies = array(
        'สวัสดี' => 'สวัสดีครับ! ยินดีต้อนรับสู่ ayam-bangkok',
        'ราคา' => 'สำหรับข้อมูลราคาไก่ชน กรุณาดูในหน้าแคตตาล็อกหรือใช้เครื่องคำนวณราคาครับ',
        'ติดต่อ' => 'สามารถติดต่อเราได้ที่ โทร: 02-xxx-xxxx หรือ Line: @ayam-bangkok',
        'เวลาทำการ' => 'เวลาทำการ: จันทร์-เสาร์ 8:00-18:00 น.',
        'สถานที่' => 'ที่อยู่: กรุงเทพมหานคร (ดูรายละเอียดในหน้าติดต่อเรา)',
        'การส่ง' => 'เรามีบริการจัดส่งทั่วประเทศครับ ค่าส่งขึ้นอยู่กับระยะทาง'
    );

    foreach ($replies as $keyword => $reply) {
        if (strpos($message, $keyword) !== false) {
            return $reply;
        }
    }

    return 'ขอบคุณสำหรับข้อความครับ เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด';
}

// สร้างตารางฐานข้อมูลสำหรับแชท
function ayam_create_chat_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'ayam_chat_messages';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        session_id varchar(100) NOT NULL,
        user_id bigint(20) DEFAULT 0,
        user_name varchar(100) NOT NULL,
        message text NOT NULL,
        message_type varchar(20) DEFAULT 'user',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY session_id (session_id),
        KEY created_at (created_at)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// เรียกใช้ฟังก์ชันสร้างตารางเมื่อเปิดใช้งานธีม
function ayam_theme_activation()
{
    ayam_create_chat_table();
}
add_action('after_switch_theme', 'ayam_theme_activation');

// Shortcode สำหรับแสดงเครื่องคำนวณราคา
function ayam_price_calculator_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'title' => 'เครื่องคำนวณราคาไก่ชน'
    ), $atts);

    ob_start();
    ?>
    <div class="ayam-price-calculator">
        <h3><?php echo esc_html($atts['title']); ?></h3>
        <form id="rooster-price-form">
            <div class="calculator-row">
                <label>สายพันธุ์:</label>
                <select name="breed" required>
                    <option value="">เลือกสายพันธุ์</option>
                    <option value="thai-asil">ไทยอาซิล</option>
                    <option value="shamo">ชาโม</option>
                    <option value="malay">มาเลย์</option>
                    <option value="kelso">เคลโซ</option>
                    <option value="hatch">แฮทช์</option>
                    <option value="sweater">สเวทเตอร์</option>
                    <option value="roundhead">ราวด์เฮด</option>
                    <option value="grey">เกรย์</option>
                    <option value="local">พันธุ์ท้องถิ่น</option>
                </select>
            </div>

            <div class="calculator-row">
                <label>อายุ (เดือน):</label>
                <input type="number" name="age_months" min="1" max="60" required>
            </div>

            <div class="calculator-row">
                <label>น้ำหนัก (กก.):</label>
                <input type="number" name="weight" min="1" max="5" step="0.1" required>
            </div>

            <div class="calculator-row">
                <label>คุณภาพ:</label>
                <select name="quality" required>
                    <option value="basic">พื้นฐาน</option>
                    <option value="standard" selected>มาตรฐาน</option>
                    <option value="high">สูง</option>
                    <option value="premium">พรีเมียม</option>
                    <option value="champion">แชมป์</option>
                </select>
            </div>

            <div class="calculator-row">
                <label>ระดับการฝึก:</label>
                <select name="training_level">
                    <option value="none" selected>ไม่ได้ฝึก</option>
                    <option value="basic">พื้นฐาน</option>
                    <option value="intermediate">ปานกลาง</option>
                    <option value="advanced">สูง</option>
                    <option value="professional">มืออาชีพ</option>
                </select>
            </div>

            <div class="calculator-row">
                <label>สายเลือด:</label>
                <select name="bloodline">
                    <option value="local" selected>ท้องถิ่น</option>
                    <option value="premium_local">ท้องถิ่นพรีเมียม</option>
                    <option value="champion_line">สายแชมป์</option>
                    <option value="imported">นำเข้า</option>
                </select>
            </div>

            <button type="submit" class="calculate-btn">คำนวณราคา</button>
        </form>

        <div id="price-result" class="price-result" style="display: none;">
            <h4>ราคาประเมิน</h4>
            <div class="price-range">
                <span class="min-price"></span> - <span class="max-price"></span> บาท
            </div>
            <div class="estimated-price">
                ราคาประเมิน: <span class="price-value"></span> บาท
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ayam_price_calculator', 'ayam_price_calculator_shortcode');

// Shortcode สำหรับแสดงปฏิทินกิจกรรม
function ayam_events_calendar_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'title' => 'ปฏิทินกิจกรรม'
    ), $atts);

    ob_start();
    ?>
    <div class="ayam-events-calendar">
        <h3><?php echo esc_html($atts['title']); ?></h3>
        <div class="calendar-header">
            <button id="prev-month">&lt;</button>
            <span id="current-month-year"></span>
            <button id="next-month">&gt;</button>
        </div>
        <div class="calendar-grid">
            <div class="calendar-days-header">
                <div>อา</div>
                <div>จ</div>
                <div>อ</div>
                <div>พ</div>
                <div>พฤ</div>
                <div>ศ</div>
                <div>ส</div>
            </div>
            <div id="calendar-days" class="calendar-days"></div>
        </div>
        <div id="events-list" class="events-list"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ayam_events_calendar', 'ayam_events_calendar_shortcode');

// Shortcode สำหรับแสดงแชทสด
function ayam_live_chat_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'position' => 'bottom-right'
    ), $atts);

    ob_start();
    ?>
    <div class="ayam-live-chat" data-position="<?php echo esc_attr($atts['position']); ?>">
        <div class="chat-toggle">
            <i class="fas fa-comment-dots"></i>
            <span class="chat-text">แชทสด</span>
        </div>
        <div class="chat-window" style="display: none;">
            <div class="chat-header">
                <span>แชทสด - Nongchok FCI</span>
                <button class="chat-close">&times;</button>
            </div>
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input">
                <input type="text" id="chat-message-input" placeholder="พิมพ์ข้อความของคุณ...">
                <button id="send-message"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ayam_live_chat', 'ayam_live_chat_shortcode');

// เพิ่มแชทสดในทุกหน้าโดยอัตโนมัติ
function ayam_add_live_chat_to_footer()
{
    if (!is_admin()) {
        echo do_shortcode('[ayam_live_chat position="bottom-right"]');
    }
}
add_action('wp_footer', 'ayam_add_live_chat_to_footer');

// ========================================
// AJAX Handlers for Advanced Rooster Catalog
// ========================================

/**
 * AJAX handler for rooster filtering
 */
function ayam_filter_roosters()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'rooster_catalog_nonce')) {
        wp_die('Security check failed');
    }

    $args = array(
        'post_type' => 'ayam_rooster',
        'post_status' => 'publish',
        'posts_per_page' => isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 12,
        'paged' => isset($_POST['page']) ? intval($_POST['page']) : 1,
        'meta_query' => array('relation' => 'AND'),
        'tax_query' => array('relation' => 'AND')
    );

    // Search query
    if (!empty($_POST['search'])) {
        $args['s'] = sanitize_text_field($_POST['search']);
    }

    // Breed filter
    if (!empty($_POST['breed']) && $_POST['breed'] !== 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'rooster_breed',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['breed'])
        );
    }

    // Category filter
    if (!empty($_POST['category']) && $_POST['category'] !== 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'rooster_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['category'])
        );
    }

    // Price range filter
    if (!empty($_POST['min_price']) || !empty($_POST['max_price'])) {
        $price_query = array(
            'key' => 'rooster_price',
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        );

        $min_price = !empty($_POST['min_price']) ? intval($_POST['min_price']) : 0;
        $max_price = !empty($_POST['max_price']) ? intval($_POST['max_price']) : 999999;

        $price_query['value'] = array($min_price, $max_price);
        $args['meta_query'][] = $price_query;
    }

    // Age filter
    if (!empty($_POST['age'])) {
        $args['meta_query'][] = array(
            'key' => 'rooster_age',
            'value' => sanitize_text_field($_POST['age']),
            'compare' => 'LIKE'
        );
    }

    // Weight filter
    if (!empty($_POST['weight'])) {
        $args['meta_query'][] = array(
            'key' => 'rooster_weight',
            'value' => sanitize_text_field($_POST['weight']),
            'compare' => 'LIKE'
        );
    }

    // Status filter
    if (!empty($_POST['status']) && $_POST['status'] !== 'all') {
        $args['meta_query'][] = array(
            'key' => 'rooster_status',
            'value' => sanitize_text_field($_POST['status']),
            'compare' => '='
        );
    }

    // Sorting
    if (!empty($_POST['orderby'])) {
        switch ($_POST['orderby']) {
            case 'price_low':
                $args['meta_key'] = 'rooster_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                break;
            case 'price_high':
                $args['meta_key'] = 'rooster_price';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'newest':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
            case 'oldest':
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
                break;
            case 'name':
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
                break;
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
        }
    }

    $query = new WP_Query($args);

    $response = array(
        'success' => true,
        'data' => array(
            'posts' => array(),
            'pagination' => array(
                'current_page' => $args['paged'],
                'total_pages' => $query->max_num_pages,
                'total_posts' => $query->found_posts,
                'posts_per_page' => $args['posts_per_page']
            )
        )
    );

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $rooster_data = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'rooster-card'),
                'price' => get_post_meta(get_the_ID(), 'rooster_price', true),
                'age' => get_post_meta(get_the_ID(), 'rooster_age', true),
                'weight' => get_post_meta(get_the_ID(), 'rooster_weight', true),
                'status' => get_post_meta(get_the_ID(), 'rooster_status', true),
                'breed' => wp_get_post_terms(get_the_ID(), 'rooster_breed', array('fields' => 'names')),
                'category' => wp_get_post_terms(get_the_ID(), 'rooster_category', array('fields' => 'names')),
                'excerpt' => get_the_excerpt()
            );

            $response['data']['posts'][] = $rooster_data;
        }
    }

    wp_reset_postdata();

    wp_send_json($response);
}
add_action('wp_ajax_filter_roosters', 'ayam_filter_roosters');
add_action('wp_ajax_nopriv_filter_roosters', 'ayam_filter_roosters');

/**
 * AJAX handler for adding to favorites
 */
function ayam_toggle_favorite()
{
    if (!is_user_logged_in()) {
        wp_send_json_error('กรุณาเข้าสู่ระบบก่อน');
    }

    if (!wp_verify_nonce($_POST['nonce'], 'rooster_catalog_nonce')) {
        wp_send_json_error('Security check failed');
    }

    $user_id = get_current_user_id();
    $rooster_id = intval($_POST['rooster_id']);

    $favorites = get_user_meta($user_id, 'favorite_roosters', true);
    if (!is_array($favorites)) {
        $favorites = array();
    }

    $is_favorite = in_array($rooster_id, $favorites);

    if ($is_favorite) {
        // Remove from favorites
        $favorites = array_diff($favorites, array($rooster_id));
        $message = 'ลบออกจากรายการโปรดแล้ว';
    } else {
        // Add to favorites
        $favorites[] = $rooster_id;
        $message = 'เพิ่มในรายการโปรดแล้ว';
    }

    update_user_meta($user_id, 'favorite_roosters', $favorites);

    wp_send_json_success(array(
        'is_favorite' => !$is_favorite,
        'message' => $message
    ));
}
add_action('wp_ajax_toggle_favorite', 'ayam_toggle_favorite');

/**
 * AJAX handler for getting rooster comparison data
 */
function ayam_get_rooster_comparison()
{
    if (!wp_verify_nonce($_POST['nonce'], 'rooster_catalog_nonce')) {
        wp_send_json_error('Security check failed');
    }

    $rooster_ids = array_map('intval', $_POST['rooster_ids']);

    if (empty($rooster_ids) || count($rooster_ids) > 3) {
        wp_send_json_error('จำนวนไก่ชนที่เปรียบเทียบไม่ถูกต้อง');
    }

    $roosters = array();

    foreach ($rooster_ids as $rooster_id) {
        $post = get_post($rooster_id);
        if ($post && $post->post_type === 'ayam_rooster') {
            $roosters[] = array(
                'id' => $rooster_id,
                'title' => get_the_title($rooster_id),
                'permalink' => get_permalink($rooster_id),
                'featured_image' => get_the_post_thumbnail_url($rooster_id, 'rooster-card'),
                'price' => get_post_meta($rooster_id, 'rooster_price', true),
                'age' => get_post_meta($rooster_id, 'rooster_age', true),
                'weight' => get_post_meta($rooster_id, 'rooster_weight', true),
                'height' => get_post_meta($rooster_id, 'rooster_height', true),
                'status' => get_post_meta($rooster_id, 'rooster_status', true),
                'breed' => wp_get_post_terms($rooster_id, 'rooster_breed', array('fields' => 'names')),
                'category' => wp_get_post_terms($rooster_id, 'rooster_category', array('fields' => 'names')),
                'description' => get_post_field('post_content', $rooster_id),
                'features' => get_post_meta($rooster_id, 'rooster_features', true)
            );
        }
    }

    wp_send_json_success($roosters);
}
add_action('wp_ajax_get_rooster_comparison', 'ayam_get_rooster_comparison');
add_action('wp_ajax_nopriv_get_rooster_comparison', 'ayam_get_rooster_comparison');

/**
 * AJAX handler for quick filters
 */
function ayam_quick_filter_roosters()
{
    if (!wp_verify_nonce($_POST['nonce'], 'rooster_catalog_nonce')) {
        wp_send_json_error('Security check failed');
    }

    $filter_type = sanitize_text_field($_POST['filter_type']);

    $args = array(
        'post_type' => 'ayam_rooster',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'meta_query' => array()
    );

    switch ($filter_type) {
        case 'available':
            $args['meta_query'][] = array(
                'key' => 'rooster_status',
                'value' => 'available',
                'compare' => '='
            );
            break;
        case 'premium':
            $args['meta_query'][] = array(
                'key' => 'rooster_price',
                'value' => 50000,
                'type' => 'NUMERIC',
                'compare' => '>='
            );
            break;
        case 'young':
            $args['meta_query'][] = array(
                'key' => 'rooster_age',
                'value' => array('3-6 เดือน', '6-12 เดือน'),
                'compare' => 'IN'
            );
            break;
        case 'champion':
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'rooster_category',
                    'field' => 'slug',
                    'terms' => 'champion'
                )
            );
            break;
    }

    $query = new WP_Query($args);

    $response = array(
        'success' => true,
        'data' => array(
            'posts' => array(),
            'total_posts' => $query->found_posts
        )
    );

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $rooster_data = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'rooster-card'),
                'price' => get_post_meta(get_the_ID(), 'rooster_price', true),
                'age' => get_post_meta(get_the_ID(), 'rooster_age', true),
                'weight' => get_post_meta(get_the_ID(), 'rooster_weight', true),
                'status' => get_post_meta(get_the_ID(), 'rooster_status', true),
                'breed' => wp_get_post_terms(get_the_ID(), 'rooster_breed', array('fields' => 'names')),
                'category' => wp_get_post_terms(get_the_ID(), 'rooster_category', array('fields' => 'names'))
            );

            $response['data']['posts'][] = $rooster_data;
        }
    }

    wp_reset_postdata();

    wp_send_json($response);
}
add_action('wp_ajax_quick_filter_roosters', 'ayam_quick_filter_roosters');
add_action('wp_ajax_nopriv_quick_filter_roosters', 'ayam_quick_filter_roosters');

// ========================================
// Member System AJAX Handlers
// ========================================

/**
 * Handle member registration
 */
function ayam_handle_member_registration()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_member_nonce')) {
        wp_send_json_error(__('การตรวจสอบความปลอดภัยล้มเหลว', 'ayam-bangkok'));
    }

    // Sanitize input data
    $membership_type = sanitize_text_field($_POST['membership_type']);
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $phone = sanitize_text_field($_POST['phone']);
    $address = sanitize_textarea_field($_POST['address']);
    $province = sanitize_text_field($_POST['province']);
    $postal_code = sanitize_text_field($_POST['postal_code']);
    $birth_date = sanitize_text_field($_POST['birth_date']);
    $gender = sanitize_text_field($_POST['gender']);
    $terms_accepted = isset($_POST['terms_accepted']) ? true : false;

    // Premium member fields
    $company_name = '';
    $company_address = '';
    $tax_id = '';
    $business_type = '';

    if ($membership_type === 'premium') {
        $company_name = sanitize_text_field($_POST['company_name']);
        $company_address = sanitize_textarea_field($_POST['company_address']);
        $tax_id = sanitize_text_field($_POST['tax_id']);
        $business_type = sanitize_text_field($_POST['business_type']);
    }

    // Validation
    $errors = array();

    if (empty($username)) {
        $errors[] = __('กรุณากรอกชื่อผู้ใช้', 'ayam-bangkok');
    } elseif (username_exists($username)) {
        $errors[] = __('ชื่อผู้ใช้นี้มีอยู่แล้ว', 'ayam-bangkok');
    }

    if (empty($email)) {
        $errors[] = __('กรุณากรอกอีเมล', 'ayam-bangkok');
    } elseif (!is_email($email)) {
        $errors[] = __('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok');
    } elseif (email_exists($email)) {
        $errors[] = __('อีเมลนี้มีอยู่แล้ว', 'ayam-bangkok');
    }

    if (empty($password)) {
        $errors[] = __('กรุณากรอกรหัสผ่าน', 'ayam-bangkok');
    } elseif (strlen($password) < 8) {
        $errors[] = __('รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร', 'ayam-bangkok');
    }

    if ($password !== $confirm_password) {
        $errors[] = __('รหัสผ่านไม่ตรงกัน', 'ayam-bangkok');
    }

    if (empty($first_name)) {
        $errors[] = __('กรุณากรอกชื่อ', 'ayam-bangkok');
    }

    if (empty($last_name)) {
        $errors[] = __('กรุณากรอกนามสกุล', 'ayam-bangkok');
    }

    if (empty($phone)) {
        $errors[] = __('กรุณากรอกเบอร์โทรศัพท์', 'ayam-bangkok');
    }

    if (!$terms_accepted) {
        $errors[] = __('กรุณายอมรับข้อกำหนดและเงื่อนไข', 'ayam-bangkok');
    }

    // Premium member validation
    if ($membership_type === 'premium') {
        if (empty($company_name)) {
            $errors[] = __('กรุณากรอกชื่อบริษัท', 'ayam-bangkok');
        }
        if (empty($tax_id)) {
            $errors[] = __('กรุณากรอกเลขประจำตัวผู้เสียภาษี', 'ayam-bangkok');
        }
    }

    if (!empty($errors)) {
        wp_send_json_error(implode('<br>', $errors));
    }

    // Create user
    $user_data = array(
        'user_login' => $username,
        'user_email' => $email,
        'user_pass' => $password,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $first_name . ' ' . $last_name,
        'role' => $membership_type === 'premium' ? 'premium_member' : 'regular_member'
    );

    $user_id = wp_insert_user($user_data);

    if (is_wp_error($user_id)) {
        wp_send_json_error(__('เกิดข้อผิดพลาดในการสร้างบัญชี: ', 'ayam-bangkok') . $user_id->get_error_message());
    }

    // Save additional user meta
    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'address', $address);
    update_user_meta($user_id, 'province', $province);
    update_user_meta($user_id, 'postal_code', $postal_code);
    update_user_meta($user_id, 'birth_date', $birth_date);
    update_user_meta($user_id, 'gender', $gender);
    update_user_meta($user_id, 'membership_type', $membership_type);
    update_user_meta($user_id, 'registration_date', current_time('mysql'));

    // Save premium member data
    if ($membership_type === 'premium') {
        update_user_meta($user_id, 'company_name', $company_name);
        update_user_meta($user_id, 'company_address', $company_address);
        update_user_meta($user_id, 'tax_id', $tax_id);
        update_user_meta($user_id, 'business_type', $business_type);
    }

    // Send welcome email
    $site_name = get_bloginfo('name');
    $welcome_subject = sprintf('[%s] ยินดีต้อนรับสู่ระบบสมาชิก', $site_name);
    $membership_name = $membership_type === 'premium' ? 'สมาชิกพิเศษ' : 'สมาชิกทั่วไป';

    $welcome_message = sprintf(
        "เรียน คุณ%s %s\n\n" .
        "ยินดีต้อนรับสู่ระบบสมาชิก %s\n\n" .
        "ข้อมูลการสมัครสมาชิก:\n" .
        "ประเภทสมาชิก: %s\n" .
        "ชื่อผู้ใช้: %s\n" .
        "อีเมล: %s\n\n" .
        "คุณสามารถเข้าสู่ระบบได้ที่: %s\n\n" .
        "ขอบคุณที่เป็นส่วนหนึ่งของครอบครัว %s\n\n" .
        "ทีมงาน %s",
        $first_name,
        $last_name,
        $site_name,
        $membership_name,
        $username,
        $email,
        wp_login_url(),
        $site_name,
        $site_name
    );

    wp_mail($email, $welcome_subject, $welcome_message);

    // Send notification to admin
    $admin_email = get_option('admin_email');
    $admin_subject = sprintf('[%s] สมาชิกใหม่สมัครเข้าร่วม', $site_name);
    $admin_message = sprintf(
        "มีสมาชิกใหม่สมัครเข้าร่วม\n\n" .
        "ชื่อ: %s %s\n" .
        "ประเภทสมาชิก: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n" .
        "วันที่สมัคร: %s\n\n" .
        "ดูข้อมูลเพิ่มเติมได้ที่: %s",
        $first_name,
        $last_name,
        $membership_name,
        $email,
        $phone,
        current_time('Y-m-d H:i:s'),
        admin_url('users.php')
    );

    wp_mail($admin_email, $admin_subject, $admin_message);

    wp_send_json_success(array(
        'message' => __('สมัครสมาชิกสำเร็จ! กรุณาตรวจสอบอีเมลเพื่อยืนยันการสมัคร', 'ayam-bangkok'),
        'redirect' => wp_login_url()
    ));
}
add_action('wp_ajax_ayam_member_registration', 'ayam_handle_member_registration');
add_action('wp_ajax_nopriv_ayam_member_registration', 'ayam_handle_member_registration');

/**
 * Check username availability
 */
function ayam_check_username_availability()
{
    $username = sanitize_user($_POST['username']);

    if (empty($username)) {
        wp_send_json_error(__('กรุณากรอกชื่อผู้ใช้', 'ayam-bangkok'));
    }

    if (username_exists($username)) {
        wp_send_json_error(__('ชื่อผู้ใช้นี้มีอยู่แล้ว', 'ayam-bangkok'));
    }

    wp_send_json_success(__('ชื่อผู้ใช้นี้สามารถใช้ได้', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_check_username', 'ayam_check_username_availability');
add_action('wp_ajax_nopriv_ayam_check_username', 'ayam_check_username_availability');

/**
 * Check email availability
 */
function ayam_check_email_availability()
{
    $email = sanitize_email($_POST['email']);

    if (empty($email)) {
        wp_send_json_error(__('กรุณากรอกอีเมล', 'ayam-bangkok'));
    }

    if (!is_email($email)) {
        wp_send_json_error(__('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok'));
    }

    if (email_exists($email)) {
        wp_send_json_error(__('อีเมลนี้มีอยู่แล้ว', 'ayam-bangkok'));
    }

    wp_send_json_success(__('อีเมลนี้สามารถใช้ได้', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_check_email', 'ayam_check_email_availability');
add_action('wp_ajax_nopriv_ayam_check_email', 'ayam_check_email_availability');

/**
 * Handle member login
 */
function ayam_handle_member_login()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'ayam_login_nonce')) {
        wp_send_json_error(__('การตรวจสอบความปลอดภัยล้มเหลว', 'ayam-bangkok'));
    }

    $username = sanitize_user($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    if (empty($username)) {
        wp_send_json_error(__('กรุณากรอกชื่อผู้ใช้หรืออีเมล', 'ayam-bangkok'));
    }

    if (empty($password)) {
        wp_send_json_error(__('กรุณากรอกรหัสผ่าน', 'ayam-bangkok'));
    }

    $credentials = array(
        'user_login' => $username,
        'user_password' => $password,
        'remember' => $remember
    );

    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
        wp_send_json_error(__('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง', 'ayam-bangkok'));
    }

    // Check if user is a member
    if (!in_array('premium_member', $user->roles) && !in_array('regular_member', $user->roles) && !in_array('administrator', $user->roles)) {
        wp_logout();
        wp_send_json_error(__('คุณไม่มีสิทธิ์เข้าใช้ระบบสมาชิก', 'ayam-bangkok'));
    }

    $redirect_url = isset($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url('/member-profile/');

    wp_send_json_success(array(
        'message' => __('เข้าสู่ระบบสำเร็จ', 'ayam-bangkok'),
        'redirect' => $redirect_url
    ));
}
add_action('wp_ajax_ayam_member_login', 'ayam_handle_member_login');
add_action('wp_ajax_nopriv_ayam_member_login', 'ayam_handle_member_login');

/**
 * Enqueue member system scripts and styles
 */
function ayam_enqueue_member_scripts()
{
    if (is_page_template('page-register.php') || is_page_template('page-login.php') || is_page_template('page-member-profile.php')) {
        // Enqueue register styles and scripts
        if (is_page_template('page-register.php')) {
            wp_enqueue_style('ayam-register-css', AYAM_THEME_URI . '/assets/css/register.css', array('ayam-style'), AYAM_THEME_VERSION);
            wp_enqueue_script('ayam-register-js', AYAM_THEME_URI . '/assets/js/register.js', array('jquery'), AYAM_THEME_VERSION, true);

            wp_localize_script('ayam-register-js', 'ayam_register', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ayam_member_nonce'),
                'strings' => array(
                    'checking' => __('กำลังตรวจสอบ...', 'ayam-bangkok'),
                    'available' => __('สามารถใช้ได้', 'ayam-bangkok'),
                    'unavailable' => __('ไม่สามารถใช้ได้', 'ayam-bangkok'),
                    'weak' => __('อ่อน', 'ayam-bangkok'),
                    'medium' => __('ปานกลาง', 'ayam-bangkok'),
                    'strong' => __('แข็งแกร่ง', 'ayam-bangkok'),
                    'very_strong' => __('แข็งแกร่งมาก', 'ayam-bangkok')
                )
            ));
        }

        // Enqueue login styles and scripts
        if (is_page_template('page-login.php')) {
            wp_enqueue_style('ayam-login-css', AYAM_THEME_URI . '/assets/css/login.css', array('ayam-style'), AYAM_THEME_VERSION);
            wp_enqueue_script('ayam-login-js', AYAM_THEME_URI . '/assets/js/login.js', array('jquery'), AYAM_THEME_VERSION, true);

            wp_localize_script('ayam-login-js', 'ayam_login', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ayam_login_nonce')
            ));
        }

        // Enqueue member profile styles and scripts
        if (is_page_template('page-member-profile.php')) {
            wp_enqueue_style('ayam-member-profile-css', AYAM_THEME_URI . '/assets/css/member-profile.css', array('ayam-style'), AYAM_THEME_VERSION);
            wp_enqueue_script('ayam-member-profile-js', AYAM_THEME_URI . '/assets/js/member-profile.js', array('jquery'), AYAM_THEME_VERSION, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'ayam_enqueue_member_scripts');

// ===== NEWS & EVENTS PAGE FUNCTIONS =====

// Enqueue News & Events page assets
function ayam_news_page_assets()
{
    if (is_page_template('page-news.php') || is_page('news') || is_page('ข่าวสาร')) {
        // Enqueue News CSS
        wp_enqueue_style(
            'ayam-news-style',
            get_template_directory_uri() . '/assets/css/news.css',
            array(),
            '1.0.0'
        );

        // Enqueue News JavaScript
        wp_enqueue_script(
            'ayam-news-script',
            get_template_directory_uri() . '/assets/js/news.js',
            array('jquery'),
            '1.0.0',
            true
        );

        // Localize script for AJAX
        wp_localize_script('ayam-news-script', 'ayam_news_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ayam_news_nonce'),
            'template_url' => get_template_directory_uri()
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_news_page_assets');

// Create News Custom Post Type
function ayam_create_news_post_type()
{
    $labels = array(
        'name' => __('ข่าวสาร', 'ayam-bangkok'),
        'singular_name' => __('ข่าวสาร', 'ayam-bangkok'),
        'menu_name' => __('ข่าวสาร', 'ayam-bangkok'),
        'add_new' => __('เพิ่มข่าวใหม่', 'ayam-bangkok'),
        'add_new_item' => __('เพิ่มข่าวใหม่', 'ayam-bangkok'),
        'edit_item' => __('แก้ไขข่าว', 'ayam-bangkok'),
        'new_item' => __('ข่าวใหม่', 'ayam-bangkok'),
        'view_item' => __('ดูข่าว', 'ayam-bangkok'),
        'search_items' => __('ค้นหาข่าว', 'ayam-bangkok'),
        'not_found' => __('ไม่พบข่าว', 'ayam-bangkok'),
        'not_found_in_trash' => __('ไม่พบข่าวในถังขยะ', 'ayam-bangkok')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'news'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author', 'custom-fields'),
        'show_in_rest' => true
    );

    register_post_type('ayam_news', $args);
}
add_action('init', 'ayam_create_news_post_type');

// Create News Categories Taxonomy
function ayam_create_news_categories()
{
    $labels = array(
        'name' => __('หมวดหมู่ข่าว', 'ayam-bangkok'),
        'singular_name' => __('หมวดหมู่ข่าว', 'ayam-bangkok'),
        'search_items' => __('ค้นหาหมวดหมู่', 'ayam-bangkok'),
        'all_items' => __('หมวดหมู่ทั้งหมด', 'ayam-bangkok'),
        'edit_item' => __('แก้ไขหมวดหมู่', 'ayam-bangkok'),
        'update_item' => __('อัปเดตหมวดหมู่', 'ayam-bangkok'),
        'add_new_item' => __('เพิ่มหมวดหมู่ใหม่', 'ayam-bangkok'),
        'new_item_name' => __('ชื่อหมวดหมู่ใหม่', 'ayam-bangkok'),
        'menu_name' => __('หมวดหมู่ข่าว', 'ayam-bangkok')
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'news-category'),
        'show_in_rest' => true
    );

    register_taxonomy('news_category', array('ayam_news'), $args);
}
add_action('init', 'ayam_create_news_categories');

// Add default news categories
function ayam_add_default_news_categories()
{
    if (!term_exists('ข่าวสาร', 'news_category')) {
        wp_insert_term('ข่าวสาร', 'news_category', array(
            'description' => 'ข่าวสารทั่วไปของบริษัท',
            'slug' => 'news'
        ));
    }

    if (!term_exists('กิจกรรม', 'news_category')) {
        wp_insert_term('กิจกรรม', 'news_category', array(
            'description' => 'กิจกรรมและงานแสดงต่างๆ',
            'slug' => 'events'
        ));
    }

    if (!term_exists('ประกาศ', 'news_category')) {
        wp_insert_term('ประกาศ', 'news_category', array(
            'description' => 'ประกาศสำคัญจากบริษัท',
            'slug' => 'announcements'
        ));
    }
}
add_action('init', 'ayam_add_default_news_categories');

// AJAX handler for loading more news
function ayam_load_more_news()
{
    check_ajax_referer('ayam_news_nonce', 'nonce');

    $page = intval($_POST['page']);
    $posts_per_page = 6;
    $category = sanitize_text_field($_POST['category']);

    $args = array(
        'post_type' => 'ayam_news',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'post_status' => 'publish'
    );

    if ($category && $category !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'news_category',
                'field' => 'slug',
                'terms' => $category
            )
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'news_category');
            $category_name = $categories ? $categories[0]->name : 'ข่าวสาร';
            $category_slug = $categories ? $categories[0]->slug : 'news';
            ?>
            <article class="news-item fade-in" data-category="<?php echo esc_attr($category_slug); ?>">
                <div class="news-image">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/default.jpg"
                            alt="<?php the_title(); ?>">
                    <?php endif; ?>
                    <div class="news-category"><?php echo esc_html($category_name); ?></div>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-date"><i class="fas fa-calendar"></i> <?php echo get_the_date('j F Y'); ?></span>
                        <span class="news-views"><i class="fas fa-eye"></i>
                            <?php echo get_post_meta(get_the_ID(), 'post_views', true) ?: rand(50, 300); ?></span>
                    </div>
                    <h3 class="news-title"><?php the_title(); ?></h3>
                    <p class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    <div class="news-tags">
                        <?php
                        $tags = get_the_tags();
                        if ($tags) {
                            foreach ($tags as $tag) {
                                echo '<span class="tag">' . esc_html($tag->name) . '</span>';
                            }
                        }
                        ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                </div>
            </article>
            <?php
        }
        wp_reset_postdata();
    }

    wp_die();
}
add_action('wp_ajax_load_more_news', 'ayam_load_more_news');
add_action('wp_ajax_nopriv_load_more_news', 'ayam_load_more_news');

// AJAX handler for newsletter subscription
function ayam_newsletter_subscription()
{
    check_ajax_referer('ayam_news_nonce', 'nonce');

    $email = sanitize_email($_POST['email']);

    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('กรุณากรอกอีเมลที่ถูกต้อง', 'ayam-bangkok')));
    }

    // Check if email already exists
    $existing = get_option('ayam_newsletter_subscribers', array());

    if (in_array($email, $existing)) {
        wp_send_json_error(array('message' => __('อีเมลนี้ได้สมัครรับข่าวสารแล้ว', 'ayam-bangkok')));
    }

    // Add email to subscribers list
    $existing[] = $email;
    update_option('ayam_newsletter_subscribers', $existing);

    // Send confirmation email (optional)
    $subject = __('ยืนยันการสมัครรับข่าวสาร - Ayam Bangkok', 'ayam-bangkok');
    $message = __('ขอบคุณที่สมัครรับข่าวสารจาก Ayam Bangkok คุณจะได้รับข่าวสารล่าสุดทางอีเมลนี้', 'ayam-bangkok');
    wp_mail($email, $subject, $message);

    wp_send_json_success(array('message' => __('สมัครรับข่าวสารเรียบร้อยแล้ว!', 'ayam-bangkok')));
}
add_action('wp_ajax_newsletter_subscription', 'ayam_newsletter_subscription');
add_action('wp_ajax_nopriv_newsletter_subscription', 'ayam_newsletter_subscription');

// Track post views
function ayam_track_post_views($post_id)
{
    if (!is_single())
        return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    $views = get_post_meta($post_id, 'post_views', true);
    $views = $views ? $views + 1 : 1;
    update_post_meta($post_id, 'post_views', $views);
}
add_action('wp_head', 'ayam_track_post_views');

// Add meta boxes for news posts
function ayam_add_news_meta_boxes()
{
    add_meta_box(
        'news_details',
        __('รายละเอียดข่าว', 'ayam-bangkok'),
        'ayam_news_meta_box_callback',
        'ayam_news',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'ayam_add_news_meta_boxes');

// Meta box callback function
function ayam_news_meta_box_callback($post)
{
    wp_nonce_field('ayam_news_meta_box', 'ayam_news_meta_box_nonce');

    $featured = get_post_meta($post->ID, '_news_featured', true);
    $priority = get_post_meta($post->ID, '_news_priority', true);
    $external_link = get_post_meta($post->ID, '_news_external_link', true);

    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="news_featured">' . __('ข่าวเด่น', 'ayam-bangkok') . '</label></th>';
    echo '<td><input type="checkbox" id="news_featured" name="news_featured" value="1" ' . checked($featured, 1, false) . '> ' . __('แสดงในส่วนข่าวเด่น', 'ayam-bangkok') . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th><label for="news_priority">' . __('ลำดับความสำคัญ', 'ayam-bangkok') . '</label></th>';
    echo '<td><select id="news_priority" name="news_priority">';
    echo '<option value="normal"' . selected($priority, 'normal', false) . '>' . __('ปกติ', 'ayam-bangkok') . '</option>';
    echo '<option value="high"' . selected($priority, 'high', false) . '>' . __('สูง', 'ayam-bangkok') . '</option>';
    echo '<option value="urgent"' . selected($priority, 'urgent', false) . '>' . __('ด่วน', 'ayam-bangkok') . '</option>';
    echo '</select></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th><label for="news_external_link">' . __('ลิงก์ภายนอก', 'ayam-bangkok') . '</label></th>';
    echo '<td><input type="url" id="news_external_link" name="news_external_link" value="' . esc_attr($external_link) . '" class="regular-text"> <br><small>' . __('หากระบุลิงก์ภายนอก ปุ่ม "อ่านต่อ" จะเชื่อมโยงไปยังลิงก์นี้แทน', 'ayam-bangkok') . '</small></td>';
    echo '</tr>';
    echo '</table>';
}

// Save meta box data
function ayam_save_news_meta_box($post_id)
{
    if (!isset($_POST['ayam_news_meta_box_nonce']))
        return;
    if (!wp_verify_nonce($_POST['ayam_news_meta_box_nonce'], 'ayam_news_meta_box'))
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    $featured = isset($_POST['news_featured']) ? 1 : 0;
    update_post_meta($post_id, '_news_featured', $featured);

    if (isset($_POST['news_priority'])) {
        update_post_meta($post_id, '_news_priority', sanitize_text_field($_POST['news_priority']));
    }

    if (isset($_POST['news_external_link'])) {
        update_post_meta($post_id, '_news_external_link', esc_url_raw($_POST['news_external_link']));
    }
}
add_action('save_post', 'ayam_save_news_meta_box');

// Helper function to get featured news
function ayam_get_featured_news($limit = 3)
{
    $args = array(
        'post_type' => 'ayam_news',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_news_featured',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );

    return new WP_Query($args);
}

// Helper function to get news by category
function ayam_get_news_by_category($category_slug, $limit = 6)
{
    $args = array(
        'post_type' => 'ayam_news',
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'news_category',
                'field' => 'slug',
                'terms' => $category_slug
            )
        ),
        'orderby' => 'date',
        'order' => 'DESC'
    );

    return new WP_Query($args);
}

// Knowledge Center Page Functions
function ayam_knowledge_page_styles()
{
    if (is_page_template('page-knowledge.php') || is_page('knowledge')) {
        wp_enqueue_style(
            'ayam-knowledge-css',
            get_template_directory_uri() . '/assets/css/knowledge.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'ayam-knowledge-js',
            get_template_directory_uri() . '/assets/js/knowledge.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'ayam_knowledge_page_styles');

// Register Knowledge Base Custom Post Type
function ayam_register_knowledge_post_type()
{
    $labels = array(
        'name' => __('บทความความรู้', 'ayam-bangkok'),
        'singular_name' => __('บทความ', 'ayam-bangkok'),
        'menu_name' => __('ศูนย์ความรู้', 'ayam-bangkok'),
        'name_admin_bar' => __('บทความความรู้', 'ayam-bangkok'),
        'archives' => __('คลังบทความ', 'ayam-bangkok'),
        'attributes' => __('คุณสมบัติบทความ', 'ayam-bangkok'),
        'parent_item_colon' => __('บทความหลัก:', 'ayam-bangkok'),
        'all_items' => __('บทความทั้งหมด', 'ayam-bangkok'),
        'add_new_item' => __('เพิ่มบทความใหม่', 'ayam-bangkok'),
        'add_new' => __('เพิ่มใหม่', 'ayam-bangkok'),
        'new_item' => __('บทความใหม่', 'ayam-bangkok'),
        'edit_item' => __('แก้ไขบทความ', 'ayam-bangkok'),
        'update_item' => __('อัปเดตบทความ', 'ayam-bangkok'),
        'view_item' => __('ดูบทความ', 'ayam-bangkok'),
        'view_items' => __('ดูบทความ', 'ayam-bangkok'),
        'search_items' => __('ค้นหาบทความ', 'ayam-bangkok'),
        'not_found' => __('ไม่พบบทความ', 'ayam-bangkok'),
        'not_found_in_trash' => __('ไม่พบบทความในถังขยะ', 'ayam-bangkok'),
        'featured_image' => __('รูปภาพประกอบ', 'ayam-bangkok'),
        'set_featured_image' => __('ตั้งรูปภาพประกอบ', 'ayam-bangkok'),
        'remove_featured_image' => __('ลบรูปภาพประกอบ', 'ayam-bangkok'),
        'use_featured_image' => __('ใช้เป็นรูปภาพประกอบ', 'ayam-bangkok'),
        'insert_into_item' => __('แทรกลงในบทความ', 'ayam-bangkok'),
        'uploaded_to_this_item' => __('อัปโหลดไปยังบทความนี้', 'ayam-bangkok'),
        'items_list' => __('รายการบทความ', 'ayam-bangkok'),
        'items_list_navigation' => __('การนำทางรายการบทความ', 'ayam-bangkok'),
        'filter_items_list' => __('กรองรายการบทความ', 'ayam-bangkok'),
    );

    $args = array(
        'label' => __('บทความความรู้', 'ayam-bangkok'),
        'description' => __('บทความความรู้เกี่ยวกับไก่ชน', 'ayam-bangkok'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields'),
        'taxonomies' => array('knowledge_category'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-book-alt',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => 'knowledge-base',
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'knowledge',
            'with_front' => false
        ),
    );

    register_post_type('ayam_knowledge', $args);
}
add_action('init', 'ayam_register_knowledge_post_type', 0);

// Register Knowledge Categories Taxonomy
function ayam_register_knowledge_categories()
{
    $labels = array(
        'name' => __('หมวดหมู่ความรู้', 'ayam-bangkok'),
        'singular_name' => __('หมวดหมู่', 'ayam-bangkok'),
        'menu_name' => __('หมวดหมู่ความรู้', 'ayam-bangkok'),
        'all_items' => __('หมวดหมู่ทั้งหมด', 'ayam-bangkok'),
        'parent_item' => __('หมวดหมู่หลัก', 'ayam-bangkok'),
        'parent_item_colon' => __('หมวดหมู่หลัก:', 'ayam-bangkok'),
        'new_item_name' => __('ชื่อหมวดหมู่ใหม่', 'ayam-bangkok'),
        'add_new_item' => __('เพิ่มหมวดหมู่ใหม่', 'ayam-bangkok'),
        'edit_item' => __('แก้ไขหมวดหมู่', 'ayam-bangkok'),
        'update_item' => __('อัปเดตหมวดหมู่', 'ayam-bangkok'),
        'view_item' => __('ดูหมวดหมู่', 'ayam-bangkok'),
        'separate_items_with_commas' => __('แยกหมวดหมู่ด้วยเครื่องหมายจุลภาค', 'ayam-bangkok'),
        'add_or_remove_items' => __('เพิ่มหรือลบหมวดหมู่', 'ayam-bangkok'),
        'choose_from_most_used' => __('เลือกจากที่ใช้บ่อยที่สุด', 'ayam-bangkok'),
        'popular_items' => __('หมวดหมู่ยอดนิยม', 'ayam-bangkok'),
        'search_items' => __('ค้นหาหมวดหมู่', 'ayam-bangkok'),
        'not_found' => __('ไม่พบหมวดหมู่', 'ayam-bangkok'),
        'no_terms' => __('ไม่มีหมวดหมู่', 'ayam-bangkok'),
        'items_list' => __('รายการหมวดหมู่', 'ayam-bangkok'),
        'items_list_navigation' => __('การนำทางรายการหมวดหมู่', 'ayam-bangkok'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
        'rewrite' => array(
            'slug' => 'knowledge-category',
            'with_front' => false
        ),
    );

    register_taxonomy('knowledge_category', array('ayam_knowledge'), $args);
}
add_action('init', 'ayam_register_knowledge_categories', 0);

// Add default knowledge categories
function ayam_add_default_knowledge_categories()
{
    if (!term_exists('สายพันธุ์ไก่ชน', 'knowledge_category')) {
        wp_insert_term('สายพันธุ์ไก่ชน', 'knowledge_category', array(
            'description' => 'ข้อมูลเกี่ยวกับสายพันธุ์ไก่ชนต่างๆ',
            'slug' => 'rooster-breeds'
        ));
    }

    if (!term_exists('การดูแลสุขภาพ', 'knowledge_category')) {
        wp_insert_term('การดูแลสุขภาพ', 'knowledge_category', array(
            'description' => 'วิธีการดูแลสุขภาพไก่ชน',
            'slug' => 'health-care'
        ));
    }

    if (!term_exists('อาหารและโภชนาการ', 'knowledge_category')) {
        wp_insert_term('อาหารและโภชนาการ', 'knowledge_category', array(
            'description' => 'ความรู้เกี่ยวกับอาหารและโภชนาการ',
            'slug' => 'nutrition'
        ));
    }

    if (!term_exists('การจัดที่อยู่อาศัย', 'knowledge_category')) {
        wp_insert_term('การจัดที่อยู่อาศัย', 'knowledge_category', array(
            'description' => 'การสร้างและจัดเตรียมที่อยู่อาศัย',
            'slug' => 'housing'
        ));
    }

    if (!term_exists('การฝึกและการแข่งขัน', 'knowledge_category')) {
        wp_insert_term('การฝึกและการแข่งขัน', 'knowledge_category', array(
            'description' => 'เทคนิคการฝึกและการแข่งขัน',
            'slug' => 'training'
        ));
    }

    if (!term_exists('กฎหมายและระเบียบ', 'knowledge_category')) {
        wp_insert_term('กฎหมายและระเบียบ', 'knowledge_category', array(
            'description' => 'กฎหมายและระเบียบที่เกี่ยวข้อง',
            'slug' => 'legal'
        ));
    }
}
add_action('init', 'ayam_add_default_knowledge_categories');

// Legacy Contact Form Handler (for backward compatibility)
function handle_contact_form_submission()
{
    if (isset($_POST['submit_contact']) && wp_verify_nonce($_POST['contact_nonce'], 'contact_form_nonce')) {

        // Sanitize form data
        $name = sanitize_text_field($_POST['contact_name']);
        $phone = sanitize_text_field($_POST['contact_phone']);
        $email = sanitize_email($_POST['contact_email']);
        $subject = sanitize_text_field($_POST['contact_subject']);
        $message = sanitize_textarea_field($_POST['contact_message']);

        // Validate required fields
        if (empty($name) || empty($phone) || empty($email) || empty($subject) || empty($message)) {
            wp_redirect(add_query_arg('contact_error', 'missing_fields', get_permalink()));
            exit;
        }

        // Validate email
        if (!is_email($email)) {
            wp_redirect(add_query_arg('contact_error', 'invalid_email', get_permalink()));
            exit;
        }

        // Prepare email content
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');

        $subject_map = array(
            'general' => 'สอบถามทั่วไป',
            'rooster_inquiry' => 'สอบถามเกี่ยวกับไก่ชน',
            'export_inquiry' => 'สอบถามการส่งออก',
            'partnership' => 'ความร่วมมือทางธุรกิจ',
            'other' => 'อื่นๆ'
        );

        $email_subject = '[' . $site_name . '] ข้อความจากหน้าติดต่อเรา - ' . $subject_map[$subject];

        $email_body = "ข้อความใหม่จากหน้าติดต่อเรา\n\n";
        $email_body .= "ชื่อ: " . $name . "\n";
        $email_body .= "เบอร์โทรศัพท์: " . $phone . "\n";
        $email_body .= "อีเมล: " . $email . "\n";
        $email_body .= "หัวข้อ: " . $subject_map[$subject] . "\n";
        $email_body .= "ข้อความ: \n" . $message . "\n\n";
        $email_body .= "ส่งเมื่อ: " . current_time('mysql') . "\n";
        $email_body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";

        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>',
            'Reply-To: ' . $name . ' <' . $email . '>'
        );

        // Send email
        $mail_sent = wp_mail($admin_email, $email_subject, $email_body, $headers);

        // Send auto-reply to customer
        $customer_subject = '[' . $site_name . '] ขอบคุณสำหรับการติดต่อ';
        $customer_body = "เรียน คุณ" . $name . "\n\n";
        $customer_body .= "ขอบคุณที่ติดต่อเรา เราได้รับข้อความของคุณเรียบร้อยแล้ว\n";
        $customer_body .= "เราจะติดต่อกลับภายใน 24 ชั่วโมง\n\n";
        $customer_body .= "ข้อความของคุณ:\n";
        $customer_body .= "หัวข้อ: " . $subject_map[$subject] . "\n";
        $customer_body .= "ข้อความ: " . $message . "\n\n";
        $customer_body .= "ขอบคุณครับ\n";
        $customer_body .= $site_name;

        $customer_headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . $admin_email . '>'
        );

        wp_mail($email, $customer_subject, $customer_body, $customer_headers);

        // Redirect with success message
        wp_redirect(add_query_arg('contact_sent', 'success', get_permalink()));
        exit;
    }
}
add_action('init', 'handle_contact_form_submission');

// Enqueue Contact Page Styles
function ayam_contact_page_styles()
{
    if (is_page_template('page-contact.php') || is_page('contact') || is_page('ติดต่อเรา')) {
        wp_enqueue_style('ayam-contact-style', get_template_directory_uri() . '/assets/css/contact.css', array(), '1.0.0');

        // Enqueue Contact JavaScript
        wp_enqueue_script('ayam-contact-js', get_template_directory_uri() . '/assets/js/contact.js', array('jquery'), '1.0.0', true);

        // Localize script for AJAX
        wp_localize_script('ayam-contact-js', 'ayam_contact_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ayam_contact_form'),
            'strings' => array(
                'sending' => __('กำลังส่ง...', 'ayam-bangkok'),
                'success' => __('ส่งข้อความสำเร็จ', 'ayam-bangkok'),
                'error' => __('เกิดข้อผิดพลาด', 'ayam-bangkok')
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_contact_page_styles');

// Enqueue Services Page Styles
function ayam_services_page_styles()
{
    if (is_page_template('page-services.php') || is_page('services') || is_page('บริการ')) {
        wp_enqueue_style('ayam-services-style', get_template_directory_uri() . '/assets/css/services.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'ayam_services_page_styles');

// Service Custom Post Type removed - now using page template (page-service.php)

/**
 * Register Rooster Catalog Post Type (Wix Style Gallery)
 */
function ayam_register_rooster_catalog_post_type()
{
    $labels = array(
        'name' => 'Rooster Catalog',
        'singular_name' => 'Rooster',
        'menu_name' => 'Rooster Catalog',
        'add_new' => 'เพิ่มไก่ใหม่',
        'add_new_item' => 'เพิ่มไก่ใหม่',
        'edit_item' => 'แก้ไขข้อมูลไก่',
        'new_item' => 'ไก่ใหม่',
        'view_item' => 'ดูข้อมูลไก่',
        'search_items' => 'ค้นหาไก่',
        'not_found' => 'ไม่พบข้อมูลไก่',
        'not_found_in_trash' => 'ไม่พบข้อมูลไก่ในถังขยะ'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'rooster-catalog'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true
    );

    register_post_type('rooster_catalog', $args);
}
add_action('init', 'ayam_register_rooster_catalog_post_type');

// Create default menu on theme activation

function ayam_create_default_menu()
{
    // Check if menu already exists
    $menu_name = 'เมนูหลัก Ayam Bangkok';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        // Create the menu
        $menu_id = wp_create_nav_menu($menu_name);

        if (!is_wp_error($menu_id)) {
            // Add menu items
            $menu_items = array(
                array(
                    'menu-item-title' => 'หน้าแรก',
                    'menu-item-url' => home_url('/'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'เกี่ยวกับเรา',
                    'menu-item-url' => home_url('/about/'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'ไก่ชน',
                    'menu-item-url' => get_post_type_archive_link('ayam_rooster'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'บริการ',
                    'menu-item-url' => home_url('/services/'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'ศูนย์ความรู้',
                    'menu-item-url' => home_url('/knowledge-center/'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'ข่าวสาร',
                    'menu-item-url' => home_url('/news/'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'ราคา',
                    'menu-item-url' => home_url('/pricing/'),
                    'menu-item-status' => 'publish'
                ),
                array(
                    'menu-item-title' => 'ติดต่อเรา',
                    'menu-item-url' => home_url('/contact/'),
                    'menu-item-status' => 'publish'
                )
            );

            foreach ($menu_items as $item) {
                wp_update_nav_menu_item($menu_id, 0, $item);
            }

            // Assign menu to primary location
            $locations = get_theme_mod('nav_menu_locations');
            $locations['primary'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
}

// Run on theme activation
add_action('after_switch_theme', 'ayam_create_default_menu');

// Also run on admin_init to ensure menu exists
add_action('admin_init', function () {
    if (!wp_get_nav_menu_object('เมนูหลัก Ayam Bangkok')) {
        ayam_create_default_menu();
    }
});

// Create inquiries table on theme activation
function ayam_create_inquiries_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'ayam_inquiries';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        inquiry_type varchar(50) NOT NULL,
        rooster_id bigint(20) DEFAULT NULL,
        customer_name varchar(100) NOT NULL,
        customer_email varchar(100) NOT NULL,
        customer_phone varchar(20) DEFAULT NULL,
        customer_company varchar(100) DEFAULT NULL,
        subject varchar(200) DEFAULT NULL,
        message text NOT NULL,
        quote_data longtext DEFAULT NULL,
        status varchar(20) DEFAULT 'new',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY inquiry_type (inquiry_type),
        KEY status (status),
        KEY created_at (created_at)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Run table creation on theme activation
add_action('after_switch_theme', 'ayam_create_inquiries_table');



// Add Contact Page Custom Fields
function ayam_add_contact_page_fields()
{
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_contact_page_settings',
            'title' => __('ตั้งค่าหน้าติดต่อเรา', 'ayam-bangkok'),
            'fields' => array(
                // Page Header
                array(
                    'key' => 'field_contact_page_title',
                    'label' => __('หัวข้อหน้า', 'ayam-bangkok'),
                    'name' => 'contact_page_title',
                    'type' => 'text',
                    'default_value' => 'ติดต่อเรา',
                ),
                array(
                    'key' => 'field_contact_page_subtitle',
                    'label' => __('คำอธิบายใต้หัวข้อ', 'ayam-bangkok'),
                    'name' => 'contact_page_subtitle',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'ติดต่อสอบถามข้อมูลเพิ่มเติมหรือนัดหมายเยี่ยมชมฟาร์ม',
                ),

                // Contact Hours
                array(
                    'key' => 'field_contact_hours',
                    'label' => __('เวลาทำการ', 'ayam-bangkok'),
                    'name' => 'contact_hours',
                    'type' => 'text',
                    'default_value' => 'จันทร์-ศุกร์ 8:00-17:00',
                ),
                array(
                    'key' => 'field_email_response_time',
                    'label' => __('เวลาตอบกลับอีเมล', 'ayam-bangkok'),
                    'name' => 'email_response_time',
                    'type' => 'text',
                    'default_value' => 'ตอบกลับภายใน 24 ชั่วโมง',
                ),

                // Contact Form
                array(
                    'key' => 'field_contact_form_title',
                    'label' => __('หัวข้อฟอร์มติดต่อ', 'ayam-bangkok'),
                    'name' => 'contact_form_title',
                    'type' => 'text',
                    'default_value' => 'ส่งข้อความถึงเรา',
                ),
                array(
                    'key' => 'field_contact_form_description',
                    'label' => __('คำอธิบายฟอร์มติดต่อ', 'ayam-bangkok'),
                    'name' => 'contact_form_description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'default_value' => 'กรอกข้อมูลด้านล่างเพื่อติดต่อเรา เราจะตอบกลับโดยเร็วที่สุด',
                ),

                // Map Section
                array(
                    'key' => 'field_map_section_title',
                    'label' => __('หัวข้อส่วนแผนที่', 'ayam-bangkok'),
                    'name' => 'map_section_title',
                    'type' => 'text',
                    'default_value' => 'แผนที่ตำแหน่ง',
                ),

                // Additional Info
                array(
                    'key' => 'field_additional_contact_info',
                    'label' => __('ข้อมูลเพิ่มเติม', 'ayam-bangkok'),
                    'name' => 'additional_contact_info',
                    'type' => 'wysiwyg',
                    'instructions' => __('ข้อมูลเพิ่มเติมที่ต้องการแสดงในหน้าติดต่อ', 'ayam-bangkok'),
                    'media_upload' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-การติดต่อ',
                    ),
                ),
            ),
            'menu_order' => 0,
        ));
    }
}
add_action('acf/init', 'ayam_add_contact_page_fields');

// Enhanced Contact Form Handler
function ayam_handle_contact_form()
{
    // Verify nonce
    if (!wp_verify_nonce($_POST['contact_nonce'], 'ayam_contact_form')) {
        wp_die(__('Security check failed', 'ayam-bangkok'));
    }

    // Sanitize input
    $name = sanitize_text_field($_POST['contact_name']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $email = sanitize_email($_POST['contact_email']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(__('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok'));
    }

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(__('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok'));
    }

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_inquiries';

    $result = $wpdb->insert(
        $table_name,
        array(
            'inquiry_type' => 'contact_form',
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => 'new',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result === false) {
        wp_send_json_error(__('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'ayam-bangkok'));
    }

    // Send email notification
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = sprintf('[%s] ข้อความใหม่จาก %s', $site_name, $name);
    $email_message = sprintf(
        "ได้รับข้อความใหม่จากเว็บไซต์\n\n" .
        "ชื่อ: %s\n" .
        "อีเมล: %s\n" .
        "โทรศัพท์: %s\n" .
        "หัวข้อ: %s\n" .
        "ข้อความ:\n%s\n\n" .
        "เวลาที่ส่ง: %s",
        $name,
        $email,
        $phone,
        $subject,
        $message,
        current_time('mysql')
    );

    wp_mail($admin_email, $email_subject, $email_message);

    // Send auto-reply to customer
    $customer_subject = sprintf('[%s] ขอบคุณสำหรับการติดต่อ', $site_name);
    $customer_message = sprintf(
        "เรียน คุณ%s\n\n" .
        "ขอบคุณที่ติดต่อเรา เราได้รับข้อความของคุณเรียบร้อยแล้ว\n" .
        "เราจะตอบกลับภายใน 24 ชั่วโมง\n\n" .
        "ขอบคุณครับ\n" .
        "%s",
        $name,
        $site_name
    );

    wp_mail($email, $customer_subject, $customer_message);

    wp_send_json_success(__('ส่งข้อความสำเร็จ เราจะติดต่อกลับโดยเร็วที่สุด', 'ayam-bangkok'));
}
add_action('wp_ajax_ayam_contact_form', 'ayam_handle_contact_form');
add_action('wp_ajax_nopriv_ayam_contact_form', 'ayam_handle_contact_form');

// Handle Appointment Form Submission
function handle_appointment_form_submission()
{
    if (!isset($_POST['appointment_nonce']) || !wp_verify_nonce($_POST['appointment_nonce'], 'appointment_form_nonce')) {
        wp_die('Security check failed');
    }

    $name = sanitize_text_field($_POST['appointment_name']);
    $phone = sanitize_text_field($_POST['appointment_phone']);
    $email = sanitize_email($_POST['appointment_email']);
    $visitors = sanitize_text_field($_POST['appointment_visitors']);
    $date = sanitize_text_field($_POST['appointment_date']);
    $time = sanitize_text_field($_POST['appointment_time']);
    $interest = isset($_POST['appointment_interest']) ? implode(', ', array_map('sanitize_text_field', $_POST['appointment_interest'])) : 'ไม่ระบุ';
    $message = sanitize_textarea_field($_POST['appointment_message']);

    // Send email to admin
    $to = get_option('admin_email');
    $email_subject = 'คำขอนัดหมายชมไก่ - ' . $name;
    $email_message = "ชื่อ: {$name}\nโทรศัพท์: {$phone}\nอีเมล: {$email}\nจำนวนผู้เข้าชม: {$visitors}\nวันที่: {$date}\nเวลา: {$time}\nสนใจ: {$interest}\n\nข้อความเพิ่มเติม:\n{$message}";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    if (wp_mail($to, $email_subject, $email_message, $headers)) {
        wp_redirect(add_query_arg('appointment', 'success', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('appointment', 'error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_submit_appointment_form', 'handle_appointment_form_submission');
add_action('admin_post_nopriv_submit_appointment_form', 'handle_appointment_form_submission');

// Create required pages on theme activation
function ayam_create_required_pages()
{
    $pages = array(
        'about' => array(
            'title' => 'เกี่ยวกับเรา',
            'slug' => 'about',
            'content' => 'หน้าเกี่ยวกับเรา - กำลังพัฒนา',
            'template' => 'page-about.php'
        ),
        'services' => array(
            'title' => 'บริการ',
            'slug' => 'services',
            'content' => 'หน้าบริการ - กำลังพัฒนา',
            'template' => 'page-services.php'
        ),
        'roosters' => array(
            'title' => 'ไก่ชน',
            'slug' => 'roosters',
            'content' => 'หน้าไก่ชน - กำลังพัฒนา',
            'template' => 'page.php'
        ),
        'knowledge-center' => array(
            'title' => 'ศูนย์ความรู้',
            'slug' => 'knowledge-center',
            'content' => 'หน้าศูนย์ความรู้ - กำลังพัฒนา',
            'template' => 'page.php'
        ),
        'news' => array(
            'title' => 'ข่าวสาร',
            'slug' => 'news',
            'content' => 'หน้าข่าวสาร - กำลังพัฒนา',
            'template' => 'page-news.php'
        ),
        'pricing' => array(
            'title' => 'ราคา',
            'slug' => 'pricing',
            'content' => 'หน้าราคา - กำลังพัฒนา',
            'template' => 'page.php'
        ),
        'contact' => array(
            'title' => 'ติดต่อเรา',
            'slug' => 'contact',
            'content' => 'หน้าติดต่อเรา - กำลังพัฒนา',
            'template' => 'page-contact.php'
        )
    );

    foreach ($pages as $page_key => $page_data) {
        // Check if page already exists
        $existing_page = get_page_by_path($page_data['slug']);

        if (!$existing_page) {
            // Create the page
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => 1
            ));

            if ($page_id && !is_wp_error($page_id)) {
                // Set page template if specified
                if (isset($page_data['template'])) {
                    update_post_meta($page_id, '_wp_page_template', $page_data['template']);
                }

                error_log("Created page: {$page_data['title']} (ID: {$page_id})");
            } else {
                error_log("Failed to create page: {$page_data['title']}");
            }
        } else {
            error_log("Page already exists: {$page_data['title']} (ID: {$existing_page->ID})");
        }
    }

    // Flush rewrite rules to ensure URLs work properly
    flush_rewrite_rules();
}

// Run on theme activation
add_action('after_switch_theme', 'ayam_create_required_pages');

// Also run on admin_init to ensure pages exist (one-time check)
add_action('admin_init', function () {
    $check_option = 'ayam_pages_created';
    if (!get_option($check_option)) {
        ayam_create_required_pages();
        update_option($check_option, true);
    }
});

/**
 * Add custom dashboard widget
 */
function ayam_dashboard_widget()
{
    wp_add_dashboard_widget(
        'ayam_dashboard_widget',
        'Ayam Bangkok - สถิติเว็บไซต์',
        'ayam_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'ayam_dashboard_widget');

function ayam_dashboard_widget_content()
{
    $rooster_count = wp_count_posts('ayam_rooster')->publish;
    $news_count = wp_count_posts('ayam_news')->publish;
    $service_count = wp_count_posts('ayam_service')->publish;

    echo '<div class="ayam-dashboard-stats">';
    echo '<div class="stat-item"><strong>ไก่ชน:</strong> ' . $rooster_count . ' ตัว</div>';
    echo '<div class="stat-item"><strong>ข่าวสาร:</strong> ' . $news_count . ' บทความ</div>';
    echo '<div class="stat-item"><strong>บริการ:</strong> ' . $service_count . ' รายการ</div>';
    echo '</div>';

    echo '<p><a href="' . admin_url('edit.php?post_type=ayam_rooster') . '" class="button button-primary">จัดการไก่ชน</a></p>';
}

/**
 * Add theme support for additional features
 */
function ayam_additional_theme_support()
{
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Add support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for starter content
    add_theme_support('starter-content', array(
        'widgets' => array(
            'sidebar-1' => array(
                'text_business_info',
                'categories',
                'archives',
            ),
            'footer-1' => array(
                'text_about',
            ),
            'footer-2' => array(
                'recent-posts',
            ),
            'footer-3' => array(
                'recent-comments',
            ),
        ),
        'posts' => array(
            'home',
            'about' => array(
                'thumbnail' => '{{image-sandwich}}',
            ),
            'contact' => array(
                'thumbnail' => '{{image-espresso}}',
            ),
            'blog' => array(
                'thumbnail' => '{{image-coffee}}',
            ),
        ),
        'theme_mods' => array(
            'panel_1' => true,
            'panel_2' => true,
            'panel_3' => true,
            'panel_4' => true,
        ),
        'nav_menus' => array(
            'primary' => array(
                'name' => 'เมนูหลัก',
                'items' => array(
                    'link_home',
                    'page_about',
                    'page_blog',
                    'page_contact',
                ),
            ),
        ),
    ));
}
add_action('after_setup_theme', 'ayam_additional_theme_support');

/**
 * About Page Admin Interface
 */
function ayam_about_admin_page()
{
    // Handle form submission
    if (isset($_POST['save_about'])) {
        if (!wp_verify_nonce($_POST['ayam_about_nonce'], 'ayam_about_save')) {
            wp_safe_redirect(admin_url('admin.php?page=ayam-about-settings&error=nonce'));
            exit;
        }

        // Save company info
        $company_data = array(
            'company_name' => sanitize_text_field($_POST['company_name']),
            'company_description' => sanitize_textarea_field($_POST['company_description']),
            'company_main_image' => esc_url_raw($_POST['company_main_image']),
            'company_vision' => sanitize_textarea_field($_POST['company_vision']),
            'company_mission' => sanitize_textarea_field($_POST['company_mission'])
        );
        update_option('ayam_company_data', $company_data);

        // Save timeline
        $timeline_data = array();
        if (isset($_POST['timeline']) && is_array($_POST['timeline'])) {
            foreach ($_POST['timeline'] as $item) {
                if (!empty($item['year']) || !empty($item['title'])) {
                    $timeline_data[] = array(
                        'year' => sanitize_text_field($item['year']),
                        'title' => sanitize_text_field($item['title']),
                        'description' => sanitize_textarea_field($item['description']),
                        'image' => esc_url_raw($item['image'])
                    );
                }
            }
        }
        update_option('ayam_company_timeline', $timeline_data);

        // Save awards
        $awards_data = array();
        if (isset($_POST['awards']) && is_array($_POST['awards'])) {
            foreach ($_POST['awards'] as $award) {
                if (!empty($award['title'])) {
                    $awards_data[] = array(
                        'title' => sanitize_text_field($award['title']),
                        'year' => sanitize_text_field($award['year']),
                        'description' => sanitize_textarea_field($award['description']),
                        'image' => esc_url_raw($award['image'])
                    );
                }
            }
        }
        update_option('ayam_company_awards', $awards_data);

        // Save team members
        $team_data = array();
        if (isset($_POST['team']) && is_array($_POST['team'])) {
            foreach ($_POST['team'] as $member) {
                if (!empty($member['name'])) {
                    $team_data[] = array(
                        'name' => sanitize_text_field($member['name']),
                        'position' => sanitize_text_field($member['position']),
                        'description' => sanitize_textarea_field($member['description']),
                        'image' => esc_url_raw($member['image'])
                    );
                }
            }
        }
        update_option('ayam_team_members', $team_data);

        // Save company features (support both simple list and structured fields)
        $features_data = array();
        // Structured fields: company_features_title[], company_features_description[], company_features_icon[]
        if (!empty($_POST['company_features_title']) && is_array($_POST['company_features_title'])) {
            $titles = array_map('sanitize_text_field', (array) $_POST['company_features_title']);
            $descs = isset($_POST['company_features_description']) ? (array) $_POST['company_features_description'] : array();
            $icons = isset($_POST['company_features_icon']) ? (array) $_POST['company_features_icon'] : array();
            foreach ($titles as $i => $t) {
                $t = trim($t);
                $d = isset($descs[$i]) ? sanitize_textarea_field($descs[$i]) : '';
                $ic = isset($icons[$i]) ? sanitize_text_field($icons[$i]) : '';
                if ($t !== '' || $d !== '' || $ic !== '') {
                    $features_data[] = array(
                        'title' => $t,
                        'description' => $d,
                        'icon' => $ic,
                    );
                }
            }
        } elseif (isset($_POST['company_features']) && is_array($_POST['company_features'])) {
            // Backward compatible: simple list of strings => map to title only
            foreach ($_POST['company_features'] as $feat) {
                $feat = sanitize_text_field($feat);
                if ($feat !== '') {
                    $features_data[] = array(
                        'title' => $feat,
                        'description' => '',
                        'icon' => '',
                    );
                }
            }
        }
        update_option('ayam_company_features', $features_data);

        // Save company values (title, description, icon)
        $values_data = array();
        if (isset($_POST['company_values']) && is_array($_POST['company_values'])) {
            foreach ($_POST['company_values'] as $val) {
                $title = isset($val['title']) ? sanitize_text_field($val['title']) : '';
                $desc = isset($val['description']) ? sanitize_textarea_field($val['description']) : '';
                $icon = isset($val['icon']) ? sanitize_text_field($val['icon']) : '';
                if ($title !== '' || $desc !== '' || $icon !== '') {
                    $values_data[] = array(
                        'title' => $title,
                        'description' => $desc,
                        'icon' => $icon,
                    );
                }
            }
        }
        update_option('ayam_company_values', $values_data);

        wp_safe_redirect(admin_url('admin.php?page=ayam-about-settings&saved=1'));
        exit;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');

    // Show messages
    if (isset($_GET['saved']) && $_GET['saved'] == '1') {
        echo '<div class="notice notice-success is-dismissible"><p><strong>✅ บันทึกเรียบร้อย!</strong> ข้อมูลหน้า About ได้รับการบันทึกแล้ว</p></div>';
    }

    if (isset($_GET['error']) && $_GET['error'] == 'nonce') {
        echo '<div class="notice notice-error is-dismissible"><p><strong>❌ ข้อผิดพลาด!</strong> Security check failed. กรุณาลองใหม่อีกครั้ง</p></div>';
    }

    // Get current data
    $company_data = get_option('ayam_company_data', array());
    $timeline_data = get_option('ayam_company_timeline', array());
    $awards_data = get_option('ayam_company_awards', array());
    $team_data = get_option('ayam_team_members', array());
    $features_data = get_option('ayam_company_features', array());
    $values_data = get_option('ayam_company_values', array());

    // Debug output
    echo '<!-- DEBUG: Timeline data count: ' . count($timeline_data) . ' -->';
    echo '<!-- DEBUG: Awards data count: ' . count($awards_data) . ' -->';
    echo '<!-- DEBUG: Team data count: ' . count($team_data) . ' -->';

    ?>
    <div class="wrap">
        <h1>จัดการหน้า About</h1>
        <p>จัดการเนื้อหาและข้อมูลสำหรับหน้า About Us</p>

        <!-- Import Button -->
        <div style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
            <h3>📥 นำเข้าข้อมูล</h3>
            <p>นำเข้าข้อมูลเริ่มต้นจากหน้า About ปัจจุบัน</p>
            <button type="button" id="import-default-data" class="button button-secondary">📥 นำเข้าข้อมูลเริ่มต้น</button>
        </div>

        <!-- Tab Navigation -->
        <div class="nav-tab-wrapper">
            <a href="javascript:void(0)" class="nav-tab nav-tab-active" data-tab="company-info">🏢 ข้อมูลบริษัท</a>
            <a href="javascript:void(0)" class="nav-tab" data-tab="timeline">📅 ประวัติความเป็นมา</a>
            <a href="javascript:void(0)" class="nav-tab" data-tab="awards">🏆 รางวัลและความสำเร็จ</a>
            <a href="javascript:void(0)" class="nav-tab" data-tab="team">👥 ทีมงาน</a>
            <a href="javascript:void(0)" class="nav-tab" data-tab="features">✨ จุดเด่นบริษัท</a>
            <a href="javascript:void(0)" class="nav-tab" data-tab="values">💡 ค่านิยมองค์กร</a>
        </div>

        <form method="post" action="">
            <?php wp_nonce_field('ayam_about_save', 'ayam_about_nonce'); ?>

            <!-- Company Information Tab -->
            <div id="company-info" class="tab-content" style="display: block;">
                <div
                    style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
                    <h3>🏢 ข้อมูลบริษัท</h3>
                    <table class="form-table">
                        <tr>
                            <th><label for="company_name">ชื่อบริษัท</label></th>
                            <td><input type="text" id="company_name" name="company_name"
                                    value="<?php echo esc_attr($company_data['company_name'] ?? ''); ?>"
                                    class="regular-text" /></td>
                        </tr>
                        <tr>
                            <th><label for="company_description">คำอธิบายบริษัท</label></th>
                            <td><textarea id="company_description" name="company_description" rows="5"
                                    class="large-text"><?php echo esc_textarea($company_data['company_description'] ?? ''); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="company_main_image">รูปภาพหลัก</label></th>
                            <td>
                                <input type="url" id="company_main_image" name="company_main_image"
                                    value="<?php echo esc_url($company_data['company_main_image'] ?? ''); ?>"
                                    class="regular-text" />
                                <button type="button" class="button media-button"
                                    data-target="company_main_image">เลือกรูป</button>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="company_vision">วิสัยทัศน์</label></th>
                            <td><textarea id="company_vision" name="company_vision" rows="3"
                                    class="large-text"><?php echo esc_textarea($company_data['company_vision'] ?? ''); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="company_mission">พันธกิจ</label></th>
                            <td><textarea id="company_mission" name="company_mission" rows="3"
                                    class="large-text"><?php echo esc_textarea($company_data['company_mission'] ?? ''); ?></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Timeline Tab -->
            <div id="timeline" class="tab-content" style="display: none;">
                <div
                    style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
                    <h3>📅 ประวัติความเป็นมา (Timeline)</h3>
                    <div id="timeline-container">
                        <?php
                        if (!empty($timeline_data)) {
                            foreach ($timeline_data as $index => $item) {
                                echo ayam_render_timeline_item($index, $item);
                            }
                        } else {
                            echo ayam_render_timeline_item(0, array());
                        }
                        ?>
                    </div>

                    <!-- Display existing timeline data -->
                    <?php if (!empty($timeline_data)): ?>
                        <div
                            style="background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin: 20px 0; border-radius: 4px;">
                            <h4>📋 รายการที่บันทึกแล้ว</h4>
                            <div class="timeline-list">
                                <?php foreach ($timeline_data as $index => $item): ?>
                                    <div
                                        style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; background: white;">
                                        <strong><?php echo esc_html($item['year'] ?? ''); ?></strong> -
                                        <strong><?php echo esc_html($item['title'] ?? ''); ?></strong>
                                        <p><?php echo esc_html($item['description'] ?? ''); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button type="button" id="add-timeline-item" class="button button-secondary">+ เพิ่มรายการ
                        Timeline</button>
                </div>
            </div>

            <!-- Awards Tab -->
            <div id="awards" class="tab-content" style="display: none;">
                <div
                    style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
                    <h3>🏆 รางวัลและความสำเร็จ</h3>
                    <div id="awards-container">
                        <?php
                        if (!empty($awards_data)) {
                            foreach ($awards_data as $index => $award) {
                                echo ayam_render_award_item($index, $award);
                            }
                        } else {
                            echo ayam_render_award_item(0, array());
                        }
                        ?>
                    </div>

                    <!-- Display existing awards data -->
                    <?php if (!empty($awards_data)): ?>
                        <div
                            style="background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin: 20px 0; border-radius: 4px;">
                            <h4>📋 รางวัลที่บันทึกแล้ว</h4>
                            <div class="awards-list">
                                <?php foreach ($awards_data as $index => $award): ?>
                                    <div
                                        style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; background: white;">
                                        <strong><?php echo esc_html($award['title'] ?? ''); ?></strong>
                                        <?php if (!empty($award['year'])): ?>
                                            <span style="color: #666;">(<?php echo esc_html($award['year']); ?>)</span>
                                        <?php endif; ?>
                                        <p><?php echo esc_html($award['description'] ?? ''); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button type="button" id="add-award-item" class="button button-secondary">+ เพิ่มรางวัล</button>
                </div>
            </div>

            <!-- Team Tab -->
            <div id="team" class="tab-content" style="display: none;">
                <div
                    style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
                    <h3>👥 ทีมงาน</h3>
                    <div id="team-container">
                        <?php
                        if (!empty($team_data)) {
                            foreach ($team_data as $index => $member) {
                                echo ayam_render_team_member($index, $member);
                            }
                        } else {
                            echo ayam_render_team_member(0, array());
                        }
                        ?>
                    </div>

                    <!-- Display existing team data -->
                    <?php if (!empty($team_data)): ?>
                        <div
                            style="background: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin: 20px 0; border-radius: 4px;">
                            <h4>📋 ทีมงานที่บันทึกแล้ว</h4>
                            <div class="team-list">
                                <?php foreach ($team_data as $index => $member): ?>
                                    <div
                                        style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; background: white;">
                                        <strong><?php echo esc_html($member['name'] ?? ''); ?></strong>
                                        <?php if (!empty($member['position'])): ?>
                                            <span style="color: #0073aa; font-weight: 600;"> -
                                                <?php echo esc_html($member['position']); ?></span>
                                        <?php endif; ?>
                                        <p><?php echo esc_html($member['description'] ?? ''); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button type="button" id="add-team-member" class="button button-secondary">+ เพิ่มสมาชิกทีม</button>
                </div>
            </div>

            <!-- Features Tab -->
            <div id="features" class="tab-content" style="display: none;">
                <div
                    style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
                    <h3>✨ จุดเด่นบริษัท (Company Features)</h3>
                    <div id="features-container">
                        <?php
                        if (!empty($features_data)) {
                            foreach ($features_data as $index => $feat) {
                                $f_title = is_array($feat) ? ($feat['title'] ?? '') : (string) $feat;
                                $f_desc = is_array($feat) ? ($feat['description'] ?? '') : '';
                                $f_icon = is_array($feat) ? ($feat['icon'] ?? '') : '';
                                ?>
                                <div class="feature-item" style="border:1px solid #eee; padding:10px; margin-bottom:10px;">
                                    <table class="form-table">
                                        <tr>
                                            <th><label>หัวข้อ</label></th>
                                            <td><input type="text" name="company_features_title[]"
                                                    value="<?php echo esc_attr($f_title); ?>" class="regular-text"
                                                    placeholder="เช่น ประสบการณ์กว่า 10 ปี" /></td>
                                        </tr>
                                        <tr>
                                            <th><label>รายละเอียด</label></th>
                                            <td><textarea name="company_features_description[]" rows="2" class="large-text"
                                                    placeholder="รายละเอียดเพิ่มเติมของจุดเด่น"><?php echo esc_textarea($f_desc); ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><label>ไอคอน (CSS Class)</label></th>
                                            <td><input type="text" name="company_features_icon[]"
                                                    value="<?php echo esc_attr($f_icon); ?>" class="regular-text"
                                                    placeholder="เช่น fas fa-award" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <?php
                            }
                        } else { ?>
                            <div class="feature-item" style="border:1px solid #eee; padding:10px; margin-bottom:10px;">
                                <table class="form-table">
                                    <tr>
                                        <th><label>หัวข้อ</label></th>
                                        <td><input type="text" name="company_features_title[]" value="" class="regular-text"
                                                placeholder="เช่น ประสบการณ์กว่า 10 ปี" /></td>
                                    </tr>
                                    <tr>
                                        <th><label>รายละเอียด</label></th>
                                        <td><textarea name="company_features_description[]" rows="2" class="large-text"
                                                placeholder="รายละเอียดเพิ่มเติมของจุดเด่น"></textarea></td>
                                    </tr>
                                    <tr>
                                        <th><label>ไอคอน (CSS Class)</label></th>
                                        <td><input type="text" name="company_features_icon[]" value="" class="regular-text"
                                                placeholder="เช่น fas fa-award" /></td>
                                    </tr>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                    <p class="description">ตัวอย่าง: ประสบการณ์กว่า 10 ปี, ใบรับรองมาตรฐาน, เครือข่ายระหว่างประเทศ</p>
                </div>
            </div>

            <!-- Values Tab -->
            <div id="values" class="tab-content" style="display: none;">
                <div
                    style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
                    <h3>💡 ค่านิยมองค์กร (Company Values)</h3>
                    <div id="values-container">
                        <?php
                        if (!empty($values_data)) {
                            foreach ($values_data as $index => $val) {
                                $v_title = $val['title'] ?? '';
                                $v_desc = $val['description'] ?? '';
                                $v_icon = $val['icon'] ?? '';
                                ?>
                                <div class="value-item" style="border:1px solid #eee; padding:10px; margin-bottom:10px;">
                                    <table class="form-table">
                                        <tr>
                                            <th><label>หัวข้อ</label></th>
                                            <td><input type="text" name="company_values[<?php echo intval($index); ?>][title]"
                                                    value="<?php echo esc_attr($v_title); ?>" class="regular-text" /></td>
                                        </tr>
                                        <tr>
                                            <th><label>รายละเอียด</label></th>
                                            <td><textarea name="company_values[<?php echo intval($index); ?>][description]" rows="2"
                                                    class="large-text"><?php echo esc_textarea($v_desc); ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <th><label>ไอคอน (CSS Class)</label></th>
                                            <td><input type="text" name="company_values[<?php echo intval($index); ?>][icon]"
                                                    value="<?php echo esc_attr($v_icon); ?>" class="regular-text"
                                                    placeholder="เช่น fas fa-heart" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <?php
                            }
                        } else { ?>
                            <div class="value-item" style="border:1px solid #eee; padding:10px; margin-bottom:10px;">
                                <table class="form-table">
                                    <tr>
                                        <th><label>หัวข้อ</label></th>
                                        <td><input type="text" name="company_values[0][title]" value="" class="regular-text" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label>รายละเอียด</label></th>
                                        <td><textarea name="company_values[0][description]" rows="2"
                                                class="large-text"></textarea></td>
                                    </tr>
                                    <tr>
                                        <th><label>ไอคอน (CSS Class)</label></th>
                                        <td><input type="text" name="company_values[0][icon]" value="" class="regular-text"
                                                placeholder="เช่น fas fa-heart" /></td>
                                    </tr>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                    <p class="description">ตัวอย่าง: ความใส่ใจ, ความน่าเชื่อถือ, นวัตกรรม, ความซื่อสัตย์</p>
                </div>
            </div>

            <!-- Save Button -->
            <div class="ayam-card"
                style="margin-top: 20px; background: white; border: 1px solid #ccd0d4; padding: 15px; border-radius: 4px;">
                <button type="submit" name="save_about" class="button button-primary button-large">💾
                    บันทึกการเปลี่ยนแปลง</button>
            </div>
        </form>
    </div>
    <?php
}

// Helper functions for rendering form items
function ayam_render_timeline_item($index, $item = array())
{
    $year = $item['year'] ?? '';
    $title = $item['title'] ?? '';
    $description = $item['description'] ?? '';
    $image = $item['image'] ?? '';

    return '<div class="timeline-item ayam-form-item">
        <div class="item-header">
            <h4>Timeline Item #' . ($index + 1) . '</h4>
            <button type="button" class="button-link remove-item">ลบ</button>
        </div>
        <table class="form-table">
            <tr>
                <th><label>ปี</label></th>
                <td><input type="text" name="timeline[' . $index . '][year]" value="' . esc_attr($year) . '" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label>หัวข้อ</label></th>
                <td><input type="text" name="timeline[' . $index . '][title]" value="' . esc_attr($title) . '" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label>คำอธิบาย</label></th>
                <td><textarea name="timeline[' . $index . '][description]" rows="3" class="large-text">' . esc_textarea($description) . '</textarea></td>
            </tr>
            <tr>
                <th><label>รูปภาพ</label></th>
                <td>
                    <input type="url" name="timeline[' . $index . '][image]" value="' . esc_url($image) . '" class="regular-text" id="timeline_image_' . $index . '" />
                    <button type="button" class="button media-button" data-target="timeline_image_' . $index . '">เลือกรูป</button>
                </td>
            </tr>
        </table>
    </div>';
}

function ayam_render_award_item($index, $award = array())
{
    $title = $award['title'] ?? '';
    $year = $award['year'] ?? '';
    $description = $award['description'] ?? '';
    $image = $award['image'] ?? '';

    return '<div class="award-item ayam-form-item">
        <div class="item-header">
            <h4>รางวัล #' . ($index + 1) . '</h4>
            <button type="button" class="button-link remove-item">ลบ</button>
        </div>
        <table class="form-table">
            <tr>
                <th><label>ชื่อรางวัล</label></th>
                <td><input type="text" name="awards[' . $index . '][title]" value="' . esc_attr($title) . '" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label>ปี</label></th>
                <td><input type="text" name="awards[' . $index . '][year]" value="' . esc_attr($year) . '" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label>คำอธิบาย</label></th>
                <td><textarea name="awards[' . $index . '][description]" rows="2" class="large-text">' . esc_textarea($description) . '</textarea></td>
            </tr>
            <tr>
                <th><label>รูปภาพ</label></th>
                <td>
                    <input type="url" name="awards[' . $index . '][image]" value="' . esc_url($image) . '" class="regular-text" id="award_image_' . $index . '" />
                    <button type="button" class="button media-button" data-target="award_image_' . $index . '">เลือกรูป</button>
                </td>
            </tr>
        </table>
    </div>';
}

function ayam_render_team_member($index, $member = array())
{
    $name = $member['name'] ?? '';
    $position = $member['position'] ?? '';
    $description = $member['description'] ?? '';
    $image = $member['image'] ?? '';

    return '<div class="team-item ayam-form-item">
        <div class="item-header">
            <h4>สมาชิกทีม #' . ($index + 1) . '</h4>
            <button type="button" class="button-link remove-item">ลบ</button>
        </div>
        <table class="form-table">
            <tr>
                <th><label>ชื่อ</label></th>
                <td><input type="text" name="team[' . $index . '][name]" value="' . esc_attr($name) . '" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label>ตำแหน่ง</label></th>
                <td><input type="text" name="team[' . $index . '][position]" value="' . esc_attr($position) . '" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label>คำอธิบาย</label></th>
                <td><textarea name="team[' . $index . '][description]" rows="2" class="large-text">' . esc_textarea($description) . '</textarea></td>
            </tr>
            <tr>
                <th><label>รูปภาพ</label></th>
                <td>
                    <input type="url" name="team[' . $index . '][image]" value="' . esc_url($image) . '" class="regular-text" id="team_image_' . $index . '" />
                    <button type="button" class="button media-button" data-target="team_image_' . $index . '">เลือกรูป</button>
                </td>
            </tr>
        </table>
    </div>';
}

// Update existing helper functions to use new option names


/**
 * AJAX handler for rooster quick view
 */
function ayam_get_rooster_quick_view()
{
    check_ajax_referer('ayam_theme_nonce', 'nonce');

    $rooster_id = intval($_POST['rooster_id']);

    if (!$rooster_id) {
        wp_send_json_error('Invalid rooster ID');
    }

    $rooster = get_post($rooster_id);

    if (!$rooster || $rooster->post_type !== 'ayam_rooster') {
        wp_send_json_error('Rooster not found');
    }

    // Get rooster data
    $rooster_number = get_post_meta($rooster_id, 'rooster_number', true);
    $price = get_post_meta($rooster_id, 'rooster_price', true);
    $age = get_post_meta($rooster_id, 'rooster_age', true);
    $weight = get_post_meta($rooster_id, 'rooster_weight', true);
    $color = get_post_meta($rooster_id, 'rooster_color', true);
    $status = get_post_meta($rooster_id, 'rooster_status', true);
    $gallery = get_post_meta($rooster_id, 'rooster_gallery', true);

    $status_labels = array(
        'available' => __('พร้อมส่งออก', 'ayam-bangkok'),
        'reserved' => __('จองแล้ว', 'ayam-bangkok'),
        'sold' => __('ขายแล้ว', 'ayam-bangkok')
    );

    // Build HTML
    ob_start();
    ?>
    <div class="quick-view-content">
        <div class="quick-view-header">
            <?php if ($rooster_number): ?>
                <div class="rooster-number-large">
                    <i class="fas fa-hashtag"></i>
                    <span><?php echo esc_html($rooster_number); ?></span>
                </div>
            <?php endif; ?>
            <h2><?php echo esc_html($rooster->post_title); ?></h2>
            <?php if ($status && isset($status_labels[$status])): ?>
                <span class="status-badge status-<?php echo esc_attr($status); ?>">
                    <?php echo esc_html($status_labels[$status]); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="quick-view-body">
            <div class="quick-view-image">
                <?php if (has_post_thumbnail($rooster_id)): ?>
                    <?php echo get_the_post_thumbnail($rooster_id, 'large'); ?>
                <?php else: ?>
                    <div class="placeholder-image">
                        <i class="fas fa-image"></i>
                    </div>
                <?php endif; ?>
            </div>

            <div class="quick-view-details">
                <?php if ($price): ?>
                    <div class="quick-view-price">
                        <span class="price-label"><?php _e('ราคา:', 'ayam-bangkok'); ?></span>
                        <span class="price-amount">฿<?php echo number_format($price); ?></span>
                    </div>
                <?php endif; ?>

                <div class="quick-view-specs">
                    <?php if ($age): ?>
                        <div class="spec-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="spec-label"><?php _e('อายุ:', 'ayam-bangkok'); ?></span>
                            <span class="spec-value"><?php echo esc_html($age); ?>         <?php _e('เดือน', 'ayam-bangkok'); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($weight): ?>
                        <div class="spec-item">
                            <i class="fas fa-weight"></i>
                            <span class="spec-label"><?php _e('น้ำหนัก:', 'ayam-bangkok'); ?></span>
                            <span class="spec-value"><?php echo esc_html($weight); ?>         <?php _e('กก.', 'ayam-bangkok'); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($color): ?>
                        <div class="spec-item">
                            <i class="fas fa-palette"></i>
                            <span class="spec-label"><?php _e('สี:', 'ayam-bangkok'); ?></span>
                            <span class="spec-value"><?php echo esc_html($color); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($rooster->post_excerpt): ?>
                    <div class="quick-view-excerpt">
                        <p><?php echo esc_html($rooster->post_excerpt); ?></p>
                    </div>
                <?php endif; ?>

                <div class="quick-view-actions">
                    <a href="<?php echo get_permalink($rooster_id); ?>" class="btn btn-primary btn-large">
                        <i class="fas fa-info-circle"></i>
                        <?php _e('ดูรายละเอียดเต็ม', 'ayam-bangkok'); ?>
                    </a>
                    <button class="btn btn-outline btn-large inquiry-btn" data-rooster-id="<?php echo $rooster_id; ?>">
                        <i class="fas fa-envelope"></i>
                        <?php _e('สอบถาม', 'ayam-bangkok'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .quick-view-content {
            padding: 1rem;
        }

        .quick-view-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .rooster-number-large {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #1E2950;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .quick-view-header h2 {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .quick-view-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .quick-view-image img {
            width: 100%;
            border-radius: 12px;
        }

        .quick-view-price {
            display: flex;
            align-items: baseline;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .quick-view-price .price-label {
            font-size: 1.1rem;
            color: #6b7280;
        }

        .quick-view-price .price-amount {
            font-size: 2rem;
            font-weight: 700;
            color: #F8F7F7FF;
        }

        .quick-view-specs {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
        }

        .spec-item i {
            color: #1E2950;
            width: 20px;
        }

        .spec-item .spec-label {
            color: #6b7280;
            min-width: 80px;
        }

        .spec-item .spec-value {
            color: #1f2937;
            font-weight: 600;
        }

        .quick-view-excerpt {
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .quick-view-excerpt p {
            color: #4b5563;
            line-height: 1.6;
            margin: 0;
        }

        .quick-view-actions {
            display: flex;
            gap: 1rem;
        }

        .quick-view-actions .btn {
            flex: 1;
        }

        @media (max-width: 768px) {
            .quick-view-body {
                grid-template-columns: 1fr;
            }

            .quick-view-actions {
                flex-direction: column;
            }
        }
    </style>
    <?php

    $html = ob_get_clean();

    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_get_rooster_quick_view', 'ayam_get_rooster_quick_view');
add_action('wp_ajax_nopriv_get_rooster_quick_view', 'ayam_get_rooster_quick_view');


// Reading time function moved to inc/template-functions.php


/**
 * AJAX handler for newsletter subscription
 */
function ayam_subscribe_newsletter()
{
    check_ajax_referer('ayam_theme_nonce', 'nonce');

    $email = sanitize_email($_POST['email']);

    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('อีเมลไม่ถูกต้อง', 'ayam-bangkok')));
    }

    // Check if email already exists
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_newsletter';

    // Create table if not exists
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        email varchar(255) NOT NULL,
        status varchar(20) DEFAULT 'active',
        subscribed_at timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Insert email
    $result = $wpdb->insert(
        $table_name,
        array(
            'email' => $email,
            'status' => 'active'
        ),
        array('%s', '%s')
    );

    if ($result === false) {
        // Check if duplicate
        if ($wpdb->last_error && strpos($wpdb->last_error, 'Duplicate') !== false) {
            wp_send_json_error(array('message' => __('อีเมลนี้ได้สมัครรับข่าวสารแล้ว', 'ayam-bangkok')));
        }
        wp_send_json_error(array('message' => __('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'ayam-bangkok')));
    }

    // Send confirmation email
    $subject = sprintf('[%s] ยืนยันการสมัครรับข่าวสาร', get_bloginfo('name'));
    $message = sprintf(
        "สวัสดีค่ะ,\n\n" .
        "ขอบคุณที่สมัครรับข่าวสารจาก %s\n\n" .
        "คุณจะได้รับข่าวสารและโปรโมชั่นพิเศษทางอีเมลนี้\n\n" .
        "ขอบคุณค่ะ\n" .
        "%s",
        get_bloginfo('name'),
        get_bloginfo('name')
    );

    wp_mail($email, $subject, $message);

    wp_send_json_success(array('message' => __('สมัครรับข่าวสารสำเร็จ!', 'ayam-bangkok')));
}
add_action('wp_ajax_subscribe_newsletter', 'ayam_subscribe_newsletter');
add_action('wp_ajax_nopriv_subscribe_newsletter', 'ayam_subscribe_newsletter');


/**
 * Member Registration System
 */

// Enqueue member registration assets
function ayam_member_registration_assets()
{
    if (is_page_template('page-member-registration.php')) {
        wp_enqueue_style('ayam-member-registration', AYAM_THEME_URI . '/assets/css/member-registration.css', array('ayam-style'), AYAM_THEME_VERSION);
        wp_enqueue_script('ayam-member-registration', AYAM_THEME_URI . '/assets/js/member-registration.js', array('jquery'), AYAM_THEME_VERSION, true);

        // Localize script for AJAX
        wp_localize_script('ayam-member-registration', 'ayamAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('member_registration_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_member_registration_assets');

// AJAX handler for member registration
function ayam_register_member()
{
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'member_registration_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed', 'ayam-bangkok')));
    }

    // Sanitize and validate input
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $phone = sanitize_text_field($_POST['phone']);
    $line_id = sanitize_text_field($_POST['line_id']);
    $country = sanitize_text_field($_POST['country']);
    $business_type = sanitize_text_field($_POST['business_type']);
    $address = sanitize_textarea_field($_POST['address']);
    $interests = isset($_POST['interests']) ? array_map('sanitize_text_field', $_POST['interests']) : array();
    $agree_newsletter = isset($_POST['agree_newsletter']) && $_POST['agree_newsletter'] === 'on';

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($phone) || empty($country)) {
        wp_send_json_error(array('message' => __('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok')));
    }

    // Validate email format
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok')));
    }

    // Check if username already exists
    if (username_exists($username)) {
        wp_send_json_error(array('message' => __('ชื่อผู้ใช้นี้ถูกใช้งานแล้ว', 'ayam-bangkok')));
    }

    // Check if email already exists
    if (email_exists($email)) {
        wp_send_json_error(array('message' => __('อีเมลนี้ถูกใช้งานแล้ว', 'ayam-bangkok')));
    }

    // Validate password strength
    if (strlen($password) < 8) {
        wp_send_json_error(array('message' => __('รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร', 'ayam-bangkok')));
    }

    // Create user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    }

    // Update user meta
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $first_name . ' ' . $last_name,
        'role' => 'subscriber'
    ));

    // Add custom user meta
    update_user_meta($user_id, 'phone', $phone);
    update_user_meta($user_id, 'line_id', $line_id);
    update_user_meta($user_id, 'country', $country);
    update_user_meta($user_id, 'business_type', $business_type);
    update_user_meta($user_id, 'address', $address);
    update_user_meta($user_id, 'interests', $interests);
    update_user_meta($user_id, 'agree_newsletter', $agree_newsletter);
    update_user_meta($user_id, 'registration_date', current_time('mysql'));

    // Save to customer profiles table
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_customer_profiles';

    $wpdb->insert(
        $table_name,
        array(
            'user_id' => $user_id,
            'customer_name' => $first_name . ' ' . $last_name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'customer_country' => $country,
            'customer_type' => $business_type,
            'preferences' => json_encode(array(
                'interests' => $interests,
                'newsletter' => $agree_newsletter
            )),
            'created_at' => current_time('mysql')
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    // Send welcome email
    $site_name = get_bloginfo('name');
    $login_url = wp_login_url();

    $email_subject = sprintf('[%s] ยินดีต้อนรับสู่ Ayam Bangkok', $site_name);
    $email_message = sprintf(
        "สวัสดี %s,\n\n" .
        "ขอบคุณที่สมัครเป็นสมาชิก Ayam Bangkok\n\n" .
        "ข้อมูลการเข้าสู่ระบบของคุณ:\n" .
        "ชื่อผู้ใช้: %s\n" .
        "อีเมล: %s\n\n" .
        "คุณสามารถเข้าสู่ระบบได้ที่: %s\n\n" .
        "สิทธิประโยชน์สมาชิก:\n" .
        "- ราคาพิเศษสำหรับสมาชิก\n" .
        "- รับข้อมูลข่าวสารและไก่ชนใหม่ก่อนใคร\n" .
        "- บันทึกรายการโปรดและติดตามสถานะ\n" .
        "- บริการส่งออกพิเศษ\n\n" .
        "หากมีคำถามหรือต้องการความช่วยเหลือ กรุณาติดต่อเราได้ตลอดเวลา\n\n" .
        "ขอบคุณครับ,\n" .
        "ทีมงาน Ayam Bangkok",
        $first_name,
        $username,
        $email,
        $login_url
    );

    wp_mail($email, $email_subject, $email_message);

    // Send notification to admin
    $admin_email = get_option('admin_email');
    $admin_subject = sprintf('[%s] สมาชิกใหม่: %s', $site_name, $first_name . ' ' . $last_name);
    $admin_message = sprintf(
        "มีสมาชิกใหม่สมัครเข้าระบบ\n\n" .
        "ชื่อ: %s %s\n" .
        "ชื่อผู้ใช้: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n" .
        "ประเทศ: %s\n" .
        "ประเภทธุรกิจ: %s\n" .
        "ความสนใจ: %s\n\n" .
        "เวลา: %s",
        $first_name,
        $last_name,
        $username,
        $email,
        $phone,
        $country,
        $business_type,
        implode(', ', $interests),
        current_time('Y-m-d H:i:s')
    );

    wp_mail($admin_email, $admin_subject, $admin_message);

    // Return success
    wp_send_json_success(array(
        'message' => __('สมัครสมาชิกสำเร็จ', 'ayam-bangkok'),
        'user_id' => $user_id
    ));
}
add_action('wp_ajax_ayam_register_member', 'ayam_register_member');
add_action('wp_ajax_nopriv_ayam_register_member', 'ayam_register_member');

// Add custom user fields to profile page
function ayam_add_custom_user_profile_fields($user)
{
    ?>
    <h3><?php _e('ข้อมูลเพิ่มเติม', 'ayam-bangkok'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="phone"><?php _e('เบอร์โทรศัพท์', 'ayam-bangkok'); ?></label></th>
            <td>
                <input type="text" name="phone" id="phone"
                    value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="line_id"><?php _e('LINE ID', 'ayam-bangkok'); ?></label></th>
            <td>
                <input type="text" name="line_id" id="line_id"
                    value="<?php echo esc_attr(get_user_meta($user->ID, 'line_id', true)); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="country"><?php _e('ประเทศ', 'ayam-bangkok'); ?></label></th>
            <td>
                <select name="country" id="country">
                    <option value=""><?php _e('เลือกประเทศ', 'ayam-bangkok'); ?></option>
                    <option value="TH" <?php selected(get_user_meta($user->ID, 'country', true), 'TH'); ?>>
                        <?php _e('ประเทศไทย', 'ayam-bangkok'); ?></option>
                    <option value="ID" <?php selected(get_user_meta($user->ID, 'country', true), 'ID'); ?>>
                        <?php _e('อินโดนีเซีย', 'ayam-bangkok'); ?></option>
                    <option value="MY" <?php selected(get_user_meta($user->ID, 'country', true), 'MY'); ?>>
                        <?php _e('มาเลเซีย', 'ayam-bangkok'); ?></option>
                    <option value="SG" <?php selected(get_user_meta($user->ID, 'country', true), 'SG'); ?>>
                        <?php _e('สิงคโปร์', 'ayam-bangkok'); ?></option>
                    <option value="OTHER" <?php selected(get_user_meta($user->ID, 'country', true), 'OTHER'); ?>>
                        <?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="business_type"><?php _e('ประเภทธุรกิจ', 'ayam-bangkok'); ?></label></th>
            <td>
                <select name="business_type" id="business_type">
                    <option value=""><?php _e('เลือกประเภทธุรกิจ', 'ayam-bangkok'); ?></option>
                    <option value="farm" <?php selected(get_user_meta($user->ID, 'business_type', true), 'farm'); ?>>
                        <?php _e('ฟาร์มเลี้ยงไก่', 'ayam-bangkok'); ?></option>
                    <option value="breeder" <?php selected(get_user_meta($user->ID, 'business_type', true), 'breeder'); ?>>
                        <?php _e('ผู้เพาะพันธุ์', 'ayam-bangkok'); ?></option>
                    <option value="trader" <?php selected(get_user_meta($user->ID, 'business_type', true), 'trader'); ?>>
                        <?php _e('ผู้ค้าไก่ชน', 'ayam-bangkok'); ?></option>
                    <option value="hobbyist" <?php selected(get_user_meta($user->ID, 'business_type', true), 'hobbyist'); ?>><?php _e('ผู้เลี้ยงเป็นงานอดิเรก', 'ayam-bangkok'); ?></option>
                    <option value="exporter" <?php selected(get_user_meta($user->ID, 'business_type', true), 'exporter'); ?>><?php _e('ผู้ส่งออก', 'ayam-bangkok'); ?></option>
                    <option value="other" <?php selected(get_user_meta($user->ID, 'business_type', true), 'other'); ?>>
                        <?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="address"><?php _e('ที่อยู่', 'ayam-bangkok'); ?></label></th>
            <td>
                <textarea name="address" id="address" rows="3"
                    class="regular-text"><?php echo esc_textarea(get_user_meta($user->ID, 'address', true)); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'ayam_add_custom_user_profile_fields');
add_action('edit_user_profile', 'ayam_add_custom_user_profile_fields');

// Save custom user profile fields
function ayam_save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    update_user_meta($user_id, 'line_id', sanitize_text_field($_POST['line_id']));
    update_user_meta($user_id, 'country', sanitize_text_field($_POST['country']));
    update_user_meta($user_id, 'business_type', sanitize_text_field($_POST['business_type']));
    update_user_meta($user_id, 'address', sanitize_textarea_field($_POST['address']));
}
add_action('personal_options_update', 'ayam_save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'ayam_save_custom_user_profile_fields');


/**
 * Member Dashboard System
 */

// Enqueue member dashboard assets
function ayam_member_dashboard_assets()
{
    if (is_page_template('page-member-dashboard.php')) {
        wp_enqueue_style('ayam-member-dashboard', AYAM_THEME_URI . '/assets/css/member-dashboard.css', array('ayam-style'), AYAM_THEME_VERSION);
        wp_enqueue_script('ayam-member-dashboard', AYAM_THEME_URI . '/assets/js/member-dashboard.js', array('jquery'), AYAM_THEME_VERSION, true);

        // Localize script for AJAX
        wp_localize_script('ayam-member-dashboard', 'ayamDashboard', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('member_dashboard_nonce'),
            'strings' => array(
                'confirm_remove' => __('ต้องการลบไก่ชนนี้ออกจากรายการโปรดหรือไม่?', 'ayam-bangkok'),
                'no_favorites' => __('ยังไม่มีไก่ชนที่ชื่นชอบ', 'ayam-bangkok'),
                'error' => __('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'ayam-bangkok'),
                'success' => __('ดำเนินการสำเร็จ', 'ayam-bangkok')
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_member_dashboard_assets');

// AJAX handler for adding favorite
function ayam_add_favorite()
{
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('กรุณาเข้าสู่ระบบก่อน', 'ayam-bangkok')));
    }

    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'member_dashboard_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed', 'ayam-bangkok')));
    }

    $user_id = get_current_user_id();
    $rooster_id = intval($_POST['rooster_id']);

    // Validate rooster exists
    $rooster = get_post($rooster_id);
    if (!$rooster || $rooster->post_type !== 'ayam_rooster') {
        wp_send_json_error(array('message' => __('ไม่พบข้อมูลไก่ชนที่ระบุ', 'ayam-bangkok')));
    }

    // Get current favorites
    $favorites = get_user_meta($user_id, 'favorite_roosters', true);
    $favorites = $favorites ? $favorites : array();

    // Check if already in favorites
    if (in_array($rooster_id, $favorites)) {
        wp_send_json_error(array('message' => __('ไก่ชนนี้อยู่ในรายการโปรดแล้ว', 'ayam-bangkok')));
    }

    // Add to favorites
    $favorites[] = $rooster_id;
    update_user_meta($user_id, 'favorite_roosters', $favorites);

    wp_send_json_success(array(
        'message' => __('เพิ่มในรายการโปรดแล้ว', 'ayam-bangkok'),
        'count' => count($favorites)
    ));
}
add_action('wp_ajax_ayam_add_favorite', 'ayam_add_favorite');

// AJAX handler for removing favorite
function ayam_remove_favorite()
{
    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('กรุณาเข้าสู่ระบบก่อน', 'ayam-bangkok')));
    }

    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'member_dashboard_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed', 'ayam-bangkok')));
    }

    $user_id = get_current_user_id();
    $rooster_id = intval($_POST['rooster_id']);

    // Get current favorites
    $favorites = get_user_meta($user_id, 'favorite_roosters', true);
    $favorites = $favorites ? $favorites : array();

    // Remove from favorites
    $key = array_search($rooster_id, $favorites);
    if ($key !== false) {
        unset($favorites[$key]);
        $favorites = array_values($favorites); // Re-index array
        update_user_meta($user_id, 'favorite_roosters', $favorites);

        wp_send_json_success(array(
            'message' => __('ลบออกจากรายการโปรดแล้ว', 'ayam-bangkok'),
            'count' => count($favorites)
        ));
    } else {
        wp_send_json_error(array('message' => __('ไม่พบไก่ชนนี้ในรายการโปรด', 'ayam-bangkok')));
    }
}
add_action('wp_ajax_ayam_remove_favorite', 'ayam_remove_favorite');

// Check if rooster is in favorites
function ayam_is_favorite($rooster_id, $user_id = null)
{
    if (!$user_id) {
        if (!is_user_logged_in()) {
            return false;
        }
        $user_id = get_current_user_id();
    }

    $favorites = get_user_meta($user_id, 'favorite_roosters', true);
    $favorites = $favorites ? $favorites : array();

    return in_array($rooster_id, $favorites);
}

// Add favorite button to rooster pages
function ayam_favorite_button($rooster_id = null)
{
    if (!$rooster_id) {
        $rooster_id = get_the_ID();
    }

    if (!is_user_logged_in()) {
        return '<a href="' . wp_login_url(get_permalink($rooster_id)) . '" class="btn-favorite" title="' . __('เข้าสู่ระบบเพื่อเพิ่มในรายการโปรด', 'ayam-bangkok') . '">
            <i class="far fa-heart"></i>
        </a>';
    }

    $is_favorite = ayam_is_favorite($rooster_id);
    $icon_class = $is_favorite ? 'fas fa-heart' : 'far fa-heart';
    $title = $is_favorite ? __('ลบออกจากรายการโปรด', 'ayam-bangkok') : __('เพิ่มในรายการโปรด', 'ayam-bangkok');
    $active_class = $is_favorite ? 'active' : '';

    return '<button class="btn-favorite ' . $active_class . '" data-rooster-id="' . $rooster_id . '" title="' . $title . '">
        <i class="' . $icon_class . '"></i>
    </button>';
}

// Get member-only pricing
function ayam_get_member_price($regular_price, $user_id = null)
{
    if (!$user_id) {
        if (!is_user_logged_in()) {
            return $regular_price;
        }
        $user_id = get_current_user_id();
    }

    // Apply 10% discount for members
    $discount_percentage = 10;
    $member_price = $regular_price * (1 - ($discount_percentage / 100));

    return $member_price;
}

// Display member pricing
function ayam_display_member_pricing($rooster_id = null)
{
    if (!$rooster_id) {
        $rooster_id = get_the_ID();
    }

    $regular_price = get_field('rooster_price', $rooster_id);

    if (!$regular_price) {
        return '';
    }

    if (is_user_logged_in()) {
        $member_price = ayam_get_member_price($regular_price);

        return '<div class="pricing-display member-pricing">
            <span class="regular-price">' . number_format($regular_price) . ' บาท</span>
            <span class="member-price">' . number_format($member_price) . ' บาท</span>
            <span class="member-badge">' . __('ราคาสมาชิก', 'ayam-bangkok') . '</span>
        </div>';
    } else {
        return '<div class="pricing-display">
            <span class="regular-price">' . number_format($regular_price) . ' บาท</span>
            <a href="' . home_url('/member-registration') . '" class="member-link">' . __('สมัครสมาชิกเพื่อรับส่วนลด', 'ayam-bangkok') . '</a>
        </div>';
    }
}

// Redirect to dashboard after login
function ayam_login_redirect($redirect_to, $request, $user)
{
    // Check if user has dashboard page
    $dashboard_page = get_page_by_path('member-dashboard');

    if ($dashboard_page && !is_wp_error($user)) {
        return get_permalink($dashboard_page->ID);
    }

    return $redirect_to;
}
add_filter('login_redirect', 'ayam_login_redirect', 10, 3);

// Add dashboard link to admin bar
function ayam_admin_bar_dashboard_link($wp_admin_bar)
{
    if (!is_user_logged_in()) {
        return;
    }

    $dashboard_page = get_page_by_path('member-dashboard');

    if ($dashboard_page) {
        $wp_admin_bar->add_menu(array(
            'id' => 'member-dashboard',
            'title' => '<i class="fas fa-tachometer-alt"></i> ' . __('Dashboard', 'ayam-bangkok'),
            'href' => get_permalink($dashboard_page->ID),
            'parent' => 'user-actions'
        ));
    }
}
add_action('admin_bar_menu', 'ayam_admin_bar_dashboard_link', 100);

// Get user statistics
function ayam_get_user_stats($user_id = null)
{
    if (!$user_id) {
        if (!is_user_logged_in()) {
            return array();
        }
        $user_id = get_current_user_id();
    }

    $user = get_userdata($user_id);
    if (!$user) {
        return array();
    }

    global $wpdb;
    $inquiries_table = $wpdb->prefix . 'ayam_inquiries';
    $bookings_table = $wpdb->prefix . 'ayam_bookings';

    $stats = array(
        'total_inquiries' => $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $inquiries_table WHERE customer_email = %s",
            $user->user_email
        )),
        'total_bookings' => $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $bookings_table WHERE customer_email = %s",
            $user->user_email
        )),
        'total_favorites' => count(get_user_meta($user_id, 'favorite_roosters', true) ?: array()),
        'member_since' => get_user_meta($user_id, 'registration_date', true) ?: $user->user_registered
    );

    return $stats;
}


/**
 * Contact Page System
 */

// Enqueue contact page assets
function ayam_contact_page_assets()
{
    if (is_page_template('page-contact.php')) {
        wp_enqueue_style('ayam-contact', AYAM_THEME_URI . '/assets/css/contact.css', array('ayam-style'), AYAM_THEME_VERSION);
        wp_enqueue_script('ayam-contact', AYAM_THEME_URI . '/assets/js/contact.js', array('jquery'), AYAM_THEME_VERSION, true);

        // Localize script for AJAX
        wp_localize_script('ayam-contact', 'ayamContact', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('contact_form_nonce'),
            'strings' => array(
                'name_required' => __('กรุณากรอกชื่อ-นามสกุล', 'ayam-bangkok'),
                'email_required' => __('กรุณากรอกอีเมล', 'ayam-bangkok'),
                'email_invalid' => __('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok'),
                'phone_invalid' => __('รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง', 'ayam-bangkok'),
                'subject_required' => __('กรุณาเลือกหัวข้อ', 'ayam-bangkok'),
                'message_required' => __('กรุณากรอกข้อความ', 'ayam-bangkok'),
                'error' => __('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'ayam-bangkok')
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_contact_page_assets');

// AJAX handler for contact form
function ayam_contact_form()
{
    // Verify nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form')) {
        wp_send_json_error(array('message' => __('Security check failed', 'ayam-bangkok')));
    }

    // Sanitize and validate input
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $visit_date = isset($_POST['visit_date']) ? sanitize_text_field($_POST['visit_date']) : '';
    $visit_time = isset($_POST['visit_time']) ? sanitize_text_field($_POST['visit_time']) : '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error(array('message' => __('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok')));
    }

    // Validate email format
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('รูปแบบอีเมลไม่ถูกต้อง', 'ayam-bangkok')));
    }

    // Map subject to Thai
    $subject_map = array(
        'general' => 'สอบถามทั่วไป',
        'rooster' => 'สอบถามเกี่ยวกับไก่ชน',
        'service' => 'สอบถามบริการ',
        'export' => 'สอบถามการส่งออก',
        'visit' => 'นัดหมายเยี่ยมชม',
        'other' => 'อื่นๆ'
    );

    $subject_text = isset($subject_map[$subject]) ? $subject_map[$subject] : $subject;

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_inquiries';

    $inquiry_data = array(
        'inquiry_type' => 'contact_form',
        'customer_name' => $name,
        'customer_email' => $email,
        'customer_phone' => $phone,
        'subject' => $subject_text,
        'message' => $message,
        'status' => 'new',
        'created_at' => current_time('mysql')
    );

    // Add visit information if applicable
    if ($subject === 'visit' && $visit_date) {
        $inquiry_data['additional_info'] = json_encode(array(
            'visit_date' => $visit_date,
            'visit_time' => $visit_time
        ));
    }

    $result = $wpdb->insert($table_name, $inquiry_data);

    if ($result === false) {
        wp_send_json_error(array('message' => __('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'ayam-bangkok')));
    }

    // Send email notification to admin
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = sprintf('[%s] ข้อความใหม่: %s', $site_name, $subject_text);

    $email_message = sprintf(
        "มีข้อความใหม่จากเว็บไซต์\n\n" .
        "หัวข้อ: %s\n" .
        "ชื่อ: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n\n" .
        "ข้อความ:\n%s\n\n",
        $subject_text,
        $name,
        $email,
        $phone,
        $message
    );

    // Add visit information to email if applicable
    if ($subject === 'visit' && $visit_date) {
        $email_message .= sprintf(
            "วันที่ต้องการเยี่ยมชม: %s\n" .
            "เวลา: %s\n\n",
            date_i18n('j F Y', strtotime($visit_date)),
            $visit_time
        );
    }

    $email_message .= sprintf("เวลา: %s", current_time('Y-m-d H:i:s'));

    wp_mail($admin_email, $email_subject, $email_message);

    // Send confirmation email to customer
    $customer_subject = sprintf('[%s] ขอบคุณที่ติดต่อเรา', $site_name);
    $customer_message = sprintf(
        "สวัสดี %s,\n\n" .
        "ขอบคุณที่ติดต่อ Ayam Bangkok\n\n" .
        "เราได้รับข้อความของคุณเรียบร้อยแล้ว และจะติดต่อกลับโดยเร็วที่สุด\n\n" .
        "รายละเอียดข้อความของคุณ:\n" .
        "หัวข้อ: %s\n" .
        "ข้อความ: %s\n\n" .
        "หากมีคำถามเพิ่มเติม สามารถติดต่อเราได้ที่:\n" .
        "โทร: %s\n" .
        "อีเมล: %s\n\n" .
        "ขอบคุณครับ,\n" .
        "ทีมงาน Ayam Bangkok",
        $name,
        $subject_text,
        $message,
        get_theme_mod('ayam_phone', ''),
        get_theme_mod('ayam_email', '')
    );

    wp_mail($email, $customer_subject, $customer_message);

    // Return success
    wp_send_json_success(array(
        'message' => __('ส่งข้อความสำเร็จ เราจะติดต่อกลับโดยเร็วที่สุด', 'ayam-bangkok')
    ));
}
add_action('wp_ajax_ayam_contact_form', 'ayam_contact_form');
add_action('wp_ajax_nopriv_ayam_contact_form', 'ayam_contact_form');


/**
 * Services System
 */

// Enqueue services assets
function ayam_services_assets()
{
    if (is_post_type_archive('ayam_service') || is_singular('ayam_service')) {
        wp_enqueue_style('ayam-services', AYAM_THEME_URI . '/assets/css/services.css', array('ayam-style'), AYAM_THEME_VERSION);
        wp_enqueue_script('ayam-services', AYAM_THEME_URI . '/assets/js/services.js', array('jquery'), AYAM_THEME_VERSION, true);

        wp_localize_script('ayam-services', 'ayamServices', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('service_booking_nonce')
        ));
    }
}
add_action('wp_enqueue_scripts', 'ayam_services_assets');

// AJAX handler for service booking
function ayam_service_booking()
{
    if (!isset($_POST['booking_nonce']) || !wp_verify_nonce($_POST['booking_nonce'], 'service_booking')) {
        wp_send_json_error(array('message' => __('Security check failed', 'ayam-bangkok')));
    }

    $service_id = intval($_POST['service_id']);
    $service_name = sanitize_text_field($_POST['service_name']);
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_email = sanitize_email($_POST['customer_email']);
    $customer_phone = sanitize_text_field($_POST['customer_phone']);
    $booking_date = sanitize_text_field($_POST['booking_date']);
    $booking_notes = sanitize_textarea_field($_POST['booking_notes']);

    if (empty($customer_name) || empty($customer_email) || empty($customer_phone) || empty($booking_date)) {
        wp_send_json_error(array('message' => __('กรุณากรอกข้อมูลให้ครบถ้วน', 'ayam-bangkok')));
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'ayam_bookings';

    $result = $wpdb->insert(
        $table_name,
        array(
            'service_id' => $service_id,
            'service_name' => $service_name,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'booking_date' => $booking_date,
            'booking_notes' => $booking_notes,
            'status' => 'pending',
            'created_at' => current_time('mysql')
        )
    );

    if ($result === false) {
        wp_send_json_error(array('message' => __('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'ayam-bangkok')));
    }

    // Send email notifications
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $admin_subject = sprintf('[%s] การจองบริการใหม่: %s', $site_name, $service_name);
    $admin_message = sprintf(
        "มีการจองบริการใหม่\n\n" .
        "บริการ: %s\n" .
        "ชื่อลูกค้า: %s\n" .
        "อีเมล: %s\n" .
        "เบอร์โทร: %s\n" .
        "วันที่: %s\n" .
        "หมายเหตุ: %s\n\n" .
        "เวลา: %s",
        $service_name,
        $customer_name,
        $customer_email,
        $customer_phone,
        date_i18n('j F Y', strtotime($booking_date)),
        $booking_notes,
        current_time('Y-m-d H:i:s')
    );

    wp_mail($admin_email, $admin_subject, $admin_message);

    // Customer confirmation
    $customer_subject = sprintf('[%s] ยืนยันการจองบริการ', $site_name);
    $customer_message = sprintf(
        "สวัสดี %s,\n\n" .
        "ขอบคุณที่จองบริการกับ Ayam Bangkok\n\n" .
        "รายละเอียดการจอง:\n" .
        "บริการ: %s\n" .
        "วันที่: %s\n\n" .
        "เราจะติดต่อกลับเพื่อยืนยันการจองโดยเร็วที่สุด\n\n" .
        "ขอบคุณครับ,\n" .
        "ทีมงาน Ayam Bangkok",
        $customer_name,
        $service_name,
        date_i18n('j F Y', strtotime($booking_date))
    );

    wp_mail($customer_email, $customer_subject, $customer_message);

    wp_send_json_success(array(
        'message' => __('จองบริการสำเร็จ เราจะติดต่อกลับโดยเร็วที่สุด', 'ayam-bangkok')
    ));
}
add_action('wp_ajax_ayam_service_booking', 'ayam_service_booking');
add_action('wp_ajax_nopriv_ayam_service_booking', 'ayam_service_booking');

/**
 * Auto-assign Wix-style templates based on page slug
 */
function ayam_auto_assign_wix_templates($template) {
    if (!is_page()) {
        return $template;
    }
    
    global $post;
    if (!$post) {
        return $template;
    }
    
    // Map page slugs to template files
    $page_templates = array(
        'about' => 'page-about.php',
        'about-us' => 'page-about.php',
        'service' => 'page-service.php',
        'services' => 'page-service.php',
        'news' => 'page-news-wix.php'
        // Removed gallery auto-assignment - let WordPress use the template selected in Customizer
    );
    
    // Check if current page slug matches
    if (isset($page_templates[$post->post_name])) {
        $template_file = locate_template($page_templates[$post->post_name]);
        if ($template_file) {
            error_log("Auto-assigning template: {$page_templates[$post->post_name]} for page: {$post->post_name}");
            return $template_file;
        }
    }
    
    return $template;
}
add_filter('template_include', 'ayam_auto_assign_wix_templates', 99);

/**
 * Force enqueue Wix styles on specific pages
 */
function ayam_force_wix_styles() {
    if (is_page('about') || is_page('about-us') || is_page(27)) {
        wp_enqueue_style('wix-about-page', AYAM_THEME_URI . '/assets/css/wix-about-page.css', array(), AYAM_THEME_VERSION . '.' . time());
    }
    // Service page uses service.css only - no wix-service-page.css needed
    if (is_page('news') || is_page(168)) {
        wp_enqueue_style('wix-all-pages', AYAM_THEME_URI . '/assets/css/wix-all-pages.css', array(), AYAM_THEME_VERSION . '.' . time());
    }
    if (is_page('gallery') || is_page('ayam-list') || is_page('ayam-list-detail')) {
        wp_enqueue_style('wix-homepage-complete', AYAM_THEME_URI . '/assets/css/wix-homepage-complete.css', array(), AYAM_THEME_VERSION);
        wp_enqueue_style('wix-all-pages', AYAM_THEME_URI . '/assets/css/wix-all-pages.css', array(), AYAM_THEME_VERSION . '.' . time());
    }
}
add_action('wp_enqueue_scripts', 'ayam_force_wix_styles', 999);


/**
 * Include Admin Pages
 */
require_once AYAM_THEME_PATH . '/admin-gallery-categories.php';
require_once AYAM_THEME_PATH . '/admin-shipment-management.php';
