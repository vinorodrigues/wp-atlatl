<?php

// ----- Body -----

function atlatl_f6_page_body_class( $classes ) {
	$classes[] = 'container-content';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_page_body_class' );

// ----- Header -----

function atlatl_f6_header_before() {
	echo '<div id="header" class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_header_before', 'atlatl_f6_header_before', 50, 0);

add_action('tha_header_after', 'atlatl_f6_end_1_div', 50, 0);


// ----- Nav -----

function atlatl_f6_nav_before() {
	echo '<div id="nav" class="grid-x grid-padding-x">';
	echo '<div class="cell large-12">';
}

add_action('tha_nav_before', 'atlatl_f6_nav_before', 50, 0);

add_action('tha_nav_after', 'atlatl_f6_end_2_divs', 50, 0);

// ----- Container -----

function atlatl_f6_container_before() {
	switch ( atlatl_get_setting('container_width') ) {
		case 'fld':
			$class = 'grid-container fluid';
			break;
		default:
			$class = 'grid-container';
			break;
	}
	echo '<div id="content" class="' . $class . '">';
	echo '<div class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_container_before', 'atlatl_f6_container_before', 50, 0);

add_action('tha_container_after', 'atlatl_f6_end_2_divs', 50, 0);

// ----- Footer -----

function atlatl_f6_footer_top() {
	echo '<div id="footer" class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_footer_top', 'atlatl_f6_footer_top', 50, 0);

add_action('tha_footer_bottom,', 'atlatl_f6_end_1_div', 50, 0);
