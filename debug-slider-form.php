<?php
/**
 * Debug Slider Form Submission
 */

require_once 'wp-config.php';

echo "<h1>🐛 Debug Slider Form Submission</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #ef4444; }</style>";

// ตรวจสอบ POST data
echo "<div style='background: #fef2f2; border: 2px solid #ef4444; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #dc2626; margin-top: 0;'>🔍 ตรวจสอบ Form Submission</h2>";

if (!empty($_POST)) {
    echo "<h3>📥 POST Data ที่ได้รับ:</h3>";
    echo "<pre style='background: #f8fafc; padding: 15px; border-radius: 8px; overflow-x: auto;'>";
    print_r($_POST);
    echo "</pre>";
    
    if (isset($_POST['save_slider'])) {
        echo "<p style='color: #10b981;'>✅ พบ save_slider button</p>";
    } else {
        echo "<p style='color: #ef4444;'>❌ ไม่พบ save_slider button</p>";
    }
    
    if (isset($_POST['ayam_slider_nonce'])) {
        echo "<p style='color: #10b981;'>✅ พบ nonce field</p>";
        $nonce_valid = wp_verify_nonce($_POST['ayam_slider_nonce'], 'ayam_slider_save');
        echo "<p>Nonce valid: " . ($nonce_valid ? '✅ ถูกต้อง' : '❌ ไม่ถูกต้อง') . "</p>";
    } else {
        echo "<p style='color: #ef4444;'>❌ ไม่พบ nonce field</p>";
    }
} else {
    echo "<p style='color: #f59e0b;'>⚠️ ไม่มี POST data - Form ไม่ได้ถูก submit</p>";
}

echo "</div>";

// สร้าง simple test form
echo "<div style='background: #f0f9ff; border: 2px solid #3b82f6; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #1e40af; margin-top: 0;'>🧪 ทดสอบ Form ง่ายๆ</h2>";

echo "<form method='post' action='' style='background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;'>";
wp_nonce_field('ayam_slider_save', 'ayam_slider_nonce');
echo "<input type='hidden' name='slides[0][image]' value='test-image.jpg'>";
echo "<input type='hidden' name='slides[0][title]' value='Test Slide'>";
echo "<input type='hidden' name='autoplay' value='1'>";
echo "<p>ฟอร์มทดสอบง่ายๆ:</p>";
echo "<input type='submit' name='save_slider' value='🧪 ทดสอบ Submit' class='button-primary' style='background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;'>";
echo "</form>";

echo "</div>";

// ตรวจสอบ JavaScript
echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #059669; margin-top: 0;'>🔧 ตรวจสอบ JavaScript</h2>";

$js_file = get_template_directory() . '/assets/js/admin-slider.js';
if (file_exists($js_file)) {
    $js_content = file_get_contents($js_file);
    echo "<p>✅ ไฟล์ JavaScript มีอยู่ (" . number_format(filesize($js_file)) . " bytes)</p>";
    
    // ตรวจสอบ form validation function
    if (strpos($js_content, 'initializeFormValidation') !== false) {
        echo "<p>✅ พบ initializeFormValidation function</p>";
        
        // ตรวจสอบว่า preventDefault ถูกเรียกหรือไม่
        if (strpos($js_content, 'e.preventDefault()') !== false) {
            echo "<p style='color: #ef4444;'>❌ ยังมี e.preventDefault() ที่อาจบล็อก form submission</p>";
        } else {
            echo "<p style='color: #10b981;'>✅ ไม่มี e.preventDefault() ที่บล็อก</p>";
        }
        
        // ตรวจสอบ return true
        if (strpos($js_content, 'return true') !== false) {
            echo "<p style='color: #10b981;'>✅ มี return true ให้ form submit</p>";
        } else {
            echo "<p style='color: #f59e0b;'>⚠️ ไม่มี return true</p>";
        }
    } else {
        echo "<p style='color: #ef4444;'>❌ ไม่พบ initializeFormValidation function</p>";
    }
} else {
    echo "<p style='color: #ef4444;'>❌ ไม่พบไฟล์ JavaScript</p>";
}

echo "</div>";

// แสดงโค้ด JavaScript ที่ควรจะเป็น
echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h2 style='color: #92400e; margin-top: 0;'>🔧 แก้ไข JavaScript</h2>";

echo "<p>JavaScript ที่ถูกต้องสำหรับ form submission:</p>";
echo "<pre style='background: #f8fafc; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 14px; overflow-x: auto;'>";
echo htmlspecialchars('function initializeFormValidation() {
    $("form").on("submit", function(e) {
        const $form = $(this);
        const $submitBtn = $form.find("input[name=\'save_slider\']");
        
        // Show loading state
        $submitBtn.val("💾 กำลังบันทึก...").prop("disabled", true);
        
        // Allow form to submit normally
        console.log("Form submitted successfully");
        return true; // ต้องมีบรรทัดนี้
    });
}');
echo "</pre>";

echo "</div>";

// ลิงก์ไปยังหน้า admin
echo "<div style='text-align: center; margin: 40px 0; padding: 30px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 16px;'>";
echo "<h2 style='color: #0c4a6e; margin-bottom: 20px;'>🎯 ขั้นตอนต่อไป</h2>";
echo "<p style='font-size: 18px; color: #0369a1; margin-bottom: 25px;'>ทดสอบ form ง่ายๆ ด้านบน แล้วไปแก้ไข JavaScript</p>";

echo "<div style='display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;'>";
echo "<a href='" . admin_url('admin.php?page=ayam-slider-settings') . "' target='_blank' style='background: #3b82f6; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600;'>🎛️ ไปที่ Slider Admin</a>";
echo "</div>";

echo "</div>";

// JavaScript debug script
echo "<script>
console.log('Debug script loaded');

// ตรวจสอบว่า jQuery โหลดแล้วหรือไม่
if (typeof jQuery !== 'undefined') {
    console.log('✅ jQuery loaded');
    
    jQuery(document).ready(function($) {
        console.log('✅ jQuery ready');
        
        // ตรวจสอบ form
        const forms = $('form');
        console.log('Forms found:', forms.length);
        
        // ตรวจสอบ submit button
        const submitBtns = $('input[name=\"save_slider\"]');
        console.log('Submit buttons found:', submitBtns.length);
        
        // เพิ่ม event listener ทดสอบ
        $('form').on('submit', function(e) {
            console.log('🚀 Form submit event triggered!');
            console.log('Form data:', new FormData(this));
        });
    });
} else {
    console.error('❌ jQuery not loaded');
}
</script>";
?>