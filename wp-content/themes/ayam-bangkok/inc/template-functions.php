<?php
/**
 * Template Functions
 */

// ayam_get_field function is provided by the plugin

// Get option field with fallback to ACF or option
function ayam_get_option_field($field_name, $default = '') {
    // Try ACF options first
    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        if ($value !== false && $value !== '') {
            return $value;
        }
    }
    
    // Fallback to WordPress option
    return get_option($field_name, $default);
}

// Enhanced Breadcrumb function
function ayam_breadcrumb() {
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="ayam-breadcrumb" aria-label="breadcrumb">';
    echo '<div class="container">';
    echo '<ol class="breadcrumb-list">';
    
    // Home link with icon
    echo '<li class="breadcrumb-item home-item">';
    echo '<a href="' . home_url() . '" class="breadcrumb-link">';
    echo '<i class="fas fa-home"></i>';
    echo '<span>' . __('หน้าแรก', 'ayam-bangkok') . '</span>';
    echo '</a>';
    echo '</li>';
    
    // Add separator
    echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
    
    if (is_category() || is_single()) {
        if (is_single()) {
            $post_type = get_post_type();
            
            // Add post type archive link for custom post types
            if ($post_type !== 'post') {
                $post_type_obj = get_post_type_object($post_type);
                if ($post_type_obj && $post_type_obj->has_archive) {
                    echo '<li class="breadcrumb-item">';
                    echo '<a href="' . get_post_type_archive_link($post_type) . '" class="breadcrumb-link">';
                    echo '<span>' . $post_type_obj->labels->name . '</span>';
                    echo '</a>';
                    echo '</li>';
                    echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
                }
            }
            
            // Add category for regular posts
            if ($post_type === 'post') {
                $category = get_the_category();
                if ($category) {
                    echo '<li class="breadcrumb-item">';
                    echo '<a href="' . get_category_link($category[0]->term_id) . '" class="breadcrumb-link">';
                    echo '<span>' . $category[0]->name . '</span>';
                    echo '</a>';
                    echo '</li>';
                    echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
                }
            }
            
            // Add taxonomies for custom post types
            if ($post_type === 'ayam_rooster') {
                $breeds = wp_get_post_terms(get_the_ID(), 'rooster_breed');
                if (!empty($breeds)) {
                    echo '<li class="breadcrumb-item">';
                    echo '<a href="' . get_term_link($breeds[0]) . '" class="breadcrumb-link">';
                    echo '<span>' . $breeds[0]->name . '</span>';
                    echo '</a>';
                    echo '</li>';
                    echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
                }
            }
            
            echo '<li class="breadcrumb-item active" aria-current="page">';
            echo '<span class="breadcrumb-current">' . get_the_title() . '</span>';
            echo '</li>';
        } else {
            echo '<li class="breadcrumb-item active" aria-current="page">';
            echo '<span class="breadcrumb-current">' . single_cat_title('', false) . '</span>';
            echo '</li>';
        }
    } elseif (is_page()) {
        if (wp_get_post_parent_id(get_the_ID())) {
            $parent_id = wp_get_post_parent_id(get_the_ID());
            $breadcrumbs = array();
            
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = array(
                    'title' => get_the_title($page->ID),
                    'url' => get_permalink($page->ID)
                );
                $parent_id = $page->post_parent;
            }
            
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . $crumb['url'] . '" class="breadcrumb-link">';
                echo '<span>' . $crumb['title'] . '</span>';
                echo '</a>';
                echo '</li>';
                echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
            }
        }
        echo '<li class="breadcrumb-item active" aria-current="page">';
        echo '<span class="breadcrumb-current">' . get_the_title() . '</span>';
        echo '</li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active" aria-current="page">';
        echo '<span class="breadcrumb-current">';
        echo '<i class="fas fa-search"></i> ';
        printf(__('ผลการค้นหา: "%s"', 'ayam-bangkok'), get_search_query());
        echo '</span>';
        echo '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumb-item active" aria-current="page">';
        echo '<span class="breadcrumb-current">';
        echo '<i class="fas fa-exclamation-triangle"></i> ';
        echo __('ไม่พบหน้า', 'ayam-bangkok');
        echo '</span>';
        echo '</li>';
    } elseif (is_post_type_archive()) {
        $post_type_obj = get_queried_object();
        echo '<li class="breadcrumb-item active" aria-current="page">';
        echo '<span class="breadcrumb-current">';
        if ($post_type_obj->name === 'ayam_rooster') {
            echo '<i class="fas fa-list"></i> ';
        }
        echo $post_type_obj->labels->name;
        echo '</span>';
        echo '</li>';
    } elseif (is_tax()) {
        $term = get_queried_object();
        $taxonomy = get_taxonomy($term->taxonomy);
        
        // Add post type archive link if available
        if ($taxonomy->object_type) {
            $post_type = $taxonomy->object_type[0];
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj && $post_type_obj->has_archive) {
                echo '<li class="breadcrumb-item">';
                echo '<a href="' . get_post_type_archive_link($post_type) . '" class="breadcrumb-link">';
                echo '<span>' . $post_type_obj->labels->name . '</span>';
                echo '</a>';
                echo '</li>';
                echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
            }
        }
        
        echo '<li class="breadcrumb-item active" aria-current="page">';
        echo '<span class="breadcrumb-current">';
        echo '<i class="fas fa-tag"></i> ';
        echo $term->name;
        echo '</span>';
        echo '</li>';
    }
    
    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}

