<?php
/**
 * THEME DEVELOPMENT FUNCTIONS
 *
 * This file contains some helpful functions for developing themes.
 */

// Format the PHP print_r output
if ( ! function_exists('print_error') ) :

    function print_error($input) {
        echo '<pre style="background:#000;border:2px solid #555;color:#fff;padding:10px;font: 13px Courier, sans-serif;">';
        print_r( $input );
        echo '</pre>';
    }

endif;

// Display all WordPress SQL queries
if ( ! function_exists('show_queries') ) :

    function show_queries() {
        global $wpdb;

        if ( current_user_can( 'administrator' ) ) {
            print_error( $wpdb->queries );
        }
    }

endif;
