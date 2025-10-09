<?php
/**
 * Template Name: Gallery Page (Wix Style)
 * Matching Service/News page structure with Gallery grid
 */

get_header();

// Get gallery images from uploads directory
$upload_dir = wp_upload_dir();
$gallery_images = array();

$gallery_dir = $upload_dir['basedir'] . '/gallery-wix/';
if (is_dir($gallery_dir)) {
    $files = glob($gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
    foreach ($files as $file) {
        $gallery_images[] = $upload_dir['baseurl'] . '/gallery-wix/' . basename($file);
    }
}

// Fallback: Use images from about gallery if no gallery images
if (empty($gallery_images)) {
    $about_gallery_dir = $upload_dir['basedir'] . '/about-gallery/';
    if (is_dir($about_gallery_dir)) {
        $files = glob($about_gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
        foreach ($files as $file) {
            $gallery_images[] = $upload_dir['baseurl'] . '/about-gallery/' . basename($file);
        }
    }
}

?>

<main id="primary" class="site-main wix-style-gallery">

    <!-- Gallery Hero Section -->
    <section class="service-hero">
        <div class="service-hero-container">
            <h1 class="service-hero-subtitle">Get to Know</h1>
            <p class="service-hero-title">Gallery</p>
            <div class="service-hero-line"></div>
        </div>
    </section>

    <!-- Gallery Grid Section -->
    <section class="gallery-grid-section">
        <div class="service-container">
            <?php if (!empty($gallery_images)): ?>
                <div class="gallery-masonry-grid" data-aos="fade-up">
                    <?php foreach ($gallery_images as $index => $image): ?>
                        <div class="gallery-item" data-aos="fade-up" data-aos-delay="<?php echo ($index % 12) * 50; ?>">
                            <a href="<?php echo esc_url($image); ?>" data-lightbox="gallery" data-title="Image <?php echo $index + 1; ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="Gallery Image <?php echo $index + 1; ?>">
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
                    <p>ยังไม่มีรูปภาพในแกลเลอรี่</p>
                    <small>กรุณาอัปโหลดรูปภาพจากหลังบ้าน</small>
                </div>
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
                        <a href="#" class="service-social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="service-social-icon"><i class="fab fa-instagram"></i></a>
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
