<?php

/******************************************/
/***** Debug functions start from here **********/
/******************************************/
if(!function_exists("alert")){

  function alert($alertText){
  	echo '<script type="text/javascript">';
  	echo "alert(\"$alertText\");";
  	echo "</script>";
  } // function alert

}// if end


if(!function_exists('db')){
	function db($array1)
	{
		echo "<pre>";
		var_dump($array1);
		echo "</pre>";
	}
}

if(!function_exists('hidden_debug')){
  function hidden_debug($debug_data){
    echo '<div style="display:none">';
    db($debug_data);
    echo '</div>';
  }
}
