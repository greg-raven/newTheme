<?php /*
Template Name: Search Page
*/
get_header(); ?>
<div class="container main-content search">
	<div class="wrapper">
		<div class="container">
			<div class="content">
				<div class="articles archive">
					<h1 class="title">Search</h1>
				</div>
			</div>
			<div class="sidebar"><?php dynamic_sidebar( 'Sidebar' ); ?></div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
