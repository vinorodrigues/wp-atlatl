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
		'user' => 'torso',
		'cat'  => 'results',
		'star' => 'star',
		'date' => 'calendar',
		'next' => 'arrow-right',
		'prev' => 'arrow-left',
		);

	$k = array_key_exists($key, $keys) ? $keys[$key] : null;
	if (!is_null($k))
		return '<i class="fi-' . $k . '"></i>';
	else
		return '';
}
