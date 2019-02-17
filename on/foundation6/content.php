<?php
/**
 * @author Vino Rodrigues
 * @package WP-Atlarl
 * @since WP-Atlarl 0.1
 */

global $post;

$is_page = is_page();  // Determines whether the query is for an existing single page.
$is_single = is_single();  // Determines whether the query is for an existing single post.
$is_singular = is_singular();  // Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
$is_attachment = is_attachment();  // Determines whether the query is for an existing attachment page.
$is_post = !$is_page && !$is_attachment;
$is_sticky = is_sticky();

$classes = get_post_class('hentry');

// if ($is_page) $classes[] = 'page';
// if ($is_attachment) $classes[] = 'attachment';
if ($is_sticky) {
	if ($is_singular) $classes[] = 'sticky-single';
	else $classes[] = 'sticky-list';
}

$tags = wp_get_post_tags( $post->ID );
foreach ($tags as $tag)
	$classes[] = 'tag-' . $tag->slug;

$pcats = wp_get_post_categories( $post->ID );
$cats = array();
foreach ($pcats as $c) {
	$cat = get_category( $c );
	$cats[] = array(
		'id' => $c,
		'name' => $cat->name,
		// 'slug' => $cat->slug,
		'desc' => $cat->description,
		);
}

?>
<article class="<?= implode(' ', $classes) ?>" id="post-<?= $post->ID ?>">
	<?php
	tha_entry_top();

	if (!$is_page || !is_front_page()) {
		// Heading
		$h = $is_singular ? 'h1' : 'h2';
		echo '<' . $h . ' class="entry-title">';

		if (!$is_singular)
			echo '<a href="' . get_permalink() . '" rel="bookmark" title="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
		echo get_the_title();
		if (!$is_singular)
			echo '</a>';
		echo '</' . $h . '>';

		// Post meta - at the top
		if (!$is_page) atlatl_f6_post_meta( $post->ID );
	}

	// Content
	if (is_search() || is_category() || is_archive()) {
		?><div class="entry-summary itemtext"><?php
		tha_entry_content_before();
		the_excerpt();
		tha_entry_content_after();
		?></div><?php
	} else {
		?><div class="entry-content itemtext"><?php
		tha_entry_content_before();
		the_content();
		tha_entry_content_after();
		?></div><?php
	}

	// page links
	$pagi = atlatl_f6_link_pages();
	if (!empty($pagi)) {
		echo '<nav>' . $pagi . '</nav>';
	}

	// Post meta - at the bottom
	if ($is_singular && (!$is_page && !is_home()))
		atlatl_f6_post_meta( $post->ID, false );

	// Pagination
	if ($is_singular && !$is_page) {
		$prev = get_previous_post_link('%link', '%title');
		$next = get_next_post_link('%link', '%title');
		if ($prev || $next) {
			echo '<nav><ul class="pagination text-center">';
			if ($prev) echo '<li class="pagination-previous">' . $prev . '</li>';
			if ($next) echo '<li class="pagination-next">' . $next . '</li>';
			echo '</ul></nav>';
		}
	}

	tha_entry_bottom();
	?>
</article>

<?php

if (!is_last_post()) echo apply_filters( 'the_post_separator', '<hr class="soft">' );
