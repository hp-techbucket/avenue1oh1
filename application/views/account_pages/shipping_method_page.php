	
	<!-- .collection-banner-->
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
	<!-- /.collection-banner-->
	
	<!-- .container-fluid sidebar_background-->
	<div class="container-fluid sidebar_background">
	
		<!-- .main-content-->
		<div class="main-content">
		
			<!-- .container-->
			<div class="container ">
			
				<!-- .row-->
				<div class="row">
				
					<!-- .col-md-7-->
					<div class="col-md-7">
					
						<br/>
	
						<!-- .main_header -->
						<div class="main_header">
							<ol class="breadcrumb">
								<li class="breadcrumb_item breadcrumb_item-completed">
									<a class="breadcrumb_link" href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>cart'" title="Cart" class="">Cart</a>
								</li>
								<li class="breadcrumb_item breadcrumb_item-completed">
									<a class="breadcrumb_link" href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout/contact-information'" title="Cart" class="">Customer information</a>
								</li>
								<li class="breadcrumb_item breadcrumb_item-current">
									<span class="breadcrumb_text">Shipping method</span>
								</li>
								<?php
									if(!empty($_SESSION["shipping_array"])){
								?>
								<li class="breadcrumb_item breadcrumb_item-completed">
									<a class="breadcrumb_link" href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout/payment-method'" title="Cart" class="">Payment method</a>
								</li>
								<?php
									}else{
								?>
								<li class="breadcrumb_item breadcrumb_item-blank">
									<span class="breadcrumb_text">Payment method</span>
								</li>
								<?php } ?>
								
							</ol>
							
						</div>
						<!-- /.main_header -->
						
						<!-- .main_content -->
						<div class="main_content checkout-content">
						
						<!-- form -->
						<?php
							$shipping_type = '';
							$shipping_company = '';
							$shipping_costs = '';
							$total_shipping_costs = '';
							
							if(!empty($_SESSION["shipping_array"])){
								
								foreach($_SESSION["shipping_array"] as $shipping){
									
									$shipping_type = $shipping['shipping_type'];
									$shipping_company = $shipping['shipping_company'];
									$shipping_costs = $shipping['shipping_costs'];
									$total_shipping_costs = $shipping['total_shipping_costs'];
								}
							}
							$form_attributes = array(
								'name' => 'shipping_method_form',
								'id' => 'shipping_method_form',
								'class' => 'form-horizontal form-label-left input_mask',
							);
							echo form_open('checkout/shipping_method_validation',$form_attributes);
						?>
						
							<!-- .step -->
							<div class="step" data-step="shipping_method">
								<!-- .step_sections -->
								<div class="step_sections">
									
									<!-- .section section--shipping-method-->
									<div class="section section--shipping-method">
										
										<div class="notif"></div>
										
										<!-- .section_header-->
										<div class="section_header">
											<!-- .section_title-->
											<h2 class="section_title">Shipping Method</h2>
										</div>
										<!-- /.section_header-->
										
										<!-- .section_content shipping-method-->
										<div class="section_content">
										
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<h3>Domestic</h3>
													<div class="domestic-shipping">
														<?php
														$this->db->from('domestic_shipping_rates');
														$this->db->order_by('id');
														$domestic_result = $this->db->get();
														if($domestic_result->num_rows() > 0) {
															foreach($domestic_result->result_array() as $row){
																
																//set default radio
																$default = (strtolower($row['shipping_company']) == strtolower($shipping_company))?'checked':'';
																$additional_items = $row['shipping_costs'] / 2;
														?>
														<div class="radio radio-primary">
														
															<input type="radio" value="domestic-<?php echo $row['shipping_company'];?>-<?php echo sprintf("%01.2f", $row['shipping_costs']);?>" name="shipping" <?php echo $default;?>>
															
															<label>
															<?php echo $row['shipping_company'];?>-$<?php echo sprintf("%01.2f", $row['shipping_costs']);?> ($<?php echo $additional_items;?> for each additional item)
															</label>
															
														</div>
														<?php
															}
														}
														?>
													</div>
												</div>
												
											</div>
										
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<h3>International</h3>
													<div class="intl-shipping">
														<?php
														$this->db->from('intl_shipping_rates');
														$this->db->order_by('id');
														$domestic_result = $this->db->get();
														if($domestic_result->num_rows() > 0) {
															foreach($domestic_result->result_array() as $row){
																
																//set default radio
																$default = (strtolower($row['shipping_company']) == strtolower($shipping_company))?'checked':'';
																$additional_items = $row['shipping_costs'] / 2;
														?>
														<div class="radio radio-primary">
														
															<input type="radio" value="domestic-<?php echo $row['shipping_company'];?>-<?php echo sprintf("%01.2f", $row['shipping_costs']);?>" name="shipping" <?php echo $default;?>>
															
															<label>
																<?php echo $row['shipping_company'];?>-$<?php echo sprintf("%01.2f", $row['shipping_costs']);?> ($<?php echo $additional_items;?> for each additional item)
															</label>
														</div>
														<?php
															}
														}
														?>
													</div>
												</div>	
												
											
											</div>
										
												<input type="hidden" name="previous_step" id="previous_step" value="shipping_method" />
												<input type="hidden" name="step" value="payment_method" />
							
										</div>		
										<!-- /.section_content shipping-method-->
									</div>
									<!-- /.section section--shipping-method-->
								</div>
								<!-- /.step_sections -->
								
								<!-- .step_footer -->
								<div class="step_footer">
									<div class="step-footer-previous-link pull-left">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout'" title="Return to customer information" class=""><i class="fa fa-angle-left" aria-hidden="true"></i><?php echo nbs(2);?>Return to customer information</a>
									</div> 
									
									<div class="pull-right">
										<button type="submit" class="btn step-footer-continue-btn" title="Continue to payment method">Continue to payment method</button>
									</div> 
							
								</div>
								<!-- /.step_footer -->
								
							</div>
							<!-- /.step -->
						</div>
						<!-- /.main_content -->
					
						<?php echo form_close(); ?>
						<!-- /form -->
						
						<br/>
					</div>
					<!-- /.col-md-7-->
					
				</div>
				<!-- /.row-->
				
			</div>
			<!-- /.container-->
			
		</div>
		<!-- /.main-content-->
		
		<!-- .sidebar-content-->
		<div class="sidebar-content">
		
			<!-- .container-->
			<div class="container ">
			
				<!-- .row-->
				<div class="row">
					<!-- .col-md-5-->
					<div class="col-md-5">
					
					<?php
						$cartTotal = "";
						if(!empty($_SESSION["cart_array"])){
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
									$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive" />';
								}
								else if($product->image == '' || $product->image == null || !file_exists($filename)){
									$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive" />';
								}
								else{
									$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive"/>';
								}
					
					
						?>
							
						<div class="product-items">
							
							<div class="row">
								<div class="col-xs-2">
									<div class="item-thumbnail">
										<div class="item-thumbnail_wrapper">
											<?php echo $thumbnail ; ?>
										</div>
										<div class="item-thumbnail_quantity">
											<?php echo $each_item['quantity']; ?>
										</div>
									</div>
								</div>
								<div class="col-xs-8">
									<div class="item-description">
										<p class="product_description_name order-summary__emphasis"><?php echo ucwords(html_escape($product_name));?></p>
										<p class="product_description_variant order-summary__small-text"><?php ; ?></p>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="item-price">
										<span class="pull-right">$<?php echo $pricetotal; ?>
										</span>
									</div>
								</div>
							</div>
							
						</div>
						<?php
							}
							$taxes = 0.05 * $cartTotal;
							$cartTotal = sprintf("%01.2f", $cartTotal);
							$taxes = sprintf("%01.2f", $taxes); 
						?>	
						
						<div class="total-line">
							
							<div class="row">
								<div class="col-xs-6">
									<p class="total-line_name">Subtotal </p>
								</div>
								<div class="col-xs-6">
									<p class="total-line_name">
										<span class="pull-right">$
											<span class="cart-total">
												<?php echo $cartTotal; ?>
											</span>
										</span>
									</p>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<p class="total-line_name">Shipping</p>
								</div>
								<div class="col-xs-6">
									<p class="total-line_name">
										<span class="pull-right">
											<span class="total-shipping-costs">
												<?php echo empty($total_shipping_costs) ? "—" : $total_shipping_costs; ?>
											</span>
										</span>
									</p>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<p class="total-line_name">Taxes (5%)</p>
								</div>
								<div class="col-xs-6">
									<p class="total-line_name">
										<span class="pull-right">$
											<span class="shipping-taxes">
												<?php echo $taxes; ?>
											</span>
										</span>
									</p>
								</div>
							</div>
						</div>
						
						<div class="total-line_footer">
						
							<div class="row">
								<div class="col-xs-6">
									<p class="payment-due-label_total">Total</p>
								</div>
								<div class="col-xs-6">
									<p class="total-line_price payment-due text-right">
										<span class="payment-due_currency">USD</span>
										<span class="payment-due_price">
											<?php echo $cartTotal + $total_shipping_costs + $taxes; ?>
										</span>
									</p>
								</div>
							</div>
						</div>
				<?php 
						}
				?>
					</div>
					<!-- .col-md-5-->
				</div>
				<!-- /.row-->
				
			</div>
			<!-- /.container-->
			
		</div>
		<!-- /.sidebar-content-->
		
	</div>
	<!-- /.container-fluid sidebar_background-->

	
			