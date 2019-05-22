		<div class="content-wrapper">
              <section class="content-header" style="background:#fff;padding:15px;">
			<h1>
				Contact List
			</h1>
        </section>
                <section class="content">
				
			<div class="row">					
					
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"> Contacts Shared With You by other users</h3>
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
											<th style="text-align:center">Shared By</th>											
											<th style="text-align:center">Shared On</th>											
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
												<td style="text-align:center"><?php echo $contact_list[$i]['shared_by_name']; ?></td>
												<td style="text-align:center"><?php echo date('d-M-y h:i A', strtotime($contact_list[$i]['shared_on'])); ?></td>												
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
						url: site_url+'/Contact/delete_contact',
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
		
		
		function share(contact_id)
		{
			$('.overlay').css('display','block');
			$.ajax({
				type: "POST",
				url: site_url+'/Contact/get_share_view',
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
