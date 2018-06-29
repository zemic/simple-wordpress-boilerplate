<article>
    <header>
        <?php the_title( sprintf( '<h1><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
        <?php if ( 'post' == get_post_type() ) : ?>
            <div>
                <?php icecreamcake_posted_on(); ?>
            </div>
        <?php endif; ?>
        <?php if ( has_post_thumbnail() ) : ?>
            <div>
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        <?php endif; ?>
    </header>
    <section>
        <?php the_excerpt(); ?>
        <button><a href="<?php the_permalink(); ?>">Continue Reading</a></button>
    </section>
</article>
