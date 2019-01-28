<?php

// Customise the footer in admin area
function atlatl_admin_footer_text () {
	echo 'WP-Altatl theme designed and developed by' .
		' <a href="//github.com/vinorodrigues" target="_blank">Vino Rodrigues</a>' .
		' and powered by <a href="//wordpress.org" target="_blank">WordPress</a>.';
}

add_filter('admin_footer_text', 'atlatl_admin_footer_text');


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
if (defined('WP_DEBUG') && WP_DEBUG && file_exists(get_template_directory().'/inc/~debug.php'))
	include_once( 'inc/~debug.php' );


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

function atlatl_get_custom_logo($classes = array(), $blog_id = 0) {
	$html = '';
	$switched_blog = false;

	if ( is_multisite() && ! empty( $blog_id ) && (int) $blog_id !== get_current_blog_id() ) {
		switch_to_blog( $blog_id );
		$switched_blog = true;
	}
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$classes[] = 'custom-logo';

	if ( $custom_logo_id ) {
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		if ($image) {
			list($src, $w, $h) = $image;

			$attr = array(
				'src' => $src,
				'itemprop' => 'logo',
				);

			$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
			$attachment = get_post( $custom_logo_id );
			if ( empty( $image_alt ) )
				$image_alt = get_bloginfo( 'name', 'display' );
			$attr['alt'] = $image_alt;

			if ( boolval( get_theme_mod( 'retina_logo' ) ) ) {
				$classes[] = 'retina-image';
				$w = intval( $w / 2);
				$h = intval( $h / 2);
			}
			$attr['class'] = implode(' ', $classes);

			$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, 'full' );
			$attr = array_map( 'esc_attr', $attr );

			$image = '<img';
			$image .= ' width="' . $w . '"';
			$image .= ' height="' . $h . '"';
			foreach ( $attr as $name => $value )
				$image .= ' ' . $name . '="' . $value . '"';
			$image .= ' />';

			$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ), $image );
    	}
    }
	elseif ( is_customize_preview() ) {
		$html = sprintf( '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="' . implode(' ', $classes) . '"/></a>',
			esc_url( home_url( '/' ) ) );
	}

	if ( $switched_blog ) restore_current_blog();
    return apply_filters( 'get_custom_logo', $html, $blog_id );
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

function atlatl_body_class( $classes ) {
	$bits = atlatl_get_sidebar_bits();
	if (($bits & 3) != 0)
		$classes[] = 'has-sidebar';
	if (($bits & 1) != 0)
		$classes[] = 'has-sidebar-1';
	if (($bits & 2) != 0)
		$classes[] = 'has-sidebar-2';
	return $classes;
}

add_filter( 'body_class','atlatl_body_class' );

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

		case 'cnt2':
		case 'dlf1':
		case 'dlf2':
		case 'slf1':
		case 'slf2':  $cpos = 'slf';  break;

		case 'cnt1':
		case 'drt1':
		case 'drt2':
		case 'srt1':
		case 'srt2':  $cpos = 'srt';  break;
	}

	return $cpos;
}

function atlatl_get_header_position() {
	$hpos = atlatl_get_setting( 'logo_placement' );
	return $hpos;
}

// ----------------------------------------------------------------------------

function atlatl_setup_theme() {
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );  // TODO : Remove, Generate own title tag

	// add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	// set_post_thumbnail_size( POST_THUMBNAIL_X, POST_THUMBNAIL_Y, true );
	// add_image_size( 'featured-image', FEATURED_IMAGE_X, FEATURED_IMAGE_Y, true);

	register_nav_menus( array(
		'primary'  => 'Primary Menu',
		'header'   => 'Header Menu',
		'footer-1' => 'Left Footer Menu',
		'footer-2' => 'Right Footer Menu',
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

	$hpos = atlatl_get_header_position();
	$class = 'widget-';
	switch ($hpos) {
		case 'lft': $class .= 'right'; break;
		case 'rgt': $class .= 'left'; break;
		default: $class .= 'center';
	}
	register_sidebar( array(
		'name'          => 'Header-bar',
		'id'            => 'sidebar-3',
		'description'   => 'Placed besides the Site Title or Site Logo',
		'before_widget' => '<aside class="widget widget-header ' . $class . ' %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<' . $tag . ' class="hidden" hidden>',
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

	if (defined('WP_DEBUG') && WP_DEBUG && file_exists(get_template_directory().'/css/~debug.css'))
		wp_enqueue_style( 'debug', get_template_directory_uri() . '/css/~debug.css', array(), GUID(), 'screen' );

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

// Custom CSS for the login page
function atlatl_login_css() {
	echo '<link rel="stylesheet" type="text/css" href="' .
		get_template_directory_uri() .
		'/css/wp-login.css" />';
}

add_action('login_head', 'atlatl_login_css');

// Create a permalink after the excerpt
function atlatl_the_excerpt($content) {
	return str_replace(' [...]',
		'<a class="readmore" href="'. get_permalink() .'">' .
		__('Read More', 'wp-atlatl') . '</a>',
		$content );
}
add_filter('the_excerpt', 'atlatl_the_excerpt');

