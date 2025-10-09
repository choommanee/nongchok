<?php
/**
 * Template Name: News Page (Wix Style)
 * Matching https://saeliwid.wixsite.com/my-site-3/news-1
 * Video Gallery Layout
 */

get_header();

// Query news posts for video gallery
$args = array(
    'post_type' => 'ayam_news',
    'posts_per_page' => 8,
    'orderby' => 'date',
    'order' => 'DESC'
);

$news_query = new WP_Query($args);

?>

<main id="primary" class="site-main wix-style-news">

    <!-- News Hero Section -->
    <section class="news-hero-section">
        <div class="container">
            <div class="news-hero-content" data-aos="fade-up">
                <h1 class="news-main-title">News</h1>
            </div>
        </div>
    </section>

    <!-- Video Gallery Grid -->
    <section class="news-video-grid-section">
        <div class="container">
            <?php if ($news_query->have_posts()): ?>
                <div class="news-video-grid" data-aos="fade-up">
                    <?php
                    $count = 0;
                    while ($news_query->have_posts()) :
                        $news_query->the_post();
                        $count++;
                        $video_duration = get_post_meta(get_the_ID(), 'video_duration', true) ?: '00:23';
                    ?>
                        <article class="news-video-card" data-aos="fade-up" data-aos-delay="<?php echo ($count % 8) * 50; ?>">
                            <a href="<?php the_permalink(); ?>" class="news-video-link">
                                <div class="news-video-thumbnail">
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('large'); ?>
                                    <?php else: ?>
                                        <div class="news-video-placeholder"></div>
                                    <?php endif; ?>

                                    <!-- Play Button Overlay -->
                                    <div class="news-video-play-overlay">
                                        <div class="news-video-play-button">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>

                                    <!-- Video Duration -->
                                    <span class="news-video-duration"><?php echo esc_html($video_duration); ?></span>
                                </div>

                                <div class="news-video-content">
                                    <h2 class="news-video-title">
                                        <?php the_title(); ?>
                                    </h2>

                                    <div class="news-video-desc">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                    </div>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                // Pagination
                if ($news_query->max_num_pages > 1):
                ?>
                    <div class="news-pagination" data-aos="fade-up">
                        <?php
                        echo paginate_links(array(
                            'total' => $news_query->max_num_pages,
                            'prev_text' => '<i class="fas fa-chevron-left"></i>',
                            'next_text' => '<i class="fas fa-chevron-right"></i>',
                        ));
                        ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="no-news-message">
                    <i class="far fa-video"></i>
                    <p>ยังไม่มีวิดีโอในขณะนี้</p>
                    <small>กรุณาเพิ่มข่าวสารจากหลังบ้าน</small>
                </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

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

<?php
get_footer();
