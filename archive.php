<?php get_header(); ?>
<div class="container main-content">
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <div class="articles archive">
					<?php
					$heading = single_term_title( '', false );
					if ( ! $heading ) {
						$heading = wp_strip_all_tags( get_the_archive_title() );
					}
					if ( is_paged() ) {
						$heading .= ' | Page ' . (int) get_query_var( 'paged' );
					}
					?>
					<h1 class="title"><span>Archive | </span><?php echo esc_html( $heading ); ?></h1>                    <div class="articles-container">
                        <?php
                        $date = '';

                        if ( have_posts() ) :
                            while ( have_posts() ) :
                                the_post();

                                $source_name = function_exists( 'amren_field' ) ? amren_field( 'source_name' ) : ( function_exists( 'get_field' ) ? get_field( 'source_name' ) : '' );
                                $source_name = str_replace(
                                    array( '<font color="red">', '</font>' ),
                                    array( '<span class="red">', '</span>' ),
                                    (string) $source_name
                                );

                                if ( is_category( array( 'news', 1 ) ) ) :
                                    if ( $date !== get_the_date() ) {
                                        $date = get_the_date();
                                        echo '<div class="date">' . esc_html( $date ) . '</div>';
                                    }
                                    ?>
                                    <article>
                                        <h2 class="title">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                                            <small><?php echo wp_kses_post( $source_name ); ?></small>
                                        </h2>
                                        <div class="excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                                    </article>
                                    <?php
                                elseif ( is_category( array( 'commentary', 'features', 86, 90 ) ) ) :
                                    ?>
                                    <article class="commentary-features">
                                        <h2 class="title">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="commentary the-date"><?php echo esc_html( get_the_date() ); ?></div>
                                        <div class="excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                                        <div class="commentary author">
                                            By <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
                                        </div>
                                    </article>
                                    <?php
                                else :
                                    ?>
                                    <article class="commentary-features">
                                        <h2 class="title">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="commentary the-date"><?php echo esc_html( get_the_date() ); ?></div>
                                        <div class="excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                                    </article>
                                    <?php
                                endif;
                            endwhile;
                        endif;

                        if ( function_exists( 'amren_nav' ) ) {
                            amren_nav();
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
