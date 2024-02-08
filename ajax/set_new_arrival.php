<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$id = $_POST['id'];
	$check = get_row($conn, "select * from arrivals where product_id='$id' LIMIT 1");
	if(count($check)==0){
		$conn->query("insert into arrivals(product_id,created_at) values('$id','$date')");
		echo 1; //success
		}
		else{
		$conn->query("delete from arrivals where product_id='$id'");
		echo 2; //Removed	
			}
	
?>
