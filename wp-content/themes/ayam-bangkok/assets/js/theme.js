/**
 * AYAM BANGKOK Theme JavaScript
 * Version 2.0.0
 */

// Mobile Menu Toggle - AYAM BANGKOK
document.addEventListener('DOMContentLoaded', function() {
    // Old mobile menu
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navigation = document.querySelector('.main-navigation ul');
    
    if (mobileToggle && navigation) {
        mobileToggle.addEventListener('click', function() {
            navigation.classList.toggle('show');
            
            // Update aria-expanded
            const isExpanded = navigation.classList.contains('show');
            mobileToggle.setAttribute('aria-expanded', isExpanded);
            
            // Change icon
            const icon = mobileToggle.querySelector('i');
            if (icon) {
                if (isExpanded) {
                    icon.className = 'fas fa-times';
                } else {
                    icon.className = 'fas fa-bars';
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileToggle.contains(e.target) && !navigation.contains(e.target)) {
                navigation.classList.remove('show');
                mobileToggle.setAttribute('aria-expanded', 'false');
                const icon = mobileToggle.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-bars';
                }
            }
        });
    }
    
    // Wix Style Mobile Menu
    const wixToggle = document.querySelector('.wix-mobile-toggle');
    const wixNav = document.querySelector('.wix-nav');
    
    if (wixToggle && wixNav) {
        wixToggle.addEventListener('click', function() {
            wixNav.classList.toggle('active');
            wixToggle.classList.toggle('active');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!wixToggle.contains(e.target) && !wixNav.contains(e.target)) {
                wixNav.classList.remove('active');
                wixToggle.classList.remove('active');
            }
        });
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Header scroll effect
    let lastScrollTop = 0;
    const header = document.querySelector('.site-header') || document.querySelector('.wix-header');

    if (header) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            lastScrollTop = scrollTop;
        });
    }
    
    // Back to top button
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTop.className = 'back-to-top';
    backToTop.setAttribute('aria-label', 'กลับไปด้านบน');
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Initialize animations on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
});

// Add CSS for back to top button and animations
const style = document.createElement('style');
style.textContent = `
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 15px var(--shadow-blue);
    }
    
    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-blue);
    }
    
    .site-header.scrolled {
        box-shadow: 0 2px 20px var(--shadow-blue);
    }
    
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .animate-on-scroll.animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    @media (max-width: 768px) {
        .back-to-top {
            width: 45px;
            height: 45px;
            bottom: 1.5rem;
            right: 1.5rem;
        }
    }
`;
document.head.appendChild(style);

/**
 * Modern Homepage JavaScript Class
 */
class AyamHomepage {
    constructor() {
        this.initSlider();
        this.initAnimations();
        this.initLazyLoading();
        this.initContactForm();
        this.initNotificationSystem();
    }

