<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	$date1 = date("d-m-Y h:i:s a");
	
	if($_POST['status']=='set'){
		
		$combo_id = $_POST['combo_id'];
		
		if(isset($_SESSION['similar_combo_list'][$combo_id])){
			unset($_SESSION['similar_combo_list'][$combo_id]);
		}
		else{
			$rows71=get_row($conn, "select * from similar_products where combo_id='$combo_id' and type='Combo' and md5(product_id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
			if(count($rows71)==0){
				$_SESSION['similar_combo_list'][$combo_id] = array('combo_id' => $combo_id);
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
		
		
		
		foreach($_SESSION['similar_combo_list'] as $id){
			
			$row = get_row($conn, "select * from similar_products where product_id='{$rows81[0]['id']}' and combo_id='{$id['combo_id']}'");
			if(count($row)==0){
				$conn->query("insert into similar_products(product_id,combo_id,type,product_type) values('{$rows81[0]['id']}','{$id['combo_id']}','Combo','{$_SESSION['similar_product_type']}')");
			}
			
		}
		echo 4;
		unset($_SESSION['similar_combo_list']);
		
		
		
	}
	
	
	
	
	
?>
