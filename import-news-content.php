<?php
/**
 * Import New News Content
 * สคริปต์สำหรับเพิ่มข่าวสารใหม่เกี่ยวกับการส่งออก Ayam Bangkok
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Admin only.');
}

echo "<h1>Import News Content - Ayam Bangkok</h1>";
echo "<p>กำลังเพิ่มข่าวสารใหม่...</p>";

// ลบข่าวเก่าทั้งหมด (ถ้าต้องการ)
$delete_old = isset($_GET['delete_old']) && $_GET['delete_old'] == '1';

if ($delete_old) {
    echo "<h2>ลบข่าวเก่า...</h2>";
    $old_news = get_posts(array(
        'post_type' => 'ayam_news',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));
    
    foreach ($old_news as $news) {
        wp_delete_post($news->ID, true);
        echo "✓ ลบข่าว: {$news->post_title}<br>";
    }
    echo "<p><strong>ลบข่าวเก่าเรียบร้อย: " . count($old_news) . " รายการ</strong></p>";
}

// สร้าง/ตรวจสอบ Categories
echo "<h2>สร้าง Categories...</h2>";

$categories = array(
    'news-export' => array(
        'name' => 'ข่าวส่งออก',
        'description' => 'ข่าวเกี่ยวกับการส่งออกไก่ชน Ayam Bangkok'
    ),
    'news-success' => array(
        'name' => 'ความสำเร็จ',
        'description' => 'ข่าวความสำเร็จและผลงาน'
    ),
    'news-media' => array(
        'name' => 'สื่อมวลชน',
        'description' => 'ข่าวจากสื่อมวลชน'
    ),
    'news-activity' => array(
        'name' => 'กิจกรรม',
        'description' => 'ข่าวกิจกรรมต่างๆ'
    )
);

$created_categories = array();

foreach ($categories as $slug => $cat_data) {
    $term = term_exists($cat_data['name'], 'news_category');
    
    if (!$term) {
        $term = wp_insert_term(
            $cat_data['name'],
            'news_category',
            array(
                'slug' => $slug,
                'description' => $cat_data['description']
            )
        );
        echo "✓ สร้าง category: {$cat_data['name']}<br>";
    } else {
        echo "✓ Category มีอยู่แล้ว: {$cat_data['name']}<br>";
    }
    
    $created_categories[$slug] = is_array($term) ? $term['term_id'] : $term;
}

// ข่าวที่จะเพิ่ม
echo "<h2>เพิ่มข่าวสาร...</h2>";

$news_data = array(
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย มูลค่า 4 ล้านบาท',
        'content' => '<p>บริษัท หนองจอก เอฟซีไอ ประสบความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปยังประเทศอินโดนีเซีย มูลค่ารวมกว่า 4 ล้านบาท ในครั้งนี้</p>

<p>การส่งออกครั้งนี้เป็นการส่งออกไก่ชนคุณภาพสูงที่ผ่านการคัดเลือกอย่างเข้มงวด โดยมีการตรวจสอบสุขภาพและคุณภาพจากสัตวแพทย์ผู้เชี่ยวชาญ พร้อมทั้งมีเอกสารครบถ้วนตามมาตรฐานสากล</p>

<h3>รายละเอียดการส่งออก</h3>
<ul>
<li>จำนวนไก่ชนที่ส่งออก: 500 ตัว</li>
<li>มูลค่ารวม: 4,000,000 บาท</li>
<li>ปลายทาง: จาการ์ตา, อินโดนีเซีย</li>
<li>ระยะเวลาการขนส่ง: 2 วัน</li>
</ul>

<h3>ความสำคัญของการส่งออกครั้งนี้</h3>
<p>การส่งออกครั้งนี้แสดงให้เห็นถึงศักยภาพของไก่พื้นเมืองไทยในตลาดสากล และเป็นการเปิดโอกาสให้เกษตรกรไทยสามารถขยายตลาดไปยังต่างประเทศได้มากขึ้น</p>

<p>นอกจากนี้ยังเป็นการสร้างรายได้ให้กับประเทศและส่งเสริมภาพลักษณ์ของไก่ไทยในเวทีโลก</p>',
        'excerpt' => 'บริษัท หนองจอก เอฟซีไอ ประสบความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปยังประเทศอินโดนีเซีย มูลค่ารวมกว่า 4 ล้านบาท',
        'categories' => array('news-export', 'news-success'),
        'highlight' => true,
        'external_link' => 'https://www.khaosod.co.th/business/news_8234567',
        'date' => '2024-01-15'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก Ayam Bangkok ไทยแลนด์สู่อินโดนีเซีย',
        'content' => '<p>กรมปศุสัตว์แสดงความยินดีกับความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปยังประเทศอินโดนีเซีย โดยเป็นการส่งออกที่ได้รับการสนับสนุนจากภาครัฐอย่างเต็มที่</p>

<h3>การสนับสนุนจากภาครัฐ</h3>
<p>กรมปศุสัตว์ได้ให้การสนับสนุนในหลายด้าน ได้แก่:</p>
<ul>
<li>การตรวจสอบและรับรองคุณภาพไก่ชน</li>
<li>การออกใบรับรองสุขภาพสัตว์</li>
<li>การอำนวยความสะดวกในการส่งออก</li>
<li>การประสานงานกับหน่วยงานอินโดนีเซีย</li>
</ul>

<h3>แผนการส่งออกในอนาคต</h3>
<p>กรมปศุสัตว์มีแผนที่จะส่งเสริมการส่งออกไก่พื้นเมืองไทยไปยังประเทศอื่นๆ เพิ่มเติม เช่น มาเลเซีย สิงคโปร์ และประเทศในตะวันออกกลาง</p>

<p>ทั้งนี้ได้มีการจัดตั้งศูนย์ส่งเสริมการส่งออกไก่พื้นเมืองไทยขึ้น เพื่อเป็นศูนย์กลางในการให้คำปรึกษาและสนับสนุนผู้ประกอบการ</p>',
        'excerpt' => 'กรมปศุสัตว์แสดงความยินดีกับความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" พร้อมสนับสนุนการขยายตลาดต่อเนื่อง',
        'categories' => array('news-media', 'news-export'),
        'highlight' => false,
        'external_link' => 'https://www.prachachat.net/economy/news-567890',
        'date' => '2024-01-18'
    ),
    array(
        'title' => 'ไก่ไทยสู่อินโดนีเซีย เปิดตลาดใหม่มูลค่าหลักร้อยล้าน',
        'content' => '<p>การส่งออกไก่พื้นเมืองไทยไปยังอินโดนีเซียไม่เพียงแต่เป็นการสร้างรายได้ให้กับผู้ประกอบการเท่านั้น แต่ยังเป็นการเปิดตลาดใหม่ที่มีมูลค่าหลักร้อยล้านบาทต่อปี</p>

<h3>ศักยภาพของตลาดอินโดนีเซีย</h3>
<p>อินโดนีเซียเป็นตลาดที่มีศักยภาพสูงสำหรับไก่พื้นเมืองไทย เนื่องจาก:</p>
<ul>
<li>ประชากรมากกว่า 270 ล้านคน</li>
<li>วัฒนธรรมการเลี้ยงไก่ชนที่แพร่หลาย</li>
<li>ความต้องการไก่คุณภาพสูงเพิ่มขึ้น</li>
<li>กำลังซื้อที่เพิ่มขึ้นอย่างต่อเนื่อง</li>
</ul>

<h3>ความได้เปรียบของไก่ไทย</h3>
<p>ไก่พื้นเมืองไทยมีจุดเด่นหลายประการที่ทำให้เป็นที่ต้องการในตลาดอินโดนีเซีย:</p>
<ul>
<li>คุณภาพดีเยี่ยม มีสายพันธุ์ที่หลากหลาย</li>
<li>ราคาแข่งขันได้</li>
<li>มีใบรับรองมาตรฐานครบถ้วน</li>
<li>ระยะทางการขนส่งใกล้</li>
</ul>',
        'excerpt' => 'การส่งออกไก่พื้นเมืองไทยไปอินโดนีเซียเปิดตลาดใหม่มูลค่าหลักร้อยล้านบาทต่อปี พร้อมศักยภาพเติบโตสูง',
        'categories' => array('news-export', 'news-success'),
        'highlight' => false,
        'external_link' => 'https://www.banmuang.co.th/news/economy/234567',
        'date' => '2024-01-20'
    ),
    array(
        'title' => 'เกษตรกรไทยยิ้ม! ไก่พื้นเมืองราคาดีหลังเปิดตลาดส่งออก',
        'content' => '<p>เกษตรกรผู้เลี้ยงไก่พื้นเมืองในหลายจังหวัดแสดงความยินดีหลังจากมีการเปิดตลาดส่งออกไปยังอินโดนีเซีย ทำให้ราคาไก่พื้นเมืองปรับตัวสูงขึ้นและมีความมั่นคงมากขึ้น</p>

<h3>ผลกระทบต่อเกษตรกร</h3>
<p>การเปิดตลาดส่งออกส่งผลดีต่อเกษตรกรในหลายด้าน:</p>
<ul>
<li>ราคาไก่พื้นเมืองสูงขึ้น 20-30%</li>
<li>มีตลาดรองรับที่แน่นอน</li>
<li>สามารถวางแผนการผลิตได้ดีขึ้น</li>
<li>รายได้เพิ่มขึ้นอย่างมีนัยสำคัญ</li>
</ul>

<h3>คำแนะนำสำหรับเกษตรกร</h3>
<p>เกษตรกรที่สนใจส่งออกไก่พื้นเมืองควรเตรียมความพร้อมดังนี้:</p>
<ul>
<li>ปรับปรุงมาตรฐานฟาร์มให้ได้มาตรฐาน</li>
<li>ศึกษาข้อกำหนดการส่งออก</li>
<li>ติดต่อผู้ประกอบการส่งออกที่เชื่อถือได้</li>
<li>เข้าร่วมโครงการฝึกอบรมจากภาครัฐ</li>
</ul>',
        'excerpt' => 'เกษตรกรผู้เลี้ยงไก่พื้นเมืองยิ้มแย้มหลังเปิดตลาดส่งออก ราคาปรับตัวสูงขึ้น 20-30% พร้อมตลาดรองรับที่แน่นอน',
        'categories' => array('news-success'),
        'highlight' => false,
        'external_link' => '',
        'date' => '2024-01-25'
    ),
    array(
        'title' => 'Ayam Bangkok ไทยแลนด์ ตีตลาดอินโดนีเซีย ด้วยคุณภาพระดับพรีเมียม',
        'content' => '<p>แบรนด์ "Ayam Bangkok Thailand" กำลังสร้างชื่อเสียงในตลาดอินโดนีเซีย ด้วยการนำเสนอไก่พื้นเมืองไทยคุณภาพระดับพรีเมียม ที่ผ่านการคัดสรรอย่างพิถีพิถัน</p>

<h3>จุดเด่นของ Ayam Bangkok Thailand</h3>
<ul>
<li><strong>คุณภาพสูง:</strong> ไก่ทุกตัวผ่านการตรวจสอบจากสัตวแพทย์</li>
<li><strong>สายพันธุ์แท้:</strong> เป็นไก่พื้นเมืองไทยสายพันธุ์ดี</li>
<li><strong>ใบรับรองครบถ้วน:</strong> มีเอกสารรับรองจากหน่วยงานราชการ</li>
<li><strong>บริการครบวงจร:</strong> ดูแลตั้งแต่คัดเลือกจนถึงส่งมอบ</li>
</ul>

<h3>การตอบรับจากตลาด</h3>
<p>ลูกค้าชาวอินโดนีเซียให้การตอบรับที่ดีมาก โดยเฉพาะกลุ่มผู้ที่ชื่นชอบการเลี้ยงไก่ชนและต้องการไก่คุณภาพสูง</p>

<p>ปัจจุบันมีคำสั่งซื้อเพิ่มขึ้นอย่างต่อเนื่อง และมีการขยายเครือข่ายตัวแทนจำหน่ายในหลายเมืองของอินโดนีเซีย</p>

<h3>แผนการขยายธุรกิจ</h3>
<p>บริษัทมีแผนที่จะขยายการส่งออกไปยังประเทศอื่นๆ ในภูมิภาคเอเชียตะวันออกเฉียงใต้ รวมถึงการพัฒนาผลิตภัณฑ์เสริมและบริการเพิ่มเติม</p>',
        'excerpt' => 'แบรนด์ Ayam Bangkok Thailand สร้างชื่อเสียงในอินโดนีเซีย ด้วยไก่พื้นเมืองไทยคุณภาพพรีเมียม ได้รับการตอบรับอย่างดี',
        'categories' => array('news-export', 'news-media'),
        'highlight' => false,
        'external_link' => '',
        'date' => '2024-02-01'
    )
);

// เพิ่มข่าวแต่ละรายการ
$imported_count = 0;

foreach ($news_data as $news) {
    // สร้างโพสต์
    $post_data = array(
        'post_title' => $news['title'],
        'post_content' => $news['content'],
        'post_excerpt' => $news['excerpt'],
        'post_status' => 'publish',
        'post_type' => 'ayam_news',
        'post_author' => 1,
        'post_date' => $news['date'] . ' 10:00:00'
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id) {
        // เพิ่ม categories
        $term_ids = array();
        foreach ($news['categories'] as $cat_slug) {
            if (isset($created_categories[$cat_slug])) {
                $term_ids[] = $created_categories[$cat_slug];
            }
        }
        wp_set_object_terms($post_id, $term_ids, 'news_category');
        
        // เพิ่ม meta fields
        if ($news['highlight']) {
            update_post_meta($post_id, 'news_highlight', '1');
        }
        
        if (!empty($news['external_link'])) {
            update_post_meta($post_id, 'news_external_link', $news['external_link']);
        }
        
        $imported_count++;
        echo "✓ เพิ่มข่าว: {$news['title']}<br>";
    } else {
        echo "✗ ไม่สามารถเพิ่มข่าว: {$news['title']}<br>";
    }
}

echo "<hr>";
echo "<h2>สรุปผลการ Import</h2>";
echo "<p><strong>เพิ่มข่าวสารสำเร็จ: {$imported_count} รายการ</strong></p>";
echo "<p><a href='" . admin_url('edit.php?post_type=ayam_news') . "' class='button button-primary'>ดูข่าวสารทั้งหมด</a></p>";
echo "<p><a href='" . get_post_type_archive_link('ayam_news') . "' class='button'>ดูหน้าข่าวสาร</a></p>";

echo "<style>
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
h1 { color: #1E2950; }
h2 { color: #CA4249; margin-top: 30px; }
.button { display: inline-block; padding: 10px 20px; background: #1E2950; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px; }
.button-primary { background: #CA4249; }
</style>";
?>
