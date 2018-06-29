<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 */

/**
 * Format Text
 *
 * Format passed variable like the_content() function
 */
function format_wp_description( $content ) {
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function icecreamcake_wp_title( $title, $sep ) {
    if ( is_feed() ) {
        return $title;
    }

    global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo( 'name', 'display' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title .= " $sep " . sprintf( __( 'Page %s', 'icecreamcake' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'icecreamcake_wp_title', 10, 2 );

/**
 * Display navigation to next/previous set of posts when applicable.
 */
if ( ! function_exists( 'icecreamcake_paging_nav' ) ) :

    function icecreamcake_paging_nav() {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }
        ?>
        <nav class="navigation paging-navigation" role="navigation">
            <div class="nav-links">

                <?php if ( get_next_posts_link() ) : ?>
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'icecreamcake' ) ); ?></div>
                <?php endif; ?>

                <?php if ( get_previous_posts_link() ) : ?>
                <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'icecreamcake' ) ); ?></div>
                <?php endif; ?>

            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }

endif;

/**
 * Display navigation to next/previous post when applicable.
 */
if ( ! function_exists( 'icecreamcake_post_nav' ) ) :

    function icecreamcake_post_nav() {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) {
            return;
        }
        ?>
        <nav class="navigation post-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'icecreamcake' ); ?></h1>
            <div class="nav-links">
                <?php
                    previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'icecreamcake' ) );
                    next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'icecreamcake' ) );
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }

endif;

if ( ! function_exists( 'icecreamcake_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function icecreamcake_posted_on() {
    $time_string = '<time datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        _x( '%s', 'post date', 'icecreamcake' ),
        $time_string
    );

    $byline = sprintf(
        _x( 'by %s', 'post author', 'icecreamcake' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo $posted_on; //, '<span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'icecreamcake_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function icecreamcake_entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' == get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( __( ', ', 'icecreamcake' ) );
        if ( $categories_list && icecreamcake_categorized_blog() ) {
            printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'icecreamcake' ) . '</span>', $categories_list );
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', __( ', ', 'icecreamcake' ) );
        if ( $tags_list ) {
            printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'icecreamcake' ) . '</span>', $tags_list );
        }
    }

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link( __( 'Leave a comment', 'icecreamcake' ), __( '1 Comment', 'icecreamcake' ), __( '% Comments', 'icecreamcake' ) );
        echo '</span>';
    }

    edit_post_link( __( 'Edit', 'icecreamcake' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function icecreamcake_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'icecreamcake_categories' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,

            // We only need to know if there is more than one category.
            'number'     => 2,
        ) );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'icecreamcake_categories', $all_the_cool_cats );
    }

    if ( $all_the_cool_cats > 1 ) {
        // This blog has more than 1 category so icecreamcake_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so icecreamcake_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in icecreamcake_categorized_blog.
 */
function icecreamcake_category_transient_flusher() {
    // Like, beat it. Dig?
    delete_transient( 'icecreamcake_categories' );
}
add_action( 'edit_category', 'icecreamcake_category_transient_flusher' );
add_action( 'save_post',     'icecreamcake_category_transient_flusher' );

function modify_read_more_link($linkText) {
    return '<button class="button button--withicon-right button--red" href="' . get_permalink() . '">' . $linkText . '<span class="button__icon material-icons">&#xE315;</span></button>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link', 10, 1 );