    // Hero Slider Implementation - Fixed and Improved
    initSlider() {
        // Wait for Swiper to be loaded
        if (typeof Swiper === 'undefined') {
            console.warn('Swiper not loaded yet, retrying...');
            setTimeout(() => this.initSlider(), 500);
            return;
        }

        const heroSlider = document.querySelector('.hero-swiper');
        if (heroSlider && heroSlider.swiper) {
            // Destroy existing swiper instance
            heroSlider.swiper.destroy(true, true);
        }
        
        if (heroSlider) {
            try {
                this.heroSwiper = new Swiper('.hero-swiper', {
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
                    
                    // Effects
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    
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
                        init: () => {
                            console.log('Swiper initialized successfully');
                            this.animateSlideContent();
                        },
                        slideChange: () => {
                            this.animateSlideContent();
                        },
                        autoplayStart: () => {
                            console.log('Autoplay started');
                        },
                        autoplayStop: () => {
                            console.log('Autoplay stopped');
                        }
                    }
                });
                
                console.log('Hero Swiper initialized:', this.heroSwiper);
                
            } catch (error) {
                console.error('Error initializing Swiper:', error);
                // Fallback: show first slide only
                this.initFallbackSlider();
            }
        }
    }

    // Fallback slider for when Swiper fails
    initFallbackSlider() {
        const slides = document.querySelectorAll('.swiper-slide');
        if (slides.length > 1) {
            let currentSlide = 0;
            
            // Hide all slides except first
            slides.forEach((slide, index) => {
                slide.style.display = index === 0 ? 'flex' : 'none';
            });
            
            // Auto-rotate slides
            setInterval(() => {
                slides[currentSlide].style.display = 'none';
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].style.display = 'flex';
                this.animateSlideContent();
            }, 6000);
        }
    }

    // Animate slide content - Improved
    animateSlideContent() {
        // Remove animations from all slides first
        const allSlideContents = document.querySelectorAll('.slide-content');
        allSlideContents.forEach(content => {
            content.classList.remove('slide-animate');
        });
        
        // Add animation to active slide
        setTimeout(() => {
            const activeSlide = document.querySelector('.swiper-slide-active .slide-content') || 
                              document.querySelector('.swiper-slide:not([style*="display: none"]) .slide-content');
            
            if (activeSlide) {
                activeSlide.classList.add('slide-animate');
                
                // Animate individual elements
                const title = activeSlide.querySelector('.slide-title');
                const description = activeSlide.querySelector('.slide-description');
                const buttons = activeSlide.querySelector('.slide-buttons');
                
                if (title) {
                    title.style.animation = 'slideInUp 0.8s ease 0.2s both';
                }
                if (description) {
                    description.style.animation = 'slideInUp 0.8s ease 0.4s both';
                }
                if (buttons) {
                    buttons.style.animation = 'slideInUp 0.8s ease 0.6s both';
                }
            }
        }, 100);
    }

    // Initialize AOS Animations
    initAnimations() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100,
                delay: 100
            });
        }
    }

    // Lazy Loading for Images
    initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        if (images.length > 0) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                img.classList.add('lazy');
                imageObserver.observe(img);
            });
        }
    }

    // Contact Form Handler
    initContactForm() {
        const form = document.querySelector('.quick-contact-form');
        if (form) {
            form.addEventListener('submit', this.handleContactSubmit.bind(this));
        }

        // Rooster inquiry buttons
        const inquiryButtons = document.querySelectorAll('.btn-inquiry');
        inquiryButtons.forEach(button => {
            button.addEventListener('click', this.handleRoosterInquiry.bind(this));
        });
    }

    // Handle contact form submission
    async handleContactSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        // Show loading state
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังส่ง...';
        submitButton.disabled = true;

        const formData = new FormData(form);
        formData.append('action', 'ayam_quick_contact');

        try {
            const response = await fetch(ayam_theme.ajax_url, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification(result.data, 'success');
                form.reset();
            } else {
                this.showNotification(result.data || 'เกิดข้อผิดพลาด', 'error');
            }
        } catch (error) {
            this.showNotification('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', 'error');
        } finally {
            // Reset button
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }

    // Handle rooster inquiry
    handleRoosterInquiry(e) {
        e.preventDefault();
        const button = e.target;
        const roosterId = button.dataset.roosterId;
        
        // Create inquiry modal
        this.createInquiryModal(roosterId);
    }

    // Create inquiry modal
    createInquiryModal(roosterId) {
        const modal = document.createElement('div');
        modal.className = 'inquiry-modal-overlay';
        modal.innerHTML = `
            <div class="inquiry-modal">
                <div class="modal-header">
                    <h3>สอบถามไก่ชน</h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="rooster-inquiry-form">
                        <input type="hidden" name="rooster_id" value="${roosterId}">
                        <input type="hidden" name="action" value="ayam_rooster_inquiry">
                        <input type="hidden" name="nonce" value="${ayam_theme.nonce}">
                        
                        <div class="form-group">
                            <label for="inquiry_name">ชื่อ-นามสกุล *</label>
                            <input type="text" id="inquiry_name" name="inquiry_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="inquiry_email">อีเมล *</label>
                            <input type="email" id="inquiry_email" name="inquiry_email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="inquiry_phone">เบอร์โทรศัพท์</label>
                            <input type="tel" id="inquiry_phone" name="inquiry_phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="inquiry_message">ข้อความ *</label>
                            <textarea id="inquiry_message" name="inquiry_message" rows="4" required placeholder="กรุณาระบุรายละเอียดที่ต้องการสอบถาม..."></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-modern outline modal-cancel">ยกเลิก</button>
                            <button type="submit" class="btn-modern primary">ส่งข้อความ</button>
                        </div>
                    </form>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Add event listeners
        const closeBtn = modal.querySelector('.modal-close');
        const cancelBtn = modal.querySelector('.modal-cancel');
        const form = modal.querySelector('.rooster-inquiry-form');

        closeBtn.addEventListener('click', () => this.closeModal(modal));
        cancelBtn.addEventListener('click', () => this.closeModal(modal));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) this.closeModal(modal);
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.handleInquirySubmit(e, modal);
        });

        // Show modal with animation
        setTimeout(() => modal.classList.add('show'), 10);
    }

    // Handle inquiry form submission
    async handleInquirySubmit(e, modal) {
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังส่ง...';
        submitButton.disabled = true;

        const formData = new FormData(form);

        try {
            const response = await fetch(ayam_theme.ajax_url, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showNotification(result.data, 'success');
                this.closeModal(modal);
            } else {
                this.showNotification(result.data || 'เกิดข้อผิดพลาด', 'error');
            }
        } catch (error) {
            this.showNotification('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', 'error');
        } finally {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }

    // Close modal
    closeModal(modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(modal);
        }, 300);
    }

    // Initialize notification system
    initNotificationSystem() {
        // Create notification container if it doesn't exist
        if (!document.querySelector('.notification-container')) {
            const container = document.createElement('div');
            container.className = 'notification-container';
            document.body.appendChild(container);
        }
    }

    // Show notification
    showNotification(message, type = 'info') {
        const container = document.querySelector('.notification-container');
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        
        const icon = type === 'success' ? 'check-circle' : 
                    type === 'error' ? 'exclamation-circle' : 
                    'info-circle';
        
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close">&times;</button>
        `;
        
        container.appendChild(notification);
        
        // Show notification
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Auto hide after 5 seconds
        const autoHide = setTimeout(() => {
            this.hideNotification(notification);
        }, 5000);
        
        // Manual close
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            clearTimeout(autoHide);
            this.hideNotification(notification);
        });
    }

    // Hide notification
    hideNotification(notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
}

