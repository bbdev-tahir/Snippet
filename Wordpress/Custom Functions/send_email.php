<?php
/******************************************/
/***** function for send email start from here **********/
/******************************************/
if(!function_exists("is_localhost")){
	function send_email($to,$subject,$message1){
		$host_address = $_SERVER['HTTP_HOST'];
		if(localhost())
		{
			require_once(get_template_directory().'/lib/PHPMailer/PHPMailerAutoload.php');
			$message_body = $message1;
			$mail = new PHPMailer;

			$mail->IsSMTP();
			$mail->SMTPSecure = "ssl";
			$mail->Host       = "smtp.gmail.com"; // SMTP server
			$mail->SMTPAuth   = true;
			$mail->Port       = 465;
			$mail->Username   = "nasiranwar2020@gmail.com";
			$mail->Password   = "NasirBro";
			//$mail->addAddress('nuqtadeveloptahir@gmail.com');
			$mail->addAddress($to);

			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $message_body;
			$mail->send();

		}
		else
		{
			$message = '<html><head><title></title></head><body>';
			$message .= $message1;
			$message .= '</body></html>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.get_option('admin_email'). "\r\n";

			if(!wp_mail($to,$subject,$message,$headers))
				return false;
			else
				return true;
		}
	}// function send_email end here
}
