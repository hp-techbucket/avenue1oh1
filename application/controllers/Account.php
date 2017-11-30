<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

		/**
		* Function to the account
		* index
		*/	
		public function index(){
			
			if($this->session->userdata('logged_in')){
			
				redirect('account/dashboard');
			
			}else{
				redirect('login');		
			}
		}
		
		/**
		* Function to access user account
		* landing page / dashboard
		*/		
		public function dashboard(){
			 
			if($this->session->userdata('logged_in')){ 
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				//checkout redirect
				if($this->session->flashdata('checkoutURL')){
					$redirect = $this->session->flashdata('checkoutURL');
					redirect($redirect);
				}
				
				$email = $this->session->userdata('email');
				
				$data['users'] = $this->Users->get_user($email);
				
				$data['default_address_array'] = $this->Default_address->get_address($email);
				
				$data['secondary_addresses_array'] = $this->Addresses->get_addresses($email);
				

				//country select dropdown
				$select_country = '';
				$select_country .= '<select name="country" id="country" class="form-control select2">';
				$select_country .= '<option value="0" selected="selected">Select Country</option>';
						
				$this->db->from('countries');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$select_country .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';			
					}
				}
				$select_country .= '</select>';
					
				$data['select_country'] = $select_country;
				
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
				$data['pageTitle'] = 'Account';
				
				//assign page ID
				$data['pageID'] = 'dashboard';
							
				//load header
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/user_dashboard_page', $data);
				
				//load main footer
				$this->load->view('account_pages/footer');				
				
			}
			else {
					$url = 'login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
		}
		
		
		
		/**
		* Function to handle display
		* user details
		* 
		*/	
		public function user_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$email = html_escape($this->input->post('email'));
			//$email = $this->session->userdata('email');
			//$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('users')->where('email_address',$email)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['first_name'] = $detail->first_name;			
					$data['last_name'] = $detail->last_name;
					$data['company_name'] = $detail->company_name;
					$data['address_line_1'] = $detail->address_line_1;
					$data['address_line_2'] = $detail->address_line_2;
					$data['city'] = $detail->city;
					$data['postcode'] = $detail->postcode;
					$data['state'] = $detail->state;
					$data['country'] = $detail->country;
					
					$country_id = '';
					//get country id
					$this->db->from('countries');
					$this->db->where('name', $detail->country);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$country_id = $row['id'];
						}
					}
					$data['country_id'] = $country_id;
					
					//get states
					//$select_states = '<select name="state" id="state" class="form-control select2 state">';
					$select_states = '';
					//$select_states .= '<option value="0" selected="selected">Select State</option>';
					
					$this->db->from('states');
					$this->db->where('country_id', $country_id);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['name']) == strtolower($detail->state))?'selected':'';
							$select_states .= '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';			
						}
					}
					//$select_states .= '</select>';
					$data['select_states'] = $select_states;
					$data['phone'] = $detail->phone;
					
					$data['model'] = 'users';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
			
		
		/**
		* Function to handle display
		* address details
		* 
		*/	
		public function address_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('addresses')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['first_name'] = $detail->first_name;			
					$data['last_name'] = $detail->last_name;
					$data['company_name'] = $detail->company_name;
					$data['address_line_1'] = $detail->address_line_1;
					$data['address_line_2'] = $detail->address_line_2;
					$data['city'] = $detail->city;
					$data['postcode'] = $detail->postcode;
					$data['state'] = $detail->state;
					$data['country'] = $detail->country;
					
					$country = '';
					$country_id = '';
					$select_country = '';
					//get country id
					$this->db->from('countries');
					//$this->db->where('name', $detail->country);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							if(strtolower($row['name']) == strtolower($detail->country)){
								$country_id = $row['id'];
							}
							
							$default = (strtolower($row['name']) == strtolower($detail->country))?'selected':'';
							$select_country .= '<option value="'.$row['id'].'" '.$default.'>'.$row['name'].'</option>';
						}
					}
					$data['select_country'] = $select_country;
					
					$data['country_id'] = $country_id;
					
					//get states
					//$select_states = '<select name="state" id="state" class="form-control select2 state">';
					$select_states = '';
					//$select_states .= '<option value="0" selected="selected">Select State</option>';
					
					$this->db->from('states');
					$this->db->where('country_id', $country_id);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['name']) == strtolower($detail->state))?'selected':'';
							$select_states .= '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';			
						}
					}
					//$select_states .= '</select>';
					$data['select_states'] = $select_states;
					
					$data['phone'] = $detail->phone;
					
					//check if user already has data saved
					//in default table
					$data['default_set'] = false;
					$email = $this->session->userdata('email');
					$detail_default_address = $this->db->select('*')->from('default_address')->where('user_email',$email)->get()->row();
					if($detail_default_address){
						$data['default_set'] = true;
					}
					
					$data['model'] = 'addresses';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		
		/**
		* Function to handle display
		* address details
		* 
		*/	
		public function default_address_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('default_address')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['first_name'] = $detail->first_name;			
					$data['last_name'] = $detail->last_name;
					$data['company_name'] = $detail->company_name;
					$data['address_line_1'] = $detail->address_line_1;
					$data['address_line_2'] = $detail->address_line_2;
					$data['city'] = $detail->city;
					$data['postcode'] = $detail->postcode;
					$data['state'] = $detail->state;
					$data['country'] = $detail->country;
					
					$country = '';
					$country_id = '';
					$select_country = '';
					//get country id
					$this->db->from('countries');
					$this->db->where('name', $detail->country);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							if(strtolower($row['name']) == strtolower($detail->country)){
								$country_id = $row['id'];
							}
							
							$default = (strtolower($row['name']) == strtolower($detail->country))?'selected':'';
							$select_country .= '<option value="'.$row['id'].'" '.$default.'>'.$row['name'].'</option>';
						}
					}
					$data['select_country'] = $select_country;
					
					$data['country_id'] = $country_id;
					
					//get states
					//$select_states = '<select name="state" id="state" class="form-control select2 state">';
					$select_states = '';
					//$select_states .= '<option value="0" selected="selected">Select State</option>';
					
					$this->db->from('states');
					$this->db->where('country_id', $country_id);
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = (strtolower($row['name']) == strtolower($detail->state))?'selected':'';
							$select_states .= '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';			
						}
					}
					//$select_states .= '</select>';
					$data['select_states'] = $select_states;
					
					$data['phone'] = $detail->phone;
					
					$data['model'] = 'default_address';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
				

		/**
		* Function to ensure a country is selected 
		* 
		*/			
		public function unique_address(){
			
			$email = $this->session->userdata('email');
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$country_id = html_escape($this->input->post('country'));
			$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
				
			$country = '';
			$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
			if($detail){
				$country = $detail->name;
			}
			
			$where = array(
				'address_line_1' => $this->input->post('address_line_1'),
				'address_line_2' => $this->input->post('address_line_2'),
				'city' => ucwords($this->input->post('city')),
				'postcode' => $this->input->post('postcode'),
				'state' => ucwords($this->input->post('state')),
				'country' => ucwords($country),
				'phone' => $this->input->post('phone'),
				'user_email' => $email,
			);
			
			$address_default = html_escape($this->input->post('address_default'));
			$unique_address = false;
				
			if($address_default == '1'){
				if(!$this->Default_address->unique_address($where)){
					$this->form_validation->set_message('unique_address', 'Address already exist in your account!');
					return FALSE;
				}else{
					return TRUE;
				}
			}else{
				if(!$this->Addresses->unique_address($where)){
					$this->form_validation->set_message('unique_address', 'Address already exist in your account!');
					return FALSE;
				}else{
					return TRUE;
				}	
			}	
			
		}



		/**
		* Function to handle add address validation
		*
		*/	        
        public function add_address() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
            $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
            $this->form_validation->set_rules('company_name','Company Name','trim|xss_clean');
			$this->form_validation->set_rules('address_line_1','Address 1','required|trim|xss_clean|callback_unique_address');
			$this->form_validation->set_rules('address_line_2','Address 2','trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postal Code','required|trim|xss_clean');
			$this->form_validation->set_rules('phone','Phone number','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
            
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
							
			
			if ($this->form_validation->run()){
				
				$email = $this->session->userdata('email');
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$country_id = html_escape($this->input->post('country'));
				$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
				
				$address_default = html_escape($this->input->post('address_default'));
				$description = '';
						
				$country = '';
				
				$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
			
				if($detail){
					$country = $detail->name;
				}
				
				$saved_address = false;
				//add new address to the database
				if($address_default == '1'){
					
					$detail_default_address = $this->db->select('*')->from('default_address')->where('user_email',$email)->get()->row();
					
					//if true,update record
					if($detail_default_address){
						
						$u = array(			
							'first_name' => ucwords($this->input->post('first_name')),
							'last_name' => ucwords($this->input->post('last_name')),
							'company_name' => strtoupper($this->input->post('company_name')),
							'address_line_1' => $this->input->post('address_line_1'),
							'address_line_2' => $this->input->post('address_line_2'),
							'city' => ucwords($this->input->post('city')),
							'postcode' => $this->input->post('postcode'),
							'state' => ucwords($this->input->post('state')),
							'country' => ucwords($country),
							'phone' => $this->input->post('phone'),
						);
						
						$saved_address = $this->Default_address->update_default($u, $email);
						
					}else{
						
						$add = array(			
							'first_name' => ucwords($this->input->post('first_name')),
							'last_name' => ucwords($this->input->post('last_name')),
							'user_email' => $email,
							'company_name' => strtoupper($this->input->post('company_name')),
							'address_line_1' => $this->input->post('address_line_1'),
							'address_line_2' => $this->input->post('address_line_2'),
							'city' => ucwords($this->input->post('city')),
							'postcode' => $this->input->post('postcode'),
							'state' => ucwords($this->input->post('state')),
							'country' => ucwords($country),
							'phone' => $this->input->post('phone'),
							'date_added' => date('Y-m-d H:i:s'),
						);
						
						$saved_address = $this->Default_address->add_address($add);
						
					}
					
					
					//update users details
					$update = array(			
						'first_name' => ucwords($this->input->post('first_name')),
						'last_name' => ucwords($this->input->post('last_name')),
						'company_name' => strtoupper($this->input->post('company_name')),
						'address_line_1' => $this->input->post('address_line_1'),
						'address_line_2' => $this->input->post('address_line_2'),
						'city' => ucwords($this->input->post('city')),
						'postcode' => $this->input->post('postcode'),
						'state' => ucwords($this->input->post('state')),
						'country' => ucwords($country),
						'phone' => $this->input->post('phone'),
					);
					
					$this->Users->user_update($update, $email);
					$description = 'added new default address and updated account';
						
					
				}else{
					$saved_address = $this->Addresses->add_address($add);
					$description = 'added new address';
						
				}
		
				//confirm saved
				if ($saved_address){

					$user_array = $this->Users->get_user($email);
						
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
						
					//update activities table
					$activity = array(			
						'name' => $fullname,
						'email' => $email,
						'description' => $description,
						'keyword' => 'Address',
						'activity_time' => date('Y-m-d H:i:s'),
					);
							
					$this->Site_activities->insert_activity($activity);
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i> Address added to your account.</div>';
						
						
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not add address to your account!</div>';
									
				} 	
				
				
            }
            else {
				$data['success'] = false;
				$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				
            }
			
			// Encode the data into JSON
			//$this->output->set_content_type('application/json');
			//$data = json_encode($data);

			// Send the data back to the client
			//$this->output->set_output($data);
			echo json_encode($data);		
			
        }		
		


		/**
		* Function to handle update address validation
		*
		*/	        
        public function update_address() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
            $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
            $this->form_validation->set_rules('company_name','Company Name','trim|xss_clean');
			$this->form_validation->set_rules('address_line_1','Address 1','required|trim|xss_clean');
			$this->form_validation->set_rules('address_line_2','Address 2','trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postal Code','required|trim|xss_clean');
			$this->form_validation->set_rules('phone','Phone number','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
            
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
							
			
			if ($this->form_validation->run()){
				
				$email = $this->session->userdata('email');
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$pid = html_escape($this->input->post('addressID'));
				$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
				
				$default = html_escape($this->input->post('defaultAdd'));
				
				$country_id = $this->input->post('country');
				$cid = preg_replace('#[^0-9]#i', '', $country_id); // filter everything but numbers
				
				$description = '';
				
				//get country name from id
				$country = '';
				$detail = $this->db->select('*')->from('countries')->where('id',$cid)->get()->row();
				if($detail){
					$country = $detail->name;
				}
				
				
				$saveToDb = false;
				
				//get checkbox value
				$address_default = html_escape($this->input->post('address_default'));
				
				//updated address to the database
				//if addressID is set, then update
				//address table
				//if($default == 'default' && $id == ''){
					
				//if checkbox is checked, save to default
				//table
				if($address_default == '1'){
					
					//check if user already has data saved
					//in default table
					$detail_default_address = $this->db->select('*')->from('default_address')->where('user_email',$email)->get()->row();
					
					//if true,update record
					if($detail_default_address){
						$update = array(			
							'first_name' => ucwords($this->input->post('first_name')),
							'last_name' => ucwords($this->input->post('last_name')),
							'company_name' => strtoupper($this->input->post('company_name')),
							'address_line_1' => $this->input->post('address_line_1'),
							'address_line_2' => $this->input->post('address_line_2'),
							'city' => ucwords($this->input->post('city')),
							'postcode' => $this->input->post('postcode'),
							'state' => ucwords($this->input->post('state')),
							'country' => ucwords($country),
							'phone' => $this->input->post('phone'),
						);
						$saveToDb = $this->Default_address->update_default($update, $email);
						
					//else add new record	
					}else{
								
						$add = array(			
							'first_name' => ucwords($this->input->post('first_name')),
							'last_name' => ucwords($this->input->post('last_name')),
							'user_email' => $email,
							'company_name' => strtoupper($this->input->post('company_name')),
							'address_line_1' => $this->input->post('address_line_1'),
							'address_line_2' => $this->input->post('address_line_2'),
							'city' => ucwords($this->input->post('city')),
							'postcode' => $this->input->post('postcode'),
							'state' => ucwords($this->input->post('state')),
							'country' => ucwords($country),
							'phone' => $this->input->post('phone'),
							'date_added' => date('Y-m-d H:i:s'),
						);
						
						$saveToDb = $this->Default_address->add_address($add);
					}
					//update users details
					$u = array(			
						'first_name' => ucwords($this->input->post('first_name')),
						'last_name' => ucwords($this->input->post('last_name')),
						'company_name' => strtoupper($this->input->post('company_name')),
						'address_line_1' => $this->input->post('address_line_1'),
						'address_line_2' => $this->input->post('address_line_2'),
						'city' => ucwords($this->input->post('city')),
						'postcode' => $this->input->post('postcode'),
						'state' => ucwords($this->input->post('state')),
						'country' => ucwords($country),
						'phone' => $this->input->post('phone'),
					);
					
					$this->Users->user_update($u, $email);
					$description = 'added/updated default address and account';
					
					//$saveToDb = $this->Users->user_update($update, $email);
				}else{
					$update = array(			
						'first_name' => ucwords($this->input->post('first_name')),
						'last_name' => ucwords($this->input->post('last_name')),
						'user_email' => $email,
						'company_name' => strtoupper($this->input->post('company_name')),
						'address_line_1' => $this->input->post('address_line_1'),
						'address_line_2' => $this->input->post('address_line_2'),
						'city' => ucwords($this->input->post('city')),
						'postcode' => $this->input->post('postcode'),
						'state' => ucwords($this->input->post('state')),
						'country' => ucwords($country),
						'phone' => $this->input->post('phone'),
						'date_added' => date('Y-m-d H:i:s'),
					);
				
					$saveToDb = $this->Addresses->update_address($update, $id);
					$description = 'updated address';
						
				}
					
				
				if ($saveToDb){

					$user_array = $this->Users->get_user($email);
						
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
						
					//update activities table
					
					$activity = array(			
						'name' => $fullname,
						'email' => $email,
						'description' => $description,
						'keyword' => 'Address',
						'activity_time' => date('Y-m-d H:i:s'),
					);
					
						
					$this->Site_activities->insert_activity($activity);
							
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i> Address updated!</div>';
						
						
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not update address!</div>';
									
				} 	
				
            }
            else {
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
					

		
		public function delete_address(){
			
			if($this->input->post('id') != '')
			{
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$pid = html_escape($this->input->post('id'));
				$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
				
				//load model
				//$object = new Addresses_model();
				//$object->load($id);
				//$object->delete();
				
				$query = $this->db->delete('addresses', array('id' => $id));
				
				if($query){
					
					$email = $this->session->userdata('email');
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					
					//update activities table
					$description = 'deleted address';
					
					
					$activity = array(			
						'name' => $fullname,
						'email' => $email,
						'description' => $description,
						'keyword' => 'Delete',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$data['success'] = true;
				
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The address has been deleted!</div>';
				
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not delete address!</div>';
				}
				
				
			}else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Invalid post!</div>';
			}
			
			echo json_encode($data);
		}
			
			
		
		/***
		* Function to handle orders ajax
		* Datatable
		***/
		public function orders_datatable()
		{
			
			$list = $this->Orders->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $order) {
				$no++;
				$row = array();
			
				$row[] = '<h4><a data-toggle="modal" href="#" data-target="#viewOrderModal" class="link" onclick="viewOrder(\''.$order->reference.'\');" id="'.$order->id.'" title="View Order">'.$order->reference.'</a></h4>';
				
				//$row[] = $order->reference;
				$row[] = number_format($order->total_price, 2);
				
				$confirm_payment_link = base_url().'account/confirm-payment';
				$confirm_payment = '<a title="Confirm Payment" href="javascript:void(0)" onclick="location.href=\''.$confirm_payment_link.'\'" class="btn btn-success btn-sm">CONFIRM PAYMENT</a>';
				$payment_status = 'Payment Pending';
				$shipping_status = 'Shipping Pending';
				
				if($order->payment_status == '1'){
					$payment_status = 'Paid';
					//$confirm_payment = '';
				}
				
				if($order->shipping_status == '1'){
					$payment_status = 'Shipped';
				}
				
				
				$row[] = $payment_status.' '.$confirm_payment.' / '.$shipping_status;
				
				$row[] = date("F j, Y", strtotime($order->order_date));
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Orders->count_user_all(),
				"recordsFiltered" => $this->Orders->count_user_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	
						
	
		/**
		* Function to handle
		* order details view
		* display
		*/	
		public function order_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$reference = html_escape($this->input->post('reference'));
			//$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			//user email from session
			$email = $this->session->userdata('email');
			
			//get payment method from payments table
			$payment_method = '';
			$payment_detail = $this->db->select('*')->from('payments')->where('reference',$reference)->where('customer_email',$email)->get()->row();
			if($payment_detail){
				$payment_method = $payment_detail->payment_method;
			}
			
			//get order from order table
			$order_id = '';
			$total_price = '';
			$tax = '';
			$shipping_n_handling_fee = '';
			$payment_gross = '';
			$billing_address_name = '';
			$billing_address_street = '';
			$billing_address_zip = '';
			$billing_address_city = '';
			$billing_address_state = '';
			$billing_address_country = '';
			$shipping_address_name = '';
			$shipping_address_street = '';
			$shipping_address_zip = '';
			$shipping_address_city = '';
			$shipping_address_state = '';
			$shipping_address_country = '';
			$customer_contact_phone = '';
			$payment_status = '';
			$shipping_status = '';
			$order_date = '';
			
			$orders_detail = $this->db->select('*')->from('orders')->where('reference',$reference)->where('customer_email',$email)->get()->row();
			if($orders_detail){
				
				$order_id = $orders_detail->id;
				$total_price = $orders_detail->total_price;
				$tax = $orders_detail->tax;
				$shipping_n_handling_fee = $orders_detail->shipping_n_handling_fee;
				$payment_gross = $orders_detail->payment_gross;
				$billing_address_name = $orders_detail->billing_address_name;
				$billing_address_street = $orders_detail->billing_address_street;
				$billing_address_zip = $orders_detail->billing_address_zip;
				$billing_address_city = $orders_detail->billing_address_city;
				$billing_address_state = $orders_detail->billing_address_state;
				$billing_address_country = $orders_detail->billing_address_country;
				$shipping_address_name = $orders_detail->shipping_address_name;
				$shipping_address_street = $orders_detail->shipping_address_street;
				$shipping_address_zip = $orders_detail->shipping_address_zip;
				$shipping_address_city = $orders_detail->shipping_address_city;
				$shipping_address_state = $orders_detail->shipping_address_state;
				$shipping_address_country = $orders_detail->shipping_address_country;
				$customer_contact_phone = $orders_detail->customer_contact_phone;
				$payment_status = $orders_detail->payment_status;
				$shipping_status = $orders_detail->shipping_status;
				$order_date = date("F j, Y", strtotime($orders_detail->order_date));
			}
			
			if($payment_status == '0'){
				$payment_status = 'Pending';
			}else{
				$payment_status = 'Paid';
			}
			
			if($shipping_status == '0'){
				$shipping_status = 'Pending';
			}else{
				$shipping_status = 'Shipped';
			}
			
			$order_detail_array = $this->Order_details->get_orders_by_reference($reference);
			
			
			if($order_detail_array){
				
				$totalPrice = 0;
				$totalQuantity = 0;
				
				//GENERATE FIRST TABLE
				$details = '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr><th colspan="2">ORDER DETAILS</th></tr></thead>';
				$details .= '<tbody><tr>';
				$details .= '<td><strong>Order ID: </strong> #'.$order_id.'<br/>';
				$details .= '<strong>Date Added: </strong>'.$order_date.'</td>';
				$details .= '<td><strong>Payment Method: </strong>'.$payment_method.'<br/>';
				$details .= '<strong>Shipping Method: </strong></td>';
				$details .= '</tr></tbody>';
				$details .= '</table>';
				$details .= '<br/>';
				
				//GENERATE SECOND TABLE - BILLING & SHIPPING INFO
				$details .= '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr><th>BILLING ADDRESS</th><th>SHIPPING ADDRESS</th></tr></thead>';
				$details .= '<tbody><tr>';
				$details .= '<td>'.$billing_address_name.'<br/>';
				$details .= $billing_address_street.'<br/>';
				$details .= $billing_address_city.' '.$billing_address_zip.'<br/>';
				$details .= $billing_address_state.'<br/>';
				$details .= $billing_address_country.'</td>';
				$details .= '<td>'.$shipping_address_name.'<br/>';
				$details .= $shipping_address_street.'<br/>';
				$details .= $shipping_address_city.' '.$billing_address_zip.'<br/>';
				$details .= $shipping_address_state.'<br/>';
				$details .= $shipping_address_country.'<br/>';
				$details .= '<strong>Contact Tel: </strong>'.$customer_contact_phone.'</td>';
				$details .= '</tr></tbody>';
				$details .= '</table>';
				$details .= '<br/>';
				
				//GENERATE THIRD TABLE - ORDER INFO
				$details .= '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr>';
				$details .= '<th>Product</th><th>Name</th><th>Quantity</th>';
				$details .= '<th>Price</th>';
				$details .= '</tr></thead><tbody>';
				foreach($order_detail_array as $detail){
					
					$details .= '<tr>';
					
					//get product details from id
					$product_array = $this->Products->get_product($detail->product_id);
					$product_image ='';
					$product_name = '';
					if($product_array){
						foreach($product_array as $product){
							$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive img-rounded img-thumbnail" width="30" height="30" />';
							$product_name = $product->name;
						}
					}
					
					$details .= '<td>'.$product_image.'</td>';
					$details .= '<td>'.$product_name.'</td>';
					$details .= '<td>'.$detail->quantity.'</td>';
					$details .= '<td>'.number_format($detail->price, 2).'</td>';
					
					$details .= '</tr>';
					
					$totalQuantity += $detail->quantity;
					$totalPrice += $detail->price;
				}
				$details .= '<tr>';
				$details .= '<td colspan="2"><strong>Sub-Total</strong></td>';
				$details .= '<td>'.$totalQuantity.' item(s)</td>';
				$details .= '<td>$'.number_format($totalPrice, 2).'</td>';
				$details .= '</tr>';
				$details .= '<tr>';
				$details .= '<td colspan="3"><strong>VAT (5%)</strong></td>';
				$details .= '<td>$'.number_format($tax, 2).'</td>';
				$details .= '</tr>';
				$details .= '<tr>';
				$details .= '<td colspan="3"><strong>Shipping & Handling</strong></td>';
				$details .= '<td>$'.number_format($shipping_n_handling_fee, 2).'</td>';
				$details .= '</tr>';
				$details .= '<tr>';
				$details .= '<td colspan="3"><strong>Total</strong></td>';
				//calculate total 
				$total = $totalPrice + $tax + $shipping_n_handling_fee;
				$details .= '<td><h4 class="text-primary">$'.number_format($payment_gross, 2).'</h4> OR <h4 class="text-success">$'.number_format($total, 2).'</h4></td>';
				$details .= '</tr>';
				$details .= '</tbody>';	
				$details .= '</table>';	
				$details .= '<br/>';
				
				//GENERATE FOURTH TABLE - PAYMENT & SHIPPING STATUS
				$details .= '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr><th>PAYMENT STATUS</th><th>SHIPPING STATUS</th></tr></thead>';
				$details .= '<tbody><tr>';
				$details .= '<td>'.$payment_status.'</td>';
				$details .= '<td>'.$shipping_status.'</td>';
				$details .= '</tr></tbody>';
				$details .= '</table>';
				
				
				
				$data['headerTitle'] = 'Order Details - '.$reference;			
				$data['order_details'] = $details;
				
				$data['model'] = 'order_details';
				$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
				
		
		/***
		* Function to handle transactions ajax
		* Datatable
		***/
		public function transactions_datatable()
		{
			
			$list = $this->Transactions->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $transaction) {
				$no++;
				$row = array();
			
				$row[] = '<h4 class="text-primary">'.$transaction->reference.'</h4>';
				
				$row[] = $transaction->description;
				$row[] = $transaction->amount;
				//$row[] = $transaction->status;
				
				$row[] = date("F j, Y", strtotime($transaction->transaction_date));
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Transactions->count_user_all(),
				"recordsFiltered" => $this->Transactions->count_user_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	
						
	
		/**
		* Function to handle
		* transaction details view
		* display
		*/	
		public function transaction_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$reference = html_escape($this->input->post('reference'));
			//$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$transaction_array = $this->Transactions->get_transaction_by_reference($reference);
			
			
			if($transaction_array){
				
				$totalPrice = 0;
				$totalQuantity = 0;
				
				$details = '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr>';
				$details .= '<th>Product</th><th>Name</th><th>Quantity</th>';
				$details .= '<th>Price</th>';
				$details .= '</tr></thead><tbody>';
				foreach($order_detail_array as $detail){
					
					$details .= '<tr>';
					
					//get product details from id
					$product_array = $this->Products->get_product($detail->product_id);
					$product_image ='';
					$product_name = '';
					if($product_array){
						foreach($product_array as $product){
							$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive img-rounded img-thumbnail" width="30" height="30" />';
							$product_name = $product->name;
						}
					}
					
					$details .= '<td>'.$product_image.'</td>';
					$details .= '<td>'.$product_name.'</td>';
					$details .= '<td>'.$detail->quantity.'</td>';
					$details .= '<td>'.number_format($detail->price, 2).'</td>';
					
					$details .= '</tr>';
					
					$totalQuantity += $detail->quantity;
					$totalPrice += $detail->price;
				}
				$details .= '<tr>';
				$details .= '<td colspan="2"><strong>Total</strong></td>';
				$details .= '<td>'.$totalQuantity.' item(s)</td>';
				$details .= '<td>$'.number_format($totalPrice, 2).'</td>';
				$details .= '</tr>';
				$details .= '</tbody>';	
				$details .= '</table>';	
				
				$data['headerTitle'] = 'Order Details - '.$reference;			
				$data['order_details'] = $details;
				
				$data['model'] = 'order_details';
				$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
						
		/**
		* Function to confirm_ user
		* payment
		*/		
		public function confirm_payment(){
			 
			if($this->session->userdata('logged_in')){ 
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				
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
				$data['pageTitle'] = 'Confirm Payment';
				
				//assign page ID
				$data['pageID'] = 'confirm_payment';
							
				//load header
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/confirm_payment_page', $data);
				
				//load main footer
				$this->load->view('account_pages/footer');				
				
			}
			else {
					$url = 'login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
		}
	
								
		/**
		* Function to access user
		* wishlist page
		*/		
		public function wishlist(){
			 
			if($this->session->userdata('logged_in')){ 
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				
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
				$data['pageTitle'] = 'Wishlist';
				
				//assign page ID
				$data['pageID'] = 'wishlist';
							
				//load header
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/wishlist_page', $data);
				
				//load main footer
				$this->load->view('account_pages/footer');				
				
			}
			else {
					$url = 'login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
		}
	
		
		/***
		* Function to handle wishlist ajax
		* Datatable
		***/
		public function wishlist_datatable()
		{
			
			$list = $this->Wishlist->get_user_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $wishlist) {
				$no++;
				$row = array();
				
				$product_id = $wishlist->product_id;
				$product_image = '';
				$product_name = '';
				$product_price = '';
				$quantity_available = '';
				$stock = '';
				
				$qty = 1;
				$name = '';
				$price = '';
				$colour = '';
				$size = '';
				$url = base_url().'store/add_cart_item';
				
				$products_array = $this->Products->get_product($product_id);
				if($products_array){
					foreach($products_array as $product){
						
						$name = $product->name;
						$price = $product->price;
						$colour = '';
						$size = '';
						
						$product_name = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($product->id)).'/'.url_title(strtolower(html_escape($product->name))).'" title="'. url_title(strtolower(html_escape($product->name))).'">'.html_escape($product->name).'</a>';
						
						$product_price = number_format($product->price, 2);
						$sale_price = number_format($product->sale_price, 2);
						
						//$quantity_available = html_escape($product->quantity_available);
						
						if($product->quantity_available > 0){
							$quantity_available = 'In Stock';
						}else{
							$quantity_available = 'Out Of Stock';
						}
						
						$filename = FCPATH.'uploads/products/'.$product->id.'/'.$product->image;
						if(file_exists($filename)){
							
							$product_image = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($product->id)).'/'.url_title(strtolower(html_escape($product->name))).'" title="'. url_title(strtolower(html_escape($product->name))).'"><img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive group list-group-image" /></a>';
							
						}
						else if($product->image == '' || $product->image == null || !file_exists($filename)){
							
							$product_image = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($product->id)).'/'.url_title(strtolower(html_escape($product->name))).'" title="'. url_title(strtolower(html_escape($product->name))).'"><img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive group list-group-image" /></a>';
							
						}
						else{
							
							$product_image = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($product->id)).'/'.url_title(strtolower(html_escape($product->name))).'" title="'. url_title(strtolower(html_escape($product->name))).'"><img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->image.'" class="img-responsive group list-group-image" /></a>';
							
						}
								
					}
				}
				
				$row[] = $product_image;
				$row[] = '<strong>'.$product_name.'</strong>';
				
				$row[] = '<span class"text-success text-center" align="center">$'.$product_price.'</span>';
				$row[] = $quantity_available;
				$row[] = '<div>'.nbs(4).'<button type="button" class="btn btn-info btn-md btn-circle" id="'.$product_id.'" title="Add To Cart" onclick="addToCart('.$product_id.','.$qty.',\''.$price.'\',\''.$name.'\',\''.$colour.'\',\''.$size.'\',\''.$url.'\')"><i class="fa fa-cart-plus"></i></button></div>';
				$row[] = '<div>'.nbs(4).'<button type="button" class="btn btn-danger btn-md btn-circle" id="'.$wishlist->id.'" title="Delete" onclick="deleteWishListItem('.$wishlist->id.')"><i class="fa fa-times"></i></button></div>';
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Wishlist->count_user_all(),
				"recordsFiltered" => $this->Wishlist->count_user_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}


		
		public function delete_wishlist(){
			
			if($this->input->post('id') != '')
			{
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				$pid = html_escape($this->input->post('id'));
				$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
				
				//load model
				//$object = new Addresses_model();
				//$object->load($id);
				//$object->delete();
				
				$query = $this->db->delete('wishlist', array('id' => $id));
				
				if($query){
					
					$email = $this->session->userdata('email');
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					
					//update activities table
					$description = 'deleted wishlist';
					
					
					$activity = array(			
						'name' => $fullname,
						'email' => $email,
						'description' => $description,
						'keyword' => 'Delete',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$data['success'] = true;
				
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The entry has been deleted!</div>';
				
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not delete wishlist!</div>';
				}
				
				
			}else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Invalid post!</div>';
			}
			
			echo json_encode($data);
		}
					
		
		
		/**
		* Function to handle display
		* verify user password
		* 
		*/	
		public function verify_password(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			//$email = html_escape($this->input->post('email'));
			$current_password = html_escape($this->input->post('current_password'));
			$password = '';
			
			$email = $this->session->userdata('email');
			$user_array = $this->Users->get_user($email);
					
			if($user_array){
				foreach($user_array as $user){
					$password = $user->password;
				}
			}
					
			
			if(md5($current_password) == $password){
				$data['success'] = true;
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Password verified!</div>';
			}else{
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Invalid password!</div>';
			}
			echo json_encode($data);
			
		}
		


		/**
		* Function to validate change password
		*
		*/
        public function change_password() {
			
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('new_password','Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|matches[new_password]|xss_clean');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_message('matches', 'The passwords do not match!');
			
			
            if ($this->form_validation->run()){
				
				$email = $this->session->userdata('email');
				
				//array of update posts
				$update = array(
					'password' => md5($this->input->post('new_password'))
				);	
				
				//update users password in database
				if ($this->Users->user_update($update, $email)){
					
					//get clients info
					$user_array = $this->Users->get_user($email);
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
					
					//send email alert
					$to = $email;
					$subject = 'Password Changed';
					$message = "<p>You have successfully changed your password.</p>";
					$message .= "<p>If you did not make this change, please contact Customer Support immediately!</p>";
					
					//$this->Messages->send_email_alert($to, $subject, $fullname, $message);
					
					//$this->session->set_flashdata('username', $this->input->post('username'));
					//$this->session->set_flashdata('email', $this->input->post('email'));
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success"><h3><i class="glyphicon glyphicon-ok"></i>Password changed successfully! You will be logged out shortly.</h3></div>';
					
					//user already logged in, redirects to account page
					//redirect('myaccount/dashboard');
				
				} else {
					$data['success'] = false;
					$data['notif'] = '<div class="">Error U755</div>';
					
					//validation errors
					//$this->dashboard();
				}
				
				
            }else {
				$data['success'] = false;
				$data['notif'] = '<div class="">'.validation_errors().'</div>';
				
				//validation errors
				//$this->dashboard();
            }
           
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
				
		}			
		

		
		/**
		* Function to activate the user account
		* @param $string Activation key
		*/		
		public function activation($activation_key = ''){
			
			if($this->session->userdata('logged_in')){
				
				//if user logged in redirect to their account page
				redirect('account/dashboard');
				
			}else{
				
				//escaping the values
				$activation_key = trim($activation_key);
				$activation_key = html_escape($activation_key);
				
				if ($activation_key != '' && $this->Temp_users->is_valid_key($activation_key)){
					if ($this->Temp_users->add_user($activation_key)){
						
						$login_link = base_url().'login';
						
						$this->session->set_flashdata('activation', '<div class="alert alert-success text-center"><h3 class="text-success text-center"><i class="fa fa-check-circle"></i> Activation Success</h3><br/><p>Your account has been activated. <a href="javascript:void(0);" class="btn btn-primary" onclick="location.href=\''.$login_link.'\'" title="Login"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></p></div>');
						redirect('activation');
					}else{
						$this->session->set_flashdata('activation', '<div class="alert alert-danger text-danger text-center"><h3 class="text-danger text-center"><i class="fa fa-ban"></i> Activation Error!</h3><br/><p>Could not complete activation</p></div>');
					
						redirect('activation');
					}
				}else{
					$this->session->set_flashdata('activation', '<div class="alert alert-danger text-danger text-center"><h3 class="text-danger text-center"><i class="fa fa-ban"></i> Activation Error!</h3><br/><p>Invalid activation</p></div>');
					
					redirect('activation');
				}
			
			}			

		}


		/**
		* Function to update password
		*
		*/			
		public function update_password(){
			
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('old_password','Old Password','trim|callback_validate_old_password');
            $this->form_validation->set_rules('new_password','New Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|trim|matches[new_password]|xss_clean');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			  
            $this->form_validation->set_message('required', '% cannot be blank!');
			
			if ($this->form_validation->run()){
				
				$username = $this->session->userdata('username');

				$data = array(
					'password' => md5($this->input->post('new_password')),
				);
						
				if ($this->Users->update_user($data)){
					
					//update activities table
					$description = 'changed password';
				
					$activity = array(			
						'username' => $username,
						'description' => $description,
						'keyword' => 'Security',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
									
					//$url = $this->logout();
					
					$this->session->set_flashdata('password_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000); setTimeout(function() { window.location = "'.base_url('account/logout').'"; }, 9000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Your password has been updated! You will be redirected shortly to login again for security reasons.</div>');
					
					$user = $this->Users->get_user($username);

					$first_name = '';
						
					foreach($user as $u){
						$first_name = $u->first_name;
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
					$ci->email->subject('Changes to your account');
						
						
					//compose email message
					$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
					$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Avenue 1-OH-1">'.img('assets/images/logo/logo.png').'</a></div><br/>';
					
					$message .= "<p>Hello ";
					$message .= $first_name. ",</p>";
					$message .= "<p>Your password has been updated</p>";
					$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
					$message .= "</div>";
						
					$ci->email->message($message);
						
					$ci->email->send();
						
						//update complete redirects to update details success page
						redirect('account/profile');
						
				}else{
					redirect('account/profile');
				}
			}else {
				$this->profile();
			}
		}
		

		/**
		* Function to validate_old_password 
		* 
		*/			
		public function validate_old_password(){
			
			$username = $this->session->userdata('username');
			
			$user = $this->Users->get_user($username);

			$password = '';
			$post = md5($this->input->post('old_password'));
						
			foreach($user as $u){		
				$password = $u->password;
			}
			if ($post != $password)
			{
				$this->form_validation->set_message('validate_old_password', 'Old Password doesn\'t match what we have on record!');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}	
		
		
		/**
		* Function to validate update memorable information
		*
		*/			
		public function update_security(){
			
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('security_question','Security Question','trim|callback_question_option_check');
            $this->form_validation->set_rules('security_answer','Security Answer','required|trim|xss_clean');

            $this->form_validation->set_message('required', 'An answer is required!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   
			if ($this->form_validation->run()){

				$username = $this->session->userdata('username');
				
				$data = array(
					'security_question' => $this->input->post('security_question'),
					'security_answer' => $this->input->post('security_answer'),
				);
							
				if ($this->Users->update_user($data)){
					//update activities table
					$description = 'changed security information';
				
					$activity = array(			
						'username' => $username,
						'description' => $description,
						'keyword' => 'Settings',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
									
					//$url = $this->logout();
					
					$this->session->set_flashdata('security_info_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000); </script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Your security information has been updated! You will be redirected shortly to login again for security reasons.</div>');
					
					//$this->session->set_flashdata('security_info_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Your security information has been updated! You will be redirected shortly to login again for security reasons.</div>');
					
					$user = $this->Users->get_user($username);

					$first_name = '';
						
					foreach($user as $u){
						$first_name = $u->first_name;
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
					$ci->email->subject('Changes to your account');
						
						
					//compose email message
					$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
					$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Avenue 1-OH-1">'.img('assets/images/logo/logo.png').'</a></div><br/>';
					
					$message .= "<p>Hello ";
					$message .= $first_name. ",</p>";
					$message .= "<p>Your security information has been updated</p>";
					$message .= "<p>If you did not make this change. Please contact us immediately.</p>";
					$message .= "</div>";
						
					$ci->email->message($message);
						
					$ci->email->send();
						
					//update complete redirects to update details success page
					redirect('account/profile');	
						
				}else{
					
					redirect('account/profile');
				}
			}else {
				
				$this->profile();
			}
		}		
		
		
		public function security_information(){
			
			if($this->session->userdata('logged_in')){
				
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
				
		
				//assign page title name
				$data['pageTitle'] = 'Security Information';
				
				//assign page ID
				$data['pageID'] = 'security_information';
								
				//load header
				$this->load->view('account_pages/header', $data);
				
				//load main body
				$this->load->view('account_pages/security_information_page', $data);  			
				
				//load main footer
				$this->load->view('account_pages/footer');				
									
			}else{
				//redirects to logged out page
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);
									
				//redirect('home/login/?redirectURL=security_information');					
			}
		}		
		

		/**
		* Function to set memorable 
		* information
		*/					
		public function set_security(){
			
			if($this->session->userdata('logged_in') && $this->Users->check_isset_security_info()){
					
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
				
				//security_questions
				$select_security_questions = '<select name="security_question" class="form-control" id="security_question" >';
				$select_security_questions .= '<option value="0" >Please Select a Question</option>';
				$this->db->from('security_questions');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$select_security_questions .= '<option value="'.$row['question'].'" >'.$row['question'].'</option>';
					}
				}
				$select_security_questions .= '</select>';
				$data['select_security_questions'] = $select_security_questions;
					
				//assign page title name
				$data['pageTitle'] = 'Set Security Information';
				
				//assign page title name
				$data['pageID'] = 'set_security';
				
				//load header
				$this->load->view('pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/set_security_information_page', $data);  					
				
				//load main footer
				$this->load->view('pages/footer');				
								
			}else {
				//user not logged in, redirects to login page
				//$this->login();	
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);
									
				//redirect('home/login/?redirectURL=set_security_information');
				
			}
		}
		

		/**
		* Function to validate memorable 
		* information
		*/		
		public function set_security_validation(){
			
            $this->load->library('form_validation');
			
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('security_question','Security Question','required|trim|xss_clean|callback_question_option_check');
            $this->form_validation->set_rules('security_answer','Security Answer','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter a %s!');
			
			
            
			if ($this->form_validation->run()){
					
				$update = array(
					'security_question' => $this->input->post('security_question'),
					'security_answer' => $this->input->post('security_answer'),
				);
				
				$email = $this->session->userdata('email');
				
				if ($this->Users->user_update($update, $email)){
						
					$user_array = $this->Users->get_user($email);
					
					$fullname = '';
					//$email = '';
					
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
							//$email = $user->email;
						}
					}
					
					//update activities table
					$description = 'updated security information';
				
					$activity = array(			
						'name' => $fullname,
						'email' => $email,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					//send email alert
					$to = $email;
					$subject = 'Security Information Updated';
					$message = "<p>Your security information has been updated!</p>";
					$message .= "<p>If you did not make this request, please contact us ASAP!</p>";
					
					//$this->Messages->send_email_alert($to, $subject, $fullname, $message);
								
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".floating-alert-box").fadeOut("slow");window.location= '.base_url('account/dashboard').'; }, 5000);</script><div class="floating-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your security information has been set! Please hold on while you are redirected to your account.</div>');
						
					redirect('account/set-security');	
				}
			}else{
				//Go back to the security Page if validation fails
				$this->set_security();
			}
		}
		

		/**
		* Function to ensure a question is selected 
		* 
		*/			
		public function question_option_check(){
			
			$str1 = $this->input->post('security_question');
			
			if ($str1 == '' || $str1 == '0')
			{
				$this->form_validation->set_message('question_option_check', 'Please select a question');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}			
		
	


		/**
		* Function display private messages 
		* 
		*/				
		public function messages(){
			
			if($this->session->userdata('logged_in')){	
				
				redirect('message/inbox');
				
			}else{
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);
									
				//redirect('home/login/?redirectURL=messages');
			}	
		}

		/**
		* Function display quizs 
		* 
		*/				
		public function quiz(){
			
			if($this->session->userdata('logged_in')){	
				
				redirect('quiz/index');
				
			}else{
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);
									
				//redirect('home/login/?redirectURL=messages');
			}	
		}



		/**
		* Function to display payment 
		* methods
		*/			
		public function payment_methods(){
			
			if($this->session->userdata('logged_in')){
				
				$username = $this->session->userdata('username');

				$data['users'] = $this->Users->get_user($username);
				
				foreach($data['users'] as $u){
					$data['account_balance'] = $u->account_balance;
				}

				$data['header_messages_array'] = $this->Users->get_header_messages();
				
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
				
				$data['card_methods_array'] = $this->Card_payment_methods->get_payment_methods($username);	
				
				$data['paypal_array'] = $this->Paypal_payment_methods->get_paypal($username);	
				
				//$data['card_types'] = $this->Credit_card_types->get_ccs();	
				
				//card types list dropdown
				$card_types = '<select name="card_types" id="card_type">';
				$card_types .= '<option value="0" selected="selected">Select Your Card Type</option>';
					
				$this->db->from('credit_card_types');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$card_types .= '<option value="'.strtolower($row['type']).'">'.$row['type'].'</option>';			
					}
				}
				$card_types .= '</select>';
				$data['card_types'] = $card_types;
				
				//country list dropdown
				$country_options = '<select name="card_billing_country" id="country_id">';
				$country_options .= '<option value="0" selected="selected">Select Country</option>';
					
				$this->db->from('countries');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$country_options .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';			
					}
				}
				$country_options .= '</select>';
				$data['country_options'] = $country_options;
				
				
				$date = new DateTime();
				//credit card expiry month dropdown
				$expiry_month = '<select name="expiry_month" id="expiry_month">';
				
											for($month = 1; $month <= 12; $month++){
												//$sel = ($x == date('m')) ? 'selected' : '';
												//selected="'.$sel.'"
												$default_month = ($month == $date->format('m'))?'selected':'';
				$expiry_month .= '<option value="'.sprintf("%02d", $month).'" '.$default_month.'>'.sprintf("%02d", $month).'</option>';
											}
				$expiry_month .= '</select>';
						
				$data['expiry_month'] = $expiry_month;
				
				//credit card expiry year dropdown		
				$expiry_year = '<select name="expiry_year" id="expiry_year">';
											for($year=date("Y");$year<=date("Y")+10;$year++){
												//$sel = ($i == date('Y')) ? 'selected' : '';
												$default_year = ($year == $date->format('Y'))?'selected':'';
				$expiry_year .= '<option value="'.$year.'" '.$default_year.'>'.$year.'</option>';
											}
				$expiry_year .= '</select>';
				$data['expiry_year'] = $expiry_year;
				//assign page title name
				$data['pageTitle'] = 'Payment Methods';
				
				//assign page ID
				$data['pageID'] = 'payment_methods';
									
				//load header
				$this->load->view('account_pages/header', $data);
								
				//load main body
				$this->load->view('account_pages/payment_methods_page');				
				
				//load main footer
				$this->load->view('account_pages/footer');				
												
			}else{
				$url = 'login?redirectURL='.urlencode(current_url());
				redirect($url);
									
				//redirect('home/login/?redirectURL=payment_methods');
			}	
		}		


		
		
		public function logout(){
			
			if($this->session->userdata('logged_in')){
				
				$email = $this->session->userdata('email');
				
				$this->session->unset_userdata('logged_in');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('login_time');
				$this->session->unset_userdata('answered_count');
				$this->session->unset_userdata('page_count');
				//$this->session->sess_destroy();
				$this->facebook->destroySession();
				
				//check if redirect url is set
				//$redirect = '';
				//$this->session->flashdata('redirectURL');
				
				if($this->input->get('redirectURL') != ''){
					$this->session->set_userdata('checkout_email', $email);	
					//$redirect = $this->session->flashdata('redirectURL');
					$url = $this->input->get('redirectURL');
					redirect($url);
				}else{
					//redirects to logged out page
					redirect('logged-out');
				}
				
			}else{
				
				//redirects to logged out page
				redirect('login');				
			}
			
		}




}	
		