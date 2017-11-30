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
	<?php echo link_tag('assets/images/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <title>Get Extra Hands | <?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
	<?php echo link_tag('assets/css/bootstrap.min.css'); ?> 
	<?php echo link_tag('assets/css/style.css'); ?>
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>

		<script type="text/javascript" language="javascript">

			var delay = 10000; //Your delay in milliseconds
			setTimeout(function(){ 
				window.location = "<?php echo base_url();?>home"; 
			}, delay);	
		</script>		
	
</head>

<body class="custom-wrapper">
      
	  <section class="container" align="center">
	  
				
				<div class="social-card social-card-container">
				
					<div class="logo-container text-center">
						<a href="<?php echo base_url();?>" title="Avenue 1-OH-1"><img src="<?php echo base_url();?>assets/images/logo/Avenue101-logo.JPG" class="img-responsive" alt="Logo" width="200" height="200"></a>
					</div>
					
					 <div class="alert alert-error" align="center">
							<h3>Activation Failed</h3>
							
							<p>The activation code is not valid!</p>
					</div>	
				</div>
					  
	
       </section>
	   
	   
</body>
</html>		   