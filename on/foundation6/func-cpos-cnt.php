<?php

// ----- Body -----

function atlatl_f6_body_class( $classes ) {
	$classes[] = 'layout-cnt';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_body_class' );

// ----- Content -----

function atlatl_f6_content_before() {
	echo '<div class="cell medium-6 medium-order-2">';
}

add_action('tha_content_before', 'atlatl_f6_content_before', 40, 0);

function atlatl_f6_content_after() {
	echo '</div>';
}

add_action('tha_content_after', 'atlatl_f6_content_after', 60, 0);

// ----- Siderbars -----

function atlatl_f6_sidebar_1_top() {
	echo '<div class="cell medium-3 medium-order-1">';
}

add_action('tha_sidebar_1_top', 'atlatl_f6_sidebar_1_top', 40, 0);

function atlatl_f6_sidebar_2_top() {
	echo '<div class="cell medium-3 medium-order-3">';
}

add_action('tha_sidebar_2_top', 'atlatl_f6_sidebar_2_top', 40, 0);

function atlatl_f6_sidebar_bottom() {
	echo '</div>';
}

add_action('tha_sidebar_bottom', 'atlatl_f6_sidebar_bottom', 60, 0);
