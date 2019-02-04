<?php

// ----- Body -----

function atlatl_f6_page_body_class( $classes ) {
	$classes[] = 'container-content';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_page_body_class' );

function __atlatl_f6_get_container_class() {
	$class = 'inner grid-container';
	if ('fld' == atlatl_get_setting('container_width') )
		$class .= ' fluid';
	return $class;
}

// ----- Header -----

function atlatl_f6_header_before() {
	echo '<div id="header">';
	echo '<div class="' . __atlatl_f6_get_container_class() . '">';
}

add_action('tha_header_before', 'atlatl_f6_header_before', 50, 0);

add_action('tha_header_after', 'atlatl_f6_end_2_divs', 50, 0);


// ----- Nav -----

function atlatl_f6_nav_before() {
	echo '<div id="nav">';
	echo '<div class="' . __atlatl_f6_get_container_class() . '">';
}

add_action('tha_nav_before', 'atlatl_f6_nav_before', 50, 0);

add_action('tha_nav_after', 'atlatl_f6_end_2_divs', 50, 0);

// function atlatl_f6_nav_class($class) {
// 	if (!empty($class)) $class .= ' ';
// 	$class .= 'grid-padding-x';
// 	return $class;
// }

// add_filter( 'atlatl_nav_class', 'atlatl_f6_nav_class', 1 );

// ----- Container -----

function atlatl_f6_container_before() {
	echo '<div id="content">';
	echo '<div class="' . __atlatl_f6_get_container_class() . '">';
	echo '<div class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_container_before', 'atlatl_f6_container_before', 50, 0);

add_action('tha_container_after', 'atlatl_f6_end_3_divs', 50, 0);

// // ----- Footer -----

function atlatl_f6_footer_before() {
	echo '<div id="footer">';
	echo '<div class="' . __atlatl_f6_get_container_class() . '">';
}

add_action('tha_footer_before', 'atlatl_f6_footer_before', 50, 0);

add_action('tha_footer_after', 'atlatl_f6_end_2_divs', 50, 0);
