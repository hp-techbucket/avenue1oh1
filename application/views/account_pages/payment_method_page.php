
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
				
				<form class="" id="customer_information_form" action="<?php echo base_url('store/confirm_customer_information'); ?>" method="post" enctype="multipart/form-data">
				
				
				
				<div class="">
					<span class="pull-left">
					<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout/shipping_method'" title="Shipping Method" class=""><i class="fa fa-angle-left" aria-hidden="true"></i><?php echo nbs(2);?>Shipping Method</a></span> 
					
					
					<span class="pull-right"><button type="submit" class="btn btn-info" title="Continue to payment method">Make Payment</button> <p align="center"><?php $pp_checkout_btn = '<a href="javascript:void(0)" onclick="location.href=\''.base_url('paypal/payment').'\'"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!"></a>';
					echo $pp_checkout_btn; ?></p></span> 
			
				</div>
				<?php echo br(5);?>
				<?php echo form_close(); ?>
				
			</div>
			<div class="col-md-5">
				<div class="">
					
				</div>	
			</div>
		</div>
	</div>

	