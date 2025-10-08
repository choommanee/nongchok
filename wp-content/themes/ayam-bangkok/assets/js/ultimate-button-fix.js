
// Ultimate Button Fix JavaScript
(function() {
    "use strict";
    
    console.log("Ultimate Button Fix: Starting...");
    
    function ultimateButtonFix() {
        // Fix buttons
        const buttons = document.querySelectorAll(".hero-slider .slide-buttons a");
        console.log("Found buttons:", buttons.length);
        
        buttons.forEach((button, index) => {
            // Get original href
            const href = button.getAttribute("href") || "#";
            
            // Clean and rebuild button
            button.innerHTML = "ดูเพิ่มเติม <i class=\"fas fa-arrow-right\"></i>";
            button.setAttribute("href", href);
            
            // Apply styles directly
            const styles = {
                display: "inline-block",
                padding: "12px 24px",
                background: "rgba(255, 255, 255, 0.95)",
                color: "#333",
                textDecoration: "none",
                borderRadius: "8px",
                fontWeight: "600",
                border: "2px solid rgba(255, 255, 255, 0.95)",
                textShadow: "none",
                fontSize: "16px",
                lineHeight: "1.4",
                fontFamily: "Sarabun, sans-serif",
                whiteSpace: "nowrap",
                boxShadow: "0 2px 10px rgba(0, 0, 0, 0.1)",
                transition: "all 0.3s ease"
            };
            
            Object.assign(button.style, styles);
            
            // Add hover effect
            button.addEventListener("mouseenter", function() {
                this.style.background = "rgba(255, 255, 255, 1)";
                this.style.transform = "translateY(-2px)";
                this.style.boxShadow = "0 4px 20px rgba(0, 0, 0, 0.2)";
            });
            
            button.addEventListener("mouseleave", function() {
                this.style.background = "rgba(255, 255, 255, 0.95)";
                this.style.transform = "translateY(0)";
                this.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)";
            });
            
            console.log("Fixed button " + (index + 1));
        });
        
        // Fix background images
        const slides = document.querySelectorAll(".hero-slider .swiper-slide");
        slides.forEach((slide, index) => {
            const bgImage = slide.style.backgroundImage;
            if (bgImage && bgImage !== "none") {
                slide.style.backgroundSize = "cover";
                slide.style.backgroundPosition = "center center";
                slide.style.backgroundRepeat = "no-repeat";
                slide.style.minHeight = "600px";
                console.log("Fixed background for slide " + (index + 1));
            }
        });
    }
    
    // Run on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", ultimateButtonFix);
    } else {
        ultimateButtonFix();
    }
    
    // Run again after swiper initialization
    setTimeout(ultimateButtonFix, 1000);
    setTimeout(ultimateButtonFix, 3000);
    
    console.log("Ultimate Button Fix: Initialized");
})();
