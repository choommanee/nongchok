// Knowledge Center Page JavaScript
jQuery(document).ready(function($) {
    
    // FAQ Accordion functionality
    $('.faq-question').on('click', function() {
        var faqItem = $(this).closest('.faq-item');
        var faqAnswer = faqItem.find('.faq-answer');
        var isActive = faqItem.hasClass('active');
        
        // Close all other FAQ items
        $('.faq-item').removeClass('active');
        $('.faq-answer').slideUp(300);
        
        // Toggle current item
        if (!isActive) {
            faqItem.addClass('active');
            faqAnswer.slideDown(300);
        }
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 800, 'swing');
        }
    });
    
    // Category card hover effects
    $('.category-card').hover(
        function() {
            $(this).find('.category-icon').addClass('animate-bounce');
        },
        function() {
            $(this).find('.category-icon').removeClass('animate-bounce');
        }
    );
    
    // Breed card image lazy loading
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Add animation classes when elements come into view
    function animateOnScroll() {
        $('.knowledge-section').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animate-fade-in');
            }
        });
    }
    
    // Run animation check on scroll and load
    $(window).on('scroll', animateOnScroll);
    $(window).on('load', animateOnScroll);
    
    // Search functionality for knowledge content
    $('#knowledge-search').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        if (searchTerm.length > 2) {
            $('.knowledge-section').each(function() {
                var sectionText = $(this).text().toLowerCase();
                if (sectionText.includes(searchTerm)) {
                    $(this).show().addClass('highlight-search');
                } else {
                    $(this).hide();
                }
            });
        } else {
            $('.knowledge-section').show().removeClass('highlight-search');
        }
    });
    
    // Print functionality
    $('.print-knowledge').on('click', function() {
        window.print();
    });
    
    // Share functionality
    $('.share-knowledge').on('click', function() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                text: 'ศูนย์ความรู้เกี่ยวกับไก่ชน - Ayam Bangkok',
                url: window.location.href
            });
        } else {
            // Fallback: copy URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('ลิงก์ถูกคัดลอกแล้ว!');
            });
        }
    });
    
    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    
    $('.back-to-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Add reading progress indicator
    function updateReadingProgress() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        
        if ($('.reading-progress').length) {
            $('.reading-progress').css('width', scrolled + '%');
        }
    }
    
    $(window).on('scroll', updateReadingProgress);
    
    // Add reading time estimation
    function estimateReadingTime() {
        var text = $('.knowledge-page').text();
        var wordCount = text.split(/\s+/).length;
        var readingTime = Math.ceil(wordCount / 200); // Average reading speed: 200 words per minute
        
        if ($('.reading-time').length) {
            $('.reading-time').text('เวลาอ่าน: ' + readingTime + ' นาที');
        }
    }
    
    estimateReadingTime();
    
    // Add bookmark functionality
    $('.bookmark-page').on('click', function() {
        var bookmarks = JSON.parse(localStorage.getItem('ayam-bookmarks') || '[]');
        var currentPage = {
            title: document.title,
            url: window.location.href,
            timestamp: new Date().toISOString()
        };
        
        // Check if already bookmarked
        var isBookmarked = bookmarks.some(bookmark => bookmark.url === currentPage.url);
        
        if (!isBookmarked) {
            bookmarks.push(currentPage);
            localStorage.setItem('ayam-bookmarks', JSON.stringify(bookmarks));
            $(this).addClass('bookmarked').text('บันทึกแล้ว');
        } else {
            // Remove bookmark
            bookmarks = bookmarks.filter(bookmark => bookmark.url !== currentPage.url);
            localStorage.setItem('ayam-bookmarks', JSON.stringify(bookmarks));
            $(this).removeClass('bookmarked').text('บันทึกหน้านี้');
        }
    });
    
    // Check if page is already bookmarked on load
    function checkBookmarkStatus() {
        var bookmarks = JSON.parse(localStorage.getItem('ayam-bookmarks') || '[]');
        var isBookmarked = bookmarks.some(bookmark => bookmark.url === window.location.href);
        
        if (isBookmarked) {
            $('.bookmark-page').addClass('bookmarked').text('บันทึกแล้ว');
        }
    }
    
    checkBookmarkStatus();
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: translate3d(0,0,0);
        }
        40%, 43% {
            transform: translate3d(0,-10px,0);
        }
        70% {
            transform: translate3d(0,-5px,0);
        }
        90% {
            transform: translate3d(0,-2px,0);
        }
    }
    
    .animate-bounce {
        animation: bounce 1s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    .highlight-search {
        background: rgba(255, 255, 0, 0.1);
        border: 2px solid #ffd700;
        border-radius: 10px;
    }
    
    .reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #3498db, #e74c3c);
        z-index: 9999;
        transition: width 0.3s ease;
    }
    
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #3498db;
        color: white;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease;
    }
    
    .back-to-top:hover {
        background: #2980b9;
        transform: scale(1.1);
    }
    
    .bookmarked {
        background: #28a745 !important;
        color: white !important;
    }
`;
document.head.appendChild(style);

// Add reading progress bar and back to top button to the page
jQuery(document).ready(function($) {
    $('body').prepend('<div class="reading-progress"></div>');
    $('body').append('<div class="back-to-top"><i class="fas fa-arrow-up"></i></div>');
});