<?php

// define( 'POST_THUMBNAIL_X', 200);
// define( 'POST_THUMBNAIL_Y', 200);
// define( 'FEATURED_IMAGE_X', 1170);
// define( 'FEATURED_IMAGE_Y', 200);

define( 'MAX_TITLE_LINK_LENGTH', 30 );

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
if (!defined('ICON_ENGINE'))
	define( 'ICON_ENGINE', 'foundation-icons3' );

include_once( 'lib/tha-theme-hooks.php' );
include_once( 'lib/lib-ts/raw-scripts.php' );
include_once( 'lib/lib-ts/raw-styles.php' );
include_once( 'on/' . THEME_ENGINE . '/functions.php' );
include_once( 'font/' . ICON_ENGINE . '/functions.php' );
include_once( 'inc/customizer.php' );
if (defined('WP_DEBUG') && WP_DEBUG && file_exists(get_template_directory().'/inc/~debug.php'))
	include_once( 'inc/~debug.php' );

// ----------------------------------------------------------------------------
// ----- Icons -----

if (!function_exists('icon')) { function icon($key) { return ''; } }

function _i($icon, $content, $icon_first = true) {
	$i = icon($icon);
	if (!empty($i)) {
		if ($icon_first)
			return sprintf(esc_html_x('%1$s %2$s', 'icon', 'wp-atlatl'), $i, $content);
		else
			return sprintf(esc_html_x('%2$s %1$s', 'icon', 'wp-atlatl'), $i, $content);
	} else {
		return $content;
	}
}

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
		$classes[] = 'WP-DEBUG';
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
		$classes[] = 'SCRIPT-DEBUG';
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

function is_last_post() {
	global $wp_query;
	return ($wp_query->current_post + 1) == ($wp_query->post_count);
}

if (!function_exists('delete_post_link')) {
	function delete_post_link( $text = null, $before = '', $after = '', $id = 0, $class = 'post-delete-link' ) {
		if ( ! $post = get_post( $id ) ) return;
		if ( ! $url = get_delete_post_link( $post->ID ) ) return;
		if ( null === $text ) $text = __( 'Delete This' );
		$link = '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . $text . '</a>';
		echo $before . apply_filters( 'delete_post_link', $link, $post->ID, $text ) . $after;
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

	load_theme_textdomain('wp-atlatl', get_template_directory() . '/lang');
}

add_action( 'after_setup_theme', 'atlatl_setup_theme', 50 );

function atlatl_widgets_init() {
	global $container_segments;

	$tag = 'h4';

	register_sidebar( array(
		'name'		  => 'Primary Sidebar',
		'id'			=> 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside class="widget widget-sidebar %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<' . $tag . '>',
		'after_title'   => '</' . $tag . '>',
		) );

	register_sidebar( array(
		'name'		  => 'Secondary Sidebar',
		'id'			=> 'sidebar-2',
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
		'name'		  => 'Header-bar',
		'id'			=> 'sidebar-3',
		'description'   => 'Placed besides the Site Title or Site Logo',
		'before_widget' => '<aside class="widget widget-header ' . $class . ' %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<' . $tag . ' class="hidden" hidden>',
		'after_title'   => '</' . $tag . '>',
		) );

	$n = array('1st', '2nd', '3rd', '4th');
	for ($i = 1; $i <= 4; $i++) {
		register_sidebar( array(
			'name'		  => $n[$i-1] . ' Footer-bar',
			'id'			=> 'sidebar-' . ($i+3),
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
// function atlatl_the_excerpt($content) {
// 	return str_replace(' [...]',
// 		'<a class="readmore" href="'. get_permalink() .'">' .
// 		_x('Read More', 'excerpt', 'wp-atlatl') . '</a>',
// 		$content );
// }

// add_filter('the_excerpt', 'atlatl_the_excerpt');

// paginate_links() clone
function atlatl_paginate_links( $args = '' ) {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts	= explode( '?', $pagenum_link );

	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$defaults = array(
		'base'         => $pagenum_link,  // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format'       => $format,  // ?page=%#% : %#% is replaced by the page number
		'total'        => $total,
		'current'      => $current,
		// 'aria_current' => 'page',
		'show_all'     => false,
		'prev_next'    => true,
		'prev_text'    => _x( 'Previous', 'pagination', 'wp-atlatl' ),
		'next_text'    => _x( 'Next', 'pagination', 'wp-atlatl' ),
		'hellip_text'  => _x( '&hellip;', 'pagination', 'wp-atlatl' ),
		'end_size'     => 1,
		'mid_size'     => 2,
		'type'         => 'plain',
		'add_args'     => array(), // array of query args to add
		);

	$args = wp_parse_args( $args, $defaults );

	if ( ! is_array( $args['add_args'] ) ) {
		$args['add_args'] = array();
	}

	// Merge additional query vars found in the original URL into 'add_args' array.
	if ( isset( $url_parts[1] ) ) {
		// Find the format argument.
		$format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
		$format_query = isset( $format[1] ) ? $format[1] : '';
		wp_parse_str( $format_query, $format_args );

		// Find the query args of the requested URL.
		wp_parse_str( $url_parts[1], $url_query_args );

		// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
		foreach ( $format_args as $format_arg => $format_arg_value ) {
			unset( $url_query_args[ $format_arg ] );
		}

		$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
	}

	// Who knows what else people pass in $args
	$total = (int) $args['total'];
	if ( $total < 2 ) {
		return;
	}
	$current  = (int) $args['current'];
	$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}
	$add_args = $args['add_args'];
	$r = '';
	$page_links = array();
	$dots = false;

	if ( $args['prev_next'] && $current && 1 < $current ) :
		$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current - 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );

		$page_links[] = array( $args['prev_text'], apply_filters( 'paginate_links', $link ), 'p' );
	elseif ( $args['prev_next'] ) :
		$page_links[] = array( $args['prev_text'], null, 'p' );
	endif;

	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = array( number_format_i18n( $n ), null, 'c' );
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );

				$page_links[] = array( number_format_i18n( $n ), apply_filters( 'paginate_links', $link ), 'l' );
				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = array( $args['hellip_text'], null, 'e' );
				$dots = false;
			endif;
		endif;
	endfor;

	if ( $args['prev_next'] && $current && $current < $total ) :
		$link = str_replace( '%_%', $args['format'], $args['base'] );
		$link = str_replace( '%#%', $current + 1, $link );
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );

		$page_links[] = array( $args['next_text'], apply_filters( 'paginate_links', $link ), 'n' );
	elseif ( $args['prev_next'] ) :
		$page_links[] = array( $args['next_text'], null, 'n' );
	endif;

	switch ( $args['type'] ) {
		case 'array' :
			return $page_links;

		case 'list' :
			$r .= '<ul>';
			foreach ($page_links as $p) {
				$r .= '<li>';
				if (!is_null($p[1])) $r .= '<a href="' . $p[1] . '">';
				$r .= $p[0];
				if (!is_null($p[1])) $r .= '</a>';
				$r .= '</li>';
			}
			$r .= '</ul>';
			break;

		default :
			foreach ($page_links as $p) {
				if (!is_null($p[1])) $r .= '<a href="' . $p[1] . '">';
				$r .= $p[0];
				if (!is_null($p[1])) $r .= '</a>';
				$r .= PHP_EOL;
			}
	}
	return $r;
}

function _atlatl_link_page( $i ) {
	global $wp_rewrite;
	$post = get_post();
	$query_args = array();

	if ( 1 == $i ) {
		$url = get_permalink();
	} else {
		if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
			$url = add_query_arg( 'page', $i, get_permalink() );
		elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
			$url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
		else
			$url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
	}

	if ( is_preview() ) {
		if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
			$query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
			$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
		}
		$url = get_preview_post_link( $post, $query_args, $url );
	}

	return $url;
}

