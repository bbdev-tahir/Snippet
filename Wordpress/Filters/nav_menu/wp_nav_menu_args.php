<?php
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); 
// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}