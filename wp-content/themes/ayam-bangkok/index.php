<?php
/**
 * The main template file
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        
        <?php if (have_posts()) : ?>
            
            <header class="page-header">
                <?php if (is_home() && !is_front_page()) : ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                <?php elseif (is_archive()) : ?>
                    <h1 class="page-title">
                        <?php
                        if (is_post_type_archive('ayam_rooster')) {
                            echo __('ไก่ชนทั้งหมด', 'ayam-bangkok');
                        } elseif (is_post_type_archive('ayam_service')) {
                            echo __('บริการทั้งหมด', 'ayam-bangkok');
                        } elseif (is_post_type_archive('ayam_news')) {
                            echo __('ข่าวสารทั้งหมด', 'ayam-bangkok');
                        } elseif (is_post_type_archive('ayam_knowledge')) {
                            echo __('ศูนย์ความรู้', 'ayam-bangkok');
                        } else {
                            the_archive_title();
                        }
                        ?>
                    </h1>
                    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                <?php elseif (is_search()) : ?>
                    <h1 class="page-title">
                        <?php printf(__('ผลการค้นหา: %s', 'ayam-bangkok'), '<span>' . get_search_query() . '</span>'); ?>
                    </h1>
                <?php else : ?>
                    <h1 class="page-title"><?php _e('บล็อก', 'ayam-bangkok'); ?></h1>
                <?php endif; ?>
            </header><!-- .page-header -->
            
            <div class="posts-container">
                <?php
                // Check if this is a custom post type archive
                $post_type = get_post_type();
                
                if (is_post_type_archive('ayam_rooster') || (is_home() && $post_type === 'ayam_rooster')) {
                    // Rooster grid layout
                    echo '<div class="rooster-grid">';
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', 'rooster-card');
                    }
                    echo '</div>';
                    
                } elseif (is_post_type_archive('ayam_service') || (is_home() && $post_type === 'ayam_service')) {
                    // Service grid layout
                    echo '<div class="service-grid">';
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', 'service-card');
                    }
                    echo '</div>';
                    
                } elseif (is_post_type_archive('ayam_news') || (is_home() && $post_type === 'ayam_news')) {
                    // News grid layout
                    echo '<div class="news-grid">';
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', 'news-card');
                    }
                    echo '</div>';
                    
                } elseif (is_post_type_archive('ayam_knowledge') || (is_home() && $post_type === 'ayam_knowledge')) {
                    // Knowledge grid layout
                    echo '<div class="knowledge-grid">';
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', 'knowledge-card');
                    }
                    echo '</div>';
                    
                } else {
                    // Default blog layout
                    echo '<div class="blog-posts">';
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', get_post_type());
                    }
                    echo '</div>';
                }
                ?>
            </div><!-- .posts-container -->
            
            <?php
            // Pagination
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('« ก่อนหน้า', 'ayam-bangkok'),
                'next_text' => __('ถัดไป »', 'ayam-bangkok'),
            ));
            ?>
            
        <?php else : ?>
            
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('ไม่พบเนื้อหา', 'ayam-bangkok'); ?></h1>
                </header><!-- .page-header -->
                
                <div class="page-content">
                    <?php if (is_home() && current_user_can('publish_posts')) : ?>
                        
                        <p><?php printf(__('พร้อมที่จะเผยแพร่โพสต์แรกของคุณแล้วหรือยัง? <a href="%1$s">เริ่มต้นที่นี่</a>.', 'ayam-bangkok'), esc_url(admin_url('post-new.php'))); ?></p>
                        
                    <?php elseif (is_search()) : ?>
                        
                        <p><?php _e('ขออภัย ไม่พบสิ่งที่คุณค้นหา กรุณาลองใช้คำค้นหาอื่น', 'ayam-bangkok'); ?></p>
                        <?php get_search_form(); ?>
                        
                    <?php else : ?>
                        
                        <p><?php _e('ดูเหมือนว่าเราไม่พบสิ่งที่คุณกำลังมองหา บางทีการค้นหาอาจช่วยได้', 'ayam-bangkok'); ?></p>
                        <?php get_search_form(); ?>
                        
                    <?php endif; ?>
                </div><!-- .page-content -->
            </section><!-- .no-results -->
            
        <?php endif; ?>
        
    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_sidebar();
get_footer();