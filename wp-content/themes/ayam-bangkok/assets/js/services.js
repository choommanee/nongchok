/**
 * Services JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        initServices();
    });

    function initServices() {
        // Booking form submission
        $('#service-booking-form').on('submit', handleBookingSubmit);
        
        // Initialize AOS
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 600, once: true });
        }
    }

    function handleBookingSubmit(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $response = $('.booking-response');
        
        $submitBtn.prop('disabled', true).addClass('loading');
        $response.hide();
        
        const formData = new FormData($form[0]);
        formData.append('action', 'ayam_service_booking');
        
        $.ajax({
            url: ayamServices.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $submitBtn.prop('disabled', false).removeClass('loading');
                
                if (response.success) {
                    $response
                        .removeClass('error')
                        .addClass('success')
                        .html('<i class="fas fa-check-circle"></i> ' + response.data.message)
                        .fadeIn();
                    $form[0].reset();
                } else {
                    $response
                        .removeClass('success')
                        .addClass('error')
                        .html('<i class="fas fa-exclamation-circle"></i> ' + response.data.message)
                        .fadeIn();
                }
            },
            error: function() {
                $submitBtn.prop('disabled', false).removeClass('loading');
                $response
                    .removeClass('success')
                    .addClass('error')
                    .html('<i class="fas fa-exclamation-circle"></i> เกิดข้อผิดพลาด')
                    .fadeIn();
            }
        });
    }

})(jQuery);
