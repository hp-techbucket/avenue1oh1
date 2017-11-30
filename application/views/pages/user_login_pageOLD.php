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
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); ?>
	<?php echo link_tag('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	<?php echo link_tag('assets/css/style.css'); ?>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	
  </head>

  <body class="custom-wrapper">

<?php 
	$wishlist = '';
	if($this->session->flashdata('logged_in') != ''){
		$wishlist = $this->session->flashdata('logged_in');
	}	
	if($this->session->flashdata('wishlist') != ''){
		$wishlist = $this->session->flashdata('wishlist');
	}	
	echo $wishlist;
?>

  
	  <section class="container" align="center">
	  
			<div class="social-card social-card-container">
				
				<div class="logo-container text-center">
					<a href="<?php echo base_url();?>" title="Avenue 1-OH-1"><img src="<?php echo base_url();?>assets/images/logo/Avenue101-logo.JPG" class="img-responsive" alt="Logo" width="200" height="200"></a>
				</div>
				
				<p class="text-center">If you are not registered, you can <strong><a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>main/signup/'" title="Sign Up">Sign Up</a></strong><p>
					
				<?php	
						$emailError = '';
						$passError = '';
						
						echo form_open('login/validation');
						if(form_error('email')){
							$emailError = 'inputError';
						}
						if(form_error('password')){
							$passError = 'inputError';
						}
	
				?>	
				<p align="left">
					<label for="email">Email</label>
					<input type="text" name="email" id="" class="form-control <?php echo $emailError;?>" value="<?php echo set_value('email');?>">
					<br/>
					<?php echo form_error('email');?>
				</p>
				
				<p align="left">
					<label for="password">Password</label>
					<input type="password" name="password" id="upass" class="form-control <?php echo $passError;?>" value="<?php echo set_value('password');?>">
					<br/>
					<?php echo form_error('password');?>
				</p>
				<p align="left"><input id="toggleBtn" type="checkbox" onclick="togglePassword()"> Show Password</p>
				<p><input type="submit" name="login_button" class="btn btn-primary btn-block" value="Log in"></p>	
				
				<?php	
						
						echo form_close();
				?>			
				
				<p style="text-align:right"><strong><a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>password/reset/'">Forgot Password?</a></strong><p>
			
			
			</div>
       </section>

	<!-- JQuery scripts
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-1.12.0.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('assets/js/jQuery.dPassword.js'); ?>"></script>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	
	<!-- Select2 -->
	<script src="<?php echo base_url('assets/js/select2.full.min.js'); ?>"></script>
	
	<!-- My custom scripts
    ================================================== -->
	<script src="<?php echo base_url(); ?>assets/js/functions.js?<?php echo time(); ?>" type="text/javascript"></script>
		   
</body>
</html>	   