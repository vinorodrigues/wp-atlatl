<?php
$pagi = atlatl_f6_pagination_bar();
if (!empty($pagi)) {
	echo '<hr class="soft">';
	echo '<nav>' . $pagi . '</nav>';
}
