<?php  
//Disable plugins update
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );