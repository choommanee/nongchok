<?php
/**
 * Template Name: Gallery - Wix Style
 * Template for Gallery page matching Wix design
 */

get_header(); ?>

<main id="primary" class="site-main wix-gallery-page">
    
    <!-- Hero Section -->
    <section class="wix-page-hero">
        <div class="wix-hero-content">
            <h1 class="wix-hero-title">AYAM LIST</h1>
        </div>
    </section>

    <!-- Rooster Gallery Grid -->
    <section class="wix-rooster-gallery-section">
        <div class="wix-section-container">
            <div class="wix-rooster-grid">
                <?php
                // Get rooster posts
                $rooster_query = new WP_Query(array(
                    'post_type' => 'ayam_rooster',
                    'posts_per_page' => 4,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($rooster_query->have_posts()) :
                    while ($rooster_query->have_posts()) : $rooster_query->the_post();
                        $price = get_post_meta(get_the_ID(), 'rooster_price', true);
                ?>
                    <div class="wix-rooster-card">
                        <div class="wix-rooster-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <div class="wix-rooster-placeholder"></div>
                            <?php endif; ?>
                        </div>
                        <div class="wix-rooster-info">
                            <p class="wix-rooster-price"><?php echo $price ? esc_html($price) : 'ราคา: ติดต่อสอบถาม'; ?></p>
                            <h3 class="wix-rooster-name"><?php the_title(); ?></h3>
                            <a href="<?php the_permalink(); ?>" class="wix-rooster-btn">More Info</a>
                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : 
                    // Default rooster cards
                    for ($i = 1; $i <= 4; $i++) :
                ?>
                    <div class="wix-rooster-card">
                        <div class="wix-rooster-image">
                            <div class="wix-rooster-placeholder"></div>
                        </div>
                        <div class="wix-rooster-info">
                            <p class="wix-rooster-price">฿ 20,000 - ฿ 50,000 บาท</p>
                            <h3 class="wix-rooster-name">Service Name</h3>
                            <a href="#" class="wix-rooster-btn">More Info</a>
                        </div>
                    </div>
                <?php 
                    endfor;
                endif; 
                ?>
            </div>
        </div>
    </section>

    <!-- Video Gallery Section -->
    <section class="wix-video-gallery">
        <div class="wix-section-container">
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
