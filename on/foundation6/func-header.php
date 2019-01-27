<?php

/**
<div class="grid-x grid-padding-x grid-padding-y">
	<div class="cell small-6">
		Logo
	</div>
	<div class="cell small-6 flex-container flex-dir-column">
		<div class="flex-child-shrink">
			Menu
		</div>
		<div class="flex-child-grow">
			Widget
		</div>
	</div>
</div>
*/

function __get_f6_header_branding($hpos = '') {
	$out = '';
	if ( has_custom_logo() ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$w = $logo[1];
		$h = $logo[2];
		$r = boolval( get_theme_mod( 'retina_logo' ) );
		$classes = array('custom-logo');
		$classes[] = 'w' . $w;
		$classes[] = 'h' . $h;

		switch ($hpos) {
			case 'lft': $classes[] = 'float-left'; break;
			case 'rgt': $classes[] = 'float-right'; break;
			default: $classes[] = 'float-center'; break;
		}

		if ( $r ) {
			$classes[] = 'retina-image';
			$w = intval( $w / 2);
			$h = intval( $h / 2);
		}
		$out .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
		$out .= '<img class="' . implode(' ', $classes) . '"';
		$out .= ' width="' . $w . '" height="' . $h . '" src="'. esc_url( $logo[0] ) .'"';
		$out .= ' alt="' . esc_attr( get_bloginfo( 'name' ) ) . '"';
		$out .= ' />';
		$out .= '</a>';
	} else {
		$classes = array('site-title');
		switch ($hpos) {
			case 'mid': $classes[] = 'text-center'; break;
			case 'rgt': $classes[] = 'text-right'; break;
			default: $classes[] = 'text-left';
		}
		$out .= '<h1 class="' . implode(' ', $classes) . '">';
		$out .= '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
		$out .= get_bloginfo( 'name' );
		$out .= '</a>';
		$out .= '</h1>';

		$desc = get_bloginfo( 'description', 'display' );
		if ( $desc || is_customize_preview() ) {
			$out .= '<p class="site-description' . $class . '">' . $desc . '</p>';
		}
	}

	return $out;
}

function __get_f6_header_menu($hpos = '') {
	switch ($hpos) {
		case 'lft': $class = 'align-right'; break;
		case 'rgt': $class = 'align-left'; break;
		default: $class = 'align-center'; break;
	}
	$out = '<div class="flex-child-shrink">';
	$out .= wp_nav_menu( array(
		'theme_location' => 'header',
		'container' => false,
		'menu_class' => 'menu ' . $class,
		'depth' => 1,
		'fallback_cb' => false,
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new Foundation6_Walker_Nav_Menu,
		'echo' => false
		) );
	$out .= '</div>';
	return $out;
}

function __get_f6_header_widgets($hpos = '') {
	$out = '<div class="flex-child-grow">';
	ob_start();
	dynamic_sidebar( 3 );
	$out .= ob_get_clean();
	$out .= '</div>';
	return $out;
}

function atlatl_f6_get_header() {
	$out = '';
	$hpos = atlatl_get_header_position();
	$has = !(('nav' == $hpos) || ('off' == $hpos));
	$mnu = has_nav_menu('header');
	$wdg = is_active_sidebar(3);
	if (!$has && !$mnu && !$wdg) return '';

	$out .= '<div class="header grid-x grid-padding-y" role="banner">';

	$both = $has && ($mnu || $wdg);

	if ($has) {
		$classes = array('cell');
		if ($both) {
			if (('lft' == $hpos) || ('rgt' == $hpos)) $classes[] = 'medium-4';
			if ('rgt' == $hpos) $classes[] = 'medium-order-2';
		}
		$out .= '<div class="' . implode(' ', $classes) . '">';
		$out .= __get_f6_header_branding($hpos);
		$out .= '</div>';
	}

	if ($mnu || $wdg) {
		$classes = array('cell');
		if ($both) {
			if (('lft' == $hpos) || ('rgt' == $hpos)) $classes[] = 'medium-8';
			if ('rgt' == $hpos) $classes[] = 'medium-order-1';
		}
		$classes[] = 'flex-container';
		$classes[] = 'flex-dir-column';
		$out .= '<div class="' . implode(' ', $classes) . '">';

		if ($mnu)
			$out .= __get_f6_header_menu($hpos);

		if ($wdg)
			$out .= __get_f6_header_widgets($hpos);

		$out .= '</div>';
	}

	$out .= '</div>';

	return $out;
}

add_filter( 'atlatl_get_header', 'atlatl_f6_get_header' );
