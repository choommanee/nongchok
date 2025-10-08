<?php
/**
 * Template Name: About Us - Wix Style (New)
 * Copy structure from front-page.php
 */

get_header(); ?>

<main id="primary" class="site-main wix-style-about">
    
    <!-- Hero Section - About -->
    <section class="wix-hero-section wix-about-hero-section">
        <div class="hero-text-section">
            <div class="container">
                <div class="hero-text-center">
                    <h1 class="hero-main-title" data-aos="fade-up">About<br>AYAM BANGKOK</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Business Section -->
    <section class="wix-about-intro">
        <div class="container">
            <div class="about-intro-grid">
                <div class="about-intro-content">
                    <h2 class="section-title" data-aos="fade-up">Our Business</h2>
                    <div class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                        Since 2025
                    </div>
                    <p class="intro-text" data-aos="fade-up" data-aos-delay="200">
                        I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me to add your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.
                    </p>
                    <p class="intro-text" data-aos="fade-up" data-aos-delay="300">
                        This is a great space to write a long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.
                    </p>
                </div>
                <div class="about-intro-images" data-aos="fade-left" data-aos-delay="200">
                    <div class="intro-image-single">
                        <div style="width: 100%; height: 400px; background: #000;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="wix-story-section" style="background: #f8f8f8; padding: 80px 0;">
        <div class="container">
            <!-- Story Header Image -->
            <div class="story-header-image" data-aos="fade-up">
                <div style="width: 100%; height: 500px; background: #000; margin-bottom: 60px;"></div>
            </div>
            
            <!-- Story Content -->
            <div class="about-intro-content" style="max-width: 800px;">
                <h2 class="section-title" data-aos="fade-up">Our Story</h2>
                <p class="intro-text" data-aos="fade-up" data-aos-delay="100">
                    I'm a paragraph. Click here to add your own text and edit me. It's easy. Just click "Edit Text" or double click me to add your own content and make changes to the font. Feel free to drag and drop me anywhere you like on your page. I'm a great place for you to tell a story and let your users know a little more about you.
                </p>
                <p class="intro-text" data-aos="fade-up" data-aos-delay="200">
                    This is a great space to write a long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.
                </p>
            </div>
            
            <!-- Video Gallery Grid -->
            <div class="video-gallery-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-top: 60px;">
                <?php for ($i = 1; $i <= 3; $i++) : ?>
                <div class="video-item" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
                    <div style="width: 100%; height: 250px; background: #ddd; margin-bottom: 20px;"></div>
                    <h3 style="font-size: 20px; font-weight: 600; color: #1E2950; margin: 0 0 10px 0;">Video Title</h3>
                    <p style="font-size: 14px; color: #666; margin: 0;">This is a great space to give more details about what you do and why you do it.</p>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="wix-contact-section" style="padding: 80px 0; background: #fff;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px;">
                <!-- Contact Info -->
                <div class="contact-info">
                    <h2 class="section-title" data-aos="fade-up">Get in touch with any questions</h2>
                    
                    <div style="margin: 40px 0;">
                        <h4 style="font-size: 16px; font-weight: 600; color: #1E2950; margin: 0 0 10px 0;">Address</h4>
                        <p style="font-size: 14px; line-height: 1.8; color: #666; margin: 0;">
                            13/5 หมู่ที่ 11 ซอยวัดใหม่เจริญราษฏร์<br>
                            แขวงคลองสิบสอง เขตหนองจอก<br>
                            กรุงเทพมหานคร, Nong Chok, Thailand, Bangkok
                        </p>
                    </div>
                    
                    <div style="margin: 30px 0;">
                        <h4 style="font-size: 16px; font-weight: 600; color: #1E2950; margin: 0 0 10px 0;">Contact</h4>
                        <p style="font-size: 14px; line-height: 1.8; color: #666; margin: 0;">
                            123-456-7890<br>
                            <a href="mailto:info@mysite.com" style="color: #CA4249; text-decoration: none;">info@mysite.com</a>
                        </p>
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <a href="#" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1E2950; color: #fff; border-radius: 50%; text-decoration: none;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #1E2950; color: #fff; border-radius: 50%; text-decoration: none;">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form" data-aos="fade-left">
                    <p style="font-size: 14px; color: #666; margin: 0 0 20px 0;">Please fill out the form:</p>
                    <form style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <input type="text" placeholder="Name" required style="padding: 12px 15px; border: 1px solid #ddd; font-size: 14px;">
                            <input type="email" placeholder="Email" required style="padding: 12px 15px; border: 1px solid #ddd; font-size: 14px;">
                        </div>
                        <input type="text" placeholder="Subject" style="padding: 12px 15px; border: 1px solid #ddd; font-size: 14px;">
                        <input type="tel" placeholder="Phone" style="padding: 12px 15px; border: 1px solid #ddd; font-size: 14px;">
                        <textarea rows="4" placeholder="Message" style="padding: 12px 15px; border: 1px solid #ddd; font-size: 14px; resize: vertical;"></textarea>
                        <button type="submit" style="padding: 15px 40px; background: #CA4249; color: #fff; border: none; font-size: 16px; font-weight: 600; cursor: pointer; align-self: flex-start;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
