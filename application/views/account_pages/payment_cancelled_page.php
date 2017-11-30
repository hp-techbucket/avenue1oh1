	
	<?php   
		if(!empty($users))
		{
			foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
			{	

	?>
	<div class="collection-banner">
		<div class="banner-wrapper">
			<div class="collection-banner-caption">
				<div class="collection-banner-header">
					<?php echo $pageTitle;?>
				</div>
				<div class="collection-banner-text">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<a href="<?php echo base_url();?>account/" title="Account" class="">Account</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<?php echo $pageTitle;?>
				</div>
			</div>	
		</div>
	</div>
	
	<br/>
	
	<div class="container">
		<div class="row">
			
			<div class="col-md-8 col-md-offset-2" align="center">
				<div class="alert alert-danger">
					<h3 class="text-danger">Your payment was cancelled!</h3>
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('collections/all');?>'" title="CONTINUE SHOPPING" class="btn btn-primary">CONTINUE SHOPPING</a>
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
					<a href="<?php echo base_url();?>account/" title="Account" class="">Account</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo html_escape($pageTitle);?>
				</span>
				<span class="pull-right"><?php echo date('l, F d, Y', time());?></span>
			</div>
		</div>
	</div>

	
	<?php   
			}
		}								
	?>
			
			