<?php
/**
 * Update News Content 2025
 * ลบข่าวเก่าและเพิ่มข่าวใหม่ตามลิงก์ที่ให้มา
 */

// Load WordPress
require_once('wp-config.php');

// Check if user is admin
if (!current_user_can('manage_options')) {
    wp_die('You do not have permission to access this page.');
}

echo "<h1>🗞️ อัพเดทข่าวสาร Ayam Bangkok 2025</h1>";
echo "<p>กำลังลบข่าวเก่าและเพิ่มข่าวใหม่...</p>";

// Step 1: ลบข่าวเก่าทั้งหมด
echo "<h2>Step 1: ลบข่าวเก่า</h2>";

$old_posts = get_posts(array(
    'post_type' => 'ayam_news',
    'posts_per_page' => -1,
    'post_status' => 'any'
));

foreach ($old_posts as $post) {
    wp_delete_post($post->ID, true);
    echo "✅ ลบข่าว: {$post->post_title}<br>";
}

echo "<p><strong>ลบข่าวเก่าเสร็จแล้ว: " . count($old_posts) . " รายการ</strong></p>";

// Step 2: เพิ่มข่าวใหม่
echo "<h2>Step 2: เพิ่มข่าวใหม่</h2>";

// ข่าวชุดที่ 1: ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท
$news_set_1 = array(
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - ข่าวสด',
        'url' => 'https://www.khaosod.co.th/update-news/news_9931581',
        'source' => 'ข่าวสด'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - ประชาชาติธุรกิจ',
        'url' => 'https://www.prachachat.net/economy/news-1881670',
        'source' => 'ประชาชาติธุรกิจ'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - บ้านเมือง',
        'url' => 'https://www.banmuang.co.th/news/politic/445881',
        'source' => 'บ้านเมือง'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - กรุงเทพธุรกิจ',
        'url' => 'https://www.bangkokbiznews.com/business/economic/1198234',
        'source' => 'กรุงเทพธุรกิจ'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - เกษตรข่าวไทย',
        'url' => 'https://www.agrinewsthai.com/news/219063',
        'source' => 'เกษตรข่าวไทย'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - เกษตรเก่าใหม่',
        'url' => 'https://www.kasetkaoklai.com/home/2025/09/%E0%B8%AA%E0%B9%88%E0%B8%87%E0%B8%AD%E0%B8%AD%E0%B8%81%E0%B9%84%E0%B8%81%E0%B9%88%E0%B8%9E%E0%B8%B7%E0%B9%89%E0%B8%99%E0%B9%80%E0%B8%A1%E0%B8%B7%E0%B8%AD%E0%B8%87%E0%B9%84%E0%B8%97%E0%B8%A2-a/',
        'source' => 'เกษตรเก่าใหม่'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - เกษตรตำกิน',
        'url' => 'https://kasettumkin.com/agriculture-news/108917/',
        'source' => 'เกษตรตำกิน'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Thailand Plus',
        'url' => 'https://www.thailandplus.tv/archives/955823',
        'source' => 'Thailand Plus'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Twitter',
        'url' => 'https://twitter.com/Thailandplus1/status/1965725993441890639',
        'source' => 'Twitter'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Facebook 1',
        'url' => 'https://m.facebook.com/story.php?story_fbid=pfbid0hbSB4KLPr9V5UXK7CxwGfirUrpyyeUndoHtfDJVJfDWAtHF1DCaTaTVgwf7sp5gPl&id=100063700894306',
        'source' => 'Facebook'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Facebook 2',
        'url' => 'https://m.facebook.com/756081632378888/posts/1584309086222801?wtsid=rdr_0GX3TMKyujC1Hqmw1',
        'source' => 'Facebook'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Facebook 3',
        'url' => 'https://m.facebook.com/495007275989497/posts/1232031748953709?wtsid=rdr_0UgTVU8FrVjGJpNSx',
        'source' => 'Facebook'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Facebook 4',
        'url' => 'https://www.facebook.com/share/p/1ERFeccDTr/',
        'source' => 'Facebook'
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท - Facebook 5',
        'url' => 'https://www.facebook.com/share/p/1EMuWFEFuU/',
        'source' => 'Facebook'
    )
);

