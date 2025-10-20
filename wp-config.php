<?php
/**
 * WordPress Configuration for Railway Production
 */

// ** MySQL Database ** //
define('DB_NAME', 'railway');
define('DB_USER', 'root');
define('DB_PASSWORD', 'jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw');
define('DB_HOST', 'nozomi.proxy.rlwy.net:42710');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// ** Auto-detect Site URL from Railway ** //
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

if (isset($_SERVER['HTTP_HOST'])) {
    $site_url = 'https://' . $_SERVER['HTTP_HOST'];
    define('WP_HOME', $site_url);
    define('WP_SITEURL', $site_url);
}

// ** Authentication Keys ** //
define('AUTH_KEY',         'ayam-bangkok-auth-key-2024-production-secure-railway');
define('SECURE_AUTH_KEY',  'ayam-bangkok-secure-auth-key-nongchok-fci-2024-railway');
define('LOGGED_IN_KEY',    'ayam-bangkok-logged-in-key-rooster-export-thailand-prod');
define('NONCE_KEY',        'ayam-bangkok-nonce-key-fighting-cock-indonesia-secure');
define('AUTH_SALT',        'ayam-bangkok-auth-salt-premium-roosters-export-railway');
define('SECURE_AUTH_SALT', 'ayam-bangkok-secure-salt-thai-gamefowl-champion-prod');
define('LOGGED_IN_SALT',   'ayam-bangkok-logged-salt-breeding-stock-quality-secure');
define('NONCE_SALT',       'ayam-bangkok-nonce-salt-official-representative-prod');

$table_prefix = 'wp_';

// ** Performance & Security ** //
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
define('DISABLE_WP_CRON', true);
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');
define('DISALLOW_FILE_EDIT', true);
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 5);

/* That's all, stop editing! Happy publishing. */

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
