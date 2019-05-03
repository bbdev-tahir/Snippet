<?php
/*------------------------------------*\
	Filter to change "current-menu-item" class to bootstrap 4 "active" class. 
\*------------------------------------*/
add_filter('nav_menu_css_class' , 'icg_nav_class' , 10 , 4);
function icg_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}