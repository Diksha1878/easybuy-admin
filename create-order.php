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
					url:'ajax/set_add_cart_edit.php',
					success:function(result){
						
						if(result==5){
							alert('Item already added !');
						}
						$.ajax({
							type:'post',
							data:{
								
							},
							url:'ajax/get_add_cart_edit.php',
							success:function(res){
								// searchproduct($('#search_product').val())
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
							url:'ajax/get_add_cart_edit.php',
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
					url:'ajax/set_add_cart_edit.php',
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
					url:'ajax/get_search_add_cart_product.php',
					success:function(result){
						//alert(result);
						$("#product_list").html(result);
					}
				});
			}
			
			function updateCart(el, item_id, pid){
			 //   console.log(el.value, item_id, pid)
			    $.ajax({
					type:'post',
					data:{
						qty:el.value,
						item_id: item_id, 
						pid: pid
					},
					url:'ajax/update_cart_item.php',
					success:function(result){
					    refreshCart()
						//alert(result);
				// 		$("#product_list").html(result);
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
			
			function refreshCart(){
		    	$.ajax({
						type:'post',
						data:{},
						url:'ajax/get_add_cart_edit.php',
						success:function(res){
						
							$("#combobox").html(res);
						}
					});
			}
			
			function updateTokenAmtStatus(e){
			var token_amount = Number($('.token_amount_val').val());
			var collectable_amount = Number($('.collectable_amount_val').val());
			if(e.target.checked === true){
			    $('.ref_no').prop('required', true)
			    $('.collectable_amount').text((collectable_amount).toFixed(2));
			     $('.token_amount').text((token_amount).toFixed(2));
			}
			else{
			    $('.ref_no').prop('required', false)
			  $('.collectable_amount').text((collectable_amount+token_amount).toFixed(2));   
			   $('.token_amount').text((0).toFixed(2));
			}
			console.log(token_amount, collectable_amount, e.target.checked);
			
			}
			
			$(document).ready(() => {
			    refreshCart()
			})
		</script>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
	    
	    <?php 
	    
	
    
    
	    if(isset($_POST['place_order'])){
	        

	       
	        $totalTokenAmount = 0;
$totalPayableAmount = 0;
$totalOrderAmount = 0;
$subTotal = 0;
$totalDelivaryCharge = 0;
$collectableAmount = 0;
$paymentMode = 'COD';
$totalQty = 0;
$orderStatus = 'PENDING';
$txnStatus = 'INIT';

if (isset($_SESSION['cart_list']) && count((array)$_SESSION['cart_list']) > 0) {
    foreach ($_SESSION['cart_list'] as $row) {
        $product = get_row($conn, "select * from products where id='".$row['pid']."'")[0];
        $product_item = get_row($conn, "select * from products_items where id='".$row['item_id']."'")[0];
        $productTotal = (float)$product_item['combo_price'] * (int)$row['qty'];
        $subTotal += $productTotal;
        $totalTokenAmount += (float)$product['token_amt_rate'] * (int)$row['qty'];
        $totalDelivaryCharge += (float)$product['shipping_charge'];
        $totalQty += (int)$row['qty'];
    }
}

// $address = Address::where('user_id', session('user')->id)->where('id', $request->address_id)->first();

// $user = User::find(session('user')->id);

$totalOrderAmount = $subTotal + $totalDelivaryCharge;

$orderId = 'OD' . time() . mt_rand(1000, 9999);

if ($_POST['payment_method'] === 'ONLINE') {
    $paymentMode = 'ONLINE';
    $totalPayableAmount = $totalOrderAmount;
    $totalTokenAmount = 0;
    $collectableAmount = 0;
} else {
    $paymentMode = 'COD';
    $totalPayableAmount = 0;
    $collectableAmount = $totalOrderAmount;
    if ($totalTokenAmount > 0) {
        // $paymentMode = 'ONLINE';
        if(isset($_POST['is_paid_token_amt']) && $_POST['is_paid_token_amt'] === 'on'){
            $totalPayableAmount = $totalTokenAmount;
            $collectableAmount = $totalOrderAmount - $totalTokenAmount;
        }
        else{
            $totalPayableAmount = 0;
            $collectableAmount = $totalOrderAmount;
        }
    }
}

$shipping_address = ((!empty($_POST['address1']) ? $_POST['address1'] . ', ' : '') . (!empty($_POST['address2']) ? $_POST['address2'] . ', ' : '') . (!empty($_POST['town_city']) ? $_POST['town_city'] . ', ' : '') . (!empty($_POST['landmark']) ? $_POST['landmark'] . ', ' : '') . ', Address Type: ' . (!empty($_POST['address_type']) ? $_POST['address_type'] . '' : ''));

$order = $conn->query("insert into orders(
    order_id, 
    user_id, 
    total_qty, 
    total_price, 
    shipping_charges, 
    grand_total, 
    collectable_amount, 
    paid_amt, 
    receiver_name, 
    shipping_address, 
    address_obj, 
    contact_number, 
    email, 
    postal_code, 
    date, 
    time, 
    payment_method, 
    status, 
    discount, 
    txn_status, 
    contact_no, 
    delivery_method, 
    state, 
    city,
    created_at,
    updated_at
    ) values(
        '".$orderId."',
        '". $_SESSION['id']."',
        '".$totalQty."',
        '".$subTotal."',
        '".$totalDelivaryCharge."',
        '".$totalOrderAmount."',
        '".$collectableAmount."',
        '".$totalPayableAmount."',
        '".$_POST['full_name']."',
        '".$shipping_address."',
        '".json_encode([
            'user_id' =>  $_SESSION['id'],
            'address1' => $_POST['address1'],
            'address2' => $_POST['address2'],
            'town_city' => $_POST['town_city'],
            'landmark' => $_POST['landmark'],
            'address_type' => $_POST['address_type'],
            'pincode' => $_POST['pincode'],
            'state' => $_POST['state'],
            'mobile' => $_POST['phno'],
            'created_at' => date("Y-m-d H:i:s"),
            'country' => 'India',
            'is_default' => '0',
        ])."',
        '".$_POST['phno']."',
        '".$_POST['email']."',
        '".$_POST['pincode']."',
        '".date("Y-m-d")."',
        '".date("H:i:s")."',
        '".$_POST['payment_method']."',
        '".$orderStatus."',
        '".(0)."',
        '".$txnStatus."',
        '".$_POST['phno']."',
        'STANDARD',
        '".(getStates()[(int)$_POST['state'] - 1]['name'])."',
        '".$_POST['town_city']."',
        '".date("Y-m-d H:i:s")."',
        '".date("Y-m-d H:i:s")."'
        )");

        $order_insert_id = $conn->insert_id; 

        if (isset($_SESSION['cart_list']) && count((array)$_SESSION['cart_list']) > 0) {
            foreach ($_SESSION['cart_list'] as $row) {
                $product = get_row($conn, "select * from products where id='".$row['pid']."'")[0];
                $item = get_row($conn, "select * from products_items where id='".$row['item_id']."'")[0];

                $tax = get_row($conn, "select * from taxes where id='".$product['tax_id']."'")[0];
                $itemPrice = (float)$item['combo_price'];
                $itemQty = (int)$row['qty'];
                $itemTotal = (float)$item['combo_price'] * (int)$row['qty'];
                $taxAmt = ((float)$itemTotal * (float)$tax['percent']) / (100 + (float)$tax['percent']);
                $itemPriceWithoutTax = $itemTotal - $taxAmt;

                $orderItem = $conn->query("insert into order_items(
                    order_id,
                    product_id,
                    pname,
                    item_id,
                    price,
                    color,
                    size,
                    product_type,
                    qty,
                    seller_id,
                    seller_name,
                    tax_amt,
                    ship_charge
                    ) values(
                        '".$orderId."',
                        '".$product['id']."',
                        '".$product['name']."',
                        '".$item['id']."',
                        '".$itemPriceWithoutTax."',
                        '".$item['color']."',
                        '".$item['size']."',
                        'Product',
                        '".(int)$row['qty']."',
                        '1',
                        'Easybuy',
                        '".(float)$taxAmt."',
                        '".$product['shipping_charge']."'
                        )");
        
                // $orderItem = new OrderItem();
                // $orderItem->order_id = $orderId;
                // $orderItem->product_id = $product->id;
                // $orderItem->pname = $product->name;
                // $orderItem->item_id = $item->id;
                // $orderItem->price = $itemPriceWithoutTax;
                // $orderItem->color = $item->color;
                // $orderItem->size = $item->size;
                // $orderItem->product_type = 'Product';
                // $orderItem->qty = (int)$row->qty;
                // $orderItem->seller_id = 1;
                // $orderItem->seller_name = 'Easybuy';
                // $orderItem->tax_amt = (float)$taxAmt;
                // $orderItem->ship_charge = $product->shipping_charge;
        
                // $orderItem->save();
                
            }
        }

// $order = new Order();
// $order->order_id = $orderId;
// $order->user_id = $_SESSION['id'];
// $order->total_qty = $totalQty;
// $order->total_price = $subTotal;
// $order->shipping_charges = $totalDelivaryCharge;
// $order->grand_total = $totalOrderAmount;
// $order->collectable_amount = $collectableAmount;
// $order->paid_amt = $totalPayableAmount;
// $order->receiver_name = $_POST['full_name'];
// $order->shipping_address = (!empty($address->address1) ? $address->address1 . ', ' : '') . (!empty($address->address2) ? $address->address2 . ', ' : '') . (!empty($address->town_city) ? $address->town_city . ', ' : '') . (!empty($address->landmark) ? $address->landmark . ', ' : '') . ', Address Type: ' . (!empty($address->address_type) ? $address->address_type . '' : '');
// $order->address_obj = json_encode($address->toArray());
// $order->contact_number = $_POST['phno'];
// $order->email = $_POST['email'];
// $order->postal_code = $address->pincode;
// $order->date = date("Y-m-d");
// $order->time = date("H:i:s");
// $order->payment_method = $request->payment_method;
// $order->status = $orderStatus;
// $order->discount = 0;
// $order->txn_status = $txnStatus;
// $order->contact_no = $_POST['phno'];
// $order->delivery_method = 'STANDARD';

// $order->state = Common::getStates()[(int)$address->state - 1]['name'];
// $order->city = $address->town_city;
// $order->save();
// dd($order);

// if ($data['cartList']->count() > 0) {
//     foreach ($data['cartList'] as $row) {
//         $product = Product::find($row->pid);
//         $item = ProductsItem::find($row->item_id);
//         $tax = Tax::find($product->tax_id);
//         $itemPrice = (float)$row->price;
//         $itemQty = (int)$row->qty;
//         $itemTotal = (float)$row->price * (int)$row->qty;
//         $taxAmt = ((float)$itemTotal * (float)$tax->percent) / (100 + (float)$tax->percent);
//         $itemPriceWithoutTax = $itemTotal - $taxAmt;

//         $orderItem = new OrderItem();
//         $orderItem->order_id = $orderId;
//         $orderItem->product_id = $product->id;
//         $orderItem->pname = $product->name;
//         $orderItem->item_id = $item->id;
//         $orderItem->price = $itemPriceWithoutTax;
//         $orderItem->color = $item->color;
//         $orderItem->size = $item->size;
//         $orderItem->product_type = 'Product';
//         $orderItem->qty = (int)$row->qty;
//         $orderItem->seller_id = 1;
//         $orderItem->seller_name = 'Easybuy';
//         $orderItem->tax_amt = (float)$taxAmt;
//         $orderItem->ship_charge = $product->shipping_charge;

//         $orderItem->save();
//     }
// }


// dd($totalOrderAmount, $totalPayableAmount, $collectableAmount, $totalTokenAmount, $paymentMode, $request->payment_method);






if ($paymentMode === 'ONLINE') {

    $orderUpdate = $conn->query("update orders set txn_id='".$_POST['txn_id']."', txn_status='SUCCESS', status='PLACED' where id='".$order_insert_id."'");

    // $order = Order::find($order->id);
    // $order->txn_id = $_POST['txn_id'];
    // $order->txn_status = 'PENDING';
    // $order->status = 'PENDING';
    // $order->save();

    $conn->query("insert into txn_histories(order_id, txn_id, order_data, status) values('".$orderId."', '".$_POST['txn_id']."', '".json_encode(['order_type' => 'self'])."', 'PENDING')");

    // $txn = new TxnHistory();
    // $txn->order_id = $orderId;
    // $txn->txn_id = $payment['order_id'];
    // $txn->order_data = json_encode($payment);
    // $txn->status = 'PENDING';
    // $txn->save();
} else {
    // dd(1);

    $orderUpdate = $conn->query("update orders set txn_id='".$_POST['txn_id']."', txn_status='SUCCESS', status='PLACED' where id='".$order_insert_id."'");
    // $order = Order::find($order->id);
    // $order->status = 'PLACED';
    // $order->save();
    // $this->sendOrderMailToUser($order, $user, 'success');
}

if($order){
    $order = get_row($conn, "select * from orders where order_id='".$orderId."' LIMIT 1")[0];
    sendOrderMailToUser($order, ['fname' => $_POST['full_name'] ,'email' => $_POST['email']], 'success');
    unset($_SESSION['cart_list']);
                echo '<script>Swal.fire({
                              title: "Success",
                              text: "Order has been placed successfully!",
                              icon: "success",
                              confirmButtonColor: "#3085d6",
                              confirmButtonText: "Ok"
                            }).then((result) => {
                              if (result.isConfirmed) {
                                window.location="'.str_replace('.php', '', $_SERVER['PHP_SELF']).'";
                              }
                            });</script>'; 
}
else{
     echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error while creating order!'
                      })</script>";
}
	    }
	    ?>
		<?php
// 			if(isset($_GET['id'])){ $id = $_SESSION['page_edit_similar'] = $_GET['id']; } 
// 			else{ $id = $_SESSION['page_edit_similar']; }
			
// 			if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Product'){
// 				$rows81=get_row($conn, "select * from similar_products where md5(product_id)='$id' LIMIT 1");
// 				$product=get_row($conn, "select * from products where md5(id)='{$id}'");
// 			}
			
			
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
									<span>Create Order</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"> Create Order
						
						</h1>
						<form action="" method="post">
							<!-- page contant -->
							<div class="row">
								<div class="col-md-12">
									<!-- BEGIN EXAMPLE TABLE PORTLET-->
									<div class="portlet box green">
										<div class="portlet-title">
											<div class="caption">
											<i class="fa fa-globe"></i>Create Order </div>
											<div class="tools"> </div>
										</div>
										<div class="portlet-body">
											
											<div class="row">
												<div class="col-md-6">
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
														   <h3>No Product Searched</h3>
														   <p>Please search product and add into cart</p>
													</div>
												</div>
												<div class="col-md-6">
													<div id="combobox"></div>
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
