<?php

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
