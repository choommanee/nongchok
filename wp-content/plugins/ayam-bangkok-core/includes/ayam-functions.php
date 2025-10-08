<?php
/**
 * Helper Functions for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get rooster data with all custom fields
 */
function ayam_get_rooster_data($rooster_id) {
    if (!$rooster_id) {
        return false;
    }
    
    $rooster = get_post($rooster_id);
    if (!$rooster || $rooster->post_type !== 'ayam_rooster') {
        return false;
    }
    
    $data = array(
        'id' => $rooster->ID,
        'title' => $rooster->post_title,
        'content' => $rooster->post_content,
        'excerpt' => $rooster->post_excerpt,
        'featured_image' => get_the_post_thumbnail_url($rooster->ID, 'large'),
        'price' => get_field('rooster_price', $rooster->ID),
        'age' => get_field('rooster_age', $rooster->ID),
        'weight' => get_field('rooster_weight', $rooster->ID),
        'color' => get_field('rooster_color', $rooster->ID),
        'fighting_record' => get_field('rooster_fighting_record', $rooster->ID),
        'pedigree_father' => get_field('rooster_pedigree_father', $rooster->ID),
        'pedigree_mother' => get_field('rooster_pedigree_mother', $rooster->ID),
        'health_status' => get_field('rooster_health_status', $rooster->ID),
        'export_ready' => get_field('rooster_export_ready', $rooster->ID),
        'gallery' => get_field('rooster_gallery', $rooster->ID),
        'video_url' => get_field('rooster_video_url', $rooster->ID),
        'breed' => wp_get_post_terms($rooster->ID, 'rooster_breed'),
        'category' => wp_get_post_terms($rooster->ID, 'rooster_category'),
        'status' => $rooster->post_status,
        'date_created' => $rooster->post_date,
        'permalink' => get_permalink($rooster->ID)
    );
    
    return $data;
}

/**
 * Search roosters with filters
 */
