/**
 * Meta Boxes JavaScript for Ayam Bangkok
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        initRoosterMetaBoxes();
        initServiceMetaBoxes();
        initNewsMetaBoxes();
    });
    
    /**
     * Initialize rooster meta boxes
     */
    function initRoosterMetaBoxes() {
        // Auto-calculate age from birth date if birth date field exists
        $('#rooster_birth_date').on('change', function() {
            var birthDate = new Date($(this).val());
            var today = new Date();
            var ageMonths = Math.floor((today - birthDate) / (1000 * 60 * 60 * 24 * 30.44));
            
            if (ageMonths > 0) {
                $('#rooster_age').val(ageMonths);
            }
        });
        
        // Price formatting
        $('#rooster_price, #service_price').on('blur', function() {
            var price = parseFloat($(this).val());
            if (!isNaN(price)) {
                $(this).val(price.toFixed(0));
            }
        });
        
        // Weight validation
        $('#rooster_weight').on('input', function() {
            var weight = parseFloat($(this).val());
            var $field = $(this);
            
            if (weight < 0 || weight > 10) {
                $field.addClass('error');
                showFieldError($field, 'น้ำหนักควรอยู่ระหว่าง 0-10 กิโลกรัม');
            } else {
                $field.removeClass('error');
                hideFieldError($field);
            }
        });
        
        // Age validation
        $('#rooster_age').on('input', function() {
            var age = parseInt($(this).val());
            var $field = $(this);
            
            if (age < 0 || age > 120) {
                $field.addClass('error');
                showFieldError($field, 'อายุควรอยู่ระหว่าง 0-120 เดือน');
            } else {
                $field.removeClass('error');
                hideFieldError($field);
            }
        });
        
        // Export ready checkbox functionality
        $('#rooster_export_ready').on('change', function() {
            if ($(this).is(':checked')) {
                $('.export-requirements').show();
                highlightRequiredFields();
            } else {
                $('.export-requirements').hide();
            }
        });
        
        // Fighting record calculator
        $('#rooster_wins, #rooster_losses, #rooster_draws').on('input', function() {
            updateFightingRecord();
        });
    }
    
    /**
     * Initialize service meta boxes
     */
    function initServiceMetaBoxes() {
        // Service type change handler
        $('#service_type').on('change', function() {
            var serviceType = $(this).val();
            updateServiceFields(serviceType);
        });
        
        // Booking availability toggle
        $('#service_booking_available').on('change', function() {
            if ($(this).is(':checked')) {
                $('.booking-fields').show();
            } else {
                $('.booking-fields').hide();
            }
        });
        
        // Duration format helper
        $('#service_duration').on('blur', function() {
            var duration = $(this).val();
            if (duration && !duration.includes('วัน') && !duration.includes('สัปดาห์') && !duration.includes('เดือน')) {
                // Suggest format if no unit is specified
                if ($.isNumeric(duration)) {
                    $(this).val(duration + ' วัน');
                }
            }
        });
    }
    
    /**
     * Initialize news meta boxes
     */
    function initNewsMetaBoxes() {
        // Video URL validation
        $('#news_video_url, #rooster_video_url, #knowledge_video_url').on('blur', function() {
            var url = $(this).val();
            var $field = $(this);
            
            if (url && !isValidYouTubeUrl(url)) {
                $field.addClass('error');
                showFieldError($field, 'กรุณาใส่ลิงก์ YouTube ที่ถูกต้อง');
            } else {
                $field.removeClass('error');
                hideFieldError($field);
            }
        });
        
        // Event date validation
        $('#news_event_date').on('change', function() {
            var eventDate = new Date($(this).val());
            var today = new Date();
            var $field = $(this);
            
            if (eventDate < today) {
                $field.addClass('past-date');
                showFieldWarning($field, 'วันที่กิจกรรมเป็นวันที่ผ่านมาแล้ว');
            } else {
                $field.removeClass('past-date');
                hideFieldError($field);
            }
        });
        
        // Highlight toggle
        $('#news_highlight').on('change', function() {
            if ($(this).is(':checked')) {
                showFieldInfo($(this), 'ข่าวนี้จะแสดงในหน้าแรกของเว็บไซต์');
            }
        });
    }
    
    /**
     * Update fighting record summary
     */
    function updateFightingRecord() {
        var wins = parseInt($('#rooster_wins').val()) || 0;
        var losses = parseInt($('#rooster_losses').val()) || 0;
        var draws = parseInt($('#rooster_draws').val()) || 0;
        var total = wins + losses + draws;
        
        if (total > 0) {
            var winRate = ((wins / total) * 100).toFixed(1);
            var summary = `สถิติรวม: ${wins} ชนะ, ${losses} แพ้, ${draws} เสมอ (อัตราชนะ ${winRate}%)`;
            
            // Update or create summary display
            var $summary = $('#fighting-record-summary');
            if ($summary.length === 0) {
                $summary = $('<div id="fighting-record-summary" class="field-summary"></div>');
                $('#rooster_draws').closest('.ayam-field').after($summary);
            }
            $summary.text(summary);
        }
    }
    
    /**
     * Update service fields based on type
     */
    function updateServiceFields(serviceType) {
        // Hide all conditional fields first
        $('.service-conditional').hide();
        
        // Show relevant fields based on service type
        switch (serviceType) {
            case 'training':
                $('.training-fields').show();
                break;
            case 'healthcare':
                $('.healthcare-fields').show();
                break;
            case 'consulting':
                $('.consulting-fields').show();
                break;
            case 'breeding':
                $('.breeding-fields').show();
                break;
            case 'export':
                $('.export-fields').show();
                break;
        }
    }
    
    /**
     * Highlight required fields for export
     */
    function highlightRequiredFields() {
        var requiredFields = ['#rooster_health_status', '#rooster_vaccination'];
        
        requiredFields.forEach(function(fieldId) {
            var $field = $(fieldId);
            if (!$field.val()) {
                $field.addClass('required-highlight');
                showFieldInfo($field, 'จำเป็นสำหรับการส่งออก');
            }
        });
    }
    
    /**
     * Validate YouTube URL
     */
    function isValidYouTubeUrl(url) {
        var youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+/;
        return youtubeRegex.test(url);
    }
    
    /**
     * Show field error
     */
    function showFieldError($field, message) {
        hideFieldError($field);
        
        var $error = $('<div class="field-error">' + message + '</div>');
        $field.after($error);
        $field.addClass('error');
    }
    
    /**
     * Show field warning
     */
    function showFieldWarning($field, message) {
        hideFieldError($field);
        
        var $warning = $('<div class="field-warning">' + message + '</div>');
        $field.after($warning);
        $field.addClass('warning');
    }
    
    /**
     * Show field info
     */
    function showFieldInfo($field, message) {
        var $info = $field.siblings('.field-info');
        if ($info.length === 0) {
            $info = $('<div class="field-info">' + message + '</div>');
            $field.after($info);
        } else {
            $info.text(message);
        }
    }
    
    /**
     * Hide field error/warning
     */
    function hideFieldError($field) {
        $field.siblings('.field-error, .field-warning').remove();
        $field.removeClass('error warning');
    }
    
    /**
     * Auto-save functionality
     */
    function initAutoSave() {
        var autoSaveTimer;
        
        $('.ayam-rooster-meta-box input, .ayam-rooster-meta-box select, .ayam-rooster-meta-box textarea').on('input change', function() {
            clearTimeout(autoSaveTimer);
            
            autoSaveTimer = setTimeout(function() {
                // Trigger WordPress autosave
                if (typeof wp !== 'undefined' && wp.autosave) {
                    wp.autosave.server.triggerSave();
                }
            }, 3000); // Auto-save after 3 seconds of inactivity
        });
    }
    
    /**
     * Field validation on form submit
     */
    function initFormValidation() {
        $('#post').on('submit', function(e) {
            var hasErrors = false;
            
            // Validate required fields
            $('.required-highlight').each(function() {
                if (!$(this).val()) {
                    showFieldError($(this), 'กรุณากรอกข้อมูลในช่องนี้');
                    hasErrors = true;
                }
            });
            
            // Validate numeric fields
            $('input[type="number"]').each(function() {
                var $field = $(this);
                var value = parseFloat($field.val());
                var min = parseFloat($field.attr('min'));
                var max = parseFloat($field.attr('max'));
                
                if (!isNaN(value)) {
                    if (!isNaN(min) && value < min) {
                        showFieldError($field, 'ค่าต้องไม่น้อยกว่า ' + min);
                        hasErrors = true;
                    }
                    if (!isNaN(max) && value > max) {
                        showFieldError($field, 'ค่าต้องไม่มากกว่า ' + max);
                        hasErrors = true;
                    }
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('.error').first().offset().top - 100
                }, 500);
                
                alert('กรุณาแก้ไขข้อผิดพลาดก่อนบันทึก');
                return false;
            }
        });
    }
    
    // Initialize additional features
    initAutoSave();
    initFormValidation();
    
})(jQuery);