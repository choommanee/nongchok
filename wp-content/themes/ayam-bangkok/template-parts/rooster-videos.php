<?php
/**
 * Template Part: Rooster Videos Section
 * แสดงวิดีโอของไก่ชน
 */

$rooster_id = get_the_ID();
$main_video = get_post_meta($rooster_id, 'rooster_video_url', true);
$additional_videos = get_post_meta($rooster_id, 'rooster_additional_videos', true);
$highlight_video = get_post_meta($rooster_id, 'rooster_highlight_video', true);

// ตรวจสอบว่ามีวิดีโอหรือไม่
if (!$main_video && !$additional_videos && !$highlight_video) {
    return;
}
?>

<section class="rooster-videos-section">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-video"></i>
                <?php _e('วิดีโอไก่ชน', 'ayam-bangkok'); ?>
            </h2>
            <p class="section-description">
                <?php _e('ดูวิดีโอการเคลื่อนไหวและความสามารถของไก่ชนตัวนี้', 'ayam-bangkok'); ?>
            </p>
        </div>

        <div class="videos-grid">
            <!-- Main Video -->
            <?php if ($main_video) : ?>
                <div class="video-item main-video">
                    <div class="video-wrapper">
                        <?php echo wp_oembed_get($main_video); ?>
                    </div>
                    <div class="video-info">
                        <h4 class="video-title">
                            <i class="fas fa-play-circle"></i>
                            <?php _e('วิดีโอหลัก', 'ayam-bangkok'); ?>
                        </h4>
                        <p class="video-description"><?php _e('วิดีโอแสดงลักษณะและการเคลื่อนไหวของไก่ชน', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Highlight Video -->
            <?php if ($highlight_video) : ?>
                <div class="video-item highlight-video">
                    <div class="video-wrapper">
                        <?php echo wp_oembed_get($highlight_video); ?>
                    </div>
                    <div class="video-info">
                        <h4 class="video-title">
                            <i class="fas fa-star"></i>
                            <?php _e('วิดีโอไฮไลท์', 'ayam-bangkok'); ?>
                        </h4>
                        <p class="video-description"><?php _e('วิดีโอแสดงความสามารถพิเศษและจุดเด่น', 'ayam-bangkok'); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Additional Videos -->
            <?php if ($additional_videos && is_array($additional_videos)) : ?>
                <?php foreach ($additional_videos as $index => $video) : ?>
                    <?php if (!empty($video['video_url'])) : ?>
                        <div class="video-item additional-video">
                            <div class="video-wrapper">
                                <?php echo wp_oembed_get($video['video_url']); ?>
                            </div>
                            <div class="video-info">
                                <h4 class="video-title">
                                    <i class="fas fa-film"></i>
                                    <?php echo !empty($video['video_title']) ? esc_html($video['video_title']) : sprintf(__('วิดีโอเพิ่มเติม %d', 'ayam-bangkok'), $index + 1); ?>
                                </h4>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Video Notes -->
        <div class="video-notes">
            <p class="note-text">
                <i class="fas fa-info-circle"></i>
                <?php _e('วิดีโอทั้งหมดถ่ายทำที่ฟาร์มของเราและแสดงสภาพจริงของไก่ชน', 'ayam-bangkok'); ?>
            </p>
        </div>
    </div>
</section>

<style>
.rooster-videos-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.videos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.video-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.video-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

.video-item.main-video {
    grid-column: 1 / -1;
}

.video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    background: #000;
}

.video-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.video-info {
    padding: 20px;
}

.video-title {
    font-size: 18px;
    font-weight: 600;
    color: #1E2950;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.video-title i {
    color: #CA4249;
}

.video-description {
    color: #6c757d;
    font-size: 14px;
    margin: 0;
}

.video-notes {
    margin-top: 30px;
    padding: 20px;
    background: white;
    border-left: 4px solid #CA4249;
    border-radius: 8px;
}

.note-text {
    margin: 0;
    color: #495057;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.note-text i {
    color: #CA4249;
    margin-top: 3px;
}

.rooster-number-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #1E2950 0%, #2D3F6F 100%);
    color: white;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    box-shadow: 0 4px 6px rgba(30, 41, 80, 0.2);
}

.rooster-number-badge i {
    font-size: 14px;
}

@media (max-width: 768px) {
    .videos-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .video-item.main-video {
        grid-column: 1;
    }

    .video-title {
        font-size: 16px;
    }
}
</style>
