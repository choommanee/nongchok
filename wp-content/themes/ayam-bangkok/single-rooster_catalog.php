<?php
/**
 * Single Rooster Catalog Template
 * หน้ารายละเอียดไก่แต่ละตัว
 */

get_header();

while (have_posts()) : the_post();
    $rooster_number = get_post_meta(get_the_ID(), 'rooster_number', true);
    $rooster_weight = get_post_meta(get_the_ID(), 'rooster_weight', true);
    $rooster_age = get_post_meta(get_the_ID(), 'rooster_age', true);
    $export_status = get_post_meta(get_the_ID(), 'export_status', true);
    $export_date = get_post_meta(get_the_ID(), 'export_date', true);
    
    $status_text = array(
        'ready' => 'พร้อมส่งออก',
        'pending' => 'กำลังเตรียม',
        'exported' => 'ส่งออกแล้ว'
    );
    ?>
    
    <article class="single-rooster">
        <div class="container">
            <div class="rooster-header">
                <h1><?php the_title(); ?></h1>
                <div class="rooster-meta">
                    <span class="rooster-number-large">หมายเลข: <?php echo esc_html($rooster_number); ?></span>
                    <span class="rooster-status-badge status-<?php echo esc_attr($export_status); ?>">
                        <?php echo esc_html($status_text[$export_status] ?? 'ไม่ระบุ'); ?>
                    </span>
                </div>
            </div>

            <div class="rooster-content-grid">
                <!-- Gallery Section -->
                <div class="rooster-gallery-section">
                    <h2>📸 รูปภาพ</h2>
                    <div class="rooster-images">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="rooster-main-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php else : ?>
                            <div class="rooster-placeholder-large">
                                <span class="rooster-icon">🐓</span>
                                <p>ยังไม่มีรูปภาพ</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Video Section -->
                    <h2>🎥 วิดีโอ</h2>
                    <div class="rooster-videos">
                        <p class="video-placeholder">ยังไม่มีวิดีโอ (จะเพิ่มในขั้นตอนถัดไป)</p>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="rooster-info-section">
                    <h2>ℹ️ ข้อมูลไก่</h2>
                    <div class="rooster-details">
                        <div class="detail-item">
                            <span class="detail-label">หมายเลข:</span>
                            <span class="detail-value"><?php echo esc_html($rooster_number); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">น้ำหนัก:</span>
                            <span class="detail-value"><?php echo esc_html($rooster_weight); ?> กก.</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">อายุ:</span>
                            <span class="detail-value"><?php echo esc_html($rooster_age); ?> ปี</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">สถานะ:</span>
                            <span class="detail-value"><?php echo esc_html($status_text[$export_status] ?? 'ไม่ระบุ'); ?></span>
                        </div>
                        <?php if ($export_date) : ?>
                        <div class="detail-item">
                            <span class="detail-label">วันที่:</span>
                            <span class="detail-value"><?php echo date_i18n('j F Y', strtotime($export_date)); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="rooster-description">
                        <h3>รายละเอียด</h3>
                        <?php the_content(); ?>
                    </div>

                    <div class="rooster-actions">
                        <a href="<?php echo home_url('/rooster-gallery'); ?>" class="btn btn-back">← กลับไปแกลเลอรี่</a>
                        <a href="<?php echo home_url('/contact'); ?>" class="btn btn-contact">สอบถามข้อมูล</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
    
    <?php
endwhile;

get_footer();
?>