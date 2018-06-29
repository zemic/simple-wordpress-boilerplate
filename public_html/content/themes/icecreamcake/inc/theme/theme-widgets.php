<?php
/**
 * Ice Cream Cake widgets
 *
 * Set up the theme widgets.
 *
 */
if ( ! function_exists( 'icecreamcake_setup_widgets' ) ) :
    /**
     * Ice Cream Cake setup.
     *
     * Set up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support post thumbnails.
     *
     * @since Ice Cream Cake 2.0
     */
    function icecreamcake_setup_widgets() {

        // adding sidebars to Wordpress (these are created in functions.php)
        add_action( 'widgets_init', 'icecreamcake_register_sidebars' );

    }
endif; // icecreamcake_setup_widgets
add_action( 'after_setup_theme', 'icecreamcake_setup_widgets' );

/**
 * Active Sidebars
 * ---------------------------------------------------
 * Sidebars & Widgetizes Areas
**/
function icecreamcake_register_sidebars() {
    register_sidebar(array(
        'id' => 'sidebar1',
        'name' => __('Sidebar 1', 'icecreamcake'),
        'description' => __('The first (primary) sidebar.', 'icecreamcake'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

    /*
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code.
    */
}
