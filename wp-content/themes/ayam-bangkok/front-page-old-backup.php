<?php
/**
 * The front page template file
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <!-- Hero Image Slider Section -->
    <section class="hero-slider-section" data-aos="fade-in">
        <?php
        $slider_images = function_exists('ayam_get_slider_images') ? @ayam_get_slider_images() : array();
        $slider_settings = ayam_get_slider_settings();
        
        if (!empty($slider_images)) :
        ?>
            <div class="swiper hero-swiper" style="height: <?php echo esc_attr($slider_settings['height']); ?>;">
                <div class="swiper-wrapper">
                    <?php foreach ($slider_images as $slide) : ?>
                        <?php 
                        // Handle both URL and attachment ID
                        $bg_image = '';
                        if (!empty($slide['slide_image'])) {
                            if (is_numeric($slide['slide_image'])) {
                                // It's an attachment ID
                                $bg_image = wp_get_attachment_image_url($slide['slide_image'], 'full');
                            } else {
                                // It's already a URL
                                $bg_image = $slide['slide_image'];
                            }
                        }
                        
                        // Store image URL in data attribute for JavaScript
                        ?>
                        <div class="swiper-slide" data-bg-image="<?php echo esc_url($bg_image); ?>" style="background-image: url('<?php echo esc_url($bg_image); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <div class="slide-overlay"></div>
                            <div class="slide-content text-<?php echo esc_attr($slide['slide_text_position'] ?? 'center'); ?>">
                                <div class="container">
                                    <div class="slide-inner">
                                        <?php if (!empty($slide['slide_title'])) : ?>
                                            <h1 class="slide-title" data-aos="fade-up" data-aos-delay="200">
                                                <?php echo esc_html($slide['slide_title']); ?>
                                            </h1>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($slide['slide_description'])) : ?>
                                            <p class="slide-description" data-aos="fade-up" data-aos-delay="400">
                                                <?php echo esc_html($slide['slide_description']); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($slide['slide_button_text']) && !empty($slide['slide_button_url'])) : ?>
                                            <div class="slide-buttons" data-aos="fade-up" data-aos-delay="600">
                                                <a href="<?php echo esc_url($slide['slide_button_url']); ?>" 
                                                   class="btn-modern <?php echo esc_attr($slide['slide_button_style'] ?? 'primary'); ?>">
                                                    <?php echo esc_html($slide['slide_button_text']); ?>
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($slider_settings['show_pagination']) : ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>
                
                <?php if ($slider_settings['show_navigation']) : ?>
                    <div class="swiper-button-next">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Enhanced Slider Configuration Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // CRITICAL: Fix background images after DOM load
                    function fixSliderBackgrounds() {
                        const slides = document.querySelectorAll('.hero-swiper .swiper-slide[data-bg-image]');
                        console.log(`Found ${slides.length} slides to fix`);
                        slides.forEach((slide, index) => {
                            const bgImage = slide.getAttribute('data-bg-image');
                            if (bgImage) {
                                slide.style.setProperty('background-image', `url('${bgImage}')`, 'important');
                                slide.style.setProperty('background-size', 'cover', 'important');
                                
                                // Responsive background positioning for mobile
                                if (window.innerWidth <= 480) {
                                    slide.style.setProperty('background-position', 'center 15%', 'important');
                                } else if (window.innerWidth <= 768) {
                                    slide.style.setProperty('background-position', 'center 20%', 'important');
                                } else {
                                    slide.style.setProperty('background-position', 'center center', 'important');
                                }
                                
                                slide.style.setProperty('background-repeat', 'no-repeat', 'important');
                                console.log(`Fixed background for slide ${index + 1}: ${bgImage}`);
                            }
                        });
                    }
                    
                    // Enhanced slider initialization with better error handling
                    function initializeSlider() {
                        if (typeof Swiper === 'undefined') {
                            console.warn('Swiper not loaded, retrying in 500ms...');
                            setTimeout(initializeSlider, 500);
                            return;
                        }

                        try {
                            const heroSwiper = new Swiper('.hero-swiper', {
                                // Core settings
                                loop: <?php echo $slider_settings['loop'] ? 'true' : 'false'; ?>,
                                effect: 'slide',
                                speed: 1000,
                                spaceBetween: 0,
                                centeredSlides: true,
                                
                                <?php if ($slider_settings['autoplay']) : ?>
                                autoplay: {
                                    delay: <?php echo intval($slider_settings['autoplay_speed']); ?>,
                                    disableOnInteraction: false,
                                    pauseOnMouseEnter: true,
                                },
                                <?php endif; ?>
                                
                                <?php if ($slider_settings['show_pagination']) : ?>
                                pagination: {
                                    el: '.swiper-pagination',
                                    clickable: true,
                                    dynamicBullets: false,
                                },
                                <?php endif; ?>
                                
                                <?php if ($slider_settings['show_navigation']) : ?>
                                navigation: {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                },
                                <?php endif; ?>
                                
                                <?php if ($slider_settings['effect'] === 'fade') : ?>
                                fadeEffect: {
                                    crossFade: true
                                },
                                <?php endif; ?>
                                
                                // Enhanced settings
                                keyboard: {
                                    enabled: true,
                                    onlyInViewport: true,
                                },
                                
                                touchRatio: 1,
                                touchAngle: 45,
                                grabCursor: true,
                                
                                a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous slide',
                                    nextSlideMessage: 'Next slide',
                                },
                                
                                on: {
                                    init: function() {
                                        console.log('Hero Swiper initialized successfully');
                                        // Fix backgrounds AFTER Swiper initialization
                                        setTimeout(() => {
                                            fixSliderBackgrounds();
                                        }, 100);
                                        // Animate first slide
                                        setTimeout(() => {
                                            const firstSlideContent = document.querySelector('.swiper-slide-active .slide-content');
                                            if (firstSlideContent) {
                                                firstSlideContent.classList.add('slide-animate');
                                            }
                                        }, 300);
                                    },
                                    slideChange: function() {
                                        // Remove animation from all slides
                                        document.querySelectorAll('.slide-content').forEach(content => {
                                            content.classList.remove('slide-animate');
                                        });
                                        
                                        // Add animation to active slide
                                        setTimeout(() => {
                                            const activeSlideContent = document.querySelector('.swiper-slide-active .slide-content');
                                            if (activeSlideContent) {
                                                activeSlideContent.classList.add('slide-animate');
                                            }
                                        }, 100);
                                        
                                        // Fix backgrounds after slide change
                                        setTimeout(() => {
                                            fixSliderBackgrounds();
                                        }, 150);
                                    }
                                }
                            });
                            
                            console.log('Hero Swiper created:', heroSwiper);
                            
                            // Force fix backgrounds every 2 seconds as fallback
                            setInterval(() => {
                                fixSliderBackgrounds();
                            }, 2000);
                            
                        } catch (error) {
                            console.error('Error initializing Swiper:', error);
                            // Fallback: show first slide with animation
                            const firstSlideContent = document.querySelector('.swiper-slide:first-child .slide-content');
                            if (firstSlideContent) {
                                firstSlideContent.classList.add('slide-animate');
                            }
                        }
                    }
                    
                    // Start initialization
                    initializeSlider();
                });
            </script>
        <?php else : ?>
            <!-- Fallback Hero Section if no slider images -->
            <div class="hero-fallback" style="height: <?php echo esc_attr($slider_settings['height']); ?>;">
                <div class="hero-fallback-content">
                    <div class="container">
                        <div class="hero-text text-center">
                            <h1 class="hero-title" data-aos="fade-up">
                                <?php echo get_theme_mod('hero_title', __('ยินดีต้อนรับสู่ Ayam Bangkok', 'ayam-bangkok')); ?>
                            </h1>
                            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                                <?php echo get_theme_mod('hero_subtitle', __('ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็ทางการรายเดียวของประเทศไทย', 'ayam-bangkok')); ?>
                            </p>
                            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                                <a href="<?php echo esc_url(get_post_type_archive_link('ayam_rooster')); ?>" class="btn-modern primary">
                                    <?php _e('ดูไก่ชนของเรา', 'ayam-bangkok'); ?>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-modern outline">
                                    <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                                    <i class="fas fa-phone"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section><!-- .hero-slider-section -->
    
    <!-- Welcome Section -->
    <?php
    $welcome_content = ayam_get_welcome_content();
    if ($welcome_content['enable']) :?>
        <section class="welcome-section welcome-bg-<?php echo esc_attr($welcome_content['background_color']); ?>" data-aos="fade-up">
            <div class="container">
                <div class="welcome-content">
                    <?php if (!empty($welcome_content['title'])) : ?>
                        <h2 class="welcome-title" data-aos="fade-up" data-aos-delay="100">
                            <?php echo esc_html($welcome_content['title']); ?>
                        </h2>
                    <?php endif; ?>
                    
                    <?php if (!empty($welcome_content['description'])) : ?>
                        <p class="welcome-description" data-aos="fade-up" data-aos-delay="200">
                            <?php echo esc_html($welcome_content['description']); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="welcome-features" data-aos="fade-up" data-aos-delay="300">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4><?php _e('ความน่าเชื่อถือ', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('ตัวแทนอย่างเป็นทางการรายเดียวของประเทศไทย', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <h4><?php _e('คุณภาพสูง', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('ไก่ชนคุณภาพพรีเมียมผ่านการคัดสรรอย่างดี', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h4><?php _e('บริการครบครัน', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('ดูแลทุกขั้นตอนตั้งแต่เลือกไก่จนถึงส่งมอบ', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h4><?php _e('ประสบการณ์ยาวนาน', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('ประสบการณ์กว่า 10 ปีในการส่งออกไก่ชน', 'ayam-bangkok'); ?></p>
                        </div>
                    </div>
                    
                    <div class="welcome-actions" data-aos="fade-up" data-aos-delay="400">
                        <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn-modern primary">
                            <?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="<?php echo esc_url(get_post_type_archive_link('ayam_rooster')); ?>" class="btn-modern outline">
                            <?php _e('ดูไก่ชนของเรา', 'ayam-bangkok'); ?>
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section><!-- .welcome-section -->
    <?php else : ?>
        <!-- Fallback Welcome Section -->
        <section class="welcome-section" style="padding: 80px 0; background: #f8fafc;">
            <div class="container">
                <div class="welcome-content text-center">
                    <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #1f2937;">ยินดีต้อนรับสู่บริการส่งออกไก่ไทย</h2>
                    <p style="font-size: 1.1rem; color: #6b7280; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">เราเป็นผู้เชี่ยวชาญในการส่งออกไก่คุณภาพสูงจากฟาร์มไทยไปยังตลาดอินโดนีเซีย ด้วยกระบวนการที่มีมาตรฐานและเชื่อถือได้</p>
                    
                    <div class="welcome-features" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-top: 3rem;">
                        <div class="feature-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">
                            <div style="font-size: 3rem; margin-bottom: 15px;">🐓</div>
                            <h3 style="color: #1f2937; margin-bottom: 10px;">ไก่คุณภาพสูง</h3>
                            <p style="color: #6b7280; font-size: 0.9rem;">คัดสรรไก่จากฟาร์มที่ได้มาตรฐาน</p>
                        </div>
                        <div class="feature-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">
                            <div style="font-size: 3rem; margin-bottom: 15px;">🚚</div>
                            <h3 style="color: #1f2937; margin-bottom: 10px;">ขนส่งปลอดภัย</h3>
                            <p style="color: #6b7280; font-size: 0.9rem;">ระบบขนส่งที่รักษาคุณภาพ</p>
                        </div>
                        <div class="feature-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">
                            <div style="font-size: 3rem; margin-bottom: 15px;">📋</div>
                            <h3 style="color: #1f2937; margin-bottom: 10px;">เอกสารครบถ้วน</h3>
                            <p style="color: #6b7280; font-size: 0.9rem;">จัดการเอกสารส่งออกทุกขั้นตอน</p>
                        </div>
                    </div>
                    
                    <div style="margin-top: 3rem;">
                        <a href="#export-process" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 500; margin-right: 15px;">
                            เรียนรู้เพิ่มเติม
                            <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                        </a>
                        <a href="#contact" style="background: transparent; color: #3b82f6; padding: 12px 30px; border: 2px solid #3b82f6; border-radius: 8px; text-decoration: none; font-weight: 500;">
                            ติดต่อเรา
                            <i class="fas fa-phone" style="margin-left: 8px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Modern Services Section -->
    <section class="services-modern-section" data-aos="fade-up">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><?php _e('บริการของเรา', 'ayam-bangkok'); ?></span>
                <h2 class="section-title"><?php _e('บริการส่งออกไก่พื้นเมืองครบวงจร', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เราให้บริการส่งออกไก่ชนคุณภาพสูงพร้อมใบรับรองมาตรฐานสากล ด้วยประสบการณ์กว่า 10 ปี', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="services-modern-grid">
                <div class="service-card-modern" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card-header">
                        <div class="service-icon-modern gradient-1">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="service-number">01</div>
                    </div>
                    <div class="service-card-body">
                        <h3 class="service-title"><?php _e('ใบรับรองคุณภาพ', 'ayam-bangkok'); ?></h3>
                        <p class="service-description"><?php _e('ไก่ชนทุกตัวผ่านการตรวจสอบคุณภาพและมีใบรับรองจากสัตวแพทย์ รับประกันมาตรฐานสากล', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> <?php _e('ตรวจสุขภาพครบถ้วน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ใบรับรองสัตวแพทย์', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('มาตรฐานส่งออก', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="service-link">
                            <?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="service-card-modern" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card-header">
                        <div class="service-icon-modern gradient-2">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="service-number">02</div>
                    </div>
                    <div class="service-card-body">
                        <h3 class="service-title"><?php _e('การส่งออกที่ปลอดภัย', 'ayam-bangkok'); ?></h3>
                        <p class="service-description"><?php _e('ระบบการขนส่งที่ได้มาตรฐานสากลพร้อมการติดตามตลอดเส้นทาง รับประกันความปลอดภัย', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> <?php _e('ระบบติดตาม GPS', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('บรรจุภัณฑ์พิเศษ', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ประกันการขนส่ง', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="service-link">
                            <?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="service-card-modern" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card-header">
                        <div class="service-icon-modern gradient-3">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="service-number">03</div>
                    </div>
                    <div class="service-card-body">
                        <h3 class="service-title"><?php _e('บริการครบวงจร', 'ayam-bangkok'); ?></h3>
                        <p class="service-description"><?php _e('ตั้งแต่การเลือกไก่ชน การดูแลรักษา ไปจนถึงการส่งมอบ เราดูแลทุกขั้นตอนอย่างใส่ใจ', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> <?php _e('คัดเลือกไก่คุณภาพ', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ดูแลก่อนส่งออก', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('บริการหลังการขาย', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="service-link">
                            <?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="service-card-modern" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card-header">
                        <div class="service-icon-modern gradient-4">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="service-number">04</div>
                    </div>
                    <div class="service-card-body">
                        <h3 class="service-title"><?php _e('ประสบการณ์ยาวนาน', 'ayam-bangkok'); ?></h3>
                        <p class="service-description"><?php _e('ความเชี่ยวชาญในการส่งออกไก่ชนไปยังอินโดนีเซียมากว่า 10 ปี พร้อมเครือข่ายที่แข็งแกร่ง', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> <?php _e('ประสบการณ์ 10+ ปี', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('เครือข่ายอินโดนีเซีย', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ลูกค้าพึงพอใจ 100%', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="service-link">
                            <?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="services-cta" data-aos="fade-up" data-aos-delay="500">
                <div class="cta-content">
                    <h3><?php _e('พร้อมเริ่มต้นส่งออกไก่ชนแล้วหรือยัง?', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ติดต่อเราวันนี้เพื่อรับคำปรึกษาฟรีและใบเสนอราคาพิเศษ', 'ayam-bangkok'); ?></p>
                </div>
                <div class="cta-actions">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-modern primary">
                        <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                        <i class="fas fa-phone"></i>
                    </a>
                    <a href="<?php echo esc_url(home_url('/pricing/')); ?>" class="btn-modern outline">
                        <?php _e('ดูราคา', 'ayam-bangkok'); ?>
                        <i class="fas fa-calculator"></i>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- .services-modern-section -->
    
    <!-- Export Process Flow Section -->
    <section id="export-process" class="export-process-section" data-aos="fade-up">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><?php _e('กระบวนการส่งออก', 'ayam-bangkok'); ?></span>
                <h2 class="section-title"><?php _e('ขั้นตอนการส่งออกไก่ชนครบวงจร', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เราดูแลทุกขั้นตอนตั้งแต่รับไก่เข้าจนถึงส่งมอบให้ลูกค้าในอินโดนีเซีย', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="process-steps-container">
                <div class="process-steps">
                    <div class="process-step" data-aos="fade-up" data-aos-delay="100" data-step="0">
                        <div class="step-icon">
                            <i class="fas fa-hand-holding"></i>
                        </div>
                        <div class="step-number">01</div>
                        <h4 class="step-title"><?php _e('รับไก่เข้า', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('รับไก่จากฟาร์มและตรวจสอบเบื้องต้น', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('30-60 นาที', 'ayam-bangkok'); ?></div>
                    </div>
                    
                    <div class="process-step" data-aos="fade-up" data-aos-delay="200" data-step="1">
                        <div class="step-icon">
                            <i class="fas fa-weight-hanging"></i>
                        </div>
                        <div class="step-number">02</div>
                        <h4 class="step-title"><?php _e('ชั่งน้ำหนัก', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('ชั่งน้ำหนักและบันทึกข้อมูลอย่างแม่นยำ', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('15-30 นาที/ตัว', 'ayam-bangkok'); ?></div>
                    </div>
                    
                    <div class="process-step" data-aos="fade-up" data-aos-delay="300" data-step="2">
                        <div class="step-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="step-number">03</div>
                        <h4 class="step-title"><?php _e('ถ่ายรูป', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('ถ่ายรูปบันทึกลักษณะและคุณสมบัติ', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('10-15 นาที/ตัว', 'ayam-bangkok'); ?></div>
                    </div>
                    
                    <div class="process-step" data-aos="fade-up" data-aos-delay="400" data-step="3">
                        <div class="step-icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <div class="step-number">04</div>
                        <h4 class="step-title"><?php _e('ตรวจสุขภาพ', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('ตรวจสุขภาพโดยสัตวแพทย์ผู้เชี่ยวชาญ', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('20-30 นาที/ตัว', 'ayam-bangkok'); ?></div>
                    </div>
                    
                    <div class="process-step" data-aos="fade-up" data-aos-delay="500" data-step="4">
                        <div class="step-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="step-number">05</div>
                        <h4 class="step-title"><?php _e('ทำเอกสาร', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('จัดทำเอกสารส่งออกและใบรับรอง', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('2-4 ชั่วโมง', 'ayam-bangkok'); ?></div>
                    </div>
                    
                    <div class="process-step" data-aos="fade-up" data-aos-delay="600" data-step="5">
                        <div class="step-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="step-number">06</div>
                        <h4 class="step-title"><?php _e('กักกัน', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('กักกันตามมาตรฐานสากลก่อนส่งออก', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('7-14 วัน', 'ayam-bangkok'); ?></div>
                    </div>
                    
                    <div class="process-step" data-aos="fade-up" data-aos-delay="700" data-step="6">
                        <div class="step-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div class="step-number">07</div>
                        <h4 class="step-title"><?php _e('ส่งขึ้นเครื่อง', 'ayam-bangkok'); ?></h4>
                        <p class="step-description"><?php _e('ส่งขึ้นเครื่องบินไปยังอินโดนีเซีย', 'ayam-bangkok'); ?></p>
                        <div class="step-duration"><?php _e('4-6 ชั่วโมง', 'ayam-bangkok'); ?></div>
                    </div>
                </div>
                
                <div class="process-flow-actions" data-aos="fade-up" data-aos-delay="800">
                    <div class="action-content">
                        <h4><?php _e('ต้องการดูรายละเอียดแต่ละขั้นตอน?', 'ayam-bangkok'); ?></h4>
                        <p><?php _e('คลิกที่ขั้นตอนใดก็ได้เพื่อดูรายละเอียดเพิ่มเติม', 'ayam-bangkok'); ?></p>
                    </div>
                    <div class="action-buttons">
                        <button class="btn-modern primary btn-simulate-process">
                            <i class="fas fa-play"></i>
                            <?php _e('จำลองกระบวนการ', 'ayam-bangkok'); ?>
                        </button>
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn-modern outline">
                            <i class="fas fa-info-circle"></i>
                            <?php _e('ดูรายละเอียดบริการ', 'ayam-bangkok'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- .export-process-section -->
    
    <!-- Export Statistics Section -->
    <section class="export-stats-section" data-aos="fade-up">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><?php _e('ความสำเร็จ', 'ayam-bangkok'); ?></span>
                <h2 class="section-title"><?php _e('สถิติการส่งออกของเรา', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('ตัวเลขที่พิสูจน์ความเชี่ยวชาญและความน่าเชื่อถือของเรา', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-number" data-count="1250">0</div>
                    <div class="stat-label"><?php _e('การส่งออกสำเร็จ', 'ayam-bangkok'); ?></div>
                    <div class="stat-description"><?php _e('ตั้งแต่เริ่มดำเนินการ', 'ayam-bangkok'); ?></div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="stat-number" data-count="98.5">0</div>
                    <div class="stat-label"><?php _e('อัตราความสำเร็จ (%)', 'ayam-bangkok'); ?></div>
                    <div class="stat-description"><?php _e('การส่งมอบที่สมบูรณ์', 'ayam-bangkok'); ?></div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number" data-count="7">0</div>
                    <div class="stat-label"><?php _e('วันเฉลี่ย', 'ayam-bangkok'); ?></div>
                    <div class="stat-description"><?php _e('ระยะเวลาดำเนินการ', 'ayam-bangkok'); ?></div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="stat-number" data-count="15">0</div>
                    <div class="stat-label"><?php _e('เมืองปลายทาง', 'ayam-bangkok'); ?></div>
                    <div class="stat-description"><?php _e('ทั่วประเทศอินโดนีเซีย', 'ayam-bangkok'); ?></div>
                </div>
            </div>
            
            <!-- Success Stories & Testimonials -->
            <div class="success-stories-section" data-aos="fade-up" data-aos-delay="500">
                <div class="stories-header">
                    <h3><?php _e('เสียงจากลูกค้าและพาร์ตเนอร์', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ความคิดเห็นจากผู้ที่ใช้บริการส่งออกของเรา', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="testimonials-grid">
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="600">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                "<?php _e('บริการของ Ayam Bangkok ดีมาก ไก่ถึงอินโดนีเซียในสภาพสมบูรณ์ เอกสารครบถ้วน กระบวนการโปร่งใส', 'ayam-bangkok'); ?>"
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="author-info">
                                    <div class="author-name"><?php _e('นาย สมชาย ใจดี', 'ayam-bangkok'); ?></div>
                                    <div class="author-role"><?php _e('เจ้าของฟาร์มไก่ชน จ.สุพรรณบุรี', 'ayam-bangkok'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="700">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                "<?php _e('Ayam Bangkok adalah partner terbaik untuk ekspor ayam dari Thailand. Proses cepat, aman, dan terpercaya.', 'ayam-bangkok'); ?>"
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="author-info">
                                    <div class="author-name">Budi Santoso</div>
                                    <div class="author-role"><?php _e('Importir Jakarta, Indonesia', 'ayam-bangkok'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card" data-aos="fade-up" data-aos-delay="800">
                        <div class="testimonial-content">
                            <div class="quote-icon">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                "<?php _e('ใช้บริการมา 3 ปีแล้ว ไม่เคยผิดหวัง ทีมงานมืออาชีพ ดูแลไก่เหมือนของตัวเอง', 'ayam-bangkok'); ?>"
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="author-info">
                                    <div class="author-name"><?php _e('นางสาว วิไล สุขใส', 'ayam-bangkok'); ?></div>
                                    <div class="author-role"><?php _e('ฟาร์มไก่ชนอีสาน จ.ขอนแก่น', 'ayam-bangkok'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-text">5.0</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Partner Network -->
            <div class="partner-network-section" data-aos="fade-up" data-aos-delay="900">
                <div class="partner-header">
                    <h3><?php _e('เครือข่ายพาร์ตเนอร์ในอินโดนีเซีย', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('พาร์ตเนอร์ที่เชื่อถือได้ในการรับและจัดส่งไก่ชนทั่วอินโดนีเซีย', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="partner-cities">
                    <div class="city-card" data-aos="fade-up" data-aos-delay="1000">
                        <div class="city-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>Jakarta</h4>
                        <p><?php _e('3 พาร์ตเนอร์', 'ayam-bangkok'); ?></p>
                        <div class="city-stats">
                            <span><?php _e('450+ การส่งออก', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="city-card" data-aos="fade-up" data-aos-delay="1100">
                        <div class="city-icon">
                            <i class="fas fa-ship"></i>
                        </div>
                        <h4>Surabaya</h4>
                        <p><?php _e('2 พาร์ตเนอร์', 'ayam-bangkok'); ?></p>
                        <div class="city-stats">
                            <span><?php _e('320+ การส่งออก', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="city-card" data-aos="fade-up" data-aos-delay="1200">
                        <div class="city-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <h4>Medan</h4>
                        <p><?php _e('2 พาร์ตเนอร์', 'ayam-bangkok'); ?></p>
                        <div class="city-stats">
                            <span><?php _e('280+ การส่งออก', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="city-card" data-aos="fade-up" data-aos-delay="1300">
                        <div class="city-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4><?php _e('เมืองอื่นๆ', 'ayam-bangkok'); ?></h4>
                        <p><?php _e('8 พาร์ตเนอร์', 'ayam-bangkok'); ?></p>
                        <div class="city-stats">
                            <span><?php _e('200+ การส่งออก', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- .export-stats-section -->
    
    <!-- Sample Export Cases Section -->
    <section class="export-cases-section" data-aos="fade-up">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><?php _e('ตัวอย่างการส่งออก', 'ayam-bangkok'); ?></span>
                <h2 class="section-title"><?php _e('กรณีศึกษาการส่งออกที่สำเร็จ', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('ตัวอย่างการส่งออกไก่ชนที่ผ่านกระบวนการครบถ้วนและส่งมอบสำเร็จ', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="export-cases-grid">
                <?php
                // Sample Export Cases Data (Mock Data)
                $export_cases = array(
                    array(
                        'id' => 'EXP-2024-001',
                        'title' => 'ไก่ชนไทยพื้นเมือง - ส่งออกไปจาการ์ตา',
                        'image' => get_template_directory_uri() . '/assets/images/export-case-1.jpg',
                        'status' => 'delivered',
                        'destination' => 'Jakarta, Indonesia',
                        'date' => '15 ม.ค. 2024',
                        'roosters_count' => 12,
                        'weight' => '18.5 กก.',
                        'timeline' => array(
                            array('step' => 'รับไก่เข้า', 'date' => '10 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ตรวจสุขภาพ', 'date' => '11 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ทำเอกสาร', 'date' => '12 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ส่งออก', 'date' => '15 ม.ค. 2024', 'status' => 'completed'),
                        )
                    ),
                    array(
                        'id' => 'EXP-2024-002',
                        'title' => 'ไก่ชนอีสาน - ส่งออกไปสุราบายา',
                        'image' => get_template_directory_uri() . '/assets/images/export-case-2.jpg',
                        'status' => 'delivered',
                        'destination' => 'Surabaya, Indonesia',
                        'date' => '22 ม.ค. 2024',
                        'roosters_count' => 8,
                        'weight' => '12.8 กก.',
                        'timeline' => array(
                            array('step' => 'รับไก่เข้า', 'date' => '18 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ตรวจสุขภาพ', 'date' => '19 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ทำเอกสาร', 'date' => '20 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ส่งออก', 'date' => '22 ม.ค. 2024', 'status' => 'completed'),
                        )
                    ),
                    array(
                        'id' => 'EXP-2024-003',
                        'title' => 'American Gamefowl - ส่งออกไปเมดาน',
                        'image' => get_template_directory_uri() . '/assets/images/export-case-3.jpg',
                        'status' => 'in_transit',
                        'destination' => 'Medan, Indonesia',
                        'date' => '28 ม.ค. 2024',
                        'roosters_count' => 15,
                        'weight' => '22.3 กก.',
                        'timeline' => array(
                            array('step' => 'รับไก่เข้า', 'date' => '25 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ตรวจสุขภาพ', 'date' => '26 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ทำเอกสาร', 'date' => '27 ม.ค. 2024', 'status' => 'completed'),
                            array('step' => 'ส่งออก', 'date' => '28 ม.ค. 2024', 'status' => 'in_progress'),
                        )
                    )
                );
                
                if (!empty($export_cases)) :
                    $delay = 100;
                    foreach ($export_cases as $case) :
                        ?>
                        <div class="export-case-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="case-header">
                                <div class="case-id">
                                    <i class="fas fa-barcode"></i>
                                    <?php echo esc_html($case['id']); ?>
                                </div>
                                <div class="case-status status-<?php echo esc_attr($case['status']); ?>">
                                    <?php if ($case['status'] === 'delivered') : ?>
                                        <i class="fas fa-check-circle"></i>
                                        <?php _e('ส่งมอบสำเร็จ', 'ayam-bangkok'); ?>
                                    <?php elseif ($case['status'] === 'in_transit') : ?>
                                        <i class="fas fa-plane"></i>
                                        <?php _e('กำลังขนส่ง', 'ayam-bangkok'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="case-content">
                                <h3 class="case-title"><?php echo esc_html($case['title']); ?></h3>
                                
                                <div class="case-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo esc_html($case['destination']); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span><?php echo esc_html($case['date']); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-list-ol"></i>
                                        <span><?php echo esc_html($case['roosters_count']); ?> <?php _e('ตัว', 'ayam-bangkok'); ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-weight-hanging"></i>
                                        <span><?php echo esc_html($case['weight']); ?></span>
                                    </div>
                                </div>
                                
                                <div class="case-timeline">
                                    <?php foreach ($case['timeline'] as $step) : ?>
                                        <div class="timeline-item status-<?php echo esc_attr($step['status']); ?>">
                                            <div class="timeline-icon">
                                                <?php if ($step['status'] === 'completed') : ?>
                                                    <i class="fas fa-check"></i>
                                                <?php elseif ($step['status'] === 'in_progress') : ?>
                                                    <i class="fas fa-clock"></i>
                                                <?php else : ?>
                                                    <i class="fas fa-circle"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="timeline-title"><?php echo esc_html($step['step']); ?></div>
                                                <div class="timeline-date"><?php echo esc_html($step['date']); ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="case-actions">
                                    <button class="btn-modern primary btn-small btn-track" data-case-id="<?php echo esc_attr($case['id']); ?>">
                                        <i class="fas fa-search"></i>
                                        <?php _e('ติดตามสถานะ', 'ayam-bangkok'); ?>
                                    </button>
                                    <button class="btn-modern outline btn-small btn-export-inquiry">
                                        <i class="fas fa-paper-plane"></i>
                                        <?php _e('ขอใช้บริการ', 'ayam-bangkok'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                        $delay += 100;
                    endforeach;
                else :
                    ?>
                    <div class="no-export-cases" data-aos="fade-up">
                        <div class="no-content-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3><?php _e('ยังไม่มีตัวอย่างการส่งออก', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('เรากำลังเตรียมตัวอย่างการส่งออกที่สำเร็จให้คุณดู', 'ayam-bangkok'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="export-cases-footer" data-aos="fade-up" data-aos-delay="600">
                <div class="footer-content">
                    <h3><?php _e('ต้องการใช้บริการส่งออกไก่ชน?', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('เราให้บริการส่งออกไก่ชนครบวงจรไปยังอินโดนีเซีย', 'ayam-bangkok'); ?></p>
                </div>
                <div class="footer-actions">
                    <a href="<?php echo esc_url(home_url('/services/')); ?>" class="btn-modern primary">
                        <?php _e('ดูบริการทั้งหมด', 'ayam-bangkok'); ?>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-modern outline">
                        <?php _e('ปรึกษาผู้เชี่ยวชาญ', 'ayam-bangkok'); ?>
                        <i class="fas fa-user-tie"></i>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- .export-cases-section -->
    
    <!-- Latest News Section - Modern Design -->
    <section class="news-modern-section" data-aos="fade-up">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></span>
                <h2 class="section-title"><?php _e('ข่าวสารและกิจกรรมล่าสุด', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('ติดตามข่าวสารและกิจกรรมของเราได้ที่นี่ อัปเดตข้อมูลใหม่ๆ เกี่ยวกับการส่งออกไก่ชน', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="news-modern-grid">
                <?php
                // Get latest news
                $latest_news = new WP_Query(array(
                    'post_type' => 'ayam_news',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                
                if ($latest_news->have_posts()) :
                    $delay = 100;
                    while ($latest_news->have_posts()) : $latest_news->the_post();
                        $news_categories = get_the_terms(get_the_ID(), 'ayam_news_category');
                        ?>
                        <article class="news-card-modern" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="news-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" class="image-link">
                                        <?php the_post_thumbnail('medium_large', array('class' => 'news-image')); ?>
                                        <div class="image-overlay">
                                            <div class="overlay-content">
                                                <i class="fas fa-eye"></i>
                                                <span><?php _e('อ่านเพิ่มเติม', 'ayam-bangkok'); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <div class="news-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="news-card-meta">
                                    <div class="news-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo get_the_date('j M Y'); ?></span>
                                    </div>
                                    
                                    <?php if ($news_categories && !is_wp_error($news_categories)) : ?>
                                        <div class="news-category">
                                            <span class="category-badge">
                                                <?php echo esc_html($news_categories[0]->name); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="news-card-content">
                                <h3 class="news-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <p class="news-card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 25, '...'); ?>
                                </p>
                                
                                <div class="news-card-footer">
                                    <div class="news-author">
                                        <div class="author-avatar">
                                            <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                                        </div>
                                        <div class="author-info">
                                            <span class="author-name"><?php the_author(); ?></span>
                                            <span class="read-time">
                                                <i class="fas fa-clock"></i>
                                                <?php echo ayam_estimate_reading_time(get_the_content()); ?> <?php _e('นาที', 'ayam-bangkok'); ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="news-read-more">
                                        <?php _e('อ่านต่อ', 'ayam-bangkok'); ?>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php
                        $delay += 100;
                    endwhile;
                    wp_reset_postdata();
                else :
                    ?>
                    <div class="no-news-modern" data-aos="fade-up">
                        <div class="no-content-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3><?php _e('ยังไม่มีข่าวสาร', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('เรากำลังเตรียมข่าวสารและกิจกรรมใหม่ๆ ให้คุณติดตาม', 'ayam-bangkok'); ?></p>
                        <?php if (current_user_can('edit_posts')) : ?>
                            <a href="<?php echo admin_url('post-new.php?post_type=ayam_news'); ?>" class="btn-modern primary">
                                <i class="fas fa-plus"></i>
                                <?php _e('เพิ่มข่าวแรก', 'ayam-bangkok'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="news-section-footer" data-aos="fade-up" data-aos-delay="400">
                <div class="footer-content">
                    <h4><?php _e('ต้องการติดตามข่าวสารเพิ่มเติม?', 'ayam-bangkok'); ?></h4>
                    <p><?php _e('อ่านข่าวสารและบทความทั้งหมดเกี่ยวกับการส่งออกไก่ชน', 'ayam-bangkok'); ?></p>
                </div>
                <div class="footer-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link('ayam_news')); ?>" class="btn-modern primary">
                        <?php _e('ดูข่าวสารทั้งหมด', 'ayam-bangkok'); ?>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-modern outline">
                        <?php _e('สมัครรับข่าวสาร', 'ayam-bangkok'); ?>
                        <i class="fas fa-bell"></i>
                    </a>
                </div>
            </div>
        </div>
    </section><!-- .news-modern-section -->
    
    <!-- Quick Contact Section -->
    <section id="contact" class="quick-contact-section">
        <div class="container">
            <div class="quick-contact-content">
                <div class="contact-info">
                    <h2><?php _e('ติดต่อเราได้ทันที', 'ayam-bangkok'); ?></h2>
                    <p><?php _e('พร้อมให้คำปรึกษาและบริการด้วยประสบการณ์กว่า 10 ปี', 'ayam-bangkok'); ?></p>
                    
                    <div class="contact-methods">
                        <?php if (ayam_get_company_info('phone')) : ?>
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-info">
                                    <h4><?php _e('โทรศัพท์', 'ayam-bangkok'); ?></h4>
                                    <a href="tel:<?php echo esc_attr(ayam_get_company_info('phone')); ?>">
                                        <?php echo esc_html(ayam_get_company_info('phone')); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (ayam_get_company_info('line_id')) : ?>
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fab fa-line"></i>
                                </div>
                                <div class="method-info">
                                    <h4><?php _e('Line', 'ayam-bangkok'); ?></h4>
                                    <span><?php echo esc_html(ayam_get_company_info('line_id')); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (ayam_get_company_info('email')) : ?>
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="method-info">
                                    <h4><?php _e('อีเมล', 'ayam-bangkok'); ?></h4>
                                    <a href="mailto:<?php echo esc_attr(ayam_get_company_info('email')); ?>">
                                        <?php echo esc_html(ayam_get_company_info('email')); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h3><?php _e('ส่งข้อความหาเรา', 'ayam-bangkok'); ?></h3>
                    
                    <form class="quick-contact-form" method="post">
                        <?php wp_nonce_field('ayam_quick_contact', 'quick_contact_nonce'); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_name"><?php _e('ชื่อ-นามสกุล', 'ayam-bangkok'); ?> *</label>
                                <input type="text" id="contact_name" name="contact_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_phone"><?php _e('เบอร์โทรศัพท์', 'ayam-bangkok'); ?></label>
                                <input type="tel" id="contact_phone" name="contact_phone">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_email"><?php _e('อีเมล', 'ayam-bangkok'); ?> *</label>
                            <input type="email" id="contact_email" name="contact_email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_subject"><?php _e('หัวข้อ', 'ayam-bangkok'); ?></label>
                            <select id="contact_subject" name="contact_subject">
                                <option value="general"><?php _e('สอบถามทั่วไป', 'ayam-bangkok'); ?></option>
                                <option value="rooster_inquiry"><?php _e('สอบถามไก่ชน', 'ayam-bangkok'); ?></option>
                                <option value="export_service"><?php _e('บริการส่งออก', 'ayam-bangkok'); ?></option>
                                <option value="pricing"><?php _e('สอบถามราคา', 'ayam-bangkok'); ?></option>
                                <option value="appointment"><?php _e('นัดหมายเยี่ยมชม', 'ayam-bangkok'); ?></option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_message"><?php _e('ข้อความ', 'ayam-bangkok'); ?> *</label>
                            <textarea id="contact_message" name="contact_message" rows="4" required placeholder="<?php _e('กรุณาระบุรายละเอียดที่ต้องการสอบถาม...', 'ayam-bangkok'); ?>"></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                <?php _e('ส่งข้อความ', 'ayam-bangkok'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- .quick-contact-section -->
    
    <!-- Company Stats Section -->
    <section class="company-stats-section">
        <div class="container">
            <div class="stats-grid">
                <?php
                $stats = ayam_get_dashboard_stats();
                ?>
                
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($stats['total_roosters'] ?? 0); ?></div>
                    <div class="stat-label"><?php _e('ไก่ชนทั้งหมด', 'ayam-bangkok'); ?></div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($stats['available_roosters'] ?? 0); ?></div>
                    <div class="stat-label"><?php _e('พร้อมส่งออก', 'ayam-bangkok'); ?></div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label"><?php _e('ปีประสบการณ์', 'ayam-bangkok'); ?></div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($stats['monthly_exports'] ?? 0); ?></div>
                    <div class="stat-label"><?php _e('ส่งออกเดือนนี้', 'ayam-bangkok'); ?></div>
                </div>
            </div>
        </div>
    </section><!-- .company-stats-section -->
    
</main><!-- #primary -->

<?php get_footer(); ?>