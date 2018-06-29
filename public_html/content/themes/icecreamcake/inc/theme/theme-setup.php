<?php
/**
 * Ice Cream Cake Setup - basic functions and definitions
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 */
if ( ! function_exists( 'icecreamcake_setup' ) ) :

    function icecreamcake_setup() {

        /**
         * Make Ice Cream Cake available for translation.
         */
        load_theme_textdomain( 'icecreamcake', get_template_directory() . '/languages' );

        /**
         * This styles the visual editor to resemble the theme style.
         */
        add_editor_style( array( 'assets/css/styles.css' ) );

        /**
         * Add RSS feed links to <head> for posts and comments.
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Switch default core markup for search form, comment form, and comments to output valid HTML5.
         */
        add_theme_support( 'html5', [
            'caption',
            'comment-list',
            'comment-form',
            'gallery',
            'search-form',
        ]);

        /**
         * Enable support for Post Formats
         *
         * @link http://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', [
            'aside',
            'audio',
            'chat',
            'gallery',
            'image',
            'link',
            'quote',
            'status',
            'video',
        ]);

        /**
         * Clean up WordPress head
         */
        remove_action( 'wp_head', 'feed_links', 2 );                                // Post and comment feeds
        remove_action( 'wp_head', 'feed_links_extra', 3 );                          // Category feeds
        remove_action( 'wp_head', 'rsd_link' );                                     // EditURI link
        remove_action( 'wp_head', 'wlwmanifest_link' );                             // Windows Live writer
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );       // Links for adjacent posts
        remove_action( 'wp_head', 'wp_generator' );                                 // Remove WP version
        remove_action( 'wp_head', 'rel_canonical');                                 // Remove WP Canonical Link

        /**
         * Remove Yoast WP SEO Canonical Link
         */
        if( ! has_filter( 'wpseo_canonical' ) ) {
            add_filter( 'wpseo_canonical', '__return_false' );
        }

        /**
         * Remove WordPress generator version from RSS
         */
        add_filter( 'the_generator', '__return_false' );

        /**
         * Remove version number from CSS and script files
         */
        if ( ! function_exists( 'remove_wp_ver_in_css_js' ) ) :
            function remove_wp_ver_in_css_js( $src ) {
                if ( strpos( $src, 'ver=' ) )
                    $src = remove_query_arg( 'ver', $src );
                return $src;
            }
            add_filter( 'style_loader_src', 'remove_wp_ver_in_css_js', 9999 );      // Remove WP version from CSS
            add_filter( 'script_loader_src', 'remove_wp_ver_in_css_js', 9999 );     // Remove WP version from scripts
        endif;

        /**
         * Removes text/css from stylesheet <links> tag
         */
        add_filter( 'style_loader_tag', function( $src ) { return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $src); } );

        /**
         * Remove injected CSS recent comments widget styles
         */
        if ( ! function_exists( 'remove_wp_widget_recent_comments_style' ) ) :
            function remove_wp_widget_recent_comments_style() {
               if ( ! has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
                  remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
               }
            }
            add_filter( 'wp_head', 'remove_wp_widget_recent_comments_style', 1 );
        endif;

        /**
         * Remove injected CSS comment styles
         */
        if ( ! function_exists( 'remove_recent_comments_style' ) ) :
            function remove_recent_comments_style() {
                global $wp_widget_factory;
                if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
                    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
                }
            }
            add_action( 'wp_head', 'remove_recent_comments_style', 1 );
        endif;

        /**
         * Remove injected CSS for gallery styles
         */
        if ( ! function_exists( 'remove_gallery_style' ) ) :
            function remove_gallery_style( $css ) {
              return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
            }
            add_filter( 'gallery_style', 'remove_gallery_style' );
        endif;

        /**
         * Remove WordPress default gallery styles
         */
        add_filter( 'use_default_gallery_style', '__return_false' );

        /**
         * Remove the P tag from around images
         *
         * @link http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
         */
        if ( ! function_exists( 'filter_ptags_on_images' ) ) :
            function filter_ptags_on_images( $content ){
                return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
            }
            add_filter( 'the_content', 'filter_ptags_on_images' );
        endif;

        /**
         * Clean the excerpt - replaces the annoying […] with a Read More link
         */
        if ( ! function_exists( 'clean_excerpt_more' ) ) :
            function clean_excerpt_more($more) {
                global $post;
                return '...  <a href="' . get_permalink( $post->ID ) . '" title="Read ' . get_the_title( $post->ID ). '">Read more &raquo;</a>';
            }
            add_filter( 'excerpt_more', 'clean_excerpt_more' );
        endif;

        /**
         * Allow SVG Uploads
         *
         * @link https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
         */
        function cc_mime_types($mimes) {
          $mimes['svg'] = 'image/svg+xml';
          return $mimes;
        }
        add_filter('upload_mimes', 'cc_mime_types');

        /**
         * Responsive Video Container.
         *
         * @link http://diywpblog.com/embed-responsive-videos-with-wordpress/
         */
         function wrap_embed_with_div($html, $url, $attr) {
                 return "<article class=\"responsive-video\"><div class=\"responsive-video__wrapper\">".$html."</div></article>";
         }
        add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);

        /**
         * Disable the emoji's
         */
        function disable_emojis_tinymce( $plugins ) {
            if ( is_array( $plugins ) ) {
                return array_diff( $plugins, array( 'wpemoji' ) );
            }
            return array();
        }

        function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
            if ( 'dns-prefetch' == $relation_type ) {
                $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
                $urls = array_diff( $urls, array( $emoji_svg_url ) );
            }
            return $urls;
        }

        function disable_emojis() {
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
            add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
            add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
        }
        add_action( 'init', 'disable_emojis' );

    }
endif; // icecreamcake_setup
add_action( 'after_setup_theme', 'icecreamcake_setup' );
