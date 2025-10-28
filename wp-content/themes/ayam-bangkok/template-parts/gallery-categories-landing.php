<?php
/**
 * Gallery Categories Landing Page
 */

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';

// Get only 'gallery' type categories (not ayam_list or behind_scene)
$categories = $wpdb->get_results("
    SELECT * FROM {$categories_table}
    WHERE category_type = 'gallery' OR category_type IS NULL
    ORDER BY category_number ASC
");

$total_images = $wpdb->get_var("SELECT SUM(image_count) FROM {$categories_table} WHERE category_type = 'gallery' OR category_type IS NULL");

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
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 80px 80px;
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
}
</style>

<main class="gallery-categories-page">

    <!-- Hero Section -->
    <section class="gallery-hero">
        <h1>AYAM LIST</h1>
    </section>

    <!-- Categories Grid -->
    <section class="categories-grid-section">
        <?php if (!empty($categories)): ?>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <div class="category-thumbnail-wrapper">
                            <?php if ($category->thumbnail_url): ?>
                                <img src="<?php echo esc_url(get_gallery_image_url($category->thumbnail_url)); ?>"
                                     alt="<?php echo esc_attr($category->category_name); ?>"
                                     class="category-thumbnail">
                            <?php else: ?>
                                <div class="category-thumbnail" style="background: #f0f0f0;"></div>
                            <?php endif; ?>
                        </div>

                        <div class="category-info">
                            <p class="category-description">Describe one of your services</p>
                            <h3 class="category-title"><?php echo esc_html($category->category_name); ?></h3>
                            <a href="<?php echo add_query_arg('category', $category->category_number, get_permalink()); ?>"
                               class="view-gallery-btn">
                                Read More
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 100px 20px; color: #718096;">
                <i class="fas fa-images" style="font-size: 5rem; color: #cbd5e0; margin-bottom: 20px;"></i>
                <p>No galleries available yet.</p>
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
