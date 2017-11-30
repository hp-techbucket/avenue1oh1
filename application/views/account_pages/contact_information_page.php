	
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
									if(!empty($_SESSION["contact_info_array"]) || !empty($_SESSION["shipping_array"])){
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
							if(!empty($_SESSION["contact_info_array"])){
								
								foreach($_SESSION["contact_info_array"] as $contact){
									
									$checkout_email = $contact['checkout_email'];
									$first_name = $contact['first_name'];
									$last_name = $contact['last_name'];
									$company = $contact['company'];
									$shipping_address = $contact['shipping_address'];
									$shipping_city = $contact['shipping_city'];
									$shipping_zip = $contact['shipping_zip'];
									$shipping_state = $contact['shipping_state'];
									$shipping_country = $contact['shipping_country'];
									$contact_phone = $contact['contact_phone'];
								}
								/*$checkout_email = $this->session->userdata('checkout_email');
								$first_name = $this->session->userdata('first_name');
								$last_name = $this->session->userdata('last_name');
								$company = $this->session->userdata('company');
								$shipping_address = $this->session->userdata('shipping_address');
								$shipping_city = $this->session->userdata('shipping_city');
								$shipping_zip = $this->session->userdata('shipping_zip');
								$shipping_state = $this->session->userdata('shipping_state');
								$shipping_country = $this->session->userdata('shipping_country');
								$contact_phone = $this->session->userdata('contact_phone');*/
							}
							//declare form attributes
							$form_attributes = array(
								'name' => 'contact_information_form',
								'id' => 'contact_information_form',
								'class' => 'form-horizontal',
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
													<table class="user-table">
														<tr>
															<td width="12%">
																<div class="user-icon">
																	<i class="fa fa-user" aria-hidden="true"></i>
																</div>
															</td>
															<td width="88%" align="left">
																<p class="">
																	<?php echo $fullname; ?> (<?php echo $email; ?>)<br/>
																	<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>account/logout?redirectURL=<?php echo urlencode(base_url('checkout')); ?>'" title="Logout" class="">Logout</a>
																</p>
															</td>
														</tr>
													</table>
													
												<?php
													}else{
														
														
												?>
													
													<h2 class="section_title layout-flex_item">Customer information</h2>
													<p class="layout-flex_item text-right">
														<span class="text-default">Already have an account?<span>
														<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>login?checkoutURL=<?php echo urlencode(base_url('checkout')); ?>'" title="Log in" class="">Log in</a>
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
													<div class="textinput">
														<input type="email" name="checkout_email" class="form-control input-lg floatLabel" id="checkout_email" value="<?php echo $checkout_email; ?>" autocapitalize="off" spellcheck="false">
														<label for="checkout_email">Email</label>
													</div>
												</div>
											</div>		
										
											<div class="form-group">
												
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="checkbox checkbox-primary">
														<input type="checkbox" name="buyer_accepts_marketing" class="input-checkbox" id="buyer_accepts_marketing" value="0">
														<label class="checkbox_label" for="buyer_accepts_marketing">
															Subscribe to our newsletter
														</label>
													</div>
														
												</div>
											</div>										
										</div>
										<!-- /.section_content customer-information-->
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
										
										<?php
										if($this->session->userdata('logged_in')){
										
										?>
										<!-- .section_content shipping-addresses-->
										<div class="section_content" data-section="shipping-addresses">
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													
													<select name="select-shipping-address" id="select-shipping-address" class="form-control floatLabel input-lg select2">
														<option value="">Stored addresses</option>
														<option value="new_address">New address</option>
												<?php
													
													//get users default address
													$default_address_query = $this->db->get_where('default_address', array('user_email' => $this->session->userdata('email')));
													
													if($default_address_query) {
														$full_address = '';	
														
														//default address
														foreach($default_address_query->result() as $row){
															
															$full_address = $row->address_line_1;
															if($row->address_line_2 != ''){
																$full_address .= ', '.$row->address_line_2;
															}
															$full_address .= ', '.$row->city;
															$full_address .= ', '.$row->postcode;
															$full_address .= ', '.$row->state;
															$full_address .= ', '.$row->country;
															
												?>
														<option value="default_address-<?php echo $row->id;?>" select="selected"><?php echo $full_address ;?></option>
												<?php
														}
													}
												?>
												
												<?php
													
												//get users secondary addresses
												$addresses_query = $this->db->get_where('addresses', array('user_email' => $email));
														
												if($addresses_query) {
													$full_address2 = '';
															
													//secondary addresses
													foreach($addresses_query->result() as $row){
														$full_address2 = $row->address_line_1;
														if($row->address_line_2 != ''){
															$full_address2 .= ', '.$row->address_line_2;
														}
														$full_address2 .= ', '.$row->city;
														$full_address2 .= ', '.$row->postcode;
														$full_address2 .= ', '.$row->state;
														$full_address2 .= ', '.$row->country;
														
												?>
												
														<option value="addresses-<?php echo $row->id;?>"><?php echo $full_address2 ;?></option>
												<?php
													}
												}	
												?>
												
													</select>
													<label for="select-shipping-address"></label>
													
												</div>		
											
											</div>
											
										</div>
										<!-- /.section_content shipping-addresses-->
										<?php
										
										}
										?>
										
										<!-- .section_content shipping-address-->
										<div class="section_content">
											
											
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
													<div class="textinput">
														<input type="text" name="first_name" class="form-control input-lg floatLabel" value="<?php echo $first_name; ?>" id="first_name">
														
														<label for="first_name">First name</label>
													
													</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="textinput">
														<input type="text" name="last_name" class="form-control input-lg floatLabel" value="<?php echo $last_name; ?>" id="last_name">	
														<label for="last_name">Last name</label>
													</div>
													
												</div>	
												
												<input type="hidden" name="previous_step" id="previous_step" value="contact_information" />
												<input type="hidden" name="step" value="shipping_method" />
							
											</div>		
											
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="textinput">
														<input type="text" name="company" class="form-control input-lg floatLabel" value="<?php echo $company; ?>" id="company">
														<label for="company">Company (optional)</label>
													</div>
												</div>
											</div>		
											
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="textinput">
														<input type="text" name="shipping_address" class="form-control input-lg floatLabel" value="<?php echo $shipping_address; ?>" id="shipping_address" >
														<label for="shipping_address">Address</label>
													</div>
												</div>
											</div>				
											
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="textinput">
														<input type="text" name="shipping_city" class="form-control input-lg floatLabel" value="<?php echo $shipping_city; ?>" id="shipping_city">
														<label for="shipping_city">City</label>
													</div>
														
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="textinput">
														<input type="text" name="shipping_zip" class="form-control input-lg floatLabel" value="<?php echo $shipping_zip; ?>" id="shipping_zip">
														<label for="shipping_zip">Postal code</label>
													</div>
														
												</div>	
											</div>		
											
											<div class="form-group">
												
												<div class="col-md-6 col-sm-6 col-xs-12">
													
													
													<select name="shipping_country" class="form-control select2 input-lg floatLabel" id="shipping_country">
														<option value="">Select Country</option>
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
													<label for="shipping_country"></label>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
													<select name="shipping_state" class="form-control select2 input-lg floatLabel" id="shipping_state">
														<option value="">Select State</option>
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
													<label for="shipping_state"></label>
													
												</div>	
											</div>		
											
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<div class="textinput">
														<input type="text" name="contact_phone" class="form-control input-lg floatLabel" id="contact_phone" value="<?php echo $contact_phone; ?>" >
														<label class="custom-label" for="contact_phone">Phone (optional)</label>
													</div>
														
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
									<div class="step-footer-previous-link pull-left">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>cart'" title="Return to cart" class=""><i class="fa fa-angle-left" aria-hidden="true"></i><?php echo nbs(2);?>Return to cart</a>
									</div> 
									
									<div class="pull-right">
										<button type="submit" class="btn step-footer-continue-btn" title="Continue to shipping method">Continue to shipping method</button>
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
								
								
								//product colour
								$product_colour = '';
								if($each_item['colour'] != '' || $each_item['colour'] != null){
									$product_colour = ucwords($each_item['colour']);
								}
									//
									
								//product size
								$product_size = '';
								if($each_item['size'] != '' || $each_item['size'] != null){
									$product_size = $each_item['size'];
								}
								
									
								//product title
								$product_title = $product_name .' - '.$product_size.' / '.$product_colour;
									
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
										<p class="product_description_name order-summary__emphasis"><?php echo ucwords(html_escape($product_title));?></p>
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

	
			