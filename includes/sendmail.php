<?php 
	//session_start(); 
	
	function sendmail(array $data){
		require('config.php');
		
		if(isset($data['sender_email'])){ 
			$sender_email=trim($conn->real_escape_string($data['sender_email']));
		}else{ $sender_email=''; }
		if(isset($data['receiver_email'])){ 
			$receiver_email=trim($conn->real_escape_string($data['receiver_email'])); 
		}else{ $receiver_email=''; }
		if(isset($data['subject'])){ 
			$subject=trim($conn->real_escape_string($data['subject'])); 
		}else{ $subject=''; }
		if(isset($data['content'])){ 
			$content=trim($conn->real_escape_string($data['content'])); 
		}else{ $content=''; }
		if(isset($data['username'])){ 
			$username=trim($conn->real_escape_string($data['username'])); 
		}else{ $username=''; }
		if(isset($data['password'])){ 
			$password=trim($conn->real_escape_string($data['password'])); 
		}else{ $password=''; }
		if(isset($data['host'])){ 
			$host=trim($conn->real_escape_string($data['host'])); 
		}else{ $host=''; }
		if(isset($data['auth'])){ 
			$auth=trim($conn->real_escape_string($data['auth'])); 
		}else{ $auth=''; }
		if(isset($data['logo_path'])){ 
			$logo_path=trim($conn->real_escape_string($data['logo_path'])); 
		}else{ $logo_path=''; }
		if(isset($data['website_name'])){ 
			$website_name=trim($conn->real_escape_string($data['website_name'])); 
		}else{ $website_name=''; }
		if(isset($data['website_link'])){ 
			$website_link=trim($conn->real_escape_string($data['website_link'])); 
		}else{ $website_link=''; }
		if(isset($data['html'])){ 
			$html=trim($conn->real_escape_string($data['html'])); 
		}else{ $html=''; }
		
		
		
		ini_set("include_path", '/home/snapholic/php:' . ini_get("include_path") );
		require 'Mail.php';
		
		/*$contant = '<h2>'.$name.'</h2><br>
			<p>'.$msg.'</p><br>
			<p><b>From: </b>'.$user_email.'</p>
			<p><b>'.$phno.'</b></p>
		'; */
		$msg = 'Mail';
		
		if($html!=''){
			$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
			"http://www.w3.org/TR/html4/loose.dtd">'.$html;
		}
		else{
			$body = '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
			"http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<title>'.$sender_email.'</title>
			
			</head>
			<body>
			<div id="page">
			<div id="address" style="float:right;">
			<p><h2 style="margin-bottom: 0;">'.$website_name.'&nbsp;&nbsp;</h2><br />
			
			</p>
			</div><!--end address-->
			<div id="logo" >
			<a href=""><img height="70px" width="200px" src="'.$logo_path.'"></a>
			</div>
			<!--end logo-->
			
			<div id="content">
			<p>
			<br/>
			<hr>
			<p>
			'.$content.'
			</p>
			
			</div><!--end content-->
			<div style="position: absolute;bottom: 5px;width: 100%;text-align: center;font-size: 10px;margin-bottom: 22px;">
			<hr/>
			Designed By <a href="'.$website_link.'">'.$website_name.'</a> 
			</div>
			</div><!--end page-->
			</body></html>';
		}
		
		$from = $sender_email;
		$to = $receiver_email;
		$subject = $subject;
		$host = $host;
		$username = $username;
		$password = $password;
		/* MIME-Version should be "1.0rn" and Content-Type should be "text/html; charset=ISO-8859-1rn" to send an HTML Email */
		$headers = array ('MIME-Version' => '1.0rn',
		'Content-Type' => "text/html; charset=ISO-8859-1rn",
		'From' => $from,
		'To' => $to,
		'Subject' => $subject
		);
		$smtp = Mail::factory('smtp',
		array ('host' => $host,
		'auth' => true,
		'username' => $username,
		'password' => $password));
		$mail = $smtp->send($to, $headers, $body);
		if (PEAR::isError($mail)) {
			//return($mail->getMessage());
			} else {
			//return("Message successfully sent!");
			
		}
	}
	
	
	
		
		//include('sendmail.php');
		/*$d = array(
		'receiver_email' => 'ki.sandeep11@gmail.com',
		'subject' => 'Test',
		'content' => 'test',
		'sender_email' => 'info@snapholic.com',
		'username' => 'info@snapholic.com',
		'password' => 'info@123',
		'host' => 'mail.snapholic.com',
		'auth' => '',
		'logo_path' => 'http://snapholic.com/images/logo.png',
		'website_name' => 'Snapolic',
		'website_link' => 'http://royalcube.in/',
		'html' => ''
		);
		$e = sendmail($d);
	print_r($e);  */
	
?>	