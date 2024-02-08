<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	//print_r($_POST);
	
	
	if($_POST['table']=='departments')
	{
		$conn->query("delete from departments where id='{$_POST['id']}'");
	}
	if($_POST['table']=='pop_up_ads')
	{
		$get_data = $conn->query("select * from pop_up_ads where id='{$_POST['id']}'");
		if(mysqli_num_rows($get_data)>0)
		{
			$data = mysqli_fetch_assoc($get_data);
			$image = '../data/ads/'.$data['image'];
			unlink($image);
			}
		$conn->query("delete from pop_up_ads where id='{$_POST['id']}'");
	}
	if($_POST['table']=='coupon')
	{
		$conn->query("delete from coupons where id='{$_POST['id']}'");
	}
	if($_POST['table']=='cats')
	{
		$conn->query("delete from cats where id='{$_POST['id']}'");
	}
	if($_POST['table']=='subcats')
	{
		$conn->query("delete from subcats where id='{$_POST['id']}'");
	}
	if($_POST['table']=='brands')
	{
		$conn->query("delete from brands where id='{$_POST['id']}'");
	}
	if($_POST['table']=='colors')
	{
		$conn->query("delete from colors where id='{$_POST['id']}' and id!='1'");
	}
	if($_POST['table']=='sizes')
	{
		$conn->query("delete from sizes where id='{$_POST['id']}' and id!='1'");
	}
	if($_POST['table']=='similar_item')
	{
		$conn->query("delete from similar_products where id='{$_POST['id']}'");
	}
	if($_POST['table']=='offers')
	{
		$conn->query("delete from offers where id='{$_POST['id']}'");
	}
	if($_POST['table']=='coupons')
	{
		$conn->query("delete from coupons where id='{$_POST['id']}'");
	}
	if($_POST['table']=='products')
	{
		
		$rows = get_row($conn, "select * from products_images where pid='{$_POST['id']}'");
		foreach($rows as $row){
			unlink('../data/product_images/'.str_replace('thumb_', '', $row['thumb']));
			unlink('../data/product_images/'.$row['thumb']);
			unlink('../data/product_images/'.$row['banner']);
			unlink('../data/product_images/'.$row['zoom']);
			
		}
		
		$conn->query("delete from products_images where p_item_id='{$_POST['id']}'");
		$conn->query("delete from products_items where pid='{$_POST['id']}'");
		$conn->query("delete from products where id='{$_POST['id']}'");
		$conn->query("delete from top_products where product_id='{$_POST['id']}'");
		$conn->query("delete from arrivals where product_id='{$_POST['id']}'");
		$conn->query("delete from similar_products where product_id='{$_POST['id']}' and type='Product'");
		$conn->query("delete from carts where pid='{$_POST['id']}' and type='Product'");
		$conn->query("delete from combo_products where product_id='{$_POST['id']}'");
		
		create_log("delete from products where id='{$_POST['id']}'","products table");
		create_log("delete from products_items where id='{$_POST['id']}'","products_item table");
		create_log("delete from products_images where p_item_id='{$_POST['id']}'","Delete products_image table");
		
	}
	if($_POST['table']=='product_image')
	{
	    $rows = get_row($conn, "select * from products_images where id='{$_POST['id']}'");
		foreach($rows as $row){
		    $conn->query("delete from products_images where id='".$_POST['id']."'");
			unlink('../data/product_images/'.str_replace('thumb_', '', $row['thumb']));
			unlink('../data/product_images/'.$row['thumb']);
			unlink('../data/product_images/'.$row['banner']);
			unlink('../data/product_images/'.$row['zoom']);
			create_log("Image ID[{$row['id']}]deleted from Item ID[ {$_POST['p_item_id']} ] and Product ID[ {$row['pid']} ]","Delete products_image table deleted by {$_SESSION['name']}");
		}
	}
	if($_POST['table']=='items')
	{
		
		$rows = get_row($conn, "select * from products_images where p_item_id='{$_POST['id']}'");
		foreach($rows as $row){
			unlink('../data/product_images/'.str_replace('thumb_', '', $row['thumb']));
			unlink('../data/product_images/'.$row['thumb']);
			unlink('../data/product_images/'.$row['banner']);
			unlink('../data/product_images/'.$row['zoom']);
			create_log("Image ID[{$row['id']}]deleted from Item ID[ {$_POST['id']} ] and Product ID[ {$row['pid']} ]","Delete products_image table deleted by {$_SESSION['name']}");
			}
		$conn->query("delete from products_images where p_item_id='{$_POST['id']}'");
		$conn->query("delete from products_items where id='{$_POST['id']}'");
		
		create_log("Item ID[ {$_POST['id']} ] deleted from Product ID[ {$row['pid']} ] ","products_item table deleted by {$_SESSION['name']}");
		
		
	}
	if($_POST['table']=='combo_item')
	{
		$conn->query("delete from combo_products where id='{$_POST['id']}'");
	}
	if($_POST['table']=='combo_product')
	{
		$conn->query("delete from combo_products where combo_id='{$_POST['id']}'");
		$conn->query("delete from combos where id='{$_POST['id']}'");
		$conn->query("delete from similar_products where product_id='{$_POST['id']}' and type='Combo'");
		
	}
	if($_POST['table']=='carts'){
		$conn->query("delete from carts where id='{$_POST['id']}'");
	}
	if($_POST['table']=='pincodes'){
		$conn->query("delete from pincodes where id='{$_POST['id']}'");
	}
	if($_POST['table']=='sliders'){
		$conn->query("delete from home_sliders where id='{$_POST['id']}'");
	}
	if($_POST['table']=='sideads'){
		$conn->query("delete from side_ads where id='{$_POST['id']}'");
	}
	if($_POST['table']=='wishlists'){
		$conn->query("delete from wishlists where id='{$_POST['id']}'");
	}
?>