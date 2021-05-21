<?php 
/******************************************/
/***** remove_menu_page from wp admin **********/
/******************************************/
function custom_menu_page_removing() {
	remove_menu_page( 'index.php' );//Dashboard
}
add_action( 'admin_menu', 'custom_menu_page_removing' );