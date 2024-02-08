<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	
	if(isset($_SESSION['combo_list']) && count($_SESSION['combo_list'])!=0){
	?>
	<h3 style="margin-top:0">Combo Box</h3>
	<table class="table">
		<thead style="background: #eee;">
			<tr style="border-bottom: solid 1px #eee;">
				<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
				<th > Name </th>
				<th> Combo Price </th>
				<th style="width: 70px;">Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$inc=1;
				$img = '';
				
				foreach($_SESSION['combo_list'] as $item){
					$rows41=get_row($conn, "select * from products where id='{$item['pid']}'");
					$rows42=get_row($conn, "select * from products_item where id='{$item['item_id']}'");
				?>
				<tr style="border-bottom:solid 1px #eee">
					<td><?php echo  $inc; ?></td>
					<td><?php echo  $rows41[0]['name']; ?></td>
					<td><?php echo  "Rs. ".$rows42[0]['combo_price']; ?></td>
					
					<td>
						<a onclick="addcombo(<?php echo $item['item_id']; ?>,<?php echo $item['pid']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Close</a>
						
					</td>
				</tr>
				
				<?php 
					$count = count($_SESSION['combo_list']);
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
		</tbody>
	</table>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-md-12">
			<div class="form-group">
				<label style="padding-left:0;" class="control-label col-sm-9" for="email"><input type="text" placeholder="Combo Name" id="combo_name" class="form-control">
					<span id="comboname_help"  class="help-block"></span>
				</label>
				<div style="padding-right:0;" class="col-sm-3">
					<a onclick="savecombo($('#combo_name').val())" class="btn red pull-right" >Add Combo</a>
				</div>
			</div>
		</div>
		<div class="col-md-6" style="padding-right: 0;">
			<a id="btnautocomboimg" onclick="comboimage(0)" style="border-radius:0;" class="btn blue btn-block btn-sm">Auto Image</a>
		</div>
		<div class="col-md-6" style="padding-left: 0;">
			<a id="btnaddcomboimg" onclick="comboimage(1)" style="border-radius:0;" class="btn btn-block btn-sm">Add Image</a>
		</div>
		
		<div class="col-md-12">
			<input type="hidden" id="image_selection" value="1">
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
								<div class="fileupload-new thumbnail" style="height:280px;width:100%;">
									<img style="height: 280px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image" draggable="false">
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
<?php } ?>