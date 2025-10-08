<?php
/**
 * Template Name: News - Wix Style
 * Template for News page matching Wix design
 */

get_header(); ?>

<main id="primary" class="site-main wix-news-page">
    
    <!-- Hero Section -->
    <section class="wix-page-hero">
        <div class="wix-hero-content">
            <h1 class="wix-hero-title">Article & News</h1>
        </div>
    </section>

    <!-- News Grid Section -->
    <section class="wix-news-grid-section">
        <div class="wix-section-container">
            <div class="wix-news-grid">
                <?php
                // Get latest news posts
                $news_query = new WP_Query(array(
                    'post_type' => 'ayam_news',
                    'posts_per_page' => 4,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post();
                ?>
                    <div class="wix-news-card">
                        <div class="wix-news-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <div class="wix-news-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="wix-news-content">
                            <h3><?php the_title(); ?></h3>
                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : 
                    // Default news cards
                    for ($i = 1; $i <= 4; $i++) :
                ?>
                    <div class="wix-news-card">
                        <div class="wix-news-image">
                            <div class="wix-news-placeholder"></div>
                        </div>
                        <div class="wix-news-content">
                            <h3>content News</h3>
                        </div>
                    </div>
                <?php 
                    endfor;
                endif; 
                ?>
            </div>
        </div>
    </section>

    <!-- Video Content Section -->
    <section class="wix-video-content-section">
        <div class="wix-section-container">
            <h2 class="wix-section-title-center">Video Content</h2>
            
            <div class="wix-gallery-grid">
                <div class="wix-gallery-item">
                    <div class="wix-gallery-image"></div>
                    <h3 class="wix-gallery-title">Video Title</h3>
                    <p class="wix-gallery-desc">This is a great space to give more details about what you do and why you do it.</p>
                </div>
                <div class="wix-gallery-item">
                    <div class="wix-gallery-image"></div>
                    <h3 class="wix-gallery-title">Video Title</h3>
                    <p class="wix-gallery-desc">This is a great space to give more details about what you do and why you do it.</p>
                </div>
                <div class="wix-gallery-item">
                    <div class="wix-gallery-image"></div>
                    <h3 class="wix-gallery-title">Video Title</h3>
                    <p class="wix-gallery-desc">This is a great space to give more details about what you do and why you do it.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="wix-contact-section">
        <div class="wix-section-container">
            <div class="wix-contact-content">
                <div class="wix-contact-info">
                    <h2 class="wix-contact-title">Get in touch with any questions</h2>
                    <div class="wix-contact-details">
                        <div class="wix-contact-item">
                            <h4>Address</h4>
                            <p>13/5 หมู่ที่ 11 ซอยวัดใหม่เจริญราษฏร์<br>
                            แขวงคลองสิบสอง เขตหนองจอก<br>
                            กรุงเทพมหานคร, Nong Chok, Thailand, Bangkok</p>
                        </div>
                        <div class="wix-contact-item">
                            <h4>Contact</h4>
                            <p>123-456-7890<br>
                            <a href="mailto:info@mysite.com">info@mysite.com</a></p>
                        </div>
                        <div class="wix-social-links">
                            <a href="#" class="wix-social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="wix-social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="wix-contact-form">
                    <p class="wix-form-intro">Please fill out the form:</p>
                    <form class="wix-form">
                        <div class="wix-form-row">
                            <div class="wix-form-group">
                                <input type="text" placeholder="Name" required>
                            </div>
                            <div class="wix-form-group">
                                <input type="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="wix-form-group">
                            <input type="text" placeholder="Subject">
                        </div>
                        <div class="wix-form-group">
                            <input type="tel" placeholder="Phone">
                        </div>
                        <div class="wix-form-group">
                            <textarea rows="4" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" class="wix-submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
