/**
 * Frontend JavaScript for Ayam Bangkok
 */

(function($) {
    'use strict';
    
    // Global variables
    var AyamBangkok = {
        currentPage: 1,
        totalPages: 1,
        isLoading: false,
        filters: {}
    };
    
    $(document).ready(function() {
        // Initialize components
        initRoosterFilters();
        initRoosterSearch();
        initContactForms();
        initImageGallery();
        initBookingSystem();
        initNotifications();
        
        // Load initial rooster data if on catalog page
        if ($('.ayam-rooster-catalog').length) {
            loadRoosters();
        }
    });
    
    /**
     * Initialize rooster filters
     */
    function initRoosterFilters() {
        $('.ayam-filters').on('change', 'select, input', function() {
            updateFilters();
        });
        
        $('.btn-filter').on('click', function(e) {
            e.preventDefault();
            AyamBangkok.currentPage = 1;
            loadRoosters();
        });
        
        $('.btn-reset').on('click', function(e) {
            e.preventDefault();
            resetFilters();
        });
    }
    
    /**
     * Initialize rooster search
     */
    function initRoosterSearch() {
        var searchTimeout;
        
        $('#rooster-search').on('input', function() {
            clearTimeout(searchTimeout);
            var searchTerm = $(this).val();
            
            searchTimeout = setTimeout(function() {
                AyamBangkok.filters.search = searchTerm;
                AyamBangkok.currentPage = 1;
                loadRoosters();
            }, 500);
        });
    }
    
    /**
     * Initialize contact forms
     */
    function initContactForms() {
        $('.ayam-contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var formData = new FormData(this);
            
            // Add nonce
            formData.append('_wpnonce', ayam_ajax.nonce);
            
            // Show loading
            $form.find('.btn-submit').prop('disabled', true).text('กำลังส่ง...');
            
            $.ajax({
                url: ayam_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification('ส่งข้อความเรียบร้อยแล้ว เราจะติดต่อกลับโดยเร็วที่สุด', 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error');
                    }
                },
                error: function() {
                    showNotification('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', 'error');
                },
                complete: function() {
                    $form.find('.btn-submit').prop('disabled', false).text('ส่งข้อความ');
                }
            });
        });
    }
    
    /**
     * Initialize image gallery
     */
    function initImageGallery() {
        $('.rooster-gallery').on('click', '.gallery-item', function(e) {
            e.preventDefault();
            
            var images = [];
            $('.gallery-item').each(function() {
                images.push({
                    src: $(this).attr('href'),
                    title: $(this).find('img').attr('alt')
                });
            });
            
            var currentIndex = $('.gallery-item').index(this);
            openLightbox(images, currentIndex);
        });
    }
    
    /**
     * Initialize booking system
     */
    function initBookingSystem() {
        $('.booking-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var formData = {
                action: 'ayam_create_booking',
                service_id: $form.find('[name="service_id"]').val(),
                booking_date: $form.find('[name="booking_date"]').val(),
                booking_time: $form.find('[name="booking_time"]').val(),
                customer_name: $form.find('[name="customer_name"]').val(),
                customer_email: $form.find('[name="customer_email"]').val(),
                customer_phone: $form.find('[name="customer_phone"]').val(),
                customer_line: $form.find('[name="customer_line"]').val(),
                service_type: $form.find('[name="service_type"]').val(),
                special_requests: $form.find('[name="special_requests"]').val(),
                _wpnonce: ayam_ajax.nonce
            };
            
            // Show loading
            $form.find('.btn-submit').prop('disabled', true).text('กำลังจอง...');
            
            $.ajax({
                url: ayam_ajax.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showNotification('จองบริการเรียบร้อยแล้ว เราจะติดต่อกลับเพื่อยืนยันรายละเอียด', 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data || 'เกิดข้อผิดพลาดในการจอง กรุณาลองใหม่อีกครั้ง', 'error');
                    }
                },
                error: function() {
                    showNotification('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', 'error');
                },
                complete: function() {
                    $form.find('.btn-submit').prop('disabled', false).text('จองบริการ');
                }
            });
        });
    }
    
    /**
     * Initialize notifications
     */
    function initNotifications() {
        $(document).on('click', '.ayam-notification .close-btn', function() {
            $(this).closest('.ayam-notification').fadeOut();
        });
        
        // Auto-hide success notifications after 5 seconds
        setTimeout(function() {
            $('.ayam-notification.success').fadeOut();
        }, 5000);
    }
    
    /**
     * Update filters object
     */
    function updateFilters() {
        AyamBangkok.filters = {
            breed: $('#filter-breed').val(),
            category: $('#filter-category').val(),
            price_min: $('#filter-price-min').val(),
            price_max: $('#filter-price-max').val(),
            age_min: $('#filter-age-min').val(),
            age_max: $('#filter-age-max').val(),
            export_ready: $('#filter-export-ready').is(':checked'),
            search: $('#rooster-search').val()
        };
    }
    
    /**
     * Reset all filters
     */
    function resetFilters() {
        $('.ayam-filters select').val('');
        $('.ayam-filters input[type="text"], .ayam-filters input[type="number"]').val('');
        $('.ayam-filters input[type="checkbox"]').prop('checked', false);
        $('#rooster-search').val('');
        
        AyamBangkok.filters = {};
        AyamBangkok.currentPage = 1;
        loadRoosters();
    }
    
    /**
     * Load roosters via AJAX
     */
    function loadRoosters() {
        if (AyamBangkok.isLoading) {
            return;
        }
        
        AyamBangkok.isLoading = true;
        
        // Show loading
        $('.rooster-grid').html('<div class="ayam-loading"><div class="spinner"></div><p>' + ayam_ajax.strings.loading + '</p></div>');
        
        var requestData = $.extend({}, AyamBangkok.filters, {
            page: AyamBangkok.currentPage,
            per_page: 12
        });
        
        $.ajax({
            url: ayam_ajax.ajax_url.replace('admin-ajax.php', 'wp-json/ayam/v1/roosters/search'),
            type: 'GET',
            data: requestData,
            success: function(response) {
                displayRoosters(response.roosters);
                updatePagination(response.current_page, response.pages, response.total);
                AyamBangkok.totalPages = response.pages;
            },
            error: function() {
                $('.rooster-grid').html('<div class="text-center"><p>เกิดข้อผิดพลาดในการโหลดข้อมูล กรุณาลองใหม่อีกครั้ง</p></div>');
            },
            complete: function() {
                AyamBangkok.isLoading = false;
            }
        });
    }
    
    /**
     * Display roosters in grid
     */
    function displayRoosters(roosters) {
        var html = '';
        
        if (roosters.length === 0) {
            html = '<div class="col-12 text-center"><p>ไม่พบไก่ชนที่ตรงตามเงื่อนไขการค้นหา</p></div>';
        } else {
            roosters.forEach(function(rooster) {
                html += createRoosterCard(rooster);
            });
        }
        
        $('.rooster-grid').html(html);
    }
    
    /**
     * Create rooster card HTML
     */
    function createRoosterCard(rooster) {
        var statusClass = rooster.status || 'available';
        var statusText = {
            'available': 'พร้อมขาย',
            'reserved': 'จอง',
            'sold': 'ขายแล้ว'
        };
        
        var breedText = rooster.breed && rooster.breed.length > 0 ? rooster.breed[0].name : 'ไม่ระบุสายพันธุ์';
        var priceText = rooster.price ? formatPrice(rooster.price) : 'ราคาตามสอบถาม';
        
        return `
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="ayam-rooster-card">
                    <div class="card-image">
                        <img src="${rooster.featured_image || '/wp-content/plugins/ayam-bangkok-core/assets/images/placeholder-rooster.jpg'}" alt="${rooster.title}">
                        <div class="price-badge">${priceText}</div>
                        <div class="status-badge ${statusClass}">${statusText[statusClass] || statusText.available}</div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">${rooster.title}</h3>
                        <div class="breed-info">${breedText}</div>
                        <div class="rooster-details">
                            <span>อายุ: ${rooster.age ? formatAge(rooster.age) : 'ไม่ระบุ'}</span>
                            <span>น้ำหนัก: ${rooster.weight ? formatWeight(rooster.weight) : 'ไม่ระบุ'}</span>
                        </div>
                        <p class="card-text">${rooster.excerpt || ''}</p>
                        <div class="card-actions">
                            <a href="${rooster.permalink}" class="btn btn-primary">ดูรายละเอียด</a>
                            <button class="btn btn-outline-primary btn-inquiry" data-rooster-id="${rooster.id}">สอบถาม</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    /**
     * Update pagination
     */
    function updatePagination(currentPage, totalPages, totalItems) {
        var html = '';
        
        if (totalPages > 1) {
            html += '<div class="ayam-pagination">';
            
            // Previous button
            if (currentPage > 1) {
                html += `<a href="#" class="page-numbers" data-page="${currentPage - 1}">« ก่อนหน้า</a>`;
            }
            
            // Page numbers
            for (var i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    html += `<span class="page-numbers current">${i}</span>`;
                } else {
                    html += `<a href="#" class="page-numbers" data-page="${i}">${i}</a>`;
                }
            }
            
            // Next button
            if (currentPage < totalPages) {
                html += `<a href="#" class="page-numbers" data-page="${currentPage + 1}">ถัดไป »</a>`;
            }
            
            html += '</div>';
        }
        
        $('.pagination-container').html(html);
        
        // Update results info
        var startItem = ((currentPage - 1) * 12) + 1;
        var endItem = Math.min(currentPage * 12, totalItems);
        $('.results-info').html(`แสดง ${startItem}-${endItem} จาก ${totalItems} รายการ`);
    }
    
    /**
     * Handle pagination clicks
     */
    $(document).on('click', '.ayam-pagination .page-numbers', function(e) {
        e.preventDefault();
        
        var page = $(this).data('page');
        if (page && page !== AyamBangkok.currentPage) {
            AyamBangkok.currentPage = page;
            loadRoosters();
            
            // Scroll to top of results
            $('html, body').animate({
                scrollTop: $('.rooster-grid').offset().top - 100
            }, 500);
        }
    });
    
    /**
     * Handle inquiry button clicks
     */
    $(document).on('click', '.btn-inquiry', function() {
        var roosterId = $(this).data('rooster-id');
        openInquiryModal(roosterId);
    });
    
    /**
     * Format price
     */
    function formatPrice(price) {
        return new Intl.NumberFormat('th-TH').format(price) + ' บาท';
    }
    
    /**
     * Format age
     */
    function formatAge(ageMonths) {
        if (ageMonths < 12) {
            return ageMonths + ' เดือน';
        } else {
            var years = Math.floor(ageMonths / 12);
            var months = ageMonths % 12;
            var ageString = years + ' ปี';
            if (months > 0) {
                ageString += ' ' + months + ' เดือน';
            }
            return ageString;
        }
    }
    
    /**
     * Format weight
     */
    function formatWeight(weight) {
        return parseFloat(weight).toFixed(2) + ' กก.';
    }
    
    /**
     * Show notification
     */
    function showNotification(message, type) {
        type = type || 'success';
        
        var html = `
            <div class="ayam-notification ${type}">
                ${message}
                <button class="close-btn">&times;</button>
            </div>
        `;
        
        // Remove existing notifications
        $('.ayam-notification').remove();
        
        // Add new notification
        $('body').prepend(html);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.ayam-notification').fadeOut();
        }, 5000);
    }
    
    /**
     * Open lightbox for image gallery
     */
    function openLightbox(images, currentIndex) {
        // Simple lightbox implementation
        var html = `
            <div class="ayam-lightbox">
                <div class="lightbox-overlay"></div>
                <div class="lightbox-content">
                    <button class="lightbox-close">&times;</button>
                    <button class="lightbox-prev">‹</button>
                    <button class="lightbox-next">›</button>
                    <img src="${images[currentIndex].src}" alt="${images[currentIndex].title}">
                    <div class="lightbox-caption">${images[currentIndex].title}</div>
                </div>
            </div>
        `;
        
        $('body').append(html);
        
        // Handle lightbox events
        $('.lightbox-close, .lightbox-overlay').on('click', function() {
            $('.ayam-lightbox').remove();
        });
        
        // Navigation (simplified)
        $('.lightbox-prev').on('click', function() {
            currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
            $('.lightbox-content img').attr('src', images[currentIndex].src);
            $('.lightbox-caption').text(images[currentIndex].title);
        });
        
        $('.lightbox-next').on('click', function() {
            currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
            $('.lightbox-content img').attr('src', images[currentIndex].src);
            $('.lightbox-caption').text(images[currentIndex].title);
        });
    }
    
    /**
     * Open inquiry modal
     */
    function openInquiryModal(roosterId) {
        // Simple modal implementation
        var html = `
            <div class="ayam-modal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>สอบถามข้อมูลไก่ชน</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form class="inquiry-form">
                            <input type="hidden" name="rooster_id" value="${roosterId}">
                            <div class="form-group">
                                <label>ชื่อ-นามสกุล *</label>
                                <input type="text" name="customer_name" required>
                            </div>
                            <div class="form-group">
                                <label>อีเมล *</label>
                                <input type="email" name="customer_email" required>
                            </div>
                            <div class="form-group">
                                <label>เบอร์โทรศัพท์</label>
                                <input type="tel" name="customer_phone">
                            </div>
                            <div class="form-group">
                                <label>Line ID</label>
                                <input type="text" name="customer_line">
                            </div>
                            <div class="form-group">
                                <label>หัวข้อ *</label>
                                <input type="text" name="subject" value="สอบถามข้อมูลไก่ชน" required>
                            </div>
                            <div class="form-group">
                                <label>ข้อความ *</label>
                                <textarea name="message" rows="4" required placeholder="กรุณาระบุข้อมูลที่ต้องการสอบถาม..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>ช่องทางติดต่อกลับที่ต้องการ</label>
                                <select name="preferred_contact">
                                    <option value="email">อีเมล</option>
                                    <option value="phone">โทรศัพท์</option>
                                    <option value="line">Line</option>
                                </select>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">ส่งคำถาม</button>
                                <button type="button" class="btn btn-secondary modal-close">ยกเลิก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(html);
        
        // Handle modal events
        $('.modal-close, .modal-overlay').on('click', function() {
            $('.ayam-modal').remove();
        });
        
        // Handle form submission
        $('.inquiry-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            formData += '&action=ayam_create_inquiry&_wpnonce=' + ayam_ajax.nonce;
            
            $.ajax({
                url: ayam_ajax.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('.ayam-modal').remove();
                        showNotification('ส่งคำถามเรียบร้อยแล้ว เราจะติดต่อกลับโดยเร็วที่สุด', 'success');
                    } else {
                        showNotification(response.data || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error');
                    }
                },
                error: function() {
                    showNotification('เกิดข้อผิดพลาดในการเชื่อมต่อ กรุณาลองใหม่อีกครั้ง', 'error');
                }
            });
        });
    }
    
})(jQuery);