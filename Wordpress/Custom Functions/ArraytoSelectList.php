<?php

/******************************************/
/***** ArraytoSelectList **********/
/******************************************/
if(!function_exists("ArraytoSelectList")){
  function ArraytoSelectList($array, $sValue = ""){
    $output = '';
    foreach($array as $key=>$value){
      if($key == $sValue)
        $output .= '<option value="'.esc_attr($key).'" selected="selected">'.esc_html($value).'</option>';
      else
        $output .= '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
    }
    return $output;
	}
}