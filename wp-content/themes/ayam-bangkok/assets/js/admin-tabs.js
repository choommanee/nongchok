(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Initialize tabs
        initTabs();
        
        // Initialize sortable
        initSortable();
        
        // Initialize image upload
        initImageUpload();
        
        // Initialize add/remove items
        initAddRemoveItems();
    });
    
    function initTabs() {
        // Handle tab clicks
        $('.nav-tab-wrapper a').on('click', function(e) {
            e.preventDefault();
            
            var target = $(this).attr('href');
            var tabId = target.replace('#tab-', '');
            
            // Update active tab
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            
            // Show/hide content
            $('.tab-content').removeClass('active').hide();
            $(target).addClass('active').show();
            
            // Update hidden field
            $('#active_tab').val(tabId);
        });
        
        // Show initial tab
        var activeTab = $('#active_tab').val() || 'company_info';
        $('.nav-tab[href="#tab-' + activeTab + '"]').trigger('click');
    }
    
    function initSortable() {
        // Make items sortable
        $('.sortable-items').sortable({
            handle: '.ui-sortable-handle',
            placeholder: 'ui-state-highlight',
            tolerance: 'pointer',
            cursor: 'move',
            opacity: 0.8
        });
    }
    
    function initImageUpload() {
        // Image upload functionality
        $(document).on('click', '.upload-image-button', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var input = button.siblings('input[type="url"]');
            
            var mediaUploader = wp.media({
                title: 'เลือกรูปภาพ',
                button: {
                    text: 'เลือก'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
                
                // Show preview
                var preview = button.siblings('.image-preview');
                if (preview.length === 0) {
                    preview = $('<div class="image-preview"></div>');
                    button.after(preview);
                }
                preview.html('<img src="' + attachment.url + '" style="max-width: 200px; height: auto;">');
            });
            
            mediaUploader.open();
        });
    }
    
    function initAddRemoveItems() {
        // Add timeline item
        $(document).on('click', '.add-timeline-item', function(e) {
            e.preventDefault();
            addTimelineItem();
        });
        
        // Add award item
        $(document).on('click', '.add-award-item', function(e) {
            e.preventDefault();
            addAwardItem();
        });
        
        // Add team item
        $(document).on('click', '.add-team-item', function(e) {
            e.preventDefault();
            addTeamItem();
        });
        
        // Add value item
        $(document).on('click', '.add-value-item', function(e) {
            e.preventDefault();
            addValueItem();
        });
        
        // Remove item
        $(document).on('click', '.remove-item', function(e) {
            e.preventDefault();
            if (confirm('คุณแน่ใจหรือไม่ที่จะลบรายการนี้?')) {
                $(this).closest('.timeline-item, .award-item, .team-item, .value-item').remove();
            }
        });
    }
    
    function addTimelineItem() {
        var html = `
            <div class="timeline-item">
                <table class="form-table">
                    <tr>
                        <th>ปี</th>
                        <td><input type="text" name="timeline_year[]" value="" class="small-text"></td>
                    </tr>
                    <tr>
                        <th>หัวข้อ</th>
                        <td><input type="text" name="timeline_title[]" value="" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>รายละเอียด</th>
                        <td><textarea name="timeline_description[]" rows="3" cols="50"></textarea></td>
                    </tr>
                </table>
                <button type="button" class="button remove-item">ลบรายการ</button>
            </div>
        `;
        $('#timeline-items').append(html);
    }
    
    function addAwardItem() {
        var html = `
            <div class="award-item">
                <table class="form-table">
                    <tr>
                        <th>ชื่อรางวัล</th>
                        <td><input type="text" name="award_title[]" value="" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>ปี</th>
                        <td><input type="text" name="award_year[]" value="" class="small-text"></td>
                    </tr>
                    <tr>
                        <th>รายละเอียด</th>
                        <td><textarea name="award_description[]" rows="3" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <th>รูปภาพ</th>
                        <td>
                            <input type="url" name="award_image[]" value="" class="regular-text">
                            <button type="button" class="button upload-image-button">เลือกรูปภาพ</button>
                        </td>
                    </tr>
                </table>
                <button type="button" class="button remove-item">ลบรายการ</button>
            </div>
        `;
        $('#awards-items').append(html);
    }
    
    function addTeamItem() {
        var html = `
            <div class="team-item">
                <table class="form-table">
                    <tr>
                        <th>ชื่อ</th>
                        <td><input type="text" name="member_name[]" value="" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>ตำแหน่ง</th>
                        <td><input type="text" name="member_position[]" value="" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>ประวัติ</th>
                        <td><textarea name="member_bio[]" rows="3" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <th>รูปภาพ</th>
                        <td>
                            <input type="url" name="member_image[]" value="" class="regular-text">
                            <button type="button" class="button upload-image-button">เลือกรูปภาพ</button>
                        </td>
                    </tr>
                    <tr>
                        <th>อีเมล</th>
                        <td><input type="email" name="member_email[]" value="" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>เบอร์โทร</th>
                        <td><input type="text" name="member_phone[]" value="" class="regular-text"></td>
                    </tr>
                </table>
                <button type="button" class="button remove-item">ลบสมาชิก</button>
            </div>
        `;
        $('#team-items').append(html);
    }
    
    function addValueItem() {
        var html = `
            <div class="value-item">
                <table class="form-table">
                    <tr>
                        <th>หัวข้อ</th>
                        <td><input type="text" name="value_title[]" value="" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>รายละเอียด</th>
                        <td><textarea name="value_description[]" rows="3" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <th>ไอคอน (CSS Class)</th>
                        <td><input type="text" name="value_icon[]" value="" class="regular-text" placeholder="เช่น fas fa-heart"></td>
                    </tr>
                </table>
                <button type="button" class="button remove-item">ลบค่านิยม</button>
            </div>
        `;
        $('#values-items').append(html);
    }
    
})(jQuery);