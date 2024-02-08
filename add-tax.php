<?php session_start(); 
	include('includes/config.php');
?>
	<?php
			if(isset($_POST['ADD_TAX'])){
				$datex = date("Y-m-d H:i:s");
				
				if(isset($_POST['id'])){
					$conn->query("update taxes set name='{$_POST['tax_name']}',percent='{$_POST['tax_percent']}' where id='{$_POST['id']}'");
				}
				else{
					$conn->query("insert into taxes(name,percent,date) values('{$_POST['tax_name']}','{$_POST['tax_percent']}','$datex')");
				}
				
				//echo "<script>window.location='".$_SERVER['REQUEST_URI']."'</script>";
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
                                    <a href="index-2.html">Home</a>
                                    <i class="fa fa-circle"></i>
								</li>
                                <li>
                                    <span>Add Tax</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title"> Tax Management
                            
						</h1>
						
                        <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add New Tax</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
										
											
											<div class="form-group">
												<label class="col-md-3 control-label">Tax Name</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Tax Name" name="tax_name">
													<span class="help-block"> </span>
												</div>
											</div>
												<div class="form-group">
												<label class="col-md-3 control-label">Tax Percent</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Tax Percent" name="tax_percent">
													<span class="help-block"> </span>
												</div>
											</div>
										
											
											<div class="form-group pull-right">
												<div class="col-md-12 ">
													<button type="submit" class="btn green btn-sm" name="ADD_TAX">Submit</button>
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
											<th>Percent</th>
											<th>Date</th>
											<th>Action</th>
												</tr>
											</thead>
                                            <tbody>
												<?php 
													$get_cat=$conn->query("select  * from taxes order by id desc");
													if(mysqli_num_rows($get_cat)==0)
													{
													}
													
													else{
													$x = 0;
														while($row=mysqli_fetch_assoc($get_cat)){
															
														?>
														
															<tr>
												<form action="" method="post">
													<td>
														<?php echo ($x+1); ?>
														<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													</td>
													<td><input class="form-control" name="tax_name" type="text" value="<?php echo $row['name']; ?>"></td>
													<td><input class="form-control" name="tax_percent" type="text" value="<?php echo $row['percent']; ?>"></td>
													<td><?php echo $row['date']; ?></td>
													<td>
														<button name="ADD_TAX" class="btn btn-warning">Edit</button>
													</td>
												</form>
											</tr>
														
														<?php
													$x++;	}
														
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
