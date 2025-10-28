<?php
/**
 * Template Name: Ayam List (Shipment List)
 * Display list of shipments for roosters
 */

get_header();
?>

<style>
.ayam-list-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    text-align: center;
}

.ayam-list-title {
    font-size: 3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 60px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.shipment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    max-width: 900px;
    margin: 0 auto;
}

.shipment-card {
    background: white;
    border: 2px solid #34495e;
    border-radius: 8px;
    padding: 30px 20px;
    text-decoration: none;
    color: #2c3e50;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 1.1rem;
}

.shipment-card:hover {
    background: #34495e;
    color: white;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .ayam-list-title {
        font-size: 2rem;
    }

    .shipment-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}
</style>

<div class="ayam-list-container">
    <h1 class="ayam-list-title">AYAM LIST</h1>

    <div class="shipment-grid">
        <?php
        // Display Shipment 6 to 13 (as shown in the screenshot)
        for ($i = 6; $i <= 13; $i++) {
            $shipment_url = home_url('/ayam-list-detail/?shipment=' . $i);
            echo '<a href="' . esc_url($shipment_url) . '" class="shipment-card">';
            echo 'Shipment ' . $i;
            echo '</a>';
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>
