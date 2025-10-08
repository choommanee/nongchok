<?php
/**
 * Template Name: Member Registration
 * Description: หน้าสมัครสมาชิก
 */

// Redirect if already logged in
if (is_user_logged_in()) {
    wp_redirect(home_url('/member-dashboard/'));
    exit;
}

get_header(); ?>

<main id="primary" class="site-main member-registration-page">
    
    <!-- Page Header -->
    <section class="page-header registration-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('สมัครสมาชิก', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('สมัครสมาชิกเพื่อรับสิทธิพิเศษและติดตามข้อมูลไก่ชน', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Registration Form -->
    <section class="registration-form-section">
        <div class="container">
            <div class="registration-wrapper">
                <!-- Benefits Sidebar -->
                <div class="registration-benefits">
                    <h3><?php _e('สิทธิประโยชน์สมาชิก', 'ayam-bangkok'); ?></h3>
                    
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
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="benefit-content">
                            <h4><?php _e('แจ้งเตือนไก่ใหม่', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('รับการแจ้งเตือนเมื่อมีไก่ชนใหม่', 'ayam-bangkok'); ?></p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="benefit-content">
                            <h4><?php _e('รายการโปรด', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('บันทึกไก่ชนที่สนใจไว้ดูภายหลัง', 'ayam-bangkok'); ?></p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="benefit-content">
                            <h4><?php _e('ประวัติการสอบถาม', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('ติดตามสถานะการสอบถามและจอง', 'ayam-bangkok'); ?></p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="benefit-content">
                            <h4><?php _e('ติดตามการส่งออก', 'ayam-bangkok'); ?></h4>
                            <p><?php _e('ติดตามสถานะการส่งออกแบบ real-time', 'ayam-bangkok'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <div class="registration-form-container">
                    <!-- Progress Steps -->
                    <div class="registration-steps">
                        <div class="step active" data-step="1">
                            <div class="step-number">1</div>
                            <div class="step-label"><?php _e('ข้อมูลพื้นฐาน', 'ayam-bangkok'); ?></div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-number">2</div>
                            <div class="step-label"><?php _e('ข้อมูลติดต่อ', 'ayam-bangkok'); ?></div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-number">3</div>
                            <div class="step-label"><?php _e('ยืนยันข้อมูล', 'ayam-bangkok'); ?></div>
                        </div>
                    </div>

                    <form id="member-registration-form" class="registration-form">
                        <?php wp_nonce_field('member_registration', 'registration_nonce'); ?>
                        
                        <!-- Step 1: Basic Information -->
                        <div class="form-step active" data-step="1">
                            <h3><?php _e('ข้อมูลพื้นฐาน', 'ayam-bangkok'); ?></h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name"><?php _e('ชื่อ', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="text" id="first_name" name="first_name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="last_name"><?php _e('นามสกุล', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="text" id="last_name" name="last_name" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="username"><?php _e('ชื่อผู้ใช้', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                <input type="text" id="username" name="username" required>
                                <small class="form-hint"><?php _e('ใช้สำหรับเข้าสู่ระบบ (ภาษาอังกฤษและตัวเลขเท่านั้น)', 'ayam-bangkok'); ?></small>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password"><?php _e('รหัสผ่าน', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password" name="password" required>
                                        <button type="button" class="toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="form-hint"><?php _e('อย่างน้อย 8 ตัวอักษร', 'ayam-bangkok'); ?></small>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password"><?php _e('ยืนยันรหัสผ่าน', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary btn-next">
                                    <?php _e('ถัดไป', 'ayam-bangkok'); ?>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Contact Information -->
                        <div class="form-step" data-step="2">
                            <h3><?php _e('ข้อมูลติดต่อ', 'ayam-bangkok'); ?></h3>
                            
                            <div class="form-group">
                                <label for="email"><?php _e('อีเมล', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone"><?php _e('เบอร์โทรศัพท์', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="line_id"><?php _e('Line ID', 'ayam-bangkok'); ?></label>
                                    <input type="text" id="line_id" name="line_id">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="country"><?php _e('ประเทศ', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <select id="country" name="country" required>
                                        <option value=""><?php _e('เลือกประเทศ', 'ayam-bangkok'); ?></option>
                                        <option value="thailand"><?php _e('ประเทศไทย', 'ayam-bangkok'); ?></option>
                                        <option value="indonesia"><?php _e('อินโดนีเซีย', 'ayam-bangkok'); ?></option>
                                        <option value="malaysia"><?php _e('มาเลเซีย', 'ayam-bangkok'); ?></option>
                                        <option value="singapore"><?php _e('สิงคโปร์', 'ayam-bangkok'); ?></option>
                                        <option value="other"><?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="business_type"><?php _e('ประเภทธุรกิจ', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <select id="business_type" name="business_type" required>
                                        <option value=""><?php _e('เลือกประเภท', 'ayam-bangkok'); ?></option>
                                        <option value="farm"><?php _e('ฟาร์มเลี้ยงไก่', 'ayam-bangkok'); ?></option>
                                        <option value="trader"><?php _e('ผู้ค้า/นายหน้า', 'ayam-bangkok'); ?></option>
                                        <option value="breeder"><?php _e('ผู้เพาะพันธุ์', 'ayam-bangkok'); ?></option>
                                        <option value="hobbyist"><?php _e('ผู้สะสม/งานอดิเรก', 'ayam-bangkok'); ?></option>
                                        <option value="other"><?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="company_name"><?php _e('ชื่อบริษัท/ฟาร์ม', 'ayam-bangkok'); ?></label>
                                <input type="text" id="company_name" name="company_name">
                                <small class="form-hint"><?php _e('ถ้ามี', 'ayam-bangkok'); ?></small>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline btn-prev">
                                    <i class="fas fa-arrow-left"></i>
                                    <?php _e('ย้อนกลับ', 'ayam-bangkok'); ?>
                                </button>
                                <button type="button" class="btn btn-primary btn-next">
                                    <?php _e('ถัดไป', 'ayam-bangkok'); ?>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Confirmation -->
                        <div class="form-step" data-step="3">
                            <h3><?php _e('ยืนยันข้อมูล', 'ayam-bangkok'); ?></h3>
                            
                            <div class="confirmation-summary">
                                <div class="summary-section">
                                    <h4><?php _e('ข้อมูลพื้นฐาน', 'ayam-bangkok'); ?></h4>
                                    <div class="summary-item">
                                        <span class="label"><?php _e('ชื่อ-นามสกุล:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-name"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label"><?php _e('ชื่อผู้ใช้:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-username"></span>
                                    </div>
                                </div>
                                
                                <div class="summary-section">
                                    <h4><?php _e('ข้อมูลติดต่อ', 'ayam-bangkok'); ?></h4>
                                    <div class="summary-item">
                                        <span class="label"><?php _e('อีเมล:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-email"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label"><?php _e('เบอร์โทร:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-phone"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label"><?php _e('ประเทศ:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-country"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label"><?php _e('ประเภทธุรกิจ:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-business"></span>
                                    </div>
                                    <div class="summary-item" id="confirm-company-wrapper" style="display: none;">
                                        <span class="label"><?php _e('บริษัท/ฟาร์ม:', 'ayam-bangkok'); ?></span>
                                        <span class="value" id="confirm-company"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="accept_terms" name="accept_terms" required>
                                    <span><?php _e('ฉันยอมรับ', 'ayam-bangkok'); ?> <a href="<?php echo home_url('/terms/'); ?>" target="_blank"><?php _e('ข้อกำหนดและเงื่อนไข', 'ayam-bangkok'); ?></a></span>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="accept_newsletter" name="accept_newsletter">
                                    <span><?php _e('รับข่าวสารและโปรโมชั่นพิเศษทางอีเมล', 'ayam-bangkok'); ?></span>
                                </label>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-outline btn-prev">
                                    <i class="fas fa-arrow-left"></i>
                                    <?php _e('ย้อนกลับ', 'ayam-bangkok'); ?>
                                </button>
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="fas fa-check"></i>
                                    <?php _e('สมัครสมาชิก', 'ayam-bangkok'); ?>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Already Member -->
                    <div class="already-member">
                        <p>
                            <?php _e('เป็นสมาชิกอยู่แล้ว?', 'ayam-bangkok'); ?>
                            <a href="<?php echo wp_login_url(); ?>"><?php _e('เข้าสู่ระบบ', 'ayam-bangkok'); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
