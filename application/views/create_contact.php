	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="background:#fff;padding:15px;">
			<h1>
				Create / Add Contact
			</h1>
        </section>
        <!-- Main content -->
        <section class="content">
			<!-- Main row -->			
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-12">
					<div class="alert alert-danger alert-dismissable alert-error" style="display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fa fa-warning"></i>
						Contact not created, Please try again.
					</div>
					
					<div class="alert alert-success alert-dismissable" style="display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fa fa-check"></i>
						Contact created successfully.
					</div>
					<div class="alert alert-warning alert-dismissable" style="display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fa fa-warning"></i>
						Contact already exist.
					</div>
					
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"> Enter Contact details</h3>
						</div>
						<div class="box-body">
							<div class="col-md-2">
								&nbsp;
							</div>
							<div class="col-md-6">
								<form id="createContactForm" method="post" class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-4 control-label">*First Name: </label>
										<div class="col-sm-8">
											<input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name"/>
											<p class="text-red" id="first_name_error_msg"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">Middle Name: </label>
										<div class="col-sm-8">
											<input type="text" name="middle_name" class="form-control" id="middle_name" placeholder="Middle Name"/>
											<p class="text-red" id="cadet_middle_name_error_msg"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">*Last Name: </label>
										<div class="col-sm-8">
											<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name"/>
											<p class="text-red" id="last_name_error_msg"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">*Primary Phone: </label>
										<div class="col-sm-8">
											<input type="text" name="primary_phone" class="form-control" id="primary_phone" placeholder="Primary Phone" maxlength="10"/>
											<p class="text-red" id="primary_phone_error_msg"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">Secondary Phone: </label>
										<div class="col-sm-8">
											<input type="text" name="secondary_phone" class="form-control" id="secondary_phone" placeholder="Secondary Phone" maxlength="10"/>
											<p class="text-red" id="secondary_phone_error_msg"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">*Email Id: </label>
										<div class="col-sm-8">
											<input type="text" name="email_id" class="form-control" id="email_id" placeholder="Email Id" />
											<p class="text-red" id="email_id_error_msg"></p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label">&nbsp;</label>
										<div class="col-sm-8">
											<br/>
											<button type="submit" class="btn btn-success" title="Click To Create Contact"> Create </button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="overlay" style="display:none">
							<i class="fa fa-spinner fa-spin"></i>
						</div>
					</div>
				</section>
			</div>
        </section>
    </div><!-- /.content-wrapper -->
	
	<footer class="main-footer">		
	</footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ASSETS; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>   
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo ASSETS; ?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo ASSETS; ?>/bootstrap/js/app.min.js"></script>
	
	<script>
		$('#createContactForm').submit(function (event){
			event.preventDefault();
			
			$("#createContactForm input").removeClass("has-error");			
			$(".text-red").html("");
			$('.alert').css('display','none');
			
			var first_name = $('#first_name').val().trim();			
			var last_name = $('#last_name').val().trim();
			var primary_phone = $('#primary_phone').val().trim();
			var email_id = $('#email_id').val().trim();
			var emailFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			
			if(first_name == '')
			{
				$('#first_name').focus();
				$('#first_name').addClass('has-error');
				$('#first_name_error_msg').html('Please enter first name.');
			}else if(last_name == ''){
				$('#last_name').focus();
				$('#last_name').addClass('has-error');
				$('#last_name_error_msg').html('Please enter last name.');
			}else if(primary_phone == ''){				
				$('#primary_phone').addClass('has-error'); 		
				$('#primary_phone').focus();
				$('#primary_phone_error_msg').html('Please enter primary phone.');
			}else if(email_id == ''  || !emailFormat.test(email_id)){
				$('#email_id').addClass('has-error'); 		
				$('#email_id').focus();
				$('#email_id_error_msg').html('Please enter valid email id.');
			}else{
				console.log("All okay");
				$('.overlay').css('display','block');				
				
				$.ajax
				({
					type: "POST",
					url: site_url+'/Contact/save_contact_details',
					data: $("#createContactForm").serialize(),
					cache: false,
					dataType: "json",
					success: function(resp)
					{
						console.log(resp);
						$('.overlay').css('display','none');
						if(resp.result == 'S'){
							$('#first_name').focus();							
							$('.alert-success').css('display','block');
							setTimeout(function () {
								location.reload();
							},2000);
						}else if(resp.result == 'Already Exist'){
							$('#first_name').focus();							
							$('.alert-warning').css('display','block');
						}else{
							$('#first_name').focus();
							$('.overlay').css('display','none');
							$('.alert-danger').css('display','block');							
						}
					}
				});
			}
		});
	</script>
	<script>
		$("input[name$='primary_phone'],input[name$='primary_phone']").on("keypress keyup",function (event) {
			
			if ((event.which != 46) && (event.which != 8) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		$('#first_name,#middle_name,#last_name').bind('keypress keyup blur',function(){
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); 
		});
	</script>	
  </body>
</html>
