<?php

if ( !defined('FOUNDATION_VERSION') )
	define('FOUNDATION_VERSION', '6.5.1');

// ----------------------------------------------------------------------------
// ----- HTML -----

/**
 * Before <html>
 */
function atlatl_f6_html_before() {
	echo '<!doctype html>' . PHP_EOL;
}

add_action('tha_html_before', 'atlatl_f6_html_before', 50, 0);

/**
 * Top of <head>
 */
function atlatl_f6_head_top() {
	echo '<meta http-equiv="x-ua-compatible" content="ie=edge"></meta>' . PHP_EOL;
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"></meta>' . PHP_EOL;
}

add_action('tha_head_top', 'atlatl_f6_head_top', 50, 0);

// ----------------------------------------------------------------------------
// ----- Layout -----

function atlatl_f6_init() {
	include_once 'func-wdth-all.php';
	include_once 'func-cpos-' . atlatl_get_setting('content_position') . '.php';
}

add_action('init', 'atlatl_f6_init', 50);

// ----------------------------------------------------------------------------
// ----- Scripts -----

/**
 * Scripts
 */
function atlatl_f6_scripts() {
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

add_action('wp_enqueue_scripts', 'atlatl_f6_scripts', 40);
