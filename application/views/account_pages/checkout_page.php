	
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
								<li class="breadcrumb_item breadcrumb_item-current">
									<span class="breadcrumb_text">Customer information</span>
								</li>
								<?php
									if($this->session->userdata('contact_information')){
								?>
								<li class="breadcrumb_item breadcrumb_item-completed">
									<a class="breadcrumb_link" href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>checkout/shipping-method'" title="Cart" class="">Shipping method</a>
								</li>
								<?php
									}else{
								?>
								<li class="breadcrumb_item breadcrumb_item-blank">
									<span class="breadcrumb_text">Shipping method</span>
								</li>
								<?php } ?>
								<li class="breadcrumb_item breadcrumb_item-blank">
									<span class="breadcrumb_text">Payment method</span>
								</li>
							</ol>
							
						</div>
						<!-- /.main_header -->
						
						<!-- .main_content -->
						<div class="main_content checkout-content">
						
						<!-- form -->
						<?php
							//declare variables used in the form
							$checkout_email = '';
							$first_name = '';
							$last_name = '';
							$company = '';
							$shipping_address = '';
							$shipping_city = '';
							$shipping_zip = '';
							$shipping_state = '';
							$shipping_country = '';
							$contact_phone = '';
							
							//get users default address if logged in
							if($this->session->userdata('logged_in')){
								
								$email = $this->session->userdata('email');
								$default_address_array = $this->Default_address->get_address($email);
														
								if($default_address_array){
									
									foreach($default_address_array as $default){
										
										$first_name = $default->first_name;
										$last_name = $default->last_name;
										$company = $default->company_name;
										
										$shipping_address = $default->address_line_1;
										if($default->address_line_2 != ''){
											$shipping_address .= ', '.$default->address_line_2;
										}
										$shipping_city = $default->city;
										$shipping_zip = $default->postcode;
										$shipping_state = $default->state;
										$shipping_country = $default->country;
										$contact_phone = $default->phone;
									}
								}
														
							}
							
							//set data from session as default if set
							if($this->session->userdata('contact_information')){
								
								$checkout_email = $this->session->userdata('checkout_email');
								$first_name = $this->session->userdata('first_name');
								$last_name = $this->session->userdata('last_name');
								$company = $this->session->userdata('company');
								$shipping_address = $this->session->userdata('shipping_address');
								$shipping_city = $this->session->userdata('shipping_city');
								$shipping_zip = $this->session->userdata('shipping_zip');
								$shipping_state = $this->session->userdata('shipping_state');
								$shipping_country = $this->session->userdata('shipping_country');
								$contact_phone = $this->session->userdata('contact_phone');
							}
							//declare form attributes
							$form_attributes = array(
								'name' => 'contact_information_form',
								'id' => 'contact_information_form',
								'class' => 'form-horizontal form-label-left input_mask',
							);
							
							//open form
							echo form_open('checkout/contact_information_validation',$form_attributes);
						?>
						
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
												<?php
													if($this->session->userdata('logged_in')){
														
														$fullname = '';
														
														$email = $this->session->userdata('email');
														$users_array = $this->Users->get_user($email);
														if($users_array){
															foreach($users_array as $user){
																$fullname = $user->first_name .' '.$user->last_name;
															}
														}
												?>
													<h2 class="section_title layout-flex_item"><?php echo $fullname; ?></h2>
													<p class="layout-flex_item">
														
														<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('logout'); ?>'" title="Logout" class="">Logout</a>
													</p>
												<?php
													}else{
														
														
												?>
													
													<h2 class="section_title layout-flex_item">Customer information</h2>
													<p class="layout-flex_item">
														<span aria-hidden="true">Already have an account?</span>
														<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>login?redirectURL=<?php echo urlencode(base_url('checkout')); ?>'" title="Log in" class="">Log in</a>
													</p>
												<?php } ?>
											</div>
										</div>
										<!-- /.section_header-->
										
										<?php
										if(!$this->session->userdata('logged_in')){
										?>
										<!-- .section_content customer-information-->
										<div class="section_content" data-section="customer-information">
										
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="email" name="checkout_email" class="form-control input-lg" id="checkout_email" value="<?php echo $checkout_email; ?>" placeholder="Email" autocapitalize="off" spellcheck="false">	
												</div>
											</div>

											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="checkbox" name="buyer_accepts_marketing" class="input-checkbox" id="buyer_accepts_marketing" value="0">
													<label class="checkbox_label" for="buyer_accepts_marketing">Subscribe to our newsletter</label>											
												</div>
											</div>										
										</div>
										<!-- /.section_content customer-information-->
										
										<?php
										}else{
										?>
										<!-- .section_content shipping-addresses-->
										<div class="section_content" data-section="shipping-addresses">
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
												<?php
													$address_options = '';
													//get users default address
													$default_address_query = $this->db->get_where('default_address', array('user_email' => $this->session->userdata('email')));
														
													//get users secondary addresses
													$addresses_query = $this->db->get_where('addresses', array('user_email' => $this->session->userdata('email')));
														
													if($default_address_query || $addresses_query) {
															
														$address_options = '<select name="select-shipping-address" id="select-shipping-address" class="form-control select2">';
															
														//default address
														foreach($default_address_query->result() as $row){
															$address_options .= '<option value="default_address-'.$row->id.'">'.$row->first_name.' '.$row->last_name.'</option>';
														}
															
														//secondary addresses
														foreach($addresses_query->result() as $row){
															$address_options .= '<option value="addresses-'.$row->id.'">'.$row->first_name.' '.$row->last_name.'</option>';
														}
															
														$address_options .= '</select>';
													}
													echo $address_options;		
												?>
													
												</div>		
											
											</div>
											
										</div>
										<!-- /.section_content shipping-addresses-->
										
										<?php
										}
										?>
									</div>
									<!-- /.section section--contact-information-->
									
									<!-- .section section--shipping-address-->
									<div class="section section--shipping-address">
										
										<div class="notif"></div>
										
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
													<input type="text" name="first_name" class="form-control input-lg" value="<?php echo $first_name; ?>" id="first_name" placeholder="First name">	
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="last_name" class="form-control input-lg" value="<?php echo $last_name; ?>" id="last_name" placeholder="Last name">	
												</div>	
												
												<input type="hidden" name="previous_step" id="previous_step" value="contact_information" />
												<input type="hidden" name="step" value="shipping_method" />
							
											</div>		
											
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="company" class="form-control input-lg" value="<?php echo $company; ?>" id="company" placeholder="Company (optional)">	
												</div>
											</div>		
											
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="shipping_address" class="form-control input-lg" value="<?php echo $shipping_address; ?>" id="shipping_address" placeholder="Address">	
												</div>
											</div>		
											
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="shipping_city" class="form-control input-lg" value="<?php echo $shipping_city; ?>" id="shipping_city" placeholder="City">	
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="shipping_zip" class="form-control input-lg" value="<?php echo $shipping_zip; ?>" id="shipping_zip" placeholder="Postal code">	
												</div>	
											</div>		
											
											<div class="form-group">
												
												<div class="col-md-6 col-sm-6 col-xs-12">
													
													<select name="shipping_country" class="form-control select2 input-lg" id="shipping_country" onchange="getStates();">
														<option value="0" selected="selected">Select Country</option>
														<?php
															$this->db->from('countries');
															$this->db->order_by('id');
															$countries_result = $this->db->get();
															if($countries_result->num_rows() > 0) {
																foreach($countries_result->result_array() as $row){
																	//set default country
																	$default = (strtolower($row['name']) == strtolower($shipping_country))?'selected':'';
														?>
														<option value="<?php echo $row['id']; ?>" <?php echo $default; ?>><?php echo $row['name']; ?></option>
														<?php
																}
															}
														?>
													</select>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
												
													<select name="shipping_state" class="form-control select2 input-lg" id="shipping_state">
														<option value="0" selected="selected">Select State</option>
													<?php
														$select_state = '';
														$country_id = '';
														if($shipping_country != ''){
															
															//get country id
															$this->db->from('countries');
															$this->db->where('LOWER(name)', strtolower($shipping_country));
															$result = $this->db->get();
															if($result->num_rows() > 0) {
																foreach($result->result_array() as $row){
																	$country_id = $row['id'];
																}
															}
															
															//get states based on country id
															$states_query = $this->db->get_where('states', array('country_id' => $country_id));
															
															if($states_query) {
																foreach($states_query->result() as $row){
																	
																	//set default state
																	$default = (strtolower($row->name) == strtolower($shipping_state))?'selected':'';
																	
																	echo '<option value="'.$row->name.'" '.$default.'>'.$row->name.'</option>';			
																}
															}
														}
														?>
														
													</select>
												
												</div>	
											</div>		
											
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input type="text" name="contact_phone" class="form-control input-lg" id="contact_phone" value="<?php echo $contact_phone; ?>" placeholder="Phone (optional)">	
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
									<p class="total-line_name"><span class="pull-right">$<?php echo $cartTotal; ?>
											</span></p>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<p class="total-line_name">Shipping</p>
								</div>
								<div class="col-xs-6">
									<p class="total-line_name">
										<span class="pull-right">—</span>
									</p>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<p class="total-line_name">Taxes (5%)</p>
								</div>
								<div class="col-xs-6">
									<p class="total-line_name">
										<span class="pull-right">$<?php echo $taxes; ?></span>
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
											<?php echo $cartTotal + $taxes; ?>
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

	
			