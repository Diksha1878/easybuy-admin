<?php session_start(); 
	include('includes/config.php');
?>

<!DOCTYPE html>

<html lang="en">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>Admin Panel</title>
		<?php include('includes/head.php'); ?>
		<script>
			function del_data(id)
			{
				
				var conf=confirm("Do you want to Delete ?");
				if(conf==1)
				{
					$.ajax({
						type:"post",
						url:"ajax/delete.php",
						data:{table:'',  id:id},
						success:function (res)
						{
							//console.log(res);
							window.location.reload();
						}
						
					});
				}
				
				
			}
			function setsearchdate(id){
				
				if(id==1){
					var date = $("#search_date").val();
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'searchdate',
							date:date
						},
						success: function(result){
							window.location.reload();
							
						}
					});
				}
				else{
					
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearsearchdate'
							
						},
						success: function(result){
							window.location.reload();
							
						}
					});
				}
				
			}
			function setfromdate(id){
				
				if(id==1){
					var date = $("#from_date").val();
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'fromdate',
							date:date
						},
						success: function(result){
							window.location.reload();
							
						}
					});
				}
				else{
					
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearfromdate'
							
						},
						success: function(result){
							window.location.reload();
							
						}
					});
				}
				
			}
		</script>
		<style>
			.portlet.box .dataTables_wrapper .dt-buttons {
			margin-top: 50px;
			}
			.dt-buttons{
			position: absolute;
			right: 1px;
			top: -154px;
			}
			.form-control{
			margin-bottom: 7px;
			}
			
		</style>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php 
			
			if(isset($_POST['update_user'])){
				
				$id = trim($conn->real_escape_string($_POST['id']));
				$fname = trim($conn->real_escape_string($_POST['fname']));
				$lname = trim($conn->real_escape_string($_POST['lname']));
				$email = trim($conn->real_escape_string($_POST['email']));
				$phno = trim($conn->real_escape_string($_POST['phno']));
				$address = trim($conn->real_escape_string($_POST['address']));
				$city = trim($conn->real_escape_string($_POST['city']));
				$pin = trim($conn->real_escape_string($_POST['pin']));
				$state = trim($conn->real_escape_string($_POST['state']));
				
				$conn->query("update users set fname='$fname', lname='$lname', email='$email', phno='$phno', address='$address', city='$city', pin='$pin', state='$state', updated_at='$date' where id='$id'");
				
				echo "<script>window.location='".$_SERVER['REQUEST_URI']."';</script>";
				
			}
			
		?>
		<div class="page-wrapper">
			
			<?php include('includes/header.php'); ?>
			
			<div class="clearfix"> </div>
			
			<div class="page-container">
				<!-- BEGIN SIDEBAR -->
				<?php include('includes/nav.php'); ?>
				
				<div class="page-content-wrapper">
					
					<div class="page-content">
						
						<div class="page-bar">
							<ul class="page-breadcrumb">
								<li>
									<a>Home</a>
									<i class="fa fa-circle"></i>
								</li>
								<li>
									<span>User List</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> User List
							
						</h1>
						<!-- page contant -->
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
										<i class="fa fa-globe"></i>User List </div>
										<div class="tools"> </div>
									</div>
									
									<div class="portlet-body">
										<div class="row" style="padding-bottom: 12px;">
											<div class="col-md-3">
												
												<input style="float:left;" class="form-control" type="date" onchange="setsearchdate(1)" <?php if(isset($_SESSION['search_date'])){ echo "value='".$_SESSION['search_date']."'"; } ?> id="search_date">
												<?php
													if(isset($_SESSION['search_date'])){ ?>
													<i style="padding-left: 7px;position: absolute;right: 0;top: 10px;" onclick="setsearchdate(0)" class="fa fa-times-circle" aria-hidden="true"></i>
													<?php	}
												?>
												
												
											</div>
											<div class="col-md-3">
												
												<input style="float:left;" class="form-control" type="date" onchange="setfromdate(1)" <?php if(isset($_SESSION['from_date'])){ echo "value='".$_SESSION['from_date']."'"; } ?> id="from_date">
												<?php
													if(isset($_SESSION['from_date'])){ ?>
													<i style="padding-left: 7px;position: absolute;right: 0;top: 10px;" onclick="setfromdate(0)" class="fa fa-times-circle" aria-hidden="true"></i>
													<?php	}
												?>
												
												
											</div>
										</div>
										<table class="table table-striped table-bordered table-hover" id="sample_2">
											<thead>
												<tr>
													<th> ID&nbsp;&nbsp; </th>
													<th> User Name </th>
													<th> Email </th>
													<th> Contact Number </th>
													<th> Date </th>
													<th> Manage</th>
												</tr>
											</thead>
											
											<tbody>
												<?php 
													/* 	if(isset($_SESSION['f_dept'])){ $dept_id = "and dept_id='{$_SESSION['f_dept']}'"; }else{ $dept_id = ""; }
														if(isset($_SESSION['f_cat'])){ $cat_id = "and cat_id='{$_SESSION['f_cat']}'"; }else{ $cat_id = ""; }
														if(isset($_SESSION['f_subcat'])){ $subcat_id = "and sub_cat_id='{$_SESSION['f_subcat']}'"; }else{ $subcat_id = ""; }
													if(isset($_SESSION['f_brand'])){ $brand_id = "and brand_id='{$_SESSION['f_brand']}'"; }else{ $brand_id = ""; } */
													if(isset($_SESSION['search_date']) && $_SESSION['search_date']!=''){
														
														if(isset($_SESSION['from_date']) && $_SESSION['from_date']!=''){ $from = $_SESSION['from_date']; }else{ $from = $_SESSION['search_date']; }
														
														$search_date="and registration_date BETWEEN '".$_SESSION['search_date']."' AND '".$from."'"; 
														
													}else{ $search_date=""; } 
													
													$rows = get_row($conn, "select  * from users where id!='' $search_date order by id desc");
													
													$x=0;
													foreach($rows as $row){
														if($row['id']==1 || $row['fname']=="Admin" || $row['fname']=="admin"){}
														else{
														?>
														
														<tr>
															
															<td>
																
															<?php echo $row['id']; ?> </td>
															<td title="Click to Edit User Details" style="cursor:pointer;" data-toggle="modal" data-target="#user<?php echo $x; ?>"><?php echo $row['fname']." ".$row['lname']; ?></td>
															<td><?php echo $row['email']; ?></td>
															<td><?php echo $row['phno']; ?></td>
															<td><?php echo date_format(date_create($row['created_at']), "d/m/Y - h:i A"); ?></td>
															<td>
																<a href="user_details/<?php echo strtoupper(md5($row['id'])); ?>">Details</a> 
															</td>	
															<!-- Modal -->
															<div id="user<?php echo $x; ?>" class="modal fade" role="dialog">
																<div class="modal-dialog">
																	
																	<!-- Modal content-->
																	<form action="" method="post">
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal">&times;</button>
																				<h4 class="modal-title">User Details</h4>
																			</div>
																			<div class="modal-body">
																				<div class="row">
																					
																					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="fname">Name</label>
																						<div class="col-sm-10">
																							<input name="fname" value="<?php echo $row['fname']; ?>" style="width:50%;float:left;" type="text" class="form-control" id="fname" placeholder="First Name">
																							<input name="lname" value="<?php echo $row['lname']; ?>" style="margin-left:1%;width:49%;float:left;" type="text" class="form-control" id="lname" placeholder="Second Name">
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="email">Email</label>
																						<div class="col-sm-10">
																							<input name="email" value="<?php echo $row['email']; ?>" type="email" class="form-control" id="email" placeholder="Email">
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="phno">Contact</label>
																						<div class="col-sm-10">
																							<input name="phno" value="<?php echo $row['phno']; ?>" type="text" class="form-control" id="phno" placeholder="Contact Number">
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="address">Address</label>
																						<div class="col-sm-10">
																							<textarea name="address" rows="2" class="form-control" id="address" placeholder="Address"><?php echo $row['address']; ?></textarea>
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="city">City</label>
																						<div class="col-sm-10">
																							<input name="city" value="<?php echo $row['city']; ?>" type="text" class="form-control" id="city" placeholder="City">
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="pin">Pincode</label>
																						<div class="col-sm-10">
																							<input name="pin" value="<?php echo $row['pin']; ?>" type="text" class="form-control" id="pin" placeholder="Pincode">
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="control-label col-sm-2" for="state">State</label>
																						<div class="col-sm-10">
																							<input name="state" value="<?php echo $row['state']; ?>" type="text" class="form-control" id="state" placeholder="State">
																						</div>
																					</div>
																					
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																				<button type="submit" name="update_user" class="btn btn-warning">Update</button>
																			</div>
																		</div>
																	</form>
																</div>
															</div>
															
														</tr>
														
													<?php } $x++; } ?>
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
