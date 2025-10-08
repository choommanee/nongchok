jQuery(document).ready(function($) {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $response = $('#contact-form-response');
        var $submitBtn = $form.find('button[type="submit"]');
        
        // Show loading state
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังส่ง...');
        $response.hide();
        
        // Prepare form data
        var formData = {
            action: 'ayam_contact_form',
            contact_name: $('#contact_name').val(),
            contact_phone: $('#contact_phone').val(),
            contact_email: $('#contact_email').val(),
            contact_subject: $('#contact_subject').val(),
            contact_message: $('#contact_message').val(),
            contact_nonce: $('input[name="contact_nonce"]').val()
        };
        
        // Send AJAX request
        $.ajax({
            url: ayam_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $response.removeClass('error').addClass('success')
                             .html('<i class="fas fa-check-circle"></i> ' + response.data)
                             .show();
                    $form[0].reset();
                } else {
                    $response.removeClass('success').addClass('error')
                             .html('<i class="fas fa-exclamation-circle"></i> ' + response.data)
                             .show();
                }
            },
            error: function() {
                $response.removeClass('success').addClass('error')
                         .html('<i class="fas fa-exclamation-circle"></i> เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง')
                         .show();
            },
            complete: function() {
                $submitBtn.prop('disabled', false)
                          .html('<i class="fas fa-paper-plane"></i> ส่งข้อความ');
            }
        });
    });
});