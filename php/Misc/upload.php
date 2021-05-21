<!DOCTYPE html>
<html>
<head>
    <title>Upload file from URL</title>
</head>
<body>
<?php

function copyfile_chunked($infile, $outfile) {
    $chunksize = 10 * (1024 * 1024); // 10 Megs

    /**
     * parse_url breaks a part a URL into it's parts, i.e. host, path,
     * query string, etc.
     */
    $parts = parse_url($infile);
    $i_handle = fsockopen($parts['host'], 80, $errstr, $errcode, 5);
    $o_handle = fopen($outfile, 'wb');

    if ($i_handle == false || $o_handle == false) {
        return false;
    }

    if (!empty($parts['query'])) {
        $parts['path'] .= '?' . $parts['query'];
    }

    /**
     * Send the request to the server for the file
     */
    $request = "GET {$parts['path']} HTTP/1.1\r\n";
    $request .= "Host: {$parts['host']}\r\n";
    $request .= "User-Agent: Mozilla/5.0\r\n";
    $request .= "Keep-Alive: 115\r\n";
    $request .= "Connection: keep-alive\r\n\r\n";
    fwrite($i_handle, $request);

    /**
     * Now read the headers from the remote server. We'll need
     * to get the content length.
     */
    $headers = array();
    while(!feof($i_handle)) {
        $line = fgets($i_handle);
        if ($line == "\r\n") break;
        $headers[] = $line;
    }

    /**
     * Look for the Content-Length header, and get the size
     * of the remote file.
     */
    $length = 0;
    foreach($headers as $header) {
        if (stripos($header, 'Content-Length:') === 0) {
            $length = (int)str_replace('Content-Length: ', '', $header);
            break;
        }
    }

    /**
     * Start reading in the remote file, and writing it to the
     * local file one chunk at a time.
     */
    $cnt = 0;
    while(!feof($i_handle)) {
        $buf = '';
        $buf = fread($i_handle, $chunksize);
        $bytes = fwrite($o_handle, $buf);
        if ($bytes == false) {
            return false;
        }
        $cnt += $bytes;

        /**
         * We're done reading when we've reached the conent length
         */
        if ($cnt >= $length) break;
    }

    fclose($i_handle);
    fclose($o_handle);
    return $cnt;
}

function downloadDistantFile($url, $dest)
  {
    $options = array(
      CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_URL => $url,
      CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $return = curl_exec($ch);

    if ($return === false)
    {
      return curl_error($ch);
    }
    else
    {
      return true;
    }
  }
  
  function otw_php_copy($url, $to)
  {
      if(!@copy($url, $to )){
			$errors= error_get_last();
			echo "COPY ERROR: ".$errors['type'];
			echo "<br />\n".$errors['message'];
		}
		else{
			echo "File copied from remote!";
		}
  }
    $BASE_URL = strtok($_SERVER['REQUEST_URI'],'?');

    if (isset($_POST['url']) && function_exists('exec')){
		
		$output=null;
		$retval=null;

        $url = $_POST['url'];
        echo "Transferring file: {$url}<br>";
        exec("wget {$url}", $output, $retval);
		echo "Returned with status $retval and output:\n";
		print_r($output);
    }
	elseif(isset($_POST['url']))
	{
	    
	    set_time_limit(0);
	    $url = $_POST['url'];
	    $to = getcwd().'/tahir.zip';
	    //file_put_contents($to, fopen($url, 'r'));
	    //otw_php_copy($url, $to);
	    //downloadDistantFile($url, $to);
	    copyfile_chunked($url, $to);
	    //chunked_copy($url, $to );
		
	//print_r(getcwd().'/tahir.txt');	
	}

?>
    <form name='upload' method='post' action="<?php echo $BASE_URL; ?>">
        <input type='text' id='url' name='url' size='128' /><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>