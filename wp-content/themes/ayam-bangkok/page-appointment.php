<?php
/**
 * Template Name: Appointment Page
 * หน้านัดหมายชมไก่
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">นัดหมายชมไก่</h1>
            <p class="page-subtitle">จองเวลาเพื่อเข้าชมไก่ชนคุณภาพของเรา</p>
        </div>

        <div class="appointment-content">
            <div class="row">
                
                <!-- Appointment Form -->
                <div class="col-lg-8">
                    <div class="appointment-form-wrapper">
                        <h3>ฟอร์มนัดหมาย</h3>
                        
                        <form id="appointment-form" class="appointment-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <?php wp_nonce_field('appointment_form_nonce', 'appointment_nonce'); ?>
                            <input type="hidden" name="action" value="submit_appointment_form">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_name">ชื่อ-นามสกุล *</label>
                                        <input type="text" id="appointment_name" name="appointment_name" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_phone">เบอร์โทรศัพท์ *</label>
                                        <input type="tel" id="appointment_phone" name="appointment_phone" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_email">อีเมล</label>
                                        <input type="email" id="appointment_email" name="appointment_email">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_visitors">จำนวนผู้เข้าชม</label>
                                        <select id="appointment_visitors" name="appointment_visitors">
                                            <option value="1">1 คน</option>
                                            <option value="2">2 คน</option>
                                            <option value="3-5">3-5 คน</option>
                                            <option value="6-10">6-10 คน</option>
                                            <option value="10+">มากกว่า 10 คน</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_date">วันที่ต้องการ *</label>
                                        <input type="date" id="appointment_date" name="appointment_date" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_time">เวลาที่ต้องการ *</label>
                                        <select id="appointment_time" name="appointment_time" required>
                                            <option value="">เลือกเวลา</option>
                                            <option value="09:00">09:00 น.</option>
                                            <option value="10:00">10:00 น.</option>
                                            <option value="11:00">11:00 น.</option>
                                            <option value="13:00">13:00 น.</option>
                                            <option value="14:00">14:00 น.</option>
                                            <option value="15:00">15:00 น.</option>
                                            <option value="16:00">16:00 น.</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="appointment_interest">สนใจไก่ชนประเภทใด</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="appointment_interest[]" value="fighting">
                                        ไก่ชนต่อสู้
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="appointment_interest[]" value="breeding">
                                        ไก่พันธุ์แม่
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="appointment_interest[]" value="show">
                                        ไก่ชนประกวด
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="appointment_interest[]" value="export">
                                        ไก่ส่งออก
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="appointment_message">ข้อความเพิ่มเติม</label>
                                <textarea id="appointment_message" name="appointment_message" rows="4" placeholder="ระบุความต้องการพิเศษหรือคำถามเพิ่มเติม..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="appointment_consent" required>
                                    ยอมรับเงื่อนไขการนัดหมายและนโยบายความเป็นส่วนตัว
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-check"></i>
                                ส่งคำขอนัดหมาย
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Appointment Info -->
                <div class="col-lg-4">
                    <div class="appointment-info">
                        <h3>ข้อมูลการนัดหมาย</h3>
                        
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>เวลาทำการ</h4>
                                <p>จันทร์-เสาร์ 9:00-17:00 น.</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <h4>การจองล่วงหน้า</h4>
                                <p>กรุณาจองล่วงหน้าอย่างน้อย 1 วัน</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <h4>จำนวนผู้เข้าชม</h4>
                                <p>รับได้สูงสุด 20 คนต่อรอบ</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <h4>มาตรการความปลอดภัย</h4>
                                <p>ปฏิบัติตามมาตรการป้องกันโรค</p>
                            </div>
                        </div>
                        
                        <div class="appointment-rules">
                            <h4>ข้อปฏิบัติสำหรับผู้เข้าชม</h4>
                            <ul>
                                <li>แต่งกายสุภาพ ไม่สวมรองเท้าส้นสูง</li>
                                <li>ห้ามสูบุหรี่ในบริเวณฟาร์ม</li>
                                <li>ห้ามให้อาหารไก่โดยไม่ได้รับอนุญาต</li>
                                <li>ปฏิบัติตามคำแนะนำของเจ้าหน้าที่</li>
                                <li>เด็กต้องอยู่ในความดูแลของผู้ใหญ่</li>
                            </ul>
                        </div>
                        
                        <div class="contact-urgent">
                            <h4>ติดต่อด่วน</h4>
                            <p>โทร: <?php echo esc_html(ayam_get_company_info('phone') ?: '02-XXX-XXXX'); ?></p>
                            <p>Line: <?php echo esc_html(ayam_get_company_info('line_id') ?: '@ayambangkok'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>