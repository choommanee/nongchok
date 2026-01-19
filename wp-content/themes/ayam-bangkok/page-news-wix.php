<?php
/**
 * Template Name: News Page (Wix Style)
 * Matching https://saeliwid.wixsite.com/my-site-3/news-1
 * Video Gallery Layout
 */

get_header();

// Query news posts excluding video category
$args = array(
    'post_type' => 'ayam_news',
    'posts_per_page' => 8,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'ayam_news_category',
            'field' => 'slug',
            'terms' => 'video',
            'operator' => 'NOT IN' // Exclude video category
        )
    ),
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'relation' => 'OR',
            array(
                'key' => 'video_url',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => 'video_url',
                'value' => '',
                'compare' => '='
            )
        ),
        array(
            'relation' => 'OR',
            array(
                'key' => 'video_embed',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => 'video_embed',
                'value' => '',
                'compare' => '='
            )
        )
    )
);

$news_query = new WP_Query($args);

?>

<style>
.news-page-wix {
    background: #fff;
}

.news-hero-simple {
    background: #fff;
    padding: 60px 20px 50px;
    text-align: center;
}

.news-hero-simple h1 {
    font-size: 3.5rem;
    font-weight: 700;
    color: #1E2950;
    margin: 0;
    letter-spacing: 2px;
}

.news-articles-section {
    background: #FAF9F9FF;
    padding: 60px 20px;
}

.news-articles-container {
    max-width: 1400px;
    margin: 0 auto;
}

.news-articles-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.news-article-card {
    text-decoration: none;
    display: block;
}

.news-article-image {
    width: 100%;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: #fff;
}

.news-article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center bottom;
}

.news-article-title-box {
    background: #fff;
    padding: 20px;
    text-align: center;
}

.news-article-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1E2950;
    margin: 0;
}

.news-video-section {
    background: #fff;
    padding: 80px 20px;
}

.news-video-container {
    max-width: 1400px;
    margin: 0 auto;
}

.news-video-section h2 {
    font-size: 3rem;
    font-weight: 700;
    color: #1E2950;
    margin-bottom: 50px;
    text-align: center;
}

/* Video Grid 4x2 Layout */
.news-videos-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(2, 1fr);
    gap: 30px;
    margin-top: 30px;
}

.news-video-item {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.news-video-item:hover {
    transform: translateY(-5px);
}

.video-thumbnail-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    background: #000;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.video-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-video-item:hover .video-thumbnail {
    transform: scale(1.05);
}

.video-play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.3);
    transition: background 0.3s ease;
}

.news-video-item:hover .video-play-overlay {
    background: rgba(0,0,0,0.5);
}

.play-icon {
    width: 68px;
    height: 48px;
    transition: transform 0.3s ease;
}

.news-video-item:hover .play-icon {
    transform: scale(1.2);
}