// Initialize homepage functionality when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Add loading class to slider
    const sliderSection = document.querySelector('.hero-slider-section');
    if (sliderSection) {
        sliderSection.classList.add('loading');
    }
    
    // Initialize homepage if we're on the homepage
    if (document.body.classList.contains('home') || document.body.classList.contains('front-page')) {
        // Wait a bit for libraries to load
        setTimeout(() => {
            new AyamHomepage();
            
            // Remove loading class after initialization
            if (sliderSection) {
                sliderSection.classList.remove('loading');
            }
        }, 100);
    }
    
    // Initialize AOS globally
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    } else {
        // Retry AOS initialization if not loaded yet
        setTimeout(() => {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true,
                    offset: 100
                });
            }
        }, 1000);
    }
});/**

 * Export Business Features
 */

// Animated Counter for Statistics
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number[data-count]');
    
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000; // 2 seconds
                const increment = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
}

// Export Case Tracking Modal
function initExportTracking() {
    const trackButtons = document.querySelectorAll('.btn-track');
    
    trackButtons.forEach(button => {
        button.addEventListener('click', function() {
            const caseId = this.getAttribute('data-case-id');
            showTrackingModal(caseId);
        });
    });
}

function showTrackingModal(caseId) {
    // Create modal HTML
    const modalHTML = `
        <div class="tracking-modal-overlay" id="trackingModal">
            <div class="tracking-modal">
                <div class="modal-header">
                    <h3>ติดตามสถานะการส่งออก</h3>
                    <button class="modal-close" onclick="closeTrackingModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tracking-info">
                        <div class="tracking-id">
                            <strong>รหัสติดตาม:</strong> ${caseId}
                        </div>
                        <div class="tracking-status">
                            <div class="status-item completed">
                                <i class="fas fa-check-circle"></i>
                                <span>รับไก่เข้าระบบ</span>
                                <small>10 ม.ค. 2024</small>
                            </div>
                            <div class="status-item completed">
                                <i class="fas fa-check-circle"></i>
                                <span>ตรวจสุขภาพ</span>
                                <small>11 ม.ค. 2024</small>
                            </div>
                            <div class="status-item completed">
                                <i class="fas fa-check-circle"></i>
                                <span>จัดทำเอกสาร</span>
                                <small>12 ม.ค. 2024</small>
                            </div>
                            <div class="status-item completed">
                                <i class="fas fa-check-circle"></i>
                                <span>ส่งออกสำเร็จ</span>
                                <small>15 ม.ค. 2024</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modern outline" onclick="closeTrackingModal()">ปิด</button>
                    <button class="btn-modern primary">ดาวน์โหลดใบรับรอง</button>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Show modal with animation
    setTimeout(() => {
        document.getElementById('trackingModal').classList.add('show');
    }, 10);
}

function closeTrackingModal() {
    const modal = document.getElementById('trackingModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}

// Export Service Inquiry
function initExportInquiry() {
    const inquiryButtons = document.querySelectorAll('.btn-export-inquiry');
    
    inquiryButtons.forEach(button => {
        button.addEventListener('click', function() {
            showExportInquiryForm();
        });
    });
}

function showExportInquiryForm() {
    const formHTML = `
        <div class="inquiry-modal-overlay" id="inquiryModal">
            <div class="inquiry-modal">
                <div class="modal-header">
                    <h3>ขอใช้บริการส่งออกไก่ชน</h3>
                    <button class="modal-close" onclick="closeInquiryModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="export-inquiry-form" id="exportInquiryForm">
                        <div class="form-group">
                            <label for="customerName">ชื่อ-นามสกุล *</label>
                            <input type="text" id="customerName" name="customer_name" required>
                        </div>
                        <div class="form-group">
                            <label for="customerPhone">เบอร์โทรศัพท์ *</label>
                            <input type="tel" id="customerPhone" name="customer_phone" required>
                        </div>
                        <div class="form-group">
                            <label for="customerEmail">อีเมล</label>
                            <input type="email" id="customerEmail" name="customer_email">
                        </div>
                        <div class="form-group">
                            <label for="roosterCount">จำนวนไก่ที่ต้องการส่งออก *</label>
                            <input type="number" id="roosterCount" name="rooster_count" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="destination">ปลายทางในอินโดนีเซีย *</label>
                            <select id="destination" name="destination" required>
                                <option value="">เลือกปลายทาง</option>
                                <option value="jakarta">Jakarta</option>
                                <option value="surabaya">Surabaya</option>
                                <option value="medan">Medan</option>
                                <option value="bandung">Bandung</option>
                                <option value="other">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">รายละเอียดเพิ่มเติม</label>
                            <textarea id="message" name="message" rows="4" placeholder="ระบุสายพันธุ์ไก่ที่ต้องการ หรือข้อมูลเพิ่มเติม"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn-modern outline" onclick="closeInquiryModal()">ยกเลิก</button>
                    <button class="btn-modern primary" onclick="submitExportInquiry()">ส่งคำขอ</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', formHTML);
    
    setTimeout(() => {
        document.getElementById('inquiryModal').classList.add('show');
    }, 10);
}

function closeInquiryModal() {
    const modal = document.getElementById('inquiryModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}

function submitExportInquiry() {
    const form = document.getElementById('exportInquiryForm');
    const formData = new FormData(form);
    
    // Basic validation
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
        }
    });
    
    if (!isValid) {
        showNotification('กรุณากรอกข้อมูลให้ครบถ้วน', 'error');
        return;
    }
    
    // Simulate form submission
    showNotification('กำลังส่งคำขอ...', 'info');
    
    setTimeout(() => {
        closeInquiryModal();
        showNotification('ส่งคำขอสำเร็จ! เราจะติดต่อกลับภายใน 24 ชั่วโมง', 'success');
    }, 1500);
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }
    }, 5000);
}

