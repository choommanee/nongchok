<?php
/**
 * Template Name: Service Page
 * Matching Wix Design
 */

get_header();

// Get service information from database
global $wpdb;
$company_info_table = $wpdb->prefix . 'ayam_company_info';
$service_info_raw = $wpdb->get_results("SELECT * FROM $company_info_table WHERE category = 'service' AND is_active = 1 ORDER BY sort_order ASC");

// Convert to associative array
$service_info = array();
foreach ($service_info_raw as $info) {
    $lang = (function_exists('pll_current_language') && pll_current_language() == 'en') ? 'en' : 'th';
    $value = $lang == 'en' ? $info->field_value_en : $info->field_value_th;
    $service_info[$info->field_key] = $value ?: $info->field_value_th;
}

// Get contact info
$contact_info_raw = $wpdb->get_results("SELECT * FROM $company_info_table WHERE is_active = 1");
$contact_info = array();
foreach ($contact_info_raw as $info) {
    $lang = (function_exists('pll_current_language') && pll_current_language() == 'en') ? 'en' : 'th';
    $value = $lang == 'en' ? $info->field_value_en : $info->field_value_th;
    $contact_info[$info->field_key] = $value ?: $info->field_value_th;
}

$hero_subtitle = $service_info['service_hero_subtitle'] ?? 'Get to Know';
$hero_title = $service_info['service_hero_title'] ?? 'Our Service';
?>

