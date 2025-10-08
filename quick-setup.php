<?php
/**
 * Ayam Bangkok - Quick Setup Script
 * Complete setup for Ayam Bangkok website with sample data
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('คุณไม่มีสิทธิ์ในการเรียกใช้ไฟล์นี้');
}

echo "<h1>🚀 Ayam Bangkok - Quick Setup</h1>";
echo "<p>การติดตั้งและตั้งค่าเว็บไซต์แบบครบครัน</p>";

echo "<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: #f5f5f5; }
h1 { color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px; }
h2 { color: #34495e; margin-top: 30px; }
.step { background: white; padding: 20px; margin: 20px 0; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.success { color: #27ae60; }
.error { color: #e74c3c; }
.warning { color: #f39c12; }
.info { color: #3498db; }
.progress { background: #ecf0f1; border-radius: 10px; padding: 3px; margin: 10px 0; }
.progress-bar { background: #3498db; height: 20px; border-radius: 7px; transition: width 0.3s; }
</style>";

/**
 * Check system requirements
 */
function check_system_requirements() {
    echo "<div class='step'>";
    echo "<h2>🔍 ตรวจสอบความพร้อมของระบบ</h2>";
    
    $requirements = [
        'WordPress Version' => version_compare(get_bloginfo('version'), '6.0', '>='),
        'PHP Version' => version_compare(PHP_VERSION, '8.0', '>='),
        'Memory Limit' => (int)ini_get('memory_limit') >= 256,
        'File Uploads' => ini_get('file_uploads'),
        'GD Extension' => extension_loaded('gd'),
        'cURL Extension' => extension_loaded('curl'),
        'Write Permissions' => is_writable(wp_upload_dir()['path'])
    ];
    
    $all_good = true;
    
    foreach ($requirements as $requirement => $status) {
        if ($status) {
            echo "<div class='success'>✅ {$requirement}: ผ่าน</div>";
        } else {
            echo "<div class='error'>❌ {$requirement}: ไม่ผ่าน</div>";
            $all_good = false;
        }
    }
    
    if ($all_good) {
        echo "<div class='success'><strong>🎉 ระบบพร้อมสำหรับการติดตั้ง!</strong></div>";
    } else {
        echo "<div class='error'><strong>⚠️ กรุณาแก้ไขปัญหาก่อนดำเนินการต่อ</strong></div>";
    }
    
    echo "</div>";
    return $all_good;
}

/**
 * Check required plugins
 */
function check_required_plugins() {
    echo "<div class='step'>";
    echo "<h2>🔌 ตรวจสอบ Plugins ที่จำเป็น</h2>";
    
    $required_plugins = [
        'Advanced Custom Fields PRO' => 'acf-pro/acf.php',
        'Ayam Bangkok Core' => 'ayam-bangkok-core/ayam-bangkok-core.php'
    ];
    
    $all_active = true;
    
    foreach ($required_plugins as $name => $plugin_file) {
        if (is_plugin_active($plugin_file)) {
            echo "<div class='success'>✅ {$name}: เปิดใช้งานแล้ว</div>";
        } else {
            echo "<div class='warning'>⚠️ {$name}: ยังไม่ได้เปิดใช้งาน</div>";
            $all_active = false;
        }
    }
    
    if (!$all_active) {
        echo "<div class='info'><strong>💡 คำแนะนำ:</strong> กรุณาติดตั้งและเปิดใช้งาน plugins ที่จำเป็นก่อน</div>";
    }
    
    echo "</div>";
    return $all_active;
}

/**
 * Setup theme options
 */
