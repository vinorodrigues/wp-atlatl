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

add_action('tha_html_before', 'atlatl_f6_html_before', 5, 0);

/**
 * Top of <head>
 */
function atlatl_f6_head_top() {
	echo '<meta http-equiv="x-ua-compatible" content="ie=edge"></meta>' . PHP_EOL;
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"></meta>' . PHP_EOL;
}

add_action('tha_head_top', 'atlatl_f6_head_top', 5, 0);

// ----- Helper actions -----

function atlatl_f6_end_1_div() {
	echo '</div>';
}

function atlatl_f6_end_2_divs() {
	echo '</div></div>';
}


// ----------------------------------------------------------------------------
// ----- Layout -----

function atlatl_f6_wp_loaded() {
	include_once( 'menu-walker.php' );
	include_once( 'func-cont-' . atlatl_get_setting( 'container_position' ) . '.php' );
	$cpos = atlatl_get_content_position();
	include_once( 'func-cpos-' . $cpos . '.php' );
	include_once( 'func-menus.php' );
	include_once( 'func-footer.php' );

	if (is_admin_bar_showing() &&
		((atlatl_get_sidebar_bits() & 3) == 2) &&  // only sidebar-2 showing
		(($cpos == 'slf') || ($cpos == 'srt')))  // stacked layouts only
		ts_enqueue_style( 'admin-bar-sticky',
			// 'body { background-color: red; }' . PHP_EOL .
			'.admin-bar .sticky-sidebar.is-stuck {' . PHP_EOL .
			'  padding-top: 32px !important;' . PHP_EOL .
			' }' . PHP_EOL .
			'@media screen and (maxwidth-width: 782px) {' . PHP_EOL .
			'  .admin-bar .sticky-sidebar.is-stuck {' . PHP_EOL .
			'    padding-top: 46px !important;' . PHP_EOL .
			'  }' . PHP_EOL .
			'}' . PHP_EOL,
			array(),
			'screen' );
}

add_action('wp_loaded', 'atlatl_f6_wp_loaded', 60);

function atlatl_f6_setup_theme() {
	register_nav_menus( array(
//		'header'  => 'Header Menu',
		) );
}

add_action( 'after_setup_theme', 'atlatl_f6_setup_theme', 60 );


// ----------------------------------------------------------------------------
// ----- Scripts -----

/**
 * Scripts
 */
function atlatl_f6_scripts() {
	$th_ver = (defined('WP_DEBUG') && WP_DEBUG) ? GUID() : wp_get_theme()->version;

	// CSS

	$url = '';  // TODO : Foundation form CDN
	if (empty($url)) {
		$ver = FOUNDATION_VERSION;
		$url = get_theme_file_uri( '/on/foundation6/css/foundation' . DOTMIN . '.css' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_style( 'foundation',
		$url,
		array(),
		$ver );

	wp_enqueue_style( 'f6-style',
		get_theme_file_uri( '/on/foundation6/css/style' . DOTMIN . '.css' ),
		array('foundation'),
		$th_ver );

	// JavaScript

	$url = '';  // TODO : Foundation form CDN
	if (empty($url)) {
		$ver = FOUNDATION_VERSION;
		$url = get_theme_file_uri( '/on/foundation6/js/foundation' . DOTMIN . '.js' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_script( 'foundation',
		$url,
		array('jquery'),
		$ver,
		true );

	ts_enqueue_script( 'init-foundation',
		"(function ( $ ) {\n\t$(document).foundation();\n}( jQuery ));" );
}

add_action('wp_enqueue_scripts', 'atlatl_f6_scripts', 60);
