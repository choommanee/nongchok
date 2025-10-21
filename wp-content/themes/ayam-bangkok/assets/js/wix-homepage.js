/**
 * Wix-Style Homepage JavaScript
 */

(function($) {
    'use strict';
    
    // Initialize on DOM ready
    $(document).ready(function() {
        initHeroSlider();
        initAOS();
        initContactForm();
        initMobileMenu();
    });
    
    /**
     * Initialize Hero Slider
     */
    function initHeroSlider() {
        if (typeof Swiper === 'undefined') {
            console.warn('Swiper not loaded');
            return;
        }
        
        const heroSwiper = new Swiper('.hero-swiper-wix', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            speed: 800,
            effect: 'slide',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        
        console.log('Hero Swiper initialized:', heroSwiper);
    }
    
    /**
     * Initialize AOS (Animate On Scroll)
     */
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-out',
                once: true,
                offset: 100,
            });
            
            console.log('AOS initialized');
        }
    }
    
    /**
     * Handle Contact Form
     */
    function initContactForm() {
        $('.wix-contact-form').on('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = {
                first_name: $(this).find('[name="first_name"]').val(),
                last_name: $(this).find('[name="last_name"]').val(),
                email: $(this).find('[name="email"]').val(),
                message: $(this).find('[name="message"]').val(),
            };
            
            // Simple validation
            if (!formData.first_name || !formData.last_name || !formData.email || !formData.message) {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                return;
            }
            
            // Here you can add AJAX submission to WordPress
            // For now, just show success message
            alert('ส่งข้อความสำเร็จ! เราจะติดต่อกลับโดยเร็วที่สุด');
            $(this)[0].reset();
        });
    }
    
    /**
     * Initialize Mobile Menu Toggle
     */
    function initMobileMenu() {
        console.log('Initializing mobile menu...');
        console.log('Found toggles:', $('.wix-mobile-toggle').length);
        console.log('Found nav:', $('.wix-nav').length);

        // Toggle menu and overlay
        $('.wix-mobile-toggle').on('click', function(e) {
            console.log('Hamburger clicked!');
            e.stopPropagation();
            $('.wix-nav').toggleClass('active');
            $(this).toggleClass('active');
            $('.mobile-menu-overlay').toggleClass('active');
            console.log('Nav has active class:', $('.wix-nav').hasClass('active'));
        });

        // Close menu when clicking overlay
        $('.mobile-menu-overlay').on('click', function() {
            console.log('Overlay clicked!');
            $('.wix-nav').removeClass('active');
            $('.wix-mobile-toggle').removeClass('active');
            $(this).removeClass('active');
        });

        // Close menu when clicking on a link
        $('.wix-menu a').on('click', function() {
            console.log('Menu link clicked!');
            $('.wix-nav').removeClass('active');
            $('.wix-mobile-toggle').removeClass('active');
            $('.mobile-menu-overlay').removeClass('active');
        });
    }
    
    /**
     * Smooth Scroll for anchor links
     */
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });
    
})(jQuery);
