<?php

get_header();

if (have_posts()) {
	$post_format = get_post_format();

	while (have_posts()) {
		the_post();

		tha_entry_before();

		get_template_part( 'on/' . THEME_ENGINE . '/content', $post_format );

		tha_entry_after();
	}

	get_template_part( 'on/' . THEME_ENGINE . '/pagenav', $post_format );
} else {
	tha_entry_before();

	get_template_part( 'on/' . THEME_ENGINE . '/content', 'none' );

	tha_entry_after();
}

get_sidebar();
get_footer();
