
// Emergency Button Fix JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Emergency Button Fix: Starting...');
    
    // Fix button HTML entities and errors
    function fixButtonHTML() {
        const buttons = document.querySelectorAll('.hero-slider .slide-buttons a');
        console.log('Found buttons:', buttons.length);
        
        buttons.forEach((button, index) => {
            console.log('Button ' + (index + 1) + ' HTML:', button.innerHTML);
            
            // Clean up the button content
            let cleanText = button.innerHTML;
            
            // Remove PHP error messages and paths
            cleanText = cleanText.replace(/\/[^<]*\.php[^<]*<b>[^<]*<\/b>[^<]*/gi, '');
            
            // Remove HTML entities and fix encoding
            cleanText = cleanText.replace(/&gt;/g, '>');
            cleanText = cleanText.replace(/&lt;/g, '<');
            cleanText = cleanText.replace(/&quot;/g, '"');
            cleanText = cleanText.replace(/&amp;/g, '&');
            
            // Extract just the button text and icon
            const textMatch = cleanText.match(/([^<]*ดูเพิ่มเติม[^<]*)/);
            const iconMatch = cleanText.match(/<i[^>]*fas fa-arrow-right[^>]*><\/i>/);
            
            if (textMatch) {
                let buttonText = textMatch[1].trim();
                let iconHTML = iconMatch ? iconMatch[0] : '<i class="fas fa-arrow-right"></i>';
                
                // Clean button text
                buttonText = buttonText.replace(/[^ก-๙a-zA-Z0-9\s]/g, '').trim();
                if (!buttonText) buttonText = 'ดูเพิ่มเติม';
                
                button.innerHTML = buttonText + ' ' + iconHTML;
                console.log('Fixed HTML entities for button ' + (index + 1));
            }
            
            // Ensure proper styling
            button.style.display = 'inline-block';
            button.style.padding = '12px 24px';
            button.style.background = 'rgba(255, 255, 255, 0.9)';
            button.style.color = '#333';
            button.style.textDecoration = 'none';
            button.style.borderRadius = '5px';
            button.style.fontWeight = '600';
            button.style.border = '2px solid rgba(255, 255, 255, 0.9)';
            button.style.textShadow = 'none';
            button.style.fontSize = '16px';
            button.style.lineHeight = '1.4';
        });
    }
    
    // Fix background images
    function fixBackgroundImages() {
        const slides = document.querySelectorAll('.hero-slider .swiper-slide');
        slides.forEach((slide, index) => {
            const style = window.getComputedStyle(slide);
            const bgImage = style.backgroundImage;
            console.log('Slide ' + (index + 1) + ' style:', bgImage);
            
            if (bgImage && bgImage !== 'none') {
                slide.style.backgroundSize = 'cover';
                slide.style.backgroundPosition = 'center';
                slide.style.backgroundRepeat = 'no-repeat';
                slide.style.minHeight = '600px';
                console.log('Fixed background for slide ' + (index + 1));
            }
        });
    }
    
    // Run fixes
    fixButtonHTML();
    fixBackgroundImages();
    
    // Run fixes again after a delay to catch dynamic content
    setTimeout(() => {
        fixButtonHTML();
        fixBackgroundImages();
    }, 1000);
    
    console.log('Emergency Button Fix: Complete');
});
