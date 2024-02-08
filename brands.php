<?php session_start(); 
	include('includes/config.php');
?>


<!DOCTYPE html>

<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
        <title>Brands | Admin Panel</title>
        <?php include('includes/head.php'); ?>
		
	</head>
	
	
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php
			
			if(isset($_POST['update'])){
				
				
				
				$name=trim(mysqli_real_escape_string($conn , $_POST['name']));
				$link=trim(mysqli_real_escape_string($conn , $_POST['link']));
				$id=$_POST['id'];
				if(isset($_POST['status']))
				{
					$status=$_POST['status'];
					$status=" , status=$status";
				}
				else{
					$status=" ";
				}
				if($name!='')
				{
				$x = 0;
						if(isset($_FILES['img1']) && $_FILES['img1']['name'][$x]){
						
						$errors= array();
						
						$rand=rand(1111,9999);
						$ext = pathinfo($_FILES['img1']['name'][$x], PATHINFO_EXTENSION);
						$img1_name= "IMG"."-".date("Ymdhis").$rand.".".$ext;
						$img1_tmp=$_FILES['img1']['tmp_name'][$x];
						
						$desired_dir="data/brands/";
						if(empty($errors)==true){
							if(is_dir($desired_dir)==false){
								mkdir("$desired_dir", 0700); // Create directory if it does not exist
							}
							
							move_uploaded_file($img1_tmp,"$desired_dir/".$img1_name);
							
						}
						else{	// rename the file if another one exist
							$new_dir="$desired_dir/".$file_name.time();
							rename($file_tmp,$new_dir) ;				
						}
						
						$conn->query("update brands set image='$img1_name',updated_at='$date' where id='$id'");
					}
					$conn->query("update brands set link='$link', name='$name' $status , modify_date='$date', updated_at='$date' where id='$id'");
				}
				
				
				echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
			}
			if(isset($_POST['save_data']))
			{
				/* echo "<pre>";
				print_r($_POST); */
				
				
				//$cat_id=trim(mysqli_real_escape_string($conn , $_POST['cat']));
				//$subcat_id=trim(mysqli_real_escape_string($conn , $_POST['subcat']));
				//$department=trim(mysqli_real_escape_string($conn , $_POST['department']));
				//$get_cat=$conn->query("select * from cat where id='$cat_id'");
				//$cat_info=mysqli_fetch_assoc($get_cat);
				//$category_name=trim(mysqli_real_escape_string($conn , $cat_info['name']));
				//$get_subcat=$conn->query("select * from subcat where id='$subcat_id'");
				//$subcat_info=mysqli_fetch_assoc($get_subcat);
				//$subcat_name=trim(mysqli_real_escape_string($conn , $subcat_info['name']));
				
				$status=trim(mysqli_real_escape_string($conn , $_POST['status']));
				$x = 0;
				
				foreach($_POST['name'] as $name){
					
					$link=trim(mysqli_real_escape_string($conn , $_POST['link'][$x]));
					
					
					if(isset($_FILES['img1']) && $_FILES['img1']['name'][$x]){
						
						$errors= array();
						
						$rand=rand(1111,9999);
						$ext = pathinfo($_FILES['img1']['name'][$x], PATHINFO_EXTENSION);
						$img1_name= "IMG"."-".date("Ymdhis").$rand.".".$ext;
						$img1_tmp=$_FILES['img1']['tmp_name'][$x];
						
						$desired_dir="data/brands/";
						if(empty($errors)==true){
							if(is_dir($desired_dir)==false){
								mkdir("$desired_dir", 0700); // Create directory if it does not exist
							}
							
							move_uploaded_file($img1_tmp,"$desired_dir/".$img1_name);
							
						}
						else{	// rename the file if another one exist
							$new_dir="$desired_dir/".$file_name.time();
							rename($file_tmp,$new_dir) ;				
						}
						
						// $ext=".jpg";
						include_once('functions/img_resize.php');
						$target_file = $desired_dir.$img1_name;
						$thumb_file = $desired_dir."update_thumb_".$img1_name;
						$ext = pathinfo($target_file, PATHINFO_EXTENSION);
						
						$thumb = "update_thumb_".$img1_name;
						
						
						$thumb_width = 300;
						$thumb_height = 150;
						
						
						img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
						//$conn->query("update cat set image='$thumb' where id='$id'");
					}
					else{
						$thumb = "";
					}
					
					$catname=trim(mysqli_real_escape_string($conn , $name));
					if($catname=='')
					{
						
					}
					else{
						
						
						$insert=$conn->query("insert into brands set image='$thumb', link='$link', name='$catname' , status='$status' , create_date='$date',created_at='$date' ");
					}
					
					$x++;
				}
				
				
				echo '<script>alert("Data Saved Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
			}
			
		?>
        <div class="page-wrapper">
			
			<?php include('includes/header.php'); ?>
			
            <div class="clearfix"> </div>
			
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <?php include('includes/nav.php'); ?>
				<script>
					function append()
					{
						$("#append").append('<div class="form-group"><label class="col-md-3 control-label">Brand Name</label><div class="col-md-9"><input type="text" class="form-control" placeholder="Enter Brand Name" name="name[]"><span class="help-block"> </span></div></div>');
					}
					function del_data(id)
					{
						
						var conf=confirm("Do you want to Delete ?");
						if(conf==1)
						{
							$.ajax({
								type:"post",
								url:"ajax/delete.php",
								data:{table:'brands',  id:id},
								success:function (res)
								{
									// console.log(res);
									window.location.reload();
								}
								
							});
						}
						
						
					}
					function get_cat(id)
					{
						
						$.ajax({
							type:"post",
							url:"ajax/get_subcat.php",
							data:{table:'cat', id:id},
							success:function (res)
							{
								//console.log(res);
								$("#append_cat").append(res);
							}
							
						});
					}
					function get_subcat(id)
					{
						
						
						$.ajax({
							type:"post",
							url:"ajax/get_subcat.php",
							data:{table:'subcat',  id:id},
							success:function (res)
							{
								//console.log(res);
								$("#append_subcat").html(res);
								
							}
							
						});
					}
					
					
				</script>
				
                <div class="page-content-wrapper">
					
                    <div class="page-content">
                        
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="./">Home</a>
                                    <i class="fa fa-circle"></i>
								</li>
                                <li>
                                    <span>Brands</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title"> Brands
                            
						</h1>
						
                        <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Brands</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											<!-- <div class="form-group">
												<label class="col-md-3 control-label">Select Department</label>
												<div class="col-md-9">
												<select class="form-control" name="department" onchange="get_cat(this.value)" required>
												
												<option value="">Select</option>
												<?php 
													// $get_cat=$conn->query("select * from departments");
													// while($cat=mysqli_fetch_assoc($get_cat))
													{
													?>
													
													<option value="<?php //echo $cat['id']; ?>"><?php // echo $cat['name']; ?></option>
													<?php
														
													}
												?>
												
												</select>
												</div>
												</div>
												<div id="append_cat"></div>
												<div id="append_subcat"></div>
												
											--> 
											
											
											<div class="form-group">
												<label class="col-md-3 control-label">Brand Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter Brand Name" name="name[]" required/>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Link</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter Brand Name" name="link[]" required/>
													<span class="help-block"> </span>
												</div>
											</div>
											<div id="append"></div>
											<div class="form-group">
												<label class="col-md-3 control-label">Image</label>
												<div class="col-md-9">
													<input type="file" class="form-control" name="img1[]">
													<span class="help-block"> </span>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Status</label>
												<div class="col-md-9">
													<div class="mt-radio-inline">
														<label class="mt-radio">
															<input type="radio" name="status"  value="1" checked=""> Active
															<span></span>
														</label>
														<label class="mt-radio">
															<input type="radio" name="status" value="0" > In-Active
															<span></span>
														</label>
														
													</div>
												</div>
												
											</div>
											<div class="form-group pull-right">
												<div class="col-md-12 ">
													<button type="submit" class="btn green btn-sm" name="save_data">Submit</button>
													<button type="button" class="btn default btn-sm">Cancel</button>
													<!-- <button type="button" class="btn btn-danger btn-sm" onclick="append()">+ Add more</button> -->
												</div>
											</div>
											
											<br/>
											<br/>
										</form>
									</div>
								</div>
								
							</div>
						</div>
						
						
						
						<div class="row">
                            <div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption">
										<i class="fa fa-globe"></i>All Brands </div>
                                        <div class="tools"> </div>
									</div>
									
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
													
													
													
                                                    <th> S No. </th>
                                                    <th> Name </th>
                                                    <th> Link </th>
                                                    <th> Image </th>
                                                    <th> Status </th>
                                                    <th> Change </th>
                                                    <th> Manage </th>
												</tr>
											</thead>
                                            <tbody>
												<?php 
													$get_cat=$conn->query("select * from brands order by id asc");
													if(mysqli_num_rows($get_cat)==0)
													{
													}
													
													else{
														$x = 0;
														while($cat=mysqli_fetch_assoc($get_cat)){
															
														?>
														
														<tr>
															
															<td>
																<form enctype="multipart/form-data" class="form-horizontal" method="post" action="">
																	<?php echo ($x+1); ?>
																</td>
																
																
																
																<td> <input type="text" class="form-control" value="<?php echo $cat['name']; ?>" name="name" > </td>
																<td> <input type="text" class="form-control" value="<?php echo $cat['link']; ?>" name="link" > </td>
																<td>
																<img style="width:100px;height:100px;" src="data/brands/<?php echo $cat['image']; ?>">
																<br/>
																<input type="file" name="img1[]">
																</td>
																<td>   <div class="mt-radio-inline">
																	
																	<?php if($cat['status']=='1'){ echo 'Active';}else{ echo 'In-Active'; }  ?>
																	<span></span>
																</div> </td>
																<td> 
																	
																	
																	<div class="mt-checkbox-inline">
																		<label class="mt-checkbox">
																			<?php if($cat['status']=='1'){ echo '<input type="checkbox" name="status" id="inlineCheckbox21" value="0"> In-Active';} else{ echo '<input type="checkbox" name="status"  value="1"> Active'; }  ?>
																			
																			<span></span>
																		</label>
																		
																	</div>
																</td> 
																<td> 
																	<input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
																	<button type="submit" name="update" class="btn btn-warning btn-sm">Update</button>
																</form>
																<?php 
																	$cat_change = get_row($conn, "select * from products where brand_id='{$cat['id']}'");
																	if(!count($cat_change)){
																	?>
																<button type="button" class="btn btn-primary btn-sm" onclick="del_data(<?php echo $cat['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
																	<?php } ?>
															</td>
														</tr>
														
														<?php
														$x++; }
														
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
                                <!-- END EXAMPLE TABLE PORTLET-->
							</div>
						</div>
						
					</div>
					<!-- END CONTENT BODY -->
				</div>
				
			</div>
			<!-- END CONTAINER -->
			<!-- BEGIN FOOTER -->
			<?php include('includes/footer.php'); ?>
			<!-- END FOOTER -->
		</div>
		
		<!-- BEGIN CORE PLUGINS -->
		<?php include('includes/footer_js.php'); ?>
		<!-- END THEME LAYOUT SCRIPTS -->
		
		<!-- End Google Tag Manager -->
	</body>
