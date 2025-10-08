<?php
/**
 * Update Slider Content for Export Business Model
 * This script updates the homepage slider with export-focused content
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    require_once dirname(__FILE__) . '/wp-config.php';
}

// Export-focused slider content
$export_slider_data = array(
    array(
        'slide_title' => 'ตัวแทนส่งออกไก่ชนอย่างเป็นทางการ',
        'slide_description' => 'รายเดียวของประเทศไทยที่ได้รับอนุญาตส่งออกไก่ชนไปยังอินโดนีเซีย',
        'slide_button_text' => 'เรียนรู้เพิ่มเติม',
        'slide_button_url' => home_url('/about/'),
        'slide_button_style' => 'primary',
        'slide_text_position' => 'center',
        'slide_image' => get_template_directory_uri() . '/assets/images/hero-export-1.jpg'
    ),
    array(
        'slide_title' => 'กระบวนการส่งออกครบวงจร',
        'slide_description' => 'ดูแลทุกขั้นตอนตั้งแต่รับไก่เข้าจนถึงส่งมอบให้ลูกค้าในอินโดนีเซีย',
        'slide_button_text' => 'ดูกระบวนการ',
        'slide_button_url' => home_url('/services/'),
        'slide_button_style' => 'primary',
        'slide_text_position' => 'center',
        'slide_image' => get_template_directory_uri() . '/assets/images/hero-export-2.jpg'
    ),
    array(
        'slide_title' => 'ประสบการณ์กว่า 10 ปี',
        'slide_description' => 'ส่งออกไก่ชนสำเร็จกว่า 1,250 ครั้ง ด้วยอัตราความสำเร็จ 98.5%',
        'slide_button_text' => 'ดูสถิติ',
        'slide_button_url' => home_url('/achievements/'),
        'slide_button_style' => 'primary',
        'slide_text_position' => 'center',
        'slide_image' => get_template_directory_uri() . '/assets/images/hero-export-3.jpg'
    )
);

// Function to update slider settings
function update_export_slider_settings() {
    $slider_settings = array(
        'enable' => true,
        'height' => '100vh',
        'autoplay' => true,
        'autoplay_speed' => 5000,
        'loop' => true,
        'effect' => 'fade',
        'show_pagination' => true,
        'show_navigation' => true
    );
    
    // Save to options or ACF fields
    update_option('ayam_slider_settings', $slider_settings);
    
    return $slider_settings;
}

// Function to update welcome section content
function update_export_welcome_content() {
    $welcome_content = array(
        'enable' => true,
        'title' => 'ยินดีต้อนรับสู่ Ayam Bangkok',
        'description' => 'ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย เราให้บริการครบวงจรตั้งแต่การรับไก่เข้าจนถึงการส่งมอบให้ลูกค้า',
        'background_color' => 'light'
    );
    
    update_option('ayam_welcome_content', $welcome_content);
    
    return $welcome_content;
}

// Function to create placeholder images
function create_export_placeholder_images() {
    $upload_dir = wp_upload_dir();
    $images_dir = $upload_dir['basedir'] . '/export-placeholders/';
    
    if (!file_exists($images_dir)) {
        wp_mkdir_p($images_dir);
    }
    
    $placeholder_images = array(
        'hero-export-1.jpg' => array(
            'title' => 'Export Success Hero',
            'alt' => 'Ayam Bangkok Export Success',
            'description' => 'Hero image showing export success and official certification'
        ),
        'hero-export-2.jpg' => array(
            'title' => 'Export Process Hero',
            'alt' => 'Complete Export Process',
            'description' => 'Hero image showing complete export process workflow'
        ),
        'hero-export-3.jpg' => array(
            'title' => 'Experience Hero',
            'alt' => '10+ Years Experience',
            'description' => 'Hero image highlighting 10+ years of export experience'
        ),
        'export-case-1.jpg' => array(
            'title' => 'Thai Native Rooster Export',
            'alt' => 'Thai Native Rooster Export to Jakarta',
            'description' => 'Successful export case of Thai native roosters to Jakarta'
        ),
        'export-case-2.jpg' => array(
            'title' => 'Isan Rooster Export',
            'alt' => 'Isan Rooster Export to Surabaya',
            'description' => 'Successful export case of Isan roosters to Surabaya'
        ),
        'export-case-3.jpg' => array(
            'title' => 'American Gamefowl Export',
            'alt' => 'American Gamefowl Export to Medan',
            'description' => 'Successful export case of American Gamefowl to Medan'
        )
    );
    
    $created_images = array();
    
    foreach ($placeholder_images as $filename => $image_data) {
        $file_path = $images_dir . $filename;
        
        // Create a simple placeholder file
        $placeholder_content = "<!-- Export Placeholder: {$image_data['title']} -->";
        
        if (file_put_contents($file_path, $placeholder_content)) {
            $created_images[] = array(
                'filename' => $filename,
                'path' => $file_path,
                'url' => $upload_dir['baseurl'] . '/export-placeholders/' . $filename,
                'data' => $image_data
            );
        }
    }
    
    return $created_images;
}

// Main execution
echo "<h2>Updating Slider Content for Export Business Model</h2>\n";
echo "<pre>\n";

echo "1. Updating slider settings...\n";
$slider_settings = update_export_slider_settings();
echo "✓ Slider settings updated\n";
echo "   - Autoplay: " . ($slider_settings['autoplay'] ? 'Yes' : 'No') . "\n";
echo "   - Effect: " . $slider_settings['effect'] . "\n";
echo "   - Height: " . $slider_settings['height'] . "\n\n";

echo "2. Updating welcome section content...\n";
$welcome_content = update_export_welcome_content();
echo "✓ Welcome content updated\n";
echo "   - Title: " . $welcome_content['title'] . "\n";
echo "   - Description length: " . strlen($welcome_content['description']) . " characters\n\n";

echo "3. Creating placeholder images...\n";
$created_images = create_export_placeholder_images();
echo "✓ Created " . count($created_images) . " placeholder images\n";
foreach ($created_images as $image) {
    echo "   - {$image['filename']}: {$image['data']['title']}\n";
}
echo "\n";

echo "4. Updating slider data...\n";
update_option('ayam_slider_images', $export_slider_data);
echo "✓ Slider data updated with " . count($export_slider_data) . " slides\n";
foreach ($export_slider_data as $index => $slide) {
    echo "   - Slide " . ($index + 1) . ": {$slide['slide_title']}\n";
}
echo "\n";

echo str_repeat("=", 60) . "\n";
echo "EXPORT CONTENT UPDATE COMPLETE!\n";
echo str_repeat("=", 60) . "\n";

echo "\nUpdated Content:\n";
echo "✓ Homepage slider with export-focused messaging\n";
echo "✓ Welcome section emphasizing export services\n";
echo "✓ Placeholder images for hero and export cases\n";
echo "✓ Export business model terminology\n";

echo "\nNext Steps:\n";
echo "1. Replace placeholder images with actual photos from Google Drive\n";
echo "2. Test the homepage to see the new export-focused content\n";
echo "3. Update any remaining rooster-selling language to export services\n";
echo "4. Add real export case data when available\n";

echo "\nSlider Content Preview:\n";
foreach ($export_slider_data as $index => $slide) {
    echo "\nSlide " . ($index + 1) . ":\n";
    echo "  Title: {$slide['slide_title']}\n";
    echo "  Description: {$slide['slide_description']}\n";
    echo "  Button: {$slide['slide_button_text']} → {$slide['slide_button_url']}\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "</pre>\n";

// Instructions for manual image replacement
echo "<h3>Image Replacement Instructions:</h3>";
echo "<ol>";
echo "<li>Download actual images from the Google Drive folder</li>";
echo "<li>Upload them to WordPress Media Library</li>";
echo "<li>Update the slider image URLs in the database or through admin</li>";
echo "<li>Ensure images are optimized for web (recommended: 1920x1080px)</li>";
echo "</ol>";

echo "<h3>Export Business Focus:</h3>";
echo "<ul>";
echo "<li><strong>Official Representative:</strong> Emphasize being the only official exporter</li>";
echo "<li><strong>Complete Process:</strong> Highlight end-to-end service</li>";
echo "<li><strong>Experience & Trust:</strong> Show statistics and success stories</li>";
echo "<li><strong>Professional Service:</strong> Focus on B2B export services</li>";
echo "</ul>";
?>