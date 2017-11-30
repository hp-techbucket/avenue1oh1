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

    <title>Get Extra Hands | <?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
	<?php echo link_tag('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); ?>
	<?php echo link_tag('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	<?php echo link_tag('assets/css/style.css'); ?>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>	
</head>
<body class="custom-wrapper">

<section class="container" align="center">
		
		
		<div class="social-card social-card-container">
				
				
				<div class="logo-container text-center">
					<a href="<?php echo base_url();?>" title="Avenue 1-OH-1"><img src="<?php echo base_url();?>assets/images/logo/Avenue101-logo.JPG" class="img-responsive" alt="Logo" width="200" height="200"></a>
				</div>
				 
				<p><a href="javascript:void(0)" onclick="location.href='<?php echo $fblogin ; ?>'" class="btn btn-primary btn-block"><i class="fa fa-fw fa-facebook"></i> Facebook</a></p>
				
				<p><a href="javascript:void(0)" onclick="location.href='<?php echo $googlelogin ; ?>'" class="btn btn-danger btn-block"><i class="fa fa-fw fa-google"></i> Google</a></p>
				
				<p class="text-center"><strong>or</strong></p>
				
				<p class="text-center"><strong>Log in or sign up with email</strong></p>
				
				<p><a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>main/login/'" class="btn btn-default mdButton" title="Log in" ><i class="fa fa-fw fa-sign-in"></i> Log in</a>
				
				<?php echo nbs(1);?>
				
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>main/signup/'"  title="Sign up" class="btn btn-default mdButton"><i class="fa fa-fw fa-user"></i> Sign up</a></p><br/>
				<p>By signing up you agree to our <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>main/terms_of_use/'" title="Terms of Use">Terms of Use</a> 
				and <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>main/privacy_policy/'" title="Privacy Policy">Privacy Policy</a></p>

				<?php echo br(2); ?>
				
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
	<script src="<?php echo base_url('assets/js/bjqs-1.3.js'); ?>" type="text/javascript"></script>
		   
</body>
</html>	   