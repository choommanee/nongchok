<?php
/**
 * Template for Member Profile page
 */

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login/'));
    exit;
}

$current_user = wp_get_current_user();
$user_meta = get_user_meta($current_user->ID);

get_header(); ?>

<main id="primary" class="site-main profile-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('โปรไฟล์สมาชิก', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php printf(__('ยินดีต้อนรับ, %s', 'ayam-bangkok'), $current_user->display_name); ?></p>
            </div>
        </div>
    </section>

    <!-- Profile Content -->
    <section class="profile-content-section">
        <div class="container">
            <div class="profile-wrapper">
                
                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        <?php echo get_avatar($current_user->ID, 120); ?>
                        <h3><?php echo esc_html($current_user->display_name); ?></h3>
                        <p class="member-since"><?php printf(__('สมาชิกตั้งแต่: %s', 'ayam-bangkok'), date_i18n('F Y', strtotime($current_user->user_registered))); ?></p>
                    </div>
                    
                    <nav class="profile-nav">
                        <ul>
                            <li><a href="#profile-info" class="nav-link active" data-tab="profile-info">
                                <i class="fas fa-user"></i> <?php _e('ข้อมูลส่วนตัว', 'ayam-bangkok'); ?>
                            </a></li>
                            <li><a href="#change-password" class="nav-link" data-tab="change-password">
                                <i class="fas fa-lock"></i> <?php _e('เปลี่ยนรหัสผ่าน', 'ayam-bangkok'); ?>
                            </a></li>
                            <li><a href="#order-history" class="nav-link" data-tab="order-history">
                                <i class="fas fa-history"></i> <?php _e('ประวัติการสั่งซื้อ', 'ayam-bangkok'); ?>
                            </a></li>
                            <li><a href="#favorites" class="nav-link" data-tab="favorites">
                                <i class="fas fa-heart"></i> <?php _e('รายการโปรด', 'ayam-bangkok'); ?>
                            </a></li>
                            <li><a href="<?php echo wp_logout_url(home_url()); ?>" class="nav-link logout">
                                <i class="fas fa-sign-out-alt"></i> <?php _e('ออกจากระบบ', 'ayam-bangkok'); ?>
                            </a></li>
                        </ul>
                    </nav>
                </div>
                
                <!-- Profile Content -->
                <div class="profile-main">
                    
                    <!-- Profile Information Tab -->
                    <div id="profile-info" class="tab-content active">
                        <div class="tab-header">
                            <h2><?php _e('ข้อมูลส่วนตัว', 'ayam-bangkok'); ?></h2>
                            <p><?php _e('จัดการข้อมูลส่วนตัวของคุณ', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <form id="profile-form" class="profile-form">
                            <?php wp_nonce_field('update_profile', 'profile_nonce'); ?>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name"><?php _e('ชื่อ', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($current_user->first_name); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name"><?php _e('นามสกุล', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($current_user->last_name); ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="display_name"><?php _e('ชื่อที่แสดง', 'ayam-bangkok'); ?></label>
                                <input type="text" id="display_name" name="display_name" value="<?php echo esc_attr($current_user->display_name); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="user_email"><?php _e('อีเมล', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                <input type="email" id="user_email" name="user_email" value="<?php echo esc_attr($current_user->user_email); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone"><?php _e('เบอร์โทรศัพท์', 'ayam-bangkok'); ?></label>
                                <input type="tel" id="phone" name="phone" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'phone', true)); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="address"><?php _e('ที่อยู่', 'ayam-bangkok'); ?></label>
                                <textarea id="address" name="address" rows="3"><?php echo esc_textarea(get_user_meta($current_user->ID, 'address', true)); ?></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city"><?php _e('เมือง/จังหวัด', 'ayam-bangkok'); ?></label>
                                    <input type="text" id="city" name="city" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'city', true)); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="postal_code"><?php _e('รหัสไปรษณีย์', 'ayam-bangkok'); ?></label>
                                    <input type="text" id="postal_code" name="postal_code" value="<?php echo esc_attr(get_user_meta($current_user->ID, 'postal_code', true)); ?>">
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> <?php _e('บันทึกข้อมูล', 'ayam-bangkok'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Change Password Tab -->
                    <div id="change-password" class="tab-content">
                        <div class="tab-header">
                            <h2><?php _e('เปลี่ยนรหัสผ่าน', 'ayam-bangkok'); ?></h2>
                            <p><?php _e('เปลี่ยนรหัสผ่านเพื่อความปลอดภัยของบัญชี', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <form id="password-form" class="profile-form">
                            <?php wp_nonce_field('change_password', 'password_nonce'); ?>
                            
                            <div class="form-group">
                                <label for="current_password"><?php _e('รหัสผ่านปัจจุบัน', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                <div class="password-input">
                                    <input type="password" id="current_password" name="current_password" required>
                                    <button type="button" class="toggle-password" data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password"><?php _e('รหัสผ่านใหม่', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                <div class="password-input">
                                    <input type="password" id="new_password" name="new_password" required>
                                    <button type="button" class="toggle-password" data-target="new_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength">
                                    <div class="strength-meter">
                                        <div class="strength-bar"></div>
                                    </div>
                                    <span class="strength-text"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirm_password"><?php _e('ยืนยันรหัสผ่านใหม่', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                <div class="password-input">
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                    <button type="button" class="toggle-password" data-target="confirm_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key"></i> <?php _e('เปลี่ยนรหัสผ่าน', 'ayam-bangkok'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Order History Tab -->
                    <div id="order-history" class="tab-content">
                        <div class="tab-header">
                            <h2><?php _e('ประวัติการสั่งซื้อ', 'ayam-bangkok'); ?></h2>
                            <p><?php _e('ดูประวัติการสั่งซื้อและสถานะของคำสั่งซื้อ', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <div class="order-history-content">
                            <div class="order-filters">
                                <select id="order-status-filter">
                                    <option value=""><?php _e('ทุกสถานะ', 'ayam-bangkok'); ?></option>
                                    <option value="pending"><?php _e('รอดำเนินการ', 'ayam-bangkok'); ?></option>
                                    <option value="processing"><?php _e('กำลังดำเนินการ', 'ayam-bangkok'); ?></option>
                                    <option value="shipped"><?php _e('จัดส่งแล้ว', 'ayam-bangkok'); ?></option>
                                    <option value="completed"><?php _e('เสร็จสิ้น', 'ayam-bangkok'); ?></option>
                                    <option value="cancelled"><?php _e('ยกเลิก', 'ayam-bangkok'); ?></option>
                                </select>
                            </div>
                            
                            <div class="orders-list">
                                <div class="no-orders">
                                    <i class="fas fa-shopping-cart"></i>
                                    <h3><?php _e('ยังไม่มีประวัติการสั่งซื้อ', 'ayam-bangkok'); ?></h3>
                                    <p><?php _e('เมื่อคุณทำการสั่งซื้อสินค้า ประวัติจะแสดงที่นี่', 'ayam-bangkok'); ?></p>
                                    <a href="<?php echo home_url('/catalog/'); ?>" class="btn btn-primary">
                                        <?php _e('เริ่มช้อปปิ้ง', 'ayam-bangkok'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Favorites Tab -->
                    <div id="favorites" class="tab-content">
                        <div class="tab-header">
                            <h2><?php _e('รายการโปรด', 'ayam-bangkok'); ?></h2>
                            <p><?php _e('ไก่ชนที่คุณสนใจและบันทึกไว้', 'ayam-bangkok'); ?></p>
                        </div>
                        
                        <div class="favorites-content">
                            <div class="favorites-list">
                                <div class="no-favorites">
                                    <i class="fas fa-heart"></i>
                                    <h3><?php _e('ยังไม่มีรายการโปรด', 'ayam-bangkok'); ?></h3>
                                    <p><?php _e('คลิกไอคอนหัวใจในหน้าแคตตาล็อกเพื่อเพิ่มไก่ชนที่คุณชอบ', 'ayam-bangkok'); ?></p>
                                    <a href="<?php echo home_url('/catalog/'); ?>" class="btn btn-primary">
                                        <?php _e('ดูแคตตาล็อก', 'ayam-bangkok'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- Success/Error Messages -->
    <div id="profile-messages" class="profile-messages"></div>
    
</main><!-- #primary -->

<?php get_footer(); ?>