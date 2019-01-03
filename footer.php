<?php

tha_footer_before();
echo '<footer>' . PHP_EOL;
tha_footer_top();

// do something here ...

tha_footer_bottom();
echo '</footer>' . PHP_EOL;
tha_footer_after();

tha_body_bottom();
echo PHP_EOL . '<span id="wp-footer" class="hidden" hidden>' . PHP_EOL;
wp_footer();
echo '</span>' . PHP_EOL;
echo '</body>' . PHP_EOL;
echo '</html>' . PHP_EOL;
