<?php 
/******************************************/
/***** Replace last occurrence of a String in a String? **********/
/*https://stackoverflow.com/questions/3835636/php-replace-last-occurrence-of-a-string-in-a-string*/
/******************************************/
function str_lreplace($search, $replace, $string){
	$pos = strrpos($string, $search);
	if($pos !== false)
		$string = substr_replace($string, $replace, $pos, strlen($search));
	return $string;
}