function ayam_search_roosters($args = array()) {
    $defaults = array(
        'post_type' => 'ayam_rooster',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' => 1,
        'meta_query' => array(),
        'tax_query' => array()
    );
    
    $args = wp_parse_args($args, $defaults);
    
    // Add breed filter
    if (!empty($args['breed'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'rooster_breed',
            'field' => 'slug',
            'terms' => $args['breed']
        );
        unset($args['breed']);
    }
    
    // Add category filter
    if (!empty($args['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'rooster_category',
            'field' => 'slug',
            'terms' => $args['category']
        );
        unset($args['category']);
    }
    
    // Add price range filter
    if (!empty($args['price_min']) || !empty($args['price_max'])) {
        $price_query = array(
            'key' => 'rooster_price',
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        );
        
        if (!empty($args['price_min']) && !empty($args['price_max'])) {
            $price_query['value'] = array($args['price_min'], $args['price_max']);
        } elseif (!empty($args['price_min'])) {
            $price_query['value'] = $args['price_min'];
            $price_query['compare'] = '>=';
        } elseif (!empty($args['price_max'])) {
            $price_query['value'] = $args['price_max'];
            $price_query['compare'] = '<=';
        }
        
        $args['meta_query'][] = $price_query;
        unset($args['price_min'], $args['price_max']);
    }
    
    // Add age filter
    if (!empty($args['age_min']) || !empty($args['age_max'])) {
        $age_query = array(
            'key' => 'rooster_age',
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        );
        
        if (!empty($args['age_min']) && !empty($args['age_max'])) {
            $age_query['value'] = array($args['age_min'], $args['age_max']);
        } elseif (!empty($args['age_min'])) {
            $age_query['value'] = $args['age_min'];
            $age_query['compare'] = '>=';
        } elseif (!empty($args['age_max'])) {
            $age_query['value'] = $args['age_max'];
            $age_query['compare'] = '<=';
        }
        
        $args['meta_query'][] = $age_query;
        unset($args['age_min'], $args['age_max']);
    }
    
    // Add export ready filter
    if (isset($args['export_ready'])) {
        $args['meta_query'][] = array(
            'key' => 'rooster_export_ready',
            'value' => $args['export_ready'],
            'compare' => '='
        );
        unset($args['export_ready']);
    }
    
    $query = new WP_Query($args);
    return $query;
}

/**
 * Format price in Thai Baht
 */
function ayam_format_price($price) {
    if (!$price) {
        return 'ราคาตามสอบถาม';
    }
    
    return number_format($price, 0, '.', ',') . ' บาท';
}

/**
 * Get rooster age in Thai format
 */
function ayam_format_age($age_months) {
    if (!$age_months) {
        return 'ไม่ระบุ';
    }
    
    if ($age_months < 12) {
        return $age_months . ' เดือน';
    } else {
        $years = floor($age_months / 12);
        $months = $age_months % 12;
        
        $age_string = $years . ' ปี';
        if ($months > 0) {
            $age_string .= ' ' . $months . ' เดือน';
        }
        
        return $age_string;
    }
}

/**
 * Get rooster weight in Thai format
 */
function ayam_format_weight($weight_kg) {
    if (!$weight_kg) {
        return 'ไม่ระบุ';
    }
    
    return number_format($weight_kg, 2) . ' กิโลกรัม';
}

/**
 * Log activity
 */
function ayam_log_activity($action, $object_type = null, $object_id = null, $description = null) {
    global $wpdb;
    
    $user_id = get_current_user_id();
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    $wpdb->insert(
        $wpdb->prefix . 'ayam_activity_log',
        array(
            'user_id' => $user_id,
            'action' => $action,
            'object_type' => $object_type,
            'object_id' => $object_id,
            'description' => $description,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent
        ),
        array('%d', '%s', '%s', '%d', '%s', '%s', '%s')
    );
}

/**
 * Check if user can view rooster details
 */
function ayam_can_view_rooster_details($rooster_id = null) {
    if (!is_user_logged_in()) {
        return false;
    }
    
    $user = wp_get_current_user();
    
    // Administrators and staff can view all details
    if (in_array('administrator', $user->roles) || 
        in_array('ayam_manager', $user->roles) || 
        in_array('ayam_staff', $user->roles)) {
        return true;
    }
    
    // Premium members can view detailed info
    if (in_array('premium_member', $user->roles)) {
        return true;
    }
    
    // Regular members can view basic info only
    return false;
}

/**
 * Get user's preferred breeds
 */
function ayam_get_user_preferred_breeds($user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    if (!$user_id) {
        return array();
    }
    
    global $wpdb;
    $preferences = $wpdb->get_var($wpdb->prepare(
        "SELECT preferred_breeds FROM {$wpdb->prefix}ayam_user_preferences WHERE user_id = %d",
        $user_id
    ));
    
    if ($preferences) {
        return json_decode($preferences, true);
    }
    
    return array();
}

/**
 * Save user preferences
 */
function ayam_save_user_preferences($user_id, $preferences) {
    global $wpdb;
    
    $table = $wpdb->prefix . 'ayam_user_preferences';
    
    // Check if preferences exist
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table WHERE user_id = %d",
        $user_id
    ));
    
    $data = array(
        'user_id' => $user_id,
        'preferred_breeds' => json_encode($preferences['preferred_breeds'] ?? array()),
        'price_range_min' => $preferences['price_range_min'] ?? null,
        'price_range_max' => $preferences['price_range_max'] ?? null,
        'notification_email' => $preferences['notification_email'] ?? 1,
        'notification_sms' => $preferences['notification_sms'] ?? 0,
        'notification_line' => $preferences['notification_line'] ?? 0,
        'newsletter_subscription' => $preferences['newsletter_subscription'] ?? 1,
        'language_preference' => $preferences['language_preference'] ?? 'th',
        'timezone' => $preferences['timezone'] ?? 'Asia/Bangkok'
    );
    
    if ($existing) {
        $wpdb->update($table, $data, array('user_id' => $user_id));
    } else {
        $wpdb->insert($table, $data);
    }
}

/**
 * Get booking by ID
 */
function ayam_get_booking($booking_id) {
    global $wpdb;
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}ayam_bookings WHERE id = %d",
        $booking_id
    ));
}

/**
 * Create new booking
 */
function ayam_create_booking($booking_data) {
    global $wpdb;
    
    $defaults = array(
        'user_id' => get_current_user_id(),
        'status' => 'pending',
        'payment_status' => 'unpaid',
        'total_amount' => 0.00
    );
    
    $booking_data = wp_parse_args($booking_data, $defaults);
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'ayam_bookings',
        $booking_data
    );
    
    if ($result) {
        $booking_id = $wpdb->insert_id;
        ayam_log_activity('booking_created', 'booking', $booking_id, 'New booking created');
        return $booking_id;
    }
    
    return false;
}

