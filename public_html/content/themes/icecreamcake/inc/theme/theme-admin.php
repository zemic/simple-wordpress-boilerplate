<?php
/**
 * Ice Cream Cake Admin Setup
 *
 * Set up the admin area with functions, actions and hooks.
 */

// Tidy the admin dashboard
if ( ! function_exists( 'icecreamcake_admin_dashboard' ) ) :

    function icecreamcake_admin_dashboard() {
        // remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );    // Right Now Widget
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' ); // Comments Widget
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );  // Incoming Links Widget
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );         // Plug-ins Widget
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );     // Quick Press Widget
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );   // Recent Drafts Widget
        remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );         //
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );       //
        remove_action( 'welcome_panel', 'wp_welcome_panel' );                // Hide welcome panel WP 3.3 addition

        // remove popular plug-in meta boxes
        remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');      // Gravity Forms Widget
        remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plug-in Widget
    }
    add_action('admin_menu', 'icecreamcake_admin_dashboard');

endif;

/**
 * Control panel sidebar links
 * Disable some default WordPress control panel options for a cleaner interface
 */
if ( ! function_exists( 'icecreamcake_disable_admin_menu_links' ) ) :

    function icecreamcake_disable_admin_menu_links() {
         //remove_menu_page('index.php');                   // Dashboard
         //remove_menu_page('edit.php');                    // Posts
         //remove_menu_page('upload.php');                  // Media
         remove_menu_page('link-manager.php');              // Links
         //remove_menu_page('edit.php?post_type=page');     // Pages
         remove_menu_page('edit-comments.php');             // Comments
         //remove_menu_page('themes.php');                  // Appearance
         //remove_menu_page('plugins.php');                 // Plugins
         //remove_menu_page('users.php');                   // Users
         //remove_menu_page('tools.php');                   // Tools
         //remove_menu_page('options-general.php');         // Settings
    }
    add_action( 'admin_menu', 'icecreamcake_disable_admin_menu_links' );

endif;

// Disable the EDITOR option from Appearance menu
function icecreamcake_remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('admin_menu', 'icecreamcake_remove_editor_menu', 1);

/**
 * Dashboard Columns
 * Change the default number of dashboard columns from 2 to 1
 */
if ( ! function_exists( 'icecreamcake_single_screen_columns' ) ) :

    function icecreamcake_single_screen_columns( $columns ) {
        $columns[ 'dashboard' ] = 1;
        return $columns;
    }

endif;
add_filter( 'screen_layout_columns', 'icecreamcake_single_screen_columns' );
add_filter( 'get_user_option_screen_layout_dashboard', function() { return 1; } );

/**
 * Admin Panel Interface Options
 * Disable some default WordPress admin panel interface options for a cleaner interface
 */
