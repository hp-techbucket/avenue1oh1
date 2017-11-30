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

<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>
	<section class="container" align="center">
			<div class="social-card social-card-container">
				
				<div class="logo-container text-center">
					<a href="<?php echo base_url();?>" title="Avenue 1-OH-1"><img src="<?php echo base_url();?>assets/images/logo/Avenue101-logo.JPG" class="img-responsive" alt="Logo" width="200" height="200"></a>
				</div>
					
			
				<p><strong>Please set your security information below</strong></p>
				
				<?php echo br(2); ?>
				
				<?php
					echo form_open('account/security_info_validation'); 
					
					$ansError = '';
					
					if(form_error('security_answer')){
						$ansError = 'inputError';
					}			
						
				?>
				<p align="left">
					<?php echo form_label('Security Question', 'security_question'); ?><br/>
					<?php echo form_dropdown('security_question', $list_of_questions, 'Select A Question'); ?><br/>
					<?php echo form_error('security_question'); ?><br/>
				</p>
				<p align="left">
					<?php echo form_label('Security Answer', 'security_answer'); ?><br/>
					<input type="text" name="security_answer" id="security_answer" value="<?php echo set_value('security_answer'); ?>" class="<?php echo $ansError; ?>" placeholder="Enter an answer" required>
					
					<?php echo br(2); ?>
					<input type="checkbox" id="toggleBtn" onclick="toggleAnswer()">Show Answer<br/>
					<?php echo form_error('security_answer'); ?><br/>		
				</p>
				<p>
					<input type="submit" name="set_memorable_info_submit" class="btn btn-primary btn-block" value="Update">
				</p>
				<?php echo form_close(); ?>
			</div>
			
	</section>
	
<?php   
		}
	}								
?>





    <!-- JQuery scripts
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery-1.12.0.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="<?php echo base_url('assets/js/jQuery.dPassword.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.mobilePassword.js'); ?>"></script>
	
	 <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
				
	
	<!-- My custom scripts
    ================================================== -->
	<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>	
	<script src="<?php echo base_url('assets/js/fileinput.js'); ?>"></script>	
	

	
</body>
</html>	 
