<?php
/*
Shortcode: email
*/

$content = $arguments['address'];
if ( !is_emain($content) ) {
    return;
}

return '<a href="mailto:' . antispambot($content) . '">' . antispambot($content) . '</a>';
