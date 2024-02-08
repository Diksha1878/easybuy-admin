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
		$conn->query("update department set name='$name' $status , modify_date='$date' where id='$id'");
	}
	
	
	echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
	
}
if(isset($_POST['save_data']))
{
	
	
	
	$status=trim(mysqli_real_escape_string($conn , $_POST['status']));
	foreach($_POST['name'] as $name){
		
		$department=trim(mysqli_real_escape_string($conn , $name));
		if($department=='')
		{
			
		}
		else{
			
			$insert=$conn->query("insert into department set name='$department' , status='$status' , create_date='$date' ");
		}
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
					$("#append").append('<div class="form-group"><label class="col-md-3 control-label">Department Name</label><div class="col-md-9"><input type="text" class="form-control" placeholder="Enter Department Name" name="name[]"><span class="help-block"> </span></div></div>');
				}
				function del_data(id)
				{
					
					var conf=confirm("Do you want to Delete ?");
					if(conf==1)
					{
						$.ajax({
							type:"post",
							url:"ajax/delete.php",
							data:{table:'department',  id:id},
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
								<span>Main Department</span>
							</li>
						</ul>
					</div>
					
					<h1 class="page-title"> Main Department
						
					</h1>
					
					<div class="row">
						<div class="col-md-12 ">
							
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption">
										<i class="icon-settings font-dark"></i>
										<span class="caption-subject font-dark sbold uppercase">Add Department</span>
									</div>
									
								</div>
								<div class="portlet-body form">
									<form class="form-horizontal" method="post" action="">
										
										<div class="form-body">
											<div class="form-group">
												<label class="col-md-3 control-label">Department Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Enter Department Name" name="name[]">
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
									<i class="fa fa-globe"></i>All Departments </div>
									<div class="tools"> </div>
								</div>
								<div class="portlet-body">
									<table class="table table-striped table-bordered table-hover" id="sample_2">
										<thead>
											<tr>
												<th> Date </th>
												<th> Modify  Date </th>
												<th> Departments Name </th>
												<th> Status </th>
												<th> Change </th>
												<th> Manage </th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$get_cat=$conn->query("select  * from department order by id asc");
												if(mysqli_num_rows($get_cat)==0)
												{
												}
												
												else{
													while($cat=mysqli_fetch_assoc($get_cat)){
														
													?>
													
													<tr>
														
														<td>
															<form class="form-horizontal" method="post" action="">
															<?php echo $cat['create_date']; ?> </td>
															<td><?php echo $cat['modify_date']; ?>  </td>
															<td> <input type="text" class="form-control" value="<?php echo $cat['name']; ?>" name="name" > </td>
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
															<button type="button" class="btn btn-primary btn-sm" onclick="del_data(<?php echo $cat['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
														</td>
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
