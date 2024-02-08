<?php session_start();
	include('includes/config.php');	
?>
<!DOCTYPE html>

<html lang="en">
    
	<head>
        <title>Admin Panel</title>
		<?php include('includes/head.php'); ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="https://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.2.7/morris.min.js" integrity="sha512-nF4mXN+lVFhVGCieWAK/uWG5iPru9+/z1iz0MJbYTto85I/k7gmbTFFFNgU+xVRkF0LI2nRCK20AhxFIizNsXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	</head>
    <!-- END HEAD -->
	
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
			<?php include('includes/header.php'); ?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
				<?php include('includes/nav.php'); ?>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                       <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="index-2.html">Home</a>
                                    <i class="fa fa-circle"></i>
								</li>
                                <li>
                                    <span>Dashboard</span>
								</li>
							</ul>
                            <div class="page-toolbar">
                                <!-- <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                                    <i class="icon-calendar"></i>&nbsp;
                                    <span class="thin uppercase hidden-xs"></span>&nbsp;
                                    <i class="fa fa-angle-down"></i>
								</div> -->
							</div>
						</div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <h1 class="page-title"> Dashboard
                            <small>dashboard & statistics</small>
						</h1>
                        <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN DASHBOARD STATS 1-->
                        <div class="row">
							<?php
								$today_date = date("Y-m-d");
								$todat_order = get_row($conn, "select * from orders where date='$today_date' and status in('PLACED', 'DISPATCHED', 'DELIVERED')");
							?>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-comments"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo count($todat_order); ?>">0</span>
										</div>
                                        <div class="desc"> Today's Orders </div>
									</div>
								</a>
							</div>
							<?php
								$today_amount=0;
								foreach($todat_order as $todatorder){
									$today_amount = $today_amount+$todatorder['total_price'];
								}
							?>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
										Rs.<span data-counter="counterup" data-value="<?php echo $today_amount; ?>">0</span> </div>
                                        <div class="desc"> Today's Sale </div>
									</div>
								</a>
							</div>
							<?php 
								$total_users = get_row($conn, "select * from users");
							?>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo count($total_users); ?>">0</span>
										</div>
                                        <div class="desc"> Total Users </div>
									</div>
								</a>
							</div>
							<?php 
								$total_products = get_row($conn, "select * from products");
							?>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php echo count($total_products); ?>">0</span>
										</div>
                                        <div class="desc"> Total Products </div>
									</div>
								</a>
							</div>
							<?php 
								//$total_admin_combo = get_row($conn, "select * from combo where role='admin'");
							?>
							<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php // echo count($total_admin_combo); ?>">0</span>
										</div>
                                        <div class="desc"> Total Combo (Admin)</div>
									</div>
								</a>
							</div> -->
							<?php 
								//$total_user_combo = get_row($conn, "select * from combo where role='user'");
							?>
							<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php // echo count($total_user_combo); ?>">0</span>
										</div>
                                        <div class="desc"> Total Combo (Users)</div>
									</div>
								</a>
							</div> -->
							
							<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            Rs.<span data-counter="counterup" data-value="<?php //echo get_all_wallet_amount($conn); ?>">0</span>
										</div>
                                        <div class="desc"> Total Wallet Amount</div>
									</div>
								</a>
							</div> -->
							<?php 
								//$total_wishlist = get_row($conn, "select * from wishlist where date='$today_date'");
							?>
							<!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:;">
                                    <div class="visual">
                                        <i class="fa fa-shopping-cart"></i>
									</div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="<?php //echo count($total_wishlist); ?>">0</span>
										</div>
                                        <div class="desc"> Total Wishlist Request</div>
									</div>
								</a>
							</div> -->
						</div>
                        <div class="clearfix"></div>
						
						<div class="row">
                            <div class="col-md-12">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">Orders Chart</span>
										</div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:ordergraph();">
                                                <i class="fa fa-refresh"></i>
											</a>
											
										</div>
									</div>
                                    <div class="portlet-body">
									<div id="order_wait" style="display:none;margin-top:100px;margin-bottom:100px;" ><center><img src="img/page_load.gif"></center></div>
										<div id="bar-example"></div>
										<script >
											/*
												* Play with this code and it'll update in the panel opposite.
												*
												* Why not try some of the options above?
											*/
											function ordergraph(){
											$('#order_wait').show();
											$('#bar-example').empty();
											$.ajax({
												type:'post',
												url:'ajax/order_graph.php',
												success:function(result){
												//alert(result);
													Morris.Bar({
														element: 'bar-example',
														data: result,
														xkey: 'y',
														ykeys: ['a'],
														labels: ['Total Orders'],
														barColors: ['#3598dc']
													});
													$('#order_wait').hide();
												}
											});
											}
                                            $(document).ready(() => {
                                                ordergraph();
                                            })
										
										</script>
									</div>
								</div>
							</div>
						</div>
                        
						<div class="row">
                            <div class="col-md-12">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">Sales Chart</span>
										</div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:salegraph();">
                                                <i class="fa fa-refresh"></i>
											</a>
											
										</div>
									</div>
                                    <div class="portlet-body">
										<div id="sale_wait" style="display:none;margin-top:100px;margin-bottom:100px;" ><center><img src="img/page_load.gif"></center></div>
										<div id="sale-graph"></div>
										<script >
											/*
												* Play with this code and it'll update in the panel opposite.
												*
												* Why not try some of the options above?
											*/
											function salegraph(){
											$('#sale_wait').show();
											$('#sale-graph').empty();
											$.ajax({
												type:'post',
												url:'ajax/sale_graph.php',
												success:function(result){
												//alert(result);
													Morris.Bar({
														element: 'sale-graph',
														data: result,
														xkey: 'y',
														ykeys: ['a'],
														labels: ['Total Sale Rs'],
														barColors: ['#e7505a']
													});
													$('#sale_wait').hide();
												}
											});
											}
											$(document).ready(() => {
											salegraph();
											});
										</script>
									</div>
								</div>
							</div>
						</div>
                        
						<!-- <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class=" icon-layers font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">Wallet Chart</span>
										</div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:walletgraph();">
                                                <i class="fa fa-refresh"></i>
											</a>
											
										</div>
									</div>
                                    <div class="portlet-body">
										<div id="wallet_wait" style="display:none;margin-top:100px;margin-bottom:100px;" ><center><img src="img/page_load.gif"></center></div>
										<div id="graph-wallet"></div>
										<script >
											/*
												* Play with this code and it'll update in the panel opposite.
												*
												* Why not try some of the options above?
											*/
											function walletgraph(){
											$('#wallet_wait').show();
											$('#graph-wallet').empty();
											$.ajax({
												type:'post',
												url:'ajax/wallet_graph.php',
												success:function(result){
												//alert(result);
													Morris.Bar({
														element: 'graph-wallet',
														data: result,
														xkey: 'y',
														ykeys: ['a','b'],
														labels: ['Total Amount(Cr) Rs','Total Amount(Dr) Rs'],
														barColors: ['#3598dc','#e7505a']
														
													});
													$('#wallet_wait').hide();
												}
											});
											}
											walletgraph();
										</script>
									</div>
								</div>
							</div>
						</div> -->
                        
                        <!-- END DASHBOARD STATS 1-->
                   </div>
                    <!-- END CONTENT BODY -->
				</div>
                <!-- END CONTENT -->
                
			</div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php include('includes/footer.php'); ?>
            <!-- END FOOTER -->
		</div>
		
        <!-- BEGIN CORE PLUGINS -->
        <script src=" assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src=" assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src=" assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src=" assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src=" assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src=" assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src=" assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src=" assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
		<!-- Google Tag Manager -->
		
		<!-- End Google Tag Manager -->
	</body>
