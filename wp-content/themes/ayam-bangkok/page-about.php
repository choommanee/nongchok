<?php
/**
 * Wix-Style Homepage Template
 * Matching https://saeliwid.wixsite.com/my-site-3
 */

get_header(); ?>

<main id="primary" class="site-main wix-style-homepage">
    
    <!-- Hero Section -->
    <section class="wix-hero-section">
        <!-- Hero Text -->
        <div class="hero-text-section">
            <div class="container">
                <div class="hero-text-center">
                    <h1 class="hero-main-title" data-aos="fade-up">Welcome to<br>AYAM BANGKOK</h1>
                    <p class="hero-main-subtitle" data-aos="fade-up" data-aos-delay="200">
                        Layanan pengiriman ayam lokal Thailand dengan pesawat terbang
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Hero Slider -->
        <div class="hero-slider-section">
            <div class="swiper hero-swiper-wix">
                <div class="swiper-wrapper">
                    <?php
                    // Hero slider images in order
                    $slider_images = [
                        get_template_directory_uri() . '/assets/images/hero-slides/slide-1.jpg',
                        get_template_directory_uri() . '/assets/images/hero-slides/slide-2.jpg',
                        get_template_directory_uri() . '/assets/images/hero-slides/slide-3.jpg',
                    ];
                    
                    foreach ($slider_images as $image) :
                    ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($image); ?>" alt="Ayam Bangkok">
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Navigation -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Our Business Section -->
    <section class="wix-about-intro">
        <div class="container">
            <div class="about-intro-grid">
                <div class="about-intro-content">
                    <h2 class="section-title" data-aos="fade-up">Our Business</h2>
                    <div class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Since 2025
                    </div>
                    <p class="intro-text" data-aos="fade-up" data-aos-delay="200">
                        I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me to add your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.
                    </p>
                    <p class="intro-text" data-aos="fade-up" data-aos-delay="300">
                        This is a great space to write a long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.
                    </p>
                </div>
                <div class="about-intro-images" data-aos="fade-left" data-aos-delay="200">
                    <!-- 3 Image Grid -->
                    <div class="intro-image-grid">
                        <?php
                        $intro_images = [
                            get_template_directory_uri() . '/assets/images/intro-1.jpg',
                            get_template_directory_uri() . '/assets/images/logo-square.jpg',
                            get_template_directory_uri() . '/assets/images/intro-3.jpg',
                        ];
                        
                        // Try to use images from pic home/2 if available
                        $intro_dir = ABSPATH . 'pic home/2/';
                        if (file_exists($intro_dir)) {
                            $intro_files = glob($intro_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
                            if (count($intro_files) >= 2) {
                                $intro_images = [
                                    home_url('/pic home/2/' . basename($intro_files[0])),
                                    get_template_directory_uri() . '/assets/images/logo-ayam-bangkok.svg',
                                    home_url('/pic home/2/' . basename($intro_files[1])),
                                ];
                            }
                        }
                        
                        foreach ($intro_images as $index => $img) :
                        ?>
                            <div class="intro-image-item">
                                <img src="<?php echo esc_url($img); ?>" alt="Ayam Bangkok">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="wix-service-section" style="background: #f8f8f8;">
        <div class="container">
            <div class="section-header-center">
                <h2 class="section-title" data-aos="fade-up">Our Story</h2>
            </div>
            
            <div class="about-intro-content" style="max-width: 900px; margin: 0 auto 60px;">
                <p class="intro-text" data-aos="fade-up" data-aos-delay="100">
                    I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me to add your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.
                </p>
                <p class="intro-text" data-aos="fade-up" data-aos-delay="200">
                    This is a great space to write a long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.
                </p>
            </div>
            
            <!-- Video Gallery Grid (8 videos) -->
            <div class="news-video-grid" data-aos="fade-up" data-aos-delay="100" style="grid-template-columns: repeat(4, 1fr);">
                <?php for ($i = 1; $i <= 8; $i++) : ?>
                    <div class="news-video-item">
                        <div class="news-video-thumbnail">
                            <div class="news-placeholder">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="news-video-content">
                            <h3 class="news-video-title">Video Title</h3>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="wix-contact-section">
        <div class="container">
            <div class="contact-layout">
                <div class="contact-info-side">
                    <h2 class="contact-title">Get in touch with<br>any questions</h2>
                    
                    <div class="contact-details">
                        <div class="contact-detail-item">
                            <strong>Address</strong>
                            <p>ถนน พุทธบูชา 11 ตำบลโคกเจริญ แขวงหนองจอก เขตหนองจอก<br>
                            Nong Chok, Thailand, Bangkok</p>
                        </div>
                        
                        <div class="contact-detail-item">
                            <strong>Contact</strong>
                            <p>089-091-4664</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form-side">
                    <div class="form-title">Please fill out the form:</div>
                    
                    <form class="wix-contact-form" method="post" action="">
                        <div class="form-row-2">
                            <div class="form-group">
                                <label>ชื่อ</label>
                                <input type="text" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label>นามสกุล</label>
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label>ข้อความ</label>
                            <textarea name="message" rows="5" required></textarea>
                        </div>
                        
                        <div class="form-submit">
                            <button type="submit" class="btn-wix-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
