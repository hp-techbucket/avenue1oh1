
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
	
	<div class="container-fluid sidebar_content2">
		<div class="main">
		
		
		</div>
		<div class="sidebar">
		
		
		</div>
	</div>
	
	<div class="container ">
		<div class="row">
			<div class="col-md-7">
			
				<div class="notif"></div>
	
				<br/>
	
				<!-- .main_header -->
				<div class="main_header">
					<ol class="breadcrumb">
						<li class="breadcrumb_item breadcrumb_item-completed">
							<a class="breadcrumb_link" href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>cart'" title="Cart" class="">Cart</a>
						</li>
						<li class="breadcrumb_item breadcrumb_item-current">
							<span class="breadcrumb_text">Customer information</span>
						</li>
						<li class="breadcrumb_item breadcrumb_item-blank">
							<span class="breadcrumb_text">Shipping method</span>
						</li>
						<li class="breadcrumb_item breadcrumb_item-blank">
							<span class="breadcrumb_text">Payment method</span>
						</li>
					</ol>
					
					<input type="hidden" name="previous_step" id="previous_step" value="contact_information" />
					<input type="hidden" name="step" value="shipping_method" />
					
				</div>
				<!-- /.main_header -->
				
				<!-- .main_content -->
				<div class="main_content">
				
				<form class="form-horizontal form-label-left input_mask" id="customer_information_form" action="<?php echo base_url('checkout/shipping_method'); ?>" method="post" enctype="multipart/form-data">
				
					<!-- .step -->
					<div class="step" data-step="contact_information">
						<!-- .step_sections -->
						<div class="step_sections">
							<!-- .section section--contact-information-->
							<div class="section section--contact-information">
								<!-- .section_header-->
								<div class="section_header">
									<div class="layout-flex">
										<!-- .section_title-->
										<h2 class="section_title layout-flex_item">Customer information</h2>
										<p class="layout-flex_item">
											<span aria-hidden="true">Already have an account?</span>
											<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>login?redirectURL=<?php echo urlencode(base_url('checkout')); ?>'" title="Log in" class="">Log in</a>
										</p>
									</div>
								</div>
								<!-- /.section_header-->
								
								<!-- .section_content customer-information-->
								<div class="section_content" data-section="customer-information">
								
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="email" name="checkout_email" class="form-control input-lg" id="checkout_email" placeholder="Email" autocapitalize="off" spellcheck="false">	
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="checkbox" name="buyer_accepts_marketing" class="input-checkbox" id="buyer_accepts_marketing" value="1">
											<label class="checkbox_label" for="buyer_accepts_marketing">Subscribe to our newsletter</label>											
										</div>
									</div>										
								</div>
								<!-- /.section_content customer-information-->
								
							</div>
							<!-- /.section section--contact-information-->
							
							<!-- .section section--shipping-address-->
							<div class="section section--shipping-address">
								<!-- .section_header-->
								<div class="section_header">
									<!-- .section_title-->
									<h2 class="section_title">Shipping address</h2>
								</div>
								<!-- /.section_header-->
								
								<!-- .section_content shipping-address-->
								<div class="section_content">
								
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="first_name" class="form-control input-lg" id="first_name" placeholder="First name">	
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="last_name" class="form-control input-lg" id="last_name" placeholder="Last name">	
										</div>	
									</div>		
									
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="text" name="company" class="form-control input-lg" id="company" placeholder="Company (optional)">	
										</div>
									</div>		
									
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="text" name="shipping_address" class="form-control input-lg" id="shipping_address" placeholder="Address">	
										</div>
									</div>		
									
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="shipping_city" class="form-control input-lg" id="shipping_city" placeholder="City">	
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="shipping_zip" class="form-control input-lg" id="shipping_zip" placeholder="Postal code">	
										</div>	
									</div>		
									
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="shipping_state" class="form-control input-lg" id="shipping_state" placeholder="State">	
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											
											<select name="shipping_country" class="form-control select2 input-lg" id="shipping_country">
												<option value="0" selected="selected">Select Country</option>
												<?php
													$this->db->from('countries');
													$this->db->order_by('id');
													$result = $this->db->get();
													if($result->num_rows() > 0) {
														foreach($result->result_array() as $row){
												?>
												<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
												<?php
														}
													}
												?>
											</select>
										</div>	
									</div>		
									
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input type="text" name="contact_phone" class="form-control input-lg" id="contact_phone" placeholder="Phone (optional)">	
										</div>
									</div>		
									
								</div>
								<!-- /.section_content shipping-address-->
							</div>
							<!-- /.section section--shipping-address-->
						</div>
						<!-- /.step_sections -->
						
						<!-- .step_footer -->
						<div class="step_footer">
							<span class="pull-left">
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>cart'" title="Return to cart" class="step_footer_previous-link"><i class="fa fa-angle-left" aria-hidden="true"></i><?php echo nbs(2);?>Return to cart</a></span> 
							
							<span class="pull-right"><button type="submit" class="btn btn-info step_footer_continue-btn" title="Continue to shipping method">Continue to shipping method</button></span> 
					
						</div>
						<!-- /.step_footer -->
						
					</div>
					<!-- /.step -->
				</div>
				<!-- /.main_content -->
			
				<?php echo form_close(); ?>
				<br/>
			</div>
			
			
	<br/>
		
			<div class="col-md-5 sidebar_content">
				
				<table class="table product-table table-responsive">
					<caption class="visually-hidden">Shopping cart</caption>
					<thead>
						<tr>
						  <th scope="col"><span class="visually-hidden">Product image</span></th>
						  <th scope="col"><span class="visually-hidden">Description</span></th>
						  <th scope="col"><span class="visually-hidden">Quantity</span></th>
						  <th scope="col"><span class="visually-hidden">Price</span></th>
						</tr>
					</thead>
					<tbody data-order-summary-section="line-items">
					<?php
						$cartTotal = "";
						foreach($_SESSION["cart_array"] as $each_item){
													
							$item_id = $each_item['product_id'];
																
							$query = $this->db->get_where('products', array('id' => $item_id));
																
							$product_name = '';
							$product_image = '';
							$price = '';
							$details = '';
							$quantity_available = '';
							
							
							if($query){
								foreach ($query->result() as $row){
									$product_image = $row->image;
									$product_name = $row->name;
									$price = $row->price;
									$details = $row->description;
									$quantity_available = $row->quantity_available;
								}							
							}
							$pricetotal = $price * $each_item['quantity'];
							$pricetotal = sprintf("%01.2f", $pricetotal);
							$cartTotal = $pricetotal + $cartTotal;
													
							$thumbnail = '';
							$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
																
							if(file_exists($filename)){
								$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive img-rounded" width="50" height="60" />';
							}
							else if($product->image == '' || $product->image == null || !file_exists($filename)){
								$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="50" height="60" />';
							}
							else{
								$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive img-rounded" width="50" height="60" />';
							}
				
				
					?>
						<tr class="product" data-product-id="<?php echo $item_id; ?>1230566597" data-variant-id="<?php ; ?>" data-product-type="">
							<td class="product_image">
								<div class="product-thumbnail">
									<div class="product-thumbnail_wrapper">
										<?php echo $thumbnail ; ?>
									</div>
									<span class="product-thumbnail_quantity" aria-hidden="true"><?php echo $each_item['quantity']; ?></span>
								</div>
							</td>
							<td class="product_description">
								<span class="product_description_name order-summary__emphasis"><?php echo ucwords(html_escape($product_name));?></span>
								<span class="product_description_variant order-summary__small-text"><?php ; ?></span>

							</td>
							
							<td class="product_price">
								<span class="order-summary__emphasis">$<?php echo $pricetotal; ?></span>
							</td>
						</tr>
					<?php
						}
						$taxes = 0.05 * $cartTotal;
						$cartTotal = sprintf("%01.2f", $cartTotal);
						$taxes = sprintf("%01.2f", $taxes); 
					?>	
					</tbody>
 				
				</table>
				
				
				<table class="table total-line-table table-responsive">
					<caption class="visually-hidden">Cost summary</caption>
					<tr class="total-line total-line--subtotal">
						<td class="total-line_name">Subtotal</td>
						<td class="total-line_price text-right">
							<span class="order-summary__emphasis">$<?php echo $cartTotal; ?>
									</span>
						</td>
					</tr>
					<tr class="total-line total-line--shipping">
						<td class="total-line_name">Shipping</td>
						<td class="total-line_price text-right">
							<span class="order-summary__emphasis">—</span>
						</td>
					</tr>

					<tr class="total-line total-line--taxes">
						<td class="total-line_name">Taxes (5%)</td>
						<td class="total-line_price text-right">
							<span class="order-summary__emphasis">$<?php echo $taxes; ?></span>
						</td>
					</tr>
				</table>	
				
				
				<table class="table total-line-table_footer table-responsive">
					<tr class="total-line">
						<td class="total-line_name payment-due-label">
							<span class="payment-due-label__total">Total</span>
						</td>
						<td class="total-line_price payment-due text-right">
							<span class="payment-due_currency">USD</span>
							<span class="payment-due_price">
								<?php echo $cartTotal + $taxes; ?>
							</span>
						</td>
					</tr>
				</table>
				<div class="">
				
					<div class="row checkout-cart-row">
						<div class="col-xs-3">
							<div class="checkout-cart-img">
							
							</div>
						</div>
						<div class="col-xs-5">
							<div class="checkout-cart-desc">
							
							</div>
						</div>
						<div class="col-xs-4">
							<div class="checkout-cart-amt">
							
							</div>
						</div>
					</div>
				
					<div class="row checkout-cart-row">
						<div class="col-xs-3">
							<div class="checkout-cart-img">
							
							</div>
						</div>
						<div class="col-xs-5">
							<div class="checkout-cart-desc">
							
							</div>
						</div>
						<div class="col-xs-4">
							<div class="checkout-cart-amt">
							
							</div>
						</div>
					</div>

				</div>	
			</div>
		
		</div>
	</div>

	
			