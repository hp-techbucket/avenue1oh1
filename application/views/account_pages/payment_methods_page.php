
<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pageTitle;?> <small></small>
                        </h1>
                        <ol class="breadcrumb">
							<li>
                                 <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li class="active">
                                <i class="fa fa-credit-card"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
<div>
<?php
	//handles success message display
		$message = '';
		if($this->session->flashdata('cc_added') != ''){
			$message = $this->session->flashdata('cc_added');
		}	
		if($this->session->flashdata('deposit_message') != ''){
			$message = $this->session->flashdata('deposit_message');
		}
		if($this->session->flashdata('paypal_added') != ''){
			$message = $this->session->flashdata('paypal_added');
		}		
		if($this->session->flashdata('paypal_updated') != ''){
			$message = $this->session->flashdata('paypal_updated');
		}
		echo $message;
?>
</div>	
				
			<div class="container-fluid">	
                <div class="row">
                    <div class="col-lg-12" >
					
					<div id="notif"></div>		
					<div id="errors"></div>		<br/>				
					
					<div class="text-center"><a class="active btn btn-default">Make Payments</a> <a data-toggle="modal" data-target="#withdrawalModal" class="btn btn-default wihdrawal-btn" id="<?php echo html_escape($user->username); ?>">Make Withdrawals</a></div><br/><br/><br/>
						<div class="paypalDiv">
							<h4>My PayPal <i class="fa fa-angle-double-down"></i></h4>
						</div>
						<?php echo br(1); ?>
									
								<?php
									if($paypal_array){				
										foreach($paypal_array as $paypal){	

											$thisRandNum = md5(uniqid());
								?>	
								<div class="paypalDepositDiv">	
									<span class="pull-left">
										<img src="<?php echo base_url(); ?>assets/images/icons/paypal.png" />
									</span>
									<span>
									<?php echo $this->Users->email_mask($paypal->PayPal_email); ?>
									</span>
									<a data-toggle="modal" data-target="#paypaldepositModal" class="btn btn-primary btn-responsive paypal_deposit"  id="<?php echo html_escape($paypal->id);?>" title="PayPal Deposit"><i class="fa fa-paypal"></i> Deposit</a>
									
									<?php echo nbs(2); ?>
									<span class="hiddenIcons">
									<a data-toggle="modal" data-target="#editPayPalModal" class="edit_paypal"  id="<?php echo html_escape($paypal->id);?>" title="Edit Payment Details"><i class="fa fa-pencil"></i> Edit</a>
									<?php echo nbs(2); ?>
									<a data-toggle="modal" data-target="#removePayPalModal" class="remove_paypal"  id="<?php echo html_escape($paypal->id);?>" title="Remove Payment Details"><i class="fa fa-trash-o"></i> Remove</a>
									
									</span>
								</div>	
								
					
								<?php
										}
									}
								  ?>	
