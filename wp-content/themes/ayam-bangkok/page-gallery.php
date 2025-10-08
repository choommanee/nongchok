<?php
/**
 * Template Name: Gallery Page
 * Description: แกลเลอรี่ไก่ชนทั้งหมด
 */

get_header(); ?>

<main id="primary" class="site-main gallery-page">
    
    <!-- Page Header -->
    <section class="page-header gallery-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('แกลเลอรี่ไก่ชน', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('ไก่ชนคุณภาพสูงพร้อมส่งออกไปยังประเทศอินโดนีเซีย', 'ayam-bangkok'); ?></p>
                
                <!-- Quick Stats -->
                <div class="gallery-stats">
                    <?php
                    $total_roosters = wp_count_posts('ayam_rooster')->publish;
                    $available_roosters = new WP_Query(array(
                        'post_type' => 'ayam_rooster',
                        'meta_query' => array(
                            array(
                                'key' => 'rooster_status',
                                'value' => 'available',
                                'compare' => '='
                            )
                        ),
                        'fields' => 'ids'
                    ));
                    ?>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo number_format($total_roosters); ?></span>
                        <span class="stat-label"><?php _e('ไก่ชนทั้งหมด', 'ayam-bangkok'); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo number_format($available_roosters->found_posts); ?></span>
                        <span class="stat-label"><?php _e('พร้อมส่งออก', 'ayam-bangkok'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Search and Filter -->
    <section class="gallery-filter-section">
        <div class="container">
            <div class="filter-container">
                <!-- Basic Search -->
                <div class="basic-search">
                    <div class="search-input-group">
                        <input type="text" id="gallery-search" placeholder="<?php _e('ค้นหาไก่ชนด้วยหมายเลขหรือชื่อ...', 'ayam-bangkok'); ?>">
                        <button class="search-btn" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Quick Filters -->
                <div class="quick-filters">
                    <button class="quick-filter-btn active" data-filter="all"><?php _e('ทั้งหมด', 'ayam-bangkok'); ?></button>
                    <button class="quick-filter-btn" data-filter="available"><?php _e('พร้อมส่งออก', 'ayam-bangkok'); ?></button>
                    <button class="quick-filter-btn" data-filter="premium"><?php _e('ไก่ชนพรีเมียม', 'ayam-bangkok'); ?></button>
                    <button class="quick-filter-btn" data-filter="new"><?php _e('เพิ่มใหม่', 'ayam-bangkok'); ?></button>
                </div>

                <!-- Sort Options -->
                <div class="sort-options">
                    <label><?php _e('เรียงตาม:', 'ayam-bangkok'); ?></label>
                    <select id="sort-gallery">
                        <option value="number-asc"><?php _e('หมายเลข (น้อย-มาก)', 'ayam-bangkok'); ?></option>
                        <option value="number-desc"><?php _e('หมายเลข (มาก-น้อย)', 'ayam-bangkok'); ?></option>
                        <option value="date-desc"><?php _e('วันที่เพิ่ม (ใหม่สุด)', 'ayam-bangkok'); ?></option>
                        <option value="price-asc"><?php _e('ราคา (ต่ำ-สูง)', 'ayam-bangkok'); ?></option>
                        <option value="price-desc"><?php _e('ราคา (สูง-ต่ำ)', 'ayam-bangkok'); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="gallery-grid-section">
        <div class="container">
            <!-- Loading State -->
            <div class="loading-state" style="display: none;">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span><?php _e('กำลังโหลด...', 'ayam-bangkok'); ?></span>
                </div>
            </div>

            <!-- Roosters Grid -->
            <div class="gallery-grid" id="gallery-container">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $roosters_query = new WP_Query(array(
                    'post_type' => 'ayam_rooster',
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($roosters_query->have_posts()) :
                    while ($roosters_query->have_posts()) : $roosters_query->the_post();
                        
                        // Get rooster data
                        $rooster_number = get_post_meta(get_the_ID(), 'rooster_number', true);
                        $price = get_post_meta(get_the_ID(), 'rooster_price', true);
                        $age = get_post_meta(get_the_ID(), 'rooster_age', true);
                        $weight = get_post_meta(get_the_ID(), 'rooster_weight', true);
                        $status = get_post_meta(get_the_ID(), 'rooster_status', true);
                        
                        $status_labels = array(
                            'available' => __('พร้อมส่งออก', 'ayam-bangkok'),
                            'reserved' => __('จองแล้ว', 'ayam-bangkok'),
                            'sold' => __('ขายแล้ว', 'ayam-bangkok')
                        );
                ?>
                        
                <article class="gallery-card" data-rooster-id="<?php echo get_the_ID(); ?>" data-status="<?php echo esc_attr($status); ?>">
                    <div class="card-image-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="card-image-link">
                                <?php the_post_thumbnail('rooster-card', array('class' => 'gallery-card-image')); ?>
                            </a>
                        <?php else : ?>
                            <div class="placeholder-image">
                                <i class="fas fa-image"></i>
                                <span><?php _e('ไม่มีรูปภาพ', 'ayam-bangkok'); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Rooster Number Badge -->
                        <?php if ($rooster_number) : ?>
                            <div class="rooster-number-badge">
                                <i class="fas fa-hashtag"></i>
                                <span><?php echo esc_html($rooster_number); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Status Badge -->
                        <?php if ($status && isset($status_labels[$status])) : ?>
                            <div class="status-badge status-<?php echo esc_attr($status); ?>">
                                <?php echo esc_html($status_labels[$status]); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Quick Actions -->
                        <div class="card-quick-actions">
                            <button class="quick-action-btn favorite-btn" data-rooster-id="<?php echo get_the_ID(); ?>" title="<?php _e('เพิ่มในรายการโปรด', 'ayam-bangkok'); ?>">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="quick-action-btn quick-view-btn" data-rooster-id="<?php echo get_the_ID(); ?>" title="<?php _e('ดูรวดเร็ว', 'ayam-bangkok'); ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <!-- Rooster Details -->
                        <div class="rooster-quick-details">
                            <?php if ($age) : ?>
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span><?php echo esc_html($age); ?> <?php _e('เดือน', 'ayam-bangkok'); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($weight) : ?>
                                <div class="detail-item">
                                    <i class="fas fa-weight"></i>
                                    <span><?php echo esc_html($weight); ?> <?php _e('กก.', 'ayam-bangkok'); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Price -->
                        <?php if ($price) : ?>
                            <div class="card-price">
                                <span class="price-label"><?php _e('ราคา:', 'ayam-bangkok'); ?></span>
                                <span class="price-amount">฿<?php echo number_format($price); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Card Footer -->
                        <div class="card-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-small btn-block">
                                <i class="fas fa-info-circle"></i>
                                <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                            </a>
                        </div>
                    </div>
                </article>
                
                <?php 
                    endwhile;
                else : 
                ?>
                    
                <!-- No Results -->
                <div class="no-results">
                    <div class="no-results-content">
                        <i class="fas fa-search"></i>
                        <h3><?php _e('ไม่พบไก่ชนในแกลเลอรี่', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('กรุณาลองค้นหาด้วยคำอื่นหรือติดต่อเราโดยตรง', 'ayam-bangkok'); ?></p>
                        <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary">
                            <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                        </a>
                    </div>
                </div>
                
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($roosters_query->have_posts()) : ?>
                <div class="gallery-pagination">
                    <?php
                    echo paginate_links(array(
                        'total' => $roosters_query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('ก่อนหน้า', 'ayam-bangkok'),
                        'next_text' => __('ถัดไป', 'ayam-bangkok') . ' <i class="fas fa-chevron-right"></i>',
                        'type' => 'list'
                    ));
                    ?>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <!-- Quick View Modal -->
    <div id="quick-view-modal" class="modal quick-view-modal" style="display: none;">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span><?php _e('กำลังโหลด...', 'ayam-bangkok'); ?></span>
                </div>
            </div>
        </div>
    </div>

</main><!-- #primary -->

<?php get_footer(); ?>
