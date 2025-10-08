<?php
/**
 * Create Wix-Style Gallery System
 * สร้างระบบ Gallery แบบ Wix (หมายเลขไก่ + รูป + วิดีโอ)
 */

// Load WordPress
require_once('wp-config.php');

if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>🎨 สร้าง Gallery System แบบ Wix</h1>";
echo "<p>กำลังสร้างระบบแกลเลอรี่ไก่ที่มีหมายเลข รูปภาพ และวิดีโอ</p>";

// Step 1: Register Custom Post Type
echo "<h2>Step 1: สร้าง Custom Post Type - Rooster Catalog</h2>";

function register_rooster_catalog_post_type() {
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
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true
    );
    
    register_post_type('rooster_catalog', $args);
}

register_rooster_catalog_post_type();
flush_rewrite_rules();

echo "✅ สร้าง Custom Post Type: rooster_catalog<br>";

// Step 2: Create Sample Roosters
echo "<h2>Step 2: สร้างไก่ตัวอย่าง</h2>";

$sample_roosters = array(
    array(
        'number' => 'A001',
        'title' => 'ไก่ชนอยัม A001',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1 ปี น้ำหนัก 2.5 กก. พร้อมส่งออก',
        'weight' => '2.5',
        'age' => '1',
        'status' => 'ready'
    ),
    array(
        'number' => 'A002',
        'title' => 'ไก่ชนอยัม A002',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1.5 ปี น้ำหนัก 2.8 กก. พร้อมส่งออก',
        'weight' => '2.8',
        'age' => '1.5',
        'status' => 'ready'
    ),
    array(
        'number' => 'A003',
        'title' => 'ไก่ชนอยัม A003',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 2 ปี น้ำหนัก 3.0 กก. พร้อมส่งออก',
        'weight' => '3.0',
        'age' => '2',
        'status' => 'ready'
    ),
    array(
        'number' => 'B001',
        'title' => 'ไก่ชนอยัม B001',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1 ปี น้ำหนัก 2.6 กก. กำลังเตรียมส่ง',
        'weight' => '2.6',
        'age' => '1',
        'status' => 'pending'
    ),
    array(
        'number' => 'B002',
        'title' => 'ไก่ชนอยัม B002',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 1.5 ปี น้ำหนัก 2.9 กก. กำลังเตรียมส่ง',
        'weight' => '2.9',
        'age' => '1.5',
        'status' => 'pending'
    ),
    array(
        'number' => 'C001',
        'title' => 'ไก่ชนอยัม C001',
        'description' => 'ไก่ชนพันธุ์แท้ อายุ 2 ปี น้ำหนัก 3.2 กก. ส่งออกแล้ว',
        'weight' => '3.2',
        'age' => '2',
        'status' => 'exported'
    )
);

$created_count = 0;
foreach ($sample_roosters as $rooster) {
    $post_data = array(
        'post_title' => $rooster['title'],
        'post_content' => $rooster['description'],
        'post_status' => 'publish',
        'post_type' => 'rooster_catalog'
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id) {
        // Add custom fields
        update_post_meta($post_id, 'rooster_number', $rooster['number']);
        update_post_meta($post_id, 'rooster_weight', $rooster['weight']);
        update_post_meta($post_id, 'rooster_age', $rooster['age']);
        update_post_meta($post_id, 'export_status', $rooster['status']);
        update_post_meta($post_id, 'export_date', date('Y-m-d'));
        
        $created_count++;
        echo "✅ สร้างไก่: {$rooster['number']} - {$rooster['title']}<br>";
    }
}

echo "<p><strong>สร้างไก่ตัวอย่าง: {$created_count} ตัว</strong></p>";

// Step 3: Create Gallery Page Template
echo "<h2>Step 3: สร้าง Gallery Page Template</h2>";

$gallery_template = <<<'PHP'
<?php
/**
 * Template Name: Rooster Gallery (Wix Style)
 * แกลเลอรี่ไก่แบบ Wix - แสดงหมายเลขไก่
 */

get_header();
?>

