<?php
/**
 * Single News template
 */

get_header(); ?>

<main id="primary" class="site-main single-news">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Breadcrumb -->
        <section class="breadcrumb-section">
            <div class="container">
                <nav class="breadcrumb">
                    <a href="<?php echo home_url(); ?>"><?php _e('หน้าแรก', 'ayam-bangkok'); ?></a>
                    <span class="separator">/</span>
                    <a href="<?php echo get_post_type_archive_link('ayam_news'); ?>"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></a>
                    <span class="separator">/</span>
                    <span class="current"><?php the_title(); ?></span>
                </nav>
            </div>
        </section>

        <!-- News Header -->
        <article class="news-article">
            <header class="news-article-header">
                <div class="container">
                    <?php
                    $categories = wp_get_post_terms(get_the_ID(), 'news_category');
                    if (!empty($categories)) :
                    ?>
                        <div class="news-categories">
                            <?php foreach ($categories as $cat) : ?>
                                <a href="<?php echo get_term_link($cat); ?>" class="category-tag">
                                    <?php echo esc_html($cat->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <h1 class="news-title"><?php the_title(); ?></h1>
                    
                    <div class="news-meta">
                        <span class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo get_the_date('j F Y'); ?>
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-user"></i>
                            <?php the_author(); ?>
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            <?php echo ayam_reading_time(); ?>
                        </span>
                    </div>
                    
                    <!-- Social Share -->
                    <div class="social-share">
                        <span class="share-label"><?php _e('แชร์:', 'ayam-bangkok'); ?></span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn facebook" title="<?php _e('แชร์บน Facebook', 'ayam-bangkok'); ?>">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn twitter" title="<?php _e('แชร์บน Twitter', 'ayam-bangkok'); ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://line.me/R/msg/text/?<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="share-btn line" title="<?php _e('แชร์บน LINE', 'ayam-bangkok'); ?>">
                            <i class="fab fa-line"></i>
                        </a>
                        <button class="share-btn copy" data-url="<?php echo get_permalink(); ?>" title="<?php _e('คัดลอกลิงก์', 'ayam-bangkok'); ?>">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="news-featured-image">
                    <div class="container">
                        <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- News Content -->
            <div class="news-content">
                <div class="container">
                    <div class="content-wrapper">
                        <div class="main-content">
                            <?php the_content(); ?>
                            
                            <?php
                            // News Gallery
                            $gallery = get_post_meta(get_the_ID(), 'news_gallery', true);
                            if (!empty($gallery)) :
                            ?>
                                <div class="news-gallery">
                                    <h3><?php _e('แกลเลอรี่', 'ayam-bangkok'); ?></h3>
                                    <div class="gallery-grid">
                                        <?php foreach ($gallery as $image) : ?>
                                            <a href="<?php echo esc_url($image['url']); ?>" class="gallery-item" data-lightbox="news-gallery">
                                                <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php
                            // News Video
                            $video_url = get_post_meta(get_the_ID(), 'news_video_url', true);
                            if ($video_url) :
                            ?>
                                <div class="news-video">
                                    <h3><?php _e('วิดีโอ', 'ayam-bangkok'); ?></h3>
                                    <div class="video-wrapper">
                                        <?php echo wp_oembed_get($video_url); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Tags -->
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                            ?>
                                <div class="news-tags">
                                    <span class="tags-label"><?php _e('แท็ก:', 'ayam-bangkok'); ?></span>
                                    <?php foreach ($tags as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag-item">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Sidebar -->
                        <aside class="news-sidebar">
                            <!-- Recent News -->
                            <div class="sidebar-widget">
                                <h3 class="widget-title"><?php _e('ข่าวล่าสุด', 'ayam-bangkok'); ?></h3>
                                <?php
                                $recent_news = new WP_Query(array(
                                    'post_type' => 'ayam_news',
                                    'posts_per_page' => 5,
                                    'post__not_in' => array(get_the_ID())
                                ));
                                
                                if ($recent_news->have_posts()) :
                                ?>
                                    <ul class="recent-news-list">
                                        <?php while ($recent_news->have_posts()) : $recent_news->the_post(); ?>
                                            <li class="recent-news-item">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <a href="<?php the_permalink(); ?>" class="recent-news-thumb">
                                                        <?php the_post_thumbnail('thumbnail'); ?>
                                                    </a>
                                                <?php endif; ?>
                                                <div class="recent-news-content">
                                                    <h4>
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h4>
                                                    <span class="recent-news-date">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        <?php echo get_the_date('j M Y'); ?>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php endwhile; wp_reset_postdata(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Categories -->
                            <div class="sidebar-widget">
                                <h3 class="widget-title"><?php _e('หมวดหมู่', 'ayam-bangkok'); ?></h3>
                                <?php
                                $categories = get_terms(array(
                                    'taxonomy' => 'news_category',
                                    'hide_empty' => true
                                ));
                                
                                if (!empty($categories)) :
                                ?>
                                    <ul class="category-list">
                                        <?php foreach ($categories as $cat) : ?>
                                            <li>
                                                <a href="<?php echo get_term_link($cat); ?>">
                                                    <?php echo esc_html($cat->name); ?>
                                                    <span class="count">(<?php echo $cat->count; ?>)</span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>

            <!-- Related News -->
            <section class="related-news-section">
                <div class="container">
                    <h2 class="section-title"><?php _e('ข่าวที่เกี่ยวข้อง', 'ayam-bangkok'); ?></h2>
                    
                    <?php
                    $categories = wp_get_post_terms(get_the_ID(), 'news_category', array('fields' => 'ids'));
                    
                    $related_query = new WP_Query(array(
                        'post_type' => 'ayam_news',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'news_category',
                                'field' => 'term_id',
                                'terms' => $categories
                            )
                        ),
                        'orderby' => 'rand'
                    ));
                    
                    if ($related_query->have_posts()) :
                    ?>
                        <div class="related-news-grid">
                            <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                <article class="related-news-card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="related-news-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('news-card'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="related-news-content">
                                        <h3>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <div class="news-meta">
                                            <span class="meta-item">
                                                <i class="fas fa-calendar-alt"></i>
                                                <?php echo get_the_date('j M Y'); ?>
                                            </span>
                                        </div>
                                        <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                        <a href="<?php the_permalink(); ?>" class="read-more-link">
                                            <?php _e('อ่านเพิ่มเติม', 'ayam-bangkok'); ?>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </article>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

        </article>
        
    <?php endwhile; ?>

</main><!-- #primary -->

<?php get_footer(); ?>
