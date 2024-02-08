<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$rows81=get_row($conn, "select * from combo where md5(id)='{$_SESSION['page_edit_combo']}'");
?>

<div>
	<h3 style="margin-top:0">Product Already in this Combo</h3>
	<table class="table">
		<thead style="background: #eee;">
			<tr style="border-bottom: solid 1px #eee;">
				<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
				<th > Name </th>
				<th> Combo Price </th>
				<th style="text-align:right;">Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$inc=1;
				$total=0;
				$img = '';
				$rows82 = get_row($conn, "select * from combo_product where md5(combo_id)='{$_SESSION['page_edit_combo']}'");
				//var_dump($rows82);
				if(count($rows82)==0){
					echo '<tr><td colspan="4">No Record Found !</td></tr>';
				}
				foreach($rows82 as $item){
					$rows41=get_row($conn, "select * from products where id='{$item['product_id']}'");
					$rows42=get_row($conn, "select * from products_item where id='{$item['product_item_id']}'");
				?>
				<tr style="border-bottom:solid 1px #eee">
					<td><?php echo  $inc; ?></td>
					<td><?php echo  $rows41[0]['name']; ?></td>
					<td><?php echo  "Rs. ".$rows42[0]['combo_price']; ?></td>
					
					<td  style="text-align:right;">
						<a onclick="deletecombo(<?php echo $item['id']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
						
					</td>
				</tr>
				<?php $total = $total+$rows42[0]['combo_price']; ?>
				
				<?php 
					if(isset($_SESSION['combo_list'])){ $combo_list = count($_SESSION['combo_list']); }else{ $combo_list = 0; }
					$count = count($rows82)+$combo_list;
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
					$img .= '<img style="float:left;'.$imagesize.';" src="'.$base_url_admin.'data/product_images/'.$rows42[0]['thumb_image'].'" draggable="false">';
					$inc++;
					
				} ?>
				<tr>
					<td colspan="3" style="text-align:right;"><b>Total Combo Price: </b></td><td style="text-align:right;"><b>Rs. <?php echo $total; ?></td>
					</b></tr>
		</tbody>
	</table>
	<?php
		if(isset($_SESSION['combo_list']) && count($_SESSION['combo_list'])!=0){
		?>
		<h3 style="margin-top:0">Combo Box</h3>
		<table class="table">
			<thead style="background: #eee;">
				<tr style="border-bottom: solid 1px #eee;">
					<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
					<th > Name </th>
					<th> Combo Price </th>
					<th style="text-align:right;">Manage</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$inc=1;
					$total1=0;
					
					foreach($_SESSION['combo_list'] as $item){
						$rows41=get_row($conn, "select * from products where id='{$item['pid']}'");
						$rows42=get_row($conn, "select * from products_item where id='{$item['item_id']}'");
					?>
					<tr style="border-bottom:solid 1px #eee">
						<td><?php echo  $inc; ?></td>
						<td><?php echo  $rows41[0]['name']; ?></td>
						<td><?php echo  "Rs. ".$rows42[0]['combo_price']; ?></td>
						
						<td  style="text-align:right;">
							<a onclick="addcombo(<?php echo $item['item_id']; ?>,<?php echo $item['pid']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Close</a>
							
						</td>
					</tr>
					<?php $total1 = $total1+$rows42[0]['combo_price']; ?>
					
					<?php 
						if(isset($_SESSION['combo_list'])){ $combo_list = count($_SESSION['combo_list']); }else{ $combo_list = 0; }
						$count = count($rows82)+$combo_list;
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
						$img .= '<img style="float:left;'.$imagesize.';" src="'.$base_url_admin.'data/product_images/'.$rows42[0]['thumb_image'].'" draggable="false">';
					$inc++; } ?>
					<tr>
						<td colspan="3" style="text-align:right;"><b>Total Combo Price: </b></td><td style="text-align:right;"><b>Rs. <?php echo $total1; ?></td>
						</b></tr>
						<tr>
							<td colspan="3" style="text-align:right;"><b>Total Amount: </b></td><td style="text-align:right;"><b>Rs. <?php echo $total1+$total; ?></td>
							</b></tr>
			</tbody>
		</table>
	<?php } ?>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-12">
			<div class="form-group">
				<label style="padding-left:0;" class="control-label col-sm-9" for="email"><input type="text" placeholder="Combo Name" id="combo_name" value="<?php echo $rows81[0]['name']; ?>" class="form-control">
					<span id="comboname_help"  class="help-block"></span>
				</label>
				<div style="padding-right:0;" class="col-sm-3">
					<a onclick="savecombo($('#combo_name').val())" class="btn red pull-right" >Save Combo</a>
				</div>
			</div>
		</div>
		<?php if($rows81[0]['image_ack']=='2'){ ?>
			<script>
				$(document).ready(function(){
					$("#btnautocomboimg").removeClass('blue');
					$("#btnaddcomboimg").addClass('blue');
					$("#addcomboimg").show();
					$("#autocomboimg").hide();
					$("#image_selection").val('2');
				});
			</script>
		<?php } ?>
		<div class="col-md-6" style="padding-right: 0;">
			<a id="btnautocomboimg" onclick="comboimage(0)" style="border-radius:0;" class="btn blue btn-block btn-sm">Auto Image</a>
		</div>
		<div class="col-md-6" style="padding-left: 0;">
			<a id="btnaddcomboimg" onclick="comboimage(1)" style="border-radius:0;" class="btn btn-block btn-sm">Add Image</a>
		</div>
		
		<div class="col-md-12">
			<input type="hidden" id="image_selection" value="<?php echo $rows81[0]['image_ack']; ?>">
			<div id="autocomboimg" style="border: solid 1px #ccc;
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
								<div id="img_container3" class="fileupload-new thumbnail" style="height:280px;width:100%;">
									<?php echo $rows81[0]['image']; ?>
								</div>
								<div id="img_container2" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div>
								</br>
								<div>
									<span style="width:49%" class="btn btn-file btn-primary">
										<span class="fileupload-new">Select image</span>
										<span class="fileupload-exists">Change</span>
										<input type="file">
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