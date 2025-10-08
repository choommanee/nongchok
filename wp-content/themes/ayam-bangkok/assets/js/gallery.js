/**
 * Gallery Page JavaScript
 * Handles search, filter, and quick view functionality
 */

(function($) {
    'use strict';

    class GalleryPage {
        constructor() {
            this.container = $('#gallery-container');
            this.searchInput = $('#gallery-search');
            this.sortSelect = $('#sort-gallery');
            this.quickFilters = $('.quick-filter-btn');
            this.quickViewModal = $('#quick-view-modal');
            this.favorites = this.loadFavorites();
            
            this.init();
        }

        init() {
            this.bindEvents();
            this.initFavorites();
            console.log('Gallery Page initialized');
        }

        bindEvents() {
            // Search functionality
            let searchTimeout;
            this.searchInput.on('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch();
                }, 500);
            });

            // Sort functionality
            this.sortSelect.on('change', () => {
                this.sortGallery();
            });

            // Quick filters
            this.quickFilters.on('click', (e) => {
                const btn = $(e.currentTarget);
                this.quickFilters.removeClass('active');
                btn.addClass('active');
                this.filterByStatus(btn.data('filter'));
            });

            // Favorite buttons
            $(document).on('click', '.favorite-btn', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const btn = $(e.currentTarget);
                const roosterId = btn.data('rooster-id');
                this.toggleFavorite(roosterId, btn);
            });

            // Quick view buttons
            $(document).on('click', '.quick-view-btn', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const roosterId = $(e.currentTarget).data('rooster-id');
                this.showQuickView(roosterId);
            });

            // Modal close
            $('.modal-close, .modal-overlay').on('click', () => {
                this.closeQuickView();
            });

            // Prevent modal content click from closing
            this.quickViewModal.find('.modal-content').on('click', (e) => {
                e.stopPropagation();
            });

            // ESC key to close modal
            $(document).on('keydown', (e) => {
                if (e.key === 'Escape' && this.quickViewModal.is(':visible')) {
                    this.closeQuickView();
                }
            });
        }

        performSearch() {
            const searchTerm = this.searchInput.val().toLowerCase().trim();
            const cards = $('.gallery-card');

            if (searchTerm === '') {
                cards.show();
                return;
            }

            cards.each(function() {
                const card = $(this);
                const title = card.find('.card-title').text().toLowerCase();
                const number = card.find('.rooster-number-badge span').text().toLowerCase();
                
                if (title.includes(searchTerm) || number.includes(searchTerm)) {
                    card.show();
                } else {
                    card.hide();
                }
            });

            this.checkNoResults();
        }

        sortGallery() {
            const sortValue = this.sortSelect.val();
            const cards = $('.gallery-card').get();

            cards.sort((a, b) => {
                const cardA = $(a);
                const cardB = $(b);

                switch(sortValue) {
                    case 'number-asc':
                    case 'number-desc':
                        const numA = parseInt(cardA.find('.rooster-number-badge span').text()) || 0;
                        const numB = parseInt(cardB.find('.rooster-number-badge span').text()) || 0;
                        return sortValue === 'number-asc' ? numA - numB : numB - numA;

                    case 'price-asc':
                    case 'price-desc':
                        const priceA = parseInt(cardA.find('.price-amount').text().replace(/[^0-9]/g, '')) || 0;
                        const priceB = parseInt(cardB.find('.price-amount').text().replace(/[^0-9]/g, '')) || 0;
                        return sortValue === 'price-asc' ? priceA - priceB : priceB - priceA;

                    case 'date-desc':
                    default:
                        return 0; // Keep original order for date
                }
            });

            $.each(cards, (index, card) => {
                this.container.append(card);
            });
        }

        filterByStatus(status) {
            const cards = $('.gallery-card');

            if (status === 'all') {
                cards.show();
                return;
            }

            cards.each(function() {
                const card = $(this);
                const cardStatus = card.data('status');

                if (status === 'available' && cardStatus === 'available') {
                    card.show();
                } else if (status === 'premium') {
                    // Show cards with price > 10000
                    const price = parseInt(card.find('.price-amount').text().replace(/[^0-9]/g, '')) || 0;
                    if (price > 10000) {
                        card.show();
                    } else {
                        card.hide();
                    }
                } else if (status === 'new') {
                    // Show first 6 cards (newest)
                    const index = card.index();
                    if (index < 6) {
                        card.show();
                    } else {
                        card.hide();
                    }
                } else {
                    card.hide();
                }
            });

            this.checkNoResults();
        }

        checkNoResults() {
            const visibleCards = $('.gallery-card:visible').length;
            let noResults = $('.no-results');

            if (visibleCards === 0) {
                if (noResults.length === 0) {
                    noResults = $(`
                        <div class="no-results">
                            <div class="no-results-content">
                                <i class="fas fa-search"></i>
                                <h3>ไม่พบไก่ชนที่ตรงกับเงื่อนไข</h3>
                                <p>ลองปรับเปลี่ยนคำค้นหาหรือตัวกรอง</p>
                            </div>
                        </div>
                    `);
                    this.container.append(noResults);
                }
                noResults.show();
            } else {
                noResults.hide();
            }
        }

        // Favorites functionality
        loadFavorites() {
            const stored = localStorage.getItem('ayam_favorites');
            return stored ? JSON.parse(stored) : [];
        }

        saveFavorites() {
            localStorage.setItem('ayam_favorites', JSON.stringify(this.favorites));
        }

        toggleFavorite(roosterId, btn) {
            const index = this.favorites.indexOf(roosterId);

            if (index > -1) {
                // Remove from favorites
                this.favorites.splice(index, 1);
                btn.removeClass('active');
                this.showNotification('ลบออกจากรายการโปรดแล้ว', 'info');
            } else {
                // Add to favorites
                this.favorites.push(roosterId);
                btn.addClass('active');
                this.showNotification('เพิ่มในรายการโปรดแล้ว', 'success');
            }

            this.saveFavorites();
        }

        initFavorites() {
            // Mark favorite buttons as active
            this.favorites.forEach(roosterId => {
                $(`.favorite-btn[data-rooster-id="${roosterId}"]`).addClass('active');
            });
        }

        // Quick View functionality
        showQuickView(roosterId) {
            const modalBody = this.quickViewModal.find('.modal-body');
            
            // Show loading
            modalBody.html(`
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>กำลังโหลด...</span>
                </div>
            `);
            
            this.quickViewModal.fadeIn(300);
            $('body').css('overflow', 'hidden');

            // Load rooster data via AJAX
            $.ajax({
                url: ayam_theme.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_rooster_quick_view',
                    rooster_id: roosterId,
                    nonce: ayam_theme.nonce
                },
                success: (response) => {
                    if (response.success) {
                        modalBody.html(response.data.html);
                    } else {
                        modalBody.html(`
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <p>ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง</p>
                            </div>
                        `);
                    }
                },
                error: () => {
                    modalBody.html(`
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง</p>
                        </div>
                    `);
                }
            });
        }

        closeQuickView() {
            this.quickViewModal.fadeOut(300);
            $('body').css('overflow', '');
        }

        showNotification(message, type = 'info') {
            const notification = $(`
                <div class="gallery-notification ${type}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
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
        if ($('.gallery-page').length) {
            new GalleryPage();
        }
    });

})(jQuery);
