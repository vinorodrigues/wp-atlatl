<?php

// finish up the content

tha_content_bottom();
echo '</main>';
tha_content_after();

// process the 2 main sidebars, if they exist

if ((atlatl_get_sidebar_bits() & 3) != 0) {
	tha_sidebars_before();

	$j = 0;
	for ($i=1; $i <= 2; $i++) {
		$j++;
		if (is_active_sidebar( 'sidebar-' . $i )) {
			tha_sidebar_top();
			do_action( 'tha_sidebar_' . $j . '_top', array($i) );

			echo '<section id="sidebar" class="sidebar-' . $i . '">';
			dynamic_sidebar( $i );
			echo '</section>';

			do_action( 'tha_sidebar_' . $j . '_bottom', array($i) );
			tha_sidebar_bottom();
		}
	}

	tha_sidebars_after();
}
