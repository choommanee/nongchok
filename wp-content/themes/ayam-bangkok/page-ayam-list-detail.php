<?php
/**
 * Template Name: Ayam List Detail (Rooster by Shipment)
 * Display roosters filtered by shipment number
 */

get_header();

$shipment = isset($_GET['shipment']) ? intval($_GET['shipment']) : 0;
?>

<style>
.ayam-detail-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.back-button {
    display: inline-block;
    margin-bottom: 30px;
    padding: 10px 20px;
    background: #34495e;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.back-button:hover {
    background: #2c3e50;
}

.shipment-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 40px;
    text-align: center;
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
    .shipment-title {
        font-size: 1.8rem;
    }

    .rooster-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
}
</style>

<div class="ayam-detail-container">
    <a href="<?php echo esc_url(home_url('/ayam-list/')); ?>" class="back-button">
        ← Back to Shipment List
    </a>

    <h1 class="shipment-title">Shipment <?php echo $shipment; ?></h1>

    <div class="rooster-grid">
        <?php
        // Query roosters from gallery categories with this shipment
        global $wpdb;
        
        // Find categories with this shipment number
        $categories = $wpdb->get_results($wpdb->prepare(
            "SELECT category_number, category_name FROM {$wpdb->prefix}gallery_categories 
            WHERE shipment_date LIKE %s OR category_name LIKE %s",
            '%Shipment ' . $shipment . '%',
            '%Shipment ' . $shipment . '%'
        ));
        
        if ($categories) {
            foreach ($categories as $category) {
                // Get images for this category
                $images = $wpdb->get_results($wpdb->prepare(
                    "SELECT * FROM {$wpdb->prefix}gallery_images 
                    WHERE category_number = %s 
                    ORDER BY image_order ASC, id ASC 
                    LIMIT 20",
                    $category->category_number
                ));
                
                if ($images) {
                    foreach ($images as $image) {
                        ?>
                        <div class="rooster-card">
                            <a href="<?php echo esc_url(home_url('/gallery/?category=' . $category->category_number)); ?>">
                                <img src="<?php echo esc_url($image->image_url); ?>" 
                                     alt="<?php echo esc_attr($category->category_name); ?>"
                                     loading="lazy">
                            </a>
                            <div class="rooster-card-content">
                                <h3><?php echo esc_html($category->category_name); ?></h3>
                                <p>Category: <?php echo esc_html($category->category_number); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        } else {
            echo '<div class="no-roosters">No roosters found for Shipment ' . $shipment . '</div>';
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>
