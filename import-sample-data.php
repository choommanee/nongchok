<?php
/**
 * Import Sample Data for Ayam Bangkok Website
 * Run this file once to populate the website with sample data
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    require_once('wp-config.php');
}

// Set execution time limit and memory limit
set_time_limit(300);
ini_set('memory_limit', '512M');

echo "<h1>🐓 Ayam Bangkok - Sample Data Import</h1>";
echo "<p>กำลังนำเข้าข้อมูลตัวอย่าง...</p>";

/**
 * Sample Rooster Data
 */
function create_sample_roosters() {
    echo "<h2>📦 กำลังสร้างข้อมูลไก่ชน...</h2>";
    
    $roosters_data = [
        [
            'title' => 'ไก่ชนไทยพื้นเมือง "เพชรดำ"',
            'content' => 'ไก่ชนไทยพื้นเมืองสายเลือดดี มีประวัติการแข่งขันที่ยอดเยี่ยม เป็นไก่ที่มีความแข็งแกร่งและทนทาน เหมาะสำหรับการส่งออกไปยังอินโดนีเซีย มีสีขนสีดำเข้มเป็นเอกลักษณ์ ขาแข็งแรง หงอนสวยงาม',
            'breed' => 'ไก่ชนไทยพื้นเมือง',
            'category' => 'พร้อมส่งออก',
            'price' => 15000,
            'age' => 18,
            'weight' => 2.8,
            'color' => 'ดำเข้ม',
            'fighting_record' => 'ชนะ 8 ครั้ง แพ้ 1 ครั้ง เสมอ 0 ครั้ง',
            'pedigree_father' => 'เพชรดำ มหาราช',
            'pedigree_mother' => 'นางฟ้า ดำเงา',
            'health_status' => 'สุขภาพดีเยี่ยม',
            'export_ready' => true,
            'image_url' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'ไก่ชนอีสาน "ทองแดง"',
            'content' => 'ไก่ชนสายพันธุ์อีสานแท้ มีความดุดันและแข็งแกร่ง สีขนทองแดงสวยงาม เป็นที่ต้องการของนักเลี้ยงไก่ชนในอินโดนีเซีย มีรูปร่างสมส่วน กล้ามเนื้อแน่น',
            'breed' => 'ไก่ชนอีสาน',
            'category' => 'พร้อมส่งออก',
            'price' => 12000,
            'age' => 16,
            'weight' => 2.6,
            'color' => 'ทองแดง',
            'fighting_record' => 'ชนะ 6 ครั้ง แพ้ 2 ครั้ง เสมอ 1 ครั้ง',
            'pedigree_father' => 'ทองแดง เจ้าพ่อ',
            'pedigree_mother' => 'นางทอง อีสาน',
            'health_status' => 'สุขภาพดี',
            'export_ready' => true,
            'image_url' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'American Gamefowl "Red Warrior"',
            'content' => 'ไก่ชนอเมริกันสายเลือดดี นำเข้าจากสหรัฐอเมริกา มีความแข็งแกร่งและความอดทนสูง เป็นที่นิยมในหมู่นักเลี้ยงไก่ชนระดับโลก สีแดงสด มีท่าทางดุดัน',
            'breed' => 'American Gamefowl',
            'category' => 'พร้อมส่งออก',
            'price' => 25000,
            'age' => 20,
            'weight' => 3.2,
            'color' => 'แดงสด',
            'fighting_record' => 'ชนะ 12 ครั้ง แพ้ 0 ครั้ง เสมอ 1 ครั้ง',
            'pedigree_father' => 'Red Champion USA',
            'pedigree_mother' => 'Golden Lady',
            'health_status' => 'สุขภาพดีเยี่ยม',
            'export_ready' => true,
            'image_url' => 'https://images.unsplash.com/photo-1612024056846-6eeaf2fdf2ba?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'ไก่ชนเหนือ "เงินเหลือง"',
            'content' => 'ไก่ชนภาคเหนือสายพันธุ์ดั้งเดิม มีความสวยงามและแข็งแรง สีขนเงินเหลืองเป็นเอกลักษณ์ เป็นไก่ที่มีความอดทนต่อสภาพอากาศ เหมาะสำหรับการเลี้ยงในทุกสภาพแวดล้อม',
            'breed' => 'ไก่ชนเหนือ',
            'category' => 'กำลังฝึก',
            'price' => 8000,
            'age' => 12,
            'weight' => 2.4,
            'color' => 'เงินเหลือง',
            'fighting_record' => 'ชนะ 3 ครั้ง แพ้ 1 ครั้ง เสมอ 0 ครั้ง',
            'pedigree_father' => 'เงินเหลือง ราชา',
            'pedigree_mother' => 'นางเงิน เหนือ',
            'health_status' => 'สุขภาพดี',
            'export_ready' => false,
            'image_url' => 'https://images.unsplash.com/photo-1606567595334-d39972c85dbe?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'Asil "Golden Prince"',
            'content' => 'ไก่ชน Asil สายพันธุ์อินเดีย มีความแข็งแกร่งและความอดทนสูงมาก เป็นไก่ที่มีประวัติศาสตร์ยาวนาน สีทองสวยงาม มีรูปร่างสง่างาม เป็นที่ต้องการของนักสะสม',
            'breed' => 'Asil',
            'category' => 'พ่อแม่พันธุ์',
            'price' => 35000,
            'age' => 24,
            'weight' => 3.5,
            'color' => 'ทองคำ',
            'fighting_record' => 'ชนะ 15 ครั้ง แพ้ 1 ครั้ง เสมอ 2 ครั้ง',
            'pedigree_father' => 'Asil King India',
            'pedigree_mother' => 'Golden Queen',
            'health_status' => 'สุขภาพดีเยี่ยม',
            'export_ready' => true,
            'image_url' => 'https://images.unsplash.com/photo-1551191023-b4389c7d4d4f?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'ไก่ชนกลาง "มรกต"',
            'content' => 'ไก่ชนภาคกลางสายเลือดดี มีสีขนเขียวมรกตสวยงาม เป็นไก่ที่มีความแข็งแกร่งและความคล่องตัวสูง เหมาะสำหรับการแข่งขันและการส่งออก มีท่าทางภูมิฐาน',
            'breed' => 'ไก่ชนกลาง',
            'category' => 'พร้อมส่งออก',
            'price' => 18000,
            'age' => 19,
            'weight' => 2.9,
            'color' => 'เขียวมรกต',
            'fighting_record' => 'ชนะ 9 ครั้ง แพ้ 2 ครั้ง เสมอ 0 ครั้ง',
            'pedigree_father' => 'มรกต เจ้าพ่อ',
            'pedigree_mother' => 'นางมรกต กลาง',
            'health_status' => 'สุขภาพดี',
            'export_ready' => true,
            'image_url' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=800&h=600&fit=crop'
        ]
    ];
    
    foreach ($roosters_data as $index => $rooster) {
        // Create post
        $post_data = [
            'post_title' => $rooster['title'],
            'post_content' => $rooster['content'],
            'post_status' => 'publish',
            'post_type' => 'ayam_rooster',
            'post_author' => 1
        ];
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Add custom fields
            update_post_meta($post_id, 'rooster_price', $rooster['price']);
            update_post_meta($post_id, 'rooster_age', $rooster['age']);
            update_post_meta($post_id, 'rooster_weight', $rooster['weight']);
            update_post_meta($post_id, 'rooster_color', $rooster['color']);
            update_post_meta($post_id, 'rooster_fighting_record', $rooster['fighting_record']);
            update_post_meta($post_id, 'rooster_pedigree_father', $rooster['pedigree_father']);
            update_post_meta($post_id, 'rooster_pedigree_mother', $rooster['pedigree_mother']);
            update_post_meta($post_id, 'rooster_health_status', $rooster['health_status']);
            update_post_meta($post_id, 'rooster_export_ready', $rooster['export_ready']);
            update_post_meta($post_id, 'rooster_status', 'available');
            update_post_meta($post_id, 'post_views_count', rand(50, 500));
            
            // Set breed taxonomy
            $breed_term = get_term_by('name', $rooster['breed'], 'rooster_breed');
            if (!$breed_term) {
                $breed_term = wp_insert_term($rooster['breed'], 'rooster_breed');
                $breed_term_id = $breed_term['term_id'];
            } else {
                $breed_term_id = $breed_term->term_id;
            }
            wp_set_post_terms($post_id, [$breed_term_id], 'rooster_breed');
            
            // Set category taxonomy
            $cat_term = get_term_by('name', $rooster['category'], 'rooster_category');
            if (!$cat_term) {
                $cat_term = wp_insert_term($rooster['category'], 'rooster_category');
                $cat_term_id = $cat_term['term_id'];
            } else {
                $cat_term_id = $cat_term->term_id;
            }
            wp_set_post_terms($post_id, [$cat_term_id], 'rooster_category');
            
            echo "✅ สร้างไก่ชน: {$rooster['title']}<br>";
        }
    }
}

