<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$id = $_POST['id'];
	
	if(!empty($id)){
		
		$check = get_row($conn, "select * from subcat where id='$id' and fast_link='1'");
		
		if(count($check)){
			$conn->query("update subcat set fast_link='0' where id='$id'");
		}
		else{
		
			$conn->query("update subcat set fast_link='1' where id='$id'");
		}
		
	}
?>
