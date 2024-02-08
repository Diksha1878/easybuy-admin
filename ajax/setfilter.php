<?php
	session_start();
	include('../includes/config.php');
	
	if($_POST['type']=='dept'){
		echo $_SESSION['f_dept'] = $_POST['deptid'];
		unset($_SESSION['f_cat']);
		unset($_SESSION['f_subcat']);
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='cleardept'){
		unset($_SESSION['f_dept']);
		unset($_SESSION['f_cat']);
		unset($_SESSION['f_subcat']);
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='cat'){
		echo $_SESSION['f_cat'] = $_POST['catid'];
		unset($_SESSION['f_subcat']);
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='clearcat'){
		unset($_SESSION['f_cat']);
		unset($_SESSION['f_subcat']);
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='subcat'){
		echo $_SESSION['f_subcat'] = $_POST['subcatid'];
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='clearsubcat'){
		unset($_SESSION['f_subcat']);
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='brand'){
		echo $_SESSION['f_brand'] = $_POST['brandid'];
	}
	if($_POST['type']=='clearbrand'){
		unset($_SESSION['f_brand']);
	}
	if($_POST['type']=='status'){
		echo $_SESSION['f_status'] = $_POST['status'];
	}
	if($_POST['type']=='clearstatus'){
		unset($_SESSION['f_status']);
	}
	if($_POST['type']=='date'){
		echo $_SESSION['f_date'] = $_POST['date'];
	}
	if($_POST['type']=='cleardate'){
		unset($_SESSION['f_date']);
	}
	if($_POST['type']=='location'){
		echo $_SESSION['f_location'] = $_POST['location'];
		unset($_SESSION['f_locality']);
		unset($_SESSION['f_city']);
	}
	if($_POST['type']=='clearlocation'){
		unset($_SESSION['f_location']);
		unset($_SESSION['f_locality']);
		unset($_SESSION['f_city']);
	}
	if($_POST['type']=='usertype'){
		echo $_SESSION['f_usertype'] = $_POST['usertype'];
	}
	if($_POST['type']=='clearusertype'){
		unset($_SESSION['f_usertype']);
	}
	if($_POST['type']=='city'){
		echo $_SESSION['f_city'] = $_POST['city'];
		unset($_SESSION['f_locality']);
	}
	if($_POST['type']=='clearcity'){
		unset($_SESSION['f_city']);
		unset($_SESSION['f_locality']);
	}
	if($_POST['type']=='locality'){
		echo $_SESSION['f_locality'] = $_POST['locality'];
	}
	if($_POST['type']=='clearlocality'){
		unset($_SESSION['f_locality']);
	}
	if($_POST['type']=="searchdate"){
		$_SESSION['search_date'] = $_POST['date'];
	}
	if($_POST['type']=="clearsearchdate"){
		unset($_SESSION['search_date']);
		unset($_SESSION['from_date']);
	}
	if($_POST['type']=="fromdate"){
		$_SESSION['from_date'] = $_POST['date'];
	}
	if($_POST['type']=="clearfromdate"){
		unset($_SESSION['from_date']);
	}
	if($_POST['type']=="state"){
		$_SESSION['f_state'] = $_POST['state'];
	}
	if($_POST['type']=="clearstate"){
		unset($_SESSION['f_state']);
	}
	
?>

