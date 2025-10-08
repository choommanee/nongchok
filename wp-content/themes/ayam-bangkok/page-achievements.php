<?php
/**
 * Template for Achievements page
 */

get_header(); ?>

<main id="primary" class="site-main achievements-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ผลงานและรางวัล', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('ความสำเร็จและการยอมรับที่เราได้รับตลอดการดำเนินธุรกิจ', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="achievements-stats-section">
        <div class="container">
            <div class="stats-grid">
                <?php
                $stats = ayam_get_achievement_stats();
                ?>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="<?php echo esc_attr($stats['total_awards']); ?>">0</div>
                        <div class="stat-label"><?php _e('รางวัลที่ได้รับ', 'ayam-bangkok'); ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="<?php echo esc_attr($stats['total_exports']); ?>">0</div>
                        <div class="stat-label"><?php _e('ไก่ชนที่ส่งออก', 'ayam-bangkok'); ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="<?php echo esc_attr($stats['satisfied_customers']); ?>">0</div>
                        <div class="stat-label"><?php _e('ลูกค้าที่พึงพอใจ', 'ayam-bangkok'); ?></div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="<?php echo esc_attr($stats['years_experience']); ?>">0</div>
                        <div class="stat-label"><?php _e('ปีประสบการณ์', 'ayam-bangkok'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Export History Timeline -->
    <section class="export-timeline-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('ประวัติการส่งออก', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('เส้นทางการเติบโตและการส่งออกไก่ชนของเราตลอดหลายปีที่ผ่านมา', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="timeline-container">
                <div class="timeline-controls">
                    <button class="timeline-btn active" data-year="all"><?php _e('ทั้งหมด', 'ayam-bangkok'); ?></button>
                    <button class="timeline-btn" data-year="2024">2024</button>
                    <button class="timeline-btn" data-year="2023">2023</button>
                    <button class="timeline-btn" data-year="2022">2022</button>
                    <button class="timeline-btn" data-year="2021">2021</button>
                </div>
                
                <div class="export-timeline">
                    <?php
                    $export_history = ayam_get_export_history();
                    if (!empty($export_history)) :
                        foreach ($export_history as $index => $export) :
                            $position_class = ($index % 2 == 0) ? 'timeline-left' : 'timeline-right';
                    ?>
                        <div class="timeline-item <?php echo $position_class; ?>" data-year="<?php echo esc_attr($export['year']); ?>">
                            <div class="timeline-content">
                                <div class="timeline-date"><?php echo esc_html($export['date']); ?></div>
                                <h4><?php echo esc_html($export['title']); ?></h4>
                                <p><?php echo esc_html($export['description']); ?></p>
                                
                                <?php if (!empty($export['stats'])) : ?>
                                    <div class="export-stats">
                                        <?php foreach ($export['stats'] as $stat) : ?>
                                            <div class="export-stat">
                                                <span class="stat-value"><?php echo esc_html($stat['value']); ?></span>
                                                <span class="stat-label"><?php echo esc_html($stat['label']); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($export['image'])) : ?>
                                    <div class="timeline-image">
                                        <img src="<?php echo esc_url($export['image']); ?>" alt="<?php echo esc_attr($export['title']); ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="timeline-marker">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                        </div>
                    <?php 
                        endforeach;
                    else :
                        // Default export history
                        $default_exports = array(
                            array(
                                'year' => '2024',
                                'date' => 'มกราคม 2024',
                                'title' => __('การส่งออกครั้งใหญ่ที่สุด', 'ayam-bangkok'),
                                'description' => __('ส่งออกไก่ชนคุณภาพสูง 500 ตัวไปยังจาการ์ตา', 'ayam-bangkok'),
                                'stats' => array(
                                    array('value' => '500', 'label' => 'ตัว'),
                                    array('value' => '15M', 'label' => 'บาท')
                                )
                            ),
                            array(
                                'year' => '2023',
                                'date' => 'กันยายน 2023',
                                'title' => __('รางวัลผู้ส่งออกดีเด่น', 'ayam-bangkok'),
                                'description' => __('ได้รับรางวัลจากกรมการค้าต่างประเทศ', 'ayam-bangkok'),
                                'stats' => array(
                                    array('value' => '1st', 'label' => 'อันดับ'),
                                    array('value' => '300', 'label' => 'ตัว/เดือน')
                                )
                            ),
                            array(
                                'year' => '2022',
                                'date' => 'มิถุนายน 2022',
                                'title' => __('ขยายตลาดสู่สุราบายา', 'ayam-bangkok'),
                                'description' => __('เปิดตลาดใหม่ในเมืองสุราบายา ประเทศอินโดนีเซีย', 'ayam-bangkok'),
                                'stats' => array(
                                    array('value' => '2', 'label' => 'เมือง'),
                                    array('value' => '150', 'label' => 'ตัว/เดือน')
                                )
                            ),
                            array(
                                'year' => '2021',
                                'date' => 'มีนาคม 2021',
                                'title' => __('ใบรับรองมาตรฐาน ISO', 'ayam-bangkok'),
                                'description' => __('ได้รับการรับรองมาตรฐาน ISO 9001:2015', 'ayam-bangkok'),
                                'stats' => array(
                                    array('value' => 'ISO', 'label' => '9001:2015'),
                                    array('value' => '100%', 'label' => 'คุณภาพ')
                                )
                            )
                        );
                        
                        foreach ($default_exports as $index => $export) :
                            $position_class = ($index % 2 == 0) ? 'timeline-left' : 'timeline-right';
                    ?>
                        <div class="timeline-item <?php echo $position_class; ?>" data-year="<?php echo esc_attr($export['year']); ?>">
                            <div class="timeline-content">
                                <div class="timeline-date"><?php echo esc_html($export['date']); ?></div>
                                <h4><?php echo esc_html($export['title']); ?></h4>
                                <p><?php echo esc_html($export['description']); ?></p>
                                
                                <div class="export-stats">
                                    <?php foreach ($export['stats'] as $stat) : ?>
                                        <div class="export-stat">
                                            <span class="stat-value"><?php echo esc_html($stat['value']); ?></span>
                                            <span class="stat-label"><?php echo esc_html($stat['label']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="timeline-marker">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('คำชมจากลูกค้า', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('ความคิดเห็นและการให้คะแนนจากลูกค้าที่ใช้บริการของเรา', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="testimonials-slider">
                <div class="testimonials-container">
                    <?php
                    $testimonials = ayam_get_testimonials();
                    if (!empty($testimonials)) :
                        foreach ($testimonials as $testimonial) :
                    ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'active' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <blockquote>
                                    "<?php echo esc_html($testimonial['message']); ?>"
                                </blockquote>
                                <div class="testimonial-author">
                                    <?php if (!empty($testimonial['avatar'])) : ?>
                                        <img src="<?php echo esc_url($testimonial['avatar']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>" class="author-avatar">
                                    <?php else : ?>
                                        <div class="author-avatar-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="author-info">
                                        <h5><?php echo esc_html($testimonial['name']); ?></h5>
                                        <p><?php echo esc_html($testimonial['company']); ?></p>
                                        <span class="testimonial-date"><?php echo esc_html($testimonial['date']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endforeach;
                    else :
                        // Default testimonials
                        $default_testimonials = array(
                            array(
                                'name' => 'คุณสมชาย วิรุฬห์',
                                'company' => 'Jakarta Fighting Club',
                                'message' => 'ไก่ชนที่ได้รับมีคุณภาพเยี่ยม บริการดีมาก ส่งตรงเวลา แนะนำเลยครับ',
                                'rating' => 5,
                                'date' => '15 ม.ค. 2024'
                            ),
                            array(
                                'name' => 'Mr. Budi Santoso',
                                'company' => 'Surabaya Rooster Farm',
                                'message' => 'Excellent service and high quality roosters. Very professional team and fast delivery.',
                                'rating' => 5,
                                'date' => '8 ม.ค. 2024'
                            ),
                            array(
                                'name' => 'คุณประยุทธ สมบูรณ์',
                                'company' => 'Bandung Cock Fighting',
                                'message' => 'ใช้บริการมา 3 ปีแล้ว ไก่ชนทุกตัวมีคุณภาพสูง ทีมงานให้คำปรึกษาดีมาก',
                                'rating' => 5,
                                'date' => '2 ม.ค. 2024'
                            )
                        );
                        
                        foreach ($default_testimonials as $testimonial) :
                    ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'active' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <blockquote>
                                    "<?php echo esc_html($testimonial['message']); ?>"
                                </blockquote>
                                <div class="testimonial-author">
                                    <div class="author-avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="author-info">
                                        <h5><?php echo esc_html($testimonial['name']); ?></h5>
                                        <p><?php echo esc_html($testimonial['company']); ?></p>
                                        <span class="testimonial-date"><?php echo esc_html($testimonial['date']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="testimonials-navigation">
                    <button class="testimonial-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="testimonial-next"><i class="fas fa-chevron-right"></i></button>
                </div>
                
                <div class="testimonials-dots"></div>
            </div>
        </div>
    </section>

    <!-- Awards Gallery -->
    <section class="awards-gallery-section">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('แกลเลอรี่รางวัลและใบรับรอง', 'ayam-bangkok'); ?></h2>
                <p class="section-description">
                    <?php _e('รางวัลและใบรับรองต่างๆ ที่เราได้รับจากหน่วยงานที่เกี่ยวข้อง', 'ayam-bangkok'); ?>
                </p>
            </div>
            
            <div class="gallery-filters">
                <button class="filter-btn active" data-filter="all"><?php _e('ทั้งหมด', 'ayam-bangkok'); ?></button>
                <button class="filter-btn" data-filter="awards"><?php _e('รางวัล', 'ayam-bangkok'); ?></button>
                <button class="filter-btn" data-filter="certificates"><?php _e('ใบรับรอง', 'ayam-bangkok'); ?></button>
                <button class="filter-btn" data-filter="media"><?php _e('สื่อมวลชน', 'ayam-bangkok'); ?></button>
            </div>
            
            <div class="awards-gallery">
                <?php
                $gallery_items = ayam_get_awards_gallery();
                if (!empty($gallery_items)) :
                    foreach ($gallery_items as $item) :
                ?>
                    <div class="gallery-item" data-category="<?php echo esc_attr($item['category']); ?>">
                        <div class="gallery-image">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                            <div class="gallery-overlay">
                                <button class="gallery-view-btn" data-image="<?php echo esc_url($item['image']); ?>" data-title="<?php echo esc_attr($item['title']); ?>">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <h4><?php echo esc_html($item['title']); ?></h4>
                            <p><?php echo esc_html($item['description']); ?></p>
                            <span class="gallery-date"><?php echo esc_html($item['date']); ?></span>
                        </div>
                    </div>
                <?php 
                    endforeach;
                else :
                    // Default gallery items
                    $default_gallery = array(
                        array(
                            'title' => 'รางวัลผู้ส่งออกดีเด่น 2023',
                            'description' => 'จากกรมการค้าต่างประเทศ',
                            'category' => 'awards',
                            'date' => '2023',
                            'image' => 'https://via.placeholder.com/400x300?text=Award+2023'
                        ),
                        array(
                            'title' => 'ใบรับรอง ISO 9001:2015',
                            'description' => 'มาตรฐานการจัดการคุณภาพ',
                            'category' => 'certificates',
                            'date' => '2021',
                            'image' => 'https://via.placeholder.com/400x300?text=ISO+Certificate'
                        ),
                        array(
                            'title' => 'ข่าวในหนังสือพิมพ์',
                            'description' => 'การรายงานข่าวความสำเร็จ',
                            'category' => 'media',
                            'date' => '2024',
                            'image' => 'https://via.placeholder.com/400x300?text=News+Media'
                        ),
                        array(
                            'title' => 'ใบรับรองสุขภาพสัตว์',
                            'description' => 'จากกรมปศุสัตว์',
                            'category' => 'certificates',
                            'date' => '2024',
                            'image' => 'https://via.placeholder.com/400x300?text=Health+Certificate'
                        ),
                        array(
                            'title' => 'รางวัลพันธมิตรทางการค้า',
                            'description' => 'จากสถานเอกอัครราชทูตอินโดนีเซีย',
                            'category' => 'awards',
                            'date' => '2022',
                            'image' => 'https://via.placeholder.com/400x300?text=Partnership+Award'
                        ),
                        array(
                            'title' => 'สัมภาษณ์ทางโทรทัศน์',
                            'description' => 'รายการเศรษฐกิจการเกษตร',
                            'category' => 'media',
                            'date' => '2023',
                            'image' => 'https://via.placeholder.com/400x300?text=TV+Interview'
                        )
                    );
                    
                    foreach ($default_gallery as $item) :
                ?>
                    <div class="gallery-item" data-category="<?php echo esc_attr($item['category']); ?>">
                        <div class="gallery-image">
                            <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                            <div class="gallery-overlay">
                                <button class="gallery-view-btn" data-image="<?php echo esc_url($item['image']); ?>" data-title="<?php echo esc_attr($item['title']); ?>">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gallery-info">
                            <h4><?php echo esc_html($item['title']); ?></h4>
                            <p><?php echo esc_html($item['description']); ?></p>
                            <span class="gallery-date"><?php echo esc_html($item['date']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="achievements-cta-section">
        <div class="container">
            <div class="cta-content">
                <h2><?php _e('พร้อมเป็นส่วนหนึ่งของความสำเร็จ?', 'ayam-bangkok'); ?></h2>
                <p><?php _e('เข้าร่วมกับเราและสัมผัสประสบการณ์การส่งออกไก่ชนคุณภาพสูงระดับมืออาชีพ', 'ayam-bangkok'); ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(get_post_type_archive_link('ayam_rooster')); ?>" class="btn btn-primary btn-large">
                        <?php _e('ดูไก่ชนของเรา', 'ayam-bangkok'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-large">
                        <?php _e('ติดต่อเรา', 'ayam-bangkok'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main><!-- #primary -->

<?php get_footer(); ?>