
<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pageTitle;?> <small></small>
                        </h1>
                        <ol class="breadcrumb">	
							<li>
                                 <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-user"></i> <?php echo $user->first_name .' '. $user->last_name[0].'.' ; ?>
                            </li>													
                           
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

	<div>	
		<?php 
			$message = '';
			if($this->session->flashdata('security_info_updated') != ''){
				$message = $this->session->flashdata('security_info_updated');
				$url = base_url('account/logout');
				$message .= '<script type="text/javascript" language="javascript"> setTimeout(function() { window.location = "'.$url.'"; }, 9000);</script>';
			}	
			if($this->session->flashdata('password_updated') != ''){
				$message = $this->session->flashdata('password_updated');
			}	
			if($this->session->flashdata('profile_updated') != ''){
				$message = $this->session->flashdata('profile_updated');
			}
			if($this->session->flashdata('error') != ''){
				$message = $this->session->flashdata('error');
			}
			echo $message;						
		?>	
	</div>	
	                
				
		<?php 			

				$form_attributes = array('id' => 'bannerForm');
				$hidden = array(
					'user_id'  => $user->id,
					'email_address' => $user->email_address,
					'banner_photo' => $user->banner_photo,
				);
				echo form_open_multipart('account/banner_upload', $form_attributes);
				echo form_hidden($hidden);	
	
		?>	
		
		<br/><br/>
	<div class="table-responsive ">					
		<table class="table table-striped ">
			<tbody>	
				<tr>
					<td class="grid-block" >
						<div id="bannerMain" >
							<?php echo $banner; ?>
						</div>		
						<div class="changeBanner" align="center">
							<span class="btn-file banner-change-icon" >
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
								</span>
								<input type="file" name="banner_upload" id="bannerUpload" title="Change Profile Header">
							</span>
						</div>	

						<?php echo form_close(); ?>
					</td>
				</tr>	
			<?php 			

				$attributes = array('id' => 'userProfileForm');
				$hide = array(
					'user_id'  => $user->id,
					'email_address' => $user->email_address,
				);
				echo form_open_multipart('account/update_profile', $attributes);
				echo form_hidden($hide);	
	
		?>	
		
				<tr>
					<td>
					<?php echo $thumbnail; ?>
							<span class="btn btn-primary  btn-responsive btn-file">
								UPLOAD PHOTO <input type="file" name="upload_photo" id="uploadPhoto">
							</span>
							<span for="uploadPhoto" >
							</span>
							<span id="uploading" >
								<img src="<?php echo base_url(); ?>assets/images/gif/loading.gif" alt="Uploading"/>
							</span>
					</td>
				</tr>
					
				<tr>
					<td>
						<div class="user-profile">
							<strong>Tagline:</strong>
							<?php echo $user->tagline; ?>
							<a  class="edit-profile" data-id="1"><i class="fa fa-pencil"></i> Edit</a>
						</div>
						
						<div class="update-profile">
							<div class="row">
								<div class="col-lg-4 col-xs-6">
									<input type="text" id="tagline" name="tagline" value="<?php echo $user->tagline; ?>" placeholder="Enter a new tagline">
								</div>
								<div class="col-lg-1 col-xs-2">
									<input type="submit" name="save" class="btn btn-default save-profile" value="Save"/>
								</div>
							</div>
						</div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="user-profile">
							<strong>Name:</strong>
							<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
							
						</div>
					</td>
				</tr>	
					
					
				<tr>
					<td>
						<div class="user-profile">
							<strong>Location:</strong>
							<?php echo $user->address .', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country; ?>
							<a href="javascript:void(0)" class="edit-profile"><i class="fa fa-pencil"></i> Edit</a>
						</div>
						
						<div class="update-profile">
							<div class="row">
								<div class="col-lg-2 col-xs-2">
									<input type="text" id="address" name="address" value="<?php echo $user->address; ?>" placeholder="No. 7 Castle road"/>
									
								</div>
								
								<div class="col-lg-2 col-xs-2">
									<input type="text" id="city" name="city" value="<?php echo $user->city; ?>" placeholder="City"/>
									
								</div>
								
								<div class="col-lg-2 col-xs-2">
									<input type="text" id="postcode" name="postcode" value="<?php echo $user->postcode; ?>" placeholder="Postcode"/>
									
								</div>
								
								<div class="col-lg-2 col-xs-2">
									<input type="text" id="state" name="state" value="<?php echo $user->state; ?>" placeholder="State or County"/>
									
								</div>
								
								<div class="col-lg-2 col-xs-2">
									<input type="text" id="country" name="country" value="<?php echo $user->country; ?>" placeholder="Country"/>
								</div>
								<div class="col-lg-1 col-xs-2">
									<button type="submit" class="btn btn-default save-profile"> Save</button>
								</div>
							</div>
						</div>
					</td>
				</tr>	
				<tr>
					<td>
						<div class="user-profile">
							<strong>Email:</strong>
							<?php echo $user->email_address; ?>
							
						</div>
						
						
					</td>
				</tr>
				<tr>
					<td>
						<div class="user-profile">
							<strong>Mobile:</strong>
							<?php echo $user->mobile; ?>
							<a href="javascript:void(0)" class="edit-profile"><i class="fa fa-pencil"></i> Edit</a>
						</div>
						
						<div class="update-profile">
							<div class="row">
								<div class="col-lg-4 col-xs-6">
									<input type="text" id="mobile" name="mobile" value="<?php echo $user->mobile; ?>" placeholder="Enter a new mobile number">
								</div>
								<div class="col-lg-1 col-xs-2">
									<button type="submit" class="btn btn-default save-profile"> Save</button>
								</div>
							</div>
						</div>
						
					</td>
				</tr>
				<tr>
					<td>
						<div class="user-profile">
							<strong>Birthday:</strong>
							<?php
								$day_value = '';
								$month_value = '';
								$year_value = '';
							?>
							<?php if($user->birthday == '0000-00-00') { ?>
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/settings/'); ?>'" title="Please enter your birthday" >Please enter your birthday</a>
							<?php } else { 
										$day_value = date("d",strtotime($user->birthday));
										$month_value = date("m",strtotime($user->birthday));
										$year_value = date("Y",strtotime($user->birthday));
							?>
								<?php echo  date('F j, Y',strtotime($user->birthday)); ?>
							<?php } ?>
							<a href="javascript:void(0)" class="edit-profile"><i class="fa fa-pencil"></i> Edit</a>
						</div>
						
						
						<div class="update-profile">
							<div class="row">
								<div class="col-lg-1 col-xs-2">
									<input type="text" id="dob-year" value="<?php echo $year_value; ?>" name="year" placeholder="YYYY"/>
								</div>
								
								<div class="col-lg-1 col-xs-2">
									<input type="text" id="dob-month" value="<?php echo $month_value; ?>" name="month" placeholder="MM"/>
								</div>
								
								<div class="col-lg-1 col-xs-2">
									<input type="text" id="dob-day" value="<?php echo $day_value; ?>" name="day" placeholder="DD"/>
								</div>
								<div class="col-lg-1 col-xs-2">
									<button type="submit" class="btn btn-default save-profile"> Save</button>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="user-profile">
							<strong>Profile:</strong>
							<a href="javascript:void(0)" class="edit-profile"><i class="fa fa-pencil"></i> Edit</a>
							<div>
							<?php echo stripslashes(wordwrap(nl2br($user->profile_description), 54, "\n", true)); ?>
							</div>	
							
						</div>
						
						<div class="update-profile">
							<div class="row">
								<div class="col-lg-4 col-xs-6">
									<textarea id="description" name="description" placeholder="Enter a new profile description"><?php echo $user->profile_description; ?></textarea>
								</div>
								<div class="col-lg-1 col-xs-2">
									<button type="submit" class="btn btn-default save-profile"> Save</button>
								</div>
								
							</div>
						</div>
								
					</td>
				</tr>
				<?php echo form_close(); ?>
				<tr>
					<td><strong>Last Login:</strong>
					<?php echo $last_login; ?>
					
					</td>
				</tr>		
				<tr>
					<td><strong>Joined:</strong>
					<?php echo date('F j, Y',strtotime($user->date_created)); ?>
					</td>
				</tr>	
				
				<tr>
					<td>
					<a class="btn btn-primary btn-responsive change-password" ><i class="fa fa-fw fa-lock"></i> Change Password</a>
					<a class="btn btn-success btn-responsive change-security" ><i class="fa fa-fw fa-unlock"></i> Change Security Info</a>
				
					</td>
				</tr>	
						<?php 
							$update_password = 'update-password';
							$change_security = 'update-security';
							
							if(form_error('old_password') || form_error('new_password') || form_error('confirm_new_password')){
								echo '<div class="alert alert-danger text-danger text-center">Please correct the errors below!</div>';
								$update_password = 'password-security';
							}
							if(form_error('security_question') || form_error('security_answer')){
								echo '<div class="alert alert-danger text-danger text-center">Please correct the errors below!</div>';
								$change_security = 'password-security';
							}

						?>
				<tr>
					<td>
						<div class="<?php echo $update_password; ?>">	
							<?php

								$old_password_error = '';
								$new_password_error = '';
								$confirm_error = '';
									
								if(form_error('old_password')){
									$old_password_error = 'input-error';
								}
								if(form_error('new_password')){
									$new_password_error = 'input-error';
								}		
								if(form_error('confirm_new_password')){
									$confirm_error = 'input-error';
								}	
								echo form_open('account/update_password');				
									
							?>
								<h4>Change Password</h4>
								<p>	
									<div class="row">
										<div class="col-lg-4 col-xs-6">
											<strong><?php echo form_label('Old Password', 'old_password'); ?></strong><br/>
											<input type="password" name="old_password" value="<?php echo set_value('old_password'); ?>" class="<?php echo $old_password_error; ?>" id="old_password" placeholder="Enter your old password" />
											<?php echo form_error('old_password'); ?>
										</div>
									</div>
								</p>
								<p>
									<div class="row">
										<div class="col-lg-4 col-xs-6">
											<strong><?php echo form_label('New Password', 'new_password'); ?></strong><br/>
											<input type="password" name="new_password" value="<?php echo set_value('new_password'); ?>" class="<?php echo $new_password_error; ?>" id="new_password" placeholder="Enter a new password" />
											<?php echo form_error('new_password'); ?>
										</div>
									</div>
								</p>
								<p>
									<div class="row">
										<div class="col-lg-4 col-xs-6">
											<strong><?php echo form_label('Confirm New Password', 'confirm_new_password'); ?></strong><br/>
											<input type="password" name="confirm_new_password" value="<?php echo set_value('confirm_new_password'); ?>" class="<?php echo $confirm_error; ?>" id="confirm_new_password" placeholder="Confirm your new password" />
											<?php echo form_error('confirm_new_password'); ?>
										</div>
									</div>
								</p>
								<p>
									<div class="row">
										<div class="col-lg-4 col-xs-6">
											<button type="submit" class="btn btn-primary btn-block">Update Password</button>
										<hr/>
										</div>
									</div>
								</p>	
								<?php echo form_close(); ?>		
							
								
									<br/>
						</div>	
						<div class="<?php echo $change_security; ?>">	
							<?php
								$question_error = '';
								$answer_error = '';
									
								if(form_error('security_question')){
									$question_error = 'input-error';
								}
								if(form_error('security_answer')){
									$answer_error = 'input-error';
								}
									
								echo form_open('account/update_security');
							?>
							<h4>Change Security Information</h4>
							<p>		
								<div class="row">
									<div class="col-lg-4 col-xs-6">
										<?php echo form_label('Security Question', 'security_question'); ?><br/>
									
										<select name="security_question" class="<?php echo $question_error; ?>">
										<?php 
											//foreach($list_of_questions as $question){
												//<option value=" $question; "> $question; </option>
										?>
											
										<?php 
											echo $security_questions;
											//}
										?>										
										</select>

										<?php form_dropdown('security_question', $list_of_questions, 'Select A Question'); ?><br/>
										<?php echo form_error('security_question'); ?>
									</div>
								</div>
							</p>
							<p>
								<div class="row">
									<div class="col-lg-4 col-xs-6">
										<strong><?php echo form_label('Security Answer', 'security_answer'); ?></strong><br/>
										<input type="text" name="security_answer" value="<?php echo $security_answer; ?>" class="<?php echo $answer_error; ?>" id="upass" placeholder="Confirm security answer" />
										<input id="toggleBtn" type="checkbox" onclick="togglePassword()"> Hide Answer
										<?php echo form_error('security_answer'); ?>
										
									</div>
								</div>
							</p>
							<p>
								<div class="row">
									<div class="col-lg-4 col-xs-6">
										<button type="submit" class="btn btn-primary btn-block">Update Security Information</button>
										<hr/>
									</div>
								</div>
							</p>
							<?php echo form_close(); ?>	

						</div>
							
							
					</td>
				</tr>			
				<tr>
					<td>
					
					</td>
				</tr>						
			</tbody>
		</table>
	</div>
			
<?php echo br(1); ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php   
		}
	}								
?>

