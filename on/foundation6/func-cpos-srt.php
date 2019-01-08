<?php

// ----- Body -----

function atlatl_f6_body_class( $classes ) {
	$classes[] = 'layout-srt';
	return $classes;
}

add_filter( 'body_class','atlatl_f6_body_class' );

// ----- Content -----

function atlatl_f6_content_before() {
	echo '<div class="cell medium-9">';
}

add_action('tha_content_before', 'atlatl_f6_content_before', 40, 0);

function atlatl_f6_content_after() {
	echo '</div>';
}

add_action('tha_content_after', 'atlatl_f6_content_after', 60, 0);

// ----- Siderbars -----


function atlatl_f6_sidebars_before() {
	echo '<div class="cell medium-3">';
}

add_action('tha_sidebars_before', 'atlatl_f6_sidebars_before', 40, 0);

function atlatl_f6_sidebars_after() {
	echo '</div>';
}

add_action('tha_sidebars_after', 'atlatl_f6_sidebars_after', 60, 0);
