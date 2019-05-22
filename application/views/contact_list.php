		<div class="content-wrapper">
              <section class="content-header" style="background:#fff;padding:15px;">
			<h1>
				User Contact List
			</h1>
        </section>
                <section class="content">
				
			<div class="row">
					<section class="col-md-12">	
					<div class="alert alert-danger alert-dismissable alert-delete-error" style="display:none;">						
						<i class="icon fa fa-warning"></i>
						Cantact not deleted, Please try again.
					</div>

					<div class="alert alert-success alert-dismissable alert-delete-success" style="display:none;">						
						<i class="icon fa fa-warning"></i>
						Deleted Successfully.

					</div>	


					<div class="alert alert-danger alert-dismissable alert-share-error" style="display:none;">						

						<i class="icon fa fa-warning"></i>

						Cantact not shared, Please try again.

					</div>

					<div class="alert alert-success alert-dismissable alert-share-success" style="display:none;">						
						<i class="icon fa fa-warning"></i>
						Shared Successfully.
					</div>	
					
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"> Contacts </h3><br>
							What You can do- 1. See all contacts created by you; 2. You can search contact by any field; 3. Delete contact; 4. Share contact with other multiple users of this system at same time (sinngle contact to multiple users at same time); 5. Export contact.
						</div>
						<div class="box-body">
							
							<div class="col-md-12" id="view-id">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Sr.No</th>
											<th style="text-align:center">First Name</th>
											<th style="text-align:center">Middle Name</th>
											<th style="text-align:center">Last Name</th>
											<th style="text-align:center">Primary</th>
											<th style="text-align:center">Secondary</th>
											<th style="text-align:center">Email Id</th>											
											<th style="text-align:center">Created on</th>
											<th class="text-center">Options</th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										for($i=0;$i<count($contact_list);$i++)
										{ ?>
											<tr>
												<td><?php echo $i+1; ?></td>
												<td style="text-align:center"><?php echo $contact_list[$i]['first_name']; ?></td>
												<td style="text-align:center"><?php echo $contact_list[$i]['middle_name']; ?></td>
												<td style="text-align:center"><?php echo $contact_list[$i]['last_name']; ?></td>
												<td style="text-align:center"><?php echo $contact_list[$i]['primary_phone']; ?></td>
												<td style="text-align:center"><?php echo $contact_list[$i]['secondary_phone']; ?></td>
												<td style="text-align:center"><?php echo $contact_list[$i]['email_id']; ?></td>
												<td style="text-align:center"><?php echo date('d-M-y h:i A', strtotime($contact_list[$i]['created_date_time'])); ?></td>
												<td style="text-align:center">
													<a href="javascript:;" class="btn btn-danger btn-small" onclick="delete_contact('<?php echo $contact_list[$i]['contact_id']; ?>');"> Delete</a>
													<br/>
													<a href="javascript:;" class="btn btn-success btn-small" onclick="share_with_other_user('<?php echo $contact_list[$i]['contact_id']; ?>');"> Share</a>
													<br/>
													<a href="<?php echo site_url("Contact/export_vcf/".$contact_list[$i]['contact_id'])?>" class="btn btn-primary btn-small">Export VCF</a>
													
												</td>
											</tr>
										<?php } ?>								
									</tbody>
								</table>
							</div>
						</div>
						<div class="overlay" style="display:none">
							<i class="fa fa-spinner fa-spin"></i>
						</div>
					</div>
				</section>
			</div>
        </section>
    </div><
	
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
	
	<!-- DataTables -->
    <script src="<?php echo ASSETS; ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo ASSETS; ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
	
	
	<script>
		$(function () {
			$("#example1").DataTable();
		});
		
		function delete_contact(contact_id)
		{
			var conf = confirm("Are you sure you want to delete this contact?");	
			if(conf==true)
			{
				
				$('.overlay').css('display','block');
					$.ajax({
						type: "POST",
						url: site_url+'/Contact/change_d_status',
						data: 'contact_id='+contact_id,
						dataType: "json",
						success: function (resp)
						{
							console.log(resp);
							if(resp.result=="S"){	
								$('.overlay').css('display','none');
								$('.alert-delete-success').css('display','block');
								setTimeout(function () {
									$('.alert-delete-success').css('display','none');
									location.reload();
								},3000);
							}						
						}
					});
			}
			
		}		
	</script>
	<script>
	
		
		function share_with_other_user(contact_id)
		{
			$('.overlay').css('display','block');
			$.ajax({
				type: "POST",
				url: site_url+'/Contact/for_share',
				data: 'contact_id='+contact_id,						
				success: function (resp){
					$('.overlay').css('display','none');
					console.log(resp);
					$('#view-id').html(resp);
					$(".select2").select2();
				}
			});
		}	
	</script>
  </body>
</html>
