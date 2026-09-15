<?php

add_shortcode( 'toggle', function ( $atts, $content = null ) {
	if ( ! defined( 'WOO_SHORTCODE_JS' ) ) {
		define( 'WOO_SHORTCODE_JS', 'load' );
	}

	$atts = wp_parse_args( $atts, [
		'title_open'           => __( 'Hide the Content', 'woothemes' ),
		'title_closed'         => __( 'Show the Content', 'woothemes' ),
		'hide'                 => 'yes',
		'display_main_trigger' => 'yes',
		'style'                => 'default',
		'border'               => 'yes',
		'excerpt_length'       => '0',
		'include_excerpt_html' => 'no',
		'read_more_text'       => __( 'Read More', 'woothemes' ),
		'read_less_text'       => __( 'Read Less', 'woothemes' ),
	] );

	$class        = '';
	$class_open   = ' toggle-' . sanitize_title( $atts['title_open'] );
	$class_closed = ' toggle-' . sanitize_title( $atts['title_closed'] );

	if ( $atts['hide'] === 'yes' ) {
		$class .= $class_closed . ' closed';
		$title = $atts['title_closed'];
	} else {
		$class .= $class_open . ' open';
		$title = $atts['title_open'];
	}

	$main_trigger = '';

	if ( $atts['display_main_trigger'] == 'yes' ) {
		$main_trigger = '<h4 class="toggle-trigger"><a href="#">' . $title . '</a></h4>' . "\n";
	}

	// Add the alternate style to the CSS class.
	$class .= ' ' . $atts['style'];

	// Add the border class, if necessary.
	if ( $atts['border'] === 'yes' ) {
		$class .= ' border';
	}

	// If the excerpt length is greater than 0, apply the excerpt logic.
	$excerpt_length = intval( $atts['excerpt_length'] );

	if ( $excerpt_length > 0 ) {

		if ( $atts['include_excerpt_html'] === 'no' ) {
			$content = strip_tags( $content );
		}

		$excerpt = substr( $content, 0, $excerpt_length );

		$more_link = '<a href="#read-more" class="more-link read-more" readless="' . esc_attr( $atts['read_less_text'] ) . '">' . $atts['read_more_text'] . '</a>';

		$content = '<span class="excerpt">' . $excerpt . '</span><!--/.excerpt-->' . "\n" . $more_link . "\n" . '<span class="more-text closed">' . substr( $content, $excerpt_length, strlen( $content ) ) . '</span><!--/.more-text-->' . "\n";
	}

	return '<div class="shortcode-toggle' . esc_attr( $class ) . '">' . $main_trigger . '<div class="toggle-content">' . do_shortcode( $content ) . '</div><!--/.toggle-content-->' . "\n" . '<input type="hidden" name="title_open" value="' . esc_attr( $atts['title_open'] ) . '" /><input type="hidden" name="title_closed" value="' . esc_attr( $atts['title_closed'] ) . '" />' . '</div><!--/.shortcode-toggle-->';

} );

