<base href="<?php echo $base_url_admin; ?>">
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<meta property="og:type" content="website">
<meta property="og:url" content="https://admin-easybuy.xtreebit.ml">
<meta property="og:title" content="Admin Panel | EasyBuy">
<meta property="og:description" content="Best ecommerce platform">
<meta property="og:image" content="https://admin-easybuy.xtreebit.ml/admin/img/favicon.png">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href=" assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href=" assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href=" assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href=" assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href=" assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href=" assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

<link href="js/bootstrap-fileupload.min.css" rel="stylesheet">	
<!-- END THEME LAYOUT STYLES -->

<link rel="shortcut icon" href="./img/favicon.png" /> 

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />

<link href=" assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
<link href=" assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
<link href="js/summernote.min.css" rel="stylesheet">

<link rel="shortcut icon" href="favicon.ico" /> 
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php
	include('./functions/function.php');
?>
<style>
.portlet.box .dataTables_wrapper .dt-buttons a{
margin-left: 4px;
}
.filter_close{
	
	padding: 7px !important;
    width: 40px;
    float: left;
    margin-left: 2px;
}
#sample_2_filter{
			float:right;
			}
</style>
<script>
function send_sms(number, message){
		
		var url = 'http://sms.mysmszone.in/api/pushsms.php?username=trendy&password=46866&sender=TRENDY&message='+message+'&numbers='+number+'&unicode=false&flash=false';
		return $.ajax({
			type:'get',
			url:url
		});
	}
</script>
<?php
	if(basename($_SERVER['PHP_SELF'])!="login.php"){
	if(!isset($_SESSION['id']) || $_SESSION['role']!='admin'){
		// echo '<pre>';
		// print_r($_SERVER);die;
		echo "<script>window.location='./login';</script>";
	} } ?>