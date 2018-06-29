<?php
/**
 * The template for displaying archive pages.
 */
get_header();

if ( have_posts() ) :

    // Useful archive page titles
    if ( is_category() ) :
        single_cat_title();
    elseif ( is_tag() ) :
        single_tag_title();
    elseif ( is_author() ) :
        printf( __( 'Author: %s', 'icecreamcake' ), '<span class="vcard">' . get_the_author() . '</span>' );
    elseif ( is_day() ) :
        printf( __( 'Day: %s', 'icecreamcake' ), '<span>' . get_the_date() . '</span>' );
    elseif ( is_month() ) :
        printf( __( 'Month: %s', 'icecreamcake' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'icecreamcake' ) ) . '</span>' );
    elseif ( is_year() ) :
        printf( __( 'Year: %s', 'icecreamcake' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'icecreamcake' ) ) . '</span>' );
    elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
        _e( 'Asides', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
        _e( 'Galleries', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
        _e( 'Images', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
        _e( 'Videos', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
        _e( 'Quotes', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
        _e( 'Links', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
        _e( 'Statuses', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
        _e( 'Audios', 'icecreamcake' );
    elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
        _e( 'Chats', 'icecreamcake' );
    else :
        _e( 'Archives', 'icecreamcake' );
    endif;

    // Show an optional term description.
    $term_description = term_description();
    if ( ! empty( $term_description ) ) :
        printf( '<div class="taxonomy-description">%s</div>', $term_description );
    endif;

    while ( have_posts() ) : the_post();
        get_template_part( 'partials/content', get_post_format() );
    endwhile;

    icecreamcake_paging_nav();

else :
    get_template_part( 'partials/content', 'none' );
endif;

get_footer();
