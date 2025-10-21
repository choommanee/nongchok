<?php
/**
 * Gallery Categories Landing Page
 */

global $wpdb;
$categories_table = $wpdb->prefix . 'gallery_categories';

// Get all categories
$categories = $wpdb->get_results("
    SELECT * FROM {$categories_table}
    ORDER BY category_number ASC
");

$total_images = $wpdb->get_var("SELECT SUM(image_count) FROM {$categories_table}");

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
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

.gallery-hero {
    background: linear-gradient(135deg, #CA4249 0%, #b03840 100%);
    color: white;
    padding: 80px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.gallery-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.gallery-hero-content {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin: 0 auto;
}

.gallery-hero h1 {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    animation: fadeInUp 0.8s ease;
}

.gallery-hero p {
    font-size: 1.3rem;
    opacity: 0.95;
    animation: fadeInUp 0.8s ease 0.2s both;
}

.gallery-stats {
    display: flex;
    justify-content: center;
    gap: 50px;
    margin-top: 40px;
    animation: fadeInUp 0.8s ease 0.4s both;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    display: block;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.categories-grid-section {
    max-width: 1400px;
    margin: -50px auto 0;
    padding: 0 20px 80px;
    position: relative;
    z-index: 2;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.category-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.category-thumbnail-wrapper {
    width: 100%;
    height: 250px;
    overflow: hidden;
}

.category-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-card:hover .category-thumbnail {
    transform: scale(1.1);
}

.category-info {
    padding: 25px;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.category-badge {
    background: linear-gradient(135deg, #CA4249 0%, #b03840 100%);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.category-meta {
    display: flex;
    align-items: center;
    gap: 15px;
    color: #a0aec0;
    font-size: 0.9rem;
}

.category-meta i {
    color: #CA4249;
}

.view-gallery-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #CA4249 0%, #b03840 100%);
    color: white !important;
    padding: 12px 25px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 15px;
    transition: all 0.3s ease;
}

.view-gallery-btn:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(202, 66, 73, 0.4);
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
    .gallery-hero {
        padding: 60px 20px 40px;
    }

    .gallery-hero h1 {
        font-size: 2.2rem;
    }

    .gallery-hero p {
        font-size: 1.1rem;
    }

    .gallery-stats {
        gap: 25px;
        flex-wrap: wrap;
    }

    .stat-number {
        font-size: 1.8rem;
    }

    .stat-label {
        font-size: 0.8rem;
    }

    .categories-grid-section {
        padding: 0 15px 60px;
        margin-top: -30px;
    }

    .categories-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .category-card {
        border-radius: 15px;
    }

    .category-thumbnail-wrapper {
        height: 180px;
    }

    .category-info {
        padding: 12px;
    }

    .category-title {
        font-size: 1.1rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .category-badge {
        font-size: 0.7rem;
        padding: 4px 10px;
    }

    .category-meta {
        font-size: 0.75rem;
        gap: 8px;
    }

    .view-gallery-btn {
        padding: 8px 16px;
        font-size: 0.8rem;
        margin-top: 10px;
    }
}

@media (max-width: 480px) {
    .gallery-hero h1 {
        font-size: 1.6rem;
    }

    .categories-grid {
        gap: 10px;
    }

    .category-thumbnail-wrapper {
        height: 140px;
    }

    .category-info {
        padding: 10px;
    }

    .category-title {
        font-size: 0.95rem;
    }

    .category-badge {
        font-size: 0.65rem;
        padding: 3px 8px;
    }

    .category-meta {
        font-size: 0.7rem;
    }

    .view-gallery-btn {
        padding: 6px 12px;
        font-size: 0.75rem;
        gap: 6px;
    }
}
</style>

<main class="gallery-categories-page">

    <!-- Hero Section -->
    <section class="gallery-hero">
        <div class="gallery-hero-content">
            <h1>🐓 Rooster Gallery</h1>
            <p>Browse our complete collection of premium Thai fighting roosters</p>

            <div class="gallery-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($categories); ?></span>
                    <span class="stat-label">Roosters</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $total_images ?: 0; ?></span>
                    <span class="stat-label">Photos</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="categories-grid-section">
        <?php if (!empty($categories)): ?>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card" data-aos="fade-up">
                        <a href="<?php echo add_query_arg('category', $category->category_number, get_permalink()); ?>">
                            <div class="category-thumbnail-wrapper">
                                <?php if ($category->thumbnail_url): ?>
                                    <img src="<?php echo esc_url(get_gallery_image_url($category->thumbnail_url)); ?>"
                                         alt="<?php echo esc_attr($category->category_name); ?>"
                                         class="category-thumbnail">
                                <?php else: ?>
                                    <div class="category-thumbnail" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="category-info">
                            <h3 class="category-title">
                                <span><?php echo esc_html($category->category_name); ?></span>
                                <span class="category-badge">#<?php echo $category->category_number; ?></span>
                            </h3>

                            <div class="category-meta">
                                <span><i class="fas fa-images"></i> <?php echo $category->image_count; ?> Photos</span>
                            </div>

                            <a href="<?php echo add_query_arg('category', $category->category_number, get_permalink()); ?>"
                               class="view-gallery-btn">
                                View Gallery <i class="fas fa-arrow-right"></i>
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