// Process Step Hover Effects
function initProcessStepEffects() {
    const processSteps = document.querySelectorAll('.process-step');
    
    processSteps.forEach((step, index) => {
        step.addEventListener('mouseenter', function() {
            // Add pulse effect to icon
            const icon = this.querySelector('.step-icon');
            if (icon) {
                icon.style.animation = 'pulse 0.6s ease-in-out';
            }
        });
        
        step.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.step-icon');
            if (icon) {
                icon.style.animation = '';
            }
        });
    });
}

// Initialize all export features
document.addEventListener('DOMContentLoaded', function() {
    // Initialize existing features first
    if (typeof initializeHomepage === 'function') {
        initializeHomepage();
    }
    
    // Initialize new export features
    animateCounters();
    initExportTracking();
    initExportInquiry();
    initProcessStepEffects();
    
    // Close modals when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('tracking-modal-overlay') || 
            e.target.classList.contains('inquiry-modal-overlay')) {
            if (e.target.id === 'trackingModal') {
                closeTrackingModal();
            } else if (e.target.id === 'inquiryModal') {
                closeInquiryModal();
            }
        }
    });
});

// CSS for modals and notifications (injected via JavaScript)
const exportStyles = `
<style>
/* Modal Styles */
.tracking-modal-overlay,
.inquiry-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.tracking-modal-overlay.show,
.inquiry-modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.tracking-modal,
.inquiry-modal {
    background: white;
    border-radius: 1rem;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.tracking-modal-overlay.show .tracking-modal,
.inquiry-modal-overlay.show .inquiry-modal {
    transform: translateY(0);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    color: #6b7280;
    padding: 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #f3f4f6;
    color: #374151;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Tracking Modal Specific */
.tracking-info {
    text-align: center;
}

.tracking-id {
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
}

.tracking-status {
    text-align: left;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.status-item:hover {
    background: #f8fafc;
}

.status-item.completed {
    color: #059669;
}

.status-item i {
    width: 20px;
}

.status-item small {
    margin-left: auto;
    color: #6b7280;
    font-size: 0.8rem;
}

/* Form Styles */
.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: border-color 0.2s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-group input.error,
.form-group select.error {
    border-color: #ef4444;
}

/* Notification Styles */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 10000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    max-width: 400px;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    border-left: 4px solid #10b981;
}

.notification-error {
    border-left: 4px solid #ef4444;
}

.notification-info {
    border-left: 4px solid #3b82f6;
}

.notification-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
}

.notification-close {
    background: none;
    border: none;
    cursor: pointer;
    color: #6b7280;
    padding: 0.25rem;
}

/* Pulse Animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .tracking-modal,
    .inquiry-modal {
        width: 95%;
        margin: 1rem;
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .notification {
        right: 10px;
        left: 10px;
        max-width: none;
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', exportStyles);/**
 
* Enhanced Export Process Flow Features
 */

// Process Flow Interactive Timeline
function initProcessFlowTimeline() {
    const processSteps = document.querySelectorAll('.process-step');
    const processLine = document.querySelector('.process-steps::before');
    
    processSteps.forEach((step, index) => {
        step.addEventListener('click', function() {
            showProcessDetails(index, step);
        });
        
        // Add progress animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animate-in');
                    }, index * 200);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(step);
    });
}

function showProcessDetails(stepIndex, stepElement) {
    const processDetails = [
        {
            title: 'รับไก่เข้าระบบ',
            description: 'เจ้าหน้าที่รับไก่จากฟาร์มและทำการตรวจสอบเบื้องต้น',
            details: [
                'ตรวจสอบเอกสารจากฟาร์ม',
                'นับจำนวนไก่ที่ส่งมา',
                'ตรวจสอบสภาพทั่วไปของไก่',
                'บันทึกข้อมูลเข้าระบบ'
            ],
            duration: '30-60 นาที',
            responsible: 'เจ้าหน้าที่รับไก่'
        },
        {
            title: 'ชั่งน้ำหนักและวัดขนาด',
            description: 'ชั่งน้ำหนักไก่แต่ละตัวและบันทึกข้อมูลอย่างแม่นยำ',
            details: [
                'ชั่งน้ำหนักไก่แต่ละตัว',
                'วัดขนาดและความสูง',
                'บันทึกข้อมูลลงในระบบ',
                'ติดป้ายรหัสไก่'
            ],
            duration: '15-30 นาที/ตัว',
            responsible: 'เจ้าหน้าที่ชั่งน้ำหนัก'
        },
        {
            title: 'ถ่ายรูปและบันทึกลักษณะ',
            description: 'ถ่ายรูปไก่ทุกมุมและบันทึกลักษณะพิเศษ',
            details: [
                'ถ่ายรูปไก่ 6 มุม',
                'บันทึกสีและลวดลาย',
                'จดลักษณะพิเศษ',
                'อัพโหลดรูปเข้าระบบ'
            ],
            duration: '10-15 นาที/ตัว',
            responsible: 'ช่างภาพ'
        },
        {
            title: 'ตรวจสุขภาพโดยสัตวแพทย์',
            description: 'สัตวแพทย์ตรวจสุขภาพและออกใบรับรอง',
            details: [
                'ตรวจสุขภาพทั่วไป',
                'ตรวจหาโรคติดต่อ',
                'ฉีดวัคซีนตามต้องการ',
                'ออกใบรับรองสุขภาพ'
            ],
            duration: '20-30 นาที/ตัว',
            responsible: 'สัตวแพทย์'
        },
        {
            title: 'จัดทำเอกสารส่งออก',
            description: 'จัดทำเอกสารครบถ้วนสำหรับการส่งออก',
            details: [
                'ใบรับรองสุขภาพ',
                'เอกสารศุลกากร',
                'ใบอนุญาตส่งออก',
                'เอกสารประกันภัย'
            ],
            duration: '2-4 ชั่วโมง',
            responsible: 'เจ้าหน้าที่เอกสาร'
        },
        {
            title: 'กักกันตามมาตรฐาน',
            description: 'กักกันไก่ตามมาตรฐานสากลก่อนส่งออก',
            details: [
                'กักกันในโรงเรือนพิเศษ',
                'ให้อาหารและน้ำสะอาด',
                'ตรวจสุขภาพประจำวัน',
                'บันทึกข้อมูลการกักกัน'
            ],
            duration: '7-14 วัน',
            responsible: 'เจ้าหน้าที่ดูแลไก่'
        },
        {
            title: 'ส่งขึ้นเครื่องบิน',
            description: 'ขนส่งไก่ขึ้นเครื่องบินไปยังอินโดนีเซีย',
            details: [
                'เตรียมกรงขนส่ง',
                'ใส่อาหารและน้ำ',
                'ขนส่งไปสนามบิน',
                'ส่งขึ้นเครื่องบิน'
            ],
            duration: '4-6 ชั่วโมง',
            responsible: 'ทีมขนส่ง'
        }
    ];
    
    const detail = processDetails[stepIndex];
    
    const modalHTML = `
        <div class="process-detail-modal-overlay" id="processDetailModal">
            <div class="process-detail-modal">
                <div class="modal-header">
                    <div class="step-info">
                        <div class="step-number-large">${String(stepIndex + 1).padStart(2, '0')}</div>
                        <h3>${detail.title}</h3>
                    </div>
                    <button class="modal-close" onclick="closeProcessDetailModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="process-description">${detail.description}</p>
                    
                    <div class="process-meta">
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span><strong>ระยะเวลา:</strong> ${detail.duration}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span><strong>ผู้รับผิดชอบ:</strong> ${detail.responsible}</span>
                        </div>
                    </div>
                    
                    <div class="process-details">
                        <h4>รายละเอียดขั้นตอน:</h4>
                        <ul>
                            ${detail.details.map(item => `<li>${item}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div class="process-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${((stepIndex + 1) / 7) * 100}%"></div>
                        </div>
                        <div class="progress-text">ขั้นตอนที่ ${stepIndex + 1} จาก 7</div>
                    </div>
                </div>
                <div class="modal-footer">
                    ${stepIndex > 0 ? `<button class="btn-modern outline" onclick="showProcessDetails(${stepIndex - 1})">ขั้นตอนก่อนหน้า</button>` : ''}
                    <button class="btn-modern outline" onclick="closeProcessDetailModal()">ปิด</button>
                    ${stepIndex < 6 ? `<button class="btn-modern primary" onclick="showProcessDetails(${stepIndex + 1})">ขั้นตอนถัดไป</button>` : ''}
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('processDetailModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    setTimeout(() => {
        document.getElementById('processDetailModal').classList.add('show');
    }, 10);
}

function closeProcessDetailModal() {
    const modal = document.getElementById('processDetailModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}

// Process Flow Progress Indicator
function initProcessProgressIndicator() {
    const processSection = document.querySelector('.export-process-section');
    if (!processSection) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateProcessFlow();
            }
        });
    }, { threshold: 0.3 });
    
    observer.observe(processSection);
}

function animateProcessFlow() {
    const steps = document.querySelectorAll('.process-step');
    const line = document.querySelector('.process-steps::before');
    
    steps.forEach((step, index) => {
        setTimeout(() => {
            step.classList.add('animate-in');
            
            // Add completion effect
            setTimeout(() => {
                step.classList.add('completed');
            }, 500);
        }, index * 300);
    });
}

// Export Process Tracking Simulator
function initProcessTrackingSimulator() {
    const simulateButton = document.querySelector('.btn-simulate-process');
    if (simulateButton) {
        simulateButton.addEventListener('click', startProcessSimulation);
    }
}

function startProcessSimulation() {
    const steps = [
        'รับไก่เข้าระบบ...',
        'กำลังชั่งน้ำหนัก...',
        'ถ่ายรูปและบันทึกข้อมูล...',
        'รอการตรวจสุขภาพ...',
        'จัดทำเอกสาร...',
        'เริ่มกักกัน...',
        'เตรียมส่งออก...'
    ];
    
    let currentStep = 0;
    const interval = setInterval(() => {
        if (currentStep < steps.length) {
            showNotification(steps[currentStep], 'info');
            currentStep++;
        } else {
            clearInterval(interval);
            showNotification('กระบวนการส่งออกเสร็จสมบูรณ์!', 'success');
        }
    }, 2000);
}

// Initialize enhanced process flow features
document.addEventListener('DOMContentLoaded', function() {
    initProcessFlowTimeline();
    initProcessProgressIndicator();
    initProcessTrackingSimulator();
});

// Enhanced CSS for process flow
const processFlowStyles = `
<style>
/* Process Flow Animations */
.process-step {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.process-step.animate-in {
    opacity: 1;
    transform: translateY(0);
}

.process-step.completed .step-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    animation: completePulse 0.6s ease;
}

@keyframes completePulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
    100% { transform: scale(1); }
}

/* Process Detail Modal */
.process-detail-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.process-detail-modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.process-detail-modal {
    background: white;
    border-radius: 1.5rem;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(-20px) scale(0.95);
    transition: transform 0.3s ease;
}

.process-detail-modal-overlay.show .process-detail-modal {
    transform: translateY(0) scale(1);
}

.step-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.step-number-large {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
}

.process-description {
    font-size: 1.1rem;
    color: #4b5563;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.process-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.75rem;
}

.process-meta .meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
}

