<?php
/**
 * Template for Member Login page
 */

get_header(); ?>

<main id="primary" class="site-main login-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('เข้าสู่ระบบสมาชิก', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('เข้าสู่ระบบเพื่อใช้งานบริการสมาชิกของเรา', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="login-form-section">
        <div class="container">
            <div class="login-wrapper">
                <div class="login-container">
                    <div class="login-header">
                        <h2><?php _e('เข้าสู่ระบบ', 'ayam-bangkok'); ?></h2>
                        <p><?php _e('กรุณากรอกข้อมูลเพื่อเข้าสู่ระบบ', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <form id="member-login-form" class="login-form">
                        <?php wp_nonce_field('ayam_login_nonce', 'login_nonce'); ?>
                        
                        <div class="form-group">
                            <label for="username"><?php _e('ชื่อผู้ใช้หรืออีเมล', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                            <input type="text" id="username" name="username" required>
                            <div class="field-icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password"><?php _e('รหัสผ่าน', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                            <input type="password" id="password" name="password" required>
                            <div class="field-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="password-toggle">
                                <i class="fas fa-eye" id="toggle-password"></i>
                            </div>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="remember" name="remember" value="1">
                                <span class="checkmark"></span>
                                <?php _e('จดจำการเข้าสู่ระบบ', 'ayam-bangkok'); ?>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-login">
                                <span class="btn-text"><?php _e('เข้าสู่ระบบ', 'ayam-bangkok'); ?></span>
                                <span class="btn-loading" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> <?php _e('กำลังเข้าสู่ระบบ...', 'ayam-bangkok'); ?>
                                </span>
                            </button>
                        </div>
                        
                        <div class="form-links">
                            <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-password">
                                <?php _e('ลืมรหัสผ่าน?', 'ayam-bangkok'); ?>
                            </a>
                        </div>
                    </form>
                    
                    <div class="login-footer">
                        <p><?php _e('ยังไม่เป็นสมาชิก?', 'ayam-bangkok'); ?> 
                            <a href="<?php echo home_url('/register/'); ?>" class="register-link">
                                <?php _e('สมัครสมาชิกที่นี่', 'ayam-bangkok'); ?>
                            </a>
                        </p>
                    </div>
                </div>
                
                <!-- Login Benefits -->
                <div class="login-benefits">
                    <h3><?php _e('ประโยชน์ของการเป็นสมาชิก', 'ayam-bangkok'); ?></h3>
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="benefit-content">
                                <h4><?php _e('ราคาพิเศษ', 'ayam-bangkok'); ?></h4>
                                <p><?php _e('รับส่วนลดพิเศษสำหรับสมาชิก', 'ayam-bangkok'); ?></p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="benefit-content">
                                <h4><?php _e('จองคิวล่วงหน้า', 'ayam-bangkok'); ?></h4>
                                <p><?php _e('จองคิวและบริการล่วงหน้าได้', 'ayam-bangkok'); ?></p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="benefit-content">
                                <h4><?php _e('ข้อมูลเฉพาะ', 'ayam-bangkok'); ?></h4>
                                <p><?php _e('เข้าถึงข้อมูลไก่ชนโดยละเอียด', 'ayam-bangkok'); ?></p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="benefit-content">
                                <h4><?php _e('บริการลูกค้า', 'ayam-bangkok'); ?></h4>
                                <p><?php _e('รับการดูแลแบบพิเศษจากทีมงาน', 'ayam-bangkok'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Success/Error Messages -->
    <div id="login-messages" class="messages-container" style="display: none;">
        <div class="message-content">
            <span class="message-text"></span>
            <button class="message-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

</main>

<?php get_footer(); ?>