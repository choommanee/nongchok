<?php
/**
 * Gallery Categories Landing Page
 */

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';

// Check if viewing Behind the Scene or Gallery
$category_param = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$is_behind_scene = ($category_param === 'BTS');

if ($is_behind_scene) {
    // Get ALL images from Behind the Scene categories
    $images_table = $wpdb->prefix . 'gallery_images';
    $all_images = $wpdb->get_results("
        SELECT gi.*, gc.category_name, gc.category_number
        FROM {$images_table} gi
        JOIN {$categories_table} gc ON gi.category_id = gc.id
        WHERE gc.category_type = 'behind_scene'
        ORDER BY gi.sort_order ASC
    ");
    $total_images = count($all_images);
} else {
    // Get ALL images from Gallery categories (same as BTS page layout)
    $images_table = $wpdb->prefix . 'gallery_images';
    $all_images = $wpdb->get_results("
        SELECT gi.*, gc.category_name, gc.category_number
        FROM {$images_table} gi
        JOIN {$categories_table} gc ON gi.category_id = gc.id
        WHERE gc.category_type = 'gallery' OR gc.category_type IS NULL
        ORDER BY gi.sort_order ASC
    ");
    $total_images = count($all_images);
}

// Helper function to get correct image URL (local uses production images)
function get_gallery_image_url($path) {
    // If local development, use production URL
    if (strpos($_SERVER['HTTP_HOST'], '.local') !== false || $_SERVER['HTTP_HOST'] === 'localhost') {
        return 'https://nongchok-production.up.railway.app' . $path;
    }
    // Production uses relative path
    return $path;
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<style>
.gallery-categories-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #fff;
    min-height: 100vh;
}

.gallery-hero {
    background: #fff;
    padding: 60px 20px 40px;
    text-align: center;
}

.gallery-hero h1 {
    font-size: 3.5rem;
    font-weight: 700;
    color: #1E2950;
    margin: 0;
    letter-spacing: 2px;
}

.categories-grid-section {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px 80px;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 60px 80px;
}

.category-card {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    align-items: center;
}

.category-thumbnail-wrapper {
    width: 100%;
    aspect-ratio: 4/3;
    overflow: hidden;
}

.category-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.category-info {
    padding: 0;
}

.category-description {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 15px;
    line-height: 1.6;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1E2950;
    margin-bottom: 15px;
}

.view-gallery-btn {
    display: inline-block;
    background: #CA4249;
    color: white !important;
    padding: 10px 30px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.view-gallery-btn:hover {
    background: #b03840;
    color: white !important;
    text-decoration: none;
}

/* Masonry Grid for BTS Images */
.masonry-grid {
    columns: 4;
    column-gap: 15px;
    margin-top: 40px;
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 15px;
    display: inline-block;
    width: 100%;
    position: relative;
    cursor: pointer;
    overflow: hidden;
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.masonry-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.masonry-item img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.5s ease;
}

.masonry-item:hover img {
    transform: scale(1.05);
}

/* Category name overlay */
.masonry-item .category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
    color: white;
    padding: 20px 15px 15px;
    font-size: 0.9rem;
    font-weight: 500;
    text-align: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.masonry-item:hover .category-overlay {
    opacity: 1;
}

/* Random sizing for masonry effect */
.masonry-item:nth-child(3n+1) img {
    /* Keep original aspect ratio */
}

.masonry-item:nth-child(5n+2) img {
    /* These will naturally vary based on image dimensions */
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 1200px) {
    .masonry-grid {
        columns: 3;
    }
}

@media (max-width: 768px) {
    .gallery-hero h1 {
        font-size: 2.2rem;
    }

    .categories-grid-section {
        padding: 30px 20px 60px;
    }

    .categories-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .category-card {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .category-thumbnail-wrapper {
        aspect-ratio: 16/9;
    }

    .category-title {
        font-size: 1.3rem;
    }

    .category-description {
        font-size: 0.9rem;
    }

    .view-gallery-btn {
        padding: 8px 24px;
        font-size: 0.9rem;
    }

    .masonry-grid {
        columns: 2;
        column-gap: 10px;
    }

    .masonry-item {
        margin-bottom: 10px;
    }
}

@media (max-width: 480px) {
    .gallery-hero h1 {
        font-size: 1.8rem;
    }

    .category-title {
        font-size: 1.1rem;
    }

    .category-description {
        font-size: 0.85rem;
    }

    .view-gallery-btn {
        padding: 7px 20px;
        font-size: 0.85rem;
    }

    .masonry-grid {
        columns: 1;
    }
}
</style>

<main class="gallery-categories-page">

    <!-- Hero Section -->
    <section class="gallery-hero">
        <h1><?php echo $is_behind_scene ? 'BEHIND THE SCENE' : 'GALLERY'; ?></h1>
    </section>

    <!-- Masonry Grid for both Gallery and BTS -->
    <section class="categories-grid-section">
        <?php if (!empty($all_images)): ?>
            <div class="masonry-grid">
                <?php
                $lightbox_id = $is_behind_scene ? 'bts-gallery' : 'main-gallery';
                foreach ($all_images as $index => $image):
                ?>
                    <div class="masonry-item">
                        <a href="<?php echo esc_url(get_gallery_image_url($image->image_url)); ?>"
                           data-lightbox="<?php echo $lightbox_id; ?>"
                           data-title="<?php echo esc_attr($image->category_name); ?> - Photo <?php echo $index + 1; ?>">
                            <img src="<?php echo esc_url(get_gallery_image_url($image->image_url)); ?>"
                                 alt="<?php echo esc_attr($image->category_name); ?> - Photo <?php echo $index + 1; ?>"
                                 loading="lazy">
                            <div class="category-overlay">
                                <?php echo esc_html($image->category_name); ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 100px 20px; color: #718096;">
                <i class="fas fa-images" style="font-size: 5rem; color: #cbd5e0; margin-bottom: 20px;"></i>
                <p>No images available yet.</p>
            </div>
        <?php endif; ?>
    </section>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
});
</script>
