<?php
	session_start();
	include('../includes/config.php');
	
	$_SESSION['similar_product_type'] = $_POST['type'];
	
?>

