<?php

if ( !defined('THEME_PATH') )
	define('THEME_PATH', dirname(__FILE__).'/');

if ( !defined('DOTMIN') )
	define('DOTMIN', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min');

include_once get_theme_file_path('config.php');

if (!defined('THEME_ENGINE'))
	define('THEME_ENGINE', 'foundation6');

// settings
global $settings;
$settings = array();

$settings['logo_placement'] = get_theme_mod('logo_placement', 'lft');
$settings['container_width'] = get_theme_mod('container_width', 'cnt');
$settings['content_position'] = get_theme_mod('content_position', 'cnt');

// config
include_once 'inc/customizer.php';

// vendors
include_once 'lib/tha-theme-hooks.php';

// get_theme_file_uri - included in WP 4.7.0+
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

if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
	function GUID() {
		if (function_exists('com_create_guid') === true)
			return trim(com_create_guid(), '{}');

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(16384, 20479),
			mt_rand(32768, 49151),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535) );
	}
}

// ----------------------------------------------------------------------------

function atlatl_init() {
	include_once 'inc/debug.php';
	include_once 'on/' . THEME_ENGINE . '/functions.php';
}

add_action('init', 'atlatl_init');

function atlatl_setup_theme() {

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );  // TODO : Remove, Generate own title tag

	// add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	// set_post_thumbnail_size( POST_THUMBNAIL_X, POST_THUMBNAIL_Y, true );
	// add_image_size( 'featured-image', FEATURED_IMAGE_X, FEATURED_IMAGE_Y, true);

	register_nav_menus( array(
		'primary' => 'Primary Menu',
		// 'header'  => 'Header Menu',
		// 'footer'  => 'Footer Menu',
		) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		// 'gallery',
		'caption',
		) );

	add_theme_support( 'post-formats', array(
		// 'aside',
		// 'image',
		// 'video',
		// 'quote',
		// 'link',
		) );

	add_theme_support( 'custom-logo', array(
		'flex-width' => true,
		'flex-height' => true,
		) );

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

	wp_enqueue_style(
		'wp-atlatl',
		get_template_directory_uri() . '/css/style.css',
		array(),
		$th_ver );

	if (is_child_theme()) {
		wp_enqueue_style(
			'style-parent',
			get_template_directory_uri() . '/style.css',
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
	}  /* */

	if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)
		wp_enqueue_style( 'debug', get_template_directory_uri() . '/css/debug.css', array(), GUID(), 'screen' );

	// JavaScript

	// remove WP jquery that relies on v1
	wp_deregister_script('jquery');

	// jQuery
	$url = '';  // $url = trim( bs4_get_option('jquery_js') );
	if (empty($url)) {
		$ver = JQUERY_VERSION;
		$url = get_template_directory_uri() . '/vendor/jquery/js/jquery-' . $ver . DOTMIN . '.js';
		$ver = NULL;  // filename already has version
	} else {
		$ver = NULL;
	}
	wp_register_script( 'jquery', $url, array(), $ver, true );

}

add_action('wp_enqueue_scripts', 'atlatl_scripts', 50);
