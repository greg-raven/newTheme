<?php get_header(); ?>

<div class="container main-content">
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article <?php post_class(); ?>>
                            <h1><?php the_title(); ?></h1>
                            <div class="the-content">
                                <?php the_content(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
