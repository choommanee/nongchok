<?php
/**
 * Plugin Name: Disable Canonical Redirects
 * Description: Prevents redirect loops on Railway deployment
 * Version: 1.0
 */

// Disable canonical redirects
add_filter('redirect_canonical', '__return_false');

// Disable term canonical redirects
add_filter('redirect_term_canonical', '__return_false');
