<?php

function atlatl_f6_get_header() {
	$out = '';
	$out .= '<div id="header">';
	$out .= ' <div id="headerimg">';
	$out .= '   <h1 class="site-title">';
	$out .= '     <a href="' . get_option('home') . '">';
	$out .= get_bloginfo('name');
	$out .= '     </a>';
	$out .= '   </h1>';
	$out .= ' <div class="description">';
	$out .= get_bloginfo('description');
	$out .= '  </div>';
	$out .= ' </div>';
	$out .= '</div>';
	return $out;
}

add_filter( 'atlatl_get_header', 'atlatl_f6_get_header' );
