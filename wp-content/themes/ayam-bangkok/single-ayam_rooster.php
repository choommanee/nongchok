<?php
/**
 * Single Rooster template - Wix Style
 */

get_header(); ?>

<main id="primary" class="site-main single-rooster wix-style-single-rooster">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Breadcrumb -->
        <section class="breadcrumb-section">
            <div class="container">
                <?php ayam_breadcrumb(); ?>
            </div>
        </section>

        <!-- Rooster Header -->
        <section class="rooster-header">
            <div class="container">
                <div class="rooster-header-content">
                    <div class="rooster-gallery">
                        <div class="main-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>" class="rooster-main-image">
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-rooster.jpg" alt="<?php the_title(); ?>" class="rooster-main-image">
                            <?php endif; ?>
                            
                            <!-- Status Badge -->
                            <?php
                            $status = ayam_get_field('rooster_status');
                            $status_labels = array(
                                'available' => __('พร้อมส่งออก', 'ayam-bangkok'),
                                'reserved' => __('จองแล้ว', 'ayam-bangkok'),
                                'sold' => __('ขายแล้ว', 'ayam-bangkok')
                            );
                            
                            if ($status && isset($status_labels[$status])) :
                            ?>
                                <div class="status-badge status-<?php echo esc_attr($status); ?>">
                                    <?php echo esc_html($status_labels[$status]); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Thumbnail Gallery -->
                        <?php
                        $gallery = ayam_get_field('rooster_gallery');
                        if (!empty($gallery)) :
                        ?>
                            <div class="thumbnail-gallery">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php the_title(); ?>" class="thumbnail active" data-large="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>">
                                <?php endif; ?>
                                
                                <?php foreach ($gallery as $image) : ?>
                                    <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="thumbnail" data-large="<?php echo esc_url($image['sizes']['large']); ?>">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="rooster-info">
                        <!-- Rooster Number Badge -->
                        <?php
                        $rooster_number = get_post_meta(get_the_ID(), 'rooster_number', true);
                        if ($rooster_number) :
                        ?>
                            <div class="rooster-number-badge">
                                <i class="fas fa-hashtag"></i>
                                <span><?php echo esc_html($rooster_number); ?></span>
                            </div>
                        <?php endif; ?>

                        <h1 class="rooster-title"><?php the_title(); ?></h1>
                        
                        <!-- Price -->
                        <?php
                        $price = ayam_get_field('rooster_price');
                        if ($price) :
                        ?>
                            <div class="rooster-price">
                                <span class="price-label"><?php _e('ราคา:', 'ayam-bangkok'); ?></span>
                                <span class="price-amount"><?php echo ayam_format_price($price); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Quick Details -->
                        <div class="quick-details">
                            <?php
                            $age = ayam_get_field('rooster_age');
                            $weight = ayam_get_field('rooster_weight');
                            $color = ayam_get_field('rooster_color');
                            ?>
                            
                            <?php if ($age) : ?>
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span class="detail-label"><?php _e('อายุ:', 'ayam-bangkok'); ?></span>
                                    <span class="detail-value"><?php echo ayam_format_age($age); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($weight) : ?>
                                <div class="detail-item">
                                    <i class="fas fa-weight"></i>
                                    <span class="detail-label"><?php _e('น้ำหนัก:', 'ayam-bangkok'); ?></span>
                                    <span class="detail-value"><?php echo ayam_format_weight($weight); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($color) : ?>
                                <div class="detail-item">
                                    <i class="fas fa-palette"></i>
                                    <span class="detail-label"><?php _e('สี:', 'ayam-bangkok'); ?></span>
                                    <span class="detail-value"><?php echo esc_html($color); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="rooster-actions">
                            <button class="btn btn-primary btn-large inquiry-btn" data-rooster-id="<?php echo get_the_ID(); ?>">
                                <i class="fas fa-envelope"></i>
                                <?php _e('สอบถามไก่ชนนี้', 'ayam-bangkok'); ?>
                            </button>
                            
                            <button class="btn btn-outline btn-large favorite-btn" data-rooster-id="<?php echo get_the_ID(); ?>">
                                <i class="far fa-heart"></i>
                                <?php _e('เพิ่มในรายการโปรด', 'ayam-bangkok'); ?>
                            </button>
                            
                            <div class="action-buttons-secondary">
                                <button class="btn btn-secondary share-btn" data-rooster-id="<?php echo get_the_ID(); ?>">
                                    <i class="fas fa-share-alt"></i>
                                    <?php _e('แชร์', 'ayam-bangkok'); ?>
                                </button>
                                
                                <button class="btn btn-secondary compare-btn" data-rooster-id="<?php echo get_the_ID(); ?>">
                                    <i class="fas fa-balance-scale"></i>
                                    <?php _e('เปรียบเทียบ', 'ayam-bangkok'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>      
  <!-- Rooster Details Tabs -->
        <section class="rooster-details-section">
            <div class="container">
                <div class="details-tabs">
                    <nav class="tabs-nav">
                        <button class="tab-btn active" data-tab="description"><?php _e('รายละเอียด', 'ayam-bangkok'); ?></button>
                        <button class="tab-btn" data-tab="specifications"><?php _e('ข้อมูลเทคนิค', 'ayam-bangkok'); ?></button>
                        <button class="tab-btn" data-tab="pedigree"><?php _e('สายเลือด', 'ayam-bangkok'); ?></button>
                        <button class="tab-btn" data-tab="health"><?php _e('สุขภาพ', 'ayam-bangkok'); ?></button>
                        <button class="tab-btn" data-tab="fighting"><?php _e('ประวัติการแข่งขัน', 'ayam-bangkok'); ?></button>
                    </nav>
                    
                    <div class="tabs-content">
                        <!-- Description Tab -->
                        <div class="tab-panel active" id="description">
                            <div class="tab-content">
                                <h3><?php _e('รายละเอียดไก่ชน', 'ayam-bangkok'); ?></h3>
                                <div class="rooster-description">
                                    <?php the_content(); ?>
                                </div>
                                
                                <!-- Taxonomy Info -->
                                <div class="taxonomy-info">
                                    <?php
                                    $breeds = wp_get_post_terms(get_the_ID(), 'rooster_breed');
                                    if (!empty($breeds)) :
                                    ?>
                                        <div class="taxonomy-item">
                                            <strong><?php _e('สายพันธุ์:', 'ayam-bangkok'); ?></strong>
                                            <?php foreach ($breeds as $breed) : ?>
                                                <span class="taxonomy-tag"><?php echo esc_html($breed->name); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php
                                    $categories = wp_get_post_terms(get_the_ID(), 'rooster_category');
                                    if (!empty($categories)) :
                                    ?>
                                        <div class="taxonomy-item">
                                            <strong><?php _e('หมวดหมู่:', 'ayam-bangkok'); ?></strong>
                                            <?php foreach ($categories as $category) : ?>
                                                <span class="taxonomy-tag"><?php echo esc_html($category->name); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Specifications Tab -->
                        <div class="tab-panel" id="specifications">
                            <div class="tab-content">
                                <h3><?php _e('ข้อมูลเทคนิค', 'ayam-bangkok'); ?></h3>
                                <div class="specifications-grid">
                                    <?php
                                    $specs = array(
                                        'rooster_age' => __('อายุ', 'ayam-bangkok'),
                                        'rooster_weight' => __('น้ำหนัก', 'ayam-bangkok'),
                                        'rooster_height' => __('ความสูง', 'ayam-bangkok'),
                                        'rooster_color' => __('สี', 'ayam-bangkok'),
                                        'rooster_leg_color' => __('สีขา', 'ayam-bangkok'),
                                        'rooster_comb_type' => __('ประเภทหงอน', 'ayam-bangkok'),
                                        'rooster_origin' => __('ที่มา', 'ayam-bangkok'),
                                        'rooster_vaccination' => __('การฉีดวัคซีน', 'ayam-bangkok')
                                    );
                                    
                                    foreach ($specs as $field => $label) :
                                        $value = ayam_get_field($field);
                                        if ($value) :
                                    ?>
                                        <div class="spec-item">
                                            <span class="spec-label"><?php echo esc_html($label); ?>:</span>
                                            <span class="spec-value">
                                                <?php 
                                                if ($field == 'rooster_age') {
                                                    echo ayam_format_age($value);
                                                } elseif ($field == 'rooster_weight') {
                                                    echo ayam_format_weight($value);
                                                } else {
                                                    echo esc_html($value);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    <?php endif; endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pedigree Tab -->
                        <div class="tab-panel" id="pedigree">
                            <div class="tab-content">
                                <h3><?php _e('ข้อมูลสายเลือด', 'ayam-bangkok'); ?></h3>
                                <?php
                                $pedigree = ayam_get_field('rooster_pedigree');
                                if ($pedigree) :
                                ?>
                                    <div class="pedigree-info">
                                        <?php echo wpautop($pedigree); ?>
                                    </div>
                                <?php else : ?>
                                    <p><?php _e('ไม่มีข้อมูลสายเลือด', 'ayam-bangkok'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Health Tab -->
                        <div class="tab-panel" id="health">
                            <div class="tab-content">
                                <h3><?php _e('ข้อมูลสุขภาพ', 'ayam-bangkok'); ?></h3>
                                <?php
                                $health = ayam_get_field('rooster_health_info');
                                if ($health) :
                                ?>
                                    <div class="health-info">
                                        <?php echo wpautop($health); ?>
                                    </div>
                                <?php else : ?>
                                    <p><?php _e('ไม่มีข้อมูลสุขภาพ', 'ayam-bangkok'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Fighting History Tab -->
                        <div class="tab-panel" id="fighting">
                            <div class="tab-content">
                                <h3><?php _e('ประวัติการแข่งขัน', 'ayam-bangkok'); ?></h3>
                                <?php
                                $fighting_history = ayam_get_field('rooster_fighting_history');
                                if ($fighting_history) :
                                ?>
                                    <div class="fighting-history">
                                        <?php echo wpautop($fighting_history); ?>
                                    </div>
                                <?php else : ?>
                                    <p><?php _e('ไม่มีประวัติการแข่งขัน', 'ayam-bangkok'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Roosters -->
        <section class="related-roosters-section">
            <div class="container">
                <div class="section-header">
                    <h2><?php _e('ไก่ชนที่เกี่ยวข้อง', 'ayam-bangkok'); ?></h2>
                    <p><?php _e('ไก่ชนอื่นๆ ที่คุณอาจสนใจ', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="related-grid">
                    <?php
                    // Get related roosters by breed
                    $breeds = wp_get_post_terms(get_the_ID(), 'rooster_breed', array('fields' => 'ids'));
                    
                    $related_query = new WP_Query(array(
                        'post_type' => 'ayam_rooster',
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'rooster_breed',
                                'field' => 'term_id',
                                'terms' => $breeds
                            )
                        ),
                        'orderby' => 'rand'
                    ));
                    
                    if ($related_query->have_posts()) :
                        while ($related_query->have_posts()) : $related_query->the_post();
                    ?>
                        <div class="related-card">
                            <div class="related-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('rooster-card'); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php
                                $price = ayam_get_field('rooster_price');
                                if ($price) :
                                ?>
                                    <div class="price-badge"><?php echo ayam_format_price($price); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="related-content">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                
                                <div class="related-details">
                                    <?php
                                    $age = ayam_get_field('rooster_age');
                                    $weight = ayam_get_field('rooster_weight');
                                    ?>
                                    
                                    <?php if ($age) : ?>
                                        <span class="detail"><?php echo ayam_format_age($age); ?></span>
                                    <?php endif; ?>
                                    
                                    <?php if ($weight) : ?>
                                        <span class="detail"><?php echo ayam_format_weight($weight); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="related-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-small btn-primary">
                                        <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                                    </a>
                                    <button class="btn btn-small btn-outline inquiry-btn" data-rooster-id="<?php echo get_the_ID(); ?>">
                                        <?php _e('สอบถาม', 'ayam-bangkok'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <p><?php _e('ไม่มีไก่ชนที่เกี่ยวข้อง', 'ayam-bangkok'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Rooster Videos Section -->
        <?php get_template_part('template-parts/rooster-videos'); ?>

    <?php endwhile; ?>

</main><!-- #primary -->

<?php get_footer(); ?>