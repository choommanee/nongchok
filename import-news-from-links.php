<?php
/**
 * Import News from URLs
 * นำเข้าข่าวจากลิงก์ทั้งหมดที่ให้มา
 */

require_once('wp-load.php');

// รายการข่าวทั้งหมด
$news_links = array(
    // ชุดข่าวที่ 1: ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด มูลค่า 4 ล้านบาท
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" ไปอินโด โตต่อเนื่อง มูลค่า 4 ล้านบาท',
        'url' => 'https://www.khaosod.co.th/update-news/news_9931581',
        'source' => 'ข่าวสด',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย โตต่อเนื่อง มูลค่า 4 ล้านบาท',
        'url' => 'https://www.prachachat.net/economy/news-1881670',
        'source' => 'ประชาชาติธุรกิจ',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย โตต่อเนื่อง มูลค่า 4 ล้านบาท',
        'url' => 'https://www.banmuang.co.th/news/politic/445881',
        'source' => 'บ้านเมือง',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย โตต่อเนื่อง',
        'url' => 'https://www.bangkokbiznews.com/business/economic/1198234',
        'source' => 'กรุงเทพธุรกิจ',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย',
        'url' => 'https://www.agrinewsthai.com/news/219063',
        'source' => 'Agri News',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโด',
        'url' => 'https://www.kasetkaoklai.com/home/2025/09/ส่งออกไก่พื้นเมืองไทย-ayam-bangkok',
        'source' => 'เกษตรก้าวไกล',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok สู่อินโดนีเซีย',
        'url' => 'https://kasettumkin.com/agriculture-news/108917/',
        'source' => 'เกษตรถั่วพิมพ์',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok ไปอินโดนีเซีย',
        'url' => 'https://www.thailandplus.tv/archives/955823',
        'source' => 'Thailand Plus',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok - Daily News',
        'url' => 'https://www.dailynews.co.th/news/5142924/',
        'source' => 'เดลินิวส์',
    ),

    // ชุดข่าวที่ 2: ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok"
    array(
        'title' => 'ปศุสัตว์ปลื้ม! ดันส่งออก "Ayam Bangkok" ไทยแลนด์สู่อินโดนีเซีย เพิ่มจำนวนต่อเนื่อง',
        'url' => 'https://www.naewna.com/local/916450',
        'source' => 'แนวหน้า',
    ),
    array(
        'title' => 'อธิบดีปศุสัตว์ ปลื้ม ดันส่งออก Ayam Bangkok',
        'url' => 'https://www.banmuang.co.th/news/politic/447680',
        'source' => 'บ้านเมือง',
    ),
    array(
        'title' => 'ปศุสัตว์ดันส่งออกไก่พื้นเมืองไทย Ayam Bangkok',
        'url' => 'https://www.agrinewsthai.com/news/222317',
        'source' => 'Agri News',
    ),
    array(
        'title' => 'ส่งออก Ayam Bangkok ไทยแลนด์สู่อินโดนีเซีย',
        'url' => 'http://www.taekpradennews.com/2025/09/ayam-bangkok.html',
        'source' => 'แถลงข่าวออนไลน์',
    ),
    array(
        'title' => 'ปศุสัตว์ดันส่งออก Ayam Bangkok - Lens News',
        'url' => 'https://lensnews21.com/v/11461',
        'source' => 'Lens News',
    ),
    array(
        'title' => 'ปศุสัตว์ปลื้ม ดันส่งออก Ayam Bangkok',
        'url' => 'https://www.thethaipress.com/2025/150768',
        'source' => 'The Thai Press',
    ),
    array(
        'title' => 'ส่งออกไก่พื้นเมืองไทย Ayam Bangkok สู่อินโดนีเซีย',
        'url' => 'https://livestockemag.com/?p=1767',
        'source' => 'Livestock E-Magazine',
    ),
    array(
        'title' => 'ปศุสัตว์ดันส่งออก Ayam Bangkok - Thailand Plus TV',
        'url' => 'https://www.thailandplus.tv/archives/959533',
        'source' => 'Thailand Plus TV',
    ),
    array(
        'title' => 'อธิบดีปศุสัตว์ ปลื้ม ดันส่งออก Ayam Bangkok',
        'url' => 'https://sootinclaimon.com/2025/09/24/อธิบดีปศุสัตว์-ปลื้ม-ดัน/',
        'source' => 'Sootin Claimon',
    ),
);

echo "📰 เริ่มนำเข้าข่าวสาร Ayam Bangkok\n";
echo "จำนวนข่าวทั้งหมด: " . count($news_links) . " รายการ\n\n";

$imported = 0;
$skipped = 0;

foreach ($news_links as $news) {
    // ตรวจสอบว่ามีข่าวนี้อยู่แล้วหรือไม่
    $existing = get_page_by_title($news['title'], OBJECT, 'post');

    if ($existing) {
        echo "⏭️  ข้าม: {$news['title']} (มีอยู่แล้ว)\n";
        $skipped++;
        continue;
    }

    // สร้างโพสต์ข่าว
    $post_data = array(
        'post_title'    => $news['title'],
        'post_content'  => '<p>อ่านข่าวฉบับเต็มได้ที่: <a href="' . esc_url($news['url']) . '" target="_blank" rel="noopener">' . $news['source'] . '</a></p>
                           <p>ข่าวนี้เกี่ยวกับการส่งออกไก่พื้นเมืองไทย "Ayam Bangkok" จากไทยไปยังอินโดนีเซีย แสดงถึงความสำเร็จและการเติบโตอย่างต่อเนื่องของธุรกิจการส่งออกไก่ชนคุณภาพสูง</p>',
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_category' => array(get_cat_ID('ข่าวสาร') ?: 1),
        'meta_input'    => array(
            'news_source' => $news['source'],
            'news_url' => $news['url'],
            'featured_news' => true
        )
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id && !is_wp_error($post_id)) {
        echo "✅ สร้างสำเร็จ: {$news['title']}\n";
        echo "   📌 Post ID: {$post_id}\n";
        echo "   🔗 แหล่งที่มา: {$news['source']}\n\n";
        $imported++;
    } else {
        echo "❌ ล้มเหลว: {$news['title']}\n";
        if (is_wp_error($post_id)) {
            echo "   Error: " . $post_id->get_error_message() . "\n\n";
        }
    }
}

echo "\n";
echo "==========================================\n";
echo "📊 สรุปผลการนำเข้าข่าว\n";
echo "==========================================\n";
echo "✅ นำเข้าสำเร็จ: {$imported} รายการ\n";
echo "⏭️  ข้าม (มีอยู่แล้ว): {$skipped} รายการ\n";
echo "📰 ทั้งหมด: " . count($news_links) . " รายการ\n";
echo "==========================================\n";

echo "\n🎉 เสร็จสิ้นการนำเข้าข่าวสาร!\n";
echo "\n📝 หมายเหตุ: \n";
echo "- ข่าวทั้งหมดถูกสร้างเป็นโพสต์ WordPress\n";
echo "- มีลิงก์ไปยังแหล่งข่าวต้นฉบับ\n";
echo "- สามารถแก้ไขเนื้อหาได้ใน WordPress Admin\n";
