<?php
/**
 * Template Name: About Us Page
 * Matching https://saeliwid.wixsite.com/my-site-3/about-us
 */

get_header();

// Get company information from database
global $wpdb;
$company_info_table = $wpdb->prefix . 'ayam_company_info';
$company_info_raw = $wpdb->get_results("SELECT * FROM $company_info_table WHERE is_active = 1");

// Convert to associative array for easy access
$company_info = array();
foreach ($company_info_raw as $info) {
    $lang = (function_exists('pll_current_language') && pll_current_language() == 'en') ? 'en' : 'th';
    $value = $lang == 'en' ? $info->field_value_en : $info->field_value_th;
    $company_info[$info->field_key] = $value ?: $info->field_value_th; // Fallback to Thai if English is empty
}

// Get company description (default text if not in database)
$company_description_1 = isset($company_info['company_description']) ? $company_info['company_description'] :
    'ยินดีต้อนรับสู่ธุรกิจของเรา เรามุ่งมั่นที่จะนำเสนอบริการและสินค้าคุณภาพสูงที่สุดให้กับลูกค้า การเดินทางของเราเริ่มต้นจากความหลงใหลในความเป็นเลิศและความมุ่งมั่นในการสร้างความแตกต่างในอุตสาหกรรมของเรา';

$company_description_2 = isset($company_info['about_description']) ? $company_info['about_description'] :
    'ด้วยประสบการณ์หลายปีและทีมผู้เชี่ยวชาญที่ทุ่มเท เรายังคงเติบโตและพัฒนาอย่างต่อเนื่อง โดยมีความต้องการของลูกค้าเป็นหัวใจหลักของทุกสิ่งที่เราทำ';

// Get story content
$story_text_1 = isset($company_info['story_text_1']) ? $company_info['story_text_1'] :
    'เรื่องราวของเราเป็นเรื่องราวของความหลงใหล ความทุ่มเท และการเติบโตอย่างต่อเนื่อง เราเริ่มต้นด้วยวิสัยทัศน์ที่เรียบง่าย: สร้างสรรค์สิ่งที่มีความหมายซึ่งสามารถสร้างความแตกต่างในชีวิตของผู้คน ตลอดหลายปีที่ผ่านมา เราได้พัฒนาและขยายธุรกิจ แต่คุณค่าหลักของเรายังคงเหมือนเดิม';

$story_text_2 = isset($company_info['story_text_2']) ? $company_info['story_text_2'] :
    'วันนี้เราภูมิใจที่ได้ให้บริการชุมชนของเราด้วยความมุ่งมั่นในความเป็นเลิศเช่นเดียวกับตั้งแต่วันแรก เรื่องราวของเรายังคงถูกเขียนต่อไป และเราขอเชิญคุณมาเป็นส่วนหนึ่งของมัน';

// Get gallery images from uploads directory
$upload_dir = wp_upload_dir();
$gallery_images = array();

