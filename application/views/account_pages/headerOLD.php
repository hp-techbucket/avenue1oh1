<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $pageTitle; ?>">
    <meta name="author" content="">
	<?php echo link_tag('assets/images/logo/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <title>Avenue 1-OH-1 | <?php echo $pageTitle; ?></title>
	<?php echo link_tag('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
	<?php echo link_tag('assets/css/bjqs.css'); ?>
    <?php echo link_tag('assets/css/sb-admin.css'); ?>
    <?php echo link_tag('assets/css/style.css'); ?>

    <!-- Fonts Awesome-->
    <?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
</head>

<body id="<?php echo $pageID;?>">
	
<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
		
?>

	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
			  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo base_url();?>account/dashboard/">Avenue 1-OH-1</a>
			</div>
			<nav class="collapse navbar-collapse" role="navigation">
					<!-- Top Menu Items -->
					<ul class="nav navbar-right top-nav">
						<li>
							<a title="Play" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>quiz/'"><i class="fa fa-play" aria-hidden="true"></i> Play</a>
						</li>					
									
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
								<ul class="dropdown-menu message-dropdown">
								<?php
									//check messages array for messages to display			
									if(!empty($header_messages_array)){			
										//obtain each row of message
										foreach ($header_messages_array as $message){			

											if($message->sender_name == 'Admin'){
												$senderThumbnail = '<img class="media-object" src="http://placehold.it/50x50" width="20" height="20" alt="">';
											}


					?>					
									<li class="message-preview">
										<a data-toggle="modal" data-target="#headerMessageModal" class="detail-message" id="<?php echo $message->id;?>">
											<div class="media">
												<span class="pull-left">
													<img class="media-object" src="http://placehold.it/50x50" width="20" height="20" alt="">
												</span>
												<div class="media-body">
													<h5 class="media-heading"><strong><?php echo $message->sender_name;?></strong>
													</h5>
													<p class="small text-muted"><i class="fa fa-clock-o"></i> <?php echo date("F j, Y", strtotime($message->date_sent));?></p>
													<p class="ellipsis"><?php echo $message->message_details;?></p>
												</div>
											</div>
										</a>
									</li>
					<?php
										}		
									}
									//	close the message form
					?> 
									<li class="message-footer">
										<a title="Read All" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>message/inbox/'">Read All New Messages</a>
									</li>
								</ul>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-money"></i> Statements <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a title="Payment Methods" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/payment_methods/'"><i class="fa fa-file-text-o" aria-hidden="true"></i> Payment Methods</a>
								</li>
								<li class="divider"></li>
								<li>
									<a title="Payments" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/payments/"><i class="fa fa-money" aria-hidden="true"></i> Payments</a>
								</li>
								<li class="divider"></li>
								
								<li>
									<a title="Statements" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/statements/"><i class="fa fa-exchange" aria-hidden="true"></i> Statements</a>
								</li>
								
							</ul>
						</li>
						<li>
							<a title="Store" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>store/'"><i class="fa fa-building"></i> Store</a>
						</li>
						
						<li>
							<a title="Cart" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>store/cart/'"><i class="fa fa-shopping-cart"></i> <span class="badge" id="cart_contents"><?php echo $cart_count ;?></span></a>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user->first_name .' '. $user->last_name[0].'.' ; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a title="Profile" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/profile/'"><i class="fa fa-fw fa-user"></i> Profile</a>
								</li>
								<li>
									<a title="<?php echo $messages_unread ;?> Unread Messages" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/messages/'" ><i class="fa fa-fw fa-envelope"></i> Inbox<span class="badge"><?php echo $messages_unread ;?></span></a>
								</li>
								
								<li class="divider"></li>
								<li>
									<a title="Log Out" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/logout/'" title="Log Out"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
								</li>
							</ul>
						</li>
					</ul>
			</nav>
		</div>

	<!-- /.navbar-collapse -->
	</nav>

<?php   
		}
	}								
