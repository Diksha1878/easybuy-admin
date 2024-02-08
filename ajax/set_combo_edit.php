<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	$date1 = date("d-m-Y h:i:s a");

	if($_POST['status']=='set'){
		
		$item_id = $_POST['item_id'];
		$pid = $_POST['pid'];
		if(isset($_SESSION['combo_list'][$item_id])){
			unset($_SESSION['combo_list'][$item_id]);
		}
		else{
			$rows71=get_row($conn, "select * from combo_product where product_item_id='$item_id' and product_id='$pid' and md5(combo_id)='{$_SESSION['page_edit_combo']}' LIMIT 1");
			if(count($rows71)==0){
				$_SESSION['combo_list'][$item_id] = array('item_id' => $item_id, 'pid' => $pid);
				}
				else{
					echo 5;
					}
			
		}
		
	}
	if($_POST['status']=='save'){
	
	$rows81=get_row($conn, "select * from combo where md5(id)='{$_SESSION['page_edit_combo']}' LIMIT 1");
	
		if(!isset($_SESSION['combo_list'])){
			//echo 3;
			$rows5 = get_row($conn, "select * from combo where name='{$_POST['comboname']}' and id!={$rows81[0]['id']} LIMIT 1");
				if(count($rows5)==0){
					$conn->query("update combo set name='{$_POST['comboname']}', image='{$_POST['image']}', image_ack='{$_POST['image_ack']}' where id='{$rows81[0]['id']}'");
					echo 4;
				}
				else{
					echo 1;
					}
		}
		else{
			
				//$combo_id='';
				
				$total=0;
				foreach($_SESSION['combo_list'] as $id){
					$rows14=get_row($conn, "select * from products_item where id='{$id['item_id']}'");
					$total = $total+$rows14[0]['combo_price'];
					//$combo_id = $combo_id+$id['item_id'];
					
				}
				$total = $total+$rows81[0]['price'];
				//$combo_id = $combo_id+$rows81[0]['combo_code'];
				$rows3 = get_row($conn, "select * from combo where name='{$_POST['comboname']}' and id!={$rows81[0]['id']} LIMIT 1");
				if(count($rows3)==0){
					$combo_name = $_POST['comboname'];
					
					$query = $conn->query("SELECT Max(id) as mexid FROM combo");
					if($row = mysqli_fetch_array($query)){
						$Maxid = $row['mexid'];
						$Maxid = $Maxid + 1;
						
					}
					else{
						$Maxid = 1;	
					}
					
					$conn->query("update combo set name='$combo_name', price='$total', modify_date='$date1', image='{$_POST['image']}' , image_ack='{$_POST['image_ack']}' where id='{$rows81[0]['id']}'");
					
					foreach($_SESSION['combo_list'] as $id){
						
						
						$conn->query("insert into combo_product(product_id,product_item_id,combo_id,date) values('{$id['pid']}','{$id['item_id']}','{$rows81[0]['id']}','$date1')");
					}
					echo 4;
					unset($_SESSION['combo_list']);
				}
				else{
					echo 1;
				}
			}
			
		}
		
		
		
	
	
?>
