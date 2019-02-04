<?php

tha_html_before();
echo '<html ';  language_attributes();  echo '>'.PHP_EOL;

echo '<head>'.PHP_EOL;
echo '<meta charset="';  bloginfo('charset');  echo '">'.PHP_EOL;
tha_head_top();

// echo '<title>';  wp_title();  echo '</title>'.PHP_EOL;    // TODO : Add, Generate own title tag
wp_head();

tha_head_bottom();
echo '</head>'.PHP_EOL;

echo '<body ';  body_class();  echo '>'.PHP_EOL;
tha_body_top();

function atlatl_do_header($class = '') {
	tha_header_before();
	echo '<header id="masthead"';  if (!empty($class)) echo ' class="'.$class.'"';  echo '>';
	tha_header_top();

	echo apply_filters( 'atlatl_get_header', '<!-- DO HEADER HERE -->' );

	tha_header_bottom();
	echo '</header>';
	tha_header_after();
}

function atlatl_do_nav($class = '') {
	if (has_nav_menu('primary')) {
		tha_nav_before();
		echo '<nav id="nav-bar"';  if (!empty($class)) echo ' class="'.$class.'"';  echo '>';
		tha_nav_top();

		echo apply_filters( 'atlatl_get_nav', '<!-- DO NAV HERE -->', 'primary' );

		tha_nav_bottom();
		echo '</nav>';
		tha_nav_after();
	}
}

atlatl_do_header( apply_filters( 'atlatl_header_class', 'site-header' ) );
atlatl_do_nav( apply_filters( 'atlatl_nav_class', '' ) );

tha_container_before();
tha_container_top();

tha_content_before();
echo '<main>';
tha_content_top();
