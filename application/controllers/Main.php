<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct() {
			parent::__construct();

			// Include two files from google-php-client library in controller
			//require_once APPPATH . "libraries/google-api-php-client/vendor/autoload.php";
			include_once APPPATH . "libraries/google-api-php-client/src/Google/Client.php";
			include_once APPPATH . "libraries/google-api-php-client/src/Google/Service/Oauth2.php";

	}
	
	public function index()
	{
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
						
		//assign meta tags
		$page = 'home';
		$keywords = '';
		$description = '';
		$metadata_array = $this->Page_metadata->get_page_metadata($page);
		if($metadata_array){
			foreach($metadata_array as $meta){
				$keywords = $meta->keywords;
				$description = $meta->description;
			}
		}
		if($description == '' || $description == null){
			$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
		}
		$data['meta_description'] = $description;
		$data['meta_author'] = 'Avenue 1-OH-1';
										
		$data['meta_keywords'] = $keywords;
				
		//assign page title name
		$data['pageTitle'] = 'Home';
		
		//assign page ID
		$data['pageID'] = 'home';
		
		$this->load->view('pages/header', $data);
		
		$this->load->view('pages/home_page', $data);
		
		$this->load->view('pages/footer');
	}

	public function about()
	{
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
						
		//assign meta tags
		$page = 'about';
		$keywords = '';
		$description = '';
		$metadata_array = $this->Page_metadata->get_page_metadata($page);
		if($metadata_array){
			foreach($metadata_array as $meta){
				$keywords = $meta->keywords;
				$description = $meta->description;
			}
		}
		if($description == '' || $description == null){
			$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
		}
		$data['meta_description'] = $description;
		$data['meta_author'] = 'Avenue 1-OH-1';
										
		$data['meta_keywords'] = $keywords;
				
		//assign page title name
		$data['pageTitle'] = 'About';
		
		//assign page ID
		$data['pageID'] = 'about';
				
		$this->load->view('pages/header', $data);
		
		$this->load->view('pages/about_page', $data);
		
		$this->load->view('pages/footer');
	}	

	public function contact_us()
	{
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
						
		//assign meta tags
		$page = 'contact';
		$keywords = '';
		$description = '';
		$metadata_array = $this->Page_metadata->get_page_metadata($page);
		if($metadata_array){
			foreach($metadata_array as $meta){
				$keywords = $meta->keywords;
				$description = $meta->description;
			}
		}
		if($description == '' || $description == null){
			$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
		}
		$data['meta_description'] = $description;
		$data['meta_author'] = 'Avenue 1-OH-1';
										
		$data['meta_keywords'] = $keywords;
				
		//assign page title name
		$data['pageTitle'] = 'Contact Us';
		
		//assign page ID
		$data['pageID'] = 'contact';
				
		$this->load->view('pages/header', $data);
		
		$this->load->view('pages/contact_us_page', $data);
		
		$this->load->view('pages/footer');
	}	


		/**
		* Function to validate messages from 
		* the contact us page
		*/			
		public function contact_us_validation() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('contact_us_name','Name','required|trim|xss_clean|min_length[4]|callback_check_double_messaging');
            $this->form_validation->set_rules('contact_us_telephone','Telephone number','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
			$this->form_validation->set_rules('contact_us_email','Email','required|trim|valid_email');
			$this->form_validation->set_rules('contact_us_subject','Subject','required|trim|xss_clean|min_length[2]');
			$this->form_validation->set_rules('contact_us_message','Message','required|trim|xss_clean|min_length[6]');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('min_length', '%s must be longer!');
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email!');
			
			if ($this->form_validation->run()){
				
					//obtain users ip address
					$ipaddress = $this->Logins->ip();	
					
					//array of all post variables
					$contact_data = array(
						'contact_name' => $this->input->post('contact_us_name'),
						'contact_telephone' => $this->input->post('contact_us_telephone'),
						'contact_email' => $this->input->post('contact_us_email'),
						'contact_subject' => $this->input->post('contact_us_subject'),
						'contact_message' => $this->input->post('contact_us_message'),
						'ip_address' => $ipaddress,
						'contact_us_date' => date('Y-m-d H:i:s'),
					);
				
					$this->Contact_us->add_contact_us($contact_data);

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
					$this->email->reply_to('getextra@gmail.com', 'Avenue 1-OH-1');
					$ci->email->to('getextra@gmail.com');
					$ci->email->subject('Contact Us Message From '. $this->input->post('contact_us_name'));
					
					
					//compose email message
					$message = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
					$message .= '<div align="center" id="logo"><a href="'.base_url().'" title="Avenue 1-OH-1">'.img('assets/images/logo/logo.png').'</a></div><br/>';
					$message .= "<p>Name: ". $this->input->post('contact_us_name'). ",</p>";
					$message .= "<p>Telephone: ". $this->input->post('contact_us_telephone'). ",</p>";
					$message .= "<p>Email: ". $this->input->post('contact_us_email'). ",</p>";
					$message .= "<p>Subject: ". $this->input->post('contact_us_subject'). ",</p>";
					$message .= "<p>Message: ". $this->input->post('contact_us_message'). ",</p>";
					$message .= "</div>";
					
					$ci->email->message($message);
					
					$ci->email->send();
					
					//$data = array(
					//	'message' => "| Your message has been sent!"
					//);
					
					//$this->session->set_userdata($data);
					
					//redirects to contact us page
					//redirect('home/contact_us', $data);	
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your message has been sent!</div>';
				
				
			}else {
					//redirects to contact us page
					//$this->contact_us();	
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Message not sent!</div>';
					$data['errors'] = '<div class="alert alert-danger text-center" role="alert">'.validation_errors().'</div>';
					
			}
                echo json_encode($data);
        }

		/**
		* Function to check_double_post 
		* 
		*/			
		public function check_double_messaging(){
			
			//obtain users ip address
			$ipaddress = $this->Logins->ip();

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('contact_us');
			$this->db->where('ip_address', $ipaddress);
			
			$this->db->where("contact_us_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_double_messaging', 'You must wait at least 20 seconds before you send another message!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			
	
	
		public function gallery(){
			
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
							
			//assign meta tags
			$page = 'gallery';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
			}
			$data['meta_description'] = $description;
			$data['meta_author'] = 'Avenue 1-OH-1';
											
			$data['meta_keywords'] = $keywords;
					
			//assign page title name
			$data['pageTitle'] = 'Gallery';
			
			//assign page ID
			$data['pageID'] = 'gallery';
					
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/gallery_page', $data);
			
			$this->load->view('pages/footer');
			
		}


	
	public function login()
	{
	
		if($this->session->userdata('logged_in')){
				
				//assign page title name
				redirect('account/dashboard');
		}
		else {
				
			if($this->input->get('redirectURL') != ''){
					$url = $this->input->get('redirectURL');
					$this->session->set_flashdata('redirectURL', $url);	
			}
			
			if($this->input->get('checkoutURL') != ''){
					$url = $this->input->get('checkoutURL');
					$this->session->set_flashdata('checkoutURL', $url);	
			}
		
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
				
			//assign meta tags
			$page = 'login';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Avenue 1-OH-1 - Login to place orders or manage previous orders';
			}
			$data['meta_description'] = $description;
			$data['meta_author'] = 'Avenue 1-OH-1';
											
			$data['meta_keywords'] = $keywords;
					
			//assign page title name
			$data['pageTitle'] = 'Account Login';
				
			//assign page ID
			$data['pageID'] = 'login';
					
			$this->load->view('pages/header', $data);
								
			//load main body
			$this->load->view('pages/user_login_page', $data);	
			
			$this->load->view('pages/footer');
			
		}
		
	}
		
		/**
		* Function to validate user login
		* information
		*/
        public function login_validation() {
			
            $this->session->keep_flashdata('redirectURL');
			
			$this->session->keep_flashdata('checkoutURL');
			
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('email','Email','required|trim|xss_clean|callback_max_login_attempts|callback_validate_credentials|valid_email');
            $this->form_validation->set_rules('password','Password','required|xss_clean|trim');
            
            $this->form_validation->set_message('required', '%s cannot be blank!');
			
			if ($this->form_validation->run()){

				$data = array(
					'email' => strtolower($this->input->post('email')),
					'logged_in' => 1,
				);
				
				$this->session->set_userdata($data);
				
				$user_array = $this->Users->get_user($this->input->post('email'));
					
				$fullname = '';
					//$email = '';
					
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name .' '.$user->last_name;
						//$email = $user->email;
					}
				}
					
				//update activities table
				$description = 'logged into account';
				
				$activity = array(			
					'name' => $fullname,
					'email' => $this->input->post('email'),
					'description' => $description,
					'keyword' => 'Login',
					'activity_time' => date('Y-m-d H:i:s'),
				);
						
				$this->Site_activities->insert_activity($activity);
						
				if($this->Users->check_isset_security_info()){
					
					//$data['success'] = true;
					//$data['set_security'] = false;		
					//redirects to set memorable information page
					redirect('account/set-security');
					
				}else {
					//$data['success'] = true;
					//$data['set_security'] = true;
					//redirects to account page
					redirect('account/dashboard');	
				}		
            }
            else {		
				//redirects to login page
				$this->login();	
				//$data['success'] = false;
				//$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
            }
			
			// Encode the data into JSON
			//$this->output->set_content_type('application/json');
			//$data = json_encode($data);

			// Send the data back to the client
			//$this->output->set_output($data);
			//echo json_encode($data);		
        }
		
		/**
		* Function to validate username
		* during login
		*/		
		public function validate_credentials() {
			
			if ($this->Users->can_log_in()){
				$email = $this->input->post('email');
				
				//check admin last login time from the logins table
				//$last_login = $this->Logins->last_login_time($username);
				
				//if there is a record then update users record
				//otherwise ignore
				/*if($last_login){
					foreach($last_login as $login){
						$this->Logins->update_login_time($username, $login->login_time);
					}
				}*/
				
				//get last login
				$last_login = $this->db->select_max('login_time')->from('logins')->where("username",$email)->get()->row();
				if(!empty($last_login)){
					$time = $last_login->login_time;
					//array of session variables
					$data = array(	
						'last_login' => $time,
					);	
					$this->Users->user_update($data, $email);
				}
				
				//obtain users ip address
				$ipaddress = $this->Users->ip();			
				
				//array of all login posts
				$data = array(
					'ip_address' => $ipaddress,
					'username' => $this->input->post('email'),
					'password' => md5($this->input->post('password')),
					'login_time' => date('Y-m-d H:i:s')
					
				);	
				
				$this->Logins->insert_login($data);
				
				return TRUE;
			}
			else {
					
				//obtain users ip address
				$ipaddress = $this->Users->ip();			
				
				//array of all login posts
				$data = array(
					'ip_address' => $ipaddress,
					'username' => $this->input->post('email'),
					'password' => $this->input->post('password'),
					'attempt_time' => date('Y-m-d H:i:s')
					
				);	
				$this->Failed_logins->insert_failed_login($data);
				
				$this->form_validation->set_message('validate_credentials', 'Incorrect username or password.');
				
				return FALSE;
			}
		}
		
		/**
		* Function to check if the user has logged in wrongly
		* more than 3 times in 24 hours
		*/			
		public function max_login_attempts(){
			
			$email = $this->input->post('email');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_logins');
			$this->db->where('username', $email);
			
			$this->db->where("attempt_time BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() < 3){	
				return TRUE;	
			}else {	
				$this->form_validation->set_message('max_login_attempts', 'You have surpassed the allowed number of login attempts in 24 hours! Please contact Customer Service!');
				return FALSE;
			}
		}	
	

		/**
		* Function to handle user sign up
		*
		*/			
        public function signup() {
			
			if($this->session->userdata('logged_in')){
				
				//if user logged in redirect to their account page
				redirect('account/dashboard');
				
			}else{
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
				
										
				//assign meta tags
				$page = 'signup';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
				}
				$data['meta_description'] = $description;
				$data['meta_author'] = 'Avenue 1-OH-1';
												
				$data['meta_keywords'] = $keywords;
						
				//assign page title name
				$data['pageTitle'] = 'Sign Up';
			
				//assign page ID
				$data['pageID'] = 'sign_up';

				//country list dropdown
				$data['list_of_countries'] =  $this->Countries->get_country_list();
		
				$country_options = '<select name="country" id="country_id">';
				$country_options .= '<option value="0" selected="selected">Select Country</option>';
					
				$this->db->from('countries');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$country_options .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';			
					}
				}
				$country_options .= '</select>';
				$data['country_options'] = $country_options;				
					
				$this->load->view('pages/header', $data);
								
				//load main body
				$this->load->view('pages/user_signup_page', $data);  
				
				$this->load->view('pages/footer');
			
			}
			
        }


		/**
		* Function to handle signup validation
		*
		*/	        
        public function signup_validation() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
            $this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
            
            $this->form_validation->set_rules('email_address','Email','required|trim|valid_email|is_unique[users.email_address]|is_unique[temp_users.email_address]|xss_clean');
			//$this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|regex_match[/^[0-9\+\(\)\/-]+$/]');
			
			//$this->form_validation->set_rules('username','Username','required|trim|is_unique[users.username]|is_unique[temp_users.username]|xss_clean');
	
            $this->form_validation->set_rules('password','Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|matches[password]|xss_clean');
            //$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			//$this->form_validation->set_rules('country','Country','required|trim|xss_clean|callback_country_option_check');
			
			$this->form_validation->set_message('is_unique', '%s already registered, please log in!');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_message('matches', 'The passwords do not match!');
			
			$this->form_validation->set_message('regex_match', 'Please enter a valid phone number!');
							
			
			if ($this->form_validation->run()){
				
				//generate a random key
				$activation_key = md5(uniqid());
				
				//generate a random code
				$code = mt_rand(100000, 999999);
				
				//add new user to the temp database
				if ($this->Temp_users->add_temp_user($activation_key)){

					$fullname = $this->input->post('first_name') .' '.$this->input->post('last_name');
						
					//update activities table
					$description = 'signed up';
					
					$activity = array(			
						'name' => $fullname,
						'email' => $this->input->post('email_address'),
						'description' => $description,
						'keyword' => 'Register',
						'activity_time' => date('Y-m-d H:i:s'),
					);
					
						
					$this->Site_activities->insert_activity($activity);
						
					$to = $this->input->post('email_address');
					$subject = 'Activate your account.';
					$full_name = $this->input->post('first_name').' '.$this->input->post('last_name');
					//compose email message
					$message = "<p>Thank you for signing up.</p>";
					$message .= "<p>You need to click the link below to activate your account:</p>";
					$message .= "<p><a href='".base_url()."account/activation/".$activation_key."'>Activate your account here</a>.</p>";
					$message .= "<p>This link expires in 24 hours.</p>";
					//$message .= "<p>Or you can go <a href='".base_url()."main/activation/'>here</a> to activate your account with this code: ".$code."</p>";

					$this->Messages->send_email_alert($to, $subject, $full_name, $message);
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i> Thank you for signing up. Please check your email to activate your account within 24 hours.</div>';
					
							
					$this->session->set_flashdata('signup', '<div class="alert alert-success text-center"><h3 class="text-success text-center"><i class="fa fa-check-circle"></i> Signup Success</h3><br/><p>Thank you for signing up. Please check your email to activate your account within 24 hours.</p></div>');
							
					//signup successful, redirects to final page
					redirect('signup/success');	
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not complete signup!</div>';
					
							
					$this->session->set_flashdata('signup', '<div class="alert alert-danger text-danger text-center"><h3 class="text-danger text-center"><i class="fa fa-ban"></i> Signup Error</h3><br/><p>Could not complete signup</p></div>');
					
					redirect('signup/success');			
				} 	
            }
            else {
				//$data['success'] = false;
				//$data['notif'] = '<div class="text-center" role="alert">'.validation_errors().'</div>';
				//registration failed and shows the signup page again
                $this->signup();
            }
			
			// Encode the data into JSON
			//$this->output->set_content_type('application/json');
			//$data = json_encode($data);

			// Send the data back to the client
			//$this->output->set_output($data);
			//echo json_encode($data);		
			
        }		
	

		/**
		* Function to handle user sign up
		* success
		*/			
        public function signup_success() {
			
			if($this->session->userdata('logged_in')){
				
				//if user logged in redirect to their account page
				redirect('account/dashboard');
				
			}else{
				
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
										
				//assign meta tags
				$page = 'signup';
				$keywords = '';
				$description = '';
				$metadata_array = $this->Page_metadata->get_page_metadata($page);
				if($metadata_array){
					foreach($metadata_array as $meta){
						$keywords = $meta->keywords;
						$description = $meta->description;
					}
				}
				if($description == '' || $description == null){
					$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
				}
				$data['meta_description'] = $description;
				$data['meta_author'] = 'Avenue 1-OH-1';
												
				$data['meta_keywords'] = $keywords;
						
				//assign page title name
				$data['pageTitle'] = 'Sign Success';
			
				//assign page ID
				$data['pageID'] = 'signup_success';

				$this->load->view('pages/header', $data);
								
				//load main body
				$this->load->view('pages/signup_success_page', $data);  
				
				$this->load->view('pages/footer');
			
			}
			
        }

		

		/**
		* Function to ensure a country is selected 
		* 
		*/			
		public function country_option_check(){
			
			$str1 = $this->input->post('country');
			
			if ($str1 == 'Select Country' )
			{
				$this->form_validation->set_message('country_option_check', 'Please select a question');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}



		/**
		* Function to for forgot password
		*
		*/
		public function forgot_password()
		{
		
			if($this->session->userdata('logged_in')){
					
					//user already logged in, redirects to account page
					redirect('account/dashboard');
					
			}	
			else {
					
					if($this->input->get('redirectURL') != ''){
						$url = $this->input->get('redirectURL');
						$this->session->set_flashdata('redirectURL', $url);	
					}
					
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
					
				
					//assign meta tags
					$page = 'forgot_password';
					$keywords = '';
					$description = '';
					$metadata_array = $this->Page_metadata->get_page_metadata($page);
					if($metadata_array){
						foreach($metadata_array as $meta){
							$keywords = $meta->keywords;
							$description = $meta->description;
						}
					}
					if($description == '' || $description == null){
						$description = 'Forgot Password';
					}
					$data['meta_description'] = $description;
					$data['meta_author'] = 'Avenue 1-OH-1';
										
					$data['meta_keywords'] = $keywords;
					
					//assign page title name
					$data['pageTitle'] = 'Forgotten Password';
					
					//assign page ID
					$data['pageID'] = 'forgot_password';
					
					//load header
					$this->load->view('pages/header', $data);
				
					//load main body
					$this->load->view('pages/forgot_password_page', $data);
					
					//load footer
					$this->load->view('pages/footer');
			}		

		}
		
		
		
		/**
		* Function to validate email
		*
		*/			
		public function validate_email(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$email = html_escape($this->input->post('email'));
			
			//ENSURE USER HASNT EXCEEDED
			//ALLOWED RESET ATTEMPTS IN THE LAST 24 HOURS
			if($this->not_max_reset_attempts()){
				
				//ENSURE THE EMAIL ADDRESS EXISTS
				if (!$this->Users->unique_user($email)){
					
					//ENSURE USER HAS NOT BEEN SUSPENDED
					if(!$this->Users->user_suspended($email)){
						//return TRUE;
						//get Users info
						$user_array = $this->Users->get_user($email);
						$security_question = '';
						if($user_array){
							foreach($user_array as $user){
								$security_question = $user->security_question;
							}
						}
							
						$data['security_question'] = $security_question;
						$data['success'] = TRUE;
					}else{
						//$this->form_validation->set_message('validate_email', 'This account has been suspended! Please contact Customer Service!');	
						//return FALSE;
						
						$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> This account has been suspended! Please contact Customer Service!</div>';
						$data['success'] = false;
					}
					
				}
				//EMAIL ADDRESS DOESNT EXIST
				else {		
					
					//obtain users ip address
					$ipaddress = $this->Failed_resets->ip();

					$answer = $this->input->post('security_answer');
					if($answer == '' || $answer == null){
						$answer = '';
					}
					
					//LOCALHOST ARRAY IPV4 IPV6
					$whitelist = array('127.0.0.1', '::1');	
					
					$ipdetails = '';
					
					//ENSURE USER MACHINE IS NOT LOCALHOST
					if(!in_array($ipaddress, $whitelist)){
						//ipinfo 
						$details = $this->misc_lib->ip_details($ipaddress);
						$ipdetails .= '<p><strong> Hostname:</strong> '.$details['hostname'].'</p>';
						$ipdetails .= '<p><strong> City:</strong> '.$details['city'].'</p>';
						$ipdetails .= '<p><strong> Region:</strong> '.$details['region'].'</p>';
						
						$detail = $this->db->select('*')->from('countries')->where('LOWER(sortname)',strtolower($details['country']))->get()->row();
						$country = '';
						if($detail){
							$country = $detail->name;
						}
						
						$ipdetails .= '<p><strong> Country:</strong> '.$country.'</p>';
						$ipdetails .= '<p><strong> LOC:</strong> '.$details['loc'].'</p>';
						$ipdetails .= '<p><strong> Org:</strong> '.$details['org'].'</p>';
					}
					
					//array of all reset posts
					$data = array(
						'ip_address' => $ipaddress,
						'ip_details' => $ipdetails,
						'email' => $email,
						'security_answer' => $answer,
						'attempt_time' => date('Y-m-d H:i:s')
					);	
					$this->Failed_resets->insert_failed_reset($data);
					
					//$this->form_validation->set_message('validate_email', 'No record of this email address.');
					//return FALSE;	
					
					$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> This email address is not registered!</div>';
					$data['success'] = false;
				}
				
			}
			//RESET EXCEEDED IN THE LAST 24 HOURS
			else{
				//$this->form_validation->set_message('validate_email', 'You have surpassed the allowed number of reset attempts in 24 hours! Please contact Customer Service!');	
				//return FALSE;
				$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> You have exceeded the number of reset attempts allowed in 24 hours!</div>';
				$data['success'] = false;
				
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
		}

				
		/**
		* Function to validate security_answer
		*
		*/			
		public function validate_security_answer(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$email = html_escape($this->input->post('email'));
			$answer = html_escape($this->input->post('security_answer'));
			$question = html_escape($this->input->post('question'));
			
			if($answer != '' && $answer != null){
				
				//check the number of attempts
				if($this->not_max_reset_attempts()){
					
					if ($this->Users->valid_answer($email, $question, $answer)){
						$data['success'] = true;
					} else {
						//obtain users ip address
						$ipaddress = $this->Failed_resets->ip();

						$answer = $this->input->post('security_answer');
						if($answer == '' || $answer == null){
							$answer = '';
						}
						
						//LOCALHOST ARRAY IPV4 IPV6
						$whitelist = array('127.0.0.1', '::1');	
						
						$ipdetails = '';
						
						//ENSURE USER MACHINE IS NOT LOCALHOST
						if(!in_array($ipaddress, $whitelist)){
							//ipinfo 
							$details = $this->misc_lib->ip_details($ipaddress);
							$ipdetails .= '<p><strong> Hostname:</strong> '.$details['hostname'].'</p>';
							$ipdetails .= '<p><strong> City:</strong> '.$details['city'].'</p>';
							$ipdetails .= '<p><strong> Region:</strong> '.$details['region'].'</p>';
							
							$detail = $this->db->select('*')->from('countries')->where('LOWER(sortname)',strtolower($details['country']))->get()->row();
							$country = '';
							if($detail){
								$country = $detail->name;
							}
							
							$ipdetails .= '<p><strong> Country:</strong> '.$country.'</p>';
							$ipdetails .= '<p><strong> LOC:</strong> '.$details['loc'].'</p>';
							$ipdetails .= '<p><strong> Org:</strong> '.$details['org'].'</p>';
						}
						
						//array of all reset posts
						$data = array(
							'ip_address' => $ipaddress,
							'ip_details' => $ipdetails,
							'email' => $email,
							'security_answer' => $answer,
							'attempt_time' => date('Y-m-d H:i:s')
						);	
						$this->Failed_resets->insert_failed_reset($data);
						
						$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Your answer does not match!</div>';
						$data['success'] = false;
					}
				}else{
					$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> You have exceeded the number of reset attempts allowed in 24 hours!</div>';
					$data['success'] = false;
				}
			}else{
				$data['notif'] = '<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Please enter an answer!</div>';
				$data['success'] = false;
			}
			
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);				
		}
		
		/**
		* Function to check if the user has tried to reset wrongly
		* more than 3 times in 24 hours
		*/			
		public function not_max_reset_attempts(){
			
			//$username = $this->input->post('username');
			$email = $this->input->post('email');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_resets');
			//$this->db->where('username', $username);
			$this->db->where('email', $email);
			
			$this->db->where("attempt_time BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() < 3){		
				return TRUE;	
			}else {	
				//$this->form_validation->set_message('max_reset_attempts', 'You have surpassed the allowed number of reset attempts in 24 hours! Please contact Customer Service!');	
				return FALSE;
			}
		}
			

		/**
		* Function to validate forgot_password
		*
		*/
        public function forgot_password_validation() {
			
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            //$this->form_validation->set_rules('username','Username','required|trim');
            $this->form_validation->set_rules('email','Email Address','required|trim|xss_clean|valid_email');
			//$this->form_validation->set_rules('password','Password','required|trim|xss_clean|matches[confirm_password]');
			//$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|xss_clean');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email address!');
			
            if ($this->form_validation->run()){
				
				//default IP function
				$ip = $this->input->ip_address();
						
				//LOCALHOST ARRAY IPV4 IPV6
				$whitelist = array('127.0.0.1', '::1');	
					
				$ipdetails = '';
					
					//ENSURE USER MACHINE IS NOT LOCALHOST
					if(!in_array($ip, $whitelist)){
						//ipinfo 
						$details = $this->misc_lib->ip_details($ip);
						$ipdetails .= '<p><strong> Hostname:</strong> '.$details['hostname'].'</p>';
						$ipdetails .= '<p><strong> City:</strong> '.$details['city'].'</p>';
						$ipdetails .= '<p><strong> Region:</strong> '.$details['region'].'</p>';
						
						$detail = $this->db->select('*')->from('countries')->where('LOWER(sortname)',strtolower($details['country']))->get()->row();
						$country = '';
						if($detail){
							$country = $detail->name;
						}
						
						$ipdetails .= '<p><strong> Country:</strong> '.$country.'</p>';
						$ipdetails .= '<p><strong> LOC:</strong> '.$details['loc'].'</p>';
						$ipdetails .= '<p><strong> Org:</strong> '.$details['org'].'</p>';
					}
					
				//generate a random key
				$activation_code = md5(uniqid());
				
				//array of all reset posts
				$reset = array(
					'ip_address' => $ip,
					'ip_details' => $ipdetails,
					'email' => $this->input->post('email'),
					'activation_code' => $activation_code,
					'request_date' => date('Y-m-d H:i:s')
				);	
				
				//insert to temp database
				if ($this->Password_resets->insert_password_resets($reset)){
					
					//get clients info
					$user_array = $this->Users->get_user($this->input->post('email'));
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
					
					//send email alert
					$to = $this->input->post('email');
					$subject = 'Password Reset';
					$message = "<p>We have received your password request.</p>";
					$message .= "<p>Click the link below to reset your password:</p>";
					$message .= "<p><a href='".base_url()."password/reset/?activation=".$activation_code."'>Reset Password</a>.</p>";
					
					$this->Messages->send_email_alert($to, $subject, $fullname, $message);
					
					//$this->session->set_flashdata('username', $this->input->post('username'));
					//$this->session->set_flashdata('email', $this->input->post('email'));
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success"><i class="glyphicon glyphicon-ok"></i> Please check your email to reset your password.</div>';
					
					//user already logged in, redirects to account page
					//redirect('myaccount/dashboard');
				
				}
				
				
            }
            else {
				$data['success'] = false;
				$data['notif'] = '<div class="">'.validation_errors().'</div>';
				
				//validation errors
				//$this->forgot_password();
            }
           
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
				
		}			

				/**
		* Function to validate that the activation key
		* exists in the database
		* @param $string Activation key
		*/			
		public function is_valid_code($activation_code = ''){
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			//check for code 24 hour expiration
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);			
			
			$this->db->where('activation_code', $activation_code);
			$this->db->where("request_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);
			
			$query = $this->db->get('password_resets');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				//if key expired delete record
				$this->db->where('activation_code', $activation_code);
				$this->db->delete('password_resets');
				
				return false;
			}			
		}

		/**
		* Function to for forgot password
		*
		*/
		public function password_reset()
		{
		
			if($this->session->userdata('logged_in')){
					
					//user already logged in, redirects to account page
					redirect('account/dashboard');
					
			}	
			else {
					
				if($this->input->get('activation')){
						
					$this->input->get(NULL, TRUE); // returns all GET items with XSS filter
					$activation_code = html_escape($this->input->get('activation'));
						
					if($this->is_valid_code($activation_code)){
						
						$detail = $this->db->select('*')->from('password_resets')->where('activation_code', $activation_code)->get()->row();
							
						$email = '';
						if($detail){
							$email = $detail->email;
						}
							
						
						if($this->input->get('redirectURL') != ''){
							$url = $this->input->get('redirectURL');
							$this->session->set_flashdata('redirectURL', $url);	
						}
						
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
						
					
						//assign meta tags
						$page = 'forgot_password';
						$keywords = '';
						$description = '';
						$metadata_array = $this->Page_metadata->get_page_metadata($page);
						if($metadata_array){
							foreach($metadata_array as $meta){
								$keywords = $meta->keywords;
								$description = $meta->description;
							}
						}
						if($description == '' || $description == null){
							$description = 'Forgot Password';
						}
						$data['meta_description'] = $description;
						$data['meta_author'] = 'Avenue 1-OH-1';
											
						$data['meta_keywords'] = $keywords;
						
						$data['email'] = $email;
						
						//assign page title name
						$data['pageTitle'] = 'Password Reset';
						
						//assign page ID
						$data['pageID'] = 'password_reset';
						
						//load header
						$this->load->view('pages/header', $data);
					
						//load main body
						$this->load->view('pages/password_reset_page', $data);
						
						//load footer
						$this->load->view('pages/footer');
							
					}
						
				}
					
			}		

		}
		
		
		/**
		* Function to validate forgot_password
		*
		*/
        public function new_password_validation() {
			
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            
            $this->form_validation->set_rules('email','Email Address','required|trim|xss_clean|valid_email');
			$this->form_validation->set_rules('password','Password','required|trim|xss_clean|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|xss_clean');
            
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('valid_email', 'Please enter a valid email address!');
			
            if ($this->form_validation->run()){
				//generate a random key
				//$activation_code = md5(uniqid());
				
				$email = $this->input->post('email');
				
				//hashing the password
				$hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				
				$update = array(
					'password' => $hashed_password,
					'last_updated' => date('Y-m-d H:i:s'),
				);
				
				//UPDATE USER PASSWORD
				if ($this->Users->user_update($update, $email)){
	
					//default IP function
					$ip = $this->input->ip_address();
						
					//LOCALHOST ARRAY IPV4 IPV6
					$whitelist = array('127.0.0.1', '::1');	
					
					$ipdetails = '';
					
					//ENSURE USER MACHINE IS NOT LOCALHOST
					if(!in_array($ip, $whitelist)){
						//ipinfo 
						$details = $this->misc_lib->ip_details($ip);
						$ipdetails .= '<p><strong> Hostname:</strong> '.$details['hostname'].'</p>';
						$ipdetails .= '<p><strong> City:</strong> '.$details['city'].'</p>';
						$ipdetails .= '<p><strong> Region:</strong> '.$details['region'].'</p>';
						
						$detail = $this->db->select('*')->from('countries')->where('LOWER(sortname)',strtolower($details['country']))->get()->row();
						$country = '';
						if($detail){
							$country = $detail->name;
						}
						
						$ipdetails .= '<p><strong> Country:</strong> '.$country.'</p>';
						$ipdetails .= '<p><strong> LOC:</strong> '.$details['loc'].'</p>';
						$ipdetails .= '<p><strong> Org:</strong> '.$details['org'].'</p>';
					}
					
					//array of all reset posts
					$reset = array(
						'ip_address' => $ip,
						'ip_details' => $ipdetails,
						'email' => $this->input->post('email'),
						//'security_answer' => $this->input->post('security_answer'),
						//'activation_code' => $activation_code,
						'request_date' => date('Y-m-d H:i:s')
					);	
					$this->Password_resets->insert_password_resets($reset);
					
					//get clients info
					$user_array = $this->Users->get_user($this->input->post('email'));
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
					
					//send email alert
					$to = $this->input->post('email');
					$subject = 'Account Password Reset';
					$message = "<p>Your account password has been changed.</p>";
					$message .= '<p>If you did not make this request please contact Customer Service immediately at <a href="mailto:services@dejor.com">services@dejor.com</a> or (234) 7080 8887.</p>';
					
					$this->Messages->send_email_alert($to, $subject, $fullname, $message);
					
					//$this->session->set_flashdata('username', $this->input->post('username'));
					//$this->session->set_flashdata('email', $this->input->post('email'));
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center"><p><i class="fa fa-check-circle-o fa-lg" aria-hidden="true"></i> Your password has been successfully reset.</p><br/><p class="text-center"><a class="btn waves-effect waves-light white-text" href="'.base_url('login').'">Login <i class="material-icons right">send</i></a></p></div>';
					
				}
			
					//user already logged in, redirects to account page
					//redirect('myaccount/dashboard');
				
				
				
            }
            else {
				$data['success'] = false;
				$data['notif'] = '<div class="">'.validation_errors().'</div>';
				
				//validation errors
				//$this->forgot_password();
            }
           
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
				
		}			
			
						

		
		/**
		* Function to check if the user has tried to reset wrongly
		* more than 3 times in 24 hours
		*/			
		public function max_reset_attempts(){
			
			//$username = $this->input->post('username');
			$email = $this->input->post('email');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_resets');
			//$this->db->where('username', $username);
			$this->db->where('email_address', $email);
			
			$this->db->where("attempt_time BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() < 3){		
				return TRUE;	
			}else {	
				$this->form_validation->set_message('max_reset_attempts', 'You have surpassed the allowed number of reset attempts in 24 hours! Please contact Customer Service!');	
				return FALSE;
			}
		}
						
						

		/**
		* Function to validate review 
		* submit
		*/			
		public function submit_review() {
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center">', '</div>');
			
            $this->form_validation->set_rules('review_name','Name','required|trim|xss_clean|min_length[4]|callback_check_double_review');
			$this->form_validation->set_rules('review_email','Email','required|trim|valid_email');
			$this->form_validation->set_rules('review_comment','Comment','required|trim|xss_clean|min_length[6]');
            $this->form_validation->set_rules('pID','Product ID','required|trim|xss_clean');
			$this->form_validation->set_rules('rating','Rating','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter your %s!');
			$this->form_validation->set_message('min_length', '%s must be longer!');
			
			$this->form_validation->set_message('valid_email', 'Please enter a valid email!');
			
			if ($this->form_validation->run()){
				
					//array of all post variables
					$review_data = array(
						'product_id' => $this->input->post('pID'),
						'rating' => $this->input->post('rating'),
						'reviewer_name' => $this->input->post('review_name'),
						'reviewer_email' => $this->input->post('review_email'),
						'comment' => $this->input->post('review_comment'),
						'review_date' => date('Y-m-d H:i:s'),
					);
				
					$this->Reviews->insert_review($review_data);

					//redirect('home/contact_us', $data);	
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Thank you for your review!</div>';
				
				
			}else {
					//redirects to contact us page
					//$this->contact_us();	
					$data['success'] = false;
					$data['notif'] = '<div class="text-center" role="alert"> <i class="fa fa-check-circle"><i class="fa fa-ban"></i>'.validation_errors().'</div>';
					
					
			}
                echo json_encode($data);
        }
	
		/**
		* Function to check double review 
		* 
		*/			
		public function check_double_review(){
			
			$review_name = $this->input->post('review_name');
			$review_email = $this->input->post('review_email');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('reviews');
			$this->db->where('reviewer_name', $review_name);
			$this->db->where('reviewer_email', $review_email);
			
			$this->db->where("review_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_double_review', 'You must wait at least 20 seconds before you submit another review!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}			
	

		
			
		
		public function logged_out() {
			
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
					
			//assign meta tags
			$page = 'logged_out';
			$keywords = '';
			$description = '';
			$metadata_array = $this->Page_metadata->get_page_metadata($page);
			if($metadata_array){
				foreach($metadata_array as $meta){
					$keywords = $meta->keywords;
					$description = $meta->description;
				}
			}
			if($description == '' || $description == null){
				$description = 'Avenue 1-OH-1 - one stop shop for everything fancy and glam';
			}
			$data['meta_description'] = $description;
			$data['meta_author'] = 'Avenue 1-OH-1';
											
			$data['meta_keywords'] = $keywords;
					
			//assign page title name
			$data['pageTitle'] = 'Logged Out';
			
			//assign page ID
			$data['pageID'] = 'logged_out';
								
			//load header
			$this->load->view('pages/header', $data);
						
			//load main body
            $this->load->view('pages/logout_page', $data);
			
			//load main footer
			$this->load->view('pages/footer');				
						
			
        } 		
	
	
	
	
	
	
	
}
