<?php

if ( !defined('FOUNDATION_VERSION') )
	define('FOUNDATION_VERSION', '6.5.1');

// ----------------------------------------------------------------------------
// ----- HTML -----

/**
 * Before <html>
 */
function atlatl_f6_html_before() {
	echo '<!doctype html>' . PHP_EOL;
}

add_action('tha_html_before', 'atlatl_f6_html_before', 5, 0);

/**
 * Top of <head>
 */
function atlatl_f6_head_top() {
	echo '<meta http-equiv="x-ua-compatible" content="ie=edge"></meta>' . PHP_EOL;
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"></meta>' . PHP_EOL;
}

add_action('tha_head_top', 'atlatl_f6_head_top', 5, 0);

// ----- Helper actions -----

function atlatl_f6_end_1_div() {
	echo '</div>';
}

function atlatl_f6_end_2_divs() {
	echo '</div></div>';
}

function atlatl_f6_end_3_divs() {
	echo '</div></div></div>';
}

// ----------------------------------------------------------------------------
// ----- Layout -----

function atlatl_f6_wp_loaded() {
	include_once( 'class-wp-foundation6-nav-menu.php' );
	include_once( 'func-cont-' . atlatl_get_setting( 'container_position' ) . '.php' );
	$pos = atlatl_get_content_position();
	include_once( 'func-cpos-' . $pos . '.php' );
	include_once( 'func-header.php' );
	include_once( 'func-menus.php' );
	include_once( 'func-footer.php' );

	if (is_admin_bar_showing() &&
		((atlatl_get_sidebar_bits() & 3) == 2) &&  // only sidebar-2 showing
		(($cpos == 'slf') || ($cpos == 'srt')))  // stacked layouts only
		ts_enqueue_style( 'admin-bar-sticky',
			// 'body { background-color: red; }' . PHP_EOL .
			'.admin-bar .sticky-sidebar.is-stuck {' . PHP_EOL .
			'  padding-top: 32px !important;' . PHP_EOL .
			' }' . PHP_EOL .
			'@media screen and (maxwidth-width: 782px) {' . PHP_EOL .
			'  .admin-bar .sticky-sidebar.is-stuck {' . PHP_EOL .
			'    padding-top: 46px !important;' . PHP_EOL .
			'  }' . PHP_EOL .
			'}' . PHP_EOL,
			array(),
			'screen' );
}

add_action('wp_loaded', 'atlatl_f6_wp_loaded', 60);

// function atlatl_f6_setup_theme() {
// 	register_nav_menus( array(
// 		) );
// }

// add_action( 'after_setup_theme', 'atlatl_f6_setup_theme', 60 );


// ----------------------------------------------------------------------------
// ----- Scripts -----

/**
 * Scripts
 */
function atlatl_f6_scripts() {
	$th_ver = (defined('WP_DEBUG') && WP_DEBUG) ? GUID() : wp_get_theme()->version;

	// CSS

	$url = '';  // TODO : Foundation form CDN
	if (empty($url)) {
		$ver = FOUNDATION_VERSION;
		$url = get_theme_file_uri( '/on/foundation6/css/foundation' . DOTMIN . '.css' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_style( 'foundation',
		$url,
		array(),
		$ver );

	wp_enqueue_style( 'f6-style',
		get_theme_file_uri( '/on/foundation6/css/style' . DOTMIN . '.css' ),
		array('foundation'),
		$th_ver );

	// JavaScript

	$url = '';  // TODO : Foundation form CDN
	if (empty($url)) {
		$ver = FOUNDATION_VERSION;
		$url = get_theme_file_uri( '/on/foundation6/js/foundation' . DOTMIN . '.js' );
	} else {
		$ver = NULL;
	}
	wp_enqueue_script( 'foundation',
		$url,
		array('jquery'),
		$ver,
		true );

	ts_enqueue_script( 'init-foundation',
		"(function ( $ ) {\n\t$(document).foundation();\n}( jQuery ));" );
}

add_action('wp_enqueue_scripts', 'atlatl_f6_scripts', 60);

// ----------------------------------------------------------------------------
// ----- Theming -----

function atlatl_f6_more_link($more_link_element, $more_link_text) {
	return '<a href="' . get_permalink( get_the_ID() ) . '" class="more-link">' .
		_i('more', 'Read More', false) . '</a>';
}

add_filter('the_content_more_link', 'atlatl_f6_more_link', 10, 2);

function atlatl_f6_excerpt_more($more) {
	if ( ! is_single() ) {
		$link = '<a href="' . get_permalink( get_the_ID() ) . '" class="excerpt-more">' .
			_i('more', 'Read More', false) . '</a>';
		$more = sprintf( _x('&hellip; %s', 'excerpt-more', 'wp-atlatl'), $link );
	}
	return $more;
}

add_filter('excerpt_more', 'atlatl_f6_excerpt_more');

function atlatl_f6_edit_post_link($link, $id, $text) {
	if (!empty($link)) {
		$link = '<span class="separator">' . _x(' | ', 'separator', 'wp-atlatl') . '</span>';
		$link .= '<a class="tiny warning button post-edit-link" href="' . esc_url( get_edit_post_link($id) ) . '">' . _i('post-edit', $text) . '</a>';
	}

	return $link;
}

add_filter('edit_post_link', 'atlatl_f6_edit_post_link', 10, 3);

function atlatl_f6_comment_reply_link( $link, $args, $comment, $post ) {
	return str_replace(
		array('comment-reply-link', 'comment-reply-login'),
		array('tiny secondary button comment-reply-link', 'tiny secondary button comment-reply-login'),
		str_replace("'", '"', $link));
}

add_filter( 'comment_reply_link', 'atlatl_f6_comment_reply_link', 10, 4 );

function atlatl_f6_post_meta($id, $is_top = true) {
	global $authordata;
	global $wp_rewrite;

	echo '<div class="entry-meta ' . ($is_top ? 'top' : 'bottom') . '"><ul class="simple menu icons icon-left">';

	// --- sticky ---
	if (is_sticky($id) && $is_top)
		echo '<li class="primary label">' . icon('star') . ' <span>' . __('Featured', 'wp-atlatl') . '</span></li>';

	// --- author ---
	if ( is_object( $authordata ) ) {
		$uid = get_the_author_meta('ID');
		if ( get_option('show_avatars') && ($uid > 0) ) {
			$avatar = get_avatar( $uid, 16, '', get_the_author_meta('nickname'), array('class' => 'avatar-icon') );
		} else {
			$avatar = icon('user');
		}

		$url = esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) );
		/* translators: %s: author's display name */
		$title = esc_attr( sprintf( __( 'Posts by %s', 'wp-atlatl' ), get_the_author() ) );
		echo '<li><a href="' . $url . '" title="' . $title . '"  rel="author">' . $avatar . ' <span>' . get_the_author() . '</span></a></li>';
	}

	// --- date ---
	$date = get_the_date();
	if (!empty($date)) {
		echo '<li><a href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">';
		echo icon('date');
		echo ' <span>' . $date . '</span></a></li>';
	}

	// --- categories ---
	$categories = get_the_category( $id );
	if ( !empty($categories) ) {
		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

		foreach ( $categories as $category ) {
			echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>';
			echo icon('cat');
			echo ' <span>';
			echo $category->name;
			echo '</span></a></li>';
		}
	} /* else {
		echo '<li>' . icon('cat') . ' <span>' . __( 'Uncategorized' ) . '</span></a></li>';
	} */

	// --- tags ---
	$tags = get_the_terms( $id, 'post_tag' );

	if ( !empty($tags) ) {
		foreach ( $tags as $tag ) {
			echo '<li><a href="' . esc_url( get_term_link( $tag, 'post_tag' ) ) . '" rel="tag">';
			echo icon('tag');
			echo ' <span>';
			echo $tag->name;
			echo '</span></a></li>';
		}
	}

	// --- comments ---
	/*
	if ( comments_open() || '0' != get_comments_number() ) {
		?><div class="entry-footer"><?php
		comments_popup_link(
			_i('no-comments', 'No Comments'),
			_i('one-comment', '1 Comment'),
			_i('n-nomments', '% Comments') );
		?></div><?php
	}
	*/

	// --- edit ---
	if ($url = esc_url( get_edit_post_link( $id ) ))
		echo '<li><a href="' . $url . '">' . icon('post-edit') . ' <span>' . _x('Edit', 'Post', 'wp-atlatl') . '</span></a></li>';

	echo '</ul></div>';
}

