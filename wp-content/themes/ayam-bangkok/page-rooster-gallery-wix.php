<?php
/**
 * Template Name: Rooster Gallery (Wix Style)
 * แกลเลอรี่ไก่แบบ Wix - แสดงหมายเลขไก่
 */

get_header();
?>

<div class="rooster-gallery-wix">
    <div class="container">
        <header class="gallery-header">
            <h1>🐓 Rooster Catalog</h1>
            <p>คลิกหมายเลขเพื่อดูรายละเอียด รูปภาพ และวิดีโอของไก่แต่ละตัว</p>
        </header>

        <!-- Filter -->
        <div class="gallery-filter">
            <button class="filter-btn active" data-filter="all">ทั้งหมด</button>
            <button class="filter-btn" data-filter="ready">พร้อมส่งออก</button>
            <button class="filter-btn" data-filter="pending">กำลังเตรียม</button>
            <button class="filter-btn" data-filter="exported">ส่งออกแล้ว</button>
        </div>

        <!-- Gallery Grid -->
        <div class="rooster-grid">
            <?php
            $roosters = new WP_Query(array(
                'post_type' => 'rooster_catalog',
                'posts_per_page' => -1,
                'orderby' => 'meta_value',
                'meta_key' => 'rooster_number',
                'order' => 'ASC'
            ));

            if ($roosters->have_posts()) :
                while ($roosters->have_posts()) : $roosters->the_post();
                    $rooster_number = get_post_meta(get_the_ID(), 'rooster_number', true);
                    $export_status = get_post_meta(get_the_ID(), 'export_status', true);
                    $status_class = 'status-' . $export_status;
                    $status_text = array(
                        'ready' => 'พร้อมส่งออก',
                        'pending' => 'กำลังเตรียม',
                        'exported' => 'ส่งออกแล้ว'
                    );
                    ?>
                    <div class="rooster-card" data-status="<?php echo esc_attr($export_status); ?>">
                        <a href="<?php the_permalink(); ?>" class="rooster-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="rooster-image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php else : ?>
                                <div class="rooster-image rooster-placeholder">
                                    <span class="rooster-icon">🐓</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="rooster-info">
                                <div class="rooster-number"><?php echo esc_html($rooster_number); ?></div>
                                <div class="rooster-status <?php echo esc_attr($status_class); ?>">
                                    <?php echo esc_html($status_text[$export_status] ?? 'ไม่ระบุ'); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="no-roosters">ยังไม่มีข้อมูลไก่</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>