/**
 * Create new inquiry
 */
function ayam_create_inquiry($inquiry_data) {
    global $wpdb;
    
    $defaults = array(
        'user_id' => get_current_user_id(),
        'inquiry_type' => 'general',
        'status' => 'new',
        'priority' => 'normal',
        'preferred_contact' => 'email'
    );
    
    $inquiry_data = wp_parse_args($inquiry_data, $defaults);
    
    $result = $wpdb->insert(
        $wpdb->prefix . 'ayam_inquiries',
        $inquiry_data
    );
    
    if ($result) {
        $inquiry_id = $wpdb->insert_id;
        ayam_log_activity('inquiry_created', 'inquiry', $inquiry_id, 'New inquiry submitted');
        return $inquiry_id;
    }
    
    return false;
}

/**
 * Send notification email
 */
function ayam_send_notification_email($to, $subject, $message, $headers = array()) {
    $default_headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Ayam Bangkok <noreply@ayambangkok.com>'
    );
    
    $headers = array_merge($default_headers, $headers);
    
    return wp_mail($to, $subject, $message, $headers);
}

/**
 * Get site settings
 */
function ayam_get_setting($key, $default = null) {
    return get_option('ayam_' . $key, $default);
}

/**
 * Update site settings
 */
function ayam_update_setting($key, $value) {
    return update_option('ayam_' . $key, $value);
}
/**

 * ACF Helper Functions
 */

/**
 * Get field value with fallback to post meta
 */
function ayam_get_field($field_name, $post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    // Try ACF first
    if (function_exists('get_field')) {
        $value = get_field($field_name, $post_id);
        if ($value !== false) {
            return $value;
        }
    }
    
    // Fallback to post meta
    return get_post_meta($post_id, $field_name, true);
}

/**
 * Get rooster price with formatting
 */
function ayam_get_rooster_price($rooster_id = null) {
    $price = ayam_get_field('rooster_price', $rooster_id);
    return $price ? ayam_format_price($price) : 'ราคาตามสอบถาม';
}

/**
 * Get rooster age with formatting
 */
function ayam_get_rooster_age($rooster_id = null) {
    $age = ayam_get_field('rooster_age', $rooster_id);
    return $age ? ayam_format_age($age) : 'ไม่ระบุ';
}

/**
 * Get rooster weight with formatting
 */
function ayam_get_rooster_weight($rooster_id = null) {
    $weight = ayam_get_field('rooster_weight', $rooster_id);
    return $weight ? ayam_format_weight($weight) : 'ไม่ระบุ';
}

/**
 * Get rooster status with Thai label
 */
function ayam_get_rooster_status($rooster_id = null) {
    $status = ayam_get_field('rooster_status', $rooster_id);
    
    $status_labels = array(
        'available' => 'พร้อมขาย',
        'reserved' => 'จองแล้ว',
        'sold' => 'ขายแล้ว',
        'training' => 'กำลังฝึก',
        'breeding' => 'ใช้ผสมพันธุ์'
    );
    
    return isset($status_labels[$status]) ? $status_labels[$status] : 'ไม่ระบุ';
}

/**
 * Get rooster color with Thai label
 */
function ayam_get_rooster_color($rooster_id = null) {
    $color = ayam_get_field('rooster_color', $rooster_id);
    
    $color_labels = array(
        'red' => 'แดง',
        'black' => 'ดำ',
        'white' => 'ขาว',
        'brown' => 'น้ำตาล',
        'yellow' => 'เหลือง',
        'mixed' => 'ผสม',
        'other' => 'อื่นๆ'
    );
    
    return isset($color_labels[$color]) ? $color_labels[$color] : 'ไม่ระบุ';
}

/**
 * Get rooster fighting record summary
 */
function ayam_get_fighting_record($rooster_id = null) {
    $wins = (int) ayam_get_field('rooster_wins', $rooster_id);
    $losses = (int) ayam_get_field('rooster_losses', $rooster_id);
    $draws = (int) ayam_get_field('rooster_draws', $rooster_id);
    
    $total = $wins + $losses + $draws;
    
    if ($total === 0) {
        return 'ยังไม่มีประวัตการแข่งขัน';
    }
    
    $win_rate = round(($wins / $total) * 100, 1);
    
    return sprintf(
        '%d ชนะ, %d แพ้, %d เสมอ (อัตราชนะ %s%%)',
        $wins,
        $losses,
        $draws,
        $win_rate
    );
}

