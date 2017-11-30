<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		$this->dashboard();
	}


	public function login()
	{
		if($this->session->userdata('admin_logged_in')){
				
				//user already logged in, redirects to account page
				redirect('admin/dashboard');
				
		}	
		else {
				
				if($this->input->get('redirectURL') != ''){
					$url = $this->input->get('redirectURL');
					$this->session->set_flashdata('redirectURL', $url);	
				}
				//assign page title name
				$data['pageTitle'] = 'Admin Login';
				
				//assign page ID
				$data['pageID'] = 'admin_login';
				
				//load main body
				$this->load->view('admin_pages/admin_login_page', $data);
		}		

	}


	/**
		* Function to validate admin login
		*
		*/
        public function login_validation() {
			
			$this->session->keep_flashdata('redirectURL');
            
            $this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('username','Username','required|trim|xss_clean|callback_validate_credentials|callback_max_login_attempts');
            $this->form_validation->set_rules('password','Password','required|trim|xss_clean');
            
			 $this->form_validation->set_message('required', '%s cannot be blank!');
			
            if ($this->form_validation->run()){
				
				$data = array(
					'admin_username' => $this->input->post('username'),
					'admin_logged_in' => 1,
				);
				$this->session->set_userdata($data);

				//user already logged in, redirects to account page
				redirect('admin/dashboard');
				
            }
            else {
				
				//user not logged in, redirects to login page
				$this->login();
            }
                
		}		
		
		/**
		* Function to validate username
		*
		*/		
		public function validate_credentials() {
			
			if ($this->Admin->admin_can_log_in()){
				
				$username = $this->input->post('username');
				
				//check admin last login time from the logins table
				$last_login = $this->db->select_max('login_time')->from('logins')->where("username",$username)->get()->row();
				if(!empty($last_login)){
					$time = $last_login->login_time;
					//array of session variables
					$data = array(	
						'last_login' => $time,
					);	
					$this->Admin->update_user($data, $username);
				}
				
				//obtain users ip address
				$ipaddress = $this->Admin->ip();			
				
				//array of all login posts
				$data = array(
					'ip_address' => $ipaddress,
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password')),
					'login_time' => date('Y-m-d H:i:s')
					
				);	
				
				//create new login record after updating with previous entry
				$this->Logins->insert_login($data);
				return TRUE;
			}
			else {
					
				//obtain users ip address
				$ipaddress = $this->Admin->ip();			
				
				//array of all login posts
				$data = array(
					'ip_address' => $ipaddress,
					'username' => $this->input->post('username'),
					'password' => md5($this->input->post('password')),
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
			
			$username = $this->input->post('username');
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('failed_logins');
			$this->db->where('username', $username);
			
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
		* Function to access admin account
		*
		*/
        public function dashboard() {
			 
			if($this->session->userdata('admin_logged_in')){
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				
				$username = $this->session->userdata('admin_username');
				
				//$data['username']=$username;
				
				$data['user_array'] = $this->Admin->get_user($username);
				
				$admin_name = '';
				$last_login = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$last_login = $user->last_login;
						$admin_name = $user->admin_name;
					}
					if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						$last_login = 'Never'; 
					}else{ 
						$last_login = date("F j, Y, g:i a", strtotime($last_login)); 
					}
				}
				
				$data['last_login'] = $last_login;
				$data['admin_name'] = $admin_name;
				$data['admin_username'] = $username;
				
				$data['contact_us_count'] = $this->Contact_us->count_unread_messages();
				if($data['contact_us_count'] == '' || $data['contact_us_count'] == null){
					$data['contact_us_count'] = 0;
				}	
				
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
				
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);	
				
				
				$data['transactions_count'] = $this->Transactions->count_new_transactions();
				if($data['transactions_count'] == '' || $data['transactions_count'] == null){
					$data['transactions_count'] = 0;
				}	
				$data['transactions_array'] = $this->Transactions->get_all_transactions(5, 0);	
				
				$data['logins_array'] = $this->Logins->get_logins(5, 0);
				
				$data['failed_logins_array'] = $this->Failed_logins->get_failed_logins(5, 0);
				
				$data['users_array'] = $this->Users->get_users(4, 0);
					
				
				$activities = $this->Site_activities->get_activities(7, 0);
				
				$activity_group = '';
				$activity_class = '';
				
				if(!empty($activities)){
					foreach($activities as $activity){
						//get time ago
						$activity_time = $this->Site_activities->time_elapsed_string(strtotime($activity->activity_time));
						$icon = '<i class="fa fa-list-alt" aria-hidden="true"></i>';
						
						//obtain keyword icon from the db using sender email
						$query = $this->db->get_where('keywords', array('keyword' => $activity->keyword));
						if($query){
							foreach ($query->result() as $row){
								$icon = $row->icon;
							}							
						}
						
						$activity_group .= '<a href="javascript:void(0)" class="list-group-item">';
						$activity_group .= '<span class="badge">'.$activity_time.'</span>';
						$activity_group .= $icon .' '.$activity->name.' '.$activity->description;
						$activity_group .= '</a>';
						$activity_class = '';
					}
				}else{
					$activity_group = '<br/><br/><h2 align="center"><a href="#" class="list-group-item"><i class="fa fa-star-o" aria-hidden="true"></i> No activities yet</a></h2>';
					$activity_class = 'fixed_height_405';
				}
				
				$data['activity_group'] = $activity_group;
				$data['activity_class'] = $activity_class;	
				
				$data['activity_group'] = $activity_group;
							
				//assign page title name
				$data['pageTitle'] = 'Admin Dashboard';
				
				//assign page ID
				$data['pageID'] = 'dashboard';
				
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/admin_account_page', $data);
				
				//load footer
				$this->load->view('admin_pages/footer');
				
			}
			else {
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					$url = 'admin/login?redirectURL='.$redirect;
					redirect($url);
				}else{	

					redirect('admin/login');
					//user not logged in, redirects to login page
					//redirect('home/','refresh');           
				} 

			}
            
        } 


		/***
		* Function to handle admins
		*
		***/		
		public function admin_users(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				if($this->Admin->check_admin_access()){
					
					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
						
					//assign page title name
					$data['pageTitle'] = 'Admin Users';
								
					//assign page title name
					$data['pageID'] = 'admin_users';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/admin_users_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
					
					
				}else{
					//Admin access error
					redirect('admin/error');
				}
			}
		}

		
		/***
		* Function to handle admin ajax
		*
		***/
		public function admin_users_datatable()
		{
			$list = $this->Admin->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$user->id.'">';
				
				$row[] = '<a href="javascript:void(0)" data-toggle="modal" data-target="#viewModal" class="link" id="'.$user->id.'" title="View '.ucwords($user->admin_name).'" onclick="viewAdmin('.$user->id.')">'.ucwords($user->admin_name).' ('.$user->admin_username.')</a>';
				
				$row[] = $user->access_level;
			
				$last_login = $user->last_login;
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
					$last_login = 'Never'; 
				}else{ 
					$last_login = date("F j, Y, g:i a", strtotime($last_login)); 
				}
				$row[] = $last_login;
				
				$row[] = date("F j, Y", strtotime($user->date_created));
				
				//prepare buttons
				$model = 'admin_users';
				
				$row[] = '<a data-toggle="modal" data-target="#messageModal" class="btn btn-success btn-xs" onclick="sendDirectMessage('.$user->id.',\''.$model.'\')" id="'.$user->id.'" title="Send Message to '.ucwords($user->admin_name).'"><i class="fa fa-envelope"></i> Message</a>
				<a data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-xs" id="'.$user->id.'" title="Click to Edit" onclick="editAdmin('.$user->id.')"><i class="fa fa-pencil"></i> Edit</a>';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Admin->count_all(),
				"recordsFiltered" => $this->Admin->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

	
		/**
		* Function to handle
		* user view and edit
		* display
		*/	
		public function admin_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('admin_users')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->admin_name;			

					$thumbnail = '';
					$update_thumbnail = '';
					$filename = FCPATH.'uploads/admins/'.$detail->id.'/'.$detail->avatar;

					//check if record in db is url thus facebook or google
					if(filter_var($detail->avatar, FILTER_VALIDATE_URL)){
						//diplay facebook avatar
						$thumbnail = '<img src="'.$detail->avatar.'" class="social_profile img-circle avatar-view" width="108" height="108" />';
						$update_thumbnail = '<img src="'.$detail->avatar.'" class="social_profile img-responsive" width="108" height="108" />';
					}
					elseif($detail->avatar == '' || $detail->avatar == null || !file_exists($filename)){
						$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle avatar-view" width="108" height="108" />';
						$update_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive" width="170" height="170" />';
					}
					
					else{
						$thumbnail = '<img src="'.base_url().'uploads/admins/'.$detail->id.'/'.$detail->avatar.'" class="img-circle avatar-view" width="108" height="108" />';
						$update_thumbnail = '<img src="'.base_url().'uploads/admins/'.$detail->id.'/'.$detail->avatar.'" class="img-responsive" width="170" height="170" />';
					}	
					$data['thumbnail'] = $thumbnail;
					$data['update_thumbnail'] = $update_thumbnail;
					$data['admin_username'] = $detail->admin_username;
					$data['admin_password'] = $detail->admin_password;
					$data['admin_name'] = $detail->admin_name;
					$data['access_level'] = $detail->access_level;
					
					//access level dropdown box
					$access_level = '<select name="access_level" class="form-control  select2" id="access_level">';
					for($i=1; $i<4; $i++){
						$default = ($i == $detail->access_level)?'selected':'';
						$access_level .= '<option value="'.$i.'" '.$default.'>'.$i.'</option>';	
					}
					$access_level .= '</select>';
					
					$data['select_access_level'] = $access_level;
					
					$data['date_created'] = date("F j, Y", strtotime($detail->date_created));
					
					$last_login = '';
					if($detail->last_login == '0000-00-00 00:00:00' || $detail->last_login == ''){
						$last_login = 'Never';
					}else{
						$last_login = date("F j, Y, g:i a", strtotime($detail->last_login));
					}
					$data['last_login'] = $last_login;
					
					$data['model'] = 'admin_users';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}	
		
		/**
		* Function to validate add admin
		*
		*/			
		public function add_admin(){

			$this->load->library('form_validation');
					
			$this->form_validation->set_rules('admin_name','Admin Name','required|trim|xss_clean');
			$this->form_validation->set_rules('admin_username','Admin Username','required|trim|xss_clean|is_unique[admin_users.admin_username]');
			$this->form_validation->set_rules('admin_password','Admin Password','required|trim|xss_clean|md5');
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Username already exists!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			if($this->form_validation->run()){
							
				$admin_data = array(
					'admin_name' => $this->input->post('admin_name'),
					'admin_username' => $this->input->post('admin_username'),
					'admin_password' => $this->input->post('admin_password'),
					'access_level' => '1',
					'date_created' => date('Y-m-d H:i:s'),
				);

				$insert_id = $this->Admin->create_admin($admin_data);
							
				if($insert_id){
								
					if(isset($_FILES["newUserPhoto"])){
									
						$file_name = '';
									
						$path = './uploads/admins/'.$insert_id.'/';
						if(!is_dir($path)){
							mkdir($path,0777);
						}
						$config['upload_path'] = $path;
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = 2048000;
						$config['max_width'] = 3048;
						$config['max_height'] = 2048;
										
						$config['file_name'] = $insert_id.'.jpg';
									
						$this->load->library('upload', $config);	

						$this->upload->overwrite = true;
								
						if($this->upload->do_upload('newUserPhoto')){
								
							$upload_data = $this->upload->data();
											
							if (isset($upload_data['file_name'])){
								$file_name = $upload_data['file_name'];
							}	
									
						}else{
							$data['upload_error'] = $this->upload->display_errors();
						}
								
						$profile_data = array(
							'avatar' => $file_name,		
						);
						$this->Admin->update_admin($profile_data, $insert_id);	
								
					}
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new admin';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						

					$this->session->set_flashdata('admin_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> A new admin user (<i>'.$this->input->post('admin_name').'</i>) has been created!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new admin user (<i>'.$this->input->post('admin_name').'</i>) has been created!</div>';
							
				}else{
							
					$this->session->set_flashdata('admin_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-danger text-center"><i class="fa fa-check-circle"></i> The new admin user has not been created!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new admin user has not been created!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update admin 
		* form
		*/			
		public function update_admin(){
			
			$id = html_escape($this->input->post('adminID'));
			
			$admin_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
			$upload = false;
			
			if(!empty($_FILES['uploadPhoto']['name'])){
						
				
				//$upload = false;
						
				$path = './uploads/admins/'.$admin_id.'/';
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
							
				$config['file_name'] = $admin_id.'.jpg';
						
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$upload = true;
											
			}
					
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('admin_password','Password','trim|xss_clean');
			$this->form_validation->set_rules('access_level','Access Level','required|trim|xss_clean');	
						
			if ($this->form_validation->run()){
					
				$username = $this->input->post('admin_username');
					
				$user = $this->Admin->get_user($username);
				$avatar = '';
				
				if($upload){
						
					if($this->upload->do_upload('uploadPhoto')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors with the photo!<br/>'.$this->upload->display_errors().'</div>';
						}
						
					}
				}else{
					//$data['upload_error'] = $this->upload->display_errors();
					foreach($user as $u){
						$avatar = $u->avatar;
					}
				}

				$password = '';
				if($this->input->post('new_password') == ''){
					$password = $this->input->post('old_password');
				}else{
					$password = $this->input->post('new_password');
				}

				$admin_data = array(
					'avatar' => $avatar,
					'admin_password' => $password,
					'access_level' => $this->input->post('access_level'),
				);
					
				if ($this->Admin->update_admin($admin_data, $admin_id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a new admin';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						

					$this->session->set_flashdata('admin_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Admin updated!</div>');
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Admin has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			


				
				
		/***
		* Function to handle users
		*
		***/		
		public function users(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

					$username = $this->session->userdata('admin_username');
				
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
				
					$data['fullname'] = $fullname;
					
					$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
					$messages_unread = $this->Messages->count_unread_messages($username);
					if($messages_unread == '' || $messages_unread == null){
						$data['messages_unread'] = 0;
					}else{
						$data['messages_unread'] = $messages_unread;
					}
					
					$data['header_messages_array'] = $this->Messages->get_header_messages($username);
					
					$length = 10;
					$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					//$rnd = md5(time()).''.$characters;
					$password_string = substr(str_shuffle($characters), 0, $length);
					$data['password_string'] = $password_string;
					
					//country list dropdown
					$country_options = '<select name="country"  class="form-control" id="cntry">';
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
					
					
					//assign page title name
					$data['pageTitle'] = 'Users';
								
					//assign page title name
					$data['pageID'] = 'users';
										
					//load header and page title
					$this->load->view('admin_pages/header', $data);
							
					//load main body
					$this->load->view('admin_pages/users_list_page', $data);	
					
					//load footer
					$this->load->view('admin_pages/footer');
					
			}
				
		}				
	
		
		/***
		* Function to handle users ajax
		* Datatable
		***/
		public function active_users_datatable()
		{
			$list = $this->Users->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$user->id.'">';
				
				$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="40" height="50" />';
				
				$row[] = $thumbnail;
				
				$row[] = '<a data-toggle="modal" data-target="#viewModal" class="link" onclick="viewUser('.$user->id.');" id="'.$user->id.'" title="View '.$user->first_name .' '.$user->last_name.'">'.$user->first_name .' '.$user->last_name.' ('.$user->email_address.')</a>';
				
				$address = $user->address_line_1.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				if($user->address_line_2 != ''){
					$address = $user->address_line_1.', '.$user->address_line_2.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				}
				$row[] = $address;
				
				//$account_balance = number_format($user->account_balance, 2);
				//$row[] = $account_balance;
				
				//$row[] = $member->username;
				//$row[] = $user->account_number;
				
				$last_login = $user->last_login;
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						$last_login = 'Never'; 
				}else{ 
					$last_login = date("d M y", strtotime($last_login)).' at '.date("h:i A", strtotime($last_login)); 
					//date("d M y h:i A", strtotime($last_login))
					
					
				}	
				$row[] = $last_login;
				
			//	$row[] = date("F j, Y", strtotime($user->date_created));
				
				$model = 'users';
				
				//prepare buttons
				
				
				$row[] = '<a data-toggle="modal" data-target="#messageModal" class="btn btn-default btn-xs" onclick="sendDirectMessage('.$user->id.',\''.$model.'\')" id="'.$user->id.'" title="Send Message to '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-envelope"></i></a>
				
				<a data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-xs" onclick="editUser('.$user->id.');" id="'.$user->id.'" title="Edit '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-edit"></i></a>
				
				<a data-toggle="modal" data-target="#suspendModal" class="btn btn-danger btn-xs" onclick="suspendUser('.$user->id.');" id="'.$user->id.'" title="Suspend '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-ban"></i></a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Users->count_all(),
				"recordsFiltered" => $this->Users->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

		
		/***
		* Function to handle suspended users
		*  ajax Datatable
		***/
		public function suspended_users_datatable()
		{
			$list = $this->Users->get_deactivated_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$user->id.'">';
				
				$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="40" height="50" />';
				
				$row[] = $thumbnail;
				$row[] = '<a data-toggle="modal" data-target="#viewModal" class="link" onclick="viewUser('.$user->id.');" id="'.$user->id.'" title="View '.$user->first_name .' '.$user->last_name.'">'.$user->first_name .' '.$user->last_name.' ('.$user->email_address.')</a>';
				
				$address = $user->address_line_1.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				if($user->address_line_2 != ''){
					$address = $user->address_line_1.', '.$user->address_line_2.', '.$user->city.' '.$user->postcode.', '.$user->state.', '.$user->country;
				}
				$row[] = $address;
				
				$account_balance = number_format($user->account_balance, 2);
				$row[] = $account_balance;
				
				$last_login = $user->last_login;
				if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
						$last_login = 'Never'; 
				}else{ 
					$last_login = date("d M y", strtotime($last_login)).' at '.date("h:i A", strtotime($last_login)); 
					//date("d M y h:i A", strtotime($last_login))
					
					
				}	
				$row[] = $last_login;
				
				$row[] = date("F j, Y", strtotime($user->date_created));
				
				$row[] = '<a data-toggle="modal" data-target="#reactivateModal" class="btn btn-success btn-xs" onclick="reactivateUser('.$user->id.');" id="'.$user->id.'" title="Reactivate '.$user->first_name .' '.$user->last_name.'"><i class="fa fa-undo"></i> Reactivate</a>';
				
				$model = 'users';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Users->count_all_deactivated(),
				"recordsFiltered" => $this->Users->count_filtered_deactivated(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		/***
		* Function to handle temp users ajax
		* Datatable
		***/
		public function temp_users_datatable()
		{
			$list = $this->Temp_users->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $user) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$user->id.'">';
				
				$row[] = $user->first_name .' '.$user->last_name.' ('.$user->username.')';
				
				$row[] = $user->email_address;
				$row[] = $user->mobile;
				//$row[] = $member->username;
				//$row[] = $user->account_number;
				
				$row[] = date("F j, Y", strtotime($user->date_created));
				
				$model = 'temp_users';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Temp_users->count_all(),
				"recordsFiltered" => $this->Temp_users->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		/**
		* Function to handle
		* clients view and edit
		* display
		*/	
		public function user_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->first_name .' '.$detail->last_name;	
					
					$data['fullName'] = $detail->first_name .' '.$detail->last_name;
					
					$thumbnail = '';
					$u_thumbnail = '';
					$filename = FCPATH.'uploads/users/'.$detail->id.'/'.$detail->avatar;

					if($detail->avatar == '' || $detail->avatar == null || !file_exists($filename)){
						$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle" width="108" height="108"/>';
						$u_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" width="" height=""/>';
					}
					else{
						$thumbnail = '<img src="'.base_url().'uploads/users/'.$detail->id.'/'.$detail->avatar.'" class="img-circle" width="108" height="108"/>';
						$u_thumbnail = '<img src="'.base_url().'uploads/users/'.$detail->id.'/'.$detail->avatar.'" class="" width="" height=""/>';
					}	
					$data['avatar_name'] = $detail->avatar;
					$data['avatar'] = $thumbnail;
					
					$data['u_thumbnail'] = $u_thumbnail;
					
					$data['first_name'] = ucwords($detail->first_name);
					
					$data['last_name'] = ucwords($detail->last_name);
					$data['fullName'] = ucwords($detail->first_name .' '.$detail->last_name);
					
					$data['address'] = $detail->address;
					$data['city'] = $detail->city;
					$data['postcode'] = $detail->postcode;
					$data['state'] = $detail->state;
					
					$data['complete_address'] = $detail->address.', '.$detail->city.' '.$detail->postcode.', '.$detail->state.', '.$detail->country;
					//country list dropdown
					$country_options = '<select name="country" class="form-control" id="countries">';
					$country_options .= '<option value="0" selected="selected">Select Country</option>';
						
					$this->db->from('countries');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($detail->country == $row['name'])?'selected':'';
							
							$country_options .= '<option value="'.$row['name'].'" '.$default.'>'.$row['name'].'</option>';			
						}
					}
					$country_options .= '</select>';
					
					$data['country_options'] = $country_options;
					
					$data['country'] = $detail->country;
					$data['email'] = $detail->email_address;
					$data['mobile'] = $detail->mobile;
					$data['birthday'] = date("F j, Y", strtotime($detail->birthday));
					$data['profile_description'] = $detail->profile_description;
					
					$data['username'] = $detail->username;
					$data['password'] = $detail->password;
				
					$data['account_balance'] = $detail->account_balance;
					$data['security_question'] = $detail->security_question;
					$data['security_answer'] = $detail->security_answer;
					
					
					$status_string = 'Active';
					if($detail->status == '1'){
						$status_string = 'Suspended';
					}
					
					$data['status'] = $status_string;
					
					//status dropdown box
					$status = '<select name="status" class="form-control" id="status">';
					$this->db->from('status');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($detail->status == $row['status'])?'selected':'';
							$status .= '<option value="'.$row['status'].'" '.$default.'>'.$row['name'].'</option>';
						}
					}
					
					$status .= '</select>';
						
					$data['select_status'] = $status;
					
					$last_login = $detail->last_login;
					if($last_login == '0000-00-00 00:00:00' || $last_login == ''){ 
							$last_login = 'Never'; 
					}else{ 
						$last_login = date("d F y, h:i A", strtotime($last_login)); 
					}	
					$data['last_login'] = $last_login;
					
					$data['date_created'] = date("F j, Y", strtotime($detail->date_created));
					
					$data['model'] = 'users';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
							
	
		
		/**
		* Function to validate add user
		*
		*/			
		public function add_user(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
			
			$this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
			$this->form_validation->set_rules('tagline','Tagline','required|trim|xss_clean');
			
			$this->form_validation->set_rules('address','Address','required|trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('email','Email','required|trim|xss_clean');
			
			$this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean');
			
			$this->form_validation->set_rules('dob','Date of Birth','required|trim|xss_clean');
			$this->form_validation->set_rules('profile_description','Profile Description','required|trim|xss_clean');
			$this->form_validation->set_rules('username','Username','required|trim|xss_clean');
			$this->form_validation->set_rules('password','Password','required|trim|xss_clean');
			
			$this->form_validation->set_rules('account_balance','Account Balance','required|trim|xss_clean');
			
			if (empty($_FILES['user_photo']['name']))
			{
				$this->form_validation->set_rules('user_photo', 'User Image', 'required');
			}
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
				
			if($this->form_validation->run()){
				
				
				$first_name = $this->input->post('first_name');
				
				$last_name = $this->input->post('last_name');
				
				//generate a random string of numbers
				$random = substr(str_shuffle("0123456789"), 0, 4);
				
				$username = $first_name[0].''.$last_name[0].''.$random;
						
				//ensure the username is unique
				while(!$this->Users->unique_username($username)){
							
					$random = substr(str_shuffle("0123456789"), 0, 4);
				
					$username = $first_name[0].''.$last_name[0].''.$random;
				}
						
				$user_name = $title .' '.$first_name.' '.$middle_name.' '.$last_name;
				
				$user_data = array(
				
					'title' => $this->input->post('title'),
					'fname' => $this->input->post('first_name'),
					'mname' => $this->input->post('middle_name'),
					'lname' => $this->input->post('last_name'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'postcode' => $this->input->post('postcode'),
					'state' => $this->input->post('state'),
					'country' => $this->input->post('country'),
					'telephone' => $this->input->post('telephone'),
					'fax' => $this->input->post('fax'),
					'mobile' => $this->input->post('mobile'),
					'marital_status' => $this->input->post('marital_status'),
					'occupation' => $this->input->post('occupation'),
					'dob' => $this->input->post('dob'),
					'account_type' => $this->input->post('account_type'),
					'currency' => $this->input->post('currency'),
					'email' => $this->input->post('email'),
					'status' => '0',
					'username' => strtolower($username),
					'password' => '',
					'account_number' => $account_number,
					'account_pin' => $account_pin,
					'account_balance' => 0,
					'security_question' => '',
					'security_answer' => '',
					
					'stamp' => $stamp,
					'cot' => $cot,
					'aml' => $aml,
					'last_login' => '0000-00-00 00:00:00',
					'date_created' => date('Y-m-d H:i:s'),
					
				);
				
				
				
				
				$insert_id = $this->Users->insert_user($user_data);
							
				if($insert_id){
					
					if(isset($_FILES["user_photo"])){
									
						$file_name = '';
									
						$path = './uploads/users/'.$insert_id.'/';
						if(!is_dir($path)){
							mkdir($path,0777);
						}
						$config['upload_path'] = $path;
						$config['allowed_types'] = 'gif|jpg|jpeg|png';
						$config['max_size'] = 2048000;
						$config['max_width'] = 3048;
						$config['max_height'] = 2048;
										
						$config['file_name'] = $insert_id.'.jpg';
									
						$this->load->library('upload', $config);	

						$this->upload->overwrite = true;
								
						if($this->upload->do_upload('user_photo')){
								
							$upload_data = $this->upload->data();
											
							if (isset($upload_data['file_name'])){
								$file_name = $upload_data['file_name'];
							}	
									
						}else{
							$data['upload_error'] = $this->upload->display_errors();
						}
								
						$profile_data = array(
							'avatar' => $file_name,		
						);
						$this->Users->user_update($profile_data, $insert_id);	
						
										
					}	
					
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admins->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new user';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					//$this->session->set_flashdata('client_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> A new user (<i>'.$member_name.'</i>) has been added!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new user (<i>'.$user_name.'</i>) has been added!</div>';
							
				}else{
							
					//$this->session->set_flashdata('client_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-danger text-center"><i class="fa fa-check-circle"></i> The new user has not been added!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new user has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update user
		* form
		*/			
		public function update_user(){
			
			$photo_uploaded = false;
			
			$id = html_escape($this->input->post('userID'));
			
			$user_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
				
			
			if(!empty($_FILES['new_user_photo']['name'])){
					
				//$upload = false;
						
				$path = './uploads/users/'.$user_id.'/';
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
							
				$config['file_name'] = $user_id.'.jpg';
						
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$photo_uploaded = true;
											
			}
					
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('title','Title','required|trim|xss_clean');
			$this->form_validation->set_rules('first_name','First Name','required|trim|xss_clean');
			$this->form_validation->set_rules('middle_name','Middle Name','required|trim|xss_clean');
			$this->form_validation->set_rules('last_name','Last Name','required|trim|xss_clean');
			$this->form_validation->set_rules('address','Address','required|trim|xss_clean');
			$this->form_validation->set_rules('city','City','required|trim|xss_clean');
			$this->form_validation->set_rules('postcode','Postcode','required|trim|xss_clean');
			$this->form_validation->set_rules('state','State','required|trim|xss_clean');
			$this->form_validation->set_rules('country','Country','required|trim|xss_clean');
			$this->form_validation->set_rules('telephone','Telephone','required|trim|xss_clean');
			$this->form_validation->set_rules('fax','Fax','required|trim|xss_clean');
			$this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean');
			$this->form_validation->set_rules('marital_status','Marital Status','required|trim|xss_clean');
			$this->form_validation->set_rules('occupation','Occupation','required|trim|xss_clean');
			$this->form_validation->set_rules('dob','Date of Birth','required|trim|xss_clean');
			$this->form_validation->set_rules('account_type','Account Type','required|trim|xss_clean');
			$this->form_validation->set_rules('password','Password','trim|xss_clean');
			$this->form_validation->set_rules('email','Email','required|trim|xss_clean');
			$this->form_validation->set_rules('currency','Currency','required|trim|xss_clean');
			$this->form_validation->set_rules('status','Status','trim|xss_clean');
				
			if ($this->form_validation->run()){
				
				$title = $this->input->post('title');
				$first_name = $this->input->post('first_name');
				$middle_name = $this->input->post('middle_name');
				$last_name = $this->input->post('last_name');

				$user_name = $title .' '.$first_name.' '.$middle_name.' '.$last_name;	
				
				$avatar = $this->input->post('avatar');
				$password = '';
				
				$users = $this->Users->get_user_by_id($user_id);
				foreach($users as $user){
					$password = $user->password;
				}
				
				if($this->input->post('new_password') != '' || $this->input->post('new_password') != null){
					$password = md5($this->input->post('new_password'));
				}

				if($photo_uploaded){
						
					if($this->upload->do_upload('new_user_photo')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';
						}
						
					}
				}
				
				
				$account_balance =  $this->input->post('account_balance');
				$account_balance = floatval(preg_replace('/[^\d\.]/', '', $account_balance));
				

				$user_data = array(
					'avatar' => $avatar,
					'title' => $this->input->post('title'),
					'fname' => $this->input->post('first_name'),
					'mname' => $this->input->post('middle_name'),
					'lname' => $this->input->post('last_name'),
					'address' => $this->input->post('address'),
					'city' => $this->input->post('city'),
					'postcode' => $this->input->post('postcode'),
					'state' => $this->input->post('state'),
					'country' => $this->input->post('country'),
					'telephone' => $this->input->post('telephone'),
					'fax' => $this->input->post('fax'),
					'mobile' => $this->input->post('mobile'),
					'marital_status' => $this->input->post('marital_status'),
					'occupation' => $this->input->post('occupation'),
					'dob' => $this->input->post('dob'),
					
					'email' => $this->input->post('email'),
					'status' => $this->input->post('status'),
					'username' => $this->input->post('username'),
					'password' => $password,
					'account_type' => $this->input->post('account_type'),
					'account_number' => $this->input->post('account_number'),
					'account_pin' => $this->input->post('account_pin'),
					'currency' => $this->input->post('currency'),
					'account_balance' => $account_balance,
					'security_question' => $this->input->post('security_question'),
					'security_answer' => $this->input->post('security_answer'),
				);

				if ($this->Users->user_update($user_data, $user_id)){
					
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admins->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated user <i>'.$user_name.'</i>';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'User',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
								
					//$this->session->set_flashdata('client_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> User updated!</div>');
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);					
		}			

		
		/**
		* Function to handle
		* suspend user
		* display
		*/	
		public function suspend_user(){
			
			//escaping the post values
			$uid = html_escape($this->input->post('userID'));
			$id = preg_replace('#[^0-9]#i', '', $uid); // filter everything but numbers

			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){

					//$data['id'] = $detail->id;
					$update = array(
						'status' => '1',
					);
					
					if($this->Users->user_update($update, $id)){
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been suspended!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Method error</div>';
					}

			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No such user!</div>';
			}
			echo json_encode($data);
		}	
			
		
		/**
		* Function to
		* reactivate user
		* display
		*/	
		public function reactivate_user(){
			
			//escaping the post values
			$uid = html_escape($this->input->post('userID'));
			$id = preg_replace('#[^0-9]#i', '', $uid); // filter everything but numbers

			$detail = $this->db->select('*')->from('users')->where('id',$id)->get()->row();
			
			if($detail){

					//$data['id'] = $detail->id;
					$update = array(
						'status' => '0',
					);
					
					if($this->Users->user_update($update, $id)){
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> User has been reactivated!</div>';
					}else{
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Method error</div>';
					}

			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No such user!</div>';
			}
			echo json_encode($data);
		}
		
						
		
		/***
		* Function to handle logins
		*
		***/		
		public function logins(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages($username);
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$delete = $this->Logins->delete_old_records();
			
				//assign page title name
				$data['pageTitle'] = 'Logins';
								
				//assign page title name
				$data['pageID'] = 'logins';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/logins_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle Logins datatable
		*
		***/
		public function logins_datatable()
		{
			$delete = $this->Logins->delete_old_records();
			
			$list = $this->Logins->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $logins) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$logins->id.'">';
				
				$row[] = $logins->ip_address;
				
				$row[] = $logins->username;
				
				$row[] = $logins->password;
				
				$row[] = date("F j, Y", strtotime($logins->login_time));
			
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Logins->count_all(),
				"recordsFiltered" => $this->Logins->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}			
											

		
		/***
		* Function to handle failed logins datatable
		*
		***/
		public function failed_logins_datatable()
		{
			$delete = $this->Failed_logins->delete_old_records();
			
			$list = $this->Failed_logins->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $logins) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$logins->id.'">';
				
				$row[] = $logins->ip_address;
				
				$row[] = $logins->username;
				
				$row[] = $logins->password;
				
				$row[] = date("F j, Y", strtotime($logins->attempt_time));
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Failed_logins->count_all(),
				"recordsFiltered" => $this->Failed_logins->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

		
		/***
		* Function to handle failed resets datatable
		*
		***/
		public function failed_resets_datatable()
		{
			$delete = $this->Failed_resets->delete_old_records();
			
			$list = $this->Failed_resets->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $reset) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$reset->id.'">';
				
				$row[] = $reset->ip_address;
				
				$row[] = $reset->email_address;
				
				$row[] = $reset->security_answer;
				
				$row[] = date("F j, Y", strtotime($reset->attempt_time));
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Failed_resets->count_all(),
				"recordsFiltered" => $this->Failed_resets->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
				


		/**
		* Function to handle jquery display and edit
		* quiz questions 
		* 
		*/	
		public function category_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('question_categories')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->category;			

					$data['category'] = $detail->category;
					
					$category = '<select name="category" class="form-control">';
					
					$this->db->from('question_categories');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['category'] == $detail->category)?'selected':'';
							$category .= '<option value="'.$row['category'].'" '.$default.'>'.$row['category'].'</option>';			
						}
					}

					$category .= '</select>';
					
					$data['category'] = $category;
					
					$data['model'] = 'question_categories';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		/***
		* Function to handle questions
		* table
		***/		
		public function question_categories(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			
					
					$username = $this->session->userdata('admin_username');	
					
					$data['users'] = $this->Admin->get_user($username);
					
					$data['header_messages_array'] = $this->Admin->get_admin_header_messages();	

					$data['messages_unread'] = $this->Messages->count_unread_messages($username);
					
					$data['categories_array'] = $this->Question_categories->get_categories();	
					
					$data['count'] = $this->Question_categories->count_categories();
						
					//assign page title name
					$data['pageTitle'] = 'Question Categories';
							
					//assign page title name
					$data['pageID'] = 'question_categories';
									
					//load header and page title
					$this->load->view('admin_pages/header', $data);
						
					//load main body
					$this->load->view('admin_pages/question_categories_page', $data);	
				
					//load footer
					$this->load->view('admin_pages/footer');
									
			}
		}

		
		/**
		* Function to validate add category
		*
		*/			
		public function add_category(){

			if($this->session->userdata('admin_logged_in')){ 

				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('category','Category','required|trim|xss_clean|is_unique[question_categories.category]');
				
				$this->form_validation->set_message('required', '%s cannot be blank!');
				$this->form_validation->set_message('is_unique', 'Category already exists! Please enter a new category!');
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
				if($this->form_validation->run()){
		
						$add = array(
							'category' => $this->input->post('category'),
						);
						//$table = 'question_categories';	
						
						$insert_id = $this->Question_categories->insert_category($add);
						
						if($insert_id){
						
							$detail = $this->db->select('*')->from('question_categories')->where('id', $insert_id)->get()->row();	
							$data['id'] = $detail->id;
							
							$data['category'] = $detail->category;
							
							$this->session->set_flashdata('category_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new category has been added!</div>');
							$data['success'] = true;
							$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new category has been added!</div>';
						
						}else{
							$this->session->set_flashdata('category_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new category has not been added!</div>');
							$data['success'] = false;
							$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new category has not been added!</div>';
						
						}				
				}
				else {
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
					//$data['errors'] = $this->form_validation->error_array();
					//$this->addhand();	
				}

				// Encode the data into JSON
				$this->output->set_content_type('application/json');
				$data = json_encode($data);

				// Send the data back to the client
				$this->output->set_output($data);
				//echo json_encode($data);	
			}else{
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);
			}
		}

		
		/**
		* Function to validate update security 
		* question
		*/			
		public function update_category(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('category','Category','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('categoryID');
						
				$edit_data = array(
					'category' => $this->input->post('category'),
				);
				
				if ($this->Question_categories->update_category($edit_data, $id)){	
				
					$this->session->set_flashdata('category_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Category updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Category has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		
		

						
		/***
		* Function to handle questions
		* page
		***/		
		public function questions(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			
					
					$username = $this->session->userdata('admin_username');	
					
					$data['users'] = $this->Admin->get_user($username);
					
					$data['header_messages_array'] = $this->Admin->get_admin_header_messages();	

					$data['messages_unread'] = $this->Messages->count_unread_messages($username);
					
					//assign page title name
					$data['pageTitle'] = 'Quiz Questions';
							
					//assign page title name
					$data['pageID'] = 'questions';
									
					//load header and page title
					$this->load->view('admin_pages/header', $data);
						
					//load main body
					$this->load->view('admin_pages/questions_page', $data);	
				
					//load footer
					$this->load->view('admin_pages/footer');
									
			}
		}
		
		/**
		* Function to handle jquery display and edit
		* quiz questions 
		* 
		*/	
		public function question_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			
			$detail = $this->db->select('*')->from('questions')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->question;			

					$data['question'] = $detail->question;
					
					$category = '<select name="category" class="form-control">';
					
					$this->db->from('question_categories');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['category'] == $detail->category)?'selected':'';
							$category .= '<option value="'.$row['category'].'" '.$default.'>'.$row['category'].'</option>';			
						}
					}
					
					$category .= '</select>';
					
					$data['category'] = $category;
					$data['option_1'] = $detail->option_1;
					$data['option_1_image'] = $detail->option_1_image;
					$data['option_2'] = $detail->option_2;
					$data['option_2_image'] = $detail->option_2_image;
					
					$data['model'] = 'questions';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}


		
		/***
		* Function to handle questions ajax
		* datatable
		***/
		public function questions_datatable()
		{
			$list = $this->Questions->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $question) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$question->id.'">';
				
				$row[] = $question->question;
				$row[] = $question->category;
				$row[] = $question->option_1;
				$row[] = '<img class="img-responsive" src="'.base_url().'uploads/questions/'.$question->id.'/'.$question->option_1_image.'" width="30" height="30">';
				$row[] = $question->option_2;
				$row[] = '<img class="img-responsive" src="'.base_url().'uploads/questions/'.$question->id.'/'.$question->option_2_image.'" width="30" height="30">';
				
				//prepare buttons
				$model = 'questions';
				
				$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-xs" id="'.$question->id.'" title="Click to Edit" onclick="editQuestion('.$question->id.')"><i class="fa fa-pencil"></i> Edit</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Questions->count_all(),
				"recordsFiltered" => $this->Questions->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		


		private function set_upload_questions_options(){   
			//upload a question image options
			$config = array();
			$path = './uploads/questions/'.$insert_id.'/';
			if(!is_dir($path)){
				mkdir($path,0777);
			}
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = 2048000;
			$config['max_width'] = 3048;
			$config['max_height'] = 2048;
			$config['overwrite']     = FALSE;

			return $config;
		}
		
		/**
		* Function to validate add question
		*
		*/			
		public function add_question(){

			$this->load->library('form_validation');
				
			$this->form_validation->set_rules('question','Question','required|trim|xss_clean|is_unique[questions.question]');
			$this->form_validation->set_rules('category','Category','required|trim|xss_clean');
				
			$this->form_validation->set_rules('option_1','Option 1','required|trim|xss_clean');
			if (empty($_FILES['image_1']['name']))
			{
				$this->form_validation->set_rules('image_1', 'Option 1 Image', 'required');
			}
			$this->form_validation->set_rules('option_2','Option 2','required|trim|xss_clean');
			if (empty($_FILES['image_2']['name']))
			{
				$this->form_validation->set_rules('image_2', 'Option 2 Image', 'required');
			}
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Question already exists! Please enter a new question!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'question' => $this->input->post('question'),
					'category' => $this->input->post('category'),
					'option_1' => ucfirst($this->input->post('option_1')),
					'option_2' => ucfirst($this->input->post('option_2')),
				);
						
						//$table = 'questions';	
						
				$insert_id = $this->Questions->insert_question($add);
						
				if($insert_id){
							
					$file1 = '';
					$file2 = '';
								
					if(isset($_FILES["image_1"]) && isset($_FILES["image_2"])){
								
						$path = './uploads/questions/'.$insert_id.'/';
						if(!is_dir($path))
						{
							mkdir($path,0777);
						}
								
						$i = 1;
						$files = array();
								
						foreach ($_FILES as $key => $value) {
									
							if (!empty($value['name'])) {
										
								$config['upload_path'] = $path;
								$config['allowed_types'] = 'gif|jpg|jpeg|png';
								$config['max_size'] = 2048000;
										
								$config['max_width'] = 3048;
								$config['max_height'] = 2048;
								$this->load->library('upload', $config);
								if($i == 1){
									//$file1 = $insert_id.'_1.jpg';
									$config['file_name'] = $insert_id.'_1.jpg';
								}
								if($i == 2){
									//$file2 = $insert_id.'_2.jpg';
									$config['file_name'] = $insert_id.'_2.jpg';
								}
								$this->upload->initialize($config);
										
								if (!$this->upload->do_upload($key)) {
									$data['upload_msg'] = $this->upload->display_errors('', '');
								}else{
									//$files[$i] = $this->upload->data();
									$upload_data = $this->upload->data();
									if (isset($upload_data['file_name'])){
										$files[$i] = $upload_data['file_name'];
									}	
									$i++;
								}
							}
						}
						$file1 = $files[1];
						$file2 = $files[2];
								
						$image_data = array(
							'option_1_image' => $file1,	
							'option_2_image' => $file2,
						);
							
						$this->Questions->update_question($image_data, $insert_id);
								
					}
					
					$this->session->set_flashdata('question_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new question has been added!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new question has been added!</div>';
						
				}else{
					
					$this->session->set_flashdata('question_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new question has not been added!</div>');
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new question has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
					//$data['errors'] = $this->form_validation->error_array();
					//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update quiz 
		* question
		*/			
		public function update_question(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$id = html_escape($this->input->post('questionID'));
			
			$question_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			
			$file1 = html_escape($this->input->post('old_image_1'));
			$file2 = html_escape($this->input->post('old_image_2'));
			
			$file_uploaded1 = false;
			$file_uploaded2 = false;
			
			if(!empty($_FILES["edit_option_1_image"]['name'])){

				$path = './uploads/questions/'.$question_id.'/';
				if(!is_dir($path)){
						mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
				$config['file_name'] = $question_id.'_1.jpg';		
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
					
				if($this->upload->do_upload('edit_option_1_image')){
						
					$upload_data = $this->upload->data();
						
					if (isset($upload_data['file_name'])){
						$file1 = $upload_data['file_name'];
					}
								
				}else{
					if($this->upload->display_errors()){
					//	$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors with the photo!<br/>'.$this->upload->display_errors().'</div>';
					}
				}			
			}
			
			if(!empty($_FILES["edit_option_2_image"]['name'])){

				$path = './uploads/questions/'.$question_id.'/';
				if(!is_dir($path)){
						mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
				$config['file_name'] = $question_id.'_2.jpg';		
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$this->upload->initialize($config);
					
				if($this->upload->do_upload('edit_option_2_image')){
						
					$upload_data = $this->upload->data();
						
					if (isset($upload_data['file_name'])){
						$file2 = $upload_data['file_name'];
					}		
				}else{
					if($this->upload->display_errors()){
					//	$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors with the photo!<br/>'.$this->upload->display_errors().'</div>';
					}
				}				
			}	
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('full_question','Question','required|trim|xss_clean');
			$this->form_validation->set_rules('category','Category','required|trim|xss_clean');
			
			$this->form_validation->set_rules('edit_option_1','Option 1','required|trim|xss_clean');
			$this->form_validation->set_rules('edit_option_2','Option 2','required|trim|xss_clean');
				
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
							
				$edit_data = array(
					'question' => $this->input->post('full_question'),
					'category' => $this->input->post('category'),
					'option_1' => ucfirst($this->input->post('edit_option_1')),
					'option_1_image' => $file1,
					'option_2' => ucfirst($this->input->post('edit_option_2')),
					'option_2_image' => $file2,
					
				);
				
				if ($this->Questions->update_question($edit_data, $question_id)){	
				
					$this->session->set_flashdata('question_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Question updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Question has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		
		
		/***
		* Function to handle questions
		*
		***/		
		public function answers(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			
					
					$username = $this->session->userdata('admin_username');	
					
					$data['users'] = $this->Admin->get_user($username);
					
					$data['header_messages_array'] = $this->Admin->get_admin_header_messages();	

					$data['messages_unread'] = $this->Messages->count_unread_messages($username);
					
					$config = array();
					$config["base_url"] = base_url()."admin/answers";
					
					$table = 'answers';
					$config["total_rows"] = $this->Admin->count_all($table);
					$config["per_page"] = 10;
					$config["uri_segment"] = 3;
					$choice = $config["total_rows"] / $config["per_page"];
					$config["num_links"] = round($choice);
				
					$this->pagination->initialize($config);
					
					if($this->uri->segment(3) > 0)
						$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
					else
						$offset = $this->uri->segment(3);					
					
					$data['quiz_answers_array'] = $this->Admin->get_all($table, $config["per_page"], $offset);	
					
					$data['pagination'] = $this->pagination->create_links();	

					$data['count'] = $this->Admin->count_all($table);	

					//$data['questions_array'] = $this->Admin->get_security_questions();	

					//$data['count'] = $this->Admin->count_questions();
					
					//assign page title name
					$data['pageTitle'] = 'Quiz Answers';
							
					//assign page title name
					$data['pageID'] = 'quiz_answers';
									
					//load header and page title
					$this->load->view('admin_pages/header', $data);
						
					//load main body
					$this->load->view('admin_pages/quiz_answers_page', $data);	
				
					//load footer
					$this->load->view('admin_pages/footer');
									
			}
		}

				
		/***
		* Function to handle contact us
		*
		***/		
		public function contact_us(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$delete = $this->Contact_us->delete_old_records();
					
				//assign page title name
				$data['pageTitle'] = 'Contact Us';
								
				//assign page title name
				$data['pageID'] = 'contact_us';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/contact_us_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle contact us datatable
		*
		***/
		public function contact_us_datatable()
		{
			
			$delete = $this->Contact_us->delete_old_records();
			
			$list = $this->Contact_us->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $contact_us) {
				$no++;
				$row = array();
				
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$contact_us->id.'">';
				
				$textWeight = '';
				$opened = $contact_us->opened;
				
				//check if message has been read
				if($opened == '0'){ 
					$textWeight = 'msgDefault';
					$opened = '<strong>Not Read</strong>'; 
					
				}else{ 
					$textWeight = 'msgRead';
					$opened = 'Read'; 
				}
				
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_name.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_company.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_telephone.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.$contact_us->contact_email.'</span>';
				$row[] = '<span class="'.$textWeight.'">'.date("F j, Y", strtotime($contact_us->contact_us_date)).'</span>';
				
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#viewModal" class="btn btn-info btn-xs" id="'.$contact_us->id.'" title="Click to View" onclick="viewContactMessage('.$contact_us->id.')"><i class="fa fa-search"></i> View</a>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Contact_us->count_all(),
				"recordsFiltered" => $this->Contact_us->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	
		/**
		* Function to handle
		* contact us view and edit
		* display
		*/	
		public function contact_us_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('contact_us')->where('id',$id)->get()->row();
			
			if($detail){
					
					$this->mark_as_read($id,'contact_us');
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Contact Us Message';			

					$data['contact_name'] = $detail->contact_name;
					$data['contact_telephone'] = $detail->contact_telephone;
					$data['contact_email'] = $detail->contact_email;
					$data['contact_company'] = $detail->contact_company;
					$data['contact_message'] = stripslashes(wordwrap(nl2br($detail->contact_message), 54, "\n", true));
					
					$data['ip_address'] = $detail->ip_address;
					
					$opened = $detail->opened;
					if($opened == '0'){
						$opened = 'Not Read';
					}else{
						$opened = 'Read';
					}
					$data['opened'] = $opened;
					
					$data['contact_us_date'] = date("F j, Y", strtotime($detail->contact_us_date));
					
					$data['model'] = 'contact_us';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}	
	
		/**
		* Function to mark messages
		* as read 
		*/	
		public function mark_as_read($id,$table){
				
			$data = array(
				'opened' => '1',
			);
			$this->db->where('id', $id);
			$query = $this->db->update($table, $data);
				
		}
	

		/***
		* Function for admin profile
		*
		***/		
		public function profile(){

			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
				
				$user_avatar = '';
				$user_id = '';
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
						$user_avatar = $user->avatar;
						$user_id = $user->id;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$thumbnail = '';
				$mini_thumbnail = '';
				$filename = FCPATH.'uploads/admins/'.$user_id.'/'.$user_avatar;

				//check if record in db is url thus facebook or google
				if(filter_var($user_avatar, FILTER_VALIDATE_URL)){
					//diplay facebook avatar
					$thumbnail = '<img src="'.$user_avatar.'" class="social_profile img-responsive img-circle avatar-view" width="170" height="170" />';
					
					$mini_thumbnail = '<img src="'.$user_avatar.'" class="" width="" height="" />';
				}
				elseif($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="170" height="170" />';
					
					$mini_thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" width="" height="" />';
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/admins/'.$user_id.'/'.$user_avatar.'" class="img-responsive img-circle avatar-view" width="170" height="170" />';
					
					$mini_thumbnail = '<img src="'.base_url().'uploads/admins/'.$user_id.'/'.$user_avatar.'" class="" width="" height="" />';
				}	
				
				$data['thumbnail'] = $thumbnail;
				$data['mini_thumbnail'] = $mini_thumbnail;
				
				//assign page title name
				$data['pageTitle'] = 'Profile';
				
				//assign page ID
				$data['pageID'] = 'profile';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/profile_page');
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}	
		}	
			
			

		/**
		* Function to validate update profile
		* form
		*/			
		public function profile_update(){
			
			$username = $this->session->userdata('admin_username');
			
			$user_array = $this->Admin->get_user($username);
				
			$user_id = '';
			$avatar = '';
			$fullname =  '';
			if($user_array){
				foreach($user_array as $user){
					$fullname = $user->admin_name;
					$user_id = $user->id;
					$avatar = $user->avatar;
				}
			}
			$photo_uploaded = false;		
			
			if(!empty($_FILES['update_photo']['name'])){
					
				//$upload = false;
						
				$path = './uploads/admins/'.$user_id.'/';
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
							
				$config['file_name'] = $user_id.'.jpg';
						
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$photo_uploaded = true;
											
			}
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if ($this->form_validation->run()){	

				if($photo_uploaded){
						
					if($this->upload->do_upload('update_photo')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';
						}
						
					}
				}
				
				$data = array(
					'avatar' => $avatar,
				);

				if ($this->Admin->update_user($data, $username)){	

					//update activities table
					$description = 'updated profile';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);$(".updated-message").animate({scrollTop: 0}, 300);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your profile has been updated!</div>');
							
					//update complete redirects to success page
					redirect('admin/profile/');	
				}
				
			}else {
				//$url = 'edit/hand_users/'.$hand_id;
				//Go back to the Edit Details Page if validation fails
				$this->profile();
			}
		
		}

		
		/**
		* Function to upload profile photo
		*
		*/			
		public function photo_upload(){
			
			if($this->session->userdata('admin_logged_in')){
				$username = $this->session->userdata('admin_username');
				
				$user_array = $this->Admin->get_user($username);
					
				$user_id = '';
				$avatar = '';
				$fullname =  '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->admin_name;
						$user_id = $user->id;
						$avatar = $user->avatar;
					}
				}
				$photo_uploaded = false;		
				
				if(!empty($_FILES['update_photo']['name'])){
						
					//$upload = false;
							
					$path = './uploads/admins/'.$user_id.'/';
					if(!is_dir($path)){
						mkdir($path,0777);
					}
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['max_size'] = 2048000;
					$config['max_width'] = 3048;
					$config['max_height'] = 2048;
								
					$config['file_name'] = $user_id.'.jpg';
							
					$this->load->library('upload', $config);	

					$this->upload->overwrite = true;
					
					$photo_uploaded = true;
												
				}
							
				if($photo_uploaded){
						
					if($this->upload->do_upload('update_photo')){
								
						$upload_data = $this->upload->data();
								
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						
						$avatar = $file_name;
						
					}else{
						
						if($this->upload->display_errors()){
							//$data['upload_error'] = '<div class="text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$this->upload->display_errors().'</div>';
							
							$this->session->set_flashdata('errors', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
						}
						
					}
				}
				
				$data = array(
					'avatar' => $avatar,
				);

				
				if ($this->Admin->update_user($data, $username)){	

					//update activities table
					$description = 'updated profile';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);$(".updated-message").animate({scrollTop: 0}, 300);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your profile has been updated!</div>');
							
					//update complete redirects to success page
					redirect('admin/profile/');	
					
				}else {
					
					$this->profile();
				}
			}
			else {
					$url = 'admin/login?redirectURL='.urlencode(current_url());
					redirect($url);
					
					//redirect('home/login/?redirectURL=settings');
			} 		
		}
		
		/***
		* Function for admin settings
		*
		***/		
		public function settings(){

			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);

				//assign page title name
				$data['pageTitle'] = 'Settings';
				
				//assign page ID
				$data['pageID'] = 'settings';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/settings_page');
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}	
		}	

			

		/**
		* Function to validate update password settings
		* form
		*/			
		public function password_update(){
			
			$username = $this->session->userdata('admin_username');
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('new_password','New Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|matches[new_password]|trim|xss_clean');
			
			$this->form_validation->set_message('required', 'Please enter a %s!');
			$this->form_validation->set_message('matches', 'Passwords do not match!');
			
			if ($this->form_validation->run()){	

				$data = array(
					'admin_password' => md5($this->input->post('new_password')),
				);

				if ($this->Admin->update_user($data, $username)){	

					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated password';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('admin_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your password has been updated!</div>');
							
					//update complete redirects to success page
					redirect('admin/settings/');	
				}
				
			}else {
				//$url = 'edit/hand_users/'.$hand_id;
				//Go back to the Edit Details Page if validation fails
				$this->settings();
			}
		
		}		
							

		/**
		* Function to validate update admin settings
		* form
		*/			
		public function settings_update(){
			
			$admin_username = $this->session->userdata('username');
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('new_password','New Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|matches[new_password]|trim|xss_clean');
			
			if ($this->form_validation->run()){	

				$data = array(
					'admin_password' => md5($this->input->post('new_password')),
				);

				if ($this->Admin->update_admin($data)){	
				
					$this->session->set_flashdata('admin_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Your password has been updated!</div>');
							
					//update complete redirects to success page
					redirect('admin/profile/');	
				}
				
			}else {
				//$url = 'edit/hand_users/'.$hand_id;
				//Go back to the Edit Details Page if validation fails
				$this->settings();
			}
		
		}



		/**
		* Function to handle jquery display and edit
		* security questions 
		* 
		*/	
		public function security_question_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('security_questions')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->question;			

					$data['question'] = $detail->question;
					
					$data['model'] = 'questions';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
				
		/***
		* Function to handle security questions
		*
		***/		
		public function security_questions(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			
					
					$admin_username = $this->session->userdata('admin_username');	
					
					$data['users'] = $this->Admin->get_user($admin_username);
					
					$data['header_messages_array'] = $this->Admin->get_admin_header_messages();	

					$data['messages_unread'] = $this->Messages->count_unread_messages($admin_username);
				

					$config = array();
					$config["base_url"] = base_url()."admin/security_questions";
					
					$table = 'security_questions';
					$config["total_rows"] = $this->Admin->count_all($table);
					$config["per_page"] = 10;
					$config["uri_segment"] = 3;
					$choice = $config["total_rows"] / $config["per_page"];
					$config["num_links"] = round($choice);
				
					$this->pagination->initialize($config);
					
					if($this->uri->segment(3) > 0)
						$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
					else
						$offset = $this->uri->segment(3);					
					
					$data['questions_array'] = $this->Admin->get_all($table, $config["per_page"], $offset);	
					
					$data['pagination'] = $this->pagination->create_links();	

					$data['count'] = $this->Admin->count_all($table);	

					//$data['questions_array'] = $this->Admin->get_security_questions();	

					//$data['count'] = $this->Admin->count_questions();
					
					//assign page title name
					$data['pageTitle'] = 'Security Questions';
							
					//assign page title name
					$data['pageID'] = 'security_questions';
									
					//load header and page title
					$this->load->view('admin_pages/header', $data);
						
					//load main body
					$this->load->view('admin_pages/security_questions_page', $data);	
				
					//load footer
					$this->load->view('admin_pages/footer');
									
			}
		}		

		
		/**
		* Function to validate add security_question
		*
		*/			
		public function add_security_question(){

			if($this->session->userdata('admin_logged_in')){ 

				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('security_question','Security Question','required|trim|xss_clean|is_unique[security_questions.question]');
				
				$this->form_validation->set_message('required', '%s cannot be blank!');
				$this->form_validation->set_message('is_unique', 'Security Question already exists! Please enter a new question!');
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
				if($this->form_validation->run()){
		
						$data = array(
							'question' => $this->input->post('security_question'),
						);
						$table = 'security_questions';	
						
						$insert_id = $this->Admin->add_to_db($table, $data);
						
						if($insert_id){
						
							$detail = $this->db->select('*')->from('security_questions')->where('id', $insert_id)->get()->row();	
							$data['id'] = $detail->id;
							
							$data['question'] = $detail->question;
							
							$this->session->set_flashdata('question_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new question has been added!</div>');$data['success'] = true;
							$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new question has been added!</div>';
						
						}else{
							$this->session->set_flashdata('question_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new question has not been added!</div>');
							$data['success'] = false;
							$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new question has not been added!</div>';
						
						}				
				}
				else {
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
					//$data['errors'] = $this->form_validation->error_array();
					//$this->addhand();	
				}

				// Encode the data into JSON
				$this->output->set_content_type('application/json');
				$data = json_encode($data);

				// Send the data back to the client
				$this->output->set_output($data);
				//echo json_encode($data);	
			}else{
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);
			}
		}

		
		/**
		* Function to validate update security 
		* question
		*/			
		public function update_security_question(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('security_question','Security Question','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('squestionID');
						
				$edit_data = array(
					'question' => $this->input->post('security_question'),
				);
				
				if ($this->Security_questions->update_question($edit_data, $id)){	
				
					$this->session->set_flashdata('question_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Question updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Question has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		

		/**
		* Function to handle jquery display and edit
		* product category 
		* 
		*/	
		public function male_category_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('male_categories')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->category_name;			

					$data['category_name'] = $detail->category_name;
					
					$category = '<select name="product_category" id="male_category" class="form-control">';
					
					$this->db->from('male_categories');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['category_name'] == $detail->category_name)?'selected':'';
							$category .= '<option value="'.$row['category_name'].'" '.$default.'>'.$row['category_name'].'</option>';			
						}
					}
					
					$category .= '</select>';
					
					$data['category'] = $category;
					
					$data['model'] = 'male_categories';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle male categories_datatable
		*
		***/
		public function male_categories_datatable()
		{
			$list = $this->Male_categories->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $category) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$category->id.'">';
				
				$row[] = $category->id;
				$row[] = ucwords($category->category_name);
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'male';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editCategoryModal" class="btn btn-primary btn-xs" id="'.$category->id.'" title="Edit '.ucwords($category->category_name).'" onclick="editCategory('.$category->id.',\''.$model.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Male_categories->count_all(),
				"recordsFiltered" => $this->Male_categories->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

		/**
		* Function to handle jquery display and edit
		* product category 
		* 
		*/	
		public function female_category_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('female_categories')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->category_name;			

					$data['category_name'] = $detail->category_name;
					
					$category = '<select name="product_category" id="female_category" class="form-control">';
					
					$this->db->from('female_categories');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['category_name'] == $detail->category_name)?'selected':'';
							$category .= '<option value="'.$row['category_name'].'" '.$default.'>'.$row['category_name'].'</option>';			
						}
					}
					
					$category .= '</select>';
					
					$data['category'] = $category;
					
					$data['model'] = 'female_categories';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle female categories_datatable
		*
		***/
		public function female_categories_datatable()
		{
			$list = $this->Female_categories->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $category) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$category->id.'">';
				
				$row[] = $category->id;
				$row[] = ucwords($category->category_name);
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'female';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editCategoryModal" class="btn btn-primary btn-xs" id="'.$category->id.'" title="Edit '.ucwords($category->category_name).'" onclick="editCategory('.$category->id.',\''.$model.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Female_categories->count_all(),
				"recordsFiltered" => $this->Female_categories->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		
		
		/***
		* Function to handle product categories
		*
		***/		
		public function product_categories(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
					
				//assign page title name
				$data['pageTitle'] = 'Products Categories';
						
				//assign page title name
				$data['pageID'] = 'product_categories';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/product_categories_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
								
		/**
		* Function to validate add category
		*
		*/			
		public function add_product_category(){

			$this->load->library('form_validation');
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$model = html_escape($this->input->post('category_model'));
			
			if($model == 'female'){
				$this->form_validation->set_rules('category_name','Category Name','required|trim|xss_clean|is_unique[female_categories.category_name]');
			}
			if($model == 'male'){
				$this->form_validation->set_rules('category_name','Category Name','required|trim|xss_clean|is_unique[male_categories.category_name]');
			}				
						
			
			$this->form_validation->set_rules('category_model','Category Model','required|trim|xss_clean');
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Category already exists! Please enter a new category!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'category_name' => $this->input->post('category_name'),
				);
				
				$model = $this->input->post('category_model');
				
				$inserted = false;
				
				if($model == 'female'){
					$inserted = $this->Female_categories->insert_category($add);
				}
				if($model == 'male'){
					$inserted = $this->Male_categories->insert_category($add);
				}				
					
				if($inserted){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new product category - <i>'.ucwords($this->input->post('category_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Product',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
											
					$this->session->set_flashdata('category_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('category_name')).' has been added!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('category_name')).' has been added!</div>';
						
				}else{
					
					$this->session->set_flashdata('category_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('category_name')).' has not been added!</div>');
							
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('category_name')).' has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update product 
		* category
		*/			
		public function update_product_category(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('category_name','Category Name','required|trim|xss_clean');
			$this->form_validation->set_rules('category_model','Category Model','required|trim|xss_clean');
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('categoryID');
						
				$edit = array(
					'category_name' => $this->input->post('category_name'),
				);
				
				$model = $this->input->post('category_model');
				
				$updated = false;
				
				if($model == 'female_categories'){
					$updated = $this->Female_categories->update_category($edit, $id);
				}
				else{
					$updated = $this->Male_categories->update_category($edit, $id);
				}				
					
				if ($updated){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a product category - <i>'.ucwords($this->input->post('category_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Product',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
								
					$this->session->set_flashdata('category_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Category updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Category has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		

		

		/**
		* Function to handle jquery display and edit
		* male size 
		* 
		*/	
		public function male_size_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('male_sizes')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Size';			

					$data['size_EU'] = $detail->size_EU;
					$data['size_UK'] = $detail->size_UK;
					$data['size_US'] = $detail->size_US;
					
					$data['model'] = 'male_sizes';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle male sizes datatable
		*
		***/
		public function male_sizes_datatable()
		{
			$list = $this->Male_sizes->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $size) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$size->id.'">';
				
				$row[] = $size->id;
				$row[] = $size->size_EU;
				$row[] = $size->size_UK;
				$row[] = $size->size_US;
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'male_sizes';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editSizeModal" class="btn btn-primary btn-xs" id="'.$size->id.'" title="Edit Size" onclick="editSize('.$size->id.',\''.$model.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Male_sizes->count_all(),
				"recordsFiltered" => $this->Male_sizes->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}


		/**
		* Function to handle jquery display and edit
		* male shoe size 
		* 
		*/	
		public function male_shoe_size_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('male_shoe_sizes')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Size';			

					$data['size_EU'] = $detail->size_EU;
					$data['size_UK'] = $detail->size_UK;
					$data['size_US'] = $detail->size_US;
					
					$data['model'] = 'male_shoe_sizes';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle male shoe sizes datatable
		*
		***/
		public function male_shoe_sizes_datatable()
		{
			$list = $this->Male_shoe_sizes->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $size) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$size->id.'">';
				
				$row[] = $size->id;
				$row[] = $size->size_EU;
				$row[] = $size->size_UK;
				$row[] = $size->size_US;
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'male_shoe_sizes';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editSizeModal" class="btn btn-primary btn-xs" id="'.$size->id.'" title="Edit Size" onclick="editSize('.$size->id.',\''.$model.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Male_shoe_sizes->count_all(),
				"recordsFiltered" => $this->Male_shoe_sizes->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

		
	
		/**
		* Function to handle jquery display and edit
		* female size 
		* 
		*/	
		public function female_size_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('female_sizes')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Size';			

					$data['size_EU'] = $detail->size_EU;
					$data['size_UK'] = $detail->size_UK;
					$data['size_US'] = $detail->size_US;
					
					$data['model'] = 'female_sizes';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle female sizes datatable
		*
		***/
		public function female_sizes_datatable()
		{
			$list = $this->Female_sizes->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $size) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$size->id.'">';
				
				$row[] = $size->id;
				$row[] = $size->size_EU;
				$row[] = $size->size_UK;
				$row[] = $size->size_US;
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'male_sizes';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editSizeModal" class="btn btn-primary btn-xs" id="'.$size->id.'" title="Edit Size" onclick="editSize('.$size->id.',\''.$model.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Female_sizes->count_all(),
				"recordsFiltered" => $this->Female_sizes->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
	
	
		/**
		* Function to handle jquery display and edit
		* female size 
		* 
		*/	
		public function female_shoe_size_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('female_shoe_sizes')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Size';			

					$data['size_EU'] = $detail->size_EU;
					$data['size_UK'] = $detail->size_UK;
					$data['size_US'] = $detail->size_US;
					
					$data['model'] = 'female_shoe_sizes';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle female shoe sizes datatable
		*
		***/
		public function female_shoe_sizes_datatable()
		{
			$list = $this->Female_shoe_sizes->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $size) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$size->id.'">';
				
				$row[] = $size->id;
				$row[] = $size->size_EU;
				$row[] = $size->size_UK;
				$row[] = $size->size_US;
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'female_shoe_sizes';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editSizeModal" class="btn btn-primary btn-xs" id="'.$size->id.'" title="Edit Size" onclick="editSize('.$size->id.',\''.$model.'\')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Female_shoe_sizes->count_all(),
				"recordsFiltered" => $this->Female_shoe_sizes->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
				
		
		/***
		* Function to handle sizes
		*
		***/		
		public function sizes(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
					
				//assign page title name
				$data['pageTitle'] = 'Sizes';
						
				//assign page title name
				$data['pageID'] = 'sizes';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/sizes_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
								
		/**
		* Function to validate add category
		*
		*/			
		public function add_size(){

			$this->load->library('form_validation');
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$model = html_escape($this->input->post('size_model'));
				
			if($model == 'male_sizes'){
				$this->form_validation->set_rules('size_EU','Size EU','required|trim|xss_clean|is_unique[male_sizes.size_EU]');
				$this->form_validation->set_rules('size_UK','Size UK','required|trim|xss_clean|is_unique[male_sizes.size_UK]');
				$this->form_validation->set_rules('size_US','Size US','required|trim|xss_clean|is_unique[male_sizes.size_US]');
			}
			else if($model == 'female_sizes'){
				$this->form_validation->set_rules('size_EU','Size EU','required|trim|xss_clean|is_unique[female_sizes.size_EU]');
				$this->form_validation->set_rules('size_UK','Size UK','required|trim|xss_clean|is_unique[female_sizes.size_UK]');
				$this->form_validation->set_rules('size_US','Size US','required|trim|xss_clean|is_unique[female_sizes.size_US]');
			}
			else if($model == 'male_shoe_sizes'){
				$this->form_validation->set_rules('size_EU','Size EU','required|trim|xss_clean|is_unique[male_shoe_sizes.size_EU]');
				$this->form_validation->set_rules('size_UK','Size UK','required|trim|xss_clean|is_unique[male_shoe_sizes.size_UK]');
				$this->form_validation->set_rules('size_US','Size US','required|trim|xss_clean|is_unique[male_shoe_sizes.size_US]');
			}
			else{
				$this->form_validation->set_rules('size_EU','Size EU','required|trim|xss_clean|is_unique[female_shoe_sizes.size_EU]');
				$this->form_validation->set_rules('size_UK','Size UK','required|trim|xss_clean|is_unique[female_shoe_sizes.size_UK]');
				$this->form_validation->set_rules('size_US','Size US','required|trim|xss_clean|is_unique[female_shoe_sizes.size_US]');
			}		
			
			$this->form_validation->set_rules('size_model','Size Model','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Size already exists! Please enter a new category!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'size_EU' => $this->input->post('size_EU'),
					'size_UK' => $this->input->post('size_UK'),
					'size_US' => $this->input->post('size_US'),
				);
				
				$model = $this->input->post('size_model');
				
				$inserted = false;
				
				if($model == 'male_sizes'){
					$inserted = $this->Male_sizes->insert_size($add);
				}
				else if($model == 'female_sizes'){
					$inserted = $this->Female_sizes->insert_size($add);
				}
				else if($model == 'male_shoe_sizes'){
					$inserted = $this->Male_shoe_sizes->insert_size($add);
				}
				else{
					$inserted = $this->Female_shoe_sizes->insert_size($add);
				}					
					
				if($inserted){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new size';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Size',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
											
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Size has been added!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Size has been added!</div>';
						
				}else{
					
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Size has not been added!</div>');
							
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Size has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update size 
		* 
		*/			
		public function update_size(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('size_EU','Size EU','required|trim|xss_clean');
			$this->form_validation->set_rules('size_UK','Size UK','required|trim|xss_clean');
			$this->form_validation->set_rules('size_US','Size US','required|trim|xss_clean');
			$this->form_validation->set_rules('size_model','Size Model','required|trim|xss_clean');
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('sizeID');
						
				$edit = array(
					'size_EU' => $this->input->post('size_EU'),
					'size_UK' => $this->input->post('size_UK'),
					'size_US' => $this->input->post('size_US'),
				);
				
				$model = $this->input->post('size_model');
				
				$updated = false;
				
				if($model == 'male_sizes'){
					$updated = $this->Male_sizes->update_size($edit, $id);
				}
				else if($model == 'female_sizes'){
					$updated = $this->Female_sizes->update_size($edit, $id);
				}
				else if($model == 'male_shoe_sizes'){
					$updated = $this->Male_shoe_sizes->update_size($edit, $id);
				}
				else{
					$updated = $this->Female_shoe_sizes->update_size($edit, $id);
				}				
					
				if ($updated){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a size';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Size',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
								
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Size updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Size has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		

				
		

		/**
		* Function to handle jquery display and edit
		* product options 
		* 
		*/	
		public function product_option_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('product_options')->where('id',$id)->get()->row();
			
			if($detail){

				$data['id'] = $detail->id;
				
				//get product details from db
				$product_array = $this->Products->get_product($detail->product_id);
				$product_name = '';
				foreach($product_array as $product){
					$product_name = ucwords($product->name);
				}	
				$data['headerTitle'] = $product_name;			

				$data['product_id'] = $detail->product_id;
				
				//***************SELECT PRODUCT ID - EDIT FUNCTION*********///
				$select_product_id = '<select name="product_id" id="pID" class="form-control select2">';
					
				$this->db->from('products');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['id'] == $detail->product_id)?'selected':'';
						$select_product_id .= '<option value="'.$row['id'].'" '.$default.'>'.$row['name'].' ('.$row['id'].')</option>';			
					}
				}
				
				$select_product_id .= '</select>';
				
				$data['select_product_id'] = $detail->select_product_id;
				//***************SELECT PRODUCT ID - EDIT FUNCTION*********///
				
				$data['size'] = $detail->size;
				
				//********************SELECT SIZE******************///
				$select_size = '<select name="product_size" id="s_size" class="form-control select2">';
				
				//MEN CLOTHING SIZES
				$select_size .= '<optgroup label="Men Clothing Sizes">';
				$this->db->from('male_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//MEN CLOTHING SIZES
					
				//MEN SHOE SIZES
				$select_size .= '<optgroup label="Men Shoe Sizes">';
				$this->db->from('male_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//MEN SHOE SIZES
					
				//WOMEN CLOTHING SIZES
				$select_size .= '<optgroup label="Women Clothing Sizes">';
				$this->db->from('female_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//WOMEN CLOTHING SIZES
					
				//WOMEN SHOE SIZES
				$select_size .= '<optgroup label="Women Shoe Sizes">';
				$this->db->from('female_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//WOMEN SHOE SIZES
					
				$select_size .= '</select>';
					
				$data['select_size'] = $select_size;
				//********************SELECT SIZE******************///
				
				
				$data['colour'] = $detail->colour;
				
				//********************SELECT COLOUR******************///
				$select_colour = '<select name="product_colour" id="s_colour" class="form-control select2">';
					
				$this->db->from('colours');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['colour_name'] == $detail->colour)?'selected':'';
						$select_colour .= '<option value="'.$row['colour_name'].'" '.$default.'>'.$row['colour_name'].'</option>';			
					}
				}
				
				$select_colour .= '</select>';
				
				$data['select_colour'] = $select_colour;
				//********************SELECT COLOUR******************///
				
				$data['quantity'] = $detail->quantity;
				
				$data['model'] = 'product_options';
				$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle product_options_datatable
		*
		***/
		public function product_options_datatable()
		{
			$list = $this->Product_options->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $option) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$option->id.'">';
				
				$row[] = $option->id;
				
				$product_array = $this->Products->get_product($option->product_id);
				$product_name = '';
				foreach($product_array as $product){
					$product_name = ucwords($product->name);
				}
				$row[] = $product_name.' ('.$option->product_id.')';
				$row[] = $option->size;
				$row[] = $option->colour;
				$row[] = $option->quantity;
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editOptionModal" class="btn btn-primary btn-xs" id="'.$option->id.'" title="Edit '.$product_name.'" onclick="editProductOption('.$option->id.')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Product_options->count_all(),
				"recordsFiltered" => $this->Product_options->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
					
		/**
		* Function to validate add option
		*
		*/			
		public function add_product_option(){

			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_id','Product ID','required|trim|xss_clean|numeric');			
			$this->form_validation->set_rules('size','Size','required|trim|xss_clean');
			$this->form_validation->set_rules('colour','Colour','required|trim|xss_clean');
			$this->form_validation->set_rules('quantity','Quantity','required|trim|xss_clean');
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('numeric', 'Product ID must be a number!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'product_id' => $this->input->post('product_id'),
					'size' => $this->input->post('size'),
					'colour' => $this->input->post('colour'),
					'quantity' => $this->input->post('quantity'),
				);
				
				$product_array = $this->Products->get_product($this->input->post('product_id'));
				$product_name = '';
				foreach($product_array as $product){
					$product_name = ucwords($product->name);
				}		
				
				$insert_id = $this->Product_options->insert_option($add);
						
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new option for '.$product_name;
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Product',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
											
					$this->session->set_flashdata('option_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new option for '.$product_name.' has been added!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new option for '.$product_name.' has been added!</div>';
						
				}else{
					
					$this->session->set_flashdata('option_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new option for '.$product_name.' has not been added!</div>');
							
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new option for '.$product_name.' has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update product 
		* option
		*/			
		public function update_product_option(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('category_name','Category Name','required|trim|xss_clean');
			
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('optionID');
						
				$edit = array(
					'product_id' => $this->input->post('product_id'),
					'size' => $this->input->post('size'),
					'colour' => $this->input->post('colour'),
					'quantity' => $this->input->post('quantity'),
				);
				
				$product_array = $this->Products->get_product($this->input->post('product_id'));
				$product_name = '';
				foreach($product_array as $product){
					$product_name = ucwords($product->name);
				}		
				
				if ($this->Product_options->update_product_options($edit, $id)){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated an option for - <i>'.$product_name.'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Product',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
								
					$this->session->set_flashdata('category_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.$product_name.' option updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$product_name.' option has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
			
		
		/***
		* Function to handle products datatable
		*
		***/
		public function products_datatable()
		{
			$list = $this->Products->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $product) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$product->id.'">';
				
				$row[] = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->image.'" class="img-responsive img-rounded" width="40" height="50" />';
				
				$row[] = ucwords($product->name);
				$row[] = $product->category;
				$row[] = $product->price;
				$row[] = $product->quantity_available;
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#viewProductModal" class="btn btn-info btn-xs" id="'.$product->id.'" title="View '.ucwords($product->name).'" onclick="viewProduct('.$product->id.')"><i class="fa fa-search"></i> View</a> 
				<a data-toggle="modal" data-target="#editProductModal" class="btn btn-primary btn-xs" id="'.$product->id.'" title="Edit '.ucwords($product->name).'" onclick="editProduct('.$product->id.')"><i class="fa fa-edit"></i> Edit</a>
				<a data-toggle="modal" data-target="#addImagesModal" class="btn btn-success btn-xs" id="'.$product->id.'" title="Edit Images" onclick="editImages('.$product->id.')"><i class="fa fa-upload"></i> Images</a> ';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Products->count_all(),
				"recordsFiltered" => $this->Products->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		
		/**
		* Function to handle display
		* product details
		* 
		*/	
		public function image_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$image_name = html_escape($this->input->post('image_name'));
			
			$detail = $this->db->select('*')->from('product_images')->where('image_name',$image_name)->get()->row();
			
			//$image_name = $this->input->post('image_name');

			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->image_name;			
					$data['product_id'] = $detail->product_id;
					
					$thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->product_id.'/'.$detail->image_name.'" class="img-responsive img-rounded" width="240" height="280" />';
					
					$data['thumbnail'] = $thumbnail;
					
					$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
					
					$data['model'] = 'product_images';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

				
		/**
		* Function to handle display
		* product details
		* 
		*/	
		public function product_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('products')->where('id',$id)->get()->row();
			
			if($detail){

				$data['id'] = $detail->id;
					
				$data['headerTitle'] = ucwords($detail->name);			
				$category = '<select name="product_category" class="form-control">';
					
				$this->db->from('product_categories');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['category_name'] == $detail->category)?'selected':'';
						$category .= '<option value="'.$row['category_name'].'" '.$default.'>'.$row['category_name'].'</option>';			
					}
				}
				
				$category .= '</select>';
					
				$data['select_category'] = $category;
				
				
				//********************SELECT CATEGORY******************///
				$select_category = '<select name="product_category" id="select_category" class="form-control select2">';
					
				//MEN CATEGORIES
				$select_category .= '<optgroup label="Men Categories">';
				$this->db->from('male_categories');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['category_name'] == $detail->category)?'selected':'';
						$select_category .= '<option value="'.$row['category_name'].'" '.$default.'>'.$row['category_name'].'</option>';			
					}
				}
				$select_category .= '</optgroup>';
				//MEN CATEGORIES
				
				//WOMEN CATEGORIES
				$select_category .= '<optgroup label="Women Categories">';
				$this->db->from('female_categories');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['category_name'] == $detail->category)?'selected':'';
						$select_category .= '<option value="'.$row['category_name'].'" '.$default.'>'.$row['category_name'].'</option>';			
					}
				}
				$select_category .= '</optgroup>';
				//WOMEN CATEGORIES
				
				$select_category .= '</select>';
					
				$data['select_category'] = $select_category;
				//********************SELECT CATEGORY******************///
				
				
					
				$select_gender = '<select name="product_gender" class="form-control select2">';
				$select_gender .= '<option value="0" >Select Gender</option>';
				$select_gender .= '<option value="Male" >Male</option>';
				$select_gender .= '<option value="Female" >Female</option>';
				$select_gender .= '</select>';
					
				$data['select_gender'] = $select_gender;
					
				//********************SELECT SIZE******************///
				$select_size = '<select name="product_size" id="select_size" class="form-control select2">';
					
				//MEN CLOTHING SIZES
				$select_size .= '<optgroup label="Men Clothing Sizes">';
				$this->db->from('male_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//MEN CLOTHING SIZES
					
				//MEN SHOE SIZES
				$select_size .= '<optgroup label="Men Shoe Sizes">';
				$this->db->from('male_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//MEN SHOE SIZES
					
				//WOMEN CLOTHING SIZES
				$select_size .= '<optgroup label="Women Clothing Sizes">';
				$this->db->from('female_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//WOMEN CLOTHING SIZES
					
				//WOMEN SHOE SIZES
				$select_size .= '<optgroup label="Women Shoe Sizes">';
				$this->db->from('female_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['size_US'] == $detail->size)?'selected':'';
						$select_size .= '<option value="'.$row['size_US'].'" '.$default.'>US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//WOMEN SHOE SIZES
					
				$select_size .= '</select>';
					
				$data['select_size'] = $select_size;
				//********************SELECT SIZE******************///
				
				
				$data['colour'] = $detail->colour;
				
				//********************SELECT COLOUR******************///
				$select_colour = '<select name="product_colour" id="product_colour" class="form-control select2">';
					
				$this->db->from('colours');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['colour_name'] == $detail->colour)?'selected':'';
						$select_colour .= '<option value="'.$row['colour_name'].'" '.$default.'>'.$row['colour_name'].'</option>';			
					}
				}
				
				$select_colour .= '</select>';
				
				$data['select_colour'] = $select_colour;
				//********************SELECT COLOUR******************///
				
				//BRAND SELECT DROPDOWN//
				$brand = '<select name="product_brand" class="form-control">';
				$this->db->from('brands');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$default = ($row['brand_name'] == $detail->brand)?'selected':'';
						$brand .= '<option value="'.$row['brand_name'].'" '.$default.'>'.$row['brand_name'].'</option>';			
					}
				}
				$brand .= '</select>';
				$data['select_brand'] = $brand;
				//BRAND SELECT DROPDOWN//
											
				//count reviews
				$count_reviews = $this->Reviews->count_product_reviews($detail->id);
				if($count_reviews == '' || $count_reviews == null || $count_reviews < 1 ){
					$count_reviews = 0 .' reviews';
				}
				else if($count_reviews == 1){
					$count_reviews = '1 review';
				}else{
					$count_reviews = $count_reviews .' reviews';
				}
				//get product ratings
				$rating = $this->db->select_avg('rating')->from('reviews')->where('product_id', $detail->id)->get()->result();
				//$res = $this->db->select_avg('rating','overall')->where('product_id', $id)->get('reviews')->result_array();
					
				$data['count_reviews'] = $count_reviews;
				$data['rating'] = round($rating[0]->rating);
					
				$rating_box = '';
				$rating_star = '';
					
				if($rating[0]->rating == '' || $rating[0]->rating == null || $rating[0]->rating < 1){
					$rating_box = '<div class="starrr stars-existing"  data-rating="'.round($rating[0]->rating).'"></div> <span class="">No reviews yet</span>';
						
					$rating_star = '<span class="text-ban">';
					for($i = 0; $i < 5; $i++){
						$rating_star .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
					}
					$rating_star .= '</span> <span class="">No reviews yet</span>';
						
				}else{
					//$rating_box = '<script type="text/javascript" language="javascript">var rating = '.round($rating[0]->rating.';$(".stars-existing").starrr({rating:rating,readOnly: true});</script>';
					$rating_box .= '<span class="sr-only">'.$count_reviews.' out of Five Stars</span>';
					//$rating_box .= '<div class="starrr stars-existing" data-rating="'.round($rating[0]->rating).'"></div>';
					$rating_box .= '<span class="stars-count-existing">'.round($rating[0]->rating).'</span> star(s) ';
					$rating_box .= '<span class="label label-success">'.$count_reviews.'</span>';
					$fullStars = round($rating[0]->rating);
					$emptyStars = 5 - round($rating[0]->rating);
						
					$rating_star = '<span class="text-ban">';
						
					for($a = 0; $a < $fullStars; $a++){
						$rating_star .= '<i class="fa fa-star" aria-hidden="true"></i>';
					}
					if($emptyStars > 0){
						for($b = 0; $b < $emptyStars; $b++){
							$rating_star .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
						}
					}
					$rating_star .= '</span> <span class="stars-count-existing">'.round($rating[0]->rating).'</span> star(s) <span class="label label-success">'.$count_reviews.'</span>';
						
				}
				$data['rating_box'] = $rating_box;
					
				$data['rating_star'] = $rating_star;
						
				$thumbnail = '';
				$mini_thumbnail = '';
				$filename = FCPATH.'uploads/products/'.$detail->id.'/'.$detail->image;
					
				if(file_exists($filename)){
					$thumbnail = '<img id="main-img" src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->id.'.jpg" class="img-responsive" width="" height="" />';
					$mini_thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->id.'.jpg" class="img-responsive img-rounded img-thumbnail" width="" height="" />';
				}
					
				else if($detail->image == '' || $detail->image == null){
					$thumbnail = '<img id="main-img" src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive" width="" height="" />';
					$mini_thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded img-thumbnail" width="" height="" />';
				}
					
				else{
					$thumbnail = '<img id="main-img" src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->image.'" class="img-responsive" width="" height="" />';
					$mini_thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->image.'" class="img-responsive img-rounded img-thumbnail" width="" height="" />';
				}	
				$data['thumbnail'] = $thumbnail;
				$data['mini_thumbnail'] = $mini_thumbnail;
					
				$product_images = $this->Products->get_product_images($detail->id);
				$count = $this->Products->count_product_images($detail->id);
				if($count == '' || $count == null){
					$count = 0;
				}
				//$images_list = '<div class="row thumbnail-row">';
					
				//start product gallery view
				$gallery = '<div class="p_gallery">';
					
				//start gallery edit group
				$image_group = '<div class="">';
						
				if(!empty($product_images)){
					/*$col = 'col-xs-3';
					if($count > 2 && $count < 4 ){
							$col = 'col-xs-4';
					}
					if($count == 2){
						$col = 'col-xs-2';
					}*/
					//item count initialised
					$i = 0;
						
					//gallery edit row
					$image_group .= '<div class="row">';
						
					foreach($product_images as $images){
						/*$images_list .= '<div class="'.$col.' nopadding"><img src="'.base_url().'uploads/products/'.$detail->id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/products/'.$detail->id.'/'.$images->image_name.'\')" width="80" height="95" /></div>';
						*/
						//products gallery view
						$gallery .= '<a href="javascript:void(0)" title="View">';
						$gallery .= '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive" onclick="changeImage(\''.base_url().'uploads/products/'.$detail->id.'/'.$images->image_name.'\')"/>';
						$gallery .= '</a>';
							
						//gallery edit group
						$image_group .= '<div class="col-sm-3 nopadding">';
							
						//gallery edit group
						$image_group .= '<div class="image-group">';
							
						$image_group .= '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive" />';
						
						//image path
						$path = 'uploads/products/'.$detail->id.'/'.$images->image_name;
						$image_group .= '<a href="#" class="remove_image" onclick="deleteProductImage(this,'.$detail->id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
						$image_group .= '</div>';
						$image_group .= '</div>';
						$i++;
						if($i % 4 == 0){
								$image_group .= '</div><br/><div class="row">';
						}
					}
				}
					
				//end gallery edit group
				$image_group .= '</div>';
				$data['image_group'] = $image_group;
					
				//end product gallery view
				$gallery .= '</div>';
				$data['product_gallery'] = $gallery;
					
					
				//$images_list .= '</div>';
				//$data['image_row'] = $images_list;
				$data['images_count'] = $count;
					
				$data['name'] = ucwords($detail->name);
				$data['category'] = $detail->category;
					
				$gender = $detail->gender;
				if($gender == '' || $gender == '0' || $gender == null){
					$gender = '0';
				}
				$data['gender'] = $gender;
				$data['product_reference'] = $detail->reference_id;
				$data['product_colour'] = $detail->colour;
				$data['product_size'] = $detail->size;
				$data['product_brand'] = $detail->brand;
					
				$data['sale'] = $detail->sale;
				$data['sale_price'] = $detail->sale_price;
					
					
				if($detail->colour != ''){
						
					$background_image = base_url().'assets/images/img/'.strtolower($detail->colour).'.png?'.time();
					
					$data['colour'] = '<div class="color-box" title="'.ucwords($detail->colour).'" id="'.strtolower($detail->colour).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($detail->colour).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"></div>';
				}
					
				if($detail->size != ''){
					$data['size'] = '<div class="size-box" title="Size '.ucwords($detail->size).'" id="'.$detail->size.'" data-toggle="tooltip" data-placement="top">'.$detail->size.'</div>';
					
				}
					
				$data['price'] = number_format($detail->price, 2);
				$data['description'] = stripslashes(wordwrap(nl2br($detail->description), 54, "\n", true));
					
				$quantity_available = $detail->quantity_available;
					
				$available = $quantity_available.' units';
					
				if($quantity_available == 1){
					$available = '1 unit';
				}
				$data['quantity_available'] = $available;
				$data['quantity'] = $detail->quantity_available;
					
				$status = 'In Stock';
				if($detail->quantity_available == 0){
					$status = 'Not in Stock';
				}
				$data['quantity_status'] = $status;
					
				$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
					
				$data['model'] = 'products';
				$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

		
		/***
		* Function to handle products
		*
		***/		
		public function products(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				//********************SELECT SIZE******************///
				$select_size = '<select name="size" id="sze" class="form-control select2">';
				$select_size .= '<option value="0">Select Size</option>';
				//MEN CLOTHING SIZES
				$select_size .= '<optgroup label="Men Clothing Sizes">';
				$this->db->from('male_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$select_size .= '<option value="'.$row['size_US'].'" >US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//MEN CLOTHING SIZES
					
				//MEN SHOE SIZES
				$select_size .= '<optgroup label="Men Shoe Sizes">';
				$this->db->from('male_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){

						$select_size .= '<option value="'.$row['size_US'].'" >US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//MEN SHOE SIZES
					
				//WOMEN CLOTHING SIZES
				$select_size .= '<optgroup label="Women Clothing Sizes">';
				$this->db->from('female_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$select_size .= '<option value="'.$row['size_US'].'" >US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//WOMEN CLOTHING SIZES
					
				//WOMEN SHOE SIZES
				$select_size .= '<optgroup label="Women Shoe Sizes">';
				$this->db->from('female_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){

						$select_size .= '<option value="'.$row['size_US'].'" >US - '.$row['size_US'].'</option>';			
					}
				}
				$select_size .= '</optgroup>';
				//WOMEN SHOE SIZES
					
				$select_size .= '</select>';
					
				$data['select_size'] = $select_size;
				//********************SELECT SIZE******************///
				
				//********************SELECT COLOUR******************///
				$select_colour = '<select name="colour" id="color" class="form-control select2">';
				$select_colour .= '<option value="0">Select Colour</option>';
				
				$this->db->from('colours');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
			
						$select_colour .= '<option value="'.$row['colour_name'].'">'.$row['colour_name'].'</option>';			
					}
				}
				
				$select_colour .= '</select>';
				
				$data['select_colour'] = $select_colour;
				//********************SELECT COLOUR******************///
				
					
				//assign page title name
				$data['pageTitle'] = 'Products List';
						
				//assign page title name
				$data['pageID'] = 'products_list';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/products_list_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
		/**
		* Function to validate add product
		*
		*/			
		public function add_product(){

				$this->load->library('form_validation');
				
				$this->form_validation->set_rules('product_category','Product Category','required|trim|xss_clean|callback_category_check');
				$this->form_validation->set_rules('product_gender','Product Gender','required|trim|xss_clean|callback_gender_check');
				$this->form_validation->set_rules('product_colour','Product Colour','required|trim|xss_clean|callback_colour_check');
				$this->form_validation->set_rules('product_size','Product Size','required|trim|xss_clean');
				$this->form_validation->set_rules('product_brand','Product Brand','required|trim|xss_clean|callback_brand_check');
				$this->form_validation->set_rules('product_name','Product name','required|trim|xss_clean|is_unique[products.name]');
				$this->form_validation->set_rules('product_price','Product price','required|trim|xss_clean');
				$this->form_validation->set_rules('sale','Sale','required|trim|xss_clean');
				$this->form_validation->set_rules('sale_price','Sale price','trim|xss_clean');
				$this->form_validation->set_rules('product_description','Product description','required|trim|xss_clean');
				$this->form_validation->set_rules('product_quantity_available','Product Quantity','required|trim|xss_clean');
				if (empty($_FILES['product_image']['name'])){
					$this->form_validation->set_rules('product_image', 'Product Image', 'required');
				}
				$this->form_validation->set_message('required', '%s cannot be blank!');
				$this->form_validation->set_message('is_unique', 'Duplicate item!');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
				if($this->form_validation->run()){
					
					$gender = strtolower($this->input->post('product_gender'));
						
					$category_id = '';
					$cat_id = '';
					
					if($gender == 'male'){
						$detail = $this->db->select('*')->from('male_categories')->where('category_name',$this->input->post('product_category'))->get()->row();
						$cat_id = $detail->id;
						$category_array = $this->Male_categories->get_category_by_name($this->input->post('product_category'));
						foreach($category_array as $cat){
							$category_id = $cat->id;
							
						}
					}
					
					if($gender == 'female'){
						$detail = $this->db->select('*')->from('female_categories')->where('category_name',$this->input->post('product_category'))->get()->row();
						$cat_id = $detail->id;
						
					}
					
					//generate a unique product reference id
					$random_string1 = substr(str_shuffle("0123456789"), 0, 4);
					$random_string2 = substr(str_shuffle("0123456789"), 0, 3);
						
					$reference_id = $cat_id .''.$random_string1.'/'.$random_string2;
						
					//ensure the reference number is unique
					while(!$this->Products->is_unique_ref($reference_id)){
							
						$random_string1 = substr(str_shuffle("0123456789"), 0, 4);
						$random_string2 = substr(str_shuffle("0123456789"), 0, 3);
						
						$reference_id = $cat_id .''.$random_string1.'/'.$random_string2;
					}
						
					
					$product_price = floatval(preg_replace('/[^\d\.]/', '', $this->input->post('product_price')));
					
					$sale_price = floatval(preg_replace('/[^\d\.]/', '', $this->input->post('sale_price')));	
						
					$add = array(
						'reference_id' => $reference_id,
						'category' => $this->input->post('product_category'),
						'gender' => $this->input->post('product_gender'),
						'colour' => $this->input->post('product_colour'),
						'size' => $this->input->post('product_size'),
						'brand' => $this->input->post('product_brand'),
						'name' => $this->input->post('product_name'),	'price' => $product_price,		
						'sale' => $this->input->post('sale'),
						'sale_price' => $sale_price,
						'description' => $this->input->post('product_description'),
						'quantity_available' => $this->input->post('product_quantity_available'),	
						'date_added' => date('Y-m-d H:i:s'),
						
					);
						
					//$table = 'users';	
					//$this->Admin->add_to_db($table, $data)
						
					$insert_id = $this->Products->insert_product($add);
						
					if($insert_id){
							
						if(isset($_FILES["product_image"])){
								
							$file_name = '';
								
							$path = './uploads/products/'.$insert_id.'/';
							if(!is_dir($path)){
								mkdir($path,0777);
							}
							$config['upload_path'] = $path;
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size'] = 2048000;
							$config['max_width'] = 3048;
							$config['max_height'] = 2048;
									
							$config['file_name'] = $insert_id.'.jpg';
								
							$this->load->library('upload', $config);	

							$this->upload->overwrite = true;
							if($this->upload->do_upload('product_image')){
							
								$upload_data = $this->upload->data();
										
								if (isset($upload_data['file_name'])){
									$file_name = $upload_data['file_name'];
								}				
							}else{
								$data['upload_error'] = $this->upload->display_errors();
							}
							$image_data = array(
								'image' => $file_name,		
							);
							$this->Products->update_product($image_data,$insert_id);
								
							//store in gallery as well
							$gallery_data = array(
								'product_id' => $insert_id,
								'image_name'=> $file_name,
								'date_added' => date('Y-m-d H:i:s'), 
							);
							$this->db->insert('product_images',$gallery_data);	
						}	
							
						$username = $this->session->userdata('admin_username');
						$user_array = $this->Admin->get_user($username);
							
						$fullname = '';
						if($user_array){
							foreach($user_array as $user){
								$fullname = $user->admin_name;
							}
						}
						//update activities table
						$description = 'added a new product - <i>'.ucwords($this->input->post('product_name')).'</i>';
						
						$activity = array(			
							'name' => $fullname,
							'username' => $username,
							'description' => $description,
							'keyword' => 'Product',
							'activity_time' => date('Y-m-d H:i:s'),
						);
								
						$this->Site_activities->insert_activity($activity);
										
						//$this->session->set_flashdata('product_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('product_name')).' has been added!</div>');
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i>'.ucwords($this->input->post('product_name')).'</i> has been added!</div>';

						//update complete redirects to success page
						//redirect('admin/users');							
					}else{
						
						//$this->session->set_flashdata('product_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('product_name')).' has not been added!</div>');
						
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i>'.ucwords($this->input->post('product_name')).'</i> not added!</div>';
		
							//update complete redirects to success page
							//redirect('admin/users');							
					}				
				}
				else {
					
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Product not added!'.validation_errors().'</div>';
					
					//$this->add_user();	
				}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		
		
		/**
		* Function to validate update product 
		* form
		*/			
		public function update_product(){
			
			$file_uploaded = false;
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			$id = html_escape($this->input->post('productID'));
			
			$product_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
				
			if(!empty($_FILES["new_product_image"]['name'])){
				
				
				$path = './uploads/products/'.$product_id.'/';
				
				if(!is_dir($path)){
					mkdir($path,0777);
				}
				
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048000;
				$config['max_width'] = 3048;
				$config['max_height'] = 2048;
						
				$config['file_name'] = $product_id.'.jpg';
					
				$this->load->library('upload', $config);	

				$this->upload->overwrite = true;
				
				$file_uploaded = true;
																
			}
				
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean');
			$this->form_validation->set_rules('product_category','Product Category','required|trim|xss_clean|callback_category_check');
			$this->form_validation->set_rules('product_gender','Product Gender','required|trim|xss_clean|callback_gender_check');
			$this->form_validation->set_rules('product_colour','Product Colour','required|trim|xss_clean|callback_colour_check');
			$this->form_validation->set_rules('product_size','Product Size','required|trim|xss_clean');
			$this->form_validation->set_rules('product_brand','Product Brand','required|trim|xss_clean|callback_brand_check');
			$this->form_validation->set_rules('product_price','Product Price','required|trim|xss_clean');
			$this->form_validation->set_rules('product_description','Product Description','required|trim|xss_clean');
			$this->form_validation->set_rules('product_quantity_available','Product Quantity','required|trim|xss_clean');
			$this->form_validation->set_rules('sale','Sale','trim|xss_clean');
			$this->form_validation->set_rules('sale_price','Sale Price','trim|xss_clean');			
			$this->form_validation->set_message('required', '%s cannot be blank!');
				
			if ($this->form_validation->run()){
				
				//get product from db
				$product = $this->Products->get_product($product_id);
				
				//initialise file name
				$new_product_image = '';
				
				//check for any uploaded file
				if($file_uploaded){
					if($this->upload->do_upload('new_product_image')){
							
						$upload_data = $this->upload->data();
							
						$file_name = '';
						if (isset($upload_data['file_name'])){
							$file_name = $upload_data['file_name'];
						}
						$new_product_image = $file_name;				
					}else{
						if($this->upload->display_errors()){
							$data['upload_error'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors with the photo!<br/>'.$this->upload->display_errors().'</div>';

						}
						//$data['upload_error'] = $this->upload->display_errors();
						
					}	
				
				}else{
					foreach($product as $p){
						$new_product_image = $p->image;
					}
				}
				
				$product_price = floatval(preg_replace('/[^\d\.]/', '', $this->input->post('product_price')));
				
				$sale_price = floatval(preg_replace('/[^\d\.]/', '', $this->input->post('sale_price')));
				$update = array(
					
					'category' => $this->input->post('product_category'),
					'gender' => $this->input->post('product_gender'),
					'colour' => $this->input->post('product_colour'),
					'size' => $this->input->post('product_size'),
					'brand' => $this->input->post('product_brand'),
					'name' => $this->input->post('product_name'),
					'price' => $product_price,
					'sale' => $this->input->post('sale'),
					'sale_price' => $sale_price,
					'description' => $this->input->post('product_description'),
					'image' => $new_product_image,
					'quantity_available' => $this->input->post('product_quantity_available'),
				);
				
				if ($this->Products->update_product($update, $product_id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated product - <i>'.ucwords($this->input->post('product_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Product',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
										
					$this->session->set_flashdata('product_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="alert alert-success text-center custom-alert-box text-center" role="alert"><i class="fa fa-check-circle"></i> <i>'.ucwords($this->input->post('product_name')).'</i> updated!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i>'.ucwords($this->input->post('product_name')).'</i> has been updated!</div>';
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		

		/**
		* Function to ensure a category is selected 
		* 
		*/			
		public function category_check(){
			
			$product_category = $this->input->post('product_category');
			
			if($product_category == '0'){
				$this->form_validation->set_message('category_check', 'Please select at least one category!');					
				return FALSE;
			}
			
			return TRUE;
		
		}	

		/**
		* Function to ensure a gender is selected 
		* 
		*/			
		public function gender_check(){
			
			$product_gender = $this->input->post('product_gender');
			
			if($product_gender == '0'){
				$this->form_validation->set_message('gender_check', 'Please select a gender!');					
				return FALSE;
			}
			
			return TRUE;
		
		}	
		

		/**
		* Function to ensure a gender is selected 
		* 
		*/			
		public function colour_check(){
			
			$product_colour = $this->input->post('product_colour');
			
			if($product_colour == '0'){
				$this->form_validation->set_message('colour_check', 'Please select a colour!');					
				return FALSE;
			}
			
			return TRUE;
		
		}	
		
		
		/**
		* Function to ensure a gender is selected 
		* 
		*/			
		public function brand_check(){
			
			$product_brand = $this->input->post('product_brand');
			
			if($product_brand == '0'){
				$this->form_validation->set_message('brand_check', 'Please select a brand!');					
				return FALSE;
			}
			
			return TRUE;
		
		}	
		

		/**
		* Function to ensure a customer is selected 
		* 
		*/			
		public function customer_check(){
			
			$selected = $this->input->post('customer_email');
			
			if($selected == '0'){
				$this->form_validation->set_message('customer_check', 'Please select at least one customer!');					
				return FALSE;
			}
			
			return TRUE;
		
		}	
		
				
		/**
		* Function to upload multiple images for product 
		* 
		*/			
		public function upload_product_images(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('prod_id'));
			$product_id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
				
			$count = $this->Products->count_product_images($product_id);	
			if($count == '' || $count == null){
				$count = 0;
			}
				
			if(!empty($_FILES['product_images']['name']) && $count <= 10){
				
				$append = 0;
				$name_array = array();
				$error_array = array();
				$upload_count = 0;
				
				$count = count($_FILES['product_images']['size']);	
				
				//$product_id = $this->input->post('prod_id');
				//$existing_images_count = $this->db->where('product_id', $product_id)->get('product_images')->num_rows();
				
				$existing_images_count = $this->db->where('product_id', $product_id)->count_all('product_images');
				
				if($existing_images_count == '' || $existing_images_count < 1){
					$append = 1;
				}else{
					$append = $existing_images_count + 1;
				}
				//$upload = false;
				foreach($_FILES as $key=>$value){
					
					for($s=0; $s<=$count-1; $s++) {
						
						$_FILES['images']['name']=$value['name'][$s];
						$_FILES['images']['type'] = $value['type'][$s];
						$_FILES['images']['tmp_name'] = $value['tmp_name'][$s];
						$_FILES['images']['error'] = $value['error'][$s];
						$_FILES['images']['size'] = $value['size'][$s]; 	
						
						//ensure only files with input are processed
						if ($_FILES['images']['size'] > 0) {
							
							$config['upload_path'] = './uploads/products/'.$product_id.'/';
							$config['allowed_types'] = 'gif|jpg|jpeg|png';
							$config['max_size'] = 2048000;
							$config['max_width'] = 3048;
							$config['max_height'] = 2048;
							
							$ext = $append + $s;
							
							$config['file_name'] = $product_id.'-'.$append.'.jpg';
							$append++;
							
							$this->load->library('upload', $config);	
							
							if($this->upload->do_upload('product_images')){
									
								$upload_data = $this->upload->data();
									
								$file_name = '';
								if (isset($upload_data['file_name'])){
									$file_name = $upload_data['file_name'];
								}
								
								$db_data = array(
									'product_id' => $product_id,
									'image_name'=> $file_name,
									'date_added' => date('Y-m-d H:i:s'), 
									);
								$this->db->insert('product_images',$db_data);	
								
							}else{
								if($this->upload->display_errors()){
									$error_array[] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors with the photo!<br/>'.$this->upload->display_errors().'</div>';

								}
							}
							
						}
						
						
					}
					$append++;
				}	
				$errors= implode(',', $error_array);
				if($errors != ''){
					$this->session->set_flashdata('image_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Image errors!</div>');
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$errors.'</div>';
				
				}else{
					
					$product_images = $this->Products->get_product_images($product_id);
					$count = $this->Products->count_product_images($product_id);
					
					//start gallery edit group
					$image_group = '<div class="">';
					
					if(!empty($product_images)){
						//item count initialised
						$i = 0;
						//gallery edit row
						$image_group .= '<div class="row">';
							
							
						foreach($product_images as $images){
							
							//gallery edit group
							$image_group .= '<div class="col-sm-3 nopadding">';
							
							//gallery edit group
							$image_group .= '<div class="image-group">';
							
							$image_group .= '<img src="'.base_url().'uploads/products/'.$product_id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive" />';
							//image path
							$path = 'uploads/products/'.$product_id.'/'.$images->image_name;
							$image_group .= '<a href="#" class="remove_image" onclick="deleteProductImage(this,'.$product_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
							$image_group .= '</div>';
							$image_group .= '</div>';
							$i++;
							if($i % 4 == 0){
								$image_group .= '</div><br/><div class="row">';
							}
							//$image_group .= '<div style="clear:both;"></div>';
						}
					}
					
					//end gallery edit group
					$image_group .= '</div>';
					$data['image_group'] = $image_group;
					
					//count and display the number of images stored
					$images_count = $this->Products->count_product_images($product_id);
					if($images_count == '' || $images_count == null){
						$images_count = 0;
					}
					$data['images_count'] = $images_count;
					
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					
					//update activities table
					$description = 'added product images';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Image',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					$this->session->set_flashdata('image_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Image(s) added!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Image added!</div>';
				}
			}
	
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		
		
		
		public function delete_product_images(){
			
			if($this->input->post('id') != '' && $this->input->post('product_id') != '' && $this->input->post('path') != '')
			{
				$id = $this->input->post('id');
				$path = $this->input->post('path');
				$product_id = $this->input->post('product_id');
				
				if($this->Products->delete_image($id,$path)){
					
					$product_images = $this->Products->get_product_images($product_id);
					$count = $this->Products->count_product_images($product_id);
					
					//start gallery edit group
					$image_group = '<div class="">';
					
					if(!empty($product_images)){
						//item count initialised
						$i = 0;
						//gallery edit row
						$image_group .= '<div class="row">';
							
							
						foreach($product_images as $images){
							
							//gallery edit group
							$image_group .= '<div class="col-sm-3 nopadding">';
							
							//gallery edit group
							$image_group .= '<div class="image-group">';
							
							$image_group .= '<img src="'.base_url().'uploads/products/'.$product_id.'/'.$images->image_name.'" id="'.$images->image_name.'" class="img-responsive"/>';
							//image path
							$path = 'uploads/products/'.$product_id.'/'.$images->image_name;
							$image_group .= '<a href="#" class="remove_image" onclick="deleteProductImage(this,'.$product_id.','.$images->id.',\''.$path.'\')"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>';
							$image_group .= '</div>';
							$image_group .= '</div>';
							$i++;
							if($i % 4 == 0){
								$image_group .= '</div><br/><div class="row">';
							}
							//$image_group .= '<div style="clear:both;"></div>';
						}
					}
					
					//end gallery edit group
					$image_group .= '</div>';
					$data['image_group'] = $image_group;
					
					//count and display the number of images stored
					$images_count = $this->Products->count_product_images($product_id);
					if($images_count == '' || $images_count == null){
						$images_count = 0;
					}
					$data['images_count'] = $images_count;
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'deleted a product image';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Image',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Image removed!</div>';
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Image not removed!</div>';
				}
				
			}
			echo json_encode($data);
		}
				

			
		
		/***
		* Function to handle orders
		*
		***/		
		public function orders(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				//assign page title name
				$data['pageTitle'] = 'Orders';
								
				//assign page title name
				$data['pageID'] = 'orders';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/orders_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle orders ajax
		* Datatable
		***/
		public function orders_datatable()
		{
			
			$list = $this->Orders->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $order) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$order->id.'">';
				
				$row[] = '<h4><a data-toggle="modal" href="#" data-target="#viewOrderModal" class="link" onclick="viewOrder('.$order->reference.');" id="'.$order->id.'" title="View">'.$order->reference.'</a></h4>';
				
				$user_array = $this->Users->get_user($order->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				
				//$row[] = $order->reference;
				$row[] = number_format($order->total_price, 2);
				$row[] = $fullname;
				$row[] = $order->payment_status;
				$row[] = $order->shipping_status;
				$row[] = date("F j, Y", strtotime($order->order_date));
				$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-info btn-xs" onclick="editOrder('.$order->id.');" id="'.$order->id.'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Orders->count_all(),
				"recordsFiltered" => $this->Orders->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

	
		/**
		* Function to handle
		* orders edit
		* display
		*/	
		public function order_edit(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('orders')->where('id',$id)->get()->row();
			
			if($detail){
				
					$data['id'] = $detail->id;
					$data['headerTitle'] = 'Order - '.$detail->reference;			
					$data['reference'] = $detail->reference;
					$data['total_price'] = number_format($detail->total_price, 0);
					$data['customer_email'] = $detail->customer_email;
					$data['payment_status'] = $detail->payment_status;
					$data['shipping_status'] = $detail->shipping_status;
					
					$data['order_date'] = date("F j, Y", strtotime($detail->order_date));
					
					$data['model'] = 'orders';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
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
			
			$order_detail_array = $this->Order_details->get_orders_by_reference($reference);
			
			
			if($order_detail_array){
				
				$totalPrice = 0;
				$totalQuantity = 0;
				
				$details = '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
				$details .= '<thead><tr>';
				$details .= '<th>Product</th><th>Name</th><th>Quantity</th>';
				$details .= '<th>Price</th><th>Customer</th>';
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
					
					//Get customers name from email
					$user_array = $this->Users->get_user($detail->customer_email);
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
					
					$details .= '<td>'.$fullname.'</td>';
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
		* Function to validate add shipping
		*
		*/			
		public function add_order(){

			$this->load->library('form_validation');
			//$this->form_validation->set_rules('reference','Reference','required|trim|xss_clean|is_unique[orders.reference]');
			$this->form_validation->set_rules('total_price','Total Price','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_email','Customer Email','required|trim|xss_clean|valid_email|callback_customer_check');
			$this->form_validation->set_rules('payment_status','Payment Status','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_status','Shipping Status','required|trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This order already exists!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			if($this->form_validation->run()){
				
				//generate a random 8 digit string of numbers
				$random = substr(str_shuffle("0123456789"), 0, 8);
					
				//ensure the username is unique
				while(!$this->Orders->unique_reference($random)){
					$random = substr(str_shuffle("0123456789"), 0, 8);
				}
						
							
				$add = array(
					'reference' => $random,
					'total_price' => $this->input->post('total_price'),
					'customer_email' => $this->input->post('customer_email'),
					'payment_status' => $this->input->post('payment_status'),
					'shipping_status' => $this->input->post('shipping_status'),
					'order_date' => date('Y-m-d H:i:s'),
				);

				$insert_id = $this->Orders->insert_order($add);
							
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'added a new order';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Orders',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new order has been added!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new order has been added!</div>';
							
				}else{
							
					//$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new order has not been added!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new order has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update order
		* form
		*/			
		public function update_order(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('order_id','Order ID','required|trim|xss_clean');
			$this->form_validation->set_rules('total_price','Total Price','required|trim|xss_clean');
			$this->form_validation->set_rules('payment_status','Payment Status','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_status','Shipping Status','required|trim|xss_clean');
			
				
			if ($this->form_validation->run()){
				
				//escaping the post values
				$order_id = html_escape($this->input->post('order_id'));
				$id = preg_replace('#[^0-9]#i', '', $order_id); // filter everything but numbers
			
				
				$update = array(
					'total_price' => $this->input->post('total_price'),
					'payment_status' => $this->input->post('payment_status'),
					'shipping_status' => $this->input->post('shipping_status'),
				);
					
				if ($this->Orders->update_order($update, $id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'updated order';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Orders',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Order has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
					
		
		/***
		* Function to handle payments
		*
		***/		
		public function payments(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				//assign page title name
				$data['pageTitle'] = 'Payments';
								
				//assign page title name
				$data['pageID'] = 'payments';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/payments_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle payments ajax
		* Datatable
		***/
		public function payments_datatable()
		{
			
			$list = $this->Payments->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $payment) {
				$no++;
				$row = array();
				
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$payment->id.'">';
				$row[] = $no;
				$user_array = $this->Users->get_user($payment->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				
				
				$row[] = $payment->reference;
				$row[] = number_format($payment->total_amount, 2);
				$row[] = ucwords($payment->payment_method);
				$row[] = $fullname;
				$row[] = date("F j, Y", strtotime($payment->payment_date));
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Payments->count_all(),
				"recordsFiltered" => $this->Payments->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

			
			
		
		/***
		* Function to handle shipping
		*
		***/		
		public function shipping(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				//assign page title name
				$data['pageTitle'] = 'Shipping';
								
				//assign page title name
				$data['pageID'] = 'shipping';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/shipping_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle shipping ajax
		* Datatable
		***/
		public function shipping_datatable()
		{
			
			$list = $this->Shipping_status->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $shipping) {
				$no++;
				$row = array();
				
				
				
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$shipping->id.'">';
				
				$row[] = $no;
				
				$row[] = '<h4><a data-toggle="modal" href="#" data-target="#viewShippingModal" class="link" onclick="viewShipping('.$shipping->id.');" id="'.$shipping->id.'" title="View">'.$shipping->reference.'</a></h4>';
				
				$status = '';
				if($shipping->status == '0'){
					$status = 'Shipping Pending';
				}else{
					$status = 'Shipped';
				}
				$row[] = $status;
					
				$user_array = $this->Users->get_user($shipping->customer_email);
					
				$fullname = '';
				if($user_array){
					foreach($user_array as $user){
						$fullname = $user->first_name.' '.$user->last_name;
					}
				}
				$row[] = $fullname;
				$shipping_date = $shipping->shipping_date;
				
				if($shipping_date == '0000-00-00 00:00:00'){
					$shipping_date = 'Not Shipped';
				}else{
					$shipping_date = date('F j, Y', strtotime($shipping_date));
				}
				$row[] = $shipping_date;
				
				$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-info btn-xs" onclick="editShipping('.$shipping->id.');" id="'.$shipping->id.'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Shipping_status->count_all(),
				"recordsFiltered" => $this->Shipping_status->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

			
	
		/**
		* Function to handle
		* shipping view and edit
		* display
		*/	
		public function shipping_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('shipping_status')->where('id',$id)->get()->row();
			
			if($detail){
				
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = 'Shipping - '.$detail->reference;			
					$data['reference'] = $detail->reference;
					
					$status = '';
					if($detail->status == '0'){
						$status = 'Shipping Pending';
					}else{
						$status = 'Shipped';
					}
					$data['status'] = $status;
					$data['shipping_status'] = $detail->status;
					$data['note'] = $detail->note;
					
					$user_array = $this->Users->get_user($detail->customer_email);
						
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->first_name.' '.$user->last_name;
						}
					}
				
					$data['customer'] = $fullname;
					$data['customer_email'] = $detail->customer_email;
					$data['shipping_date'] = date("F j, Y", strtotime($detail->shipping_date));
					
					$shipping_date = $detail->shipping_date;
					$u_shipping_date = '';
					
					if($shipping_date == '0000-00-00'){
						$shipping_date = 'Not Assigned';
						$u_shipping_date = '';
					}else{
						$shipping_date = date('F j, Y', strtotime($shipping_date));
						$u_shipping_date = date('d/m/Y', strtotime($shipping_date));
					}
					
					$data['update_shipping_date'] = $u_shipping_date;
					
					
					$details = '<table class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">';
					$details .= '<tr>';
					$details .= '<th>Reference</th>';
					$details .= '<td>'.$detail->reference.'</td>';
					$details .= '</tr>';
					$details .= '<tr>';
					$details .= '<th>Status</th>';
					$details .= '<td>'.$status.'</td>';
					$details .= '</tr>';
					$details .= '<tr>';
					$details .= '<th>Note</th>';
					$details .= '<td>'.$detail->note.'</td>';
					$details .= '</tr>';
					$details .= '<tr>';
					$details .= '<th>Customer</th>';
					$details .= '<td>'.$fullname.'</td>';
					$details .= '</tr>';
					$details .= '<tr>';
					$details .= '<th>Date</th>';
					$details .= '<td>'.date("F j, Y", strtotime($detail->shipping_date)).'</td>';
					$details .= '</tr>';
					$details .= '</table>';	
					
					$data['details'] = $details;
					
					$data['model'] = 'shipping_status';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
			
	
		/**
		* Function to handle
		* shipping view and edit
		* display
		*/	
		public function customer_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$reference = html_escape($this->input->post('reference'));
			//$reference = preg_replace('#[^0-9]#i', '', $reference); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('orders')->where('reference',$reference)->get()->row();
			
			if($detail){
				
					$data['customer_email'] = $detail->customer_email;
					
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
				
		/**
		* Function to validate add shipping
		*
		*/			
		public function add_shipping(){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('reference','Reference','required|trim|xss_clean|is_unique[shipping_status.reference]');
			$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
			$this->form_validation->set_rules('customer_email','Customer Email','required|trim|xss_clean|valid_email');
			$this->form_validation->set_rules('shipping_date','Shipping Date','required|trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This order already exists!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			if($this->form_validation->run()){
							
				$add = array(
					'reference' => $this->input->post('reference'),
					'status' => $this->input->post('status'),
					'customer_email' => $this->input->post('customer_email'),
					'shipping_date' => $this->input->post('shipping_date'),
				);

				$insert_id = $this->Shipping_status->insert_shipping($add);
							
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'added a new shipping status';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Shipping',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new shipping status has been added!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new shipping status has been added!</div>';
							
				}else{
							
					//$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new shipping has not been added!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new shipping has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update shipping
		* form
		*/			
		public function update_shipping(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('shipping_id','Shipping ID','required|trim|xss_clean');
			$this->form_validation->set_rules('status','Status','required|trim|xss_clean');
			$this->form_validation->set_rules('note','Note','required|trim|xss_clean');
			$this->form_validation->set_rules('shipping_date','Shipping Date','required|trim|xss_clean');
			
				
			if ($this->form_validation->run()){
				
				//escaping the post values
				$shipping_id = html_escape($this->input->post('shipping_id'));
				$id = preg_replace('#[^0-9]#i', '', $shipping_id); // filter everything but numbers
			
				
				$update = array(
					'status' => $this->input->post('status'),
					'note' => $this->input->post('note'),
					'shipping_date' => $this->input->post('shipping_date'),
				);
					
				if ($this->Shipping_status->update_shipping($update, $id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'updated shipping';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Shipping',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Page metadata has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
		

		/**
		* Function to handle jquery display and edit
		* brand
		* 
		*/	
		public function brand_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('brands')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->brand_name;			

					$data['brand_name'] = $detail->brand_name;
					
					$select_brand = '<select name="product_brand" id="brand" class="form-control">';
					
					$this->db->from('brands');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['brand_name'] == $detail->brand_name)?'selected':'';
							$select_brand .= '<option value="'.$row['brand_name'].'" '.$default.'>'.$row['brand_name'].'</option>';			
						}
					}
					
					$select_brand .= '</select>';
					
					$data['select_brand'] = $select_brand;
					
					$data['model'] = 'brands';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		/***
		* Function to handle brands datatable
		*
		***/
		public function brands_datatable()
		{
			$list = $this->Brands->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $brand) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$brand->id.'">';
				
				$row[] = $brand->id;
				$row[] = ucwords($brand->brand_name);
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'brands';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editBrandModal" class="btn btn-primary btn-xs" id="'.$brand->id.'" title="Edit '.ucwords($brand->brand_name).'" onclick="editBrand('.$brand->id.')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Brands->count_all(),
				"recordsFiltered" => $this->Brands->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		
		
		/***
		* Function to handle product categories
		*
		***/		
		public function brands(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
					
				//assign page title name
				$data['pageTitle'] = 'Brands';
						
				//assign page title name
				$data['pageID'] = 'brands';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/brands_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
								
		/**
		* Function to validate add brand
		*
		*/			
		public function add_brand(){

			$this->load->library('form_validation');
				
			$this->form_validation->set_rules('brand_name','Brand Name','required|trim|xss_clean|is_unique[brands.brand_name]');
			
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Brand already exists! Please enter a new brand!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'brand_name' => ucwords($this->input->post('brand_name')),
				);
				
				if($this->Brands->insert_brand($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new brand - <i>'.ucwords($this->input->post('brand_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Brands',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
											
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('brand_name')).' has been added!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('brand_name')).' has been added!</div>';
						
				}else{
					
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('brand_name')).' has not been added!</div>');
							
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('brand_name')).' has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update brand 
		*  
		*/			
		public function update_brand(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('brand_name','Brand Name','required|trim|xss_clean');
			 	
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('brandID');
						
				$edit = array(
					'brand_name' => ucwords($this->input->post('brand_name')),
				);
				
				if ($this->Brands->update_brand($edit, $id)){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a brand - <i>'.ucwords($this->input->post('brand_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Brands',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
								
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Brand updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Brand has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		

		

		/**
		* Function to handle jquery display and edit
		* colour
		* 
		*/	
		public function colour_details(){
			
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('colours')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = $detail->colour_name;			

					$data['colour_name'] = $detail->colour_name;
					
					$select_colour = '<select name="product_colour" id="colour" class="form-control">';
					
					$this->db->from('colours');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['colour_name'] == $detail->colour_name)?'selected':'';
							$select_colour .= '<option value="'.$row['colour_name'].'" '.$default.'>'.$row['colour_name'].'</option>';			
						}
					}
					
					$select_colour .= '</select>';
					
					$data['select_colour'] = $select_colour;
					
					$data['model'] = 'colours';
					$data['success'] = true;
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}
		
		/***
		* Function to handle colours datatable
		*
		***/
		public function colours_datatable()
		{
			$list = $this->Colours->get_datatables();
			$data = array();
			$no = $_POST['start'];
			$last_login  = '';
			foreach ($list as $colour) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$colour->id.'">';
				
				$row[] = $colour->id;
				$row[] = ucwords($colour->colour_name);
				
				//$row[] = date("F j, Y", strtotime($portfolio->date_added));
				
				$model = 'colours';
				
				//prepare buttons
				$row[] = '<a data-toggle="modal" data-target="#editColourModal" class="btn btn-primary btn-xs" id="'.$colour->id.'" title="Edit '.ucwords($colour->colour_name).'" onclick="editColour('.$colour->id.')"><i class="fa fa-edit"></i> Edit</a>
				';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Colours->count_all(),
				"recordsFiltered" => $this->Colours->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
		
		
		
		/***
		* Function to handle colours
		*
		***/		
		public function colours(){
			
			if(!$this->session->userdata('admin_logged_in')){
				
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);				
				//redirect('admin/login/','refresh');
				
			}else{  
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
					
				//assign page title name
				$data['pageTitle'] = 'Colours';
						
				//assign page title name
				$data['pageID'] = 'colours';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
					
				//load main body
				$this->load->view('admin_pages/colours_page', $data);	
				
				//load footer
				$this->load->view('admin_pages/footer');
								
			}
		}
		
		
								
		/**
		* Function to validate add colour
		*
		*/			
		public function add_colour(){

			$this->load->library('form_validation');
				
			$this->form_validation->set_rules('colour_name','Colour','required|trim|xss_clean|is_unique[colours.colour_name]');
			
					
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'Colour already exists! Please enter a new colour!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			if($this->form_validation->run()){
		
				$add = array(
					'colour_name' => strtolower($this->input->post('colour_name')),
				);
				
				if($this->Colours->insert_colour($add)){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'added a new colour - <i>'.ucwords($this->input->post('colour_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Colours',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
											
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('colour_name')).' has been added!</div>');
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('colour_name')).' has been added!</div>';
						
				}else{
					
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut(600); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($this->input->post('colour_name')).' has not been added!</div>');
							
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($this->input->post('colour_name')).' has not been added!</div>';
						
				}				
			}
			else {
					
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
		}

		
		/**
		* Function to validate update colour 
		*  
		*/			
		public function update_colour(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('colour_name','Colour Name','required|trim|xss_clean');
			 	
			$this->form_validation->set_message('required', '%s cannot be blank!');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			   	
			if ($this->form_validation->run()){
				
				$id = $this->input->post('colourID');
						
				$edit = array(
					'colour_name' => strtolower($this->input->post('colour_name')),
				);
				
				if ($this->Colours->update_colour($edit, $id)){	
				
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
							
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated a colour - <i>'.ucwords($this->input->post('colour_name')).'</i>';
						
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Colours',
						'activity_time' => date('Y-m-d H:i:s'),
					);
								
					$this->Site_activities->insert_activity($activity);
								
					$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Colour updated!</div>');
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Colour has been updated!</div>';	
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}
		
			
		
		/***
		* Function to handle site_activities
		*
		***/		
		public function site_activities(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$delete = $this->Site_activities->delete_old_records();
			
				//assign page title name
				$data['pageTitle'] = 'Site Activities';
								
				//assign page title name
				$data['pageID'] = 'site_activities';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/site_activities_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle Site Activities ajax
		* Datatable
		***/
		public function site_activities_datatable()
		{
			$delete = $this->Site_activities->delete_old_records();
			
			$list = $this->Site_activities->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $activity) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$activity->id.'">';
				
				$row[] = $activity->name .' ('.$activity->username.')';
				
				$row[] = $activity->description;
				
				$row[] = $activity->keyword;
				
				$row[] = date("F j, Y", strtotime($activity->activity_time));
			
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Site_activities->count_all(),
				"recordsFiltered" => $this->Site_activities->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}			
					
			
		
		/***
		* Function to handle page metadata
		*
		***/		
		public function page_metadata(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//redirect('admin/login/','refresh');
				
			}else{			

				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				//assign page title name
				$data['pageTitle'] = 'Page Metadata';
								
				//assign page title name
				$data['pageID'] = 'page_metadata';
										
				//load header and page title
				$this->load->view('admin_pages/header', $data);
							
				//load main body
				$this->load->view('admin_pages/page_metadata_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
					
			}
				
		}
		
	
		
		/***
		* Function to handle Page metadata ajax
		* Datatable
		***/
		public function page_metadata_datatable()
		{
			
			$list = $this->Page_metadata->get_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $page) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$page->id.'">';
				
				$row[] = '<h4><a data-toggle="modal" href="#" data-target="#viewPageMetadataModal" class="link" onclick="viewPageMetadata('.$page->id.');" id="'.$page->id.'" title="View">'.$page->page.'</a></h4>';
				
				$row[] = $page->keywords;
				
				$row[] = '<a data-toggle="modal" data-target="#editModal" class="btn btn-info btn-xs" onclick="editPageMetadata('.$page->id.');" id="'.$page->id.'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				
				
				//$row[] = $type->details;
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Page_metadata->count_all(),
				"recordsFiltered" => $this->Page_metadata->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}

			
	
		/**
		* Function to handle
		* page metadata view and edit
		* display
		*/	
		public function page_metadata_details(){
			
			//escaping the post values
			$pid = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('page_metadata')->where('id',$id)->get()->row();
			
			if($detail){
					
					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->page).' metadata';			

					$data['page'] = $detail->page;
					$data['keywords'] = $detail->keywords;
					$data['description'] = $detail->description;
					
					$data['model'] = 'page_metadata';
					$data['success'] = true;

			}else {
				$data['success'] = false;
			}
			echo json_encode($data);
		}					
	
		
		/**
		* Function to validate add page metadata
		*
		*/			
		public function add_page_metadata(){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('page','Page','required|trim|xss_clean|is_unique[page_metadata.page]');
			$this->form_validation->set_rules('keywords','Keywords','required|trim|xss_clean');
			$this->form_validation->set_rules('description','Description','required|trim|xss_clean');
			
						
			$this->form_validation->set_message('required', '%s cannot be blank!');
			$this->form_validation->set_message('is_unique', 'This page already exists!');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
			if($this->form_validation->run()){
							
				$add = array(
					'page' => $this->input->post('page'),
					'keywords' => $this->input->post('keywords'),
					'description' => $this->input->post('description'),
				);

				$insert_id = $this->Page_metadata->insert_page_metadata($add);
							
				if($insert_id){
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'added a new page metadata (<i>'.$this->input->post('page').'</i>)';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Page Metadata',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> A new page metadata (<i>'.$this->input->post('page').'</i>)  has been added!</div>');
							
					$data['success'] = true;
							
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> A new page metadata (<i>'.$this->input->post('page').'</i>) has been added!</div>';
							
				}else{
							
					//$this->session->set_flashdata('added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> The new page metadata has not been added!</div>');
								
					$data['success'] = false;
							
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The new page metadata has not been added!</div>';
							
				}				
			}
			else {
						
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.validation_errors().'</div>';
				//$data['errors'] = $this->form_validation->error_array();
				//$this->addhand();	
			}

			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}


			
		/**
		* Function to validate update page metadata
		* form
		*/			
		public function update_page_metadata(){
			
			$this->load->library('form_validation');
				
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('page','Page','required|trim|xss_clean');
			$this->form_validation->set_rules('keywords','Keywords','required|trim|xss_clean');
			$this->form_validation->set_rules('description','Description','required|trim|xss_clean');
				
			if ($this->form_validation->run()){
				
				//escaping the post values
				$page_metadata_id = html_escape($this->input->post('page_metadata_id'));
				$id = preg_replace('#[^0-9]#i', '', $page_metadata_id); // filter everything but numbers
			
				
				$update = array(
					'page' => $this->input->post('page'),
					'keywords' => $this->input->post('keywords'),
					'description' => $this->input->post('description'),
				);
					
				if ($this->Page_metadata->update_page_metadata($update, $id)){	
					
					$username = $this->session->userdata('admin_username');
					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update page metadata table
					$description = 'updated page metadata';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Page Metadata',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					//$this->session->set_flashdata('updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box text-center"><i class="fa fa-check-circle"></i> Page Metadata updated!</div>');
						
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Page metadata has been updated!</div>';
				}
					
			}else {
				
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> There are errors on the form!'.validation_errors().'</div>';
			}
			
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
		}			
	
		
		
	
		/***
		* Function for admin profile
		*
		***/		
		public function profile2(){

			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
				
				$user_avatar = '';
				$user_id = '';
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
						$user_avatar = $user->avatar;
						$user_id = $user->id;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				$thumbnail = '';
				$filename = FCPATH.'uploads/admins/'.$user_id.'/'.$user_avatar;

				//check if record in db is url thus facebook or google
				if(filter_var($user_avatar, FILTER_VALIDATE_URL)){
					//diplay facebook avatar
					$thumbnail = '<img src="'.$user_avatar.'" class="social_profile img-responsive img-circle avatar-view" width="170" height="170" />';
				}
				elseif($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-responsive img-circle avatar-view" width="170" height="170" />';
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/admins/'.$user_id.'/'.$user_avatar.'" class="img-responsive img-circle avatar-view" width="170" height="170" />';
				}	
				$data['thumbnail'] = $thumbnail;
				
				//assign page title name
				$data['pageTitle'] = 'Profile';
				
				//assign page ID
				$data['pageID'] = 'profile';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/profile_page');
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}	
		}	
			

		/***
		* Function for admin settings
		*
		***/		
		public function settings2(){

			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);

				//assign page title name
				$data['pageTitle'] = 'Settings';
				
				//assign page ID
				$data['pageID'] = 'settings';
								
				//load header and page title
				$this->load->view('admin_pages/header', $data);
				
				//load main body
				$this->load->view('admin_pages/settings_page');
				
				//load footer
				$this->load->view('admin_pages/footer');
									
			}	
		}	

			

		/**
		* Function to validate update admin settings
		* form
		*/			
		public function settings_update2(){
			
			$username = $this->session->userdata('admin_username');
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
			$this->form_validation->set_rules('new_password','New Password','required|trim|xss_clean');
			$this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|matches[new_password]|trim|xss_clean');
			
			if ($this->form_validation->run()){	

				$data = array(
					'admin_password' => md5($this->input->post('new_password')),
				);

				if ($this->Admin->update_user($data, $username)){	

					$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					//update activities table
					$description = 'updated profile';
				
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Update',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
					$this->session->set_flashdata('admin_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".custom-alert-box").fadeOut("slow"); }, 5000);</script><div class="custom-alert-box alert alert-success text-center"><i class="fa fa-check-circle"></i> Your password has been updated!</div>');
							
					//update complete redirects to success page
					redirect('admin/profile/');	
				}
				
			}else {
				//$url = 'edit/hand_users/'.$hand_id;
				//Go back to the Edit Details Page if validation fails
				$this->settings();
			}
		
		}		

		
		public function multi_delete(){
			
			if($this->input->post('cb') != '' && $this->input->post('model')!= '' )
			{
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				//get model from post
				$model = html_escape($this->input->post('model'));
				
				$new_model = ucfirst($model.'_model');
				
				if(strtolower($model) == 'admin_users'){
					$new_model = 'Admin_model';
				}
				
				//load model
				$object = new $new_model();
				
				$i = 0;
				
				foreach($checked as $each){
					
					$each = preg_replace('#[^0-9]#i', '', $each); // filter everything but numbers
					
					//remove upload folder
					if(strtolower($model) == 'admin_users'){
						$path = './uploads/admins/'.$each.'/';
						delete_files($path);
						
					}	
					
					if(strtolower($model) == 'products'){
						$path = './uploads/products/'.$each.'/';
						delete_files($path);
						
					}	
					
					if(strtolower($model) == 'users'){
						$path = './uploads/users/'.$each.'/';
						delete_files($path);
						//unlink("uploads/testimonials/".$each);
					}

					if(strtolower($model) == 'orders'){
						$order_array = $this->Orders->get_order($each);
						$reference_id = '';
						if($order_array){
							foreach($order_array as $order){
								$reference_id = $order->reference;
							}
						}
						if($reference_id != '' || $reference_id != null){
							$this->db->delete('payments', array('reference' => $reference_id));
							$this->db->delete('shipping_status', array('reference' => $reference_id));
						}
					}	
					
					//delete from db
					$object->load($each);
					$object->delete();
					
					$i++;
				}
				
				$data['deleted_count'] = $i;
				$message = 'The record has been deleted!';
				$description = 'deleted a record from '.$model;
				if($i > 1){
					$message = 'The '.$i.' records have been deleted!';
					$description = 'deleted '.$i.' records from '.$model;
				}
					
				$username = $this->session->userdata('admin_username');
				$user_array = $this->Admin->get_user($username);
					
					$fullname = '';
					if($user_array){
						foreach($user_array as $user){
							$fullname = $user->admin_name;
						}
					}
					
					//update activities table
					$activity = array(			
						'name' => $fullname,
						'username' => $username,
						'description' => $description,
						'keyword' => 'Delete',
						'activity_time' => date('Y-m-d H:i:s'),
					);
						
					$this->Site_activities->insert_activity($activity);
							
				$data['success'] = true;
				
				$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.$message.'</div>';
				
			}else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Could not delete records!</div>';
			}
			
			echo json_encode($data);
		}
			
			
		/***
		* Function for error message
		*
		***/
		public function error(){
			
			if(!$this->session->userdata('admin_logged_in')){
								
				$url = 'admin/login?redirectURL='.urlencode(current_url());
				redirect($url);							
				//$this->login();
				//redirect('admin/login/','refresh');
				
			}else{ 	
			
				$username = $this->session->userdata('admin_username');
				
				$data['user_array'] = $this->Admin->get_user($username);
					
				$fullname = '';
				if($data['user_array']){
					foreach($data['user_array'] as $user){
						$fullname = $user->admin_name;
					}
				}
				
				$data['fullname'] = $fullname;
					
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
					
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
					
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);

				//assign page title name
				$data['pageTitle'] = 'Error';
									
				//assign page title name
				$data['pageID'] = 'error';
											
				//load header and page title
				$this->load->view('admin_pages/header', $data);
								
				//load main body
				$this->load->view('admin_pages/error_page', $data);	
					
				//load footer
				$this->load->view('admin_pages/footer');
			}	
		}
		
				
		/**
		* Function to log out user
		*
		*/        
		public function logout() {
			
				$this->session->unset_userdata('admin_logged_in');
				$this->session->unset_userdata('admin_username');
				$this->session->unset_userdata('login_time');
				
				$this->session->sess_destroy();	
				//log out successful, redirects to log in page
				redirect('admin/login');				
		
		}
		
		
}