.video-title {
    margin-top: 15px;
    font-size: 1rem;
    font-weight: 600;
    color: #1E2950;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Placeholder for empty video slots */
.video-placeholder .video-thumbnail-wrapper {
    background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-placeholder-box {
    text-align: center;
    color: #999;
    font-size: 1rem;
}

.video-placeholder {
    pointer-events: none;
    opacity: 0.5;
}

/* Empty state */
.video-grid-empty {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.video-grid-empty p {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.video-grid-empty small {
    font-size: 0.9rem;
    color: #999;
}

/* Video Modal */
.video-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    animation: fadeIn 0.3s ease;
}

.video-modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-modal-content {
    position: relative;
    width: 90%;
    max-width: 1200px;
    animation: slideIn 0.3s ease;
}

.video-modal-close {
    position: absolute;
    top: -40px;
    right: 0;
    color: #fff;
    font-size: 35px;
    font-weight: normal;
    cursor: pointer;
    transition: color 0.3s ease;
    z-index: 10001;
}

.video-modal-close:hover {
    color: #ff0000;
}

.video-modal-body {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
}

.video-modal-body iframe,
.video-modal-body video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Video Pagination Styles */
.video-pagination {
    margin-top: 50px;
    display: flex;
    justify-content: center;
}

.video-pagination ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 10px;
    align-items: center;
}

.video-pagination li {
    margin: 0;
}

.video-pagination a,
.video-pagination .current {
    display: inline-block;
    padding: 10px 15px;
    background: #f5f5f5;
    color: #1E2950;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.video-pagination a:hover {
    background: #1E2950;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.video-pagination .current {
    background: #1E2950;
    color: #fff;
    border-color: #1E2950;
}

.video-pagination .prev,
.video-pagination .next {
    font-weight: 600;
}

.video-pagination .dots {
    padding: 10px 5px;
    color: #999;
}

@media (max-width: 1024px) {
    .news-articles-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .news-videos-grid {
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: auto;
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .news-hero-simple h1 {
        font-size: 2.2rem;
    }

    .news-articles-section {
        padding: 40px 20px;
    }

    .news-articles-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .news-article-title-box {
        padding: 15px;
    }

    .news-article-title {
        font-size: 0.9rem;
    }

    .news-video-section {
        padding: 60px 20px;
    }

    .news-video-section h2 {
        font-size: 2rem;
        margin-bottom: 30px;
    }

    .news-videos-grid {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: auto;
        gap: 20px;
    }

    .video-title {
        font-size: 0.9rem;
    }

    .play-icon {
        width: 54px;
        height: 38px;
    }

    .video-modal-content {
        width: 95%;
    }
}

@media (max-width: 480px) {
    .news-hero-simple h1 {
        font-size: 1.8rem;
    }

    .news-articles-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .news-article-title {
        font-size: 0.85rem;
    }

    .news-videos-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .video-title {
        font-size: 0.85rem;
        margin-top: 10px;
    }

    .play-icon {
        width: 48px;
        height: 34px;
    }

    .news-video-section h2 {
        font-size: 1.8rem;
    }

    .video-pagination {
        margin-top: 30px;
    }

    .video-pagination a,
    .video-pagination .current {
        padding: 8px 12px;
        font-size: 0.9rem;
    }
}
</style>

<main id="primary" class="site-main news-page-wix">

    <!-- Hero Section -->
    <section class="news-hero-simple">
        <h1>Article & News</h1>
    </section>

    <!-- Articles Grid -->
    <section class="news-articles-section">
        <div class="news-articles-container">
            <?php if ($news_query->have_posts()): ?>
                <div class="news-articles-grid">
                    <?php
                    while ($news_query->have_posts()) :
                        $news_query->the_post();
                    ?>
                        <a href="<?php the_permalink(); ?>" class="news-article-card">
                            <div class="news-article-image">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                <?php endif; ?>
                            </div>
                            <div class="news-article-title-box">
                                <h3 class="news-article-title"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>

            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: #fff;">
                    <p>ยังไม่มีข่าวสารในขณะนี้</p>
                </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- Video Content Section -->
    <section class="news-video-section">
        <div class="news-video-container">
            <h2>Video Content</h2>

            <?php
            // Get current page for pagination
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            // Query posts from "Video" category or posts with video_url
            $video_args = array(
                'post_type' => 'ayam_news',
                'posts_per_page' => 8, // 4x2 grid = 8 videos per page
                'paged' => $paged,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'video_url',
                        'compare' => 'EXISTS'
                    ),
                    array(
                        'key' => 'video_embed',
                        'compare' => 'EXISTS'
                    ),
                    array(
                        'key' => 'video_url',
                        'value' => '',
                        'compare' => '!='
                    )
                ),
                'orderby' => 'date',
                'order' => 'DESC'
            );

            // Alternative: Query by category
            $video_args_alt = array(
                'post_type' => 'ayam_news',
                'posts_per_page' => 8,
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'ayam_news_category',
                        'field' => 'slug',
                        'terms' => 'video',
                    )
                ),
                'orderby' => 'date',
                'order' => 'DESC'
            );

            // First try to get posts with video meta
            $video_query = new WP_Query($video_args);

            // If no posts with video meta, try category
            if (!$video_query->have_posts()) {
                $video_query = new WP_Query($video_args_alt);
            }

            if ($video_query->have_posts()): ?>
                <div class="news-videos-grid">
                    <?php
                    $video_count = 0;
                    while ($video_query->have_posts() && $video_count < 8):
                        $video_query->the_post();

                        // Get video URL from multiple possible sources
                        $video_url = get_post_meta(get_the_ID(), 'video_url', true);
                        $video_embed = get_post_meta(get_the_ID(), 'video_embed', true);

                        // Try to extract from content if no custom field
                        if (empty($video_url) && empty($video_embed)) {
                            $content = get_the_content();
                            // Match YouTube URLs
                            preg_match('/(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $content, $youtube_matches);
                            // Match Vimeo URLs
                            preg_match('/(https?:\/\/)?(www\.)?(vimeo\.com\/)(\d+)/', $content, $vimeo_matches);

                            if (!empty($youtube_matches[4])) {
                                $video_id = $youtube_matches[4];
                                $video_url = "https://www.youtube.com/watch?v=" . $video_id;
                            } elseif (!empty($vimeo_matches[4])) {
                                $video_id = $vimeo_matches[4];
                                $video_url = "https://vimeo.com/" . $video_id;
                            }
                        }

                        // Get thumbnail
                        $thumbnail_url = '';
                        if ($video_url) {
                            // Extract video ID for thumbnail
                            if (strpos($video_url, 'youtube') !== false || strpos($video_url, 'youtu.be') !== false) {
                                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $video_url, $matches);
                                if (!empty($matches[1])) {
                                    $thumbnail_url = "https://img.youtube.com/vi/{$matches[1]}/maxresdefault.jpg";
                                    // Fallback to high quality if maxres doesn't exist
                                    $thumbnail_url_alt = "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
                                }
                            } elseif (strpos($video_url, 'vimeo') !== false) {
                                // For Vimeo, we'd need to use their API to get thumbnail
                                // For now, use featured image as fallback
                                if (has_post_thumbnail()) {
                                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                }
                            }
                        }

                        // Use featured image as fallback thumbnail
                        if (empty($thumbnail_url) && has_post_thumbnail()) {
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        }

                        // Default placeholder if no thumbnail
                        if (empty($thumbnail_url)) {
                            $thumbnail_url = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgZmlsbD0iIzMzMyIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjIwMCIgeT0iMTUwIiBmaWxsPSIjOTk5IiBmb250LXNpemU9IjIwIiBmb250LWZhbWlseT0iQXJpYWwiPlZpZGVvPC90ZXh0Pjwvc3ZnPg==';
                        }

                        if ($video_url || $video_embed):
                            $video_count++;
                    ?>
                        <div class="news-video-item" data-video-url="<?php echo esc_attr($video_url); ?>">
                            <div class="video-thumbnail-wrapper">
                                <img src="<?php echo esc_url($thumbnail_url); ?>"
                                     alt="<?php the_title_attribute(); ?>"
                                     class="video-thumbnail"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgZmlsbD0iIzMzMyIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjIwMCIgeT0iMTUwIiBmaWxsPSIjOTk5IiBmb250LXNpemU9IjIwIiBmb250LWZhbWlseT0iQXJpYWwiPlZpZGVvPC90ZXh0Pjwvc3ZnPg==';">
                                <div class="video-play-overlay">
                                    <svg class="play-icon" viewBox="0 0 68 48" fill="none">
                                        <path d="M66.52 7.74c-.78-2.93-3.08-5.23-6.01-6.01C55.19 0 34 0 34 0S12.81 0 7.49 1.73c-2.93.78-5.23 3.08-6.01 6.01C0 13.06 0 24 0 24s0 10.94 1.48 16.26c.78 2.93 3.08 5.23 6.01 6.01C12.81 48 34 48 34 48s21.19 0 26.51-1.73c2.93-.78 5.23-3.08 6.01-6.01C68 34.94 68 24 68 24s0-10.94-1.48-16.26z" fill="#FF0000"/>
                                        <path d="M27 34V14l18 10-18 10z" fill="#fff"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="video-title"><?php the_title(); ?></h3>

                            <!-- Hidden embed code for modal -->
                            <div class="video-embed-code" style="display: none;">
                                <?php
                                if ($video_embed) {
                                    echo $video_embed;
                                } elseif ($video_url) {
                                    $embed = wp_oembed_get($video_url, array('width' => 800, 'height' => 450));
                                    echo $embed ?: '<p>Unable to load video</p>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                        endif;
                    endwhile;

                    // Add placeholder items if less than 8 videos
                    for ($i = $video_count; $i < 8; $i++): ?>
                        <div class="news-video-item video-placeholder">
                            <div class="video-thumbnail-wrapper">
                                <div class="video-placeholder-box">
                                    <span>Coming Soon</span>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <?php
                // Add pagination if there are more than 8 videos
                if ($video_query->max_num_pages > 1): ?>
                    <div class="video-pagination">
                        <?php
                        echo paginate_links(array(
                            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format' => '?paged=%#%',
                            'current' => max(1, $paged),
                            'total' => $video_query->max_num_pages,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                            'type' => 'list',
                            'mid_size' => 2,
                            'end_size' => 1
                        ));
                        ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="video-grid-empty">
                    <p>ยังไม่มีวิดีโอในขณะนี้</p>
                    <small>เพิ่มวิดีโอโดยใส่ URL วิดีโอใน Custom Field "video_url" หรือสร้างหมวดหมู่ "video" สำหรับข่าวที่มีวิดีโอ</small>
                </div>
            <?php endif;

            wp_reset_postdata();
            ?>
        </div>
    </section>

    <!-- Video Modal -->
    <div id="videoModal" class="video-modal">
        <div class="video-modal-content">
            <span class="video-modal-close">&times;</span>
            <div class="video-modal-body"></div>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="service-contact">
        <div class="service-container">
            <div class="service-contact-grid">
                <div class="service-contact-left">
                    <h2 class="service-contact-title">Get in touch with any questions</h2>

                    <div class="service-contact-info">
                        <h4>Address</h4>
                        <p>13/5 หมู่ที่ 11 ซอยวัดใหม่จริยาภิรมย์ แขวงคลองสิบสอง เขตหนองจอก กรุงเทพมหานคร,<br>Nong Chok, Thailand, Bangkok</p>
                    </div>

                    <div class="service-contact-info">
                        <h4>Contact</h4>
                        <p>123-456-7890<br>info@mysite.com</p>
                    </div>

                    <div class="service-social">
                        <a href="#" class="service-social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="service-social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="service-contact-right">
                    <p class="service-form-subtitle">Please fill out the form:</p>
                    <form class="service-contact-form">
                        <div class="service-form-row">
                            <div class="service-form-group">
                                <label>ชื่อ</label>
                                <input type="text" name="first_name" required>
                            </div>
                            <div class="service-form-group">
                                <label>นามสกุล</label>
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        <div class="service-form-group">
                            <label>อีเมล</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="service-form-group">
                            <label>ที่อยู่</label>
                            <input type="text" name="address">
                        </div>
                        <div class="service-form-group">
                            <label>โทรศัพท์</label>
                            <input type="tel" name="phone">
                        </div>
                        <button type="submit" class="service-form-submit">ส่ง</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="service-map">
        <div id="service-map-container" style="width: 100%; height: 400px; background: #ddd;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.5447896873453!2d100.72875631483056!3d13.835540990304847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d61f8e9b3c3e1%3A0x3a7e5e5e5e5e5e5e!2sNong%20Chok%2C%20Bangkok!5e0!3m2!1sen!2sth!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Video modal functionality
    const videoModal = document.getElementById('videoModal');
    const modalBody = videoModal.querySelector('.video-modal-body');
    const modalClose = videoModal.querySelector('.video-modal-close');
    const videoItems = document.querySelectorAll('.news-video-item:not(.video-placeholder)');

    // Open video modal when clicking on video item
    videoItems.forEach(item => {
        item.addEventListener('click', function() {
            const embedCode = this.querySelector('.video-embed-code');
            if (embedCode) {
                modalBody.innerHTML = embedCode.innerHTML;
                videoModal.classList.add('active');
                document.body.style.overflow = 'hidden';

                // If iframe exists, update its size
                const iframe = modalBody.querySelector('iframe');
                if (iframe) {
                    iframe.style.width = '100%';
                    iframe.style.height = '100%';
                }
            }
        });
    });

    // Close modal when clicking close button
    modalClose.addEventListener('click', function() {
        closeVideoModal();
    });

    // Close modal when clicking outside the video
    videoModal.addEventListener('click', function(e) {
        if (e.target === videoModal) {
            closeVideoModal();
        }
    });

    // Close modal on ESC key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.classList.contains('active')) {
            closeVideoModal();
        }
    });

    // Function to close modal and stop video
    function closeVideoModal() {
        videoModal.classList.remove('active');
        document.body.style.overflow = '';
        // Clear the modal body to stop the video
        modalBody.innerHTML = '';
    }

    // Lazy load YouTube thumbnails
    const lazyLoadThumbnails = function() {
        const videoThumbnails = document.querySelectorAll('.video-thumbnail[data-lazy-src]');

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.lazySrc;
                    img.removeAttribute('data-lazy-src');
                    observer.unobserve(img);
                }
            });
        });

        videoThumbnails.forEach(img => imageObserver.observe(img));
    };

    // Initialize lazy loading if IntersectionObserver is supported
    if ('IntersectionObserver' in window) {
        lazyLoadThumbnails();
    }

    // Enhance touch responsiveness on mobile
    if ('ontouchstart' in window) {
        videoItems.forEach(item => {
            item.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            item.addEventListener('touchend', function() {
                this.style.transform = '';
            });
        });
    }
});
</script>

<?php
get_footer();
