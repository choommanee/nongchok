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
        const $toggle = $('.wix-mobile-toggle');
        const $nav = $('.wix-nav');
        const $overlay = $('.mobile-menu-overlay');

        console.log('Initializing mobile menu...');
        console.log('Found toggles:', $toggle.length);
        console.log('Found nav:', $nav.length);
        console.log('Found overlay:', $overlay.length);

        // Use event delegation for dynamically loaded elements
        $(document).on('click', '.wix-mobile-toggle', function(e) {
            console.log('Hamburger clicked!');
            e.preventDefault();
            e.stopPropagation();

            const $nav = $('.wix-nav');
            const $toggle = $(this);

            console.log('Nav element found:', $nav.length);
            console.log('Nav classes before:', $nav.attr('class'));

            $nav.toggleClass('active');
            $toggle.toggleClass('active');
            $overlay.toggleClass('active');

            console.log('Nav classes after:', $nav.attr('class'));
            console.log('Nav has active class:', $nav.hasClass('active'));
            console.log('Toggle has active class:', $toggle.hasClass('active'));

            // Force with jQuery
            if (!$nav.hasClass('active')) {
                console.log('Adding active class manually...');
                $nav.addClass('active');
                console.log('After manual add:', $nav.hasClass('active'));
            }
        });

        // Close menu when clicking overlay
        $(document).on('click', '.mobile-menu-overlay', function() {
            console.log('Overlay clicked!');
            $('.wix-nav').removeClass('active');
            $('.wix-mobile-toggle').removeClass('active');
            $(this).removeClass('active');
        });

        // Close menu when clicking on a link
        $(document).on('click', '.wix-menu a', function() {
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
