<?php session_start(); 
	include('includes/config.php');
?>


<!DOCTYPE html>

<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
        <title>Admin Panel</title>
        <?php include('includes/head.php'); ?>
		
	</head>
	
	
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php
			
			if(isset($_POST['update'])){
				
				$name=trim(mysqli_real_escape_string($conn , $_POST['name']));
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
					if(isset($_FILES['img1']) && $_FILES['img1']['name']){
						$errors= array();
						
						$rand=rand(1111,9999);
						$ext = pathinfo($_FILES['img1']['name'], PATHINFO_EXTENSION);
						$img1_name= "IMG"."-".date("Ymdhis").$rand.".".$ext;
						$img1_tmp=$_FILES['img1']['tmp_name'];
						
						$desired_dir="data/cat_images/";
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
						
						
						$thumb_width = 150;
						$thumb_height = 150;
						
						
						img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
						$conn->query("update cats set image='$thumb', updated_at='$date' where id='$id'");
					}
					
					$conn->query("update cats set name='$name' $status , modify_date='$date', updated_at='$date' where id='$id'");
				}
				
				
				//echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
			}
			
			if(isset($_POST['save_data']))
			{
				
				
				
				//$department=trim(mysqli_real_escape_string($conn , $_POST['department']));
				$department = 0;
				$status=trim(mysqli_real_escape_string($conn , $_POST['status']));
				$x=0;
				foreach($_POST['name'] as $name){
					
					$catname=trim(mysqli_real_escape_string($conn , $name));
					if($catname!='')
					{
						//start
						$image_count=count($_FILES['img1']['name']);
						
						if(isset($_FILES['img1']) && $_FILES['img1']['name'][$x]){
							$errors= array();
							
							$rand=rand(1111,9999);
							$ext = pathinfo($_FILES['img1']['name'][$x], PATHINFO_EXTENSION);
							$img1_name= "IMG".$x."-".date("Ymdhis").$rand.".".$ext;
							$img1_tmp=$_FILES['img1']['tmp_name'][$x];
							
							$desired_dir="data/cat_images/";
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
							$thumb_file = $desired_dir."thumb_".$img1_name;

							$ext = pathinfo($target_file, PATHINFO_EXTENSION);
							
							
							$thumb = "thumb_".$img1_name;
							
							
							$thumb_width = 150;
							$thumb_height = 150;
							
							
							img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
							
						}
						else{
							$thumb = "";
						}
						$conn->query("insert into cats(department_id,name,status,create_date,image,created_at) values('$department','$catname','$status','$date','$thumb','$date')");
						/* end image insert */
						//end
						
						
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
						$("#append").append('<div class="form-group"><label class="col-md-3 control-label">Image</label><div class="col-md-9"><input type="file" class="form-control" name="img1[]"><span class="help-block"> </span></div></div><div class="form-group"><label class="col-md-3 control-label">Category Name</label><div class="col-md-9"><input type="text" class="form-control" placeholder="Enter Category Name" name="name[]"><span class="help-block"> </span></div></div>');
					}
					function del_data(id)
					{
						
						var conf=confirm("Do you want to Delete ?");
						if(conf==1)
						{
							$.ajax({
								type:"post",
								url:"ajax/delete.php",
								data:{table:'cats',  id:id},
								success:function (res)
								{
									
									window.location.reload();
								}
								
							});
						}
						
						
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
                                    <span>Main Category</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title"> Main Category
                            
						</h1>
						
                        <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Category</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											<!-- <div class="form-group">
												<label class="col-md-3 control-label">Select Department</label>
												<div class="col-md-9">
												<select class="form-control" name="department" required>
												
												<option value="">Select</option>
												<?php 
													// $get_cat=$conn->query("select * from departments");
													// while($cat=mysqli_fetch_assoc($get_cat))
													{
													?>
													
													<option value="<?php // echo $cat['id']; ?>"><?php //echo $cat['name']; ?></option>
													<?php
														
													}
												?>
												
												</select>
												</div>
											</div> -->
											<div class="form-group">
												<label class="col-md-3 control-label">Image</label>
												<div class="col-md-9">
													<input type="file" class="form-control" name="img1[]">
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Category Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter Category Name" name="name[]">
													<span class="help-block"> </span>
												</div>
											</div>
											
											<div id="append"></div>
											
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
													<button type="button" class="btn btn-danger btn-sm" onclick="append()">+ Add more</button>
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
										<i class="fa fa-globe"></i>All Categories </div>
                                        <div class="tools"> </div>
									</div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th> S No. </th>
                                                    <th> Date </th>
                                                    <th> Modify  Date </th>
													
                                                    <th> Category Name </th>
                                                    <th> Image </th>
                                                    <th> Status </th>
                                                    <th> Change </th>
                                                    <th style="width:230px;"> Manage </th>
												</tr>
											</thead>
                                            <tbody>
												<?php 
													$get_cat=$conn->query("select  * from cats order by id desc");
													if(mysqli_num_rows($get_cat)==0)
													{
													}
													
													else{
														$x = 0;
														while($cat=mysqli_fetch_assoc($get_cat)){
															
														?>
														
														<tr>
															<td><?php echo ($x+1); ?></td>
															<td>
																<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
																<?php echo $cat['create_date']; ?> 
																<span style="height:0;display:none;"><?php echo $cat['name']; ?></span>
																</td>
																<td><?php echo $cat['modify_date']; ?>  </td>
																
																
																<td> <input type="text" class="form-control" value="<?php echo $cat['name']; ?>" name="name" > </td>
																<td style="width:200px;"><img width="60" height="60" src="data/cat_images/<?php if($cat['image']!=''){ echo $cat['image']; }else{ echo 'default_image.png'; }  ?>"><input type="file" name="img1"></td>
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
																	$cat_change = get_row($conn, "select * from products where cat_id='{$cat['id']}'");
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
