
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
			<div class="col-md-6">
				<div class="box box-primary">
					<h3 class="text-primary"><i class="fa fa-user-plus" aria-hidden="true"></i> REGISTER</h3>
					
					<br/>
					
					<p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
					
					<p><a href="javascript:void(0);" onclick="location.href='<?php echo base_url();?>signup/'" title="REGISTER" class="btn btn-primary">REGISTER</a></p>
					<br/>
					
					<hr/>
				<?php
				if($this->session->flashdata('checkoutURL')){
				?>
					<h3 class="text-primary"><i class="fa fa-user" aria-hidden="true"></i> CONTINUE AS A GUEST</h3>
					
					<br/>
					
					<p>Continue checkout as a guest. No sign-up required.</p>
					
					<p><a href="javascript:void(0);" onclick="location.href='<?php echo base_url();?>checkout/'" title="CONTINUE" class="btn btn-primary"><i class="fa fa-chevron-right" aria-hidden="true"></i> CONTINUE</a></p>
				<?php
				}
				?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-primary">
					<h3 class="text-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> LOGIN</h3>
					<br/>
					
					<p>Login to shop faster, manage new and previous orders.</p>
					<br/>
					<?php	
						
						$notice = '';
						if($this->session->flashdata('notice')){
							$notice = $this->session->flashdata('notice');
						}
						echo $notice;
						
						$emailError = '';
						$passError = '';
						
						$login_form = array(
							'name' => 'login_form',
							'id' => 'login_form',
							'class' => 'form-horizontal'
						);
						echo form_open('login/validation',$login_form);
						
						if(form_error('email')){
							$emailError = 'input-error';
						}
						if(form_error('password')){
							$passError = 'input-error';
						}
						echo form_error('email');
						echo form_error('password');
					?>	
					<div id="notif"></div>
					
					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="text" name="email" id="login-email" class="form-control input-lg" value="<?php echo set_value('email');?>" placeholder="Enter your email address">
						
					</div>		
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="upass" class="form-control input-lg login-password" value="<?php echo set_value('password');?>" placeholder="Enter your password">
						<span class="show-password-wrap">
							<a class="show-password" href="#">Show</a>
						</span>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-signin">LOGIN</button>
					</div>
					
					<?php	
						echo form_close();
					?>			
					<p>Forgot your password? No worries, click <strong><a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>forgot-password/'">here</a></strong> to reset your password.<p>
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

