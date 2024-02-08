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
			
			if(isset($_POST['update_color'])){
				
				
				$id=$_POST['id'];
				
				$color_name = trim(mysqli_real_escape_string($conn, $_POST['name']));
				$color_code = trim(mysqli_real_escape_string($conn, $_POST['code']));
				$rows = get_row($conn, "select * from colors where name='$color_name' LIMIT 1");
				if($color_name!='' && $color_code!='' && count($rows)==0){
					$conn->query("UPDATE COLORS SET name='$color_name', code='$color_code', updated_at='$date' WHERE id='$id'");
				}
				
				//echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
			}
			if(isset($_POST['update_size'])){
				
				
				$id=$_POST['id'];
				
				$size_name = trim(mysqli_real_escape_string($conn, $_POST['name']));
				
				$rows = get_row($conn, "select * from sizes where name='$size_name' LIMIT 1");
				if($size_name!='' && count($rows)==0){
					$conn->query("UPDATE sizes SET name='$size_name', updated_at='$date' WHERE id='$id'");
				}
				
				//echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
			}
			if(isset($_POST['save_data']))
			{
				
				$x=0;
				foreach($_POST['name'] as $name){
					$color_name = trim(mysqli_real_escape_string($conn, $name));
					$color_code = trim(mysqli_real_escape_string($conn, $_POST['code'][$x]));
					$rows = get_row($conn, "select * from colors where code='$color_code' and name='$color_name' LIMIT 1");
					if($color_name!='' && $color_code!='' && count($rows)==0){
						$conn->query("insert into colors(code,name,created_at) values('$color_code','$color_name','$date')");
					}
					$x++;
				}
				
				
				echo '<script>alert("Data Saved Successfully..!!");window.location="'.str_replace('.php', '', $_SERVER['PHP_SELF']).'";</script>';
			}
			if(isset($_POST['add_size'])){
				
				foreach($_POST['name'] as $name){
					$size_name = trim(mysqli_real_escape_string($conn, $name));
					
					$rows = get_row($conn, "select * from sizes where name='$size_name' LIMIT 1");
					if($size_name!='' && count($rows)==0){
						$conn->query("insert into sizes(name,created_at) values('$size_name','$date')");
					}
					
				}
				
				
				echo '<script>alert("Data Saved Successfully..!!");window.location="'.str_replace('.php', '', $_SERVER['PHP_SELF']).'";</script>';
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
						$("#append").append('<div class="form-group"><label class="col-md-3 control-label">Color Name / Code</label><div class="col-md-9"><div class="row"><div class="col-md-9"><input type="text" class="form-control" placeholder="Enter Color Name" name="name[]" required><span class="help-block"> </span></div><div class="col-md-3"><input title="Select Color Code" type="color" class="form-control" placeholder="Select Color Code" name="code[]" required><span class="help-block"> </span></div></div></div></div>');
					}
					function append_size()
					{
						$("#append-size").append('<div class="form-group"><label class="col-md-3 control-label">Size</label><div class="col-md-9"><input type="text" class="form-control" placeholder="Exa:- X, XL, XXL, or 32, 36, 40 etc" name="name[]" required><span class="help-block"> </span></div></div>');
					}
					function del_color_data(id)
					{
						
						var conf=confirm("Do you want to Delete ?");
						if(conf==1)
						{
							$.ajax({
								type:"post",
								url:"ajax/delete.php",
								data:{table:'colors',  id:id},
								success:function (res)
								{
									
									window.location.reload();
								}
								
							});
						}
						
						
					}
					function del_size_data(id)
					{
						
						var conf=confirm("Do you want to Delete ?");
						if(conf==1)
						{
							$.ajax({
								type:"post",
								url:"ajax/delete.php",
								data:{table:'sizes',  id:id},
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
                                    <span>Products Criteria</span>
								</li>
							</ul>
						</div>
						
                        <h1 class="page-title"> Products Criteria
                            
						</h1>
						
                        <div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Color</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="">
											
											<div class="form-group">
												<label class="col-md-3 control-label">Color Name / Code</label>
												<div class="col-md-9">
													<div class="row">
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Enter Color Name" name="name[]" required>
															<span class="help-block"> </span>
														</div>
														<div class="col-md-3">
															<input title="Select Color Code" type="color" class="form-control" placeholder="Select Color Code" name="code[]" required>
															<span class="help-block"> </span>
														</div>
													</div>
													
												</div>
											</div>
											
											
											<div id="append"></div>
											
											
											
											<div class="form-actions">
												<button type="button" class="btn btn-danger btn-sm pull-right" onclick="append()">+ Add more</button>
											</div>
											
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn green" name="save_data">Submit</button>
														<button type="button" class="btn default">Cancel</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								
							</div>
						</div>
						<div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Add Size</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="">
											
											<div class="form-group">
												<label class="col-md-3 control-label">Size</label>
												<div class="col-md-9">
													<input type="text" class="form-control" placeholder="Exa:- X, XL, XXL, or 32, 36, 40 etc" name="name[]" required>
													<span class="help-block"> </span>
												</div>
											</div>
											
											
											<div id="append-size"></div>
											
											
											
											<div class="form-actions">
												<button type="button" class="btn btn-danger btn-sm pull-right" onclick="append_size()">+ Add more</button>
											</div>
											
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-3 col-md-9">
														<button type="submit" class="btn green" name="add_size">Submit</button>
														<button type="button" class="btn default">Cancel</button>
													</div>
												</div>
											</div>
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
										<i class="fa fa-globe"></i>All Colors </div>
										<!-- <div class="tools"> </div> -->
									</div>
									<div class="portlet-body">
										<table class="table table-striped table-bordered table-hover" id="sample_3">
											<thead>
												<tr>
													<th> ID </th>
													<th> Name </th>
													<th> Code </th>
													<th> Color </th>
													<th> Manage </th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$rows = get_row($conn, "select  * from colors order by id desc");
													if(count($rows)==0)
													{
														echo '<tr><td colspan="4">Record not found !</td></tr>';
													}
													
													else{
														foreach($rows as $row){
															
														?>
														
														<tr>
															
															<td>
																<form class="form-horizontal" method="post" action="">
																<?php echo $row['id']; ?> </td>
																<td><input name="name" type="text" class="form-control" value="<?php echo $row['name']; ?>">  </td>
																
																<td><input type="text" class="form-control" value="<?php echo $row['code']; ?>" disabled>  </td>
																<td><input title="Click to change" name="code" style="padding: 0px;" class="form-control" type="color" value="<?php echo $row['code']; ?>"></td>
																<td> 
																	<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
																	<button type="submit" name="update_color" class="btn btn-warning btn-sm">Update</button>
																</form>
																<button type="button" class="btn btn-primary btn-sm" onclick="del_color_data(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
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
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
										<i class="fa fa-globe"></i>All Sizes </div>
										<!-- <div class="tools"> </div> -->
									</div>
									<div class="portlet-body">
										<table class="table table-striped table-bordered table-hover" id="sample">
											<thead>
												<tr>
													<th> ID </th>
													<th> Name </th>
													<th> Manage </th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$rows1 = get_row($conn, "select  * from sizes order by id desc");
													if(count($rows1)==0)
													{
														echo '<tr><td colspan="4">Record not found !</td></tr>';
													}
													
													else{
														foreach($rows1 as $row1){
															
														?>
														
														<tr>
															
															<td>
																<form class="form-horizontal" method="post" action="">
																<?php echo $row1['id']; ?> </td>
																<td><input name="name" type="text" class="form-control" value="<?php echo $row1['name']; ?>">  </td>
																
																
																
																<td> 
																	<input type="hidden" name="id" value="<?php echo $row1['id']; ?>">
																	<button type="submit" name="update_size" class="btn btn-warning btn-sm">Update</button>
																</form>
																<button type="button" class="btn btn-primary btn-sm" onclick="del_size_data(<?php echo $row1['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
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
