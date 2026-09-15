<?php get_header(); ?>
<div class="container main-content">
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();

                        $source_url    = function_exists( 'amren_field' ) ? amren_field( 'source_url' ) : ( function_exists( 'get_field' ) ? get_field( 'source_url' ) : '' );
                        $article_source = function_exists( 'amren_field' ) ? amren_field( 'article_source' ) : ( function_exists( 'get_field' ) ? get_field( 'article_source' ) : '' );
                        ?>
                        <article <?php post_class(); ?>>
                            <div class="date">Posted on <?php echo esc_html( get_the_date() ); ?></div>
                            <h1>
                                <?php if ( in_category( 'news' ) && $source_url ) : ?>
                                    <a target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( $source_url ); ?>"><?php the_title(); ?></a>
                                <?php else : ?>
                                    <?php the_title(); ?>
                                <?php endif; ?>
                            </h1>
                            <?php if ( $article_source ) : ?>
                                <p class="source"><?php echo wp_kses_post( $article_source ); ?></p>
                            <?php endif; ?>
                            <div class="the-content">
                                <?php if ( in_category( array( 'videos', 'features' ) ) && has_post_thumbnail() ) : ?>
                                    <div class="image"><?php the_post_thumbnail( 'full' ); ?></div>
                                <?php endif; ?>
                                <?php
                                if ( in_category( 'videos' ) ) {
                                    the_excerpt();
                                }
                                the_content();
                                ?>
                            </div>
                        </article>
                        <?php
                    endwhile;
                endif;

                if ( ! empty( $source_url ) ) :
                    ?>
                    <div class="original">
                        <p class="sourceLink"><a href="<?php echo esc_url( $source_url ); ?>">Original Article</a></p>
                    </div>
                <?php endif; ?>

                <div class="topics share">
                    <div class="tags"><?php the_tags( 'Topics: ', ', ', '<br />' ); ?></div>
                    <div class="share">
                        <?php
                        if ( function_exists( 'amren_field' ) ) {
                            echo wp_kses_post( amren_field( 'post_share', 'options' ) );
                        } elseif ( function_exists( 'the_field' ) ) {
                            the_field( 'post_share', 'options' );
                        }
                        ?>
                    </div>
                </div>

                <?php
                $author = get_the_author();
                if ( 'Henry Wolff' !== $author ) :
                    ?>
                    <div class="post-author">
                        <div class="profile-header">
                            <h3><?php echo esc_html( sprintf( __( 'About %s', 'amren' ), $author ) ); ?></h3>
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                <?php echo esc_html( sprintf( __( 'View all posts by %s', 'amren' ), $author ) ); ?>
                            </a>
                            <div class="fix"></div>
                        </div>
                        <div class="profile-content">
                            <div class="profile-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?></div>
                            <?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?>
                        </div>
                        <div class="fix"></div>
                    </div>
                <?php endif; ?>

                <div class="ad">
                    <?php
                    if ( function_exists( 'the_field' ) ) {
                        the_field( 'post_ad_code', 'options' );
                    }
                    ?>
                </div>

                <div class="post-entries">
                    <div class="nav-prev fl">
                        <?php previous_post_link( '%link', '&lt; %title' ); ?>
                    </div>
                    <div class="nav-next fr">
                        <?php next_post_link( '%link', '%title &gt;' ); ?>
                    </div>
                </div>

                <script async src="https://talk.hyvor.com/embed/embed.js" type="module"></script>
                <hyvor-talk-comments website-id="6591" page-id=""></hyvor-talk-comments>
            </div>
            <div class="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
