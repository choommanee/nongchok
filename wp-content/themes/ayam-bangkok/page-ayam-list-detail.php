<?php
/**
 * Template Name: Ayam List Detail (Rooster by Shipment)
 * Display roosters filtered by shipment number
 */

get_header();

$shipment = isset($_GET['shipment']) ? intval($_GET['shipment']) : 0;
?>

<style>
.ayam-detail-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #fff;
    min-height: 100vh;
}

.ayam-detail-hero {
    background: #fff;
    padding: 60px 20px 40px;
    text-align: center;
}

.ayam-detail-hero h1 {
    font-size: 3.5rem;
    font-weight: 700;
    color: #1E2950;
    margin: 0;
    letter-spacing: 2px;
}

.ayam-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 80px 80px;
}

.back-button {
    display: inline-block;
    margin-bottom: 30px;
    padding: 10px 30px;
    background: #CA4249;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.back-button:hover {
    background: #b03840;
    color: white;
    text-decoration: none;
}

.rooster-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.rooster-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.rooster-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.rooster-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.rooster-card-content {
    padding: 20px;
}

.rooster-card-content h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #2c3e50;
}

.rooster-card-content p {
    color: #7f8c8d;
    margin: 5px 0;
    font-size: 0.9rem;
}

.no-roosters {
    text-align: center;
    padding: 60px 20px;
    color: #95a5a6;
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .ayam-detail-hero h1 {
        font-size: 2.2rem;
    }

    .ayam-detail-container {
        padding: 30px 20px 60px;
    }

    .rooster-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
}
</style>

<main class="ayam-detail-page">
    <!-- Hero Section -->
    <section class="ayam-detail-hero">
        <h1>Shipment <?php echo $shipment; ?></h1>
    </section>

    <!-- Content Section -->
    <section class="ayam-detail-container">
        <a href="<?php echo esc_url(home_url('/ayam-list/')); ?>" class="back-button">
            ← Back to Shipment List
        </a>

    <div class="rooster-grid">
        <?php
        // Query roosters from gallery categories with this shipment
        global $wpdb;

        // Find categories with this shipment number (exact match on shipment_date field)
        $categories = $wpdb->get_results($wpdb->prepare(
            "SELECT c.category_number, c.category_name, c.image_count, c.thumbnail_url
            FROM {$wpdb->prefix}gallery_categories c
            WHERE c.shipment_date = %s
            AND c.category_type = 'ayam_list'
            ORDER BY c.category_number ASC",
            'Shipment ' . $shipment
        ));

        if ($categories && count($categories) > 0) {
            foreach ($categories as $category) {
                // Get first image for this category
                $first_image = $wpdb->get_row($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}gallery_images
                    WHERE category_number = %s
                    ORDER BY image_order ASC, id ASC
                    LIMIT 1",
                    $category->category_number
                ));

                // Use thumbnail or first image
                $image_url = $category->thumbnail_url;
                if (!$image_url && $first_image) {
                    $image_url = $first_image->image_url;
                }

                if ($image_url) {
                    ?>
                    <div class="rooster-card">
                        <a href="<?php echo esc_url(home_url('/gallery/?category=' . $category->category_number)); ?>">
                            <img src="<?php echo esc_url($image_url); ?>"
                                 alt="<?php echo esc_attr($category->category_name); ?>"
                                 loading="lazy">
                        </a>
                        <div class="rooster-card-content">
                            <h3><?php echo esc_html($category->category_name); ?></h3>
                            <p>Category: <?php echo esc_html($category->category_number); ?></p>
                            <p><?php echo esc_html($category->image_count); ?> images</p>
                        </div>
                    </div>
                    <?php
                }
            }
        } else {
            echo '<div class="no-roosters">ยังไม่มีไก่ใน Shipment ' . $shipment . '<br><small>กรุณาสร้าง category และตั้งค่า shipment ที่หน้า Admin</small></div>';
        }
        ?>
    </div>
    </section>
</main>

<?php
get_footer();
?>
