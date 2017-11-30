<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

		public function indexOld(){
				 
			if($this->session->userdata('logged_in')){ 
					
				// Get the id of the first question

				$res = $this->db->select_min('id')->get('questions')->result_array();

				$id = $res[0]['id'];
				$result = $this->db->select_min('id')->from('questions')->where('id', $username)->get()->row();
				
				if(!empty($result)){
					$data['next'] = $result->id;
				}
				$this->show($id);
			}else {
					redirect('main/login');
			} 
		}
		

	
		public function index(){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
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
				$username = $this->session->userdata('username');
				
				$this->session->unset_userdata('category');
				$this->session->unset_userdata('answered_count');
				
				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
					
				$category = '<select name="category" class="form-control">';
					
				$this->db->from('question_categories');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$category .= '<option value="'.$row['category'].'" >'.$row['category'].'</option>';			
					}
				}
				
				$category .= '</select>';
					
				$data['category'] = $category;
				//assign page title name
				$data['pageTitle'] = 'Quiz Start';
				
				//assign page ID
				$data['pageID'] = 'quiz_start';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/quiz_start', $data);	
							
				//load footer
				$this->load->view('account_pages/footer');	
					
			}else {
					$url = 'main/login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
		}
	

		/**
		* Function to handle answer_validation
		*
		*/	        
        public function start() {
			
            if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				$this->load->library('form_validation');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
				$this->form_validation->set_rules('category','Category','required|trim|xss_clean');
				
				$this->form_validation->set_message('required', 'Please select a category!');
				
				if ($this->form_validation->run()){
					
					$category = strtolower($this->input->post('category'));
					
					$session = array(
						'category' => $category,
					);
					$this->session->set_userdata($session);
					
					// Get the id of the first question

					//$res = $this->db->select_min('id')->get('questions')->result_array();

					//$id = $res[0]['id'];
					$id = '';
					if($category == 'all'){
						$result = $this->db->select_min('id')->from('questions')->get()->row();
					
					}else{
						$result = $this->db->select_min('id')->from('questions')->where('LOWER(category)', $category)->get()->row();
					}
					
					if(!empty($result)){
						$id = $result->id;
					}
					$this->show($id, $category);
				}
				else {
					//failed and shows the start page again
					$this->index();
				}		
			}else {
					$url = 'main/login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
        }
		
		public function show($id = -1, $category){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				$category = strtolower($category);	
				$username = $this->session->userdata('username');
					
				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
				
				$detail = '';
				// Select the question
				if($category == 'all'){
					$detail = $this->db->select('*')->from('questions')->where('id', $id)->get()->row();
				}else{
					//$q = $this->db->where(array('id'=>$id))->get('questions')->result_array();
					$detail = $this->db->select('*')->from('questions')->where('id', $id)->where('LOWER(category)', $category)->get()->row();
				}
				
				//$answer = $this->db->select('*')->from('answers')->where('question_id', $id)->get()->row();
				$answer = $this->Answers->get_answer($id);

				if(empty($detail)){
					// Show an error page
					//show_404();
					$this->session->unset_userdata('answered_count');
					
					redirect('quiz/complete');
					
				}
				$data['question_id'] = $detail->id;
				//$data['question'] = $q[0]['question'];
				$data['question'] = $detail->question;
				$option_1 = '<input type="radio" name="answer" id="" value="'.$detail->option_1.'" > '.$detail->option_1;
				$option_2 = '<input type="radio" name="answer" id="" value="'.$detail->option_2.'" > '.$detail->option_2;
				
				$ans = '';
				
				if(!empty($answer)){
					foreach($answer as $a){
						$ans = $a->answer;
					}
					if($ans == $detail->option_1){
						$option_1 = '<input type="radio" name="answer" id="" value="'.$detail->option_1.'"  checked="checked" /> '.$detail->option_1;
					}
					if($ans == $detail->option_2){
							$option_2 = '<input type="radio" name="answer" id="" value="'.$detail->option_2.'"  checked="checked" /> '.$detail->option_2;
					}
				
				}
				
				$data['option_1'] = $option_1;
				$data['option_1_image'] = $detail->option_1_image;
				
				$data['option_2'] = $option_2;
				$data['option_2_image'] = $detail->option_2_image;
				
				// Get the ids of the previous
				// and next questions

				$data['previous'] = 0;
				$data['next'] = 0;
				
				$next = '';
				if($category == 'all'){
					$next = $this->db->select_min('id')->from('questions')->where("id > $id")->get()->row();
				}else{
					//$q = $this->db->where(array('id'=>$id))->get('questions')->result_array();
					$next = $this->db->select_min('id')->from('questions')->where("id > $id")->where('LOWER(category)', $category)->get()->row();
				}
				if(!empty($next)){
				//	$data['next'] = $res[0]['id'];
					$data['next'] = $next->id;
				}

				$previous = '';
				if($category == 'all'){
					$previous = $this->db->select_max('id')->from('questions')->where("id < $id")->get()->row();
				
				}else{
					//$q = $this->db->where(array('id'=>$id))->get('questions')->result_array();
					$previous = $this->db->select_max('id')->from('questions')->where("id < $id")->where('LOWER(category)', $category)->get()->row();
				
				}
				if(!empty($previous)){
					//$data['previous'] = $res[0]['id'];
					$data['previous'] = $previous->id;
				}
				
				
				$answer_count = $this->session->userdata('answered_count');
				
				$question_count = '';
				if($category == 'all'){
					$question_count = $this->Questions->count_all();
				}else{
					//$q = $this->db->where(array('id'=>$id))->get('questions')->result_array();
					$question_count = $this->Questions->count_questions($category);
				}
				$data['question_count'] = $question_count;
				
				$percentage_completed = ($answer_count / $question_count) * 100;
				$percentage_completed = round($percentage_completed);
				//$data['percentage_completed'] = 0;
				$data['percentage_completed'] = $percentage_completed;
				//if($percentage_completed > 0){
				//	$data['percentage_completed'] = $percentage_completed;
				//}
				$data['category'] = $category;
				
				
				//$data['test'] = $this->db->where("id > $id")->count_all('questions');
				/*$res = $this->db->select_min('id')->get('questions')->result_array();

				$first_id = $res[0]['id'];
				
				$test = $this->Questions->current_count($first_id,$id);
				if($test == 0 || $test == null){
					$data['page_count'] = 1;
				}else{
					$data['page_count'] = $test;
				}*/
				//get page count from the
				//number of answered questions
				if($answer_count == 0 || $answer_count == '' || $answer_count == null){
					$data['page_count'] = 1;
				}else{
					$data['page_count'] = $answer_count + 1;
				}
				
				$data['count'] = $this->db->count_all('questions');
				
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
				$data['pageTitle'] = 'Quiz';
									
				//assign page title name
				$data['pageID'] = 'quiz';
											
				//load header and page title
				$this->load->view('account_pages/header', $data);
								
				//load main body
				$this->load->view('account_pages/quiz_page', $data);	
						
				//load footer
				$this->load->view('account_pages/footer');					
					
			}else {
					//$url = 'main/login?redirectURL='.urlencode(current_url());
					//redirect($url);
					redirect('main/login');
			} 
		}


		/**
		* Function to handle answer_validation
		*
		*/	        
        public function answer_validation() {
			
            if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				$this->load->library('form_validation');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
				$this->form_validation->set_rules('answer','Answer','required|trim|xss_clean');
				
				$this->form_validation->set_message('required', 'Please select an answer!');
				
				$id = $this->input->post('question_id');
				$category = strtolower($this->input->post('category'));
				
				if ($this->form_validation->run()){
					
					//check if counter is set
					if($this->session->userdata('answered_count')){
						//get current value
						$answered_count = $this->session->userdata('answered_count');
						
						//add to count
						$new_count = $answered_count + 1;
						
						//set new count
						$session = array(
							'answered_count' => $new_count,
						);
						$this->session->set_userdata($session);
						
					}else{
						//set count
						$session = array(
							'answered_count' => 1,
						);
						$this->session->set_userdata($session);
					}
					
					
					$data = array(				
						'question_id' => $id,
						'question' => $this->input->post('question'),
						'username' => $this->session->userdata('username'),
						'answer' => $this->input->post('answer'),
						'category' => $category,
						'time_answered' => date('Y-m-d H:i:s'),			
					);
					
					if($this->Answers->first_time_answer()){
						
						$this->Answers->insert_answer($data);
					}else{
						
						$this->Answers->update_answer($data, $id);
					}
					$next = 0;
				
					//$get_next = $this->db->select_min('id')->from('questions')->where("id > $id")->where('category', $category)->get()->row();
					$get_next = '';
					if($category == 'all'){
						$get_next = $this->db->select_min('id')->from('questions')->where("id > $id")->get()->row();
					}else{
					//$q = $this->db->where(array('id'=>$id))->get('questions')->result_array();
						$get_next = $this->db->select_min('id')->from('questions')->where("id > $id")->where('LOWER(category)', $category)->get()->row();
					}
					if(!empty($get_next)){
						
						$next = $get_next->id;
						//successful, redirects to next page
						$url = 'quiz/show/'.$next.'/'.$category;
						redirect($url);
					}else{
						$this->session->unset_userdata('answered_count');
						$this->session->unset_userdata('page_count');
						
						//$url = 'quiz/complete/'.$category;
						//redirect($url);
						//set count
						
						redirect('quiz/complete');
					}
					
					
						
				}
				else {
					//failed and shows the question page again
					$this->show($id,$category);
				}		
			}else {
					$url = 'main/login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
        }		
		

	
		public function complete(){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
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
				
				$username = $this->session->userdata('username');
				
				$category = $this->session->userdata('category');
				
				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
				
				$data['answers_array'] = $this->Answers->get_user_answers($username, $category);
				
				$data['category'] = ucwords($category);
				
				$description = 'completed quiz';
				
				$activity = array(
						
						'username' => $username,
						'description' => $description,
						'keyword' => 'Complete',
						'activity_time' => date('Y-m-d H:i:s'),
				);
				$this->Site_activities->insert_activity($activity);
				
				//assign page title name
				$data['pageTitle'] = 'Quiz Complete';
				
				//assign page ID
				$data['pageID'] = 'complete';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/quiz_complete', $data);	
							
				//load footer
				$this->load->view('account_pages/footer');	
					
			}else {
					//$url = 'main/login?redirectURL='.urlencode(current_url());
					//redirect($url);
					redirect('main/login');
			} 		
		}
		
		public function chichi_start(){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
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
				
				$username = $this->session->userdata('username');
				
				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
					
				
				//assign page title name
				$data['pageTitle'] = 'Bonus';
				
				//assign page ID
				$data['pageID'] = 'bonus';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/proposal_start', $data);	
							
				//load footer
				$this->load->view('account_pages/footer');	
					
			}else {
					$url = 'main/login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
		}
	
	
		public function chichi(){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					redirect($redirect);
				}
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
				
				$username = $this->session->userdata('username');

				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);
				
				$data['question'] = 'So, Ms Chituwa Kasiana Mary Chibambo, would you do me the honour of being my wife?';
				
				//assign page title name
				$data['pageTitle'] = 'About Us';
				
				//assign page ID
				$data['pageID'] = 'chichi';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/proposal_page', $data);	
							
				//load footer
				$this->load->view('account_pages/footer');	
					
			}else {
					$url = 'main/login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('main/login');
			} 		
		}

		/**
		* Function to handle answer_validation
		*
		*/	        
        public function chichi_validation() {
			
            if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				$this->load->library('form_validation');
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
				
				$this->form_validation->set_rules('answer','Answer','required|trim|xss_clean');
				
				$this->form_validation->set_message('required', 'Please select an answer!');
				
				
				if ($this->form_validation->run()){
					
					$answer = $this->input->post('answer');
					$data = array(				
						'question' => $this->input->post('question'),
						'username' => $this->session->userdata('username'),
						'answer' => $answer,
						'time_answered' => date('Y-m-d H:i:s'),			
					);
					$this->Answers->insert_proposal_answer($data);
					
					
					if($answer == 'Yes'){
						redirect('quiz/yay');
					}else{
						redirect('quiz/nay');
					}	
				}
				else {
					//failed and shows the question page again
					$this->chichi();
				}		
			}else {
					$url = 'main/login?redirectURL='.urlencode(current_url());
					redirect($url);
					//redirect('home/login/?redirectURL=dashboard');
			} 		
        }		
	
		public function yay(){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
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
				
				$username = $this->session->userdata('username');

				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);

				//assign page title name
				$data['pageTitle'] = 'Hippy Hippy Yay';
				
				//assign page ID
				$data['pageID'] = 'yay';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/proposal_yay', $data);	
							
				//load footer
				$this->load->view('account_pages/footer');	
					
			}else {
					//$url = 'main/login?redirectURL='.urlencode(current_url());
					//redirect($url);
					redirect('main/login');
			} 		
		}
	
		public function nay(){
				 
			if($this->session->userdata('logged_in')){ 
					
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}
				
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
				
				$username = $this->session->userdata('username');

				$data['users'] = $this->Users->get_user($username);

				$data['header_messages_array'] = $this->Users->get_header_messages();
				$data['messages_unread'] = $this->Messages->count_unread_messages($username);

				//assign page title name
				$data['pageTitle'] = 'Nay';
				
				//assign page ID
				$data['pageID'] = 'nay';
				
				//load header and page title
				$this->load->view('account_pages/header', $data);
									
				//load main body
				$this->load->view('account_pages/proposal_nay', $data);	
							
				//load footer
				$this->load->view('account_pages/footer');	
					
			}else {
					//$url = 'main/login?redirectURL='.urlencode(current_url());
					//redirect($url);
					redirect('main/login');
			} 		
		}
				
				








}