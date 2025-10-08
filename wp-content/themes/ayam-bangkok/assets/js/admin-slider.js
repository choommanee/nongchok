/**
 * Simple Admin Slider JavaScript - No Form Blocking
 */

jQuery(document).ready(function($) {
    console.log("🎛️ Slider admin JS loaded");
    
    // ลบ event listeners เก่าทั้งหมดที่อาจบล็อก form
    $("form").off();
    
    // ไม่เพิ่ม form validation ที่บล็อก - ให้ form submit ตามปกติ
    console.log("✅ Form validation disabled - forms can submit normally");
    
    // Media Library function
    window.selectMedia = function(slideIndex) {
        console.log("🖼️ Opening media library for slide", slideIndex);
        
        if (typeof wp === "undefined" || typeof wp.media === "undefined") {
            alert("WordPress Media Library ไม่พร้อมใช้งาน\nกรุณารีเฟรชหน้าและลองใหม่");
            return;
        }
        
        try {
            const mediaUploader = wp.media({
                title: "เลือกรูปภาพสำหรับ Slider",
                button: { text: "เลือกรูปนี้" },
                multiple: false,
                library: { type: "image" }
            });
            
            mediaUploader.on("select", function() {
                try {
                    const attachment = mediaUploader.state().get("selection").first().toJSON();
                    const imageUrl = attachment.url;
                    
                    console.log("✅ Image selected:", imageUrl);
                    
                    // Update input field
                    const $input = $("#slide_image_" + slideIndex);
                    $input.val(imageUrl);
                    
                    // Update preview
                    const $preview = $("#preview_" + slideIndex);
                    $preview.attr("src", imageUrl).show();
                    
                    alert("เลือกรูปภาพเรียบร้อยแล้ว");
                } catch (error) {
                    console.error("Error selecting media:", error);
                    alert("เกิดข้อผิดพลาดในการเลือกรูปภาพ");
                }
            });
            
            mediaUploader.open();
            
        } catch (error) {
            console.error("Error opening media library:", error);
            alert("ไม่สามารถเปิด Media Library ได้");
        }
    };
    
    // Add slide function
    window.addSlide = function() {
        const slideCount = $(".slide-item").length;
        console.log("➕ Adding new slide", slideCount + 1);
        
        const slideHtml = `
        <div class="slide-item" style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; padding: 24px; margin: 20px 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3>📸 Slide ${slideCount + 1}</h3>
                <button type="button" onclick="removeSlide(this)" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">🗑️ ลบ</button>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">รูปภาพ</label>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <button type="button" onclick="selectMedia(${slideCount})" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">📁 เลือกรูปจาก Media</button>
                    <input type="url" name="slides[${slideCount}][image]" id="slide_image_${slideCount}" placeholder="หรือใส่ URL รูปภาพ" style="flex: 1; padding: 8px; border: 2px solid #e2e8f0; border-radius: 6px;">
                </div>
                <img src="" id="preview_${slideCount}" style="display: none; max-width: 200px; height: 120px; object-fit: cover; border-radius: 8px; margin-top: 10px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">หัวข้อ</label>
                <input type="text" name="slides[${slideCount}][title]" placeholder="หัวข้อของ slide" style="width: 100%; padding: 8px; border: 2px solid #e2e8f0; border-radius: 6px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">คำอธิบาย</label>
                <textarea name="slides[${slideCount}][description]" rows="3" placeholder="คำอธิบายรายละเอียด" style="width: 100%; padding: 8px; border: 2px solid #e2e8f0; border-radius: 6px;"></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px;">ข้อความปุ่ม</label>
                    <input type="text" name="slides[${slideCount}][button_text]" placeholder="เช่น: เรียนรู้เพิ่มเติม" style="width: 100%; padding: 8px; border: 2px solid #e2e8f0; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px;">ลิงก์ปุ่ม</label>
                    <input type="url" name="slides[${slideCount}][button_url]" placeholder="https://example.com" style="width: 100%; padding: 8px; border: 2px solid #e2e8f0; border-radius: 6px;">
                </div>
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px;">ตำแหน่งข้อความ</label>
                <select name="slides[${slideCount}][text_position]" style="padding: 8px; border: 2px solid #e2e8f0; border-radius: 6px;">
                    <option value="left">ซ้าย</option>
                    <option value="center" selected>กลาง</option>
                    <option value="right">ขวา</option>
                </select>
            </div>
        </div>`;
        
        $("#slider-images").append(slideHtml);
    };
    
    // Remove slide function
    window.removeSlide = function(button) {
        if ($(".slide-item").length > 1) {
            console.log("🗑️ Removing slide");
            $(button).closest(".slide-item").remove();
        } else {
            alert("ต้องมีอย่างน้อย 1 slide");
        }
    };
    
    // Image preview functionality
    $(document).on('input', 'input[type="url"][name*="[image]"]', function() {
        const $input = $(this);
        const url = $input.val().trim();
        const slideIndex = $input.attr('name').match(/\[(\d+)\]/)[1];
        const $preview = $('#preview_' + slideIndex);
        
        if (url) {
            $preview.attr('src', url).show();
        } else {
            $preview.hide();
        }
    });
    
    console.log("🚀 All functions loaded - forms should work normally");
});