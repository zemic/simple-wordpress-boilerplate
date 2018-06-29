<?php
/**
 * Ice Cream Cake setup menus and navigational functions.
 *
 * Set up the theme menus and provide some helper functions which are used in
 * the theme to call different navigation menus.
 *
 * For more information on register_nav_menus
 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
 *
 */
if ( ! function_exists( 'icecreamcake_setup_menus' ) ) :

    function icecreamcake_setup_menus() {

        register_nav_menus( array(
            'header-large' => __( 'Header large screen menu', 'icecreamcake' ),
            'header-small' => __( 'Header small screen menu', 'icecreamcake' ),
            'footer-large' => __( 'Footer large screen menu', 'icecreamcake' ),
            'footer-small' => __( 'Footer small screen menu', 'icecreamcake' ),
        ) );

    }

endif; // icecreamcake_setup_menus
add_action( 'after_setup_theme', 'icecreamcake_setup_menus' );

/**
 * Helper menu calling functions
 *
 * These functions act as shortcodes to call the various
 * menus.
 *
 * For more information on wp_nav_menu
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
function header_large_menu() {

    wp_nav_menu(array(
        'container'         => false,                   // remove nav container
        'menu_class'        => 'header-large-menu',    // adding custom nav class
        'theme_location'    => 'header-large',         // where it's located in the theme
        'depth'             => 0,                       // limit the depth of the nav
    ));

} // primary_large_menu

function header_small_menu() {

    wp_nav_menu(array(
        'container'         => false,                   // remove nav container
        'menu_class'        => 'header-small-menu',    // adding custom nav class
        'theme_location'    => 'header-small',         // where it's located in the theme
        'depth'             => 0,                       // limit the depth of the nav
    ));

} // primary_small_menu

function footer_large_menu() {

    wp_nav_menu(array(
        'container'         => false,                   // remove nav container
        'menu_class'        => 'footer-large-menu',     // adding custom nav class
        'theme_location'    => 'footer-large',          // where it's located in the theme
        'depth'             => 0,                       // limit the depth of the nav
    ));

} // footer_large_menu

function footer_small_menu() {

    wp_nav_menu(array(
        'container'         => false,                   // remove nav container
        'menu_class'        => 'footer-small-menu',     // adding custom nav class
        'theme_location'    => 'footer-small',          // where it's located in the theme
        'depth'             => 0,                       // limit the depth of the nav
    ));

} // footer_small_menu