<div class="rooster-gallery-wix">
    <div class="container">
        <header class="gallery-header">
            <h1>🐓 Rooster Catalog</h1>
            <p>คลิกหมายเลขเพื่อดูรายละเอียด รูปภาพ และวิดีโอของไก่แต่ละตัว</p>
        </header>

        <!-- Filter -->
        <div class="gallery-filter">
            <button class="filter-btn active" data-filter="all">ทั้งหมด</button>
            <button class="filter-btn" data-filter="ready">พร้อมส่งออก</button>
            <button class="filter-btn" data-filter="pending">กำลังเตรียม</button>
            <button class="filter-btn" data-filter="exported">ส่งออกแล้ว</button>
        </div>

        <!-- Gallery Grid -->
        <div class="rooster-grid">
            <?php
            $roosters = new WP_Query(array(
                'post_type' => 'rooster_catalog',
                'posts_per_page' => -1,
                'orderby' => 'meta_value',
                'meta_key' => 'rooster_number',
                'order' => 'ASC'
            ));

            if ($roosters->have_posts()) :
                while ($roosters->have_posts()) : $roosters->the_post();
                    $rooster_number = get_post_meta(get_the_ID(), 'rooster_number', true);
                    $export_status = get_post_meta(get_the_ID(), 'export_status', true);
                    $status_class = 'status-' . $export_status;
                    $status_text = array(
                        'ready' => 'พร้อมส่งออก',
                        'pending' => 'กำลังเตรียม',
                        'exported' => 'ส่งออกแล้ว'
                    );
                    ?>
                    <div class="rooster-card" data-status="<?php echo esc_attr($export_status); ?>">
                        <a href="<?php the_permalink(); ?>" class="rooster-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="rooster-image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php else : ?>
                                <div class="rooster-image rooster-placeholder">
                                    <span class="rooster-icon">🐓</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="rooster-info">
                                <div class="rooster-number"><?php echo esc_html($rooster_number); ?></div>
                                <div class="rooster-status <?php echo esc_attr($status_class); ?>">
                                    <?php echo esc_html($status_text[$export_status] ?? 'ไม่ระบุ'); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="no-roosters">ยังไม่มีข้อมูลไก่</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
PHP;

$template_file = get_template_directory() . '/page-rooster-gallery-wix.php';
file_put_contents($template_file, $gallery_template);
echo "✅ สร้างไฟล์: page-rooster-gallery-wix.php<br>";

// Step 4: Create Single Rooster Template
echo "<h2>Step 4: สร้าง Single Rooster Template</h2>";

$single_template = <<<'PHP'
<?php
/**
 * Single Rooster Catalog Template
 * หน้ารายละเอียดไก่แต่ละตัว
 */

get_header();

while (have_posts()) : the_post();
    $rooster_number = get_post_meta(get_the_ID(), 'rooster_number', true);
    $rooster_weight = get_post_meta(get_the_ID(), 'rooster_weight', true);
    $rooster_age = get_post_meta(get_the_ID(), 'rooster_age', true);
    $export_status = get_post_meta(get_the_ID(), 'export_status', true);
    $export_date = get_post_meta(get_the_ID(), 'export_date', true);
    
    $status_text = array(
        'ready' => 'พร้อมส่งออก',
        'pending' => 'กำลังเตรียม',
        'exported' => 'ส่งออกแล้ว'
    );
    ?>
    
    <article class="single-rooster">
        <div class="container">
            <div class="rooster-header">
                <h1><?php the_title(); ?></h1>
                <div class="rooster-meta">
                    <span class="rooster-number-large">หมายเลข: <?php echo esc_html($rooster_number); ?></span>
                    <span class="rooster-status-badge status-<?php echo esc_attr($export_status); ?>">
                        <?php echo esc_html($status_text[$export_status] ?? 'ไม่ระบุ'); ?>
                    </span>
                </div>
            </div>

            <div class="rooster-content-grid">
                <!-- Gallery Section -->
                <div class="rooster-gallery-section">
                    <h2>📸 รูปภาพ</h2>
                    <div class="rooster-images">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="rooster-main-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php else : ?>
                            <div class="rooster-placeholder-large">
                                <span class="rooster-icon">🐓</span>
                                <p>ยังไม่มีรูปภาพ</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Video Section -->
                    <h2>🎥 วิดีโอ</h2>
                    <div class="rooster-videos">
                        <p class="video-placeholder">ยังไม่มีวิดีโอ (จะเพิ่มในขั้นตอนถัดไป)</p>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="rooster-info-section">
                    <h2>ℹ️ ข้อมูลไก่</h2>
                    <div class="rooster-details">
                        <div class="detail-item">
                            <span class="detail-label">หมายเลข:</span>
                            <span class="detail-value"><?php echo esc_html($rooster_number); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">น้ำหนัก:</span>
                            <span class="detail-value"><?php echo esc_html($rooster_weight); ?> กก.</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">อายุ:</span>
                            <span class="detail-value"><?php echo esc_html($rooster_age); ?> ปี</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">สถานะ:</span>
                            <span class="detail-value"><?php echo esc_html($status_text[$export_status] ?? 'ไม่ระบุ'); ?></span>
                        </div>
                        <?php if ($export_date) : ?>
                        <div class="detail-item">
                            <span class="detail-label">วันที่:</span>
                            <span class="detail-value"><?php echo date_i18n('j F Y', strtotime($export_date)); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="rooster-description">
                        <h3>รายละเอียด</h3>
                        <?php the_content(); ?>
                    </div>

                    <div class="rooster-actions">
                        <a href="<?php echo home_url('/rooster-gallery'); ?>" class="btn btn-back">← กลับไปแกลเลอรี่</a>
                        <a href="<?php echo home_url('/contact'); ?>" class="btn btn-contact">สอบถามข้อมูล</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
    
    <?php
