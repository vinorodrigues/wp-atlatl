<?php

/**
 * Footer-bar Layouts dependant on population of widgets.  (11 combinations)
 *
 * [1] [2] [3] [4] [5] [6] [7] [8] [9] [A] [B] [C]   Active footer-bars       i
 * ------------------------------------------------+------------------------+----
 * [111111111111111111111111111111111111111111111]   1  or  2  or  3  or  4   0
 * [111111111111111111111] [222222222222222222222]   1 & 2  or  3 & 4         1
 * [11111111111111111111111111111] [3333333333333]   1 & 3                    2
 * [111111111111111111111111111111111] [444444444]   1 & 4                    3
 * [1111111111111] [2222222222222] [3333333333333]   1 & 2 & 3                4
 * [111111111] [222222222222222222222] [444444444]   1 & 2 & 4                5
 * [111111111111111111111] [333333333] [444444444]   1 & 3 & 4                6
 * [111111111] [222222222] [333333333] [444444444]   1 & 2 & 3 & 4            7
 * [2222222222222] [33333333333333333333333333333]   2 & 3                    8
 * [222222222] [444444444444444444444444444444444]   2 & 4                    9
 * [222222222] [333333333] [444444444444444444444]   2 & 3 & 4                10
 * ------------------------------------------------+------------------------+----
 * [1] [2] [3] [4] [5] [6] [7] [8] [9] [A] [B] [C]
 */

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

// Get ACTIVE sidebars
$fpos = '';
$fsbr = array();
$cnt = atlatl_get_sidebar_bits();
if (($cnt & 8) != 0) { $fpos .= '1'; $fsbr[] = 4; }  // this should be in a for loop with << masking
if (($cnt & 16) != 0) { $fpos .= '2'; $fsbr[] = 5; }
if (($cnt & 32) != 0) { $fpos .= '3'; $fsbr[] = 6; }
if (($cnt & 64) != 0) { $fpos .= '4'; $fsbr[] = 7; }

switch ($fpos) {
	case '12':
	case '34': $idx = 1; break;
	case '13': $idx = 2; break;
	case '14': $idx = 3; break;
	case '123': $idx = 4; break;
	case '124': $idx = 5; break;
	case '134': $idx = 6; break;
	case '1234': $idx = 7; break;
	case '23': $idx = 8; break;
	case '24': $idx = 9; break;
	case '234': $idx = 10; break;
	default: $idx = 0; break;
}

// ----- code -----

tha_footer_before();

if (count($fsbr) > 0) {
	echo '<footer>' . PHP_EOL;
	tha_footer_top();

	echo '<div class="footer grid-x grid-padding-x grid-padding-y">';

	for ($i=0; $i < count($fsbr); $i++) {
		echo '<div class="footer-' . ($fsbr[$i] - 3) . ' cell ' . $footer_classes[$idx][$i] . '">';

		dynamic_sidebar( 'sidebar-' . $fsbr[$i] );

		echo '</div>';
	}

	echo '</div>';

	tha_footer_bottom();
	echo '</footer>' . PHP_EOL;
}
tha_footer_after();

tha_body_bottom();
echo PHP_EOL . '<div id="wp-footer" class="hidden" hidden>' . PHP_EOL;
wp_footer();
echo '</div>' . PHP_EOL;
echo '</body>' . PHP_EOL;
echo '</html>' . PHP_EOL;
