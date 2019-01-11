<?php

function debug_tha_hook() {
	$e = new Exception();
	$trace = explode("\n", $e->getTraceAsString());
	echo "<!-- " . explode(': ', $trace[4])[1] . ' -->';
}

add_action( 'tha_html_before'         , 'debug_tha_hook' );
add_action( 'tha_head_top'            , 'debug_tha_hook', 9 );
add_action( 'tha_head_bottom'         , 'debug_tha_hook', 99 );
add_action( 'tha_body_top'            , 'debug_tha_hook', 9 );
add_action( 'tha_body_bottom'         , 'debug_tha_hook', 99 );
add_action( 'tha_header_before'       , 'debug_tha_hook', 9 );
add_action( 'tha_header_after'        , 'debug_tha_hook', 99 );
add_action( 'tha_header_top'          , 'debug_tha_hook', 9 );
add_action( 'tha_header_bottom'       , 'debug_tha_hook', 99 );
add_action( 'tha_nav_before'          , 'debug_tha_hook', 9 );
add_action( 'tha_nav_after'           , 'debug_tha_hook', 99 );
add_action( 'tha_nav_top'             , 'debug_tha_hook', 9 );
add_action( 'tha_nav_bottom'          , 'debug_tha_hook', 99 );
add_action( 'tha_container_before'         , 'debug_tha_hook', 9 );
add_action( 'tha_container_after'          , 'debug_tha_hook', 99 );
add_action( 'tha_container_top'            , 'debug_tha_hook', 9 );
add_action( 'tha_container_bottom'         , 'debug_tha_hook', 99 );
add_action( 'tha_content_before'      , 'debug_tha_hook', 9 );
add_action( 'tha_content_after'       , 'debug_tha_hook', 99 );
add_action( 'tha_content_top'         , 'debug_tha_hook', 9 );
add_action( 'tha_content_bottom'      , 'debug_tha_hook', 99 );
add_action( 'tha_content_while_before', 'debug_tha_hook', 9 );
add_action( 'tha_content_while_after' , 'debug_tha_hook', 99 );
add_action( 'tha_entry_before'        , 'debug_tha_hook', 9 );
add_action( 'tha_entry_after'         , 'debug_tha_hook', 99 );
add_action( 'tha_entry_content_before', 'debug_tha_hook', 9 );
add_action( 'tha_entry_content_after' , 'debug_tha_hook', 99 );
add_action( 'tha_entry_top'           , 'debug_tha_hook', 9 );
add_action( 'tha_entry_bottom'        , 'debug_tha_hook', 99 );
add_action( 'tha_comments_before'     , 'debug_tha_hook', 9 );
add_action( 'tha_comments_after'      , 'debug_tha_hook', 99 );
add_action( 'tha_sidebars_before'     , 'debug_tha_hook', 9 );
add_action( 'tha_sidebars_after'      , 'debug_tha_hook', 99 );
add_action( 'tha_sidebar_top'         , 'debug_tha_hook', 9 );
add_action( 'tha_sidebar_bottom'      , 'debug_tha_hook', 99 );
add_action( 'tha_footer_before'       , 'debug_tha_hook', 9 );
add_action( 'tha_footer_after'        , 'debug_tha_hook', 99 );
add_action( 'tha_footer_top'          , 'debug_tha_hook', 9 );
add_action( 'tha_footer_bottom'       , 'debug_tha_hook', 99 );

function disable_wp_emojicons() {
	remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'embed_head',          'print_emoji_detection_script' );
	remove_action( 'wp_print_styles',     'print_emoji_styles' );
	remove_action( 'admin_print_styles',  'print_emoji_styles' );

	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}

add_action( 'init', 'disable_wp_emojicons', 999 );

// https://stackoverflow.com/questions/38693992/notice-ob-end-flush-failed-to-send-buffer-of-zlib-output-compression-1-in
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
