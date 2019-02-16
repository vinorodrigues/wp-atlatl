<?php

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();

		tha_entry_before();

		$pf = get_post_format();
		get_template_part( 'on/' . THEME_ENGINE . '/content', $pf );

		tha_entry_after();
	}

	$pf = '';
	get_template_part( 'on/' . THEME_ENGINE . '/prevnext', $pf );
} else {
	tha_entry_before();

	get_template_part( 'on/' . THEME_ENGINE . '/content', 'search' );

	tha_entry_after();
}

get_sidebar();
get_footer();
