<?php

function icon($key) {
	static $keys = array(
		// ----- ABCDEFGHIJKLMNOPQRSTUVWXYZ -----
		'alert'       => 0x26A0,
		'cat'         => 0x1F4C1,
		'date'        => 0x1F4C5,
		'info'        => 0x1F6C8,
		'login'       => 0x1F512,
		'more'        => 0x25B6,
		'next'        => 0x25BA,
		'no-comments' => 0x1F4AC,
		'n-comments'  => 0x1F4AC,
		'one-comment' => 0x1F4AC,
		'post-edit'   => 0x270E,
		'prev'        => 0x25C4,
		'reply'       => 0x293E,
		'search'      => 0x1F50D,
		'star'        => 0x2605,
		'tag'         => 0x1F516,
		'user'        => 0x1F9D1,
		);

	$k = array_key_exists($key, $keys) ? $keys[$key] : null;
	if (!is_null($k))
		return '<b class="uico">&#' . $k . ';</b>';
	else
		return '';
}
