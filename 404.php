<?php

get_header();

tha_entry_before();

get_template_part( 'on/' . THEME_ENGINE . '/content', 'empty' );

tha_entry_after();

get_sidebar();
get_footer();
