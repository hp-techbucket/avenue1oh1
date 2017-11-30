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
	<?php echo link_tag('assets/images/icons/favicon.ico', 'shortcut icon', 'image/ico'); ?>
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>

    <title>Avenue 1-Oh-1 | <?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
			
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css?<?php echo time();?>" media="all"/>
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
  </head>

  <body class="custom-wrapper2">

  
	  <section class="container">
	  
			<div class="card card-container">
			<div class="" align="center">
				<a class="" href="<?php echo base_url();?>">
					<img alt="Brand" src="<?php echo base_url('assets/images/logo/logo2.png');?>" width="155" height="105">
				</a>
			</div>
				<h3 class="text-center text-primary" ><i class="fa fa-lock fa-5x"></i></h3>
			
				<?php	
						$usernameError = '';
						$passError = '';
						
						echo form_open('admin/login_validation');
						if(form_error('username')){
							$usernameError = 'inputError';
						}
						if(form_error('password')){
							$passError = 'inputError';
						}
					
				?>	
				<p><?php echo form_error('username');?></p>
				
				<div class="form-group">
					<input type="text" name="username" value="<?php echo set_value('username'); ?>" class="form-control <?php echo $usernameError; ?>" placeholder="Username" required autofocus>	
				<br/>
											      
				</div>
				<div class="form-group">
					<input type="password" id="upass" name="password" value="<?php echo set_value('password'); ?>" class="form-control <?php echo $passError; ?>" placeholder="Password" required>	
				
				<?php echo form_error('password');?>						      
				</div>
				<div class="form-group">
                        <input id="toggleBtn" type="checkbox" onclick="togglePassword()"> Show Password
                </div>
				<button name="login_button" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Log in</button>
   
				<?php	
						
						echo form_close();
				?>			
				
				
			
			</div>
       </section>
	   
    <!-- JQuery scripts
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	<!-- Custom scripts
    ================================================== -->
	<script src="<?php echo base_url('assets/js/jQuery.dPassword.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>	
	<script src="<?php echo base_url('assets/js/bjqs-1.3.js'); ?>" type="text/javascript"></script>
	
</body>
</html>	   