<hr/>	
		
								<div id="deposit-success"></div>	
								<div class="ccDiv">
									<h4>My Credit Cards <i class="fa fa-angle-double-down"></i></h4>
								</div>
								<?php echo br(1); ?>
								<?php
									if($card_methods_array){				
										foreach($card_methods_array as $card){
											
											$thisRandNum = md5(uniqid());		
								?>	
								<div class="ccListDiv">	
									<span class="pull-left">
										<img src="<?php echo base_url(); ?>assets/images/icons/credit_cards.png" />
									</span>
									<span>
										<strong><?php echo nbs(2).'XXXX-XXXX-XXXX-'.substr($card->card_number,-4); ?></strong>
									</span>
									<a data-toggle="modal" data-target="#carddepositModal" class="btn btn-success btn-responsive card_deposit"  id="<?php echo html_escape($card->id);?>" title="Deposit"><i class="fa fa-credit-card"></i> Deposit</a>

								<?php echo nbs(2); ?>
									<span class="hiddenIcons">
										<a data-toggle="modal" data-target="#editcardModal" class="edit_card"  id="<?php echo html_escape($card->id);?>" title="Edit Payment Details"><i class="fa fa-pencil"></i> Edit</a>
										<?php echo nbs(2); ?>
										<a data-toggle="modal" data-target="#removecardModal" class="remove_card"  id="<?php echo html_escape($card->id);?>" title="Remove Payment Details"><i class="fa fa-trash-o"></i> Remove</a>
									
									</span>
								
								</div>							
					
								<?php
										}
									}
								  ?>	
		<hr/>							  
								<div id="cashdeposit-success"></div>					  
								<div class="cashDiv">
									<span class="pull-left">
										<img src="<?php echo base_url('assets/images/icons/cashdirect.jpg'); ?>" class="img-responsive img-rounded" id="cash_direct" width="180" height="30"/>
									</span>
								</div>
								
								<?php echo br(3); ?>
								
								<div class="cashDepositDiv">
									<a data-toggle="modal" data-target="#cashdirectModal" class="btn btn-default cashdirect" title="Cash Direct Deposit"><i class="fa fa-money"></i> Deposit</a>
									
								</div>
                    </div>
                </div>
                <!-- /.row -->
			</div>
			
			<?php echo br(1); ?>
			
			<hr/>
			
			
            <div class="container-fluid">
			
				
				<p>You can securely add funds required for purchases to your account wallet. The funds will be held securely until you decide to use or withdraw the funds.</p>
				<hr/>
						
						<?php 
						$addPayPalDiv = 'addPayPalDiv';
						$addCCDiv = 'addCCDiv';
						
						if(form_error('paypal_email')){
							echo '<div class="alert alert-error">Please correct the errors below!</div>';
							$addPayPalDiv = 'addDiv';
						}
						if(validation_errors()){
							echo '<div class="alert alert-error">Please correct the errors below!</div>';
							$addCCDiv = 'addDiv';
						}

						?>		

