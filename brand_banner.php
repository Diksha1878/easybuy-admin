<?php session_start(); 
	include('includes/config.php');
?>
<?php
	if(isset($_POST['addbrand'])){
		
		$img1_name = "";
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$link = mysqli_real_escape_string($conn, $_POST['link']);
		
		$image_count=count($_FILES['img1']['name']);
		$datex = date("Y-m-d H:i:s");
		
		for($x=0;$x<$image_count;$x++){
			
			if(isset($_FILES['img1']) && $_FILES['img1']['name'][$x]){
				$errors= array();
				
				$rand=rand(1111,9999);
				$ext = pathinfo($_FILES['img1']['name'][$x] , PATHINFO_EXTENSION);
				$img1_name= "IMG-".date("YmdHis")."-".rand().".".$ext;
				$img1_tmp=$_FILES['img1']['tmp_name'][$x];
				
				$desired_dir="data/banner/";
				if(empty($errors)==true){
					if(is_dir($desired_dir)==false){
						mkdir("$desired_dir", 0700);		// Create directory if it does not exist
					}
					
					move_uploaded_file($img1_tmp,"$desired_dir/".$img1_name);
					
				}
				else{									// rename the file if another one exist
					$new_dir="$desired_dir/".$file_name.time();
					rename($file_tmp,$new_dir) ;				
					
					// $mysqli->query($query);		
					
					
				}
				
				
				
			}
			
		}
		
		$mysqli->query("INSERT INTO brand_banner (name,link,date,image) VALUES('{$name}','{$link}','{$datex}','{$img1_name}')");
		
		echo '<font style="color:#047402">'.$_POST['name']. ' is added to the Brands successfully.'.'</font>';
	}
	
	if(isset($_POST['update'])){
		
		$img1_name = "";
		$id = mysqli_real_escape_string($conn, $_POST['id']);
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$link = mysqli_real_escape_string($conn, $_POST['link']);
		
		$image_count=count($_FILES['img1']['name']);
		$datex = date("Y-m-d H:i:s");
		
		for($x=0;$x<$image_count;$x++){
			
			if(isset($_FILES['img1']) && $_FILES['img1']['name'][$x]){
				$errors= array();
				
				$rand=rand(1111,9999);
				$ext = pathinfo($_FILES['img1']['name'][$x] , PATHINFO_EXTENSION);
				$img1_name= "IMG-".date("YmdHis")."-".rand().".".$ext;
				$img1_tmp=$_FILES['img1']['tmp_name'][$x];
				
				$desired_dir="data/banner/";
				if(empty($errors)==true){
					if(is_dir($desired_dir)==false){
						mkdir("$desired_dir", 0700);		// Create directory if it does not exist
					}
					
					move_uploaded_file($img1_tmp,"$desired_dir/".$img1_name);
					
				}
				else{									// rename the file if another one exist
					$new_dir="$desired_dir/".$file_name.time();
					rename($file_tmp,$new_dir) ;				
					
					// $mysqli->query($query);		
					
					
				}
				$mysqli->query("update brand_banner set image='{$img1_name}' where id='{$id}'");
				
				
			}
			
		}
		
		$mysqli->query("update brand_banner set name='{$name}', link='{$link}' where id='{$id}'");
		
		echo '<font style="color:#047402">'.$_POST['name']. ' is added to the Brands successfully.'.'</font>';
	}
	
	if(isset($_POST['delete_item'])){
		$conn->query("delete from brand_banner where id='{$_POST['id']}'");
	}
?>

<!DOCTYPE html>

<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
        <title>Admin Panel</title>
        <?php include('includes/head.php'); ?>
		
	</head>
	
	
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
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
                                    <span>Brand Banner</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title">Brand Banner</h1>
						
                        <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Brand Banner</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											
											<div class="form-group">
												<label class="col-md-3 control-label">Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter Name" name="name">
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Link</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter Link" name="link">
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Image</label>
												<div class="col-md-9">
													<input type="file" class="form-control" name="img1[]">
													<span class="help-block"> </span>
												</div>
											</div>
											
											
											<div class="form-group pull-right">
												<div class="col-md-12 ">
													<button type="submit" class="btn green btn-sm" name="addbrand">Submit</button>
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
                                                   <th>#</th>
														<th>Name</th>
														
														<th>Link</th>
														<th>Image</th>
														<th>Date</th>
														<th>Manage</th>
												</tr>
											</thead>
                                            <tbody>
												<?php 
														
														$query = $mysqli->query("SELECT * FROM brand_banner order by id desc");
														
														//$q="SELECT * FROM products";
														while($row = mysqli_fetch_array($query)){
															
														?>
														<tr class="odd pointer">
															
															<td class=" ">
																<form action="" method="post" enctype="multipart/form-data">
																<?php echo $row['id']; ?></td>
															<td class=" ">
																<input name="name" type="text" value="<?php echo $row['name']; ?>" class="form-control"></td>
															<td class=" ">
																<input name="link" type="text" value="<?php echo $row['link']; ?>" class="form-control"></td>
															<td class=" "><?php echo $row['date']; ?></td>
															<td class=" ">
															<img style="width:100px;height:100px;" src="data/banner/<?php echo $row['image']; ?>">
																<br/>
																<input type="file" name="img1[]">
																</td>
															
															
															<td class="">
															<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
															<button name="update" class="btn btn-warning">Edit</button>
															</form>
																<form action="" method="post">
																	<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
																	<button name="delete_item" class="btn btn-danger">Delete</button>
																</form>	
															</td>
															
														</tr>
													<?php } ?>
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
