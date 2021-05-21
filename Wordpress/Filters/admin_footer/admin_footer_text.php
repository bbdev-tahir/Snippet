<?php

/******************************************/
/***** Customize wordpress Footer **********/
/******************************************/
add_filter( 'update_footer', 'change_footer_version', 9999 );
function change_footer_version() {
  return '<a class="bbwp_footer_version ab-item" href="http://localhost/warraichtraders/">Link text</a>';
}


add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin () {
	echo 'Developed and Designed By <a href="https://bytebunch.com/" target="_blank">ByteBunch</a></p>';
	 
}