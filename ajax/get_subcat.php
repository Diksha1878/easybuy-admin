<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	// print_r($_POST);
	if($_POST['table']=='cats')
	{
	?>
	<div class="form-group">
		<label class="col-md-3 control-label">Select Category</label>
		<div class="col-md-9">
			<select class="form-control" id="cat" name="cat"  onchange="get_subcat(this.value)" required>
				
				<option value="">Select</option>
				<?php 
					$get_cat=$conn->query("select * from cats where status='1'");
					while($cat=mysqli_fetch_assoc($get_cat))
					{
					?>
					
					<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
					<?php
						
					}
				?>
				
			</select>
		</div>
	</div>
	<?php
	}
	if($_POST['table']=='subcats')
	{
	?>
	<div class="form-group">
		<label class="col-md-3 control-label">Select Sub Category</label>
		<div class="col-md-9">
			<select class="form-control" id="subcat" name="subcat"  onchange="get_brand(this.value)">
				
				<option value="0">Select</option>
				<?php 
					$get_cat=$conn->query("select * from subcats where cat_id='{$_POST['id']}' and status='1'");
					while($cat=mysqli_fetch_assoc($get_cat))
					{
					?>
					
					<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
					<?php
						
					}
				?>
				
			</select>
		</div>
	</div>
	<?php
	}
	if($_POST['table']=='brands')
	{
	?>
	<div class="form-group">
		<label class="col-md-3 control-label">Select brand</label>
		<div class="col-md-9">
			<select class="form-control" id="brand" name="brand">
				
				<option value="">Select</option>
				<?php 
					$get_cat=$conn->query("select * from brands where subcat_id='{$_POST['id']}'");
					while($cat=mysqli_fetch_assoc($get_cat))
					{
					?>
					
					<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
					<?php
						
					}
				?>
				
			</select>
		</div>
	</div>
	<?php
	}
	
	
?>