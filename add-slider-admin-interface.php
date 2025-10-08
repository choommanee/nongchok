<?php
/**
 * Add Slider Admin Interface
 * Create admin interface for managing homepage slider
 */

require_once 'wp-config.php';

echo "<h1>🎛️ Adding Slider Admin Interface</h1>";
echo "<style>body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 40px; } h1 { color: #1e40af; }</style>";

// Add slider fields to ACF
$acf_fields_path = get_template_directory() . '/../plugins/ayam-bangkok-core/includes/class-ayam-acf-fields.php';
$acf_content = file_get_contents($acf_fields_path);

// Check if slider fields already exist
if (strpos($acf_content, 'register_slider_fields') === false) {
    
    // Add slider method to the class
    $slider_method = "
    /**
     * Register slider fields
     */
    public function register_slider_fields() {
        acf_add_local_field_group(array(
            'key' => 'group_slider_settings',
            'title' => 'การตั้งค่า Slider หน้าแรก',
            'fields' => array(
                array(
                    'key' => 'field_slider_images',
                    'label' => 'รูปภาพ Slider',
                    'name' => 'slider_images',
                    'type' => 'repeater',
                    'instructions' => 'เพิ่มรูปภาพสำหรับ slider หน้าแรก',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => 'field_slide_title',
                    'min' => 1,
                    'max' => 5,
                    'layout' => 'block',
                    'button_label' => 'เพิ่มรูป Slider',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_slide_image',
                            'label' => 'รูปภาพ',
                            'name' => 'slide_image',
                            'type' => 'image',
                            'instructions' => 'เลือกรูปภาพสำหรับ slide (แนะนำขนาด 1920x800px)',
                            'required' => 1,
                            'return_format' => 'url',
                            'preview_size' => 'medium',
                            'library' => 'all',
                        ),
                        array(
                            'key' => 'field_slide_title',
                            'label' => 'หัวข้อ',
                            'name' => 'slide_title',
                            'type' => 'text',
                            'instructions' => 'หัวข้อหลักของ slide',
                            'required' => 1,
                            'maxlength' => 100,
                        ),
                        array(
                            'key' => 'field_slide_description',
                            'label' => 'คำอธิบาย',
                            'name' => 'slide_description',
                            'type' => 'textarea',
                            'instructions' => 'คำอธิบายรายละเอียด',
                            'required' => 0,
                            'rows' => 3,
                            'maxlength' => 200,
                        ),
                        array(
                            'key' => 'field_slide_button_text',
                            'label' => 'ข้อความปุ่ม',
                            'name' => 'slide_button_text',
                            'type' => 'text',
                            'instructions' => 'ข้อความบนปุ่ม (เว้นว่างไว้หากไม่ต้องการปุ่ม)',
                            'required' => 0,
                            'maxlength' => 30,
                        ),
                        array(
                            'key' => 'field_slide_button_url',
                            'label' => 'ลิงก์ปุ่ม',
                            'name' => 'slide_button_url',
                            'type' => 'url',
                            'instructions' => 'URL ที่ปุ่มจะลิงก์ไป',
                            'required' => 0,
                        ),
                        array(
                            'key' => 'field_slide_text_position',
                            'label' => 'ตำแหน่งข้อความ',
                            'name' => 'slide_text_position',
                            'type' => 'select',
                            'instructions' => 'เลือกตำแหน่งของข้อความบน slide',
                            'required' => 0,
                            'choices' => array(
                                'left' => 'ซ้าย',
                                'center' => 'กลาง',
                                'right' => 'ขวา',
                            ),
                            'default_value' => 'center',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_slider_autoplay',
                    'label' => 'เล่นอัตโนมัติ',
                    'name' => 'slider_autoplay',
                    'type' => 'true_false',
                    'instructions' => 'เปิดใช้การเล่น slider อัตโนมัติ',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_slider_autoplay_speed',
                    'label' => 'ความเร็วการเล่น (มิลลิวินาที)',
                    'name' => 'slider_autoplay_speed',
                    'type' => 'number',
                    'instructions' => 'ระยะเวลาในการแสดงแต่ละ slide (5000 = 5 วินาที)',
                    'required' => 0,
                    'default_value' => 5000,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 500,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_slider_autoplay',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_slider_show_navigation',
                    'label' => 'แสดงปุ่มนำทาง',
                    'name' => 'slider_show_navigation',
                    'type' => 'true_false',
                    'instructions' => 'แสดงปุ่มลูกศรซ้าย-ขวา',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_slider_show_pagination',
                    'label' => 'แสดงจุดนำทาง',
                    'name' => 'slider_show_pagination',
                    'type' => 'true_false',
                    'instructions' => 'แสดงจุดด้านล่างสำหรับนำทาง',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_slider_height',
                    'label' => 'ความสูง Slider',
                    'name' => 'slider_height',
                    'type' => 'text',
                    'instructions' => 'ความสูงของ slider (เช่น 600px, 80vh)',
                    'required' => 0,
                    'default_value' => '600px',
                ),
                array(
                    'key' => 'field_slider_effect',
                    'label' => 'เอฟเฟกต์การเปลี่ยน',
                    'name' => 'slider_effect',
                    'type' => 'select',
                    'instructions' => 'เลือกเอฟเฟกต์การเปลี่ยน slide',
                    'required' => 0,
                    'choices' => array(
                        'slide' => 'เลื่อน',
                        'fade' => 'จางหาย',
                        'cube' => 'ลูกบาศก์',
                        'coverflow' => 'Cover Flow',
                    ),
                    'default_value' => 'slide',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'ayam-site-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => 'จัดการ slider หน้าแรกของเว็บไซต์',
        ));
    }";
    
    // Add the method call to register_field_groups
    $register_call = "\$this->register_slider_fields();";
    
    // Insert the method before the last closing brace
    $last_brace_pos = strrpos($acf_content, '}');
    $acf_content = substr_replace($acf_content, $slider_method . "\n" . $register_call . "\n        }\n    }", $last_brace_pos, 1);
    
    // Also add the call to register_field_groups method
    $acf_content = str_replace(
        '$this->register_company_info_fields();',
        '$this->register_company_info_fields();
            $this->register_slider_fields();',
        $acf_content
    );
    
    file_put_contents($acf_fields_path, $acf_content);
    echo "<p>✅ Added slider fields to ACF configuration</p>";
} else {
    echo "<p>ℹ️ Slider fields already exist in ACF configuration</p>";
}

// Update functions.php to use ACF data if available
$functions_path = get_template_directory() . '/functions.php';
$functions_content = file_get_contents($functions_path);

if (strpos($functions_content, 'Updated ayam_get_slider_images for ACF') === false) {
    $updated_function = "
// Updated ayam_get_slider_images for ACF
function ayam_get_slider_images() {
    if (function_exists('get_field')) {
        \$slides = get_field('slider_images', 'option');
        if (\$slides && !empty(\$slides)) {
            return \$slides;
        }
    }
    
    // Fallback to option data
    \$slides = get_option('ayam_slider_images', array());
    if (is_array(\$slides)) {
        return \$slides;
    }
    
    // If it's a string, decode it
    return json_decode(\$slides, true) ?: array();
}

function ayam_get_slider_settings() {
    if (function_exists('get_field')) {
        return array(
            'autoplay' => get_field('slider_autoplay', 'option') ? true : false,
            'autoplay_speed' => get_field('slider_autoplay_speed', 'option') ?: 5000,
            'show_navigation' => get_field('slider_show_navigation', 'option') ? true : false,
            'show_pagination' => get_field('slider_show_pagination', 'option') ? true : false,
            'height' => get_field('slider_height', 'option') ?: '600px',
            'effect' => get_field('slider_effect', 'option') ?: 'slide',
            'loop' => true
        );
    }
    
    // Fallback settings
    return array(
        'autoplay' => true,
        'autoplay_speed' => 5000,
        'show_navigation' => true,
        'show_pagination' => true,
        'height' => '600px',
        'effect' => 'slide',
        'loop' => true
    );
}";

    // Replace the existing functions
    $functions_content = preg_replace(
        '/function ayam_get_slider_images\(\) \{.*?\n\}/s',
        trim($updated_function),
        $functions_content
    );
    
    file_put_contents($functions_path, $functions_content);
    echo "<p>✅ Updated slider functions to use ACF data</p>";
}

echo "<div style='background: #f0fdf4; border: 2px solid #10b981; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3>🎉 Slider Admin Interface Added!</h3>";
echo "<p>คุณสามารถแก้ไข slider ได้ที่:</p>";
echo "<ol>";
echo "<li>เข้า WordPress Admin</li>";
echo "<li>ไปที่ <strong>ตั้งค่าเว็บไซต์</strong> ในเมนูซ้าย</li>";
echo "<li>คลิก <strong>ตั้งค่าเว็บไซต์</strong></li>";
echo "<li>เลื่อนลงไปหาส่วน <strong>การตั้งค่า Slider หน้าแรก</strong></li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #fef3c7; border: 2px solid #f59e0b; border-radius: 12px; padding: 20px; margin: 20px 0;'>";
echo "<h3>📋 คุณสมบัติที่เพิ่มเข้ามา:</h3>";
echo "<ul>";
echo "<li>✅ เพิ่ม/ลบ/แก้ไขรูป slider</li>";
echo "<li>✅ ตั้งหัวข้อและคำอธิบายแต่ละ slide</li>";
echo "<li>✅ เพิ่มปุ่มและลิงก์</li>";
echo "<li>✅ เลือกตำแหน่งข้อความ (ซ้าย/กลาง/ขวา)</li>";
echo "<li>✅ ตั้งค่าการเล่นอัตโนมัติ</li>";
echo "<li>✅ ปรับความเร็วการเล่น</li>";
echo "<li>✅ เปิด/ปิดปุ่มนำทางและจุดนำทาง</li>";
echo "<li>✅ ปรับความสูง slider</li>";
echo "<li>✅ เลือกเอฟเฟกต์การเปลี่ยน</li>";
echo "</ul>";
echo "</div>";

echo "<div style='text-align: center; margin: 40px 0; padding: 20px; background: #e0f2fe; border-radius: 12px;'>";
echo "<h3>🔧 ขั้นตอนต่อไป</h3>";
echo "<p>1. เข้า WordPress Admin และไปที่ <strong>ตั้งค่าเว็บไซต์</strong></p>";
echo "<p>2. อัปโหลดรูปจาก Google Drive ผ่าน Media Library</p>";
echo "<p>3. ตั้งค่า slider ตามต้องการ</p>";
echo "<p><a href='" . admin_url('admin.php?page=ayam-site-settings') . "' target='_blank' style='background: #3b82f6; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;'>ไปที่หน้าตั้งค่า Slider</a></p>";
echo "</div>";
?>