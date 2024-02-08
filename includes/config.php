<?php
	$root = '';
	$public_path = '';
// 	require_once __DIR__.'/../../../vendor/autoload.php';

// 	use Symfony\Component\Dotenv\Dotenv;

// 	$dotenv = new Dotenv();
// 	$dotenv->load(__DIR__.'/../../../../.env');
	// print_r($_ENV);die;

	$conn = $mysqli = mysqli_connect("localhost" , "easybuy" , 'CS4PbmErBihM56P7' , "easybuy");
	if(mysqli_connect_error())
	{
		
		echo "Error occurred : Can't connect to database";
		die;
	}
	else{}
	
	$base_url="http://".$_SERVER['SERVER_NAME']."/";
	$base_url_admin="http://".$_SERVER['SERVER_NAME'].$public_path."/admin/";
	date_default_timezone_set('Asia/Calcutta'); 
	$date=date("Y-m-d");
	$time=date("H:i:s");
	
	$admin_email = "ki.sandeep11@gmail.com";
	$website_name = "snapholic.com";
	$logo_path = $base_url.'images/logo.jpg';
	
	ini_set("include_path", '/home/snapholic/php:' . ini_get("include_path") );
	
	$email_config = array(
	'host' => "mail.snapholic.com",
	'username' => 'info@snapholic.com',
	'password' => 'info@123',
	'offline' => 0
	);
	
	$_config['root_path'] = $_SERVER['DOCUMENT_ROOT'] . dirname('') . $root ."/";
	$_config['image_quality'] = 50;
	
	$sms_config = array(
	'username' => 'trendy',
	'password' => '46866',
	'sender' => array('TRENDY')
	);
	
	$pickup_location = array(
		'pin' => '110059',
		'add' => 'delhi',
		'phone' => '9582281977',
		'state' => 'delhi',
		'city' => 'delhi',
		'country' => 'India',
		'name' => 'ashish'
		);
		
		$mailer_url = 'https://mailer.xtreebit.ml';
		$img_url = 'https://admin.easy-buy.in/admin/data/';
		
		$site_address = 'E-353 TAGORE GARDEN EXTENSION NEW DELHI - 110027';
	
?>