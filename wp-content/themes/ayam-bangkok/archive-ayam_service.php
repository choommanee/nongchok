<?php
/**
 * Archive Template for Services
 * Display all services
 */

get_header();
?>

<main id="primary" class="site-main services-archive-page">
    
    <!-- Page Header -->
    <section class="page-header services-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('บริการของเรา', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('บริการครบวงจรสำหรับไก่ชนคุณภาพ', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="services-section">
        <div class="container">
            
            <?php if (have_posts()) : ?>
                
                <div class="services-grid">
                    <?php
                    $delay = 0;
                    while (have_posts()) : the_post();
                        $service_id = get_the_ID();
                        $price = get_field('service_price');
                        $duration = get_field('service_duration');
                        $features = get_field('service_features');
                        $icon = get_field('service_icon') ?: 'fas fa-concierge-bell';
                        $delay += 100;
                    ?>
                        <div class="service-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="service-icon">
                                <i class="<?php echo esc_attr($icon); ?>"></i>
                            </div>
                            
                            <div class="service-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                
                                <?php if (has_excerpt()) : ?>
                                    <p class="service-excerpt"><?php echo get_the_excerpt(); ?></p>
                                <?php endif; ?>
                                
                                <div class="service-meta">
                                    <?php if ($price) : ?>
                                        <div class="service-price">
                                            <i class="fas fa-tag"></i>
                                            <span><?php echo number_format($price); ?> บาท</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($duration) : ?>
                                        <div class="service-duration">
                                            <i class="fas fa-clock"></i>
                                            <span><?php echo esc_html($duration); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($features) : ?>
                                    <ul class="service-features">
                                        <?php foreach (array_slice($features, 0, 3) as $feature) : ?>
                                            <li><i class="fas fa-check"></i> <?php echo esc_html($feature['feature']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('ก่อนหน้า', 'ayam-bangkok'),
                    'next_text' => __('ถัดไป', 'ayam-bangkok') . ' <i class="fas fa-chevron-right"></i>',
                ));
                ?>
                
            <?php else : ?>
                
                <div class="no-services">
                    <i class="fas fa-inbox"></i>
                    <h3><?php _e('ไม่พบบริการ', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ขณะนี้ยังไม่มีบริการที่แสดง', 'ayam-bangkok'); ?></p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                        <?php _e('กลับหน้าแรก', 'ayam-bangkok'); ?>
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>

    <!-- CTA Section -->
    <section class="services-cta-section">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2><?php _e('สนใจบริการของเรา?', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ติดต่อเราเพื่อขอคำปรึกษาและรับข้อเสนอพิเศษ', 'ayam-bangkok'); ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary">
                        <i class="fas fa-envelope"></i>
                        <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                    </a>
                    <?php
                    $phone = get_theme_mod('ayam_phone');
                    if ($phone) :
                    ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="btn btn-secondary">
                            <i class="fas fa-phone"></i>
                            <?php _e('โทรหาเรา', 'ayam-bangkok'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
