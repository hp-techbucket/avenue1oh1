<?php

class Messages_model extends MY_Model {
    
    const DB_TABLE = 'messages';
    const DB_TABLE_PK = 'id';


	var $table = 'messages';
	
    var $column_order = array(null, 'sender_name','sender_username','receiver_name','receiver_username','message_subject','message_details','opened','recipient_archive','sender_archive','replied','date_sent'); //set column field database for datatable orderable
	
    var $column_search = array('sender_name','receiver_name','message_subject','message_details','date_sent'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 
 
	
	
    /**
     * Sender name.
     * @var string 
     */
    public $sender_name;
	
    /**
     * Sender username.
     * @var string 
     */
    public $sender_username;
	
    /**
     * Receiver username.
     * @var string 
     */
    public $receiver_name;	
    	
    /**
     * Receiver username.
     * @var string 
     */
    public $receiver_username;	
    
    /**
     * Message Subject.
     * @var string 
     */
    public $message_subject;
    
    /**
     * Message Details.
     * @var string 
     */
    public $message_details;
	
    /**
     * Message read or not.
     * @var int 
     */
    public $opened;	
	
    /**
     * recipient delete or not.
     * @var int 
     */
    public $recipient_archive;	
	
    /**
     * sender delete or not.
     * @var int 
     */
    public $sender_archive;	
	
    /**
     * Message replied or not.
     * @var int 
     */
    public $replied;	
				
    /**
     * Date sent.
     * @var string 
     */
    public $date_sent;		
	
		

		
	private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }	
	
	/*
	*	DATATABLE FUNCTION FOR USER INBOX
	*
	*/
	private function _get_inbox_datatables_query()
    {
         $username = $this->session->userdata('username');
		
		if($this->session->userdata('admin_logged_in')){
			$username = $this->session->userdata('admin_username');
		}
			
		
        $this->db->from($this->table);
		
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
			$this->db->where('receiver_username', $username);
			$this->db->where('recipient_archive', '0');
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
		
    }
	
