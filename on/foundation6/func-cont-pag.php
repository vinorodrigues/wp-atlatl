<?php

// ----- Body -----

function atlatl_f6_page_body_class( $classes ) {
	$classes[] = 'container-page';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_page_body_class' );

function atlatl_f6_wdth_body_top() {
	switch ( atlatl_get_setting('container_width') ) {
		case 'fld':
			$class = 'grid-container fluid';
			break;
		default:
			$class = 'grid-container';
			break;
	}

	echo '<div id="wrapper" class="' . $class . '">';
}

add_action('tha_body_top', 'atlatl_f6_wdth_body_top', 45, 0);

add_action('tha_body_bottom', 'atlatl_f6_end_1_div', 55, 0);


// ----- Header -----

// function atlatl_f6_header_before() {
// 	echo '<div id="header" class="grid-x grid-padding-x grid-padding-y">';
// }

// add_action('tha_header_before', 'atlatl_f6_header_before', 40, 0);

// add_action('tha_header_after', 'atlatl_f6_end_1_div', 50, 0);

function atlatl_f6_inner_div_class( $class ) {
	return (empty($class) ? '' : $class . ' ') . 'inner';
}

add_action( 'atlatl_header_class', 'atlatl_f6_inner_div_class' );
add_action( 'atlatl_nav_class', 'atlatl_f6_inner_div_class' );
add_action( 'atlatl_content_class', 'atlatl_f6_inner_div_class' );
add_action( 'atlatl_footer_class', 'atlatl_f6_inner_div_class' );

// ----- Nav -----

// function atlatl_f6_nav_before() {
// 	echo '<div id="nav" class="grid-x grid-padding-x">';
// 	echo '<div class="cell large-12">';
// }

// add_action('tha_nav_before', 'atlatl_f6_nav_before', 50, 0);

// add_action('tha_nav_after', 'atlatl_f6_end_2_divs', 50, 0);

// ----- Main -----

function atlatl_f6_container_before() {
	echo '<div id="content" class="' . apply_filters( 'atlatl_content_class', 'grid-x grid-padding-x grid-padding-y' ) . '">';
}

add_action('tha_container_before', 'atlatl_f6_container_before', 50, 0);

add_action('tha_container_after', 'atlatl_f6_end_1_div', 50, 0);

