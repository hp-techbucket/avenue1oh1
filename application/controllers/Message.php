<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
		
		/**
		* Function for controller
		*  index
		*/	
		public function index(){
			
			if($this->session->userdata('admin_logged_in') || $this->session->userdata('logged_in')){
			
				redirect('message/inbox');

			}else{
				
				redirect('home');	
			}
		}

		
		/***
		* Function to handle messages archive
		* Datatable
		***/
		public function archive_datatable()
		{
			$list = $this->Messages->get_archive_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				
				$textWeight = '';	
				$icon = '';
				$replied = '';
				
				if($message->opened == "0"){		
					$textWeight = 'msgDefault';	
					$icon = '<i class="fa fa-circle"></i>';
				}else{	
					$textWeight = 'msgRead';
					$icon = '<i class="fa fa-circle-o"></i>';
				}
				if($message->replied == "1"){
					$replied = '<i class="fa fa-reply" ></i>';		
				}else{		
					$replied = '';
				}	
				
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$message->id.'">';
				
				$row[] = $message->sender_name;
				
				$row[] = '<span class="messageToggle" style="padding:3px;">
							<a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$message->id.'">'. stripslashes($message->message_subject).'</a>
						</span>
																
						<div class="messageDiv"><br/>'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'
																	<br/><br/><br/>
																</div>';
				
				$row[] = '<small>'.date("d M Y", strtotime($message->date_sent)).'</small>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_archive_all(),
				"recordsFiltered" => $this->Messages->count_filtered_archive(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
				
		
		/***
		* Function to handle messages inbox
		* Datatable
		***/
		public function inbox_datatable()
		{
			$list = $this->Messages->get_inbox_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				
				
				$textWeight = '';	
				$icon = '';
				$replied = '';
				
				if($message->opened == "0"){		
					$textWeight = 'msgDefault';	
					$icon = '<i class="fa fa-circle"></i>';
				}else{	
					$textWeight = 'msgRead';
					$icon = '<i class="fa fa-circle-o"></i>';
				}
				if($message->replied == "1"){
					$replied = '<i class="fa fa-reply" ></i>';		
				}else{		
					$replied = '';
				}	
				$row = array();
			
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$message->id.'">
				'.nbs(5).''.$icon.''.nbs(10).''.$replied;
				//$row[] = $replied;
				
				$row[] = $message->sender_name;
				
				$row[] = '<span class="messageToggle" style="padding:3px;">
							<a href="javascript:void(0)" class="'.$textWeight.'" id="subj_line_'.$message->id.'" onclick="markAsRead('.$message->id.'); ">'. stripslashes($message->message_subject).'</a>
						</span>
																
						<div class="messageDiv">'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'<strong><a data-toggle="modal" data-target="#replyModal" class="btn btn-default" onclick="replyMessage('.$message->id.');" id="'.$message->id.'"><i class="fa fa-reply"></i> Reply</a></strong></div>';
				
				$row[] = '<small>'.date("d M Y", strtotime($message->date_sent)).'</small>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_inbox_all(),
				"recordsFiltered" => $this->Messages->count_filtered_inbox(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
			
		/**
		* Function to display
		* inbox messages
		*/	
		public function inbox(){
										
			if($this->session->userdata('admin_logged_in') || $this->session->userdata('logged_in')){	
			
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				
				if($this->session->userdata('admin_logged_in')){
					$username = $this->session->userdata('admin_username');
					
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
			
				}
				
				if($this->session->userdata('logged_in')){
					$username = $this->session->userdata('username');
					
					$data['user_array'] = $this->Users->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->first_name .' '.$user->last_name;
						}
					}
			
				}
				
				$data['fullname'] = $fullname;
				$data['username'] = $username;
				
				$data['unread_contact_us'] = $this->Contact_us->count_unread_messages();
				
				$messages_unread = $this->Messages->count_unread_messages($username);
				if($messages_unread == '' || $messages_unread == null){
					$data['messages_unread'] = 0;
				}else{
					$data['messages_unread'] = $messages_unread;
				}
				
				$data['header_messages_array'] = $this->Messages->get_header_messages($username);
				
				
				$count_inbox_messages = $this->Messages->count_received_messages($username);
				if($count_inbox_messages == '' || $count_inbox_messages == null){
					$count_inbox_messages = 0;
				}
				$data['count_inbox_messages'] = $count_inbox_messages;
				
				
				$count_sent_messages = $this->Messages->count_sent_messages($username);
				if($count_sent_messages == '' || $count_sent_messages == null){
					$count_sent_messages = 0;
				}
				$data['count_sent_messages'] = $count_sent_messages;
				
				//number of items displayed per page				
				$items_per_page = 10;
				
				if($this->input->post('items_per_page') != ''){
					$items_per_page = $this->input->post('items_per_page');
				}
				
				$result = '';
				$config = array();
				
					$result = $this->db->limit(1)->select('*')->from('messages')->where('receiver_username', $username)->order_by('id','DESC')->get()->row();	
					
					$data['display_option'] = '<strong>Showing All</strong>';
					$config["base_url"] = base_url("message/inbox");
					$config["total_rows"] = $this->Messages->count_received_messages($username);
					$config["per_page"] = $items_per_page;
					$config["uri_segment"] = 3;
					$choice = $config["total_rows"] / $config["per_page"];
					$config["num_links"] = round($choice);
			
					$this->pagination->initialize($config);
						
					if($this->uri->segment(3) > 0)
						$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
					else
						$offset = $this->uri->segment(3);					
								
					//call the model function to get the messages data
					$data['messages_array'] = $this->Messages->get_message($username, $config["per_page"], $offset);	
					
					
					//create pagination links
					$data['pagination'] = $this->pagination->create_links();
				
					
					$data['count'] = $this->Messages->count_received_messages($username);
					$currentPage = floor(($offset/$config['per_page']) + 1); 
					$total = $this->Messages->count_received_messages($username);
					
					$result_start = ($currentPage - 1) * $items_per_page + 1;
					if ($result_start == 0) 
						$result_start= 1; // *it happens only for the first run*
						
					$result_end = $result_start + $items_per_page - 1;

					if ($result_end < $items_per_page)   // happens when records less than per page  
						$result_end = $items_per_page;  
					else if ($result_end > $total)  // happens when result end is greater than total records  
						$result_end = $total;
					if($total == 0){
						//display current page and no of pages
						$data['current'] = "";
					}else{
						//display current page and no of pages
						$data['current'] = "Displaying ".$result_start.' to '.$result_end.' of '.$total;
					}	
					
												
				
				$data['result'] = $result;
				
				if(!empty($result)){
					
					$this->mark_as_read($result->id);
				
					$data['message_id'] = $result->id;
					$data['sender_name'] = $result->sender_name;
					$data['sender_username'] = $result->sender_username;
					$data['message_subject'] = $result->message_subject;
					$data['message_details'] = $result->message_details;
					$data['message_date'] = date("F j, Y", strtotime($result->date_sent)); 
				}
				
				//assign page title name
				$data['pageTitle'] = 'Inbox';
				
				//assign page ID
				$data['pageID'] = 'inbox';
				
				
				
				if($this->session->userdata('admin_logged_in')){
					
					//load header
					$this->load->view('admin_pages/header', $data);
				
					//load main body
					$this->load->view('admin_pages/inbox_page', $data);
				
					//load main footer
					$this->load->view('admin_pages/footer');
				
				}
				
				if($this->session->userdata('logged_in')){
					
					//load header
					$this->load->view('account_pages/header', $data);
				
					//load main body
					$this->load->view('account_pages/inbox_page', $data);
				
					//load main footer
					$this->load->view('account_pages/footer');
				
				}
												
								
			}else{
				redirect('home');
			}	
		}		
	

		
		/**
		* Function to handle
		* ajax inbox search
		* display
		*/	
		public function inbox_search(){
			
			$username = '';
			if($this->session->userdata('admin_logged_in')){
				$username = $this->session->userdata('admin_username');
			}else{
				$username = $this->session->userdata('username');
			}
			
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the search values
			$search =  html_escape($this->input->post('search'));
			$search = trim($search);
				
			$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
			
			$count = $this->Messages->count_search($search);
			if($count == '' || $count == null){
				$count = 0;
			}
				
			$data['count'] = $count;
			//number of items displayed per page				
			$items_per_page = 10;
				
			if($this->input->post('items_per_page') != ''){
				$items_per_page = html_escape($this->input->post('items_per_page'));
				$items_per_page = preg_replace('#[^0-9]#i', '', $items_per_page); // filter everything but numbers
			
			}
							
			
			$data['display_option'] = 'Showing '.$count.' results for "<strong><em>'.$search.'</em></strong>" <a href="'.base_url("message/inbox").'"  >Show All</a>';
			if($count == 1){
				$data['display_option'] = 'Showing 1 result for "<strong><em>'.$search.'</em></strong>" <a href="'.base_url("message/inbox").'"  >Show All</a>';
			}			
			
			$config["base_url"] = base_url("message/inbox");
			$config["total_rows"] = $count;
			$config["per_page"] = $items_per_page;
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
					
			$this->pagination->initialize($config);
						
			if($this->uri->segment(3) > 0)
				$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
			else
				$offset = $this->uri->segment(3);					
					
			$messages_array = $this->Messages->get_search($search, $config['per_page'], $offset);

			
			$messages_display = '';
			
			if($messages_array){
					
					
				//create pagination links
				$data['pagination'] = $this->pagination->create_links();
					
				$total = $count;
				$currentPage = floor(($offset/$config['per_page']) + 1); 
				$result_start = ($currentPage - 1) * $items_per_page + 1;
				if ($result_start == 0) 
					$result_start= 1; // *it happens only for the first run*
							
				$result_end = $result_start + $items_per_page - 1;

				if ($result_end < $items_per_page)   // happens when records less than per page  
					$result_end = $items_per_page;  
				else if ($result_end > $total)  // happens when result end is greater than total records  
					$result_end = $total;
							
				//display current page and no of pages
				$data['current'] = "Showing ".$result_start.' to '.$result_end.' of '.$total;
				
				foreach($messages_array as $message){
					
					
					//check if message has been read
					if($message->opened == "0"){		
						$textWeight = 'msgDefault';	
						$icon = '<i class="fa fa-circle"></i>';
					}else{	
						$textWeight = 'msgRead';
						$icon = '<i class="fa fa-circle-o"></i>';
					}			

					//check if message has been replied
					if($message->replied == "1"){
						$replied = '<i class="fa fa-reply" aria-hidden="true"></i>';		
					}else{		
						$replied = '';
					}	
					$messages_display .= '<tr>';
					$messages_display .= '<td><input type="checkbox"name="cb[]" id="cb" value="'.$message->id.'"></td>
					<td><i class="fa fa-reply" aria-hidden="true"></i></td>
					<td>'. $message->sender_name.'</td>';
					$messages_display .= '<td class="mailbox-subject">';
					$messages_display .= '<span class="messageToggle" style="padding:3px;">
					<a href="javascript:void(0)" class="'. $textWeight.'" id="subj_line_'. $message->id.'" onclick="markAsRead('. $message->id.'); ">'.stripslashes($message->message_subject).'</a>
																</span>';
					$messages_display .= '<div class="messageDiv"><br/>'. 
																	stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'
					<br/><br/>
					<strong> 
					<a data-toggle="modal" data-target="#replyModal" class="btn btn-default reply_message"  id="'. $message->id.'"><i class="fa fa-reply"></i> Reply</a></strong>
																</div>';
					$messages_display .= '</td>';
					$messages_display .= '<td class="mailbox-date"><small>'. date("F j, Y", strtotime($message->date_sent)).'</small></td>';
					$messages_display .= '</tr>';
					
				}
					
				$data['messages_display'] = $messages_display;
				$data['success'] = true;
				
			
			}else{
				
				$messages_display .= '<td colspan="5"><div class="alert alert-default text-center notif" role="alert"><i class="fa fa-ban"></i> There are no messages matching your search!</div></td>';
				
				$data['messages_display'] = $messages_display;
				
				$data['display_option'] = 'Showing 0 results for "<strong><em>'.$search.'</em></strong>" <a href="'.base_url("message/inbox").'"  >Show All</a>';
				
				$data['pagination'] = '';
				$data['current'] = "";
				
				$data['count'] = 0;
				$data['success'] = false;
				
			}

			echo json_encode($data);
			
		}		
				
			
		/***
		* Function to handle messages sent
		* Datatables
		***/
		public function sent_datatable()
		{
			$list = $this->Messages->get_sent_datatables();
			$data = array();
			$no = $_POST['start'];
			
			foreach ($list as $message) {
				$no++;
				$row = array();
				$row[] = '<input type="checkbox" name="cb[]" id="cb" onclick="enableButton(this)" value="'.$message->id.'">
				'.nbs(15).'<i class="fa fa-reply" aria-hidden="true"></i>';
				
				//$row[] = '';
				
				$row[] = $message->receiver_name;
				
				$row[] = '<span class="messageToggle" style="padding:3px;">
							<a href="javascript:void(0)" class="msgRead" id="subj_line_'.$message->id.'">'. stripslashes($message->message_subject).'</a>
							</span>
																
							<div class="messageDiv"><br/>'.stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'
																	<br/><br/><br/>
																</div>';
				
				$row[] = '<small>'.date("F j, Y", strtotime($message->date_sent)).'</small>';
				
				$data[] = $row;
			}
	 
			$output = array(
				
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Messages->count_sent_all(),
				"recordsFiltered" => $this->Messages->count_filtered_sent(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
					
		/**
		* Function to display
		* sent messages
		*/				
		public function sent(){
			
			if($this->session->userdata('admin_logged_in') || $this->session->userdata('logged_in')){
				
				//check if redirect url is set
				$redirect = '';
				if($this->session->flashdata('redirectURL')){
					$redirect = $this->session->flashdata('redirectURL');
					//redirect user to previous url
					//$url = 'account/'.$redirect;
					redirect($redirect);
				}	
				
				$username = '';
				if($this->session->userdata('admin_logged_in')){
					$username = $this->session->userdata('admin_username');
					
					$data['user_array'] = $this->Admin->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->admin_name;
						}
					}
			
				}
				
				if($this->session->userdata('logged_in')){
					$username = $this->session->userdata('username');
					
					$data['user_array'] = $this->Users->get_user($username);
					
					$fullname = '';
					if($data['user_array']){
						foreach($data['user_array'] as $user){
							$fullname = $user->fname .' '.$user->mname .' '.$user->lname;
						}
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
				
				
				$count_inbox_messages = $this->Messages->count_received_messages($username);
				if($count_inbox_messages == '' || $count_inbox_messages == null){
					$count_inbox_messages = 0;
				}
				$data['count_inbox_messages'] = $count_inbox_messages;
				
				
				$count_sent_messages = $this->Messages->count_sent_messages($username);
				if($count_sent_messages == '' || $count_sent_messages == null){
					$count_sent_messages = 0;
				}
				$data['count_sent_messages'] = $count_sent_messages;
				
				//number of items displayed per page				
				$items_per_page = 10;
				
				if($this->input->post('items_per_page') != ''){
					$items_per_page = $this->input->post('items_per_page');
				}
				
				$result = '';
				$config = array();
					
				$data['display_option'] = '<strong>Showing All</strong>';
					
					$config["base_url"] = base_url()."message/sent";
					$config["total_rows"] = $count_sent_messages;
					$config["per_page"] = $items_per_page;
					$config["uri_segment"] = 3;
					$choice = $config["total_rows"] / $config["per_page"];
					$config["num_links"] = round($choice);
		
					$this->pagination->initialize($config);
						
					if($this->uri->segment(3) > 0)
						$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
					else
						$offset = $this->uri->segment(3);					
							
					$data['messages_array'] = $this->Messages->get_sent_messages($username, $config["per_page"], $offset);	
					
					$total = $count_sent_messages;
					$currentPage = floor(($offset/$config['per_page']) + 1);
					$result_start = ($currentPage - 1) * $items_per_page + 1;
					if ($result_start == 0) 
						$result_start= 1; // *it happens only for the first run*
					
					$result_end = $result_start + $items_per_page - 1;

					if ($result_end < $items_per_page)   // happens when records less than per page  
						$result_end = $items_per_page;  
					else if ($result_end > $total)  // happens when result end is greater than total records  
						$result_end = $total;
					
					//display current page and no of pages
					if($total >= 1){
						//display current page and no of pages
						$data['current'] = "Displaying ".$result_start.' to '.$result_end.' of '.$total;
					}else{
						$data['current'] = "";
					}					
				
				//create pagination links
				$data['pagination'] = $this->pagination->create_links();
				
				
				
				//load header and page title
				//assign page title name
				$data['pageTitle'] = 'Sent';
				
				//assign page ID
				$data['pageID'] = 'sent';
				
				
				if($this->session->userdata('admin_logged_in')){
					
					//load header
					$this->load->view('admin_pages/header', $data);
				
					//load main body
					$this->load->view('admin_pages/sent_page', $data);
				
					//load main footer
					$this->load->view('admin_pages/footer');
				
				}
				
				if($this->session->userdata('logged_in')){
					
					//load header
					$this->load->view('account_pages/header', $data);
				
					//load main body
					$this->load->view('account_pages/sent_page', $data);
				
					//load main footer
					$this->load->view('account_pages/footer');
				
				}
				
			}else{
				
				redirect('home');
			}	
		}	

	
		
		/**
		* Function to handle
		* ajax sent search
		* display
		*/	
		public function sent_search(){
			
			$username = '';
			if($this->session->userdata('admin_logged_in')){
				$username = $this->session->userdata('admin_username');
			}else{
				$username = $this->session->userdata('username');
			}
			
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the search values
			$search =  html_escape($this->input->post('search'));
			$search = trim($search);
				
			$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
			
			$data['count_sent_messages'] = $this->Messages->count_search_sent($search, $username);
		
			$count = $this->Messages->count_search_sent($search, $username);
		
			if($count == '' || $count == null){
				$count = 0;
			}
				
			$data['count'] = $count;
			//number of items displayed per page				
			$items_per_page = 10;
				
			if($this->input->post('items_per_page') != ''){
				$items_per_page = html_escape($this->input->post('items_per_page'));
				$items_per_page = preg_replace('#[^0-9]#i', '', $items_per_page); // filter everything but numbers
			
			}
			
			$data['display_option'] = 'Showing '.$count.' results for "<strong><em>'.$search.'</em></strong>" <a href="'.base_url("message/sent").'"  >Show All</a>';
			if($count == 1){
				$data['display_option'] = 'Showing 1 result for "<strong><em>'.$search.'</em></strong>" <a href="'.base_url("message/sent").'"  >Show All</a>';
			}			
			
						
			$config["base_url"] = base_url("message/sent");
			$config["total_rows"] = $count;
			$config["per_page"] = $items_per_page;
			$config["uri_segment"] = 3;
			$choice = $config["total_rows"] / $config["per_page"];
			$config["num_links"] = round($choice);
					
			$this->pagination->initialize($config);
						
			if($this->uri->segment(3) > 0)
				$offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
			else
				$offset = $this->uri->segment(3);					
					
			$messages_array = $this->Messages->get_search_sent($username, $search, $config["per_page"], $offset);

			
			$messages_display = '';
			
			if($messages_array){
					
					
				//create pagination links
				$data['pagination'] = $this->pagination->create_links();
					
				$total = $count;
				$currentPage = floor(($offset/$config['per_page']) + 1); 
				$result_start = ($currentPage - 1) * $items_per_page + 1;
				if ($result_start == 0) 
					$result_start= 1; // *it happens only for the first run*
							
				$result_end = $result_start + $items_per_page - 1;

				if ($result_end < $items_per_page)   // happens when records less than per page  
					$result_end = $items_per_page;  
				else if ($result_end > $total)  // happens when result end is greater than total records  
					$result_end = $total;
							
				//display current page and no of pages
				$data['current'] = "Showing ".$result_start.' to '.$result_end.' of '.$total;
				
				foreach($messages_array as $message){
					
					
					$textWeight = 'msgRead';
					$icon = '<i class="fa fa-circle-o"></i>';
					$replied = '<i class="fa fa-reply" aria-hidden="true"></i>';
					
					
					$messages_display .= '<tr>';
					$messages_display .= '<td><input type="checkbox"name="cb[]" id="cb" value="'.$message->id.'"></td>
																<td><i class="fa fa-reply" aria-hidden="true"></i></td>
																<td>'. $message->sender_name.'</td>';
					$messages_display .= '<td class="mailbox-subject">';
					$messages_display .= '<span class="messageToggle" style="padding:3px;">
																<a href="javascript:void(0)" class="'. $textWeight.'" id="subj_line_'. $message->id.'" >'.stripslashes($message->message_subject).'</a>
																</span>';
					$messages_display .= '<div class="messageDiv"><br/>'. 
																	stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)).'
																	<br/><br/>
																	
																</div>';
					$messages_display .= '</td>';
					$messages_display .= '<td class="mailbox-date"><small>'. date("F j, Y", strtotime($message->date_sent)).'</small></td>';
					$messages_display .= '</tr>';
					
				}
					
				$data['messages_display'] = $messages_display;
				$data['success'] = true;
				
			
			}else{
				
				$messages_display .= '<td colspan="5"><div class="alert alert-default text-center notif" role="alert"><i class="fa fa-ban"></i> There are no messages matching your search!</div></td>';
				
				$data['messages_display'] = $messages_display;
				
				$data['display_option'] = 'Showing 0 results for "<strong><em>'.$search.'</em></strong>" <a href="'.base_url("message/inbox").'"  >Show All</a>';
				
				$data['pagination'] = '';
				$data['current'] = "";
				
				$data['count'] = 0;
				$data['success'] = false;
				
			}

			echo json_encode($data);
			
		}		
			
			
			
		/**
		* Function to handle display
		* message preview and
		* reply message
		*/	
		public function detail(){
			
			$username = $this->session->userdata('username');

			$detail = $this->db->select('*')->from('messages')->where('id',$this->input->post('id'))->get()->row();
			
			$id = $this->input->post('id');

			if($detail){

				//$this->db->where('message_id',$this->input->post('id'))->update('messages',array('opened'=>'0'));
				
				//$this->mark_as_read($id);
				$update = array(
					'opened' => '1',
				);
				$this->db->where('id', $id);
				$query = $this->db->update('messages', $update);
					
				$data['id'] = $detail->id;
				$data['name'] = $detail->sender_name;
				$data['username'] = $detail->sender_username;
				$data['subject'] = $detail->message_subject;
				$data['message'] = $detail->message_details;
				$data['date_sent'] = date("F j, Y", strtotime($detail->date_sent)); 
				
				//$data['update_count_message'] = $this->db->where('opened','0')->count_all_results('message');
				$count = $this->Messages->count_unread_messages($detail->receiver_username);
				//$data['count_unread'] = "'".$count."'";
				if($count == '' || $count == null){
					$count = 0;
				}
				$data['count_unread'] = $count;
				$data['success'] = true;
				
				//handle reply requests
					$data['receiver_name'] = $detail->sender_name;
					$data['receiver_username'] = $detail->sender_username;
					$data['sender_name'] = $detail->receiver_name;
					$data['sender_username'] = $detail->receiver_username;
					$data['message_subject'] = 'Re: '.$detail->message_subject;
					
					//handle default reply box content
					$Sname = $detail->receiver_name;
					$Rname = $detail->sender_name;
					
					//message content default display
					$message_content = '';
					
					$message_content .= '<br/><br/>';
					$message_content .= $detail->message_details;
					$message_content .= '-----------------------------------------------------------------------------------------------';
					$message_content .= '<br/><br/>';
					$message_content .= '<br/><br/>';
					$breaks = array("<br />","<br>","<br/>");  
					$message_content = str_ireplace($breaks, "\r\n", $message_content); 
					/*$message_content .= '<br/>';
					$message_content .= '<br/>';
					$message_content .= '-----------------------------------------------------------------------------------------------<br/>';
					$message_content .= 'From: '.$Rname.' <'.$detail->sender_username.'><br/>';
					$message_content .= 'To: '.$Sname.' <'.$detail->receiver_username.'><br/>';
					$message_content .= 'Sent: '.date("F j, Y, g:i a", strtotime($detail->date_sent)) .'<br/>';
					$message_content .= 'Subject: '.$detail->message_subject.'<br/>';
					$message_content .= '<br/><br/>';
					$message_content .= $detail->message_details;
					$message_content .= '<br/><br/>';
					$message_content .= '-----------------------------------------------------------------------------------------------';
					
					
					$breaks = array("<br />","<br>","<br/>");  
					$message_content = str_ireplace($breaks, "\r\n", $message_content); 
					*/				
					
					$data['message_details'] = $message_content;
					$data['replying_to'] = '<strong>Replying to:</strong> '.$Rname;
					$data['email_to'] = '<strong>Email To:</strong> '.$Rname.' ('.$detail->sender_username.')';
					$data['message_id'] = $detail->id;
					$data['headerTitle'] = 'Re: '.$detail->message_subject;			

			} else {
				$data['success'] = false;
			}
			echo json_encode($data);
					
		}
	
	
		/**
		* Function to mark messages
		* as read 
		*/	
		public function mark_as_read(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			//escaping the post values
			$message_id = html_escape($this->input->post('message_id'));
			$id = preg_replace('#[^0-9]#i', '', $message_id); // filter everything but numbers
			
			$update = array(
				'opened' => '1',
			);
			$this->db->where('id', $id);
			$query = $this->db->update('messages', $update);
			if($query){
				$username = $this->session->userdata('username');
				if($this->session->userdata('admin_logged_in')){
					$username = $this->session->userdata('admin_username');
				}
			
				$data['count_unread_messages'] = $this->Messages->count_unread_messages($username);
				$data['success'] = true;
			}
			
			//echo json_encode($data);
			
		}



		/**
		* Function to handle new compose
		* 
		* 
		*/	
		public function new_message_detail(){
			
			
			$message_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $message_id); // filter everything but numbers
			
			$model = html_escape($this->input->post('model'));
			
			
			//initialise variables
			$user_array = '';
			$sender_name = '';
			$sender_username = '';
			$receiver_name = '';
			$receiver_username = ''; 
			
			//check if admin loggedin
			if($this->session->userdata('admin_logged_in')){
				
				$username = $this->session->userdata('admin_username');
				$user_array = $this->Admin->get_user($username);
				if($user_array){
					foreach($user_array as $user){
						$sender_name = $user->admin_name;
						$sender_username = $user->admin_username;
					}
				}
			}
			
			//check if user loggedin
			if($this->session->userdata('logged_in')){
				
				$username = $this->session->userdata('username');
				$user_array = $this->Users->get_user($username);
				if($user_array){
					foreach($user_array as $user){
						$sender_name = $user->fname .' '.$user->mname .' '.$user->lname;
						$sender_username = $username;
					}
				}
			}
			
			$detail = $this->db->select('*')->from($model)->where('id',$id)->get()->row();
			
			if($detail){
				
				if($model == 'admin_users'){
					$receiver_name = $detail->admin_name;
					$receiver_username = $detail->admin_username; 
				}
				if($model == 'users'){
					$receiver_name = $detail->fname .' '.$detail->mname .' '.$detail->lname;
					$receiver_username = $detail->username; 
				}
			}
			if($receiver_username != $username){
				
				$data['email_to'] = $receiver_name.' ('.$receiver_username.')';
					
				$data['messageTitle'] = 'Send Message To '.$receiver_name;
				$data['sender_name'] = $sender_name;
				$data['sender_username'] = $sender_username;
				$data['receiver_name'] = $receiver_name;
				$data['receiver_username'] = $receiver_username;
				$data['model'] = $model;

				$data['success'] = true;
			
			} else {
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> You can\'t email that user!</div>';
				$data['success'] = false;
			}
			echo json_encode($data);
					
		}


		/**
		* Function to validate replied
		* message
		*/	
		public function reply_message(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
            $this->form_validation->set_rules('sender_name','Sender Name','required|trim|xss_clean');
			$this->form_validation->set_rules('sender_username','Sender Username','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_name','Receiver Name','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_username','Receiver Username','required|trim|xss_clean');
			$this->form_validation->set_rules('message_subject','Subject','required|trim|xss_clean');
			$this->form_validation->set_rules('message_details','Message','required|trim|xss_clean');
		
			$this->form_validation->set_message('required', 'Please enter a %s!');
			
			$id = $this->input->post('message_id');
			
			if ($this->form_validation->run()){
		
				//array of all post variables
				$message_data = array(
					'sender_name' => $this->input->post('sender_name'),
					'sender_username' => $this->input->post('sender_username'),
					'receiver_name' => $this->input->post('receiver_name'),
					'receiver_username' => $this->input->post('receiver_username'),
					'message_subject' => $this->input->post('message_subject'),
					'message_details' => $this->input->post('message_details'),
					'opened' => '0',
					'recipient_archive' => '0',
					'sender_archive' => '0',
					'replied' => '0',
					'date_sent' => date('Y-m-d H:i:s'),
				);
				
				if($this->Messages->reply_message($message_data)){
					
					
					//store info in address book
					$username = $this->input->post('sender_username');
					$receiver_name = $this->input->post('receiver_name');
					$receiver_username = $this->input->post('receiver_username');
					
					//count users sent messages
					$data['count_sent_messages'] = $this->Messages->count_sent_messages($username);
				
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your reply has been sent!</div>';
				
					}else {
						//redirects to contact us page
						//$this->contact_us();	
						$data['success'] = false;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Reply not sent! Add to db issue</div>';
						
					}
					
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Reply not sent!</div>';
				$data['errors'] = '<div class="alert alert-danger text-center" role="alert">'.validation_errors().'</div>';
			}
			echo json_encode($data);
		}

		
		/**
		* Function to prevent user from posting
		* same message within a few seconds
		*/			
		public function prevent_double_post($username){

			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('sender_username', $username);
			
			$this->db->where("date_sent BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				return true;
			}else {
				return false;
			}	
								
		}		
		
		
		/**
		* Function to validate
		* new message sent
		*/	
		public function new_message_validation(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('sender_name','Sender Name','required|trim|xss_clean');
			$this->form_validation->set_rules('sender_username','Sender Username','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_name','Receiver Name','required|trim|xss_clean');
			$this->form_validation->set_rules('receiver_username','Receiver Username','required|trim|xss_clean');
			$this->form_validation->set_rules('message_subject','Subject','required|trim|xss_clean');
			$this->form_validation->set_rules('message_details','Message','required|trim|xss_clean|callback_check_double_messaging');
		
			$this->form_validation->set_message('required', 'Please enter a %s!');
			$this->form_validation->set_message('min_length', '%s is too short!');
			
			if ($this->form_validation->run()){
				
				//store info in address book
				$username = $this->input->post('sender_username');
				$receiver_name = $this->input->post('receiver_name');
				$receiver_username = $this->input->post('receiver_username');

				//array of all post variables
				$message_data = array(
					'sender_name' => $this->input->post('sender_name'),
					'sender_username' => $this->input->post('sender_username'),
					'receiver_name' => $this->input->post('receiver_name'),
					'receiver_username' => $this->input->post('receiver_username'),
					'message_subject' => $this->input->post('message_subject'),
					'message_details' => $this->input->post('message_details'),
					'opened' => '0',
					'recipient_archive' => '0',
					'sender_archive' => '0',
					'replied' => '0',
					'date_sent' => date('Y-m-d H:i:s'),
				);
				
				if($this->Messages->send_new_message($message_data)){
					
					//count users sent messages
					$data['count_sent_messages'] = $this->Messages->count_sent_messages($username);
				
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your message has been sent!</div>';
				
				}
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert">'.validation_errors().'</div>';
			}
			echo json_encode($data);
		}
		
		
		/**
		* Function to validate
		* new message sent
		*/	
		public function bulk_message_validation(){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_error_delimiters('<div class="text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ', '</div>');
			
            $this->form_validation->set_rules('sender_name','Sender Name','required|trim|xss_clean');
			$this->form_validation->set_rules('sender_username','Sender Username','required|trim|xss_clean');
			
			$this->form_validation->set_rules('message_subject','Subject','required|trim|xss_clean');
			$this->form_validation->set_rules('message_details','Message','required|trim|xss_clean|callback_check_double_messaging');
			$this->form_validation->set_rules('model','Model','required|trim|xss_clean');
		
			$this->form_validation->set_message('required', 'Please enter a %s!');
			$this->form_validation->set_message('min_length', '%s is too short!');
			
			if ($this->form_validation->run()){
				
				//initialise variables
				$success = false;
				$recipients_array = '';
				
				//get model name
				$model = $this->input->post('model');
				if($model == 'team_members'){
					//get all from db
					$recipients_array = $this->Team_members->get_all_members();
				}
				
				if($model == 'clients'){
					//get all from db
					$recipients_array = $this->Clients->get_all_clients();
				}
				
				//check if array not empty
				if($recipients_array){
					
					//loop through array and send mail to each
					foreach($recipients_array as $recipient){
						
						//get receivers details for message db
						$receiver_name = $recipient->first_name .' '.$recipient->last_name;
						$receiver_username = $recipient->username;
						
						//array of all post variables
						$message_data = array(
							'sender_name' => $this->input->post('sender_name'),
							'sender_username' => $this->input->post('sender_username'),
							'receiver_name' => $receiver_name,
							'receiver_username' => $receiver_username,
							'message_subject' => $this->input->post('message_subject'),
							'message_details' => $this->input->post('message_details'),
							'opened' => '0',
							'recipient_archive' => '0',
							'sender_archive' => '0',
							'replied' => '0',
							'date_sent' => date('Y-m-d H:i:s'),
						);
						
						//save to messages table
						if($this->Messages->send_new_message($message_data)){
							
									
							//store info in address book
							$username = $this->input->post('sender_username');
							$receiver_name = $this->input->post('receiver_name');
							$receiver_username = $this->input->post('receiver_username');

							if($this->Address_book->unique_address($username,$receiver_name,$receiver_username)){
								
								$address_data = array(
									'sender_username' => $username,
									'receiver_name' => $receiver_name,
									'receiver_username' => $receiver_username,
									'date_added' => date('Y-m-d H:i:s'),
								);
								
								$this->Address_book->add_address($address_data);
							}	
							
							$success = true;
							
						}
						
						
					}
					
					if($success){
						$data['success'] = $success;
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Your messages have been sent!</div>';
					}else{
						$data['success'] = $success;
						$data['notif'] = '<div class="alert alert-danger text-center" role="alert"> <i class="fa fa-exclamation-triangle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error sending messages!</div>';
					}
				
				}
				
			}else {
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-center" role="alert">'.validation_errors().'</div>';
			}
			echo json_encode($data);
		}
				
		
		/**
		* Function to check_double_post 
		* 
		*/			
		public function check_double_messaging($username){
			
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-20 second", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('sender_username', $username);
			
			$this->db->where("date_sent BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if ($query->num_rows() >= 1){	
				$this->form_validation->set_message('check_double_messaging', 'You must wait at least 20 seconds before you send another message!');
				return FALSE;
			}else {
				
				return TRUE;
			}	
		}	
		
		
		/**
		* Function to check if the user has sent
		*  too many messages in 24 hours
		*/			
		public function max_sent_messages(){
			
			//obtain users username
			$username = '';
			if($this->session->userdata('admin_logged_in')){
				$username = $this->session->userdata('admin_username');
			}
			//check if user logged in
			if($this->session->userdata('logged_in')){
				$username = $this->session->userdata('username');
			}
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('sender_username', $username);
			
			$this->db->where("date_sent BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			//get admin username array
			$admin_usernames = $this->Admins->get_all_usernames();
			
			//get team members username array
			$member_usernames = $this->Users->get_all_usernames();
			
			if ($query->num_rows() < 20){	
				return TRUE;	
			}
			//else if(in_array(strtolower($username), $admin_usernames) || in_array(strtolower($username), $member_usernames)){
				//return TRUE;
			else {	
				$this->form_validation->set_message('max_sent_messages', 'You can\'t send any more messages. Your have surpassed the allowed quota in 24 hours! Please contact Customer Service!');
				return FALSE;
			}
		}	
	
				
			
		
		/**
		* Function to delete
		* multiple messages
		*/			
		public function multi_delete() {
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			if($this->input->post('deleteBtn') != ''){
						
				$data = array(
					'recipient_archive' => '1',
				);
				
				//get checked items from post
				$checked_messages =  html_escape($this->input->post('cb'));
				//$checked_messages = $this->input->post('cb');		
				
				$this->db->where_in('id', $checked_messages);
				$query = $this->db->update('messages', $data);	
						
				if($query){
							
					$count = count($checked_messages);
					
					if($count == 1){
						//$this->session->set_flashdata('message_deleted', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>');
								
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>';
					}else{
						//$this->session->set_flashdata('archived', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>');
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>';

					}
							
					$data['success'] = true;
					
				}else{
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Delete Error!</div>';
					$data['success'] = false;
				}
												
				//redirect('account/messages/','refresh');
			}
			
			if($this->input->post('deleteSent') != ''){
						
				$data = array(
					'sender_archive' => '1',
				);
				
				//get checked items from post
				$checked_messages =  html_escape($this->input->post('cb'));
				//$checked_messages = $this->input->post('cb');
				$this->db->where_in('id', $checked_messages);
				$query = $this->db->update('messages', $data);	
						
				if($query){
					$count = count($checked_messages);
					if($count == 1){
						//$this->session->set_flashdata('archived', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>');
								
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' message has been archived!</div>';
								
					}else{
						//$this->session->set_flashdata('message_deleted', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".commentDiv").fadeOut("slow"); }, 5000);</script><div class="commentDiv alert alert-success text-center"><i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>');
								
						$data['notif'] = '<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' messages have been archived!</div>';
					}
				}else{
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Delete Error!</div>';
					$data['success'] = false;
				}
						//redirect('message/sent_messages/','refresh');
			}				
				
			echo json_encode($data);
        }		
					
		
		/**
		* Function to archive
		* multiple messages
		*/			
		public function multi_archive(){
			
			
			if($this->input->post('cb') != '' && $this->input->post('table')== 'inbox' )
			{
				$username = $this->session->userdata('username');
				
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				//check if message has been read
				$unread = $this->Messages->check_for_unread('0',$checked);
				//$this->db->where_in('id', $checked);
				//$this->db->where('opened', '0');
				//$q = $this->db->get('messages');
				
				if(!$unread){
					
					$update = array(
						'recipient_archive' => '1',
					);
					
					$this->db->where_in('id', $checked);
					$query = $this->db->update('messages', $update);	
							
					if($query){
						$count = count($checked);
						$message = '';
						if($count == 1){
							$message = $count.' message has been archived!';
							
						}else{
							$message = $count.' messages have been archived!';
						}
						
						//get current inbox count
						$count_inbox_messages = $this->Messages->count_unread_messages($username);
						if($count_inbox_messages == '' || $count_inbox_messages == null){
							$data['count_inbox_messages'] = 0;
						}else{
							$data['count_inbox_messages'] = $count_inbox_messages;
						}
						
						//get current archive count
						$count_archive_messages = $this->Messages->count_archive_messages($username);
						if($count_archive_messages == '' || $count_archive_messages == null){
							$data['count_archive_messages'] = 0;
						}else{
							$data['count_archive_messages'] = $count_archive_messages;
						}	
						$data['table'] = 'inbox';
						
						$data['success'] = true;
						$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i> '.$message.'</div>';
					}
					
				}else{
					$data['success'] = false;
					$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-ban"></i> You can\'t archive unread message(s)!</div>';
				}
				
				
				
			}
			
			echo json_encode($data);
		}
			
		
		/**
		* Function to archive
		* multiple messages
		*/			
		public function sent_archive(){
			
			if($this->input->post('cb') != '' && $this->input->post('table')== 'sent' )
			{
				$username = $this->session->userdata('username');
				
				//get checked items from post
				$checked =  html_escape($this->input->post('cb'));
				
				$update = array(
					'sender_archive' => '1',
				);
				
				$this->db->where_in('id', $checked);
				$query = $this->db->update('messages', $update);	
						
				if($query){
					$count = count($checked);
					$message = '';
					if($count == 1){
						$message = $count.' message has been deleted!';
						
					}else{
						$message = $count.' messages have been deleted!';
					}
					
					//get current sent count
					$count_sent_messages = $this->Messages->count_sent_messages($username);
					if($count_sent_messages == '' || $count_sent_messages == null){
						$data['count_sent_messages'] = 0;
					}else{
						$data['count_sent_messages'] = $count_sent_messages;
					}
					
					$data['table'] = 'sent';
					
					$data['success'] = true;
					$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i> '.$message.'</div>';
				}
				
				
			}
			else{
				//$url = current_url();
				//redirect($url);
				$data['success'] = false;
				$data['notif'] = '<div class="alert alert-danger text-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-ban"></i> Can\'t delete message(s)!</div>';
			}
			
			echo json_encode($data);
		}
											
		
		/**
		* Function to move multiple archive 
		* messages back to inbox
		*/			
		public function move_to_inbox() {
			
			
			if($this->input->post('cb') != '' && $this->input->post('table') == 'archives'){
						
				$username = $this->session->userdata('username');
				
				//escaping the post values
				$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
				
			
				//get checked items from post
				$checked_messages =  html_escape($this->input->post('cb'));
				//$checked_messages = $this->input->post('cb');		
				
				$update = array(
					'recipient_archive' => '0',
				);
				
				$this->db->where_in('id', $checked_messages);
				$query = $this->db->update('messages', $update);	
						
				if($query){
							
					$count = count($checked_messages);
					
					if($count == 1){
						
						$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' message has been moved to your inbox!</div>';
					}else{
						$data['notif'] = '<div class="alert alert-success text-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i>'.$count.' messages  has been moved to your inbox!</div>';

					}
							
					$data['success'] = true;
					
					//get current inbox count
					$count_inbox_messages = $this->Messages->count_unread_messages($username);
					if($count_inbox_messages == '' || $count_inbox_messages == null){
						$data['count_inbox_messages'] = 0;
					}else{
						$data['count_inbox_messages'] = $count_inbox_messages;
					}
					
					//get current archive count
					$count_archive_messages = $this->Messages->count_archive_messages($username);
					if($count_archive_messages == '' || $count_archive_messages == null){
						$data['count_archive_messages'] = 0;
					}else{
						$data['count_archive_messages'] = $count_archive_messages;
					}	
					
					
				}else{
					$data['notif'] = '<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Delete Error!</div>';
					$data['success'] = false;
				}
												
				//redirect('account/messages/','refresh');
			}				
				
			echo json_encode($data);
        }		
					
		
		
		
		
		
		



}