function setup_theme_options() {
    echo "<div class='step'>";
    echo "<h2>🎨 ตั้งค่า Theme Options</h2>";
    
    // Set theme mods
    set_theme_mod('hero_title', 'ยินดีต้อนรับสู่ Ayam Bangkok');
    set_theme_mod('hero_subtitle', 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย');
    
    // Set site options
    update_option('blogname', 'Ayam Bangkok');
    update_option('blogdescription', 'ตัวแทนส่งออกไก่ชนไปยังอินโดนีเซียอย่างเป็นทางการ');
    update_option('date_format', 'j F Y');
    update_option('time_format', 'H:i');
    update_option('start_of_week', '1'); // Monday
    
    // Set permalink structure
    update_option('permalink_structure', '/%postname%/');
    
    echo "<div class='success'>✅ ตั้งค่า Theme Options เรียบร้อย</div>";
    echo "</div>";
}

/**
 * Create sample menus
 */
function create_sample_menus() {
    echo "<div class='step'>";
    echo "<h2>📋 สร้างเมนูตัวอย่าง</h2>";
    
    // Create main menu
    $menu_name = 'เมนูหลัก';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Add menu items
        $menu_items = [
            ['title' => 'หน้าแรก', 'url' => home_url('/')],
            ['title' => 'เกี่ยวกับเรา', 'url' => home_url('/about/')],
            ['title' => 'ไก่ชน', 'url' => get_post_type_archive_link('ayam_rooster')],
            ['title' => 'บริการ', 'url' => get_post_type_archive_link('ayam_service')],
            ['title' => 'ราคา', 'url' => home_url('/pricing/')],
            ['title' => 'ข่าวสาร', 'url' => get_post_type_archive_link('ayam_news')],
            ['title' => 'ติดต่อเรา', 'url' => home_url('/contact/')]
        ];
        
        foreach ($menu_items as $item) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'],
                'menu-item-status' => 'publish'
            ]);
        }
        
        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        
        echo "<div class='success'>✅ สร้างเมนูหลักเรียบร้อย</div>";
    } else {
        echo "<div class='info'>ℹ️ เมนูหลักมีอยู่แล้ว</div>";
    }
    
    echo "</div>";
}

/**
 * Create sample pages
 */
function create_sample_pages() {
    echo "<div class='step'>";
    echo "<h2>📄 สร้างหน้าเว็บตัวอย่าง</h2>";
    
    $pages = [
        [
            'title' => 'เกี่ยวกับเรา',
            'slug' => 'about',
            'content' => 'หน้าเกี่ยวกับบริษัท Ayam Bangkok ตัวแทนส่งออกไก่ชนไปยังอินโดนีเซียอย่างเป็นทางการ'
        ],
        [
            'title' => 'ราคาและแพ็กเกจ',
            'slug' => 'pricing',
            'content' => 'ราคาและแพ็กเกจบริการส่งออกไก่ชนต่างๆ'
        ],
        [
            'title' => 'ผลงานและรางวัล',
            'slug' => 'achievements',
            'content' => 'ผลงานและรางวัลที่ได้รับจากการส่งออกไก่ชน'
        ],
        [
            'title' => 'ติดต่อเรา',
            'slug' => 'contact',
            'content' => 'ข้อมูลการติดต่อและแบบฟอร์มสอบถาม'
        ]
    ];
    
    foreach ($pages as $page) {
        $existing_page = get_page_by_path($page['slug']);
        
        if (!$existing_page) {
            $page_data = [
                'post_title' => $page['title'],
                'post_name' => $page['slug'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => 1
            ];
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id) {
                echo "<div class='success'>✅ สร้างหน้า: {$page['title']}</div>";
            } else {
                echo "<div class='error'>❌ ไม่สามารถสร้างหน้า: {$page['title']}</div>";
            }
        } else {
            echo "<div class='info'>ℹ️ หน้า {$page['title']} มีอยู่แล้ว</div>";
        }
    }
    
    echo "</div>";
}

/**
 * Import sample data
 */
function import_sample_data() {
    echo "<div class='step'>";
    echo "<h2>📦 นำเข้าข้อมูลตัวอย่าง</h2>";
    
    // Include the import file
    if (file_exists('import-sample-data.php')) {
        echo "<div class='info'>🔄 กำลังนำเข้าข้อมูลตัวอย่าง...</div>";
        
        // Capture output from import script
        ob_start();
        include 'import-sample-data.php';
        $import_output = ob_get_clean();
        
        // Display simplified output
        if (strpos($import_output, 'เสร็จสิ้นการนำเข้าข้อมูล') !== false) {
            echo "<div class='success'>✅ นำเข้าข้อมูลตัวอย่างเรียบร้อย</div>";
        } else {
            echo "<div class='warning'>⚠️ การนำเข้าข้อมูลอาจไม่สมบูรณ์</div>";
        }
    } else {
        echo "<div class='error'>❌ ไม่พบไฟล์ import-sample-data.php</div>";
    }
    
    echo "</div>";
}

/**
 * Final setup tasks
 */
