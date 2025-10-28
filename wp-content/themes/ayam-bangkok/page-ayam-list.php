<?php
/**
 * Template Name: Ayam List (Shipment List)
 * Display list of shipments for roosters
 */

get_header();
?>

<style>
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
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 80px 80px;
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
    .ayam-list-hero h1 {
        font-size: 2.2rem;
    }

    .ayam-list-container {
        padding: 30px 20px 60px;
    }

    .shipment-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}
</style>

<main class="ayam-list-page">
    <!-- Hero Section -->
    <section class="ayam-list-hero">
        <h1>AYAM LIST</h1>
    </section>

    <!-- Shipment Grid -->
    <section class="ayam-list-container">

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
    </section>
</main>

<?php
get_footer();
?>
