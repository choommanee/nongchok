/**
 * Admin JavaScript for Ayam Bangkok
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Initialize admin components
        initRoosterManagement();
        initGalleryManagement();
        initBookingManagement();
        initInquiryManagement();
        initReportsAndAnalytics();
        initSettingsPage();
    });
    
    /**
     * Initialize rooster management
     */
    function initRoosterManagement() {
        // Auto-calculate age from birth date
        $('#rooster_birth_date').on('change', function() {
            var birthDate = new Date($(this).val());
            var today = new Date();
            var ageMonths = Math.floor((today - birthDate) / (1000 * 60 * 60 * 24 * 30.44));
            
            if (ageMonths > 0) {
                $('#rooster_age').val(ageMonths);
            }
        });
        
        // Price formatting
        $('#rooster_price').on('blur', function() {
            var price = parseFloat($(this).val());
            if (!isNaN(price)) {
                $(this).val(price.toFixed(2));
            }
        });
        
        // Weight validation
        $('#rooster_weight').on('input', function() {
            var weight = parseFloat($(this).val());
            if (weight < 0 || weight > 10) {
                $(this).addClass('error');
                showAdminNotice('น้ำหนักควรอยู่ระหว่าง 0-10 กิโลกรัม', 'warning');
            } else {
                $(this).removeClass('error');
            }
        });
        
        // Export ready checkbox
        $('#rooster_export_ready').on('change', function() {
            if ($(this).is(':checked')) {
                $('.export-requirements').show();
            } else {
                $('.export-requirements').hide();
            }
        });
    }
    
    /**
     * Initialize gallery management
     */
    function initGalleryManagement() {
        var mediaUploader;
        
        // Add images button
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'เลือกรูปภาพสำหรับแกลเลอรี่',
                button: {
                    text: 'เพิ่มรูปภาพ'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                var attachments = mediaUploader.state().get('selection').toJSON();
                
                attachments.forEach(function(attachment) {
                    addGalleryImage(attachment);
                });
                
                updateGalleryField();
            });
            
            mediaUploader.open();
        });
        
        // Remove image
        $(document).on('click', '.remove-gallery-image', function() {
            $(this).closest('.gallery-item').remove();
            updateGalleryField();
        });
        
        // Set featured image
        $(document).on('click', '.set-featured', function() {
            $('.gallery-item').removeClass('is-featured');
            $(this).closest('.gallery-item').addClass('is-featured');
            updateGalleryField();
        });
        
        // Sortable gallery
        if ($.fn.sortable) {
            $('.ayam-gallery-grid').sortable({
                update: function() {
                    updateGalleryField();
                }
            });
        }
    }
    
    /**
     * Add gallery image
     */
    function addGalleryImage(attachment) {
        var html = `
            <div class="gallery-item" data-id="${attachment.id}">
                <img src="${attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url}" alt="${attachment.alt}">
                <button type="button" class="remove-gallery-image">&times;</button>
                <button type="button" class="set-featured">หลัก</button>
            </div>
        `;
        
        $('.ayam-gallery-grid').append(html);
        $('.ayam-gallery-container').addClass('has-images');
    }
    
    /**
     * Update gallery field
     */
    function updateGalleryField() {
        var galleryData = [];
        
        $('.gallery-item').each(function(index) {
            var $item = $(this);
            galleryData.push({
                id: $item.data('id'),
                order: index,
                featured: $item.hasClass('is-featured')
            });
        });
        
        $('#rooster_gallery_data').val(JSON.stringify(galleryData));
    }
    
    /**
     * Initialize booking management
     */
    function initBookingManagement() {
        // Status change
        $('.booking-status-select').on('change', function() {
            var bookingId = $(this).data('booking-id');
            var newStatus = $(this).val();
            
            updateBookingStatus(bookingId, newStatus);
        });
        
        // Quick actions
        $('.booking-action').on('click', function(e) {
            e.preventDefault();
            
            var action = $(this).data('action');
            var bookingId = $(this).data('booking-id');
            
            switch (action) {
                case 'view':
                    viewBookingDetails(bookingId);
                    break;
                case 'confirm':
                    updateBookingStatus(bookingId, 'confirmed');
                    break;
                case 'cancel':
                    if (confirm('คุณแน่ใจหรือไม่ที่จะยกเลิกการจองนี้?')) {
                        updateBookingStatus(bookingId, 'cancelled');
                    }
                    break;
            }
        });
        
        // Booking filters
        $('#booking-filter-status, #booking-filter-date').on('change', function() {
            filterBookings();
        });
    }
    
    /**
     * Update booking status
     */
    function updateBookingStatus(bookingId, status) {
        showLoadingOverlay();
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ayam_update_booking_status',
                booking_id: bookingId,
                status: status,
                _wpnonce: ayam_admin_nonce
            },
            success: function(response) {
                if (response.success) {
                    showAdminNotice('อัพเดทสถานะการจองเรียบร้อยแล้ว', 'success');
                    location.reload();
                } else {
                    showAdminNotice(response.data || 'เกิดข้อผิดพลาด', 'error');
                }
            },
            error: function() {
                showAdminNotice('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
            },
            complete: function() {
                hideLoadingOverlay();
            }
        });
    }
    
    /**
     * Initialize inquiry management
     */
    function initInquiryManagement() {
        // Mark as read
        $('.btn-mark-read').on('click', function() {
            var inquiryId = $(this).data('inquiry-id');
            markInquiryAsRead(inquiryId);
        });
        
        // Reply to inquiry
        $('.btn-reply').on('click', function() {
            var inquiryId = $(this).data('inquiry-id');
            openReplyModal(inquiryId);
        });
        
        // Delete inquiry
        $('.btn-delete-inquiry').on('click', function() {
            if (confirm('คุณแน่ใจหรือไม่ที่จะลบคำถามนี้?')) {
                var inquiryId = $(this).data('inquiry-id');
                deleteInquiry(inquiryId);
            }
        });
        
        // Bulk actions
        $('#bulk-action-apply').on('click', function() {
            var action = $('#bulk-action-select').val();
            var selectedIds = [];
            
            $('.inquiry-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });
            
            if (selectedIds.length === 0) {
                alert('กรุณาเลือกรายการที่ต้องการดำเนินการ');
                return;
            }
            
            processBulkInquiryAction(action, selectedIds);
        });
    }
    
    /**
     * Mark inquiry as read
     */
    function markInquiryAsRead(inquiryId) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ayam_mark_inquiry_read',
                inquiry_id: inquiryId,
                _wpnonce: ayam_admin_nonce
            },
            success: function(response) {
                if (response.success) {
                    $(`.ayam-inquiry-item[data-inquiry-id="${inquiryId}"]`).removeClass('unread');
                    showAdminNotice('ทำเครื่องหมายอ่านแล้วเรียบร้อย', 'success');
                }
            }
        });
    }
    
    /**
     * Initialize reports and analytics
     */
    function initReportsAndAnalytics() {
        // Date range picker
        if ($.fn.daterangepicker) {
            $('#report-date-range').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    separator: ' - ',
                    applyLabel: 'ตกลง',
                    cancelLabel: 'ยกเลิก',
                    fromLabel: 'จาก',
                    toLabel: 'ถึง',
                    customRangeLabel: 'กำหนดเอง',
                    weekLabel: 'สัปดาห์',
                    daysOfWeek: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
                    monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                               'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม']
                },
                ranges: {
                    'วันนี้': [moment(), moment()],
                    'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 วันที่แล้ว': [moment().subtract(6, 'days'), moment()],
                    '30 วันที่แล้ว': [moment().subtract(29, 'days'), moment()],
                    'เดือนนี้': [moment().startOf('month'), moment().endOf('month')],
                    'เดือนที่แล้ว': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });
        }
        
        // Generate report
        $('#generate-report').on('click', function() {
            var reportType = $('#report-type').val();
            var dateRange = $('#report-date-range').val();
            
            generateReport(reportType, dateRange);
        });
        
        // Export report
        $('#export-report').on('click', function() {
            var format = $('#export-format').val();
            exportReport(format);
        });
    }
    
    /**
     * Generate report
     */
    function generateReport(type, dateRange) {
        showLoadingOverlay();
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ayam_generate_report',
                report_type: type,
                date_range: dateRange,
                _wpnonce: ayam_admin_nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#report-results').html(response.data.html);
                    
                    // Initialize charts if data exists
                    if (response.data.chart_data) {
                        initializeCharts(response.data.chart_data);
                    }
                } else {
                    showAdminNotice(response.data || 'เกิดข้อผิดพลาดในการสร้างรายงาน', 'error');
                }
            },
            error: function() {
                showAdminNotice('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
            },
            complete: function() {
                hideLoadingOverlay();
            }
        });
    }
    
    /**
     * Initialize settings page
     */
    function initSettingsPage() {
        // Color picker
        if ($.fn.wpColorPicker) {
            $('.color-picker').wpColorPicker();
        }
        
        // Image upload for settings
        $('.upload-image-button').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var inputField = button.siblings('input[type="text"]');
            var previewImage = button.siblings('.image-preview');
            
            var mediaUploader = wp.media({
                title: 'เลือกรูปภาพ',
                button: {
                    text: 'เลือก'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                inputField.val(attachment.url);
                previewImage.attr('src', attachment.url).show();
            });
            
            mediaUploader.open();
        });
        
        // Remove image
        $('.remove-image-button').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var inputField = button.siblings('input[type="text"]');
            var previewImage = button.siblings('.image-preview');
            
            inputField.val('');
            previewImage.hide();
        });
        
        // Settings form validation
        $('#ayam-settings-form').on('submit', function(e) {
            var isValid = true;
            
            // Validate required fields
            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('error');
                    isValid = false;
                } else {
                    $(this).removeClass('error');
                }
            });
            
            // Validate email fields
            $(this).find('input[type="email"]').each(function() {
                var email = $(this).val();
                if (email && !isValidEmail(email)) {
                    $(this).addClass('error');
                    isValid = false;
                } else {
                    $(this).removeClass('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showAdminNotice('กรุณากรอกข้อมูลให้ครบถ้วนและถูกต้อง', 'error');
            }
        });
    }
    
    /**
     * Show loading overlay
     */
    function showLoadingOverlay() {
        var html = `
            <div class="ayam-loading-overlay">
                <div class="ayam-loading-spinner">
                    <div class="spinner"></div>
                    <p>กำลังประมวลผล...</p>
                </div>
            </div>
        `;
        
        $('body').append(html);
    }
    
    /**
     * Hide loading overlay
     */
    function hideLoadingOverlay() {
        $('.ayam-loading-overlay').remove();
    }
    
    /**
     * Show admin notice
     */
    function showAdminNotice(message, type) {
        type = type || 'success';
        
        var html = `
            <div class="ayam-admin-notice ${type}">
                ${message}
            </div>
        `;
        
        // Remove existing notices
        $('.ayam-admin-notice').remove();
        
        // Add new notice
        $('.wrap').prepend(html);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.ayam-admin-notice').fadeOut();
        }, 5000);
    }
    
    /**
     * Validate email
     */
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    /**
     * Initialize charts
     */
    function initializeCharts(chartData) {
        // This would integrate with Chart.js or similar library
        // For now, just a placeholder
        console.log('Chart data:', chartData);
    }
    
    /**
     * View booking details
     */
    function viewBookingDetails(bookingId) {
        // Open modal or redirect to booking details page
        window.location.href = `admin.php?page=ayam-bookings&action=view&id=${bookingId}`;
    }
    
    /**
     * Filter bookings
     */
    function filterBookings() {
        var status = $('#booking-filter-status').val();
        var date = $('#booking-filter-date').val();
        
        var url = new URL(window.location);
        
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        
        if (date) {
            url.searchParams.set('date', date);
        } else {
            url.searchParams.delete('date');
        }
        
        window.location.href = url.toString();
    }
    
    /**
     * Open reply modal
     */
    function openReplyModal(inquiryId) {
        // Simple modal implementation for replying to inquiries
        var html = `
            <div class="ayam-modal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>ตอบกลับคำถาม</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="reply-form">
                            <input type="hidden" name="inquiry_id" value="${inquiryId}">
                            <div class="form-group">
                                <label>ข้อความตอบกลับ</label>
                                <textarea name="response" rows="6" required></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-ayam-primary">ส่งคำตอบ</button>
                                <button type="button" class="btn-ayam-secondary modal-close">ยกเลิก</button>
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
        $('#reply-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            formData += '&action=ayam_reply_inquiry&_wpnonce=' + ayam_admin_nonce;
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('.ayam-modal').remove();
                        showAdminNotice('ส่งคำตอบเรียบร้อยแล้ว', 'success');
                        location.reload();
                    } else {
                        showAdminNotice(response.data || 'เกิดข้อผิดพลาด', 'error');
                    }
                },
                error: function() {
                    showAdminNotice('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
                }
            });
        });
    }
    
    /**
     * Delete inquiry
     */
    function deleteInquiry(inquiryId) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ayam_delete_inquiry',
                inquiry_id: inquiryId,
                _wpnonce: ayam_admin_nonce
            },
            success: function(response) {
                if (response.success) {
                    $(`.ayam-inquiry-item[data-inquiry-id="${inquiryId}"]`).fadeOut();
                    showAdminNotice('ลบคำถามเรียบร้อยแล้ว', 'success');
                } else {
                    showAdminNotice(response.data || 'เกิดข้อผิดพลาด', 'error');
                }
            }
        });
    }
    
    /**
     * Process bulk inquiry actions
     */
    function processBulkInquiryAction(action, ids) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ayam_bulk_inquiry_action',
                bulk_action: action,
                inquiry_ids: ids,
                _wpnonce: ayam_admin_nonce
            },
            success: function(response) {
                if (response.success) {
                    showAdminNotice('ดำเนินการเรียบร้อยแล้ว', 'success');
                    location.reload();
                } else {
                    showAdminNotice(response.data || 'เกิดข้อผิดพลาด', 'error');
                }
            }
        });
    }
    
})(jQuery);