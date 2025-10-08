<?php
/**
 * REST API Endpoints for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamAPI {
    
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }
    
    /**
     * Register REST API routes
     */
    public function register_routes() {
        // Roosters endpoints
        register_rest_route('ayam/v1', '/roosters', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_roosters'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('ayam/v1', '/roosters/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_rooster'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('ayam/v1', '/roosters/search', array(
            'methods' => 'GET',
            'callback' => array($this, 'search_roosters'),
            'permission_callback' => '__return_true'
        ));
        
        // Bookings endpoints
        register_rest_route('ayam/v1', '/bookings', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_booking'),
            'permission_callback' => array($this, 'check_user_permission')
        ));
        
        register_rest_route('ayam/v1', '/bookings/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_booking'),
            'permission_callback' => array($this, 'check_user_permission')
        ));
        
        // Inquiries endpoints
        register_rest_route('ayam/v1', '/inquiries', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_inquiry'),
            'permission_callback' => '__return_true'
        ));
        
        // Services endpoints
        register_rest_route('ayam/v1', '/services', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_services'),
            'permission_callback' => '__return_true'
        ));
        
        // Breeds and categories endpoints
        register_rest_route('ayam/v1', '/breeds', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_breeds'),
            'permission_callback' => '__return_true'
        ));
        
        register_rest_route('ayam/v1', '/categories', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_categories'),
            'permission_callback' => '__return_true'
        ));
    }
    
    /**
     * Get roosters list
     */
    public function get_roosters($request) {
        $params = $request->get_params();
        
        $args = array(
            'post_type' => 'ayam_rooster',
            'post_status' => 'publish',
            'posts_per_page' => $params['per_page'] ?? 12,
            'paged' => $params['page'] ?? 1
        );
        
        if (!empty($params['breed'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'rooster_breed',
                'field' => 'slug',
                'terms' => $params['breed']
            );
        }
        
        if (!empty($params['category'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'rooster_category',
                'field' => 'slug',
                'terms' => $params['category']
            );
        }
        
        $query = new WP_Query($args);
        $roosters = array();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $roosters[] = $this->format_rooster_data(get_the_ID());
            }
            wp_reset_postdata();
        }
        
        return rest_ensure_response(array(
            'roosters' => $roosters,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages,
            'current_page' => $args['paged']
        ));
    }
    
    /**
     * Get single rooster
     */
    public function get_rooster($request) {
        $rooster_id = $request['id'];
        $rooster_data = ayam_get_rooster_data($rooster_id);
        
        if (!$rooster_data) {
            return new WP_Error('rooster_not_found', 'Rooster not found', array('status' => 404));
        }
        
        return rest_ensure_response($rooster_data);
    }
    
    /**
     * Search roosters
     */
    public function search_roosters($request) {
        $params = $request->get_params();
        
        $search_args = array(
            'posts_per_page' => $params['per_page'] ?? 12,
            'paged' => $params['page'] ?? 1
        );
        
        // Add search filters
        if (!empty($params['breed'])) {
            $search_args['breed'] = $params['breed'];
        }
        
        if (!empty($params['category'])) {
            $search_args['category'] = $params['category'];
        }
        
        if (!empty($params['price_min'])) {
            $search_args['price_min'] = floatval($params['price_min']);
        }
        
        if (!empty($params['price_max'])) {
            $search_args['price_max'] = floatval($params['price_max']);
        }
        
        if (!empty($params['age_min'])) {
            $search_args['age_min'] = intval($params['age_min']);
        }
        
        if (!empty($params['age_max'])) {
            $search_args['age_max'] = intval($params['age_max']);
        }
        
        if (isset($params['export_ready'])) {
            $search_args['export_ready'] = $params['export_ready'] === 'true';
        }
        
        if (!empty($params['search'])) {
            $search_args['s'] = sanitize_text_field($params['search']);
        }
        
        $query = ayam_search_roosters($search_args);
        $roosters = array();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $roosters[] = $this->format_rooster_data(get_the_ID());
            }
            wp_reset_postdata();
        }
        
        return rest_ensure_response(array(
            'roosters' => $roosters,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages,
            'current_page' => $search_args['paged'],
            'filters' => $params
        ));
    }
    
    /**
     * Create booking
     */
    public function create_booking($request) {
        $params = $request->get_params();
        
        // Validate required fields
        $required_fields = array('service_id', 'booking_date', 'customer_name', 'customer_email');
        foreach ($required_fields as $field) {
            if (empty($params[$field])) {
                return new WP_Error('missing_field', "Field '$field' is required", array('status' => 400));
            }
        }
        
        // Sanitize data
        $booking_data = array(
            'service_id' => intval($params['service_id']),
            'booking_date' => sanitize_text_field($params['booking_date']),
            'booking_time' => sanitize_text_field($params['booking_time'] ?? ''),
            'customer_name' => sanitize_text_field($params['customer_name']),
            'customer_email' => sanitize_email($params['customer_email']),
            'customer_phone' => sanitize_text_field($params['customer_phone'] ?? ''),
            'customer_line' => sanitize_text_field($params['customer_line'] ?? ''),
            'service_type' => sanitize_text_field($params['service_type'] ?? ''),
            'special_requests' => sanitize_textarea_field($params['special_requests'] ?? ''),
            'total_amount' => floatval($params['total_amount'] ?? 0)
        );
        
        $booking_id = ayam_create_booking($booking_data);
        
        if ($booking_id) {
            // Send confirmation email
            $this->send_booking_confirmation($booking_id);
            
            return rest_ensure_response(array(
                'success' => true,
                'booking_id' => $booking_id,
                'message' => 'Booking created successfully'
            ));
        }
        
        return new WP_Error('booking_failed', 'Failed to create booking', array('status' => 500));
    }
    
    /**
     * Get booking
     */
    public function get_booking($request) {
        $booking_id = $request['id'];
        $booking = ayam_get_booking($booking_id);
        
        if (!$booking) {
            return new WP_Error('booking_not_found', 'Booking not found', array('status' => 404));
        }
        
        // Check if user can view this booking
        $current_user_id = get_current_user_id();
        if ($booking->user_id != $current_user_id && !current_user_can('manage_ayam_bookings')) {
            return new WP_Error('access_denied', 'Access denied', array('status' => 403));
        }
        
        return rest_ensure_response($booking);
    }
    
    /**
     * Create inquiry
     */
    public function create_inquiry($request) {
        $params = $request->get_params();
        
        // Validate required fields
        $required_fields = array('customer_name', 'customer_email', 'subject', 'message');
        foreach ($required_fields as $field) {
            if (empty($params[$field])) {
                return new WP_Error('missing_field', "Field '$field' is required", array('status' => 400));
            }
        }
        
        // Sanitize data
        $inquiry_data = array(
            'rooster_id' => intval($params['rooster_id'] ?? 0),
            'customer_name' => sanitize_text_field($params['customer_name']),
            'customer_email' => sanitize_email($params['customer_email']),
            'customer_phone' => sanitize_text_field($params['customer_phone'] ?? ''),
            'customer_line' => sanitize_text_field($params['customer_line'] ?? ''),
            'inquiry_type' => sanitize_text_field($params['inquiry_type'] ?? 'general'),
            'subject' => sanitize_text_field($params['subject']),
            'message' => sanitize_textarea_field($params['message']),
            'preferred_contact' => sanitize_text_field($params['preferred_contact'] ?? 'email')
        );
        
        $inquiry_id = ayam_create_inquiry($inquiry_data);
        
        if ($inquiry_id) {
            // Send notification to admin
            $this->send_inquiry_notification($inquiry_id);
            
            return rest_ensure_response(array(
                'success' => true,
                'inquiry_id' => $inquiry_id,
                'message' => 'Inquiry submitted successfully'
            ));
        }
        
        return new WP_Error('inquiry_failed', 'Failed to submit inquiry', array('status' => 500));
    }
    
    /**
     * Get services
     */
    public function get_services($request) {
        $params = $request->get_params();
        
        $args = array(
            'post_type' => 'ayam_service',
            'post_status' => 'publish',
            'posts_per_page' => $params['per_page'] ?? -1
        );
        
        if (!empty($params['category'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'service_category',
                'field' => 'slug',
                'terms' => $params['category']
            );
        }
        
        $query = new WP_Query($args);
        $services = array();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $services[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'content' => get_the_content(),
                    'excerpt' => get_the_excerpt(),
                    'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    'price' => get_field('service_price'),
                    'duration' => get_field('service_duration'),
                    'category' => wp_get_post_terms(get_the_ID(), 'service_category'),
                    'permalink' => get_permalink()
                );
            }
            wp_reset_postdata();
        }
        
        return rest_ensure_response($services);
    }
    
    /**
     * Get breeds
     */
    public function get_breeds($request) {
        $breeds = get_terms(array(
            'taxonomy' => 'rooster_breed',
            'hide_empty' => false
        ));
        
        return rest_ensure_response($breeds);
    }
    
    /**
     * Get categories
     */
    public function get_categories($request) {
        $categories = get_terms(array(
            'taxonomy' => 'rooster_category',
            'hide_empty' => false
        ));
        
        return rest_ensure_response($categories);
    }
    
    /**
     * Format rooster data for API response
     */
    private function format_rooster_data($rooster_id) {
        $data = ayam_get_rooster_data($rooster_id);
        
        // Remove sensitive data for non-privileged users
        if (!ayam_can_view_rooster_details()) {
            unset($data['fighting_record']);
            unset($data['pedigree_father']);
            unset($data['pedigree_mother']);
        }
        
        return $data;
    }
    
    /**
     * Check user permission
     */
    public function check_user_permission($request) {
        return is_user_logged_in();
    }
    
    /**
     * Send booking confirmation email
     */
    private function send_booking_confirmation($booking_id) {
        $booking = ayam_get_booking($booking_id);
        if (!$booking) {
            return false;
        }
        
        $subject = 'ยืนยันการจองบริการ - Ayam Bangkok';
        $message = "
        <h2>ยืนยันการจองบริการ</h2>
        <p>เรียน คุณ{$booking->customer_name}</p>
        <p>ขอบคุณที่ใช้บริการของเรา รายละเอียดการจองของท่าน:</p>
        <ul>
            <li>หมายเลขการจอง: #{$booking->id}</li>
            <li>วันที่จอง: {$booking->booking_date}</li>
            <li>เวลา: {$booking->booking_time}</li>
            <li>ประเภทบริการ: {$booking->service_type}</li>
            <li>จำนวนเงิน: " . ayam_format_price($booking->total_amount) . "</li>
        </ul>
        <p>เราจะติดต่อกลับไปยังท่านเพื่อยืนยันรายละเอียดเพิ่มเติม</p>
        <p>ขอบคุณครับ<br>ทีมงาน Ayam Bangkok</p>
        ";
        
        return ayam_send_notification_email($booking->customer_email, $subject, $message);
    }
    
    /**
     * Send inquiry notification to admin
     */
    private function send_inquiry_notification($inquiry_id) {
        global $wpdb;
        
        $inquiry = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ayam_inquiries WHERE id = %d",
            $inquiry_id
        ));
        
        if (!$inquiry) {
            return false;
        }
        
        $admin_email = get_option('admin_email');
        $subject = 'มีคำถามใหม่จากลูกค้า - Ayam Bangkok';
        $message = "
        <h2>คำถามใหม่จากลูกค้า</h2>
        <p><strong>ชื่อ:</strong> {$inquiry->customer_name}</p>
        <p><strong>อีเมล:</strong> {$inquiry->customer_email}</p>
        <p><strong>เบอร์โทร:</strong> {$inquiry->customer_phone}</p>
        <p><strong>หัวข้อ:</strong> {$inquiry->subject}</p>
        <p><strong>ข้อความ:</strong></p>
        <p>{$inquiry->message}</p>
        <p><strong>ประเภทการติดต่อที่ต้องการ:</strong> {$inquiry->preferred_contact}</p>
        <p>กรุณาตอบกลับลูกค้าโดยเร็วที่สุด</p>
        ";
        
        return ayam_send_notification_email($admin_email, $subject, $message);
    }
}

new AyamAPI();