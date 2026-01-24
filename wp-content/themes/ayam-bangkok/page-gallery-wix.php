<?php
/**
 * Template Name: Gallery Page (Wix Style)
 * Matching Service/News page structure with Gallery grid
 */

get_header();

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Check if we're viewing a specific category
$category_param = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Helper function to get correct image URL
function get_gallery_image_url_wix($path) {
    // Always use /wp-content/uploads/ prefix for gallery images
    if (strpos($path, '/wp-content/uploads/') === 0) {
        return $path;
    }
    return '/wp-content/uploads' . $path;
}

if (!empty($category_param)) {
    // DETAIL VIEW - Show images from specific category
    $category = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$categories_table} WHERE category_number = %s OR category_name = %s",
        $category_param,
        $category_param
    ));
    
    if ($category) {
        $gallery_images = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$images_table} WHERE category_id = %d ORDER BY sort_order ASC",
            $category->id
        ));
    } else {
        $gallery_images = array();
    }
} else {
    // LANDING PAGE - Show all categories as thumbnails
    $categories = $wpdb->get_results("
        SELECT gc.*, 
               (SELECT image_url FROM {$images_table} WHERE category_id = gc.id ORDER BY sort_order ASC LIMIT 1) as thumbnail,
               (SELECT COUNT(*) FROM {$images_table} WHERE category_id = gc.id) as actual_count
        FROM {$categories_table} gc
        WHERE (gc.category_type = 'gallery' OR gc.category_type IS NULL OR gc.category_type = '')
        AND gc.id IN (SELECT DISTINCT category_id FROM {$images_table})
        ORDER BY gc.id DESC
    ");
    
    // Update image_count if different
    foreach ($categories as $cat) {
        if ($cat->actual_count != $cat->image_count) {
            $wpdb->update(
                $categories_table,
                array('image_count' => $cat->actual_count),
                array('id' => $cat->id)
            );
            $cat->image_count = $cat->actual_count;
        }
    }
}

?>

<main id="primary" class="site-main wix-style-gallery">

    <!-- Gallery Hero Section -->
    <section class="service-hero">
        <div class="service-hero-container">
            <?php if (!empty($category_param) && isset($category)): ?>
                <h1 class="service-hero-subtitle">Gallery</h1>
                <p class="service-hero-title"><?php echo esc_html($category->category_name); ?></p>
                <div class="service-hero-line"></div>
                <p class="service-hero-description">
                    <a href="<?php echo esc_url(get_permalink()); ?>" style="color: #CA4249; text-decoration: none;">
                        ← กลับไปหน้าแกลเลอรี่
                    </a>
                </p>
            <?php else: ?>
                <?php
                $gallery_title = get_theme_mod('gallery_title', 'Our Gallery');
                $gallery_description = get_theme_mod('gallery_description', 'Explore our collection of Thai fighting roosters');
                ?>
                <h1 class="service-hero-subtitle">Get to Know</h1>
                <p class="service-hero-title"><?php echo esc_html($gallery_title); ?></p>
                <div class="service-hero-line"></div>
                <?php if ($gallery_description) : ?>
                    <p class="service-hero-description"><?php echo esc_html($gallery_description); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Gallery Grid Section -->
    <section class="gallery-grid-section">
        <div class="service-container">
            <?php if (!empty($category_param)): ?>
                <!-- DETAIL VIEW: Show images from category -->
                <?php if (!empty($gallery_images)): ?>
                    <div class="gallery-masonry-grid" data-aos="fade-up">
                        <?php foreach ($gallery_images as $index => $image): ?>
                            <div class="gallery-item" data-aos="fade-up" data-aos-delay="<?php echo ($index % 12) * 50; ?>">
                                <a href="<?php echo esc_url(get_gallery_image_url_wix($image->image_url)); ?>" 
                                   data-lightbox="gallery" 
                                   data-title="<?php echo esc_attr($category->category_name); ?> - Photo <?php echo $index + 1; ?>">
                                    <img src="<?php echo esc_url(get_gallery_image_url_wix($image->image_url)); ?>" 
                                         alt="<?php echo esc_attr($category->category_name); ?> - Photo <?php echo $index + 1; ?>"
                                         loading="lazy">
                                    <div class="gallery-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-gallery-message">
                        <i class="fas fa-images"></i>
                        <p>ยังไม่มีรูปภาพในหมวดหมู่นี้</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- LANDING PAGE: Show categories -->
                <?php if (!empty($categories)): ?>
                    <div class="gallery-categories-grid" data-aos="fade-up">
                        <?php foreach ($categories as $index => $cat): ?>
                            <div class="gallery-category-card" data-aos="fade-up" data-aos-delay="<?php echo ($index % 6) * 100; ?>">
                                <a href="<?php echo esc_url(add_query_arg('category', urlencode($cat->category_number))); ?>" class="category-link">
                                    <div class="category-thumbnail-wrapper">
                                        <?php if ($cat->thumbnail): ?>
                                            <img src="<?php echo esc_url(get_gallery_image_url_wix($cat->thumbnail)); ?>" 
                                                 alt="<?php echo esc_attr($cat->category_name); ?>"
                                                 loading="lazy">
                                        <?php else: ?>
                                            <div class="category-placeholder">
                                                <i class="fas fa-images"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="category-overlay">
                                            <span class="view-category-text">ดูแกลเลอรี่ →</span>
                                        </div>
                                    </div>
                                    <div class="category-info">
                                        <h3 class="category-name"><?php echo esc_html($cat->category_name); ?></h3>
                                        <p class="category-count"><?php echo $cat->image_count; ?> รูปภาพ</p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-gallery-message">
                        <i class="fas fa-images"></i>
                        <p>ยังไม่มีแกลเลอรี่</p>
                        <small>กรุณาสร้างแกลเลอรี่จากหลังบ้าน</small>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="service-contact">
        <div class="service-container">
            <div class="service-contact-grid">
                <div class="service-contact-left">
                    <h2 class="service-contact-title">Get in touch with any questions</h2>

                    <div class="service-contact-info">
                        <h4>Address</h4>
                        <p>13/5 หมู่ที่ 11 ซอยวัดใหม่จริยาภิรมย์ แขวงคลองสิบสอง เขตหนองจอก กรุงเทพมหานคร,<br>Nong Chok, Thailand, Bangkok</p>
                    </div>

                    <div class="service-contact-info">
                        <h4>Contact</h4>
                        <p>123-456-7890<br>info@mysite.com</p>
                    </div>

                    <div class="service-social">
                        <a href="#" class="service-social-icon"><?php ayam_svg_icon('facebook', 'social-svg-icon'); ?></a>
                        <a href="#" class="service-social-icon"><?php ayam_svg_icon('instagram', 'social-svg-icon'); ?></a>
                    </div>
                </div>

                <div class="service-contact-right">
                    <p class="service-form-subtitle">Please fill out the form:</p>
                    <form class="service-contact-form">
                        <div class="service-form-row">
                            <div class="service-form-group">
                                <label>ชื่อ</label>
                                <input type="text" name="first_name" required>
                            </div>
                            <div class="service-form-group">
                                <label>นามสกุล</label>
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        <div class="service-form-group">
                            <label>อีเมล</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="service-form-group">
                            <label>ที่อยู่</label>
                            <input type="text" name="address">
                        </div>
                        <div class="service-form-group">
                            <label>โทรศัพท์</label>
                            <input type="tel" name="phone">
                        </div>
                        <button type="submit" class="service-form-submit">ส่ง</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="service-map">
        <div id="service-map-container" style="width: 100%; height: 400px; background: #ddd;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.5447896873453!2d100.72875631483056!3d13.835540990304847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d61f8e9b3c3e1%3A0x3a7e5e5e5e5e5e5e!2sNong%20Chok%2C%20Bangkok!5e0!3m2!1sen!2sth!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
