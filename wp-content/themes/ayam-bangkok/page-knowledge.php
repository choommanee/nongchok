<?php
/**
 * Template for Knowledge Center page
 */

get_header(); ?>

<main id="primary" class="site-main knowledge-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ศูนย์ความรู้เกี่ยวกับไก่ชน', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('ความรู้และข้อมูลที่เป็นประโยชน์สำหรับผู้เลี้ยงไก่ชน', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Knowledge Categories -->
    <section class="knowledge-categories-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('หมวดหมู่ความรู้', 'ayam-bangkok'); ?></h2>
                <p><?php _e('เลือกหมวดหมู่ที่คุณสนใจเพื่อเรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="knowledge-categories-grid">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-dna"></i>
                    </div>
                    <h3><?php _e('สายพันธุ์ไก่ชน', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ข้อมูลเกี่ยวกับสายพันธุ์ไก่ชนต่างๆ ลักษณะเด่น และคุณสมบัติพิเศษ', 'ayam-bangkok'); ?></p>
                    <a href="#breeds" class="category-link"><?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3><?php _e('การดูแลสุขภาพ', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('วิธีการดูแลสุขภาพไก่ชน การป้องกันโรค และการรักษาเบื้องต้น', 'ayam-bangkok'); ?></p>
                    <a href="#health" class="category-link"><?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3><?php _e('อาหารและโภชนาการ', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('ความรู้เกี่ยวกับอาหารที่เหมาะสม โภชนาการ และการให้อาหารไก่ชน', 'ayam-bangkok'); ?></p>
                    <a href="#nutrition" class="category-link"><?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3><?php _e('การจัดที่อยู่อาศัย', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('การสร้างและจัดเตรียมที่อยู่อาศัยที่เหมาะสมสำหรับไก่ชน', 'ayam-bangkok'); ?></p>
                    <a href="#housing" class="category-link"><?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3><?php _e('การฝึกและการแข่งขัน', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('เทคนิคการฝึกไก่ชน กฎการแข่งขัน และการเตรียมตัวสำหรับการแข่งขัน', 'ayam-bangkok'); ?></p>
                    <a href="#training" class="category-link"><?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></a>
                </div>
                
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h3><?php _e('กฎหมายและระเบียบ', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('กฎหมายที่เกี่ยวข้องกับการเลี้ยงไก่ชน การส่งออก และข้อบังคับต่างๆ', 'ayam-bangkok'); ?></p>
                    <a href="#legal" class="category-link"><?php _e('เรียนรู้เพิ่มเติม', 'ayam-bangkok'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooster Breeds Section -->
    <section id="breeds" class="knowledge-section breeds-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('สายพันธุ์ไก่ชนยอดนิยม', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ทำความรู้จักกับสายพันธุ์ไก่ชนที่มีชื่อเสียงและเป็นที่นิยม', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="breeds-grid">
                <div class="breed-card">
                    <div class="breed-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/breeds/asil.jpg" alt="Asil">
                    </div>
                    <div class="breed-content">
                        <h3><?php _e('อาซิล (Asil)', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('สายพันธุ์ดั้งเดิมจากอินเดีย มีความแข็งแกร่งและทนทาน เป็นที่นิยมในการแข่งขัน', 'ayam-bangkok'); ?></p>
                        <ul class="breed-features">
                            <li><?php _e('ความแข็งแกร่งสูง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ทนทานต่อสภาพอากาศ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('มีสัญชาตญาณการต่อสู้ดี', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="breed-card">
                    <div class="breed-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/breeds/shamo.jpg" alt="Shamo">
                    </div>
                    <div class="breed-content">
                        <h3><?php _e('ชาโม (Shamo)', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('สายพันธุ์จากญี่ปุ่น มีรูปร่างสูงใหญ่ และมีความแข็งแกร่งเป็นพิเศษ', 'ayam-bangkok'); ?></p>
                        <ul class="breed-features">
                            <li><?php _e('รูปร่างสูงใหญ่', 'ayam-bangkok'); ?></li>
                            <li><?php _e('กล้ามเนื้อแข็งแรง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('มีความอดทนสูง', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="breed-card">
                    <div class="breed-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/breeds/kelso.jpg" alt="Kelso">
                    </div>
                    <div class="breed-content">
                        <h3><?php _e('เคลโซ (Kelso)', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('สายพันธุ์อเมริกัน มีความเร็วและความแม่นยำในการต่อสู้', 'ayam-bangkok'); ?></p>
                        <ul class="breed-features">
                            <li><?php _e('ความเร็วสูง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การเคลื่อนไหวแม่นยำ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('สติปัญญาดี', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Health Care Section -->
    <section id="health" class="knowledge-section health-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('การดูแลสุขภาพไก่ชน', 'ayam-bangkok'); ?></h2>
                <p><?php _e('คำแนะนำสำหรับการดูแลสุขภาพและการป้องกันโรค', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="health-content">
                <div class="health-tips">
                    <div class="tip-card">
                        <div class="tip-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3><?php _e('การป้องกันโรค', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('ฉีดวัคซีนตามกำหนด', 'ayam-bangkok'); ?></li>
                            <li><?php _e('รักษาความสะอาดของที่อยู่อาศัย', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ให้อาหารที่มีคุณภาพ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ตรวจสุขภาพเป็นประจำ', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="tip-card">
                        <div class="tip-icon">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <h3><?php _e('อาการที่ควรสังเกต', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('การเปลี่ยนแปลงของพฤติกรรม', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การกินอาหารลดลง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ขนไม่เรียบเนียน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('มีอาการซึมเศร้า', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="tip-card">
                        <div class="tip-icon">
                            <i class="fas fa-first-aid"></i>
                        </div>
                        <h3><?php _e('การรักษาเบื้องต้น', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('แยกไก่ที่ป่วยออกจากฝูง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ให้น้ำสะอาดและอาหารที่ย่อยง่าย', 'ayam-bangkok'); ?></li>
                            <li><?php _e('รักษาอุณหภูมิให้เหมาะสม', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ปรึกษาสัตวแพทย์เมื่อจำเป็น', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nutrition Section -->
    <section id="nutrition" class="knowledge-section nutrition-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('อาหารและโภชนาการ', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ความรู้เกี่ยวกับการให้อาหารที่เหมาะสมสำหรับไก่ชน', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="nutrition-content">
                <div class="nutrition-grid">
                    <div class="nutrition-card">
                        <h3><?php _e('อาหารหลัก', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('ข้าวโพด - แหล่งพลังงาน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ปลาป่น - โปรตีนสูง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('รำข้าว - วิตามินและแร่ธาตุ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('ถั่วเหลือง - โปรตีนพืช', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="nutrition-card">
                        <h3><?php _e('อาหารเสริม', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('ผักใบเขียว - วิตามินเอ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('หอยนางรม - แคลเซียม', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เกลือแร่ - แร่ธาตุจำเป็น', 'ayam-bangkok'); ?></li>
                            <li><?php _e('วิตามินรวม - เสริมภูมิคุ้มกัน', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="nutrition-card">
                        <h3><?php _e('ตารางการให้อาหาร', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('เช้า 06:00 - อาหารหลัก', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เที่ยง 12:00 - อาหารเสริม', 'ayam-bangkok'); ?></li>
                            <li><?php _e('เย็น 18:00 - อาหารหลัก', 'ayam-bangkok'); ?></li>
                            <li><?php _e('น้ำสะอาด - ตลอดเวลา', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Housing Section -->
    <section id="housing" class="knowledge-section housing-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('การจัดที่อยู่อาศัย', 'ayam-bangkok'); ?></h2>
                <p><?php _e('คำแนะนำในการสร้างและจัดเตรียมที่อยู่อาศัยที่เหมาะสม', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="housing-content">
                <div class="housing-requirements">
                    <div class="requirement-item">
                        <div class="requirement-icon">
                            <i class="fas fa-ruler-combined"></i>
                        </div>
                        <h3><?php _e('ขนาดและพื้นที่', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('กรงควรมีขนาดอย่างน้อย 1x1x2 เมตร สำหรับไก่ชน 1 ตัว พื้นที่ออกกำลังกายแยกต่างหาก', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <div class="requirement-item">
                        <div class="requirement-icon">
                            <i class="fas fa-wind"></i>
                        </div>
                        <h3><?php _e('การระบายอากาศ', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ต้องมีการระบายอากาศที่ดี ไม่มีลมกรด และมีแสงธรรมชาติเพียงพอ', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <div class="requirement-item">
                        <div class="requirement-icon">
                            <i class="fas fa-broom"></i>
                        </div>
                        <h3><?php _e('ความสะอาด', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ทำความสะอาดกรงเป็นประจำ เปลี่ยนแป้งรองพื้น และฆ่าเชื้อโรคสม่ำเสมอ', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <div class="requirement-item">
                        <div class="requirement-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3><?php _e('ความปลอดภัย', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ป้องกันสัตว์ร้าย มีระบบล็อคที่มั่นคง และวัสดุที่ไม่เป็นอันตราย', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Training Section -->
    <section id="training" class="knowledge-section training-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('การฝึกและการแข่งขัน', 'ayam-bangkok'); ?></h2>
                <p><?php _e('เทคนิคการฝึกไก่ชนและการเตรียมตัวสำหรับการแข่งขัน', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="training-content">
                <div class="training-phases">
                    <div class="phase-card">
                        <div class="phase-number">1</div>
                        <h3><?php _e('การฝึกพื้นฐาน', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('การเดินและการวิ่ง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การสร้างความแข็งแกร่ง', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การปรับสภาพร่างกาย', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="phase-card">
                        <div class="phase-number">2</div>
                        <h3><?php _e('การฝึกเทคนิค', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('การฝึกการโจมตี', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การฝึกการป้องกัน', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การฝึกความเร็ว', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="phase-card">
                        <div class="phase-number">3</div>
                        <h3><?php _e('การเตรียมแข่งขัน', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><?php _e('การปรับสภาพจิตใจ', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การควบคุมน้ำหนัก', 'ayam-bangkok'); ?></li>
                            <li><?php _e('การฝึกซ้อมจริง', 'ayam-bangkok'); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Legal Section -->
    <section id="legal" class="knowledge-section legal-section">
        <div class="container">
            <div class="section-header">
                <h2><?php _e('กฎหมายและระเบียบ', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ข้อมูลกฎหมายและระเบียบที่เกี่ยวข้องกับการเลี้ยงและส่งออกไก่ชน', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="legal-content">
                <div class="legal-categories">
                    <div class="legal-card">
                        <div class="legal-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h3><?php _e('ใบอนุญาตการเลี้ยง', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ข้อกำหนดและขั้นตอนการขอใบอนุญาตเลี้ยงไก่ชนตามกฎหมาย', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <div class="legal-card">
                        <div class="legal-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3><?php _e('กฎการส่งออก', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ระเบียบและข้อกำหนดสำหรับการส่งออกไก่ชนไปต่างประเทศ', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <div class="legal-card">
                        <div class="legal-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3><?php _e('ใบรับรองสุขภาพ', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('ข้อกำหนดเกี่ยวกับใบรับรองสุขภาพและการตรวจสอบคุณภาพ', 'ayam-bangkok'); ?></p>
                    </div>
                    
                    <div class="legal-card">
                        <div class="legal-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3><?php _e('กฎการแข่งขัน', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('กฎและระเบียบสำหรับการจัดการแข่งขันไก่ชนอย่างถูกกฎหมาย', 'ayam-bangkok'); ?></p>
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
                <p><?php _e('คำตอบสำหรับคำถามที่ลูกค้าถามบ่อยเกี่ยวกับไก่ชน', 'ayam-bangkok'); ?></p>
            </div>
            
            <div class="faq-content">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php _e('ไก่ชนสายพันธุ์ไหนเหมาะสำหรับผู้เริ่มต้น?', 'ayam-bangkok'); ?></h3>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('สำหรับผู้เริ่มต้น แนะนำสายพันธุ์ที่ทนทานและดูแลง่าย เช่น อาซิล หรือไก่ชนไทยพื้นเมือง เนื่องจากมีความแข็งแกร่งและปรับตัวได้ดี', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php _e('ควรให้อาหารไก่ชนวันละกี่มื้อ?', 'ayam-bangkok'); ?></h3>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('ควรให้อาหารวันละ 2-3 มื้อ โดยมื้อเช้าและมื้อเย็นเป็นอาหารหลัก ส่วนมื้อเที่ยงให้อาหารเสริมหรือผักใบเขียว พร้อมน้ำสะอาดตลอดเวลา', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php _e('ไก่ชนป่วยมีอาการอย่างไร?', 'ayam-bangkok'); ?></h3>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('อาการที่ควรสังเกต ได้แก่ การกินอาหารลดลง ขนไม่เรียบเนียน มีอาการซึมเศร้า ตาหรือจมูกมีน้ำมูก หรือมีการเปลี่ยนแปลงพฤติกรรมผิดปกติ', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3><?php _e('การส่งออกไก่ชนต้องมีเอกสารอะไรบ้าง?', 'ayam-bangkok'); ?></h3>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p><?php _e('ต้องมีใบรับรองสุขภาพจากสัตวแพทย์ ใบอนุญาตส่งออก ใบรับรองพันธุ์ และเอกสารการขนส่งที่ครบถ้วนตามกฎหมายของประเทศปลายทาง', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2><?php _e('ต้องการคำปรึกษาเพิ่มเติม?', 'ayam-bangkok'); ?></h2>
                <p><?php _e('ทีมผู้เชี่ยวชาญของเราพร้อมให้คำแนะนำเกี่ยวกับการเลี้ยงและดูแลไก่ชน', 'ayam-bangkok'); ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary"><?php _e('ติดต่อเรา', 'ayam-bangkok'); ?></a>
                    <a href="<?php echo home_url('/appointment'); ?>" class="btn btn-secondary"><?php _e('นัดหมายปรึกษา', 'ayam-bangkok'); ?></a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();