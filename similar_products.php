<?php session_start(); 
	include('includes/config.php');

	$_SESSION['similar_product_type']='Product';
?>

<!DOCTYPE html>

<html lang="en">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>Admin Panel</title>
		<?php include('includes/head.php'); ?>
		
		<script>
			function addsimilar(item_id,pid){ 
				$.ajax({
					type:'post',
					data:{
						item_id:item_id,
						pid:pid,
						status:'set'
					},
					url:'ajax/set_similar_edit.php',
					success:function(result){
						
						if(result==5){
							alert('Item already added !');
						}
						$.ajax({
							type:'post',
							data:{
								
							},
							url:'ajax/get_similar_edit.php',
							success:function(res){
								searchproduct($('#search_product').val())
								$("#combobox").html(res);
							}
						});
					}
				});
				
			}
			function deletesimilar(id){
				$.ajax({
					type:'post',
					data:{
						table:'similar_item',
						id:id
					},
					url:'ajax/delete.php',
					success:function(result){
						$.ajax({
							type:'post',
							data:{
								
							},
							url:'ajax/get_similar_edit.php',
							success:function(res){
								searchproduct($('#search_product').val())
								$("#combobox").html(res);
							}
						});
					}
				});
			}
			function savesimilar(){
				
				$.ajax({
					type:'post',
					data:{
						status:'save',
					},
					url:'ajax/set_similar_edit.php',
					success:function(result){
						//alert(result);
						if(result==1){
							$("#comboname_help").html('<b>Name Already Exist ! <b>').css("color","#f00");
						}
						else if(result==2 || result==3){
							$("#comboname_help").html('<b>Please Select Atleast Two Items ! <b>').css("color","#f00");
						}
						else if(result==4){
							
							$("#comboname_help").html('<b>Save Successfully ! <b>').css("color","#0f0");
							setInterval(function() {
								window.location.reload();
							}, 1000);
						}
						
					}
				});
				
			}
			function searchproduct(key){
				$.ajax({
					type:'post',
					data:{
						key:key
					},
					url:'ajax/get_search_similar_product.php',
					success:function(result){
						//alert(result);
						$("#product_list").html(result);
					}
				});
			}
		</script>
		<script>
			function comboimage(id){
				if(id==1){
					$("#btnautocomboimg").removeClass('blue');
					$("#btnaddcomboimg").addClass('blue');
					$("#addcomboimg").show();
					$("#autocomboimg").hide();
					$("#image_selection").val('2');
				}
				else{
					$("#btnautocomboimg").addClass('blue');
					$("#btnaddcomboimg").removeClass('blue');
					$("#autocomboimg").show();
					$("#addcomboimg").hide();
					$("#image_selection").val('1');
				}
			}
		</script>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php
			if(isset($_GET['id'])){ $id = $_SESSION['page_edit_similar'] = $_GET['id']; } 
			else{ $id = $_SESSION['page_edit_similar']; }
			
			if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Product'){
				$rows81=get_row($conn, "select * from similar_products where md5(product_id)='$id' LIMIT 1");
				$product=get_row($conn, "select * from products where md5(id)='{$id}'");
			}
			
			
			//var_dump($rows81);
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
									<span>Related Products</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> Related Products
						
						</h1>
						<form action="" method="post">
							<!-- page contant -->
							<div class="row">
								<div class="col-md-12">
									<!-- BEGIN EXAMPLE TABLE PORTLET-->
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">
											<i class="fa fa-globe"></i>Related Products </div>
											<div class="tools"> </div>
										</div>
										<div class="portlet-body">
											
											<div class="row">
												<div class="col-md-7">
													<div class="row" style="margin-bottom: 10px;">
														<div class="col-md-12">
															<div class="form-group">
																<label style="padding-left:0;" class="control-label col-sm-9" for="email"><input onkeyup="searchproduct($('#search_product').val())" id="search_product" type="text" placeholder="Search Product" class="form-control">
																	
																</label>
																<div style="padding-right:0;" class="col-sm-3">
																	<a onclick="searchproduct($('#search_product').val())" class="btn red pull-right" >Search</a>
																</div>
															</div>
														</div>
														
													</div>
													<div id="product_list">
														<table class="table table-striped table-bordered table-hover" id="combotable">
															<thead>
																<tr>
																	<th> ID&nbsp;&nbsp;</th>
																	<th> Name </th>
																	
																	<th> Category </th>
																	<th>Manage</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$rows = get_row($conn, "select * from products order by id desc LIMIT 10");
																	
																	$x=0;
																	foreach($rows as $row){
																		
																	?>
																	
																	<tr>
																		
																		<td>
																		<?php echo $row['id']; ?> </td>
																		<td><?php echo $row['name']; ?></td>
																		
																		<?php 
																			
																			$rows13=get_row($conn, "select * from cats where id='{$row['cat_id']}'");
																		?>
																		
																		<td><?php echo $rows13[0]['name'] ?? ''; ?></td>
																		<td> 
																			
																			<a data-toggle="collapse" data-target="#item<?php echo $x; ?>" class="btn btn-xs btn-primary">Show Items <i class="fa fa-angle-down" aria-hidden="true"></i></a>
																		</td>
																	</tr>
																	
																	<tr id="item<?php echo $x; ?>" class="collapse">
																		
																		<td colspan="6" style="padding:0">
																			<div>
																				<table style="background:#dcdcdc;margin-bottom:0;" class="table table-bordered">
																					<thead>
																						<tr>
																							<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
																							<th> Image </th>
																							<th> Color </th>
																							<th> MRP </th>
																							<th> Sale Price </th>
																							
																							<th>Manage</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																							$rows16=get_row($conn, "select * from products_items where pid='{$row['id']}'");
																							
																							
																							foreach($rows16 as $row16){
																							?>
																							<tr>
																								<td><?php echo $row16['id']; ?></td>
																								<td><img style="width:56px;height:56px;" src="data/product_images/<?php echo $row16['thumb_image']; ?>"></td>
																								<?php
																									$rows31=get_row($conn, "select * from colors where id='{$row16['color']}' LIMIT 1");
																								?>
																								<td><input disabled style="padding:0;" type="color" value="<?php echo $rows31[0]['code'] ?? ''; ?>"></td>
																								<td><?php echo "Rs ".$row16['mrp']; ?></td>
																								<td><?php echo "Rs ".$row16['price']; ?></td>
																								
																								
																								<td>
																									<?php if(isset($_SESSION['similar_list'][$row16['id']])){ ?>
																										<script>
																											$(document).ready(function(){
																												
																												$("#item"+<?php echo $x; ?>).addClass('in');
																											});
																											
																											
																										</script>	
																										
																									<?php } ?>
																									
																									<input <?php if(isset($_SESSION['similar_list'][$row16['id']])){ echo 'checked'; } ?> onclick="addsimilar(<?php echo $row16['id']; ?>,<?php echo $row['id']; ?>);" type="checkbox">
																									&nbsp;Add to Similar
																								</td>
																							</tr>
																						<?php } ?>
																					</tbody>
																				</table>
																			</div>
																			
																			
																		</td>
																	</tr>
																	
																<?php $x++; } ?>
															</tbody>
														</table>
													</div>
												</div>
												<div class="col-md-5">
													<div id="combobox">
														
														<div>
															<h3 style="margin-top:0">Product Already Added</h3>
															<table class="table">
																<thead style="background: #eee;">
																	<tr style="border-bottom: solid 1px #eee;">
																		<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
																		<th > Name </th>
																		<th> SKU </th>
																		<th style="text-align:right;">Manage</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																		$inc=1;
																		$total=0;
																		$img = '';
																		$rows82 = get_row($conn, "select * from similar_products where md5(product_id)='{$_SESSION['page_edit_similar']}' and type='Product'");
																		//var_dump($rows82);
																		if(count($rows82)==0){
																			echo '<tr><td colspan="4">No Record Found !</td></tr>';
																		}
																		foreach($rows82 as $item){
																			$rows41=get_row($conn, "select * from products where id='{$item['similar_product_id']}'");
																			$rows42=get_row($conn, "select * from products_items where id='{$item['similar_item_id']}'");
																		?>
																		<tr style="border-bottom:solid 1px #eee">
																			<td><?php echo  $inc; ?></td>
																			<td><?php echo  $rows41[0]['name']; ?></td>
																			<td><?php echo  $rows42[0]['sku']; ?></td>
																			
																			<td style="text-align:right;">
																				<a onclick="deletesimilar(<?php echo $item['id']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Delete</a>
																				
																			</td>
																		</tr>
																		<?php $total = $total+$rows42[0]['combo_price']; ?>
																		
																		<?php 
																			if(isset($_SESSION['similar_list'])){ $similar_list = count($_SESSION['similar_list']); }else{ $similar_list = 0; }
																			$count = count($rows82)+$similar_list;
																			if($count==1){
																				$imagesize = "width:100%;height:100%";
																			}
																			if($count==2){
																				$imagesize = "width:50%;height:100%";
																			}
																			if($count==3 || $count==4){
																				$imagesize = "width:50%;height:50%";
																			}
																			if($count>4){
																				if($count%2==0){ $c = $count; }else{ $c = $count+1; }
																				$y = 100/($c/2);
																				$imagesize = "width:50%;height:".$y."%";
																			}
																			$img .= '<img style="float:left;'.$imagesize.';" src="'.$base_url_admin.'data/product_images/'.$rows42[0]['thumb_image'].'" draggable="false">';
																		$inc++; }
																		
																	?>
																	
																</tbody>
															</table>
															<?php
																if(isset($_SESSION['similar_list']) && count($_SESSION['similar_list'])!=0){
																?>
																<h3 style="margin-top:0">Related Products</h3>
																<table class="table">
																	<thead style="background: #eee;">
																		<tr style="border-bottom: solid 1px #eee;">
																			<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
																			<th > Name </th>
																			<th> SKU </th>
																			<th style="text-align:right;">Manage</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			$inc=1;
																			$total1=0;
																			
																			foreach($_SESSION['similar_list'] as $item){
																				$rows41=get_row($conn, "select * from products where id='{$item['pid']}'");
																				$rows42=get_row($conn, "select * from products_items where id='{$item['item_id']}'");
																			?>
																			<tr style="border-bottom:solid 1px #eee">
																				<td><?php echo  $inc; ?></td>
																				<td><?php echo  $rows41[0]['name']; ?></td>
																				<td><?php echo  $rows42[0]['sku']; ?></td>
																				
																				<td  style="text-align:right;">
																					<a onclick="addsimilar(<?php echo $item['item_id']; ?>,<?php echo $item['pid']; ?>)" ><i class="fa fa-times" aria-hidden="true"></i> Close</a>
																					
																				</td>
																			</tr>
																			<?php $total1 = $total1+$rows42[0]['combo_price']; ?>
																			
																			<?php 
																				if(isset($_SESSION['similar_list'])){ $similar_list = count($_SESSION['similar_list']); }else{ $similar_list = 0; }
																				$count = count($rows82)+$similar_list;
																				if($count==1){
																					$imagesize = "width:100%;height:100%";
																				}
																				if($count==2){
																					$imagesize = "width:50%;height:100%";
																				}
																				if($count==3 || $count==4){
																					$imagesize = "width:50%;height:50%";
																				}
																				if($count>4){
																					if($count%2==0){ $c = $count; }else{ $c = $count+1; }
																					$y = 100/($c/2);
																					$imagesize = "width:50%;height:".$y."%";
																				}
																				$img .= '<img style="float:left;'.$imagesize.';" src="'.$base_url_admin.'data/product_images/'.$rows42[0]['thumb_image'].'" draggable="false">';
																				
																			$inc++; } ?>
																			
																	</tbody>
																</table>
															<?php } ?>
															<div class="row" style="margin-bottom: 10px;">
																<div class="col-md-12">
																	<div class="form-group">
																		<label style="padding-left:0;" class="control-label col-sm-9" for="email"><input type="text" placeholder="Product Name" id="combo_name" value="<?php echo $product[0]['name'] ?? ''; ?>" class="form-control" disabled>
																			<span id="comboname_help"  class="help-block"></span>
																		</label>
																		<div style="padding-right:0;" class="col-sm-3">
																			<a onclick="savesimilar()" class="btn red pull-right" >Save</a>
																		</div>
																	</div>
																</div>
																
																
																
																<div class="col-md-12">
																	<input type="hidden" id="image_selection" value="1">
																	<div id="autocomboimg" style="border: solid 1px #ccc;
																	padding: 8px;"><div id="img_container1" style="width:100%;height:320px;min-width:300px;"><?php echo $img; ?></div></div>
																	
																	<div id="addcomboimg" style="display:none;border: solid 1px #ccc;
																	padding: 8px;">
																		<style>
																			#img_container2 img{
																			width: 100%;
																			height: 270px;
																			}
																		</style>
																		<div style="width:100%;height:320px;min-width:300px;">
																			
																			<div class="col-sm-12 controls">
																				<div class="">
																					<div class="fileupload fileupload-new" data-provides="fileupload">
																						<div class="fileupload-new thumbnail" style="height:280px;width:100%;">
																							<img style="height: 280px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image" draggable="false">
																						</div>
																						<div id="img_container2" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div>
																						</br>
																						<div>
																							<span style="width:49%" class="btn btn-file btn-primary">
																								<span class="fileupload-new">Select image</span>
																								<span class="fileupload-exists">Change</span>
																								<input accept="image/jpeg" type="file">
																							</span>
																							<a href="#" style="width:49%" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
																						</div>
																					</div>
																				</div>
																				
																			</div>
																			
																		</div></div>
																</div>
															</div>
														</div>
														
													</div>
												</div>
											</div>
										</form>
										
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
