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
			
		</script>
		<style>
			.portlet.box .dataTables_wrapper .dt-buttons {
			margin-top: 0px;
			}
			.dt-buttons{
			position: absolute;
			top: -51px;
			right:4px;
			}
			
		</style>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php
			if(isset($_GET['id'])){
				$order = get_row($conn, "select * from orders where md5(order_id)='{$_GET['id']}'");
			
				if(count($order)==0){
					echo "<script>window.location='./'</script>";die;
				}
			}
			else{
				echo "<script>window.location='./'</script>";die;
			}
			
			if(isset($_POST['update_ship'])){
				
				$id = trim($conn->real_escape_string($_POST['id']));
				$address = trim($conn->real_escape_string($_POST['address']));
				$city = trim($conn->real_escape_string($_POST['city']));
				$state = trim($conn->real_escape_string($_POST['state']));
				$pin = trim($conn->real_escape_string($_POST['pin']));
				$r_name = trim($conn->real_escape_string($_POST['r_name']));
				$contact_no = trim($conn->real_escape_string($_POST['contact_no']));
				
				$conn->query("update orders set shipping_address='$address', city='$city', state='$state', postal_code='$pin', receiver_name='$r_name', contact_no='$contact_no' where id='$id'");
				echo '<script>window.location="'.str_replace('.php', '', $_SERVER['REQUEST_URI']).'"</script>';
			}
			if(isset($_POST['update_order'])){
				
				$id = trim($conn->real_escape_string($_POST['id']));
				
				$status = trim($conn->real_escape_string($_POST['status']));
				// $approve = trim($conn->real_escape_string($_POST['approve']));
				$approve = '';
				
				$total = 0;
				$ship_charge = 0;
				$tax_amt = 0;
				$grand_total = 0;
				$discount = 0;
				$total_qty = 0;
				$collectable_amount = 0;
				
				$orders = get_row($conn, "select * from orders where id='{$id}' limit 1");
				
				if($status == "Cancelled"){
					$conn->query("update orders set discount='0' where id='$id'");
				}
				if($approve == "Approve"){
					
					
					
					if(count($orders)){
						$order_items = get_row($conn, "select * from order_items where order_id='{$orders[0]['order_id']}'");
						
						
						foreach($order_items as $order_item){
							if($order_item['cancel'] != '1'){
								
								$total += $order_item['price']*$order_item['qty'];
								$ship_charge += $order_item['ship_charge'];
								$tax_amt += $order_item['tax_amt'];
								$total_qty += $order_item['qty'];
								
								$grand_total = $total+$ship_charge;
								$grand_total1 = $total+$tax_amt+$ship_charge;
							}
							else{
								$product_item = get_row($conn, "select * from products_items where id='{$order_item['item_id']}'");
								if(count($product_item)){
									$qty = $product_item[0]['qty']+$order_item['qty'];
								}
								$conn->query("update products_items set qty='{$qty}' where id='{$order_item['item_id']}'");
							}
							
						}
						$collectable_amount = $grand_total1-$orders[0]['discount'];
					}
					
				}
				
				$sms_trigger = false;
				
				if($status != $orders[0]['status']){
					$sms_trigger = true;
				}
				
				
				
				//echo "update orders set grand_total='$grand_total', shipping_charges='$ship_charge', collectable_amount='$collectable_amount', discount='$discount', total_qty='$total_qty', approve='$approve', status='$status' where id='$id'";
				// $conn->query("update orders set grand_total='$grand_total', shipping_charges='$ship_charge', collectable_amount='$collectable_amount', approve='$approve', status='$status' where id='$id'");

				$conn->query("update orders set status='$status' where id='$id'");

				echo '<script>window.location="'.str_replace('.php', '', $_SERVER['REQUEST_URI']).'"</script>';
				return;
				
				
				if($approve == "Approve" && $status == "Dispatched"){
					// $orders = get_row($conn, "select * from orders where id='{$id}' limit 1");
					// $shipments[] = array(
					// "return_name" => $orders[0]['receiver_name'],
					// "return_pin" => $orders[0]['postal_code'],
					// "return_city" => $orders[0]['city'],
					// "return_phone" => $orders[0]['contact_number'],
					// "return_add" => $orders[0]['shipping_charges'],
					// "return_state" => $orders[0]['state'],
					// "return_country" => "India",
					// "order" => $orders[0]['order_id'],
					// "phone" => $orders[0]['contact_number'],
					// "products_desc" => " ",
					// "cod_amount" => str_replace(",", "", number_format($orders[0]['collectable_amount'],2)),
					// "name" => $orders[0]['receiver_name'],
					// "country" => "India",
					// "seller_inv_date" => " ",
					// "order_date" => $orders[0]['date']." ".$orders[0]['time'],
					// "total_amount" => str_replace(",", "", number_format($orders[0]['grand_total'],2)),
					// "seller_add" => "",
					// "seller_cst" => "",
					// "add" => $orders[0]['shipping_address'],
					// "seller_name" => " ",
					// "seller_inv" => " ",
					// "seller_tin" => " ",
					// "pin" => $orders[0]['postal_code'],
					// "quantity" => $orders[0]['total_qty'],
					// "payment_mode" => $orders[0]['payment_method'],
					// "state" => $orders[0]['state'],
					// "city" => $orders[0]['city'],
					// );
					
					// $response = create_logistic_order($shipments);
					
					// if($response['status'] && $response['data']['success'] == TRUE){
					// 	$data = json_encode($response);
					// 	$upload_wbn = $response['data']['upload_wbn'];
					// 	$waybill = $response['data']['packages'][0]['waybill'];
					// 	$refnum = $response['data']['packages'][0]['refnum'];
						
					// 	$conn->query("update orders set upload_wbn='{$upload_wbn}', waybill='{$waybill}', refnum='{$refnum}', logistic_data='{$data}' where id='$id'");
					// }
				}
				
				
				if($sms_trigger){
				?>
				<script>
					var message = 'Your order has been successfully <?php echo $status; ?>. OrderID: <?php echo $orders[0]['order_id']; ?>';
					var phno = '<?php echo $orders[0]['contact_number']; ?>';		
					var sms = send_sms(phno, message);
					sms.success(function(){
						
						window.location='<?php echo str_replace('.php', '', $_SERVER['REQUEST_URI']); ?>';
					});
				</script>
				<?php
				}
				else{
					echo '<script>window.location="'.str_replace('.php', '', $_SERVER['REQUEST_URI']).'"</script>';
				}
				
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
									<span>Order Details</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> OrderID <?php echo $order[0]['order_id']; ?> (<?php echo $order[0]['status']; ?>)
							
						</h1>
						<!-- page contant -->
						
						<div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            
                                            <span class="caption-subject font-dark sbold uppercase">Customer Details &nbsp;&nbsp;</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											
											<div class="form-group">
												<label class="col-md-3 control-label">Customer Name</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['receiver_name']; ?>" type="text" name="" placeholder="receiver_name" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Contact Number</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['contact_number']; ?>" type="text" name="" value="" placeholder="contact_number" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Email</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['email']; ?>" type="text" name="" value="" placeholder="City" class="form-control" disabled>
												</div>
											</div>
											
											<div class="form-group pull-right">
												<div class="col-md-12 ">
													
													<a href="user_details/<?php echo strtoupper(md5($order[0]['user_id'])); ?>" class="btn btn-sm btn-info" name="update_ship">View</a>
												</div>
											</div>
											<br/><br/>
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
                                            
                                            <span class="caption-subject font-dark sbold uppercase">Shipping Details</span>
										</div>
                                        
									</div>
									<?php 
										$address = json_decode($order[0]['address_obj'],1);
									?>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											<input type="hidden" name="id" value="<?php echo $order[0]['id']; ?>">
											<div class="form-group">
												<label class="col-md-3 control-label">Address</label>
												<div class="col-md-9">
													<textarea rows="3" name="address" placeholder="Address" class="form-control"><?php 
													echo !empty($address['address1']) ? $address['address1'].', ' : '';
													echo !empty($address['address2']) ? $address['address2'].', ' : '';
													echo !empty($address['town_city']) ? $address['town_city'].', ' : '';
													echo !empty($address['landmark']) ? $address['landmark'].', ' : '';
													echo !empty($address['address_type']) ? $address['address_type'].'' : '';
													
													?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">City / State</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['city']; ?>" style="float:left;width:50%;" type="text" name="city" placeholder="City" class="form-control">
													<input value="<?php echo $order[0]['state']; ?>" style="margin-left:1%;float:left;width:49%;" type="text" name="state"  placeholder="State" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Receiver Name / Pincode</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['receiver_name']; ?>" style="float:left;width:50%;" type="text" name="r_name" placeholder="Receiver Name" class="form-control">
													<input value="<?php echo $order[0]['postal_code']; ?>" style="margin-left:1%;float:left;width:49%;" type="text" name="pin" placeholder="Pincode" class="form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Contact No.</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['contact_no']; ?>" type="text" name="contact_no" placeholder="Contact No." class="form-control">
												
												</div>
											</div>
											
											
											
											
											
											<div class="form-group pull-right">
												<div class="col-md-12 ">
													<button type="submit" class="btn btn-sm btn-warning" name="update_ship">Update</button>
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
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            
                                            <span class="caption-subject font-dark sbold uppercase">Order Details</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											<input type="hidden" name="id" value="<?php echo $order[0]['id']; ?>">
											<div class="form-group">
												<label class="col-md-3 control-label">Total Quantity</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['total_qty']; ?>" type="text" name="" placeholder="Total Quantity" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Contact Number</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['contact_number']; ?>" type="text" name="" value="" placeholder="contact_number" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Date/Time</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['date']." / ".$order[0]['time']; ?>" type="text" name="" value="" placeholder="City" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Payment Method</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['payment_method']; ?>" type="text" name="" value="" placeholder="City" class="form-control" disabled>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Delivery Method</label>
												<div class="col-md-9">
													<input value="<?php echo $order[0]['delivery_method']; ?>" type="text" name="" value="" placeholder="City" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Order Status</label>
												<div class="col-md-9">
													<select class="form-control" name="status" required>
														
														<option <?php if($order[0]['status']=='PENDING'){ echo 'selected'; } ?> value="PENDING">Pending</option>
														
														<option <?php if($order[0]['status']=='PLACED'){ echo 'selected'; } ?> value="PLACED">Placed</option>
														<option <?php if($order[0]['status']=='DISPATCHED'){ echo 'selected'; } ?> value="DISPATCHED">Dispatched</option>
														<option <?php if($order[0]['status']=='DELIVERED'){ echo 'selected'; } ?> value="DELIVERED">Deliverd</option>
														<option <?php if($order[0]['status']=='CANCELLED'){ echo 'selected'; } ?> value="CANCELLED">Cancelled</option>
                                                        
													</select>
												</div>
											</div>
											<!-- <div class="form-group">
												<label class="col-md-3 control-label">Logistic Status</label>
												<div class="col-md-9">
													<select class="form-control" name="approve">
														<option value="">Select</option>
														<option <?php //if($order[0]['approve']=='Approve'){ echo 'selected'; } ?> value="Approve">Approve</option>
														
                                                        
													</select>
												</div>
											</div> -->
											<!-- <div class="form-group">
												<label class="col-md-3 control-label">Upload WBN</label>
												<div class="col-md-9">
													<input value="<?php //echo $order[0]['upload_wbn']; ?>" type="text" name="" placeholder="upload_wbn" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Waybill</label>
												<div class="col-md-9">
													<input value="<?php //echo $order[0]['waybill']; ?>" type="text" name="" value="" placeholder="waybill" class="form-control" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Reference Number</label>
												<div class="col-md-9">
													<input value="<?php //echo $order[0]['refnum']; ?>" type="text" name="" value="" placeholder="refnum" class="form-control" disabled>
												</div>
											</div> -->
											<div class="form-group pull-right">
												<div class="col-md-12 ">
													<button type="submit" class="btn btn-sm btn-warning" name="update_order">Update</button>
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
										<i class="fa fa-globe"></i>Items Details </div>
										<div class="tools"> </div>
									</div>
									
									<div class="portlet-body">
										<table class="table table-striped table-bordered table-hover" id="sample_2">
											<thead>
												<tr>
													<th> ID&nbsp;&nbsp; </th>
													<th> Image </th>
													<th> Product Name </th>
													<th> Price </th>
													<th> Color </th>
													<th> Size </th>
													<th> Quantity </th>
													<!-- <th> Status </th> -->
													
												</tr>
											</thead>
											
											<tbody>
												<?php 
													/* 	if(isset($_SESSION['f_dept'])){ $dept_id = "and dept_id='{$_SESSION['f_dept']}'"; }else{ $dept_id = ""; }
														if(isset($_SESSION['f_cat'])){ $cat_id = "and cat_id='{$_SESSION['f_cat']}'"; }else{ $cat_id = ""; }
														if(isset($_SESSION['f_subcat'])){ $subcat_id = "and sub_cat_id='{$_SESSION['f_subcat']}'"; }else{ $subcat_id = ""; }
													if(isset($_SESSION['f_brand'])){ $brand_id = "and brand_id='{$_SESSION['f_brand']}'"; }else{ $brand_id = ""; } */
													
													$rows = get_row($conn, "select * from order_items where id!='' and order_id='{$order[0]['order_id']}'  order by id desc");
													
													$tax_amt = 0;
													$taxAmt = 0;
													


													foreach($rows as $row){
														
														if($row['product_type']=='Product'){
															$product = get_row($conn, "select * from products where id='{$row['product_id']}'");
															$item = get_row($conn, "select * from products_items where id='{$row['item_id']}'");
															// $tax = get_row($conn, "select * from taxes where id='".$product[0]['tax_id']."'");
															
															$img = "<img onerror=this.src='img/imgerror.jpg' style='width:56px;height:56px;' src='data/product_images/".$item[0]['thumb_image']."'>";
															
															$action_url = product_link($conn,$item[0]['id']);
															
												

															// $subTotal += (float)$row['price'];
															// $itemQty = (int)$row['qty'];
															// $itemTotal = (float)$row['price'] * (int)$row['qty'];
															$taxAmt += $row['tax_amt'];
															// $itemPriceWithoutTax = $itemTotal-$taxAmt;
															
														}
														
														
														
														
													?>
													
													<tr class="<?php if($row['cancel']==1){ echo 'danger'; } ?>" >
														
														<td>
															
														<?php echo $row['id']; ?> </td>
														<td><?php echo $img; ?></td>
														<td><a href="<?php echo $base_url.$action_url; ?>"><?php echo $row['pname']; ?></a></td>
														<td><?php echo $row['price']; ?></td>
														<?php $color = get_row($conn, "select * from colors where id='{$row['color']}' LIMIT 1"); ?>
														<?php $size = get_row($conn, "select * from sizes where id='{$row['size']}' LIMIT 1"); ?>
														<td><?php echo $color[0]['name'] ?? ''; ?></td>
														<td><?php echo $size[0]['name'] ?? ''; ?></td>
														<td><?php echo $row['qty']; ?></td>
														<!-- <td><?php //if($row['cancel']==1){ echo '<span style="color:#f00;font-weight:bold;">Cancelled</span>'; }  ?></td> -->
														
														
													</tr>
													
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<!-- END EXAMPLE TABLE PORTLET-->
							</div>
						</div>
						<div class="row">
                            <div class="col-md-12 ">
								
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            
                                            <span class="caption-subject font-dark sbold uppercase">Amount Details</span>
										</div>
                                        
									</div>
                                    <div class="portlet-body form">
                                        <form style="text-align:right;" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
											
											
											<h4>Payment Information</h4>
											<ul style="list-style:none;padding-left:0;">
												
												<li>Total : <i class="fa fa-inr"></i> <?php echo number_format($order[0]['total_price'],2); ?></li>
												<li>Shipping Charge : <i class="fa fa-inr"></i> <?php echo number_format($order[0]['shipping_charges'],2); ?></li>
												<li>Tax : <i class="fa fa-inr"></i> <?php echo number_format($taxAmt, 2); ?></li>
												
												<li>Discount : <i class="fa fa-inr"></i> <?php echo number_format($order[0]['discount'],2); ?></li>
												<li>Advance Paid : <span class="text-success"><i class="fa fa-inr"></i> <?php echo number_format($order[0]['paid_amt'],2); ?></span></li>
												
												<li>Collectable Amount : <span class="text-danger"><i class="fa fa-inr"></i> <?php echo number_format($order[0]['collectable_amount'],2); ?></span></li>
												<li>Grand Total : <i class="fa fa-inr"></i> <?php echo number_format($order[0]['grand_total'],2); ?></li>
											</ul>
											
										</form>
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
