<?php

tha_html_before();
echo '<html ';  language_attributes();  echo '>'.PHP_EOL;

echo '<head>'.PHP_EOL;
echo '<meta charset="';  bloginfo('charset');  echo '">'.PHP_EOL;
tha_head_top();
echo '<title>';  wp_title();  echo '</title>'.PHP_EOL;
wp_head();
echo '<link rel="stylesheet" href="';  bloginfo('stylesheet_url');  echo '">'.PHP_EOL;
// echo '<link rel="pingback" href="';  bloginfo('pingback_url');  echo '">'.PHP_EOL;
tha_head_bottom();
echo '</head>'.PHP_EOL;

echo '<body ';  body_class();  echo '>'.PHP_EOL;
tha_body_top();

function atlatl_do_header($class = '') {
	tha_header_before();
	echo '<header id="header"';  if (!empty($class)) echo ' class="'.$class.'"';  echo '>';
	tha_header_top();
	tha_header_bottom();
	echo '</header>';
	tha_header_after();
}

function atlatl_do_nav($class = '') {
	tha_nav_before();
	echo '<nav';  if (!empty($class)) echo ' class="'.$class.'"';  echo '>';
	tha_nav_top();
	tha_nav_bottom();
	echo '</nav>';
	tha_nav_after();
}

atlatl_do_header();
atlatl_do_nav();

tha_content_before();
echo '<main id="content">';
tha_content_top();
