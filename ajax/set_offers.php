<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	//print_r($_POST);die;
	$item_id = $_POST['item_id'];
	$offer_id = $_POST['offer_id'];
	
	if($item_id!='' && $offer_id!=''){
		
		$check = get_row($conn, "select * from offer_products where item_id='$item_id' and offer_id='$offer_id'");
		
		if(count($check)){
			$conn->query("delete from offer_products where id='{$check[0]['id']}'");
		}
		else{
		echo "insert into offer_products(item_id,offer_id,date) values('$item_id','$offer_id','$date')";
			$conn->query("insert into offer_products(item_id,offer_id,date,created_at) values('$item_id','$offer_id','$date','$date')");
		}
		
	}else{
	echo '0';
	} ?>
		