<?php
/**
 * WordPress Configuration for Railway Production
 *
 * This file will be copied to wp-config.php during Railway deployment
 */

// ** Detect HTTPS from Railway proxy ** //
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = '443';
}

// ** Railway MySQL Database Settings ** //
define( 'DB_NAME', getenv('MYSQL_DATABASE') ?: 'railway' );
define( 'DB_USER', getenv('MYSQL_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('MYSQL_PASSWORD') ?: '' );

// Railway provides MYSQL_HOST with port included (host:port)
// WordPress needs just host, port is already in the connection string format
$mysql_host = getenv('MYSQL_HOST') ?: 'localhost';
define( 'DB_HOST', $mysql_host );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         'ayam-bangkok-auth-key-2024-production-secure-railway' );
define( 'SECURE_AUTH_KEY',  'ayam-bangkok-secure-auth-key-nongchok-fci-2024-railway' );
define( 'LOGGED_IN_KEY',    'ayam-bangkok-logged-in-key-rooster-export-thailand-prod' );
define( 'NONCE_KEY',        'ayam-bangkok-nonce-key-fighting-cock-indonesia-secure' );
define( 'AUTH_SALT',        'ayam-bangkok-auth-salt-premium-roosters-export-railway' );
define( 'SECURE_AUTH_SALT', 'ayam-bangkok-secure-salt-thai-gamefowl-champion-prod' );
define( 'LOGGED_IN_SALT',   'ayam-bangkok-logged-salt-breeding-stock-quality-secure' );
define( 'NONCE_SALT',       'ayam-bangkok-nonce-salt-official-representative-prod' );
/**#@-*/

// ** WordPress Database Table prefix ** //
$table_prefix = 'wp_';

// ** WordPress debugging mode - ENABLED for troubleshooting ** //
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set('display_errors', 0);

// ** Site URL Configuration for Railway ** //
// Force HTTPS and auto-detect from Railway's HTTP_HOST
if (isset($_SERVER['HTTP_HOST'])) {
    // Railway always uses HTTPS in production
    $protocol = 'https';
    define('WP_HOME', $protocol . '://' . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $protocol . '://' . $_SERVER['HTTP_HOST']);
}

// Override any database values for home and siteurl
add_filter('option_home', function($url) {
    return defined('WP_HOME') ? WP_HOME : $url;
}, 1);

add_filter('option_siteurl', function($url) {
    return defined('WP_SITEURL') ? WP_SITEURL : $url;
}, 1);

// ** Disable WP Cron ** //
define('DISABLE_WP_CRON', true);

// ** Increase memory limit ** //
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// ** Disable file editing in admin for security ** //
define('DISALLOW_FILE_EDIT', true);

// ** Force SSL ** //
// define('FORCE_SSL_ADMIN', true); // Disabled - Railway proxy handles SSL

// ** Auto-save interval ** //
define('AUTOSAVE_INTERVAL', 300);

// ** Post revisions ** //
define('WP_POST_REVISIONS', 5);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
