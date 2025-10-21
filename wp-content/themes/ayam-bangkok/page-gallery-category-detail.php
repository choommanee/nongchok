<?php
/**
 * Template Name: Gallery Category Detail
 * Display images for a specific category
 */

get_header();

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';
$images_table = $wpdb->prefix . 'gallery_images';

// Get category from URL parameter
$category_code = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

if (empty($category_code)) {
    // Redirect to gallery main page
    wp_redirect(get_permalink());
    exit;
}

// Get category info
$category = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM {$categories_table} WHERE category_number = %s",
    $category_code
));

if (!$category) {
    echo '<p>Category not found.</p>';
    get_footer();
    exit;
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
.category-detail-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #f7fafc;
    min-height: 100vh;
}

.category-detail-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 20px 40px;
    position: relative;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: white;
    text-decoration: none;
    margin-bottom: 30px;
    font-weight: 500;
    transition: transform 0.3s ease;
}

.back-button:hover {
    transform: translateX(-5px);
    color: white;
}

.category-detail-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.category-detail-meta {
    display: flex;
    gap: 30px;
    font-size: 1.1rem;
    opacity: 0.9;
}

.category-images-section {
    max-width: 1400px;
    margin: -20px auto 0;
    padding: 0 20px 80px;
}

.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 40px;
}

.image-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
}

.image-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.image-card img {
    width: 100%;
    height: 350px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.image-card:hover img {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 20px;
}

.image-card:hover .image-overlay {
    opacity: 1;
}

.image-info {
    color: white;
    font-size: 0.9rem;
}

.zoom-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-card:hover .zoom-icon {
    opacity: 0.9;
}

@media (max-width: 768px) {
    .category-detail-title {
        font-size: 2rem;
    }

    .category-detail-meta {
        flex-direction: column;
        gap: 10px;
    }

    .images-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<main class="category-detail-page">

    <!-- Header -->
    <section class="category-detail-header">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
            <a href="<?php echo get_permalink(); ?>" class="back-button">
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
        <div style="max-width: 1400px; margin: 40px auto; padding: 0 20px;">
            <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 20px; color: #2d3748;">
                <i class="fas fa-video"></i> Video Showcase
            </h2>
            <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <iframe
                    src="<?php echo esc_url($category->video_url); ?>"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Images Grid -->
    <section class="category-images-section">
        <?php if (!empty($images)): ?>
            <div class="images-grid">
                <?php foreach ($images as $index => $image): ?>
                    <div class="image-card" data-aos="fade-up" data-aos-delay="<?php echo ($index % 12) * 50; ?>">
                        <a href="<?php echo esc_url($image->image_url); ?>"
                           data-lightbox="gallery-<?php echo $category->category_number; ?>"
                           data-title="<?php echo esc_attr($category->category_name); ?> - Photo <?php echo $index + 1; ?>">

                            <img src="<?php echo esc_url($image->image_url); ?>"
                                 alt="<?php echo esc_attr($category->category_name); ?> - <?php echo $index + 1; ?>">

                            <div class="image-overlay">
                                <div class="zoom-icon">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                                <div class="image-info">
                                    Photo <?php echo $index + 1; ?>
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

    // Lightbox options
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
    }
});
</script>

<?php
get_footer();