/**
 * Sample News Data
 */
function create_sample_news() {
    echo "<h2>📰 กำลังสร้างข่าวสาร...</h2>";
    
    $news_data = [
        [
            'title' => 'Ayam Bangkok ส่งออกไก่ชนไปอินโดนีเซียสำเร็จ 500 ตัว',
            'content' => 'บริษัท หนองจอก เอฟซีไอ หรือ Ayam Bangkok ประสบความสำเร็จในการส่งออกไก่ชนคุณภาพสูงไปยังประเทศอินโดนีเซียจำนวน 500 ตัว ในเดือนที่ผ่านมา โดยไก่ชนที่ส่งออกเป็นสายพันธุ์ไทยพื้นเมืองและ American Gamefowl ที่ผ่านการคัดสรรอย่างดี

ทั้งนี้ การส่งออกครั้งนี้เป็นไปตามมาตรฐานสากลและได้รับการรับรองจากกรมปศุสัตว์ ไก่ชนทุกตัวผ่านการตรวจสุขภาพอย่างครบถ้วนและมีใบรับรองสุขภาพจากสัตวแพทย์

คุณสมชาย ผู้จัดการทั่วไป กล่าวว่า "เราภูมิใจที่สามารถส่งมอบไก่ชนคุณภาพสูงให้กับลูกค้าในอินโดนีเซีย และจะยังคงพัฒนาคุณภาพการบริการต่อไป"',
            'excerpt' => 'Ayam Bangkok ประสบความสำเร็จส่งออกไก่ชนคุณภาพสูง 500 ตัวไปอินโดนีเซีย พร้อมใบรับรองมาตรฐานสากล',
            'category' => 'ข่าวบริษัท',
            'image_url' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'เปิดตัวโครงการ "ไก่ชนไทยสู่โลก" ยกระดับมาตรฐานการส่งออก',
            'content' => 'Ayam Bangkok เปิดตัวโครงการ "ไก่ชนไทยสู่โลก" เพื่อยกระดับมาตรฐานการส่งออกไก่ชนไทยให้เป็นที่ยอมรับในระดับสากล โดยร่วมมือกับมหาวิทยาลัยเกษตรศาสตร์และกรมปศุสัตว์

โครงการนี้มุ่งเน้นการพัฒนาสายพันธุ์ไก่ชนไทยให้มีคุณภาพสูง การปรับปรุงระบบการเลี้ยงดู และการสร้างมาตรฐานการส่งออกที่เป็นสากล

ดร.วิชัย นักวิจัยจากมหาวิทยาลัยเกษตรศาสตร์ กล่าวว่า "โครงการนี้จะช่วยให้ไก่ชนไทยได้รับการยอมรับมากขึ้นในตลาดโลก และเป็นการอนุรักษ์พันธุ์ไก่ชนไทยไปในตัว"

คาดว่าโครงการจะแล้วเสร็จในปี 2025 และจะเป็นแนวทางสำหรับผู้ประกอบการรายอื่นๆ ในอุตสาหกรรมนี้',
            'excerpt' => 'เปิดตัวโครงการยกระดับมาตรฐานการส่งออกไก่ชนไทย ร่วมกับมหาวิทยาลัยเกษตรศาสตร์และกรมปศุสัตว์',
            'category' => 'โครงการพิเศษ',
            'image_url' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'การแข่งขันไก่ชนนานาชาติ 2024 Ayam Bangkok คว้า 3 รางวัล',
            'content' => 'ในการแข่งขันไก่ชนนานาชาติ Indonesia Gamefowl Championship 2024 ที่จัดขึ้นที่กรุงจาการ์ตา ไก่ชนจาก Ayam Bangkok สามารถคว้ารางวัลสำคัญมาได้ 3 รางวัล

รางวัลที่ได้รับ ได้แก่:
- รางวัลชนะเลิศ ประเภทไก่ชนไทยพื้นเมือง
- รางวัลรองชนะเลิศอันดับ 1 ประเภท American Gamefowl  
- รางวัลไก่ชนสวยงามที่สุด

การแข่งขันครั้งนี้มีผู้เข้าร่วมจาก 8 ประเทศ รวมกว่า 500 ตัว แสดงให้เห็นถึงคุณภาพของไก่ชนจาก Ayam Bangkok ที่ได้รับการยอมรับในระดับสากล

คุณประยุทธ์ หัวหน้าทีมฝึกไก่ชน กล่าวว่า "ความสำเร็จครั้งนี้เป็นผลมาจากการดูแลและฝึกฝนอย่างต่อเนื่อง รวมถึงการคัดเลือกไก่ชนคุณภาพสูง"',
            'excerpt' => 'ไก่ชนจาก Ayam Bangkok คว้า 3 รางวัลในการแข่งขันไก่ชนนานาชาติ 2024 ที่อินโดนีเซีย',
            'category' => 'รางวัลและความสำเร็จ',
            'image_url' => 'https://images.unsplash.com/photo-1612024056846-6eeaf2fdf2ba?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'เปิดศูนย์ฝึกอบรมไก่ชนแห่งใหม่ พร้อมเทคโนโลยีทันสมัย',
            'content' => 'Ayam Bangkok เปิดศูนย์ฝึกอบรมไก่ชนแห่งใหม่ที่จังหวัดนครปฐม พื้นที่กว่า 50 ไร่ พร้อมเทคโนโลยีการเลี้ยงดูที่ทันสมัย

ศูนย์แห่งนี้มีสิ่งอำนวยความสะดวกครบครัน ได้แก่:
- โรงเรือนเลี้ยงไก่ชนมาตรฐานสากล 20 หลัง
- ระบบควบคุมอุณหภูมิและความชื้นอัตโนมัติ
- สนามฝึกไก่ชนขนาดมาตรฐาน 5 สนาม
- ห้องปฏิบัติการตรวจสุขภาพ
- ห้องประชุมและห้องเรียนสำหรับอบรม

ศูนย์นี้จะเปิดให้บริการหลักสูตรการเลี้ยงไก่ชนสำหรับผู้สนใจทั่วไป และจะเป็นสถานที่ฝึกอบรมไก่ชนก่อนส่งออก

คุณสุรชัย ผู้อำนวยการศูนย์ฝึกอบรม กล่าวว่า "เราต้องการถ่ายทอดความรู้และประสบการณ์ให้กับคนรุ่นใหม่ เพื่อสืบทอดศิลปะการเลี้ยงไก่ชนไทย"',
            'excerpt' => 'เปิดศูนย์ฝึกอบรมไก่ชนแห่งใหม่ พื้นที่ 50 ไร่ พร้อมเทคโนโลジีทันสมัยและหลักสูตรครบครัน',
            'category' => 'ข่าวบริษัท',
            'image_url' => 'https://images.unsplash.com/photo-1606567595334-d39972c85dbe?w=800&h=600&fit=crop'
        ]
    ];
    
    foreach ($news_data as $news) {
        $post_data = [
            'post_title' => $news['title'],
            'post_content' => $news['content'],
            'post_excerpt' => $news['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'ayam_news',
            'post_author' => 1
        ];
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Set category
            $cat_term = get_term_by('name', $news['category'], 'news_category');
            if (!$cat_term) {
                $cat_term = wp_insert_term($news['category'], 'news_category');
                $cat_term_id = $cat_term['term_id'];
            } else {
                $cat_term_id = $cat_term->term_id;
            }
            wp_set_post_terms($post_id, [$cat_term_id], 'news_category');
            
            echo "✅ สร้างข่าว: {$news['title']}<br>";
        }
    }
}

