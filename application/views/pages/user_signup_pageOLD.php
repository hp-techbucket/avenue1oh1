<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $pageTitle; ?>">
    <meta name="author" content="">
	<?php echo link_tag('assets/images/logo/favicon.ico', 'shortcut icon', 'image/ico'); ?>
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>

     <title>Avenue 1-OH-1 | <?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
	<?php echo link_tag('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); ?>
	<?php echo link_tag('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	<?php echo link_tag('assets/css/style.css'); ?>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	
  </head>

  <body class="custom-wrapper">

  
	  <section class="container" align="center">
       
	   <div class="social-card social-card-container" >
		
			
				<div class="logo-container text-center">
					<a href="<?php echo base_url();?>" title="Avenue 1-OH-1"><img src="<?php echo base_url();?>assets/images/logo/Avenue101-logo.JPG" class="img-responsive" alt="Logo" width="200" height="200"></a>
				</div>
				
				 <p>If you are already registered, <strong><a href="javascript:void(0)" onclick="location.href='<?php echo base_url()."main/login" ;?>'">Log in</a></strong><p>
			
				<?php	
						$fnError = '';
						$lnError = '';
						$emailError = '';
						$mobileError = '';
						$usernameError = '';
						$passError = '';
						$cpassError = '';
						$cityError = '';
						$countryError = '';
						
						
						if(form_error('first_name')){
							$fnError = 'inputError';
						}
						if(form_error('last_name')){
							$lnError = 'inputError';
						}
						if(form_error('email_address')){
							$emailError = 'inputError';
						}
						if(form_error('mobile')){
							$mobileError = 'inputError';
						}	
						if(form_error('username')){
							$usernameError = 'inputError';
						}
						if(form_error('password')){
							$passError = 'inputError';
						}
						if(form_error('confirm_password')){
							$cpassError = 'inputError';
						}
						
						if(form_error('city')){
							$cityError = 'inputError';
						}
						if(form_error('country')){
							$countryError = 'inputError';
						}	
					echo form_open('main/signup_validation');
						
				?>	
					
				<p align="left">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" id="" class="<?php echo $fnError;?>" value="<?php echo set_value('first_name');?>">
					<br/>
					<?php echo form_error('first_name');?>
				</p>
				
				<p align="left">
					<label for="last_name">Surname</label>
					<input type="text" name="last_name" id="" class="<?php echo $lnError;?>" value="<?php echo set_value('last_name');?>">
					<br/>
					<?php echo form_error('last_name');?>
				</p>
				
				<p align="left">
					<label for="email_address">Email</label>
					<input type="text" name="email_address" class="<?php echo $emailError;?>" value="<?php echo set_value('email_address');?>">
					<br/>
					<?php echo form_error('email_address');?>
				</p>	
				
				<p align="left">
					<label for="mobile">Mobile</label>
					<input type="text" name="mobile" id="" class="<?php echo $mobileError;?>" value="<?php echo set_value('mobile');?>">
					<br/>
					<?php echo form_error('mobile');?>
				</p>
				
				<p align="left">
					<label for="username">Username</label>
					<input type="text" name="username" id="" class="<?php echo $usernameError;?>" value="<?php echo set_value('username');?>">
					<br/>
					<?php echo form_error('username');?>
				</p>
				
				<p align="left">
					<label for="password">Password</label>
					<input type="password" name="password" id="upass" class="<?php echo $passError;?>" value="<?php echo set_value('password');?>">
					<br/>
					<?php echo form_error('password');?>
				</p>
				
				<p align="left">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" name="confirm_password" class="<?php echo $cpassError;?>" value="<?php echo set_value('confirm_password');?>">
					<br/>
					<?php echo form_error('confirm_password');?>
				</p>
				
				<p align="left">
					<label for="city">City</label>
					<input type="text" name="city" id="" class="<?php echo $cityError;?>" value="<?php echo set_value('city');?>">
					<br/>
					<?php echo form_error('city');?>
				</p>
				<p align="left">
					<label for="country">Country</label>
					<?php echo form_dropdown('country', $list_of_countries, 'Select Country');?><br/>
					<br/>
					<?php echo form_error('country');?>
				</p>

				<p><input type="submit" name="signup_button" class="btn btn-primary btn-block" value="Create account"></p>
				<?php	
					echo form_close();
				?>
			<?php echo br(3); ?>
		</div>

					
       </section>

	   
	<!-- JQuery scripts
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery-1.12.0.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	
	<!-- My custom scripts
    ================================================== -->
	<script src="<?php echo base_url('assets/js/script.js'); ?>" type="text/javascript"></script>
		   
	   
</body>
</html>	   