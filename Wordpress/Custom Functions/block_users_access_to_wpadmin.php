<?php
/******************************************/
/***** Only administrator can get access to wpadmin **********/
/******************************************/
if(!function_exists("block_users_access_to_wpadmin")){
  function block_users_access_to_wpadmin() {
    if ( is_admin() && ! current_user_can( 'administrator' ) &&
      ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
      wp_redirect( home_url() );
      exit;
    }
  }
  add_action( 'init', 'block_users_access_to_wpadmin' );
}
