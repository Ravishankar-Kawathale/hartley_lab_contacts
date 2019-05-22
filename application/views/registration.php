<!DOCTYPE html>
<html>
  <head>
    <title>HL's Registration</title>      
    
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/bootstrap/css/bootstrap.css" />
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/bootstrap/css/AdminLTE.css">
	
	<!-- get base url to use in ajax call -->
	<script type="text/javascript">
		var site_url = '<?php echo base_url()."index.php";?>';
	</script>
	
	<style>
		.has-error{
			border-color: #dd4b39;
		}
	</style>
  </head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="#"> HL's Contact List Management</a>
			</div><!-- /.login-logo -->
			<div class="box box-primary">
				<div class="login-box-body">
					<div class="alert alert-success alert-dismissable" style="display:none">										
						Registration Successfull. Please login.
					</div>
					<div class="alert alert-danger alert-dismissable" style="display:none">						
						Somwthing went wrong please try again.
					</div>
					<div class="alert alert-warning alert-dismissable" style="display:none">										
						Email Id already exist.
					</div>
					<p class="login-box-msg">Registration</p>
					<form name="regForm" id="regForm">			
					  <div class="form-group has-feedback">
						<input type="text" name="full_name" id="full_name" class="form-control" placeholder="User Full Name" />			
						
						<p class="text-red" id="user_name_error_msg"></p>
					  </div>
					  <div class="form-group has-feedback">
						<input type="text" name="email_id" id="email_id" class="form-control" placeholder="User Email Id as user id" />			
						
						<p class="text-red" id="email_id_error_msg"></p>
					  </div>
					  <div class="form-group has-feedback">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password">
						
						<p class="text-red" id="password_error_msg"></p>
					  </div>
						<div class="row">           
							<div class="col-xs-4">
								<button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>								
								<br/>
								<a href="<?php echo site_url('User/login');?>">Login here</a>
							</div>
						</div>
					</form>
				</div><!-- /.login-box -->
				<div class="overlay" style="display:none">
				  <i class="fa fa-spinner fa-spin"></i>
				</div>
			</div>
		</div>
	

		<!-- jQuery 2.1.4 -->
		<script src="<?php echo ASSETS; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="<?php echo ASSETS; ?>/bootstrap/js/bootstrap.min.js"></script>
		
		<script>
			$('#regForm').submit(function (event){
				event.preventDefault();
				
				var user_name = $('#full_name').val().trim();
				var email_id = $('#email_id').val().trim();
				var password = $('#password').val().trim();
				var emailFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

				$('.text-red').html('');	
				$('.alert').css('display','none');
				if(user_name == '')
				{
					$('#user_name').addClass('has-error'); 
					$('#user_name').focus();
					$('#user_name_error_msg').html('Please enter User name.');
				}else if(email_id == '' || !emailFormat.test(email_id)){					
					$('#email_id').addClass('has-error'); 		
					$('#email_id').focus();
					$('#email_id_error_msg').html('Please enter valid email id.');
				}else if(password == ''){					;					
					$('#password').addClass('has-error'); 		
					$('#password').focus();
					$('#password_error_msg').html('Please enter Pasword.');
				}else{
					$('.overlay').css('display','block');
					$.ajax
					({
						type: "POST",
						url: site_url+'/User/save_user_details',
						data: $("#regForm").serialize(),
						cache: false,
						dataType: "json",
						success: function(resp)
						{
							$('.overlay').css('display','none');
							if(resp.result == 'Success'){
								$('.alert-success').css('display','block');
								$("#regForm")[0].reset();
								setTimeout(function () {
									$('.alert-success').css('display','none');								
								},3000);
							}else if(resp.result == 'Already Exists'){
								$('.alert-warning').css('display','block');									
								setTimeout(function () {
									$('.alert-warning').css('display','none');								
								},3000);
								
							}else{
								$('.alert-error').css('display','block');
								setTimeout(function () {
									$('.alert-error').css('display','none');								
								},3000);
							}
						}
					});
				}
			});
		</script>
		
	</body>
</html>
