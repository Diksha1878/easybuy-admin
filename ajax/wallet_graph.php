<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	
	$order_date = date("Y-m-d");
	
	
	$j='';
	$s_date = 1;
	$s_date+0;
	$l_date = date("d");
	
	
	$datetime = new DateTime(date("Y-m-").'00');
	for($s_date;$s_date<=$l_date;$s_date++){
		
		$datetime->modify('+1 day');
		$real_date =  $datetime->format('Y-m-d');
		
		$wallets = get_row($conn, "select * from wallet where txn_date='$real_date'");
		$total_amount_cr=0;
		$total_amount_dr=0;
		
		foreach($wallets as $wallet){
			if($wallet['txn_type']=="Cr"){
				$total_amount_cr = $total_amount_cr+base64_decode($wallet['amount']);
			}
			if($wallet['txn_type']=="Dr"){
				$total_amount_dr = $total_amount_dr+base64_decode($wallet['amount']);
			}
			
		}
		//echo $total_amount;
		$j[] = array('y' => date_format(date_create($real_date), "d-m-Y"), 'a' => $total_amount_cr, 'b' => $total_amount_dr);
	}
	
	echo json_encode($j);
?>