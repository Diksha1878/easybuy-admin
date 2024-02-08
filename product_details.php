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
			
			.cus-hide{
			    visibility: hidden;
			    z-index: -10;
			}
		</style>
		<script>
			
			function del_data(id)
			{
				
				var conf=confirm("Do you want to Delete ?");
				if(conf==1)
				{
					$.ajax({
						type:"post",
						url:"ajax/delete.php",
						data:{table:'items',  id:id},
						success:function (res)
						{
							//console.log(res);
							window.location.reload();
						}
						
					});
				}
				
				
			}
			
		</script>
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
			
			function imageRemoveHandler(e, id){
			    if(e.target.files[0]){
			         $(e.target).parents('.pimg-box').find('.db-file-remove-btn').attr('data-id','0')
			    }
			    else{
			         $(e.target).parents('.pimg-box').find('.db-file-remove-btn').attr('data-id',id)
			    }
			}
			
			function removeImage(id, e){
			    if(id != 0){
    			     Swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                      if (result.isConfirmed) {
                            $.ajax({
        						type:"post",
        						url:"ajax/delete.php",
        						data:{table:'product_image',  id:id},
        						success:function (res)
        						{
        						    $(e.target).parents('.pimg-box').remove()
        				// 			console.log(res);
        				// 			window.location.reload();
                    				 Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                    )
        						}
        						
        					});
                       
                      }
                    })   
			    }
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
			if(isset($_GET['id'])){ $id = $_SESSION['page_product_details'] = $_GET['id']; } 
			else{ $id = $_SESSION['page_product_details']; }
			
			$rows=get_row($conn, "select * from products where md5(id)='$id'");
			
		?>
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
					
					$conn->query("update brands set name='$name' $status , modify_date='$date1' where id='$id'");
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
				$is_indexable=sanitize_string($_POST['is_indexable']);
				$tax_id=sanitize_string($_POST['tax_id']);
					$token_amt_rate=(float)sanitize_string($_POST['token_amt_rate']);
				//$vat=trim(mysqli_real_escape_string($conn , $_POST['vat']));
				$vat=0;
				//$cst=trim(mysqli_real_escape_string($conn , $_POST['cst']));
				$cst=0;
				$meta_desp=trim(mysqli_real_escape_string($conn , $_POST['meta_desp'])); 
				$meta_keyword=trim(mysqli_real_escape_string($conn , $_POST['meta_keyword'])); 
				$asi_no=trim(mysqli_real_escape_string($conn , $_POST['asi_no'])); 
				$ptag=$_POST['ptag'];
				
				
				/* Update data into products table */
				$sql=$conn->query("update products set is_indexable='$is_indexable', asi_no='$asi_no', tax_id='$tax_id', meta_desp='$meta_desp', meta_keyword='$meta_keyword', product_tag='$ptag', dept_id='$dept', cat_id='$cat', sub_cat_id='$subcat', brand_id='$brand', name='$name', caption_name='$caption', keyword=' $keyword', status='$status', modify_date='$date1', short_desp='$short_desp', long_desp='$long_desp', shipping_charge='$ship_charge', vat='$vat', cst='$cst',token_amt_rate='$token_amt_rate' where id='{$_POST['product_id']}'");
				
				$item_error = false;
				
				/* check insert status products table */
				if($sql==1){
					
					for($i=0;$i<=$box_count;$i++){
						if($_POST['box_type'][$i]=='update' || $_POST['box_type'][$i]=='insert'){

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
									
								// }
								// else{
								// 	$p_item_id = 1;	
								// }
								
								$p_item_id = null;
								
								/* SKU generation */
								// if($box_count==0){
								// 	$sku = "S-".date("ymd-").$_POST['product_id']."-".$p_item_id."-".$size."-".$color;
								// }
								// else{
								// 	$sku = "C-".date("ymd-").$_POST['product_id']."-".$p_item_id."-".$size."-".$color;
								// }
								
								$sku=trim(mysqli_real_escape_string($conn , $_POST['sku'][$i]));
								
								if($_POST['box_type'][$i]=='update'){
								    $sql_query = "update products_items set item_desp='$item_desp', sku='$sku', weight='$weight', unit_type='$unit_type', dimension='$dimension', mrp='$mrp', price='$combo_price', combo_price='$price', qty='$qty', modify_date='$date1', size='$size', color='$color',item_name='$item_name' where id='{$_POST['item_id'][$i]}'";
								    
								    	$sql1=$conn->query($sql_query);
									$p_item_id = $_POST['item_id'][$i];
									
								}
								if($_POST['box_type'][$i]=='insert'){
									/* insert data into products_item table */
									
									$sql_query = "insert into products_items(pid,weight,unit_type,dimension,mrp,price,combo_price,qty,date,sku,size,color,item_name,item_desp) values('{$_POST['product_id']}','$weight','$unit_type','$dimension','$mrp','$combo_price','$price','$qty','$date1','$sku','$size','$color','$item_name','$item_desp')";
										$sql1=$conn->query($sql_query);
								$p_item_id = mysqli_insert_id($conn);
								}
								
								
								
								
								/* check insert status products_item table */
								if($sql1==2){
									
									$image_count=count($_FILES['img1'.$i]['name']);
									
									for($x=0;$x<$image_count;$x++){
										if(isset($_FILES['img1'.$i]) && $_FILES['img1'.$i]['name'][$x]){
											/* Image insertion code */ 
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
											/* End Image insertion code */
											
											if($_POST['box_type'][$i]=='update'){ /* box type check (insert/update)*/
												//var_dump('update');
												//var_dump($_POST['item_id'][$i]);
												if($_POST['image_type'.$i][$x]=='update'){ /* image type check (insert/update)*/
													//var_dump('image_update');
													$conn->query("update products_images set modify_date='$date1', thumb='$thumb', banner='$banner', zoom='$zoom' where id='{$_POST['img_id'.$i][$x]}'");
												}
												else{
													//var_dump('image_insert');	
													$conn->query("insert into products_images(pid,p_item_id,date,thumb,banner,zoom) values('{$_POST['product_id']}','{$p_item_id}','$date1','$thumb','$banner','$zoom')");
													
												}
											}
											else{
												//var_dump('insert');
												//var_dump($p_item_id);
												if($_POST['image_type'.$i][$x]=='update'){ /* image type check (insert/update)*/
													//var_dump('image_update');
													
												}
												else{
													//var_dump('image_insert');	
													$conn->query("insert into products_images(pid,p_item_id,date,thumb,banner,zoom) values('{$_POST['product_id']}','$p_item_id','$date1','$thumb','$banner','$zoom')");
													$conn->query("update products_items set thumb_image='$thumb' where id='$p_item_id'");
												}
											}
										}
									}
								}
								else{
								    $item_error = true;
									 create_log("Error while saving product item: ".$sql_query, "products table saved by {$_SESSION['name']}");
									echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Error while inserting product item!',
                                        footer: `<a target='_blank' href='./log.txt'>See logs</a>`
                                      })</script>";
								}
							}
							
						}
					}
					$specification = $_POST['specification'];
					$date = date('Y-m-d');
					$n=0;
					$pid = $_POST['product_id'];
					foreach($specification as $s)
					{
						if($_POST['type'][$n] == 'insert')
						{
							if($s!='')
							{
								$insert3 = "insert into product_specifications(pid,specification,date) values('$pid','$s','$date')";
								$conn->query($insert3);
								//echo "<br>";
								
							}
						}
						if($_POST['type'][$n] == 'update')
						{
							$update3 = "update product_specifications set specification='$s' where id='{$_POST['sp_id'][$n]}'";
							$conn->query($update3);
							//echo "<br>";
						}
						$n++;
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
					
				 create_log("Error while updating product: "."update products set asi_no='$asi_no', tax_id='$tax_id', meta_desp='$meta_desp', meta_keyword='$meta_keyword', product_tag='$ptag', dept_id='$dept', cat_id='$cat', sub_cat_id='$subcat', brand_id='$brand', name='$name', caption_name='$caption', keyword=' $keyword', status='$status', modify_date='$date1', short_desp='$short_desp', long_desp='$long_desp', shipping_charge='$ship_charge', vat='$vat', cst='$cst' where id='{$_POST['product_id']}'", "products table updated by {$_SESSION['name']}");
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
									<span>Product Details</span>
								</li>
							</ul>
						</div>
						
						<h1 class="page-title"><?php echo $rows[0]['name']; ?></h1>
						
						<div class="row">
							<div class="col-md-12 ">
								
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="icon-settings font-dark"></i>
											<span class="caption-subject font-dark sbold uppercase">Edit Product</span>
										</div>
										
									</div>
									<div class="portlet-body form">
										<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
											<input type="hidden" name="product_id" value="<?php echo $rows[0]['id']; ?>">
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
															
															<option <?php if($rows[0]['dept_id']==$dept['id']){ echo 'selected'; } ?> value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
															<?php
																
															}
														?>
														
													</select>
												</div>
											</div> -->
											
											<div class="form-group">
												<label class="col-md-3 control-label">Select Category <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<select class="form-control" id="cat" name="cat"  onchange="get_subcat(this.value)" required>
														
														<option value="">Select</option>
														<?php 
															$get_cat=$conn->query("select * from cats order by id desc");
															while($cat=mysqli_fetch_assoc($get_cat))
															{
															?>
															
															<option <?php if($rows[0]['cat_id']==$cat['id']){ echo 'selected'; } ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
															<?php
																
															}
														?>
														
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Select Sub Category</label>
												<div class="col-md-9">
													<select class="form-control" id="subcat" name="subcat">
														
														<option value="">Select</option>
														<?php 
															$get_cat=$conn->query("select * from subcats where cat_id='{$rows[0]['cat_id']}'");
															while($sub_cat=mysqli_fetch_assoc($get_cat))
															{
															?>
															
															<option <?php if($rows[0]['sub_cat_id']==$sub_cat['id']){ echo 'selected'; } ?> value="<?php echo $sub_cat['id']; ?>"><?php echo $sub_cat['name']; ?></option>
															<?php
																
															}
														?>
														
													</select>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Select brand <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<select class="form-control" name="brand" required>
														
														<option value="">Select</option>
														<?php 
															$get_cat=$conn->query("select * from brands order by id desc");
															while($brand=mysqli_fetch_assoc($get_cat))
															{
															?>
															
															<option <?php if($rows[0]['brand_id']==$brand['id']){ echo 'selected'; } ?> value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
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
														<option <?php if($rows[0]['product_tag']=='New'){ echo 'selected'; } ?> value="New">New</option>
														<option <?php if($rows[0]['product_tag']=='Old'){ echo 'selected'; } ?> value="Old">Old</option>
														<option <?php if($rows[0]['product_tag']=='Sale'){ echo 'selected'; } ?> value="Sale">Sale</option>
													</select>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Product Name <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<input value="<?php echo $rows[0]['name']; ?>" type="text" class="form-control" placeholder="Enter Product Name" id="name" name="name" required/>
													<span class="help-block"> </span>
												</div>
											</div>
												<div class="form-group">
												<label class="col-md-3 control-label">Serial No. <span class="text-danger">*</span></label>
												<div class="col-md-9">
													<input value="<?php echo $rows[0]['asi_no']; ?>" type="text" class="form-control" placeholder="Enter Serial No." id="name" name="asi_no" required/>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Short Description</label>
												<div class="col-md-9">
													<textarea id="short_desp" name="short_desp"><?php echo base64_decode($rows[0]['short_desp']); ?></textarea>
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
													<textarea id="long_desp" name="long_desp"><?php echo base64_decode($rows[0]['long_desp']); ?></textarea>
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
													<textarea rows="3" class="form-control" placeholder="Enter Meta Description" id="meta_desp" name="meta_desp"><?php echo $rows[0]['meta_desp']; ?></textarea>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Meta Keywords</label>
												<div class="col-md-9">
													
													<textarea rows="3" class="form-control" placeholder="Enter Meta Keywords" id="meta_keyword" name="meta_keyword"><?php echo $rows[0]['meta_keyword']; ?></textarea>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Caption Name</label>
												<div class="col-md-9">
													<input value="<?php echo $rows[0]['caption_name']; ?>" type="text" class="form-control" placeholder="Enter Caption Name" id="caption" name="caption" />
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Keywords</label>
												<div class="col-md-9">
													<input value="<?php echo $rows[0]['keyword']; ?>" type="text" class="form-control" placeholder="Enter Keywords" id="keyword" name="keyword"/>
													<span class="help-block"> </span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">SEO Indexing</label>
												<div class="col-md-9">
													<div class="mt-radio-inline">
														<label class="mt-radio">
															<input <?php if($rows[0]['is_indexable']==1){ echo 'checked'; } ?> type="radio" name="is_indexable"  value="1"> On
															<span></span>
														</label>
														<label class="mt-radio">
															<input <?php if($rows[0]['is_indexable']==0){ echo 'checked'; } ?> type="radio" name="is_indexable" value="0" > Off
															<span></span>
														</label>
														
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Shipping Charge</label>
												<div class="col-md-9">
													<input value="<?php echo $rows[0]['shipping_charge']; ?>" type="number" min=0 class="form-control" placeholder="Enter the Shipping Amount" id="ship_charge" name="ship_charge" />
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
															<option <?php if($tax['id'] == $rows[0]['tax_id']){ echo 'selected'; } ?> value="<?php echo $tax['id']; ?>"><?php echo $tax['name']; ?></option>
														<?php } ?>
													</select>
													<span class="help-block"> </span>
												</div>
											</div>
											
											<?php 
									$spec = get_row($conn,"select * from product_specifications where pid='{$rows[0]['id']}'");		
								?>
								<div id="more" data-val='<?php echo count($spec); ?>'>
									<div class="form-group" data-id='0'>
										<label class="col-sm-3 control-label">Specification</label>
										<div class="col-sm-7">
											<textarea name="specification[]" class="form-control" placeholder="Enter specification by @: separated, Example: Data Title @: Data Description"></textarea>
										</div>
										<div class="col-sm-2">
											<i onclick="getmultiple($('#more').attr('data-val'))" class="fa fa-plus-square" style="margin-top:10px;font-size:20px"></i>
										</div>
										<input type="hidden" name="type[]" value="insert">
										<input type="hidden" name="sp_id[]" value="">
									</div>
									<?php 
										$n=1;
										foreach($spec as $sp)
										{
										?>
										<div class="form-group" data-id='<?php echo $n; ?>'>
											<label  class="col-sm-3 control-label">Specification</label>
											<div class="col-sm-7">
												<textarea name="specification[]" class="form-control"><?php echo $sp['specification'] ?></textarea>
											</div>
											<div class="col-sm-2">
												
											</div>
											<input type="hidden" name="type[]" value="update">
											<input type="hidden" name="sp_id[]" value="<?php echo $sp['id'] ?>">
										</div>
										<?php 
											$n++; 
										}
									?>
								</div>
                                <div class="form-group">
												<label class="col-md-3 control-label">Advance Token Amount Rate</label>
												<div class="col-md-9">
													<input type="number" value="<?php echo $rows[0]['token_amt_rate']; ?>" class="form-control" placeholder="Enter Advance Token Amount Rate (%)" id="token_amt_rate" name="token_amt_rate"/>
													<span class="help-block"> </span>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-3 control-label">Status</label>
												<div class="col-md-9">
													<div class="mt-radio-inline">
														<label class="mt-radio">
															<input <?php if($rows[0]['status']==1){ echo 'checked'; } ?> type="radio" name="status"  value="1"> Active
															<span></span>
														</label>
														<label class="mt-radio">
															<input <?php if($rows[0]['status']==0){ echo 'checked'; } ?> type="radio" name="status" value="0" > In-Active
															<span></span>
														</label>
														
													</div>
												</div>
											</div>
											<?php
												$rows1=get_row($conn, "select * from products_items where pid='{$rows[0]['id']}'");
												$x=0;
												foreach($rows1 as $row91){
												?>
												<hr>
												<div id="box<?php echo $x; ?>">
													
													<input type="hidden" name="box_type[]" value="update">
													<input type="hidden" name="item_id[]" value="<?php echo $row91['id']; ?>">
													<div style="width: 100%;text-align: left;padding: 10px;border: solid 1px #F44336;background: #ff6156;color: #fff;font-weight: bold;" >Variety <?php echo $x+1; ?>
													</div>
													<div style="border-radius: 4px;border-top-left-radius:0;border-top-right-radius:0;padding: 15px;border: solid 1px #ccc;background: #f9f9f9;">
													     <div class="form-group">
															<label class="col-md-3 control-label">Item Name <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input  value="<?php echo $row91['item_name'] ?>"  type="text" class="form-control" placeholder="Enter Item Name" id="item_name" name="item_name[]" required/>
																<span class="help-block"> </span>
															</div>
														</div>
															<div class="form-group">
												<label class="col-md-3 control-label">Description</label>
												<div class="col-md-9">
													<textarea id="item_desp<?php echo $x; ?>" name="item_desp[]"><?php echo base64_decode($row91['item_desp']); ?></textarea>
													<script>
														$(document).ready(function() {
															$('#item_desp<?php echo $x; ?>').summernote({
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
																				$rows5 = get_row($conn, "select * from sizes");
																				foreach($rows5 as $row){ ?>
																				<option <?php if($row91['size']==$row['id']){ echo 'selected'; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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
																				<option <?php if($row91['color']==$row1['id']){ echo 'selected'; } ?> value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
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
																<input value="<?php echo $row91['mrp'] ?>" onblur="setsaleprice(this.value,<?php echo $x; ?>)" type="number" min=1 class="form-control" placeholder="Enter Maximum Retail Price" id="mrp<?php echo $x; ?>" name="mrp[]" required/>
																<span class="help-block"> </span>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-3 control-label">Sale Price <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input value="<?php echo $row91['combo_price'] ?>" onkeyup="setcomboprice(this.value,$('#mrp<?php echo $x; ?>').val(),<?php echo $x; ?>)" type="number" min=1 class="form-control" placeholder="Enter Sale Price" id="price<?php echo $x; ?>" name="price[]" required/>
																<span class="help-block help_price<?php echo $x; ?>"> </span>
															</div>
														</div>
														<!-- <div class="form-group">
															<label class="col-md-3 control-label">Sale Price</label>
															<div class="col-md-9">
																<input value="<?php //echo $row91['price'] ?>" onkeyup="setcombowarning(this.value,$('#price<?php //echo $x; ?>').val(),<?php //echo $x; ?>)" type="number" min=1 class="form-control" placeholder="Sale Price" id="combo_price<?php //echo $x; ?>" name="combo_price[]" required/>
																<span class="help-block help_comboprice<?php //echo $x; ?>"> </span>
															</div>
														</div> -->
														
														<div class="form-group">
															<label class="col-md-3 control-label">Product Quantity <span class="text-danger">*</span></label>
															<div class="col-md-9">
																<input value="<?php echo $row91['qty'] ?>" type="number" min=0 class="form-control" placeholder="Enter Product Quantity"  name="quantity[]" required/>
																<span class="help-block"> </span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">SKU</label>
															<div class="col-md-9">
																<input value="<?php echo $row91['sku'] ?>" type="text" class="form-control" placeholder="SKU" name="sku[]" />
																<span class="help-block"> </span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Product Weight <span class="text-danger">*</span></label>
															<div class="col-md-6">
																<input value="<?php echo $row91['weight'] ?>" type="text" class="form-control" placeholder="Enter Product Weight" id="weight" name="weight[]" required/>
																<span class="help-block"> </span>
															</div>
															<div class="col-md-3">
																<select class="form-control" id="unit_type" name="unit_type[]" required/>
																	<option value="">Select <span class="text-danger">*</span></option>
																	<option <?php if($row91['unit_type']=='Kg'){ echo 'selected'; } ?> value="Kg">Kg</option>
																	<option <?php if($row91['unit_type']=='Gram'){ echo 'selected'; } ?> value="Gram">Gram</option>
																	<option <?php if($row91['unit_type']=='Liter'){ echo 'selected'; } ?> value="Liter">Liter</option>
																</select>
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-md-3 control-label">Show Dimension</label>
															<div class="col-md-9">
																<div class="mt-radio-inline">
																	<label class="mt-radio">
																		<input <?php if($row91['dimension']!=''){ echo 'checked'; } ?> onclick="showdimension(1,<?php echo $x; ?>)" type="radio" name="dimensionstatus<?php echo $x; ?>[]"  value="1"> Show
																		<span></span>
																	</label>
																	<label class="mt-radio">
																		<input <?php if($row91['dimension']==''){ echo 'checked'; } ?> onclick="showdimension(0,<?php echo $x; ?>)" type="radio" name="dimensionstatus<?php echo $x; ?>[]" value="0"> Hide<span></span>
																	</label>
																</div>
																<span class="help-block"> </span>
															</div>
														</div> 
														
														<div class="form-group" id="dimension<?php echo $x; ?>" style="<?php if($row91['dimension']==''){ echo 'display:none;'; } ?>">
															<label class="col-md-3 control-label">Dimension</label>
															<div class="col-md-9">
																<input value="<?php echo $row91['dimension'] ?>" type="text" class="form-control" placeholder="Enter Product Dimension" id="dimension" name="dimension[]"/>
																
																<span class="help-block"> </span>
															</div>
														</div>
														
														
														<div class="row">
														     <div class="col-md-12" style="margin-bottom:16px">	<small class="text-info">Image dimension: 1100x1100</small></div>
															<?php
																$rows92=get_row($conn, "select * from products_images where pid='{$rows[0]['id']}' and p_item_id='{$row91['id']}'");
																foreach($rows92 as $row92){
																?>
																<input type="hidden" name="image_type<?php echo $x; ?>[]" value="update">
																<div class="col-md-4 pimg-box">
																	<div class="form-group">
																		<div class="col-sm-12 controls">
																			<div class="">
																				<div class="fileupload fileupload-new" data-provides="fileupload">
																					<div class="fileupload-new thumbnail" style="height:200px;width:100%;">
																						<img style="height: 148px;padding-top: 42px;" src="data/product_images/<?php        echo $row92['thumb']; ?>" alt="admin-profile-image">
																					</div>
																					<div id="pro_image" class="fileupload-preview fileupload-exists thumbnail" style        ="width:100%;"></div>
																					    </br>
																					<div>
																						<span style="width:49%" class="btn btn-file btn-primary">
																							<span class="fileupload-new">Select image</span>
																							<span class="fileupload-exists">Change</span>
																						    <input onchange="imageRemoveHandler(event, '<?php echo $row92['id']; ?>')" name="img1<?php echo $x; ?>[]" accept="image/jpeg" type="file">
																							<input type="hidden" name="img_id<?php echo $x; ?>[]" value="<?php echo $row92['id']; ?>">
																						</span>
																					
																					<a href="#" data-id="<?php echo $row92['id']; ?>" onclick="removeImage($(this).attr('data-id'), event)" style="width:49%" class="btn btn-danger db-file-remove-btn" data-dismiss="fileupload">Remove</a>
																						
																					</div>
																						
																					
																				</div>
																					
																			</div>
																		</div>
																	</div>
																</div>
															<?php } ?>
															<div id="append<?php echo $x; ?>"></div>
														</div>
														<div class="form-actions">
															<?php
																
																if($x!=0){
																?>
																<a onclick="del_data(<?php echo $row91['id']; ?>)" style="margin-left: 16px;" class="btn blue btn-sm pull-right">Delete</a>
															<?php } ?>
															<button type="button" class="btn btn-danger btn-sm pull-right" onclick="append(<?php echo $x; ?>)">+ Add more</button>
														</div>
													</div>
												</div>
											<?php $x++; } ?>
											<div id="more_box"></div>
											<input type="hidden" id="box_count" name="box_count" value="<?php echo $x-1; ?>">
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
		<div id="script_div">
			<script>
				
			</script>
		</div>
		<script>
			var id = parseInt(<?php echo $x; ?>);
			
			function append(id)
			{
				$("#append"+id).append('<input type="hidden" name="image_type'+id+'[]" value="insert"><div class="col-md-4"><div class="form-group"><div class="col-sm-12 controls"><div class=""><div class="fileupload fileupload-new" data-provides="fileupload"><div class="fileupload-new thumbnail" style="height:200px;width:100%;"><img style="height: 148px;padding-top: 42px;" src="img/default_image.png" alt="admin-profile-image"></div><div id="pro_image" class="fileupload-preview fileupload-exists thumbnail" style="width:100%;"></div></br><div><span style="width:49%" class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input name="img1'+id+'[]" accept="image/jpeg" type="file"></span><a href="#" style="width:49%" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a></div></div></div></div></div></div>');
			}
			//parseInt(<?php echo $x; ?>);
			//localStorage.setItem('boxid','<?php echo $x; ?>');
			//var id = parseInt(localStorage.getItem('boxid'));
			
			
			function more_box(){
				$("#loading").show();
				$.ajax({
					type:'post',
					data:{
						id:id
					},
					url:'ajax/get_box_edit.php',
					success:function(result){
						$("#undo_btn").show();
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
				//var id = $("#box_count").val();
				var x = '<input type="hidden" name="mrp[]" value=""><input type="hidden" name="price[]" value=""><input type="hidden" name="combo_price[]" value=""><input type="hidden" name="quantity[]" value=""><input type="hidden" name="weight[]" value=""><input type="hidden" name="unit_type[]" value=""><input type="hidden" name="dimension[]" value=""><input type="hidden" name="color[]" value=""><input type="hidden" name="size[]" value="">';
				
				$("#box_type"+id).val('delete');
				$("#box_head"+id).empty();
				$("#box_delete"+id).hide();
				$("#box_ribbon"+id).css("background","#eee");
				$("#box_ribbon"+id).css("border","none");
				$("#box_ribbon"+id).css("color","#000");
				$("#box_ribbon_text"+id).text("Deleted");
				$("#box_head"+id).html(x);
				
			}
		</script>
		<!-- End Google Tag Manager -->
	</body>