// Check if there's a custom about gallery
$about_gallery_dir = $upload_dir['basedir'] . '/about-gallery/';
if (is_dir($about_gallery_dir)) {
    $files = glob($about_gallery_dir . '*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
    foreach ($files as $file) {
        $gallery_images[] = $upload_dir['baseurl'] . '/about-gallery/' . basename($file);
    }
}

// Fallback to theme images if no custom gallery
if (empty($gallery_images)) {
    for ($i = 1; $i <= 8; $i++) {
        $image_path = get_template_directory() . '/assets/images/about/about-' . $i . '.jpg';
        if (file_exists($image_path)) {
            $gallery_images[] = get_template_directory_uri() . '/assets/images/about/about-' . $i . '.jpg';
        }
    }
}

// Get contact information
$contact_address = isset($company_info['address']) ? $company_info['address'] :
    'ถนน พุทธบูชา 11 ตำบลโคกเจริญ<br>แขวงหนองจอก เขตหนองจอก<br>Nong Chok, Bangkok, Thailand';

$contact_phone = isset($company_info['phone']) ? $company_info['phone'] : '089-091-4664';
$contact_email = isset($company_info['email']) ? $company_info['email'] : '';

// Get Google Map URL
$google_map_url = isset($company_info['google_map_url']) ? $company_info['google_map_url'] :
    'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.5234!2d100.8234!3d13.8234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDQ5JzI0LjIiTiAxMDDCsDQ5JzI0LjIiRQ!5e0!3m2!1sen!2sth!4v1234567890';

?>

<main id="primary" class="site-main wix-style-about">

    <!-- Hero Section with Images -->
    <section class="about-hero-section">
        <div class="container">
            <div class="about-hero-grid">
                <div class="about-hero-content" data-aos="fade-right">
                    <h1 class="about-main-title">About Us</h1>
                    <p class="about-intro-text">
                        <?php echo esc_html($company_description_1); ?>
                    </p>
                    <p class="about-intro-text">
                        <?php echo esc_html($company_description_2); ?>
                    </p>
                </div>
                <div class="about-hero-images" data-aos="fade-left">
                    <div class="hero-image-grid">
                        <?php
                        // Display first 3 images from gallery for hero
                        $hero_images = array_slice($gallery_images, 0, 3);
                        if (empty($hero_images)) {
                            // Fallback placeholder
                            $hero_images = array(
                                get_template_directory_uri() . '/assets/images/logo-square.jpg',
                                get_template_directory_uri() . '/assets/images/logo-square.jpg',
                                get_template_directory_uri() . '/assets/images/logo-square.jpg',
                            );
                        }

                        foreach ($hero_images as $index => $img) :
                        ?>
                            <div class="hero-image-item">
                                <img src="<?php echo esc_url($img); ?>" alt="About Us Image <?php echo $index + 1; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section with Gallery -->
    <section class="about-story-section">
        <div class="container">
            <div class="section-header-center">
                <h2 class="section-title" data-aos="fade-up">Our Story</h2>
            </div>

            <div class="about-story-content" data-aos="fade-up" data-aos-delay="100">
                <p class="story-text">
                    <?php echo esc_html($story_text_1); ?>
                </p>
                <p class="story-text">
                    <?php echo esc_html($story_text_2); ?>
                </p>
            </div>

            <!-- Gallery Grid -->
            <div class="about-gallery-grid" data-aos="fade-up" data-aos-delay="200">
                <?php
                if (!empty($gallery_images)) {
                    foreach ($gallery_images as $index => $image) :
                ?>
                    <div class="gallery-item" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($index * 50); ?>">
                        <img src="<?php echo esc_url($image); ?>" alt="Gallery Image <?php echo $index + 1; ?>">
                    </div>
                <?php
                    endforeach;
                } else {
                    // Show placeholder if no images
                    echo '<p>ยังไม่มีรูปภาพในแกลเลอรี่</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="about-contact-section">
        <div class="container">
            <div class="about-contact-layout">
                <div class="contact-info-column" data-aos="fade-right">
                    <h2 class="contact-section-title">Get in touch with<br>any questions</h2>

                    <div class="contact-info-details">
                        <div class="contact-info-item">
                            <h4>Address</h4>
                            <p><?php echo wp_kses_post($contact_address); ?></p>
                        </div>

                        <div class="contact-info-item">
                            <h4>Contact</h4>
                            <p><a href="tel:<?php echo esc_attr(str_replace('-', '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a></p>
                            <?php if ($contact_email): ?>
                                <p><a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html($contact_email); ?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="contact-form-column" data-aos="fade-left">
                    <div class="contact-form-header">
                        <h3>Please fill out the form:</h3>
                    </div>

                    <?php
                    // Handle form submission
                    if (isset($_POST['about_contact_submit'])) {
                        // Verify nonce
                        if (wp_verify_nonce($_POST['about_contact_nonce'], 'about_contact_form')) {
                            // Sanitize input
                            $first_name = sanitize_text_field($_POST['first_name']);
                            $last_name = sanitize_text_field($_POST['last_name']);
                            $email = sanitize_email($_POST['email']);
                            $message = sanitize_textarea_field($_POST['message']);

                            // Send email
                            $to = $contact_email ?: get_option('admin_email');
                            $subject = 'ข้อความจากแบบฟอร์มติดต่อ About Us';
                            $body = "ชื่อ: $first_name $last_name\n";
                            $body .= "Email: $email\n\n";
                            $body .= "ข้อความ:\n$message";

                            $headers = array('Content-Type: text/plain; charset=UTF-8');

                            if (wp_mail($to, $subject, $body, $headers)) {
                                echo '<div class="contact-form-success">ส่งข้อความเรียบร้อยแล้ว ขอบคุณที่ติดต่อเรา!</div>';
                            } else {
                                echo '<div class="contact-form-error">เกิดข้อผิดพลาดในการส่งข้อความ กรุณาลองใหม่อีกครั้ง</div>';
                            }
                        }
                    }
                    ?>

                    <form class="about-contact-form" method="post" action="">
                        <?php wp_nonce_field('about_contact_form', 'about_contact_nonce'); ?>

                        <div class="form-row-split">
                            <div class="form-field">
                                <label for="first_name">ชื่อ *</label>
                                <input type="text" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-field">
                                <label for="last_name">นามสกุล *</label>
                                <input type="text" id="last_name" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-field">
                            <label for="message">ข้อความ *</label>
                            <textarea id="message" name="message" rows="6" required></textarea>
                        </div>

                        <div class="form-submit-btn">
                            <button type="submit" name="about_contact_submit" class="btn-primary-submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Google Map -->
            <div class="contact-map-container" data-aos="fade-up" data-aos-delay="100">
                <iframe
                    src="<?php echo esc_url($google_map_url); ?>"
                    width="100%"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

</main><!-- #main -->

<?php
get_footer();