?>



	<div class="cart-container">
		<div class="shopping-cart">
			<div class="scrollable-cart">
				
				<?php
				$cartTotal = "";
				$pp_checkout_btn = '';
				$product_id_array = '';
				if(!empty($_SESSION["cart_array"])){
					$i = 0;
					foreach($_SESSION["cart_array"] as $each_item){
															
						$item_id = $each_item['product_id'];
															
						$query = $this->db->get_where('products', array('id' => $item_id));
															
						$product_name = '';
						$product_image = '';
						$price = '';
						$details = '';
						if($query){
							foreach ($query->result() as $row){
								$product_image = $row->image;
								$product_name = $row->name;
								$price = $row->price;
								$details = $row->description;
							}							
						}
						$pricetotal = $price * $each_item['quantity'];
						$pricetotal = sprintf("%01.2f", $pricetotal);
						$cartTotal = $pricetotal + $cartTotal;
															
						// Dynamic Checkout Btn Assembly
						$x = $i + 1;
						
						$thumbnail = '';
						$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
						if(file_exists($filename)){
							$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive img-rounded" width="50" height="60" alt="item'.$item_id.'"/>';
						}else if($product->image == '' || $product->image == null || !file_exists($filename)){
							$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="50" height="60" alt="item'.$item_id.'" />';
						}else{
							$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive img-rounded" width="50" height="60" alt="item'.$item_id.'" />';
						}
				?>
					<div class="row shopping-cart-items">
						<div class="col-xs-3">
							<?php echo $thumbnail ; ?>
						</div>
						<div class="col-xs-9">
							<span class="item-name"><?php echo $product_name ; ?></span>
							<span class="item-price">$<?php echo $price ; ?></span>
							<span class="item-quantity">Quantity: <?php echo $each_item['quantity'] ; ?></span>
						</div>
					</div>
					  
					  
				<?php
						$i++;
					}
					$cartTotal = '$'.sprintf("%01.2f", $cartTotal);
				?>
				
				
				<div class="row shopping-cart-header">
					<div class="col-xs-12">
						<i class="fa fa-shopping-cart cart-icon"></i><span class="cart-badge"><?php echo $cart_count ;?></span>
						<div class="shopping-cart-total">
							<span class="lighter-text">Total:</span>
							<span class="main-color-text"><?php echo $cartTotal; ?></span>
						</div>
					</div>
				</div> <!--end shopping-cart-header -->
					 <?php  
				}
			?>
				
				
			</div>
			<div class="row cart-buttons">
				<div class="col-xs-6">
					<a title="View Cart" href="javascript:void(0)" onclick="location.href='<?php echo base_url('store/cart/');?>'" class="btn btn-success btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> View Cart</a>
				</div>
				<div class="col-xs-6">
					<a title="Checkout" href="javascript:void(0)" onclick="location.href='<?php echo base_url('store/checkout/');?>'" class="btn btn-primary btn-block">Checkout</a>
				</div>
			</div>
		</div> <!--end shopping-cart -->
	</div> <!--end container -->
		
		
		
		
			<div class="modal fade" id="headerMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3><span id="show_subject"></span></h3>
				  </div>
				  <div class="modal-body message-preview">
						
						<div class="row">
							<div class="col-xs-12">
								<strong>From: </strong>
								<span id="show_name"></span>
								<br/>
								
								<div class="panel panel-default">
									<div class="panel-body">
										<span id="show_message"></span>
									</div>
								</div>
								<small class="pull-right"><span id="show_date"></span></small>
							</div>
						</div>
				
				  </div>

				</div>
			  </div>
			</div>	
			
			<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Deposit Funds</h3>
				  </div>
					<div class="modal-body">
						
						<div class="row">
							<div class="col-xs-4">
								<div id="card-deposit-logo" align="center"><img src="<?php echo base_url(); ?>assets/images/icons/credit_cards.png" /></div>
								
								<div id="cash-deposit-logo" align="center"><img src="<?php echo base_url('assets/images/icons/cashdirect.jpg'); ?>" /></div>
								
								<div id="paypal-deposit-logo" align="center"><img src="<?php echo base_url('assets/images/icons/paypal.png'); ?>" /></div>
							</div>
							<div class="col-xs-8">
								<div class="scrollable">
									<!-- Deposit via Card -->
									<div id="card-deposit-show">
										<h3 align="center"><img src="<?php echo base_url(); ?>assets/images/icons/credit_cards.png" /></h3>
										
										<?php 
											$attr = array(
												'name' => 'cardDepositForm',
												'id' => 'cardDepositForm',
											);			
											//start form
											echo form_open('payment/card_deposit', $attr);	
											
										?>
											
												<p>
													<div class="row">
														<div class="col-xs-12">
															<select name="user-cards" id="user-cards">
																<option value=""></option>
															</select>
														</div>
													</div>
													
												</p>
												<p>
													<div class="row">
														<div class="col-xs-6">
														  <?php echo form_label('Name on Card', 'name_on_card'); ?>
														  <input type="text" name="name_on_card" id="card_name" readonly>
														</div>
														<div class="col-xs-3">
														  <?php echo form_label('Expiry Month', 'expiry_month'); ?>
														  <input type="text" name="expiry_month" id="expiry_m" readonly>
														</div>
														<div class="col-xs-3">
														  <?php echo form_label('Expiry Year', 'expiry_year'); ?>
														  <input type="text" name="expiry_year" id="expiry_y" readonly>
														</div>
													</div>
													
												</p>
												
												<p>
													<div class="row">
														<div class="col-xs-3">
														  <?php echo form_label('Enter your CVV', 'card_cvv'); ?>
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
														<div class="col-xs-2">
															<button type="button" class="btn btn-primary" onclick="javascript:cardDeposit();">Make Deposit</button>
														</div>
													</div>
												</p>

											<div id="alert-msg"></div>
											
										 <?php echo form_close(); ?>	
									</div>
									<!-- Deposit via Card -->
									
									
									<!-- Deposit via CashDirect -->
									<div id="cash-deposit-show">
										<h3 align="center"><img src="<?php echo base_url('assets/images/icons/cashdirect.jpg'); ?>" /></h3>
										<div class="cashdirect_errors"></div>
											<?php 
												$attr3 = array(
													'name' => 'cashDirectForm',
													'id' => 'cashDirectForm',
												);			
												//start form
												echo form_open('payment/cashdirect', $attr3);	
												
											?>
											<p>
												<?php echo form_label('Voucher Number (19 digit)', 'voucher_number'); ?>
												<div class="row">
													<div class="col-xs-12">
													  <input type="text" name="voucher_number" id="voucher_number" value="65872" onkeypress="return allowNumbersOnly(event)" placeholder="65872 00 3242 1229" >
													</div>
												</div>
												
											</p>
							
											<p>
												<?php echo form_label('Voucher Amount', 'voucher_amount'); ?>
												<div class="row" >
													<div class="col-xs-6">
														<div class="input-group">
														  <div class="input-group-addon">$</div>
														  <input type="text" name="voucher_amount" id="voucher_amount" class="form-control input-lg" onkeypress="return allowNumbersOnly(event)" onclick="return depositAlert()" onkeyup="delayedSubmission()" placeholder="Amount" required>
														  <div class="input-group-addon">.00</div>
														</div>
														
													</div>
													<div class="col-xs-2">
														<input type="button" class="btn btn-primary" onclick="javascript:cashDirectDeposit();" value="Deposit">
													</div>
												</div>
											</p>
										<?php echo form_close(); ?>	
									</div>
									<!-- Deposit via CashDirect -->
									
									
									<!-- Deposit via PayPal -->
									<div id="paypal-deposit-show">
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
										<h3 align="center"><img src="<?php echo base_url('assets/images/icons/paypal.png'); ?>" /></h3>
										<div class="form_errors"></div>
										<div class="row" >
											<div class="col-xs-12">
												<div class="form-group pull-left" >
													
													<div class="input-group">
													  <div class="input-group-addon">$</div>
													  <input type="text" name="amount" class="form-control newDeposit" onkeypress="return allowNumbersOnly(event)" placeholder="Amount" required>
													  <div class="input-group-addon">.00</div>
													  
													</div>
													<input type="submit" class="btn btn-primary paypalDeposit" value="Deposit">
													<input type="button" class="btn btn-primary" onclick="javascript:paypalDeposit();" value="Make Deposit">
													
													
												</div>
											</div>
										</div>
										
										<br/>
										<div class="row" >
											<div class="col-xs-12">
												<p><span class="alert alert-danger depositNote">Please enter your deposit!</span></p>
											</div>
										</div>
											
										<div id="alert-msg"></div>
										
											
										<?php echo form_close(); ?>
									</div>
									<!-- Deposit via PayPal -->
								</div>
								<!-- .scrollable -->
							</div>
							<!-- .col-xs-8 -->
						</div>
						<!-- .row -->
						
					</div>
					<!-- .modal-body -->
					
				</div>
				<!-- .modal-content -->
				
			  </div>
			  <!-- .modal-dialog -->
			  
			</div>
			<!-- .modal -->
			
			<div class="modal fade" id="withdrawalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Withdraw Funds</h3>
				  </div>
				  <div class="modal-body">
						
						<div class="row">
							<div class="col-xs-4">
								<div id="card-withdrawal-logo" align="center"><img src="<?php echo base_url(); ?>assets/images/icons/credit_cards.png" /></div>
								
								<div id="paypal-withdrawal-logo" align="center"><img src="<?php echo base_url('assets/images/icons/paypal.png'); ?>" /></div>
							</div>
							<div class="col-xs-8">
								<div id="card-withdrawal-show">
									
										<?php
											echo form_open('payment/withdraw_to_card');
										?>
										
										<p><strong>Make a withdrawal to your credit/debit card</strong></p>
										
										<p>
											<span id="cards-withdrawal"></span>
										</p>
										
									<div class="row" >
										<div class="col-xs-7">
											<div class="form-group pull-left" >
												<div class="input-group">
													<div class="input-group-addon">$</div>
													<input type="text" name="amount" class="form-control" onkeypress="return allowNumbersOnly(event)" placeholder="10" required>
													<div class="input-group-addon">.00</div>
												</div>
											</div>
										</div>
										<div class="col-xs-3">
											<input type="button" class="btn btn-primary" value="Withdraw">
										</div>
									</div>
									<?php echo form_close(); ?>	
								</div>
								
								<div id="paypal-withdrawal-show">
									<?php
											echo form_open('payment/withdraw_to_paypal');
									?>
									<div class="row" >
										<div class="col-xs-12">
											<p><strong>Make withdrawal to your PayPal account</strong></p>
											<p>
												<div class="form-group" >
													<input type="text" name="paypal-account" class="form-control" id="paypal-account" readonly>
													<input type="hidden" name="paypal_id" id="paypal_id">
												</div>
											</p>
										</div>
									</div>
									<div class="row" >
										<div class="col-xs-7">
											<div class="form-group pull-left" >
												<div class="input-group">
													<div class="input-group-addon">$</div>
													<input type="text" name="amount" class="form-control" onkeypress="return allowNumbersOnly(event)" placeholder="10" required>
													<div class="input-group-addon">.00</div>
												</div>
												
											</div>
										</div>
										<div class="col-xs-3">
											<input type="submit" class="btn btn-primary" value="Withdraw">
										</div>
									</div>
									<?php echo form_close(); ?>	
								</div>
							</div>
						</div>
				
				  </div>

				</div>
			  </div>
			</div>		
						
			