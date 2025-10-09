<?php
/**
 * Plugin Name: Disable Canonical Redirects & Force HTTPS
 * Description: Prevents redirect loops and forces HTTPS on Railway deployment
 * Version: 1.1
 */

// Disable canonical redirects
add_filter('redirect_canonical', '__return_false');

// Disable term canonical redirects
add_filter('redirect_term_canonical', '__return_false');

// Force HTTPS for all scripts and styles
add_filter('script_loader_src', function($src) {
    return str_replace('http://', 'https://', $src);
}, 10, 1);

add_filter('style_loader_src', function($src) {
    return str_replace('http://', 'https://', $src);
}, 10, 1);

// Force HTTPS for content URLs
add_filter('wp_get_attachment_url', function($url) {
    return str_replace('http://', 'https://', $url);
}, 10, 1);

add_filter('the_content', function($content) {
    return str_replace('http://nongchok-production.up.railway.app', 'https://nongchok-production.up.railway.app', $content);
}, 10, 1);
