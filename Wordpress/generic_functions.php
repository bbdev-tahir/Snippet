<?php

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


if(!function_exists('alert')){
	function alert($alertText = 'Test')
	{
		echo '<script type="text/javascript">';
		echo "alert(\"$alertText\");";
		echo "</script>";
	}
}
if(!function_exists('db')){
	function db($array1)
	{
		echo "<pre>";
		var_dump($array1);
		echo "</pre>";
	}
}

/******************************************/
/***** isLocalhost **********/
/******************************************/
function isLocalhost($whitelist = ['127.0.0.1', '::1']) {
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}

/******************************************/
/***** generate random integre value **********/
/******************************************/
function generate_random_int($number_values)
{
	$number_values = $number_values-2;
	$lastid = rand(0,9);
	for($i=0; $i <= $number_values; $i++)
	{
		$lastid .= rand(0,9);
	}
	return $lastid;
}



/******************************************/
/***** get featured image url **********/
/******************************************/
function get_feature_image_url($post_id, $default = false)
{
	if(has_post_thumbnail($post_id))
	{
		$image5 = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		return $image5[0];
	}
	else
	{
		return $default;
	}
}

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


  /******************************************/
  /***** arrayToSerializeString **********/
  /******************************************/
  if(!function_exists("ArrayToSerializeString")){
    function ArrayToSerializeString($array){
      if(isset($array) && is_array($array) && count($array) >= 1)
        return serialize($array);
      else
        return serialize(array());
    }
  }

  /******************************************/
  /***** SerializeStringToArray **********/
  /******************************************/
  if(!function_exists("SerializeStringToArray")){
    function SerializeStringToArray($string){
      if(isset($string) && is_array($string) && count($string) >= 1)
        return $string;
      elseif(isset($string) && $string && @unserialize($string)){
        return unserialize($string);
      }else
        return array();
    }
  }
  
  /******************************************/
  /***** show_admin_bar **********/
  /******************************************/
  add_filter('show_admin_bar', '__return_false');
  



	