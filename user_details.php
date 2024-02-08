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
						data:{table:'coupon',  id:id},
						success:function (res)
						{
							//console.log(res);
							window.location.reload();
						}
						
					});
				}
				
				
			}
			
		</script>
		<style>
			.portlet.box .dataTables_wrapper .dt-buttons {
			margin-top: 103px;
			}
			.dt-buttons{
			position: absolute;
			right: 1px;
			top: -154px;
			}
			
		</style>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php 
			if(!isset($_GET['id'])){ echo "<script>window.location='./';</script>"; }
			$user = get_row($conn, "select * from users where md5(id)='{$_GET['id']}' LIMIT 1");
			if(count($user)==0){ echo "<script>window.location='./';</script>"; }
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
									<span>User Details</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> User Details
							
						</h1>
						<div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-user font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">User Details</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
										<div class="row">
											<div class="col-md-6">
												<table class="table table-bordered">
													<tr>
														<td>Name</td><td><?php echo $user[0]['fname']." ".$user[0]['lname']; ?></td>
													</tr>
													<tr>
														<td>Email</td><td><?php echo $user[0]['email']; ?></td>
													</tr>
													<tr>
														<td>Contact Number</td><td><?php echo $user[0]['phno']; ?></td>
													</tr>
													
													<tr>
														<td>Registration Date</td><td><?php echo date_format(date_create($user[0]['created_at']), "d/m/Y - h:i A"); ?></td>
													</tr>
													<tr>
														<td>New User</td><td><?php if($user[0]['isnew']==''){ echo 'YES'; }else{ echo 'NO'; } ?></td>
													</tr>
													
												</table>
											</div>
											<div class="col-md-6">
											<h4>User Activity</h4>
											<ul style="padding-left:0;list-style:none">
											<li><a href="./order-list/<?php echo strtoupper(md5($user[0]['id'])); ?>">Orders</a></li>
											
											</ul>
											</div>
										</div>
										
									</div>
								</div>
								
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
