<?php
/**
 * Improve Export Cases Design
 * Make the export cases section more beautiful and professional
 */

require_once 'wp-config.php';

echo "<h1>🎨 Improving Export Cases Design</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #1e40af; }</style>";

// Add improved CSS for export cases
$improved_css = "
/* ===== IMPROVED EXPORT CASES DESIGN ===== */

.export-cases-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
    overflow: hidden;
}

.export-cases-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23000\" opacity=\"0.02\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>') repeat;
    pointer-events: none;
}

.export-cases-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
    gap: 40px;
    margin-top: 60px;
}

.export-case-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.export-case-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.export-case-image {
    position: relative;
    height: 240px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.export-case-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.export-case-card:hover .export-case-image img {
    transform: scale(1.05);
}

.export-case-status {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.export-case-status.completed {
    background: rgba(16, 185, 129, 0.9);
    color: white;
}

.export-case-status.in_transit {
    background: rgba(245, 158, 11, 0.9);
    color: white;
}

.export-case-status.processing {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.export-case-content {
    padding: 30px;
}

.export-case-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.export-case-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    line-height: 1.3;
}

.export-case-id {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
    background: #f3f4f6;
    padding: 4px 12px;
    border-radius: 12px;
}

.export-case-details {
    margin: 20px 0;
}

.export-case-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}

.export-case-detail:last-child {
    border-bottom: none;
}

.export-case-detail-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
}

.export-case-detail-value {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
}

.export-case-progress {
    margin: 25px 0;
}

.export-case-progress-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.export-case-progress-text {
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
}

.export-case-progress-percent {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
}

.export-case-progress-bar {
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
}

.export-case-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    border-radius: 4px;
    transition: width 0.6s ease;
}

