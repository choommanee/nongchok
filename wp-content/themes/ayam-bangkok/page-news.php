<?php
/**
 * Template for News & Events page
 */

get_header(); ?>

<main id="primary" class="site-main news-page">
    
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title"><?php _e('ข่าวสารและกิจกรรม', 'ayam-bangkok'); ?></h1>
                <p class="page-subtitle"><?php _e('ติดตามข่าวสารล่าสุดและกิจกรรมของ Ayam Bangkok', 'ayam-bangkok'); ?></p>
            </div>
        </div>
    </section>

    <!-- News Filter -->
    <section class="news-filter-section">
        <div class="container">
            <div class="filter-tabs">
                <button class="filter-btn active" data-filter="all"><?php _e('ทั้งหมด', 'ayam-bangkok'); ?></button>
                <button class="filter-btn" data-filter="news"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></button>
                <button class="filter-btn" data-filter="events"><?php _e('กิจกรรม', 'ayam-bangkok'); ?></button>
                <button class="filter-btn" data-filter="announcements"><?php _e('ประกาศ', 'ayam-bangkok'); ?></button>
            </div>
            
            <div class="search-box">
                <input type="text" id="news-search" placeholder="<?php _e('ค้นหาข่าวสาร...', 'ayam-bangkok'); ?>">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </section>

    <!-- Featured News -->
    <section class="featured-news-section">
        <div class="container">
            <h2 class="section-title"><?php _e('ข่าวเด่น', 'ayam-bangkok'); ?></h2>
            
            <div class="featured-news-grid">
                <article class="featured-news-item main-featured">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/featured-1.jpg" alt="ข่าวเด่น">
                        <div class="news-category"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 15 มกราคม 2024</span>
                            <span class="news-author"><i class="fas fa-user"></i> Admin</span>
                        </div>
                        <h3 class="news-title"><?php _e('Ayam Bangkok ขยายตลาดส่งออกไก่ชนไปยังมาเลเซีย', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('บริษัทได้รับการอนุมัติให้ส่งออกไก่ชนคุณภาพสูงไปยังประเทศมาเลเซีย เพิ่มช่องทางการขายในตลาดอาเซียน...', 'ayam-bangkok'); ?></p>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
                
                <div class="featured-news-sidebar">
                    <article class="featured-news-item">
                        <div class="news-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/featured-2.jpg" alt="ข่าวเด่น">
                            <div class="news-category"><?php _e('กิจกรรม', 'ayam-bangkok'); ?></div>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-date"><i class="fas fa-calendar"></i> 12 มกราคม 2024</span>
                            </div>
                            <h4 class="news-title"><?php _e('งานแสดงไก่ชนนานาชาติ 2024', 'ayam-bangkok'); ?></h4>
                            <p class="news-excerpt"><?php _e('เชิญร่วมงานแสดงไก่ชนนานาชาติประจำปี 2024...', 'ayam-bangkok'); ?></p>
                        </div>
                    </article>
                    
                    <article class="featured-news-item">
                        <div class="news-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/featured-3.jpg" alt="ข่าวเด่น">
                            <div class="news-category"><?php _e('ประกาศ', 'ayam-bangkok'); ?></div>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-date"><i class="fas fa-calendar"></i> 10 มกราคม 2024</span>
                            </div>
                            <h4 class="news-title"><?php _e('ประกาศปรับปรุงระบบการสั่งซื้อออนไลน์', 'ayam-bangkok'); ?></h4>
                            <p class="news-excerpt"><?php _e('เพื่อให้บริการที่ดีขึ้น เราจะปรับปรุงระบบ...', 'ayam-bangkok'); ?></p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="news-grid-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php _e('ข่าวสารทั้งหมด', 'ayam-bangkok'); ?></h2>
                <div class="sort-options">
                    <select id="news-sort">
                        <option value="latest"><?php _e('ล่าสุด', 'ayam-bangkok'); ?></option>
                        <option value="oldest"><?php _e('เก่าสุด', 'ayam-bangkok'); ?></option>
                        <option value="popular"><?php _e('ยอดนิยม', 'ayam-bangkok'); ?></option>
                    </select>
                </div>
            </div>
            
            <div class="news-grid" id="news-grid">
                <!-- News Item 1 -->
                <article class="news-item" data-category="news">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/news-1.jpg" alt="ข่าวสาร">
                        <div class="news-category"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 8 มกราคม 2024</span>
                            <span class="news-views"><i class="fas fa-eye"></i> 245</span>
                        </div>
                        <h3 class="news-title"><?php _e('เทคนิคการเลี้ยงไก่ชนในฤดูฝน', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('การดูแลไก่ชนในช่วงฤดูฝนต้องใส่ใจเป็นพิเศษ เพื่อป้องกันโรคและรักษาสุขภาพที่ดี...', 'ayam-bangkok'); ?></p>
                        <div class="news-tags">
                            <span class="tag"><?php _e('การเลี้ยง', 'ayam-bangkok'); ?></span>
                            <span class="tag"><?php _e('สุขภาพ', 'ayam-bangkok'); ?></span>
                        </div>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
                
                <!-- News Item 2 -->
                <article class="news-item" data-category="events">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/event-1.jpg" alt="กิจกรรม">
                        <div class="news-category"><?php _e('กิจกรรม', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 5 มกราคม 2024</span>
                            <span class="news-views"><i class="fas fa-eye"></i> 189</span>
                        </div>
                        <h3 class="news-title"><?php _e('สัมมนาการส่งออกไก่ชนสู่ตลาดโลก', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('เชิญร่วมสัมมนาเรื่องการส่งออกไก่ชนและกฎระเบียบการค้าระหว่างประเทศ...', 'ayam-bangkok'); ?></p>
                        <div class="news-tags">
                            <span class="tag"><?php _e('สัมมนา', 'ayam-bangkok'); ?></span>
                            <span class="tag"><?php _e('ส่งออก', 'ayam-bangkok'); ?></span>
                        </div>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
                
                <!-- News Item 3 -->
                <article class="news-item" data-category="announcements">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/announcement-1.jpg" alt="ประกาศ">
                        <div class="news-category"><?php _e('ประกาศ', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 3 มกราคม 2024</span>
                            <span class="news-views"><i class="fas fa-eye"></i> 156</span>
                        </div>
                        <h3 class="news-title"><?php _e('ประกาศหยุดรับออเดอร์ช่วงเทศกาลตรุษจีน', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('เนื่องในโอกาสเทศกาลตรุษจีน บริษัทจะหยุดรับออเดอร์ตั้งแต่วันที่...', 'ayam-bangkok'); ?></p>
                        <div class="news-tags">
                            <span class="tag"><?php _e('ประกาศ', 'ayam-bangkok'); ?></span>
                            <span class="tag"><?php _e('วันหยุด', 'ayam-bangkok'); ?></span>
                        </div>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
                
                <!-- News Item 4 -->
                <article class="news-item" data-category="news">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/news-2.jpg" alt="ข่าวสาร">
                        <div class="news-category"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 1 มกราคม 2024</span>
                            <span class="news-views"><i class="fas fa-eye"></i> 298</span>
                        </div>
                        <h3 class="news-title"><?php _e('แนวโน้มตลาดไก่ชนปี 2024', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('วิเคราะห์แนวโน้มตลาดไก่ชนในปี 2024 และโอกาสทางธุรกิจที่น่าสนใจ...', 'ayam-bangkok'); ?></p>
                        <div class="news-tags">
                            <span class="tag"><?php _e('ตลาด', 'ayam-bangkok'); ?></span>
                            <span class="tag"><?php _e('แนวโน้ม', 'ayam-bangkok'); ?></span>
                        </div>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
                
                <!-- News Item 5 -->
                <article class="news-item" data-category="events">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/event-2.jpg" alt="กิจกรรม">
                        <div class="news-category"><?php _e('กิจกรรม', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 28 ธันวาคม 2023</span>
                            <span class="news-views"><i class="fas fa-eye"></i> 167</span>
                        </div>
                        <h3 class="news-title"><?php _e('การแข่งขันไก่ชนชิงแชมป์ภาคใต้', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('ร่วมเชียร์การแข่งขันไก่ชนชิงแชมป์ภาคใต้ ประจำปี 2023 ที่จังหวัดสงขลา...', 'ayam-bangkok'); ?></p>
                        <div class="news-tags">
                            <span class="tag"><?php _e('แข่งขัน', 'ayam-bangkok'); ?></span>
                            <span class="tag"><?php _e('ภาคใต้', 'ayam-bangkok'); ?></span>
                        </div>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
                
                <!-- News Item 6 -->
                <article class="news-item" data-category="news">
                    <div class="news-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/news-3.jpg" alt="ข่าวสาร">
                        <div class="news-category"><?php _e('ข่าวสาร', 'ayam-bangkok'); ?></div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar"></i> 25 ธันวาคม 2023</span>
                            <span class="news-views"><i class="fas fa-eye"></i> 203</span>
                        </div>
                        <h3 class="news-title"><?php _e('นวัตกรรมใหม่ในการขนส่งไก่ชน', 'ayam-bangkok'); ?></h3>
                        <p class="news-excerpt"><?php _e('เทคโนโลยีใหม่ในการขนส่งไก่ชนที่ปลอดภัยและลดความเครียดให้กับสัตว์...', 'ayam-bangkok'); ?></p>
                        <div class="news-tags">
                            <span class="tag"><?php _e('นวัตกรรม', 'ayam-bangkok'); ?></span>
                            <span class="tag"><?php _e('ขนส่ง', 'ayam-bangkok'); ?></span>
                        </div>
                        <a href="#" class="read-more-btn"><?php _e('อ่านต่อ', 'ayam-bangkok'); ?></a>
                    </div>
                </article>
            </div>
            
            <!-- Load More Button -->
            <div class="load-more-section">
                <button class="load-more-btn" id="load-more-news">
                    <i class="fas fa-plus"></i>
                    <?php _e('โหลดข่าวเพิ่มเติม', 'ayam-bangkok'); ?>
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter Subscription -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h3><?php _e('รับข่าวสารล่าสุด', 'ayam-bangkok'); ?></h3>
                    <p><?php _e('สมัครรับข่าวสารและอัปเดตล่าสุดจาก Ayam Bangkok', 'ayam-bangkok'); ?></p>
                </div>
                <form class="newsletter-form" id="newsletter-form">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="<?php _e('อีเมลของคุณ', 'ayam-bangkok'); ?>" required>
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                            <?php _e('สมัครรับข่าวสาร', 'ayam-bangkok'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();