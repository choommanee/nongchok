<?php
/**
 * Create placeholder images for hero slider
 */

require_once 'wp-config.php';

echo "<h1>🖼️ Creating Placeholder Images</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #1e40af; }</style>";

// Create images directory
$images_dir = get_template_directory() . '/assets/images';
if (!file_exists($images_dir)) {
    wp_mkdir_p($images_dir);
    echo "<p>✅ Created images directory: {$images_dir}</p>";
}

// Create simple placeholder images using GD
if (extension_loaded('gd')) {
    $images = [
        'hero-export-1.jpg' => [
            'width' => 1920,
            'height' => 800,
            'color' => [59, 130, 246], // Blue
            'text' => 'Export Services'
        ],
        'hero-export-2.jpg' => [
            'width' => 1920,
            'height' => 800,
            'color' => [16, 185, 129], // Green
            'text' => 'Quality Chickens'
        ],
        'hero-export-3.jpg' => [
            'width' => 1920,
            'height' => 800,
            'color' => [245, 158, 11], // Orange
            'text' => 'Thailand to Indonesia'
        ]
    ];

    foreach ($images as $filename => $config) {
        $filepath = $images_dir . '/' . $filename;
        
        // Create image
        $image = imagecreatetruecolor($config['width'], $config['height']);
        
        // Create gradient background
        for ($y = 0; $y < $config['height']; $y++) {
            $alpha = $y / $config['height'];
            $r = (int)($config['color'][0] * (1 - $alpha * 0.3));
            $g = (int)($config['color'][1] * (1 - $alpha * 0.3));
            $b = (int)($config['color'][2] * (1 - $alpha * 0.3));
            
            $color = imagecolorallocate($image, $r, $g, $b);
            imageline($image, 0, $y, $config['width'], $y, $color);
        }
        
        // Add text
        $white = imagecolorallocate($image, 255, 255, 255);
        $text_x = ($config['width'] - strlen($config['text']) * 20) / 2;
        $text_y = $config['height'] / 2;
        
        // Use built-in font
        imagestring($image, 5, $text_x, $text_y, $config['text'], $white);
        
        // Save image
        if (imagejpeg($image, $filepath, 85)) {
            echo "<p>✅ Created: {$filename} (" . number_format(filesize($filepath)) . " bytes)</p>";
        } else {
            echo "<p>❌ Failed to create: {$filename}</p>";
        }
        
        imagedestroy($image);
    }
    
    echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
    echo "<h3>🎉 Placeholder Images Created!</h3>";
    echo "<p>Hero slider images have been created successfully.</p>";
    echo "</div>";
    
} else {
    echo "<div style='background: #fef2f2; border: 2px solid #ef4444; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
    echo "<h3>⚠️ GD Extension Not Available</h3>";
    echo "<p>Cannot create placeholder images. Using external URLs instead.</p>";
    echo "</div>";
    
    // Update slider data to use external placeholder images
    $placeholder_images = [
        [
            'slide_image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=1920&h=800&fit=crop',
            'slide_title' => 'บริการส่งออกไก่ไทยคุณภาพสูง',
            'slide_description' => 'เชื่อมต่อฟาร์มไทยสู่ตลาดอินโดนีเซีย ด้วยกระบวนการส่งออกที่มีมาตรฐาน',
            'slide_button_text' => 'เรียนรู้เพิ่มเติม',
            'slide_button_url' => '#export-process',
            'slide_text_position' => 'center'
        ],
        [
            'slide_image' => 'https://images.unsplash.com/photo-1518492104633-130d0cc84637?w=1920&h=800&fit=crop',
            'slide_title' => 'ไก่คุณภาพสูงจากฟาร์มไทย',
            'slide_description' => 'คัดสรรไก่จากฟาร์มที่ได้มาตรฐาน พร้อมระบบขนส่งที่ปลอดภัย',
            'slide_button_text' => 'ดูกระบวนการ',
            'slide_button_url' => '#export-process',
            'slide_text_position' => 'center'
        ],
        [
            'slide_image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920&h=800&fit=crop',
            'slide_title' => 'เชื่อถือได้ทุกขั้นตอน',
            'slide_description' => 'จัดการเอกสารส่งออกครบถ้วน ติดตามสถานะได้ตลอดเวลา',
            'slide_button_text' => 'ติดต่อเรา',
            'slide_button_url' => '#contact',
            'slide_text_position' => 'center'
        ]
    ];
    
    update_option('ayam_slider_images', $placeholder_images);
    echo "<p>✅ Updated slider data with external placeholder images</p>";
}

echo "<div style='text-align: center; margin: 40px 0; padding: 20px; background: #e0f2fe; border-radius: 12px;'>";
echo "<h3>🔧 Next Steps</h3>";
echo "<p>Refresh your homepage to see the images!</p>";
echo "<p><a href='" . home_url() . "' target='_blank' style='background: #3b82f6; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none;'>View Homepage</a></p>";
echo "</div>";
?>