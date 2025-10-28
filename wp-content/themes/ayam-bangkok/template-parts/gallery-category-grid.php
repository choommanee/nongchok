<?php
/**
 * Gallery Category Grid View (For Behind the Scene & other grid displays)
 */

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Get category from URL parameter
$category_code = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Helper function to get correct image URL
function get_gallery_grid_image_url($path) {
    if (strpos($_SERVER['HTTP_HOST'], '.local') !== false || $_SERVER['HTTP_HOST'] === 'localhost') {
        return 'https://nongchok-production.up.railway.app' . $path;
    }
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

// Get all images for this category
$images = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM {$images_table}
     WHERE category_id = %d
     ORDER BY sort_order ASC",
    $category->id
));
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<style>
body {
    padding-top: 60px !important;
}

.gallery-grid-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #f9fafb;
    min-height: 100vh;
}

.gallery-grid-hero {
    background: #fff;
    padding: 60px 20px 40px;
    text-align: center;
    border-bottom: 1px solid #e5e7eb;
}

.gallery-grid-hero h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1E2950;
    margin: 0 0 10px 0;
}

.gallery-grid-hero p {
    color: #6b7280;
    font-size: 1rem;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #6b7280 !important;
    text-decoration: none !important;
    margin-bottom: 20px;
    font-weight: 500;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: #CA4249 !important;
}

.gallery-grid-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px 80px;
}

.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.image-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.image-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.image-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
}

.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.image-wrapper:hover img {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-wrapper:hover .image-overlay {
    opacity: 1;
}

.zoom-icon {
    font-size: 2rem;
    color: white;
}

.image-info {
    padding: 15px;
    text-align: center;
}

.image-title {
    font-size: 0.9rem;
    color: #4a5568;
    font-weight: 500;
}

.no-images {
    text-align: center;
    padding: 100px 20px;
    color: #9ca3af;
}

.no-images i {
    font-size: 5rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .gallery-grid-hero h1 {
        font-size: 2rem;
    }

    .images-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .gallery-grid-container {
        padding: 30px 15px 60px;
    }
}

@media (max-width: 480px) {
    .gallery-grid-hero h1 {
        font-size: 1.5rem;
    }

    .images-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
}
</style>

<main class="gallery-grid-page">
    <!-- Hero Section -->
    <section class="gallery-grid-hero">
        <h1><?php echo esc_html($category->category_name); ?></h1>
        <?php if (!empty($category->shipment_date) || !empty($category->owner)): ?>
            <p>
                <?php if (!empty($category->shipment_date)): ?>
                    <?php echo esc_html($category->shipment_date); ?>
                <?php endif; ?>
                <?php if (!empty($category->owner)): ?>
                    | Owner: <?php echo esc_html($category->owner); ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </section>

    <!-- Content Section -->
    <section class="gallery-grid-container">
        <a href="<?php echo remove_query_arg('category'); ?>" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Gallery
        </a>

        <?php if (!empty($images)): ?>
            <div class="images-grid">
                <?php foreach ($images as $index => $image): ?>
                    <div class="image-card">
                        <a href="<?php echo esc_url(get_gallery_grid_image_url($image->image_url)); ?>"
                           data-lightbox="gallery-<?php echo $category->category_number; ?>"
                           data-title="<?php echo esc_attr($image->title ?: 'Image ' . ($index + 1)); ?>">
                            <div class="image-wrapper">
                                <img src="<?php echo esc_url(get_gallery_grid_image_url($image->image_url)); ?>"
                                     alt="<?php echo esc_attr($image->title ?: $category->category_name); ?>"
                                     loading="lazy">
                                <div class="image-overlay">
                                    <div class="zoom-icon">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php if (!empty($image->title)): ?>
                            <div class="image-info">
                                <div class="image-title"><?php echo esc_html($image->title); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-images">
                <i class="fas fa-images"></i>
                <p>ยังไม่มีรูปภาพในหมวดนี้</p>
            </div>
        <?php endif; ?>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    }
});
</script>