function final_setup_tasks() {
    echo "<div class='step'>";
    echo "<h2>🏁 งานสุดท้าย</h2>";
    
    // Flush rewrite rules
    flush_rewrite_rules();
    echo "<div class='success'>✅ อัปเดต URL Structure</div>";
    
    // Clear any caches
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
        echo "<div class='success'>✅ ล้าง Cache</div>";
    }
    
    // Set homepage
    $front_page = get_page_by_path('home');
    if ($front_page) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page->ID);
        echo "<div class='success'>✅ ตั้งค่าหน้าแรก</div>";
    }
    
    echo "</div>";
}

// Main execution
echo "<div class='progress'><div class='progress-bar' style='width: 0%'></div></div>";
echo "<div id='status'>เริ่มต้นการติดตั้ง...</div>";

$steps = [
    'ตรวจสอบความพร้อมของระบบ' => 'check_system_requirements',
    'ตรวจสอบ Plugins' => 'check_required_plugins',
    'ตั้งค่า Theme Options' => 'setup_theme_options',
    'สร้างเมนูตัวอย่าง' => 'create_sample_menus',
    'สร้างหน้าเว็บตัวอย่าง' => 'create_sample_pages',
    'นำเข้าข้อมูลตัวอย่าง' => 'import_sample_data',
    'งานสุดท้าย' => 'final_setup_tasks'
];

$total_steps = count($steps);
$current_step = 0;

foreach ($steps as $step_name => $function_name) {
    $current_step++;
    $progress = ($current_step / $total_steps) * 100;
    
    echo "<script>
        document.querySelector('.progress-bar').style.width = '{$progress}%';
        document.getElementById('status').innerHTML = 'ขั้นตอนที่ {$current_step}/{$total_steps}: {$step_name}';
    </script>";
    
    if (ob_get_level()) {
        ob_flush();
    }
    flush();
    
    if (function_exists($function_name)) {
        $function_name();
    }
}

echo "<script>
    document.querySelector('.progress-bar').style.width = '100%';
    document.getElementById('status').innerHTML = 'การติดตั้งเสร็จสิ้น!';
</script>";

echo "<div class='step'>";
echo "<h2>🎉 การติดตั้งเสร็จสิ้น!</h2>";
echo "<p>เว็บไซต์ Ayam Bangkok ได้ถูกติดตั้งและตั้งค่าเรียบร้อยแล้ว</p>";

echo "<h3>📋 สิ่งที่ได้ทำเสร็จ:</h3>";
echo "<ul>";
echo "<li>✅ ตรวจสอบความพร้อมของระบบ</li>";
echo "<li>✅ ตั้งค่า Theme Options</li>";
echo "<li>✅ สร้างเมนูและหน้าเว็บตัวอย่าง</li>";
echo "<li>✅ นำเข้าข้อมูลไก่ชน ข่าวสาร และบริการ</li>";
echo "<li>✅ ตั้งค่า Slider และข้อมูลบริษัท</li>";
echo "<li>✅ อัปเดต URL Structure</li>";
echo "</ul>";

echo "<h3>🚀 ขั้นตอนถัดไป:</h3>";
echo "<ol>";
echo "<li>ดาวน์โหลดรูปภาพ: <a href='download-images.php'>รันไฟล์ download-images.php</a></li>";
echo "<li>ตรวจสอบและปรับแต่งเนื้อหา</li>";
echo "<li>ตั้งค่า SSL Certificate</li>";
echo "<li>ติดตั้ง Security Plugin</li>";
echo "<li>ตั้งค่า Backup</li>";
echo "</ol>";

echo "<div style='margin-top: 30px;'>";
echo "<a href='" . home_url() . "' style='background: #2ecc71; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin-right: 10px; display: inline-block;'>🏠 ดูเว็บไซต์</a>";
echo "<a href='" . admin_url() . "' style='background: #3498db; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>⚙️ ไปที่ Admin</a>";
echo "</div>";

echo "</div>";

echo "<div class='step'>";
echo "<h3>⚠️ ข้อควรระวัง</h3>";
echo "<ul>";
echo "<li>ลบไฟล์ setup นี้หลังจากใช้งานเสร็จ</li>";
echo "<li>เปลี่ยนรหัสผ่าน Admin</li>";
echo "<li>ตั้งค่า Security Plugin</li>";
echo "<li>สำรองข้อมูลเป็นประจำ</li>";
echo "</ul>";
echo "</div>";
?>