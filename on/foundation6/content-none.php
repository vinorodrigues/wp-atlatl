<?php

if (is_404()) {
	?><div class="callout alert" data-closable="hide">
	<h1><?= _i('alert', 'Oops') ?></h1>
	<p><?= __('We can\'t seem to find the content you\'re looking for.', 'wp-atlatl') ?></p>
	<p><small><?= sprintf( __('Error code: %d'), 404) ?></small></p>
	<button class="close-button" type="button" data-close><span aria-hidden="true">&times;</span></button>
	</div><?php
} else {
	?><p><?= icon('info') ?> <?= __('We can\'t seem to find the content you\'re looking for.', 'wp-atlatl') ?></p>
	<hr class="soft"><?php
}

?><h3><?= __('Search this site', 'wp-atlatl') ?></h3><?php

global $is_search_form;
$is_search_form = true;
get_search_form();
$is_search_form = false;
