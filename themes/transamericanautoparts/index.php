<?php get_header(); ?>

    <main class="container <?=prefix()?>-content">
        <div class="group">
            <div class="c c-12">
	            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
	            <?php endwhile; else : ?>
                    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
	            <?php endif; ?>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
