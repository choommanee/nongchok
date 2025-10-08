<?php
/**
 * Database Helper Functions for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamDBHelpers {
    
    /**
     * Get setting value
     */
    public static function get_setting($key, $default = null) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_settings';
        $value = $wpdb->get_var($wpdb->prepare(
            "SELECT setting_value FROM $table WHERE setting_key = %s",
            $key
        ));
        
        return $value !== null ? $value : $default;
    }
    
    /**
     * Update setting value
     */
    public static function update_setting($key, $value, $type = 'string', $category = 'general') {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_settings';
        
        // Check if setting exists
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE setting_key = %s",
            $key
        ));
        
        if ($exists) {
            return $wpdb->update(
                $table,
                array(
                    'setting_value' => $value,
                    'setting_type' => $type,
                    'updated_at' => current_time('mysql')
                ),
                array('setting_key' => $key)
            );
        } else {
            return $wpdb->insert(
                $table,
                array(
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'setting_type' => $type,
                    'category' => $category
                )
            );
        }
    }
    
    /**
     * Add health record
     */
    public static function add_health_record($rooster_id, $data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_health_records';
        
        $defaults = array(
            'rooster_id' => $rooster_id,
            'record_date' => current_time('Y-m-d'),
            'status' => 'active',
            'created_by' => get_current_user_id()
        );
        
        $data = wp_parse_args($data, $defaults);
        
        return $wpdb->insert($table, $data);
    }
    
    /**
     * Get health records for rooster
     */
    public static function get_health_records($rooster_id, $limit = 10) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_health_records';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE rooster_id = %d ORDER BY record_date DESC LIMIT %d",
            $rooster_id,
            $limit
        ));
    }
    
    /**
     * Add training record
     */
    public static function add_training_record($rooster_id, $data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_training_records';
        
        $defaults = array(
            'rooster_id' => $rooster_id,
            'training_date' => current_time('Y-m-d'),
            'created_by' => get_current_user_id()
        );
        
        $data = wp_parse_args($data, $defaults);
        
        return $wpdb->insert($table, $data);
    }
    
    /**
     * Get training records for rooster
     */
    public static function get_training_records($rooster_id, $limit = 10) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_training_records';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE rooster_id = %d ORDER BY training_date DESC LIMIT %d",
            $rooster_id,
            $limit
        ));
    }
    
    /**
     * Add fighting record
     */
    public static function add_fighting_record($rooster_id, $data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_fighting_records';
        
        $defaults = array(
            'rooster_id' => $rooster_id,
            'fight_date' => current_time('Y-m-d'),
            'created_by' => get_current_user_id()
        );
        
        $data = wp_parse_args($data, $defaults);
        
        $result = $wpdb->insert($table, $data);
        
        if ($result) {
            // Update rooster fighting statistics
            self::update_rooster_fighting_stats($rooster_id);
        }
        
        return $result;
    }
    
    /**
     * Get fighting records for rooster
     */
    public static function get_fighting_records($rooster_id, $limit = 10) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_fighting_records';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE rooster_id = %d ORDER BY fight_date DESC LIMIT %d",
            $rooster_id,
            $limit
        ));
    }
    
    /**
     * Update rooster fighting statistics
     */
    public static function update_rooster_fighting_stats($rooster_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_fighting_records';
        
        // Get fight statistics
        $stats = $wpdb->get_row($wpdb->prepare(
            "SELECT 
                COUNT(*) as total_fights,
                SUM(CASE WHEN result = 'win' THEN 1 ELSE 0 END) as wins,
                SUM(CASE WHEN result = 'loss' THEN 1 ELSE 0 END) as losses,
                SUM(CASE WHEN result = 'draw' THEN 1 ELSE 0 END) as draws,
                SUM(prize_money) as total_prize_money
            FROM $table 
            WHERE rooster_id = %d",
            $rooster_id
        ));
        
        if ($stats) {
            // Update post meta
            update_post_meta($rooster_id, 'rooster_wins', $stats->wins);
            update_post_meta($rooster_id, 'rooster_losses', $stats->losses);
            update_post_meta($rooster_id, 'rooster_draws', $stats->draws);
            update_post_meta($rooster_id, 'rooster_total_fights', $stats->total_fights);
            update_post_meta($rooster_id, 'rooster_total_prize_money', $stats->total_prize_money);
            
            // Calculate win rate
            if ($stats->total_fights > 0) {
                $win_rate = round(($stats->wins / $stats->total_fights) * 100, 2);
                update_post_meta($rooster_id, 'rooster_win_rate', $win_rate);
            }
        }
    }
    
    /**
     * Create customer profile
     */
    public static function create_customer_profile($user_id, $data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_customer_profiles';
        
        $defaults = array(
            'user_id' => $user_id,
            'customer_type' => 'individual',
            'country' => 'Thailand',
            'preferred_contact' => 'phone',
            'status' => 'active'
        );
        
        $data = wp_parse_args($data, $defaults);
        
        return $wpdb->insert($table, $data);
    }
    
    /**
     * Get customer profile
     */
    public static function get_customer_profile($user_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_customer_profiles';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE user_id = %d",
            $user_id
        ));
    }
    
    /**
     * Add notification
     */
    public static function add_notification($user_id, $type, $title, $message, $action_url = null, $priority = 'normal') {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_notifications';
        
        return $wpdb->insert($table, array(
            'user_id' => $user_id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $action_url,
            'priority' => $priority
        ));
    }
    
    /**
     * Get unread notifications for user
     */
    public static function get_unread_notifications($user_id, $limit = 10) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_notifications';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table 
            WHERE user_id = %d AND is_read = 0 
            AND (expires_at IS NULL OR expires_at > NOW())
            ORDER BY priority DESC, created_at DESC 
            LIMIT %d",
            $user_id,
            $limit
        ));
    }
    
    /**
     * Mark notification as read
     */
    public static function mark_notification_read($notification_id, $user_id = null) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_notifications';
        
        $where = array('id' => $notification_id);
        if ($user_id) {
            $where['user_id'] = $user_id;
        }
        
        return $wpdb->update(
            $table,
            array(
                'is_read' => 1,
                'read_at' => current_time('mysql')
            ),
            $where
        );
    }
    
    /**
     * Get export documents
     */
    public static function get_export_documents($export_record_id) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_export_documents';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE export_record_id = %d ORDER BY document_type",
            $export_record_id
        ));
    }
    
    /**
     * Add export document
     */
    public static function add_export_document($export_record_id, $data) {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_export_documents';
        
        $defaults = array(
            'export_record_id' => $export_record_id,
            'status' => 'valid'
        );
        
        $data = wp_parse_args($data, $defaults);
        
        return $wpdb->insert($table, $data);
    }
    
    /**
     * Get dashboard statistics
     */
    public static function get_dashboard_stats() {
        global $wpdb;
        
        $stats = array();
        
        // Total roosters
        $stats['total_roosters'] = $wpdb->get_var(
            "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'ayam_rooster' AND post_status = 'publish'"
        );
        
        // Available roosters
        $stats['available_roosters'] = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->posts} p 
            INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id 
            WHERE p.post_type = 'ayam_rooster' 
            AND p.post_status = 'publish' 
            AND pm.meta_key = 'rooster_status' 
            AND pm.meta_value = %s",
            'available'
        ));
        
        // Pending bookings
        $bookings_table = $wpdb->prefix . 'ayam_bookings';
        $stats['pending_bookings'] = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $bookings_table WHERE status = %s",
            'pending'
        ));
        
        // Unread inquiries
        $inquiries_table = $wpdb->prefix . 'ayam_inquiries';
        $stats['unread_inquiries'] = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $inquiries_table WHERE status = %s",
            'new'
        ));
        
        // This month's exports
        $export_table = $wpdb->prefix . 'ayam_export_records';
        $stats['monthly_exports'] = $wpdb->get_var(
            "SELECT COUNT(*) FROM $export_table 
            WHERE YEAR(export_date) = YEAR(CURDATE()) 
            AND MONTH(export_date) = MONTH(CURDATE())"
        );
        
        return $stats;
    }
    
    /**
     * Clean up expired notifications
     */
    public static function cleanup_expired_notifications() {
        global $wpdb;
        
        $table = $wpdb->prefix . 'ayam_notifications';
        
        return $wpdb->query(
            "DELETE FROM $table WHERE expires_at IS NOT NULL AND expires_at < NOW()"
        );
    }
}