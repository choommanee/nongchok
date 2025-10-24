<?php
/**
 * Gallery Category Detail View
 */

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Get category from URL parameter
$category_code = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Helper function to get correct image URL (local uses production images)
function get_gallery_image_url_detail($path) {
    // If local development, use production URL
    if (strpos($_SERVER['HTTP_HOST'], '.local') !== false || $_SERVER['HTTP_HOST'] === 'localhost') {
        return 'https://nongchok-production.up.railway.app' . $path;
    }
    // Production uses relative path
    return $path;
}

// Get category info
$category = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM {$categories_table} WHERE category_number = %s",
    $category_code
));

if (!$category) {
    echo '<div style="padding: 100px 20px; text-align: center;"><p>Category not found.</p></div>';
    return;
}

// Get all media items
$all_media = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$images_table}
     WHERE category_id = %d
     ORDER BY sort_order ASC",
    $category->id
));

// Define 6 media slots with labels
$media_slots = [
    1 => ['label' => 'เอกสารรับไว้', 'media' => null],
    2 => ['label' => 'ภาพชั่งน้ำหนัก', 'media' => null],
    3 => ['label' => 'ภาพหน้าแซงไก่หน้า', 'media' => null],
    4 => ['label' => 'ภาพหน้าแซงไก่หลัง', 'media' => null],
    5 => ['label' => 'ภาพยิ่งสวยๆ', 'media' => null],
    6 => ['label' => 'วิดีโอไก่ต่ อยู่ฟาร์ม', 'media' => null],
];

// Map media to slots based on sort_order
foreach ($all_media as $index => $media) {
    $slot_number = $index + 1;
    if ($slot_number <= 6) {
        $media_slots[$slot_number]['media'] = $media;
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<style>
.category-detail-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #f9fafb;
    min-height: 100vh;
    padding: 40px 20px;
}

.gallery-container {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 40px;
    align-items: start;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #6b7280 !important;
    text-decoration: none !important;
    margin-bottom: 30px;
    font-weight: 400;
    font-size: 0.95rem;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: #CA4249 !important;
}

/* Left Column - Category Info */
.category-info-card {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    position: sticky;
    top: 40px;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1E2950;
    margin-bottom: 20px;
    text-align: center;
}

.category-image {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 20px;
}

.category-details {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.detail-label {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
}

.detail-value {
    font-size: 1rem;
    color: #1E2950;
    font-weight: 600;
}

/* Right Column - Media Slots Grid */
.media-slots-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.media-slot {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 2px solid #e5e7eb;
    position: relative;
}

.media-slot.empty {
    border-style: dashed;
    background: #f9fafb;
}

.media-content {
    aspect-ratio: 1;
    position: relative;
    overflow: hidden;
}

.media-content img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.media-content:hover img {
    transform: scale(1.05);
}

.media-content iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.slot-label {
    padding: 12px 15px;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 500;
    color: #4a5568;
    background: #f7fafc;
    border-top: 1px solid #e5e7eb;
}

.empty-slot-placeholder {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e0;
    font-size: 0.85rem;
    text-align: center;
    padding: 20px;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.media-content:hover .image-overlay {
    opacity: 1;
}

.zoom-icon {
    font-size: 2rem;
    color: white;
}

@media (max-width: 1024px) {
    .gallery-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .category-info-card {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .category-detail-page {
        padding: 20px 15px;
    }

    .gallery-container {
        gap: 20px;
    }

    .media-slots-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .category-title {
        font-size: 1.3rem;
    }
}

@media (max-width: 480px) {
    .category-info-card {
        padding: 20px;
    }

    .media-slots-grid {
        gap: 12px;
    }
}
</style>

<main class="category-detail-page">
    <a href="<?php echo remove_query_arg('category'); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i> Back to Gallery
    </a>

    <div class="gallery-container">
        <!-- Left Column: Category Info -->
        <aside class="category-info-card">
            <h1 class="category-title">ตัวอย่าง Gallery ให้ลูกค้าเข้ามาดู</h1>

            <?php
            // Get first image for display
            $main_image = !empty($all_media) ? $all_media[0] : null;
            if ($main_image):
            ?>
                <img src="<?php echo esc_url(get_gallery_image_url_detail($main_image->image_url)); ?>"
                     alt="<?php echo esc_attr($category->category_name); ?>"
                     class="category-image">
            <?php endif; ?>

            <div class="category-details">
                <div class="detail-item">
                    <div class="detail-label">Shipment วันที่</div>
                    <div class="detail-value">15 ตุลาคม 2025</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Leg band:</div>
                    <div class="detail-value"><?php echo esc_html($category->category_number); ?></div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">ลูกค้าคิด เข้าไปดู (โครีกดูได้)</div>
                    <div class="detail-value">Owner: Abdul Rahim</div>
                </div>
            </div>
        </aside>

        <!-- Right Column: Media Slots -->
        <div class="media-slots-grid">
            <?php foreach ($media_slots as $slot_num => $slot): ?>
                <div class="media-slot <?php echo empty($slot['media']) ? 'empty' : ''; ?>">
                    <?php if (!empty($slot['media'])):
                        $media = $slot['media'];
                        $is_video = ($media->media_type === 'video');

                        if ($is_video):
                            // Video content
                            $video_url = $media->image_url;
                            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                if (strpos($video_url, 'youtu.be') !== false) {
                                    preg_match('/youtu\.be\/([^?]+)/', $video_url, $matches);
                                    $video_id = $matches[1] ?? '';
                                } else {
                                    preg_match('/[?&]v=([^&]+)/', $video_url, $matches);
                                    $video_id = $matches[1] ?? '';
                                }
                                $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                            } else {
                                $embed_url = $video_url;
                            }
                        ?>
                            <div class="media-content">
                                <iframe src="<?php echo esc_url($embed_url); ?>" allowfullscreen loading="lazy"></iframe>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo esc_url(get_gallery_image_url_detail($media->image_url)); ?>"
                               data-lightbox="gallery-<?php echo $category->category_number; ?>"
                               data-title="<?php echo esc_attr($slot['label']); ?>">
                                <div class="media-content">
                                    <img src="<?php echo esc_url(get_gallery_image_url_detail($media->image_url)); ?>"
                                         alt="<?php echo esc_attr($slot['label']); ?>"
                                         loading="lazy">
                                    <div class="image-overlay">
                                        <div class="zoom-icon">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-slot-placeholder">
                            รอเพิ่งวิดีโอ<br>หลังจากได้อยู่มาแล้ว<br>3-4 วัน
                        </div>
                    <?php endif; ?>

                    <div class="slot-label"><?php echo esc_html($slot['label']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true
        });
    }

    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    }
});
</script>
