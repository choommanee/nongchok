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

@media (max-width: 1024px) {
    .news-articles-grid {
        grid-template-columns: repeat(3, 1fr);
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

    .news-video-section h2 {
        font-size: 2rem;
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
            <!-- Video content will go here in future -->
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
