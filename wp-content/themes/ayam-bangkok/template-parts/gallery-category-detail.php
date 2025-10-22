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

// Get all images
$images = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$images_table}
     WHERE category_id = %d
     ORDER BY sort_order ASC",
    $category->id
));
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<style>
.category-detail-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #fff;
    min-height: 100vh;
}

.category-detail-header {
    background: #fff;
    padding: 40px 20px 30px;
    border-bottom: 1px solid #e5e7eb;
}

.category-header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 80px;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #6b7280 !important;
    text-decoration: none !important;
    margin-bottom: 20px;
    font-weight: 400;
    font-size: 0.95rem;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: #CA4249 !important;
}

.category-detail-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1E2950;
    margin-bottom: 15px;
}

.category-detail-meta {
    display: flex;
    gap: 20px;
    font-size: 0.95rem;
    color: #6b7280;
    flex-wrap: wrap;
}

.category-detail-meta i {
    color: #CA4249;
    margin-right: 5px;
}

.category-images-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 80px 80px;
}

.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.image-card {
    background: #fff;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    aspect-ratio: 1;
}

.image-wrapper {
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
}

.image-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.image-card:hover img {
    transform: scale(1.05);
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

.image-card:hover .image-overlay {
    opacity: 1;
}

.zoom-icon {
    font-size: 2rem;
    color: white;
}

.category-video-section {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 80px;
}

.video-section-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1E2950;
}

.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}

@media (max-width: 768px) {
    .category-header-container,
    .category-images-section,
    .category-video-section {
        padding-left: 20px;
        padding-right: 20px;
    }

    .category-detail-title {
        font-size: 2rem;
    }

    .category-detail-meta {
        gap: 15px;
        font-size: 0.9rem;
    }

    .images-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
}

@media (max-width: 480px) {
    .category-detail-title {
        font-size: 1.6rem;
    }

    .images-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
}
</style>

<main class="category-detail-page">

    <!-- Header -->
    <section class="category-detail-header">
        <div class="category-header-container">
            <a href="<?php echo remove_query_arg('category'); ?>" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Gallery
            </a>

            <h1 class="category-detail-title"><?php echo esc_html($category->category_name); ?></h1>

            <div class="category-detail-meta">
                <span><i class="fas fa-images"></i> <?php echo count($images); ?> Photos</span>
                <span><i class="fas fa-hashtag"></i> <?php echo $category->category_number; ?></span>
            </div>
        </div>
    </section>

    <!-- Video Section (if exists) -->
    <?php if (!empty($category->video_url)): ?>
    <section class="category-video-section">
        <h2 class="video-section-title">
            <i class="fas fa-video"></i> Video Showcase
        </h2>
        <div class="video-container">
            <iframe
                src="<?php echo esc_url($category->video_url); ?>"
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                allowfullscreen
                loading="lazy"
            ></iframe>
        </div>
    </section>
    <?php endif; ?>

    <!-- Images Grid -->
    <section class="category-images-section">
        <?php if (!empty($images)): ?>
            <div class="images-grid">
                <?php foreach ($images as $index => $image): ?>
                    <div class="image-card" data-aos="fade-up" data-aos-delay="<?php echo ($index % 12) * 50; ?>">
                        <a href="<?php echo esc_url(get_gallery_image_url_detail($image->image_url)); ?>"
                           data-lightbox="gallery-<?php echo $category->category_number; ?>"
                           data-title="<?php echo esc_attr($category->category_name); ?> - Photo <?php echo $index + 1; ?>">

                            <div class="image-wrapper">
                                <img src="<?php echo esc_url(get_gallery_image_url_detail($image->image_url)); ?>"
                                     alt="<?php echo esc_attr($category->category_name); ?> - <?php echo $index + 1; ?>"
                                     loading="lazy">

                                <div class="image-overlay">
                                    <div class="zoom-icon">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 100px 20px; color: #718096;">
                <i class="fas fa-images" style="font-size: 5rem; color: #cbd5e0; margin-bottom: 20px;"></i>
                <p>No images in this category yet.</p>
            </div>
        <?php endif; ?>
    </section>

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
