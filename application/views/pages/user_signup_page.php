
	<div class="collection-banner">
		<div class="banner-wrapper">
			<div class="collection-banner-caption">
				<div class="collection-banner-header">
					<?php echo $pageTitle;?>
				</div>
				<div class="collection-banner-text">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo $pageTitle;?>
				</div>
			</div>	
		</div>
	</div>
	
	<br/>
	
	<div class="container">
		<div class="row">
			
			<div class="col-md-8 col-md-offset-2">
				<div class="box box-primary">
					<h3 class="text-primary text-center"><i class="fa fa-user-plus" aria-hidden="true"></i> SIGNUP</h3>
					
					<br/>
					<div class="signup-box">
					
						<p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
					
						<p>If you already have an account with us, please login at the <strong><a href="javascript:void(0);" onclick="location.href='<?php echo base_url()."login" ;?>'">login page</a></strong>.<p>
						
						<?php	
							$fnError = '';
							$lnError = '';
							$emailError = '';
							$passError = '';
							$cpassError = '';
							
							$signup_form = array('name' => 'signup_form','id' => 'signup_form',);
							echo form_open('signup/validation',$signup_form);
							if(form_error('first_name')){
								$fnError = 'input-error';
							}
							if(form_error('last_name')){
								$lnError = 'input-error';
							}
							if(form_error('email_address')){
								$emailError = 'input-error';
							}
							if(form_error('password')){
								$passError = 'input-error';
							}
							if(form_error('confirm_password')){
								$cpassError = 'input-error';
							}
							
							echo form_error('first_name');
							echo form_error('last_name');
							echo form_error('email_address');
							echo form_error('password');
							echo form_error('confirm_password');
							
						?>	
						<div id="notif"></div>
						
						<div class="form-group">
							<label for="first_name">First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control <?php echo $fnError;?>" value="<?php echo set_value('first_name');?>" placeholder="First Name">
						</div>
						<div class="form-group">
							<label for="last_name">Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control <?php echo $lnError;?>" value="<?php echo set_value('last_name');?>" placeholder="Last Name">
						</div>
						<div class="form-group">
							<label for="email_address">Email Address</label>
							<input type="email" name="email_address" id="email_address" class="form-control <?php echo $emailError;?>" value="<?php echo set_value('email_address');?>" placeholder="Email Address">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control <?php echo $passError;?>" value="<?php echo set_value('password');?>" placeholder="Password">
						</div>
						<div class="form-group">
							<label for="confirm_password">Password Confirm</label>
							<input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo $cpassError;?>" value="<?php echo set_value('confirm_password');?>" placeholder="Password Confirm">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block" >CREATE ACCOUNT</button>
							
						</div>
						<p></p>	
						
						<?php	
							echo form_close();
						?>			
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="breadcrumb-container">
		<div class="container">
			<div class="custom-breadcrumb">
				<span class="breadcrumb">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo html_escape($pageTitle);?>
				</span>
				<span class="pull-right"><?php echo date('l, F d, Y', time());?></span>
			</div>
		</div>
	</div>

