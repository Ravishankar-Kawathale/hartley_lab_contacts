<!DOCTYPE html>
<html>
	<head>		
		<title><?php echo $page_name; ?></title>	
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?php echo ASSETS; ?>/bootstrap/css/bootstrap.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		
		<link rel="stylesheet" href="<?php echo ASSETS; ?>/plugins/select2/select2.min.css"/>
		
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo ASSETS; ?>/bootstrap/css/AdminLTE.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?php echo ASSETS; ?>/bootstrap/css/lightbox.min.css">
		<link rel="stylesheet" href="<?php echo ASSETS; ?>/bootstrap/css/_all-skins.min.css">
		
		<!-- DataTables -->
		<link rel="stylesheet" href="<?php echo ASSETS; ?>/plugins/datatables/dataTables.bootstrap.css">
		
		<style>
			.has-error{
				border-color: #dd4b39;
			}
			p{
				margin:0px;
			}
		</style>
		<script type="text/javascript">
			var site_url = '<?php echo base_url()."index.php";?>';
		</script>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">				
				<a href="javascript:void(0)" class="logo">				
				  <span class="logo-mini"><b>HL</b></span>				 
				  <span class="logo-lg"><b>Hartley Labs</b></span>
				</a>				
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->					
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">				
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								  <img src="<?php echo ASSETS; ?>/images/no_profile_image.png" class="user-image" alt="User Image">
								  <span class="hidden-xs"><?php echo $this->session->userdata('user_name');?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<img src="<?php echo ASSETS; ?>/images/no_profile_image.png" class="img-circle" alt="User Image">
										<p>
											Hi, <?php echo $this->session->userdata('user_name');?>
										</p>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">										
										<div class="pull-right">
										  <a href="<?php echo site_url('User/logout');?>" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>             
						</ul>
					</div>
				</nav>
			</header>
			<aside class="main-sidebar">
				<section class="sidebar">
					<ul class="sidebar-menu">													
						<li class="treeview" >
							<a href="#">
								<i class="fa fa-user"></i> <span>Manage Contacts</span> <i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu menu-open" style="display:block">
								<li><a href="<?php echo site_url('/Contact/create') ?>"><i class="fa fa-circle-o"></i>Create/Add new</a></li>
								<li><a href="<?php echo site_url('/Contact') ?>"><i class="fa fa-circle-o"></i>Your Contacts List</a></li>																	
								<li><a href="<?php echo site_url('/Contact/shared_contacts') ?>"><i class="fa fa-circle-o"></i>Contacts shared with you</a></li>									
							</ul>
						</li>
						
					</ul>						
				</section>				
			</aside>