<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paypal extends CI_Controller 
{
     function  __construct(){
        parent::__construct();
        $this->load->library('paypal_lib');
        
     }
  
	/**
	* Function to display paypal payment success 
	*  
	*/	    
    public function success(){
		 
		if($this->session->userdata('logged_in')){ 
		  				
			$email = $this->session->userdata('email');
				
			$data['users'] = $this->Users->get_user($email);
			
			//get the transaction data
			//$paypalInfo = $this->input->get();
			if(isset($_GET['tx'])){
				
				$firstname = '';
				$lastname = '';
				$address_name = '';
				$address_street = '';
				$address_zip = '';
				$address_city = '';
				$address_state = '';
				$address_country = '';
				$contact_phone = '';
				$itemname = '';
				//$amount = $payment_data['mc_gross'];
				$payment_gross = '';
				$transactionID = '';
				$receiver_email = '';
				$payer_email = '';
				$payment_status = '';
				$payment_currency = '';
				//ASbWd127mqGlmi-ZWQ5KjJB2RbtWfkUohnGF6_-hcn70_F1h31UwDgJ8jQERc5vwENBalGb9yDIEq6mD
				$tx = $_GET['tx'];
				$pdt = 'MxbmldqEB0jW6g3QGUxgeH-uOGxZ2KhNyw7Bp2iyh-j-gEmGQhy9Zn-yvJu';
				
				$payment_data = $this->process_pdt($tx, $pdt);
				
				// parse the data
				//$lines = explode("\n", $payment_data);
				//$keyarray = array();				
				
				if ($payment_data) {
					
				///	for ($i=1; $i<count($lines);$i++){
					//	list($key,$val) = explode("=", $lines[$i]);
					//	$keyarray[urldecode($key)] = urldecode($val);
				//	}
					// check the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					//$myarray = array_shift($payment_data);
	
					$firstname = $payment_data['first_name'];
					$lastname = $payment_data['last_name'];
					$address_name = '';
					$address_street = '';
					$address_zip = '';
					$address_city = '';
					$address_state = '';
					$address_country = '';
					$contact_phone = '';
					//$itemname = $payment_data['item_name'];
					//$amount = $payment_data['mc_gross'];
					$payment_gross = $payment_data["payment_gross"];
					$transactionID = $payment_data["txn_id"];
					$receiver_email = $payment_data["receiver_email"];
					$payer_email = $payment_data["payer_email"];
					$payment_status = $payment_data["payment_status"];
					$payment_currency = $payment_data["mc_currency"];
				}
				
				
				//$mypaypalemail = $this->session->userdata('business_email');
				$mypaypalemail = 'paypal@avenue1oh1.com';
						
				if (($payment_status == 'Completed') && ($receiver_email == $mypaypalemail) && ($payment_currency == 'USD')) 
				{
					// do your stuff here... if nothing else you must check that $payment_status=='Completed'
					//$new_deposit = $this->input->post('amount');
					//remove non-numbers from post
					$amount = preg_replace("/[^\d-.]+/","", $payment_gross);
							
					//$maskedPaypal = $this->session->userdata('maskedPaypal');
					$maskedPaypal = $this->Users->email_mask($payer_email);
					
					$ip_address = $this->input->ip_address();

					$transactions = array(
						'reference' => $transactionID,
						'amount' => '+ $'.number_format($amount, 2),
						'description' => 'Payment from '.$maskedPaypal,
						'ip_address' => $ip_address,
						'email' => $email,
						'status' => '1',
						'transaction_date' => date('Y-m-d H:i:s'),
					);
					
					//	echo json_encode($result);
					if ($this->Paypal_payment_methods->paypal_payment($transactions)){
										
						//instant notification div
						$notification = ' <p>Hello '.$first_name.',</p>';
						$notification .= '<p>You have successfully added to $'.$amount.' your account!</p>';
								
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i>'.$notification.'</div>');
										
							
						//send email
						$ci = get_instance();
						$ci->load->library('email');
										
						$config['protocol'] = "smtp";
						$config['validate'] = 'FALSE';
						$config['smtp_host'] = "ssl://cp-in-1.webhostbox.net";
						$config['smtp_port'] = "465";
						$config['smtp_user'] = "getextra@global-sub.com"; 
						$config['smtp_pass'] = "1234567";
						$config['charset'] = "utf-8";
						$config['mailtype'] = "html";
						$config['newline'] = "\r\n";

						$ci->email->initialize($config);

						//setup email function
						$ci->email->from('getextra@global-sub.com', 'Get Extra Hands');
						$ci->email->to($email_address);
						$this->email->reply_to('getextra@gmail.com', 'Get Extra Hands');
						$ci->email->subject('Your account has been credited');
						
						$url = 'https://vrqhxykxwa.localtunnel.me/websites/getextra/';
						//img('assets/images/get.png')
						//compose email message
						$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
						$message .= '<div align="center" id="logo"><a href="'.$url.'" title="Get Extra Hands"><img src="'.$url.'assets/images/get.png" ></a></div><br/>';
									
						$message .= '<p>Hello ';
						$message .= $first_name. ',</p>';
						$message .= '<p>You have successfully made a deposit of $ '.$amount.' via PayPal.</p>';
						$message .= '</div>';
										
						$ci->email->message($message);
										
						$ci->email->send();
						//End email notification			
						$this->session->set_flashdata('tx', $tx);
						$this->session->set_flashdata('pdt', $pdt);
						//$r_url = 'paypal/complete/'.$tx.'/'.$pdt;
						redirect('paypal/complete');	
					}	
				}else{
					
					//$payment_data = $this->process_pdt($tx, $pdt);
					$this->session->set_flashdata('payment_data', $payment_data);
					//failed for some reason
					redirect('paypal/failure');
				}				
			}  						
		}else{
			redirect('login');
		}		
     }
	 
	 
	/**
	* Function to display paypal payment success 
	*  
	*/	    
    public function payment_success(){
		 
		if($this->session->userdata('logged_in')){ 
		  				
			$email = $this->session->userdata('email');
				
			$data['users'] = $this->Users->get_user($email);
			
			//get the transaction data
			//$paypalInfo = $this->input->get();
			if(isset($_GET['tx'])){
				
				//Transaction ID
				$tx = $_GET['tx'];
				
				//Payment Data Transfer ID token from PayPal
				$pdt = '5sLO7Fj4kMiok_KV9eHUjENNNrtQPXsxV3RX8gD1UY2bBh2jZqqXyds8_uO';
				
				//verify transaction
				$payment_data = $this->process_pdt($tx, $pdt);
				
				// parse the data
				//$lines = explode("\n", $payment_data);
				//$keyarray = array();				
				
				if ($payment_data) {
					
					///	for ($i=1; $i<count($lines);$i++){
						//	list($key,$val) = explode("=", $lines[$i]);
						//	$keyarray[urldecode($key)] = urldecode($val);
					//	}
					// check the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your Primary PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment
					//$myarray = array_shift($payment_data);
					//
					
					/*
					*
					*https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/
					*/
					//Customer's first name
					$firstname = $payment_data['first_name'];
					
					//Customer's last name
					$lastname = $payment_data['last_name'];
					
					//Name used with address (included when the customer provides a Gift Address) 
					$address_name = $payment_data["address_name"];
					
					if($address_name == ''){
						$address_name = $firstname .' '.$lastname;
					}
					
					//Customer's street address. 
					$address_street = $payment_data["address_street"];
					
					//Zip code of customer's address. 
					$address_zip = $payment_data["address_zip"];
					
					//City of customer's address 
					$address_city = $payment_data["address_city"];
					
					//State of customer's address
					$address_state = $payment_data["address_state"];
					
					//Country of customer's address
					$address_country = $payment_data["address_country"];
					
					//Customer's telephone number. 
					$contact_phone = '';
					$contact_phone = $payment_data["contact_phone"];
					//$itemname = $payment_data['item_name'];
					//$amount = $payment_data['mc_gross'];
					
					//Full USD amount of the customer's payment, before transaction fee is subtracted. Will be empty for non-USD payments.
					$payment_gross = $payment_data["mc_gross"];
					
					//The merchant's original transaction identification number for the payment from the buyer, against which the case was registered.
					$transactionID = $payment_data["txn_id"];
					
					//Unique ID generated during guest checkout (payment by credit card without logging in).
					//$receipt_id = $payment_data["receipt_id"];
					
					//Primary email address of the payment recipient
					$receiver_email = $payment_data["receiver_email"];
					
					//Customer's primary email address. Use this email to provide any credits. 
					$payer_email = $payment_data["payer_email"];
					
					//The status of the payment:
					$payment_status = $payment_data["payment_status"];
					
					//currency of the payment.
					$payment_currency = $payment_data["mc_currency"];
					
					//Total handling amount associated with the transaction.
					$handling_fee = $payment_data["mc_handling"];
					
					//USD transaction fee associated with the payment. 
					$payment_fee = $payment_data["mc_fee"];
					
					//Amount of tax charged on payment.
					$tax = $payment_data["tax"];
					
					//Total shipping amount associated with the transaction.
					//$shipping_fee = $payment_data["shipping"];
					$shipping_fee = $payment_data["mc_shipping"];	
					
					//number of items in cart..
					$num_cart_items = $payment_data["num_cart_items"];	
					
					//Time/Date stamp generated by PayPal, in the following format: HH:MM:SS Mmm DD, YYYY PDT
					$payment_date = $payment_data["payment_date"];	
					//convert date format
					//$payment_date_timestamp = strtotime($payment_date);
					//$new_payment_date = date('Y-m-d H:i:s', $payment_date_timestamp); 
					$new_payment_date = date('Y-m-d H:i:s', strtotime($payment_date)); 
					
					//This variable is set only if payment_status is Pending
					//$pending_reason = $payment_data["pending_reason"];	
					
					//$mypaypalemail = $this->session->userdata('business_email');
					$mypaypalemail = 'paypal@avenue1oh1.com';
							
					if (($payment_status == 'Completed') && ($receiver_email == $mypaypalemail)) 
					{
						// do your stuff here... if nothing else you must check that $payment_status=='Completed'
						//$new_deposit = $this->input->post('amount');
						//remove non-numbers from post
						$amount = preg_replace("/[^\d-.]+/","", $payment_gross);
								
						//$maskedPaypal = $this->session->userdata('maskedPaypal');
						$maskedPaypal = $this->email_mask($payer_email);
						
						$ip_address = $this->input->ip_address();
						
						//store paypal transaction in db
						$transactions = array(
							'reference' => $transactionID,
							'amount' => '+ $'.number_format($amount, 2),
							'description' => 'Payment from '.$maskedPaypal,
							'ip_address' => $ip_address,
							'email' => $email,
							'status' => '1',
							//'transaction_date' => date('Y-m-d H:i:s'),
							'transaction_date' => $new_payment_date,
						);
						
						//store order in db
						$orders = array(
							'reference' => $transactionID,
							//'total_price' => $amount,
							'tax' => $tax,
							'shipping_n_handling_fee' => $shipping_fee + $handling_fee,
							'payment_gross' => $amount,
							'num_cart_items' => $num_cart_items,
							'customer_email' => $email,
							'billing_address_name' => $firstname .' '.$lastname,
							'billing_address_street' => $address_street,
							'billing_address_zip' => $address_zip,
							'billing_address_city' => $address_city,
							'billing_address_state' => $address_state,
							'billing_address_country' => $address_country,
							'shipping_address_name' => $address_name,
							'shipping_address_street' => $address_street,
							'shipping_address_zip' => $address_zip,
							'shipping_address_city' => $address_city,
							'shipping_address_state' => $address_state,
							'shipping_address_country' => $address_country,
							'customer_contact_phone' => $contact_phone,
							'payment_status' => '1',
							'shipping_status' => '0',
							//'order_date' => date('Y-m-d H:i:s'),
							'order_date' => $new_payment_date,
						);
						
						//store payment in db
						$payments = array(
							'reference' => $transactionID,
							'total_amount' => $amount,
							'payment_method' => 'PayPal',
							'customer_email' => $email,
							//'payment_date' => date('Y-m-d H:i:s'),
							'payment_date' => $new_payment_date,
						);
						
						
						//store shipping_status in db
						/*$shipping = array(
							'reference' => $transactionID,
							'status' => '0',
							'note' => 'Shipping Pending',
							'customer_email' => $email,
							//'status_date' => date('Y-m-d H:i:s'),
							'status_date' => $new_payment_date,
						);
						*/
						
						//check if reference already stored in db						
						if($this->Transactions->is_unique_reference($transactionID) && $this->Orders->is_unique_reference($transactionID)){
							
							//insert into db
							$this->Transactions->insert_transaction($transactions);
							$order_id = $this->Orders->insert_order($orders);
							//$this->Shipping_status->insert_shipping($shipping);
							$this->Payments->insert_payment($payments);
							
							//GET ITEMS FROM CART
							$cartTotal = '';
							$order_table = '';
							
							foreach($_SESSION["cart_array"] as $each){
								
								$item_id = $each['product_id'];
																
								$query = $this->db->get_where('products', array('id' => $item_id));
								
								$pname = '';
								$pprice = '';
								$quantity_available = 0;
								
								if($query){
									foreach ($query->result() as $row){
										
										$pname = $row->name;
										$pprice = $row->price;
										$quantity_available = $row->quantity_available;
									}							
								}
								$pricetotal = $pprice * $each['quantity'];
								$pricetotal = sprintf("%01.2f", $pricetotal);
								$cartTotal = $pricetotal + $cartTotal;
								
								$newQuantityAvailable = $quantity_available - $each['quantity'];
								
								//order details
								$order_details = array(
									'order_reference' => $transactionID,
									'product_id' => $item_id,
									'quantity' => $each['quantity'],
									'price' => $pricetotal,
									'customer_email' => $email,
									
								);
								//store individual items in order details
								//table
								$this->Order_details->insert_order_detail($order_details);
								
								//update quantity available
								$update = array(
									'quantity_available' => $newQuantityAvailable,
								);
								$this->Products->update_product($update, $item_id);

								//GENERATE ORDER TABLE
								$order_table .= '<tr>';
								$order_table .= '<td><p class="text-primary"><strong>'.$pname.'</strong></p>';
								$order_table .= '<p>Item Price: $'.$pprice.'</p>';
								$order_table .= '<p>Quantity:'.$each['quantity'].'</p>';
								$order_table .= '</td><td><strong>$'.$pricetotal.'</strong></td>';
								$order_table .= '</tr>';
								
							}
							$cartTotal = sprintf("%01.2f", $cartTotal);
							
							//update total_price
							$update_order = array(
								'total_price' => $cartTotal,
							);
							$this->Orders->update_order($update_order, $order_id);
								
							$order_table .= '<tr>';
							$order_table .= '<td><p class="text-primary"><strong>Sub Total</strong></p><p>VAT (5%) </p><p>Shipping and handling</p></td>';
							$order_table .= '<td>';
							$order_table .= '<p class="text-primary"><strong>$'.$cartTotal.'</strong></p>';
							$order_table .= '<p>$'.$tax.'</p>';
							$order_table .= '<p>$'.$shipping_fee + $handling_fee.'</p>';
							$order_table .= '</td></tr>';
							$order_table .= '<tr>';
							$order_table .= '<td><strong>Total Amount</strong></td>';
							$order_table .= '<td><strong>$'.$payment_gross.'</strong></td>';
							$order_table .= '</tr>';
							
							
							$this->session->set_userdata('order_table', $order_table);
							$this->session->set_userdata('reference', $payment_data["txn_id"]);
							
							$this->session->set_userdata('tx', $tx);
							$this->session->set_userdata('pdt', $pdt);
							
							$this->session->unset_userdata('cart_array');
							
							//$r_url = 'paypal/complete/'.$tx.'/'.$pdt;
							redirect('paypal/complete');	
							
						}else{
							$this->session->set_userdata('tx', $tx);
							$this->session->set_userdata('pdt', $pdt);
							//$r_url = 'paypal/complete/'.$tx.'/'.$pdt;
							redirect('paypal/complete');
						}	
					}else{
						
						//$payment_data = $this->process_pdt($tx, $pdt);
						$this->session->set_flashdata('payment_data', $payment_data);
						//failed for some reason
						$this->session->set_flashdata('error', '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Variable Error! Status: '.$payment_status.'</div>');
						redirect('paypal/failure');
					}	
				}else{
					
					$this->session->set_flashdata('error', '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Payment Data Error!</div>');
					redirect('paypal/failure');
				}	
							
			}else{
				$this->session->set_flashdata('error', '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> GET not set!</div>');
				//failed for some reason
				redirect('paypal/failure');
			}					
		}else{
			redirect('login');
		}		
     }
	 

		function email_mask($email) 
		{ 
				$mask_char = '*';
				$percent = 50;
				list($user, $domain) = preg_split("/@/", $email); 

				$len = strlen($user); 
				$mask_count = floor( $len * $percent /100 ); 

				$offset = floor( ( $len - $mask_count ) / 2 ); 

				$masked = substr( $user, 0, $offset ) 
						.str_repeat( $mask_char, $mask_count ) 
						.substr( $user, $mask_count+$offset ); 
				
				$domain_len = strlen($domain);
				$mask_domain_count = floor($domain_len * 40 /100);
				$domain_offset = floor( ($domain_len - $mask_domain_count) / 2 ); 
				
				$masked_domain = substr($domain, 0, $domain_offset ) 
						.str_repeat( $mask_char, $mask_domain_count) 
						.substr($domain, $mask_domain_count+$domain_offset );
						
				return( $masked.'@'.$masked_domain); 
		} 
	 
 	/**
	* Function to display paypal  
	* cancel or failure
	*/	    
    public function complete(){
			
		if($this->session->userdata('logged_in')){
			
			//check if table and ref sessions are set otherwise redirect
			if($this->session->userdata('order_table') && $this->session->userdata('reference')){
		
				$email = $this->session->userdata('email');
					
				$data['users'] = $this->Users->get_user($email);
				
				//set cart count
				$data['cart_count'] = 0;
				
				$data['order_table'] = $this->session->userdata('order_table');
				$data['reference'] = $this->session->userdata('reference');
								
				$tx = $this->session->userdata('tx');
				$pdt = $this->session->userdata('pdt');
				
				$data['payment_data'] = $this->process_pdt($tx, $pdt);
						
				//check if user has started shopping
				//update cart accordingly
				if($this->session->userdata('cart_array')){ 
							
					//count cart items
					$cart_count = count($this->session->userdata('cart_array'));
					if($cart_count == '' || $cart_count == null){
						$cart_count = 0;
					}
					$data['cart_count'] = $cart_count;
						
					//get cart items
					$data['cart_array'] = $this->session->userdata('cart_array');
								
				}	
						
				//assign page title name
				$data['pageTitle'] = 'Payment Success';
										
				//assign page ID
				$data['pageID'] = 'payment_success';
															
				//load header
				$this->load->view('account_pages/header', $data);
														
				//load main body
				$this->load->view('account_pages/payment_success_page', $data); 			
					
				//load main footer
				$this->load->view('account_pages/footer');				
																
				
			}else{
				//redirect to shopping bag
				redirect('cart');
			}
				
		}else{
			redirect('login');
		}	
    }
	
 	/**
	* Function to display paypal  
	* cancel
	*/	    
    public function cancel(){
			
		if($this->session->userdata('logged_in')){
				
			$email = $this->session->userdata('email');
				
			$data['users'] = $this->Users->get_user($email);
			
			//set cart count
			$data['cart_count'] = 0;
					
			//check if user has started shopping
			//update cart accordingly
			if($this->session->userdata('cart_array')){ 
						
				//count cart items
				$cart_count = count($this->session->userdata('cart_array'));
				if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
				}
				$data['cart_count'] = $cart_count;
					
				//get cart items
				$data['cart_array'] = $this->session->userdata('cart_array');
							
			}	
					
			//assign page title name
			$data['pageTitle'] = 'Payment Cancelled';
				
			//assign page ID
			$data['pageID'] = 'payment_cancelled';
									
			//load header
			$this->load->view('account_pages/header', $data);
								
			//load main body
			$this->load->view('account_pages/payment_cancelled_page');				
				
			//load main footer
			$this->load->view('account_pages/footer');				
												
		}else{
			redirect('login');
		}	
    }

	
 	/**
	* Function to display paypal  
	* failure
	*/	    
    public function failure(){
			
		if($this->session->userdata('logged_in')){
				
			$email = $this->session->userdata('email');
				
			$data['users'] = $this->Users->get_user($email);
			
			//set cart count
			$data['cart_count'] = 0;
					
			//check if user has started shopping
			//update cart accordingly
			if($this->session->userdata('cart_array')){ 
						
				//count cart items
				$cart_count = count($this->session->userdata('cart_array'));
				if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
				}
				$data['cart_count'] = $cart_count;
					
				//get cart items
				$data['cart_array'] = $this->session->userdata('cart_array');
							
			}	
					
			//assign page title name
			$data['pageTitle'] = 'Payment Failure';
				
			//assign page ID
			$data['pageID'] = 'payment_failure';
									
			//load header
			$this->load->view('account_pages/header', $data);
								
			//load main body
			$this->load->view('account_pages/payment_failure_page');				
				
			//load main footer
			$this->load->view('account_pages/footer');				
												
		}else{
			redirect('login');
		}	
    }
     
    public function payment_ipn(){
        //paypal return transaction details array
        $paypalInfo    = $this->input->post();

        //$data['user_id'] = $paypalInfo['custom'];
        $data['product_id']    = $_POST["item_number"];
        $data['txn_id']    = $_POST["txn_id"];
        $data['payment_gross'] = $_POST["payment_gross"];
        $data['currency_code'] = $_POST["mc_currency"];
        $data['payer_email'] = $_POST["payer_email"];
        $data['payment_status']    = $_POST["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
        
        //check whether the payment is verified
        if(eregi("VERIFIED",$result)){
			
			$new_deposit = $_POST["payment_amount"];
			$transactionID = $_POST["txn_id"];
			$receiver_email = $_POST["receiver_email"];
			$payer_email = $_POST["payer_email"];
			$payment_status = $_POST["payment_status"];
			$payment_currency = $_POST["mc_currency"];
			
			$mypaypalemail = $this->session->userdata('business_email');;
					
			if (($payment_status == 'Completed') && ($receiver_email == $mypaypalemail) && ($payment_currency == 'USD')) 
			{
				// do your stuff here... if nothing else you must check that $payment_status=='Completed'
				//$new_deposit = $this->input->post('amount');
				//remove non-numbers from post
				$amount = preg_replace("/[^\d-.]+/","", $new_deposit);
						
				//$maskedPaypal = $this->session->userdata('maskedPaypal');
				$maskedPaypal = $this->Users->email_mask($payer_email);
						
				$email = $this->session->userdata('email');
				
				
					$ip_address = $this->input->ip_address();

					$transactions = array(
						'reference' => $transactionID,
						'amount' => '+ $'.number_format($amount, 2),
						'description' => 'Payment from '.$maskedPaypal,
						'ip_address' => $ip_address,
						'email' => $email,
						'status' => '1',
						'transaction_date' => date('Y-m-d H:i:s'),
					);
					
					//	echo json_encode($result);
					if ($this->Paypal_payment_methods->paypal_payment($transactions)){
						
						//send email
						$ci = get_instance();
						$ci->load->library('email');
									
						$config['protocol'] = "smtp";
						$config['validate'] = 'FALSE';
						$config['smtp_host'] = "ssl://cp-in-1.webhostbox.net";
						$config['smtp_port'] = "465";
						$config['smtp_user'] = "getextra@global-sub.com"; 
						$config['smtp_pass'] = "1234567";
						$config['charset'] = "utf-8";
						$config['mailtype'] = "html";
						$config['newline'] = "\r\n";

						$ci->email->initialize($config);

						//message admin
						$ci->email->from('getextra@global-sub.com', 'Get Extra Hands');
						$ci->email->to('getextra@global-sub.com');
						$this->email->reply_to('getextra@gmail.com', 'Get Extra Hands');
						$ci->email->subject('Verified IPN');
						$ci->email->message($listener->getTextReport());
									
						$ci->email->send();
							
							//redirect('payment/deposit_success', 'refresh');
					}
					
			}			
			
            //insert the transaction data into the database
           // $this->product->insertTransaction($data);
        }
    }
	   
    public function ipn(){
        //paypal return transaction details array
        $paypalInfo    = $this->input->post();

        //$data['user_id'] = $paypalInfo['custom'];
        $data['product_id']    = $_POST["item_number"];
        $data['txn_id']    = $_POST["txn_id"];
        $data['payment_gross'] = $_POST["payment_gross"];
        $data['currency_code'] = $_POST["mc_currency"];
        $data['payer_email'] = $_POST["payer_email"];
        $data['payment_status']    = $_POST["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;        
        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
        
        //check whether the payment is verified
        if(eregi("VERIFIED",$result)){
			
			$new_deposit = $_POST["payment_amount"];
			$transactionID = $_POST["txn_id"];
			$receiver_email = $_POST["receiver_email"];
			$payer_email = $_POST["payer_email"];
			$payment_status = $_POST["payment_status"];
			$payment_currency = $_POST["mc_currency"];
			
			$mypaypalemail = $this->session->userdata('business_email');;
					
			if (($payment_status == 'Completed') && ($receiver_email == $mypaypalemail) && ($payment_currency == 'USD')) 
			{
				// do your stuff here... if nothing else you must check that $payment_status=='Completed'
				//$new_deposit = $this->input->post('amount');
				//remove non-numbers from post
				$amount = preg_replace("/[^\d-.]+/","", $new_deposit);
						
				//$maskedPaypal = $this->session->userdata('maskedPaypal');
				$maskedPaypal = $this->Users->email_mask($payer_email);
						
				$email_address = $this->session->userdata('email_address');
				
				$deposit_date = date('Y-m-d H:i:s');
								
					$this->session->set_flashdata('deposit_date', $deposit_date);
						
					//array of post value from add credit card form
					$deposit_data = array(
						'type' => 'PayPal',
						'payment_info' => $maskedPaypal,
						'deposit_amount' => $amount,
						'user_email' => $email_address,
						'deposit_date' => $deposit_date,
					);

					//	echo json_encode($result);
					if ($this->Users->paypal_deposit($deposit_data)){
									
						$user = $this->Users->get_user($email_address);
							
						//Start email notification
						//get users first name for email message
						$first_name = '';
									
						foreach($user as $u){
								$first_name = $u->first_name;
						}
							
						//instant notification div
						$notification = ' <p>Hello '.$first_name.',</p>';
						$notification .= '<p>You have successfully added to $'.$amount.' your account!</p>';
							
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i>'.$notification.'</div>');
									
						
						//send email
						$ci = get_instance();
						$ci->load->library('email');
									
						$config['protocol'] = "smtp";
						$config['validate'] = 'FALSE';
						$config['smtp_host'] = "ssl://cp-in-1.webhostbox.net";
						$config['smtp_port'] = "465";
						$config['smtp_user'] = "getextra@global-sub.com"; 
						$config['smtp_pass'] = "1234567";
						$config['charset'] = "utf-8";
						$config['mailtype'] = "html";
						$config['newline'] = "\r\n";

						$ci->email->initialize($config);

						//setup email function
						$ci->email->from('getextra@global-sub.com', 'Get Extra Hands');
						$ci->email->to($email_address);
						$this->email->reply_to('getextra@gmail.com', 'Get Extra Hands');
						$ci->email->subject('Account Deposit');
									
						//compose email message
						$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
						$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
								
						$message .= '<p>Hello ';
						$message .= $first_name. ',</p>';
						$message .= '<p>You have successfully made a deposit of $ '.$deposit.' via PayPal.</p>';
						$message .= '</div>';
									
						$ci->email->message($message);
									
						$ci->email->send();
						//End email notification
								
						//redirects to payment methods page
						//redirect('account/payment_methods', 'refresh');
							
						//message admin
						$ci->email->from('getextra@global-sub.com', 'Get Extra Hands');
						$ci->email->to('getextra@global-sub.com');
						$this->email->reply_to('getextra@gmail.com', 'Get Extra Hands');
						$ci->email->subject('Verified IPN');
						$ci->email->message($listener->getTextReport());
									
						$ci->email->send();
							
							//redirect('payment/deposit_success', 'refresh');
					}
					
			}			
			
            //insert the transaction data into the database
           // $this->product->insertTransaction($data);
        }
    }
	
	/**
	 * Processes a PDT transaction id.
	 *
	 * @author     Torleif Berger
	 * @link       http://www.geekality.net/?p=1210
	 * @license    http://creativecommons.org/licenses/by/3.0/
	 * @return     The payment data if $tx was valid; otherwise FALSE.
	 */
	public function process_pdt($tx, $pdt)
	{
			// Init cURL
			$request = curl_init();

			// Set request options
			curl_setopt_array($request, array
			(
					CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
					CURLOPT_POST => TRUE,
					CURLOPT_POSTFIELDS => http_build_query(array
					(
							'cmd' => '_notify-synch',
							'tx' => $tx,
							'at' => $pdt,
					)),
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_HEADER => FALSE,
					//CURLOPT_SSL_VERIFYPEER => TRUE,
					//CURLOPT_CAINFO => 'cacert.pem',
			));

			// Execute request and get response and status code
			$response = curl_exec($request);
			$status   = curl_getinfo($request, CURLINFO_HTTP_CODE);

			// Close connection
			curl_close($request);
			
			$lines = explode("\n", $response);

			$keyarray = array();
			
			// Validate response
			if($status == 200 AND strpos($response, 'SUCCESS') === 0)
			{
				$i=0;
				for ($i=1; $i<count($lines);$i++){

					//list($key,$val) = explode("=", $lines[$i]); array_pad(explode("=", $lines[$i]),2,null);
					list($key,$val) = array_pad(explode("=", $lines[$i]),2,null);

					$keyarray[urldecode($key)] = urldecode($val);

				}
				return $keyarray;
					// Remove SUCCESS part (7 characters long)
					/*$response = substr($response, 7);

					// Urldecode it
					$response = urldecode($response);

					// Turn it into associative array
					preg_match_all('/^([^=\r\n]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER);
					$response = array_combine($m[1], $m[2]);

					// Fix character encoding if needed
					if(isset($response['charset']) AND strtoupper($response['charset']) !== 'UTF-8')
					{
							foreach($response as $key => &$value)
							{
									$value = mb_convert_encoding($value, 'UTF-8', $response['charset']);
							}

							$response['charset_original'] = $response['charset'];
							$response['charset'] = 'UTF-8';
					}

					// Sort on keys
					ksort($response);

					// Done!
					return $response;
					*/
			}

			return FALSE;
	}	
	
	
	
	
	
}