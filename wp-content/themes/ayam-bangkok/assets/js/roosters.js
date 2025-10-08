/**
 * Advanced Rooster Catalog JavaScript
 * Handles filtering, searching, comparison, and favorites
 */

class RoosterCatalog {
    constructor() {
        this.init();
        this.filters = {};
        this.comparison = [];
        this.favorites = this.loadFavorites();
        this.currentView = 'grid';
        this.isLoading = false;
    }

    init() {
        this.bindEvents();
        this.initializeFilters();
        this.initializeComparison();
        this.initializeFavorites();
        this.initializeViewToggle();
        this.initializeInfiniteScroll();
    }

    bindEvents() {
        // Advanced filter events
        $(document).on('change', '.roosters-filter-form select, .roosters-filter-form input', this.handleFilterChange.bind(this));
        $(document).on('input', '#rooster-search', this.debounce(this.handleSearch.bind(this), 300));
        $(document).on('change', '#sort-roosters', this.handleSort.bind(this));
        
        // Price range slider
        $(document).on('input', '#price-range-min, #price-range-max', this.handlePriceRange.bind(this));
        
        // Age and weight filters
        $(document).on('change', '#age-filter, #weight-filter', this.handleAdvancedFilters.bind(this));
        
        // View toggle
        $(document).on('click', '.view-btn', this.handleViewToggle.bind(this));
        
        // Comparison system
        $(document).on('click', '.compare-btn', this.handleCompareToggle.bind(this));
        $(document).on('click', '.compare-clear', this.clearComparison.bind(this));
        $(document).on('click', '.compare-view', this.showComparison.bind(this));
        
        // Favorites system
        $(document).on('click', '.favorite-btn', this.handleFavoriteToggle.bind(this));
        
        // Share functionality
        $(document).on('click', '.share-btn', this.handleShare.bind(this));
        
        // Quick filters
        $(document).on('click', '.quick-filter', this.handleQuickFilter.bind(this));
        
        // Reset filters
        $(document).on('click', '.filter-reset', this.resetFilters.bind(this));
    }

    initializeFilters() {
        // Initialize price range slider
        this.initPriceRangeSlider();
        
        // Initialize advanced filters
        this.initAdvancedFilters();
        
        // Load saved filters from localStorage
        this.loadSavedFilters();
    }

