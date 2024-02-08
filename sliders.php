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
				
				$title=trim(mysqli_real_escape_string($conn , $_POST['title']));
				$name=trim(mysqli_real_escape_string($conn , $_POST['name']));
				$desp=trim(mysqli_real_escape_string($conn , $_POST['desp']));
				$link=trim(mysqli_real_escape_string($conn , $_POST['link']));
				$text_color=trim(mysqli_real_escape_string($conn , $_POST['text_color']));
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
						
						$img1_name= "IMG"."-".date("Ymdhis").$rand.".jpg";
						$img1_tmp=$_FILES['img1']['tmp_name'];
						
						$desired_dir="data/offers/";
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
						
						
					    $thumb_width = 1280;
						$thumb_height = 720;
						
						
						img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
						$conn->query("update offers set image='$thumb', updated_at='$date' where id='$id'");
						unlink($target_file);
					}
					
					$conn->query("update offers set text_color='$text_color', title='$title',desp='$desp',link='$link',updated_at='$date',name='$name' $status , modify_date='$date' where id='$id'");
				}
				
				
				echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
			}
			if(isset($_POST['save_data']))
			{
				
				
				
				//$department=trim(mysqli_real_escape_string($conn , $_POST['department']));
				$status=trim(mysqli_real_escape_string($conn , $_POST['status']));
				$x=0;
				foreach($_POST['name'] as $name){
					
					$catname=trim(mysqli_real_escape_string($conn , $name));
					$title=trim(mysqli_real_escape_string($conn , $_POST['title'][$x]));
					$desp=trim(mysqli_real_escape_string($conn , $_POST['desp'][$x]));
					$link=trim(mysqli_real_escape_string($conn ,  $_POST['link'][$x]));
					$text_color=trim(mysqli_real_escape_string($conn ,  $_POST['text_color'][$x]));
					if($catname!='')
					{
						//start
						$image_count=count($_FILES['img1']['name']);
						
						if(isset($_FILES['img1']) && $_FILES['img1']['name'][$x]){
							$errors= array();
							
							$rand=rand(1111,9999);
							
							$img1_name= "IMG".$x."-".date("Ymdhis").$rand.".jpg";
							$img1_tmp=$_FILES['img1']['tmp_name'][$x];
							
							$desired_dir="data/offers/";
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
							$thumb_file = $desired_dir."thumb_".$img1_name;
							
							
							$thumb = "thumb_".$img1_name;
							
							
						    $thumb_width = 1280;
						    $thumb_height = 720;
							
							
							img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
							unlink($target_file);
							
						}
						else{
							$thumb = "";
						}
						$conn->query("insert into offers(name,status,create_date,image,desp,link,created_at,title,text_color) values('$catname','$status','$date','$thumb','$desp','$link','$date','$title', '$text_color')");
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
								data:{table:'offers',  id:id},
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
                                    <span>Sliders</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title"> Sliders </h1>
						
                        <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Slider</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											<div class="form-group">
												<label class="col-md-3 control-label">Image</label>
												<div class="col-md-9">
												    
													<input type="file" class="form-control" name="img1[]" accept="image/jpeg,image/jpg">
													<small class="text-info">Dimension: 1280x720</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Title</label>
												<div class="col-md-9">
													<input maxlength="50" type="text" class="form-control" placeholder="Enter Title" name="title[]">
														<small class="text-info">Max length: 50</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Name</label>
												<div class="col-md-9">
													<input maxlength="80" type="text" class="form-control" placeholder="Enter Name" name="name[]">
														<small class="text-info">Max length: 80</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Description</label>
												<div class="col-md-9">
												<textarea maxlength="100" type="text" class="form-control" placeholder="Enter Description" name="desp[]"></textarea>
													<small class="text-info">Max length: 100</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Text Color</label>
												<div class="col-md-9">
													<input type="color" class="form-control" placeholder="Enter Text Color" name="text_color[]" value="#555555">
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Link</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter link" name="link[]">
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
													
												</div>
											</div>
											
											<br/>
											<br/>
											
										</form>
									</div>
								</div>
								
							</div>
						</div>
						
						<!-- <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Offers Related Products</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											
											<div class="form-group">
												<label class="col-md-3 control-label">Select Offers</label>
												<div class="col-md-9">
													<select class="form-control" name="offer_id" id="offer_id">
														<option value="">select</option>
														<?php 
															$offers = get_row($conn, "select * from offers where status='1'");
															foreach($offers as $offer){
															?>
															<option value="<?php echo $offer['id']; ?>"><?php echo $offer['name']; ?></option>
														<?php } ?>
													</select>
													<span class="help-block"> </span>
												</div>
											</div>
											<script>
												function searchProduct(key){
													var offer_id = $('#offer_id').val();
													if(offer_id){
														$.ajax({
															type:'post',
															data:{
																key:key,
																offer_id:offer_id
															},
															url:'ajax/get_product_list.php',
															success:function(result){
																$('#product_lists').html(result);
															}
														});
													}
													
												}
												
												function setOffers(item_id,offer_id){
													
													$.ajax({
														type:'post',
														data:{
															item_id:item_id,
															offer_id:offer_id
														},
														url:'ajax/set_offers.php',
														success:function(result){
															console.log(result);
														}
													});
												}
											</script>
											<div class="form-group">
												<label class="col-md-3 control-label">Search Product</label>
												<div class="col-md-9">
													<input autocomplete="off" onkeyup="searchProduct(this.value)" id="key" type="text" class="form-control" placeholder="Enter Name" name="name[]">
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">List</label>
												<div class="col-md-9">
													<ul style="list-style:none;padding-left:0" id="product_lists">
														<li>Products List</li>
													</ul>
													<span class="help-block"> </span>
												</div>
											</div>
											
											
											
											<br/>
											<br/>
											
										</form>
									</div>
								</div>
								
							</div>
						</div> -->
						
						
						
						<div class="row">
                            <div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption">
										<i class="fa fa-globe"></i>All Sliders </div>
                                        <div class="tools"> </div>
									</div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                                            <thead>
                                                <tr>
                                                    <th> Date </th>
                                                    <th> Modify  Date </th>
                                                     <th> Manage </th>
													<th> Title </th>
                                                    <th> Name </th>
                                                    <th> Color </th>
                                                    <th> Image </th>
                                                    <th> Description </th>
                                                    <th> Link </th>
                                                    <th> Status </th>
                                                    <th> Change </th>
                                                   
												</tr>
											</thead>
                                            <tbody>
												<?php 
													$get_cat=$conn->query("select  * from offers order by id desc");
													if(mysqli_num_rows($get_cat)==0)
													{
													}
													
													else{
														while($cat=mysqli_fetch_assoc($get_cat)){
															
														?>
															
														<tr>
															<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
															<td>
															
																<?php echo $cat['create_date']; ?> </td>
																<td><?php echo $cat['modify_date']; ?>  </td>
																<td> 
																	<input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
																	<button style="margin-bottom:8px" type="submit" name="update" class="btn btn-warning btn-sm btn-block">Update</button>
															
																<button type="button" class="btn btn-primary btn-sm btn-block" onclick="del_data(<?php echo $cat['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
															</td>
																<td> <textarea style="width:200px" maxlength="50" type="text" class="form-control" name="title" ><?php echo $cat['title']; ?></textarea> <small class="text-info">Max length: 50</small></td>
																<td> <textarea style="width:200px"  maxlength="80" type="text" class="form-control" name="name" ><?php echo $cat['name']; ?></textarea>
																	<small class="text-info">Max length: 80</small>
																</td>
																<td> <input style="width:30px;padding:2px"  type="color" class="form-control" value="<?php echo $cat['text_color']; ?>" name="text_color" >
															
																</td>
																<td style="width:200px;"><img class="img-thumbnail" style="width:160px;height:90px" src="data/offers/<?php if($cat['image']!=''){ echo $cat['image']; }else{ echo 'default_image.png'; }  ?>"><input type="file" name="img1">	<small class="text-info">Dimension: 1280x720</small></td>
																<td> <textarea style="width:200px;" maxlength="100" type="text" class="form-control" name="desp" ><?php echo $cat['desp']; ?></textarea> 
																<small class="text-info">Max length: 100</small>
																</td>
																<td> <input style="width:200px;" type="text" class="form-control" value="<?php echo $cat['link']; ?>" name="link" > </td>
																<td>   <div class="mt-radio-inline">
																	
																	<?php if($cat['status']=='1'){ echo 'Active';}else{ echo 'In-Active'; }  ?>
																	<span></span>
																</div> </td>
																<td> 
																	
																	
																	<div class="mt-checkbox-inline">
																		<label class="mt-checkbox">
																			<?php if($cat['status']=='1'){ echo '<input type="checkbox" name="status" id="inlineCheckbox21" value="0"> Inactive';} else{ echo '<input type="checkbox" name="status"  value="1"> Active'; }  ?>
																			
																			<span></span>
																		</label>
																		
																	</div>
																</td> 
																</form>	
														</tr>
														
														<?php
														}
														
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
