<?php
/**
 * Template Name: Member Dashboard
 * Description: หน้า Dashboard สำหรับสมาชิก
 */

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// Get user meta
$phone = get_user_meta($user_id, 'phone', true);
$country = get_user_meta($user_id, 'country', true);
$business_type = get_user_meta($user_id, 'business_type', true);
$registration_date = get_user_meta($user_id, 'registration_date', true);

// Get statistics
global $wpdb;
$inquiries_table = $wpdb->prefix . 'ayam_inquiries';
$bookings_table = $wpdb->prefix . 'ayam_bookings';

$total_inquiries = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $inquiries_table WHERE customer_email = %s",
    $current_user->user_email
));

$total_bookings = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $bookings_table WHERE customer_email = %s",
    $current_user->user_email
));

// Get favorite roosters
$favorites = get_user_meta($user_id, 'favorite_roosters', true);
$favorites = $favorites ? $favorites : array();

get_header();
?>

<main id="primary" class="site-main member-dashboard-page">
    
    <!-- Dashboard Header -->
    <section class="dashboard-header">
        <div class="container">
            <div class="header-content">
                <div class="user-welcome">
                    <h1><?php printf(__('สวัสดี, %s', 'ayam-bangkok'), $current_user->first_name); ?></h1>
                    <p class="member-since">
                        <?php 
                        if ($registration_date) {
                            printf(__('สมาชิกตั้งแต่: %s', 'ayam-bangkok'), 
                                date_i18n('j F Y', strtotime($registration_date)));
                        }
                        ?>
                    </p>
                </div>
                <div class="header-actions">
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i>
                        <?php _e('ออกจากระบบ', 'ayam-bangkok'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Stats -->
    <section class="dashboard-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $total_inquiries; ?></h3>
                        <p class="stat-label"><?php _e('การสอบถาม', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $total_bookings; ?></h3>
                        <p class="stat-label"><?php _e('การจอง', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo count($favorites); ?></h3>
                        <p class="stat-label"><?php _e('รายการโปรด', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">0</h3>
                        <p class="stat-label"><?php _e('การแจ้งเตือน', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="dashboard-content">
        <div class="container">
            <div class="dashboard-grid">
                
                <!-- Left Column -->
                <div class="dashboard-main">
                    
                    <!-- Favorite Roosters -->
                    <div class="dashboard-section favorites-section">
                        <div class="section-header">
                            <h2>
                                <i class="fas fa-heart"></i>
                                <?php _e('ไก่ชนที่ชื่นชอบ', 'ayam-bangkok'); ?>
                            </h2>
                            <a href="<?php echo get_post_type_archive_link('ayam_rooster'); ?>" class="view-all">
                                <?php _e('ดูทั้งหมด', 'ayam-bangkok'); ?>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        
                        <div class="favorites-grid">
                            <?php
                            if (!empty($favorites)) {
                                $args = array(
                                    'post_type' => 'ayam_rooster',
                                    'post__in' => $favorites,
                                    'posts_per_page' => 6,
                                    'orderby' => 'post__in'
                                );
                                
                                $favorites_query = new WP_Query($args);
                                
                                if ($favorites_query->have_posts()) {
                                    while ($favorites_query->have_posts()) {
                                        $favorites_query->the_post();
                                        $rooster_id = get_the_ID();
                                        $price = get_field('rooster_price');
                                        $status = get_field('rooster_status');
                                        ?>
                                        <div class="favorite-card">
                                            <div class="favorite-image">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('rooster-card'); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="<?php the_permalink(); ?>">
                                                        <img src="<?php echo AYAM_THEME_URI; ?>/assets/images/placeholder-rooster.jpg" alt="<?php the_title(); ?>">
                                                    </a>
                                                <?php endif; ?>
                                                
                                                <button class="remove-favorite" data-rooster-id="<?php echo $rooster_id; ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                
                                                <?php if ($status) : ?>
                                                    <span class="status-badge status-<?php echo esc_attr($status); ?>">
                                                        <?php echo esc_html($status); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="favorite-content">
                                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                <?php if ($price) : ?>
                                                    <p class="price"><?php echo number_format($price); ?> บาท</p>
                                                <?php endif; ?>
                                                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary">
                                                    <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    wp_reset_postdata();
                                } else {
                                    echo '<p class="no-favorites">' . __('ยังไม่มีไก่ชนที่ชื่นชอบ', 'ayam-bangkok') . '</p>';
                                }
                            } else {
                                echo '<p class="no-favorites">' . __('ยังไม่มีไก่ชนที่ชื่นชอบ', 'ayam-bangkok') . '</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Recent Inquiries -->
                    <div class="dashboard-section inquiries-section">
                        <div class="section-header">
                            <h2>
                                <i class="fas fa-question-circle"></i>
                                <?php _e('ประวัติการสอบถาม', 'ayam-bangkok'); ?>
                            </h2>
                        </div>
                        
                        <div class="inquiries-list">
                            <?php
                            $inquiries = $wpdb->get_results($wpdb->prepare(
                                "SELECT * FROM $inquiries_table 
                                WHERE customer_email = %s 
                                ORDER BY created_at DESC 
                                LIMIT 5",
                                $current_user->user_email
                            ));
                            
                            if ($inquiries) {
                                foreach ($inquiries as $inquiry) {
                                    $status_class = 'status-' . $inquiry->status;
                                    $status_text = $inquiry->status;
                                    ?>
                                    <div class="inquiry-item">
                                        <div class="inquiry-header">
                                            <h4><?php echo esc_html($inquiry->subject); ?></h4>
                                            <span class="status-badge <?php echo $status_class; ?>">
                                                <?php echo esc_html($status_text); ?>
                                            </span>
                                        </div>
                                        <div class="inquiry-meta">
                                            <span class="inquiry-date">
                                                <i class="far fa-calendar"></i>
                                                <?php echo date_i18n('j F Y', strtotime($inquiry->created_at)); ?>
                                            </span>
                                            <span class="inquiry-type">
                                                <i class="far fa-folder"></i>
                                                <?php echo esc_html($inquiry->inquiry_type); ?>
                                            </span>
                                        </div>
                                        <p class="inquiry-message"><?php echo esc_html(wp_trim_words($inquiry->message, 20)); ?></p>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<p class="no-inquiries">' . __('ยังไม่มีประวัติการสอบถาม', 'ayam-bangkok') . '</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="dashboard-section bookings-section">
                        <div class="section-header">
                            <h2>
                                <i class="fas fa-calendar-check"></i>
                                <?php _e('ประวัติการจอง', 'ayam-bangkok'); ?>
                            </h2>
                        </div>
                        
                        <div class="bookings-list">
                            <?php
                            $bookings = $wpdb->get_results($wpdb->prepare(
                                "SELECT * FROM $bookings_table 
                                WHERE customer_email = %s 
                                ORDER BY created_at DESC 
                                LIMIT 5",
                                $current_user->user_email
                            ));
                            
                            if ($bookings) {
                                foreach ($bookings as $booking) {
                                    $status_class = 'status-' . $booking->status;
                                    $status_text = $booking->status;
                                    ?>
                                    <div class="booking-item">
                                        <div class="booking-header">
                                            <h4><?php echo esc_html($booking->service_name); ?></h4>
                                            <span class="status-badge <?php echo $status_class; ?>">
                                                <?php echo esc_html($status_text); ?>
                                            </span>
                                        </div>
                                        <div class="booking-meta">
                                            <span class="booking-date">
                                                <i class="far fa-calendar"></i>
                                                <?php echo date_i18n('j F Y', strtotime($booking->booking_date)); ?>
                                            </span>
                                            <?php if ($booking->booking_time) : ?>
                                                <span class="booking-time">
                                                    <i class="far fa-clock"></i>
                                                    <?php echo esc_html($booking->booking_time); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo '<p class="no-bookings">' . __('ยังไม่มีประวัติการจอง', 'ayam-bangkok') . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                    
                </div>

                <!-- Right Sidebar -->
                <div class="dashboard-sidebar">
                    
                    <!-- Profile Card -->
                    <div class="dashboard-widget profile-widget">
                        <div class="widget-header">
                            <h3><?php _e('ข้อมูลส่วนตัว', 'ayam-bangkok'); ?></h3>
                        </div>
                        <div class="widget-content">
                            <div class="profile-avatar">
                                <?php echo get_avatar($user_id, 80); ?>
                            </div>
                            <div class="profile-info">
                                <h4><?php echo $current_user->display_name; ?></h4>
                                <p class="profile-email"><?php echo $current_user->user_email; ?></p>
                                <?php if ($phone) : ?>
                                    <p class="profile-phone">
                                        <i class="fas fa-phone"></i>
                                        <?php echo esc_html($phone); ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($country) : ?>
                                    <p class="profile-country">
                                        <i class="fas fa-globe"></i>
                                        <?php echo esc_html($country); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo get_edit_profile_url($user_id); ?>" class="btn btn-block btn-secondary">
                                <i class="fas fa-edit"></i>
                                <?php _e('แก้ไขโปรไฟล์', 'ayam-bangkok'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Member Benefits -->
                    <div class="dashboard-widget benefits-widget">
                        <div class="widget-header">
                            <h3><?php _e('สิทธิประโยชน์', 'ayam-bangkok'); ?></h3>
                        </div>
                        <div class="widget-content">
                            <ul class="benefits-list">
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <?php _e('ราคาพิเศษสำหรับสมาชิก', 'ayam-bangkok'); ?>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <?php _e('รับข้อมูลข่าวสารก่อนใคร', 'ayam-bangkok'); ?>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <?php _e('บันทึกรายการโปรด', 'ayam-bangkok'); ?>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <?php _e('บริการส่งออกพิเศษ', 'ayam-bangkok'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="dashboard-widget actions-widget">
                        <div class="widget-header">
                            <h3><?php _e('เมนูด่วน', 'ayam-bangkok'); ?></h3>
                        </div>
                        <div class="widget-content">
                            <nav class="quick-actions">
                                <a href="<?php echo get_post_type_archive_link('ayam_rooster'); ?>" class="action-link">
                                    <i class="fas fa-th-large"></i>
                                    <?php _e('ดูไก่ชนทั้งหมด', 'ayam-bangkok'); ?>
                                </a>
                                <a href="<?php echo get_post_type_archive_link('ayam_service'); ?>" class="action-link">
                                    <i class="fas fa-concierge-bell"></i>
                                    <?php _e('บริการของเรา', 'ayam-bangkok'); ?>
                                </a>
                                <a href="<?php echo get_post_type_archive_link('ayam_news'); ?>" class="action-link">
                                    <i class="fas fa-newspaper"></i>
                                    <?php _e('ข่าวสาร', 'ayam-bangkok'); ?>
                                </a>
                                <a href="<?php echo home_url('/contact'); ?>" class="action-link">
                                    <i class="fas fa-envelope"></i>
                                    <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="dashboard-widget notifications-widget">
                        <div class="widget-header">
                            <h3><?php _e('การแจ้งเตือน', 'ayam-bangkok'); ?></h3>
                        </div>
                        <div class="widget-content">
                            <p class="no-notifications">
                                <?php _e('ไม่มีการแจ้งเตือนใหม่', 'ayam-bangkok'); ?>
                            </p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
