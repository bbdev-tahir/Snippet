<?php

/******************************************/
/***** add html headers in wp mail function. **********/
/******************************************/
if(!function_exists("bbwp_mail_content_type")){
  function bbwp_mail_content_type(){
      return "text/html";
  }
  add_filter( 'wp_mail_content_type', 'bbwp_mail_content_type' );
}
