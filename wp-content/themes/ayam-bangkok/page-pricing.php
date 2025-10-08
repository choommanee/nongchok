<?php
/**
 * Template for Pricing page
 */

get_header(); ?>

<main id="primary" class="site-main pricing-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ราคาและแพ็กเกจ', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('แพ็กเกจบริการและราคาสำหรับการส่งออกไก่ชน', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Pricing Calculator Section -->
    <section class="pricing-calculator-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('เครื่องคำนวณราคา', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('คำนวณราคาการส่งออกไก่ชนตามความต้องการของคุณ', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="calculator-container">
                <form id="pricing-calculator" class="pricing-form">
                    <div class="calculator-inputs">
                        <div class="input-group">
                            <label for="rooster-count"><?php _e('จำนวนไก่ชน', 'ayam-bangkok'); ?></label>
                            <input type="number" id="rooster-count" name="rooster_count" min="1" value="1" required>
                            <span class="input-unit"><?php _e('ตัว', 'ayam-bangkok'); ?></span>
                        </div>
                        
                        <div class="input-group">
                            <label for="rooster-breed"><?php _e('สายพันธุ์', 'ayam-bangkok'); ?></label>
                            <select id="rooster-breed" name="rooster_breed" required>
                                <option value=""><?php _e('เลือกสายพันธุ์', 'ayam-bangkok'); ?></option>
                                <?php
                                $breeds = get_terms(array(
                                    'taxonomy' => 'rooster_breed',
                                    'hide_empty' => false
                                ));
                                
                                if (!empty($breeds)) :
                                    foreach ($breeds as $breed) :
                                ?>
                                    <option value="<?php echo esc_attr($breed->slug); ?>" data-price="<?php echo esc_attr(get_term_meta($breed->term_id, 'breed_base_price', true)); ?>">
                                        <?php echo esc_html($breed->name); ?>
                                    </option>
                                <?php 
                                    endforeach;
                                else :
                                    // Default breeds with prices
                                    $default_breeds = array(
                                        'thai-native' => array('name' => 'ไก่ไทยพื้นเมือง', 'price' => 5000),
                                        'fighting-cock' => array('name' => 'ไก่ชนแท้', 'price' => 8000),
                                        'premium-breed' => array('name' => 'สายพันธุ์พรีเมียม', 'price' => 12000),
                                        'champion-line' => array('name' => 'สายแชมป์', 'price' => 20000)
                                    );
                                    
                                    foreach ($default_breeds as $slug => $breed) :
                                ?>
                                    <option value="<?php echo esc_attr($slug); ?>" data-price="<?php echo esc_attr($breed['price']); ?>">
                                        <?php echo esc_html($breed['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="input-group">
                            <label for="service-package"><?php _e('แพ็กเกจบริการ', 'ayam-bangkok'); ?></label>
                            <select id="service-package" name="service_package" required>
                                <option value=""><?php _e('เลือกแพ็กเกจ', 'ayam-bangkok'); ?></option>
                                <option value="basic" data-price="2000"><?php _e('แพ็กเกจพื้นฐาน', 'ayam-bangkok'); ?></option>
                                <option value="standard" data-price="3500"><?php _e('แพ็กเกจมาตรฐาน', 'ayam-bangkok'); ?></option>
                                <option value="premium" data-price="5000"><?php _e('แพ็กเกจพรีเมียม', 'ayam-bangkok'); ?></option>
                                <option value="vip" data-price="8000"><?php _e('แพ็กเกจ VIP', 'ayam-bangkok'); ?></option>
                            </select>
                        </div>
                        
                        <div class="input-group">
                            <label for="shipping-method"><?php _e('วิธีการขนส่ง', 'ayam-bangkok'); ?></label>
                            <select id="shipping-method" name="shipping_method" required>
                                <option value=""><?php _e('เลือกวิธีขนส่ง', 'ayam-bangkok'); ?></option>
                                <option value="air-cargo" data-price="1500"><?php _e('ขนส่งทางอากาศ', 'ayam-bangkok'); ?></option>
                                <option value="sea-freight" data-price="800"><?php _e('ขนส่งทางเรือ', 'ayam-bangkok'); ?></option>
                                <option value="land-transport" data-price="1200"><?php _e('ขนส่งทางบก', 'ayam-bangkok'); ?></option>
                            </select>
                        </div>
                        
                        <div class="input-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="health-certificate" name="health_certificate" data-price="500">
                                <span class="checkmark"></span>
                                <?php _e('ใบรับรองสุขภาพ (+500 บาท)', 'ayam-bangkok'); ?>
                            </label>
                        </div>
                        
                        <div class="input-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="insurance" name="insurance" data-price="300">
                                <span class="checkmark"></span>
                                <?php _e('ประกันภัย (+300 บาท)', 'ayam-bangkok'); ?>
                            </label>
                        </div>
                        
                        <div class="input-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="express-service" name="express_service" data-price="1000">
                                <span class="checkmark"></span>
                                <?php _e('บริการด่วนพิเศษ (+1,000 บาท)', 'ayam-bangkok'); ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="calculator-result">
                        <div class="price-breakdown">
                            <h3><?php _e('รายละเอียดราคา', 'ayam-bangkok'); ?></h3>
                            <div class="breakdown-list">
                                <div class="breakdown-item">
                                    <span class="item-label"><?php _e('ราคาไก่ชน', 'ayam-bangkok'); ?></span>
                                    <span class="item-value" id="rooster-price">0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="item-label"><?php _e('ค่าบริการ', 'ayam-bangkok'); ?></span>
                                    <span class="item-value" id="service-price">0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="item-label"><?php _e('ค่าขนส่ง', 'ayam-bangkok'); ?></span>
                                    <span class="item-value" id="shipping-price">0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
                                </div>
                                <div class="breakdown-item">
                                    <span class="item-label"><?php _e('ค่าบริการเสริม', 'ayam-bangkok'); ?></span>
                                    <span class="item-value" id="extras-price">0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
                                </div>
                                <div class="breakdown-item discount-item" id="discount-row" style="display: none;">
                                    <span class="item-label"><?php _e('ส่วนลด', 'ayam-bangkok'); ?></span>
                                    <span class="item-value" id="discount-amount">-0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
                                </div>
                                <div class="breakdown-total">
                                    <span class="total-label"><?php _e('ราคารวม', 'ayam-bangkok'); ?></span>
                                    <span class="total-value" id="total-price">0 <?php _e('บาท', 'ayam-bangkok'); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="calculator-actions">
                            <button type="button" id="calculate-btn" class="btn btn-primary">
                                <i class="fas fa-calculator"></i>
                                <?php _e('คำนวณราคา', 'ayam-bangkok'); ?>
                            </button>
                            <button type="button" id="request-quote-btn" class="btn btn-secondary">
                                <i class="fas fa-file-alt"></i>
                                <?php _e('ขอใบเสนอราคา', 'ayam-bangkok'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Service Packages Section -->
    <section class="service-packages-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('แพ็กเกจบริการ', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เลือกแพ็กเกจที่เหมาะสมกับความต้องการของคุณ', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="packages-grid">
                <!-- Basic Package -->
                <div class="package-card basic-package">
                    <div class="package-header">
                        <div class="package-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 class="package-name"><?php _e('แพ็กเกจพื้นฐาน', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price-amount">2,000</span>
                            <span class="price-currency"><?php _e('บาท', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="package-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <?php _e('การตรวจสุขภาพเบื้องต้น', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('เอกสารส่งออกพื้นฐาน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การขนส่งมาตรฐาน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การติดตามสถานะ', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-times"></i> <?php _e('ประกันภัย', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-times"></i> <?php _e('บริการหลังการขาย', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="package-action">
                        <button class="btn btn-outline select-package-btn" data-package="basic">
                            <?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?>
                        </button>
                    </div>
                </div>
                
                <!-- Standard Package -->
                <div class="package-card standard-package">
                    <div class="package-header">
                        <div class="package-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3 class="package-name"><?php _e('แพ็กเกจมาตรฐาน', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price-amount">3,500</span>
                            <span class="price-currency"><?php _e('บาท', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="package-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <?php _e('การตรวจสุขภาพครบถ้วน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('เอกสารส่งออกครบชุด', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การขนส่งปลอดภัย', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การติดตามแบบ Real-time', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ประกันภัยพื้นฐาน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('บริการหลังการขาย 30 วัน', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="package-action">
                        <button class="btn btn-primary select-package-btn" data-package="standard">
                            <?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?>
                        </button>
                    </div>
                </div>
                
                <!-- Premium Package -->
                <div class="package-card premium-package popular">
                    <div class="package-badge"><?php _e('แนะนำ', 'ayam-bangkok'); ?></div>
                    <div class="package-header">
                        <div class="package-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h3 class="package-name"><?php _e('แพ็กเกจพรีเมียม', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price-amount">5,000</span>
                            <span class="price-currency"><?php _e('บาท', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="package-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <?php _e('การตรวจสุขภาพแบบพิเศษ', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('เอกสารส่งออกพรีเมียม', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การขนส่งแบบพิเศษ', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การติดตาม 24/7', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ประกันภัยครอบคลุม', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('บริการหลังการขาย 90 วัน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('คำปรึกษาฟรี', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="package-action">
                        <button class="btn btn-primary select-package-btn" data-package="premium">
                            <?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?>
                        </button>
                    </div>
                </div>
                
                <!-- VIP Package -->
                <div class="package-card vip-package">
                    <div class="package-header">
                        <div class="package-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h3 class="package-name"><?php _e('แพ็กเกจ VIP', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price-amount">8,000</span>
                            <span class="price-currency"><?php _e('บาท', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    
                    <div class="package-features">
                        <ul>
                            <li><i class="fas fa-check"></i> <?php _e('การตรวจสุขภาพแบบ VIP', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('เอกสารส่งออกแบบ VIP', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('การขนส่งแบบ VIP', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ผู้จัดการส่วนตัว', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('ประกันภัยเต็มจำนวน', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('บริการหลังการขายตลodชีพ', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('คำปรึกษาและฝึกอบรม', 'ayam-bangkok'); ?></li>
                            <li><i class="fas fa-check"></i> <?php _e('บริการรับซื้อคืน', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="package-action">
                        <button class="btn btn-secondary select-package-btn" data-package="vip">
                            <?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Discount Section -->
    <section class="discount-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('ส่วนลดพิเศษ', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('รับส่วนลดเมื่อสั่งซื้อในปริมาณมากหรือเป็นสมาชิก', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="discount-grid">
                <div class="discount-card">
                    <div class="discount-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3><?php _e('ส่วนลดสมาชิก', 'ayam-bangkok'); ?></h3>
                    <div class="discount-amount">5-15%</div>
                    <p><?php _e('สมาชิกได้รับส่วนลดตามระดับสมาชิกภาพ', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="discount-card">
                    <div class="discount-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3><?php _e('ส่วนลดปริมาณ', 'ayam-bangkok'); ?></h3>
                    <div class="discount-amount">10-25%</div>
                    <p><?php _e('สั่งซื้อ 5 ตัวขึ้นไป รับส่วนลดเพิ่มเติม', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="discount-card">
                    <div class="discount-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3><?php _e('ส่วนลดช่วงเวลา', 'ayam-bangkok'); ?></h3>
                    <div class="discount-amount">5-20%</div>
                    <p><?php _e('ส่วนลดพิเศษในช่วงเทศกาลและโปรโมชั่น', 'ayam-bangkok'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="pricing-faq-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('คำถามที่พบบ่อย', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('คำตอบสำหรับคำถามเกี่ยวกับราคาและการชำระเงิน', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4><?php _e('ราคาที่แสดงรวมค่าใช้จ่ายทั้งหมดหรือไม่?', 'ayam-bangkok'); ?></h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('ราคาที่แสดงเป็นราคาประมาณการ ราคาจริงอาจแตกต่างขึ้นอยู่กับสภาพตลาดและข้อกำหนดเฉพาะของแต่ละรายการ', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4><?php _e('สามารถผ่อนชำระได้หรือไม่?', 'ayam-bangkok'); ?></h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('สำหรับการสั่งซื้อมูลค่าสูง เราสามารถจัดการผ่อนชำระได้ กรุณาติดต่อเจ้าหน้าที่เพื่อหารือเงื่อนไข', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4><?php _e('มีการรับประกันหรือไม่?', 'ayam-bangkok'); ?></h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('เรามีการรับประกันสุขภาพไก่ชนและการส่งมอบตามแพ็กเกจที่เลือก รายละเอียดจะระบุในสัญญา', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4><?php _e('สามารถยกเลิกคำสั่งซื้อได้หรือไม่?', 'ayam-bangkok'); ?></h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('สามารถยกเลิกได้ภายใน 24 ชั่วโมงหลังจากสั่งซื้อ หากเกินกำหนดจะมีค่าธรรมเนียมตามเงื่อนไข', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>