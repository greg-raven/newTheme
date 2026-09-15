jQuery( function( $ ) {

	/* HOME SCRIPTS */

	// Slideshow on Home //

	$( ".home .features" ).owlCarousel( {
		autoplay: true,
		autoplayHoverPause: true,
		autoplayTimeout: 9000,
		dots: true,
		items: 1,
		loop: true,
		margin: 0,
		nav: false,
		smartSpeed: 1000
	} );

	// Article Selector on the Homepage //

	$( '.home .article-selector a' ).on( 'click', function( e ) {
		e.preventDefault();
		var location = $( this ).attr( 'href' );
		$( '.article-selector a' ).removeClass( 'selected' );
		$( this ).addClass( 'selected' );
		$( '.articles' ).empty();
		$( '<div class="loading"><div class="lds-css ng-scope"><div class="lds-gear" style="width:100%;height:100%"><div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>' ).appendTo( '.articles' );
		$.ajax( {
			url: location,
			type: 'GET',
			success: function( data ) {
				// Get Desired Data //
				$( '.articles' ).html( $( data ).find( '.articles-container' ).html() );
				// Discard Unneeded Data //
				$( '.articles .navigation' ).remove();
				// Append Load More Element //
				var home_selected_article_category     = $( '.home .article-selector a.selected' ).html();
				var home_selected_article_category_url = $( '.home .article-selector a.selected' ).attr( 'href' );
//				if(home_selected_article_category !== "Blog"){
				$( '<div class="load-more"><a href="">More <span></span></a></div>' ).appendTo( '.articles' );
				// Update "More" Link at the bottom of the articles //
				$( '.articles .load-more span' ).append( home_selected_article_category );
				$( '.articles .load-more a' ).attr( 'href', home_selected_article_category_url + 'page/2/' );
//				}
			}
		} );
	} );
	var home_selected_article_category     = $( '.home .article-selector a.selected' ).html();
	var home_selected_article_category_url = $( '.home .article-selector a.selected' ).attr( 'href' );
	$( '.articles .load-more span' ).append( home_selected_article_category );
	$( '.articles .load-more a' ).attr( 'href', home_selected_article_category_url + 'page/2/' );

	/* Responsive Menu */

	var effect   = 'slide';
	var options  = 'left';
	var duration = 250;
	$( '.responsive-menu-icon' ).click( function() {
		$( '.responsive-menu' ).toggle( effect, options, duration );
	} );
	$( '.responsive-menu .menu-item-has-children' ).click( function() {
		$( this ).find( 'ul' ).slideToggle( 250 );
	} );

} );

function init() {
	var vidDefer = document.getElementsByTagName( 'iframe' );
	for ( var i = 0; i < vidDefer.length; i ++ ) {
		if ( vidDefer[ i ].getAttribute( 'data-src' ) ) {
			vidDefer[ i ].setAttribute( 'src', vidDefer[ i ].getAttribute( 'data-src' ) );
		}
	}
}

window.onload = init;

jQuery( function( $ ) {
	if ( window.outerWidth < 990 ) {
		var $allVideos = $( 'iframe[src^=\'http://\'], iframe[src^=\'https://\'], iframe[src^=\'//\'], iframe[data-src^=\'http://\'], iframe[data-src^=\'https://\'], iframe[data-src^=\'//\']' ),
			$fluidEl   = $( '.the-content' );

		$allVideos.each( function() {

			$( this )
			// jQuery .data does not work on object/embed elements
				.attr( 'data-aspectRatio', this.height / this.width )
				.removeAttr( 'height' )
				.removeAttr( 'width' );

		} );

		$( window ).resize( function() {

			var newWidth = $fluidEl.width();
			$allVideos.each( function() {

				var $el = $( this );
				$el
					.width( newWidth )
					.height( newWidth * $el.attr( 'data-aspectRatio' ) );

			} );

		} ).resize();

	}

} );
