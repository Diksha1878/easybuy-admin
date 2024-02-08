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
			function setdept(flag,id){
				if(flag==1){
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'dept',
							deptid:id
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				else{
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'cleardept'
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				
			}
			function setcat(flag,id){
				if(flag==1){
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'cat',
							catid:id
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				else{
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearcat'
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				
			}
			function setsubcat(flag,id){
				if(flag==1){
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'subcat',
							subcatid:id
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				else{
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearsubcat'
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				
			}
			function setbrand(flag,id){
				if(flag==1){
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'brand',
							brandid:id
						},
						success: function(result){
							//alert(result);
							window.location.reload();
						}
					});
				}
				else{
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearbrand'
						},
						success: function(result){
							//alert(result);
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
		<script>
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
			function setstate(id,state){
				
				if(id==1){
					
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'state',
							state:state
						},
						success: function(result){
							//alert(result);
							window.location.reload();
							
						}
					});
				}
				else{
					
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearstate'
							
						},
						success: function(result){
							window.location.reload();
							
						}
					});
				}
				
			}
			function setStatus(id,status){
				
				if(id==1){
					
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'status',
							status:status
						},
						success: function(result){
							//alert(result);
							window.location.reload();
							
						}
					});
				}
				else{
					
					$.ajax({
						type:'post',
						url: 'ajax/setfilter.php',
						data: { 
							type:'clearstatus'
							
						},
						success: function(result){
							window.location.reload();
							
						}
					});
				}
				
			}
		</script>
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
									<span>Order List</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> Order List
							<?php
								if(isset($_GET['id'])){
									echo "<a style='float:right;' href='order-list'>Show All</a>";
								}
							?>
						</h1>
						
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
							<div class="col-md-3">
								
								<select onchange="setstate(1,this.value)" style="float:left;" class="form-control">
									<?php
										if(isset($_SESSION['f_state'])){  ?>
										<option value='<?php echo $_SESSION['f_state']; ?>'><?php echo $_SESSION['f_state']; ?></option>
										<?php	}else{ ?>
										<option value=''>Select State</option>
									<?php } ?>
									<option value="Andaman and Nicobar Islands" stateid="1">Andaman and Nicobar Islands</option><option value="Andhra Pradesh" stateid="2">Andhra Pradesh</option><option value="Arunachal Pradesh" stateid="3">Arunachal Pradesh</option><option value="Assam" stateid="4">Assam</option><option value="Bihar" stateid="5">Bihar</option><option value="Chandigarh" stateid="6">Chandigarh</option><option value="Chhattisgarh" stateid="7">Chhattisgarh</option><option value="Dadra and Nagar Haveli" stateid="8">Dadra and Nagar Haveli</option><option value="Daman and Diu" stateid="9">Daman and Diu</option><option value="Delhi" stateid="10">Delhi</option><option value="Goa" stateid="11">Goa</option><option value="Gujarat" stateid="12">Gujarat</option><option value="Haryana" stateid="13">Haryana</option><option value="Himachal Pradesh" stateid="14">Himachal Pradesh</option><option value="Jammu and Kashmir" stateid="15">Jammu and Kashmir</option><option value="Jharkhand" stateid="16">Jharkhand</option><option value="Karnataka" stateid="17">Karnataka</option><option value="Kenmore" stateid="18">Kenmore</option><option value="Kerala" stateid="19">Kerala</option><option value="Lakshadweep" stateid="20">Lakshadweep</option><option value="Madhya Pradesh" stateid="21">Madhya Pradesh</option><option value="Maharashtra" stateid="22">Maharashtra</option><option value="Manipur" stateid="23">Manipur</option><option value="Meghalaya" stateid="24">Meghalaya</option><option value="Mizoram" stateid="25">Mizoram</option><option value="Nagaland" stateid="26">Nagaland</option><option value="Narora" stateid="27">Narora</option><option value="Natwar" stateid="28">Natwar</option><option value="Odisha" stateid="29">Odisha</option><option value="Paschim Medinipur" stateid="30">Paschim Medinipur</option><option value="Pondicherry" stateid="31">Pondicherry</option><option value="Punjab" stateid="32">Punjab</option><option value="Rajasthan" stateid="33">Rajasthan</option><option value="Sikkim" stateid="34">Sikkim</option><option value="Tamil Nadu" stateid="35">Tamil Nadu</option><option value="Telangana" stateid="36">Telangana</option><option value="Tripura" stateid="37">Tripura</option><option value="Uttar Pradesh" stateid="38">Uttar Pradesh</option><option value="Uttarakhand" stateid="39">Uttarakhand</option><option value="West Bengal" stateid="41">West Bengal</option>
								</select>
								<?php
									if(isset($_SESSION['f_state'])){ ?>
									<i style="padding-left: 7px;position: absolute;right: 0;top: 10px;" onclick="setstate(0,'')" class="fa fa-times-circle" aria-hidden="true"></i>
									<?php	}
								?>
								
								
							</div>
							<div class="col-md-3">
								
								<select onchange="setStatus(1,this.value)" style="float:left;" class="form-control">
									
									<option value="">Select Status</option>
									<option <?php if(@$_SESSION['f_status']=='Pending'){ echo 'selected'; } ?> value="Pending">Pending</option>
									<option <?php if(@$_SESSION['f_status']=='Placed'){ echo 'selected'; } ?> value="Placed">Placed</option>
									<option <?php if(@$_SESSION['f_status']=='Dispatched'){ echo 'selected'; } ?> value="Dispatched">Dispatched</option>
									<option <?php if(@$_SESSION['f_status']=='Deliverd'){ echo 'selected'; } ?> value="Deliverd">Deliverd</option>
									<option <?php if(@$_SESSION['f_status']=='Cancelled'){ echo 'selected'; } ?> value="Cancelled">Cancelled</option>
									
									
								</select>
								<?php
									if(isset($_SESSION['f_status'])){ ?>
									<i style="padding-left: 7px;position: absolute;right: 0;top: 10px;" onclick="setStatus(0,'')" class="fa fa-times-circle" aria-hidden="true"></i>
									<?php	}
								?>
								
								
							</div>
							
						</div>
						
						<!-- page contant -->
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
										<i class="fa fa-globe"></i>Order List </div>
										<div class="tools"> </div>
									</div>
									
									<div class="portlet-body">
										<table class="table table-striped table-bordered table-hover" id="sample_2">
											<thead>
												<tr>
													<th> ID&nbsp;&nbsp; </th>
													<th> Receiver Name </th>
													<th> Order ID </th>
													<th> Payment </th>
													<th> Status </th>
													<th> Address </th>
													<th> Grand Total </th>
													<th> Collectable Amount </th>
													<th> Date </th>
													<th>Manage</th>
												</tr>
											</thead>
											
											<tbody>
												<?php 
													/* 	if(isset($_SESSION['f_dept'])){ $dept_id = "and dept_id='{$_SESSION['f_dept']}'"; }else{ $dept_id = ""; }
														if(isset($_SESSION['f_cat'])){ $cat_id = "and cat_id='{$_SESSION['f_cat']}'"; }else{ $cat_id = ""; }
													if(isset($_SESSION['f_subcat'])){ $subcat_id = "and sub_cat_id='{$_SESSION['f_subcat']}'"; }else{ $subcat_id = ""; } */
													if(isset($_SESSION['f_state'])){ $state = "and t1.state='{$_SESSION['f_state']}'"; }else{ $state = ""; } 
													if(isset($_SESSION['f_status'])){ $status = "and (t1.status='{$_SESSION['f_status']}')"; }else{ $status = " and t1.status!='CANCELLED'"; } 
													if(isset($_SESSION['search_date']) && $_SESSION['search_date']!=''){
														
														if(isset($_SESSION['from_date']) && $_SESSION['from_date']!=''){ $from = $_SESSION['from_date']; }else{ $from = $_SESSION['search_date']; }
														
														$search_date="and t1.date BETWEEN '".$_SESSION['search_date']."' AND '".$from."'"; 
														
													}else{ $search_date=""; }
													
													if(isset($_GET['id'])){ $user_id = "and md5(t1.user_id)='".$_GET['id']."'"; }else{ $user_id = ''; }
													
													
													$rows = get_row($conn, "select t1.* from orders as t1 where t1.id!='' $user_id $search_date $state $status order by t1.id DESC");
													
													$x = 0;
													foreach($rows as $row){
														$user = get_row($conn, "select * from users where id='{$row['user_id']}'");
														
														$sub_orders = get_row($conn, "select * from order_items where order_id='{$row['order_id']}'");
														$cn = "";
														
														// foreach($sub_orders as $sub_order){
														// 	if($sub_order['cancel'] == 1){
														// 	$cn = "danger";
														// 		}
														// 	}
														
														if($row['status'] === 'Cancelled'){
															$cn = "danger";
														}
													?>
													
													<tr class="<?php echo $cn; ?>">
														
														<td>
															
														<?php echo ($x+1); ?> </td>
														<td><?php echo $row['receiver_name']; ?></td>
														<td><?php echo $row['order_id']; ?></td>
														<td><?php echo ucwords($row['payment_method']); ?></td>
														<td><?php echo $row['status']; ?></td>
														<td><?php echo $row['shipping_address'].", ".$row['city'].", ".$row['state'].", ".$row['postal_code']; ?></td>
														<td><i class="fa fa-inr"></i> <?php echo $row['grand_total']; ?></td>
														<td><i class="fa fa-inr"></i> <?php echo $row['collectable_amount']; ?></td>
														<td><?php echo date_format(date_create($row['date']), "d/m/Y")." - ".$row['time']; ?></td>
														<td> 
															<a href="order_details/<?php echo strtoupper(md5($row['order_id'])); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
														</td>
													</tr>
													
												<?php $x++; } ?>
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
