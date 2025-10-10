<?php
/**
 * Template Name: Contact Page (Wix Style)
 * Matching Service/News/Gallery page structure
 */

get_header();

// Get company information from Customizer
$company_address = get_theme_mod('contact_address', 'ถนน พุทธบูชา 11 ตำบลโคกเจริญ แขวงหนองจอก เขตหนองจอก Nong Chok, Bangkok, Thailand');
$company_phone = get_theme_mod('contact_phone', '089-091-4664');
$company_email = get_theme_mod('contact_email', 'info@ayambangkok.com');
$company_line = get_theme_mod('ayam_line_id', '@nongchok');
$company_facebook = get_theme_mod('ayam_facebook', '');
$company_youtube = get_theme_mod('ayam_youtube', '');
?>

<main id="primary" class="site-main wix-style-contact">

    <!-- Hero Section -->
    <section class="service-hero">
        <div class="service-hero-container">
            <?php
            $contact_title = get_theme_mod('contact_title', 'Get in Touch');
            $contact_subtitle = get_theme_mod('contact_subtitle', "We'd love to hear from you");
            ?>
            <h1 class="service-hero-subtitle"><?php echo esc_html($contact_title); ?></h1>
            <p class="service-hero-title">Contact Us</p>
            <div class="service-hero-line"></div>
            <?php if ($contact_subtitle) : ?>
                <p class="service-hero-description"><?php echo esc_html($contact_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Info Cards Section -->
    <section class="contact-cards-section">
        <div class="service-container">
            <div class="contact-cards-grid">

                <!-- Address Card -->
                <div class="contact-info-card">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Address</h3>
                    <p><?php echo esc_html($company_address); ?></p>
                </div>

                <!-- Phone Card -->
                <div class="contact-info-card">
                    <div class="card-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Phone</h3>
                    <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $company_phone)); ?>"><?php echo esc_html($company_phone); ?></a></p>
                    <?php if ($company_line) : ?>
                    <p class="line-id">
                        <i class="fab fa-line"></i> LINE: <?php echo esc_html($company_line); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <!-- Email Card -->
                <div class="contact-info-card">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p><a href="mailto:<?php echo esc_attr($company_email); ?>"><?php echo esc_html($company_email); ?></a></p>
                </div>

                <!-- Hours Card -->
                <div class="contact-info-card">
                    <div class="card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Business Hours</h3>
                    <p>Mon - Fri: 8:00 AM - 5:00 PM</p>
                    <p>Sat: 8:00 AM - 12:00 PM</p>
                    <p>Sun: Closed</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact Form & Map Section (Same as Service page) -->
    <section class="service-contact">
        <div class="service-container">
            <div class="service-contact-grid">

                <!-- Left: Contact Info -->
                <div class="service-contact-left">
                    <h2 class="service-contact-title">Get in touch with any questions</h2>
                    <div class="service-contact-info">
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Phone</strong>
                                <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $company_phone)); ?>"><?php echo esc_html($company_phone); ?></a></p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <p><a href="mailto:<?php echo esc_attr($company_email); ?>"><?php echo esc_html($company_email); ?></a></p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Address</strong>
                                <p><?php echo esc_html($company_address); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="service-social-icons">
                        <?php if ($company_facebook) : ?>
                        <a href="<?php echo esc_url($company_facebook); ?>" target="_blank" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($company_youtube) : ?>
                        <a href="<?php echo esc_url($company_youtube); ?>" target="_blank" class="social-icon">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <?php endif; ?>
                        <a href="https://line.me/ti/p/~<?php echo esc_attr($company_line); ?>" target="_blank" class="social-icon">
                            <i class="fab fa-line"></i>
                        </a>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="service-contact-right">
                    <p class="service-form-subtitle">Please fill out the form:</p>
                    <form class="service-contact-form" id="contact-form">
                        <?php wp_nonce_field('contact_form', 'contact_nonce'); ?>

                        <div class="form-group">
                            <input type="text" id="contact_name" name="contact_name" placeholder="Name *" required>
                        </div>

                        <div class="form-row-2col">
                            <div class="form-group">
                                <input type="email" id="contact_email" name="contact_email" placeholder="Email *" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" id="contact_phone" name="contact_phone" placeholder="Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <select id="contact_subject" name="contact_subject" required>
                                <option value="">Subject *</option>
                                <option value="general">General Inquiry</option>
                                <option value="rooster">About Roosters</option>
                                <option value="service">Service Inquiry</option>
                                <option value="export">Export Inquiry</option>
                                <option value="visit">Visit Appointment</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <textarea id="contact_message" name="contact_message" rows="5" placeholder="Message *" required></textarea>
                        </div>

                        <button type="submit" class="service-submit-btn">
                            Send Message
                            <i class="fas fa-arrow-right"></i>
                        </button>

                        <div class="form-response" style="display: none;"></div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="service-map">
        <div id="service-map-container" style="width: 100%; height: 400px;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.9644774857647!2d100.75366931484233!3d13.725840990354915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d664d6c477e45%3A0x6c1e1c1e1c1e1c1e!2z4Lir4LiZ4Lit4LiH4LiI4Lit4LiB!5e0!3m2!1sth!2sth!4v1234567890123!5m2!1sth!2sth"
                width="100%"
                height="400"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
