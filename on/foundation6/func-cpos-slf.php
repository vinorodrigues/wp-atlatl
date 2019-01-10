<?php

// ----- Body -----

function atlatl_f6_slf_body_class( $classes ) {
	$classes[] = 'layout-slf';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_slf_body_class' );

// ----- Content -----

function atlatl_f6_slf_content_before() {
	echo '<div class="cell medium-9 medium-order-2">';
}

add_action('tha_content_before', 'atlatl_f6_slf_content_before', 60, 0);

add_action('tha_content_after', 'atlatl_f6_end_1_div', 40, 0);

// ----- Siderbars -----


function atlatl_f6_slf_sidebars_before() {
	$b = atlatl_get_sidebar_bits();
	$class = 'cell medium-3 medium-order-1 sidebars';
	if (($b & 3) == 2) $class .= ' data-sticky-container';
	echo '<div class="' . $class . '">';
	if (($b & 3) == 2) echo '<div class="sticky-sidebar sticky" data-sticky data-margin-top="0">';
}

add_action('tha_sidebars_before', 'atlatl_f6_slf_sidebars_before', 60, 0);

function atlatl_f6_slf_sidebars_after() {
	if ((atlatl_get_sidebar_bits() & 3) == 2) echo '</div>';
	echo '</div>';
}

add_action('tha_sidebars_after', 'atlatl_f6_slf_sidebars_after', 40, 0);
