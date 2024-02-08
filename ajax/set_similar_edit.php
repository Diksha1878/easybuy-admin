<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	$date1 = date("d-m-Y h:i:s a");
	
	if($_POST['status']=='set'){
		
		$item_id = $_POST['item_id'];
		$pid = $_POST['pid'];
		if(isset($_SESSION['similar_list'][$item_id])){
			unset($_SESSION['similar_list'][$item_id]);
		}
		else{
			$rows71=get_row($conn, "select * from similar_products where similar_item_id='$item_id' and similar_product_id='$pid' and md5(product_id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
			if(count($rows71)==0){
				$_SESSION['similar_list'][$item_id] = array('item_id' => $item_id, 'pid' => $pid);
			}
			else{
				echo 5;
			}
			
		}
		
	}
	if($_POST['status']=='save'){
		
		if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Product'){
			$rows81=get_row($conn, "select * from products where md5(id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
		}
		if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Combo'){
			$rows81=get_row($conn, "select * from combo where md5(id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
		}
		
		
		
		foreach($_SESSION['similar_list'] as $id){
			
			$row = get_row($conn, "select * from similar_products where product_id='{$rows81[0]['id']}' and similar_product_id='{$id['pid']}' and similar_item_id='{$id['item_id']}'");
			if(count($row)==0){
				$conn->query("insert into similar_products(product_id,similar_product_id,similar_item_id,type,product_type,created_at) values('{$rows81[0]['id']}','{$id['pid']}','{$id['item_id']}','Product','{$_SESSION['similar_product_type']}', '$date')");
			}
			
		}
		echo 4;
		unset($_SESSION['similar_list']);
		
		
		
	}
	
	
	
	
	
?>
