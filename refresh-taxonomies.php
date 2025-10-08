<?php
/**
 * Refresh Taxonomies and Add Default Terms
 */

require_once('wp-config.php');

echo "<h1>🔄 Refreshing Taxonomies</h1>\n";
echo "<pre>\n";

try {
    // Flush rewrite rules
    flush_rewrite_rules(true);
    echo "✅ Rewrite rules flushed\n\n";
    
    // Check taxonomies
    echo "Checking taxonomies:\n";
    $taxonomies = array(
        'rooster_breed' => 'Rooster Breeds',
        'rooster_category' => 'Rooster Categories',
        'service_category' => 'Service Categories',
        'news_category' => 'News Categories',
        'knowledge_category' => 'Knowledge Categories'
    );
    
    foreach ($taxonomies as $taxonomy => $label) {
        if (taxonomy_exists($taxonomy)) {
            echo "✅ $taxonomy - EXISTS\n";
        } else {
            echo "❌ $taxonomy - NOT EXISTS\n";
        }
    }
    
    echo "\nAdding default terms:\n";
    
    // Add rooster breeds
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
            $result = wp_insert_term($thai_name, 'rooster_breed', array(
                'description' => $english_name
            ));
            if (!is_wp_error($result)) {
                echo "✅ Added breed: $thai_name\n";
            }
        } else {
            echo "- Breed exists: $thai_name\n";
        }
    }
    
    // Add rooster categories
    $rooster_categories = array(
        'พร้อมส่งออก' => 'Ready for Export',
        'กำลังฝึก' => 'In Training',
        'พ่อแม่พันธุ์' => 'Breeding Stock',
        'ไก่หนุ่ม' => 'Young Roosters',
        'ไก่แชมป์' => 'Champion Roosters'
    );
    
    foreach ($rooster_categories as $thai_name => $english_name) {
        if (!term_exists($thai_name, 'rooster_category')) {
            $result = wp_insert_term($thai_name, 'rooster_category', array(
                'description' => $english_name
            ));
            if (!is_wp_error($result)) {
                echo "✅ Added rooster category: $thai_name\n";
            }
        } else {
            echo "- Rooster category exists: $thai_name\n";
        }
    }
    
    // Add service categories
    $service_categories = array(
        'บริการฝึกไก่' => 'Rooster Training Services',
        'บริการดูแลรักษา' => 'Healthcare Services',
        'คอนซัลติ้ง' => 'Consulting Services',
        'ผสมพันธุ์' => 'Breeding Services',
        'บริการส่งออก' => 'Export Services',
        'ฝากเลี้ยง' => 'Boarding Services'
    );
    
    foreach ($service_categories as $thai_name => $english_name) {
        if (!term_exists($thai_name, 'service_category')) {
            $result = wp_insert_term($thai_name, 'service_category', array(
                'description' => $english_name
            ));
            if (!is_wp_error($result)) {
                echo "✅ Added service category: $thai_name\n";
            }
        } else {
            echo "- Service category exists: $thai_name\n";
        }
    }
    
    // Add news categories
    $news_categories = array(
        'ข่าวบริษัท' => 'Company News',
        'กิจกรรม' => 'Activities',
        'การแข่งขัน' => 'Competitions',
        'ความรู้' => 'Knowledge',
        'ประกาศ' => 'Announcements'
    );
    
    foreach ($news_categories as $thai_name => $english_name) {
        if (!term_exists($thai_name, 'news_category')) {
            $result = wp_insert_term($thai_name, 'news_category', array(
                'description' => $english_name
            ));
            if (!is_wp_error($result)) {
                echo "✅ Added news category: $thai_name\n";
            }
        } else {
            echo "- News category exists: $thai_name\n";
        }
    }
    
    // Add knowledge categories
    $knowledge_categories = array(
        'การเลี้ยงดู' => 'Raising and Care',
        'โภชนาการ' => 'Nutrition',
        'การฝึกซ้อม' => 'Training',
        'โรคและการรักษา' => 'Diseases and Treatment',
        'การผสมพันธุ์' => 'Breeding',
        'เทคนิคการแข่งขัน' => 'Competition Techniques',
        'อุปกรณ์' => 'Equipment',
        'กฎระเบียบ' => 'Rules and Regulations'
    );
    
    foreach ($knowledge_categories as $thai_name => $english_name) {
        if (!term_exists($thai_name, 'knowledge_category')) {
            $result = wp_insert_term($thai_name, 'knowledge_category', array(
                'description' => $english_name
            ));
            if (!is_wp_error($result)) {
                echo "✅ Added knowledge category: $thai_name\n";
            }
        } else {
            echo "- Knowledge category exists: $thai_name\n";
        }
    }
    
    echo "\n✅ Taxonomies refreshed successfully!\n";
    echo "\nNow you should see:\n";
    echo "- Breed and category options when adding roosters\n";
    echo "- Service categories when adding services\n";
    echo "- News categories when adding news\n";
    echo "- Knowledge categories when adding articles\n";
    
    echo "\nRefresh your WordPress admin page to see the changes!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>\n";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #28a745; }
pre { background: #f5f5f5; padding: 20px; border-radius: 5px; line-height: 1.5; }
</style>