<div id="success"></div>	
<div class="log"></div>
<div class="text-center"><a class="btn btn-success addCCButton"  ><i class="fa fa-credit-card"></i> Add Credit Card</a> <a class="btn btn-primary addPPButton"><i class="fa fa-paypal"></i> Add PayPal</a> </div><br/>
				
				<div class="<?php echo $addCCDiv; ?>">	
						<?php
					
						
						$nameError = '';
						$numberError = '';
						$monthError = '';
						$yearError = '';
						$cvcError = '';
						$addressError = '';
						$cityError = '';
						$postcodeError = '';
						$stateError = '';
						$countryError = '';

							
							if(form_error('name_on_card')){
								$nameError = 'inputError';
							}
							if(form_error('card_number')){
								$numberError = 'inputError';
							}		
							if(form_error('expiry_month')){
								$monthError = 'inputError';
							}	
							if(form_error('expiry_year')){
								$yearError = 'inputError';
							}	
							if(form_error('card_cvc')){
								$cvcError = 'inputError';
							}	

							if(form_error('card_billing_street_address')){
								$addressError = 'inputError';
							}
							if(form_error('card_billing_city')){
								$cityError = 'inputError';
							}
							if(form_error('card_billing_postcode')){
								$postcodeError = 'inputError';
							}
							if(form_error('card_billing_state')){
								$stateError = 'inputError';
							}
							if(form_error('card_billing_country')){
								$countryError = 'inputError';
							}
						$creditform = array(
							'name' => 'addCreditCardForm',
							'id' => 'addCreditCardForm',
						);
						
						//echo form_open('payment/add_credit_card',$creditform);				
						
						?>
						<form action="javascript:addCreditCard();" id="addCreditCardForm" name="addCreditCardForm" method="post">
			 
						<h4>CREDIT CARD</h4>
						<div class="row">
							<div class="col-xs-3">
								
								<label for="card_type">Card Type</label><br/>
								<?php echo $card_types; ?>
							</div>
							<div class="col-xs-4">
								
								<label for="accepted_cards">Accepted Cards</label>		
								<div class="pull-left" id="accepted-cards-images">
									<img src="<?php echo base_url('assets/images/icons/visa.png'); ?>" class="img visa"/>
									<img src="<?php echo base_url('assets/images/icons/mastercard.png'); ?>" class="img mastercard"/>
									<img src="<?php echo base_url('assets/images/icons/amex.png'); ?>" class="img amex"/>
									<img src="<?php echo base_url('assets/images/icons/diners.png'); ?>" class="img diners"/>
									<img src="<?php echo base_url('assets/images/icons/discover.png'); ?>" class="img discover"/>
									<img src="<?php echo base_url('assets/images/icons/jcb.png'); ?>" class="img jcb"/>
									<img src="<?php echo base_url('assets/images/icons/maestro.png'); ?>" class="img maestro"/>
								</div>
							</div>							
							
						</div>
						<p>
							<div class="row">
								<div class="col-xs-3">
									
									<label for="name_on_card">Name on Card</label><br/>
									<input type="text" name="name_on_card" class="<?php echo $nameError; ?>" id="name_on_card" size="50" placeholder="John Doe" required>
						
								</div>
								<div class="col-xs-3">
									
									<label for="card_number">Card Number</label><br/>
									<input type="text" name="card_number" id="card_number" class="<?php echo $numberError; ?>" size="50" placeholder="1234567891011231" onkeypress="return allowNumbersOnly(event)" required>
									
								</div>
								<div class="col-xs-2">
									
									<label for="expiry_month">Expiry Month</label><br/>
									<?php echo $expiry_month; ?>
								</div>
								<div class="col-xs-2">
								
									<label for="expiry_year">Expiry Year</label><br/>
									<?php echo $expiry_year; ?>
								</div>
							</div>						
						</p>
						<p>
							<div class="row">
								<div class="col-xs-6">
									
									<label for="card_billing_street_address">Billing Address</label><br/>
									<input type="text" name="card_billing_street_address" id="card_billing_street_address" class="<?php echo $addressError; ?>" placeholder="No. 12 Milton Road" required>
								</div>
								
							</div>							
						</p>
						
						
							<div class="row">
								<div class="col-xs-2">
									
									<label for="country_id">Country</label><br/>
									<?php echo $country_options; ?>
								</div>
								<div class="col-xs-2">
									
									<label for="states">State</label><br/>
									<select name="card_billing_state" class="states" id="states" >
										<option value="0">Select State</option>
									</select>
								</div>
								<div class="col-xs-2">
									
									
									<label for="cities">City</label><br/>
									<div id="city">
										<select name="card_billing_city" class="cities" id="cities" >
											<option value="0">Select City</option>
										</select>
										<input type="text" name="card_billing_city" class="billing_city" >
									</div>
									<label><a class="manual_city_entry" > Enter City manually</a></label><br/>
									
								</div>
							
								<div class="col-xs-2">
									
									<label for="card_billing_postcode">Postcode</label><br/>
									<input type="text" name="card_billing_postcode" id="card_billing_postcode" value="<?php echo set_value('card_billing_postcode'); ?>" class="<?php echo $postcodeError; ?>" placeholder="W1C 4ER" required>
								</div>								
							</div>						
					
					<br/>
					<div><button type="button" class="btn btn-default" onclick="javascript:addCreditCard();">Add Credit Card</button></div>	

					<?php echo form_close(); ?>		
				
					<hr/>
		<br/>
				</div>	
				<div class="<?php echo $addPayPalDiv; ?>">	
				<?php
						$paypalError = '';
						
						if(form_error('paypal_email')){
							$paypalError = 'inputError';
						}
						$form_attr = array(
							'name' => 'paypalForm',
							'id' => 'addpaypalForm',
							'class' => 'addpaypalForm',
						);
						echo form_open('payment/add_paypal', $form_attr);
				?>
				<h4>PayPal</h4>
						<p>
						<div class="row">
								<div class="col-xs-6">
									<input type="text" name="paypal_email" value="<?php echo set_value('paypal_email'); ?>" class="<?php echo $paypalError; ?>" id="paypal_email" size="50" placeholder="Enter your PayPal Email address here" />
								</div>
								<div class="col-xs-1">
									<img src="<?php echo base_url(); ?>assets/images/icons/paypal.png" />
								</div>
								<div class="col-xs-2">
									<button type="button" class="btn btn-default" onclick="javascript:addPayPal();">Add PayPal</button>
									
								</div>
						</div>		
						
						
						
						</p>
						<div></div>	
				</div>
					<?php echo form_close(); ?>	
					<hr/>
						
					<h4>Task Credit balance:</h4>	
					<h3>$<?php echo number_format($user->account_balance, 0);?></h3>				
				
			</div>
