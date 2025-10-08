<?php
/**
 * Single Service Template
 * Display individual service details
 */

get_header();

while (have_posts()) : the_post();
    $service_id = get_the_ID();
    $price = get_field('service_price');
    $duration = get_field('service_duration');
    $features = get_field('service_features');
    $icon = get_field('service_icon') ?: 'fas fa-concierge-bell';
    $gallery = get_field('service_gallery');
?>

<main id="primary" class="site-main single-service-page">
    
    <!-- Service Header -->
    <section class="service-header">
        <div class="container">
            <div class="service-header-content">
                <div class="service-icon-large">
                    <i class="<?php echo esc_attr($icon); ?>"></i>
                </div>
                <h1 class="service-title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="service-subtitle"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
                
                <div class="service-meta-bar">
                    <?php if ($price) : ?>
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <span><?php echo number_format($price); ?> บาท</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($duration) : ?>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span><?php echo esc_html($duration); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Content -->
    <section class="service-content-section">
        <div class="container">
            <div class="service-layout">
                
                <!-- Main Content -->
                <div class="service-main">
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="service-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="service-description">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php if ($features) : ?>
                        <div class="service-features-section">
                            <h2><?php _e('รายละเอียดบริการ', 'ayam-bangkok'); ?></h2>
                            <ul class="features-list">
                                <?php foreach ($features as $feature) : ?>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        <span><?php echo esc_html($feature['feature']); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($gallery) : ?>
                        <div class="service-gallery-section">
                            <h2><?php _e('ภาพกิจกรรม', 'ayam-bangkok'); ?></h2>
                            <div class="service-gallery-grid">
                                <?php foreach ($gallery as $image) : ?>
                                    <div class="gallery-item">
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- Sidebar -->
                <div class="service-sidebar">
                    
                    <!-- Booking Card -->
                    <div class="sidebar-card booking-card">
                        <h3><?php _e('จองบริการ', 'ayam-bangkok'); ?></h3>
                        
                        <?php if ($price) : ?>
                            <div class="price-display">
                                <span class="price-label"><?php _e('ราคา', 'ayam-bangkok'); ?></span>
                                <span class="price-amount"><?php echo number_format($price); ?> บาท</span>
                            </div>
                        <?php endif; ?>
                        
                        <form id="service-booking-form" class="booking-form">
                            <?php wp_nonce_field('service_booking', 'booking_nonce'); ?>
                            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
                            <input type="hidden" name="service_name" value="<?php the_title(); ?>">
                            
                            <div class="form-group">
                                <label><?php _e('ชื่อ-นามสกุล', 'ayam-bangkok'); ?></label>
                                <input type="text" name="customer_name" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?php _e('อีเมล', 'ayam-bangkok'); ?></label>
                                <input type="email" name="customer_email" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?php _e('เบอร์โทร', 'ayam-bangkok'); ?></label>
                                <input type="tel" name="customer_phone" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?php _e('วันที่ต้องการ', 'ayam-bangkok'); ?></label>
                                <input type="date" name="booking_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?php _e('หมายเหตุ', 'ayam-bangkok'); ?></label>
                                <textarea name="booking_notes" rows="3"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-calendar-check"></i>
                                <?php _e('จองเลย', 'ayam-bangkok'); ?>
                            </button>
                        </form>
                        
                        <div class="booking-response" style="display: none;"></div>
                    </div>
                    
                    <!-- Contact Card -->
                    <div class="sidebar-card contact-card">
                        <h3><?php _e('ต้องการสอบถาม?', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ติดต่อเราเพื่อขอข้อมูลเพิ่มเติม', 'ayam-bangkok'); ?></p>
                        
                        <?php
                        $phone = get_theme_mod('ayam_phone');
                        $email = get_theme_mod('ayam_email');
                        $line = get_theme_mod('ayam_line_id');
                        ?>
                        
                        <div class="contact-methods">
                            <?php if ($phone) : ?>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="contact-method">
                                    <i class="fas fa-phone"></i>
                                    <span><?php echo esc_html($phone); ?></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($email) : ?>
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-method">
                                    <i class="fas fa-envelope"></i>
                                    <span><?php echo esc_html($email); ?></span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($line) : ?>
                                <a href="https://line.me/ti/p/~<?php echo esc_attr($line); ?>" target="_blank" class="contact-method">
                                    <i class="fab fa-line"></i>
                                    <span>LINE: <?php echo esc_html($line); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>

    <!-- Related Services -->
    <?php
    $related_args = array(
        'post_type' => 'ayam_service',
        'posts_per_page' => 3,
        'post__not_in' => array($service_id),
        'orderby' => 'rand'
    );
    
    $related_query = new WP_Query($related_args);
    
    if ($related_query->have_posts()) :
    ?>
        <section class="related-services-section">
            <div class="container">
                <h2 class="section-title"><?php _e('บริการอื่นๆ', 'ayam-bangkok'); ?></h2>
                
                <div class="services-grid">
                    <?php
                    while ($related_query->have_posts()) : $related_query->the_post();
                        $rel_price = get_field('service_price');
                        $rel_icon = get_field('service_icon') ?: 'fas fa-concierge-bell';
                    ?>
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="<?php echo esc_attr($rel_icon); ?>"></i>
                            </div>
                            <div class="service-content">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php if (has_excerpt()) : ?>
                                    <p class="service-excerpt"><?php echo get_the_excerpt(); ?></p>
                                <?php endif; ?>
                                <?php if ($rel_price) : ?>
                                    <div class="service-price">
                                        <i class="fas fa-tag"></i>
                                        <span><?php echo number_format($rel_price); ?> บาท</span>
                                    </div>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main><!-- #primary -->

<?php
endwhile;
get_footer();
?>