.export-case-actions {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.export-case-btn {
    flex: 1;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.export-case-btn.primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.export-case-btn.primary:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    transform: translateY(-2px);
}

.export-case-btn.secondary {
    background: #f8fafc;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.export-case-btn.secondary:hover {
    background: #f1f5f9;
    border-color: #d1d5db;
}

.no-export-cases {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

.no-export-cases-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 20px;
}

.no-export-cases h3 {
    font-size: 1.5rem;
    color: #374151;
    margin-bottom: 15px;
}

.no-export-cases p {
    color: #6b7280;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.no-export-cases .btn-modern {
    display: inline-block;
    padding: 15px 30px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.no-export-cases .btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .export-cases-grid {
        grid-template-columns: 1fr;
        gap: 30px;
        margin-top: 40px;
    }
    
    .export-case-card {
        border-radius: 16px;
    }
    
    .export-case-content {
        padding: 25px;
    }
    
    .export-case-title {
        font-size: 1.2rem;
    }
    
    .export-case-actions {
        flex-direction: column;
    }
    
    .export-case-btn {
        padding: 14px 20px;
    }
}

/* Animation for progress bars */
@keyframes progressFill {
    from { width: 0%; }
    to { width: var(--progress-width); }
}

.export-case-progress-fill {
    animation: progressFill 1.5s ease-out;
    animation-delay: 0.5s;
    animation-fill-mode: both;
}
";

// Add the CSS to the theme's style.css
$style_css_path = get_template_directory() . '/style.css';
$current_css = file_get_contents($style_css_path);

// Check if the improved CSS is already added
if (strpos($current_css, '/* ===== IMPROVED EXPORT CASES DESIGN =====') === false) {
    file_put_contents($style_css_path, $current_css . "\n\n" . $improved_css);
    echo "<p>✅ Added improved export cases CSS to style.css</p>";
} else {
    echo "<p>ℹ️ Improved export cases CSS already exists in style.css</p>";
}

// Create sample export cases data
$sample_export_cases = [
    [
        'id' => 'EXP-2024-001',
        'title' => 'ไก่ชนไทยพื้นเมือง - Jakarta',
        'image' => get_template_directory_uri() . '/assets/images/hero-export-1.jpg',
        'status' => 'completed',
        'progress' => 100,
        'destination' => 'Jakarta, Indonesia',
        'quantity' => '25 ตัว',
        'value' => '฿125,000',
        'date' => '15 ม.ค. 2024',
        'customer' => 'PT. Ayam Juara Indonesia'
    ],
    [
        'id' => 'EXP-2024-002', 
        'title' => 'American Gamefowl - Surabaya',
        'image' => get_template_directory_uri() . '/assets/images/hero-export-2.jpg',
        'status' => 'in_transit',
        'progress' => 75,
        'destination' => 'Surabaya, Indonesia',
        'quantity' => '18 ตัว',
        'value' => '฿180,000',
        'date' => '22 ม.ค. 2024',
        'customer' => 'CV. Sabung Ayam Nusantara'
    ],
    [
        'id' => 'EXP-2024-003',
        'title' => 'ไก่ชนอีสาน - Medan',
        'image' => get_template_directory_uri() . '/assets/images/hero-export-3.jpg',
        'status' => 'processing',
        'progress' => 45,
        'destination' => 'Medan, Indonesia',
        'quantity' => '30 ตัว',
        'value' => '฿150,000',
        'date' => '28 ม.ค. 2024',
        'customer' => 'UD. Ayam Champion Sumatra'
    ]
];

// Save sample data
update_option('ayam_sample_export_cases', $sample_export_cases);

echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3>✅ Export Cases Design Improved!</h3>";
echo "<ul>";
echo "<li>✅ Added beautiful card design with hover effects</li>";
echo "<li>✅ Professional status badges and progress bars</li>";
echo "<li>✅ Responsive grid layout</li>";
echo "<li>✅ Smooth animations and transitions</li>";
echo "<li>✅ Created sample export cases data</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3>🔧 Next Steps</h3>";
echo "<p>The export cases section now has a professional design. To complete the setup:</p>";
echo "<ol>";
echo "<li>Replace placeholder images with actual export photos</li>";
echo "<li>Add real export case data</li>";
echo "<li>Test the tracking modal functionality</li>";
echo "<li>Optimize for mobile devices</li>";
echo "</ol>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 20px; background: #e0f2fe; border-radius: 12px;'>";
echo "<h3>🎉 Ready to View!</h3>";
echo "<p>The export cases section is now beautifully designed and professional.</p>";
echo "<p><a href='" . home_url() . "' target='_blank' style='background: #3b82f6; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;'>View Updated Homepage</a></p>";
echo "</div>";

// Show preview of the design
echo "<h3>🎨 Design Preview</h3>";
echo "<div style='background: white; border-radius: 12px; padding: 20px; margin: 20px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.1);'>";
echo "<h4>Export Cases Features:</h4>";
echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;'>";

$features = [
    ['icon' => '🎨', 'title' => 'Beautiful Cards', 'desc' => 'Modern card design with shadows'],
    ['icon' => '📊', 'title' => 'Progress Bars', 'desc' => 'Animated progress tracking'],
    ['icon' => '🏷️', 'title' => 'Status Badges', 'desc' => 'Color-coded status indicators'],
    ['icon' => '📱', 'title' => 'Responsive', 'desc' => 'Works on all devices'],
    ['icon' => '✨', 'title' => 'Animations', 'desc' => 'Smooth hover effects'],
    ['icon' => '🔍', 'title' => 'Detailed Info', 'desc' => 'Complete export information']
];

foreach ($features as $feature) {
    echo "<div style='text-align: center; padding: 15px; background: #f8fafc; border-radius: 8px;'>";
    echo "<div style='font-size: 2rem; margin-bottom: 8px;'>{$feature['icon']}</div>";
    echo "<h5 style='margin: 0 0 5px 0; color: #1f2937;'>{$feature['title']}</h5>";
    echo "<p style='margin: 0; font-size: 0.85rem; color: #6b7280;'>{$feature['desc']}</p>";
    echo "</div>";
}

echo "</div>";
echo "</div>";
?>