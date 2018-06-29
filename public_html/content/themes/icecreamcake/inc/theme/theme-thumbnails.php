<?php
/**
 * Ice Cream Cake setup thumbnails.
 *
 * Set up the theme thumbnails support.
 *
 * For more information on add_theme_support
 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
 *
 */

/**
 * Thumbnail size options
 *
 * To add more media sizes, simply copy the add_image_size function below
 * and change the dimensions & name. As long as you upload a "featured image"
 * as large as the biggest set width or height, all the other sizes will be
 * auto-cropped.
 *
 * To call a different size, simply change the text inside the thumbnail
 * function.
 *
 * For example, to call the 300 x 300 sized image, we would use the function:
 * <?php the_post_thumbnail( 'thumb-300' ); ?> for the 600 x 100 image:
 * <?php the_post_thumbnail( 'thumb-600' ); ?>
 *
 * You can change the names and dimensions to whatever you like.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_image_size
 */
if ( ! function_exists( 'icecreamcake_generate_image_sizes' ) ) :

    function icecreamcake_generate_image_sizes() {

        //add_image_size( $name, $width, $height, $crop );

    }
endif; // generate_image_sizes

/**
 * Enable support for post thumbnails
 */
if ( ! function_exists( 'icecreamcake_setup_thumbnails' ) ) :

    function icecreamcake_setup_thumbnails() {
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 320, 320, true );

        // Call the function that specifies custom image sizes
        icecreamcake_generate_image_sizes();
    }

endif; // icecreamcake_setup_thumbnails
add_action( 'after_setup_theme', 'icecreamcake_setup_thumbnails' );
