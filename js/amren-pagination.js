$( '.archive .navigation a' ).on( 'click', function( e ) {
	e.preventDefault();
	var location = $( this ).attr( 'href' );
	/*$('.archive .navigation li').removeClass('active');
	$(this).parent().addClass('active');*/
	$( '.articles-container' ).empty();
	$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
	$( '<div class="loading"><div class="lds-css ng-scope"><div class="lds-gear" style="width:100%;height:100%"><div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>' ).appendTo( '.articles-container' );
	$.ajax( {
		url: location,
		type: 'GET',
		success: function( data ) {
			// Get desired data //
			$( '.articles-container' ).html( $( data ).find( '.articles-container' ).html() );
			// Reload the pagination script //
			$.getScript( '/wp-content/themes/amren/js/amren-pagination.js' );
			// Update window URL //
			window.history.pushState( 'object or string', 'Title', location );
		}
	} );
} );
