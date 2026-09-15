<?php get_header(); ?>
	<div class="container main-content">
		<div class="wrapper">
			<div class="container">
				<div class="content">
					<div class="articles archive">
						<?php
						$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						// echo $url;
						$urlParts     = explode( '/', str_ireplace( [ 'http://', 'https://' ], '', $url ) );
						$first_folder = $urlParts[1];
						// echo $first_folder;
						if ( $first_folder == 'author' ) {
							$third_folder = isset( $urlParts[3] ) ? $urlParts[3] : '';
							// echo $third_folder;
							if ( $third_folder == 'page' ) {
								$fourth_folder = $urlParts[4];
								// echo $fourth_folder;
								$current_page = '<span> | Page ' . $fourth_folder . '</span>';
								// echo $current_page;
							}
						}

						// Main Code //
						echo '<h1 class="title"><span>Archive | </span>' . get_the_author() . ( $third_folder == 'page' ? $current_page : '' ) . '</h1>';
						echo '<div class="articles-container">';
						$date       = '';
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							if ( $date != get_the_date() ) {
								$date = get_the_date();
								echo '<div class="date">' . $date . '</div>';
							}
							$source_name_font          = str_replace( '<font color="red">', '<span class="red">', get_field( 'source_name' ) );
							$source_name_font_adjusted = str_replace( '</font>', '</span>', $source_name_font );
							echo '<article>
							<h2 class="title">
								<a href="' . get_permalink() . '">' . get_the_title() . '</a>
								<small>' . $source_name_font_adjusted . '</small>
							</h2>'; ?>
							<?php echo '<div class="excerpt">' . get_the_excerpt() . '</div>
						</article>';
						endwhile; endif;
						wp_reset_postdata();
						wp_reset_query();
						amren_nav();
						echo '</div>';
						?>
					</div>
				</div>
				<div class="sidebar"><?php dynamic_sidebar( 'Sidebar' ); ?></div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
