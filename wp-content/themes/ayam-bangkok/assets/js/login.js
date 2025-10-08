/**
 * Login Page JavaScript
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        initLoginForm();
        initPasswordToggle();
        initMessageHandling();
    });
    
    /**
     * Initialize login form
     */
    function initLoginForm() {
        $('#member-login-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('.btn-login');
            const btnText = submitBtn.find('.btn-text');
            const btnLoading = submitBtn.find('.btn-loading');
            
            // Get form data
            const formData = {
                action: 'ayam_member_login',
                nonce: form.find('#login_nonce').val(),
                username: form.find('#username').val().trim(),
                password: form.find('#password').val(),
                remember: form.find('#remember').is(':checked') ? 1 : 0,
                redirect_to: getUrlParameter('redirect_to') || ''
            };
            
            // Validate form
            if (!validateLoginForm(formData)) {
                return;
            }
            
            // Show loading state
            submitBtn.prop('disabled', true);
            btnText.hide();
            btnLoading.show();
            
            // Submit form
            $.ajax({
                url: ayam_login.ajax_url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showMessage(response.data.message, 'success');
                        
                        // Redirect after short delay
                        setTimeout(function() {
                            if (response.data.redirect) {
                                window.location.href = response.data.redirect;
                            } else {
                                window.location.reload();
                            }
                        }, 1500);
                    } else {
                        showMessage(response.data, 'error');
                        resetSubmitButton();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Login error:', error);
                    showMessage('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', 'error');
                    resetSubmitButton();
                }
            });
            
            function resetSubmitButton() {
                submitBtn.prop('disabled', false);
                btnText.show();
                btnLoading.hide();
            }
        });
    }
    
    /**
     * Validate login form
     */
    function validateLoginForm(data) {
        let isValid = true;
        
        // Clear previous errors
        $('.form-group').removeClass('error');
        $('.error-message').remove();
        
        // Validate username
        if (!data.username) {
            showFieldError('#username', 'กรุณากรอกชื่อผู้ใช้หรืออีเมล');
            isValid = false;
        }
        
        // Validate password
        if (!data.password) {
            showFieldError('#password', 'กรุณากรอกรหัสผ่าน');
            isValid = false;
        }
        
        return isValid;
    }
    
    /**
     * Show field error
     */
    function showFieldError(fieldSelector, message) {
        const field = $(fieldSelector);
        const formGroup = field.closest('.form-group');
        
        formGroup.addClass('error');
        
        if (formGroup.find('.error-message').length === 0) {
            formGroup.append('<div class="error-message">' + message + '</div>');
        }
        
        // Focus on first error field
        if ($('.form-group.error').length === 1) {
            field.focus();
        }
    }
    
    /**
     * Initialize password toggle
     */
    function initPasswordToggle() {
        $('#toggle-password').on('click', function() {
            const passwordField = $('#password');
            const icon = $(this);
            
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    }
    
    /**
     * Initialize message handling
     */
    function initMessageHandling() {
        // Close message on click
        $(document).on('click', '.message-close', function() {
            $(this).closest('.messages-container').fadeOut();
        });
        
        // Auto hide success messages
        setTimeout(function() {
            $('.messages-container .message-content.success').closest('.messages-container').fadeOut();
        }, 5000);
    }
    
    /**
     * Show message
     */
    function showMessage(message, type = 'info') {
        const messagesContainer = $('#login-messages');
        const messageContent = messagesContainer.find('.message-content');
        const messageText = messagesContainer.find('.message-text');
        
        // Set message content
        messageText.html(message);
        
        // Set message type
        messageContent.removeClass('success error info').addClass(type);
        
        // Show message
        messagesContainer.fadeIn();
        
        // Auto hide after 5 seconds for success messages
        if (type === 'success') {
            setTimeout(function() {
                messagesContainer.fadeOut();
            }, 5000);
        }
    }
    
    /**
     * Get URL parameter
     */
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
    
    /**
     * Handle enter key in form fields
     */
    $('.login-form input').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            $('#member-login-form').submit();
        }
    });
    
    /**
     * Clear error state on input
     */
    $('.login-form input').on('input', function() {
        const formGroup = $(this).closest('.form-group');
        if (formGroup.hasClass('error')) {
            formGroup.removeClass('error');
            formGroup.find('.error-message').remove();
        }
    });
    
})(jQuery);