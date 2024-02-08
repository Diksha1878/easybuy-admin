<?php session_start(); 
	include('includes/config.php');
?>

<!DOCTYPE html>

<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<head>
        <title>Admin Panel</title>
        <?php include('includes/head.php'); ?>
		<link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
		<script>
			
			function press(e) {
				e = e || window.event;
				if (e.keyCode == 13)
				{
					$('#login').trigger('click');
				}
			}
			
			
		</script>
	</head>
	
    <body class=" login">
		
		<?php
			if(isset($_REQUEST['login'])){ 
				unset($_SESSION['block']);
				unset($_SESSION['user_login_status']);
				
				$email = trim(mysqli_real_escape_string($conn,$_REQUEST['email']));
				$password = trim(mysqli_real_escape_string($conn,$_REQUEST['password']));
				$password=md5($password);
				
				$sql=$conn->query("select * from users where BINARY email= BINARY '$email' and BINARY password= BINARY '$password' and role='admin' LIMIT 1");
				if(mysqli_num_rows($sql)==1){
					$row=mysqli_fetch_assoc($sql);
					if($row['block']==1){
						$_SESSION['block']='<div class="alert alert-danger"><strong><i class="fa fa-ban" aria-hidden="true"></i> </strong> Account is blocked</div>';
					}
					else{
						
						$conn->query("insert into last_logins(user_id,date,time) values('{$row['id']}','$date','$time')");
						
						$_SESSION['id'] = $row['id'];
						$_SESSION['name'] = $row['fname'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['phno'] = $row['phno'];
						$_SESSION['role'] = $row['role'];
						
						if(isset($_REQUEST['remember']) && $_REQUEST['remember']==1){
							
						}
						//last login
						$sql1=$conn->query("select * from last_logins where user_id='{$row['id']}' order by id desc LIMIT 1");
						$row1=mysqli_fetch_assoc($sql1);
						
						$_SESSION['last_login'] = $row1['date']." / ".$row1['time'];
						echo "<script>window.location='./';</script>";
					}
					
				}
				else{
				?>
				<script>
					$(document).ready(function(){
						$("#login_msg_box").removeClass('display-hide');
					});
				</script>
				<?php
				}
			}
		?>
		
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="./">
			<img style="max-width: 150px;" src="img/logo.png" alt="" /> </a>
		</div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="" method="post">
                <h3 class="form-title font-green">Login</h3>
                <div id="login_msg_box" class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span id="login_msg"> Enter Valid Email and password. </span>
				</div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
				<input onkeydown="press(event)" class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input onkeydown="press(event)" class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> 
					
				</div>
                <div class="form-actions">
                    <button type="submit" name="login" id="login" class="btn green uppercase">Login</button>
					<!--  <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
					</label> -->
                    <!-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> -->
				</div>
				
			</form>
			<!-- <form class="login-form" action="" method="post">
                <div class="login-options">
                    <h4>Or login with</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
						</li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
						</li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
						</li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
						</li>
					</ul>
				</div>
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
					</p>
				</div>
			</form> -->
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="" method="post">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
				</div>
			</form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form" action="" method="post">
                <h3 class="font-green">Sign Up</h3>
                <p class="hint"> Enter your personal details below: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Full Name</label>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname" /> </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Address</label>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">City/Town</label>
				<input class="form-control placeholder-no-fix" type="text" placeholder="City/Town" name="city" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Country</label>
                    <select name="country" class="form-control">
                        <option value="">Country</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AL">Albania</option>
                        
					</select>
				</div>
                <p class="hint"> Enter your account details below: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                <div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> I agree to the
                        <a href="javascript:;">Terms of Service </a> &
                        <a href="javascript:;">Privacy Policy </a>
                        <span></span>
					</label>
                    <div id="register_tnc_error"> </div>
				</div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
				</div>
			</form>
            <!-- END REGISTRATION FORM -->
			
			<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
			<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			<script src="assets/pages/scripts/login.min.js" type="text/javascript"></script>
			<!-- END PAGE LEVEL SCRIPTS -->
			
			
			<!-- BEGIN CORE PLUGINS -->
			<?php include('includes/footer_js.php'); ?>
			<!-- END THEME LAYOUT SCRIPTS -->
			
			<!-- End Google Tag Manager -->
		</body>
		</html>
		