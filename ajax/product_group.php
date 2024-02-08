<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$key = trim(mysqli_real_escape_string($conn, $_POST['key']));
	$group_id = trim(mysqli_real_escape_string($conn, $_POST['group_id']));
	
	$lists = get_row($conn, "select * from products where name like '%".$key."%' or keyword like '%".$key."%' limit 50");
?>


<?php 
	$x = 0;
	foreach($lists as $list){ 
		$pg = get_row($conn, "select * from top_product_group where product_id='{$list['id']}' and group_id='{$group_id}'");
	?>
	<tr>
		<td><?php echo ($x+1); ?></td>
		<td><?php echo $list['name']; ?></td>
		<td><input <?php if(count($pg)){ echo 'checked'; } ?> onclick="setProduct('<?php echo $list['id']; ?>', '<?php echo $group_id; ?>')" type="checkbox"> Add to Group</td>
	</tr>
	
	
<?php $x++; } ?>
