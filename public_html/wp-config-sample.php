<?php
// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define('AUTH_KEY',         '');
define('SECURE_AUTH_KEY',  '');
define('LOGGED_IN_KEY',    '');
define('NONCE_KEY',        '');
define('AUTH_SALT',        '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT',   '');
define('NONCE_SALT',       '');

// ==============================================================
// Database parameters
// ==============================================================
if (file_exists( dirname( __FILE__ ) . '/wp-config.local.php')) {
    include( dirname( __FILE__ ) . '/wp-config.local.php' );
} else {
    if( preg_match('/^www2\./i', $_SERVER[ 'SERVER_NAME' ] ) ) {
        define( 'DB_HOST',         '' );
        define( 'DB_NAME',         '' );
        define( 'DB_USER',         '' );
        define( 'DB_PASSWORD',     '' );
        define( 'WP_ENV',          'production' );
        define( 'WP_HOME',         'https://www2.domain.com.au' );
        define( 'WP_SITEURL',      WP_HOME . '/wp' );
    }
    else {
        define( 'DB_HOST',         '' );
        define( 'DB_NAME',         '' );
        define( 'DB_USER',         '' );
        define( 'DB_PASSWORD',     '' );
        define( 'WP_ENV',          'production' );
        define( 'WP_HOME',         'https://www.domain.com.au' );
        define( 'WP_SITEURL',      WP_HOME . '/wp' );
        define( 'FORCE_SSL_LOGIN',  true );
        define( 'FORCE_SSL_ADMIN',  true );
    }

    if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $_SERVER['HTTPS'] = 'on';
    }
}

define( 'WP_TBL_PREFIX',   'wp_' );
define( 'DB_CHARSET',      'utf8' );   // MySQL database charset
define( 'DB_COLLATE',      '' );       // MySQL database collate

/* MySQL database table prefix. */
$table_prefix = WP_TBL_PREFIX;

// ==============================================================
// AWS Access Keys for Media Uploads to S3
// ==============================================================
define( 'AWS_ACCESS_KEY_ID',         '' );
define( 'AWS_SECRET_ACCESS_KEY',     '' );

// ==============================================================
// TypeKit ID
// ==============================================================
define( 'TYPEKIT_ID',                '' );

// ==============================================================
// Custom WordPress Directory / URLs
// ==============================================================
define( 'WP_CONTENT_DIR',            dirname( __FILE__ ) . '/content' );                     // custom content directory
define( 'WP_CONTENT_URL',            'http://' . $_SERVER[ 'SERVER_NAME' ] . '/content' );   // custom content directory URL

// ==============================================================
// Specify maximum number of Revisions (off by default)
// ==============================================================
define( 'WP_POST_REVISIONS',         5 );

// ==============================================================
// Wordpress Auto Save Interval (seconds)
// ==============================================================
define( 'AUTOSAVE_INTERVAL',         120 );

// ==============================================================
// Wordpress Trash
// ==============================================================
define( 'MEDIA_TRASH',               true );
define( 'EMPTY_TRASH_DAYS',          30 );

// ==============================================================
// Wordpress Auto Updates
// ==============================================================
define( 'AUTOMATIC_UPDATER_DISABLED',true );

// ==============================================================
// Compression
// ==============================================================
define( 'ENFORCE_GZIP',              true );

// ==============================================================
// Memory limit
// ==============================================================
define( 'WP_MEMORY_LIMIT',           '64M' );

// ==============================================================
// Disable some harmful features
// File modification and plugin/theme editor
// ==============================================================
define( 'DISALLOW_FILE_MODS',        true );
define( 'DISALLOW_FILE_EDIT',        true );
define( 'DISALLOW_UNFILTERED_HTML',  true );

// ==============================================================
// Debug mode
// set WP_ENV to either 'development' or 'production'
// ==============================================================
if( WP_ENV == 'development' ) {
    define( 'WP_DEBUG',             true ); // Display errors and warnings.
    define( 'WP_DEBUG_LOG',         true ); // Log errors and warnings.
    define( 'WP_DEBUG_DISPLAY',     true ); // Display errors and warnings.
    define( 'SCRIPT_DEBUG',         true ); // JavaScript or CSS errors.
    define( 'SAVEQUERIES',          true ); // Save database queries in an array ($wpdb->queries) for analysis.
}

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
