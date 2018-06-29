<?php get_header();

if ( have_posts() ) :

    while ( have_posts() ) : the_post();

        get_template_part( 'partials/content', get_post_format() );

    endwhile;

    icecreamcake_paging_nav();

else :

    get_template_part( 'partials/content', 'none' );

endif;

get_footer();
