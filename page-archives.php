<?php /*
Template Name: Archives Page
*/
get_header(); ?>
<div class="container main-content archives-page">
	<div class="wrapper">
		<div class="container">
			<div class="content">
				<div class="articles archive">
					<h1 class="title">Archives</h1>
				</div>
				<div class="tag-cloud">
					<h2 class="h3">Tag Archives:</h2>
					<?php
					if ( function_exists( 'wp_tag_cloud' ) ):
						$args = [
							'smallest'  => 8,
							'largest'   => 22,
							'number'    => 120,
							'separator' => ",\n",
						];
						wp_tag_cloud( $args );
					endif;
					?>
				</div>
				<div class="monthly-archives">
					<h2 class="h3">Monthly Archives:</h2>
					<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value=""><?php echo esc_attr( __( 'Select a Month' ) ); ?></option>
						<?php wp_get_archives( 'type=monthly&format=option' ); ?>
					</select>
				</div>
				<div class="author-archives">
					<h2 class="h3">Author Archives:</h2>
					<ul>
						<?php wp_list_authors( 'show_fullname=1&optioncount=1' ); ?>
					</ul>
				</div>
			</div>
			<div class="sidebar"><?php dynamic_sidebar( 'Sidebar' ); ?></div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
