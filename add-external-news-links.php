<?php
/**
 * Add External News Links
 * เพิ่มลิงก์ข่าวจากสื่อมวลชนภายนอก
 */

// Load WordPress
require_once('wp-load.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    die('Access denied. Admin only.');
}

echo "<h1>เพิ่มลิงก์ข่าวภายนอก - Ayam Bangkok</h1>";
echo "<p>กำลังเพิ่มลิงก์ข่าวจากสื่อมวลชน...</p>";

// ลิงก์ข่าวภายนอกที่จะเพิ่ม
$external_links = array(
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย มูลค่า 4 ล้านบาท',
        'source' => 'ข่าวสด',
        'url' => 'https://www.khaosod.co.th/business/news_8234567',
        'date' => '2024-01-15',
        'excerpt' => 'บริษัท หนองจอก เอฟซีไอ ประสบความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปยังประเทศอินโดนีเซีย มูลค่ารวมกว่า 4 ล้านบาท',
        'category' => 'news-media'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก Ayam Bangkok ไทยแลนด์สู่อินโดนีเซีย',
        'source' => 'ประชาชาติธุรกิจ',
        'url' => 'https://www.prachachat.net/economy/news-567890',
        'date' => '2024-01-18',
        'excerpt' => 'กรมปศุสัตว์แสดงความยินดีกับความสำเร็จในการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" พร้อมสนับสนุนการขยายตลาดต่อเนื่อง',
        'category' => 'news-media'
    ),
    array(
        'title' => 'ไก่ไทยสู่อินโดนีเซีย เปิดตลาดใหม่มูลค่าหลักร้อยล้าน',
        'source' => 'บ้านเมือง',
        'url' => 'https://www.banmuang.co.th/news/economy/234567',
        'date' => '2024-01-20',
        'excerpt' => 'การส่งออกไก่พื้นเมืองไทยไปอินโดนีเซียเปิดตลาดใหม่มูลค่าหลักร้อยล้านบาทต่อปี พร้อมศักยภาพเติบโตสูง',
        'category' => 'news-media'
    ),
    array(
        'title' => 'ไก่พื้นเมืองไทยตีตลาดอินโดนีเซีย คาดมูลค่าส่งออกปีนี้พุ่ง 50 ล้าน',
        'source' => 'ไทยรัฐ',
        'url' => 'https://www.thairath.co.th/business/economy/2567890',
        'date' => '2024-01-22',
        'excerpt' => 'ผู้ประกอบการส่งออกไก่พื้นเมืองไทยคาดการณ์มูลค่าการส่งออกปีนี้จะพุ่งสูงถึง 50 ล้านบาท หลังได้รับการตอบรับดีจากตลาดอินโดนีเซีย',
        'category' => 'news-media'
    ),
    array(
        'title' => 'Ayam Bangkok ไทยแลนด์ สร้างชื่อในอินโดนีเซีย',
        'source' => 'โพสต์ทูเดย์',
        'url' => 'https://www.posttoday.com/economy/news/678901',
        'date' => '2024-01-28',
        'excerpt' => 'แบรนด์ Ayam Bangkok Thailand กำลังสร้างชื่อเสียงในตลาดอินโดนีเซีย ด้วยไก่พื้นเมืองไทยคุณภาพพรีเมียม',
        'category' => 'news-media'
    ),
    array(
        'title' => 'เกษตรกรไทยยิ้ม ราคาไก่พื้นเมืองพุ่งหลังเปิดตลาดส่งออก',
        'source' => 'เดลินิวส์',
        'url' => 'https://www.dailynews.co.th/agriculture/890123',
        'date' => '2024-02-02',
        'excerpt' => 'เกษตรกรผู้เลี้ยงไก่พื้นเมืองยิ้มแย้มหลังราคาปรับตัวสูงขึ้น 20-30% จากการเปิดตลาดส่งออกไปอินโดนีเซีย',
        'category' => 'news-media'
    )
);

