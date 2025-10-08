<?php
/**
 * About Page Database Management for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamAboutDatabase {
    
    /**
     * Create About page related database tables
     */
    public static function create_about_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Company Information table
        $company_info_table = $wpdb->prefix . 'ayam_company_info';
        $company_info_sql = "CREATE TABLE $company_info_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            field_key varchar(100) NOT NULL,
            field_value_th longtext DEFAULT NULL,
            field_value_en longtext DEFAULT NULL,
            field_type varchar(50) DEFAULT 'text',
            category varchar(100) DEFAULT 'general',
            sort_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY field_key (field_key),
            KEY category (category),
            KEY is_active (is_active)
        ) $charset_collate;";
        
        // Company Timeline table
        $timeline_table = $wpdb->prefix . 'ayam_company_timeline';
        $timeline_sql = "CREATE TABLE $timeline_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            year varchar(10) NOT NULL,
            title_th varchar(255) NOT NULL,
            title_en varchar(255) DEFAULT NULL,
            description_th text NOT NULL,
            description_en text DEFAULT NULL,
            image_url varchar(500) DEFAULT NULL,
            icon varchar(100) DEFAULT NULL,
            sort_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY year (year),
            KEY sort_order (sort_order),
            KEY is_active (is_active)
        ) $charset_collate;";
        
        // Company Awards table
        $awards_table = $wpdb->prefix . 'ayam_company_awards';
        $awards_sql = "CREATE TABLE $awards_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            title_th varchar(255) NOT NULL,
            title_en varchar(255) DEFAULT NULL,
            year varchar(10) NOT NULL,
            description_th text NOT NULL,
            description_en text DEFAULT NULL,
            image_url varchar(500) DEFAULT NULL,
            issuer_th varchar(255) DEFAULT NULL,
            issuer_en varchar(255) DEFAULT NULL,
            certificate_url varchar(500) DEFAULT NULL,
            sort_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY year (year),
            KEY sort_order (sort_order),
            KEY is_active (is_active)
        ) $charset_collate;";
        
        // Team Members table
        $team_table = $wpdb->prefix . 'ayam_team_members';
        $team_sql = "CREATE TABLE $team_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            name_th varchar(255) NOT NULL,
            name_en varchar(255) DEFAULT NULL,
            position_th varchar(255) NOT NULL,
            position_en varchar(255) DEFAULT NULL,
            description_th text DEFAULT NULL,
            description_en text DEFAULT NULL,
            image_url varchar(500) DEFAULT NULL,
            email varchar(255) DEFAULT NULL,
            phone varchar(50) DEFAULT NULL,
            linkedin_url varchar(500) DEFAULT NULL,
            facebook_url varchar(500) DEFAULT NULL,
            twitter_url varchar(500) DEFAULT NULL,
            experience_years int(11) DEFAULT NULL,
            specialties text DEFAULT NULL,
            sort_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY sort_order (sort_order),
            KEY is_active (is_active)
        ) $charset_collate;";
        
        // Company Values table
        $values_table = $wpdb->prefix . 'ayam_company_values';
        $values_sql = "CREATE TABLE $values_table (
            id int(11) NOT NULL AUTO_INCREMENT,
            title_th varchar(255) NOT NULL,
            title_en varchar(255) DEFAULT NULL,
            description_th text NOT NULL,
            description_en text DEFAULT NULL,
            icon varchar(100) DEFAULT NULL,
            color varchar(20) DEFAULT NULL,
            sort_order int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY sort_order (sort_order),
            KEY is_active (is_active)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        dbDelta($company_info_sql);
        dbDelta($timeline_sql);
        dbDelta($awards_sql);
        dbDelta($team_sql);
        dbDelta($values_sql);
        
        // Insert default data
        self::insert_default_about_data();
    }
    
    /**
     * Insert default data for About page
     */
    private static function insert_default_about_data() {
        global $wpdb;
        
        // Insert default company information
        $company_info_table = $wpdb->prefix . 'ayam_company_info';
        
        $default_company_info = array(
            array(
                'field_key' => 'company_name',
                'field_value_th' => 'หนองจอก เอฟซีไอ',
                'field_value_en' => 'Nongchok FCI',
                'field_type' => 'text',
                'category' => 'basic'
            ),
            array(
                'field_key' => 'company_description',
                'field_value_th' => 'ผู้นำด้านการส่งออกไก่ชนคุณภาพสูงจากประเทศไทยสู่ตลาดโลก ด้วยประสบการณ์กว่า 20 ปี',
                'field_value_en' => 'Leading exporter of high-quality fighting roosters from Thailand to global markets with over 20 years of experience',
                'field_type' => 'textarea',
                'category' => 'basic'
            ),
            array(
                'field_key' => 'vision',
                'field_value_th' => 'เป็นผู้นำระดับโลกในการส่งออกไก่ชนคุณภาพสูง พร้อมสร้างมาตรฐานใหม่ในอุตสาหกรรม',
                'field_value_en' => 'To be the world leader in exporting high-quality fighting roosters while setting new industry standards',
                'field_type' => 'textarea',
                'category' => 'vision_mission'
            ),
            array(
                'field_key' => 'mission',
                'field_value_th' => 'มุ่งมั่นส่งมอบไก่ชนคุณภาพเยี่ยมพร้อมบริการที่เป็นเลิศ เพื่อความพึงพอใจสูงสุดของลูกค้า',
                'field_value_en' => 'Committed to delivering excellent quality fighting roosters with outstanding service for maximum customer satisfaction',
                'field_type' => 'textarea',
                'category' => 'vision_mission'
            )
        );
        
        foreach ($default_company_info as $info) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $company_info_table WHERE field_key = %s",
                $info['field_key']
            ));
            
            if (!$exists) {
                $wpdb->insert($company_info_table, $info);
            }
        }
        
        // Insert default timeline data
        $timeline_table = $wpdb->prefix . 'ayam_company_timeline';
        
        $default_timeline = array(
            array(
                'year' => '2004',
                'title_th' => 'ก่อตั้งบริษัท',
                'title_en' => 'Company Establishment',
                'description_th' => 'เริ่มต้นธุรกิจการเลี้ยงและส่งออกไก่ชนด้วยฟาร์มขนาดเล็ก',
                'description_en' => 'Started rooster breeding and export business with a small farm',
                'icon' => 'fas fa-seedling',
                'sort_order' => 1
            ),
            array(
                'year' => '2008',
                'title_th' => 'ขยายธุรกิจ',
                'title_en' => 'Business Expansion',
                'description_th' => 'ขยายฟาร์มและเริ่มส่งออกไปยังประเทศเพื่อนบ้าน',
                'description_en' => 'Expanded farm operations and began exporting to neighboring countries',
                'icon' => 'fas fa-chart-line',
                'sort_order' => 2
            ),
            array(
                'year' => '2012',
                'title_th' => 'ได้รับใบรับรองมาตรฐาน',
                'title_en' => 'Quality Certification',
                'description_th' => 'ได้รับใบรับรองมาตรฐานการส่งออกจากกรมปศุสัตว์',
                'description_en' => 'Received export quality certification from Department of Livestock',
                'icon' => 'fas fa-certificate',
                'sort_order' => 3
            ),
            array(
                'year' => '2016',
                'title_th' => 'เข้าสู่ตลาดโลก',
                'title_en' => 'Global Market Entry',
                'description_th' => 'เริ่มส่งออกไปยังตลาดในเอเชียและยุโรป',
                'description_en' => 'Started exporting to Asian and European markets',
                'icon' => 'fas fa-globe',
                'sort_order' => 4
            ),
            array(
                'year' => '2020',
                'title_th' => 'นวัตกรรมดิจิทัล',
                'title_en' => 'Digital Innovation',
                'description_th' => 'พัฒนาระบบออนไลน์สำหรับการจัดการและติดตาม',
                'description_en' => 'Developed online systems for management and tracking',
                'icon' => 'fas fa-laptop',
                'sort_order' => 5
            ),
            array(
                'year' => '2024',
                'title_th' => 'ผู้นำตลาด',
                'title_en' => 'Market Leader',
                'description_th' => 'กิจการเติบโตเป็นผู้นำในการส่งออกไก่ชนจากประเทศไทย',
                'description_en' => 'Became the leading rooster exporter from Thailand',
                'icon' => 'fas fa-trophy',
                'sort_order' => 6
            )
        );
        
        foreach ($default_timeline as $timeline) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $timeline_table WHERE year = %s AND title_th = %s",
                $timeline['year'], $timeline['title_th']
            ));
            
            if (!$exists) {
                $wpdb->insert($timeline_table, $timeline);
            }
        }
        
        // Insert default awards data
        $awards_table = $wpdb->prefix . 'ayam_company_awards';
        
        $default_awards = array(
            array(
                'title_th' => 'รางวัลผู้ส่งออกดีเด่น',
                'title_en' => 'Outstanding Exporter Award',
                'year' => '2023',
                'description_th' => 'รางวัลจากกรมการค้าต่างประเทศ กระทรวงพาณิชย์',
                'description_en' => 'Award from Department of Foreign Trade, Ministry of Commerce',
                'issuer_th' => 'กรมการค้าต่างประเทศ',
                'issuer_en' => 'Department of Foreign Trade',
                'sort_order' => 1
            ),
            array(
                'title_th' => 'ใบรับรองมาตรฐาน ISO',
                'title_en' => 'ISO Standard Certification',
                'year' => '2022',
                'description_th' => 'มาตรฐานการจัดการคุณภาพระดับสากล ISO 9001:2015',
                'description_en' => 'International Quality Management Standard ISO 9001:2015',
                'issuer_th' => 'องค์กรรับรองมาตรฐานสากล',
                'issuer_en' => 'International Certification Body',
                'sort_order' => 2
            ),
            array(
                'title_th' => 'รางวัลพันธมิตรทางการค้าดีเด่น',
                'title_en' => 'Outstanding Trade Partner Award',
                'year' => '2021',
                'description_th' => 'รางวัลจากสถานเอกอัครราชทูตอินโดนีเซียประจำประเทศไทย',
                'description_en' => 'Award from Embassy of Indonesia in Thailand',
                'issuer_th' => 'สถานเอกอัครราชทูตอินโดนีเซีย',
                'issuer_en' => 'Embassy of Indonesia',
                'sort_order' => 3
            )
        );
        
        foreach ($default_awards as $award) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $awards_table WHERE title_th = %s AND year = %s",
                $award['title_th'], $award['year']
            ));
            
            if (!$exists) {
                $wpdb->insert($awards_table, $award);
            }
        }
        
        // Insert default team members
        $team_table = $wpdb->prefix . 'ayam_team_members';
        
        $default_team = array(
            array(
                'name_th' => 'คุณสมชาย ใจดี',
                'name_en' => 'Mr. Somchai Jaidee',
                'position_th' => 'ผู้อำนวยการ',
                'position_en' => 'Managing Director',
                'description_th' => 'ประสบการณ์กว่า 20 ปีในธุรกิจการส่งออกไก่ชน ผู้เชี่ยวชาญด้านการจัดการฟาร์มและการตลาดระหว่างประเทศ',
                'description_en' => 'Over 20 years of experience in rooster export business, expert in farm management and international marketing',
                'experience_years' => 20,
                'specialties' => 'การจัดการฟาร์ม, การตลาดระหว่างประเทศ, การพัฒนาธุรกิจ',
                'sort_order' => 1
            ),
            array(
                'name_th' => 'คุณสมหญิง รักษ์ดี',
                'name_en' => 'Ms. Somying Rakdee',
                'position_th' => 'ผู้จัดการฝ่ายขาย',
                'position_en' => 'Sales Manager',
                'description_th' => 'เชี่ยวชาญด้านการขายและการบริการลูกค้าระหว่างประเทศ มีความสามารถในการสื่อสารหลายภาษา',
                'description_en' => 'Expert in international sales and customer service with multilingual communication skills',
                'experience_years' => 15,
                'specialties' => 'การขายระหว่างประเทศ, การบริการลูกค้า, การสื่อสารหลายภาษา',
                'sort_order' => 2
            ),
            array(
                'name_th' => 'คุณสมศักดิ์ เก่งมาก',
                'name_en' => 'Mr. Somsak Kengmak',
                'position_th' => 'ผู้เชี่ยวชาญด้านไก่ชน',
                'position_en' => 'Rooster Specialist',
                'description_th' => 'ความรู้เชิงลึกเกี่ยวกับการเลี้ยง การฝึก และการดูแลสุขภาพไก่ชน รวมถึงการคัดเลือกพันธุ์',
                'description_en' => 'Deep knowledge in rooster breeding, training, and health care, including breed selection',
                'experience_years' => 18,
                'specialties' => 'การเลี้ยงไก่ชน, การฝึกซ้อม, การดูแลสุขภาพ, การคัดเลือกพันธุ์',
                'sort_order' => 3
            ),
            array(
                'name_th' => 'คุณสมปอง ช่วยดี',
                'name_en' => 'Mr. Sompong Chuaydee',
                'position_th' => 'ผู้จัดการฝ่ายส่งออก',
                'position_en' => 'Export Manager',
                'description_th' => 'ผู้เชี่ยวชาญด้านขั้นตอนการส่งออก เอกสารศุลกากร และกฎระเบียบระหว่างประเทศ',
                'description_en' => 'Expert in export procedures, customs documentation, and international regulations',
                'experience_years' => 12,
                'specialties' => 'ขั้นตอนการส่งออก, เอกสารศุลกากร, กฎระเบียบระหว่างประเทศ',
                'sort_order' => 4
            )
        );
        
        foreach ($default_team as $member) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $team_table WHERE name_th = %s",
                $member['name_th']
            ));
            
            if (!$exists) {
                $wpdb->insert($team_table, $member);
            }
        }
        
        // Insert default company values
        $values_table = $wpdb->prefix . 'ayam_company_values';
        
        $default_values = array(
            array(
                'title_th' => 'ความใส่ใจ',
                'title_en' => 'Care & Attention',
                'description_th' => 'ใส่ใจในทุกรายละเอียดของการดูแลไก่ชนและบริการลูกค้า เพื่อให้ได้ผลลัพธ์ที่ดีที่สุด',
                'description_en' => 'Attention to every detail in rooster care and customer service to achieve the best results',
                'icon' => 'fas fa-heart',
                'color' => '#e74c3c',
                'sort_order' => 1
            ),
            array(
                'title_th' => 'ความน่าเชื่อถือ',
                'title_en' => 'Reliability',
                'description_th' => 'สร้างความเชื่อมั่นด้วยคุณภาพและการบริการที่สม่ำเสมอ ตรงตามคำมั่นสัญญา',
                'description_en' => 'Building trust through consistent quality and service that meets our promises',
                'icon' => 'fas fa-shield-alt',
                'color' => '#3498db',
                'sort_order' => 2
            ),
            array(
                'title_th' => 'นวัตกรรม',
                'title_en' => 'Innovation',
                'description_th' => 'พัฒนาและปรับปรุงวิธีการทำงานอย่างต่อเนื่อง เพื่อให้ได้ผลลัพธ์ที่ดีขึ้น',
                'description_en' => 'Continuously developing and improving our methods to achieve better results',
                'icon' => 'fas fa-lightbulb',
                'color' => '#f39c12',
                'sort_order' => 3
            ),
            array(
                'title_th' => 'ความซื่อสัตย์',
                'title_en' => 'Integrity',
                'description_th' => 'ดำเนินธุรกิจด้วยความโปร่งใส เป็นธรรม และยึดมั่นในหลักจริยธรรม',
                'description_en' => 'Conducting business with transparency, fairness, and strong ethical principles',
                'icon' => 'fas fa-handshake',
                'color' => '#27ae60',
                'sort_order' => 4
            )
        );
        
        foreach ($default_values as $value) {
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM $values_table WHERE title_th = %s",
                $value['title_th']
            ));
            
            if (!$exists) {
                $wpdb->insert($values_table, $value);
            }
        }
    }
    
    /**
     * Drop About page related tables
     */
    public static function drop_about_tables() {
        global $wpdb;
        
        $tables = array(
            $wpdb->prefix . 'ayam_company_info',
            $wpdb->prefix . 'ayam_company_timeline',
            $wpdb->prefix . 'ayam_company_awards',
            $wpdb->prefix . 'ayam_team_members',
            $wpdb->prefix . 'ayam_company_values'
        );
        
        foreach ($tables as $table) {
            $wpdb->query("DROP TABLE IF EXISTS $table");
        }
    }
}