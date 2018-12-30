<?php

if ( !defined('THEME_PATH') )
	define('THEME_PATH', dirname(__FILE__).'/');

if ( !defined('DOTMIN') )
	define('DOTMIN', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min');

include_once get_theme_file_path('config.php');

if (!defined('THEME_ENGINE'))
	define('THEME_ENGINE', 'foundation6');

include_once 'lib/tha-theme-hooks.php';

if (!function_exists('get_theme_file_uri')) {
	function get_theme_file_uri( $file = '' ) {
		$file = ltrim( $file, '/' );

		if ( empty( $file ) ) {
			$url = get_stylesheet_directory_uri();
		} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
			$url = get_stylesheet_directory_uri() . '/' . $file;
 		} else {
			$url = get_template_directory_uri() . '/' . $file;
		}

		return apply_filters( 'theme_file_uri', $url, $file );
	}
}

function atlatl_init() {
	include_once 'debug.php';
	include_once 'on/' . THEME_ENGINE . '/functions.php';
}
add_action('init', 'atlatl_init');

function atlatl_setup_theme() {
	add_theme_support( 'tha_hooks', array(
		'html',
		'body',
		'head',
		'header',
		'nav',
		'content',
		'entry',
		// 'comments',
		'sidebars',
		'sidebar',
		'footer',
		) );
}
add_action( 'after_setup_theme', 'atlatl_setup_theme' );

function atlatl_scripts() {
	$th_ver = wp_get_theme()->version;

	// CSS

	if (is_child_theme()) {
		wp_enqueue_style(
			'style-parent',
			get_template_directory_uri().'/style.css',
			array(),
			$th_ver );
		wp_enqueue_style(
			'style-child',
			get_stylesheet_uri(),
			array('style-parent'),
			$th_ver );
	} else {
		wp_enqueue_style(
			'style',
			get_stylesheet_uri(),
			array(),
			$th_ver );
	}

	// JavaScript

	// remove WP jquery that relies on v1
	wp_deregister_script('jquery');

	// jQuery
	$url = '';  // $url = trim( bs4_get_option('jquery_js') );
	if (empty($url)) {
		$ver = JQUERY_VERSION;
		$url = get_theme_file_uri( '/vendor/jquery/js/jquery-' . $ver . DOTMIN . '.js' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_script( 'jquery', $url, array(), $ver, true );

}
add_action('wp_enqueue_scripts', 'atlatl_scripts');