/**
 * Check if rooster is export ready
 */
function ayam_is_export_ready($rooster_id = null) {
    return (bool) ayam_get_field('rooster_export_ready', $rooster_id);
}

/**
 * Get rooster gallery images
 */
function ayam_get_rooster_gallery($rooster_id = null) {
    $gallery = ayam_get_field('rooster_gallery', $rooster_id);
    
    if (empty($gallery)) {
        return array();
    }
    
    // Handle ACF gallery format
    if (is_array($gallery) && isset($gallery[0]['url'])) {
        return $gallery;
    }
    
    // Handle custom meta format (comma-separated IDs)
    if (is_string($gallery)) {
        $image_ids = explode(',', $gallery);
        $images = array();
        
        foreach ($image_ids as $id) {
            $id = trim($id);
            if (is_numeric($id)) {
                $image = wp_get_attachment_image_src($id, 'large');
                if ($image) {
                    $images[] = array(
                        'id' => $id,
                        'url' => $image[0],
                        'width' => $image[1],
                        'height' => $image[2],
                        'alt' => get_post_meta($id, '_wp_attachment_image_alt', true)
                    );
                }
            }
        }
        
        return $images;
    }
    
    return array();
}

/**
 * Get service price with formatting
 */
function ayam_get_service_price($service_id = null) {
    $price = ayam_get_field('service_price', $service_id);
    return $price ? ayam_format_price($price) : 'ราคาตามสอบถาม';
}

/**
 * Get service duration
 */
function ayam_get_service_duration($service_id = null) {
    $duration = ayam_get_field('service_duration', $service_id);
    return $duration ?: 'ระยะเวลาตามสอบถาม';
}

/**
 * Check if service booking is available
 */
function ayam_is_service_bookable($service_id = null) {
    return (bool) ayam_get_field('service_booking_available', $service_id);
}

/**
 * Get company information
 */
if (!function_exists('ayam_get_company_info')) {
    function ayam_get_company_info($field_name) {
        if (function_exists('get_field')) {
            return get_field($field_name, 'option');
        }
        
        return get_option('ayam_company_' . $field_name, '');
    }
}

/**
 * Get company name
 */
function ayam_get_company_name($lang = 'th') {
    $field_name = $lang === 'en' ? 'company_name_en' : 'company_name_th';
    return ayam_get_company_info($field_name) ?: 'หนองจอก เอฟซีไอ';
}

/**
 * Get company contact info
 */
function ayam_get_company_contact() {
    return array(
        'phone' => ayam_get_company_info('company_phone'),
        'email' => ayam_get_company_info('company_email'),
        'line_id' => ayam_get_company_info('company_line_id'),
        'address' => ayam_get_company_info('company_address'),
        'facebook' => ayam_get_company_info('company_facebook'),
        'youtube' => ayam_get_company_info('company_youtube'),
    );
}

/**
 * Display rooster card
 */
