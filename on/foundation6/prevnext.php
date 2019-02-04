<?php

function atlatl_pagination_bar() {
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;

	if ($total_pages <= 0) return '';

	$current_page = max(1, get_query_var('paged'));

	$args = array(
		// 'base' => get_pagenum_link(1) . '%_%',
		// 'format' => '/page/%#%',
		'total' => $total_pages,
		'current' => $current_page,
		'end_size' => 2,
		'mid_size' => 2,
		'type' => 'array',
		);
	if (is_archive() || (is_front_page() && is_home())) {
		$args['next_text'] = _i( 'next', _x('Older', 'pagination', 'wp-atlatl'), false);
		$args['prev_text'] = _i( 'prev', _x('Newer', 'pagination', 'wp-atlatl'));
	} else {
		$args['next_text'] = _i( 'next', _x('Next', 'pagination', 'wp-atlatl'), false);
		$args['prev_text'] = _i( 'prev', _x('Previous', 'pagination', 'wp-atlatl'));
	}

	$pagi = atlatl_paginate_links( $args );

	if (empty($pagi)) return '';

	$r = '<ul class="pagination" role="navigation">';
	foreach ($pagi as $p) {
		switch ($p[2]) {
			case 'p' :
			case 'n' :
			case 'l' :
				$r .= '<li';
				if (is_null($p[1])) $r .= ' class="disabled"';
				$r .= '>';
				if (!is_null($p[1])) $r .= '<a href="' . $p[1] . '">';
				$r .= $p[0];
				if (!is_null($p[1])) $r .= '</a>';
				$r .= '</li>';
				break;
			case 'c' :
				$r .= '<li class="current">' . $p[0] . '</li>';
				break;
			case 'e' :
				$r .= '<li class="ellipsis"></li>';
				break;
		}
	}
	$r .= '</ul>';

	return $r;
}

$pagi = atlatl_pagination_bar();
if (!empty($pagi)) {
	echo '<hr class="entry-hr">';

	echo '<nav class="float-center text-center">' . $pagi . '</nav>';
}
