<?php
/**
 * Archive template for Roosters with Advanced Features and Wix Style
 */

// Use Wix-style header
get_template_part('template-parts/wix-header');
?>

<main id="primary" class="site-main roosters-archive wix-style-roosters">
    
    <!-- Page Header -->
    <section class="page-header roosters-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ไก่ชนของเรา', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('ไก่ชนคุณภาพสูงพร้อมส่งออกไปยังประเทศอินโดนีเซีย', 'ayam-bangkok'); ?></p>
                
                <!-- Quick Stats -->
                <div class="roosters-stats">
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

    <!-- Advanced Filter Section -->
    <section class="roosters-filter-section advanced-filter-section">
        <div class="container">
            <!-- Quick Filters -->
            <div class="quick-filters">
                <h3><?php _e('ตัวกรองด่วน', 'ayam-bangkok'); ?></h3>
                <div class="quick-filter-buttons">
                    <button class="quick-filter-btn" data-filter="available"><?php _e('พร้อมส่งออก', 'ayam-bangkok'); ?></button>
                    <button class="quick-filter-btn" data-filter="premium"><?php _e('ไก่ชนพรีเมียม', 'ayam-bangkok'); ?></button>
                    <button class="quick-filter-btn" data-filter="new"><?php _e('เพิ่มใหม่', 'ayam-bangkok'); ?></button>
                    <button class="quick-filter-btn" data-filter="under-10k"><?php _e('ราคาต่ำกว่า 10,000', 'ayam-bangkok'); ?></button>
                </div>
            </div>

            <div class="filter-container">
                <!-- Basic Search -->
                <div class="basic-search">
                    <div class="search-input-group">
                        <input type="text" id="rooster-search" placeholder="<?php _e('ค้นหาไก่ชน...', 'ayam-bangkok'); ?>">
                        <button class="search-btn" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters Toggle -->
                <div class="advanced-toggle">
                    <button class="toggle-advanced-btn" type="button">
                        <i class="fas fa-sliders-h"></i>
                        <?php _e('ตัวกรองขั้นสูง', 'ayam-bangkok'); ?>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>

                <!-- Advanced Filters Panel -->
                <div class="advanced-filters-panel" style="display: none;">
                    <div class="filter-row">
                        <!-- Price Range Slider -->
                        <div class="filter-group price-range-group">
                            <label><?php _e('ช่วงราคา', 'ayam-bangkok'); ?></label>
                            <div class="price-range-slider">
                                <div class="price-inputs">
                                    <input type="number" id="price-min" placeholder="<?php _e('ราคาต่ำสุด', 'ayam-bangkok'); ?>">
                                    <span>-</span>
                                    <input type="number" id="price-max" placeholder="<?php _e('ราคาสูงสุด', 'ayam-bangkok'); ?>">
                                </div>
                                <div class="slider-container">
                                    <div class="price-slider" id="price-slider"></div>
                                </div>
                                <div class="price-labels">
                                    <span>0</span>
                                    <span>100,000+</span>
                                </div>
                            </div>
                        </div>

                        <!-- Age Range -->
                        <div class="filter-group">
                            <label for="age-range"><?php _e('อายุ (เดือน)', 'ayam-bangkok'); ?></label>
                            <div class="range-inputs">
                                <input type="number" id="age-min" placeholder="<?php _e('อายุต่ำสุด', 'ayam-bangkok'); ?>">
                                <span>-</span>
                                <input type="number" id="age-max" placeholder="<?php _e('อายุสูงสุด', 'ayam-bangkok'); ?>">
                            </div>
                        </div>

                        <!-- Weight Range -->
                        <div class="filter-group">
                            <label for="weight-range"><?php _e('น้ำหนัก (กก.)', 'ayam-bangkok'); ?></label>
                            <div class="range-inputs">
                                <input type="number" id="weight-min" placeholder="<?php _e('น้ำหนักต่ำสุด', 'ayam-bangkok'); ?>" step="0.1">
                                <span>-</span>
                                <input type="number" id="weight-max" placeholder="<?php _e('น้ำหนักสูงสุด', 'ayam-bangkok'); ?>" step="0.1">
                            </div>
                        </div>
                    </div>

                    <div class="filter-row">
                        <!-- Breed Filter -->
                        <div class="filter-group">
                            <label for="filter-breed"><?php _e('สายพันธุ์', 'ayam-bangkok'); ?></label>
                            <select id="filter-breed" multiple>
                                <?php
                                $breeds = get_terms(array(
                                    'taxonomy' => 'rooster_breed',
                                    'hide_empty' => false
                                ));
                                
                                if (!empty($breeds)) :
                                    foreach ($breeds as $breed) :
                                ?>
                                    <option value="<?php echo esc_attr($breed->slug); ?>">
                                        <?php echo esc_html($breed->name); ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="filter-group">
                            <label for="filter-category"><?php _e('หมวดหมู่', 'ayam-bangkok'); ?></label>
                            <select id="filter-category" multiple>
                                <?php
                                $categories = get_terms(array(
                                    'taxonomy' => 'rooster_category',
                                    'hide_empty' => false
                                ));
                                
                                if (!empty($categories)) :
                                    foreach ($categories as $category) :
                                ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <!-- Color Filter -->
                        <div class="filter-group">
                            <label for="filter-color"><?php _e('สี', 'ayam-bangkok'); ?></label>
                            <div class="color-checkboxes">
                                <?php
                                $colors = array(
                                    'red' => __('แดง', 'ayam-bangkok'),
                                    'black' => __('ดำ', 'ayam-bangkok'),
                                    'white' => __('ขาว', 'ayam-bangkok'),
                                    'brown' => __('น้ำตาล', 'ayam-bangkok'),
                                    'mixed' => __('ผสม', 'ayam-bangkok')
                                );
                                
                                foreach ($colors as $value => $label) :
                                ?>
                                    <label class="color-checkbox">
                                        <input type="checkbox" name="colors[]" value="<?php echo esc_attr($value); ?>">
                                        <span class="color-swatch color-<?php echo esc_attr($value); ?>"></span>
                                        <?php echo esc_html($label); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="filter-group">
                            <label for="filter-status"><?php _e('สถานะ', 'ayam-bangkok'); ?></label>
                            <div class="status-checkboxes">
                                <label>
                                    <input type="checkbox" name="status[]" value="available" checked>
                                    <?php _e('พร้อมส่งออก', 'ayam-bangkok'); ?>
                                </label>
                                <label>
                                    <input type="checkbox" name="status[]" value="reserved">
                                    <?php _e('จองแล้ว', 'ayam-bangkok'); ?>
                                </label>
                                <label>
                                    <input type="checkbox" name="status[]" value="sold">
                                    <?php _e('ขายแล้ว', 'ayam-bangkok'); ?>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="filter-actions">
                        <button type="button" class="btn btn-primary apply-filters-btn">
                            <i class="fas fa-filter"></i>
                            <?php _e('ใช้ตัวกรอง', 'ayam-bangkok'); ?>
                        </button>
                        <button type="button" class="btn btn-outline reset-filters-btn">
                            <i class="fas fa-undo"></i>
                            <?php _e('รีเซ็ต', 'ayam-bangkok'); ?>
                        </button>
                        <button type="button" class="btn btn-outline save-search-btn">
                            <i class="fas fa-save"></i>
                            <?php _e('บันทึกการค้นหา', 'ayam-bangkok'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="roosters-results-section">
        <div class="container">
            <!-- Results Header -->
            <div class="results-header">
                <div class="results-info">
                    <div class="results-count">
                        <span class="count-text"><?php _e('แสดงผลลัพธ์', 'ayam-bangkok'); ?></span>
                        <span class="count-numbers">1-12 <?php _e('จาก', 'ayam-bangkok'); ?> 48</span>
                    </div>
                    <div class="active-filters">
                        <!-- Active filters will be populated by JavaScript -->
                    </div>
                </div>

                <div class="results-controls">
                    <!-- Sort Options -->
                    <div class="sort-options">
                        <label><?php _e('เรียงตาม:', 'ayam-bangkok'); ?></label>
                        <select id="sort-roosters">
                            <option value="date-desc"><?php _e('วันที่เพิ่ม (ใหม่สุด)', 'ayam-bangkok'); ?></option>
                            <option value="date-asc"><?php _e('วันที่เพิ่ม (เก่าสุด)', 'ayam-bangkok'); ?></option>
                            <option value="title-asc"><?php _e('ชื่อ (A-Z)', 'ayam-bangkok'); ?></option>
                            <option value="title-desc"><?php _e('ชื่อ (Z-A)', 'ayam-bangkok'); ?></option>
                            <option value="price-asc"><?php _e('ราคา (ต่ำ-สูง)', 'ayam-bangkok'); ?></option>
                            <option value="price-desc"><?php _e('ราคา (สูง-ต่ำ)', 'ayam-bangkok'); ?></option>
                            <option value="popular"><?php _e('ความนิยม', 'ayam-bangkok'); ?></option>
                        </select>
                    </div>

                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid" title="<?php _e('มุมมองตาราง', 'ayam-bangkok'); ?>">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" data-view="list" title="<?php _e('มุมมองรายการ', 'ayam-bangkok'); ?>">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div class="loading-state" style="display: none;">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span><?php _e('กำลังโหลด...', 'ayam-bangkok'); ?></span>
                </div>
            </div>

            <!-- Roosters Grid -->
            <div class="roosters-grid grid-view" id="roosters-container">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article class="rooster-card" data-rooster-id="<?php echo get_the_ID(); ?>">
                            <div class="card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('rooster-card', array('class' => 'rooster-image')); ?>
                                    </a>
                                <?php else : ?>
                                    <div class="placeholder-image">
                                        <i class="fas fa-image"></i>
                                        <span><?php _e('ไม่มีรูปภาพ', 'ayam-bangkok'); ?></span>
                                    </div>
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
                                
                                <!-- Price Badge -->
                                <?php
                                $price = ayam_get_field('rooster_price');
                                if ($price) :
                                ?>
                                    <div class="price-badge">
                                        <?php echo ayam_format_price($price); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Quick Actions -->
                                <div class="card-actions">
                                    <button class="action-btn favorite-btn" data-rooster-id="<?php echo get_the_ID(); ?>" title="<?php _e('เพิ่มในรายการโปรด', 'ayam-bangkok'); ?>">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="action-btn compare-btn" data-rooster-id="<?php echo get_the_ID(); ?>" title="<?php _e('เปรียบเทียบ', 'ayam-bangkok'); ?>">
                                        <i class="fas fa-balance-scale"></i>
                                    </button>
                                    <button class="action-btn share-btn" data-rooster-id="<?php echo get_the_ID(); ?>" title="<?php _e('แชร์', 'ayam-bangkok'); ?>">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="card-content">
                                <h3 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <!-- Breed and Category -->
                                <div class="rooster-taxonomy">
                                    <?php
                                    $breeds = wp_get_post_terms(get_the_ID(), 'rooster_breed');
                                    if (!empty($breeds)) :
                                    ?>
                                        <span class="breed-tag">
                                            <i class="fas fa-tag"></i>
                                            <?php echo esc_html($breeds[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php
                                    $categories = wp_get_post_terms(get_the_ID(), 'rooster_category');
                                    if (!empty($categories)) :
                                    ?>
                                        <span class="category-tag">
                                            <i class="fas fa-folder"></i>
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Rooster Details -->
                                <div class="rooster-details">
                                    <?php
                                    $age = ayam_get_field('rooster_age');
                                    $weight = ayam_get_field('rooster_weight');
                                    $color = ayam_get_field('rooster_color');
                                    ?>
                                    
                                    <?php if ($age) : ?>
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span><?php echo ayam_format_age($age); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($weight) : ?>
                                        <div class="detail-item">
                                            <i class="fas fa-weight"></i>
                                            <span><?php echo ayam_format_weight($weight); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($color) : ?>
                                        <div class="detail-item">
                                            <i class="fas fa-palette"></i>
                                            <span><?php echo esc_html($color); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Description -->
                                <div class="card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                                </div>
                                
                                <!-- Card Footer -->
                                <div class="card-footer">
                                    <div class="card-buttons">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-small">
                                            <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                                        </a>
                                        <button class="btn btn-outline btn-small inquiry-btn" data-rooster-id="<?php echo get_the_ID(); ?>">
                                            <?php _e('สอบถาม', 'ayam-bangkok'); ?>
                                        </button>
                                    </div>
                                    
                                    <div class="card-meta">
                                        <span class="post-date">
                                            <i class="fas fa-clock"></i>
                                            <?php echo get_the_date('j M Y'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                <?php else : ?>
                    
                    <!-- No Results -->
                    <div class="no-results">
                        <div class="no-results-content">
                            <i class="fas fa-search"></i>
                            <h3><?php _e('ไม่พบไก่ชนที่ตรงกับเงื่อนไข', 'ayam-bangkok'); ?></h3>
                            <p><?php _e('ลองปรับเปลี่ยนเงื่อนไขการค้นหาหรือตัวกรอง', 'ayam-bangkok'); ?></p>
                            <button class="btn btn-primary reset-filters-btn">
                                <?php _e('รีเซ็ตตัวกรอง', 'ayam-bangkok'); ?>
                            </button>
                        </div>
                    </div>
                    
                <?php endif; ?>
            </div>

            <!-- Load More Button -->
            <div class="load-more-section">
                <button class="btn btn-outline load-more-btn" style="display: none;">
                    <i class="fas fa-plus"></i>
                    <?php _e('โหลดเพิ่มเติม', 'ayam-bangkok'); ?>
                </button>
            </div>

            <!-- Pagination -->
            <?php if (have_posts()) : ?>
                <div class="pagination-wrapper">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('ก่อนหน้า', 'ayam-bangkok'),
                        'next_text' => __('ถัดไป', 'ayam-bangkok') . ' <i class="fas fa-chevron-right"></i>',
                        'type' => 'list'
                    ));
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Compare Bar -->
    <div class="compare-bar" id="compare-bar" style="display: none;">
        <div class="container">
            <div class="compare-content">
                <div class="compare-items">
                    <span class="compare-label">
                        <i class="fas fa-balance-scale"></i>
                        <?php _e('เปรียบเทียบ', 'ayam-bangkok'); ?>
                        (<span class="compare-count">0</span>/3)
                    </span>
                    <div class="compare-list">
                        <!-- Compare items will be populated by JavaScript -->
                    </div>
                </div>
                <div class="compare-actions">
                    <button class="btn btn-primary compare-now-btn" disabled>
                        <?php _e('เปรียบเทียบตอนนี้', 'ayam-bangkok'); ?>
                    </button>
                    <button class="btn btn-outline clear-compare-btn">
                        <?php _e('ล้างทั้งหมด', 'ayam-bangkok'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Roosters Section -->
    <?php if (!have_posts() || is_paged()) : ?>
    <section class="featured-roosters-section">
        <div class="container">
            <h2 class="section-title"><?php _e('ไก่ชนแนะนำ', 'ayam-bangkok'); ?></h2>
            <div class="featured-roosters-grid">
                <?php
                $featured_query = new WP_Query(array(
                    'post_type' => 'ayam_rooster',
                    'posts_per_page' => 3,
                    'meta_query' => array(
                        array(
                            'key' => 'rooster_featured',
                            'value' => '1',
                            'compare' => '='
                        )
                    ),
                    'orderby' => 'rand'
                ));
                
                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
                ?>
                    <div class="featured-rooster-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="featured-content">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-small btn-primary">
                                <?php _e('ดูรายละเอียด', 'ayam-bangkok'); ?>
                            </a>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main><!-- #primary -->

<?php
// Use Wix-style footer
get_template_part('template-parts/wix-footer');
?>