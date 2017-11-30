
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
				<div class="box box-info">
					<h3 class="text-primary text-center"><i class="fa fa-lock" aria-hidden="true"></i> FORGOT YOUR PASSWORD?</h3>
					
					<br/>
					<div class="forgot-password-box">
						<p>Enter the e-mail address associated with your account and click continue to reset your password.<p>
						
						<?php	
							
							$reset_form = array('name' => 'reset_form','id' => 'reset_form',);
							echo form_open('forgot-password/validation',$reset_form);
							
						?>	
						<div id="notif"></div>
						
						<div class="form-group">
							
							<input type="email" name="email" id="email" class="form-control reset-email" value="<?php echo set_value('email');?>" placeholder="Email Address">
						</div>
						
						<div class="form-group">
							<a href="javascript:void(0);" onclick="location.href='<?php echo base_url();?>login'" title="BACK" class="btn btn-primary pull-left">BACK</a>
							<button type="submit" class="btn btn-primary pull-right btn-continue" >CONTINUE</button>
							<br/>
						</div>
						<p></p>	
						
						<?php	
							echo form_close();
						?>			
					</div>
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

