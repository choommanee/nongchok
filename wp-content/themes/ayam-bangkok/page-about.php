<?php
/**
 * Template Name: About Us - Wix Style
 * Template for About Us page matching Wix design
 */

get_header(); 
?>

<style id="wix-about-override">
/* Inline Wix About Page CSS - Force Load with !important */
body.page-about { padding-top: 0 !important; }
body.page-about .wix-about-page { background: #fff !important; padding-top: 120px !important; margin-top: 0 !important; }
body.page-about .wix-section-container { max-width: 1200px !important; margin: 0 auto !important; padding: 0 40px !important; }
body.page-about .wix-about-hero { background: #fff !important; padding: 80px 40px 40px !important; text-align: center !important; border-bottom: 3px solid #CA4249 !important; margin-top: 0 !important; }
body.page-about .wix-about-hero-content { max-width: 1200px !important; margin: 0 auto !important; }
body.page-about .wix-about-title { font-size: 18px !important; font-weight: 400 !important; color: #666 !important; margin: 0 0 10px 0 !important; letter-spacing: 2px !important; text-transform: uppercase !important; }
body.page-about .wix-about-company { font-size: 48px !important; font-weight: 700 !important; color: #1E2950 !important; margin: 0 !important; letter-spacing: 3px !important; }
body.page-about .wix-our-business { padding: 80px 0 !important; background: #fff !important; }
body.page-about .wix-business-content { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 60px !important; align-items: start !important; }
body.page-about .wix-business-text { padding-right: 40px !important; }
body.page-about .wix-section-title { font-size: 36px !important; font-weight: 700 !important; color: #1E2950 !important; margin: 0 0 15px 0 !important; }
body.page-about .wix-since-text { font-size: 16px !important; color: #666 !important; margin: 0 0 30px 0 !important; font-style: italic !important; }
body.page-about .wix-business-description p, body.page-about .wix-story-description p { font-size: 15px !important; line-height: 1.8 !important; color: #333 !important; margin: 0 0 20px 0 !important; }
body.page-about .wix-business-image { position: relative !important; }
body.page-about .wix-image-placeholder { width: 100% !important; height: 400px !important; background: #000 !important; }
body.page-about .wix-our-story { padding: 80px 0 !important; background: #f8f8f8 !important; }
body.page-about .wix-story-header { margin-bottom: 60px !important; }
body.page-about .wix-story-image-top .wix-image-placeholder { height: 500px !important; margin-bottom: 40px !important; }
body.page-about .wix-story-content { margin-bottom: 60px !important; }
body.page-about .wix-story-text { max-width: 800px !important; }
body.page-about .wix-gallery-grid { display: grid !important; grid-template-columns: repeat(3, 1fr) !important; gap: 30px !important; margin-top: 40px !important; }
body.page-about .wix-gallery-item { background: #fff !important; overflow: hidden !important; }
body.page-about .wix-gallery-image { width: 100% !important; height: 250px !important; background: #ddd !important; }
body.page-about .wix-gallery-title { font-size: 20px !important; font-weight: 600 !important; color: #1E2950 !important; margin: 20px 20px 10px !important; }
body.page-about .wix-gallery-desc { font-size: 14px !important; line-height: 1.6 !important; color: #666 !important; margin: 0 20px 20px !important; }
body.page-about .wix-contact-section { padding: 80px 0 !important; background: #fff !important; }
body.page-about .wix-contact-content { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 80px !important; }
body.page-about .wix-contact-title { font-size: 32px !important; font-weight: 700 !important; color: #1E2950 !important; margin: 0 0 40px 0 !important; }
body.page-about .wix-contact-item { margin-bottom: 30px !important; }
body.page-about .wix-contact-item h4 { font-size: 16px !important; font-weight: 600 !important; color: #1E2950 !important; margin: 0 0 10px 0 !important; }
body.page-about .wix-contact-item p { font-size: 14px !important; line-height: 1.8 !important; color: #666 !important; margin: 0 !important; }
body.page-about .wix-contact-item a { color: #CA4249 !important; text-decoration: none !important; }
body.page-about .wix-social-links { display: flex !important; gap: 15px !important; margin-top: 20px !important; }
body.page-about .wix-social-icon { display: flex !important; align-items: center !important; justify-content: center !important; width: 40px !important; height: 40px !important; background: #1E2950 !important; color: #fff !important; border-radius: 50% !important; text-decoration: none !important; transition: all 0.3s ease !important; }
body.page-about .wix-social-icon:hover { background: #CA4249 !important; transform: translateY(-3px) !important; }
body.page-about .wix-form { display: flex !important; flex-direction: column !important; gap: 20px !important; }
body.page-about .wix-form-row { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 20px !important; }
body.page-about .wix-form-group input, body.page-about .wix-form-group textarea { padding: 12px 15px !important; border: 1px solid #ddd !important; border-radius: 0 !important; font-size: 14px !important; font-family: inherit !important; }
body.page-about .wix-form-group input:focus, body.page-about .wix-form-group textarea:focus { outline: none !important; border-color: #CA4249 !important; }
body.page-about .wix-submit-btn { padding: 15px 40px !important; background: #CA4249 !important; color: #fff !important; border: none !important; font-size: 16px !important; font-weight: 600 !important; cursor: pointer !important; transition: all 0.3s ease !important; align-self: flex-start !important; }
body.page-about .wix-submit-btn:hover { background: #b33940 !important; transform: translateY(-2px) !important; box-shadow: 0 4px 12px rgba(202, 66, 73, 0.3) !important; }
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

<script>
// Move inline CSS to end of head to override all other styles
(function() {
    var style = document.getElementById('wix-about-override');
    if (style) {
        document.head.appendChild(style);
    }
})();
</script>

<?php get_footer(); ?>