// ข่าวชุดที่ 2: ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง
$news_set_2 = array(
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - เดลินิวส์',
        'url' => 'https://www.dailynews.co.th/news/5142924/',
        'source' => 'เดลินิวส์'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - แนวหน้า',
        'url' => 'https://www.naewna.com/local/916450',
        'source' => 'แนวหน้า'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - บ้านเมือง',
        'url' => 'https://www.banmuang.co.th/news/politic/447680',
        'source' => 'บ้านเมือง'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - เกษตรข่าวไทย',
        'url' => 'https://www.agrinewsthai.com/news/222317',
        'source' => 'เกษตรข่าวไทย'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - แต๊กประเดนนิวส์',
        'url' => 'http://www.taekpradennews.com/2025/09/ayam-bangkok.html',
        'source' => 'แต๊กประเดนนิวส์'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Lens News',
        'url' => 'https://lensnews21.com/v/11461',
        'source' => 'Lens News'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - The Thai Press',
        'url' => 'https://www.thethaipress.com/2025/150768',
        'source' => 'The Thai Press'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Livestock E-Magazine',
        'url' => 'https://livestockemag.com/?p=1767',
        'source' => 'Livestock E-Magazine'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Thailand Plus TV',
        'url' => 'https://www.thailandplus.tv/archives/959533',
        'source' => 'Thailand Plus TV'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Sootin Claimon',
        'url' => 'https://sootinclaimon.com/2025/09/24/%e0%b8%ad%e0%b8%98%e0%b8%b4%e0%b8%9a%e0%b8%94%e0%b8%b5%e0%b8%9b%e0%b8%a8%e0%b8%b8%e0%b8%aa%e0%b8%b1%e0%b8%95%e0%b8%a7%e0%b9%8c-%e0%b8%9b%e0%b8%a5%e0%b8%b7%e0%b9%89%e0%b8%a1-%e0%b8%94%e0%b8%b1/',
        'source' => 'Sootin Claimon'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - X (Twitter)',
        'url' => 'https://x.com/Thailandplus1/status/1970745843042201863',
        'source' => 'X (Twitter)'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Facebook 1',
        'url' => 'https://www.facebook.com/756081632378888/posts/1596918808295162',
        'source' => 'Facebook'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Facebook 2',
        'url' => 'https://www.facebook.com/470054465140739/posts/1228605192618992',
        'source' => 'Facebook'
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง - Facebook 3',
        'url' => 'https://www.facebook.com/462025375949895/posts/1188137126672046',
        'source' => 'Facebook'
    )
);

// รวมข่าวทั้งหมด
$all_news = array_merge($news_set_1, $news_set_2);

// สร้างหมวดหมู่ข่าว
echo "<h3>สร้างหมวดหมู่ข่าว</h3>";

$categories = array(
    'export-success' => 'ความสำเร็จการส่งออก',
    'media-coverage' => 'ข่าวสื่อมวลชน',
    'government-support' => 'การสนับสนุนจากภาครัฐ'
);

foreach ($categories as $slug => $name) {
    $term = wp_insert_term($name, 'news_category', array('slug' => $slug));
    if (!is_wp_error($term)) {
        echo "✅ สร้างหมวดหมู่: {$name}<br>";
    }
}

// เพิ่มข่าวใหม่
echo "<h3>เพิ่มข่าวใหม่</h3>";

$count = 0;
foreach ($all_news as $news) {
    $count++;
    
    // กำหนดหมวดหมู่ตามแหล่งข่าว
    $category = 'media-coverage';
    if (strpos($news['source'], 'Facebook') !== false || strpos($news['source'], 'Twitter') !== false || strpos($news['source'], 'X (') !== false) {
        $category = 'export-success';
    } elseif (strpos($news['title'], 'ปศุสัตว์') !== false) {
        $category = 'government-support';
    }
    
    // สร้างเนื้อหาข่าว
    $content = "<p>ข่าวการส่งออกไก่พื้นเมืองไทย 'Ayam Bangkok' ไปยังประเทศอินโดนีเซีย ซึ่งเป็นความสำเร็จที่สำคัญของอุตสาหกรรมปศุสัตว์ไทย</p>";
    $content .= "<p><strong>แหล่งข่าว:</strong> {$news['source']}</p>";
    $content .= "<p><a href='{$news['url']}' target='_blank' class='btn btn-primary'>อ่านข่าวฉบับเต็ม <i class='fas fa-external-link-alt'></i></a></p>";
    
    // สร้างโพสต์ข่าว
    $post_data = array(
        'post_title' => $news['title'],
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'ayam_news',
        'post_date' => date('Y-m-d H:i:s', strtotime('-' . $count . ' days'))
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id) {
        // เพิ่มหมวดหมู่
        wp_set_object_terms($post_id, $category, 'news_category');
        
        // เพิ่ม meta fields
        update_post_meta($post_id, 'external_link', $news['url']);
        update_post_meta($post_id, 'news_source', $news['source']);
        update_post_meta($post_id, 'highlight', true);
        
        echo "✅ เพิ่มข่าว #{$count}: {$news['title']}<br>";
    } else {
        echo "❌ ไม่สามารถเพิ่มข่าว: {$news['title']}<br>";
    }
}

echo "<h2>✅ เสร็จสิ้น!</h2>";
echo "<p><strong>สรุป:</strong></p>";
echo "<ul>";
echo "<li>ลบข่าวเก่า: " . count($old_posts) . " รายการ</li>";
echo "<li>เพิ่มข่าวใหม่: " . count($all_news) . " รายการ</li>";
echo "<li>สร้างหมวดหมู่: " . count($categories) . " หมวด</li>";
echo "</ul>";

echo "<p><a href='" . admin_url('edit.php?post_type=ayam_news') . "' class='button button-primary'>ดูข่าวทั้งหมด</a></p>";
echo "<p><a href='" . home_url() . "' class='button'>กลับหน้าแรก</a></p>";

?>

<style>
body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f1;
}
h1, h2, h3 {
    color: #1E2950;
}
.button {
    display: inline-block;
    padding: 10px 20px;
    background: #CA4249;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    margin: 5px;
}
.button-primary {
    background: #1E2950;
}
</style>
