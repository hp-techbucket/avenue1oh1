
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
			
			<div class="col-md-8 col-md-offset-2" align="center">
				<div class="box box-primary">
					<p><img src="<?php echo base_url('assets/images/gif/plz_wait.gif');?>" width="150" height="150"/></p>
					
					<div class="alert alert-success">
						<p class="text-success">Your order is being processed and you will be redirected to the PayPal website to complete your payment.</p>
					</div>
					<?php
						//Set variables for paypal form
						$paypalURL = 'https://www.sandbox.paypal.com/us/cgi-bin/webscr'; //test PayPal api url
						$paypalID = 'paypal@avenue1oh1.com'; //business email
						$returnURL = base_url().'paypal/payment_success'; //payment success url
						$cancelURL = base_url().'paypal/cancel'; //payment cancel url
						$notifyURL = base_url().'paypal/ipn'; //ipn url
						//$userID = 1;
						$logo = '<img alt="Brand" src="'.base_url('assets/images/logo/Avenue101-logo.JPG').'" width="105" height="72">';
						
						$hidden = array(
							'cmd' => '_cart',
							'upload' => '1',
							'currency_code' => 'USD',
							'no_note' => '1',
							'rm' => '2',
							'lc' => 'GB',
							'image_url' => $logo,
							'business' => $paypalID,
							'email' => $this->session->userdata('email'),
							'return' => $returnURL,
							'cancel_return' => $cancelURL,
							'notify_url' => $notifyURL,
							'no_shipping' => '2',
							//'shipping' => '2',
							'shipping2' => 9.95,
							'tax_rate' => 0.05,
							'first_name' => '2',
							'last_name' => '2',
							'address1' => '2',
							'city' => '2',
							'state' => '2',
							'zip' => '2',
							'country' => '2',
							'cbt' => 'Return to Avenue 1-OH-1',
							
						);
						$email = $this->session->userdata('email');
						
						
					?>
					
					<?php echo $page_redirect; ?>
					
					<form id="paypalForm" action="<?php echo $paypalURL; ?>" method="post">
					
						<?php echo form_hidden($hidden); ?>
					
						<?php
							
							$cartTotal = "";
							$cartCount = 1;
							
							foreach($_SESSION["cart_array"] as $item){
								$itemID = $item['product_id'];
								$productName = '';
								
								$productPrice = '';
								$productDescription = '';
								
								//item quantity
								$product_qty = $item['quantity'];
								
								$product_array = $this->Products->get_product($itemID);
								if($product_array){
									foreach($product_array as $product){
										$productName = $product->name;
										$productPrice = $product->price;
										$productDescription = $product->description;
									}
								}
								
								//item price
								$pricetotal = $productPrice * $product_qty;
																				
								//total cart amount
								$cartTotal = $pricetotal + $cartTotal;
								
						?>
							<input type="hidden" name="item_number_<?php echo $cartCount; ?>" value="<?php echo $itemID; ?>"> 
							<input type="hidden" name="item_name_<?php echo $cartCount; ?>" value="<?php echo $productName; ?>"> 
							<input type="hidden" name="quantity_<?php echo $cartCount; ?>" value="<?php echo $product_qty; ?>">
							<input type="hidden" name="amount_<?php echo $cartCount; ?>" value="<?php echo $productPrice; ?>"> 
						<?php
								$cartCount++;
							}
						?>
						

						<br>
						<button type="submit" class="btn btn-primary checkout-continue" >CONTINUE</button>
						
						<br/>
		
					</form>
				</div>
			</div>
		</div>
	</div>

				<br/>
	
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

