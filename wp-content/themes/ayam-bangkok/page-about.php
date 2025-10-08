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

    <!-- Meet the Nong Chok FCI Section -->
    <section class="wix-about-intro">
        <div class="container">
            <div class="about-intro-grid">
                <div class="about-intro-content">
                    <h2 class="section-title" data-aos="fade-up">Meet the<br>Nong Chok FCI</h2>
                    <div class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Six executives of Ayam Bangkok
                    </div>
                    <p class="intro-text" data-aos="fade-up" data-aos-delay="200">
                        I'm a paragraph. Click here to add your own text and edit me. 
                        I'm a great place for you to tell a story and let your users know 
                        a little more about you.
                    </p>
                    <div class="intro-button" data-aos="fade-up" data-aos-delay="300">
                        <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn-wix-outline">Our Story</a>
                    </div>
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

    <!-- Our Service Section -->
    <section class="wix-service-section">
        <div class="container">
            <div class="section-header-center">
                <h2 class="section-title" data-aos="fade-up">Our Service</h2>
            </div>
            
            <div class="service-feature" data-aos="fade-up" data-aos-delay="100">
                <div class="service-images-grid">
                    <?php
                    // Service images from pic home/3
                    $service_dir = ABSPATH . 'pic home/3/';
                    $service_images = [];
                    
                    if (file_exists($service_dir)) {
                        $service_files = glob($service_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
                        foreach ($service_files as $file) {
                            $service_images[] = home_url('/pic home/3/' . basename($file));
                        }
                    }
                    
                    // Display service images
                    if (!empty($service_images)) :
                        foreach (array_slice($service_images, 0, 2) as $img) :
                    ?>
                        <div class="service-image-item">
                            <img src="<?php echo esc_url($img); ?>" alt="Service">
                        </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="service-content-center">
                    <div class="service-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3 class="service-title">Export by plane</h3>
                    <p class="service-description">
                        I'm a paragraph. Click here to add your own text and edit me. It's easy. 
                        Just click "Edit Text" or double click me to add your own content and make 
                        changes to the font. I'm a great place for you to tell a story and let 
                        your users know a little more about you.
                    </p>
                    <div class="service-button">
                        <a href="<?php echo esc_url(home_url('/service')); ?>" class="btn-wix-outline">Learn More</a>
                    </div>
                </div>
            </div>
            
            <!-- Plane Background Image -->
            <div class="service-bg-image" data-aos="fade-up" data-aos-delay="200">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/plane-bg.jpg" alt="Plane">
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="wix-gallery-section">
        <div class="container">
            <div class="section-header-center">
                <h2 class="section-title" data-aos="fade-up">Gallery</h2>
            </div>
            
            <div class="gallery-circle-grid" data-aos="fade-up" data-aos-delay="100">
                <?php
                // Get gallery images from pic home/gallery
                $gallery_dir = ABSPATH . 'pic home/gallery/';
                $gallery_images = [];
                
                if (file_exists($gallery_dir)) {
                    $gallery_files = glob($gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
                    foreach ($gallery_files as $file) {
                        $gallery_images[] = home_url('/pic home/gallery/' . basename($file));
                    }
                }
                
                // Show first 5 images in circular style
                $gallery_count = min(count($gallery_images), 5);
                
                if ($gallery_count > 0) :
                    for ($i = 0; $i < $gallery_count; $i++) :
                ?>
                    <div class="gallery-circle-item">
                        <a href="<?php echo esc_url(home_url('/gallery')); ?>">
                            <div class="circle-image">
                                <img src="<?php echo esc_url($gallery_images[$i]); ?>" alt="Gallery">
                            </div>
                        </a>
                    </div>
                <?php 
                    endfor;
                else :
                    // Fallback with rooster icon
                    for ($i = 1; $i <= 5; $i++) :
                ?>
                    <div class="gallery-circle-item">
                        <a href="<?php echo esc_url(home_url('/gallery')); ?>">
                            <div class="circle-image circle-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        </a>
                    </div>
                <?php 
                    endfor;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="wix-news-section">
        <div class="container">
            <div class="section-header-center">
                <h2 class="section-title" data-aos="fade-up">News</h2>
            </div>
            
            <div class="news-video-grid" data-aos="fade-up" data-aos-delay="100">
                <?php
                // Get latest 3 posts
                $news_query = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);
                
                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post();
                ?>
                    <div class="news-video-item">
                        <div class="news-video-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <div class="news-placeholder">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="news-video-content">
                            <h3 class="news-video-title">Video Title</h3>
                            <p class="news-video-description">
                                This is a great space to update your audience with a description of your video. 
                                Include information like what the video is about, who produced it, where it was...
                            </p>
                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Show placeholder news items
                    for ($i = 1; $i <= 3; $i++) :
                ?>
                    <div class="news-video-item">
                        <div class="news-video-thumbnail">
                            <div class="news-placeholder">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                        <div class="news-video-content">
                            <h3 class="news-video-title">Video Title</h3>
                            <p class="news-video-description">
                                This is a great space to update your audience with a description of your video. 
                                Include information like what the video is about, who produced it, where it was...
                            </p>
                        </div>
                    </div>
                <?php 
                    endfor;
                endif;
                ?>
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
