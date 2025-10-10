<?php
/**
 * Theme Customizer
 *
 * @package Ayam_Bangkok
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function ayam_bangkok_customize_register( $wp_customize ) {

    // ===================================
    // HOMEPAGE SETTINGS
    // ===================================

    $wp_customize->add_panel( 'homepage_panel', array(
        'title'       => __( 'Homepage Settings', 'ayam-bangkok' ),
        'description' => __( 'Customize homepage content', 'ayam-bangkok' ),
        'priority'    => 30,
    ) );

    // Hero Section
    $wp_customize->add_section( 'hero_section', array(
        'title'    => __( 'ส่วน Hero', 'ayam-bangkok' ),
        'panel'    => 'homepage_panel',
        'priority' => 10,
    ) );

    // Hero Title
    $wp_customize->add_setting( 'hero_title', array(
        'default'           => 'Welcome to<br>AYAM BANGKOK',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'hero_title', array(
        'label'    => __( 'หัวข้อหลัก', 'ayam-bangkok' ),
        'section'  => 'hero_section',
        'type'     => 'textarea',
        'description' => __( 'ใช้ &lt;br&gt; เพื่อขึ้นบรรทัดใหม่', 'ayam-bangkok' ),
    ) );

    // Hero Subtitle
    $wp_customize->add_setting( 'hero_subtitle', array(
        'default'           => 'Layanan pengiriman ayam lokal Thailand dengan pesawat terbang',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'hero_subtitle', array(
        'label'    => __( 'คำบรรยาย', 'ayam-bangkok' ),
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ) );

    // Hero Slider Images
    for ( $i = 1; $i <= 3; $i++ ) {
        $wp_customize->add_setting( "hero_slide_$i", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ) );

        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "hero_slide_$i", array(
            'label'     => sprintf( __( 'รูปภาพสไลด์ %d', 'ayam-bangkok' ), $i ),
            'section'   => 'hero_section',
            'mime_type' => 'image',
        ) ) );
    }

    // About Intro Section
    $wp_customize->add_section( 'about_intro_section', array(
        'title'    => __( 'ส่วน About Intro', 'ayam-bangkok' ),
        'panel'    => 'homepage_panel',
        'priority' => 20,
    ) );

    // About Intro Title
    $wp_customize->add_setting( 'about_intro_title', array(
        'default'           => 'Meet the<br>Nong Chok FCI',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'about_intro_title', array(
        'label'    => __( 'หัวข้อ', 'ayam-bangkok' ),
        'section'  => 'about_intro_section',
        'type'     => 'textarea',
    ) );

    // About Intro Subtitle
    $wp_customize->add_setting( 'about_intro_subtitle', array(
        'default'           => 'Six executives of Ayam Bangkok',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'about_intro_subtitle', array(
        'label'    => __( 'คำบรรยายย่อย', 'ayam-bangkok' ),
        'section'  => 'about_intro_section',
        'type'     => 'text',
    ) );

    // About Intro Text
    $wp_customize->add_setting( 'about_intro_text', array(
        'default'           => "I'm a paragraph. Click here to add your own text and edit me. I'm a great place for you to tell a story and let your users know a little more about you.",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'about_intro_text', array(
        'label'    => __( 'เนื้อหา', 'ayam-bangkok' ),
        'section'  => 'about_intro_section',
        'type'     => 'textarea',
    ) );

    // About Intro Images
    for ( $i = 1; $i <= 3; $i++ ) {
        $wp_customize->add_setting( "about_intro_image_$i", array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ) );

        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "about_intro_image_$i", array(
            'label'     => sprintf( __( 'รูปภาพ %d', 'ayam-bangkok' ), $i ),
            'section'   => 'about_intro_section',
            'mime_type' => 'image',
        ) ) );
    }

    // Services Section
    $wp_customize->add_section( 'services_section', array(
        'title'    => __( 'ส่วนบริการ', 'ayam-bangkok' ),
        'panel'    => 'homepage_panel',
        'priority' => 30,
    ) );

    // Services Title
    $wp_customize->add_setting( 'services_title', array(
        'default'           => 'Our Services',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'services_title', array(
        'label'    => __( 'หัวข้อ', 'ayam-bangkok' ),
        'section'  => 'services_section',
        'type'     => 'text',
    ) );

    // Services Description
    $wp_customize->add_setting( 'services_description', array(
        'default'           => 'We offer comprehensive export services for Thai fighting roosters',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'services_description', array(
        'label'    => __( 'คำบรรยาย', 'ayam-bangkok' ),
        'section'  => 'services_section',
        'type'     => 'textarea',
    ) );

    // 3 Services
    for ( $i = 1; $i <= 3; $i++ ) {
        // Service Icon
        $wp_customize->add_setting( "service_{$i}_icon", array(
            'default'           => 'fas fa-plane',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( "service_{$i}_icon", array(
            'label'       => sprintf( __( 'บริการ %d - ไอคอน', 'ayam-bangkok' ), $i ),
            'section'     => 'services_section',
            'type'        => 'text',
            'description' => __( 'FontAwesome class (เช่น fas fa-plane)', 'ayam-bangkok' ),
        ) );

        // Service Title
        $wp_customize->add_setting( "service_{$i}_title", array(
            'default'           => "Service $i",
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( "service_{$i}_title", array(
            'label'    => sprintf( __( 'บริการ %d - หัวข้อ', 'ayam-bangkok' ), $i ),
            'section'  => 'services_section',
            'type'     => 'text',
        ) );

        // Service Description
        $wp_customize->add_setting( "service_{$i}_description", array(
            'default'           => "Description for service $i",
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( "service_{$i}_description", array(
            'label'    => sprintf( __( 'บริการ %d - คำบรรยาย', 'ayam-bangkok' ), $i ),
            'section'  => 'services_section',
            'type'     => 'textarea',
        ) );
    }

    // Stats Section
    $wp_customize->add_section( 'stats_section', array(
        'title'    => __( 'ส่วนสถิติ', 'ayam-bangkok' ),
        'panel'    => 'homepage_panel',
        'priority' => 40,
    ) );

    // 4 Stats
    $stat_defaults = array(
        1 => array( 'number' => '500+', 'label' => 'ไก่ที่ส่งออก' ),
        2 => array( 'number' => '100+', 'label' => 'ลูกค้าที่พึงพอใจ' ),
        3 => array( 'number' => '10+', 'label' => 'ประเทศที่ส่งออก' ),
        4 => array( 'number' => '5+', 'label' => 'ปีของประสบการณ์' ),
    );

    for ( $i = 1; $i <= 4; $i++ ) {
        // Stat Number
        $wp_customize->add_setting( "stat_{$i}_number", array(
            'default'           => $stat_defaults[$i]['number'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( "stat_{$i}_number", array(
            'label'    => sprintf( __( 'สถิติ %d - ตัวเลข', 'ayam-bangkok' ), $i ),
            'section'  => 'stats_section',
            'type'     => 'text',
        ) );

        // Stat Label
        $wp_customize->add_setting( "stat_{$i}_label", array(
            'default'           => $stat_defaults[$i]['label'],
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( "stat_{$i}_label", array(
            'label'    => sprintf( __( 'สถิติ %d - ป้ายกำกับ', 'ayam-bangkok' ), $i ),
            'section'  => 'stats_section',
            'type'     => 'text',
        ) );
    }

    // ===================================
    // GALLERY PAGE SETTINGS
    // ===================================

    $wp_customize->add_section( 'gallery_section', array(
        'title'       => __( 'Gallery Page', 'ayam-bangkok' ),
        'description' => __( 'Customize gallery page content', 'ayam-bangkok' ),
        'priority'    => 40,
    ) );

    // Gallery Title
    $wp_customize->add_setting( 'gallery_title', array(
        'default'           => 'Our Gallery',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'gallery_title', array(
        'label'    => __( 'หัวข้อ', 'ayam-bangkok' ),
        'section'  => 'gallery_section',
        'type'     => 'text',
    ) );

    // Gallery Description
    $wp_customize->add_setting( 'gallery_description', array(
        'default'           => 'Explore our collection of Thai fighting roosters',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'gallery_description', array(
        'label'    => __( 'คำบรรยาย', 'ayam-bangkok' ),
        'section'  => 'gallery_section',
        'type'     => 'textarea',
    ) );

    // ===================================
    // CONTACT PAGE SETTINGS
    // ===================================

    $wp_customize->add_section( 'contact_section', array(
        'title'       => __( 'Contact Page', 'ayam-bangkok' ),
        'description' => __( 'Customize contact page content', 'ayam-bangkok' ),
        'priority'    => 50,
    ) );

    // Contact Title
    $wp_customize->add_setting( 'contact_title', array(
        'default'           => 'Get in Touch',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'contact_title', array(
        'label'    => __( 'หัวข้อ', 'ayam-bangkok' ),
        'section'  => 'contact_section',
        'type'     => 'text',
    ) );

    // Contact Subtitle
    $wp_customize->add_setting( 'contact_subtitle', array(
        'default'           => 'We\'d love to hear from you',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'contact_subtitle', array(
        'label'    => __( 'คำบรรยาย', 'ayam-bangkok' ),
        'section'  => 'contact_section',
        'type'     => 'textarea',
    ) );

    // Contact Address
    $wp_customize->add_setting( 'contact_address', array(
        'default'           => 'ถนน พุทธบูชา 11 ตำบลโคกเจริญ แขวงหนองจอก เขตหนองจอก Nong Chok, Bangkok, Thailand',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'contact_address', array(
        'label'    => __( 'ที่อยู่', 'ayam-bangkok' ),
        'section'  => 'contact_section',
        'type'     => 'textarea',
    ) );

    // Contact Phone
    $wp_customize->add_setting( 'contact_phone', array(
        'default'           => '089-091-4664',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'contact_phone', array(
        'label'    => __( 'เบอร์โทรศัพท์', 'ayam-bangkok' ),
        'section'  => 'contact_section',
        'type'     => 'text',
    ) );

    // Contact Email
    $wp_customize->add_setting( 'contact_email', array(
        'default'           => 'info@ayambangkok.com',
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'contact_email', array(
        'label'    => __( 'อีเมล', 'ayam-bangkok' ),
        'section'  => 'contact_section',
        'type'     => 'email',
    ) );

    // Google Map URL
    $wp_customize->add_setting( 'contact_map_url', array(
        'default'           => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.5234!2d100.8234!3d13.8234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDQ5JzI0LjIiTiAxMDDCsDQ5JzI0LjIiRQ!5e0!3m2!1sen!2sth!4v1234567890',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'contact_map_url', array(
        'label'       => __( 'Google Map Embed URL', 'ayam-bangkok' ),
        'section'     => 'contact_section',
        'type'        => 'url',
        'description' => __( 'URL สำหรับฝัง Google Map', 'ayam-bangkok' ),
    ) );
}
add_action( 'customize_register', 'ayam_bangkok_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ayam_bangkok_customize_preview_js() {
    wp_enqueue_script( 'ayam-bangkok-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20250110', true );
}
add_action( 'customize_preview_init', 'ayam_bangkok_customize_preview_js' );
