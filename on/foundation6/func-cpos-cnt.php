<?php

// -----------------------------------------------------------------------------
// ----- Layout -----

/**
 * Top of <body>
 */
function atlatl_f6_body_top() {
//	global $settings;
//	echo '<pre>'; var_dump($settings); echo '</pre>';

//	echo '<div class="grid-x">';
}

add_action('tha_body_top', 'atlatl_f6_body_top', 50, 0);

/**
 * Bottom of <body>
 */
function atlatl_f6_body_bottom() {
//	echo '</div><!-- grid-x -->';
}

add_action('tha_body_bottom', 'atlatl_f6_body_bottom', 50, 0);
