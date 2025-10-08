// Member Registration Page JavaScript

(function($) {
    'use strict';
    
    $(document).ready(function() {
        initMembershipSelection();
        initFormValidation();
        initFormSubmission();
        initPasswordStrength();
    });
    
    // Membership Type Selection
    function initMembershipSelection() {
        $('.select-membership').on('click', function(e) {
            e.preventDefault();
            
            const membershipType = $(this).data('type');
            
            // Update UI
            $('.membership-card').removeClass('selected');
            $(this).closest('.membership-card').addClass('selected');
            
            // Set form value
            $('#membershipType').val(membershipType);
            
            // Show/hide business info section
            if (membershipType === 'premium') {
                $('#businessInfo').slideDown();
            } else {
                $('#businessInfo').slideUp();
            }
            
            // Show registration form
            $('#registrationForm').slideDown();
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#registrationForm').offset().top - 100
            }, 800);
        });
    }
    
    // Form Validation
    function initFormValidation() {
        const form = $('#memberRegistrationForm');
        
        // Real-time validation
        form.find('input, select, textarea').on('blur', function() {
            validateField($(this));
        });
        
        // Username availability check
        $('#username').on('blur', function() {
            checkUsernameAvailability($(this));
        });
        
        // Email availability check
        $('#email').on('blur', function() {
            checkEmailAvailability($(this));
        });
        
        // Password confirmation
        $('#confirm_password').on('input', function() {
            validatePasswordConfirmation();
        });
    }
    
    // Field Validation
    function validateField($field) {
        const fieldName = $field.attr('name');
        const fieldValue = $field.val().trim();
        const $formGroup = $field.closest('.form-group');
        
        // Remove previous error state
        $formGroup.removeClass('error');
        $formGroup.find('.error-message').remove();
        
        let isValid = true;
        let errorMessage = '';
        
        // Required field validation
        if ($field.prop('required') && !fieldValue) {
            isValid = false;
            errorMessage = 'กรุณากรอกข้อมูลในช่องนี้';
        }
        
        // Specific field validations
        switch (fieldName) {
            case 'username':
                if (fieldValue && !/^[a-zA-Z0-9_]{3,20}$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = 'ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษและตัวเลข 3-20 ตัวอักษร';
                }
                break;
                
            case 'email':
                if (fieldValue && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = 'รูปแบบอีเมลไม่ถูกต้อง';
                }
                break;
                
            case 'password':
                if (fieldValue && fieldValue.length < 8) {
                    isValid = false;
                    errorMessage = 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร';
                }
                break;
                
            case 'phone':
                if (fieldValue && !/^[0-9+\-\s()]{10,15}$/.test(fieldValue)) {
                    isValid = false;
                    errorMessage = 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง';
                }
                break;
        }
        
        if (!isValid) {
            $formGroup.addClass('error');
            $formGroup.append(`<div class="error-message">${errorMessage}</div>`);
        }
        
        return isValid;
    }
    
    // Check Username Availability
    function checkUsernameAvailability($field) {
        const username = $field.val().trim();
        const $formGroup = $field.closest('.form-group');
        
        if (!username || username.length < 3) return;
        
        // Show loading state
        $formGroup.find('.availability-check').remove();
        $formGroup.append('<div class="availability-check"><i class="fas fa-spinner fa-spin"></i> กำลังตรวจสอบ...</div>');
        
        $.ajax({
            url: ayam_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'check_username_availability',
                username: username,
                nonce: ayam_ajax.nonce
            },
            success: function(response) {
                $formGroup.find('.availability-check').remove();
                
                if (response.success) {
                    if (response.data.available) {
                        $formGroup.append('<div class="availability-check success"><i class="fas fa-check"></i> ชื่อผู้ใช้นี้ใช้ได้</div>');
                    } else {
                        $formGroup.addClass('error');
                        $formGroup.append('<div class="availability-check error"><i class="fas fa-times"></i> ชื่อผู้ใช้นี้ถูกใช้แล้ว</div>');
                    }
                }
            },
            error: function() {
                $formGroup.find('.availability-check').remove();
            }
        });
    }
    
    // Check Email Availability
    function checkEmailAvailability($field) {
        const email = $field.val().trim();
        const $formGroup = $field.closest('.form-group');
        
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return;
        
        // Show loading state
        $formGroup.find('.availability-check').remove();
        $formGroup.append('<div class="availability-check"><i class="fas fa-spinner fa-spin"></i> กำลังตรวจสอบ...</div>');
        
        $.ajax({
            url: ayam_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'check_email_availability',
                email: email,
                nonce: ayam_ajax.nonce
            },
            success: function(response) {
                $formGroup.find('.availability-check').remove();
                
                if (response.success) {
                    if (response.data.available) {
                        $formGroup.append('<div class="availability-check success"><i class="fas fa-check"></i> อีเมลนี้ใช้ได้</div>');
                    } else {
                        $formGroup.addClass('error');
                        $formGroup.append('<div class="availability-check error"><i class="fas fa-times"></i> อีเมลนี้ถูกใช้แล้ว</div>');
                    }
                }
            },
            error: function() {
                $formGroup.find('.availability-check').remove();
            }
        });
    }
    
    // Password Confirmation Validation
    function validatePasswordConfirmation() {
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        const $formGroup = $('#confirm_password').closest('.form-group');
        
        $formGroup.removeClass('error');
        $formGroup.find('.error-message').remove();
        
        if (confirmPassword && password !== confirmPassword) {
            $formGroup.addClass('error');
            $formGroup.append('<div class="error-message">รหัสผ่านไม่ตรงกัน</div>');
            return false;
        }
        
        return true;
    }
    
    // Password Strength Indicator
    function initPasswordStrength() {
        $('#password').on('input', function() {
            const password = $(this).val();
            const $formGroup = $(this).closest('.form-group');
            
            // Remove existing strength indicator
            $formGroup.find('.password-strength').remove();
            
            if (password.length > 0) {
                const strength = calculatePasswordStrength(password);
                const strengthClass = getStrengthClass(strength);
                const strengthText = getStrengthText(strength);
                
                $formGroup.append(`
                    <div class="password-strength ${strengthClass}">
                        <div class="strength-bar">
                            <div class="strength-fill" style="width: ${strength}%"></div>
                        </div>
                        <span class="strength-text">${strengthText}</span>
                    </div>
                `);
            }
        });
    }
    
    // Calculate Password Strength
    function calculatePasswordStrength(password) {
        let strength = 0;
        
        // Length
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 25;
        
        // Character types
        if (/[a-z]/.test(password)) strength += 15;
        if (/[A-Z]/.test(password)) strength += 15;
        if (/[0-9]/.test(password)) strength += 10;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 10;
        
        return Math.min(strength, 100);
    }
    
    // Get Strength Class
    function getStrengthClass(strength) {
        if (strength < 30) return 'weak';
        if (strength < 60) return 'medium';
        if (strength < 80) return 'good';
        return 'strong';
    }
    
    // Get Strength Text
    function getStrengthText(strength) {
        if (strength < 30) return 'อ่อน';
        if (strength < 60) return 'ปานกลาง';
        if (strength < 80) return 'ดี';
        return 'แข็งแกร่ง';
    }
    
    // Form Submission
    function initFormSubmission() {
        $('#memberRegistrationForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $('#submitRegistration');
            
            // Validate all fields
            let isFormValid = true;
            $form.find('input[required], select[required], textarea[required]').each(function() {
                if (!validateField($(this))) {
                    isFormValid = false;
                }
            });
            
            // Check password confirmation
            if (!validatePasswordConfirmation()) {
                isFormValid = false;
            }
            
            // Check terms agreement
            if (!$('#agree_terms').is(':checked')) {
                alert('กรุณายอมรับข้อกำหนดและเงื่อนไข');
                isFormValid = false;
            }
            
            if (!isFormValid) {
                // Scroll to first error
                const $firstError = $('.form-group.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 500);
                }
                return;
            }
            
            // Show loading state
            $submitBtn.prop('disabled', true);
            $submitBtn.find('.btn-text').hide();
            $submitBtn.find('.btn-loading').show();
            
            // Submit form
            $.ajax({
                url: ayam_ajax.ajax_url,
                type: 'POST',
                data: $form.serialize() + '&action=register_member',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showSuccessMessage(response.data.message);
                        
                        // Redirect after delay
                        setTimeout(function() {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                window.location.href = '/login';
                            }
                        }, 2000);
                    } else {
                        showErrorMessage(response.data.message || 'เกิดข้อผิดพลาดในการสมัครสมาชิก');
                    }
                },
                error: function() {
                    showErrorMessage('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง');
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false);
                    $submitBtn.find('.btn-text').show();
                    $submitBtn.find('.btn-loading').hide();
                }
            });
        });
    }
    
    // Show Success Message
    function showSuccessMessage(message) {
        const $alert = $(`
            <div class="alert alert-success" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
                <i class="fas fa-check-circle"></i> ${message}
            </div>
        `);
        
        $('body').append($alert);
        
        setTimeout(function() {
            $alert.fadeOut(function() {
                $alert.remove();
            });
        }, 5000);
    }
    
    // Show Error Message
    function showErrorMessage(message) {
        const $alert = $(`
            <div class="alert alert-error" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
                <i class="fas fa-exclamation-circle"></i> ${message}
            </div>
        `);
        
        $('body').append($alert);
        
        setTimeout(function() {
            $alert.fadeOut(function() {
                $alert.remove();
            });
        }, 5000);
    }
    
})(jQuery);

