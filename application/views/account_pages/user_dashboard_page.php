
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
	
	<?php   
		if(!empty($users))
		{
			foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
			{	
				$last_login = '';
				if($user->last_login == '0000-00-00 00:00:00'){
					$last_login = 'Never';
				}
				else{
					$last_login = date("F j, Y, g:i a", strtotime($user->last_login));
				
				}
				
				$default_tag = '';
				$default_name = '';
				$default_address = '';
				$default_phone = '';
				
				$first_name = '';
				$last_name = '';
				$email_address = '';
				$company_name = '';						
				$phone = '';									
				$address_line_1 = '';					
				$address_line_2 = '';								
				$city = '';									
				$postcode = '';
				$country = '';	
				$state = '';
	?>
		<div class="row">
			<div class="col-lg-12 col-xs-12 text-right">
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										
					<span class=""><i class="fa fa-clock-o fa-fw"></i>  <strong>Last Login: </strong><?php echo $last_login; ?></span>
				</div>
			</div>
		</div>
		
		<div class="row">
			
			<div class="dashboard">
			
				<p>Welcome <?php echo ucwords($user->first_name); ?>,</p>
			
				<div class="floating-alert-box"></div>
				<div class="notif"></div>
				
				<div class="tabs-custom">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#tab_content1" id="orders-tab" role="tab" data-toggle="tab" aria-expanded="true">MY ORDERS</a>
						</li>
						<li role="presentation" class="">
							<a href="#tab_content2" role="tab" id="account-tab" data-toggle="tab" aria-expanded="false">MY ACCOUNT</a>
						</li>
					</ul>
					
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="orders-tab">
							<div class="row">
								<div class="col-lg-3">
									<ul class="nav nav-pills nav-stacked">
										<li>
											<a href="#" class="orders-tab">
												<i class="fa fa-list-alt" aria-hidden="true"></i>
												View Order History	
												
											</a>
										</li>
										<li>
											<a href="#" class="transactions-tab">
												<i class="fa fa-share-square-o" aria-hidden="true"></i>
												View Transactions
												
											</a>
										</li>
										<li class="menu-link">
											<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/wishlist/'" title="Wishlist">
												<i class="fa fa-heart" aria-hidden="true"></i>
												Wishlist
												
											</a>
										</li>
									</ul>
								</div>
								<div class="col-lg-9">
								
									<!-- #order-history -->
									<div id="order-history">
										<h3>Order History</h3>
										<!-- table-responsive -->
										<div class="table-responsive" >
											<table id="orders-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Reference</th>
														<th>Price</th>
														<th>Status</th>
														<th>Date</th>
														
													</tr>
												</thead>
												<tbody>
												</tbody>
												 
											</table>
										</div>
										<!-- /table-responsive -->
										
									</div>
									<!-- #order-history -->
									
									<!-- #transactions -->
									<div id="transactions">
										<h3>Transactions</h3>
										<!-- table-responsive -->
										<div class="table-responsive" >
											<table id="transactions-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Reference</th>
														<th>Description</th>
														<th>Amount</th>
														
														<th>Date</th>
														
													</tr>
												</thead>
												<tbody>
												</tbody>
												 
											</table>
										</div>
										<!-- /table-responsive -->
										
									</div>
									<!-- /#transactions -->
									
								</div>
							</div>
							
						
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="account-tab">
							<div class="row">
								<div class="col-lg-3">
									<ul class="nav nav-pills nav-stacked nav-account">
										<!-- <li>
											
												<a href="javascript:void(0)" class="default-address-tab" onclick="defaultUserDetails();">
													<span class="icon-box">
														<i class="fa fa-check" aria-hidden="true"></i>
													</span>
													<?php echo ucwords($user->first_name.' '.$user->last_name); ?>
													<span class="pull-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
												</a>
											
										</li> -->
										<?php
											if($default_address_array){
												
												foreach($default_address_array as $default){
													
													$default_name = ucwords($default->first_name.' '.$default->last_name).' (Default)';
													$default_phone = $default->phone;
													
													//check if default address is set
													if($default->address_line_1 == ''){
														
														$default_address = '<a href="#" class="add-address-link">Add Address</a>';
														
													}else{
														
														$default_address = $default->address_line_1.'<br/>';
														if($default->address_line_2 != ''){
															$default_address .= $default->address_line_2.'<br/>';
														}
														$default_address .= $default->city.', '.$default->state.', '.$default->country.'<br/>';
														$default_address .= $default->postcode;
													}
																				
													$first_name = $default->first_name;
													$last_name = $default->last_name;
													$email_address = $this->session->userdata('email');
													$company_name = $default->company_name;						
													$phone = $default->phone;						
													$address_line_1 = $default->address_line_1;					
													$address_line_2 = $default->address_line_2;		
													$city = $default->city;						
													$postcode = $default->postcode;
													$country = $default->country;	
													$state = $default->state;
													
										?>
										<li>
											<a href="javascript:void(0)" class="user-address-tab" onclick="getDefaultAddress(<?php echo $default->id ; ?>);">
												<i class="fa fa-check" aria-hidden="true"></i> 
												<?php echo ucwords($default->first_name.' '.$default->last_name);?>
											</a>
										</li>
										<?php
												}
											}
										?>
										
										<?php
																	
											if($secondary_addresses_array){
												foreach($secondary_addresses_array as $add){
													
													$icon = '<i class="fa fa-user" aria-hidden="true"></i>';
													
													if($first_name != $add->first_name && $last_name != $add->last_name){
														
														if(empty($default_address_array)){
															
															$icon = '<i class="fa fa-check" aria-hidden="true"></i>';		
															
															$default_name = ucwords($add->first_name.' '.$add->last_name).' (Default)';
															
															$default_phone = $add->phone;
																						
															//check if default address is set
															if($add->address_line_1 == ''){
																$default_address = '<a href="#" class="add-address-link">Add Address</a>';
															}else{
																
																$default_address = $add->address_line_1.'<br/>';
																
																if($add->address_line_2 != ''){
																	$default_address .= $add->address_line_2.'<br/>';
																}
																$default_address .= $add->city.', '.$add->state.', '.$add->country.'<br/>';
																
																$default_address .= $add->postcode;
															}
																					
															$first_name = $add->first_name;
															$last_name = $add->last_name;
															$email_address = $this->session->userdata('email');
															$company_name = $add->company_name;						
															$phone = $add->phone;
															$address_line_1 = $add->address_line_1;					
															$address_line_2 = $add->address_line_2;		
															$city = $add->city;						
															$postcode = $add->postcode;
															$country = $add->country;	
															$state = $add->state;
																						
														}
						
													
													
							
										?>
										<li>
											<a href="javascript:void(0)" class="user-address-tab" onclick="getAddressDetails(<?php echo $add->id ; ?>);">
												<?php echo $icon; ?>
												<?php echo ucwords($add->first_name.' '.$add->last_name);?>
											</a>
										</li>
										
										<?php
													}
												}
											}
										?>
										
										<li>
											<a href="javascript:void(0)" class="add-address-tab">
												<i class="fa fa-list-alt" aria-hidden="true"></i>
												Add New Address	
												
											</a>
										</li>
										<li>
											<a href="javascript:void(0)" class="change-password-tab">
												<i class="fa fa-share-square-o" aria-hidden="true"></i>
												Change your password
												
											</a>
										</li>
										
									</ul>
							
								</div>
								<div class="col-lg-9">
									<!-- .default -->
									<div class="default-address">
										<div class="row">
											<div class="col-lg-1 col-xs-2" align="right">
												<h4><i class="fa fa-user" aria-hidden="true"></i></h4>
											</div>
											<div class="col-lg-7 col-xs-6">
												<h4><span id="user-name"><?php echo $default_name; ?></span></h4>
											</div>
											<div class="col-lg-4 col-xs-4">
												<span class="pull-right">
													<a href="#" class="btn btn-default btn-xs" id="edit-address"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a>
													<?php $delete_button; ?>
													<a data-toggle="modal" data-target="#deleteAddressModal" href="#" class="btn btn-default btn-xs" id="delete-button" onclick="deleteAdd();"><i class="fa fa-trash-o" aria-hidden="true"></i> DELETE</a>
												</span>
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-1 col-xs-2" align="right">
												<h4><i class="fa fa-home" aria-hidden="true"></i></h4>
											</div>
											<div class="col-lg-11 col-xs-10">
												<h4><span id="user-address"><?php echo $default_address; ?></span></h4>
											</div>
											
										</div>
										<?php 
											//$phone = ''; 
											if($default_phone != ''){
												//$phone = $user->phone;
										?>
										<div class="row">
											<div class="col-lg-1 col-xs-2" align="right">
												<h4><i class="fa fa-phone-square" aria-hidden="true"></i>
												</h4>
											</div>
											<div class="col-lg-11 col-xs-10">
												<h4>
													<span id="user-phone">
														<?php echo $default_phone; ?>
													</span>
												</h4>
											</div>
											
										</div>
										<?php }?>
									</div>
									<!-- /.default -->
									
									<div class="form-errors"></div>
										
									<!-- .add-address -->
									<div class="add-address-form">
									
										<!-- . -->
										<div class="">
											
											<form action="<?php echo base_url('account/add-address'); ?>" id="addAddressForm" name="addAddressForm" class="" method="post" enctype="multipart/form-data">
											<!-- table-responsive -->
											<div class="table-responsive" >
												<table class="table" cellspacing="0" width="100%">
													<tr>
														<td width="50%">
															<div class="form-group">
																<label class="">First Name</label>
																<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
																<input type="hidden" name="email" id="email" value="<?php echo $email_address; ?>">
																<input type="hidden" name="addressID" id="addressID" >
																<input type="hidden" name="defaultAdd" id="defaultAdd" >
															</div>
															
														</td>
														<td width="50%">
															<div class="form-group">
																<label class="">Last Name</label>
																<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
															</div>
															
														</td>
													</tr>
													
													<tr>
														<td>
															<div class="form-group">
																<label class="">Company Name</label>
																<input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo $company_name; ?>">
															</div>
															
														</td>
														<td>
															<div class="form-group">
																<label class="">Phone</label>
																<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>">
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-group">
																<label class="">Address 1</label>
																<input type="text" class="form-control" name="address_line_1" id="address_line_1" value="<?php echo $address_line_1; ?>">
															</div>
															
														</td>
														<td>
															<div class="form-group">
																<label class="">Address 2</label>
																<input type="text" class="form-control" name="address_line_2" id="address_line_2" value="<?php echo $address_line_2; ?>">
															</div>
															
														</td>
														
													</tr>
													<tr>
														<td>
															<div class="form-group">
																<label class="">City</label>
																<input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>">
															</div>
															
														</td>
														<td>
															<div class="form-group">
																<label class="">Postal/Zip Code</label>
																<input type="text" class="form-control" name="postcode" id="postcode" value="<?php echo $postcode; ?>">
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															
															<div class="form-group">
																<label class="">Country</label>
																<select name="country" id="country" class="form-control select2">
																<option value="0" selected="selected">Select Country</option>
																<?php 
																
																 
																$this->db->from('countries');
																$result = $this->db->get();
																if($result->num_rows() > 0) {
																	foreach($result->result_array() as $row){
																		$default = (strtolower($row['name']) == strtolower($country))?'selected':'';
																		echo '<option value="'.$row['id'].'" '.$default.'>'.$row['name'].'</option>';			
																	}
																}
																
																?>
																</select>
															</div>
														</td>
														<td>
															<div class="form-group">
																<label class="">State</label>
																<select name="state" id="state" class="form-control select2 states">
																	<option value="0" selected="selected">Select State</option>
															<?php 
																$country_id = '';
																//get country id
																$this->db->from('countries');
																$this->db->where('name', $country);
																$result = $this->db->get();
																if($result->num_rows() > 0) {
																	foreach($result->result_array() as $row){
																		$country_id = $row['id'];
																	}
																}
																 
																//get states
																$this->db->from('states');
																$this->db->where('country_id', $country_id);
																$result = $this->db->get();
																if($result->num_rows() > 0) {
																	foreach($result->result_array() as $row){
																		$default = (strtolower($row['name']) == strtolower($state))?'selected':'';
																		echo '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';			
																	}
																}
																
																?>
																</select>
																
															</div>
															
														</td>
													</tr>
													<tr>
														<td>
															<div class="form-group">
																
																<label for="address_default"><input type="checkbox" id="address_default" class="address_default" name="address_default" value="0" checked="checked"/> Set as default address</label>
															</div>
															
														</td>
														<td>
															
														</td>
													</tr>
													
													
													<tr>
														<td>
														<?php
															$button_text = 'UPDATE ADDRESS';
															if($address_line_1 == ''){
																$button_text = 'ADD ADDRESS';
															}
														?>
														<button type="button" class="btn btn-primary btn-1" onclick="javascript:submitAddress();"><i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $button_text; ?></button>
														
														
														<button type="button" class="btn btn-default" onclick="javascript:toggleAddressForm();">CANCEL</button>
														</td>
														<td></td>
													</tr>
													
												</table>
											</div>
											<!-- /.table-responsive -->
											</form>	
										</div>
										
									</div>
									<!-- /.add-address -->
									
									<!-- .change-password -->
									<div class="change-password">
									
										<!-- .verify-password -->
										<div class="verify-password">
										<p>To change your password, you need to confirm your current password below: </p>
											<?php
												$verify_password = array(
													'name' => 'verifyPasswordForm',
													'id' => 'verifyPasswordForm',
													'class' => ''
												);
												echo form_open('account/verify-password',$verify_password);
												echo form_error('current_password');
											?>
											<div class="form-group">
												<label class="">Current Password</label>
												<input type="password" class="form-control" name="current_password" id="current_password">
												
											</div>
											<p align="left"><input class="toggleBtn" type="checkbox" onclick="passwordToggle()"> <span class="toggleText">Show Password</span></p>
											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Confirm</button>
											</div>
											
											
											<?php
												echo form_close();
											?>
										</div>
										<!-- /.verify-password -->
										
										<!-- .password-change -->
										<div class="password-change">
											<div class="password-notif"></div>
										<p>You can set up a new password below: </p>
											<?php
												$change_password = array(
													'name' => 'changePasswordForm',
													'id' => 'changePasswordForm',
													'class' => ''
												);
												echo form_open('account/change-password',$change_password);
											?>
											<div class="form-group">
												<label class="">New Password</label>
												<input type="password" class="form-control" name="new_password" id="new_password">
												
											</div>
											<div class="form-group">
												<label class="">Confirm Password</label>
												<input type="password" class="form-control" name="confirm_password" id="confirm_password">
												
											</div>
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Confirm</button>
											</div>
											
											
											<?php
												echo form_close();
											?>
										</div>
										<!-- /.password-change -->
									</div>
									<!-- /.change-password -->
									
								</div>
							</div>
							
						</div>
					</div>
				</div>

			
			</div>
		</div>
		
	<?php   
			}
		}								
	?>
			
			
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


		
			<!-- Delete Modal -->
			<div class="modal fade" id="deleteAddressModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				<form action="<?php echo base_url('account/delete_address'); ?>" id="deleteAddressForm" name="deleteAddressForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
				
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Delete Address?
					<div id="delete-errors"></div>
				  </div>
				  <div class="modal-body">
				  
					<strong>Are you sure you want to delete this (<i><span id="address-name"></i></span>) address?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="addID" id="addID">
					<input type="button" onclick="deleteAddress()" class="btn btn-danger" value="Delete">
				  </div>
				  </form>
				</div>
			  </div>
			</div>
			
			
			
			
		
		
	<!-- View Order -->
	<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
					
					<div id="view-details"></div>
					<br/>
							
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Order -->	
			
			

				