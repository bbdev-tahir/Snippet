<?php
/******************************************/
/***** generate random integre value **********/
/******************************************/
if(!function_exists('generate_random_int')){
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
}
