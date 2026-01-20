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