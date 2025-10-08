<?php
/**
 * Template for Member Registration page
 */

get_header(); ?>

<main id="primary" class="site-main register-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('สมัครสมาชิก', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('เข้าร่วมเป็นสมาชิกของ Ayam Bangkok เพื่อรับสิทธิประโยชน์พิเศษ', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Registration Form Section -->
    <section class="registration-section">
        <div class="container">
            <div class="registration-wrapper">
                
                <!-- Membership Types -->
                <div class="membership-types">
                    <h2><?php _e('เลือกประเภทสมาชิก', 'ayam-bangkok'); ?></h2>
                    <div class="membership-cards">
                        
                        <!-- Regular Member -->
                        <div class="membership-card" data-type="regular">
                            <div class="card-header">
                                <h3><?php _e('สมาชิกทั่วไป', 'ayam-bangkok'); ?></h3>
                                <div class="price"><?php _e('ฟรี', 'ayam-bangkok'); ?></div>
                            </div>
                            <div class="card-body">
                                <ul class="benefits-list">
                                    <li><i class="fas fa-check"></i> <?php _e('ดูแคตตาล็อกไก่ชน', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('ส่งคำถามและสอบถาม', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('จองบริการพื้นฐาน', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('รับข่าวสารและอัปเดต', 'ayam-bangkok'); ?></li>
                                </ul>
                                <button class="btn btn-outline select-membership" data-type="regular">
                                    <?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Premium Member -->
                        <div class="membership-card premium" data-type="premium">
                            <div class="card-header">
                                <h3><?php _e('สมาชิกพิเศษ', 'ayam-bangkok'); ?></h3>
                                <div class="price"><?php _e('฿2,500/ปี', 'ayam-bangkok'); ?></div>
                                <div class="badge"><?php _e('แนะนำ', 'ayam-bangkok'); ?></div>
                            </div>
                            <div class="card-body">
                                <ul class="benefits-list">
                                    <li><i class="fas fa-check"></i> <?php _e('สิทธิประโยชน์สมาชิกทั่วไป', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('ดูข้อมูลไก่ชนแบบละเอียด', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('ราคาพิเศษสำหรับสมาชิก', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('จองบริการล่วงหน้า', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('ติดต่อโดยตรงกับผู้เชี่ยวชาญ', 'ayam-bangkok'); ?></li>
                                    <li><i class="fas fa-check"></i> <?php _e('เข้าถึงเนื้อหาพิเศษ', 'ayam-bangkok'); ?></li>
                                </ul>
                                <button class="btn btn-primary select-membership" data-type="premium">
                                    <?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Registration Form -->
                <div class="registration-form-wrapper" id="registrationForm" style="display: none;">
                    <h2><?php _e('ข้อมูลการสมัครสมาชิก', 'ayam-bangkok'); ?></h2>
                    
                    <form id="memberRegistrationForm" class="member-registration-form" method="post">
                        <?php wp_nonce_field('ayam_member_registration', 'registration_nonce'); ?>
                        
                        <input type="hidden" id="membershipType" name="membership_type" value="">
                        
                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3><?php _e('ข้อมูลส่วนตัว', 'ayam-bangkok'); ?></h3>
                            
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
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="username"><?php _e('ชื่อผู้ใช้', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="text" id="username" name="username" required>
                                    <small class="form-text"><?php _e('ใช้สำหรับเข้าสู่ระบบ (ภาษาอังกฤษและตัวเลขเท่านั้น)', 'ayam-bangkok'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="email"><?php _e('อีเมล', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password"><?php _e('รหัสผ่าน', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="password" id="password" name="password" required>
                                    <small class="form-text"><?php _e('อย่างน้อย 8 ตัวอักษร', 'ayam-bangkok'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password"><?php _e('ยืนยันรหัสผ่าน', 'ayam-bangkok'); ?> <span class="required">*</span></label>
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="form-section">
                            <h3><?php _e('ข้อมูลการติดต่อ', 'ayam-bangkok'); ?></h3>
                            
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
                            
                            <div class="form-group">
                                <label for="address"><?php _e('ที่อยู่', 'ayam-bangkok'); ?></label>
                                <textarea id="address" name="address" rows="3"></textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city"><?php _e('เมือง/จังหวัด', 'ayam-bangkok'); ?></label>
                                    <input type="text" id="city" name="city">
                                </div>
                                <div class="form-group">
                                    <label for="country"><?php _e('ประเทศ', 'ayam-bangkok'); ?></label>
                                    <select id="country" name="country">
                                        <option value=""><?php _e('เลือกประเทศ', 'ayam-bangkok'); ?></option>
                                        <option value="TH"><?php _e('ประเทศไทย', 'ayam-bangkok'); ?></option>
                                        <option value="ID"><?php _e('อินโดนีเซีย', 'ayam-bangkok'); ?></option>
                                        <option value="MY"><?php _e('มาเลเซีย', 'ayam-bangkok'); ?></option>
                                        <option value="SG"><?php _e('สิงคโปร์', 'ayam-bangkok'); ?></option>
                                        <option value="other"><?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Business Information (for Premium Members) -->
                        <div class="form-section business-info" id="businessInfo" style="display: none;">
                            <h3><?php _e('ข้อมูลธุรกิจ', 'ayam-bangkok'); ?></h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="company_name"><?php _e('ชื่อบริษัท/ร้านค้า', 'ayam-bangkok'); ?></label>
                                    <input type="text" id="company_name" name="company_name">
                                </div>
                                <div class="form-group">
                                    <label for="business_type"><?php _e('ประเภทธุรกิจ', 'ayam-bangkok'); ?></label>
                                    <select id="business_type" name="business_type">
                                        <option value=""><?php _e('เลือกประเภทธุรกิจ', 'ayam-bangkok'); ?></option>
                                        <option value="breeder"><?php _e('ผู้เพาะพันธุ์ไก่ชน', 'ayam-bangkok'); ?></option>
                                        <option value="trader"><?php _e('ผู้ค้าไก่ชน', 'ayam-bangkok'); ?></option>
                                        <option value="exporter"><?php _e('ผู้ส่งออก', 'ayam-bangkok'); ?></option>
                                        <option value="importer"><?php _e('ผู้นำเข้า', 'ayam-bangkok'); ?></option>
                                        <option value="other"><?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="business_experience"><?php _e('ประสบการณ์ในธุรกิจไก่ชน', 'ayam-bangkok'); ?></label>
                                <select id="business_experience" name="business_experience">
                                    <option value=""><?php _e('เลือกประสบการณ์', 'ayam-bangkok'); ?></option>
                                    <option value="beginner"><?php _e('เริ่มต้น (น้อยกว่า 1 ปี)', 'ayam-bangkok'); ?></option>
                                    <option value="intermediate"><?php _e('ปานกลาง (1-5 ปี)', 'ayam-bangkok'); ?></option>
                                    <option value="experienced"><?php _e('มีประสบการณ์ (5-10 ปี)', 'ayam-bangkok'); ?></option>
                                    <option value="expert"><?php _e('ผู้เชี่ยวชาญ (มากกว่า 10 ปี)', 'ayam-bangkok'); ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="form-section">
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="agree_terms" name="agree_terms" required>
                                    <span class="checkmark"></span>
                                    <?php _e('ฉันยอมรับ', 'ayam-bangkok'); ?> 
                                    <a href="#" class="terms-link"><?php _e('ข้อกำหนดและเงื่อนไข', 'ayam-bangkok'); ?></a> 
                                    <?php _e('และ', 'ayam-bangkok'); ?> 
                                    <a href="#" class="privacy-link"><?php _e('นโยบายความเป็นส่วนตัว', 'ayam-bangkok'); ?></a>
                                </label>
                            </div>
                            
                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="newsletter" name="newsletter">
                                    <span class="checkmark"></span>
                                    <?php _e('ฉันต้องการรับข่าวสารและข้อเสนอพิเศษทางอีเมล', 'ayam-bangkok'); ?>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-large" id="submitRegistration">
                                <span class="btn-text"><?php _e('สมัครสมาชิก', 'ayam-bangkok'); ?></span>
                                <span class="btn-loading" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> <?php _e('กำลังดำเนินการ...', 'ayam-bangkok'); ?>
                                </span>
                            </button>
                            
                            <p class="login-link">
                                <?php _e('มีบัญชีอยู่แล้ว?', 'ayam-bangkok'); ?> 
                                <a href="<?php echo wp_login_url(); ?>"><?php _e('เข้าสู่ระบบ', 'ayam-bangkok'); ?></a>
                            </p>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="member-features-section">
        <div class="container">
            <h2><?php _e('ทำไมต้องเป็นสมาชิกกับเรา', 'ayam-bangkok'); ?></h2>
            <div class="features-grid">
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3><?php _e('ความปลอดภัย', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ข้อมูลของคุณได้รับการปกป้องด้วยระบบความปลอดภัยระดับสูง', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3><?php _e('การสนับสนุน 24/7', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ทีมงานผู้เชี่ยวชาญพร้อมให้คำปรึกษาตลอด 24 ชั่วโมง', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3><?php _e('คุณภาพระดับพรีเมียม', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ไก่ชนคุณภาพสูงที่ผ่านการคัดเลือกอย่างเข้มงวด', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3><?php _e('การส่งมอบรวดเร็ว', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ระบบขนส่งที่เชื่อถือได้และรวดเร็วทั่วเอเชียตะวันออกเฉียงใต้', 'ayam-bangkok'); ?></p>
                </div>
                
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>