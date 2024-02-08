<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$key = $_POST['key'];
?>
<table class="table table-striped table-bordered table-hover" id="table">
	<thead>
		<tr >
			
			<th colspan="8"> Coupon</th>
			
			<!-- <th>Manage</th> -->
		</tr>
	</thead>
	
	<tbody>
		<?php 
			
			$rows = get_row($conn, "SELECT DISTINCT coupon_code FROM used_coupon where coupon_code like '$key%'or order_id like '$key%' LIMIT 10");
			
			$x=0;
			foreach($rows as $row){
			?>
			
			<tr style="background: #eee;">
														
														
														<td colspan="7"><b style="color: #f44336;"><?php echo $row['coupon_code']; ?></b> <a data-toggle="collapse" data-target="#usedcoupon<?php echo $x; ?>" style="float:right;cursor:pointer;">Details</a></td>
														
														<!--  <td> 
															
															<button type="button" class="btn red btn-sm" onclick="del_data(<?php //echo $row['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button> 
														</td> -->
													</tr>
													<tr id="usedcoupon<?php echo $x; ?>" class="collapse">
														
														
														<tr>
															<th>ID</th>
															<th>User Name</th>
															<th>User ID</th>
															<th>Discount %</th>
															<th>Cashback</th>
															<th>OrderID</th>
															<th>Date/time</th>
															
														</tr>
														<?php 
															
															$used_coupon = get_row($conn, "select  * from used_coupon where id!='' and coupon_code='{$row['coupon_code']}' order by id desc");
															//echo "<pre>";
															//var_dump($used_coupon);
															
															foreach($used_coupon as $uc){
																$user = get_row($conn, "select * from users where id='{$uc['user_id']}'");
															?>
															
															<tr>
															<td><?php echo $uc['id']; ?></td>
																<td><a href="user_details/<?php echo strtoupper(md5($user[0]['id'])); ?>"><?php echo $user[0]['fname']." ".$user[0]['lname']; ?></a> </td>
																<td><?php echo $uc['user_id']; ?></td>
																<td><?php echo $uc['discount']; ?></td>
																<td><?php echo $uc['cashback']; ?></td>
																<td><a href="order_details/<?php echo strtoupper(md5($uc['order_id'])); ?>"><?php echo $uc['order_id']; ?></a></td>
																<td><?php echo date_format(date_create($uc['date']), "d/m/Y"); ?> - <?php echo $uc['time']; ?></td>
																
															</tr>
															
														<?php } ?>
														
														
													</tr>
			
			
		<?php $x++; } ?>
	</tbody>
</table>
