<?php

/**
 * Before <html>
 */
function wpf6_html_before() {
	echo '<!doctype html>';
}
add_action('tha_html_before', 'wpf6_html_before', 50, 0);

/**
 * Top of <head>
 */
function wpf6_head_top() {
	echo '<meta http-equiv="x-ua-compatible" content="ie=edge" />'.PHP_EOL;
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0" />'.PHP_EOL;
}
add_action('tha_head_top', 'wpf6_head_top', 50, 0);

/**
 * Top of <body>
 */
function wpf6_body_top() {
	echo '<div class="wrapper">';
}
add_action('tha_body_top', 'wpf6_body_top', 50, 0);

/**
 * Bottom of <body>
 */
function wpf6_body_bottom() {
	echo '</div>';
}
add_action('tha_body_bottom', 'wpf6_body_bottom', 50, 0);
