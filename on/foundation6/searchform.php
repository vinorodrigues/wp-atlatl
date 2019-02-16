<?php

global $is_search_form;
if (!isset($is_search_form)) $is_search_form = false;

?>
<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<?php if ($is_search_form) : ?><span class="input-group-label"><?= icon('search') ?></span><?php endif; ?>
		<input
			class="input-group-field"
			type="search"
			placeholder="<?php echo esc_attr( _x('Search…', 'placeholder', 'wp-atlatl'), 'presentation' ); ?>"
			name="s"
			id="search-input"
			value="<?php echo esc_attr( get_search_query() ); ?>" />
		<div class="input-group-button">
			<button type="submit" class="button"><?php
				if ($is_search_form) {
					echo _x('Search', 'button', 'wp-atlatl');
				} else {
					echo icon('search');
				}
			?></button>
		</div>
    </div>
</form>
