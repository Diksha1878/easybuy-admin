<?php session_start();
	include('../includes/config.php');
	include('../functions/function.php');
	
	if(isset($_SESSION['similar_product_type']) && $_SESSION['similar_product_type']=='Product'){
// 		$rows81=get_row($conn, "select * from similar_products where md5(product_id)='{$_SESSION['page_edit_similar']}' LIMIT 1");
// 		$product=get_row($conn, "select * from products where md5(id)='{$_SESSION['page_edit_similar']}'");
	}
	
	
?>

<div>
	

	<?php
// 	echo '<pre>';
// 	print_r($_SESSION);
// 	echo '</pre>';
	$sub_total = 0;
	$delivery_charge = 0;
	$grand_total = 0;
	$token_amount = 0;
	$collectable_amount = 0;
	$img = '';
		if(isset($_SESSION['cart_list']) && count($_SESSION['cart_list'])!=0){
		?>
		<h3 style="margin-top:0">Cart List</h3>
		<table class="table">
																	<thead style="background: #eee;">
																		<tr style="border-bottom: solid 1px #eee;">
																			<th style="min-width:50px;">ID&nbsp;&nbsp;</th>
																			<th > Name </th>
																			<th > Price </th>
																			<th> Qty </th>
																			<th style="text-align:right;"></th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			$inc=1;
																			$total1=0;  
																			
																			
																				
																			
																			foreach($_SESSION['cart_list'] as $item){
																				$rows41=get_row($conn, "select * from products where id='{$item['pid']}'");
																				$rows42=get_row($conn, "select * from products_items where id='{$item['item_id']}'");
																				
																				$sub_total += $item['qty']*$rows42[0]['combo_price'];
																				$delivery_charge += $rows41[0]['shipping_charge'];
																				$token_amount += $rows41[0]['token_amt_rate']*$item['qty'];
																				
																			?>
																			<tr style="border-bottom:solid 1px #eee">
																				<td><?php echo  $inc; ?></td>
																				<td><?php echo  $rows41[0]['name']; ?>  (<?php echo  $rows42[0]['item_name']; ?>)</td>
																				<td><?php echo  $rows42[0]['combo_price']; ?></td>
																				<td style="width:100px;"><input onchange="updateCart(this, '<?php echo  $rows42[0]['id']; ?>', '<?php echo  $rows41[0]['id']; ?>')" onkeyup="updateCart(this, '<?php echo  $rows42[0]['id']; ?>', '<?php echo  $rows41[0]['id']; ?>')" min="1" type="number" style="text-align:center;padding-right: 4px;" class="form-control" value="<?php echo $item['qty']; ?>"/></td>
																				
																				<td  style="text-align:right;padding-top: 16px;">
																					<a onclick="addsimilar(<?php echo $item['item_id']; ?>,<?php echo $item['pid']; ?>)" ><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
																					
																				</td>
																			</tr>
																			<?php $total1 = $total1+$rows42[0]['combo_price']; ?>
																			
																			<?php 
																				if(isset($_SESSION['cart_list'])){ $cart_list = count($_SESSION['cart_list']); }else{ $cart_list = 0; }
																				$count = $cart_list;
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
		
			                                                <?php 
															$grand_total = ($sub_total+$delivery_charge);
															$collectable_amount = $grand_total-$token_amount;
															?>
															
															<div class="row" style="margin-bottom: 10px;">
																
																
																<form action="" method="post">
																
																<div class="col-md-12">
																<h3>Address</h3>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Full Name</label>
                                                                        <input name="full_name" type="text" class="form-control" placeholder="Full Name" required />
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Mobile Number</label>
                                                                        <input name="phno" type="number" class="form-control" placeholder="Mobile Number" required />
                                                                      </div>
																</div>
																	<div class="col-md-12">
																    <div class="form-group">
                                                                        <label >Email</label>
                                                                        <input name="email" type="email" class="form-control" placeholder="Email" required />
                                                                      </div>
																</div>
																<div class="col-md-12">
																    <div class="form-group">
                                                                        <label >Flat/House No/Building No</label>
                                                                        <textarea name="address1" type="text" class="form-control" placeholder="Flat/House No/Building No"  required ></textarea>
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Road name/Area/Colony</label>
                                                                        <input name="address2" type="text" class="form-control" placeholder="Road name/Area/Colony" required />
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Town/City</label>
                                                                        <input name="town_city" type="text" class="form-control" placeholder="Town/City" required />
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Pincode</label>
                                                                        <input name="pincode" type="number" class="form-control" placeholder="Pincode" required />
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >State</label>
                                                                        <select name="state" class="form-control" name="state" required="">
<option value="">Select state</option>
<?php 
$stateList = getStates();
if(count($stateList)){
 foreach($stateList as $state){
  ?>
  <option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
  <?php
 }   
}

?>


</select>
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Address type</label>
                                                                        
                                                                        <select name="address_type" class="form-control" required>
                                                                            <option value="">Select</option>
                                                                            <option value="home">Home</option>
                                                                            <option value="office">Office</option>
                                                                        </select>
                                                                      </div>
																</div>
																<div class="col-md-6">
																    <div class="form-group">
                                                                        <label >Landmark</label>
                                                                        <input name="landmark" type="text" class="form-control" placeholder="Landmark" />
                                                                      </div>
																</div>
																
																
																
															   	<div class="col-md-12" style="text-align:right">
																<h4>Subtotal: Rs <?php echo number_format($sub_total, 2); ?></h4>
																<h4>Delivery Charges: Rs <?php echo number_format($delivery_charge, 2); ?></h4>
																<h4>Grand Total: Rs <?php echo number_format($grand_total, 2); ?></h4>
																<h4>Token Amount: Rs <span class="token_amount"><?php echo str_replace(',','',number_format($token_amount, 2)); ?></span></h4>
																<h4>Collectable Total: Rs <span class="collectable_amount"><?php echo str_replace(',','',number_format($collectable_amount, 2)); ?></span></h4>
																</div> 
																<div class="col-md-12" style="text-align:right;zoom:1.2">
																    <input class="token_amount_val" type="hidden" value="<?php echo $token_amount; ?>"/>
																    <input class="collectable_amount_val" type="hidden" value="<?php echo $collectable_amount; ?>"/>
																   <input name="is_paid_token_amt" checked class="paid_token_amt" onchange="updateTokenAmtStatus(event)" type="checkbox" /> Already Paid Token Amount 
																</div>
																<div class="col-md-12" style="text-align:right;zoom:1.2">
																    <input class="token_amount_val" type="hidden" value="<?php echo $token_amount; ?>"/>
																    <input class="collectable_amount_val" type="hidden" value="<?php echo $collectable_amount; ?>"/>
																   <input name="payment_method" value="ONLINE" onclick="($('.paid_token_amt').is(':checked')) ? $('.paid_token_amt').trigger('click') : '';$('.ref_no').prop('required', true);$('.paid_token_amt').prop('disabled', true);$('.collectable_amount').text((0).toFixed(2))" type="radio" /> Online
																   <input name="payment_method" value="COD" onclick="$('.paid_token_amt').prop('disabled', false);$('.paid_token_amt').trigger('click');" checked type="radio" /> COD 
																</div>
																<div class="col-md-12">
																    <div class="form-group">
                                                                        <label >Payment Reference No.</label>
                                                                        <input name="txn_id" type="text" class="form-control ref_no" placeholder="Payment Reference No." required />
                                                                      </div>
																</div>
															
																<div class="col-md-12" style="margin-bottom:24px;margin-top:24px;text-align:right;">
																<button name="place_order" class="btn btn-primary">Place Order</button>
																</div>
																</form>
															</div>
	<?php } ?>
	<div class="row" style="margin-bottom: 10px;">
		
		<div class="col-md-12">
			<input type="hidden" id="image_selection" value="1">
			<?php if(!empty($img)){ ?>
			<div id="autocomboimg" style="border: solid 1px #ccc;
			padding: 8px;"><div id="img_container1" style="width:100%;height:320px;min-width:300px;"><?php echo $img; ?></div></div>
			<?php } ?>
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