<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
		$item_id = @$_POST['item_id'];
		$pid = @$_POST['pid'];
		if(!empty($item_id) && !empty($pid)){
		    $_SESSION['cart_list'][$item_id] = array('item_id' => $item_id, 'pid' => $pid, 'qty' => $_POST['qty'] ?? 1);
		}
	?>