// wp_link_pages clone
function atlatl_link_pages( $args = '' ) {
	global $page, $numpages, $multipage, $more;

	$defaults = array(
		'next_or_number'   => 'number',
		'nextpagelink'     => __( 'Next page', 'wp-atlatl' ),
		'previouspagelink' => __( 'Previous page', 'wp-atlatl' ),
		'pagelink'         => '%',
		'echo'             => 1
		);

	$r = wp_parse_args( $args, $defaults );

	$page_links = array();
	if ( $multipage ) {
		if ( 'number' == $r['next_or_number'] ) {
			for ( $i = 1; $i <= $numpages; $i++ ) {
				$text = str_replace( '%', $i, $r['pagelink'] );
				$link = _atlatl_link_page( $i );
				$page_links[] = array($text, $link, ( $i != $page || ! $more && 1 == $page ) ? 'l' : 'c');
			}
		} elseif ( $more ) {
			$prev = $page - 1;
			if ( $prev > 0 )
				$link = _atlatl_link_page( $prev );
			else
				$link = null;
			$page_links[] = array($r['previouspagelink'], $link, 'p');

			$next = $page + 1;
			if ( $next <= $numpages )
				$link = _atlatl_link_page( $next );
			else
				$link = null;
			$page_links[] = array($r['nextpagelink'], $link, 'n');
		}
	}

	return $page_links;
}

function atlatl_adjacent_post_link( $output, $format, $link, $post, $adjacent ) {
	$previous = ('next' != $adjacent);
	if ( empty( $post->post_title ) )
		return '';
	else
		$title = $post->post_title;
	$rel = $previous ? 'prev' : 'next';
	$href = '<a href="' . get_permalink( $post ) . '" rel="'.$rel.'">';
	$title = str_replace( '%title', mb_strimwidth($title, 0, MAX_TITLE_LINK_LENGTH, '&hellip;'), $link );
	$output = $href . $title . '</a>';
	$output = str_replace( '%link', $output, $format );
	return $output;
}

add_filter( 'next_post_link', 'atlatl_adjacent_post_link', 10, 5 );
add_filter( 'previous_post_link', 'atlatl_adjacent_post_link', 10, 5 );
