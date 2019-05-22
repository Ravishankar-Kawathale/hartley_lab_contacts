<!DOCTYPE html>
<html>
  <head>
    <title>Ravishankar's Hartley Lab Test Login</title>      
    
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
			<div class="box box-primary">
				<div class="login-box-body">
					<div class="alert alert-danger alert-dismissable" style="display:none">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Error!</h4>
						Incorrect Email Id and Password combination.
					</div>
					<p class="login-box-msg">Welcome To HL's Contact List Management <br/>Login/ Sign In</p>
					<form name="signinForm" id="signinForm">			
					  <div class="form-group has-feedback">
						<input type="email" name="user_id" id="user_id" class="form-control" placeholder="User Id(Reg. Email)" />			
						
						<p class="text-red" id="user_id_error_msg"></p>
					  </div>
					  <div class="form-group has-feedback">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<p class="text-red" id="password_error_msg"></p>
					  </div>
						<div class="row">           
							<div class="col-xs-12">
								<button id="admin_signin" type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
								<br/>
								Don't have an Account? You can <a href="<?php echo site_url('User/registration');?>"> Register here </a>
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
			$('#signinForm').submit(function (event){
				event.preventDefault();
				console.log(site_url);
				
				var user_id = $('#user_id').val().trim();
				var password = $('#password').val().trim();
				$('.text-red').html('');
				if(user_id == '')
				{
					$('#user_id').addClass('has-error'); 
					$('#user_id').focus();
					$('#user_id_error_msg').html('Please enter User Id to sign in.');
				}else if(password == ''){					
					$('#password').addClass('has-error'); 		
					$('#password').focus();
					$('#password_error_msg').html('Please enter Pasword to sign in.');
				}else{					
					$('.overlay').css('display','block');
					
					$.ajax
					({
						type: "POST",
						url: site_url+'/User/login_auth',
						data: $("#signinForm").serialize(),
						cache: false,
						dataType: "json",
						success: function(resp)
						{
							if(resp.result == 'Yes'){
								console.log("Yes");
								window.location.replace(site_url+"/Contact");
							}else{
								$('.overlay').css('display','none');
								$('.alert').css('display','block');
								console.log("No");
							}
						}
					});
				}
			});
		</script>
		
	</body>
</html>