/**
 * Sample Services Data
 */
function create_sample_services() {
    echo "<h2>🛠 กำลังสร้างบริการ...</h2>";
    
    $services_data = [
        [
            'title' => 'บริการส่งออกไก่ชนครบวงจร',
            'content' => 'เราให้บริการส่งออกไก่ชนแบบครบวงจร ตั้งแต่การคัดเลือกไก่ชนคุณภาพ การตรวจสุขภาพ การจัดเตรียมเอกสาร ไปจนถึงการขนส่งและส่งมอบ

บริการของเรารวมถึง:
- การคัดเลือกไก่ชนตามความต้องการของลูกค้า
- การตรวจสุขภาพโดยสัตวแพทย์ผู้เชี่ยวชาญ
- การจัดทำใบรับรองสุขภาพและเอกสารส่งออก
- การบรรจุภัณฑ์พิเศษสำหรับการขนส่ง
- การประสานงานกับหน่วยงานศุลกากร
- การติดตามการขนส่งตลอดเส้นทาง
- การประกันภัยสำหรับไก่ชน

ทีมงานของเรามีประสบการณ์กว่า 10 ปีในการส่งออกไก่ชน และมีเครือข่ายพันธมิตรที่แข็งแกร่งในอินโดนีเซีย',
            'price' => 2500,
            'duration' => '7-14 วัน',
            'service_type' => 'ส่งออก',
            'booking_available' => true,
            'category' => 'บริการหลัก',
            'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'บริการฝึกไก่ชนมืออาชีพ',
            'content' => 'บริการฝึกไก่ชนโดยผู้เชี่ยวชาญที่มีประสบการณ์กว่า 20 ปี เพื่อเตรียมความพร้อมสำหรับการแข่งขันและการส่งออก

โปรแกรมการฝึก:
- การประเมินศักยภาพของไก่ชน
- การวางแผนการฝึกเฉพาะตัว
- การฝึกความแข็งแกร่งและความคล่องตัว
- การฝึกเทคนิคการต่อสู้
- การดูแลโภชนาการและสุขภาพ
- การเตรียมตัวก่อนการแข่งขัน

ระยะเวลาการฝึก 3-6 เดือน ขึ้นอยู่กับสภาพและศักยภาพของไก่ชนแต่ละตัว มีการติดตามผลและรายงานความก้าวหน้าเป็นประจำ',
            'price' => 5000,
            'duration' => '3-6 เดือน',
            'service_type' => 'ฝึกไก่',
            'booking_available' => true,
            'category' => 'บริการฝึกอบรม',
            'image_url' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'บริการดูแลรักษาและสุขภาพ',
            'content' => 'บริการดูแลสุขภาพไก่ชนโดยสัตวแพทย์ผู้เชี่ยวชาญ พร้อมคลินิกสัตว์เลี้ยงที่ทันสมัย

บริการรวมถึง:
- การตรวจสุขภาพประจำ
- การฉีดวัคซีนป้องกันโรค
- การรักษาโรคและการบาดเจ็บ
- การผ่าตัดเมื่อจำเป็น
- การให้คำปรึกษาด้านโภชนาการ
- การตรวจเลือดและการวินิจฉัยโรค
- บริการฉุกเฉิน 24 ชั่วโมง

ทีมสัตวแพทย์ของเรามีความเชี่ยวชาญเฉพาะด้านไก่ชน และใช้อุปกรณ์การแพทย์ที่ทันสมัย เพื่อให้การรักษาที่มีประสิทธิภาพสูงสุด',
            'price' => 800,
            'duration' => '1-7 วัน',
            'service_type' => 'ดูแลรักษา',
            'booking_available' => true,
            'category' => 'บริการสุขภาพ',
            'image_url' => 'https://images.unsplash.com/photo-1551191023-b4389c7d4d4f?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'บริการคอนซัลติ้งและให้คำปรึกษา',
            'content' => 'บริการให้คำปรึกษาด้านการเลี้ยงไก่ชนโดยผู้เชี่ยวชาญ สำหรับผู้ที่ต้องการเริ่มต้นหรือพัฒนาการเลี้ยงไก่ชน

หัวข้อการปรึกษา:
- การเลือกพันธุ์ไก่ชนที่เหมาะสม
- การจัดสร้างโรงเรือนและสิ่งแวดล้อม
- การวางแผนการผสมพันธุ์
- การจัดการด้านโภชนาการ
- การป้องกันและรักษาโรค
- การเตรียมตัวสำหรับการแข่งขัน
- กลยุทธ์การตลาดและการขาย

มีทั้งการปรึกษาแบบออนไลน์และการเยื่ยมชมสถานที่จริง พร้อมรายงานและแผนการดำเนินงานที่ละเอียด',
            'price' => 1500,
            'duration' => '2-4 ชั่วโมง',
            'service_type' => 'คอนซัลติ้ง',
            'booking_available' => true,
            'category' => 'บริการปรึกษา',
            'image_url' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=800&h=600&fit=crop'
        ],
        [
            'title' => 'บริการผสมพันธุ์และพัฒนาสายเลือด',
            'content' => 'บริการผสมพันธุ์ไก่ชนเพื่อพัฒนาสายเลือดใหม่ที่มีคุณภาพสูง โดยใช้เทคโนโลยีการผสมพันธุ์ที่ทันสมัย

บริการรวมถึง:
- การวิเคราะห์พันธุกรรมของไก่พ่อแม่พันธุ์
- การวางแผนการผสมพันธุ์เพื่อได้ลูกที่มีคุณสมบัติตามต้องการ
- การดูแลไก่แม่พันธุ์ระหว่างตั้งไข่และฟักไข่
- การดูแลลูกไก่ตั้งแต่แรกเกิดจนโต
- การติดตามและประเมินผลการผสมพันธุ์
- การจดบันทึกพันธุ์วงศ์ตระกูล

เรามีไก่พ่อแม่พันธุ์คุณภาพสูงหลายสายพันธุ์ และสามารถสร้างสายเลือดใหม่ตามความต้องการของลูกค้า',
            'price' => 3000,
            'duration' => '6-12 เดือน',
            'service_type' => 'ผสมพันธุ์',
            'booking_available' => true,
            'category' => 'บริการพิเศษ',
            'image_url' => 'https://images.unsplash.com/photo-1606567595334-d39972c85dbe?w=800&h=600&fit=crop'
        ]
    ];
    
    foreach ($services_data as $service) {
        $post_data = [
            'post_title' => $service['title'],
            'post_content' => $service['content'],
            'post_status' => 'publish',
            'post_type' => 'ayam_service',
            'post_author' => 1
        ];
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Add custom fields
            update_post_meta($post_id, 'service_price', $service['price']);
            update_post_meta($post_id, 'service_duration', $service['duration']);
            update_post_meta($post_id, 'service_type', $service['service_type']);
            update_post_meta($post_id, 'booking_available', $service['booking_available']);
            
            // Set category
            $cat_term = get_term_by('name', $service['category'], 'service_category');
            if (!$cat_term) {
                $cat_term = wp_insert_term($service['category'], 'service_category');
                $cat_term_id = $cat_term['term_id'];
            } else {
                $cat_term_id = $cat_term->term_id;
            }
            wp_set_post_terms($post_id, [$cat_term_id], 'service_category');
            
            echo "✅ สร้างบริการ: {$service['title']}<br>";
        }
    }
}

