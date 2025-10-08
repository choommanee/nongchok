<?php
/**
 * Database Management for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamDatabase {
    
    /**
     * Create custom database tables
     */
    public static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Bookings table
        $bookings_table = $wpdb->prefix . 'ayam_bookings';
        $bookings_sql = "CREATE TABLE $bookings_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            service_id int(11) NOT NULL,
            booking_date datetime NOT NULL,
            booking_time varchar(20) DEFAULT NULL,
            customer_name varchar(255) NOT NULL,
            customer_email varchar(255) NOT NULL,
            customer_phone varchar(50) DEFAULT NULL,
            customer_line varchar(100) DEFAULT NULL,
            service_type varchar(100) DEFAULT NULL,
            special_requests text DEFAULT NULL,
            status varchar(50) DEFAULT 'pending',
            admin_notes text DEFAULT NULL,
            total_amount decimal(10,2) DEFAULT 0.00,
            payment_status varchar(50) DEFAULT 'unpaid',
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY service_id (service_id),
            KEY status (status),
            KEY booking_date (booking_date)
        ) $charset_collate;";
        
        // Inquiries table
        $inquiries_table = $wpdb->prefix . 'ayam_inquiries';
        $inquiries_sql = "CREATE TABLE $inquiries_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) DEFAULT NULL,
            rooster_id int(11) DEFAULT NULL,
            customer_name varchar(255) NOT NULL,
            customer_email varchar(255) NOT NULL,
            customer_phone varchar(50) DEFAULT NULL,
            customer_line varchar(100) DEFAULT NULL,
            inquiry_type varchar(100) DEFAULT 'general',
            subject varchar(255) NOT NULL,
            message text NOT NULL,
            preferred_contact varchar(50) DEFAULT 'email',
            status varchar(50) DEFAULT 'new',
            priority varchar(20) DEFAULT 'normal',
            assigned_to int(11) DEFAULT NULL,
            response text DEFAULT NULL,
            response_date datetime DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY rooster_id (rooster_id),
            KEY status (status),
            KEY inquiry_type (inquiry_type),
            KEY assigned_to (assigned_to)
        ) $charset_collate;";
        
        // Export records table
        $export_records_table = $wpdb->prefix . 'ayam_export_records';
        $export_records_sql = "CREATE TABLE $export_records_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            rooster_id int(11) NOT NULL,
            customer_id int(11) DEFAULT NULL,
            customer_name varchar(255) NOT NULL,
            customer_company varchar(255) DEFAULT NULL,
            export_date date NOT NULL,
            destination_country varchar(100) NOT NULL,
            destination_city varchar(100) DEFAULT NULL,
            export_method varchar(100) DEFAULT 'air',
            tracking_number varchar(100) DEFAULT NULL,
            export_documents text DEFAULT NULL,
            health_certificate varchar(255) DEFAULT NULL,
            customs_declaration varchar(255) DEFAULT NULL,
            total_cost decimal(10,2) DEFAULT 0.00,
            status varchar(50) DEFAULT 'preparing',
            notes text DEFAULT NULL,
            created_by int(11) DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY rooster_id (rooster_id),
            KEY customer_id (customer_id),
            KEY export_date (export_date),
            KEY destination_country (destination_country),
            KEY status (status)
        ) $charset_collate;";
        
        // Rooster gallery table
        $gallery_table = $wpdb->prefix . 'ayam_rooster_gallery';
        $gallery_sql = "CREATE TABLE $gallery_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            rooster_id int(11) NOT NULL,
            media_id int(11) NOT NULL,
            media_type varchar(20) DEFAULT 'image',
            title varchar(255) DEFAULT NULL,
            description text DEFAULT NULL,
            sort_order int(11) DEFAULT 0,
            is_featured tinyint(1) DEFAULT 0,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY rooster_id (rooster_id),
            KEY media_id (media_id),
            KEY media_type (media_type),
            KEY sort_order (sort_order)
        ) $charset_collate;";
        
        // User preferences table
        $preferences_table = $wpdb->prefix . 'ayam_user_preferences';
        $preferences_sql = "CREATE TABLE $preferences_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            preferred_breeds text DEFAULT NULL,
            price_range_min decimal(10,2) DEFAULT NULL,
            price_range_max decimal(10,2) DEFAULT NULL,
            notification_email tinyint(1) DEFAULT 1,
            notification_sms tinyint(1) DEFAULT 0,
            notification_line tinyint(1) DEFAULT 0,
            newsletter_subscription tinyint(1) DEFAULT 1,
            language_preference varchar(10) DEFAULT 'th',
            timezone varchar(50) DEFAULT 'Asia/Bangkok',
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY user_id (user_id)
        ) $charset_collate;";
        
        // Activity log table
        $activity_log_table = $wpdb->prefix . 'ayam_activity_log';
        $activity_log_sql = "CREATE TABLE $activity_log_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) DEFAULT NULL,
            action varchar(100) NOT NULL,
            object_type varchar(50) DEFAULT NULL,
            object_id int(11) DEFAULT NULL,
            description text DEFAULT NULL,
            ip_address varchar(45) DEFAULT NULL,
            user_agent text DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY action (action),
            KEY object_type (object_type),
            KEY object_id (object_id),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        // Rooster health records table
        $health_records_table = $wpdb->prefix . 'ayam_health_records';
        $health_records_sql = "CREATE TABLE $health_records_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            rooster_id int(11) NOT NULL,
            record_date date NOT NULL,
            record_type varchar(50) NOT NULL,
            veterinarian varchar(255) DEFAULT NULL,
            diagnosis text DEFAULT NULL,
            treatment text DEFAULT NULL,
            medication text DEFAULT NULL,
            notes text DEFAULT NULL,
            next_checkup date DEFAULT NULL,
            cost decimal(10,2) DEFAULT 0.00,
            status varchar(50) DEFAULT 'active',
            created_by int(11) DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY rooster_id (rooster_id),
            KEY record_date (record_date),
            KEY record_type (record_type),
            KEY status (status)
        ) $charset_collate;";
        
        // Training records table
        $training_records_table = $wpdb->prefix . 'ayam_training_records';
        $training_records_sql = "CREATE TABLE $training_records_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            rooster_id int(11) NOT NULL,
            training_date date NOT NULL,
            training_type varchar(100) NOT NULL,
            trainer varchar(255) DEFAULT NULL,
            duration_minutes int(11) DEFAULT NULL,
            intensity varchar(50) DEFAULT NULL,
            performance_score int(11) DEFAULT NULL,
            notes text DEFAULT NULL,
            weather_conditions varchar(100) DEFAULT NULL,
            created_by int(11) DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY rooster_id (rooster_id),
            KEY training_date (training_date),
            KEY training_type (training_type),
            KEY performance_score (performance_score)
        ) $charset_collate;";
        
        // Fighting records table
        $fighting_records_table = $wpdb->prefix . 'ayam_fighting_records';
        $fighting_records_sql = "CREATE TABLE $fighting_records_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            rooster_id int(11) NOT NULL,
            fight_date date NOT NULL,
            opponent_info text DEFAULT NULL,
            location varchar(255) DEFAULT NULL,
            result varchar(50) NOT NULL,
            fight_duration varchar(50) DEFAULT NULL,
            performance_notes text DEFAULT NULL,
            injuries text DEFAULT NULL,
            prize_money decimal(10,2) DEFAULT 0.00,
            video_url varchar(500) DEFAULT NULL,
            created_by int(11) DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY rooster_id (rooster_id),
            KEY fight_date (fight_date),
            KEY result (result)
        ) $charset_collate;";
        
        // Customer profiles table
        $customer_profiles_table = $wpdb->prefix . 'ayam_customer_profiles';
        $customer_profiles_sql = "CREATE TABLE $customer_profiles_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) DEFAULT NULL,
            customer_type varchar(50) DEFAULT 'individual',
            company_name varchar(255) DEFAULT NULL,
            tax_id varchar(50) DEFAULT NULL,
            contact_person varchar(255) DEFAULT NULL,
            phone varchar(50) DEFAULT NULL,
            line_id varchar(100) DEFAULT NULL,
            email varchar(255) DEFAULT NULL,
            address text DEFAULT NULL,
            city varchar(100) DEFAULT NULL,
            province varchar(100) DEFAULT NULL,
            postal_code varchar(20) DEFAULT NULL,
            country varchar(100) DEFAULT 'Thailand',
            preferred_contact varchar(50) DEFAULT 'phone',
            credit_limit decimal(15,2) DEFAULT 0.00,
            payment_terms varchar(100) DEFAULT NULL,
            notes text DEFAULT NULL,
            status varchar(50) DEFAULT 'active',
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY user_id (user_id),
            KEY customer_type (customer_type),
            KEY status (status),
            KEY email (email)
        ) $charset_collate;";
        
        // Export documentation table
        $export_docs_table = $wpdb->prefix . 'ayam_export_documents';
        $export_docs_sql = "CREATE TABLE $export_docs_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            export_record_id int(11) NOT NULL,
            document_type varchar(100) NOT NULL,
            document_number varchar(100) DEFAULT NULL,
            issued_by varchar(255) DEFAULT NULL,
            issue_date date DEFAULT NULL,
            expiry_date date DEFAULT NULL,
            file_path varchar(500) DEFAULT NULL,
            file_size int(11) DEFAULT NULL,
            mime_type varchar(100) DEFAULT NULL,
            status varchar(50) DEFAULT 'valid',
            notes text DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY export_record_id (export_record_id),
            KEY document_type (document_type),
            KEY status (status),
            KEY expiry_date (expiry_date)
        ) $charset_collate;";
        
        // Notifications table
        $notifications_table = $wpdb->prefix . 'ayam_notifications';
        $notifications_sql = "CREATE TABLE $notifications_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            type varchar(50) NOT NULL,
            title varchar(255) NOT NULL,
            message text NOT NULL,
            action_url varchar(500) DEFAULT NULL,
            is_read tinyint(1) DEFAULT 0,
            priority varchar(20) DEFAULT 'normal',
            expires_at datetime DEFAULT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            read_at datetime DEFAULT NULL,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY type (type),
            KEY is_read (is_read),
            KEY priority (priority),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        // Settings table
        $settings_table = $wpdb->prefix . 'ayam_settings';
        $settings_sql = "CREATE TABLE $settings_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            setting_key varchar(100) NOT NULL,
            setting_value longtext DEFAULT NULL,
            setting_type varchar(50) DEFAULT 'string',
            category varchar(100) DEFAULT 'general',
            description text DEFAULT NULL,
            is_autoload tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY setting_key (setting_key),
            KEY category (category),
            KEY is_autoload (is_autoload)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        dbDelta($bookings_sql);
        dbDelta($inquiries_sql);
        dbDelta($export_records_sql);
        dbDelta($gallery_sql);
        dbDelta($preferences_sql);
        dbDelta($activity_log_sql);
        dbDelta($health_records_sql);
        dbDelta($training_records_sql);
        dbDelta($fighting_records_sql);
        dbDelta($customer_profiles_sql);
        dbDelta($export_docs_sql);
        dbDelta($notifications_sql);
        dbDelta($settings_sql);
        
        // Insert default data
        self::insert_default_data();
        
        // Insert default settings
        self::insert_default_settings();
    }
    
    /**
     * Insert default data
     */
    private static function insert_default_data() {
        // Insert default rooster breeds
        $breeds = array(
            'ไก่ชนไทยพื้นเมือง' => 'Thai Native Fighting Cock',
            'ไก่ชนอีสาน' => 'Northeastern Thai Fighting Cock',
            'ไก่ชนเหนือ' => 'Northern Thai Fighting Cock',
            'ไก่ชนกลาง' => 'Central Thai Fighting Cock',
            'ไก่ชนใต้' => 'Southern Thai Fighting Cock',
            'American Gamefowl' => 'American Gamefowl',
            'Asil' => 'Asil',
            'Shamo' => 'Shamo',
            'Malay' => 'Malay',
            'ลูกผสมพิเศษ' => 'Special Crossbreed'
        );
        
        foreach ($breeds as $thai_name => $english_name) {
            if (!term_exists($thai_name, 'rooster_breed')) {
                wp_insert_term($thai_name, 'rooster_breed', array(
                    'description' => $english_name
                ));
            }
        }
        
        // Insert default rooster categories
        $categories = array(
            'พร้อมส่งออก' => 'Ready for Export',
            'กำลังฝึก' => 'In Training',
            'พ่อแม่พันธุ์' => 'Breeding Stock',
            'ไก่หนุ่ม' => 'Young Roosters'
        );
        
        foreach ($categories as $thai_name => $english_name) {
            if (!term_exists($thai_name, 'rooster_category')) {
                wp_insert_term($thai_name, 'rooster_category', array(
                    'description' => $english_name
                ));
            }
        }
        
        // Insert default service categories
        $service_categories = array(
            'บริการฝึกไก่' => 'Rooster Training Services',
            'บริการดูแลรักษา' => 'Healthcare Services',
            'คอนซัลติ้ง' => 'Consulting Services',
            'ผสมพันธุ์' => 'Breeding Services'
        );
        
        foreach ($service_categories as $thai_name => $english_name) {
            if (!term_exists($thai_name, 'service_category')) {
                wp_insert_term($thai_name, 'service_category', array(
                    'description' => $english_name
                ));
            }
        }
        
        // Insert default knowledge categories
        $knowledge_categories = array(
            'การเลี้ยงดู' => 'Raising and Care',
            'โภชนาการ' => 'Nutrition',
            'การฝึกซ้อม' => 'Training',
            'โรคและการรักษา' => 'Diseases and Treatment',
            'การผสมพันธุ์' => 'Breeding',
            'เทคนิคการแข่งขัน' => 'Competition Techniques'
        );
        
        foreach ($knowledge_categories as $thai_name => $english_name) {
            if (!term_exists($thai_name, 'knowledge_category')) {
                wp_insert_term($thai_name, 'knowledge_category', array(
                    'description' => $english_name
                ));
            }
        }
    }
    
    /**
     * Insert default settings
     */
    private static function insert_default_settings() {
        global $wpdb;
        
        $settings_table = $wpdb->prefix . 'ayam_settings';
        
        $default_settings = array(
            array(
                'setting_key' => 'company_name_th',
                'setting_value' => 'หนองจอก เอฟซีไอ',
                'category' => 'company',
                'description' => 'ชื่อบริษัทภาษาไทย'
            ),
            array(
                'setting_key' => 'company_name_en',
                'setting_value' => 'Nongchok FCI',
                'category' => 'company',
                'description' => 'ชื่อบริษัทภาษาอังกฤษ'
            ),
            array(
                'setting_key' => 'export_license_number',
                'setting_value' => 'EXP-TH-001-2024',
                'category' => 'export',
                'description' => 'หมายเลขใบอนุญาตส่งออก'
            ),
            array(
                'setting_key' => 'quarantine_period_days',
                'setting_value' => '21',
                'setting_type' => 'integer',
                'category' => 'export',
                'description' => 'ระยะเวลากักกันก่อนส่งออก (วัน)'
            ),
            array(
                'setting_key' => 'health_check_validity_days',
                'setting_value' => '7',
                'setting_type' => 'integer',
                'category' => 'health',
                'description' => 'ระยะเวลาใช้ได้ของใบรับรองสุขภาพ (วัน)'
            ),
            array(
                'setting_key' => 'notification_email_admin',
                'setting_value' => 'admin@ayambangkok.com',
                'category' => 'notifications',
                'description' => 'อีเมลผู้ดูแลระบบสำหรับการแจ้งเตือน'
            ),
            array(
                'setting_key' => 'booking_advance_days',
                'setting_value' => '3',
                'setting_type' => 'integer',
                'category' => 'booking',
                'description' => 'จำนวนวันล่วงหน้าสำหรับการจอง'
            ),
            array(
                'setting_key' => 'currency_symbol',
                'setting_value' => '฿',
                'category' => 'general',
                'description' => 'สัญลักษณ์สกุลเงิน'
            ),
            array(
                'setting_key' => 'timezone',
                'setting_value' => 'Asia/Bangkok',
                'category' => 'general',
                'description' => 'เขตเวลา'
            ),
            array(
                'setting_key' => 'rooster_min_age_export',
                'setting_value' => '6',
                'setting_type' => 'integer',
                'category' => 'export',
                'description' => 'อายุขั้นต่ำของไก่ชนที่สามารถส่งออกได้ (เดือน)'
            )
        );
        
        foreach ($default_settings as $setting) {
            // Check if setting already exists
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $settings_table WHERE setting_key = %s",
                $setting['setting_key']
            ));
            
            if (!$exists) {
                $wpdb->insert($settings_table, $setting);
            }
        }
    }
    
    /**
     * Drop custom tables
     */
    public static function drop_tables() {
        global $wpdb;
        
        $tables = array(
            $wpdb->prefix . 'ayam_bookings',
            $wpdb->prefix . 'ayam_inquiries',
            $wpdb->prefix . 'ayam_export_records',
            $wpdb->prefix . 'ayam_rooster_gallery',
            $wpdb->prefix . 'ayam_user_preferences',
            $wpdb->prefix . 'ayam_activity_log',
            $wpdb->prefix . 'ayam_health_records',
            $wpdb->prefix . 'ayam_training_records',
            $wpdb->prefix . 'ayam_fighting_records',
            $wpdb->prefix . 'ayam_customer_profiles',
            $wpdb->prefix . 'ayam_export_documents',
            $wpdb->prefix . 'ayam_notifications',
            $wpdb->prefix . 'ayam_settings'
        );
        
        foreach ($tables as $table) {
            $wpdb->query("DROP TABLE IF EXISTS $table");
        }
    }
}