<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	$id = $_POST['id'];
?>


<hr>
<div id="box<?php echo $id; ?>">
	
	<div id="box_delete<?php echo $id; ?>" onclick="deleteitembox(<?php echo $id; ?>)" style="cursor:pointer;position: absolute;right: 49px;padding-top: 13px;color: #9a190f;"><i class="fa fa-times fa-2x" aria-hidden="true"></i></div>
	
	<input type="hidden" id="box_type<?php echo $id; ?>" name="box_type[]" value="insert">
	<div  id="box_ribbon<?php echo $id; ?>" style="width: 100%;text-align: left;padding: 10px;border: solid 1px #F44336;background: #ff6156;color: #fff;font-weight: bold;" >Variety <?php echo $id+1; ?>
	<span id="box_ribbon_text<?php echo $id; ?>"></span></div>
	<div id="box_head<?php echo $id; ?>">
		<div style="border-radius: 4px;border-top-left-radius:0;border-top-right-radius:0;padding: 15px;border: solid 1px #ccc;background: #f9f9f9;">
		     <div class="form-group">
				<label class="col-md-3 control-label">Item Name <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<input   type="text" class="form-control" placeholder="Enter Item Name" id="item_name<?php echo $id; ?>" name="item_name[]" required/>
					<span class="help-block"> </span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Description</label>
				<div class="col-md-9">
					<textarea id="item_desp<?php echo $id; ?>" name="item_desp[]"></textarea>
					<script>
						$(document).ready(function() {
							$('#item_desp<?php echo $id; ?>').summernote({
								height:150
							});
						});
					</script>
					<span class="help-block"> </span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Size / Color <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-6">
							<select class="form-control" name="size[]" required>
								<option value="">Select Size</option>
								
								<?php 
									$rows = get_row($conn, "select * from sizes");
									foreach($rows as $row){ ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6">
							<select class="form-control" id="color" name="color[]" required>
								<option value="">Select Color</option>
								
								<?php 
									$rows1 = get_row($conn, "select * from colors");
									foreach($rows1 as $row1){ ?>
									<option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Product M.R.P. <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<input onblur="setsaleprice(this.value, <?php echo $id; ?>)" type="number" min=1 class="form-control" placeholder="Enter Maximum Retail Price" id="mrp<?php echo $id; ?>" name="mrp[]" required/><span class="help-block"> </span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Sale Price <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<input onkeyup="setcomboprice(this.value,$( '#mrp<?php echo $id; ?>').val(), <?php echo $id; ?>)" type="number" min=1 class="form-control" placeholder="Enter Sale Price" id="price<?php echo $id; ?>" name="price[]" required/><span class="help-block help_price<?php echo $id; ?>"> </span>
				</div>
			</div>
			<!-- <div class="form-group">
				<label class="col-md-3 control-label">Sale Price</label>
				<div class="col-md-9">
					<input onkeyup="setcombowarning(this.value,$( '#price<?php //echo $id; ?>').val(), <?php //echo $id; ?>)" type="number" min=1 class="form-control" placeholder="Sale Price" id="combo_price<?php //echo $id; ?>" name="combo_price[]" required/><span class="help-block help_comboprice<?php //echo $id; ?>"> </span>
				</div>
			</div> -->
			<div class="form-group">
				<label class="col-md-3 control-label">Product Quantity <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<input type="number" min=0 class="form-control" placeholder="Enter Product Quantity" id="quantity" name="quantity[]" required/><span class="help-block"> </span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">SKU</label>
				<div class="col-md-9">
					<input value="" type="text" class="form-control" placeholder="SKU" name="sku[]" />
					<span class="help-block"> </span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Product Weight <span class="text-danger">*</span></label>
				<div class="col-md-6">
					<input type="text" class="form-control" placeholder="Enter Product Weight" id="weight" name="weight[]" required/><span class="help-block"> </span>
				</div>
				<div class="col-md-3">
					<select class="form-control" id="unit_type" name="unit_type[]" required>
						<option value="">Select <span class="text-danger">*</span></option>
						<option value="Kg">Kg</option>
						<option value="Gram">Gram</option>
						<option value="Liter">Liter</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Show Dimension</label>
				<div class="col-md-9">
					<div class="mt-radio-inline">
						<label class="mt-radio">
							<input onclick="showdimension(1,<?php echo $id; ?>)" type="radio" name="dimensionstatus<?php echo $id; ?>[]" value="1"> Show<span></span>
						</label>
						<label class="mt-radio">
							<input onclick="showdimension(0,<?php echo $id; ?>)" type="radio" name="dimensionstatus<?php echo $id; ?>[]" value="0" checked> Hide<span></span>
						</label>
					</div><span class="help-block"> </span>
				</div>
			</div>
			<div class="form-group" id="dimension<?php echo $id; ?>" style="display:none;">
				<label class="col-md-3 control-label">Dimension</label>
				<div class="col-md-9">
					<input type="text" class="form-control" placeholder="Enter Product Dimension" id="dimension" name="dimension[]" /><span class="help-block"> </span>
				</div>
			</div>
			<div class="row">
				<input type="hidden" name="image_type<?php echo $id; ?>[]" value="insert">
				<div class="col-md-4">
					<div class="form-group">
						<div class="col-sm-12 controls">
							<div class="">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new thumbnail" style="height:200px;width:100%;"><img style="height: 148px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image">
									</div>
									<div id="pro_image" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div>
									</br>
									<div><span style="width:49%" class="btn btn-file btn-primary"><span class="fileupload-new">Select image <span class="text-danger">*</span></span><span class="fileupload-exists">Change</span>
										<input name="img1<?php echo $id; ?>[]" accept="image/jpeg" type="file" required>
									</span><a href="#" style="width:49%" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="append<?php echo $id; ?>"></div>
			</div>
			<div class="form-actions">
				<button type="button" class="btn btn-danger btn-sm pull-right" onclick="append(<?php echo $id; ?>)">+ Add more</button>
			</div>
		</div>
	</div>