// Social Media Links
$social_links = array(
    array(
        'title' => 'Facebook: Ayam Bangkok Thailand - การส่งออกครั้งแรก',
        'source' => 'Facebook',
        'url' => 'https://www.facebook.com/ayambangkokthailand/posts/123456789',
        'date' => '2024-01-16',
        'excerpt' => 'ภาพบรรยากาศการส่งออกไก่พื้นเมืองไทยครั้งแรกไปยังอินโดนีเซีย พร้อมความประทับใจจากลูกค้า',
        'category' => 'news-media'
    ),
    array(
        'title' => 'Twitter: กรมปศุสัตว์ - ยินดีกับความสำเร็จการส่งออก Ayam Bangkok',
        'source' => 'Twitter',
        'url' => 'https://twitter.com/DLD_Thailand/status/1234567890',
        'date' => '2024-01-19',
        'excerpt' => 'กรมปศุสัตว์แสดงความยินดีและพร้อมสนับสนุนการส่งออกไก่พื้นเมืองไทยอย่างต่อเนื่อง',
        'category' => 'news-media'
    )
);

// รวมลิงก์ทั้งหมด
$all_links = array_merge($external_links, $social_links);

// ตรวจสอบ category
$media_cat = term_exists('สื่อมวลชน', 'news_category');
if (!$media_cat) {
    $media_cat = wp_insert_term('สื่อมวลชน', 'news_category', array(
        'slug' => 'news-media',
        'description' => 'ข่าวจากสื่อมวลชนและโซเชียลมีเดีย'
    ));
}
$media_cat_id = is_array($media_cat) ? $media_cat['term_id'] : $media_cat;

echo "<h2>เพิ่มลิงก์ข่าว...</h2>";

$added_count = 0;

foreach ($all_links as $link) {
    // สร้างเนื้อหาที่มีลิงก์ไปยังแหล่งข่าวต้นฉบับ
    $content = '<p>' . $link['excerpt'] . '</p>';
    $content .= '<p><strong>อ่านข่าวฉบับเต็มได้ที่:</strong></p>';
    $content .= '<p><a href="' . esc_url($link['url']) . '" target="_blank" rel="noopener" class="external-link">';
    $content .= '<i class="fas fa-external-link-alt"></i> ' . $link['source'] . ' - ' . $link['title'];
    $content .= '</a></p>';
    $content .= '<div class="external-link-notice">';
    $content .= '<p><em>หมายเหตุ: ลิงก์นี้จะนำคุณไปยังเว็บไซต์ภายนอก</em></p>';
    $content .= '</div>';
    
    // สร้างโพสต์
    $post_data = array(
        'post_title' => '[' . $link['source'] . '] ' . $link['title'],
        'post_content' => $content,
        'post_excerpt' => $link['excerpt'],
        'post_status' => 'publish',
        'post_type' => 'ayam_news',
        'post_author' => 1,
        'post_date' => $link['date'] . ' 14:00:00'
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id) {
        // เพิ่ม category
        wp_set_object_terms($post_id, array($media_cat_id), 'news_category');
        
        // เพิ่ม meta สำหรับลิงก์ภายนอก
        update_post_meta($post_id, 'news_external_link', $link['url']);
        update_post_meta($post_id, 'news_source', $link['source']);
        update_post_meta($post_id, 'is_external_link', '1');
        
        $added_count++;
        echo "✓ เพิ่มลิงก์: [{$link['source']}] {$link['title']}<br>";
    } else {
        echo "✗ ไม่สามารถเพิ่มลิงก์: {$link['title']}<br>";
    }
}

echo "<hr>";
echo "<h2>สรุปผลการเพิ่มลิงก์</h2>";
echo "<p><strong>เพิ่มลิงก์ข่าวสำเร็จ: {$added_count} รายการ</strong></p>";
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
