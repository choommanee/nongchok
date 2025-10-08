/**
 * Hero Slider Fix - Direct Implementation
 */

// Wait for DOM and libraries to load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Slider Fix: DOM loaded');
    
    // Initialize slider with retry mechanism
    let retryCount = 0;
    const maxRetries = 10;
    
    function initializeHeroSlider() {
        console.log('Slider Fix: Attempting to initialize, retry:', retryCount);
        
        // Check if Swiper is available
        if (typeof Swiper === 'undefined') {
            console.log('Slider Fix: Swiper not loaded yet, retrying...');
            retryCount++;
            if (retryCount < maxRetries) {
                setTimeout(initializeHeroSlider, 500);
            } else {
                console.log('Slider Fix: Max retries reached, using fallback');
                initFallbackSlider();
            }
            return;
        }
        
        const heroSlider = document.querySelector('.hero-swiper');
        if (!heroSlider) {
            console.log('Slider Fix: No hero slider found');
            return;
        }
        
        // Destroy existing instance if any
        if (heroSlider.swiper) {
            console.log('Slider Fix: Destroying existing swiper');
            heroSlider.swiper.destroy(true, true);
        }
        
        // CRITICAL: Fix background images before creating Swiper
        fixSlideBackgrounds();
        
        try {
            console.log('Slider Fix: Creating new Swiper instance');
            
            const swiper = new Swiper('.hero-swiper', {
                // Basic settings
                loop: true,
                speed: 1000,
                spaceBetween: 0,
                centeredSlides: true,
                
                // Autoplay
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                
                // Effects - CHANGED FROM FADE TO SLIDE
                effect: 'slide',
                
                // Navigation
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                
                // Pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: false,
                },
                
                // Keyboard control
                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                },
                
                // Touch settings
                touchRatio: 1,
                touchAngle: 45,
                grabCursor: true,
                
                // Accessibility
                a11y: {
                    enabled: true,
                    prevSlideMessage: 'Previous slide',
                    nextSlideMessage: 'Next slide',
                },
                
                // Events
                on: {
                    init: function() {
                        console.log('Slider Fix: Swiper initialized successfully');
                        animateSlideContent();
                        
                        // Remove loading class if exists
                        const sliderSection = document.querySelector('.hero-slider-section');
                        if (sliderSection) {
                            sliderSection.classList.remove('loading');
                        }
                    },
                    slideChange: function() {
                        console.log('Slider Fix: Slide changed');
                        animateSlideContent();
                    },
                    autoplayStart: function() {
                        console.log('Slider Fix: Autoplay started');
                    },
                    autoplayStop: function() {
                        console.log('Slider Fix: Autoplay stopped');
                    }
                }
            });
            
            console.log('Slider Fix: Swiper created successfully:', swiper);
            
            // Store reference
            window.heroSwiper = swiper;
            
        } catch (error) {
            console.error('Slider Fix: Error creating Swiper:', error);
            initFallbackSlider();
        }
    }
    
    // Fallback slider without Swiper
    function initFallbackSlider() {
        console.log('Slider Fix: Initializing fallback slider');
        
        const slides = document.querySelectorAll('.swiper-slide');
        if (slides.length <= 1) {
            console.log('Slider Fix: Only one slide, no need for fallback');
            animateSlideContent();
            return;
        }
        
        let currentSlide = 0;
        
        // Hide all slides except first
        slides.forEach((slide, index) => {
            slide.style.display = index === 0 ? 'flex' : 'none';
            slide.style.opacity = index === 0 ? '1' : '0';
        });
        
        // Animate first slide
        animateSlideContent();
        
        // Auto-rotate slides
        const interval = setInterval(() => {
            // Hide current slide
            slides[currentSlide].style.opacity = '0';
            setTimeout(() => {
                slides[currentSlide].style.display = 'none';
                
                // Show next slide
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].style.display = 'flex';
                setTimeout(() => {
                    slides[currentSlide].style.opacity = '1';
                    animateSlideContent();
                }, 50);
            }, 500);
        }, 6000);
        
        // Store interval for cleanup
        window.fallbackSliderInterval = interval;
        
        console.log('Slider Fix: Fallback slider initialized');
    }
    
    // Animate slide content
    function animateSlideContent() {
        console.log('Slider Fix: Animating slide content');
        
        // Remove animations from all slides first
        const allSlideContents = document.querySelectorAll('.slide-content');
        allSlideContents.forEach(content => {
            content.classList.remove('slide-animate');
            content.style.opacity = '0';
        });
        
        // Find active slide
        let activeSlideContent = document.querySelector('.swiper-slide-active .slide-content');
        if (!activeSlideContent) {
            // Fallback: find visible slide
            const visibleSlide = Array.from(document.querySelectorAll('.swiper-slide')).find(slide => {
                const style = window.getComputedStyle(slide);
                return style.display !== 'none' && style.opacity !== '0';
            });
            if (visibleSlide) {
                activeSlideContent = visibleSlide.querySelector('.slide-content');
            }
        }
        
        if (activeSlideContent) {
            console.log('Slider Fix: Found active slide content, animating');
            
            // Show content
            activeSlideContent.style.opacity = '1';
            
            // Add animation class
            setTimeout(() => {
                activeSlideContent.classList.add('slide-animate');
                
                // Animate individual elements
                const title = activeSlideContent.querySelector('.slide-title');
                const description = activeSlideContent.querySelector('.slide-description');
                const buttons = activeSlideContent.querySelector('.slide-buttons');
                
                if (title) {
                    title.style.opacity = '0';
                    title.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        title.style.transition = 'all 0.8s ease';
                        title.style.opacity = '1';
                        title.style.transform = 'translateY(0)';
                    }, 200);
                }
                
                if (description) {
                    description.style.opacity = '0';
                    description.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        description.style.transition = 'all 0.8s ease';
                        description.style.opacity = '1';
                        description.style.transform = 'translateY(0)';
                    }, 400);
                }
                
                if (buttons) {
                    buttons.style.opacity = '0';
                    buttons.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        buttons.style.transition = 'all 0.8s ease';
                        buttons.style.opacity = '1';
                        buttons.style.transform = 'translateY(0)';
                    }, 600);
                }
            }, 100);
        } else {
            console.log('Slider Fix: No active slide content found');
        }
    }
    
    // Function to fix slide backgrounds
    function fixSlideBackgrounds() {
        console.log('Slider Fix: Fixing slide backgrounds');
        
        const slides = document.querySelectorAll('.hero-swiper .swiper-slide');
        slides.forEach((slide, index) => {
            const style = slide.getAttribute('style');
            console.log('Slide ' + (index + 1) + ' current style:', style);
            
            // Check if background-image is missing but we have the URL printed nearby
            if (!style || !style.includes('background-image')) {
                // Look for the URL that was echoed in PHP
                const slideContainer = slide.parentElement;
                const textNodes = [];
                const walker = document.createTreeWalker(
                    slideContainer,
                    NodeFilter.SHOW_TEXT,
                    null,
                    false
                );
                
                let node;
                while (node = walker.nextNode()) {
                    if (node.textContent.includes('wp-content/uploads')) {
                        const url = node.textContent.trim();
                        console.log('Found image URL:', url);
                        
                        // Apply the background image
                        slide.style.backgroundImage = `url('${url}')`;
                        slide.style.backgroundSize = 'cover';
                        slide.style.backgroundPosition = 'center center';
                        slide.style.backgroundRepeat = 'no-repeat';
                        
                        console.log('Applied background to slide ' + (index + 1));
                        
                        // Remove the text node
                        node.remove();
                        break;
                    }
                }
            }
        });
    }
    
    // Start initialization
    console.log('Slider Fix: Starting initialization');
    setTimeout(initializeHeroSlider, 100);
});

// Add CSS for animations
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    .slide-content {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    
    .slide-content.slide-animate {
        opacity: 1;
    }
    
    .slide-content .slide-title,
    .slide-content .slide-description,
    .slide-content .slide-buttons {
        opacity: 0;
        transform: translateY(30px);
    }
    
    .hero-slider-section.loading::after {
        content: 'กำลังโหลด...';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 1.2rem;
        z-index: 10;
    }
`;
document.head.appendChild(animationStyles);