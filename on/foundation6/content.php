<?php
/**
 * @author Vino Rodrigues
 * @package WP-Atlarl
 * @since WP-Atlarl 0.1
 */

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

	if ($is_post) {
		$d = get_the_date();
		if (!empty($c)) {
			echo '<div class="entry-utility">';
			$h = '<a href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">';
			$h .= $d;
			$h .= '</a>';
			echo _i( 'date', $h );
			echo '</div>';
		}
	}

	if (!$is_page || !is_home()) {
		$h = $is_singular ? 'h1' : 'h2';
		echo '<' . $h . ' class="entry-title">';

		if (!$is_singular)
			echo '<a href="' . get_permalink() . '" rel="bookmark" title="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
		echo get_the_title();
		if (!$is_singular)
			echo '</a>';
		echo '</' . $h . '>';

		if ($is_post) {
			echo '<div class="entry-meta">';
			if ($is_sticky)
				echo '<span class="primary label">' . _i('star', __('Featured', 'wp-atlatl')) . '</span> ';
			foreach ($cats as $c) {
				echo '<a class="secondary label" href="' . get_category_link($c['id']) . '" title="' . $c['desc'] . '">' . _i('cat', $c['name']) . '</a> ';
			}
			echo '<span class="separator">' . _x(' ', 'separator', 'wp-atlatl') . '</span>';
			echo __('by', 'wp-atlatl') . ' ' . _i('user', get_the_author_posts_link());
			echo '</div>';

			<?php
			$el = edit_post_link( __( 'Edit', 'bootstrap2' ), '<span class="edit-link">', '</span>' );
			// todo : edit button
			?>
		}
	}

	?>
	<div class="entry-content itemtext"><?php
		tha_entry_content_before();
		the_content();
		tha_entry_content_after();
	?></div>
	<?php

	tha_entry_bottom();
	?>
</article>
<?php

if (!is_last_post()) echo apply_filters( 'the_post_separator', '<hr class="separator-hr" />' );
