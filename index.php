<?php

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();

		tha_entry_before();

		get_template_part( 'on/' . THEME_ENGINE . '/content', get_post_format() );

		tha_entry_after();
	}

	get_template_part( 'on/' . THEME_ENGINE . '/prevnext', get_post_format() );
} else {
	tha_entry_before();

	get_template_part( 'on/' . THEME_ENGINE . '/content', 'empty' );

	tha_entry_after();
}

get_sidebar();
get_footer();
