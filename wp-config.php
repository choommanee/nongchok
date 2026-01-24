<?php
/**
 * WordPress Configuration for Local Development
 *
 * Copy this file to wp-config.php when developing locally
 */

// ** Load environment variables from .env file ** //
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(sprintf('%s=%s', trim($name), trim($value)));
    }
}

// ** Local MySQL Database Settings ** //
define( 'DB_NAME', getenv('MYSQL_DATABASE') ?: 'nongchok' );
define( 'DB_USER', getenv('MYSQL_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('MYSQL_PASSWORD') ?: '' );
define( 'DB_HOST', getenv('MYSQL_HOST') ?: 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         'ayam-bangkok-auth-key-2024-local-dev' );
define( 'SECURE_AUTH_KEY',  'ayam-bangkok-secure-auth-key-local' );
define( 'LOGGED_IN_KEY',    'ayam-bangkok-logged-in-key-local' );
define( 'NONCE_KEY',        'ayam-bangkok-nonce-key-local' );
define( 'AUTH_SALT',        'ayam-bangkok-auth-salt-local' );
define( 'SECURE_AUTH_SALT', 'ayam-bangkok-secure-salt-local' );
define( 'LOGGED_IN_SALT',   'ayam-bangkok-logged-salt-local' );
define( 'NONCE_SALT',       'ayam-bangkok-nonce-salt-local' );
/**#@-*/

// ** WordPress Database Table prefix ** //
$table_prefix = 'wp_';

// ** WordPress debugging mode - ENABLED for local development ** //
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
@ini_set('display_errors', 1);

// ** Site URL Configuration for Local ** //
// Force HTTP for local development
$_SERVER['HTTPS'] = 'off';
define('WP_HOME', 'https://nongchok.local/');
define('WP_SITEURL', 'https://nongchok.local/');
define('FORCE_SSL_ADMIN', false);

// ** Disable WP Cron ** //
define('DISABLE_WP_CRON', false);

// ** Increase memory limit ** //
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// ** Allow file editing in admin for local dev ** //
define('DISALLOW_FILE_EDIT', false);

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
