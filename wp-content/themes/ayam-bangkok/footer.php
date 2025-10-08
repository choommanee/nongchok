<?php
/**
 * The template for displaying the footer
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
                <div class="footer-widgets">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-4'); ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .footer-widgets -->
            <?php else : ?>
                <!-- Default footer content when no widgets are active -->
                <div class="footer-widgets">
                    <div class="footer-widget">
                        <h3><?php _e('เกี่ยวกับเรา', 'ayam-bangkok'); ?></h3>
                        <p><?php _e('หนองจอก เอฟซีไอ เป็นตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย', 'ayam-bangkok'); ?></p>
                        
                        <div class="footer-social">
                            <?php if (ayam_get_company_info('facebook')) : ?>
                                <a href="<?php echo esc_url(ayam_get_company_info('facebook')); ?>" target="_blank" rel="noopener">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (ayam_get_company_info('youtube')) : ?>
                                <a href="<?php echo esc_url(ayam_get_company_info('youtube')); ?>" target="_blank" rel="noopener">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="footer-widget">
                        <h3><?php _e('เมนูหลัก', 'ayam-bangkok'); ?></h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class' => 'footer-menu',
                            'container' => false,
                            'fallback_cb' => 'ayam_footer_menu_fallback',
                        ));
                        ?>
                    </div>
                    
                    <div class="footer-widget">
                        <h3><?php _e('บริการของเรา', 'ayam-bangkok'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('ayam_rooster')); ?>"><?php _e('ไก่ชนคุณภาพ', 'ayam-bangkok'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('ayam_service')); ?>"><?php _e('บริการส่งออก', 'ayam-bangkok'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_post_type_archive_link('ayam_knowledge')); ?>"><?php _e('ศูนย์ความรู้', 'ayam-bangkok'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php _e('ปรึกษาผู้เชี่ยวชาญ', 'ayam-bangkok'); ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-widget">
                        <h3><?php _e('ติดต่อเรา', 'ayam-bangkok'); ?></h3>
                        <div class="contact-info">
                            <?php if (ayam_get_company_info('phone')) : ?>
                                <p>
                                    <i class="fas fa-phone"></i>
                                    <a href="tel:<?php echo esc_attr(ayam_get_company_info('phone')); ?>">
                                        <?php echo esc_html(ayam_get_company_info('phone')); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (ayam_get_company_info('email')) : ?>
                                <p>
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:<?php echo esc_attr(ayam_get_company_info('email')); ?>">
                                        <?php echo esc_html(ayam_get_company_info('email')); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (ayam_get_company_info('line_id')) : ?>
                                <p>
                                    <i class="fab fa-line"></i>
                                    <span><?php echo esc_html(ayam_get_company_info('line_id')); ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div><!-- .footer-widgets -->
            <?php endif; ?>
            
            <div class="footer-bottom">
                <div class="footer-info">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('สงวนลิขสิทธิ์', 'ayam-bangkok'); ?></p>
                    <p><?php _e('ตัวแทนส่งออกไก่ชนไปยังประเทศอินโดนีเซียอย่างเป็นทางการรายเดียวของประเทศไทย', 'ayam-bangkok'); ?></p>
                </div>
                
                <div class="footer-links">
                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php _e('นโยบายความเป็นส่วนตัว', 'ayam-bangkok'); ?></a>
                    <span class="separator">|</span>
                    <a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>"><?php _e('เงื่อนไขการใช้งาน', 'ayam-bangkok'); ?></a>
                    <span class="separator">|</span>
                    <a href="<?php echo esc_url(home_url('/sitemap/')); ?>"><?php _e('แผนผังเว็บไซต์', 'ayam-bangkok'); ?></a>
                </div>
            </div><!-- .footer-bottom -->
            
        </div><!-- .container -->
    </footer><!-- #colophon -->
    
</div><!-- #page -->

<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top" aria-label="<?php _e('กลับไปด้านบน', 'ayam-bangkok'); ?>">
    <i class="fas fa-chevron-up"></i>
</button>

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Footer menu fallback
 */
function ayam_footer_menu_fallback() {
    echo '<ul class="footer-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('หน้าแรก', 'ayam-bangkok') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">' . __('เกี่ยวกับเรา', 'ayam-bangkok') . '</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('ayam_rooster')) . '">' . __('ไก่ชน', 'ayam-bangkok') . '</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('ayam_service')) . '">' . __('บริการ', 'ayam-bangkok') . '</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('ayam_news')) . '">' . __('ข่าวสาร', 'ayam-bangkok') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">' . __('ติดต่อเรา', 'ayam-bangkok') . '</a></li>';
    echo '</ul>';
}
?>