endwhile;

get_footer();
?>
PHP;

$single_file = get_template_directory() . '/single-rooster_catalog.php';
file_put_contents($single_file, $single_template);
echo "✅ สร้างไฟล์: single-rooster_catalog.php<br>";

// Step 5: Create CSS
echo "<h2>Step 5: สร้าง CSS สำหรับ Gallery</h2>";

$css_content = <<<'CSS'
/**
 * Rooster Gallery Wix Style CSS
 */

/* Gallery Header */
.rooster-gallery-wix {
    padding: 60px 0;
    background: #f5f5f5;
}

.gallery-header {
    text-align: center;
    margin-bottom: 40px;
}

.gallery-header h1 {
    font-size: 48px;
    color: #1E2950;
    margin-bottom: 15px;
}

.gallery-header p {
    font-size: 18px;
    color: #666;
}

/* Filter */
.gallery-filter {
    text-align: center;
    margin-bottom: 40px;
}

.filter-btn {
    padding: 12px 24px;
    margin: 0 5px;
    background: #fff;
    border: 2px solid #1E2950;
    color: #1E2950;
    border-radius: 25px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.filter-btn:hover,
.filter-btn.active {
    background: #1E2950;
    color: #fff;
}

/* Rooster Grid */
.rooster-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    margin: 0 auto;
    max-width: 1200px;
}