function atlatl_f6_pagination_bar() {
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

	$r = '<ul class="pagination text-center" role="navigation">';
	foreach ($pagi as $p) {
		switch ($p[2]) {
			case 'p' :
			case 'n' :
			case 'l' :
				if (is_null($p[1]))
					$r .= '<li class="disabled">' . $p[0] . '</li>';
				else
					$r .= '<li><a href="' . $p[1] . '">' . $p[0] . '</a></li>';
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

function atlatl_f6_link_pages() {
	$pagl = atlatl_link_pages(array(
		'pagelink' => __('Page %', 'wp-atlatl'),
		// 'next_or_number' => 'next',
		));
	$r = '';
	if (!empty($pagl)) {
		$r .= '<ul class="pagination text-center" role="navigation">';
		foreach ($pagl as $p) {
			switch ($p[2]) {
				case 'p' : $c = 'pagination-previous'; break;
				case 'n' : $c = 'pagination-next'; break;
				default : $c = ''; break;
			}
			if (is_null($p[1])) $c = (('' == $c) ? '' : $c . ' ') . 'disabled';
			switch ($p[2]) {
				case 'p' :
				case 'n' :
				case 'l' :
					$r .= '<li';
					if ('' != $c) $r .= ' class="' . $c . '"';
					$r .= '>';
					if (!is_null($p[1])) $r .= '<a href="' . $p[1] . '">';
					$r .= $p[0];
					if (!is_null($p[1])) $r .= '</a>';
					$r .= '</li>';
					break;
				case 'c' :
					$r .= '<li class="current">' . $p[0] . '</li>';
					break;
			}
		}
		$r .= '</ul>';
	}
	return $r;
}

function atlatl_f6_password_form() {
	global $post;

	ob_start();
	?><form action="<?= esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) ?>" method="post">
	<p><?= icon('info') ?> <?= __( 'This content is password protected. To view it please enter your password below:' ) ?></p>
	<div class="input-group">
		<span class="input-group-label"><?= icon('login') ?></span>
		<input class="input-group-field" name="post_password" id="password" type="password" placeholder="<?= esc_attr__('Password', 'wp-atlatl') ?>" size="20" required>
		<div class="input-group-button">
			<input type="submit" class="button" name="Submit" value="<?= esc_attr_x('Enter', 'post password form', 'wp-atlatl') ?>">
		</div>
	</div></form><?php

	// ' . __( "This post is password protected. To view it please enter your password below: or add custom message" ) . '
	// <label for="Email">' . __( "Email:" ) . ' </label><input name="Email" type="text" size="20" required />
	// <label for="password">' . __( "Password:" ) . ' </label><input type="password" size="20" required/>
	// <input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />

	return ob_get_clean();
}

add_filter( 'the_password_form', 'atlatl_f6_password_form' );
