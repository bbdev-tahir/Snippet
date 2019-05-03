<?php

/******************************************/
/***** test if requst is from localhost for testing **********/
/******************************************/
if(!function_exists("is_localhost")){
	function is_localhost()
	{
		$whitelist = array('127.0.0.1', "::1");

		if(in_array($_SERVER['REMOTE_ADDR'], $whitelist))
			return true;
		else
			return false;
	}
}
