<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$id = $_POST['id'];
	$check = get_row($conn, "select * from top_products where product_id='$id' LIMIT 1");
	if(count($check)==0){
		$conn->query("insert into top_products(product_id,created_at) values('$id','$date')");
		echo 1; //success
		}
		else{
		$conn->query("delete from top_products where product_id='$id'");
		echo 2; //Removed	
	}
	
?>
