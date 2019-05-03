<?php

/******************************************/
/***** get singl post data from database **********/
/******************************************/
if(!function_exists("get_single_post_data")){
  function get_single_post_data($post_id, $key = 'post_content'){
  	$post_data = get_post($post_id,ARRAY_A);
  	if($post_data && is_array($post_data) && isset($post_data[$key])){
  		return $post_data[$key];
  	}else{
  		return false;
  	}
  }
}
