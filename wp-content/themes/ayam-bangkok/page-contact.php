<?php
/**
 * Template Name: Contact Us
 * Description: หน้าติดต่อเรา
 */

get_header();

// Get company information
$company_name = get_field('company_name', 'option') ?: 'หนองจอก เอฟซีไอ';
$company_address = get_field('company_address', 'option') ?: 'หนองจอก กรุงเทพมหานคร ประเทศไทย';
$company_phone = get_theme_mod('ayam_phone', '');
$company_email = get_theme_mod('ayam_email', '');
$company_line = get_theme_mod('ayam_line_id', '');
$company_facebook = get_theme_mod('ayam_facebook', '');
$company_youtube = get_theme_mod('ayam_youtube', '');
$google_maps_url = get_field('google_maps_url', 'option');
$google_maps_embed = get_field('google_maps_embed', 'option');

// Business hours
$business_hours = get_field('business_hours', 'option') ?: array(
    array('day' => 'จันทร์ - ศุกร์', 'hours' => '08:00 - 17:00'),
    array('day' => 'เสาร์', 'hours' => '08:00 - 12:00'),
    array('day' => 'อาทิตย์', 'hours' => 'ปิดทำการ')
);
?>

<main id="primary" class="site-main contact-page">
    
    <!-- Page Header -->
    <section class="page-header contact-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ติดต่อเรา', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('เรายินดีให้บริการและตอบคำถามของคุณ', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="contact-info-section">
        <div class="container">
            <div class="contact-info-grid">
                
                <div class="info-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3><?php _e('ที่อยู่', 'ayam-bangkok'); ?></h3>
                    <p><?php echo esc_html($company_address); ?></p>
                    <?php if ($google_maps_url) : ?>
                        <a href="<?php echo esc_url($google_maps_url); ?>" target="_blank" class="info-link">
                            <?php _e('ดูแผนที่', 'ayam-bangkok'); ?>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3><?php _e('โทรศัพท์', 'ayam-bangkok'); ?></h3>
                    <?php if ($company_phone) : ?>
                        <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $company_phone)); ?>"><?php echo esc_html($company_phone); ?></a></p>
                    <?php endif; ?>
                    <?php if ($company_line) : ?>
                        <p class="line-id">
                            <i class="fab fa-line"></i>
                            LINE: <?php echo esc_html($company_line); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="info-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3><?php _e('อีเมล', 'ayam-bangkok'); ?></h3>
                    <?php if ($company_email) : ?>
                        <p><a href="mailto:<?php echo esc_attr($company_email); ?>"><?php echo esc_html($company_email); ?></a></p>
                    <?php endif; ?>
                    <div class="social-links">
                        <?php if ($company_facebook) : ?>
                            <a href="<?php echo esc_url($company_facebook); ?>" target="_blank" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($company_youtube) : ?>
                            <a href="<?php echo esc_url($company_youtube); ?>" target="_blank" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3><?php _e('เวลาทำการ', 'ayam-bangkok'); ?></h3>
                    <?php if ($business_hours) : ?>
                        <div class="business-hours">
                            <?php foreach ($business_hours as $hours) : ?>
                                <div class="hours-row">
                                    <span class="day"><?php echo esc_html($hours['day']); ?></span>
                                    <span class="time"><?php echo esc_html($hours['hours']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-grid">
                
                <!-- Contact Form -->
                <div class="contact-form-wrapper" data-aos="fade-right">
                    <div class="form-header">
                        <h2><?php _e('ส่งข้อความถึงเรา', 'ayam-bangkok'); ?></h2>
                        <p><?php _e('กรอกแบบฟอร์มด้านล่าง เราจะติดต่อกลับโดยเร็วที่สุด', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <form id="contact-form" class="contact-form">
                        <?php wp_nonce_field('contact_form', 'contact_nonce'); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_name">
                                    <?php _e('ชื่อ-นามสกุล', 'ayam-bangkok'); ?>
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="contact_name" name="contact_name" required>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_email">
                                    <?php _e('อีเมล', 'ayam-bangkok'); ?>
                                    <span class="required">*</span>
                                </label>
                                <input type="email" id="contact_email" name="contact_email" required>
                                <div class="error-message"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_phone">
                                    <?php _e('เบอร์โทรศัพท์', 'ayam-bangkok'); ?>
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone">
                                <div class="error-message"></div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_subject">
                                    <?php _e('หัวข้อ', 'ayam-bangkok'); ?>
                                    <span class="required">*</span>
                                </label>
                                <select id="contact_subject" name="contact_subject" required>
                                    <option value=""><?php _e('เลือกหัวข้อ', 'ayam-bangkok'); ?></option>
                                    <option value="general"><?php _e('สอบถามทั่วไป', 'ayam-bangkok'); ?></option>
                                    <option value="rooster"><?php _e('สอบถามเกี่ยวกับไก่ชน', 'ayam-bangkok'); ?></option>
                                    <option value="service"><?php _e('สอบถามบริการ', 'ayam-bangkok'); ?></option>
                                    <option value="export"><?php _e('สอบถามการส่งออก', 'ayam-bangkok'); ?></option>
                                    <option value="visit"><?php _e('นัดหมายเยี่ยมชม', 'ayam-bangkok'); ?></option>
                                    <option value="other"><?php _e('อื่นๆ', 'ayam-bangkok'); ?></option>
                                </select>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_message">
                                    <?php _e('ข้อความ', 'ayam-bangkok'); ?>
                                    <span class="required">*</span>
                                </label>
                                <textarea id="contact_message" name="contact_message" rows="6" required></textarea>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        
                        <!-- Visit Date (conditional) -->
                        <div class="form-row visit-date-row" style="display: none;">
                            <div class="form-group">
                                <label for="visit_date">
                                    <?php _e('วันที่ต้องการเยี่ยมชม', 'ayam-bangkok'); ?>
                                </label>
                                <input type="date" id="visit_date" name="visit_date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                <small class="form-help"><?php _e('กรุณาเลือกวันล่วงหน้าอย่างน้อย 1 วัน', 'ayam-bangkok'); ?></small>
                            </div>
                            
                            <div class="form-group">
                                <label for="visit_time">
                                    <?php _e('เวลาที่ต้องการ', 'ayam-bangkok'); ?>
                                </label>
                                <select id="visit_time" name="visit_time">
                                    <option value=""><?php _e('เลือกเวลา', 'ayam-bangkok'); ?></option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                    <option value="16:00">16:00</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="fas fa-paper-plane"></i>
                                <?php _e('ส่งข้อความ', 'ayam-bangkok'); ?>
                            </button>
                        </div>
                        
                        <div class="form-response" style="display: none;"></div>
                    </form>
                </div>
                
                <!-- Map -->
                <div class="map-wrapper" data-aos="fade-left">
                    <?php if ($google_maps_embed) : ?>
                        <div class="google-map">
                            <?php echo $google_maps_embed; ?>
                        </div>
                    <?php else : ?>
                        <div class="map-placeholder">
                            <i class="fas fa-map-marked-alt"></i>
                            <p><?php _e('แผนที่จะแสดงที่นี่', 'ayam-bangkok'); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="map-info">
                        <h3><?php echo esc_html($company_name); ?></h3>
                        <p><?php echo esc_html($company_address); ?></p>
                        <?php if ($google_maps_url) : ?>
                            <a href="<?php echo esc_url($google_maps_url); ?>" target="_blank" class="btn btn-secondary">
                                <i class="fas fa-directions"></i>
                                <?php _e('เปิดใน Google Maps', 'ayam-bangkok'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('คำถามที่พบบ่อย', 'ayam-bangkok'); ?></h2>
                <p><?php _e('คำตอบสำหรับคำถามที่ลูกค้าถามบ่อยที่สุด', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="faq-grid">
                <?php
                $faqs = array(
                    array(
                        'question' => 'ไก่ชนของท่านมีการรับประกันหรือไม่?',
                        'answer' => 'เรามีการรับประกันคุณภาพไก่ชนทุกตัว พร้อมใบรับรองสุขภาพและประวัติการเลี้ยงดูที่ชัดเจน หากมีปัญหาภายใน 7 วันสามารถติดต่อเราได้ทันที'
                    ),
                    array(
                        'question' => 'มีบริการจัดส่งไก่ชนหรือไม่?',
                        'answer' => 'มีบริการจัดส่งทั้งในประเทศและต่างประเทศ โดยเฉพาะการส่งออกไปอินโดนีเซีย เรามีทีมงานมืออาชีพดูแลตลอดกระบวนการ'
                    ),
                    array(
                        'question' => 'สามารถเยี่ยมชมฟาร์มได้หรือไม่?',
                        'answer' => 'สามารถเยี่ยมชมได้ แต่ขอให้นัดหมายล่วงหน้าอย่างน้อย 1 วัน เพื่อให้เราเตรียมการต้อนรับและให้ข้อมูลที่ดีที่สุด'
                    ),
                    array(
                        'question' => 'มีบริการฝึกไก่ชนหรือไม่?',
                        'answer' => 'มีบริการฝึกไก่ชนโดยผู้เชี่ยวชาญ ทั้งแบบรายวันและแบบแพ็กเกจ สามารถสอบถามรายละเอียดเพิ่มเติมได้'
                    ),
                    array(
                        'question' => 'ราคาไก่ชนเริ่มต้นที่เท่าไหร่?',
                        'answer' => 'ราคาขึ้นอยู่กับสายพันธุ์ อายุ และคุณภาพของไก่ชน เริ่มต้นตั้งแต่หลักพันถึงหลักแสน สามารถดูรายละเอียดในหน้าแกลเลอรี่'
                    ),
                    array(
                        'question' => 'มีบริการหลังการขายหรือไม่?',
                        'answer' => 'มีบริการให้คำปรึกษาและดูแลหลังการขาย รวมถึงคำแนะนำการเลี้ยงดู อาหาร และการฝึก สามารถติดต่อได้ตลอดเวลา'
                    )
                );
                
                foreach ($faqs as $index => $faq) :
                ?>
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                        <div class="faq-question">
                            <h3><?php echo esc_html($faq['question']); ?></h3>
                            <button class="faq-toggle">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="faq-answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="contact-cta-section">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2><?php _e('ยังมีคำถามอยู่หรือไม่?', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ทีมงานของเรายินดีให้คำปรึกษาและตอบคำถามทุกข้อสงสัย', 'ayam-bangkok'); ?></p>
                <div class="cta-buttons">
                    <?php if ($company_phone) : ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $company_phone)); ?>" class="btn btn-primary">
                            <i class="fas fa-phone"></i>
                            <?php _e('โทรหาเรา', 'ayam-bangkok'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($company_line) : ?>
                        <a href="https://line.me/ti/p/~<?php echo esc_attr($company_line); ?>" target="_blank" class="btn btn-success">
                            <i class="fab fa-line"></i>
                            <?php _e('แชทผ่าน LINE', 'ayam-bangkok'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
