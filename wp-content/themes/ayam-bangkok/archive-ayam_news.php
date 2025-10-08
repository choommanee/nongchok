<?php
/**
 * Archive template for News
 */

get_header(); ?>

<main id="primary" class="site-main news-archive">
    
    <!-- Page Header -->
    <section class="page-header news-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('ข่าวสารและกิจกรรมล่าสุดเกี่ยวกับการส่งออกไก่ชน Ayam Bangkok', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- News Filter -->
    <section class="news-filter-section">
        <div class="container">
            <div class="filter-container">
                <!-- Category Filter -->
                <div class="category-filters">
                    <button class="category-btn active" data-category="all">
                        <?php _e('ทั้งหมด', 'ayam-bangkok'); ?>
                    </button>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'news_category',
                        'hide_empty' => true
                    ));
                    
                    if (!empty($categories)) :
                        foreach ($categories as $category) :
                    ?>
                        <button class="category-btn" data-category="<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </button>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="news-grid-section">
        <div class="container">
            <?php if (have_posts()) : ?>
                
                <!-- Featured News (First Post) -->
                <?php
                $first_post = true;
                while (have_posts()) : the_post();
                    if ($first_post && !is_paged()) :
                        $first_post = false;
                ?>
                    
                <article class="news-featured" data-aos="fade-up">
                    <div class="featured-image-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php
                        $is_highlight = get_post_meta(get_the_ID(), 'news_highlight', true);
                        if ($is_highlight) :
                        ?>
                            <span class="highlight-badge">
                                <i class="fas fa-star"></i>
                                <?php _e('ข่าวเด่น', 'ayam-bangkok'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="featured-content">
                        <?php
                        $categories = wp_get_post_terms(get_the_ID(), 'news_category');
                        if (!empty($categories)) :
                        ?>
                            <div class="news-categories">
                                <?php foreach ($categories as $cat) : ?>
                                    <span class="category-tag"><?php echo esc_html($cat->name); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <h2 class="featured-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="news-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <?php echo get_the_date('j F Y'); ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-user"></i>
                                <?php the_author(); ?>
                            </span>
                        </div>
                        
                        <div class="featured-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                            <?php _e('อ่านเพิ่มเติม', 'ayam-bangkok'); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>

                <!-- Regular News Grid -->
                <div class="news-grid">
                    
                <?php else : ?>
                    
                    <article class="news-card" data-aos="fade-up" data-aos-delay="<?php echo (get_query_var('paged') > 1 ? 0 : ($wp_query->current_post * 100)); ?>">
                        <div class="card-image-wrapper">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="card-image-link">
                                    <?php the_post_thumbnail('news-card', array('class' => 'news-card-image')); ?>
                                </a>
                            <?php else : ?>
                                <div class="placeholder-image">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php
                            $is_highlight = get_post_meta(get_the_ID(), 'news_highlight', true);
                            if ($is_highlight) :
                            ?>
                                <span class="highlight-badge">
                                    <i class="fas fa-star"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-content">
                            <?php
                            $categories = wp_get_post_terms(get_the_ID(), 'news_category');
                            if (!empty($categories)) :
                            ?>
                                <div class="news-categories">
                                    <span class="category-tag"><?php echo esc_html($categories[0]->name); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="news-meta">
                                <span class="meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?php echo get_the_date('j M Y'); ?>
                                </span>
                            </div>
                            
                            <div class="card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more-link">
                                <?php _e('อ่านเพิ่มเติม', 'ayam-bangkok'); ?>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                    
                <?php endif; endwhile; ?>
                
                </div><!-- .news-grid -->
                
                <!-- Pagination -->
                <div class="news-pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('ก่อนหน้า', 'ayam-bangkok'),
                        'next_text' => __('ถัดไป', 'ayam-bangkok') . ' <i class="fas fa-chevron-right"></i>',
                        'type' => 'list'
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <!-- No News -->
                <div class="no-news">
                    <div class="no-news-content">
                        <i class="fas fa-newspaper"></i>
                        <h3><?php _e('ยังไม่มีข่าวสาร', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('กรุณาติดตามข่าวสารของเราในเร็วๆ นี้', 'ayam-bangkok'); ?></p>
                        <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                            <?php _e('กลับหน้าแรก', 'ayam-bangkok'); ?>
                        </a>
                    </div>
                </div>
                
            <?php endif; ?>
        </div>
    </section>

    <!-- Newsletter Subscription -->
    <section class="newsletter-section" data-aos="fade-up">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h3><?php _e('รับข่าวสารล่าสุด', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('สมัครรับข่าวสารและโปรโมชั่นพิเศษทางอีเมล', 'ayam-bangkok'); ?></p>
                </div>
                <form class="newsletter-form" id="newsletter-form">
                    <input type="email" name="email" placeholder="<?php _e('อีเมลของคุณ', 'ayam-bangkok'); ?>" required>
                    <button type="submit" class="btn btn-primary">
                        <?php _e('สมัครรับข่าวสาร', 'ayam-bangkok'); ?>
                    </button>
                </form>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>
