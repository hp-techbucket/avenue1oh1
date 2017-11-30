
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
	
	<div class="row">
		<div class="col-md-6">
			<div class="box-primary">
				<div class="row">
					<div class="col-xs-4">
					
					</div>
					<div class="col-xs-8">
						REGISTER
					</div>
				</div>
				<p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
				<a href="" class="btn btn-primary">CONTINUE</a>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box-primary">
				<div class="row">
					<div class="col-xs-4">
					
					</div>
					<div class="col-xs-8">
						LOGIN
					</div>
				</div>
				<?php	
					echo form_open('login/validation');
						
				?>	
				<div class="form-group">
					<label for="email">Email <span class="text-danger">*</span></label>
					<input type="text" name="email" id="" class="form-control" value="<?php echo set_value('email');?>" placeholder="Email Address">
				</div>
				<div class="form-group">
					<label for="password">Password <span class="text-danger">*</span></label>
					<input type="password" name="password" id="upass" class="form-control" value="<?php echo set_value('password');?>" placeholder="Password">
				</div>
				
				<p align="left"><input id="toggleBtn" type="checkbox" onclick="togglePassword()"> Show Password</p>
				<p><button type="submit" class="btn btn-primary btn-block">LOGIN</button></p>	
				<?php	
					echo form_close();
				?>			
				<p style="text-align:right"><strong><a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>password/reset/'">Forgot Password?</a></strong><p>
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

