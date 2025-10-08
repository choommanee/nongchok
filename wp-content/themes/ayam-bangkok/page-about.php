<?php
/**
 * Template Name: About Us - Wix Style
 * Template for About Us page matching Wix design
 */

get_header(); 

// Debug: Check if CSS is loaded
error_log('About page template loaded: page-about.php');
?>

<main id="primary" class="site-main wix-about-page">
    
    <!-- Hero Section -->
    <section class="wix-about-hero">
        <div class="wix-about-hero-content">
            <h1 class="wix-about-title">About</h1>
            <h2 class="wix-about-company">AYAM BANGKOK</h2>
        </div>
    </section>

    <!-- Our Business Section -->
    <section class="wix-our-business">
        <div class="wix-section-container">
            <div class="wix-business-content">
                <div class="wix-business-text">
                    <h2 class="wix-section-title">Our Business</h2>
                    <p class="wix-since-text">Since 2025</p>
                    <div class="wix-business-description">
                        <p>I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me to add your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                        <p>This is a great space to write a long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.</p>
                    </div>
                </div>
                <div class="wix-business-image">
                    <div class="wix-image-placeholder"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="wix-our-story">
        <div class="wix-section-container">
            <div class="wix-story-header">
                <div class="wix-story-image-top">
                    <div class="wix-image-placeholder"></div>
                </div>
            </div>
            <div class="wix-story-content">
                <div class="wix-story-text">
                    <h2 class="wix-section-title">Our Story</h2>
                    <div class="wix-story-description">
                        <p>I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me to add your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.</p>
                        <p>This is a great space to write a long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.</p>
                    </div>
                </div>
            </div>
            
            <!-- Video/Image Gallery Grid -->
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
                                <label>First Name *</label>
                                <input type="text" required>
                            </div>
                            <div class="wix-form-group">
                                <label>Last Name *</label>
                                <input type="text" required>
                            </div>
                        </div>
                        <div class="wix-form-group">
                            <label>Email *</label>
                            <input type="email" required>
                        </div>
                        <div class="wix-form-group">
                            <label>Subject</label>
                            <input type="text">
                        </div>
                        <div class="wix-form-group">
                            <label>Message</label>
                            <textarea rows="4"></textarea>
                        </div>
                        <button type="submit" class="wix-submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>