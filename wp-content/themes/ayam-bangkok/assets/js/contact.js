/**
 * Contact Page JavaScript
 * Handles contact form submission and FAQ accordion
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        initContactPage();
    });

    /**
     * Initialize contact page
     */
    function initContactPage() {
        // Contact form submission
        $('#contact-form').on('submit', handleFormSubmit);
        
        // FAQ accordion
        $('.faq-question').on('click', toggleFAQ);
        
        // Subject change handler
        $('#contact_subject').on('change', handleSubjectChange);
        
        // Real-time validation
        $('#contact_email').on('blur', validateEmail);
        $('#contact_phone').on('blur', validatePhone);
        
        // Clear error on input
        $('input, select, textarea').on('input change', function() {
            clearFieldError($(this));
        });
        
        // Initialize AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 600,
                once: true
            });
        }
    }

    /**
     * Handle form submission
     */
    function handleFormSubmit(e) {
        e.preventDefault();
        
        // Validate form
        if (!validateForm()) {
            return;
        }
        
        const $form = $(this);
        const $submitBtn = $form.find('.btn-submit');
        const $response = $form.find('.form-response');
        
        // Show loading state
        $submitBtn.addClass('loading').prop('disabled', true);
        $response.hide();
        
        // Prepare form data
        const formData = new FormData($form[0]);
        formData.append('action', 'ayam_contact_form');
        
        // Submit via AJAX
        $.ajax({
            url: ayamContact.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $submitBtn.removeClass('loading').prop('disabled', false);
                
                if (response.success) {
                    // Show success message
                    $response
                        .removeClass('error')
                        .addClass('success')
                        .html('<i class="fas fa-check-circle"></i> ' + response.data.message)
                        .fadeIn();
                    
                    // Reset form
                    $form[0].reset();
                    $('.visit-date-row').hide();
                    
                    // Scroll to response
                    $('html, body').animate({
                        scrollTop: $response.offset().top - 100
                    }, 400);
                } else {
                    // Show error message
                    $response
                        .removeClass('success')
                        .addClass('error')
                        .html('<i class="fas fa-exclamation-circle"></i> ' + response.data.message)
                        .fadeIn();
                }
            },
            error: function() {
                $submitBtn.removeClass('loading').prop('disabled', false);
                $response
                    .removeClass('success')
                    .addClass('error')
                    .html('<i class="fas fa-exclamation-circle"></i> ' + ayamContact.strings.error)
                    .fadeIn();
            }
        });
    }

    /**
     * Validate form
     */
    function validateForm() {
        let isValid = true;
        
        // Name validation
        const $name = $('#contact_name');
        if (!$name.val().trim()) {
            showFieldError($name, ayamContact.strings.name_required);
            isValid = false;
        }
        
        // Email validation
        if (!validateEmail()) {
            isValid = false;
        }
        
        // Subject validation
        const $subject = $('#contact_subject');
        if (!$subject.val()) {
            showFieldError($subject, ayamContact.strings.subject_required);
            isValid = false;
        }
        
        // Message validation
        const $message = $('#contact_message');
        if (!$message.val().trim()) {
            showFieldError($message, ayamContact.strings.message_required);
            isValid = false;
        }
        
        return isValid;
    }

    /**
     * Validate email
     */
    function validateEmail() {
        const $email = $('#contact_email');
        const email = $email.val().trim();
        
        if (!email) {
            showFieldError($email, ayamContact.strings.email_required);
            return false;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showFieldError($email, ayamContact.strings.email_invalid);
            return false;
        }
        
        clearFieldError($email);
        return true;
    }

    /**
     * Validate phone
     */
    function validatePhone() {
        const $phone = $('#contact_phone');
        const phone = $phone.val().trim();
        
        // Phone is optional, so only validate if provided
        if (phone) {
            if (!/^[\d\s\-\(\)\+]+$/.test(phone)) {
                showFieldError($phone, ayamContact.strings.phone_invalid);
                return false;
            }
            
            const digitsOnly = phone.replace(/\D/g, '');
            if (digitsOnly.length < 9) {
                showFieldError($phone, ayamContact.strings.phone_invalid);
                return false;
            }
        }
        
        clearFieldError($phone);
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
     * Handle subject change
     */
    function handleSubjectChange() {
        const subject = $(this).val();
        const $visitDateRow = $('.visit-date-row');
        
        if (subject === 'visit') {
            $visitDateRow.slideDown(300);
        } else {
            $visitDateRow.slideUp(300);
        }
    }

    /**
     * Toggle FAQ
     */
    function toggleFAQ() {
        const $item = $(this).closest('.faq-item');
        const $allItems = $('.faq-item');
        
        // Close other items
        $allItems.not($item).removeClass('active');
        
        // Toggle current item
        $item.toggleClass('active');
    }

})(jQuery);
