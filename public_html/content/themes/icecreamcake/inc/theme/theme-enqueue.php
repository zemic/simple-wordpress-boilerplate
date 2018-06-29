<?php
/**
 * Ice Cream Cake enqueue styles & scripts.
 *
 * Enqueue theme styles and scripts for the front end.
 *
 * For more information on wp_enqueue_script and wp_enqueue_style
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 */
if ( ! function_exists( 'icecreamcake_scripts' ) ) :

    function icecreamcake_scripts() {

        // SCRIPTS
        if (!empty(TYPEKIT_ID)) {
            wp_enqueue_script( 'typekit', '//use.typekit.net/' . TYPEKIT_ID . '.js' ); // TypeKit
        }

        // Load our JS in the header (before the closing <head> tag)
        wp_enqueue_script( 'script-head', get_template_directory_uri() . '/assets/js/min/scripts-header.min.js', array( 'jquery' ), '', false );

        // Load our JS in the footer (before closing <body> tag)
        wp_enqueue_script( 'script-footer', get_template_directory_uri() . '/assets/js/min/scripts-footer.min.js', array( 'jquery', 'wp-util' ), '', true );

        // Localise ajax scripts
        wp_localize_script( 'script-footer', 'ajaxObject', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'ajaxNonce' => wp_create_nonce( 'next-nonce' ))
        );

        // STYLESHEETS
        wp_enqueue_style( 'styles', get_stylesheet_directory_uri() . '/assets/css/styles.css', '', '', 'all' );

        // Load the Internet Explorer specific stylesheet.
        //wp_enqueue_style( 'iestyles', get_template_directory_uri() . '/assets/css/ie8-only.css', array( 'styles' ) );
        //wp_style_add_data( 'iestyles', 'conditional', 'lt IE 9' );
    }
    add_action( 'wp_enqueue_scripts', 'icecreamcake_scripts' );

endif; // icecreamcake_scripts

/**
 * TypeKit Fonts
 *
 * Add TypeKit inline script to <head>
 */
if ( ! function_exists( 'icecreamcake_typekit_inline' ) ) :

    function icecreamcake_typekit_inline() {

        if ( !empty(TYPEKIT_ID) && wp_script_is( 'typekit', 'done' ) ) {
            ?>
            <script>try{Typekit.load();}catch(e){}</script>
            <?php
        }

    }
    add_action( 'wp_head', 'icecreamcake_typekit_inline' );

endif;
