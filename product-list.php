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
						data:{table:'products',  id:id},
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
			margin-top: 0px;
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
									<span>All Products</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> All Products
							
						</h1>
						<!-- page contant -->
						<div class="row">
							<div class="col-md-12">
								<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption" style="width:100%;">
										<i class="fa fa-globe"></i>All Products 
										<!-- <button  style="float:right;" onclick="printDiv('barcode')" class="btn btn-danger" type="button">Print Barcode</button> -->
									</div>
										<div class="tools"> </div>
									</div>
									
									<div class="portlet-body">
										<div class="row">
											<div style="margin-bottom: 44px;">
												
												<div class="col-md-3">
													
													<select style="float:left;width:80%;" onchange="setcat(1,this.value)" class="form-control">
														<?php 
															if(isset($_SESSION['f_dept'])){
																$sql81=$conn->query("select * from cats where department_id='{$_SESSION['f_dept']}'");	
															}
															else{
																$sql81=$conn->query("select * from cats where status='1'");
															}
														?>
														<option value="">Select Category</option>
														<?php
															
															while($row81=mysqli_fetch_assoc($sql81)){
															?>
															<option <?php if(isset($_SESSION['f_cat'])){ if($row81['id']==$_SESSION['f_cat']){ echo "selected"; } } ?> value="<?php echo $row81['id']; ?>"><?php echo $row81['name']; ?></option>
														<?php } ?>
													</select>
													<?php 
														if(isset($_SESSION['f_cat'])){
														?>
														<button title="Clear Category" onclick="setcat(0)" style="float:left" class="btn btn-danger filter_close"><i class="fa fa-times" aria-hidden="true"></i></button>
													<?php } ?>
												</div>
												<div class="col-md-3">
													<?php 
														if(isset($_SESSION['f_cat'])){
															$sql82=$conn->query("select * from subcats where cat_id='{$_SESSION['f_cat']}' and status='1'");	
														}
														else{
															$sql82=$conn->query("select * from subcats");
														}
													?>
													<select style="float:left;width:80%;" onchange="setsubcat(1,this.value)" class="form-control">
														<option value="">Select Sub Category</option>
														<?php
															
															while($row82=mysqli_fetch_assoc($sql82)){
															?>
															<option <?php if(isset($_SESSION['f_subcat'])){ if($row82['id']==$_SESSION['f_subcat']){ echo "selected"; } } ?> value="<?php echo $row82['id']; ?>"><?php echo $row82['name']; ?></option>
														<?php } ?>
													</select>
													<?php 
														if(isset($_SESSION['f_subcat'])){
														?>
														<button title="Clear Category" onclick="setsubcat(0)" style="float:left" class="btn btn-danger filter_close"><i class="fa fa-times" aria-hidden="true"></i></button>
													<?php } ?>
												</div>
												<div class="col-md-3">
													<?php 
														if(isset($_SESSION['f_subcat'])){
															$sql82=$conn->query("select * from brands where status='1'");	
														}
														else{
															$sql82=$conn->query("select * from brands");
														}
													?>
													<select style="float:left;width:80%;" onchange="setbrand(1,this.value)" class="form-control">
														<option value="">Select Brand</option>
														<?php
															
															while($row82=mysqli_fetch_assoc($sql82)){
															?>
															<option <?php if(isset($_SESSION['f_brand'])){ if($row82['id']==$_SESSION['f_brand']){ echo "selected"; } } ?> value="<?php echo $row82['id']; ?>"><?php echo $row82['name']; ?></option>
														<?php } ?>
													</select>
													<?php 
														if(isset($_SESSION['f_brand'])){
														?>
														<button title="Clear Category" onclick="setbrand(0)" style="float:left" class="btn btn-danger filter_close"><i class="fa fa-times" aria-hidden="true"></i></button>
													<?php } ?>
												</div>
											</div>
										</div>
										<style>
										.table-scrollable{
										min-height:180px;
										}
										</style>
										<table class="table table-striped table-bordered table-hover" id="sample_2">
											<thead>
												<tr>
													<th> ID&nbsp;&nbsp; </th>
													<th> Name </th>
													<th> Caption Name </th>
													
													<th> Category </th>
													<th>Action</th>
													<th>Manage</th>
													
												</tr>
											</thead>
											
											<tbody>
												<?php 
													if(isset($_SESSION['f_dept'])){ $dept_id = "and dept_id='{$_SESSION['f_dept']}'"; }else{ $dept_id = ""; }
													if(isset($_SESSION['f_cat'])){ $cat_id = "and cat_id='{$_SESSION['f_cat']}'"; }else{ $cat_id = ""; }
													if(isset($_SESSION['f_subcat'])){ $subcat_id = "and sub_cat_id='{$_SESSION['f_subcat']}'"; }else{ $subcat_id = ""; }
													if(isset($_SESSION['f_brand'])){ $brand_id = "and brand_id='{$_SESSION['f_brand']}'"; }else{ $brand_id = ""; }
													
													$rows = get_row($conn, "select  * from products where id!='' $dept_id $cat_id $subcat_id $brand_id order by id desc");
													
													$x=0;
													$last = count($rows);
													foreach($rows as $row){
														
														$top_pro = get_row($conn, "select * from top_products where product_id='{$row['id']}' LIMIT 1");
														
														$new_arrival = get_row($conn, "select * from arrivals where product_id='{$row['id']}' LIMIT 1");
														
													?>
													
													<tr <?php //if(($last-1)==$x){ echo 'style="height:200px;"';  };?> >
														
														<td>
															
														<?php echo ($x+1); ?> </td>
														<td><?php echo $row['name']; ?></td>
														<td><?php echo $row['caption_name']; ?></td>
														<?php 
															
															$rows13=get_row($conn, "select * from cats where id='{$row['cat_id']}'");
														?>
														
														<td><?php echo $rows13[0]['name'] ?? ''; ?></td>
														<td>
															<div class="dropdown">
																<button class="btn dropdown-toggle btn-success" type="button" data-toggle="dropdown">Action
																<span class="caret"></span></button>
																<ul class="dropdown-menu">
																	<li><a href="./similar_products?id=<?php echo md5($row['id']); ?>">Similar Product</a></li>
																	<li id="toppro<?php echo $x; ?>"><a style="cursor:pointer" onclick="addtopproduct(<?php echo $x; ?>,<?php echo $row['id']; ?>, event)"><?php if(isset($top_pro[0]['product_id'])){ echo 'Remove Top Product (Added)'; }else{ echo 'Add to Top Product (Removed)'; } ?></a></li>
																	<li style="cursor:pointer;" onclick="addnewarrival(<?php echo $x; ?>,<?php echo $row['id']; ?>, event)"><a><?php if(isset($new_arrival[0]['product_id'])){ echo 'Remove New Arrival (Added)'; }else{ echo 'Add to New Arrival (Removed)'; } ?></a></li>
																</ul>
															</div>
														</td>
														<td> 
															
															<a style="margin-bottom:8px" href="product_details/<?php echo md5($row['id'])?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-eye"></i> Edit</a>
															
															<?php
																$rows21=get_row($conn, "select * from products_items where pid='{$row['id']}'");
																if(count($rows21)==1 || count($rows21)==0){ ?>
																<button type="button" class="btn red btn-sm btn-block" onclick="del_data(<?php echo $row['id']; ?>)"><i class='fa fa-trash-o'></i> Delete</button>
																<?php }
																else{
																	echo "<a title='You can not delete this product.' class='btn default btn-block btn-sm'><i class='fa fa-trash-o'></i> Delete</a>";
																}
															?>
															
														</td>
														
													</tr>
													
												<?php $x++; } ?>
													
											</tbody>
										</table>
											<div class="row" id="barcode" style="display:none;visibility:hidden;height:0;">
										<?php 
											$rows = get_row($conn, "select t1.*, t2.*, t2.id as id from products as t1 join products_items as t2 on t1.id=t2.pid"); 
											//$q="SELECT * FROM products";
											foreach($rows as $row){
											
												$color = get_row($conn, "select * from colors where id='{$row['color']}'");
												
												$size = get_row($conn, "select * from sizes where id='{$row['size']}'");
												
											?>
											<div class="col-md-3" style="text-align: center;">
												<img style="padding: 10px;" src="barcode.php?size=40&text=<?php echo $row['pid']; ?>&print=true">
												<p><?php echo $row['id']; ?> - <?php echo $row['name']; ?><?php echo " - (".@$color[0]['name']; ?> - <?php echo @$size[0]['name'].")"; ?></p>
											</div>
											<?php 
											}
										?>
									</div>
								
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
		<?php include('includes/script.php'); ?>
		<!-- END THEME LAYOUT SCRIPTS -->
		
		<!-- End Google Tag Manager -->
		<script>
			function printDiv(printableArea) { 
				var printContents = document.getElementById(printableArea).innerHTML;
				var originalContents = document.body.innerHTML;
				
				document.body.innerHTML = printContents;
				
				window.print();
				
				document.body.innerHTML = originalContents;
			}
		</script>
	</body>
</html>