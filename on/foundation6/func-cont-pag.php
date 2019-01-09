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

	echo '<div class="wrapper ' . $class . '">';
}

add_action('tha_body_top', 'atlatl_f6_wdth_body_top', 45, 0);

function atlatl_f6_wdth_body_bottom() {
	echo '</div>';
}

add_action('tha_body_bottom', 'atlatl_f6_wdth_body_bottom', 55, 0);


// ----- Header -----

function atlatl_f6_header_before() {
	echo '<div id="header" class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_header_before', 'atlatl_f6_header_before', 40, 0);

function atlatl_f6_header_after() {
	echo '</div>';  // grid
}

add_action('tha_header_after', 'atlatl_f6_header_after', 50, 0);


// ----- Nav -----

function atlatl_f6_nav_before() {
	echo '<div id="nav" class="grid-x grid-padding-x">';
	echo '<div class="cell large-12">';
}

add_action('tha_nav_before', 'atlatl_f6_nav_before', 50, 0);

function atlatl_f6_nav_after() {
	echo '</div>';  // cell
	echo '</div>';  // grid
	echo '<div id="content" class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_nav_after', 'atlatl_f6_nav_after', 50, 0);


// ----- Footer -----

function atlatl_f6_footer_after() {
	echo '</div>';  // cell
	echo '</div>';  // grid
}

add_action('tha_footer_after', 'atlatl_f6_footer_after', 50, 0);

function atlatl_f6_footer_before() {
	echo '</div>';  // grid
	echo '<div id="footer" class="grid-x grid-padding-x grid-padding-y">';
	echo '<div class="cell large-12">';
}

add_action('tha_footer_before', 'atlatl_f6_footer_before', 50, 0);