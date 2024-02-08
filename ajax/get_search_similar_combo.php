<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	$key = $_POST['key'];
?>
<table class="table table-striped table-bordered table-hover" id="combotable">
	<thead>
		<tr>
			<th> ID&nbsp;&nbsp;</th>
			<th> Name </th>
			<th> Price </th>
			<th>Add Combo</th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$rows = get_row($conn, "select  * from combo where name like '%$key%' order by id desc");
			if(count($rows)==0){
				echo '<tr><td colspan="5">Result Not Found !</td></tr>';
				}
			$x=0;
			foreach($rows as $row){
				
			?>
			
			<tr>
				
				<td>
				<?php echo $row['id']; ?> </td>
				<td><?php echo $row['name']; ?></td>
				
				
				<td>Rs.<?php echo get_combo_price($conn,$row['id']); ?></td>
				<td>
				<input <?php if(isset($_SESSION['similar_combo_list'][$row['id']])){ echo 'checked'; } ?> onclick="addsimilar(<?php echo $row['id']; ?>)" type="checkbox">	&nbsp;&nbsp;Add to Combo
				</td>
				<td> 
					
					<a data-toggle="collapse" data-target="#item<?php echo $x; ?>" class="btn btn-xs btn-primary">Show Items <i class="fa fa-angle-down" aria-hidden="true"></i></a>
				</td>
			</tr>
			
			<tr id="item<?php echo $x; ?>" class="collapse">
				
				<td colspan="6" style="padding:0">
					<div>
						<table style="background:#dcdcdc;margin-bottom:0;" class="table table-bordered">
							<thead>
								<tr>
									<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
									<th> Image </th>
									<th> Color </th>
									<th> MRP </th>
									<th> Sale Price </th>
									<th> Combo Price </th>
									
								</tr>
							</thead>
							<tbody>
								<?php
									$cs = get_row($conn, "select * from combo_product where combo_id='{$row['id']}'");
									
									foreach($cs as $c){
									
									$row16=get_row_single($conn, "select * from products_item where pid='{$c['product_id']}'");
									?>
									<tr>
										<td><?php echo $row16['id']; ?></td>
										<td><img style="width:56px;height:56px;" src="data/product_images/<?php echo $row16['thumb_image']; ?>"></td>
										<?php
											$rows31=get_row($conn, "select * from color where id='{$row16['color']}' LIMIT 1");
										?>
										<td><input disabled style="padding:0;" type="color" value="<?php echo $rows31[0]['code']; ?>"></td>
										<td><?php echo "Rs ".$row16['mrp']; ?></td>
										<td><?php echo "Rs ".$row16['price']; ?></td>
										<td><?php echo "Rs ".$row16['combo_price']; ?></td>
										
										
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					
					
				</td>
			</tr>
			
		<?php $x++; } ?>
	</tbody>
</table>
