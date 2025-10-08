// Profile Page JavaScript
(function($) {
    'use strict';
    
    // Initialize when document is ready
    $(document).ready(function() {
        initProfileTabs();
        initPasswordToggle();
        initPasswordStrength();
        initProfileForm();
        initPasswordForm();
        initOrderFilters();
    });
    
    // Profile Tabs Navigation
    function initProfileTabs() {
        $('.profile-nav .nav-link').on('click', function(e) {
            e.preventDefault();
            
            const targetTab = $(this).data('tab');
            
            if (!targetTab || $(this).hasClass('logout')) {
                return;
            }
            
            // Update active nav link
            $('.profile-nav .nav-link').removeClass('active');
            $(this).addClass('active');
            
            // Show target tab content
            $('.tab-content').removeClass('active');
            $('#' + targetTab).addClass('active');
            
            // Update URL hash
            window.history.replaceState(null, null, '#' + targetTab);
        });
        
        // Handle initial hash
        const hash = window.location.hash.substring(1);
        if (hash && $('#' + hash).length) {
            $('.profile-nav .nav-link[data-tab="' + hash + '"]').click();
        }
    }
    
    // Password Toggle Functionality
    function initPasswordToggle() {
        $('.toggle-password').on('click', function() {
            const targetId = $(this).data('target');
            const targetInput = $('#' + targetId);
            const icon = $(this).find('i');
            
            if (targetInput.attr('type') === 'password') {
                targetInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                targetInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    }
    
    // Password Strength Checker
    function initPasswordStrength() {
        $('#new_password').on('input', function() {
            const password = $(this).val();
            const strength = checkPasswordStrength(password);
            
            const strengthBar = $('.strength-bar');
            const strengthText = $('.strength-text');
            
            // Remove all strength classes
            strengthBar.removeClass('weak fair good strong');
            
            if (password.length === 0) {
                strengthText.text('');
                return;
            }
            
            switch (strength.level) {
                case 1:
                    strengthBar.addClass('weak');
                    strengthText.text('รหัสผ่านอ่อน').css('color', '#e74c3c');
                    break;
                case 2:
                    strengthBar.addClass('fair');
                    strengthText.text('รหัสผ่านปานกลาง').css('color', '#f39c12');
                    break;
                case 3:
                    strengthBar.addClass('good');
                    strengthText.text('รหัสผ่านดี').css('color', '#f1c40f');
                    break;
                case 4:
                    strengthBar.addClass('strong');
                    strengthText.text('รหัสผ่านแข็งแกร่ง').css('color', '#27ae60');
                    break;
            }
        });
    }
    
    // Check Password Strength
    function checkPasswordStrength(password) {
        let score = 0;
        const checks = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            numbers: /\d/.test(password),
            special: /[^\w\s]/.test(password)
        };
        
        // Calculate score
        Object.values(checks).forEach(check => {
            if (check) score++;
        });
        
        // Determine strength level
        let level = 1;
        if (score >= 5) level = 4;
        else if (score >= 4) level = 3;
        else if (score >= 3) level = 2;
        
        return { score, level, checks };
    }
    
    // Profile Form Handler
    function initProfileForm() {
        $('#profile-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'ayam_update_profile');
            
            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...').prop('disabled', true);
            
            $.ajax({
                url: ayam_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showMessage('บันทึกข้อมูลเรียบร้อยแล้ว', 'success');
                        
                        // Update display name if changed
                        if (response.data.display_name) {
                            $('.profile-avatar h3').text(response.data.display_name);
                        }
                    } else {
                        showMessage(response.data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
                    }
                },
                error: function() {
                    showMessage('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
    }
    
    // Password Form Handler
    function initPasswordForm() {
        $('#password-form').on('submit', function(e) {
            e.preventDefault();
            
            const newPassword = $('#new_password').val();
            const confirmPassword = $('#confirm_password').val();
            
            // Validate password match
            if (newPassword !== confirmPassword) {
                showMessage('รหัสผ่านใหม่และการยืนยันไม่ตรงกัน', 'error');
                return;
            }
            
            // Check password strength
            const strength = checkPasswordStrength(newPassword);
            if (strength.level < 2) {
                showMessage('รหัสผ่านต้องมีความแข็งแกร่งอย่างน้อยระดับปานกลาง', 'error');
                return;
            }
            
            const formData = new FormData(this);
            formData.append('action', 'ayam_change_password');
            
            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> กำลังเปลี่ยน...').prop('disabled', true);
            
            $.ajax({
                url: ayam_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showMessage('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว', 'success');
                        $('#password-form')[0].reset();
                        $('.strength-bar').removeClass('weak fair good strong');
                        $('.strength-text').text('');
                    } else {
                        showMessage(response.data.message || 'เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน', 'error');
                    }
                },
                error: function() {
                    showMessage('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
    }
    
    // Order Filters
    function initOrderFilters() {
        $('#order-status-filter').on('change', function() {
            const status = $(this).val();
            // TODO: Implement order filtering when order system is ready
            console.log('Filter orders by status:', status);
        });
    }
    
    // Show Message Function
    function showMessage(message, type = 'info') {
        const messageHtml = `
            <div class="profile-message ${type}">
                ${message}
            </div>
        `;
        
        const messageElement = $(messageHtml);
        $('#profile-messages').append(messageElement);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            messageElement.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
        
        // Allow manual close
        messageElement.on('click', function() {
            $(this).fadeOut(300, function() {
                $(this).remove();
            });
        });
    }
    
    // Form Validation Helpers
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function validatePhone(phone) {
        const re = /^[0-9+\-\s()]+$/;
        return re.test(phone);
    }
    
    // Real-time validation
    $('#user_email').on('blur', function() {
        const email = $(this).val();
        if (email && !validateEmail(email)) {
            $(this).css('border-color', '#e74c3c');
            showMessage('รูปแบบอีเมลไม่ถูกต้อง', 'error');
        } else {
            $(this).css('border-color', '#ecf0f1');
        }
    });
    
    $('#phone').on('blur', function() {
        const phone = $(this).val();
        if (phone && !validatePhone(phone)) {
            $(this).css('border-color', '#e74c3c');
            showMessage('รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง', 'error');
        } else {
            $(this).css('border-color', '#ecf0f1');
        }
    });
    
})(jQuery);