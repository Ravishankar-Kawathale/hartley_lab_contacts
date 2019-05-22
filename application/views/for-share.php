	<div class="col-md-2">
		&nbsp;&nbsp;
	</div>
	<div class="col-md-8">
		<form id="shareForm" name="shareForm" method="post" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">*Select Users to share: </label>
				<div class="col-sm-6">
					<input type="hidden" name="contact_id" value="<?php echo $contact_id;?>">
					<select class="form-control select2" data-placeholder="Select User" multiple="multiple" name="user[]" id="user_name">												
						<?php 
							foreach($user_list as $user){
								echo "<option value='".$user['user_id']."'>".$user['full_name']." </option>";
							}												
						?>
					</select>
					<p class="text-red" id="user_name_error_msg"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">&nbsp;</label>
				<div class="col-sm-8">
					<br/>
					<button type="submit" class="btn btn-success"  title="Share Contact"> Share </button>
				</div>
			</div>
		</form>
	</div>	
	
	<script>
		$('#shareForm').submit(function (event){
			event.preventDefault();
			$("#shareForm select").removeClass("has-error");
			$(".text-red").html("");
			$('.alert-danger').css('display','none');
			
			var user_name = $('#user_name').val();
			
			if(user_name == null)
			{
				$('#user_name').focus();
				$('#user_name').addClass('has-error');
				$('#user_name_error_msg').html('Please select at least one user to share contact.');
			}else{				
				$('.overlay').css('display','block');				
				
				$.ajax
				({
					type: "POST",
					url: site_url+'/Contact/share_contact',
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false,					
					dataType: "json",
					success: function(resp)
					{
						console.log(resp);
						
						if(resp.result == 'S'){
							$('.overlay').css('display','none');
							$('.alert-share-success').css('display','block');
							setTimeout(function () {
								location.reload();
							},4000);
						}else{
							$('.overlay').css('display','none');
							$('.alert-share-error').css('display','block');
						}
					}
				});
			}
		});
	</script>