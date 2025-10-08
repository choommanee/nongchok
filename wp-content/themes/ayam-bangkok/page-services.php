<?php
/**
 * Template for Services & Products page
 */

get_header(); ?>

<main id="primary" class="site-main services-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('บริการและสินค้าเสริม', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('บริการครบวงจรสำหรับการส่งออกไก่ชนและสินค้าเสริมคุณภาพสูง', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Main Services Section -->
    <section class="main-services-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('บริการหลักของเรา', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เราให้บริการครบวงจรตั้งแต่การคัดเลือกไก่ชนไปจนถึงการส่งมอบที่ปลายทาง', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="services-grid">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="service-content">
                        <h3><?php _e('การคัดเลือกไก่ชน', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ทีมผู้เชี่ยวชาญคัดเลือกไก่ชนคุณภาพสูงตามมาตรฐานสากล พร้อมตรวจสอบสุขภาพและประวัติการแข่งขัน', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><?php _e('ตรวจสอบสายเลือดและประวัติ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ประเมินคุณภาพและศักยภาพ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ตรวจสุขภาพโดยสัตวแพทย์', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="service-content">
                        <h3><?php _e('การดูแลและรักษา', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('บริการดูแลไก่ชนก่อนการส่งออก รวมถึงการฉีดวัคซีน การรักษา และการเตรียมความพร้อม', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><?php _e('ฉีดวัคซีนป้องกันโรค', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การรักษาและฟื้นฟูสุขภาพ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การเตรียมความพร้อมก่อนส่งออก', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="service-content">
                        <h3><?php _e('เอกสารและใบรับรอง', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('จัดทำเอกสารครบถ้วนตามกฎหมายและข้อกำหนดของประเทศปลายทาง รวมถึงใบรับรองสุขภาพ', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><?php _e('ใบรับรองสุขภาพสัตว์', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เอกสารการส่งออก', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ใบรับรองสายพันธุ์', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="service-content">
                        <h3><?php _e('การขนส่งและจัดส่ง', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('บริการขนส่งที่ปลอดภัยและรวดเร็ว พร้อมระบบติดตามและประกันภัยครอบคลุม', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><?php _e('ขนส่งทางอากาศ ทางเรือ และทางบก', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ระบบติดตามแบบเรียลไทม์', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ประกันภัยครอบคลุม', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="service-content">
                        <h3><?php _e('บริการหลังการขาย', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ให้คำปรึกษาและสนับสนุนหลังการขาย รวมถึงการดูแลและการฝึกอบรม', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><?php _e('คำปรึกษาการเลี้ยงดู', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การฝึกอบรมเทคนิค', 'ayam-bangkok'); ?></li>
                            <li><?php _e('สนับสนุนตลอด 24/7', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="service-content">
                        <h3><?php _e('ความร่วมมือทางธุรกิจ', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('เปิดโอกาสความร่วมมือกับพันธมิตรทางธุรกิจ ตัวแทนจำหน่าย และนักลงทุน', 'ayam-bangkok'); ?></p>
                        <ul class="service-features">
                            <li><?php _e('โปรแกรมตัวแทนจำหน่าย', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ความร่วมมือการลงทุน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('พันธมิตรทางธุรกิจ', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Packages Section -->
    <section class="service-packages-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('แพ็กเกจบริการ', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เลือกแพ็กเกจบริการที่เหมาะสมกับความต้องการของคุณ', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="packages-grid">
                <div class="package-item">
                    <div class="package-header">
                        <h3><?php _e('แพ็กเกจพื้นฐาน', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price">2,000</span>
                            <span class="currency"><?php _e('บาท/ตัว', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li><?php _e('การคัดเลือกไก่ชนพื้นฐาน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ตรวจสุขภาพเบื้องต้น', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เอกสารการส่งออกพื้นฐาน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การขนส่งมาตรฐาน', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="package-cta">
                        <a href="#contact" class="btn btn-outline"><?php _e('สอบถามเพิ่มเติม', 'ayam-bangkok'); ?></a>
                    </div>
                </div>
                
                <div class="package-item featured">
                    <div class="package-badge"><?php _e('แนะนำ', 'ayam-bangkok'); ?></div>
                    <div class="package-header">
                        <h3><?php _e('แพ็กเกจมาตรฐาน', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price">3,500</span>
                            <span class="currency"><?php _e('บาท/ตัว', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li><?php _e('การคัดเลือกไก่ชนคุณภาพสูง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ตรวจสุขภาพครบถ้วน + วัคซีน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เอกสารครบถ้วนทุกประเภท', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การขนส่งพิเศษ + ติดตาม', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ประกันภัยพื้นฐาน', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="package-cta">
                        <a href="#contact" class="btn btn-primary"><?php _e('เลือกแพ็กเกจนี้', 'ayam-bangkok'); ?></a>
                    </div>
                </div>
                
                <div class="package-item">
                    <div class="package-header">
                        <h3><?php _e('แพ็กเกจพรีเมียม', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price">5,000</span>
                            <span class="currency"><?php _e('บาท/ตัว', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li><?php _e('การคัดเลือกไก่ชนระดับแชมป์', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ตรวจสุขภาพเฉพาะทาง + การรักษา', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เอกสารพิเศษ + ใบรับรองสายพันธุ์', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การขนส่งพรีเมียม + VIP', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ประกันภัยครอบคลุม', 'ayam-bangkok'); ?></li>
                            <li><?php _e('บริการหลังการขาย 6 เดือน', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="package-cta">
                        <a href="#contact" class="btn btn-outline"><?php _e('สอบถามเพิ่มเติม', 'ayam-bangkok'); ?></a>
                    </div>
                </div>
                
                <div class="package-item">
                    <div class="package-header">
                        <h3><?php _e('แพ็กเกจ VIP', 'ayam-bangkok'); ?></h3>
                        <div class="package-price">
                            <span class="price">8,000</span>
                            <span class="currency"><?php _e('บาท/ตัว', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li><?php _e('การคัดเลือกไก่ชนระดับโลก', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การดูแลสุขภาพแบบ VIP', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เอกสารครบถ้วน + การรับรอง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การขนส่งแบบ VIP + ผู้ดูแลเฉพาะ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ประกันภัยเต็มจำนวน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('บริการหลังการขาย 1 ปี', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การฝึกอบรมเฉพาะทาง', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    <div class="package-cta">
                        <a href="#contact" class="btn btn-outline"><?php _e('สอบถามเพิ่มเติม', 'ayam-bangkok'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Products Section -->
    <section class="additional-products-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('สินค้าและอุปกรณ์เสริม', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('สินค้าคุณภาพสูงสำหรับการเลี้ยงดูและการแข่งขันไก่ชน', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="products-grid">
                <div class="product-item">
                    <div class="product-image">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="product-content">
                        <h3><?php _e('อาหารไก่ชนพิเศษ', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('อาหารสูตรพิเศษเพื่อเสริมสร้างความแข็งแรงและความคล่องตัว', 'ayam-bangkok'); ?></p>
                        <div class="product-price">
                            <span><?php _e('เริ่มต้น', 'ayam-bangkok'); ?> 500 <?php _e('บาท/กิโลกรัม', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="product-item">
                    <div class="product-image">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="product-content">
                        <h3><?php _e('วิตามินและอาหารเสริม', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('วิตามินและอาหารเสริมเพื่อเสริมสร้างภูมิคุ้มกันและสุขภาพ', 'ayam-bangkok'); ?></p>
                        <div class="product-price">
                            <span><?php _e('เริ่มต้น', 'ayam-bangkok'); ?> 300 <?php _e('บาท/ขวด', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="product-item">
                    <div class="product-image">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="product-content">
                        <h3><?php _e('กรงและอุปกรณ์', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('กรงคุณภาพสูงและอุปกรณ์ต่างๆ สำหรับการเลี้ยงดูไก่ชน', 'ayam-bangkok'); ?></p>
                        <div class="product-price">
                            <span><?php _e('เริ่มต้น', 'ayam-bangkok'); ?> 2,000 <?php _e('บาท/ชุด', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="product-item">
                    <div class="product-image">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="product-content">
                        <h3><?php _e('อุปกรณ์ป้องกัน', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('อุปกรณ์ป้องกันและความปลอดภัยสำหรับการฝึกและการแข่งขัน', 'ayam-bangkok'); ?></p>
                        <div class="product-price">
                            <span><?php _e('เริ่มต้น', 'ayam-bangkok'); ?> 150 <?php _e('บาท/ชิ้น', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="product-item">
                    <div class="product-image">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="product-content">
                        <h3><?php _e('หนังสือและคู่มือ', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('หนังสือและคู่มือการเลี้ยงดูไก่ชนจากผู้เชี่ยวชาญ', 'ayam-bangkok'); ?></p>
                        <div class="product-price">
                            <span><?php _e('เริ่มต้น', 'ayam-bangkok'); ?> 200 <?php _e('บาท/เล่ม', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="product-item">
                    <div class="product-image">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="product-content">
                        <h3><?php _e('บริการสัตวแพทย์', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('บริการตรวจสุขภาพและรักษาโดยสัตวแพทย์ผู้เชี่ยวชาญ', 'ayam-bangkok'); ?></p>
                        <div class="product-price">
                            <span><?php _e('เริ่มต้น', 'ayam-bangkok'); ?> 500 <?php _e('บาท/ครั้ง', 'ayam-bangkok'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('ทำไมต้องเลือกเรา', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เหตุผลที่ลูกค้าไว้วางใจให้เราดูแลการส่งออกไก่ชน', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="reasons-grid">
                <div class="reason-item">
                    <div class="reason-number">01</div>
                    <h3><?php _e('ประสบการณ์กว่า 10 ปี', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ความเชี่ยวชาญและประสบการณ์ยาวนานในธุรกิจส่งออกไก่ชน', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="reason-item">
                    <div class="reason-number">02</div>
                    <h3><?php _e('เครือข่ายระหว่างประเทศ', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ความสัมพันธ์ที่แน่นแฟ้นกับพันธมิตรในอินโดนีเซียและประเทศอื่นๆ', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="reason-item">
                    <div class="reason-number">03</div>
                    <h3><?php _e('มาตรฐานสากล', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ได้รับการรับรองมาตรฐานจากหน่วยงานราชการและองค์กรสากล', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="reason-item">
                    <div class="reason-number">04</div>
                    <h3><?php _e('ทีมผู้เชี่ยวชาญ', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ทีมงานมืออาชีพที่มีความรู้และประสบการณ์ในทุกขั้นตอน', 'ayam-bangkok'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="contact-cta-section" id="contact">
        <div class="container">
            <div class="cta-content text-center">
                <h2><?php _e('พร้อมเริ่มต้นแล้วหรือยัง?', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ติดต่อเราวันนี้เพื่อปรึกษาและวางแผนการส่งออกไก่ชนของคุณ', 'ayam-bangkok'); ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary btn-large">
                        <i class="fas fa-phone"></i>
                        <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                    </a>
                    <a href="<?php echo home_url('/appointment'); ?>" class="btn btn-secondary btn-large">
                        <i class="fas fa-calendar-alt"></i>
                        <?php _e('นัดหมายเยี่ยมชม', 'ayam-bangkok'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>