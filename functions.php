<?php

// ----------------------------------------------------------------------------
// Defines, includes & globals

if ( !defined('THEME_PATH') )
	define('THEME_PATH', dirname(__FILE__).'/');

if ( !defined('DOTMIN') )
	define('DOTMIN', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min');

include_once( get_theme_file_path('config.php') );

if (!defined('THEME_ENGINE'))
	define('THEME_ENGINE', 'foundation6');

include_once( 'lib/tha-theme-hooks.php' );
include_once( 'lib/lib-ts/raw-scripts.php' );
include_once( 'lib/lib-ts/raw-styles.php' );
include_once( 'on/' . THEME_ENGINE . '/functions.php' );
include_once( 'inc/customizer.php' );
if (defined('WP_DEBUG') && WP_DEBUG)
	include_once( 'inc/debug.php' );


// ----------------------------------------------------------------------------
// Helper functions

if (!function_exists('get_theme_file_uri')) {  // get_theme_file_uri - included in WP 4.7.0+
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

if (defined('WP_DEBUG') && WP_DEBUG && (!function_exists('GUID'))) {
	function GUID() {
		if (function_exists('com_create_guid') === true)
			return trim(com_create_guid(), '{}');
		else
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

if (defined('WP_DEBUG') && WP_DEBUG) {
	function atlatl_wp_debug_body_class( $classes ) {
		$classes[] = 'WP_DEBUG';
		$classes[] = 'layout-' .
			atlatl_get_setting( 'content_position' ) . '-' .
			atlatl_get_content_position() . '-' .
			atlatl_get_sidebar_bits();
		return $classes;
	}

	add_filter( 'body_class','atlatl_wp_debug_body_class' );
}

if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
	function atlatl_script_debug_body_class( $classes ) {
		$classes[] = 'SCRIPT_DEBUG';
		return $classes;
	}

	add_filter( 'body_class','atlatl_script_debug_body_class' );
}

/**
 * See: http://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
 */
if (!function_exists('wpb_copyright_date')) {
	function wpb_copyright_date() {
		global $wpdb;
		$copyright_dates = $wpdb->get_results('SELECT' .
			' YEAR(min(post_date_gmt)) AS firstdate,' .
			' YEAR(max(post_date_gmt)) AS lastdate' .
			' FROM' .
			' ' . $wpdb->posts .
			' WHERE' .
			' post_status = \'publish\'');
		$output = '';
		if($copyright_dates) {
			$output .= $copyright_dates[0]->firstdate;
			if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate)
				$output .= '-' . $copyright_dates[0]->lastdate;
		}
		return $output;
	}
}


// ----------------------------------------------------------------------------
// Settings functions

function atlatl_get_default( $option ) {
	static $defaults = array(
		'logo_placement' => 'lft',
		'menu_position' => 'pag',
		'container_position' => 'pag',
		'container_width' => 'cnt',
		'content_position' => 'cnt',
		);
	if ( isset($defaults[$option]) )
		return $defaults[$option];
	else
		return false;
}

function atlatl_get_setting( $option ) {
	$value = get_theme_mod( $option );
	if (false === $value) $value = atlatl_get_default( $option );
	return $value;
}

/**
 * Bitwize mask of set sidebars
 *
 * +----------+-----------------------+--------+---------------------+
 * |          | Footer                |        | Sidebar             |
 * | Not used +-----+-----+-----+-----+ Header +-----------+---------+
 * |          | 4th | 3rd | 2nd | 1st |        | Secondary | Primary |
 * +----------+-----+-----+-----+-----+--------+-----------+---------+
 * | 128      | 64  | 32  | 16  | 8   | 4      | 2         | 1       |
 * +----------+-----+-----+-----+-----+--------+-----------+---------+
 */
function atlatl_get_sidebar_bits() {
	global $atlatl_sidebar_cnt;
	if (!isset($atlatl_sidebar_cnt)) $atlatl_sidebar_cnt = 0;

	if ($atlatl_sidebar_cnt === 0)
		for ($i=0; $i < 7; $i++) {
			if (is_active_sidebar( 'sidebar-' . ($i+1) ))
				$atlatl_sidebar_cnt = $atlatl_sidebar_cnt | (1 << $i);
		}

	return $atlatl_sidebar_cnt;
}

function atlatl_get_content_position() {
	$cpos = atlatl_get_setting( 'content_position' );

	// Get MISSING sidebars
	$cnt = atlatl_get_sidebar_bits();
	if (($cnt & 1) == 0) $cpos .= '1';
	if (($cnt & 2) == 0) $cpos .= '2';

	switch ($cpos) {
		case 'cnt12':
		case 'dlf12':
		case 'slf12':
		case 'drt12':
		case 'srt12':
		case 'btm1':
		case 'btm2':
		case 'btm12': $cpos = 'btm';  break;

		case 'cnt1':
		case 'dlf1':
		case 'dlf2':
		case 'slf1':
		case 'slf2':  $cpos = 'slf';  break;

		case 'cnt2':
		case 'drt1':
		case 'drt2':
		case 'srt1':
		case 'srt2':  $cpos = 'srt';  break;
	}  /* */

	return $cpos;
}


// ----------------------------------------------------------------------------

function atlatl_setup_theme() {
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );  // TODO : Remove, Generate own title tag

	// add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	// set_post_thumbnail_size( POST_THUMBNAIL_X, POST_THUMBNAIL_Y, true );
	// add_image_size( 'featured-image', FEATURED_IMAGE_X, FEATURED_IMAGE_Y, true);

	register_nav_menus( array(
		'primary' => 'Primary Menu',
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
		'container',
		'content',
		// 'entry',
		// 'comments',
		'sidebars',
		'sidebar',
		'footer',
		) );
}

add_action( 'after_setup_theme', 'atlatl_setup_theme', 50 );

function atlatl_widgets_init() {
	global $container_segments;

	$tag = 'h4';

	register_sidebar( array(
		'name'          => 'Primary Sidebar',
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside class="widget widget-sidebar %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<' . $tag . '>',
		'after_title'   => '</' . $tag . '>',
		) );

	register_sidebar( array(
		'name'          => 'Secondary Sidebar',
		'id'            => 'sidebar-2',
		'description'   => '',
		'before_widget' => '<aside class="widget widget-sidebar %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<' . $tag . '>',
		'after_title'   => '</' . $tag . '>',
		) );

	register_sidebar( array(
		'name'          => 'Header-bar',
		'id'            => 'sidebar-3',
		'description'   => 'Placed besides the Site Title or Site Logo',
		'before_widget' => '<aside class="widget widget-header h-i %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<' . $tag . ' class="hidden-xs-up" hidden>',
		'after_title'   => '</' . $tag . '>',
		) );

	$n = array('1st', '2nd', '3rd', '4th');
	for ($i = 1; $i <= 4; $i++) {
		register_sidebar( array(
			'name'          => $n[$i-1] . ' Footer-bar',
			'id'            => 'sidebar-' . ($i+3),
			'description'   => '',
			'before_widget' => '<aside class="widget widget-footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<' . $tag . '>',
			'after_title'   => '</' . $tag . '>',
			) );
	}
}

add_action( 'widgets_init', 'atlatl_widgets_init', 50 );

// function atlatl_wp_loaded() {
// }

// add_action('wp_loaded', 'atlatl_wp_loaded', 30);

function atlatl_scripts() {
	$th_ver = (defined('WP_DEBUG') && WP_DEBUG) ? GUID() : wp_get_theme()->version;

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

	if (defined('WP_DEBUG') && WP_DEBUG)
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

