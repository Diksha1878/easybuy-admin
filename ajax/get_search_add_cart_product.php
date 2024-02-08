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
			
			<th> Category </th>
			<th>Manage</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$key_segments = explode(' ', $key);
		$search_query = '';
		if (count((array)$key_segments) > 0) {
                    foreach ($key_segments as $k => $sKey) {
                        if ($k === 0) {
                            $search_query .= " and name like '%".$sKey."%'";
                        } else {
                            $search_query .= " and name like '% ".$sKey."%'";
                        }

                    }
                }
                
               
                
			$rows = get_row($conn, "select  * from products where id!='' $search_query order by id desc");
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
				
				<?php 
					//$rows12=get_row($conn, "select * from department where id='{$row['dept_id']}'");
					$rows13=get_row($conn, "select * from cats where id='{$row['cat_id']}'");
				?>
				
				<td><?php echo $rows13[0]['name'] ?? ''; ?></td>
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
									<th>Manage</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$rows16=get_row($conn, "select * from products_items where pid='{$row['id']}'");
									foreach($rows16 as $row16){
									?>
									<tr>
										<td><?php echo $row16['id']; ?></td>
										<td><img style="width:56px;height:56px;" src="data/product_images/<?php echo $row16['thumb_image']; ?>"></td>
										<?php
											$rows31=get_row($conn, "select * from colors where id='{$row16['color']}' LIMIT 1");
										?>
										<td><input disabled style="padding:0;" type="color" value="<?php echo $rows31[0]['code']; ?>"></td>
										<td><?php echo "Rs ".$row16['mrp']; ?></td>
										<!--<td><?php echo "Rs ".$row16['price']; ?></td>-->
										<td><?php echo "Rs ".$row16['combo_price']; ?></td>
										
										<td>
											<?php if(isset($_SESSION['cart_list'][$row16['id']])){ ?>
												<script>
													$(document).ready(function(){
														
														$("#item"+<?php echo $x; ?>).addClass('in');
													});
													
													
												</script>	
												
											<?php } ?>
											
											<input <?php if(isset($_SESSION['cart_list'][$row16['id']])){ echo 'checked'; } ?> onclick="addsimilar(<?php echo $row16['id']; ?>,<?php echo $row['id']; ?>)" type="checkbox">
											&nbsp;Add to Cart
										</td>
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
