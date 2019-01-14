<?php

// ----------------------------------------------------------------------------
// ----- Nav Menu -----

function atlatl_f6_get_nav_menu( $output, $theme_location ) {
	$output = '';  // clear

	$output = '<div class="title-bar" data-responsive-toggle="' . $theme_location . '-menu" data-hide-for="medium">' .
		'<button class="menu-icon" type="button" data-toggle="' . $theme_location . '-menu"></button>' .
		'<div class="title-bar-title">' . __( 'Menu', 'wp-atlatl' ) . '</div>' .
		'</div>';

	$output .= '<div class="top-bar" id="' . $theme_location . '-menu">';

	$items_wrap = '<ul id="%1$s" class="%2$s" data-dropdown-menu>';
	// $items_wrap .= '<li class="menu-text">[LOGO HERE]</li>';
	$items_wrap .= '%3$s</ul>';

	$output .= wp_nav_menu( array(
		'echo' => false,
		'theme_location' => $theme_location,
		'container_class' => 'top-bar-left',
		'items_wrap' => $items_wrap,
		'menu_class' => 'dropdown menu',
		'depth' => 2,
		'fallback_cb' => false,
		'walker' => new Foundation6_Walker_Nav_Menu,
		) );

	$output .= '</div>';

	return $output;
}

add_filter( 'atlatl_get_nav', 'atlatl_f6_get_nav_menu', 50, 2 );


// function foundation6_primary_nav_menu_css_class( $classes ) {
// 	if ( in_array('current-menu-item', $classes) )
// 		$classes[] = 'active';

// 	return $classes;
// }

// add_filter( 'nav_menu_css_class', 'foundation6_primary_nav_menu_css_class', 20 );


// ----------------------------------------------------------------------------
// ----- Footer Menu -----

function atlatl_f6_get_generic_menu( $output, $theme_location ) {
	$output = '';  // clear

	$output .= wp_nav_menu( array(
		'echo' => false,
		'theme_location' => $theme_location,
		// 'container' => false,
		'container' => 'nav',
		// 'container_class' => '',
		'menu_class' => 'vertical medium-horizontal simple menu',
		'depth' => 1,
		'fallback_cb' => false,
		'walker' => new Foundation6_Walker_Nav_Menu,
		) );

	return $output;
}

add_filter( 'atlatl_get_footer_menu', 'atlatl_f6_get_generic_menu', 50, 2);

function foundation6_footer_nav_menu_css_class( $classes, $item, $args ) {
//	echo '<pre>'; var_dump($args->theme_location); var_dump($classes); echo '</pre>';
	if ( ('footer-1' === $args->theme_location) || ('footer-2' === $args->theme_location) )
		if (($key = array_search('is-active', $classes)) !== false)
			unset($classes[$key]);

 	return $classes;
}

add_filter( 'nav_menu_css_class', 'foundation6_footer_nav_menu_css_class', 20, 3 );
