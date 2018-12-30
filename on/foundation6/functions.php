<?php

if ( !defined('FOUNDATION_VERSION') )
	define('FOUNDATION_VERSION', '6.5.1');

/**
 * Before <html>
 */
function atlatl_f64_html_before() {
	echo '<!doctype html>' . PHP_EOL;
}
add_action('tha_html_before', 'atlatl_f64_html_before', 50, 0);

/**
 * Top of <head>
 */
function atlatl_f64_head_top() {
	echo '<meta http-equiv="x-ua-compatible" content="ie=edge" />'.PHP_EOL;
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />'.PHP_EOL;
}
add_action('tha_head_top', 'atlatl_f64_head_top', 50, 0);

/**
 * Top of <body>
 */
function atlatl_f64_body_top() {
	echo '<div class="wrapper">';
}
add_action('tha_body_top', 'atlatl_f64_body_top', 50, 0);

/**
 * Bottom of <body>
 */
function atlatl_f64_body_bottom() {
	echo '</div>';
}
add_action('tha_body_bottom', 'atlatl_f64_body_bottom', 50, 0);

function atlatl_f64_scripts() {
	$th_ver = wp_get_theme()->version;

	// CSS

	$url = '';
	if (empty($url)) {
		$ver = FOUNDATION_VERSION;
		$url = get_theme_file_uri( '/on/foundation6/css/foundation' . DOTMIN . '.css' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_style( 'foundation', $url, array(), $ver );

	// JavaScript

	// jQuery
	$url = '';  // $url = trim( bs4_get_option('jquery_js') );
	if (empty($url)) {
		$ver = FOUNDATION_VERSION;
		$url = get_theme_file_uri( '/on/foundation6/js/foundation' . DOTMIN . '.js' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_script( 'foundation', $url, array('jquery'), $ver, true );

}
add_action('wp_enqueue_scripts', 'atlatl_f64_scripts');
