<?php
/**
 * Template Name: About Us - Wix Style
 * Template for About Us page matching Wix design
 */

get_header(); 

// Force load CSS
wp_enqueue_style('wix-about-page-inline', get_template_directory_uri() . '/assets/css/wix-about-page.css', array(), time());
?>

<style>
/* Inline Wix About Page CSS - Force Load */
.wix-about-page { background: #fff; padding-top: 0; }
.wix-section-container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }
.wix-about-hero { background: #fff; padding: 80px 40px 40px; text-align: center; border-bottom: 3px solid #CA4249; }
.wix-about-hero-content { max-width: 1200px; margin: 0 auto; }
.wix-about-title { font-size: 18px; font-weight: 400; color: #666; margin: 0 0 10px 0; letter-spacing: 2px; text-transform: uppercase; }
.wix-about-company { font-size: 48px; font-weight: 700; color: #1E2950; margin: 0; letter-spacing: 3px; }
.wix-our-business { padding: 80px 0; background: #fff; }
.wix-business-content { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; }
.wix-business-text { padding-right: 40px; }
.wix-section-title { font-size: 36px; font-weight: 700; color: #1E2950; margin: 0 0 15px 0; }
.wix-since-text { font-size: 16px; color: #666; margin: 0 0 30px 0; font-style: italic; }
.wix-business-description p, .wix-story-description p { font-size: 15px; line-height: 1.8; color: #333; margin: 0 0 20px 0; }
.wix-business-image { position: relative; }
.wix-image-placeholder { width: 100%; height: 400px; background: #000; }
.wix-our-story { padding: 80px 0; background: #f8f8f8; }
.wix-story-header { margin-bottom: 60px; }
.wix-story-image-top .wix-image-placeholder { height: 500px; margin-bottom: 40px; }
.wix-story-content { margin-bottom: 60px; }
.wix-story-text { max-width: 800px; }
.wix-gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 40px; }
.wix-gallery-item { background: #fff; overflow: hidden; }
.wix-gallery-image { width: 100%; height: 250px; background: #ddd; }
.wix-gallery-title { font-size: 20px; font-weight: 600; color: #1E2950; margin: 20px 20px 10px; }
.wix-gallery-desc { font-size: 14px; line-height: 1.6; color: #666; margin: 0 20px 20px; }
.wix-contact-section { padding: 80px 0; background: #fff; }
.wix-contact-content { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; }
.wix-contact-title { font-size: 32px; font-weight: 700; color: #1E2950; margin: 0 0 40px 0; }
.wix-contact-item { margin-bottom: 30px; }
.wix-contact-item h4 { font-size: 16px; font-weight: 600; color: #1E2950; margin: 0 0 10px 0; }
.wix-contact-item p { font-size: 14px; line-height: 1.8; color: #666; margin: 0; }
.wix-contact-item a { color: #CA4249; text-decoration: none; }
.wix-social-links { display: flex; gap: 15px; margin-top: 20px; }
.wix-social-icon { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1E2950; color: #fff; border-radius: 50%; text-decoration: none; transition: all 0.3s ease; }
.wix-social-icon:hover { background: #CA4249; transform: translateY(-3px); }
.wix-form { display: flex; flex-direction: column; gap: 20px; }
.wix-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.wix-form-group input, .wix-form-group textarea { padding: 12px 15px; border: 1px solid #ddd; border-radius: 0; font-size: 14px; font-family: inherit; }
.wix-form-group input:focus, .wix-form-group textarea:focus { outline: none; border-color: #CA4249; }
.wix-submit-btn { padding: 15px 40px; background: #CA4249; color: #fff; border: none; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; align-self: flex-start; }
.wix-submit-btn:hover { background: #b33940; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(202, 66, 73, 0.3); }
@media (max-width: 1024px) {
    .wix-business-content, .wix-contact-content { grid-template-columns: 1fr; gap: 40px; }
    .wix-business-text { padding-right: 0; }
    .wix-gallery-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .wix-about-company { font-size: 36px; }
    .wix-section-title { font-size: 28px; }
    .wix-gallery-grid { grid-template-columns: 1fr; }
    .wix-form-row { grid-template-columns: 1fr; }
}
</style>

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