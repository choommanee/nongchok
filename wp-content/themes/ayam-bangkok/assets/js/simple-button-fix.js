
// Simple Button Replacement - No debugging
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        const buttons = document.querySelectorAll(".hero-slider .slide-buttons a");
        buttons.forEach(function(button) {
            const href = button.getAttribute("href") || "#";
            button.innerHTML = "ดูเพิ่มเติม <i class=\"fas fa-arrow-right\"></i>";
            button.setAttribute("href", href);
            
            // Apply clean styles
            button.style.cssText = `
                display: inline-block !important;
                padding: 12px 24px !important;
                background: rgba(255, 255, 255, 0.95) !important;
                color: #333 !important;
                text-decoration: none !important;
                border-radius: 8px !important;
                font-weight: 600 !important;
                border: 2px solid rgba(255, 255, 255, 0.95) !important;
                text-shadow: none !important;
                font-size: 16px !important;
                line-height: 1.4 !important;
                font-family: Sarabun, sans-serif !important;
                white-space: nowrap !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
                transition: all 0.3s ease !important;
            `;
        });
    }, 500);
});
