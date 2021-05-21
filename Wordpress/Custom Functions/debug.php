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

/******************************************/
/***** Debug functions start from here **********/
/******************************************/
if(!function_exists("bb_shutdown")){
  function bb_shutdown()
  {
    if(!(defined('DOING_AJAX') && DOING_AJAX)){
		if(!(isset($_GET['action']) && $_GET['action'] == 'elementor')){
			echo '<div style="color:#fff;position:fixed;bottom:20px;left:0px; background-color:#000; z-index:999999999;">'.$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"].'</div>';
		}
      
    }
	}
	
	add_action('wp_loaded', function(){
		//if(isset($_GET['test']) && $_GET['test'] == 'admin'){
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				if($current_user->user_email == 'tahir@otw.design'){
					register_shutdown_function('bb_shutdown');
				}
			}		
		//}
	});
}
