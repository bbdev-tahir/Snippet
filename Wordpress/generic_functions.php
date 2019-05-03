<?php

/******************************************/
/***** Debug functions start from here **********/
/******************************************/
function bb_shutdown()
{
echo '<div style="color:#fff;position:fixed;bottom:20px;left:0px; background-color:#000;">'.$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"].'</div>';
}

//register_shutdown_function('bb_shutdown');


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
				$output .= '<option value="'.esc_attr($key).'" selected="selected">'.$value.'</option>';
			else
				$output .= '<option value="'.$key.'">'.$value.'</option>';
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
