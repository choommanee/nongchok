<?php
/**
 * Sample Data for Company Information
 */

if (!defined('ABSPATH')) {
    exit;
}

function ayam_create_sample_company_data() {
    // Company Info
    update_option('ayam_company_name', 'หนองจอก เอฟซีไอ');
    update_option('ayam_company_description', 'ผู้นำด้านการส่งออกไก่ชนไทยคุณภาพสูงสู่ตลาดโลก ด้วยประสบการณ์กว่า 20 ปี');
    update_option('ayam_company_vision', 'เป็นผู้นำระดับโลกในการส่งออกไก่ชนไทยคุณภาพสูง และเป็นสะพานเชื่อมวัฒนธรรมไทยสู่นานาชาติ');
    update_option('ayam_company_mission', 'พัฒนาและส่งเสริมการเลี้ยงไก่ชนไทยให้มีคุณภาพระดับมาตรฐานสากล สร้างเครือข่ายการค้าที่ยั่งยืน และอนุรักษ์วัฒนธรรมไก่ชนไทยให้คงอยู่สืบไป');
    
    // Timeline
    $timeline = array(
        array(
            'year' => '2004',
            'title' => 'ก่อตั้งบริษัท',
            'description' => 'เริ่มต้นธุรกิจการเลี้ยงและส่งออกไก่ชนไทย'
        ),
        array(
            'year' => '2008',
            'title' => 'ขยายตลาดสู่อินโดนีเซีย',
            'description' => 'เปิดตลาดส่งออกครั้งแรกสู่ประเทศอินโดนีเซีย'
        ),
        array(
            'year' => '2012',
            'title' => 'ได้รับใบรับรองมาตรฐาน',
            'description' => 'ได้รับใบรับรองมาตรฐานการส่งออกสัตว์จากกรมปศุสัตว์'
        ),
        array(
            'year' => '2016',
            'title' => 'ขยายฟาร์มการเลี้ยง',
            'description' => 'เปิดฟาร์มการเลี้ยงไก่ชนขนาดใหญ่ในจังหวัดนครปฐม'
        ),
        array(
            'year' => '2020',
            'title' => 'เปิดตัวเว็บไซต์',
            'description' => 'เปิดตัวเว็บไซต์เพื่อขยายช่องทางการติดต่อและการขาย'
        )
    );
    update_option('ayam_company_timeline', $timeline);
    
    // Awards
    $awards = array(
        array(
            'title' => 'รางวัลผู้ส่งออกดีเด่น',
            'year' => '2018',
            'description' => 'รางวัลจากกรมการค้าต่างประเทศ สำหรับผู้ส่งออกสัตว์ปีก',
            'image' => ''
        ),
        array(
            'title' => 'ใบรับรองมาตรฐาน ISO 9001',
            'year' => '2019',
            'description' => 'ใบรับรองระบบการจัดการคุณภาพมาตรฐานสากล',
            'image' => ''
        ),
        array(
            'title' => 'รางวัลเกษตรกรดีเด่น',
            'year' => '2021',
            'description' => 'รางวัลจากกระทรวงเกษตรและสหกรณ์',
            'image' => ''
        )
    );
    update_option('ayam_company_awards', $awards);
    
    // Team Members
    $team = array(
        array(
            'name' => 'นายสมชาย ใจดี',
            'position' => 'ผู้อำนวยการ',
            'bio' => 'ผู้เชี่ยวชาญด้านการเลี้ยงไก่ชนมากว่า 25 ปี',
            'image' => '',
            'email' => 'somchai@ayambangkok.com',
            'phone' => '081-234-5678'
        ),
        array(
            'name' => 'นางสาวมาลี รักษ์ดี',
            'position' => 'ผู้จัดการฝ่ายส่งออก',
            'bio' => 'ผู้เชี่ยวชาญด้านการส่งออกสัตว์ปีก',
            'image' => '',
            'email' => 'malee@ayambangkok.com',
            'phone' => '081-345-6789'
        ),
        array(
            'name' => 'นายวิชัย เก่งกาจ',
            'position' => 'หัวหน้าฟาร์ม',
            'bio' => 'ผู้ดูแลฟาร์มการเลี้ยงไก่ชนมืออาชีพ',
            'image' => '',
            'email' => 'wichai@ayambangkok.com',
            'phone' => '081-456-7890'
        )
    );
    update_option('ayam_team_members', $team);
    
    // Company Values
    $values = array(
        array(
            'title' => 'คุณภาพ',
            'description' => 'มุ่งมั่นในการผลิตและส่งมอบไก่ชนคุณภาพสูงที่ตรงตามมาตรฐานสากล',
            'icon' => 'fas fa-award'
        ),
        array(
            'title' => 'ความน่าเชื่อถือ',
            'description' => 'สร้างความไว้วางใจกับลูกค้าด้วยการให้บริการที่โปร่งใสและตรงเวลา',
            'icon' => 'fas fa-handshake'
        ),
        array(
            'title' => 'นวัตกรรม',
            'description' => 'พัฒนาเทคนิคการเลี้ยงและการจัดการอย่างต่อเนื่อง',
            'icon' => 'fas fa-lightbulb'
        ),
        array(
            'title' => 'ความยั่งยืน',
            'description' => 'ดำเนินธุรกิจโดยคำนึงถึงสิ่งแวดล้อมและชุมชน',
            'icon' => 'fas fa-leaf'
        )
    );
    update_option('ayam_company_values', $values);
}

// เรียกใช้ฟังก์ชันเมื่อเปิดใช้งานธีม
add_action('after_switch_theme', 'ayam_create_sample_company_data');