<?php
/******************************************/
/***** get_current_loggedin_user_role **********/
/******************************************/
if(!function_exists("get_user_role")){
  function get_user_role($current = true) {
    if($current === true && is_user_logged_in()){
      global $current_user;

    	$user_roles = $current_user->roles;
    	$user_role = array_shift($user_roles);

    	return $user_role;
    }
    else
      return false;
  }
}