function icecreamcake_disable_meta_boxes() {
    // On posts
    //remove_meta_box( 'submitdiv', 'post', 'normal' );         // Publish meta box
    remove_meta_box( 'commentsdiv', 'post', 'normal' );         // Comments meta box
    remove_meta_box( 'revisionsdiv', 'post', 'normal' );        // Revisions meta box
    remove_meta_box( 'authordiv', 'post', 'normal' );           // Author meta box
    //remove_meta_box( 'slugdiv', 'post', 'normal' );           // Slug meta box - Warning: if you enable this you wont be able to change permalinks
    //remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );    // Post tags meta box
    //remove_meta_box( 'categorydiv', 'post', 'side' );         // Category meta box
    //remove_meta_box( 'postexcerpt', 'post', 'normal' );       // Excerpt meta box
    remove_meta_box( 'formatdiv', 'post', 'normal' );           // Post format meta box
    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );       // Trackbacks meta box
    remove_meta_box( 'postcustom', 'post', 'normal' );          // Custom fields meta box
    remove_meta_box( 'commentstatusdiv', 'post', 'normal' );    // Comment status meta box
    remove_meta_box( 'postimagediv', 'post', 'side' );          // Featured image meta box
    //remove_meta_box( 'pageparentdiv', 'page', 'side' );       // Page attributes meta box

    // On pages
    //remove_meta_box( 'submitdiv', 'page', 'normal' );         // Publish meta box
    remove_meta_box( 'commentsdiv', 'page', 'normal' );         // Comments meta box
    remove_meta_box( 'revisionsdiv', 'page', 'normal' );        // Revisions meta box
    remove_meta_box( 'authordiv', 'page', 'normal' );           // Author meta box
    //remove_meta_box( 'slugdiv', 'page', 'normal' );           // Slug meta box - Warning: if you enable this you wont be able to change permalinks
    remove_meta_box( 'postexcerpt', 'page', 'normal' );         // Excerpt meta box
    remove_meta_box( 'trackbacksdiv', 'page', 'normal' );       // Trackbacks meta box
    remove_meta_box( 'postcustom', 'page', 'normal' );          // Custom fields meta box
    remove_meta_box( 'commentstatusdiv', 'page', 'normal' );    // Comment status meta box
}
add_action( 'admin_menu', 'icecreamcake_disable_meta_boxes' );

/**
 * Admin Bar Items
 * Disable default admin bar items that we hardly use
 */
function icecreamcake_disable_default_admin_bar_items() {

    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    //$wp_admin_bar->remove_menu('site-name');      // Remove the site name menu
    //$wp_admin_bar->remove_menu('view-site');      // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    //$wp_admin_bar->remove_menu('new-content');    // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If we use w3 total cache, remove the performance link
    $wp_admin_bar->remove_menu('wpseo-menu');       // If we use Yoast Wordpress SEO, remove the SEO link
    //$wp_admin_bar->remove_menu('my-account');     // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'icecreamcake_disable_default_admin_bar_items' );

/**
 * Replace HOWDY, USER message
 * Replace the default Howdy message in the admin panel to Logged In
 */
function icecreamcake_replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'Logged in as', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
        ) );
}
add_filter( 'admin_bar_menu', 'icecreamcake_replace_howdy', 25 );

/**
 * Add Custom Footer Message to Admin Panel
 */
add_filter( 'admin_footer_text', '__return_false' );

/**
 * Custom Login Page
 * Include custom CSS so the page can be styled
 */
function icecreamcake_login_css() {
    wp_enqueue_style( 'icecreamcake_login_css', get_template_directory_uri() . '/assets/css/min/login.css', false );
}
add_action( 'login_enqueue_scripts', 'icecreamcake_login_css', 10 );

// changing the logo link from wordpress.org to the site URL
function icecreamcake_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'icecreamcake_login_url' );

// changing the alt text on the logo to show the site name
function icecreamcake_login_title() { return get_option('blogname'); }
add_filter( 'login_headertitle', 'icecreamcake_login_title' );

/**
 * Include TypeKit fonts in WP-Admin and TinyMCE editor
 */
function icecreamcake_custom_wp_admin_style() {
    wp_enqueue_script( 'typekit', '//use.typekit.net/' . TYPEKIT_ID . '.js' ); // TypeKit
}
add_action( 'admin_enqueue_scripts', 'icecreamcake_custom_wp_admin_style' );

function icecreamcake_my_custom_admin_head(){
    echo '<style>[for="wp_welcome_panel-hide"] {display: none !important;}</style>';
    if ( wp_script_is( 'typekit', 'done' ) ) {
        ?>
        <script>try{Typekit.load({async:false});}catch(e){}</script>
        <?php
    }
}
add_action('admin_head', 'icecreamcake_my_custom_admin_head');

function icecreamcake_mce_external_plugins($plugins){
    $plugins['typekit']  =  get_template_directory_uri().'/assets/js/min/typekit.tinymce.min.js';
    return $plugins;
}
add_filter("mce_external_plugins", "icecreamcake_mce_external_plugins");
