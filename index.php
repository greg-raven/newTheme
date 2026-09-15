<?php get_header(); ?>
<div class="container main-content">
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <div class="features owl-carousel owl-theme">
                    <?php
                    $features = function_exists( 'amren_get_home_features' )
                        ? amren_get_home_features()
                        : new WP_Query(
                            array(
                                'post_type'           => 'post',
                                'post_status'         => 'publish',
                                'category_name'       => 'features',
                                'posts_per_page'      => 6,
                                'no_found_rows'       => true,
                                'ignore_sticky_posts' => true,
                            )
                        );

                    if ( $features->have_posts() ) :
                        while ( $features->have_posts() ) :
                            $features->the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="image">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'full', array( 'class' => 'no-ll' ) ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="teaser">
                                    <div class="teaser-inner">
                                        <div class="date"><?php echo esc_html( get_the_date() ); ?></div>
                                        <h1 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h1>
                                        <div class="author">By <?php the_author(); ?></div>
                                    </div>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <div class="article-selector">
                    <?php
                    $filter_cats = array(
                        'news'       => '<a class="selected" href="' . esc_url( home_url( '/category/news/' ) ) . '">News</a>',
                        'blog'       => '<a href="' . esc_url( home_url( '/category/blog/' ) ) . '">Blog</a>',
                        'commentary' => '<a href="' . esc_url( home_url( '/category/commentary/' ) ) . '">Commentary</a>',
                        'features'   => '<a href="' . esc_url( home_url( '/category/features/' ) ) . '">Features</a>',
                        'videos'     => '<a href="' . esc_url( home_url( '/category/videos/' ) ) . '">Videos</a>',
                        'podcasts'   => '<a href="' . esc_url( home_url( '/category/podcasts/' ) ) . '">Podcasts</a>',
                    );

                    $filter_categories = function_exists( 'get_field' ) ? get_field( 'home_filter_categories', 'option' ) : array();

                    if ( is_array( $filter_categories ) ) {
                        foreach ( $filter_categories as $category ) {
                            if ( isset( $filter_cats[ $category ] ) ) {
                                echo $filter_cats[ $category ];
                            }
                        }
                    }
                    ?>
                </div>

                <div class="articles">
                    <?php
                    $date = '';

                    if ( have_posts() ) :
                        while ( have_posts() ) :
                            the_post();

                            if ( $date !== get_the_date() ) {
                                $date = get_the_date();
                                echo '<div class="date">' . esc_html( $date ) . '</div>';
                            }

                            $source_name = function_exists( 'amren_field' ) ? amren_field( 'source_name' ) : ( function_exists( 'get_field' ) ? get_field( 'source_name' ) : '' );
                            $source_name = str_replace(
                                array( '<font color="red">', '</font>' ),
                                array( '<span class="red">', '</span>' ),
                                (string) $source_name
                            );
                            ?>
                            <article>
                                <h2 class="title">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                                    <small><?php echo wp_kses_post( $source_name ); ?></small>
                                </h2>
                                <div class="excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                            </article>
                            <?php
                        endwhile;
                    endif;
                    ?>
                    <div class="load-more hide-mobile"><a href="">More <span></span></a></div>
                    <div class="dt-load-more show-mobile"><a href="<?php echo esc_url( home_url( '/category/news/' ) ); ?>">More news</a></div>
                </div>
            </div>
            <div class="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
