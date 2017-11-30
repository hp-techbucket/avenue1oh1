<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Payment extends CI_Controller {
 
		/**
		 * Class constructor.
		 * Adding libraries for each call.
		 */
		public function __construct() {
			
			parent::__construct();
			
			$this->merchant->load('paypal_express');

							
		}	
		
		/**
		* Function for controller
		*  index
		*/	
		public function index(){
			
			if($this->session->userdata('logged_in')){
				redirect('account/payment_methods');
			}else{
				redirect('main/login');	
			}
		}
	

		/**
		* Function for cc deposit 
		* 
		*/			
		public function deposit($id, $rndm){
			
			if($this->session->userdata('logged_in')){
				
				$username = $this->session->userdata('username');

				$data['users'] = $this->Users->get_user($username);
				
				$object = new Card_payment_methods_model();
				$object->load($id);
				
				$data['header_messages_array'] = $this->Users->get_header_messages();
				
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
				
				$data['credit_card_details'] = $this->Card_payment_methods->get_card_info($id,$username);	
				
				//assign page title name
				$data['pageTitle'] = 'Deposit';
				
				//assign page ID
				$data['pageID'] = 'deposit';
									
				//load header
				$this->load->view('account_pages/header', $data);
								
				//load main body
				$this->load->view('account_pages/deposit_page', array(
					'object' => $object
				));
				
				//load main footer
				$this->load->view('account_pages/footer');				
									
			}else{
				redirect('home/login');
			}	
		}		
	

		/**
		* Function for cash direct
		* deposit
		*/			
		public function cashdirect() {		
		
				//$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				
				$this->form_validation->set_rules('voucher_number','Voucher Number','required|trim|xss_clean|numeric|exact_length[19]|callback_validate_voucher');
				$this->form_validation->set_rules('voucher_amount','Voucher Amount','required|numeric|trim|xss_clean');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> %s cannot be blank!');
				$this->form_validation->set_message('numeric', '<i class="fa fa-exclamation-triangle"></i> %s can only be digits!');
				$this->form_validation->set_message('exact_length', '<i class="fa fa-exclamation-triangle"></i> Voucher Number must be 19 digits!');
			
				if ($this->form_validation->run()){
					
					$username = $this->session->userdata('username');
					
					$voucher_amount = $this->input->post('voucher_amount');
					$amount = preg_replace("/[^\d-.]+/","", $voucher_amount);
					
					$deposit_date = date('Y-m-d H:i:s');
					
					$this->session->set_flashdata('deposit_date', $deposit_date);
					
					$voucher_number = $this->input->post('voucher_number');
					
					//array of post value from add credit card form
					$deposit = array(
						'type' => 'Cash Direct',
						'payment_info' => $voucher_number,
						'deposit_amount' => $amount,
						'username' => $username,
						'deposit_date' => $deposit_date,
					);
					
					if($this->Users->add_deposit($deposit)){
						
						//mark voucher as used
						$this->Cashdirectvouchers->update_voucher();
						
						//instant notification div
						$success = '<strong>You have successfully added to $'.$amount.' your account!</strong>';
							
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i>'.$success.'</div>');
						//redirect('account/payment_methods');
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$success.'</div>';
						
					}else{
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDivError").fadeOut("slow"); }, 5000);</script><div class="commentDivError text-center"><i class="fa fa-exclamation-triangle"></i> Cash could not be deposited!</div>');
						//redirect('account/payment_methods');
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  Cash could not be deposited!</div>';

					}			
				}else{
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDivError").fadeOut("slow"); }, 5000);</script><div class="commentDivError text-center">'.validation_errors().'</div>');
						//redirect('account/payment_methods');
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';

				}
				
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
		}	
		

		/**
		* Function to validate if the cvv matches
		* what is stored in db
		*/			
		public function validate_voucher(){
			
			if ($this->Cashdirectvouchers->voucher_validation()){
				return TRUE;
			}
			else{
				$this->form_validation->set_message('validate_voucher', 'Voucher is invalid!');
				return FALSE;
			}
		}	
		
		
		/**
		* Function for card deposit
		* 
		*/			
		public function card_deposit() {		
		
				//$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
				
				$this->form_validation->set_rules('cvc','CVC','trim|xss_clean|numeric|callback_validate_cvc');
				$this->form_validation->set_rules('deposit_amount','Amount','required|trim|xss_clean');
				
				$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> %s cannot be blank!');
				$this->form_validation->set_message('numeric', '<i class="fa fa-exclamation-triangle"></i> Amount can only be digits!');
			
				if ($this->form_validation->run()){
					
					$username = $this->session->userdata('username');
					
					$deposit_amount = $this->input->post('deposit_amount');
					$amount = preg_replace("/[^\d-.]+/","", $deposit_amount);
					
					$deposit_date = date('Y-m-d H:i:s');
					
					$this->session->set_flashdata('deposit_date', $deposit_date);
					
					$card_number = $this->input->post('card_number');
					$card_number = 'XXXX-XXXX-XXXX-'.substr($card_number,-4);
					   
					//array of post value from add credit card form
					$d = array(
						'type' => 'Credit Card',
						'payment_info' => $card_number,
						'deposit_amount' => $amount,
						'username' => $username,
						'deposit_date' => $deposit_date,
					);
					
					$this->Users->add_deposit($d);
		
					//instant notification div
					$success = '<strong>You have successfully added to $'.$deposit_amount.' your account!</strong>';
						
					$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i>'.$success.'</div>');
					//redirect('account/payment_methods');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$success.'</div>';
										
				}else{
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDivError").fadeOut("slow"); }, 5000);</script><div class="commentDivError text-center"><i class="fa fa-exclamation-circle"></i>'.validation_errors().'</div>');
						//redirect('account/payment_methods');
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';

				}
				
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			
		}		

		
		/**
		* Function to validate if the cvc matches
		* what is stored in db
		*/	
		
		public function validate_cvc() {
			
			if ($this->Card_payment_methods->valid_cvc($this->input->post('cvc'))){
				
				return TRUE;
			}
			else {
				$this->form_validation->set_message('validate_cvc', '<i class="fa fa-exclamation-triangle"></i> The CVC provided doesn\'t match the card!');
				return FALSE;
			}
		}
				
		/**
		* Function to deposit via credit card 
		* validation
		*/		
		public function add_deposit(){
			
            $this->load->library('form_validation');
			
            //$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			
			$this->form_validation->set_rules('card_cvv','CVV','required|trim|xss_clean|numeric|callback_cvv_validate');
            $this->form_validation->set_rules('deposit_amount','Amount','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('numeric', 'Amount can only be digits!');
			
			$new_token = $this->security->get_csrf_hash();
            //set all the rules in $validation_rules array
			$validation_rules = array(
				   array(
						 'field'   => 'card_cvv',
						 'label'   => 'CVV',
						 'rules'   => 'required|trim|xss_clean|numeric|callback_cvv_validate'
					  ),
				   array(
						 'field'   => 'deposit_amount',
						 'label'   => 'Amount',
						 'rules'   => 'required|trim|xss_clean'
					  ),
			);
			
			
			//just pass your rules array to validation_errors_to_array() function it will give validation errors in array
			//$errors_array array contain validation errors in array form
			//$errors_array['field_name'] will give error of the field,, for eg---$errors_array['name'],$errors_array['password']
			$errors_array = $this->validation_errors_to_array($validation_rules);
	 
			$id = $this->input->post('id');
			
			$rndm = md5(uniqid());
				
			if ($this->form_validation->run()){
					
					$username = $this->session->userdata('username');
					
					$deposit_amount = $this->input->post('deposit_amount');
					$amount = preg_replace("/[^\d-.]+/","", $deposit_amount);
					
					$deposit_date = date('Y-m-d H:i:s');
					
					$this->session->set_flashdata('deposit_date', $deposit_date);
					
					$card_number = $this->input->post('card_number');
					$card_number = 'XXXX-XXXX-XXXX-'.substr($card_number,-4);
					
					//array of post value from add credit card form
					$data = array(
						'type' => 'Credit Card',
						'payment_info' => $card_number,
						'deposit_amount' => $amount,
						'username' => $username,
						'deposit_date' => $deposit_date,
					);
					
					if ($this->Users->add_deposit($data)){
						
						$user = $this->Users->get_user($username);
						
						$first_name = '';
						$email_address = ''; 
					
						foreach($user as $u){
							$first_name = $u->first_name;
							$email_address = $u->email_address;
						}
						
						//instant notification div
						$success = ' <p>Hello '.$first_name.',</p>';
						$success .= '<p>You have successfully added to $'.$deposit_amount.' your account!</p>';
						
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i>'.$success.'</div>');
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$success.'</div>';
										
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
						$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
						$ci->email->to($email_address);
						$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
						$ci->email->subject('Account Deposit');
						
						//compose email message
						$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
						$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
					
						$message .= '<p>Hello ';
						$message .= $first_name. ',</p>';
						$message .= '<p>You have successfully made a deposit of $ '.$deposit_amount.'.</p>';
						$message .= '</div>';
						
						$ci->email->message($message);
						
						$ci->email->send();
						
						
						//redirects to payment methods page
						//redirect('account/payment_methods', 'refresh');	
						
					}else {
						$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDivError").fadeOut("slow"); }, 5000);</script><div class="commentDivError text-center"><i class="fa fa-exclamation-circle"></i> Error!</div>');
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Errors with your deposit!</div>';
				
							//redirects to payment methods page
							//redirect('account/payment_methods', 'refresh');
					}
			}else{
					$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDivError").fadeOut("slow"); }, 5000);</script><div class="commentDivError text-center"><i class="fa fa-exclamation-circle"></i> Error!</div>');
					$data['success'] = false;
					echo $errors_array['card_cvv'];
					$data['errors'] = "<pre>".print_r($errors_array);
					$data['new_token'] = $new_token;
					$data['card_cvv'] = $errors_array['card_cvv'];
					//$data['errors'] = validation_errors();
					//$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.print_r($errors_array).'</div>';
					//$this->deposit($id, $rndm);
					
			}
				echo json_encode($data);
				// Encode the data into JSON
				//$this->output->set_content_type('application/json');
				//$data = json_encode($data);

				// Send the data back to the client
				//$this->output->set_output($data);
				//echo json_encode($data);					
		}

	//this function can be used for any form with any number of fields
    //this function is for converting validation errors to array
    //$validation_rules contains all rules set in above fuunction
    public function validation_errors_to_array($validation_rules){
 
        $this->form_validation->set_rules($validation_rules); //through this statement rules are set
 
        $errors_array = array();//array is initialized
         
        //if form validation is false means their are errors
        if($this->form_validation->run() == false){
 
            //$row as each individual field array 
            foreach($validation_rules as $row){
                $field = $row['field'];          //getting field name
                $error = form_error($field);    //getting error for field name
                                                //form_error() is inbuilt function
                //if error is their for field then only add in $errors_array array
                if($error)
                $errors_array[$field] = $error;
            }
            return $errors_array;
        }
        else
            return false;//if no validation error then return false
    }
 

		/**
		* Function for paypal deposit 
		* 
		*/			
		public function paypalDeposit($id, $rndm){
			
			if($this->session->userdata('logged_in')){
				
				$username = $this->session->userdata('username');

				$data['users'] = $this->Users->get_user($username);
				
				$object = new Paypal_methods_model();
				$object->load($id);
				
				$data['header_messages_array'] = $this->Users->get_header_messages();
				
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
					
				$data['paypal_details'] = $this->Payment_methods->get_paypal_info($id,$username);			
						
				//assign page title name
				$data['pageTitle'] = 'PayPal Deposit';
				
				//assign page ID
				$data['pageID'] = 'paypal_deposit';
									
				//load header
				$this->load->view('account_pages/header', $data);
								
				//load main body
				$this->load->view('account_pages/paypal_deposit_page', array(
					'object' => $object
				));
				
				//load main footer
				$this->load->view('account_pages/footer');				
									
			}else{
				redirect('main/login');
			}	
		}		
	
	
		/**
		* Function to process payment 
		* validation
		*/		
		public function paypal_process(){
			
			if($this->session->userdata('logged_in')){
				
				$data = array(
					//'maskedPaypal' => $this->Users->email_mask($object->PayPal_email),
					'business_email' => 'paypal@avenue1oh1.com',
				);		
				
				$this->session->set_userdata($data);
				
				$email = $this->session->userdata('email');
				
				if(isset($_SESSION["cart_array"])){
						
					//Set variables for paypal form
					$paypalURL = 'https://www.sandbox.paypal.com/us/cgi-bin/webscr?cmd=_express-checkout&token='; //test PayPal api url
					$paypalID = 'paypal@avenue1oh1.com'; //business email
					$returnURL = base_url().'paypal/payment_success'; //payment success url
					$cancelURL = base_url().'paypal/cancel'; //payment cancel url
					$notifyURL = base_url().'paypal/ipn'; //ipn url
					//$userID = 1;
					$logo = base_url('assets/images/logo/Avenue101-logo.JPG');
					
					$this->paypal_lib->add_field('image_url', $logo);
					$this->paypal_lib->add_field('cmd', '_cart');
					$this->paypal_lib->add_field('upload', '1');
					$this->paypal_lib->add_field('no_note',  '1');
					$this->paypal_lib->add_field('currency_code',  'USD');
					$this->paypal_lib->add_field('rm',  '2');
					$this->paypal_lib->add_field('lc',  'GB');
					$this->paypal_lib->add_field('business', $paypalID);
					$this->paypal_lib->add_field('return', $returnURL);
					$this->paypal_lib->add_field('cancel_return', $cancelURL);
					$this->paypal_lib->add_field('notify_url', $notifyURL);
					$this->paypal_lib->add_field('no_shipping',  '2');
					$this->paypal_lib->add_field('shipping',  '2');
					$this->paypal_lib->add_field('shipping2',  '2');
					$this->paypal_lib->add_field('tax_rate',  0.05);
					$this->paypal_lib->add_field('first_name',  '2');
					$this->paypal_lib->add_field('last_name',  '2');
					$this->paypal_lib->add_field('address1',  '2');
					$this->paypal_lib->add_field('city',  '2');
					$this->paypal_lib->add_field('state',  '2');
					$this->paypal_lib->add_field('zip',  '2');
					$this->paypal_lib->add_field('country',  '2');
					$this->paypal_lib->add_field('email', $email);
					//$this->paypal_lib->add_field('item_number',  $id);
					
					$this->paypal_lib->add_field('paymentaction',  'sale');
					//
					
					
					$this->paypal_lib->add_field('cbt',  'Return to Avenue 1-OH-1');
						   
					$this->paypal_lib->image($logo);
					
					$cartTotal = "";
					$cartCount = 1;
					
					foreach($_SESSION["cart_array"] as $each){
						$item_id = $each['product_id'];
						$product_name = '';
						
						$product_price = '';
						$details = '';
						
						//item quantity
						$product_qty = $each['quantity'];
						
						$product_details = $this->Products->get_product($item_id);
						if($product_details){
							foreach($product_details as $product){
								$product_name = $product->name;
								$product_price = $product->price;
								$details = $product->description;
							}
						}
						
						//item price
						$pricetotal = $product_price * $each['quantity'];
																		
						//total cart amount
						$cartTotal = $pricetotal + $cartTotal;
						
						$this->paypal_lib->add_field('item_number_'.$cartCount.'', $item_id);
						$this->paypal_lib->add_field('item_name_'.$cartCount.'', $product_name);
						$this->paypal_lib->add_field('amount_'.$cartCount.'',  $product_price); 
						$this->paypal_lib->add_field('quantity_'.$cartCount.'', $product_qty);
						
						$cartCount++;
					}
					
					$this->paypal_lib->paypal_auto_form();
				
				}
				
				//$data['success'] = true;
				//echo json_encode($data);
			
			}else{
				redirect('login');
			}				
		}	
		
		
		/**
		* Function to add credit card 
		* validation
		*/		
		public function add_paypal_deposit(){
			
				$this->load->library('form_validation');
			
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

				$this->form_validation->set_rules('amount','Amount','required|trim|xss_clean');
			
				$this->form_validation->set_message('required', '%s cannot be blank!');
            
				$id = $this->input->post('id');
			
				$rndm = md5(uniqid());
				
				if ($this->form_validation->run()){
							
				$new_deposit = $this->input->post('amount');
				$maskedPaypal = $this->input->post('maskedPaypal');
				$username = $this->session->userdata('username');
			
				$deposit_date = date('Y-m-d H:i:s');
							
				$this->session->set_flashdata('deposit_date', $deposit_date);
					
				//array of post value from add credit card form
				$data = array(
						'type' => 'PayPal',
						'payment_info' => $maskedPaypal,
						'deposit_amount' => $new_deposit,
						'username' => $username,
						'deposit_date' => $deposit_date,
					);

				//	echo json_encode($result);
				if ($this->Users->paypal_deposit($data)){
								
					$user = $this->Users->get_user($username);
						
					$id = $this->session->flashdata('insert_id');
						
					$result = $this->Users->get_payment_by_id($id);

					echo json_encode($result);
						
					$first_name = '';
					$email_address = ''; 
					
					foreach($user as $u){
						$first_name = $u->first_name;
						$email_address = $u->email_address;
					}
				
					//instant notification div
					$message = ' <p>Hello '.$first_name.',</p>';
					$message .= '<p>You have successfully added to $'.$deposit_amount.' your account!</p>';
						
					$this->session->set_flashdata('deposit_message', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i>'.$message.'</div>');
															
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
					$message .= '<p>You have successfully made a deposit of $ '.$deposit_amount.'.</p>';
					$message .= '</div>';
						
					$ci->email->message($message);
						
					$ci->email->send();
						
					//redirects to payment methods page
					redirect('account/payment_methods', 'refresh');	
						
				}else {
						//redirects to payment methods page
						redirect('account/payment_methods', 'refresh');
				}
			}else{

				$this->deposit($id, $rndm);
			}
		}
				
		//save billing info insert billing details value on db
		public function p_process() {

				/*
				Since this script is executed on the back end between the PayPal server and this
				script, you will want to log errors to a file or email. Do not try to use echo
				or print--it will not work! 

				Here I am turning on PHP error logging to a file called "ipn_errors.log". Make
				sure your web server has permissions to write to that file. In a production 
				environment it is better to have that log file outside of the web root.
				*/
				//ini_set('log_errors', true);
				//ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');
				
				// instantiate the IpnListener class
				//	$listener = new IpnListener();
				
				/*
				When you are testing your IPN script you should be using a PayPal "Sandbox"
				account: https://developer.paypal.com
				When you are ready to go live change use_sandbox to false.
				*/
				//	$listener->use_sandbox = true;

				/*
				The processIpn() method will encode the POST variables sent by PayPal and then
				POST them back to the PayPal server. An exception will be thrown if there is 
				a fatal error (cannot connect, your server is not configured properly, etc.).
				Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
				file we setup at the top of this file.

				The processIpn() method will send the raw data on 'php://input' to PayPal.
				*/
				try {
					$listener->requirePostMethod();
					$verified = $listener->processIpn();
				} catch (Exception $e) {
					error_log($e->getMessage());
					exit(0);
				}
				

				/*
				The processIpn() method returned true if the IPN was "VERIFIED" and false if it
				was "INVALID".
				*/
				if ($verified){
					// check whether the payment_status is Completed
					// check that txn_id has not been previously processed
					// check that receiver_email is your PayPal email
					// check that payment_amount/payment_currency are correct
					// process payment and mark item as paid.
					$new_deposit = '';
					$currency = '';
					$transactionID = '';
					$receiver_email = '';
					$payment_status = '';
					$payment_currency = '';

					
					/*
					Once you have a verified IPN you need to do a few more checks on the POST
					fields--typically against data you stored in your database during when the
					end user made a purchase (such as in the "success" page on a web payments
					standard button). The fields PayPal recommends checking are:
					
						1. Check the $_POST['payment_status'] is "Completed"
						2. Check that $_POST['txn_id'] has not been previously processed 
						3. Check that $_POST['receiver_email'] is your Primary PayPal email 
						4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] 
						   are correct
					
					Since implementations on this varies, I will leave these checks out of this
					example and just send an email using the getTextReport() method to get all
					of the details about the IPN.  
					*/
					$new_deposit = $_POST['payment_amount'];
					$transactionID = $_POST['txn_id'];
					$receiver_email = $_POST['receiver_email'];
					$payer_email = $_POST['payer_email'];
					$payment_status = $_POST['payment_status'];
					$payment_currency = $_POST['payment_currency'];
					$mypaypalemail = $this->session->userdata('business_email');;
					
					if (($payment_status == 'Completed') && ($receiver_email == $mypaypalemail) && ($payment_currency == 'USD')) 
					{
						// do your stuff here... if nothing else you must check that $payment_status=='Completed'
						//$new_deposit = $this->input->post('amount');
						//remove non-numbers from post
						$amount = preg_replace("/[^\d-.]+/","", $new_deposit);
						
						//$maskedPaypal = $this->session->userdata('maskedPaypal');
						$maskedPaypal = $this->Users->email_mask($payer_email);
						
						$username = $this->session->userdata('username');
				
						$deposit_date = date('Y-m-d H:i:s');
								
						$this->session->set_flashdata('deposit_date', $deposit_date);
						
						//array of post value from add credit card form
						$data = array(
							'type' => 'PayPal',
							'payment_info' => $maskedPaypal,
							'deposit_amount' => $amount,
							'username' => $username,
							'deposit_date' => $deposit_date,
						);

						//	echo json_encode($result);
						if ($this->Users->paypal_deposit($data)){
									
							$user = $this->Users->get_user($username);
							
							//Start email notification
							//get users first name for email message
							$first_name = '';
							$email_address = '';
							
							foreach($user as $u){
								$first_name = $u->first_name;
								$email_address = $u->email_address;
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
							$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
							$ci->email->to($email_address);
							$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
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
							$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
							$ci->email->to('getextra@global-sub.com');
							$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
							$ci->email->subject('Verified IPN');
							$ci->email->message($listener->getTextReport());
									
							$ci->email->send();
							
							redirect('payment/deposit_success', 'refresh');
						}
					
					}	//mail('YOUR EMAIL ADDRESS', 'Verified IPN', $listener->getTextReport());
					if(DEBUG == true) {
						error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
					}
				}else{
					/*
					An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
					a good idea to have a developer or sys admin manually investigate any 
					invalid IPN.
					*/
					
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
					$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
					$ci->email->to('getextra@global-sub.com');
					$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
					$ci->email->subject('Invalid IPN');
					$ci->email->message($listener->getTextReport());
									
					$ci->email->send();
						
					//mail('YOUR EMAIL ADDRESS', 'Invalid IPN', $listener->getTextReport());
					//redirects to payment methods page
					//redirect('account/payment_methods', 'refresh');
					redirect('account/payment_methods', 'refresh');
					
					if(DEBUG == true) {
						error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
					}
				}

			
		}
	

		/**
		* Function to handle view
		* paypal details
		* 
		*/	
		public function payment_methods_details(){
			
			if($this->session->userdata('logged_in') ){
					
				$paypal_detail = $this->db->select('*')->from('paypal_payment_methods')->where('username',$this->input->post('username'))->get()->row();
				
				//card types list dropdown
				$card_details = '<select name="select-cards-withdrawal" id="cards-withdrawal">';
				
				$this->db->from('card_payment_methods');
				$this->db->where('username', $this->input->post('username'));
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$card_details .= '<option value="'.$row['id'].'">XXXX-XXXX-XXXX-'.substr($row['card_number'],-4).'</option>';			
					}
					$data['success'] = true;
				}
				$card_details .= '</select>';
				$data['card_details'] = $card_details;
				
				if($paypal_detail){

						$data['paypal_id'] = $paypal_detail->id;
						$data['masked_PayPal'] = $this->Users->email_mask($paypal_detail->PayPal_email);
						$data['success'] = true;
					
				}
				if($result->num_rows() < 0 || !$paypal_detail){
					$data['success'] = false;
				}
				
				echo json_encode($data);
				
			}else{
				redirect('main/');
			}
			
		}

		/**
		* Function to handle view
		* card details
		* 
		*/	
		public function card_details(){
			
			if($this->session->userdata('logged_in')){
				
				$detail = $this->db->select('*')->from('card_payment_methods')->where('id',$this->input->post('id'))->get()->row();
				
				$id = $this->input->post('id');

				if($detail){

						$data['id'] = $detail->id;
						$data['type'] = $detail->type;			
						$data['name_on_card'] = $detail->name_on_card;
						$data['card_number'] = $detail->card_number;
						$data['masked_card'] = 'XXXX-XXXX-XXXX-'.substr($detail->card_number,-4);
						
						$expiry_month = '<select name="expiry_month">';
						//$expiry_month .= '<option value="'.$detail->expiry_month.'" selected="selected">'.$detail->expiry_month.'</option>';
											for($month = 1; $month <= 12; $month++){
												$default_month = ($month == $detail->expiry_month)?'selected':'';
						$expiry_month .= '<option value="'.sprintf("%02d", $month).'" '.$default_month.'>'.sprintf("%02d", $month).'</option>';
											}
						$expiry_month .= '</select>';
						
						$data['expiry_month'] = $expiry_month;
						
						$data['expiry_m'] = $detail->expiry_month;
						
						$expiry_year = '<select name="expiry_year">';
						//$expiry_year .= '<option value="'.$detail->expiry_year.'" selected="selected">'.$detail->expiry_year.'</option>';
											for($year=date("Y");$year<=date("Y")+10;$year++){
												//$sel = ($i == date('Y')) ? 'selected' : '';
												$default_year = ($year == $detail->expiry_year)?'selected':'';
						$expiry_year .= '<option value="'.$year.'" '.$default_year.'>'.$year.'</option>';
											}
						$expiry_year .= '</select>';
						$data['expiry_year'] = $expiry_year;
						
						$data['expiry_y'] = $detail->expiry_year;
						
						$data['billing_street_address'] = $detail->card_billing_street_address;
						$data['billing_city'] = $detail->card_billing_city;
						$data['billing_postcode'] = $detail->card_billing_postcode;
						$data['billing_state'] = $detail->card_billing_state;
						$data['billing_country'] = $detail->card_billing_country;
						
						$data['username'] = $detail->username;

						$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
						
						$data['model'] = 'card_payment_methods';
						$data['success'] = true;
					
				}else {
					$data['success'] = false;
				}
				
				echo json_encode($data);
				
			}else{
				redirect('main/');
			}
			
		}


		/**
		* Function to handle view
		* paypal details
		* 
		*/	
		public function paypal_details(){
			
			if($this->session->userdata('logged_in') ){
					
				$detail = $this->db->select('*')->from('paypal_payment_methods')->where('id',$this->input->post('id'))->get()->row();
				
				$id = $this->input->post('id');

				if($detail){

						$data['id'] = $detail->id;
						$data['type'] = $detail->type;			
						$data['PayPal_email'] = $detail->PayPal_email;
						$data['masked_PayPal'] = $this->Users->email_mask($detail->PayPal_email);
						$data['username'] = $detail->username;
						$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
						
						$data['model'] = 'paypal_payment_methods';
						$data['success'] = true;
					
				}else {
					$data['success'] = false;
				}
				
				echo json_encode($data);
				
			}else{
				redirect('main/');
			}
			
		}


		/**
		* Function to add credit card 
		* validation
		*/		
		public function add_paypal(){
			
            $this->load->library('form_validation');
            //$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
            
            $this->form_validation->set_rules('paypal_email','PayPal','required|trim|xss_clean|valid_email|is_unique[paypal_payment_methods.PayPal_email]');
				  
			//set all the rules in $validation_rules array
			$validation_rules = array(
				   array(
						 'field'   => 'paypal_email',
						 'label'   => 'PayPal',
						 'rules'   => 'required|trim|xss_clean|valid_email|is_unique[paypal_payment_methods.PayPal_email]'
					  ),
				  
			);
			$this->form_validation->set_message('required', '<i class="fa fa-exclamation-triangle"></i> %s cannot be blank!');
			$this->form_validation->set_message('valid_email', '<i class="fa fa-exclamation-triangle"></i> Please enter a valid email!');
            $this->form_validation->set_message('is_unique', '<i class="fa fa-exclamation-triangle"></i> This PayPal account has already been registered');
				  
            $errors_array = $this->validation_errors_to_array($validation_rules);
				  
			if ($this->form_validation->run()){
					
					$username = $this->session->userdata('username');
					
					$table = 'paypal_payment_methods'; 
					
					//array of post value from add credit card form
					$d = array(
						'type' => 'PayPal',
						'PayPal_email' => $this->input->post('paypal_email'),
						'username' => $username,
						'date_added' => date('Y-m-d H:i:s'),
					);				
					
					if ($this->Users->insert_to_db($table, $d)){
						
						$user = $this->Users->get_user($username);
					
						$first_name = '';
						$email_address = '';
							
						foreach($user as $u){
							$first_name = $u->first_name;
							$email_address = $u->email_address;
						}
								
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
						$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
						$ci->email->to($email_address);
						$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
						$ci->email->subject('Added a new PayPal account');
							
						//compose email message
						$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
						$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
						
						$message .= "<p>Hello ";
						$message .= $first_name. ",</p>";
						$message .= "<p>You have successfully added a new PayPal account.</p>";
						$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
						$message .= "</div>";
							
						$ci->email->message($message);
							
						$ci->email->send();
						
						$this->session->set_flashdata('paypal_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i> The PayPal account has been added!</div>');
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"><i class="fa fa-check-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The PayPal account has been added!</div>';
						
						//redirects to payment methods page
						//redirect('account/payment_methods', 'refresh');	
						
					}else {
							$data['success'] = false;
							$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-triangle"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The PayPal account could not be added!</div>';
				
							//redirects to payment methods page
							//redirect('account/payment_methods', 'refresh');
					}
			}else{
				$data['success'] = false;
				$data['paypal_email'] = $this->input->post('paypal_email'); 
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				
				//$this->payment_methods();
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			// echo json_encode($data);			
		}

						
		/**
		* Function to validate update admin 
		* form
		*/			
		public function update_paypal(){
				
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
           
			$this->form_validation->set_rules('paypal_email','PayPal','required|trim|xss_clean|valid_email|is_unique[paypal_payment_methods.PayPal_email]');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email!');
				
			if ($this->form_validation->run()){
				
				$username = $this->session->userdata('username');		

				$d = array(
					'type' => 'PayPal',
					'PayPal_email' => $this->input->post('paypal_email'),
					'username' => $username,
					'date_added' => date('Y-m-d H:i:s'),
				);
				
				if ($this->Paypal_payment_methods->update_paypal($d)){	

					$user = $this->Users->get_user($username);
							
					$first_name = '';
					$email_address = '';
							
					foreach($user as $u){
						$first_name = $u->first_name;
						$email_address = $u->email_address;
					}
								
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
					$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
					$ci->email->to($email_address);
					$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
					$ci->email->subject('Updated payment method');
							
					//compose email message
					$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
					$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
						
					$message .= "<p>Hello ";
					$message .= $first_name. ",</p>";
					$message .= "<p>You have successfully updated a payment method.</p>";
					$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
					$message .= "</div>";
							
					$ci->email->message($message);
							
					$ci->email->send();			
				
					$this->session->set_flashdata('paypal_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i> Your PayPal account has been updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your PayPal account has been updated!</div>';
					//redirect('account/payment_methods');
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-triangle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
				$this->session->set_flashdata('paypal_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDivError").fadeOut("slow"); }, 5000);</script><div class="commentDivError text-center">'.validation_errors().'</div>');
					
				//redirect('account/payment_methods');
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			

	
		
		/**
		* Function to add credit card 
		* validation
		*/		
		public function add_credit_card(){
			
            $this->load->library('form_validation');
            
			//$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
            
			$this->form_validation->set_rules('card_type','Card Type','required|trim|xss_clean');
            $this->form_validation->set_rules('name_on_card','Name on Card','required|trim|xss_clean|min_length[5]');
			$this->form_validation->set_rules('card_number','Card Number','required|trim|xss_clean|min_length[16]|numeric|is_unique[card_payment_methods.card_number]');
			$this->form_validation->set_rules('expiry_month','Expiry Month','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('expiry_year','Expiry Year','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('card_billing_street_address','Address','required|trim|xss_clean');
			$this->form_validation->set_rules('card_billing_city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('card_billing_postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('card_billing_state','State','trim|xss_clean');
			$this->form_validation->set_rules('card_billing_country','Country','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('min_length', '%s must be longer!');
            $this->form_validation->set_message('exact_length', 'Please check the length of %s !');
            $this->form_validation->set_message('is_unique', 'Card already registered!');
            
			if ($this->form_validation->run()){
					
					$username = $this->session->userdata('username');
					
					//check if cc already exists
					if($this->Card_payment_methods->isUnique_cc($this->input->post('card_number'))){
						
						$city_detail = $this->db->select('*')->from('cities')->where('id',$this->input->post('card_billing_city'))->get()->row();
						$state_detail = $this->db->select('*')->from('states')->where('id',$this->input->post('card_billing_state'))->get()->row();
						$country_detail = $this->db->select('*')->from('countries')->where('id',$this->input->post('card_billing_country'))->get()->row();
				
						$city = $city_detail->name;
						$state = $state_detail->name;
						$country = $country_detail->name;
						
						//array of post value from add credit card form
						$ccdata = array(
							'type' => $this->input->post('card_type'),
							'name_on_card' => $this->input->post('name_on_card'),
							'card_number' => $this->input->post('card_number'),
							'expiry_month' => $this->input->post('expiry_month'),
							'expiry_year' => $this->input->post('expiry_year'),
							'card_billing_street_address' => $this->input->post('card_billing_street_address'),
							'card_billing_city' => $city,
							'card_billing_postcode' => $this->input->post('card_billing_postcode'),
							'card_billing_state' => $state,
							'card_billing_country' => $country,
							'username' => $username,
							'date_added' => date('Y-m-d H:i:s'),
						);
						
						if ($this->Card_payment_methods->add_cc($ccdata)){
							
							$user = $this->Users->get_user($username);
							
							$first_name = '';
							$email_address = '';
							
							foreach($user as $u){
								$first_name = $u->first_name;
								$email_address = $u->email_address;
							}
								
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
							$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
							$ci->email->to($email_address);
							$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
							$ci->email->subject('Added a new payment method');
							
							//compose email message
							$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
							$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
						
							$message .= "<p>Hello ";
							$message .= $first_name. ",</p>";
							$message .= "<p>You have successfully added a new payment method.</p>";
							$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
							$message .= "</div>";
							
							$ci->email->message($message);
							
							$ci->email->send();
							
							$this->session->set_flashdata('cc_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i> The PayPal account has been added!</div>');
							$data['success'] = true;
							$data['notif'] = '<div class="alert alert-success text-center" role="alert"><i class="fa fa-check-circle"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The credit card has been added!</div>';
							
							//redirects to payment methods page
							//redirect('account/payment_methods', 'refresh');	
							
						}else {
								$data['success'] = false;
								$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-triangle"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The credit card could not be added!</div>';
					
								//redirects to payment methods page
								//redirect('account/payment_methods', 'refresh');
						}
					}
			}else{
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				
				//$this->payment_methods();
			}
				// Encode the data into JSON
				$this->output->set_content_type('application/json');
				$data = json_encode($data);

				// Send the data back to the client
				$this->output->set_output($data);			
		}


		
		/**
		* Function to validate update admin 
		* form
		*/			
		public function update_card(){
				
			$this->load->library('form_validation');
			
			//$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
            $this->form_validation->set_rules('card_number','Card Number','required|trim|xss_clean');
			$this->form_validation->set_rules('name_on_card','Name on Card','required|trim|xss_clean');
			$this->form_validation->set_rules('expiry_month','Expiry Month','required|trim|xss_clean');
			$this->form_validation->set_rules('expiry_year','Expiry Year','required|trim|xss_clean');
			
			$this->form_validation->set_rules('card_billing_street_address','Billing Address','required|trim|xss_clean');
			
			$this->form_validation->set_rules('card_billing_city','Billing City','required|trim|xss_clean');
			$this->form_validation->set_rules('card_billing_postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('card_billing_state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('card_billing_country','Country','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter a %s!');
				
			if ($this->form_validation->run()){
				
				$username = $this->session->userdata('username');		

				$d = array(
					'name_on_card' => $this->input->post('name_on_card'),
					'card_number' => $this->input->post('card_number'),
					'expiry_month' => $this->input->post('expiry_month'),
					'expiry_year' => $this->input->post('expiry_year'),
					'card_billing_street_address' => $this->input->post('card_billing_street_address'),
					'card_billing_city' => $this->input->post('card_billing_city'),
					'card_billing_postcode' => $this->input->post('card_billing_postcode'),
					'card_billing_state' => $this->input->post('card_billing_state'),
					'card_billing_country' => $this->input->post('card_billing_country'),
					'date_added' => date('Y-m-d H:i:s'),
				);
				
				if ($this->Card_payment_methods->update_card($d)){	
					
					$user = $this->Users->get_user($username);
							
					$first_name = '';
					$email_address = '';
							
					foreach($user as $u){
						$first_name = $u->first_name;
						$email_address = $u->email_address;
					}
								
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
					$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
					$ci->email->to($email_address);
					$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
					$ci->email->subject('Updated payment method');
							
					//compose email message
					$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
					$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
						
					$message .= "<p>Hello ";
					$message .= $first_name. ",</p>";
					$message .= "<p>You have successfully updated a payment method.</p>";
					$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
					$message .= "</div>";
							
					$ci->email->message($message);
							
					$ci->email->send();
							
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i> Your credit card has been updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your credit card has been updated!</div>';
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			

		/**
         * cancel Function
         * @param int $issue_id
         */
        public function remove() {
			
			if($this->session->userdata('logged_in') && ($this->input->post('id') != '' && $this->input->post('model') != '')){
				
				$username = $this->session->userdata('username');
				
				$id = $this->input->post('id');	
				$model = $this->input->post('model');
				
				//$this->load->model(array('Issue'));
				$new_model = ucfirst($model.'_model');
				//$issue = new Issue();	
				$object = new $new_model();
				//$issue->load($issue_id);
				$object->load($id);
				$object->delete();
				
				$user = $this->Users->get_user($username);
							
				$first_name = '';
				$email_address = '';
							
				foreach($user as $u){
					$first_name = $u->first_name;
					$email_address = $u->email_address;
				}
								
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
				$ci->email->from('getextra@global-sub.com', 'Avenue 1-OH-1');
				$ci->email->to($email_address);
				$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
				$ci->email->subject('Removed payment method');
							
				//compose email message
				$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
				$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Get Extra Hands">'.img('assets/images/get.png').'</a></div><br/>';
						
				$message .= "<p>Hello ";
				$message .= $first_name. ",</p>";
				$message .= "<p>You have successfully removed a payment method.</p>";
				$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
				$message .= "</div>";
							
				$ci->email->message($message);
							
				$ci->email->send();
							
				$this->session->set_flashdata('removed', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv text-center"><i class="fa fa-check-circle"></i> The account has been removed!</div>');					
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The account has been removed!</div>';

				// Encode the data into JSON
				$this->output->set_content_type('application/json');
				$data = json_encode($data);

				// Send the data back to the client
				$this->output->set_output($data);
				//echo json_encode($data);				
														
			}else{
			
				redirect('main/');
			}	
		}	

	
	
	}