    function get_inbox_datatables()
    {
		$this->_get_inbox_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }
			
 
    function count_filtered_inbox(){
        $this->_get_inbox_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 			
			
	public function count_inbox_all(){
		
		$username = $this->session->userdata('username');
		
		if($this->session->userdata('admin_logged_in')){
			$username = $this->session->userdata('admin_username');
		}
		
		$this->db->where('receiver_username', $username);
		$this->db->where('recipient_archive', '0');
		$query = $this->db->get($this->table);
		return $query->num_rows();			

	} 
	///END DATATABLE FUNCTION FOR USER INBOX
	
	/*
	*	DATATABLE FUNCTION FOR USER SENT MESSAGES
	*
	*/	
	private function _get_sent_datatables_query()
    {
         $username = $this->session->userdata('username');
		
		if($this->session->userdata('admin_logged_in')){
			$username = $this->session->userdata('admin_username');
		}
			
		
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
		$this->db->where('sender_username', $username);
		$this->db->where('sender_archive', '0');
    }	
 	
    function get_sent_datatables()
    {
		$this->_get_sent_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }
	
    function count_filtered_sent()
    {
		$this->_get_sent_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 			
	public function count_sent_all(){
				
		$username = $this->session->userdata('username');
		
		if($this->session->userdata('admin_logged_in')){
			$username = $this->session->userdata('admin_username');
		}
			
		$this->db->where('sender_username', $username);
		$this->db->where('sender_archive', '0');
		$query = $this->db->get($this->table);
		return $query->num_rows();	
	}			
	// END DATATABLE FUNCTION FOR USER SENT MESSAGES

	
	/*
	*	DATATABLE FUNCTION FOR USER ARCHIVE
	*
	*/
	private function _get_archive_datatables_query()
    {
         $username = $this->session->userdata('username');
		
		if($this->session->userdata('admin_logged_in')){
			$username = $this->session->userdata('admin_username');
		}
			
		
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
		$this->db->where('receiver_username', $username);
		$this->db->where('recipient_archive', '1');
    }
	
    function get_archive_datatables()
    {
		$this->_get_archive_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }
			
 
    function count_filtered_archive(){
        $this->_get_archive_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 			
			
	public function count_archive_all(){
		
		$username = $this->session->userdata('username');
		
		if($this->session->userdata('admin_logged_in')){
			$username = $this->session->userdata('admin_username');
		}
		
		$this->db->where('receiver_username', $username);
		$this->db->where('recipient_archive', '1');
		$query = $this->db->get($this->table);
		return $query->num_rows();			

	} 
	///END DATATABLE FUNCTION FOR USER ARCHIVE
		
	

			/****
			** Function to get 5 recent messages for the header
			****/
			public function get_header_messages($username = ''){
				
				$limit = $this->count_unread_messages($username);
				
				$this->db->limit($limit, 0);
				$this->db->where('receiver_username', $username);
				$this->db->where('opened', '0');
				$this->db->where('recipient_archive', '0');
				$this->db->order_by('date_sent','DESC');
				$q = $this->db->get('messages');
				
				if($q->num_rows() > 0){
				  foreach ($q->result() as $row)
				  {
					$data[] = $row;
				  }
				  return $data;
				}

			}	
			
			
			public function get_message($username, $limit, $start){
				
				$this->db->limit($limit, $start);
				$this->db->where('receiver_username', $username);
				$this->db->where('recipient_archive', '0');
				$this->db->order_by('date_sent','DESC');
				$messages = $this->db->get('messages');
				
				if($messages->num_rows() > 0){
					//if(){}
					
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				  foreach ($messages->result() as $row)
				  {
					$data[] = $row;
				  }
				  return $data;
				  
				}else{
					return false;
				}
			}
			
			//function to send a reply
			public function reply_message($data){
				
				$reply_data = array (
					'replied' => '1',
				);

				$query = $this->db->insert('messages', $data);				
				
				if ($query){

					$this->db->where('id', $this->input->post('message_id'));
					$update = $this->db->update('messages', $reply_data);			
					
					return true;
				}else {
					return false;
				}					
			}

			//function to send a new message to admin
			public function send_new_message($data){
				
				$query = $this->db->insert('messages', $data);				
				
				if ($query){
					return true;
				}else {
					return false;
				}					
			}
			
			public function count_unread_messages($username){
				
				$this->db->where('receiver_username', $username);
				$this->db->where('opened', '0');
				$this->db->where('recipient_archive', '0');
				$count_messages = $this->db->get('messages');
				
				if($count_messages->num_rows() > 0)	{
					
					$count = $count_messages->num_rows();
					return $count;
				}else {
					
					return false;
				}			
				
			}
			
			
			public function get_sent_messages($username, $limit, $start){
				
				$this->db->limit($limit, $start);
				$this->db->where('sender_username', $username);
				$this->db->where('sender_archive', '0');
				$this->db->order_by('date_sent','DESC');
				$messages = $this->db->get('messages');
				
				if($messages->num_rows() > 0){
					
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				  foreach ($messages->result() as $row)
				  {
					$data[] = $row;
				  }
				  return $data;
				  
				}else{
					return false;
				}
			}
			
			public function count_sent_messages($username){
				
				$this->db->where('sender_username', $username);
				$this->db->where('sender_archive', '0');
				$count_sent_messages = $this->db->get('messages');
				
				if($count_sent_messages->num_rows() > 0)	{
					$count_sent = $count_sent_messages->num_rows();
					return $count_sent;
				}else {
					return false;
				}			
			}			
			
			public function count_received_messages($username){
				
				$this->db->where('receiver_username', $username);
				$this->db->where('recipient_archive', '0');
				$count_messages = $this->db->get('messages');
				
				if($count_messages->num_rows() > 0)	{
					
					$count_received = $count_messages->num_rows();
					
					return $count_received;
					
				}else {
					
					return false;
				}			
				
			}	
			
			public function count_archive_messages($username){
				
				$this->db->where('receiver_username', $username);
				$this->db->where('recipient_archive', '1');
				$count_archives = $this->db->get('messages');
				
				if($count_archives->num_rows() > 0)	{
					
					$count = $count_archives->num_rows();
					
					return $count;
					
				}else {
					
					return false;
				}			
				
			}	
						
		/**
		* Function to delete old records
		*  
		*/		
		public function delete_old_records(){
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			//delete records older than 90 days
			$min_date = strtotime("-90 day", $date);
			
			$this->db->where("date_sent < '$min_date'", NULL, FALSE);
			$this->db->delete('messages');
		}
			
		/**
		* Function to search messages
		* @var string
		*/			
		public function get_search($keyword, $limit, $offset){
			
			$username = '';
			if($this->session->userdata('admin_logged_in')){
				$username = $this->session->userdata('admin_username');
			}else{
				$username = $this->session->userdata('username');
			}

			//$this->db->like('message_subject',$keyword);
			//$this->db->or_like('message_details',$keyword);
			$this->db->where("(message_subject LIKE '%".$keyword."%' OR message_details LIKE '%".$keyword."%')", NULL, FALSE);
			$this->db->where('receiver_username', $username);
			$this->db->where('recipient_archive', '0');
			$this->db->limit($limit, $offset);
			$this->db->order_by('date_sent','DESC');
			$query = $this->db->get('messages');
			
			if($query->num_rows() > 0){
					
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_search($keyword){
			
			$username = '';
			if($this->session->userdata('admin_logged_in')){
				$username = $this->session->userdata('admin_username');
			}else{
				$username = $this->session->userdata('username');
			}
			
			//$this->db->like('message_subject',$keyword);
			//$this->db->or_like('message_details',$keyword);
			$this->db->where("(message_subject LIKE '%".$keyword."%' OR message_details LIKE '%".$keyword."%')", NULL, FALSE);
			$this->db->where('receiver_username', $username);
			$this->db->where('recipient_archive', '0');
			$count_search = $this->db->get('messages');
				
			if($count_search->num_rows() > 0)	{
					
				$count = $count_search->num_rows();
				return $count;
			}else {
					
				return false;
			}			
				
		}
		
			
		/**
		* Function to search messages
		* @var string
		*/			
		public function get_search_sent($username, $keyword, $limit, $offset){
			
			//$this->db->like('message_subject',$keyword);
			//$this->db->or_like('message_details',$keyword);
			$this->db->where("(message_subject LIKE '%".$keyword."%' OR message_details LIKE '%".$keyword."%')", NULL, FALSE);
			$this->db->where('sender_username', $username);
			$this->db->where('sender_archive', '0');
			$this->db->limit($limit, $offset);
			$this->db->order_by('date_sent','DESC');
			$query = $this->db->get('messages');
			if($query->num_rows() > 0){
					
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}							

		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_search_sent($keyword, $username){
			
			//$this->db->like('message_subject',$keyword);
			//$this->db->or_like('message_details',$keyword);
			$this->db->where("(message_subject LIKE '%".$keyword."%' OR message_details LIKE '%".$keyword."%')", NULL, FALSE);
			$this->db->where('sender_username', $username);
			$this->db->where('sender_archive', '0');
			$count_search = $this->db->get('messages');
				
			if($count_search->num_rows() > 0)	{
					
				$count = $count_search->num_rows();
				return $count;
			}else {
					
				return false;
			}			
				
		}

		
		 /**
		 * Function to search result
		 * @var string
		 */			
		public function check_for_unread($opened = '0',$checked){
	
			if($opened != '' && $opened != null){
				$this->db->where('opened', $opened);
			}
			if(is_array($checked) && count($checked) > 0){
				$this->db->where_in('id', $checked);
			}

			$this->db->order_by('id','DESC');
			$query = $this->db->get('messages');
			if($query->num_rows() > 0){
					
				return true;
			}
			return false;
		}			
		
			
		/**
		 * Function to send_email_alert
		 * @var string
		 */			
		public function send_email_alert($to = '', $subject = '', $first_name = '', $message = ''){
			//send email
			//Load email library
			//send email
			//$ci = get_instance();
			$this->load->library('email');
			
			//template
			//compose email message
			$template = "<div style='font-size: 1.0em; border: 1px solid #D0D0D0; border-radius: 3px; margin: 5px; padding: 10px; '>";
			$template .= '<div align="center" id="logo"><a href="'.base_url().'" title="GSI">'.img('assets/images/img/logo.png').'</a></div><br/>';
						
			$template .= '<p>Hello '.$first_name. ',</p>';
			$template .= $message;
			$template .= "</div>";
					
			
			//setup email function
			$this->email->from('info@avenue1oh1.com', 'Avenue 1-OH-1');
			$this->email->to($to);
			$this->email->reply_to('avenue1oh1@gmail.com', 'Avenue 1-OH-1');
			$this->email->subject($subject);
			$this->email->message($template);
			$this->email->send();				
			
		}															
			
		
			
	
	
}