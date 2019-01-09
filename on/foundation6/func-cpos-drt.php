<?php

// ----- Body -----

function atlatl_f6_body_class( $classes ) {
	$classes[] = 'layout-drt';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_body_class' );

// ----- Content -----

function atlatl_f6_content_before() {
	echo '<div class="cell large-6 medium-8">';
}

add_action('tha_content_before', 'atlatl_f6_content_before', 40, 0);

function atlatl_f6_content_after() {
	echo '</div>';
}

add_action('tha_content_after', 'atlatl_f6_content_after', 60, 0);

// ----- Siderbars -----


function atlatl_f6_sidebar_1_top() {
	echo '<div class="cell large-6 medium-4">';
	echo '<div class="grid-x grid-padding-x">';
	echo '<div class="cell large-6">';
}

add_action('tha_sidebar_1_top', 'atlatl_f6_sidebar_1_top', 40, 0);

function atlatl_f6_sidebar_2_top() {
	echo '<div class="cell large-6">';
}

add_action('tha_sidebar_2_top', 'atlatl_f6_sidebar_2_top', 40, 0);

function atlatl_f6_sidebar_1_bottom() {
	echo '</div>';
}

add_action('tha_sidebar_1_bottom', 'atlatl_f6_sidebar_1_bottom', 60, 0);

function atlatl_f6_sidebar_2_bottom() {
	echo '</div>';
	echo '</div>';
	echo '</div>';
}

add_action('tha_sidebar_2_bottom', 'atlatl_f6_sidebar_2_bottom', 60, 0);
