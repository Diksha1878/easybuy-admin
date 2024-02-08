<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Product'){
		$rows81=get_row($conn, "select * from similar_products where md5(product_id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
		$product=get_row($conn, "select * from products where md5(id)='{$_SESSION['page_edit_similar']}'");
	}
	if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Combo'){ 
		$rows81=get_row($conn, "select * from similar_products where md5(combo_id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
		$product=get_row($conn, "select * from combo where md5(id)='{$_SESSION['page_edit_similar']}'");
		
	}
?>

<div>
	<h3 style="margin-top:0">Combo Already Added</h3>
	<table class="table">
		<thead style="background: #eee;">
			<tr style="border-bottom: solid 1px #eee;">
				<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
				<th> Name </th>
				<th> Price </th>
				<th style="text-align:right;">Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$inc=1;
				$total=0;
				$img = '';
				$rows82 = get_row($conn, "select * from similar_products where md5(product_id)='{$_SESSION['page_edit_similar']}' and type='Combo'");
				//var_dump($rows82);
				if(count($rows82)==0){
					echo '<tr><td colspan="4">No Record Found !</td></tr>';
				}
				foreach($rows82 as $item){
					$rows45=get_row($conn, "select * from combo where id='{$item['combo_id']}'");
				?>
				<tr style="border-bottom:solid 1px #eee">
					<td><?php echo  $inc; ?></td>
					<td><?php echo  $rows45[0]['name']; ?></td>
					<td>Rs.<?php echo  get_combo_price($conn,$rows45[0]['id']); ?></td>
					
					<td style="text-align:right;">
						<a onclick="deletesimilar(<?php echo $item['id']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
						
					</td>
				</tr>
				<?php $total = $total+$rows45[0]['price']; ?>
				
				<?php 
					if(isset($_SESSION['similar_combo_list'])){ $similar_list = count($_SESSION['similar_combo_list']); }else{ $similar_list = 0; }
					$count = count($rows82)+$similar_list;
					if($count==1){
						$imagesize = "width:100%;height:100%";
					}
					if($count==2){
						$imagesize = "width:50%;height:100%";
					}
					if($count==3 || $count==4){
						$imagesize = "width:50%;height:50%";
					}
					if($count>4){
						if($count%2==0){ $c = $count; }else{ $c = $count+1; }
						$y = 100/($c/2);
						$imagesize = "width:50%;height:".$y."%";
					}
					$img .= '<div>'.$rows45[0]['image'].'</div>';
				$inc++; }
				
			?>
			
		</tbody>
	</table>
	<?php
		if(isset($_SESSION['similar_combo_list']) && count($_SESSION['similar_combo_list'])!=0){
		?>
		<h3 style="margin-top:0">Related Combos</h3>
		<table class="table">
			<thead style="background: #eee;">
				<tr style="border-bottom: solid 1px #eee;">
					<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
					<th> Name </th>
					<th> Price </th>
					<th style="text-align:right;">Manage</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$inc=1;
					$total1=0;
					
					foreach($_SESSION['similar_combo_list'] as $item){
						$rows41=get_row($conn, "select * from combo where id='{$item['combo_id']}'");
						
					?>
					<tr style="border-bottom:solid 1px #eee">
						<td><?php echo  $inc; ?></td>
						<td><?php echo  $rows41[0]['name']; ?></td>
						<td>Rs. <?php echo get_combo_price($conn,$rows41[0]['id']); ?></td>
						
						
						<td  style="text-align:right;">
							<a onclick="addsimilar(<?php echo $item['combo_id']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Close</a>
							
						</td>
					</tr>
					<?php $total1 = $total1+$rows41[0]['price']; ?>
					
					<?php 
						if(isset($_SESSION['similar_combo_list'])){ $similar_list = count($_SESSION['similar_combo_list']); }else{ $similar_list = 0; }
						$count = count($rows82)+$similar_list;
						if($count==1){
							$imagesize = "width:100%;height:100%";
						}
						if($count==2){
							$imagesize = "width:50%;height:100%";
						}
						if($count==3 || $count==4){
							$imagesize = "width:50%;height:50%";
						}
						if($count>4){
							if($count%2==0){ $c = $count; }else{ $c = $count+1; }
							$y = 100/($c/2);
							$imagesize = "width:50%;height:".$y."%";
						}
						$img .= '<div>'.$rows41[0]['image'].'</div>';
						
					$inc++; } ?>
					
			</tbody>
		</table>
	<?php } ?>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-12">
			<div class="form-group">
				<label style="padding-left:0;" class="control-label col-sm-9" for="email"><input type="text" placeholder="Product Name" id="combo_name" value="<?php echo $product[0]['name']; ?>" class="form-control" disabled>
					<span id="comboname_help"  class="help-block"></span>
				</label>
				<div style="padding-right:0;" class="col-sm-3">
					<a onclick="savesimilar()" class="btn red pull-right" >Save</a>
				</div>
			</div>
		</div>
		
		
		
		<div class="col-md-12">
			<input type="hidden" id="image_selection" value="1">
			<div id="autocomboimg" style="overflow: hidden;border: solid 1px #ccc;
			padding: 8px;"><div id="img_container1" style="width:100%;height:320px;min-width:300px;"><?php echo $img; ?></div></div>
			
			<div id="addcomboimg" style="display:none;border: solid 1px #ccc;
			padding: 8px;">
				<style>
					#img_container2 img{
					width: 100%;
					height: 270px;
					}
				</style>
				<div style="width:100%;height:320px;min-width:300px;">
					
					<div class="col-sm-12 controls">
						<div class="">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="height:280px;width:100%;">
									<img style="height: 280px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image" draggable="false">
								</div>
								<div id="img_container2" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div>
								</br>
								<div>
									<span style="width:49%" class="btn btn-file btn-primary">
										<span class="fileupload-new">Select image</span>
										<span class="fileupload-exists">Change</span>
										<input accept="image/jpeg" type="file">
									</span>
									<a href="#" style="width:49%" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
						
					</div>
					
				</div></div>
		</div>
	</div>
</div>
