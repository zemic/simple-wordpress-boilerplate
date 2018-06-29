<?php
/**
 * Ice Cream Cake Theme Setup Files
 *
 * The included files setup our Ice Cream Cake theme defaults.
 * Edit individual files when customising the site theme.
 *
 */
require_once( 'inc/theme/theme-setup.php' );          // Theme setup - no need to edit
require_once( 'inc/theme/theme-menus.php' );          // Setup menus
require_once( 'inc/theme/theme-thumbnails.php' );     // Setup thumbnails
require_once( 'inc/theme/theme-enqueue.php' );        // Enqueue styles and scripts
require_once( 'inc/theme/theme-widgets.php' );        // Setup widgets
require_once( 'inc/theme/theme-admin.php' );          // Customises the WordPress control panel
require_once( 'inc/theme/theme-extras.php' );         // Useful theme functionality

/**
 * Developer Functions
 *
 * Include some helper functions if the site is in development mode
 */
if( WP_ENV == 'development' ) {
    require_once('inc/theme/functions-development.php');
}
