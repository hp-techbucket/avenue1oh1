
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
				
				
					<h5 align="center">Please set your account security question and answer and click continue below:</h5>
				<?php echo br(2); ?>
				
				<?php
					echo form_open('account/set-security/validation'); 
					
					$ansError = '';
					
					if(form_error('security_answer')){
						$ansError = 'input-error';
					}			
						
				?>
				
				
					<div class="form-group">
						<label for="security_question">Security Question</label>
						<?php echo $select_security_questions ; ?>
					</div>
					<div class="form-group">
						<label for="security_answer">Security Answer</label>
						<input type="text" name="security_answer" id="security_answer" class="form-control <?php echo $ansError;?>" value="<?php echo set_value('security_answer');?>" placeholder="Security Answer">
						<input id="toggleCheckbox" type="checkbox" onclick="toggleAnswer();" > Show
					</div>
					
					<p align="left"></p>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Continue</button>
					</div>	
					<?php	
						echo form_close();
					?>			
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

