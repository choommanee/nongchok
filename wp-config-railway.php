<?php
/**
 * WordPress Configuration for Railway
 * Copy this to wp-config.php when deploying to Railway
 */

// ** Railway MySQL Database Settings ** //
define( 'DB_NAME', getenv('MYSQL_DATABASE') ?: 'railway' );
define( 'DB_USER', getenv('MYSQL_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('MYSQL_PASSWORD') ?: 'jNgCrBkMdKXzXMKukfrZNDcZsjjJPXiw' );
define( 'DB_HOST', getenv('MYSQL_HOST') ?: 'nozomi.proxy.rlwy.net:42710' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// ** Railway Environment Detection ** //
define( 'WP_ENVIRONMENT_TYPE', 'production' );

// ** Security Keys ** //
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// ** WordPress Database Table prefix ** //
$table_prefix = 'wp_';

// ** WordPress debugging mode ** //
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );

// ** Site URL Configuration for Railway ** //
if (isset($_SERVER['HTTP_HOST'])) {
    define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST']);
}

// ** Increase memory limit ** //
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// ** Disable file editing in admin ** //
define('DISALLOW_FILE_EDIT', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
