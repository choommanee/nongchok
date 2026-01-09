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

    <!-- Immediately hide only Google Translate banner -->
    <style>
        /* Hide only the banner, not the functionality */
        .goog-te-banner-frame,
        iframe.goog-te-banner-frame,
        iframe.VIpgJd-ZVi9od-ORHb-OEVmcd,
        .skiptranslate:has(iframe.VIpgJd-ZVi9od-ORHb-OEVmcd) {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            margin-top: -100px !important;
            position: absolute !important;
            top: -9999px !important;
            left: -9999px !important;
        }

        /* Specific targeting for the container div */
        div.skiptranslate[style*="visibility"] {
            display: none !important;
            position: absolute !important;
            top: -9999px !important;
            left: -9999px !important;
        }

        /* Reset body position that Google Translate adds */
        body {
            top: 0 !important;
            position: relative !important;
            margin-top: 0 !important;
        }

        body.translated-ltr {
            top: 0 !important;
            margin-top: 0 !important;
        }

        /* Hide the translate widget but keep it functional */
        #google_translate_element {
            position: absolute;
            left: -9999px;
        }
    </style>

    <?php wp_head(); ?>

    <!-- Google Translate Scripts -->
    <script type="text/javascript">
    // Watch for Google Translate iframe creation and inject styles
    (function() {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    // Check if it's the skiptranslate div
                    if (node.nodeType === 1 && node.className && node.className.includes('skiptranslate')) {
                        // Check for iframe inside
                        const iframe = node.querySelector('iframe.VIpgJd-ZVi9od-ORHb-OEVmcd');
                        if (iframe) {
                            // Hide the parent div
                            node.style.position = 'absolute';
                            node.style.top = '-100px';
                            node.style.left = '-9999px';
                            node.style.height = '0';
                            node.style.overflow = 'hidden';

                            // Also hide the iframe
                            iframe.style.display = 'none';
                            iframe.style.visibility = 'hidden';
                            iframe.style.marginTop = '-100px';

                            console.log('Google Translate banner iframe hidden');
                        }
                    }

                    // Also check if the node itself is the iframe
                    if (node.nodeType === 1 && node.tagName === 'IFRAME' &&
                        node.className && node.className.includes('VIpgJd-ZVi9od-ORHb-OEVmcd')) {
                        node.style.display = 'none';
                        node.style.visibility = 'hidden';
                        node.style.marginTop = '-100px';

                        // Hide parent div if exists
                        if (node.parentElement && node.parentElement.className.includes('skiptranslate')) {
                            node.parentElement.style.position = 'absolute';
                            node.parentElement.style.top = '-100px';
                            node.parentElement.style.left = '-9999px';
                            node.parentElement.style.height = '0';
                            node.parentElement.style.overflow = 'hidden';
                        }
                    }
                });
            });
        });

        // Start observing the entire document
        observer.observe(document.documentElement, {
            childList: true,
            subtree: true
        });
    })();

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'th',
            includedLanguages: 'th,en,id',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');

        // Additional check after initialization
        setTimeout(function() {
            // Find all skiptranslate divs and check if they contain the iframe
            const skiptranslateDivs = document.querySelectorAll('.skiptranslate');
            skiptranslateDivs.forEach(function(div) {
                const iframe = div.querySelector('iframe.VIpgJd-ZVi9od-ORHb-OEVmcd');
                if (iframe) {
                    // Hide the container div
                    div.style.cssText = 'position: absolute !important; top: -9999px !important; left: -9999px !important; height: 0 !important; overflow: hidden !important; display: none !important;';

                    // Hide the iframe too
                    iframe.style.cssText = 'display: none !important; visibility: hidden !important; margin-top: -100px !important;';
                }
            });

            // Also directly target any iframe with this class
            const iframes = document.querySelectorAll('iframe.VIpgJd-ZVi9od-ORHb-OEVmcd');
            iframes.forEach(function(iframe) {
                iframe.style.cssText = 'display: none !important; visibility: hidden !important; margin-top: -100px !important;';

                // Hide parent if it's skiptranslate
                if (iframe.parentElement && iframe.parentElement.className.includes('skiptranslate')) {
                    iframe.parentElement.style.cssText = 'position: absolute !important; top: -9999px !important; left: -9999px !important; height: 0 !important; overflow: hidden !important; display: none !important;';
                }
            });
        }, 100);
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <style>
    /* Hide Google Translate widget */
    #google_translate_element {
        position: absolute !important;
        top: -9999px !important;
        left: -9999px !important;
    }

    /* Hide only the Google Translate banner frame */
    .goog-te-banner-frame,
    iframe.goog-te-banner-frame {
        display: none !important;
        margin-top: -46px !important;
        position: absolute !important;
        top: -100px !important;
    }

    /* Keep body position normal */
    body {
        top: 0 !important;
    }

    /* Prevent body from being pushed down */
    body.translated-ltr {
        margin-top: 0 !important;
        top: 0 !important;
    }

    /* Hide Google Translate tooltips (optional) */
    .goog-tooltip {
        display: none !important;
    }

    /* Custom Language Switcher Dropdown */
    .language-switcher-wrapper {
        position: relative;
        display: inline-block;
        margin-left: 15px;
    }

    .language-current {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white;
        font-size: 13px;
        font-weight: 500;
    }

    .language-current:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .language-current .arrow {
        font-size: 10px;
        transition: transform 0.3s ease;
    }

    .language-current.active .arrow {
        transform: rotate(180deg);
    }

    .language-dropdown {
        position: absolute;
        top: calc(100% + 5px);
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        min-width: 120px;
        overflow: hidden;
        z-index: 1002;
    }

    .language-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .language-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        cursor: pointer;
        transition: background 0.2s ease;
        color: #2B3E50;
        font-size: 13px;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .language-option:hover {
        background: #f5f5f5;
    }

    .language-option.active {
        background: #CA4249;
        color: white;
    }

    /* Flag emoji styles */
    .flag-emoji {
        font-size: 16px;
    }

    /* Mobile responsive */
    @media (max-width: 1024px) {
        /* Hide desktop language switcher on mobile */
        .wix-nav .language-switcher-wrapper {
            display: none !important;
        }

        /* Show mobile language switcher at bottom of menu */
        .mobile-language-switcher {
            display: block;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(20, 30, 40, 0.5);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px 20px;
            backdrop-filter: blur(10px);
        }

        .mobile-language-switcher .language-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            text-align: center;
        }

        .mobile-language-options {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .mobile-lang-btn {
            flex: 1;
            max-width: 100px;
            padding: 10px 8px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 11px;
            font-weight: 500;
        }

        .mobile-lang-btn:hover,
        .mobile-lang-btn:active {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .mobile-lang-btn.active {
            background: #CA4249;
            border-color: #CA4249;
            color: white;
        }

        .mobile-lang-btn .flag-emoji {
            display: block;
            font-size: 22px;
            margin-bottom: 5px;
            line-height: 1;
        }

        /* Adjust nav menu to account for language switcher at bottom */
        .wix-nav.active .wix-menu {
            padding-bottom: 100px;
        }
    }

    /* Desktop only */
    @media (min-width: 1025px) {
        .mobile-language-switcher {
            display: none !important;
        }
    }
    </style>

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

<!-- Hidden Google Translate Element -->
<div id="google_translate_element"></div>

<script>
// Toggle language dropdown
function toggleLanguageDropdown(event) {
    event.stopPropagation();
    const dropdown = document.querySelector('.language-dropdown');
    const current = document.querySelector('.language-current');

    dropdown.classList.toggle('show');
    current.classList.toggle('active');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.language-switcher-wrapper')) {
        document.querySelector('.language-dropdown')?.classList.remove('show');
        document.querySelector('.language-current')?.classList.remove('active');
    }
});

