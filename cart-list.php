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
						data:{table:'carts',  id:id},
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
			margin-top: 57px;
			}
			.dt-buttons{
			position: absolute;
			right: 1px;
			top: -154px;
			}
			
		</style>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
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
									<span>Cart List</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> Cart List
							
						</h1>
						<!-- page contant -->
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
										<i class="fa fa-globe"></i>Cart List </div>
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
													<th> Product Name </th>
													<th> Color </th>
													<th> Size </th>
													<th> Quantity </th>
													<th> Date </th>
													<th>Manage</th>
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
														
														$search_date="and date BETWEEN '".$_SESSION['search_date']."' AND '".$from."'"; 
														
													}else{ $search_date=""; }
													$rows = get_row($conn, "select  * from carts where id!='' $search_date order by id desc");
													
													
													foreach($rows as $row){
														$user = get_row($conn, "select * from users where id='{$row['user_id']}'");
														$product = get_row($conn, "select * from products where id='{$row['pid']}'");
														$item = get_row($conn, "select * from products_items where id='{$row['item_id']}'");
													?>
													
													<tr>
														
														<td>
															
														<?php echo $row['id']; ?> </td>
														<td><?php echo ($user[0]['fname'] ?? '')." ".($user[0]['lname'] ?? ''); ?></td>
														<td><?php echo $product[0]['name'] ?? ''; ?></td>
														<?php $color = get_row($conn, "select * from colors where id='".($item[0]['color'] ?? 0)."' LIMIT 1"); ?>
														<?php $size = get_row($conn, "select * from sizes where id='".($item[0]['size'] ?? 0)."' LIMIT 1"); ?>
														<td><?php echo $color[0]['name'] ?? ''; ?></td>
														<td><?php echo $size[0]['name'] ?? ''; ?></td>
														<td><?php echo $row['qty']; ?></td>
														<td><?php echo date_format(date_create($row['date']), "d/m/Y"); ?></td>
														<td> 
															<button type="button" class="btn red btn-sm" onclick="del_data(<?php echo $row['id']; ?>)"><i class="fa fa-trash-o"></i> Delete</button>
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
