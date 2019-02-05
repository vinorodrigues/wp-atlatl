<?php

function icon($key) {

	static $keys = array(
		'user' => 0x1F9D1,
		'cat'  => 0x1F5D2,
		'star' => 0x2605,
		'date' => 0x1F4C5,
		'next' => 0x25BA,
		'prev' => 0x25C4,
		);

	$k = array_key_exists($key, $keys) ? $keys[$key] : null;
	if (!is_null($k))
		return '<small>&#' . $k . ';</small>';
	else
		return '';
}
