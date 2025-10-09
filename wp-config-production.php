<?php
/**
 * WordPress Configuration for Railway Production
 *
 * This file will be copied to wp-config.php during Railway deployment
 */

// ** Railway MySQL Database Settings ** //
define( 'DB_NAME', getenv('MYSQL_DATABASE') ?: 'railway' );
define( 'DB_USER', getenv('MYSQL_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('MYSQL_PASSWORD') ?: '' );
define( 'DB_HOST', getenv('MYSQL_HOST') ?: 'localhost' );
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
// Let WordPress use the URLs from database to avoid redirect loops
// define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST']);
// define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST']);

// ** Disable WP Cron ** //
define('DISABLE_WP_CRON', true);

// ** Increase memory limit ** //
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// ** Disable file editing in admin for security ** //
define('DISALLOW_FILE_EDIT', true);

// ** Force SSL ** //
define('FORCE_SSL_ADMIN', value: false); // Disabled - Railway proxy handles SSL

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
