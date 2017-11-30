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

		<script type="text/javascript" language="javascript">

			//var delay = 10000; //Your delay in milliseconds
			//setTimeout(function(){ 
			//	window.location = "<?php echo base_url();?>home/login/"; 
			//}, delay);	
		</script>		
	
</head>

<body class="custom-wrapper">
      
		<section class="container" align="center">

				<div class="social-card social-card-container">
				
					<div class="logo-container text-center">
						<a href="<?php echo base_url();?>" title="Avenue 1-OH-1"><img src="<?php echo base_url();?>assets/images/logo/Avenue101-logo.JPG" class="img-responsive" alt="Logo" width="200" height="200"></a>
					</div>
				
					
					
					<div class="alert alert-success" align="center">
						<h3>Signup Success!</h3>
						<p>Thank you for signing up. Please check your email to activate your account.</p>
					</div>
					<?php echo br(1); ?>
				
				</div>
		</section>
	   
	   
</body>
</html>		   