function ayam_display_rooster_card($rooster_id, $show_details = true) {
    $rooster = get_post($rooster_id);
    if (!$rooster) {
        return '';
    }
    
    $price = ayam_get_rooster_price($rooster_id);
    $age = ayam_get_rooster_age($rooster_id);
    $weight = ayam_get_rooster_weight($rooster_id);
    $status = ayam_get_rooster_status($rooster_id);
    $color = ayam_get_rooster_color($rooster_id);
    $featured_image = get_the_post_thumbnail_url($rooster_id, 'medium');
    $breeds = wp_get_post_terms($rooster_id, 'rooster_breed');
    $breed_name = !empty($breeds) ? $breeds[0]->name : 'ไม่ระบุสายพันธุ์';
    
    $status_class = strtolower(str_replace(' ', '-', ayam_get_field('rooster_status', $rooster_id)));
    
    ob_start();
    ?>
    <div class="ayam-rooster-card" data-rooster-id="<?php echo $rooster_id; ?>">
        <div class="card-image">
            <?php if ($featured_image): ?>
                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($rooster->post_title); ?>">
            <?php else: ?>
                <div class="placeholder-image">
                    <span class="dashicons dashicons-pets"></span>
                </div>
            <?php endif; ?>
            
            <div class="price-badge"><?php echo esc_html($price); ?></div>
            <div class="status-badge <?php echo esc_attr($status_class); ?>"><?php echo esc_html($status); ?></div>
        </div>
        
        <div class="card-body">
            <h3 class="card-title"><?php echo esc_html($rooster->post_title); ?></h3>
            <div class="breed-info"><?php echo esc_html($breed_name); ?></div>
            
            <?php if ($show_details): ?>
                <div class="rooster-details">
                    <span class="detail-item">
                        <strong>อายุ:</strong> <?php echo esc_html($age); ?>
                    </span>
                    <span class="detail-item">
                        <strong>น้ำหนัก:</strong> <?php echo esc_html($weight); ?>
                    </span>
                    <span class="detail-item">
                        <strong>สี:</strong> <?php echo esc_html($color); ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <?php if ($rooster->post_excerpt): ?>
                <p class="card-excerpt"><?php echo esc_html($rooster->post_excerpt); ?></p>
            <?php endif; ?>
            
            <div class="card-actions">
                <a href="<?php echo get_permalink($rooster_id); ?>" class="btn btn-primary">
                    <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                </a>
                <button class="btn btn-outline-primary btn-inquiry" data-rooster-id="<?php echo $rooster_id; ?>">
                    <?php _e('สอบถาม', 'ayam-bangkok'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Validate ACF field data
 */
function ayam_validate_field_data($field_name, $value, $post_id = null) {
    $errors = array();
    
    switch ($field_name) {
        case 'rooster_price':
            if ($value < 0) {
                $errors[] = 'ราคาต้องไม่น้อยกว่า 0';
            }
            break;
            
        case 'rooster_age':
            if ($value < 0 || $value > 120) {
                $errors[] = 'อายุต้องอยู่ระหว่าง 0-120 เดือน';
            }
            break;
            
        case 'rooster_weight':
            if ($value < 0 || $value > 10) {
                $errors[] = 'น้ำหนักต้องอยู่ระหว่าง 0-10 กิโลกรัม';
            }
            break;
            
        case 'rooster_video_url':
        case 'news_video_url':
        case 'knowledge_video_url':
            if ($value && !preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+/', $value)) {
                $errors[] = 'กรุณาใส่ลิงก์ YouTube ที่ถูกต้อง';
            }
            break;
    }
    
    return $errors;
}
/**
 *
 Database Helper Functions
 */

/**
 * Get system setting
 */
function ayam_get_system_setting($key, $default = null) {
    return AyamDBHelpers::get_setting($key, $default);
}

/**
 * Update system setting
 */
function ayam_update_system_setting($key, $value, $type = 'string', $category = 'general') {
    return AyamDBHelpers::update_setting($key, $value, $type, $category);
}

/**
 * Add health record for rooster
 */
function ayam_add_health_record($rooster_id, $data) {
    return AyamDBHelpers::add_health_record($rooster_id, $data);
}

/**
 * Get health records for rooster
 */
function ayam_get_health_records($rooster_id, $limit = 10) {
    return AyamDBHelpers::get_health_records($rooster_id, $limit);
}

/**
 * Add training record for rooster
 */
function ayam_add_training_record($rooster_id, $data) {
    return AyamDBHelpers::add_training_record($rooster_id, $data);
}

/**
 * Get training records for rooster
 */
function ayam_get_training_records($rooster_id, $limit = 10) {
    return AyamDBHelpers::get_training_records($rooster_id, $limit);
}

/**
 * Add fighting record for rooster
 */
function ayam_add_fighting_record($rooster_id, $data) {
    return AyamDBHelpers::add_fighting_record($rooster_id, $data);
}

/**
 * Get fighting records for rooster
 */
function ayam_get_fighting_records($rooster_id, $limit = 10) {
    return AyamDBHelpers::get_fighting_records($rooster_id, $limit);
}

/**
 * Get customer profile
 */
function ayam_get_customer_profile($user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    return AyamDBHelpers::get_customer_profile($user_id);
}

/**
 * Create customer profile
 */
function ayam_create_customer_profile($user_id, $data) {
    return AyamDBHelpers::create_customer_profile($user_id, $data);
}

/**
 * Add notification for user
 */
function ayam_add_notification($user_id, $type, $title, $message, $action_url = null, $priority = 'normal') {
    return AyamDBHelpers::add_notification($user_id, $type, $title, $message, $action_url, $priority);
}

/**
 * Get unread notifications for current user
 */
function ayam_get_unread_notifications($user_id = null, $limit = 10) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    return AyamDBHelpers::get_unread_notifications($user_id, $limit);
}

/**
 * Mark notification as read
 */
function ayam_mark_notification_read($notification_id, $user_id = null) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    return AyamDBHelpers::mark_notification_read($notification_id, $user_id);
}

