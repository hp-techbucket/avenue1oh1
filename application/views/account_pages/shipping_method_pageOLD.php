
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
	
	<div class="notif"></div>
	
	
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<div class="checkout-wizard">
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>cart'" title="Cart" class="">Cart</a> 
					<?php echo nbs(2);?>
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo nbs(2);?>
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout'" title="Customer Information" class="">Customer Information</a> 
					<?php echo nbs(2);?>
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<?php echo nbs(2);?>
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>shipping-method'" title="Shipping Method" class="">Shipping Method</a> 
					<?php echo nbs(2);?>
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo nbs(2);?>
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>payment-method'" title="Payment Method" class="">Payment Method</a> 
			
				</div>
				
				<?php echo br(2);?>
				
				
				<form class="" id="shipping_method_form" action="<?php echo base_url('checkout/payment_method'); ?>" method="post" enctype="multipart/form-data">
				
				<div class="row">
					<div class="col-md-3">
						<p>Shipping address</p>
					</div>
					<div class="col-md-6">
						<p class="text-default"><?php ?></p>
					</div>
					<div class="col-md-3">
						<span class="pull-right">
							<a href="#" title="Edit Shipping Address" class="edit-shipping">Edit</a>
						</span>
					</div>
				</div>		
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<select name="shipping" class="form-control select2">
							<option value="3.95" selected>USPS $3.95</option>
							<option value="5.95">UPS $5.95</option>
							<option value="7.95">FedEx $7.95</option>
						</select>
					</div>
				</div>		
				
				<?php echo br(4);?>
				
				
				
				
				<div class="">
					<span class="pull-left">
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout'" title="Return to customer information" class=""><i class="fa fa-angle-left" aria-hidden="true"></i><?php echo nbs(2);?>Return to customer information</a></span> 
					
					<span class="pull-right"><button type="submit" class="btn btn-info" title="Continue to payment method">Continue to payment method</button></span> 
			
				</div>
				
				<?php echo form_close(); ?>
				<?php echo br(5);?>
			</div>
			<div class="col-md-5">
				<div class="">
					
				</div>	
			</div>
		</div>
	</div>

	