<?php get_header(); ?>
<div class="container main-content search">
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <div class="articles archive">
                    <h1 class="title">
                        <?php
                        printf(
                            esc_html__( 'Search results for: %s', 'amren' ),
                            esc_html( get_search_query() )
                        );
                        ?>
                    </h1>
                    <div class="articles-container">
                        <?php if ( have_posts() ) : ?>
                            <?php
                            while ( have_posts() ) :
                                the_post();
                                ?>
                                <article class="commentary-features">
                                    <h2 class="title">
                                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="commentary the-date"><?php echo esc_html( get_the_date() ); ?></div>
                                    <div class="excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                                </article>
                                <?php
                            endwhile;

                            if ( function_exists( 'amren_nav' ) ) {
                                amren_nav();
                            }
                            ?>
                        <?php else : ?>
                            <p><?php esc_html_e( 'No results found.', 'amren' ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
