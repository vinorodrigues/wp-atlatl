<?php

// -----------------------------------------------------------------------------
// ----- Layout -----

/**
 * Top of <body>
 */
function atlatl_f6_wdth_body_top() {
	global $settings;
	$wdt = $settings['container_width'];
	switch ($wdt) {
		case 'fld':
			$class = 'grid-container fluid';
			break;
		default:
			$class = 'grid-container';
			break;
	}

	echo '<div class="wrapper ' . $class . '">';
}

add_action('tha_body_top', 'atlatl_f6_wdth_body_top', 45, 0);

/**
 * Bottom of <body>
 */
function atlatl_f6_wdth_body_bottom() {
	echo '</div><!-- grid-container -->';
}

add_action('tha_body_bottom', 'atlatl_f6_wdth_body_bottom', 55, 0);