<?php
		
		echo br(15);
?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php   
		}
	}			
//define form attributes
			
?>

		<!-- Deposit via PayPal -->
		<div class="modal fade" id="paypaldepositModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<?php 
				$attributes = array(
					'name' => 'paypalDepositForm',
					'class' => 'form-inline',
					'id' => 'paypalDepositForm',
				);			
				//start form
				echo form_open('payment/paypal_process', $attributes);	
				$hidden = array('id' => 'paypal_id',);	
				echo form_hidden($hidden);
			?>
			<div class="modal-dialog" role="document">
				<div class="modal-content" align="center">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Deposit via <img src="<?php echo base_url('assets/images/icons/paypal.png'); ?>" /></h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					
						<div class="form-group pull-left" >
							
							<div class="input-group">
							  <div class="input-group-addon">$</div>
							  <input type="text" name="amount" class="form-control newDeposit" onkeypress="return allowNumbersOnly(event)" placeholder="Amount" required>
							  <div class="input-group-addon">.00</div>
							  
							</div>
							<span class="depositNote">Please enter your deposit!</span>
						</div>
						<br/>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<span class="pull-left">
						<input type="submit" class="btn btn-primary paypalDeposit" value="Deposit">
						<input type="button" class="btn btn-primary" onclick="javascript:paypalDeposit();" value="Make Deposit">
					</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				  </div>
				</div>
			  </div>
			  <?php echo form_close(); ?>	
			</div>	
		<!-- Deposit via PayPal -->
		
		

		<!-- Edit PayPal -->
			<div class="modal fade" id="editPayPalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <?php 
				$attr = array(
					'name' => 'editPayPalForm',
					'id' => 'editPayPalForm',
				);			
				//start form
				echo form_open('payment/update_paypal', $attr);	
				
			?>
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Edit PayPal</h3>
					<div id="alert-message"></div>
				  </div>
				  <div class="modal-body">
						<div class="form-group" >
							<?php echo form_label('PayPal', 'paypal_email'); ?>
							<div class="input-group">
							  <div class="input-group-addon"><i class="fa fa-paypal"></i></div>
							  <input type="text" class="form-control" name="paypal_email" id="masked_paypal_email">
							  <input type="hidden" name="id" id="paypalID">
							</div>
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn btn-primary editPayPal" value="Update PayPal">
					<input type="button" class="btn btn-primary" onclick="javascript:editPayPal();" value="Update">
				  </div>
				</div>
			  </div>
			  <?php echo form_close(); ?>
			</div>	
		<!-- /Edit PayPal -->
		
		
		<!-- Remove Paypal -->
		<div class="modal fade" id="removePayPalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<form action="javascript:removePayPal();" id="removePayPal_form" name="removePayPalForm" method="post">  
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Remove?</h3>
				  </div>
				  <div class="modal-body text-center">
						<p>
						Are you sure you want to remove this account (<span id="paypalhead"></span>)?
						<input type="hidden" name="paypEmail" id="paypEmail"/>
						<input type="hidden" name="id" id="paypID">
						</p>

				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-danger" onclick="javascript:removePayPal();" value="Remove PayPal">
				  </div>
				</div>
			  </div>
			  </form>	
			</div>	
	<!-- /Remove Paypal -->
	
		<?php base_url('payment/add_deposit');

		?>
		<!-- Deposit via Card -->
		<div class="modal fade" id="carddepositModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<?php 
				$attr = array(
					'name' => 'cardDepositForm',
					'id' => 'cardDepositForm',
				);			
				//start form
				echo form_open('payment/card_deposit', $attr);	
				
			?>
			 <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Deposit via Card <img src="<?php echo base_url(); ?>assets/images/icons/credit_cards.png" /></h3>
				  </div>
					<div class="modal-body">
						<div class="card_errors"></div>
					
							<p>
								<div class="row">
									<div class="col-xs-6">
									  <?php echo form_label('Name on Card', 'name_on_card'); ?>
									</div>
								</div>
								<input type="text" name="name_on_card" id="card_name" readonly>
							</p>
							<p>
								<div class="row">
									<div class="col-xs-6">
									  <?php echo form_label('Card Number', 'card_number'); ?>
									</div>
								</div>
								
								<input type="text" name="card_number" id="card_number" readonly>
								<input type="hidden" name="id" id="card_id">
								
							</p>

							<p>
								<div class="row">
									<div class="col-xs-3">
									  <?php echo form_label('Expiry Month', 'expiry_month'); ?>
									</div>
									<div class="col-xs-3">
									  <?php echo form_label('Expiry Year', 'expiry_year'); ?>
									</div>
									<div class="col-xs-3">
									  <?php echo form_label('Enter your CVV', 'card_cvv'); ?>
									</div>
								</div>
								<div class="row" align="center">
									
									<div class="col-xs-3">
										
										<input type="text" name="expiry_month" id="expiry_m" readonly>
									</div>
									<div class="col-xs-3">
										
										<input type="text" name="expiry_year" id="expiry_y" readonly>
									</div>
										
									<div class="col-xs-3">
										<input type="text" name="cvc_card" id="cvc_card" onkeypress="return allowNumbersOnly(event)" required>
									</div>	
								</div>
							</p>
			
							<p>
								<?php echo form_label('Amount', 'deposit_amount'); ?>
								<div class="row" >
									<div class="col-xs-6">
										<div class="input-group">
										  <div class="input-group-addon">$</div>
										  <input type="text" name="deposit_amount" class="form-control input-lg depositAmount" onkeypress="return allowNumbersOnly(event)" onclick="return depositAlert()" onkeyup="delayedSubmission()" placeholder="Amount" required>
										  <div class="input-group-addon">.00</div>
										</div>	
									</div>
								</div>
							</p>

						<div id="alert-msg"></div>
					</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="javascript:cardDeposit();">Make Deposit</button>
					<input type="submit" class="btn btn-primary" value="Deposit">
				  </div>
				</div>
			  </div>
			  <?php echo form_close(); ?>	
			</div>	
		<!-- Deposit via Card -->
		

		<!-- Edit Card -->
			<div class="modal fade" id="editcardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<?php 
				$attr2 = array(
					'name' => 'editCardForm',
					'id' => 'editCardForm',
				);			
				//start form
				echo form_open('payment/update_card', $attr2);	
				
			?>
			 
			 <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Edit Card</h3>
					<p class="log"></p>
				  </div>
				  <div class="modal-body">
						<div class="row">
							<div class="col-xs-8">
								<?php echo form_label('Card Number', 'card_number'); ?>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-credit-card"></i></div>
									<input type="tel" class="form-control" name="card_number" id="cardNo" onkeypress="return allowNumbersOnly(event)">
									<input type="hidden" name="id" id="cardID">
									<input type="hidden" name="number" id="card_n">
								</div>
							</div>
							<div class="col-xs-4">
							
							<?php echo form_label('Accepted Cards', 'accepted_cards'); ?>
								
								<div class="pull-left" id="accepted-cards-images">
									<img src="<?php echo base_url('assets/images/cards/visa.png'); ?>" class="img visa"/>
									<img src="<?php echo base_url('assets/images/cards/mastercard.png'); ?>" class="img mastercard"/>
									<img src="<?php echo base_url('assets/images/cards/amex.png'); ?>" class="img amex"/>
									<img src="<?php echo base_url('assets/images/cards/diners.png'); ?>" class="img diners"/>
									<img src="<?php echo base_url('assets/images/cards/discover.png'); ?>" class="img discover"/>
									<img src="<?php echo base_url('assets/images/cards/jcb.png'); ?>" class="img jcb"/>
									<img src="<?php echo base_url('assets/images/cards/maestro.png'); ?>" class="img maestro"/>
								</div>
							</div>							
						</div>
						
					<p>
						<div class="row">
							<div class="col-xs-8">
								<strong><?php echo form_label('Name on Card', 'name_on_card'); ?></strong><br/>
								<input type="text" name="name_on_card" id="cardName" placeholder="John Doe" />
							</div>
							<div class="col-xs-2">
								<strong><?php echo form_label('Expiry Month', 'expiry_month'); ?></strong><br/>
								<span id="e_month"></span>
							</div>
							<div class="col-xs-2">
								<strong><?php echo form_label('Expiry Year', 'expiry_year'); ?></strong><br/>
								<span id="e_year"></span>
							</div>
							
						</div>						
					</p>							
						<p>
						<div class="row">
							<div class="col-xs-8">
								<strong><?php echo form_label('Billing Address', 'card_billing_street_address'); ?></strong><br/>
								<input type="text" name="card_billing_street_address" id="card_billing_street_address" placeholder="No. 12 Milton Road" >
							</div>
							<div class="col-xs-4">
								<strong><?php echo form_label('Billing City', 'card_billing_city'); ?></strong><br/>
								<input type="text" name="card_billing_city" id="card_billing_city" placeholder="London" >
							</div>
						</div>					
						</p>
						<p>
							<div class="row">
								<div class="col-xs-2">
									<strong><?php echo form_label('Postcode', 'card_billing_postcode'); ?></strong><br/>
									<input type="text" name="card_billing_postcode" id="card_billing_postcode" placeholder="W1C 4ER" >
								</div>	
								<div class="col-xs-3">
									<strong><?php echo form_label('State', 'card_billing_state'); ?></strong><br/>
									<input type="text" name="card_billing_state" id="card_billing_state" placeholder="Greater London" >
								</div>	
								<div class="col-xs-3">
									<strong><?php echo form_label('Country', 'card_billing_country'); ?></strong><br/>
									<?php $countries = $this->Countries->get_countries(); ?>
									<input type="text" name="card_billing_country" id="card_billing_country" placeholder="United Kingdom" >
								</div>
							</div>						
						</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn btn-primary" value="Update Card">
					<input type="button" class="btn btn-primary" onclick="javascript:editCard();" value="Update">
				  </div>
				</div>
			  </div>
			  <?php echo form_close(); ?>	
			</div>	
		<!-- /Edit Card -->
		
		<!-- Remove Card -->
		<div class="modal fade" id="removecardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<form action="javascript:removeCard();" id="removeCard_form" name="removeCardForm" method="post">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Remove Card (<span id="ccHead"></span>)?</h3>
				  </div>
				  <div class="modal-body text-center">
						<p>
						Are you sure you want to remove <span id="card"></span>?
						<input type="hidden" name="cardNo" id="cardNo"/>
						<input type="hidden" name="id" id="cdID">
						</p>

				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-danger" onclick="javascript:removeCard();" value="Remove">
				  </div>
				</div>
			  </div>
			  </form>
			</div>		
	<!-- /Remove Card -->
	
	

		<!-- Deposit via CashDirect -->
			<div class="modal fade" id="cashdirectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<?php 
				$attr3 = array(
					'name' => 'cashDirectForm',
					'id' => 'cashDirectForm',
				);			
				//start form
				echo form_open('payment/cashdirect', $attr3);	
				
			?>
			 
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Deposit via <img src="<?php echo base_url('assets/images/icons/cashdirect.jpg'); ?>" /></h3>
				  </div>
					<div class="modal-body">
						<div class="cashdirect_errors"></div>
					
							<p>
								<?php echo form_label('Voucher Number (19 digit)', 'voucher_number'); ?>
								<div class="row">
									<div class="col-xs-8">
									  
									  <input type="text" name="voucher_number" id="voucher_number" value="65872" onkeypress="return allowNumbersOnly(event)" placeholder="65872 00 3242 1229" >
									</div>
								</div>
								
							</p>
			
							<p>
								<?php echo form_label('Voucher Amount', 'voucher_amount'); ?>
								<div class="row" >
									<div class="col-xs-5">
										<div class="input-group">
										  <div class="input-group-addon">$</div>
										  <input type="text" name="voucher_amount" id="voucher_amount" class="form-control input-lg" onkeypress="return allowNumbersOnly(event)" onclick="return depositAlert()" onkeyup="delayedSubmission()" placeholder="Amount" required>
										  <div class="input-group-addon">.00</div>
										</div>
										
									</div>
									<div class="col-xs-3">
										
										<input type="button" class="btn btn-primary btn-lg" onclick="javascript:cashDirectDeposit();" value="Deposit">
									</div>
								</div>
							</p>

						
					</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

				  </div>
				</div>
			  </div>
			  <?php echo form_close(); ?>	
			</div>	
		<!-- Deposit via CashDirect -->
		
		