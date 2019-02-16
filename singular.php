<?php

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();

		tha_entry_before();

		$pf = get_post_format();
		if (false === $pf) $pf = 'singular';
		get_template_part( 'on/' . THEME_ENGINE . '/content', $pf );

		tha_entry_after();

		// if ( comments_open() || 0 != intval(get_comments_number()) ) {
		// 	comments_template( '/on/' . THEME_ENGINE . '/comments.php', true );
		// }
	}

	get_template_part( 'on/' . THEME_ENGINE . '/prevnext', $pf );
}

get_sidebar();
get_footer();
