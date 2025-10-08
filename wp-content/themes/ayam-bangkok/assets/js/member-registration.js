/**
 * Member Registration Form Handler
 * Handles multi-step form, validation, and AJAX submission
 */

(function($) {
    'use strict';

    // Form state
    let currentStep = 1;
    const totalSteps = 3;
    let formData = {};

    // Initialize on document ready
    $(document).ready(function() {
        initRegistrationForm();
    });

    /**
     * Initialize registration form
     */
    function initRegistrationForm() {
        // Navigation buttons
        $('.btn-next').on('click', handleNextStep);
        $('.btn-prev').on('click', handlePrevStep);
        
        // Form submission
        $('#member-registration-form').on('submit', handleFormSubmit);
        
        // Password toggle
        $('.toggle-password').on('click', togglePasswordVisibility);
        
        // Real-time validation
        $('#username').on('blur', validateUsername);
        $('#email').on('blur', validateEmail);
        $('#password').on('input', validatePassword);
        $('#confirm_password').on('input', validateConfirmPassword);
        $('#phone').on('blur', validatePhone);
        
        // Clear error on input
        $('input, select, textarea').on('input change', function() {
            clearFieldError($(this));
        });
    }

    /**
     * Handle next step
     */
    function handleNextStep() {
        if (validateCurrentStep()) {
            saveCurrentStepData();
            
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepDisplay();
                
                // Update summary on step 3
                if (currentStep === 3) {
                    updateConfirmationSummary();
                }
            }
        }
    }

    /**
     * Handle previous step
     */
    function handlePrevStep() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    }

    /**
     * Update step display
     */
    function updateStepDisplay() {
        // Update step indicators
        $('.step').removeClass('active completed');
        $('.step').each(function() {
            const stepNum = parseInt($(this).data('step'));
            if (stepNum < currentStep) {
                $(this).addClass('completed');
            } else if (stepNum === currentStep) {
                $(this).addClass('active');
            }
        });
        
        // Update form steps
        $('.form-step').removeClass('active');
        $(`.form-step[data-step="${currentStep}"]`).addClass('active');
        
        // Scroll to top
        $('html, body').animate({
            scrollTop: $('.form-container').offset().top - 100
        }, 400);
    }

    /**
     * Validate current step
     */
    function validateCurrentStep() {
        const $currentStep = $(`.form-step[data-step="${currentStep}"]`);
        let isValid = true;
        
        // Get all required fields in current step
        $currentStep.find('input[required], select[required]').each(function() {
            if (!validateField($(this))) {
                isValid = false;
            }
        });
        
        // Additional validations for step 1
        if (currentStep === 1) {
            if (!validateUsername(null, true)) isValid = false;
            if (!validateEmail(null, true)) isValid = false;
            if (!validatePassword(null, true)) isValid = false;
            if (!validateConfirmPassword(null, true)) isValid = false;
        }
        
        // Additional validations for step 2
        if (currentStep === 2) {
            if (!validatePhone(null, true)) isValid = false;
        }
        
        // Additional validations for step 3
        if (currentStep === 3) {
            if (!$('#agree_terms').is(':checked')) {
                showFieldError($('#agree_terms'), 'กรุณายอมรับข้อกำหนดและเงื่อนไข');
                isValid = false;
            }
        }
        
        return isValid;
    }

    /**
     * Validate individual field
     */
    function validateField($field) {
        const value = $field.val().trim();
        const fieldName = $field.attr('name');
        
        if ($field.prop('required') && !value) {
            showFieldError($field, 'กรุณากรอกข้อมูลในช่องนี้');
            return false;
        }
        
        clearFieldError($field);
        return true;
    }

    /**
     * Validate username
     */
    function validateUsername(event, silent = false) {
        const $field = $('#username');
        const value = $field.val().trim();
        
        if (!value) {
            if (!silent) showFieldError($field, 'กรุณากรอกชื่อผู้ใช้');
            return false;
        }
        
        // Check format (alphanumeric only)
        if (!/^[a-zA-Z0-9_]+$/.test(value)) {
            if (!silent) showFieldError($field, 'ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษและตัวเลขเท่านั้น');
            return false;
        }
        
        // Check length
        if (value.length < 4) {
            if (!silent) showFieldError($field, 'ชื่อผู้ใช้ต้องมีอย่างน้อย 4 ตัวอักษร');
            return false;
        }
        
        clearFieldError($field);
        return true;
    }

    /**
     * Validate email
     */
    function validateEmail(event, silent = false) {
        const $field = $('#email');
        const value = $field.val().trim();
        
        if (!value) {
            if (!silent) showFieldError($field, 'กรุณากรอกอีเมล');
            return false;
        }
        
        // Check email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            if (!silent) showFieldError($field, 'รูปแบบอีเมลไม่ถูกต้อง');
            return false;
        }
        
        clearFieldError($field);
        return true;
    }

    /**
     * Validate password
     */
    function validatePassword(event, silent = false) {
        const $field = $('#password');
        const value = $field.val();
        
        if (!value) {
            if (!silent) showFieldError($field, 'กรุณากรอกรหัสผ่าน');
            return false;
        }
        
        // Check length
        if (value.length < 8) {
            if (!silent) showFieldError($field, 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร');
            return false;
        }
        
        // Check complexity
        const hasUpperCase = /[A-Z]/.test(value);
        const hasLowerCase = /[a-z]/.test(value);
        const hasNumber = /[0-9]/.test(value);
        
        if (!hasUpperCase || !hasLowerCase || !hasNumber) {
            if (!silent) showFieldError($field, 'รหัสผ่านต้องมีตัวพิมพ์ใหญ่ พิมพ์เล็ก และตัวเลข');
            return false;
        }
        
        clearFieldError($field);
        
        // Also validate confirm password if it has value
        if ($('#confirm_password').val()) {
            validateConfirmPassword(null, silent);
        }
        
        return true;
    }

    /**
     * Validate confirm password
     */
    function validateConfirmPassword(event, silent = false) {
        const $field = $('#confirm_password');
        const value = $field.val();
        const password = $('#password').val();
        
        if (!value) {
            if (!silent) showFieldError($field, 'กรุณายืนยันรหัสผ่าน');
            return false;
        }
        
        if (value !== password) {
            if (!silent) showFieldError($field, 'รหัสผ่านไม่ตรงกัน');
            return false;
        }
        
        clearFieldError($field);
        return true;
    }

    /**
     * Validate phone
     */
    function validatePhone(event, silent = false) {
        const $field = $('#phone');
        const value = $field.val().trim();
        
        if (!value) {
            if (!silent) showFieldError($field, 'กรุณากรอกเบอร์โทรศัพท์');
            return false;
        }
        
        // Check phone format (allow digits, spaces, dashes, parentheses, plus)
        if (!/^[\d\s\-\(\)\+]+$/.test(value)) {
            if (!silent) showFieldError($field, 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง');
            return false;
        }
        
        // Check minimum length (at least 9 digits)
        const digitsOnly = value.replace(/\D/g, '');
        if (digitsOnly.length < 9) {
            if (!silent) showFieldError($field, 'เบอร์โทรศัพท์ต้องมีอย่างน้อย 9 หลัก');
            return false;
        }
        
        clearFieldError($field);
        return true;
    }

    /**
     * Show field error
     */
    function showFieldError($field, message) {
        const $formGroup = $field.closest('.form-group');
        $formGroup.addClass('error');
        $formGroup.find('.error-message').text(message);
    }

    /**
     * Clear field error
     */
    function clearFieldError($field) {
        const $formGroup = $field.closest('.form-group');
        $formGroup.removeClass('error');
        $formGroup.find('.error-message').text('');
    }

    /**
     * Save current step data
     */
    function saveCurrentStepData() {
        const $currentStep = $(`.form-step[data-step="${currentStep}"]`);
        
        $currentStep.find('input, select, textarea').each(function() {
            const $field = $(this);
            const name = $field.attr('name');
            
            if (name) {
                if ($field.attr('type') === 'checkbox') {
                    if (name.includes('[]')) {
                        // Handle checkbox arrays
                        const baseName = name.replace('[]', '');
                        if (!formData[baseName]) {
                            formData[baseName] = [];
                        }
                        if ($field.is(':checked')) {
                            formData[baseName].push($field.val());
                        }
                    } else {
                        formData[name] = $field.is(':checked');
                    }
                } else {
                    formData[name] = $field.val();
                }
            }
        });
    }

    /**
     * Update confirmation summary
     */
    function updateConfirmationSummary() {
        // Personal info
        $('#summary-name').text(`${formData.first_name} ${formData.last_name}`);
        $('#summary-username').text(formData.username);
        $('#summary-email').text(formData.email);
        
        // Contact info
        $('#summary-phone').text(formData.phone);
        
        // Country
        const countryText = $('#country option:selected').text();
        $('#summary-country').text(countryText);
        
        // Business type
        const businessText = $('#business_type option:selected').text();
        $('#summary-business').text(businessText || '-');
    }

    /**
     * Toggle password visibility
     */
    function togglePasswordVisibility() {
        const $button = $(this);
        const $input = $button.siblings('input');
        const $icon = $button.find('i');
        
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    /**
     * Handle form submission
     */
    function handleFormSubmit(e) {
        e.preventDefault();
        
        // Validate final step
        if (!validateCurrentStep()) {
            return;
        }
        
        // Save final step data
        saveCurrentStepData();
        
        // Show loading state
        const $submitBtn = $('.btn-submit');
        $submitBtn.addClass('loading').prop('disabled', true);
        
        // Prepare form data
        const submitData = new FormData();
        submitData.append('action', 'ayam_register_member');
        submitData.append('nonce', $('#registration_nonce').val());
        
        // Add all form data
        for (const [key, value] of Object.entries(formData)) {
            if (Array.isArray(value)) {
                value.forEach(v => submitData.append(`${key}[]`, v));
            } else {
                submitData.append(key, value);
            }
        }
        
        // Submit via AJAX
        $.ajax({
            url: ayamAjax.ajaxurl,
            type: 'POST',
            data: submitData,
            processData: false,
            contentType: false,
            success: function(response) {
                $submitBtn.removeClass('loading').prop('disabled', false);
                
                if (response.success) {
                    // Show success modal
                    showSuccessModal();
                    
                    // Reset form
                    $('#member-registration-form')[0].reset();
                    currentStep = 1;
                    formData = {};
                    updateStepDisplay();
                } else {
                    // Show error message
                    alert(response.data.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
            },
            error: function(xhr, status, error) {
                $submitBtn.removeClass('loading').prop('disabled', false);
                console.error('Registration error:', error);
                alert('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง');
            }
        });
    }

    /**
     * Show success modal
     */
    function showSuccessModal() {
        $('#registration-success-modal').fadeIn(300);
        
        // Close on overlay click
        $('.modal-overlay').on('click', function() {
            $('#registration-success-modal').fadeOut(300);
        });
    }

})(jQuery);
