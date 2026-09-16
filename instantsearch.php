<?php
/**
 * WP Search With Algolia instantsearch template file.
 *
 * @author  WebDevStudios <contact@webdevstudios.com>
 * @since   1.0.0
 *
 * @version Custom
 * @package WebDevStudios\WPSWA
 */

get_header();

?>
<div class="wrapper ais-container main-content">
	<div id="ais-wrapper">
		<main id="ais-main" class="content">
			<div class="algolia-search-box-wrapper">
				<div id="algolia-search-box"></div>
				<svg xmlns="http://www.w3.org/2000/svg" class="search-icon icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#003c5e" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
				<div class="open-filters">FILTER RESULTS</div>
				<div id="algolia-stats"></div>
				<div id="algolia-powered-by"></div>
			</div>
			<div id="algolia-hits" class="articles-container articles"></div>
			<div id="algolia-pagination" class="navigation"></div>
		</main>
		<aside id="ais-facets" class="sidebar">
			<svg xmlns="http://www.w3.org/2000/svg" class="close-filters icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#003c5e" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
			<div class="filters-wrapper">
				<div>
					<h3 class="widget-title"><?php esc_html_e( 'Categories', 'wp-search-with-algolia' ); ?></h3>
					<section class="ais-facets" id="facet-categories"></section>
				</div>
				<div>
					<h3 class="widget-title"><?php esc_html_e( 'Tags', 'wp-search-with-algolia' ); ?></h3>
					<section class="ais-facets" id="facet-tags"></section>
				</div>
				<div>
					<h3 class="widget-title"><?php esc_html_e( 'Authors', 'wp-search-with-algolia' ); ?></h3>
					<section class="ais-facets" id="facet-users"></section>
				</div>
			</div>
			<div class="apply-filters">APPLY FILTERS</div>
		</aside>
	</div>

	<script type="text/javascript">
		function htmlDecode(htmlStr) {
			htmlStr = htmlStr.replace(/&lt;/g , "<");
			htmlStr = htmlStr.replace(/&gt;/g , ">");
			htmlStr = htmlStr.replace(/&quot;/g , "\"");
			htmlStr = htmlStr.replace(/&#39;/g , "\'");
			htmlStr = htmlStr.replace(/&amp;/g , "&");
			return htmlStr;
		}
	</script>

	<script type="text/html" id="tmpl-instantsearch-hit">
		<article class="commentary-features" itemtype="http://schema.org/Article">
			<div class="ais-hits--content">
				<div class="title">
					<# const highlightedTitle = htmlDecode( data._highlightResult.post_title.value ); #>
					<h2 class="title" itemprop="name headline"><a href="{{ data.permalink }}" title="{{ data.post_title }}" class="ais-hits--title-link" itemprop="url">{{{ highlightedTitle }}}</a></h2>
					<div class="commentary the-date">{{ data.post_date_formatted }}</div>
				</div>
				<div class="excerpt">
					<p>
						<# if ( data._snippetResult['content'] ) { #>
							<# const highlightedExcerpt = htmlDecode( data._snippetResult['content'].value ); #>
							<span class="suggestion-post-content ais-hits--content-snippet">{{{ highlightedExcerpt }}}</span>
						<# } #>
					</p>
				</div>
				<?php
				do_action( 'algolia_instantsearch_after_hit' );
				?>
			</div>
			<div class="ais-clearfix"></div>
		</article>
	</script>


	<script type="text/javascript">
		window.addEventListener('load', function() {
			if ( document.getElementById("algolia-search-box") ) {
				if ( algolia.indices.searchable_posts === undefined && document.getElementsByClassName("admin-bar").length > 0) {
					alert('It looks like you haven\'t indexed the searchable posts index. Please head to the Indexing page of the Algolia Search plugin and index it.');
				}

				/* Instantiate instantsearch.js */
				var search = instantsearch({
					indexName: algolia.indices.searchable_posts.name,
					searchClient: algoliasearch( algolia.application_id, algolia.search_api_key ),
					routing: {
						router: instantsearch.routers.history({ writeDelay: 1000 }),
						stateMapping: {
							stateToRoute( indexUiState ) {
								return {
									s: indexUiState[ algolia.indices.searchable_posts.name ].query ?? '',
									page: indexUiState[ algolia.indices.searchable_posts.name ].page
								}
							},
							routeToState( routeState ) {
								const indexUiState = {};
								indexUiState[ algolia.indices.searchable_posts.name ] = {
									query: routeState.s,
									page: routeState.page
								};
								return indexUiState;
							}
						}
					}
				});

				search.addWidgets([

					/* Search box widget */
					instantsearch.widgets.searchBox({
						container: '#algolia-search-box',
						placeholder: 'Search for...',
						searchAsYouType: false,
						showReset: false,
						showSubmit: false,
						showLoadingIndicator: false,
					}),

					/* Stats widget */
					instantsearch.widgets.stats({
						container: '#algolia-stats'
					}),

					/* Hits widget */
					instantsearch.widgets.hits({
						container: '#algolia-hits',
						templates: {
							empty: 'No results were found for "<strong>{{query}}</strong>".',
							item: wp.template('instantsearch-hit')
						},
						transformData: {
							item: function (hit) {

								function replace_highlights_recursive (item) {
									if (item instanceof Object && item.hasOwnProperty('value')) {
										item.value = _.escape(item.value);
										item.value = item.value.replace(/__ais-highlight__/g, '<em>').replace(/__\/ais-highlight__/g, '</em>');
									} else {
										for (var key in item) {
											item[key] = replace_highlights_recursive(item[key]);
										}
									}
									return item;
								}

								hit._highlightResult = replace_highlights_recursive(hit._highlightResult);
								hit._snippetResult = replace_highlights_recursive(hit._snippetResult);

								return hit;
							}
						}
					}),

					/* Pagination widget */
					instantsearch.widgets.pagination({
						container: '#algolia-pagination',
						templates: {
							previous: `Previous Page`,
							next: `Next Page`,
						}
					}),

					/* Categories refinement widget */
					instantsearch.widgets.hierarchicalMenu({
						container: '#facet-categories',
						separator: ' > ',
						sortBy: ['count'],
						attributes: ['taxonomies_hierarchical.category.lvl0', 'taxonomies_hierarchical.category.lvl1', 'taxonomies_hierarchical.category.lvl2'],
					}),

					/* Tags refinement widget */
					instantsearch.widgets.refinementList({
						container: '#facet-tags',
						attribute: 'taxonomies.post_tag',
						operator: 'and',
						limit: 15,
						sortBy: ['isRefined:desc', 'count:desc', 'name:asc'],
					}),

					/* Users refinement widget */
					instantsearch.widgets.menu({
						container: '#facet-users',
						attribute: 'post_author.display_name',
						sortBy: ['isRefined:desc', 'count:desc', 'name:asc'],
						limit: 10,
					}),

					/* Search powered-by widget */
					instantsearch.widgets.poweredBy({
						container: '#algolia-powered-by'
					}),

					instantsearch.widgets.configure({
						facetingAfterDistinct: true,
						hitsPerPage: 20,
					}),
				]);

				search.on( 'render', () => {
					const renderState = search.renderState[ algolia.indices.searchable_posts.name ];

					const algoliaFacets = [
						{
							widget: 'hierarchicalMenu',
							args: {
								attribute: 'taxonomies_hierarchical.category.lvl0',
								container: '#facet-categories',
							}
						},
						{
							widget: 'refinementList',
							args: {
								attribute: 'taxonomies.post_tag',
								container: '#facet-tags',
							}
						},
						{
							widget: 'menu',
							args: {
								attribute: 'post_author.display_name',
								container: '#facet-users',
							}
						}
					];

					algoliaFacets.forEach( ( facet ) => {
						if ( 'undefined' !== typeof renderState[ facet.widget ] ) {
							if ( renderState[ facet.widget ][ facet.args.attribute ].items.length === 0 ) {
								jQuery( facet.args.container ).parent().hide();
							} else {
								jQuery( facet.args.container ).parent().show();
							}
						}
					} );
				} );

				jQuery( '.open-filters' ).click( () => {
					jQuery( '#ais-facets' ).addClass( 'open' );
				} );

				jQuery( '.close-filters, .apply-filters' ).click( () => {
					jQuery( '#ais-facets' ).removeClass( 'open' );
				} );

				/* Start */
				search.start();

				// This needs work
				document.querySelector("#algolia-search-box input[type='search']").select()
			}
		});
	</script>
</div>
<?php

get_footer();
