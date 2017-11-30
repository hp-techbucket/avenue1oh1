<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

		
        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $pageTitle;?></h3>
					</div>
					
				</div>

				<div class="clearfix"></div>
				
				
				<!-- breadcrumb -->
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<ol class="breadcrumb">
							<li>
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
									<i class="fa fa-home"></i> Dashboard
								</a>
							</li>						
							<li class="active">
								<i class="fa fa-user"></i> <?php echo $pageTitle;?>
							</li>
																					
						</ol>
					</div>
				</div>
				<!-- /breadcrumb -->
				
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2><?php echo $pageTitle;?></h2>
							   
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div>	
								<?php 
									$message = '';
									if($this->session->flashdata('updated') != ''){
										$message = $this->session->flashdata('updated');
									}	
									if($this->session->flashdata('errors') != ''){
										$message = $this->session->flashdata('errors');
									}	
									echo $message;	
										
								?>	
							</div>	
							
							<!-- Main content -->
							<section class="container">
								
								<div class="row">
									<div class="col-md-3">
										<!-- Profile Image -->
										<div class="box box-primary">
											<div class="box-body box-profile" align="center">
												<?php echo $thumbnail; ?>
												<h3 class="profile-username text-center"><?php echo $user->admin_name; ?>
												</h3>
												
											</div>
										</div>
								
									</div>
									<!-- /.col -->
									<div class="col-md-9">
									<br/>
									
									<div class="nav-tabs-custom">
										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active">
												<a href="#user-profile" aria-controls="user-profile" role="tab" data-toggle="tab">Profile</a>
											</li>
											<li role="presentation">
												<a href="#user-edit" aria-controls="user-edit" role="tab" data-toggle="tab">Edit</a>
											</li>
											
										</ul>
										<!-- /Nav tabs -->
							
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="user-profile">
								<br/>
									<p><strong>Name: </strong><?php echo $user->admin_name; ?></p>
									<p><strong>Username: </strong><?php echo $user->admin_username; ?></p>
									<p><strong>Access Level: </strong> <?php echo $user->access_level; ?></p>
									<p><strong>Date Joined: </strong><?php echo date("F j, Y", strtotime($user->date_created)); ?></p>
								</div>
								<div role="tabpanel" class="tab-pane" id="user-edit">
									
									<br/>
									
									<form action="<?php echo base_url('admin/photo_upload');?>" id="settings_update" name="settings_update" class="form-horizontal" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label class="control-label col-md-5 col-sm-5 col-xs-12">Upload Avatar</label>
											<div class="col-md-7 col-sm-7 col-xs-12">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; ">
													<?php echo $mini_thumbnail; ?>
													</div>
													<div>
														<span class="btn btn-primary btn-file">
															<span class="fileinput-new">Select new image</span>
															<span class="fileinput-exists">Change</span>
															<input type="file" name="update_photo" id="update_photo" >
														</span>
														<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
													</div>
												</div>
												
											</div>
										</div>		
											
									  <div class="form-group">
										<label for="admin_name" class="col-sm-3 control-label">Admin Name</label>

										<div class="col-sm-9">
										  <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo $user->admin_name; ?>" readonly>
										</div>
									  </div>
									  <div class="form-group">
										<label for="admin_username" class="col-sm-3 control-label">Username</label>

										<div class="col-sm-9">
										  <input type="text" class="form-control" id="admin_username" value="<?php echo $user->admin_username; ?>" name="admin_username" readonly>
										</div>
									  </div>
									  
									  <div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
										  <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#updateModal" title="Click to Update Profile">Update Profile</button>
										</div>
									  </div>
										<!-- /.row -->
									  
		<!-- Update Profile Modal -->
		<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Update Profile?</h3>
					</div>
					<div class="modal-body">
						<strong>Are you sure you want to update your profile?</strong>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																				
						<input type="submit" class="btn btn-primary" value="OK">
					</div>
				</div>
			</div>
		</div>  
									  
									</form>
								</div>
								
								<br/><br/>
							</div>
							<!-- /Tab panes -->
										</div>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</section>
							<!-- /.content -->
								
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->

<?php   
		}
	}								
?>

													