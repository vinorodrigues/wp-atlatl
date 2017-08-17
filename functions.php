<?php

if (!defined('THEMEENGINE'))
	define('THEMEENGINE', 'f6');

if ( !defined('THEMEPATH') )
	define('THEMEPATH', dirname(__FILE__).'/');

if ( !defined('DOTMIN') )
	define('DOTMIN', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min');

include_once get_theme_file_path('config.php');
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

function wpf6_init() {
	include_once 'engine/' . THEMEENGINE . '/' . THEMEENGINE . '-functions.php';
}
add_action('init', 'wpf6_init');

function wpf6_setup_theme() {
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
add_action( 'after_setup_theme', 'wpf6_setup_theme' );

function wpf6_scripts() {
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
		$url = get_theme_file_uri( '/vendor/jquery/js/jquery-' . JQUERY_VERSION . DOTMIN . '.js' );
		$ver = JQUERY_VERSION;
	} else {
		$ver = NULL;
	}
	wp_enqueue_script( 'jquery', $url, array(), $ver, true );

}
add_action('wp_enqueue_scripts', 'wpf6_scripts');