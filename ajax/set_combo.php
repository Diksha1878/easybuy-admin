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
			$_SESSION['combo_list'][$item_id] = array('item_id' => $item_id, 'pid' => $pid);
		}
		
	}
	if($_POST['status']=='save'){
		if(!isset($_SESSION['combo_list'])){
			echo 3;
		}
		else{
			if(count($_SESSION['combo_list'])>1){
				//$combo_id='';
				
				$total=0;
				foreach($_SESSION['combo_list'] as $id){
					$rows14=get_row($conn, "select * from products_item where id='{$id['item_id']}'");
					$total = $total+$rows14[0]['combo_price'];
					//$combo_id = $combo_id+$id['item_id'];
				}
				$rows3 = get_row($conn, "select * from combo where name='{$_POST['comboname']}' LIMIT 1");
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
					
					
					$conn->query("insert into combo(id,name,user_id,role,price,date,image,image_ack) values('$Maxid','$combo_name','{$_SESSION['id']}','{$_SESSION['role']}','$total','$date1','{$_POST['image']}','{$_POST['image_ack']}')");
					foreach($_SESSION['combo_list'] as $id){
						
						
						$conn->query("insert into combo_product(product_id,product_item_id,combo_id,date) values('{$id['pid']}','{$id['item_id']}','$Maxid','$date1')");
					}
					echo 4;
					unset($_SESSION['combo_list']);
				}
				else{
					echo 1;
				}
			}
			else{
				echo 2;
			}
		}
		
		
		
	}
	
?>
