<?php
/**
 * Template Name: Ayam List (Shipment List)
 * Display list of shipments for roosters with masonry grid layout
 */

get_header();

global $wpdb;
$shipments_table = $wpdb->prefix . 'ayam_shipments';

// Get all shipments with images
$shipments = $wpdb->get_results("
    SELECT * FROM {$shipments_table}
    WHERE shipment_number >= 6 AND shipment_number <= 13
    ORDER BY shipment_number ASC
");
?>

<style>
body {
    padding-top: 60px !important;
}

.ayam-list-page {
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    background: #fff;
    min-height: 100vh;
}

.ayam-list-hero {
    background: #fff;
    padding: 60px 20px 40px;
    text-align: center;
}

.ayam-list-hero h1 {
    font-size: 3.5rem;
    font-weight: 700;
    color: #1E2950;
    margin: 0;
    letter-spacing: 2px;
}

.ayam-list-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px 80px;
}

/* Masonry Grid Layout - Same as Gallery */
.masonry-grid {
    column-count: 4;
    column-gap: 20px;
    padding: 0;
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background: #f5f5f5;
}

.masonry-item a {
    display: block;
    position: relative;
    overflow: hidden;
}

.masonry-item img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.masonry-item:hover img {
    transform: scale(1.05);
}

.shipment-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(30, 41, 80, 0.9), transparent);
    color: white;
    padding: 20px 15px 15px;
    font-weight: 600;
    font-size: 1.1rem;
    text-align: center;
    letter-spacing: 1px;
}

/* Responsive */
@media (max-width: 1200px) {
    .masonry-grid {
        column-count: 3;
    }
}

@media (max-width: 768px) {
    .ayam-list-hero h1 {
        font-size: 2.2rem;
    }

    .masonry-grid {
        column-count: 2;
        column-gap: 15px;
    }
    
    .masonry-item {
        margin-bottom: 15px;
    }
}

@media (max-width: 480px) {
    .masonry-grid {
        column-count: 1;
    }
}
</style>

<main class="ayam-list-page">
    <!-- Hero Section -->
    <section class="ayam-list-hero">
        <h1>AYAM LIST</h1>
    </section>

    <!-- Masonry Grid -->
    <section class="ayam-list-container">
        <div class="masonry-grid">
            <?php
            if ($shipments) {
                foreach ($shipments as $shipment) {
                    $shipment_url = home_url('/ayam-list-detail/?shipment=' . $shipment->shipment_number);
                    
                    // Get thumbnail image for this shipment
                    $thumbnail = '';
                    if (!empty($shipment->thumbnail_url)) {
                        $thumbnail = $shipment->thumbnail_url;
                    } else {
                        // Fallback to placeholder
                        $thumbnail = get_template_directory_uri() . '/assets/images/placeholder-rooster.jpg';
                    }
                    
                    echo '<div class="masonry-item">';
                    echo '<a href="' . esc_url($shipment_url) . '">';
                    echo '<img src="' . esc_url($thumbnail) . '" alt="Shipment ' . $shipment->shipment_number . '" loading="lazy">';
                    echo '<div class="shipment-overlay">';
                    echo 'Shipment ' . $shipment->shipment_number;
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                // Fallback if no shipments in database
                for ($i = 6; $i <= 13; $i++) {
                    $shipment_url = home_url('/ayam-list-detail/?shipment=' . $i);
                    echo '<div class="masonry-item">';
                    echo '<a href="' . esc_url($shipment_url) . '">';
                    echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder-rooster.jpg" alt="Shipment ' . $i . '" loading="lazy">';
                    echo '<div class="shipment-overlay">';
                    echo 'Shipment ' . $i;
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>
</main>

<?php
get_footer();
?>