<main id="primary" class="site-main wix-service-page">

    <!-- Hero Section -->
    <section class="service-hero">
        <div class="service-hero-container">
            <h1 class="service-hero-subtitle"><?php echo esc_html($hero_subtitle); ?></h1>
            <p class="service-hero-title"><?php echo esc_html($hero_title); ?></p>
            <div class="service-hero-line"></div>
        </div>
    </section>

    <!-- 3 Export Services -->
    <section class="service-exports">
        <div class="service-container">
            <div class="service-exports-grid">
                <?php for ($i = 1; $i <= 3; $i++):
                    $title = $service_info["service_{$i}_title"] ?? '';
                    $desc = $service_info["service_{$i}_desc"] ?? '';
                    if ($title):
                ?>
                <div class="service-export-item">
                    <div class="service-export-icon">
                        <svg viewBox="0 0 35 52.22" xmlns="http://www.w3.org/2000/svg" width="60" height="90">
                            <path fill="#ca4249" d="M35 52.22l-18.17-7.81L0 52.22v-42h35v42z"/>
                            <path fill="#ffffff" d="M17.5 18.33l2.54 5.13 5.66.83-4.1 4 .97 5.64-5.07-2.66-5.07 2.66.97-5.64-4.1-4 5.66-.83 2.54-5.13z"/>
                        </svg>
                    </div>
                    <h2 class="service-export-title"><?php echo esc_html($title); ?></h2>
                    <p class="service-export-desc"><?php echo nl2br(esc_html($desc)); ?></p>
                </div>
                <?php endif; endfor; ?>
            </div>
        </div>
    </section>

    <!-- Images Grid -->
    <section class="service-images">
        <div class="service-container-full">
            <div class="service-images-grid">
                <?php for ($i = 1; $i <= 4; $i++):
                    $image_url = $service_info["service_image_{$i}"] ?? '';
                    if (empty($image_url)) {
                        $image_url = get_template_directory_uri() . "/assets/images/service/service-{$i}.jpg";
                    }
                ?>
                <div class="service-image-item" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                    <div class="service-image-overlay"></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    <section class="service-videos">
        <div class="service-container">
            <div class="service-videos-grid">
                <?php for ($i = 1; $i <= 2; $i++):
                    $video_title = $service_info["video_{$i}_title"] ?? '';
                    $video_desc = $service_info["video_{$i}_desc"] ?? '';
                    $video_url = $service_info["video_{$i}_url"] ?? '';

                    if ($video_title && $video_url):
                        // Extract video ID and get thumbnail
                        $thumbnail_url = '';
                        $video_id = '';

                        // YouTube
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
                            $video_id = $matches[1];
                            $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/maxresdefault.jpg";
                        }
                        // Vimeo
                        elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                            $video_id = $matches[1];
                            // Get Vimeo thumbnail via API
                            $vimeo_data = @file_get_contents("https://vimeo.com/api/v2/video/{$video_id}.json");
                            if ($vimeo_data) {
                                $vimeo_json = json_decode($vimeo_data);
                                $thumbnail_url = $vimeo_json[0]->thumbnail_large ?? '';
                            }
                        }
                ?>
                <div class="service-video-item">
                    <div class="service-video-thumbnail" style="position: relative; cursor: pointer;" onclick="playVideo<?php echo $i; ?>(this)">
                        <?php if ($thumbnail_url): ?>
                            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($video_title); ?>" style="width: 100%; display: block;">
                        <?php endif; ?>
                        <div class="service-video-play" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; background: rgba(255,255,255,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-play" style="font-size: 30px; color: #ca4249; margin-left: 5px;"></i>
                        </div>
                    </div>
                    <div class="service-video-player" id="player<?php echo $i; ?>" style="display: none; position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
                    </div>
                    <h3 class="service-video-title" style="margin-top: 15px;"><?php echo esc_html($video_title); ?></h3>
                    <?php if ($video_desc): ?>
                    <p class="service-video-desc"><?php echo esc_html($video_desc); ?></p>
                    <?php endif; ?>

                    <script>
                    function playVideo<?php echo $i; ?>(element) {
                        var thumbnail = element;
                        var player = document.getElementById('player<?php echo $i; ?>');
                        var iframe = document.createElement('iframe');

                        iframe.setAttribute('src', '<?php echo esc_js(str_replace('watch?v=', 'embed/', $video_url) . '?autoplay=1'); ?>');
                        iframe.setAttribute('frameborder', '0');
                        iframe.setAttribute('allowfullscreen', '1');
                        iframe.setAttribute('allow', 'autoplay; encrypted-media');
                        iframe.style.position = 'absolute';
                        iframe.style.top = '0';
                        iframe.style.left = '0';
                        iframe.style.width = '100%';
                        iframe.style.height = '100%';

                        player.querySelector('div').appendChild(iframe);
                        thumbnail.style.display = 'none';
                        player.style.display = 'block';
                    }
                    </script>
                </div>
                <?php endif; endfor; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="service-contact">
        <div class="service-container">
            <div class="service-contact-grid">
                <div class="service-contact-left">
                    <h2 class="service-contact-title">Get in touch with any questions</h2>

                    <div class="service-contact-info">
                        <h4>Address</h4>
                        <p>13/5 หมู่ที่ 11 ซอยวัดใหม่จริยาภิรมย์ แขวงคลองสิบสอง เขตหนองจอก กรุงเทพมหานคร,<br>Nong Chok, Thailand, Bangkok</p>
                    </div>

                    <div class="service-contact-info">
                        <h4>Contact</h4>
                        <p><?php echo isset($contact_info['phone']) ? esc_html($contact_info['phone']) : '123-456-7890'; ?><br>
                        <?php echo isset($contact_info['email']) ? esc_html($contact_info['email']) : 'info@mysite.com'; ?></p>
                    </div>

                    <div class="service-social">
                        <a href="#" class="service-social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="service-social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="service-contact-right">
                    <p class="service-form-subtitle">Please fill out the form:</p>
                    <form class="service-contact-form">
                        <div class="service-form-row">
                            <div class="service-form-group">
                                <label>ชื่อ</label>
                                <input type="text" name="first_name" required>
                            </div>
                            <div class="service-form-group">
                                <label>นามสกุล</label>
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        <div class="service-form-group">
                            <label>อีเมล</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="service-form-group">
                            <label>ที่อยู่</label>
                            <input type="text" name="address">
                        </div>
                        <div class="service-form-group">
                            <label>โทรศัพท์</label>
                            <input type="tel" name="phone">
                        </div>
                        <button type="submit" class="service-form-submit">ส่ง</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="service-map">
        <div id="service-map-container" style="width: 100%; height: 400px; background: #ddd;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3874.5447896873453!2d100.72875631483056!3d13.835540990304847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d61f8e9b3c3e1%3A0x3a7e5e5e5e5e5e5e!2sNong%20Chok%2C%20Bangkok!5e0!3m2!1sen!2sth!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

</main>

<style>
/* Force Avenir/system font - inline to ensure highest priority */
body.page-service *,
body.page-service,
.page-service *,
html body.page-service *,
html body.page-service,
.wix-service-page *,
.wix-service-page,
.service-hero *,
.service-exports *,
.service-videos *,
.service-contact *,
.site-footer *,
.wix-header * {
    font-family: Avenir, 'Avenir Next', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
}
</style>

<?php
get_footer();