// Additional CSS for alerts
const alertStyles = `
<style>
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    font-weight: 500;
    animation: slideInRight 0.3s ease;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert i {
    margin-right: 8px;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.password-strength {
    margin-top: 8px;
}

.strength-bar {
    width: 100%;
    height: 4px;
    background: #eee;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 5px;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.password-strength.weak .strength-fill {
    background: #e74c3c;
}

.password-strength.medium .strength-fill {
    background: #f39c12;
}

.password-strength.good .strength-fill {
    background: #3498db;
}

.password-strength.strong .strength-fill {
    background: #27ae60;
}

.strength-text {
    font-size: 0.8rem;
    font-weight: 500;
}

.password-strength.weak .strength-text {
    color: #e74c3c;
}

.password-strength.medium .strength-text {
    color: #f39c12;
}

.password-strength.good .strength-text {
    color: #3498db;
}

.password-strength.strong .strength-text {
    color: #27ae60;
}

.availability-check {
    margin-top: 5px;
    font-size: 0.85rem;
    font-weight: 500;
}

.availability-check.success {
    color: #27ae60;
}

.availability-check.error {
    color: #e74c3c;
}

.availability-check i {
    margin-right: 5px;
}
</style>
`;

// Inject styles
if (!document.querySelector('#register-alert-styles')) {
    const styleElement = document.createElement('div');
    styleElement.id = 'register-alert-styles';
    styleElement.innerHTML = alertStyles;
    document.head.appendChild(styleElement);
}