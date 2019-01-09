<?php

// finish up the content

tha_content_bottom();
echo '</main>';
tha_content_after();

// process the 2 main sidebars, if they exist

if ((atlatl_get_sidebar_bits() & 3) != 0) {
	tha_sidebars_before();

	for ($i=1; $i <= 2; $i++)
		if (is_active_sidebar( 'sidebar-' . $i )) {
			tha_sidebar_top();
			do_action( 'tha_sidebar_' . $i . '_top');

			echo '<section id="sidebar" class="sidebar-' . $i . '">';
			dynamic_sidebar( 'sidebar-' . $i );
			echo '</section>';

			do_action( 'tha_sidebar_' . $i . '_bottom');
			tha_sidebar_bottom();
		}

	tha_sidebars_after();
}
