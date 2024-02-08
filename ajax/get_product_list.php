<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$key = $_POST['key'];
	$offer_id = $_POST['offer_id'];
	
	if($key!=''){
	$products = get_row($conn, "select * from products where name like '%".$key."%'");
	if(count($products)){
	
	
	
	foreach($products as $product){
	$pro_items = get_row($conn, "select * from products_item where pid='{$product['id']}'");
	
	foreach($pro_items as $pro_item){
	$chk = get_row($conn, "select * from offer_products where item_id='{$pro_item['id']}' and offer_id='{$offer_id}'");
	?>
	<li><input <?php if(count($chk)){ echo 'checked'; } ?> onclick="setOffers('<?php echo $pro_item['id']; ?>', '<?php echo $offer_id; ?>')" type="checkbox"> <?php echo $product['name']; ?></li>
	<?php } } } }else{
	echo "<li>Product List</li>";
	} ?>
