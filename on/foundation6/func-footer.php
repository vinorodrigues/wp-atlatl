<?php

// ----------------------------------------------------------------------------
// ----- Footer -----


function atlatl_f6_footer_top() {
	echo '<div class="grid-x grid-padding-x grid-padding-y">';
}

add_action('tha_footer_top', 'atlatl_f6_footer_top', 40, 0);

add_action('tha_footer_bottom', 'atlatl_f6_end_1_div', 60, 0);

function atlatl_f6_footer_x_top( $args ) {

	static $footer_classes = array(
		array('small-12'),
		array('medium-6', 'medium-6'),
		array('medium-8', 'medium-4'),
		array('medium-9', 'medium-3'),
		array('medium-4', 'medium-4', 'medium-4'),
		array('medium-3', 'medium-6', 'medium-3'),
		array('medium-6', 'medium-3', 'medium-3'),
		array('medium-6 large-3', 'medium-6 large-3', 'medium-6 large-3', 'medium-6 large-3'),
		array('medium-4', 'medium-8'),
		array('medium-3', 'medium-9'),
		array('medium-3', 'medium-3', 'medium-6')
		);

	/*
	 * $args[0] = footer sequence no. (1..4)
	 * $args[1] = footer-bar no. (1..4)
	 * $args[2] = layout index @see footer.php
	 */

	echo '<div class="footer-' . $args[1] . ' cell ' . $footer_classes[$args[2]][$args[0]-1] . '">';
}

add_action( 'tha_footer_1_top', 'atlatl_f6_footer_x_top' );
add_action( 'tha_footer_2_top', 'atlatl_f6_footer_x_top' );
add_action( 'tha_footer_3_top', 'atlatl_f6_footer_x_top' );
add_action( 'tha_footer_4_top', 'atlatl_f6_footer_x_top' );

add_action( 'tha_footer_1_bottom', 'atlatl_f6_end_1_div' );
add_action( 'tha_footer_2_bottom', 'atlatl_f6_end_1_div' );
add_action( 'tha_footer_3_bottom', 'atlatl_f6_end_1_div' );
add_action( 'tha_footer_4_bottom', 'atlatl_f6_end_1_div' );

// ----- Copyright -----

function __footer_f6_copyright_0() {
	echo '<div class="cell small-12 text-center">';
	echo apply_filters( 'atlatl_get_copyright', '&copy; ' .  wpb_copyright_date() . ' ' . get_bloginfo('name') );
	echo '</div>';
}

function __footer_f6_copyright_1() {
	echo '<div class="cell small-12">';

	$items_wrap = '<ul id="%1$s" class="%2$s">';
	$items_wrap .= '%3$s';
	$items_wrap .= '<li class="menu-text">' . apply_filters( 'atlatl_get_copyright', '&copy; ' .  wpb_copyright_date() . ' ' . get_bloginfo('name') ) . '</li>';
	$items_wrap .= '</ul>';

	wp_nav_menu( array(
		'theme_location' => 'footer-1',
		'container' => false,
		'menu_class' => 'menu simple align-center',
		'depth' => 1,
		'fallback_cb' => false,
		'items_wrap' => $items_wrap,
		'walker' => new Foundation6_Walker_Nav_Menu,
		) );

	echo '</div>';
}

function __footer_f6_copyright_2() {
	echo '<div class="cell small-12">';

	$items_wrap = '<ul id="%1$s" class="%2$s">';
	$items_wrap .= '<li class="menu-text">' . apply_filters( 'atlatl_get_copyright', '&copy; ' .  wpb_copyright_date() . ' ' . get_bloginfo('name') ) . '</li>';
	$items_wrap .= '%3$s';
	$items_wrap .= '</ul>';

	wp_nav_menu( array(
		'theme_location' => 'footer-2',
		'container' => false,
		'menu_class' => 'menu simple align-center',
		'depth' => 1,
		'fallback_cb' => false,
		'items_wrap' => $items_wrap,
		'walker' => new Foundation6_Walker_Nav_Menu,
		) );

	echo '</div>';
}

function __footer_f6_copyright_12() {
	echo '<div class="cell small-12 medium-6 large-4 large-order-1">';
	wp_nav_menu( array(
		'theme_location' => 'footer-1',
		'container' => false,
		'menu_class' => 'menu simple align-left',
		'depth' => 1,
		'fallback_cb' => false,
		'walker' => new Foundation6_Walker_Nav_Menu,
		) );
	echo '</div>';

	// -----

	echo '<div class="cell small-12 medium-6 large-4 large-order-3">';
	wp_nav_menu( array(
		'theme_location' => 'footer-2',
		'container' => false,
		'menu_class' => 'menu simple align-right',
		'depth' => 1,
		'fallback_cb' => false,
		'walker' => new Foundation6_Walker_Nav_Menu,
		) );
	echo '</div>';

	// -----

	echo '<div class="cell small-12 medium-12 large-4 text-center large-order-2">';
	echo apply_filters( 'atlatl_get_copyright', '&copy; ' .  wpb_copyright_date() . ' ' . get_bloginfo('name') );
	echo '</div>';
}

function tha_footer_f6_copyright() {
	if ( (atlatl_get_sidebar_bits() & 120) != 0 )
		echo '</div><div class="grid-x grid-padding-x grid-padding-y">';

	$fm1 = has_nav_menu('footer-1');
	$fm2 = has_nav_menu('footer-2');

	if ($fm1 && $fm2) __footer_f6_copyright_12();
	elseif ($fm1) __footer_f6_copyright_1();
	elseif ($fm2) __footer_f6_copyright_2();
	else __footer_f6_copyright_0();
}

add_action( 'tha_footer_bottom', 'tha_footer_f6_copyright', 40, 0 );

function foundation6_footer_nav_menu_css_class( $classes, $item, $args ) {
	if ( ('footer-1' === $args->theme_location) || ('footer-2' === $args->theme_location) )
		if (($key = array_search('is-active', $classes)) !== false)
			unset($classes[$key]);

 	return $classes;
}

add_filter( 'nav_menu_css_class', 'foundation6_footer_nav_menu_css_class', 20, 3 );
