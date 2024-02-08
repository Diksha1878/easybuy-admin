<?php session_start(); 
	include('includes/config.php');
?>


<!DOCTYPE html>

<html lang="en">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
		<title>Product | Admin Panel</title>
		<?php include('includes/head.php'); ?>
		<?php include('includes/script.php'); ?>
		<style>
			#pro_image img{
			width: 100%;
			height: 190px;
			}
		</style>
		<script>
			function getmultiple(inc)
			{
				inc = parseInt(inc);
				inc = inc+1;
				$.ajax({
					type:'post',
					url:'ajax/getmultiple.php',
					data:{
						inc:inc
					},
					success:function(response)
					{
						//alert(response);
						$('#more').append(response);
						$('#more').attr('data-val',inc);
					}
				});
			}
		</script>
		<script>
			function append(id)
			{
				$("#append"+id).append('<div class="col-md-4"><div class="form-group"><div class="col-sm-12 controls"><div class=""><div class="fileupload fileupload-new" data-provides="fileupload"><div class="fileupload-new thumbnail" style="height:200px;width:100%;"><img style="height: 148px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image"></div><div id="pro_image" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div></br><div><span style="width:49%" class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input name="img1'+id+'[]" accept="image/jpeg" type="file"></span><a href="#" style="width:49%" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a></div></div></div></div></div></div>');
			}
			function del_data(id)
			{
				
				var conf=confirm("Do you want to Delete ?");
				if(conf==1)
				{
					$.ajax({
						type:"post",
						url:"ajax/delete.php",
						data:{table:'brand',  id:id},
						success:function (res)
						{
							// console.log(res);
							window.location.reload();
						}
						
					});
				}
				
				
			}
			var id=1;
			function more_box(){
				$("#loading").show();
				$.ajax({
					type:'post',
					data:{
						id:id
					},
					url:'ajax/get_box.php',
					success:function(result){
						var data=result;
						$("#more_box").append(data);
						$("#box"+id).focus();
						$("#loading").hide();
					}
				});
				
				$("#box_count").val(id);
				id=id+1;
			}
		</script>
		<script>
			function deleteitembox(id){
				var x = '<input type="hidden" name="mrp[]" value=""><input type="hidden" name="price[]" value=""><input type="hidden" name="combo_price[]" value=""><input type="hidden" name="quantity[]" value=""><input type="hidden" name="weight[]" value=""><input type="hidden" name="unit_type[]" value=""><input type="hidden" name="dimension[]" value=""><input type="hidden" name="color[]" value=""><input type="hidden" name="size[]" value="">';
				
				$("#box_status"+id).val('delete');
				$("#box_head"+id).empty();
				$("#box_delete"+id).hide();
				$("#box_ribbon"+id).css("background","#eee");
				$("#box_ribbon"+id).css("border","none");
				$("#box_ribbon"+id).css("color","#000");
				$("#box_ribbon_text"+id).text("Deleted");
				$("#box_head"+id).html(x);
				
			}
		</script>
		<style>
			.portlet.box .dataTables_wrapper .dt-buttons {
			margin-top: 0px !important;
			}
		</style>
	</head>
	
	
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
		<?php
			$date1 = date("Y-m-d h:i:s a");
			
			
			if(isset($_POST['update'])){
				
				
				$name=trim(mysqli_real_escape_string($conn , $_POST['name']));
				$id=$_POST['id'];
				if(isset($_POST['status']))
				{
					$status=$_POST['status'];
					$status=" , status=$status";
				}
				else{
					$status=" ";
				}
				if($name!='')
				{
					
					$conn->query("update brands set name='$name', updated_at='$date' $status  modify_date='$date1' where id='$id'");
				}
				
				
				echo '<script>alert("Changes made  Successfully..!!");window.location="'.$_SERVER['PHP_SELF'].'";</script>';
				
			}
			if(isset($_POST['save_data']))
			{
				
				$box_count = $_POST['box_count'];
				/* echo "<pre>";
				print_r($_POST);die; */
				
				//$dept = trim(mysqli_real_escape_string($conn , $_POST['dept']));
				$dept = 0;
				$cat=trim(mysqli_real_escape_string($conn , $_POST['cat']));
				if(isset($_POST['subcat'])){ $subcat=trim(mysqli_real_escape_string($conn , $_POST['subcat'])); }else{ $subcat=""; }
				if(isset( $_POST['brand'])){ $brand=trim(mysqli_real_escape_string($conn , $_POST['brand'])); }else{ $brand=""; }
				
				$name=sanitize_string($_POST['name']);
				$short_desp=base64_encode(trim($_POST['short_desp']));
				$long_desp=base64_encode(trim($_POST['long_desp']));
				$caption=sanitize_string($_POST['caption']);
				$keyword=sanitize_string($_POST['keyword']);
				$ship_charge=(float)sanitize_string($_POST['ship_charge']);
				$status=sanitize_string($_POST['status']);
				$tax_id=sanitize_string($_POST['tax_id']);
				$token_amt_rate=(float)sanitize_string($_POST['token_amt_rate']);
				//$vat=trim(mysqli_real_escape_string($conn , $_POST['vat']));
				$vat=0;
				//$cst=trim(mysqli_real_escape_string($conn , $_POST['cst'])); 
				$cst=0; 
				$meta_desp=sanitize_string($_POST['meta_desp']); 
				$meta_keyword=sanitize_string($_POST['meta_keyword']); 
				$asi_no=sanitize_string($_POST['asi_no']); 
				$ptag=$_POST['ptag']; 
				
				
				/* insert data into products table */
				$sql=$conn->query("insert into products(dept_id,cat_id,sub_cat_id,brand_id,name,caption_name,keyword,status,create_date,short_desp,long_desp,shipping_charge,product_tag,vat,cst,meta_desp,meta_keyword,tax_id,asi_no,created_at,token_amt_rate) values('$dept','$cat','$subcat','$brand','$name','$caption',' $keyword','$status','$date1','$short_desp','$long_desp','$ship_charge','$ptag','$vat','$cst','$meta_desp','$meta_keyword','$tax_id','$asi_no','$date','$token_amt_rate')");
				
				/* Get product id */
				/* $query = $conn->query("SELECT Max(id) as mexid FROM products");
					if($row = mysqli_fetch_array($query)){
					$Maxid = $row['mexid'];
					$Maxid = $Maxid;
					
				} */
				
				$Maxid = mysqli_insert_id($conn);
				$item_error = false;
				
				if($sql==1){
					
					for($i=0;$i<=$box_count;$i++){
						
						if($_POST['box_status'][$i]=='insert'){ 

							$_POST['combo_price'][$i] = 0;
							
							$qty=trim(mysqli_real_escape_string($conn , $_POST['quantity'][$i]));
							$weight=trim(mysqli_real_escape_string($conn , $_POST['weight'][$i])); 
							$unit_type=trim(mysqli_real_escape_string($conn , $_POST['unit_type'][$i])); 
							$size=trim(mysqli_real_escape_string($conn , $_POST['size'][$i])); 
							$color=trim(mysqli_real_escape_string($conn , $_POST['color'][$i])); 
							$item_name=trim(mysqli_real_escape_string($conn , $_POST['item_name'][$i])); 
								$item_desp=	base64_encode(trim($_POST['item_desp'][$i]));
							
							
							$mrp=trim(mysqli_real_escape_string($conn , $_POST['mrp'][$i]));
							$price=trim(mysqli_real_escape_string($conn , $_POST['price'][$i]));
							$combo_price=trim(mysqli_real_escape_string($conn , $_POST['combo_price'][$i]));
							
							if(isset($_POST['dimension'])){
								$dimension=trim(mysqli_real_escape_string($conn , $_POST['dimension'][$i]));
								}else{
								$dimension="";
							}
							
							if($price>=$mrp || $combo_price>=$price || $combo_price>=$mrp){ //price verification
								echo "<script>alert('Price verification Error on block ".($i+1)." !')</script>";
								
							}
							else{
								
								/* Get products_item id */
								// $query1 = $conn->query("SELECT Max(id) as mexid FROM products_items");
								// if($row = mysqli_fetch_array($query1)){
								// 	$p_item_id = $row['mexid'];
								// 	$p_item_id = $p_item_id + 1;
								
								$p_item_id = null;
									
								// }
								// else{
								// 	$p_item_id = 1;	
								// }
								
								/* SKU generation */
								// if($box_count==0){
								// 	$sku = "S-".date("ymd-").$Maxid."-".$p_item_id."-".$size."-".$color;
								// }
								// else{
								// 	$sku = "C-".date("ymd-").$Maxid."-".$p_item_id."-".$size."-".$color;
								// }
								
								$sku=trim(mysqli_real_escape_string($conn , $_POST['sku'][$i])); 
								
								
								/* insert data into products_item table */
								$sql_query = "insert into products_items(pid,weight,unit_type,dimension,mrp,price,combo_price,qty,date,sku,size,color,created_at,item_name,item_desp) values('$Maxid','$weight','$unit_type','$dimension','$mrp','$combo_price','$price','$qty','$date1','$sku','$size','$color','$date','$item_name','$item_desp')";
								$sql1=$conn->query($sql_query);
								
								/* check insert status products_item table */
								if($sql1==1){
									$p_item_id = mysqli_insert_id($conn);
									$image_count=count($_FILES['img1'.$i]['name']);
									
									for($x=0;$x<$image_count;$x++){
										
										if(isset($_FILES['img1'.$i]) && $_FILES['img1'.$i]['name'][$x]){
											$errors= array();
											
											$rand=rand(1111,9999);
											
											$img1_name= "IMG".$x."-".date("Ymdhis").$rand.".jpg";
											$img1_tmp=$_FILES['img1'.$i]['tmp_name'][$x];
											
											$desired_dir="data/product_images/";
											if(empty($errors)==true){
												if(is_dir($desired_dir)==false){
													mkdir("$desired_dir", 0700);		// Create directory if it does not exist
												}
												
												move_uploaded_file($img1_tmp,"$desired_dir/".$img1_name);
												
											}
											else{	// rename the file if another one exist
												$new_dir="$desired_dir/".$file_name.time();
												rename($file_tmp,$new_dir) ;				
											}
											
											$ext=".jpg";
											include_once('functions/img_resize.php');
											$target_file = $desired_dir.$img1_name;
											$thumb_file = $desired_dir."thumb_".$img1_name;
											$banner_file = $desired_dir."banner_".$img1_name;
											$zoom_file = $desired_dir."zoom_".$img1_name;
											
											$thumb = "thumb_".$img1_name;
											$banner = "banner_".$img1_name;
											$zoom = "zoom_".$img1_name;
											
											$thumb_width = 150;
											$thumb_height = 150;
											$banner_width = 300;
											$banner_height = 300;
											$zoom_width = 1100;
											$zoom_height = 1100;
											
											img_resize($target_file, $thumb_file, $thumb_width, $thumb_height, $ext);
											img_resize($target_file, $banner_file, $banner_width, $banner_height, $ext);
											img_resize($target_file, $zoom_file, $zoom_width, $zoom_height, $ext);
											
											/* insert data products_image  */
											$conn->query("insert into products_images(pid,p_item_id,date,thumb,banner,zoom,created_at) values('$Maxid','$p_item_id','$date1','$thumb','$banner','$zoom','$date')");
											if($x==0){
												$conn->query("update products_items set thumb_image='$thumb', updated_at='$date' where id='$p_item_id'");
											}
											
											
										}
										
									} /* end image insert */
								}
								else{
								    	$item_error = true;
                                    create_log("Error while inserting product item: ".$sql_query, "products table inserted by {$_SESSION['name']}");
									echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Error while inserting product item!',
                                        footer: `<a target='_blank' href='./log.txt'>See logs</a>`
                                      })</script>";
								}
							}
							
						}
						if($i==0){
							$conn->query("update products set thumb_image='$thumb', updated_at='$date' where id='$Maxid'");
						}
					}
					$specification = $_POST['specification'];
					$date = date('Y-m-d');
					$n=0;
					foreach($specification as $s)
					{
						if($s!='')
						{
							$insert3 = "insert into product_specifications(pid,specification,date,created_at) values('$Maxid','$s','$date','$date')";
							$conn->query($insert3);
							$n++;
						}
					}
					
					if($item_error === false){
					       echo '<script>Swal.fire({
                              title: "Success",
                              text: "Data saved successfully!",
                              icon: "success",
                              confirmButtonColor: "#3085d6",
                              confirmButtonText: "Ok"
                            }).then((result) => {
                              if (result.isConfirmed) {
                                window.location="'.str_replace('.php', '', $_SERVER['PHP_SELF']).'";
                              }
                            });</script>';
					}

                 
				}
				else{
					/* rollback */
					$conn->query("delete from products where id='$Maxid'");
                    create_log("Error while inserting product: "."insert into products(dept_id,cat_id,sub_cat_id,brand_id,name,caption_name,keyword,status,create_date,short_desp,long_desp,shipping_charge,product_tag,vat,cst,meta_desp,meta_keyword,tax_id,asi_no,created_at,token_amt_rate) values('$dept','$cat','$subcat','$brand','$name','$caption',' $keyword','$status','$date1','$short_desp','$long_desp','$ship_charge','$ptag','$vat','$cst','$meta_desp','$meta_keyword','$tax_id','$asi_no','$date','$token_amt_rate')", "products table inserted by {$_SESSION['name']}");
                    echo "<script>Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error while inserting product!',
                        footer: `<a target='_blank' href='./log.txt'>See logs</a>`
                      })</script>";
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
									<a href="index-2.html">Home</a>
									<i class="fa fa-circle"></i>
								</li>
								<li>
									<span>Product</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title">Product</h1>
						
						<div class="row">
							<div class="col-md-12 ">
								
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="icon-settings font-dark"></i>
											<span class="caption-subject font-dark sbold uppercase">Add Product</span>
										</div>
										
									</div>
									<div class="portlet-body form">
										<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
											<!-- <div class="form-group">
												<label class="col-md-3 control-label">Select Department</label>
												<div class="col-md-9">
													<select class="form-control" name="dept"  onchange="get_cat(this.value)" required>
														
														<option value="">Select</option>
														<?php 
															$get_dept=$conn->query("select * from departments");
															while($dept=mysqli_fetch_assoc($get_dept))
															{
															?>
															
															<option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
															<?php
																
															}
														?>
														
													</select>
												</div>
											</div>
											<div id="cat"></div> -->
											
											<div class="form-group">
												<label class="col-md-3 control-label">Select Category <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<select class="form-control" name="cat"  id="cat" onchange="get_subcat(this.value)" required>
														
														<option value="">Select</option>
														<?php 
															$get_dept=$conn->query("select * from cats where status='1'");
															while($dept=mysqli_fetch_assoc($get_dept))
															{
															?>
															
															<option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
															<?php
																
															}
														?>
														
													</select>
												</div>
											</div>
											
											<div id="subcat"></div>
											<!-- <div id="brand"></div> -->
											
											<div class="form-group">
												<label class="col-md-3 control-label">Select Brand <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<select class="form-control" name="brand" required>
														
														<option value="">Select</option>
														<?php 
															$get_dept=$conn->query("select * from brands where status='1'");
															while($dept=mysqli_fetch_assoc($get_dept))
															{
															?>
															
															<option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
															<?php
																
															}
														?>
														
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Product Tag</label>
												<div class="col-md-9">
													<select class="form-control" name="ptag">
														<option value="">Select</option>
														<option value="New">New</option>
														<option value="Sale">Sale</option>
														<option value="Upcoming">Upcoming</option>
													</select>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Product Name <span class="text-danger">*</span></label>
												<div class="col-md-9">
												    
													<input maxlength="500" type="text" class="form-control" placeholder="Enter Product Name" id="name" name="name" required/>
													<small class="text-info">Max length: 500</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Serial No. <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<input maxlength="500" type="text" class="form-control" value="<?php echo date("YmdHis").mt_rand(1000,9999); ?>" placeholder="Enter Serial No." id="name" name="asi_no" required/>
													<small class="text-info">Max length: 500</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Short Description</label>
												<div class="col-md-9">
													<textarea id="short_desp" name="short_desp"></textarea>
													<script>
														$(document).ready(function() {
															$('#short_desp').summernote({
																height:150
															});
														});
													</script>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Long Description</label>
												<div class="col-md-9">
													<textarea id="long_desp" name="long_desp"></textarea>
													<script>
														$(document).ready(function() {
															$('#long_desp').summernote({
																height:200
															});
														});
													</script>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Meta Description</label>
												<div class="col-md-9">
													<textarea maxlength="250" rows="3" class="form-control" placeholder="Enter Meta Description" id="meta_desp" name="meta_desp"></textarea>
													<small class="text-info">Max length: 250</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Meta Keywords</label>
												<div class="col-md-9">
													
													<textarea maxlength="100" rows="3" class="form-control" placeholder="Enter Meta Keywords" id="meta_keyword" name="meta_keyword"></textarea>
													<small class="text-info">Max length: 100</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Caption Name</label>
												<div class="col-md-9">
													<input maxlength="500" type="text" class="form-control" placeholder="Enter Caption Name" id="caption" name="caption" />
													<small class="text-info">Max length: 500</small>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Keywords</label>
												<div class="col-md-9">
													<input maxlength="100" type="text" class="form-control" placeholder="Enter Keywords" id="keyword" name="keyword"/>
                                                    <small class="text-info">Max length: 100</small>												
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Shipping Charge</label>
												<div class="col-md-9">
													<input type="number" min=0 class="form-control" placeholder="Enter the Shipping Amount" id="ship_charge" name="ship_charge" />
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Select Tax <span class="text-danger">*</span></label>
												<div class="col-md-9">
													
													<select name="tax_id" class="form-control" required>
														<option value="">select</option>
														<?php 
															$taxes = get_row($conn, "select * from taxes order by id desc");
															foreach($taxes as $tax){
															?>
															<option value="<?php echo $tax['id']; ?>"><?php echo $tax['name']; ?> - <?php echo $tax['percent']; ?>%</option>
														<?php } ?>
													</select>
													<span class="help-block"> </span>
												</div>
											</div>
											<!-- <div class="form-group">
												<label class="col-md-3 control-label">VAT Percent</label>
												<div class="col-md-9">
													<input type="number" class="form-control" placeholder="Enter VAT Percent" id="vat" name="vat" />
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">CST Percent</label>
												<div class="col-md-9">
													<input type="number" class="form-control" placeholder="Enter CST Percent" id="cst" name="cst" />
													<span class="help-block"> </span>
												</div>
											</div> -->
											<div id="more" data-val='0'>
												<div class="form-group" data-id='0'>
													<label class="col-md-3 control-label">Specification</label>
													<div class="col-md-7">
														<textarea maxlength="500" name="specification[]" class="form-control" placeholder="Enter specification by @: separated, Example: Data Title @: Data Description"></textarea>
														<small class="text-info">Max length: 500</small>
													</div>
													<div class="col-sm-2">
														<i onclick="getmultiple($('#more').attr('data-val'))" class="fa fa-plus-square" style="margin-top:10px;font-size:20px"></i>
													</div>
												</div>
											</div>
                                            <div class="form-group">
												<label class="col-md-3 control-label">Advance Token Amount Rate</label>
												<div class="col-md-9">
													<input type="number" class="form-control" placeholder="Enter Advance Token Amount Rate (%)" id="token_amt_rate" name="token_amt_rate"/>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Status <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<div class="mt-radio-inline">
														<label class="mt-radio">
															<input type="radio" name="status"  value="1" checked=""> Active
															<span></span>
														</label>
														<label class="mt-radio">
															<input type="radio" name="status" value="0" > In-Active
															<span></span>
														</label>
														
													</div>
												</div>
											</div>
											
											<hr>
											<div id="box0">
												<input id="box_status0" type="hidden" name="box_status[]" value="insert">
												
												
												<div  id="box_ribbon0" style="width: 100%;text-align: left;padding: 10px;border: solid 1px #F44336;background: #ff6156;color: #fff;font-weight: bold;" >Variety 1
												<span id="box_ribbon_text0"></span></div>
												<div id="box_head0">
													<div style="border-radius: 4px;border-top-left-radius:0;border-top-right-radius:0;padding: 15px;border: solid 1px #ccc;background: #f9f9f9;">
                                                        <div class="form-group">
															<label class="col-md-3 control-label">Item Name <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input maxlength="100" type="text" class="form-control" placeholder="Enter Item Name" id="item_name" name="item_name[]" required/>
																<small class="text-info">Max length: 100</small>
																<span class="help-block"> </span>
															</div>
														</div>
														<div class="form-group">
												<label class="col-md-3 control-label">Description</label>
												<div class="col-md-9">
													<textarea id="item_desp0" name="item_desp[]"></textarea>
													<script>
														$(document).ready(function() {
															$('#item_desp0').summernote({
																height:150
															});
														});
													</script>
													<span class="help-block"> </span>
												</div>
											</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Size / Color <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<div class="row">
																	<div class="col-md-6">
																		<select class="form-control" name="size[]" required>
																			<option value="">Select Size</option>
																			
																			<?php 
																				$rows = get_row($conn, "select * from sizes");
																				foreach($rows as $row){ ?>
																				<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
																			<?php } ?>
																		</select>
																		<span class="help-block"> </span>
																	</div>
																	<div class="col-md-6">
																		<select class="form-control" id="color" name="color[]" required>
																			<option value="">Select Color</option>
																			
																			<?php 
																				$rows1 = get_row($conn, "select * from colors");
																				foreach($rows1 as $row1){ ?>
																				<option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
																			<?php } ?>
																		</select>
																		
																		<span class="help-block"> </span>
																	</div>
																</div>
																
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Product M.R.P. <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input onblur="setsaleprice(this.value,0)" type="number" min=1 class="form-control" placeholder="Enter Maximum Retail Price" id="mrp0" name="mrp[]" required/>
																<span class="help-block"> </span>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-3 control-label">Sale Price <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input onkeyup="setcomboprice(this.value,$('#mrp0').val(),0)" type="number" min=1 class="form-control" placeholder="Enter Sale Price" id="price0" name="price[]" required/>
																<span class="help-block help_price0"> </span>
															</div>
														</div>
														<!-- <div class="form-group">
															<label class="col-md-3 control-label">Sale Price</label>
															<div class="col-md-9">
																<input onkeyup="setcombowarning(this.value,$('#price0').val(),0)" type="number" min=1 class="form-control" placeholder="Sale Price" id="combo_price0" name="combo_price[]" required/>
																<span class="help-block help_comboprice0"> </span>
															</div>
														</div>
														 -->
														<div class="form-group">
															<label class="col-md-3 control-label">Product Quantity <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input type="number" min=0 class="form-control" placeholder="Enter Product Quantity" id="quantity" name="quantity[]" required/>
																<span class="help-block"> </span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">SKU</label>
															<div class="col-md-9">
																<input maxlength="100" type="text" class="form-control" placeholder="Enter SKU" id="sku" name="sku[]" />
																<small class="text-info">Max length: 100</small>
																<span class="help-block"> </span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Product Weight <span class="text-danger">*</span></label>
															<div class="col-md-6">
																<input type="number" class="form-control" placeholder="Enter Product Weight" id="weight" name="weight[]" required/>
																<span class="help-block"> </span>
															</div>
															<div class="col-md-3">
																<select class="form-control" id="unit_type" name="unit_type[]" required/>
																	<option value="">Select <span class="text-danger">*</span></option>
																	<option value="Kg">Kg</option>
																	<option value="Gram">Gram</option>
																	<option value="Liter">Liter</option>
																</select>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-3 control-label">Show Dimension</label>
															<div class="col-md-9">
																<div class="mt-radio-inline">
																	<label class="mt-radio">
																		<input onclick="showdimension(1,0)" type="radio" name="dimensionstatus0[]"  value="1"> Show
																		<span></span>
																	</label>
																	<label class="mt-radio">
																		<input onclick="showdimension(0,0)" type="radio" name="dimensionstatus0[]" value="0" checked> Hide<span></span>
																	</label>
																</div>
																<span class="help-block"> </span>
															</div>
														</div>
														<div class="form-group" id="dimension0" style="display:none;">
															<label class="col-md-3 control-label">Dimension</label>
															<div class="col-md-9">
																<input maxlength="100" type="text" class="form-control" placeholder="Enter Product Dimension" id="dimension" name="dimension[]"/>
																<small class="text-info">Max length: 100</small>
																<span class="help-block"> </span>
															</div>
														</div>
														
														
														<div class="row">
														    <div class="col-md-12" style="margin-bottom:16px">	<small class="text-info">Image dimension: 1100x1100</small></div>
															<div class="col-md-4">
																<div class="form-group">
																	<div class="col-sm-12 controls">
																		<div class="">
																			<div class="fileupload fileupload-new" data-provides="fileupload">
																				<div class="fileupload-new thumbnail" style="height:200px;width:100%;">
																					<img style="height: 148px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image">
																				</div>
																				<div id="pro_image" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div>
																				</br>
																				<div>
																					<span style="width:49%" class="btn btn-file btn-primary">
																						<span class="fileupload-new">Select image <span class="text-danger">*</span></span>
																						
																						<span class="fileupload-exists">Change</span>
																						<input name="img10[]" accept="image/jpeg" type="file" required>
																					</span>
																					<a href="#" style="width:49%" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
																					
																				</div>
																			
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div id="append0"></div>
														</div>
														<div class="form-actions">
															<button type="button" class="btn btn-danger btn-sm pull-right" onclick="append(0)">+ Add more</button>
														</div>
													</div>
												</div>
											</div>
											<div id="more_box"></div>
											<input type="hidden" id="box_count" name="box_count" value="0">
											<hr style="margin:0">
											<div class="form-actions">
												<div class="row">
													<div class="col-md-offset-0 col-md-12">
														<a onclick="more_box()" class="btn red">Add More Variety</a>
														<a id="loading" style="display:none;"><img style="margin-left:5px;height:32px;width:32px;" src="img/loading.gif"></a>
														<button type="submit" class="btn green pull-right" name="save_data">Submit</button>
														
													</div>
												</div>
											</div>
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