// Pagination function
function ayam_pagination($query = null) {
    global $wp_query;
    
    if (!$query) {
        $query = $wp_query;
    }
    
    $total_pages = $query->max_num_pages;
    
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        
        echo '<nav class="pagination-nav" aria-label="' . __('การแบ่งหน้า', 'ayam-bangkok') . '">';
        echo '<ul class="pagination">';
        
        // Previous page link
        if ($current_page > 1) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="' . get_pagenum_link($current_page - 1) . '" aria-label="' . __('หน้าก่อนหน้า', 'ayam-bangkok') . '">';
            echo '<i class="fas fa-chevron-left"></i>';
            echo '</a>';
            echo '</li>';
        }
        
        // Page numbers
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo '<li class="page-item active" aria-current="page">';
                echo '<span class="page-link">' . $i . '</span>';
                echo '</li>';
            } else {
                echo '<li class="page-item">';
                echo '<a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a>';
                echo '</li>';
            }
        }
        
        // Next page link
        if ($current_page < $total_pages) {
            echo '<li class="page-item">';
            echo '<a class="page-link" href="' . get_pagenum_link($current_page + 1) . '" aria-label="' . __('หน้าถัดไป', 'ayam-bangkok') . '">';
            echo '<i class="fas fa-chevron-right"></i>';
            echo '</a>';
            echo '</li>';
        }
        
        echo '</ul>';
        echo '</nav>';
    }
}

// Social share buttons
function ayam_social_share() {
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    
    echo '<div class="social-share">';
    echo '<h4>' . __('แชร์', 'ayam-bangkok') . '</h4>';
    echo '<div class="share-buttons">';
    
    // Facebook
    echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" rel="noopener" class="share-btn facebook">';
    echo '<i class="fab fa-facebook-f"></i>';
    echo '</a>';
    
    // Twitter
    echo '<a href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener" class="share-btn twitter">';
    echo '<i class="fab fa-twitter"></i>';
    echo '</a>';
    
    // Line
    echo '<a href="https://social-plugins.line.me/lineit/share?url=' . $url . '" target="_blank" rel="noopener" class="share-btn line">';
    echo '<i class="fab fa-line"></i>';
    echo '</a>';
    
    // Copy link
    echo '<button class="share-btn copy-link" data-url="' . get_permalink() . '" title="' . __('คัดลอกลิงก์', 'ayam-bangkok') . '">';
    echo '<i class="fas fa-link"></i>';
    echo '</button>';
    
    echo '</div>';
    echo '</div>';
}

// Related posts function
function ayam_related_posts($post_id = null, $limit = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_type = get_post_type($post_id);
    $categories = wp_get_post_categories($post_id);
    
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $limit,
        'post__not_in' => array($post_id),
        'post_status' => 'publish'
    );
    
    if (!empty($categories)) {
        $args['category__in'] = $categories;
    }
    
    $related_posts = new WP_Query($args);
    
    if ($related_posts->have_posts()) {
        echo '<div class="related-posts">';
        echo '<h3>' . __('โพสต์ที่เกี่ยวข้อง', 'ayam-bangkok') . '</h3>';
        echo '<div class="related-posts-grid">';
        
        while ($related_posts->have_posts()) {
            $related_posts->the_post();
            echo '<div class="related-post-item">';
            
            if (has_post_thumbnail()) {
                echo '<div class="related-post-image">';
                echo '<a href="' . get_permalink() . '">';
                the_post_thumbnail('medium');
                echo '</a>';
                echo '</div>';
            }
            
            echo '<div class="related-post-content">';
            echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
            echo '<p class="related-post-date">' . get_the_date() . '</p>';
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        
        wp_reset_postdata();
    }
}

// Custom excerpt function
function ayam_custom_excerpt($limit = 20, $more = '...') {
    $excerpt = get_the_excerpt();
    if ($excerpt) {
        return wp_trim_words($excerpt, $limit, $more);
    }
    
    $content = get_the_content();
    $content = strip_shortcodes($content);
    $content = wp_strip_all_tags($content);
    
    return wp_trim_words($content, $limit, $more);
}

// Reading time function
function ayam_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed
    
    if ($reading_time == 1) {
        return '1 ' . __('นาที', 'ayam-bangkok');
    } else {
        return $reading_time . ' ' . __('นาที', 'ayam-bangkok');
    }
}

// Post views counter
function ayam_set_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function ayam_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return 0;
    }
    
    return $count;
}

// ลบส่วนนี้ออก - ฟังก์ชันซ้ำกับใน functions.php
// Track post views
// function ayam_track_post_views($post_id) {
//     if (!is_single()) return;
//     if (empty($post_id)) {
//         global $post;
//         $post_id = $post->ID;
//     }
//     ayam_set_post_views($post_id);
// }
// add_action('wp_head', 'ayam_track_post_views');