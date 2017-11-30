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
							<li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/profile'" title="Profile"><i class="fa fa-user"></i> Profile</a>
                            
                            </li>		
							<li class="active">
								<i class="fa fa-cog"></i> <?php echo $pageTitle;?>
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
								<div class="row">
									<div class="col-lg-8 col-lg-offset-2">
										
										<?php 
											$attributes = array(
												'class' => 'form-horizontal',
												
											);
											//start message form
											echo form_open('admin/password_update',$attributes);
										
										?>	
										
										<div class="form-group">
											<label for="new_password" class="col-sm-3 control-label">New Password</label>

											<div class="col-sm-9">
												<input type="password" class="form-control" id="new_password" value="<?php echo set_value('new_password'); ?>" name="new_password">
											</div>
										</div>
									  
										<div class="form-group">
											<label for="confirm_new_password" class="col-sm-3 control-label">Confirm New Password</label>

											<div class="col-sm-9">
												<input type="text" class="form-control" id="confirm_new_password" value="<?php echo set_value('confirm_new_password'); ?>" name="confirm_new_password">
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-sm-9 col-sm-offset-3">
												<button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#updateModal" title="Click to Update Password" > Update</button>
											
											</div>
										</div>
									  
	<!-- Update Password Modal -->
	<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Update Password?</h3>
				</div>
				<div class="modal-body">
					<strong>Are you sure you want to change your password?</strong>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								
					<input type="submit" class="btn btn-primary" value="OK">
				</div>
			</div>
		</div>
	</div>													
										
						<?php 
							echo form_close();
						?>	
									</div>
								</div>
								<!-- /.row -->
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
