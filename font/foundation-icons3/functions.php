<?php

/**
 * @see: https://zurb.com/playground/foundation-icon-fonts-3
 */

if (!defined('FI_VERSION')) define( 'FI_VERSION', '3.0' );

function atlatl_fif6_scripts() {
	$th_ver = (defined('WP_DEBUG') && WP_DEBUG) ? GUID() : FI_VERSION;

	// CSS

	$url = '';  // TODO : Foundation Icon Fonts form CDN
	if (empty($url)) {
		$ver = $th_ver;
		$url = get_theme_file_uri( '/font/foundation-icons3/foundation-icons' . DOTMIN . '.css' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_style( 'foundation-icons',
		$url,
		array(),
		$ver );
}

add_action('wp_enqueue_scripts', 'atlatl_fif6_scripts', 70);

function icon($key) {
	static $keys = array(
		// ----- ABCDEFGHIJKLMNOPQRSTUVWXYZ -----
		// 'alert'       => 'alert',
		'cat'         => 'folder',
		'date'        => 'calendar',
		// 'info'        => 'info',
		'login'       => 'lock',
		'more'        => 'play',
		'next'        => 'arrow-right',
		'no-comments' => 'comment',
		'n-comments'  => 'comments',
		'one-comment' => 'comment',
		'post-edit'   => 'pencil',
		'prev'        => 'arrow-left',
		'reply'       => 'arrow-left',
		'search'      => 'magnifying-glass',
		'star'        => 'star',
		'tag'         => 'bookmark',
		'user'        => 'torso',
		);

	$k = array_key_exists($key, $keys) ? $keys[$key] : null;
	if (!is_null($k))
		return '<i class="fi-' . $k . '"></i>';
	else
		return '<i class="fi-' . $key . '"></i>';
}