// Custom language switcher functionality
function changeLanguage(lang, event) {
    if (event) event.stopPropagation();

    // Update active state for both desktop and mobile buttons
    document.querySelectorAll('.language-option, .mobile-lang-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`.language-option[data-lang="${lang}"]`)?.classList.add('active');
    document.querySelector(`.mobile-lang-btn[data-lang="${lang}"]`)?.classList.add('active');

    // Update current display
    const langDisplay = {
        'th': { flag: '🇹🇭', text: 'TH' },
        'en': { flag: '🇬🇧', text: 'EN' },
        'id': { flag: '🇮🇩', text: 'ID' }
    };

    const current = document.querySelector('.language-current');
    if (current && langDisplay[lang]) {
        current.innerHTML = `
            <span class="flag-emoji">${langDisplay[lang].flag}</span>
            <span class="lang-text">${langDisplay[lang].text}</span>
            <span class="arrow">▼</span>
        `;
    }

    // Close dropdown
    document.querySelector('.language-dropdown')?.classList.remove('show');
    document.querySelector('.language-current')?.classList.remove('active');

    // Store selected language
    localStorage.setItem('selectedLanguage', lang);

    // Change language using Google Translate cookie method (most reliable)
    const hostname = window.location.hostname;
    const domain = hostname.includes('localhost') || hostname.includes('.local') ? hostname : '.' + hostname.replace('www.', '');

    if (lang === 'th') {
        // Clear Google Translate cookies to return to original language
        document.cookie = `googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=${domain}`;
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    } else {
        // Set Google Translate cookie for the selected language
        document.cookie = `googtrans=/th/${lang}; path=/; domain=${domain}`;
        document.cookie = `googtrans=/th/${lang}; path=/;`;
    }

    // Reload page to apply translation
    location.reload();
}

// Get current language from Google Translate cookie
function getCurrentLangFromCookie() {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        if (cookie.includes('googtrans=')) {
            const match = cookie.match(/googtrans=\/th\/([^;]+)/);
            if (match) {
                return match[1];
            }
        }
    }
    return 'th';
}