/**
 * Sample Slider Data
 */
function create_sample_slider_data() {
    echo "<h2>🖼 กำลังสร้างข้อมูล Slider...</h2>";
    
    $slider_data = [
        [
            'slide_title' => 'ยินดีต้อนรับสู่ Ayam Bangkok',
            'slide_description' => 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย',
            'slide_button_text' => 'ดูไก่ชนของเรา',
            'slide_button_url' => home_url('/roosters/'),
            'slide_button_style' => 'primary',
            'slide_text_position' => 'center',
            'slide_image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=1920&h=1080&fit=crop'
        ],
        [
            'slide_title' => 'ไก่ชนคุณภาพสูง พร้อมส่งออก',
            'slide_description' => 'ไก่ชนสายพันธุ์ดีที่ผ่านการคัดสรรอย่างดี พร้อมใบรับรองมาตรฐานสากล',
            'slide_button_text' => 'ดูรายละเอียด',
            'slide_button_url' => home_url('/about/'),
            'slide_button_style' => 'secondary',
            'slide_text_position' => 'left',
            'slide_image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=1920&h=1080&fit=crop'
        ],
        [
            'slide_title' => 'บริการครบวงจร ประสบการณ์กว่า 10 ปี',
            'slide_description' => 'ตั้งแต่การเลือกไก่ชน การดูแลรักษา ไปจนถึงการส่งมอบ เราดูแลทุกขั้นตอน',
            'slide_button_text' => 'ติดต่อเรา',
            'slide_button_url' => home_url('/contact/'),
            'slide_button_style' => 'primary',
            'slide_text_position' => 'right',
            'slide_image' => 'https://images.unsplash.com/photo-1612024056846-6eeaf2fdf2ba?w=1920&h=1080&fit=crop'
        ]
    ];
    
    // Update slider options (use WordPress options if ACF not available)
    if (function_exists('update_field')) {
        update_field('slider_images', $slider_data, 'option');
        update_field('slider_autoplay', true, 'option');
        update_field('slider_autoplay_speed', 5000, 'option');
        update_field('slider_show_navigation', true, 'option');
        update_field('slider_show_pagination', true, 'option');
        update_field('slider_effect', 'fade', 'option');
        update_field('slider_loop', true, 'option');
        update_field('slider_height', '100vh', 'option');
        
        // Update welcome section
        update_field('welcome_enable', true, 'option');
        update_field('welcome_title', 'ยินดีต้อนรับสู่ Ayam Bangkok', 'option');
        update_field('welcome_description', 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย พร้อมบริการครบวงจรและประสบการณ์กว่า 10 ปี', 'option');
        update_field('welcome_background_color', 'gradient', 'option');
    } else {
        // Fallback to WordPress options
        update_option('ayam_slider_images', json_encode($slider_data));
        update_option('ayam_slider_autoplay', 1);
        update_option('ayam_slider_autoplay_speed', 5000);
        update_option('ayam_slider_show_navigation', 1);
        update_option('ayam_slider_show_pagination', 1);
        update_option('ayam_slider_effect', 'fade');
        update_option('ayam_slider_loop', 1);
        update_option('ayam_slider_height', '100vh');
        
        // Welcome section fallback
        update_option('ayam_welcome_enable', 1);
        update_option('ayam_welcome_title', 'ยินดีต้อนรับสู่ Ayam Bangkok');
        update_option('ayam_welcome_description', 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย พร้อมบริการครบวงจรและประสบการณ์กว่า 10 ปี');
        update_option('ayam_welcome_background_color', 'gradient');
    }
    
    echo "✅ สร้างข้อมูล Slider และ Welcome Section<br>";
}

/**
 * Sample Company Data
 */
function create_sample_company_data() {
    echo "<h2>🏢 กำลังสร้างข้อมูลบริษัท...</h2>";
    
    // Company basic info
    update_option('ayam_phone', '02-123-4567');
    update_option('ayam_email', 'info@ayambangkok.com');
    update_option('ayam_line_id', '@ayambangkok');
    update_option('ayam_facebook', 'https://facebook.com/ayambangkok');
    update_option('ayam_youtube', 'https://youtube.com/ayambangkok');
    
    // Company detailed info
    // Company detailed info (with ACF fallback)
    if (function_exists('update_field')) {
        update_field('company_name', 'หนองจอก เอฟซีไอ (Ayam Bangkok)', 'option');
        update_field('company_description', 'บริษัทผู้นำด้านการส่งออกไก่ชนไปยังประเทศอินโดนีเซีย ด้วยประสบการณ์กว่า 10 ปี และเป็นตัวแทนอย่างเป็นทางการรายเดียวของประเทศไทย', 'option');
        update_field('company_vision', 'เป็นผู้นำระดับโลกในการส่งออกไก่ชนคุณภาพสูง และเป็นสะพานเชื่อมวัฒนธรรมไก่ชนระหว่างไทยและอินโดนีเซีย', 'option');
        update_field('company_mission', 'มุ่งมั่นส่งมอบไก่ชนคุณภาพสูงสุด ด้วยบริการที่เป็นเลิศ และสร้างความพึงพอใจสูงสุดให้กับลูกค้า พร้อมทั้งอนุรักษ์และพัฒนาพันธุ์ไก่ชนไทยให้เป็นที่ยอมรับในระดับสากล', 'option');
    } else {
        // Fallback to WordPress options
        update_option('ayam_company_name', 'หนองจอก เอฟซีไอ (Ayam Bangkok)');
        update_option('ayam_company_description', 'บริษัทผู้นำด้านการส่งออกไก่ชนไปยังประเทศอินโดนีเซีย ด้วยประสบการณ์กว่า 10 ปี และเป็นตัวแทนอย่างเป็นทางการรายเดียวของประเทศไทย');
        update_option('ayam_company_vision', 'เป็นผู้นำระดับโลกในการส่งออกไก่ชนคุณภาพสูง และเป็นสะพานเชื่อมวัฒนธรรมไก่ชนระหว่างไทยและอินโดนีเซีย');
        update_option('ayam_company_mission', 'มุ่งมั่นส่งมอบไก่ชนคุณภาพสูงสุด ด้วยบริการที่เป็นเลิศ และสร้างความพึงพอใจสูงสุดให้กับลูกค้า พร้อมทั้งอนุรักษ์และพัฒนาพันธุ์ไก่ชนไทยให้เป็นที่ยอมรับในระดับสากล');
    }
    
    // Timeline data
    $timeline_data = [
        [
            'year' => '2014',
            'title' => 'ก่อตั้งบริษัท',
            'description' => 'เริ่มต้นธุรกิจส่งออกไก่ชนไปยังอินโดนีเซีย',
            'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=400&h=300&fit=crop'
        ],
        [
            'year' => '2016',
            'title' => 'ได้รับการรับรองเป็นตัวแทนอย่างเป็นทางการ',
            'description' => 'ได้รับการรับรองจากรัฐบาลไทยให้เป็นตัวแทนส่งออกไก่ชนรายเดียว',
            'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=400&h=300&fit=crop'
        ],
        [
            'year' => '2018',
            'title' => 'ขยายธุรกิจและเปิดศูนย์ฝึกอบรม',
            'description' => 'เปิดศูนย์ฝึกอบรมไก่ชนและขยายกำลังการผลิต',
            'image' => 'https://images.unsplash.com/photo-1612024056846-6eeaf2fdf2ba?w=400&h=300&fit=crop'
        ],
        [
            'year' => '2020',
            'title' => 'รางวัลผู้ส่งออกดีเด่น',
            'description' => 'ได้รับรางวัลผู้ส่งออกดีเด่นจากกระทรวงพาณิชย์',
            'image' => 'https://images.unsplash.com/photo-1606567595334-d39972c85dbe?w=400&h=300&fit=crop'
        ],
        [
            'year' => '2024',
            'title' => 'ครบรอบ 10 ปี และเปิดตัวเว็บไซต์ใหม่',
            'description' => 'ฉลองครบรอบ 10 ปี พร้อมเปิดตัวเว็บไซต์และระบบออนไลน์ใหม่',
            'image' => 'https://images.unsplash.com/photo-1551191023-b4389c7d4d4f?w=400&h=300&fit=crop'
        ]
    ];
    
    // Timeline data (with ACF fallback)
    if (function_exists('update_field')) {
        update_field('timeline_items', $timeline_data, 'option');
    } else {
        update_option('ayam_timeline_items', json_encode($timeline_data));
    }
    
    // Awards data
    $awards_data = [
        [
            'title' => 'รางวัลผู้ส่งออกดีเด่น ประจำปี 2023',
            'year' => '2023',
            'description' => 'รางวัลจากกระทรวงพาณิชย์ สำหรับผู้ส่งออกสินค้าเกษตรดีเด่น',
            'image' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400&h=300&fit=crop'
        ],
        [
            'title' => 'รางวัลชนะเลิศการแข่งขันไก่ชนนานาชาติ',
            'year' => '2024',
            'description' => 'รางวัลชนะเลิศจากการแข่งขัน Indonesia Gamefowl Championship',
            'image' => 'https://images.unsplash.com/photo-1612024056846-6eeaf2fdf2ba?w=400&h=300&fit=crop'
        ],
        [
            'title' => 'ใบรับรอง ISO 9001:2015',
            'year' => '2022',
            'description' => 'ได้รับการรับรองมาตรฐานการจัดการคุณภาพระดับสากล',
            'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?w=400&h=300&fit=crop'
        ]
    ];
    
    // Awards data (with ACF fallback)
    if (function_exists('update_field')) {
        update_field('awards_items', $awards_data, 'option');
    } else {
        update_option('ayam_awards_items', json_encode($awards_data));
    }
    
    // Team members data
    $team_data = [
        [
            'name' => 'คุณสมชาย วงศ์ไก่ชน',
            'position' => 'ผู้จัดการทั่วไป',
            'description' => 'ประสบการณ์ด้านไก่ชนกว่า 25 ปี ผู้เชี่ยวชาญด้านการส่งออกและการจัดการธุรกิจ',
            'email' => 'somchai@ayambangkok.com',
            'phone' => '081-234-5678',
            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop'
        ],
        [
            'name' => 'ดร.วิชัย สุขใส',
            'position' => 'หัวหน้าสัตวแพทย์',
            'description' => 'สัตวแพทย์ผู้เชี่ยวชาญด้านไก่ชน จบการศึกษาจากมหาวิทยาลัยเกษตรศาสตร์',
            'email' => 'wichai@ayambangkok.com',
            'phone' => '081-345-6789',
            'image' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&h=400&fit=crop'
        ],
        [
            'name' => 'คุณประยุทธ์ ชนะเลิศ',
            'position' => 'หัวหน้าทีมฝึกไก่ชน',
            'description' => 'ผู้เชี่ยวชาญด้านการฝึกไก่ชน มีประสบการณ์การแข่งขันระดับนานาชาติ',
            'email' => 'prayuth@ayambangkok.com',
            'phone' => '081-456-7890',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop'
        ],
        [
            'name' => 'คุณสุรชัย เก่งกาจ',
            'position' => 'ผู้อำนวยการศูนย์ฝึกอบรม',
            'description' => 'ผู้เชี่ยวชาญด้านการอบรมและพัฒนาบุคลากร มีประสบการณ์การสอนกว่า 15 ปี',
            'email' => 'surachai@ayambangkok.com',
            'phone' => '081-567-8901',
            'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop'
        ]
    ];
    
    // Team members data (with ACF fallback)
    if (function_exists('update_field')) {
        update_field('team_members', $team_data, 'option');
    } else {
        update_option('ayam_team_members', json_encode($team_data));
    }
    
    echo "✅ สร้างข้อมูลบริษัท Timeline Awards และทีมงาน<br>";
}

// Run the import
echo "<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background: #f5f5f5; }
h1 { color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px; }
h2 { color: #34495e; margin-top: 30px; }
p { color: #7f8c8d; }
</style>";

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('คุณไม่มีสิทธิ์ในการเรียกใช้ไฟล์นี้');
}

echo "<p><strong>เริ่มต้นการนำเข้าข้อมูล...</strong></p>";

// Create sample data
create_sample_roosters();
create_sample_news();
create_sample_services();
create_sample_slider_data();
create_sample_company_data();

echo "<h2>🎉 เสร็จสิ้นการนำเข้าข้อมูล!</h2>";
echo "<p>ข้อมูลตัวอย่างทั้งหมดได้ถูกนำเข้าเรียบร้อยแล้ว</p>";
echo "<p><a href='" . home_url() . "' style='background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>ดูเว็บไซต์</a></p>";
echo "<p><a href='" . admin_url() . "' style='background: #2ecc71; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-left: 10px;'>ไปที่ Admin</a></p>";
?>