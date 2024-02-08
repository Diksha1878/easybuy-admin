<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	
	$order_date = date("Y-m-d");
	
	
	$j=array();
	$s_date = 1;
	$s_date+0;
	$l_date = date("d");
	
	
	$datetime = new DateTime(date("Y-m-").'00');
	for($s_date;$s_date<=$l_date;$s_date++){
		
		$datetime->modify('+1 day');
		$real_date =  $datetime->format('Y-m-d');
		
		$orders = get_row($conn, "select * from orders where date='$real_date' and status in('PLACED', 'DISPATCHED', 'DELIVERED')");
		$total_amount=0;
		$x=0;
		foreach($orders as $order){
			
			$total_amount = $total_amount+$order['total_price'];
			$x++;
		}
		//echo $total_amount;
		$j[] = array('y' => date_format(date_create($real_date), "d-m-Y"), 'a' => $x);
	}
	/* foreach($orders as $order){
		
		$j[] = array('y' => date_format(date_create($order['date']), "d-m-Y"), 'a' => $order['total_price']);
	} */
	echo json_encode($j);
?>