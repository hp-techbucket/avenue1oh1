<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function index()
	{
		$this->contact_information();
	}
	
	public function contact_information()
	{
		
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//set cart count
			$data['cart_count'] = 0;
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
			
				//assign page title name
			$data['pageTitle'] = 'Checkout';
			
			//assign page ID
			$data['pageID'] = 'checkout';
						
			$this->load->view('pages/header', $data);
				
			$this->load->view('account_pages/contact_information_page', $data);
				
			$this->load->view('account_pages/footer');
		
		}else{
			
			redirect('cart');
		}
		
	}
	
		
	/**
	* Function to validate user contact
	* information
	*/
    public function contact_information_validation() {
			
        $this->session->keep_flashdata('redirectURL');
			
        $this->load->library('form_validation');
			
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
		$this->form_validation->set_rules('checkout_email','Email','trim|xss_clean|valid_email');
        
		$this->form_validation->set_rules('buyer_accepts_marketing','Subscription','xss_clean|trim');
        
		$this->form_validation->set_rules('first_name','First name','required|trim|xss_clean');
		
		$this->form_validation->set_rules('last_name','Last name','required|trim|xss_clean');
		$this->form_validation->set_rules('company','Company','trim|xss_clean');
		$this->form_validation->set_rules('shipping_address','Address','required|trim|xss_clean');
		$this->form_validation->set_rules('shipping_city','City','required|trim|xss_clean');
		$this->form_validation->set_rules('shipping_zip','Postal code','required|trim|xss_clean');
		$this->form_validation->set_rules('shipping_state','State','required|trim|xss_clean');
		$this->form_validation->set_rules('shipping_country','Country','required|trim|xss_clean');
		$this->form_validation->set_rules('contact_phone','Phone','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
			
        $this->form_validation->set_message('required', '%s cannot be blank!');
		$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
							
		if ($this->form_validation->run()){
			
			$country_id = html_escape($this->input->post('shipping_country'));
			$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
			
			$shipping_country = '';
			$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
			if($detail){
				$shipping_country = $detail->name;
			}

			/*$session = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'checkout_email' => $this->input->post('checkout_email'),
				'company' => $this->input->post('company'),
				'shipping_address' => $this->input->post('shipping_address'),
				'shipping_city' => $this->input->post('shipping_city'),
				'shipping_zip' => $this->input->post('shipping_zip'),
				'shipping_state' => $this->input->post('shipping_state'),
				'shipping_country' => $shipping_country,
				'contact_phone' => $this->input->post('contact_phone'),
				'buyer_accepts_marketing' => $this->input->post('buyer_accepts_marketing'),
				'contact_information' => 1,
			);*/
				
			//$this->session->set_userdata($session);
			
			// SET CONTACT INFO SESSION
			$_SESSION["contact_info_array"] = array(
				0 => array(
					"first_name" => $this->input->post('first_name'), 
					"last_name" => $this->input->post('last_name'), 
					"checkout_email" => $this->input->post('checkout_email'),
					"email" => $this->input->post('checkout_email'),
					"company" => $this->input->post('company'),
					"shipping_address" => $this->input->post('shipping_address'), 
					"shipping_city" => $this->input->post('shipping_city'),
					"shipping_zip" => $this->input->post('shipping_zip'), 
					"shipping_state" => $this->input->post('shipping_state'),
					"shipping_country" => $shipping_country, 
					"contact_phone" => $this->input->post('contact_phone'),
					"buyer_accepts_marketing" => $this->input->post('buyer_accepts_marketing'),
					"contact_information" => 1,
				)
			);
			
			$data['success'] = true;
			$data['previous_step'] = $this->input->post('previous_step');
			$data['step'] = $this->input->post('step');
			//redirect to next page
			//redirect('checkout/shipping-method');
				
        }else {		
			//redirects to contact information page
			//$this->contact_information();	
			$data['success'] = false;
			$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
        }
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
    }
	
	
	
	public function shipping_method(){
		
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//set cart count
			$data['cart_count'] = 0;
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
			
			//assign page title name
			$data['pageTitle'] = 'Shipping Method';
			
			//assign page ID
			$data['pageID'] = 'shipping_method';
						
			$this->load->view('pages/header', $data);
				
			$this->load->view('account_pages/shipping_method_page', $data);
				
			$this->load->view('account_pages/footer');
			
		}else{
			
			redirect('cart');
		}
	
	}
	
	
		
	/**
	* Function to validate user shipping
	* method
	*/
    public function shipping_method_validation() {
			
        $this->session->keep_flashdata('redirectURL');
			
        $this->load->library('form_validation');
			
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
		$this->form_validation->set_rules('shipping','Shipping','required|trim|xss_clean');
        
			
        $this->form_validation->set_message('required', '%s cannot be blank!');
					
		if ($this->form_validation->run()){
			
			$shipping_details = explode('-',$this->input->post('shipping'));
			
			//get shipping type, domestic or international
			$shipping_type = $shipping_details[0];
			
			//get shipping company name
			$shipping_company = $shipping_details[1];
			
			//get unit shipping cost
			$shipping_costs = $shipping_details[2];
			
			//count items in cart
			$cart_count = count($_SESSION["cart_array"]);
			
			//get additional items shipping costs
			//as a fraction of initial shipping cost
			$additional_items_unit_cost = $shipping_costs / 2;
			
			//count additional items
			$additional_items_count = $cart_count - 1;
			
			//get additional items cost
			$total_additional_items_cost = $additional_items_unit_cost * $additional_items_count;
			
			//calculate total shipping cost
			$total_shipping_costs = $shipping_costs + $total_additional_items_cost;
			/*
			$session = array(
				'shipping_type' => $shipping_type,
				'shipping_company' => $shipping_company,
				'shipping_costs' => $shipping_costs,
				'total_shipping_costs' => $total_shipping_costs,
				'shipping_method' => 1,
			);
			*/
			//$this->session->set_userdata($session);
			
			
			// SET SHIPPING SESSION
			$_SESSION["shipping_array"] = array(
				0 => array(
					"shipping_type" => $shipping_type, 
					"shipping_company" => $shipping_company, 
					"shipping_costs" => $shipping_costs,
					"total_shipping_costs" => $total_shipping_costs,
					"shipping_method" => 1,
				)
			);
			
			
			$data['success'] = true;
			$data['previous_step'] = $this->input->post('previous_step');
			$data['step'] = $this->input->post('step');
			//redirect to next page
			//redirect('checkout/shipping-method');
				
        }else {		
			//redirects to contact information page
			//$this->contact_information();	
			$data['success'] = false;
			$data['notif'] = '<div class="text-center floating-alert-box" role="alert">'.validation_errors().'</div>';
        }
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
    }
	
	
	
	public function payment_method(){
		
		//set cart count
		$data['cart_count'] = 0;
			
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
				
			//assign page title name
			$data['pageTitle'] = 'Payment Method';
			
			//assign page ID
			$data['pageID'] = 'payment_method';
						
			$this->load->view('pages/header', $data);
				
			$this->load->view('account_pages/payment_method_page', $data);
				
			$this->load->view('account_pages/footer');
			
		}else{
			
			redirect('cart');
		}
	
	
	}
		
	
	
	
		/**
		* Function to process payment 
		* validation
		*/		
		public function paypal_payment(){
			
			if($this->session->userdata('logged_in')){
				
				$data = array(
					//'maskedPaypal' => $this->Users->email_mask($object->PayPal_email),
					'business_email' => 'paypal@avenue1oh1.com',
				);		
				
				$this->session->set_userdata($data);
				
				$email = $this->session->userdata('email');
				
				if(isset($_SESSION["cart_array"])){
					
					$this->session->set_flashdata('paypal_processing', '1');
						
					redirect('paypal/payment-processing');
				
				}
				
				//$data['success'] = true;
				//echo json_encode($data);
			
			}else{
				$this->session->set_flashdata('notice', '<div class="alert alert-danger text-danger text-center" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please login to continue your checkout!</div>');
				$cart_url = base_url().'store/cart';
				//$url = 'login?redirectURL='.urlencode(current_url());
				$url = 'login?redirectURL='.urlencode($cart_url);
				redirect($url);
				//redirect('login');
			}				
		}	
		
		
	
	public function paypal_processing(){
		
		if($this->session->userdata('logged_in')){
			
			if($this->session->flashdata('paypal_processing')){		
			
				//set cart count
				$data['cart_count'] = 0;
					
				//check if cart session is set
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
				$data['page_redirect'] = '<script type="text/javascript" language="javascript">setTimeout(function() {$("#paypalForm").submit();}, 5000);</script>';
				
					
				
				//assign page title name
				$data['pageTitle'] = 'PayPal Payment';
				
				//assign page ID
				$data['pageID'] = 'payment_processing';
							
				$this->load->view('pages/header', $data);
					
				$this->load->view('account_pages/payment_processing_page', $data);
					
				$this->load->view('pages/footer');
				
			}else{
				redirect('cart');
			}
			
		 
		}else {
			
			redirect('login');
		} 		
	
	}
			
	
	
	
	
	
	
	
	
	
	
	
	
}