    initPriceRangeSlider() {
        const minPrice = parseInt($('#price-range-min').attr('min')) || 0;
        const maxPrice = parseInt($('#price-range-max').attr('max')) || 100000;
        
        // Create dual range slider
        if ($('#price-range-slider').length) {
            $('#price-range-slider').slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [minPrice, maxPrice],
                slide: (event, ui) => {
                    $('#price-range-min').val(ui.values[0]);
                    $('#price-range-max').val(ui.values[1]);
                    this.updatePriceDisplay(ui.values[0], ui.values[1]);
                },
                stop: () => {
                    this.applyFilters();
                }
            });
        }
    }

    initAdvancedFilters() {
        // Initialize age filter
        if ($('#age-filter').length) {
            $('#age-filter').select2({
                placeholder: 'เลือกช่วงอายุ',
                allowClear: true
            });
        }
        
        // Initialize weight filter
        if ($('#weight-filter').length) {
            $('#weight-filter').select2({
                placeholder: 'เลือกช่วงน้ำหนัก',
                allowClear: true
            });
        }
        
        // Initialize color filter
        if ($('#color-filter').length) {
            $('#color-filter').select2({
                placeholder: 'เลือกสี',
                allowClear: true,
                multiple: true
            });
        }
    }

    handleFilterChange(e) {
        const $target = $(e.target);
        const filterName = $target.attr('name');
        const filterValue = $target.val();
        
        this.filters[filterName] = filterValue;
        this.saveFilters();
        this.applyFilters();
    }

    handleSearch(e) {
        const searchTerm = $(e.target).val();
        this.filters.search = searchTerm;
        this.applyFilters();
    }

    handleSort(e) {
        const sortBy = $(e.target).val();
        this.filters.orderby = sortBy;
        this.applyFilters();
    }

    handlePriceRange() {
        const minPrice = parseInt($('#price-range-min').val());
        const maxPrice = parseInt($('#price-range-max').val());
        
        this.filters.price_min = minPrice;
        this.filters.price_max = maxPrice;
        
        this.updatePriceDisplay(minPrice, maxPrice);
        this.applyFilters();
    }

    updatePriceDisplay(min, max) {
        $('#price-display').text(`${this.formatPrice(min)} - ${this.formatPrice(max)}`);
    }

    formatPrice(price) {
        return new Intl.NumberFormat('th-TH', {
            style: 'currency',
            currency: 'THB',
            minimumFractionDigits: 0
        }).format(price);
    }

    handleAdvancedFilters() {
        // Collect all advanced filter values
        this.filters.age_range = $('#age-filter').val();
        this.filters.weight_range = $('#weight-filter').val();
        this.filters.colors = $('#color-filter').val();
        
        this.applyFilters();
    }

    applyFilters() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoadingState();
        
        // Prepare filter data
        const filterData = {
            action: 'ayam_filter_roosters',
            nonce: ayam_roosters.nonce,
            ...this.filters
        };
        
        $.ajax({
            url: ayam_roosters.ajax_url,
            type: 'POST',
            data: filterData,
            success: (response) => {
                if (response.success) {
                    this.updateResults(response.data);
                    this.updateResultsCount(response.data.total);
                    this.updateURL();
                } else {
                    this.showError('เกิดข้อผิดพลาดในการกรองข้อมูล');
                }
            },
            error: () => {
                this.showError('เกิดข้อผิดพลาดในการเชื่อมต่อ');
            },
            complete: () => {
                this.isLoading = false;
                this.hideLoadingState();
            }
        });
    }

    updateResults(data) {
        const $grid = $('.roosters-grid');
        
        // Fade out current results
        $grid.fadeOut(300, () => {
            $grid.html(data.html);
            $grid.fadeIn(300);
            
            // Reinitialize any components
            this.initializeCardActions();
            
            // Update pagination
            if (data.pagination) {
                $('.pagination-container').html(data.pagination);
            }
            
            // Trigger custom event
            $(document).trigger('roosters:updated', [data]);
        });
    }

    updateResultsCount(total) {
        $('.results-count').text(`พบ ${total.toLocaleString()} รายการ`);
    }

    updateURL() {
        const url = new URL(window.location);
        
        // Clear existing parameters
        url.search = '';
        
        // Add current filters
        Object.keys(this.filters).forEach(key => {
            if (this.filters[key] && this.filters[key] !== '') {
                url.searchParams.set(key, this.filters[key]);
            }
        });
        
        // Update URL without page reload
        window.history.replaceState({}, '', url);
    }

    handleViewToggle(e) {
        e.preventDefault();
        
        const $btn = $(e.currentTarget);
        const view = $btn.data('view');
        
        if (view === this.currentView) return;
        
        // Update button states
        $('.view-btn').removeClass('active');
        $btn.addClass('active');
        
        // Update grid class
        const $grid = $('.roosters-grid');
        $grid.removeClass('grid-view list-view').addClass(`${view}-view`);
        
        this.currentView = view;
        localStorage.setItem('rooster_view', view);
        
        // Trigger animation
        this.animateViewChange();
    }

    animateViewChange() {
        const $cards = $('.rooster-card');
        
        $cards.addClass('view-changing');
        
        setTimeout(() => {
            $cards.removeClass('view-changing');
        }, 300);
    }

    // Comparison System
    initializeComparison() {
        this.updateComparisonUI();
    }

    handleCompareToggle(e) {
        e.preventDefault();
        
        const $btn = $(e.currentTarget);
        const roosterId = $btn.data('rooster-id');
        
        if (this.comparison.includes(roosterId)) {
            this.removeFromComparison(roosterId);
        } else {
            this.addToComparison(roosterId);
        }
    }

    addToComparison(roosterId) {
        if (this.comparison.length >= 3) {
            this.showNotification('สามารถเปรียบเทียบได้สูงสุด 3 รายการ', 'warning');
            return;
        }
        
        this.comparison.push(roosterId);
        this.updateComparisonUI();
        this.saveComparison();
        
        this.showNotification('เพิ่มในรายการเปรียบเทียบแล้ว', 'success');
    }

    removeFromComparison(roosterId) {
        this.comparison = this.comparison.filter(id => id !== roosterId);
        this.updateComparisonUI();
        this.saveComparison();
    }

    updateComparisonUI() {
        // Update compare buttons
        $('.compare-btn').each((index, btn) => {
            const $btn = $(btn);
            const roosterId = $btn.data('rooster-id');
            
            if (this.comparison.includes(roosterId)) {
                $btn.addClass('active').find('i').removeClass('fas fa-balance-scale').addClass('fas fa-check');
            } else {
                $btn.removeClass('active').find('i').removeClass('fas fa-check').addClass('fas fa-balance-scale');
            }
        });
        
        // Update comparison bar
        this.updateComparisonBar();
    }

    updateComparisonBar() {
        const $bar = $('.comparison-bar');
        
        if (this.comparison.length > 0) {
            $bar.addClass('active');
            $bar.find('.compare-count').text(this.comparison.length);
            
            if (this.comparison.length >= 2) {
                $bar.find('.compare-view').prop('disabled', false);
            } else {
                $bar.find('.compare-view').prop('disabled', true);
            }
        } else {
            $bar.removeClass('active');
        }
    }

    showComparison() {
        if (this.comparison.length < 2) {
            this.showNotification('ต้องเลือกอย่างน้อย 2 รายการเพื่อเปรียบเทียบ', 'warning');
            return;
        }
        
        // Open comparison modal
        this.loadComparisonData();
    }

    loadComparisonData() {
        $.ajax({
            url: ayam_roosters.ajax_url,
            type: 'POST',
            data: {
                action: 'ayam_get_comparison_data',
                nonce: ayam_roosters.nonce,
                rooster_ids: this.comparison
            },
            success: (response) => {
                if (response.success) {
                    this.showComparisonModal(response.data);
                }
            }
        });
    }

    showComparisonModal(data) {
        const modal = this.createComparisonModal(data);
        $('body').append(modal);
        $(modal).fadeIn();
    }

    createComparisonModal(data) {
        // Create comparison modal HTML
        return `
            <div class="comparison-modal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>เปรียบเทียบไก่ชน</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        ${this.generateComparisonTable(data)}
                    </div>
                </div>
            </div>
        `;
    }

    // Favorites System
    initializeFavorites() {
        this.updateFavoritesUI();
    }

    handleFavoriteToggle(e) {
        e.preventDefault();
        
        const $btn = $(e.currentTarget);
        const roosterId = $btn.data('rooster-id');
        
        if (this.favorites.includes(roosterId)) {
            this.removeFromFavorites(roosterId);
        } else {
            this.addToFavorites(roosterId);
        }
    }

    addToFavorites(roosterId) {
        this.favorites.push(roosterId);
        this.updateFavoritesUI();
        this.saveFavorites();
        
        this.showNotification('เพิ่มในรายการโปรดแล้ว', 'success');
    }

    removeFromFavorites(roosterId) {
        this.favorites = this.favorites.filter(id => id !== roosterId);
        this.updateFavoritesUI();
        this.saveFavorites();
        
        this.showNotification('ลบออกจากรายการโปรดแล้ว', 'info');
    }

    updateFavoritesUI() {
        $('.favorite-btn').each((index, btn) => {
            const $btn = $(btn);
            const roosterId = $btn.data('rooster-id');
            
            if (this.favorites.includes(roosterId)) {
                $btn.addClass('active').find('i').removeClass('far fa-heart').addClass('fas fa-heart');
            } else {
                $btn.removeClass('active').find('i').removeClass('fas fa-heart').addClass('far fa-heart');
            }
        });
    }

    // Share functionality
    handleShare(e) {
        e.preventDefault();
        
        const $btn = $(e.currentTarget);
        const roosterId = $btn.data('rooster-id');
        const roosterTitle = $btn.closest('.rooster-card').find('.card-title a').text();
        const roosterUrl = $btn.closest('.rooster-card').find('.card-title a').attr('href');
        
        if (navigator.share) {
            navigator.share({
                title: roosterTitle,
                text: `ดูไก่ชนคุณภาพ: ${roosterTitle}`,
                url: roosterUrl
            });
        } else {
            this.showShareModal(roosterTitle, roosterUrl);
        }
    }

    showShareModal(title, url) {
        const modal = `
            <div class="share-modal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>แชร์ไก่ชน</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="share-options">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}" target="_blank" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}" target="_blank" class="share-btn twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://line.me/R/msg/text/?${encodeURIComponent(title + ' ' + url)}" target="_blank" class="share-btn line">
                                <i class="fab fa-line"></i> LINE
                            </a>
                        </div>
                        <div class="share-url">
                            <input type="text" value="${url}" readonly>
                            <button class="copy-url">คัดลอก</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modal);
        $('.share-modal').fadeIn();
    }

    // Quick filters
    handleQuickFilter(e) {
        e.preventDefault();
        
        const $btn = $(e.currentTarget);
        const filterType = $btn.data('filter');
        const filterValue = $btn.data('value');
        
        // Clear existing filters
        this.resetFilters();
        
        // Apply quick filter
        this.filters[filterType] = filterValue;
        this.applyFilters();
        
        // Update UI
        $('.quick-filter').removeClass('active');
        $btn.addClass('active');
    }

    resetFilters() {
        this.filters = {};
        
        // Reset form elements
        $('.roosters-filter-form')[0].reset();
        $('#price-range-slider').slider('values', [0, 100000]);
        $('.select2').val(null).trigger('change');
        
        // Reset quick filters
        $('.quick-filter').removeClass('active');
        
        // Apply empty filters
        this.applyFilters();
        
        // Clear saved filters
        localStorage.removeItem('rooster_filters');
    }

    // Infinite scroll
    initializeInfiniteScroll() {
        if ($('.roosters-grid').data('infinite-scroll') === true) {
            $(window).on('scroll', this.debounce(this.handleScroll.bind(this), 100));
        }
    }

    handleScroll() {
        if (this.isLoading) return;
        
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();
        
        if (scrollTop + windowHeight >= documentHeight - 1000) {
            this.loadMoreRoosters();
        }
    }

    loadMoreRoosters() {
        const currentPage = parseInt($('.roosters-grid').data('current-page')) || 1;
        const maxPages = parseInt($('.roosters-grid').data('max-pages')) || 1;
        
        if (currentPage >= maxPages) return;
        
        this.isLoading = true;
        
        $.ajax({
            url: ayam_roosters.ajax_url,
            type: 'POST',
            data: {
                action: 'ayam_load_more_roosters',
                nonce: ayam_roosters.nonce,
                page: currentPage + 1,
                ...this.filters
            },
            success: (response) => {
                if (response.success) {
                    $('.roosters-grid').append(response.data.html);
                    $('.roosters-grid').data('current-page', currentPage + 1);
                    
                    this.initializeCardActions();
                }
            },
            complete: () => {
                this.isLoading = false;
            }
        });
    }

    // Utility functions
    initializeCardActions() {
        // Reinitialize tooltips, lazy loading, etc.
        this.updateFavoritesUI();
        this.updateComparisonUI();
    }

    showLoadingState() {
        $('.roosters-grid').addClass('loading');
        $('.filter-loading').show();
    }

    hideLoadingState() {
        $('.roosters-grid').removeClass('loading');
        $('.filter-loading').hide();
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showNotification(message, type = 'info') {
        const notification = `
            <div class="notification notification-${type}">
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;
        
        $('.notifications-container').append(notification);
        
        setTimeout(() => {
            $('.notification').last().fadeOut(() => {
                $(this).remove();
            });
        }, 5000);
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Storage functions
    saveFilters() {
        localStorage.setItem('rooster_filters', JSON.stringify(this.filters));
    }

    loadSavedFilters() {
        const saved = localStorage.getItem('rooster_filters');
        if (saved) {
            this.filters = JSON.parse(saved);
            this.populateFiltersFromStorage();
        }
    }

    populateFiltersFromStorage() {
        Object.keys(this.filters).forEach(key => {
            const value = this.filters[key];
            const $element = $(`[name="${key}"]`);
            
            if ($element.length) {
                $element.val(value).trigger('change');
            }
        });
    }

    saveComparison() {
        localStorage.setItem('rooster_comparison', JSON.stringify(this.comparison));
    }

    loadComparison() {
        const saved = localStorage.getItem('rooster_comparison');
        return saved ? JSON.parse(saved) : [];
    }

    saveFavorites() {
        localStorage.setItem('rooster_favorites', JSON.stringify(this.favorites));
    }

    loadFavorites() {
        const saved = localStorage.getItem('rooster_favorites');
        return saved ? JSON.parse(saved) : [];
    }
}

// Initialize when document is ready
jQuery(document).ready(function($) {
    window.roosterCatalog = new RoosterCatalog();
});