.process-meta .meta-item i {
    color: #3b82f6;
    width: 20px;
}

.process-details h4 {
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 1.1rem;
}

.process-details ul {
    list-style: none;
    padding: 0;
}

.process-details li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f3f4f6;
    position: relative;
    padding-left: 1.5rem;
}

.process-details li:before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #10b981;
    font-weight: bold;
}

.process-details li:last-child {
    border-bottom: none;
}

.process-progress {
    margin-top: 1.5rem;
    text-align: center;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.9rem;
    color: #6b7280;
}

/* Clickable Process Steps */
.process-step {
    cursor: pointer;
    position: relative;
}

.process-step:hover {
    transform: translateY(-15px);
}

.process-step:hover::after {
    content: 'คลิกเพื่อดูรายละเอียด';
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: #374151;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.8rem;
    white-space: nowrap;
    z-index: 10;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .process-detail-modal {
        width: 95%;
        margin: 1rem;
    }
    
    .step-info {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .step-number-large {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .process-meta {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
`;

// Inject enhanced styles
document.head.insertAdjacentHTML('beforeend', processFlowStyles);

/**
 * Advanced JavaScript Interactions and Animations
 * Export Business Theme Enhancement
 */

// Advanced Homepage Class
class AyamHomepageAdvanced {
    constructor() {
        this.initLazyLoading();
        this.initScrollAnimations();
        this.initParallaxEffects();
        this.initTypewriterEffect();
        this.initCounterAnimations();
        this.initImageGallery();
        this.initSmoothScrolling();
        this.initProgressBars();
        this.initTooltips();
        this.initAdvancedModals();
    }

    // Advanced Lazy Loading with Intersection Observer
    initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    // Add loading animation
                    img.classList.add('loading');
                    
                    // Create new image to preload
                    const newImg = new Image();
                    newImg.onload = () => {
                        img.src = img.dataset.src;
                        img.classList.remove('loading');
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    };
                    newImg.src = img.dataset.src;
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.1
        });

        images.forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Advanced Scroll Animations
    initScrollAnimations() {
        const animatedElements = document.querySelectorAll('[data-animate]');
        
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const animationType = element.dataset.animate;
                    const delay = element.dataset.delay || 0;
                    
                    setTimeout(() => {
                        element.classList.add(`animate-${animationType}`);
                    }, delay);
                    
                    animationObserver.unobserve(element);
                }
            });
        }, {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(element => {
            animationObserver.observe(element);
        });
    }

    // Parallax Effects
    initParallaxEffects() {
        const parallaxElements = document.querySelectorAll('[data-parallax]');
        
        if (parallaxElements.length === 0) return;
        
        let ticking = false;
        
        const updateParallax = () => {
            const scrollTop = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.parallax) || 0.5;
                const yPos = -(scrollTop * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
            
            ticking = false;
        };
        
        const requestParallaxUpdate = () => {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        };
        
        window.addEventListener('scroll', requestParallaxUpdate, { passive: true });
    }

    // Typewriter Effect for Headlines
    initTypewriterEffect() {
        const typewriterElements = document.querySelectorAll('[data-typewriter]');
        
        typewriterElements.forEach(element => {
            const text = element.textContent;
            const speed = parseInt(element.dataset.speed) || 100;
            
            element.textContent = '';
            element.style.borderRight = '2px solid currentColor';
            
            let i = 0;
            const typeWriter = () => {
                if (i < text.length) {
                    element.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, speed);
                } else {
                    // Remove cursor after typing is complete
                    setTimeout(() => {
                        element.style.borderRight = 'none';
                    }, 1000);
                }
            };
            
            // Start typing when element comes into view
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(typeWriter, 500);
                        observer.unobserve(element);
                    }
                });
            });
            
            observer.observe(element);
        });
    }

    // Enhanced Counter Animations
    initCounterAnimations() {
        const counters = document.querySelectorAll('[data-counter]');
        
        counters.forEach(counter => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animateCounter(counter);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });
            
            observer.observe(counter);
        });
    }

    animateCounter(element) {
        const target = parseInt(element.dataset.counter);
        const duration = parseInt(element.dataset.duration) || 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
                element.classList.add('counter-complete');
            }
        };
        
        updateCounter();
    }

    // Advanced Image Gallery
    initImageGallery() {
        const galleryImages = document.querySelectorAll('[data-gallery]');
        
        galleryImages.forEach(img => {
            img.addEventListener('click', (e) => {
                e.preventDefault();
                this.openLightbox(img.src, img.alt);
            });
        });
    }

    openLightbox(src, alt) {
        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox-overlay';
        lightbox.innerHTML = `
            <div class="lightbox-container">
                <button class="lightbox-close">&times;</button>
                <img src="${src}" alt="${alt}" class="lightbox-image">
                <div class="lightbox-caption">${alt}</div>
            </div>
        `;
        
        document.body.appendChild(lightbox);
        document.body.style.overflow = 'hidden';
        
        // Animate in
        setTimeout(() => {
            lightbox.classList.add('show');
        }, 10);
        
        // Close handlers
        const closeBtn = lightbox.querySelector('.lightbox-close');
        closeBtn.addEventListener('click', () => this.closeLightbox(lightbox));
        
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                this.closeLightbox(lightbox);
            }
        });
        
        // Keyboard handler
        const keyHandler = (e) => {
            if (e.key === 'Escape') {
                this.closeLightbox(lightbox);
                document.removeEventListener('keydown', keyHandler);
            }
        };
        document.addEventListener('keydown', keyHandler);
    }

    closeLightbox(lightbox) {
        lightbox.classList.remove('show');
        document.body.style.overflow = '';
        
        setTimeout(() => {
            if (lightbox.parentNode) {
                lightbox.parentNode.removeChild(lightbox);
            }
        }, 300);
    }

    // Smooth Scrolling for Anchor Links
    initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                const targetId = link.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 80; // Account for fixed header
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Progress Bars Animation
    initProgressBars() {
        const progressBars = document.querySelectorAll('[data-progress]');
        
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const progress = parseInt(bar.dataset.progress);
                    const fill = bar.querySelector('.progress-fill');
                    
                    if (fill) {
                        setTimeout(() => {
                            fill.style.width = `${progress}%`;
                        }, 200);
                    }
                    
                    progressObserver.unobserve(bar);
                }
            });
        }, { threshold: 0.5 });
        
        progressBars.forEach(bar => {
            progressObserver.observe(bar);
        });
    }

    // Advanced Tooltips
    initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', (e) => {
                this.showTooltip(e.target);
            });
            
            element.addEventListener('mouseleave', (e) => {
                this.hideTooltip(e.target);
            });
        });
    }

    showTooltip(element) {
        const tooltipText = element.dataset.tooltip;
        const position = element.dataset.tooltipPosition || 'top';
        
        const tooltip = document.createElement('div');
        tooltip.className = `tooltip tooltip-${position}`;
        tooltip.textContent = tooltipText;
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        const tooltipRect = tooltip.getBoundingClientRect();
        
        let top, left;
        
        switch (position) {
            case 'top':
                top = rect.top - tooltipRect.height - 10;
                left = rect.left + (rect.width - tooltipRect.width) / 2;
                break;
            case 'bottom':
                top = rect.bottom + 10;
                left = rect.left + (rect.width - tooltipRect.width) / 2;
                break;
            case 'left':
                top = rect.top + (rect.height - tooltipRect.height) / 2;
                left = rect.left - tooltipRect.width - 10;
                break;
            case 'right':
                top = rect.top + (rect.height - tooltipRect.height) / 2;
                left = rect.right + 10;
                break;
        }
        
        tooltip.style.top = `${top + window.scrollY}px`;
        tooltip.style.left = `${left + window.scrollX}px`;
        
        element._tooltip = tooltip;
        
        setTimeout(() => {
            tooltip.classList.add('show');
        }, 10);
    }

    hideTooltip(element) {
        if (element._tooltip) {
            element._tooltip.classList.remove('show');
            setTimeout(() => {
                if (element._tooltip && element._tooltip.parentNode) {
                    element._tooltip.parentNode.removeChild(element._tooltip);
                }
                element._tooltip = null;
            }, 200);
        }
    }

    // Advanced Modal System
    initAdvancedModals() {
        const modalTriggers = document.querySelectorAll('[data-modal]');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.dataset.modal;
                this.openAdvancedModal(modalId);
            });
        });
    }

    openAdvancedModal(modalId) {
        // This would integrate with existing modal system
        // but add advanced features like stacking, focus management, etc.
        console.log(`Opening advanced modal: ${modalId}`);
    }
}

// Performance Monitoring
class PerformanceMonitor {
    constructor() {
        this.metrics = {};
        this.initPerformanceTracking();
    }

    initPerformanceTracking() {
        // Track page load performance
        window.addEventListener('load', () => {
            const perfData = performance.getEntriesByType('navigation')[0];
            this.metrics.pageLoad = {
                domContentLoaded: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart,
                loadComplete: perfData.loadEventEnd - perfData.loadEventStart,
                totalTime: perfData.loadEventEnd - perfData.fetchStart
            };
            
            this.reportMetrics();
        });

        // Track user interactions
        this.trackInteractions();
    }

    trackInteractions() {
        const interactionElements = document.querySelectorAll('.btn-modern, .process-step, .stat-card');
        
        interactionElements.forEach(element => {
            element.addEventListener('click', (e) => {
                const elementType = e.target.className;
                const timestamp = Date.now();
                
                if (!this.metrics.interactions) {
                    this.metrics.interactions = [];
                }
                
                this.metrics.interactions.push({
                    element: elementType,
                    timestamp: timestamp
                });
            });
        });
    }

    reportMetrics() {
        // In production, this would send metrics to analytics
        console.log('Performance Metrics:', this.metrics);
    }
}

// Accessibility Enhancements
class AccessibilityEnhancer {
    constructor() {
        this.initKeyboardNavigation();
        this.initScreenReaderSupport();
        this.initFocusManagement();
    }

    initKeyboardNavigation() {
        // Enhanced keyboard navigation for interactive elements
        const interactiveElements = document.querySelectorAll('.process-step, .btn-modern, .stat-card');
        
        interactiveElements.forEach(element => {
            if (!element.hasAttribute('tabindex')) {
                element.setAttribute('tabindex', '0');
            }
            
            element.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    element.click();
                }
            });
        });
    }

    initScreenReaderSupport() {
        // Add ARIA labels and descriptions
        const processSteps = document.querySelectorAll('.process-step');
        processSteps.forEach((step, index) => {
            step.setAttribute('role', 'button');
            step.setAttribute('aria-label', `Export process step ${index + 1}`);
        });

        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            const number = card.querySelector('.stat-number');
            const label = card.querySelector('.stat-label');
            if (number && label) {
                card.setAttribute('aria-label', `${label.textContent}: ${number.textContent}`);
            }
        });
    }

    initFocusManagement() {
        // Manage focus for modals and dynamic content
        document.addEventListener('modal-opened', (e) => {
            const modal = e.detail.modal;
            const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        });
    }
}

// Initialize Advanced Features
document.addEventListener('DOMContentLoaded', function() {
    // Initialize existing features
    if (typeof initProcessFlowTimeline === 'function') {
        initProcessFlowTimeline();
    }
    if (typeof animateCounters === 'function') {
        animateCounters();
    }
    if (typeof initExportTracking === 'function') {
        initExportTracking();
    }
    if (typeof initExportInquiry === 'function') {
        initExportInquiry();
    }

    // Initialize advanced features
    new AyamHomepageAdvanced();
    new PerformanceMonitor();
    new AccessibilityEnhancer();

    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
            disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        });
    }
});

// Advanced CSS Injection for New Features
const advancedStyles = `
<style>
/* Advanced Animation Styles */
.animate-fadeInUp {
    animation: fadeInUp 0.8s ease forwards;
}

.animate-slideInLeft {
    animation: slideInLeft 0.8s ease forwards;
}

.animate-slideInRight {
    animation: slideInRight 0.8s ease forwards;
}

.animate-zoomIn {
    animation: zoomIn 0.6s ease forwards;
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Lazy Loading Styles */
img[data-src] {
    opacity: 0;
    transition: opacity 0.3s ease;
}

img[data-src].loading {
    opacity: 0.5;
    filter: blur(2px);
}

img[data-src].loaded {
    opacity: 1;
    filter: none;
}

/* Lightbox Styles */
.lightbox-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.lightbox-overlay.show {
    opacity: 1;
    visibility: visible;
}

.lightbox-container {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    text-align: center;
}

.lightbox-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
}

.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: none;
    color: white;
    font-size: 2rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: background 0.2s ease;
}

.lightbox-close:hover {
    background: rgba(255, 255, 255, 0.1);
}

.lightbox-caption {
    color: white;
    margin-top: 1rem;
    font-size: 1rem;
}

/* Progress Bar Styles */
.progress-bar {
    width: 100%;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
    margin: 1rem 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%);
    border-radius: 4px;
    width: 0%;
    transition: width 1.5s ease;
}

/* Tooltip Styles */
.tooltip {
    position: absolute;
    background: #374151;
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    z-index: 1000;
    opacity: 0;
    transform: translateY(5px);
    transition: all 0.2s ease;
    pointer-events: none;
    white-space: nowrap;
}

.tooltip.show {
    opacity: 1;
    transform: translateY(0);
}

.tooltip::after {
    content: '';
    position: absolute;
    width: 0;
    height: 0;
    border: 5px solid transparent;
}

.tooltip.tooltip-top::after {
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-top-color: #374151;
}

.tooltip.tooltip-bottom::after {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-bottom-color: #374151;
}

.tooltip.tooltip-left::after {
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    border-left-color: #374151;
}

.tooltip.tooltip-right::after {
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    border-right-color: #374151;
}

/* Typewriter Effect */
[data-typewriter] {
    display: inline-block;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 50% { border-color: transparent; }
    51%, 100% { border-color: currentColor; }
}

/* Enhanced Focus Styles */
.process-step:focus,
.stat-card:focus,
.btn-modern:focus {
    outline: 3px solid #3b82f6;
    outline-offset: 2px;
}

/* Parallax Container */
[data-parallax] {
    will-change: transform;
}

/* Counter Animation */
.counter-complete {
    animation: counterPulse 0.6s ease;
}

@keyframes counterPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); color: #10b981; }
    100% { transform: scale(1); }
}

/* Mobile Optimizations */
@media (max-width: 768px) {
    .lightbox-container {
        max-width: 95vw;
        max-height: 95vh;
    }
    
    .lightbox-close {
        top: -30px;
        font-size: 1.5rem;
    }
    
    .tooltip {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .animate-fadeInUp,
    .animate-slideInLeft,
    .animate-slideInRight,
    .animate-zoomIn {
        animation: none !important;
        opacity: 1 !important;
        transform: none !important;
    }
    
    .progress-fill {
        transition: none !important;
    }
    
    [data-parallax] {
        transform: none !important;
    }
}
</style>
`;

// Inject advanced styles
document.head.insertAdjacentHTML('beforeend', advancedStyles);