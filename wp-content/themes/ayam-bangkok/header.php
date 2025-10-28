<?php
/**
 * The header for our theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <style>
    /* Gallery Submenu Dropdown - Override all other styles with higher specificity */
    .wix-header .wix-nav .wix-menu li.has-submenu {
        position: relative !important;
    }

    .wix-header .wix-nav .wix-menu li.has-submenu .submenu {
        display: none !important;
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        background: #2B3E50 !important;
        min-width: 200px !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 10px 0 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
        z-index: 1001 !important;
    }

    .wix-header .wix-nav .wix-menu li.has-submenu:hover .submenu {
        display: block !important;
    }

    .wix-header .wix-nav .wix-menu li.has-submenu .submenu li {
        margin: 0 !important;
        padding: 0 !important;
        display: block !important;
    }

    .wix-header .wix-nav .wix-menu li.has-submenu .submenu li a {
        padding: 10px 20px !important;
        display: block !important;
        font-size: 13px !important;
        color: white !important;
        text-decoration: none !important;
        transition: background 0.3s ease, color 0.3s ease !important;
        background: transparent !important;
    }

    .wix-header .wix-nav .wix-menu li.has-submenu .submenu li a:hover {
        background: #3d5568 !important;
        color: #C4504A !important;
    }

    /* Mobile submenu */
    @media (max-width: 1024px) {
        .wix-header .wix-nav .wix-menu li.has-submenu .submenu {
            position: static !important;
            display: none !important;
            background: #1f2d3d !important;
            box-shadow: none !important;
            padding-left: 20px !important;
        }

        .wix-header .wix-nav .wix-menu li.has-submenu.active .submenu {
            display: block !important;
        }

        .wix-header .wix-nav .wix-menu li.has-submenu .submenu li a {
            padding: 12px 20px !important;
            font-size: 12px !important;
        }
    }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php _e('ข้ามไปยังเนื้อหา', 'ayam-bangkok'); ?></a>
    
    <!-- Wix Style Header -->
    <header id="masthead" class="wix-header">
        <div class="wix-header-container">
            <div class="wix-header-left">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="wix-logo">
                    <?php 
                    $custom_logo_id = get_theme_mod('custom_logo');
                    if ($custom_logo_id) {
                        $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
                        if ($logo_image) {
                            echo '<img src="' . esc_url($logo_image[0]) . '" alt="' . get_bloginfo('name') . '" class="custom-logo">';
                        }
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/images/logo-ayam-bangkok.svg" alt="AYAM BANGKOK" class="wix-logo-img">';
                    }
                    ?>
                </a>
            </div>
            
            <nav class="wix-nav">
                <ul class="wix-menu">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/service')); ?>">Service</a></li>
                    <li><a href="<?php echo esc_url(home_url('/news-1')); ?>">News</a></li>
                    <li class="has-submenu">
                        <a href="<?php echo esc_url(home_url('/gallery')); ?>">Gallery</a>
                        <ul class="submenu">
                            <li><a href="<?php echo esc_url(home_url('/gallery')); ?>">Gallery</a></li>
                            <li><a href="<?php echo esc_url(home_url('/ayam-list')); ?>">Ayam list</a></li>
                            <li><a href="<?php echo esc_url(home_url('/gallery/?category=BTS')); ?>">behind the scene</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </nav>
            
            <button class="wix-mobile-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header><!-- #masthead -->

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay"></div>

    <script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.querySelector('.wix-mobile-toggle');
        const wixNav = document.querySelector('.wix-nav');
        const hasSubmenuItems = document.querySelectorAll('.wix-menu li.has-submenu');

        // Toggle mobile menu
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                wixNav.classList.toggle('active');
            });
        }

        // Mobile submenu toggle
        hasSubmenuItems.forEach(function(item) {
            const link = item.querySelector('> a');
            if (window.innerWidth <= 1024 && link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    item.classList.toggle('active');
                });
            }
        });
    });
    </script>

    <?php
    // Display breadcrumbs on non-front pages
    if (!is_front_page()) {
        ayam_breadcrumbs();
    }
    ?>

<?php
/**
 * Default menu fallback
 */
function ayam_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('หน้าแรก', 'ayam-bangkok') . '</a></li>';
    
    // Add custom post type archives
    $post_types = array(
        'ayam_rooster' => __('ไก่ชน', 'ayam-bangkok'),
        'ayam_service' => __('บริการ', 'ayam-bangkok'),
        'ayam_news' => __('ข่าวสาร', 'ayam-bangkok'),
        'ayam_knowledge' => __('ศูนย์ความรู้', 'ayam-bangkok'),
    );
    
    foreach ($post_types as $post_type => $label) {
        if (post_type_exists($post_type)) {
            $archive_link = get_post_type_archive_link($post_type);
            if ($archive_link) {
                echo '<li><a href="' . esc_url($archive_link) . '">' . esc_html($label) . '</a></li>';
            }
        }
    }
    
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('ติดต่อเรา', 'ayam-bangkok') . '</a></li>';
    echo '</ul>';
}

/**
 * Breadcrumbs function
 */
function ayam_breadcrumbs() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumbs" aria-label="' . __('Breadcrumb', 'ayam-bangkok') . '">';
        echo '<div class="container">';
        echo '<ol class="breadcrumb-list">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('หน้าแรก', 'ayam-bangkok') . '</a></li>';
        
        if (is_category() || is_single()) {
            if (is_single()) {
                $category = get_the_category();
                if ($category) {
                    echo '<li><a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a></li>';
                }
                echo '<li class="current">' . get_the_title() . '</li>';
            } else {
                echo '<li class="current">' . single_cat_title('', false) . '</li>';
            }
        } elseif (is_page()) {
            if ($post = get_post()) {
                if ($post->post_parent) {
                    $ancestors = get_post_ancestors($post);
                    $ancestors = array_reverse($ancestors);
                    foreach ($ancestors as $ancestor) {
                        echo '<li><a href="' . esc_url(get_permalink($ancestor)) . '">' . get_the_title($ancestor) . '</a></li>';
                    }
                }
                echo '<li class="current">' . get_the_title() . '</li>';
            }
        } elseif (is_post_type_archive()) {
            echo '<li class="current">' . post_type_archive_title('', false) . '</li>';
        } elseif (is_tax()) {
            echo '<li class="current">' . single_term_title('', false) . '</li>';
        }
        
        echo '</ol>';
        echo '</div>';
        echo '</nav>';
    }
}
?>