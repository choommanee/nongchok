/**
 * Member Dashboard JavaScript
 * Handles favorite management and dashboard interactions
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        initDashboard();
    });

    /**
     * Initialize dashboard
     */
    function initDashboard() {
        // Remove favorite handler
        $('.remove-favorite').on('click', handleRemoveFavorite);
        
        // Initialize AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 600,
                once: true
            });
        }
    }

    /**
     * Handle remove favorite
     */
    function handleRemoveFavorite(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $button = $(this);
        const roosterId = $button.data('rooster-id');
        const $card = $button.closest('.favorite-card');
        
        // Confirm removal
        if (!confirm(ayamDashboard.strings.confirm_remove)) {
            return;
        }
        
        // Show loading state
        $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        
        // Send AJAX request
        $.ajax({
            url: ayamDashboard.ajaxurl,
            type: 'POST',
            data: {
                action: 'ayam_remove_favorite',
                nonce: ayamDashboard.nonce,
                rooster_id: roosterId
            },
            success: function(response) {
                if (response.success) {
                    // Animate removal
                    $card.fadeOut(400, function() {
                        $(this).remove();
                        
                        // Check if no favorites left
                        if ($('.favorite-card').length === 0) {
                            $('.favorites-grid').html(
                                '<p class="no-favorites">' + 
                                ayamDashboard.strings.no_favorites + 
                                '</p>'
                            );
                        }
                        
                        // Update stat counter
                        updateFavoriteCount(-1);
                    });
                    
                    // Show success message
                    showNotification(response.data.message, 'success');
                } else {
                    // Show error message
                    showNotification(response.data.message, 'error');
                    $button.prop('disabled', false).html('<i class="fas fa-times"></i>');
                }
            },
            error: function() {
                showNotification(ayamDashboard.strings.error, 'error');
                $button.prop('disabled', false).html('<i class="fas fa-times"></i>');
            }
        });
    }

    /**
     * Update favorite count in stats
     */
    function updateFavoriteCount(change) {
        const $statNumber = $('.stat-card').eq(2).find('.stat-number');
        const currentCount = parseInt($statNumber.text());
        const newCount = Math.max(0, currentCount + change);
        
        // Animate count change
        $({ count: currentCount }).animate(
            { count: newCount },
            {
                duration: 500,
                step: function() {
                    $statNumber.text(Math.floor(this.count));
                },
                complete: function() {
                    $statNumber.text(newCount);
                }
            }
        );
    }

    /**
     * Show notification
     */
    function showNotification(message, type) {
        // Remove existing notifications
        $('.dashboard-notification').remove();
        
        // Create notification element
        const $notification = $('<div>')
            .addClass('dashboard-notification')
            .addClass('notification-' + type)
            .html('<i class="fas fa-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + message);
        
        // Add to page
        $('body').append($notification);
        
        // Show notification
        setTimeout(function() {
            $notification.addClass('show');
        }, 100);
        
        // Auto hide after 3 seconds
        setTimeout(function() {
            $notification.removeClass('show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 3000);
    }

})(jQuery);

// Add notification styles dynamically
(function() {
    const style = document.createElement('style');
    style.textContent = `
        .dashboard-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            z-index: 9999;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .dashboard-notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .dashboard-notification.notification-success {
            border-left: 4px solid #28a745;
            color: #28a745;
        }
        
        .dashboard-notification.notification-error {
            border-left: 4px solid #dc3545;
            color: #dc3545;
        }
        
        .dashboard-notification i {
            font-size: 1.25rem;
        }
        
        @media (max-width: 768px) {
            .dashboard-notification {
                top: 10px;
                right: 10px;
                left: 10px;
                transform: translateY(-100px);
            }
            
            .dashboard-notification.show {
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
})();