// Set active language on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check Google Translate cookie first, then localStorage
    let currentLang = getCurrentLangFromCookie();
    if (currentLang === 'th') {
        currentLang = localStorage.getItem('selectedLanguage') || 'th';
    }

    // Update display
    const langDisplay = {
        'th': { flag: '🇹🇭', text: 'TH' },
        'en': { flag: '🇬🇧', text: 'EN' },
        'id': { flag: '🇮🇩', text: 'ID' }
    };

    const current = document.querySelector('.language-current');
    if (current && langDisplay[currentLang]) {
        current.innerHTML = `
            <span class="flag-emoji">${langDisplay[currentLang].flag}</span>
            <span class="lang-text">${langDisplay[currentLang].text}</span>
            <span class="arrow">▼</span>
        `;
    }

    // Set active option for both desktop and mobile
    document.querySelector(`.language-option[data-lang="${currentLang}"]`)?.classList.add('active');
    document.querySelector(`.mobile-lang-btn[data-lang="${currentLang}"]`)?.classList.add('active');

    // Update localStorage to sync
    localStorage.setItem('selectedLanguage', currentLang);

    // Force hide Google Translate banner
    hideGoogleTranslateBanner();
});

// Hide Google Translate banner function
function hideGoogleTranslateBanner() {
    // Simple function to hide only the banner
    const bannerFrame = document.querySelector('.goog-te-banner-frame');
    if (bannerFrame) {
        bannerFrame.style.display = 'none';
    }

    // Reset body position
    document.body.style.top = '0px';
}

// Also hide banner when window loads completely
window.addEventListener('load', function() {
    hideGoogleTranslateBanner();
});
</script>

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
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-home"></i> หน้าแรก</a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">เกี่ยวกับเรา</a></li>
                    <li><a href="<?php echo esc_url(home_url('/service')); ?>">บริการ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/news-1')); ?>">ข่าวสาร</a></li>
                    <li class="has-submenu">
                        <a href="<?php echo esc_url(home_url('/gallery')); ?>">แกลเลอรี่</a>
                        <ul class="submenu">
                            <li><a href="<?php echo esc_url(home_url('/gallery')); ?>">แกลเลอรี่</a></li>
                            <!-- <li><a href="<?php echo esc_url(home_url('/ayam-list')); ?>">Ayam list</a></li> -->
                            <li><a href="<?php echo esc_url(home_url('/gallery/?category=BTS')); ?>">เบื้องหลัง</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">ติดต่อ</a></li>
                </ul>

                <!-- Desktop Language Switcher -->
                <div class="language-switcher-wrapper">
                    <div class="language-current" onclick="toggleLanguageDropdown(event)">
                        <span class="flag-emoji">🇹🇭</span>
                        <span class="lang-text">TH</span>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="language-dropdown">
                        <button class="language-option" data-lang="th" onclick="changeLanguage('th', event)">
                            <span class="flag-emoji">🇹🇭</span>
                            <span>ไทย</span>
                        </button>
                        <button class="language-option" data-lang="id" onclick="changeLanguage('id', event)">
                            <span class="flag-emoji">🇮🇩</span>
                            <span>Indonesia</span>
                        </button>
                        <button class="language-option" data-lang="en" onclick="changeLanguage('en', event)">
                            <span class="flag-emoji">🇬🇧</span>
                            <span>English</span>
                        </button>
                    </div>
                </div>

                <!-- Mobile Language Switcher (shown at bottom of mobile menu) -->
                <div class="mobile-language-switcher">
                    <div class="language-title">Language / ภาษา</div>
                    <div class="mobile-language-options">
                        <button class="mobile-lang-btn" data-lang="th" onclick="changeLanguage('th', event)">
                            <span class="flag-emoji">🇹🇭</span>
                            <span>ไทย</span>
                        </button>
                        <button class="mobile-lang-btn" data-lang="id" onclick="changeLanguage('id', event)">
                            <span class="flag-emoji">🇮🇩</span>
                            <span>Indonesia</span>
                        </button>
                        <button class="mobile-lang-btn" data-lang="en" onclick="changeLanguage('en', event)">
                            <span class="flag-emoji">🇬🇧</span>
                            <span>English</span>
                        </button>
                    </div>
                </div>
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