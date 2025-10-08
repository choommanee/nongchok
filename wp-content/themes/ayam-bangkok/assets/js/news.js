/**
 * News System JavaScript
 * Handles social sharing, newsletter, and interactions
 */

(function($) {
    'use strict';

    class NewsSystem {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            console.log('News System initialized');
        }

        bindEvents() {
            // Copy link button
            $('.share-btn.copy').on('click', (e) => {
                e.preventDefault();
                const url = $(e.currentTarget).data('url');
                this.copyToClipboard(url);
            });

            // Newsletter form
            $('#newsletter-form').on('submit', (e) => {
                e.preventDefault();
                this.handleNewsletterSubmit(e.currentTarget);
            });

            // Category filter (if on archive page)
            $('.category-btn').on('click', (e) => {
                const btn = $(e.currentTarget);
                const category = btn.data('category');
                this.filterByCategory(category, btn);
            });
        }

        copyToClipboard(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    this.showNotification('คัดลอกลิงก์แล้ว', 'success');
                }).catch(() => {
                    this.fallbackCopyToClipboard(text);
                });
            } else {
                this.fallbackCopyToClipboard(text);
            }
        }

        fallbackCopyToClipboard(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                document.execCommand('copy');
                this.showNotification('คัดลอกลิงก์แล้ว', 'success');
            } catch (err) {
                this.showNotification('ไม่สามารถคัดลอกได้', 'error');
            }

            document.body.removeChild(textArea);
        }

        handleNewsletterSubmit(form) {
            const $form = $(form);
            const email = $form.find('input[name="email"]').val();
            const $button = $form.find('button[type="submit"]');
            const originalText = $button.html();

            // Validate email
            if (!this.isValidEmail(email)) {
                this.showNotification('กรุณากรอกอีเมลที่ถูกต้อง', 'error');
                return;
            }

            // Show loading
            $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังส่ง...');

            // Send AJAX request
            $.ajax({
                url: ayam_theme.ajax_url,
                type: 'POST',
                data: {
                    action: 'subscribe_newsletter',
                    email: email,
                    nonce: ayam_theme.nonce
                },
                success: (response) => {
                    if (response.success) {
                        this.showNotification('สมัครรับข่าวสารสำเร็จ!', 'success');
                        $form[0].reset();
                    } else {
                        this.showNotification(response.data.message || 'เกิดข้อผิดพลาด', 'error');
                    }
                },
                error: () => {
                    this.showNotification('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error');
                },
                complete: () => {
                    $button.prop('disabled', false).html(originalText);
                }
            });
        }

        isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        filterByCategory(category, btn) {
            $('.category-btn').removeClass('active');
            btn.addClass('active');

            const $cards = $('.news-card, .news-featured');

            if (category === 'all') {
                $cards.show();
                return;
            }

            $cards.each(function() {
                const $card = $(this);
                const categories = $card.find('.category-tag').map(function() {
                    return $(this).text().trim();
                }).get();

                // Check if card has the selected category
                const hasCategory = categories.some(cat => 
                    cat.toLowerCase().includes(category.toLowerCase())
                );

                if (hasCategory) {
                    $card.show();
                } else {
                    $card.hide();
                }
            });
        }

        showNotification(message, type = 'info') {
            const icons = {
                success: 'check-circle',
                error: 'exclamation-circle',
                info: 'info-circle'
            };

            const notification = $(`
                <div class="news-notification ${type}">
                    <i class="fas fa-${icons[type]}"></i>
                    <span>${message}</span>
                </div>
            `);

            $('body').append(notification);

            setTimeout(() => {
                notification.addClass('show');
            }, 100);

            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        if ($('.news-archive, .single-news').length) {
            new NewsSystem();
        }
    });

})(jQuery);