/**
 * Get dashboard statistics
 */
function ayam_get_dashboard_stats() {
    return AyamDBHelpers::get_dashboard_stats();
}

/**
 * Get export documents
 */
function ayam_get_export_documents($export_record_id) {
    return AyamDBHelpers::get_export_documents($export_record_id);
}

/**
 * Add export document
 */
function ayam_add_export_document($export_record_id, $data) {
    return AyamDBHelpers::add_export_document($export_record_id, $data);
}

/**
 * Check if rooster is ready for export
 */
function ayam_check_export_readiness($rooster_id) {
    $readiness = array(
        'ready' => false,
        'issues' => array(),
        'requirements' => array()
    );
    
    // Check age requirement
    $min_age = ayam_get_system_setting('rooster_min_age_export', 6);
    $rooster_age = ayam_get_field('rooster_age', $rooster_id);
    
    if (!$rooster_age || $rooster_age < $min_age) {
        $readiness['issues'][] = "ไก่ชนต้องมีอายุอย่างน้อย $min_age เดือน";
    } else {
        $readiness['requirements'][] = "อายุ: $rooster_age เดือน (ผ่าน)";
    }
    
    // Check health status
    $health_status = ayam_get_field('rooster_health_status', $rooster_id);
    if ($health_status !== 'excellent' && $health_status !== 'good') {
        $readiness['issues'][] = 'สถานะสุขภาพต้องอยู่ในระดับดีหรือดีเยี่ยม';
    } else {
        $readiness['requirements'][] = "สุขภาพ: $health_status (ผ่าน)";
    }
    
    // Check health certificate
    $health_cert = ayam_get_field('rooster_health_certificate', $rooster_id);
    if (!$health_cert) {
        $readiness['issues'][] = 'ต้องมีใบรับรองสุขภาพจากสัตวแพทย์';
    } else {
        $readiness['requirements'][] = 'ใบรับรองสุขภาพ: มี (ผ่าน)';
    }
    
    // Check vaccination records
    $vaccination = ayam_get_field('rooster_vaccination', $rooster_id);
    if (!$vaccination) {
        $readiness['issues'][] = 'ต้องมีบันทึกการฉีดวัคซีน';
    } else {
        $readiness['requirements'][] = 'บันทึกวัคซีน: มี (ผ่าน)';
    }
    
    // Check quarantine period
    $quarantine_date = ayam_get_field('rooster_quarantine_date', $rooster_id);
    $quarantine_days = ayam_get_system_setting('quarantine_period_days', 21);
    
    if ($quarantine_date) {
        $quarantine_end = date('Y-m-d', strtotime($quarantine_date . " + $quarantine_days days"));
        if (date('Y-m-d') < $quarantine_end) {
            $days_left = ceil((strtotime($quarantine_end) - time()) / (60 * 60 * 24));
            $readiness['issues'][] = "ต้องกักกันอีก $days_left วัน";
        } else {
            $readiness['requirements'][] = "กักกัน: ครบ $quarantine_days วันแล้ว (ผ่าน)";
        }
    } else {
        $readiness['issues'][] = "ต้องเข้ากักกัน $quarantine_days วันก่อนส่งออก";
    }
    
    // Set ready status
    $readiness['ready'] = empty($readiness['issues']);
    
    return $readiness;
}

/**
 * Format currency
 */
function ayam_format_currency($amount) {
    $symbol = ayam_get_system_setting('currency_symbol', '฿');
    return $symbol . number_format($amount, 2);
}

/**
 * Get timezone
 */
function ayam_get_timezone() {
    return ayam_get_system_setting('timezone', 'Asia/Bangkok');
}

/**
 * Schedule notification cleanup (run daily)
 */
function ayam_schedule_cleanup() {
    if (!wp_next_scheduled('ayam_daily_cleanup')) {
        wp_schedule_event(time(), 'daily', 'ayam_daily_cleanup');
    }
}
add_action('init', 'ayam_schedule_cleanup');

/**
 * Daily cleanup hook
 */
function ayam_daily_cleanup_hook() {
    AyamDBHelpers::cleanup_expired_notifications();
}
add_action('ayam_daily_cleanup', 'ayam_daily_cleanup_hook');