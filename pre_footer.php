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
				
				$name1=trim(mysqli_real_escape_string($conn , $_POST['name1']));
				$name2=trim(mysqli_real_escape_string($conn , $_POST['name2']));
				$name3=trim(mysqli_real_escape_string($conn , $_POST['name3']));
				$name4=trim(mysqli_real_escape_string($conn , $_POST['name4']));
				$id=$_POST['id'];
				
				if($name1!='' && $name2!='' && $name3!='' && $name4!=''){
				
					/* if(isset($_FILES['img1']) && $_FILES['img1']['name']){
						$errors= array();
						
						$rand=rand(1111,9999);
						
						$img1_name= "IMG"."-".date("Ymdhis").$rand.".jpg";
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
						
						$ext=".jpg";
						include_once('functions/img_resize.php');
						$target_file = $desired_dir.$img1_name;
						$thumb_file = $desired_dir."update_thumb_".$img1_name;
						
						
						$thumb = "update_thumb_".$img1_name;
						
						
						$thumb_width = 150;
						$thumb_height = 150;
						
						
						img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
						$conn->query("update cat set image='$thumb' where id='$id'");
					} */
					
					$conn->query("update pre_footer set box1_text='$name1', box2_text='$name2', box3_text='$name3', box4_text='$name4' where id='$id'");
				}
				
				
				echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
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
								data:{table:'cat',  id:id},
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
                                    <a href="index-2.html">Home</a>
                                    <i class="fa fa-circle"></i>
								</li>
                                <li>
                                    <span>Pre Footer</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title"> Pre Footer
                            
						</h1>
						
                      
						
						<div class="row">
                            <div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption">
										<i class="fa fa-globe"></i>Pre Footer </div>
                                        <div class="tools"> </div>
									</div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th> Text </th>
                                                    
                                                    
                                                    <th> Manage </th>
												</tr>
											</thead>
                                            <tbody>
												<?php 
													$get_cat=$conn->query("select  * from pre_footer order by id asc");
													$pre_footer=mysqli_fetch_assoc($get_cat);
															
														?>
														
														<tr>
															
															<td>
																<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
																<input type="text" class="form-control" name="name1" value="<?php echo $pre_footer['box1_text']; ?>">
																<br/>
																<input type="text" class="form-control" name="name2" value="<?php echo $pre_footer['box2_text']; ?>">
																<br/>
																<input type="text" class="form-control" name="name3" value="<?php echo $pre_footer['box3_text']; ?>">
																<br/>
																<input type="text" class="form-control" name="name4" value="<?php echo $pre_footer['box4_text']; ?>">
																</td>
																<td> 
																	<input type="hidden" name="id" value="<?php echo $pre_footer['id']; ?>">
																	
																	<button type="submit" name="update" class="btn btn-warning btn-sm">Update</button>
																</form>
																
															</td>
														</tr>
														
												
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
