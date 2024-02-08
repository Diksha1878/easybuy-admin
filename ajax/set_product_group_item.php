<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$product_id = trim(mysqli_real_escape_string($conn, $_POST['product_id']));
	$group_id = trim(mysqli_real_escape_string($conn, $_POST['group_id']));
	$datex = date("Y-m-d H:i:s");
	
	$check = get_row($conn, "select * from top_product_group where product_id='$product_id' and group_id='$group_id' ");
	if(!$check){
		$conn->query("insert into top_product_group(product_id,group_id,date) value('$product_id','$group_id','$datex')");
	}
	else{
		$conn->query("delete from top_product_group where product_id='$product_id' and group_id='$group_id'");
	}
	
	
?>
