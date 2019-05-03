<?php

/******************************************/
/***** add defer asynac or any other attribute to js files. **********/
/******************************************/
if(!function_exists("bbwp_script_loader_tag")){
    function bbwp_script_loader_tag($tag, $handle) {
  
        /*if ( 'my-js-handle' !== $handle )
                return $tag;*/
        //db($handle);
       // add script handles to the array below
       $scripts_to_defer = array(
             'jquery-core',
             'jquery-migrate',
             'bootstrap',
             'scripts'
         );
  
       foreach($scripts_to_defer as $defer_script) {
          if ($defer_script === $handle) {
             return str_replace(' src', ' defer="defer" src', $tag);
          }
       }
       return $tag;
    }
    add_filter('script_loader_tag', 'bbwp_script_loader_tag', 10, 2);
  }