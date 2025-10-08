<?php
/**
 * Custom User Roles for Ayam Bangkok
 */

if (!defined('ABSPATH')) {
    exit;
}

class AyamUserRoles {
    
    public function __construct() {
        // User roles are added during plugin activation
    }
    
    /**
     * Add custom user roles
     */
    public static function add_roles() {
        // Manager Role
        add_role('ayam_manager', __('ผู้จัดการ', 'ayam-bangkok'), array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
            'publish_posts' => true,
            'upload_files' => true,
            'edit_pages' => true,
            'delete_pages' => true,
            'publish_pages' => true,
            'edit_others_posts' => true,
            'delete_others_posts' => true,
            'edit_published_posts' => true,
            'delete_published_posts' => true,
            'edit_others_pages' => true,
            'delete_others_pages' => true,
            'edit_published_pages' => true,
            'delete_published_pages' => true,
            'manage_categories' => true,
            'moderate_comments' => true,
            // Custom capabilities for Ayam Bangkok
            'edit_ayam_roosters' => true,
            'edit_others_ayam_roosters' => true,
            'publish_ayam_roosters' => true,
            'read_private_ayam_roosters' => true,
            'delete_ayam_roosters' => true,
            'delete_private_ayam_roosters' => true,
            'delete_published_ayam_roosters' => true,
            'delete_others_ayam_roosters' => true,
            'edit_private_ayam_roosters' => true,
            'edit_published_ayam_roosters' => true,
            'edit_ayam_services' => true,
            'edit_others_ayam_services' => true,
            'publish_ayam_services' => true,
            'read_private_ayam_services' => true,
            'delete_ayam_services' => true,
            'edit_ayam_news' => true,
            'edit_others_ayam_news' => true,
            'publish_ayam_news' => true,
            'read_private_ayam_news' => true,
            'delete_ayam_news' => true,
            'manage_ayam_bookings' => true,
            'view_ayam_reports' => true,
        ));
        
        // Staff Role
        add_role('ayam_staff', __('เจ้าหน้าที่', 'ayam-bangkok'), array(
            'read' => true,
            'upload_files' => true,
            'edit_posts' => true,
            'delete_posts' => true,
            'publish_posts' => true,
            // Custom capabilities for Ayam Bangkok
            'edit_ayam_roosters' => true,
            'publish_ayam_roosters' => true,
            'delete_ayam_roosters' => true,
            'edit_published_ayam_roosters' => true,
            'delete_published_ayam_roosters' => true,
            'edit_ayam_services' => true,
            'publish_ayam_services' => true,
            'edit_ayam_news' => true,
            'publish_ayam_news' => true,
            'respond_to_inquiries' => true,
        ));
        
        // Premium Member Role
        add_role('premium_member', __('สมาชิกพิเศษ', 'ayam-bangkok'), array(
            'read' => true,
            'view_premium_content' => true,
            'access_special_pricing' => true,
            'priority_booking' => true,
            'view_detailed_rooster_info' => true,
            'contact_direct' => true,
        ));
        
        // Regular Member Role
        add_role('regular_member', __('สมาชิกทั่วไป', 'ayam-bangkok'), array(
            'read' => true,
            'view_rooster_catalog' => true,
            'submit_inquiries' => true,
            'book_services' => true,
        ));
        
        // Add custom capabilities to administrator
        $admin_role = get_role('administrator');
        if ($admin_role) {
            $admin_capabilities = array(
                'edit_ayam_roosters',
                'edit_others_ayam_roosters',
                'publish_ayam_roosters',
                'read_private_ayam_roosters',
                'delete_ayam_roosters',
                'delete_private_ayam_roosters',
                'delete_published_ayam_roosters',
                'delete_others_ayam_roosters',
                'edit_private_ayam_roosters',
                'edit_published_ayam_roosters',
                'edit_ayam_services',
                'edit_others_ayam_services',
                'publish_ayam_services',
                'read_private_ayam_services',
                'delete_ayam_services',
                'delete_private_ayam_services',
                'delete_published_ayam_services',
                'delete_others_ayam_services',
                'edit_private_ayam_services',
                'edit_published_ayam_services',
                'edit_ayam_news',
                'edit_others_ayam_news',
                'publish_ayam_news',
                'read_private_ayam_news',
                'delete_ayam_news',
                'delete_private_ayam_news',
                'delete_published_ayam_news',
                'delete_others_ayam_news',
                'edit_private_ayam_news',
                'edit_published_ayam_news',
                'edit_ayam_knowledge',
                'edit_others_ayam_knowledge',
                'publish_ayam_knowledge',
                'read_private_ayam_knowledge',
                'delete_ayam_knowledge',
                'manage_ayam_bookings',
                'view_ayam_reports',
                'manage_ayam_settings',
            );
            
            foreach ($admin_capabilities as $cap) {
                $admin_role->add_cap($cap);
            }
        }
    }
    
    /**
     * Remove custom user roles
     */
    public static function remove_roles() {
        remove_role('ayam_manager');
        remove_role('ayam_staff');
        remove_role('premium_member');
        remove_role('regular_member');
        
        // Remove custom capabilities from administrator
        $admin_role = get_role('administrator');
        if ($admin_role) {
            $admin_capabilities = array(
                'edit_ayam_roosters',
                'edit_others_ayam_roosters',
                'publish_ayam_roosters',
                'read_private_ayam_roosters',
                'delete_ayam_roosters',
                'delete_private_ayam_roosters',
                'delete_published_ayam_roosters',
                'delete_others_ayam_roosters',
                'edit_private_ayam_roosters',
                'edit_published_ayam_roosters',
                'edit_ayam_services',
                'edit_others_ayam_services',
                'publish_ayam_services',
                'read_private_ayam_services',
                'delete_ayam_services',
                'delete_private_ayam_services',
                'delete_published_ayam_services',
                'delete_others_ayam_services',
                'edit_private_ayam_services',
                'edit_published_ayam_services',
                'edit_ayam_news',
                'edit_others_ayam_news',
                'publish_ayam_news',
                'read_private_ayam_news',
                'delete_ayam_news',
                'delete_private_ayam_news',
                'delete_published_ayam_news',
                'delete_others_ayam_news',
                'edit_private_ayam_news',
                'edit_published_ayam_news',
                'edit_ayam_knowledge',
                'edit_others_ayam_knowledge',
                'publish_ayam_knowledge',
                'read_private_ayam_knowledge',
                'delete_ayam_knowledge',
                'manage_ayam_bookings',
                'view_ayam_reports',
                'manage_ayam_settings',
            );
            
            foreach ($admin_capabilities as $cap) {
                $admin_role->remove_cap($cap);
            }
        }
    }
}