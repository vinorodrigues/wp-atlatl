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

function tha_footer_f6_copyright() {
	echo '</div><div class="grid-x grid-padding-y align-middle">';

	echo '<div class="cell medium-10 large-5 text-center large-text-left">';
	echo apply_filters( 'atlatl_get_footer_menu', '<!-- FOOTER MENU HERE -->', 'footer' );
	echo '</div><div class="cell medium-2 text-center medium-text-right large-text-center">';
	echo '<a class="to-top" href="#" title="' . __( 'Top of Page', 'wp-atlatl' ) . '">' . apply_filters( 'atlatl_get_to_top', '&#8682;' )  . '</a>';
	echo '</div><div class="cell large-5 text-center large-text-right">';
	echo apply_filters( 'atlatl_get_copyright', '&copy; ' .  wpb_copyright_date() . ' ' . get_bloginfo('name') );
	echo '</div>';
}

add_action( 'tha_footer_bottom', 'tha_footer_f6_copyright', 40, 0 );