.rooster-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.rooster-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.rooster-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.rooster-image {
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rooster-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.rooster-placeholder {
    background: linear-gradient(135deg, #1E2950 0%, #CA4249 100%);
}

.rooster-icon {
    font-size: 80px;
}

.rooster-info {
    padding: 20px;
}

.rooster-number {
    font-size: 32px;
    font-weight: 800;
    color: #1E2950;
    text-align: center;
    margin-bottom: 10px;
}

.rooster-status {
    text-align: center;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.status-ready {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-exported {
    background: #d1ecf1;
    color: #0c5460;
}

/* Single Rooster */
.single-rooster {
    padding: 60px 0;
}

.rooster-header {
    text-align: center;
    margin-bottom: 40px;
}

.rooster-header h1 {
    font-size: 42px;
    color: #1E2950;
    margin-bottom: 15px;
}

.rooster-meta {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.rooster-number-large {
    font-size: 24px;
    font-weight: 700;
    color: #CA4249;
}

.rooster-status-badge {
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
}

.rooster-content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.rooster-gallery-section h2,
.rooster-info-section h2 {
    color: #1E2950;
    margin-bottom: 20px;
}

.rooster-main-image img {
    width: 100%;
    height: auto;
    border-radius: 12px;
}

.rooster-placeholder-large {
    background: linear-gradient(135deg, #1E2950 0%, #CA4249 100%);
    padding: 100px;
    text-align: center;
    border-radius: 12px;
    color: #fff;
}

.rooster-placeholder-large .rooster-icon {
    font-size: 120px;
}

.rooster-videos {
    margin-top: 30px;
}

.video-placeholder {
    background: #f5f5f5;
    padding: 40px;
    text-align: center;
    border-radius: 12px;
    color: #666;
}

.rooster-details {
    background: #f5f5f5;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #ddd;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #1E2950;
}

.detail-value {
    color: #666;
}

.rooster-description {
    margin-bottom: 30px;
}

.rooster-actions {
    display: flex;
    gap: 15px;
}

.btn {
    padding: 15px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-back {
    background: #f5f5f5;
    color: #1E2950;
}

.btn-back:hover {
    background: #1E2950;
    color: #fff;
}

.btn-contact {
    background: #CA4249;
    color: #fff;
}

.btn-contact:hover {
    background: #1E2950;
}

/* Responsive */
@media (max-width: 768px) {
    .rooster-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    
    .rooster-content-grid {
        grid-template-columns: 1fr;
    }
    
    .rooster-actions {
        flex-direction: column;
    }
}
CSS;

$css_file = get_template_directory() . '/assets/css/rooster-gallery-wix.css';
file_put_contents($css_file, $css_content);
echo "✅ สร้างไฟล์: rooster-gallery-wix.css<br>";

// Step 6: Enqueue CSS
echo "<h2>Step 6: เพิ่ม CSS ใน functions.php</h2>";
echo "<p>⚠️ ต้องเพิ่มโค้ดนี้ใน functions.php ด้วยตนเอง:</p>";
echo "<pre>";
echo htmlspecialchars("
// Enqueue Rooster Gallery CSS
function ayam_rooster_gallery_assets() {
    if (is_page_template('page-rooster-gallery-wix.php') || is_singular('rooster_catalog')) {
        wp_enqueue_style('rooster-gallery-wix', get_template_directory_uri() . '/assets/css/rooster-gallery-wix.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'ayam_rooster_gallery_assets');
");
echo "</pre>";

// Step 7: Create Gallery Page
echo "<h2>Step 7: สร้างหน้า Gallery</h2>";

$gallery_page = array(
    'post_title' => 'Rooster Gallery',
    'post_content' => 'แกลเลอรี่ไก่ชนอยัม กรุงเทพ - คลิกหมายเลขเพื่อดูรายละเอียด',
    'post_status' => 'publish',
    'post_type' => 'page',
    'post_name' => 'rooster-gallery'
);

$page_id = wp_insert_post($gallery_page);

if ($page_id) {
    update_post_meta($page_id, '_wp_page_template', 'page-rooster-gallery-wix.php');
    echo "✅ สร้างหน้า: Rooster Gallery (ID: {$page_id})<br>";
    echo "<p><a href='" . get_permalink($page_id) . "' target='_blank'>ดูหน้า Gallery</a></p>";
} else {
    echo "❌ ไม่สามารถสร้างหน้า Gallery<br>";
}

// Summary
echo "<h2>✅ สรุปผลการสร้าง</h2>";
echo "<div class='summary'>";
echo "<ul>";
echo "<li>✅ Custom Post Type: rooster_catalog</li>";
echo "<li>✅ ไก่ตัวอย่าง: {$created_count} ตัว</li>";
echo "<li>✅ Gallery Page Template</li>";
echo "<li>✅ Single Rooster Template</li>";
echo "<li>✅ CSS สำหรับ Gallery</li>";
echo "<li>✅ หน้า Gallery</li>";
echo "</ul>";
echo "</div>";

echo "<h2>🎉 เสร็จสิ้น!</h2>";
echo "<p><strong>ขั้นตอนถัดไป:</strong></p>";
echo "<ol>";
echo "<li>เพิ่มโค้ด enqueue CSS ใน functions.php (ดูด้านบน)</li>";
echo "<li>อัพโหลดรูปภาพไก่</li>";
echo "<li>เพิ่มวิดีโอ (ขั้นตอนถัดไป)</li>";
echo "<li>ทดสอบ Gallery</li>";
echo "</ol>";

echo "<p><a href='" . home_url('/rooster-gallery') . "' class='button button-primary' target='_blank'>ดู Gallery ที่สร้าง</a></p>";
echo "<p><a href='" . admin_url('edit.php?post_type=rooster_catalog') . "' class='button' target='_blank'>จัดการไก่ใน Admin</a></p>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f1;
}
h1, h2 {
    color: #1E2950;
}
.summary {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
pre {
    background: #2d2d2d;
    color: #f8f8f2;
    padding: 20px;
    border-radius: 8px;
    overflow-x: auto;
}
.button {
    display: inline-block;
    padding: 12px 24px;
    background: #CA4249;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    margin: 10px 5px;
}
.button-primary {
    background: #1E2950;
}
</style>
