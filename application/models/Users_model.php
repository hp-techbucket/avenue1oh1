<?php

class Users_model extends MY_Model {
    
    const DB_TABLE = 'users';
    const DB_TABLE_PK = 'id';
	

	var $table = 'users';
	
    var $column_order = array(null, 'first_name','last_name','company_name','address_line_1','address_line_2','city','postcode','state','country','email_address','password','phone','account_balance','security_question','security_answer','status','date_created','last_login'); //set column field database for datatable orderable
	
    var $column_search = array('first_name','last_name','company_name','address_line_1','address_line_2','city','postcode','state','country','email_address','password','phone','account_balance','security_question','security_answer','status','date_created','last_login'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 

    /**
     * User First Name.
     * @var string 
     */
    public $first_name;
    
     /**
     * User Last Name.
     * @var string
     */
    public $last_name;
    
     /**
     * User company Name.
     * @var string
     */
    public $company_name;

    /**
     * User address.
     * @var string
     */
    public $address_line_1;

    /**
     * User address.
     * @var string
     */
    public $address_line_2;
                
    /**
     * User city.
     * @var string
     */
    public $city;
	            
    /**
     * User postcode.
     * @var string
     */
    public $postcode;
	            
    /**
     * User state.
     * @var string
     */
    public $state;
	            
    /**
     * User country.
     * @var string
     */
    public $country;
			
    /**
     * User Email Address.
     * @var string
     */
    public $email_address;

     /**
     * User password.
     * @var string
     */
    public $password;
    
     /**
     * User phone.
     * @var string
     */
    public $phone;

     /**
     * User Account balance.
     * @var float
     */
    public $account_balance;
    
     /**
     * User Security question.
     * @var float
     */
    public $security_question;
    
     /**
     * User Security answer.
     * @var string
     */
    public $security_answer;
    
     /**
     * status.
     * @var string
     */
    public $status;

    /**
     * Date created.
     * @var string 
     */
    public $date_created;

    /**
     * User last login.
     * @var string 
     */
    public $last_login;


			
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
			$this->db->where('status', '0');
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
			$this->db->where('status', '0');
			$query = $this->db->get($this->table);
			return $query->num_rows();
			//$this->db->from($this->table);
			//return $this->db->count_all_results();
		}	
		

			
		private function _get_deactivated_datatables_query()
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
			$this->db->where('status', '1');
		}
		
		function get_deactivated_datatables()
		{
			$this->_get_deactivated_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_filtered_deactivated()
		{
			$this->_get_deactivated_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_all_deactivated()
		{
			$this->db->where('status', '1');
			$query = $this->db->get($this->table);
			return $query->num_rows();
			//$this->db->from($this->table);
			//return $this->db->count_all_results();
		}	
				
				
		/**
		* Function to check that the email and password 
		* exists in the database
		*/	
		public function can_log_in(){
			
			$email = strtolower($this->input->post('email'));
			
			$this->db->where('LOWER(email_address)', $email);
			$this->db->where('password', md5($this->input->post('password')));
			$this->db->where('status', '0');
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}

				
		/**
		* Function to add the user 
		* to the users table in the database
		* @param $string Activation key
		*/		
		public function insert_user($data){

			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}
		
		function get_user($email){
			
			$this->db->where('email_address', $email);
			$q = $this->db->get('users');
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}

		
		
		/****
		** Function to get users from the database
		****/
		function get_users($limit, $offset){
			
			$this->db->limit($limit, $offset);
			$this->db->order_by('id','DESC');
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}

		}		
			

		public function user_update($data='', $email=''){
			
			if( $email != ''){
				$this->db->where('email_address', $email);
			}

			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;	
			}else {		
				return false;			
			}			
		}			
		
		public function update_user($data, $id=''){
			
			if( $id != ''){
				$this->db->where('id', $id);
			}

			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;	
			}else {		
				return false;			
			}			
		}		
		

		
		/****
		** Function to get a user from the database
		****/
		function get_user_address($email){
			
			$this->db->select('address,city,postcode,state,country');
			$this->db->from('users');
			$this->db->where('email_address', $email);
			//$query = $this->db->get();
			
			$q = $this->db->get();
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}

		/**
		* Function to check if the user 
		* is logging in for the first time
		*  
		*/			
		public function first_time_log_in(){
			
			$email = $this->session->userdata('email');
			
			$user = $this->get_user($email);
			$last_login = '';
			
			foreach($user as $u){	
				$last_login = $u->last_login;
			}
			if ($last_login === '0000-00-00 00:00:00'){		
				return TRUE;		
			}else {
				return FALSE;
			}
		}
	
		//function to check if user has set 
		//their security question and answer
		//after log in
		public function check_isset_security_info(){
			
				$email = $this->session->userdata('email');
				
				$security_question = '';
				
				$user = $this->get_user($email);
				
				foreach($user as $u){	
					$security_question = $u->security_question;
				}					
				if($security_question == '' || $security_question == null){
					return true;
				}else{
					return false;
				}	
		} 
		

		/* Function to check that the memorable answer 
		* exists in the database
		*/	
		public function answer_exists(){
			
			$security_answer = $this->input->post('security_answer');

			$this->db->like('LOWER(security_answer)', strtolower($security_answer));
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}		
	
		/* Function to check that the email address 
		* exists in the database
		*/	
		public function email_exists(){
			
			$this->db->where('email_address', $this->input->post('email_address'));
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}

		/* Function to check that the email address 
		* exists in the database
		*/	
		public function check_email_exists($email){
			
			$this->db->where('email_address', $email);
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}

		/* Function to check that the email address 
		* exists in the database
		*/	
		public function check_account_exists($email){
			
			$this->db->where('email_address', $email);
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}
			
		
		/***
		** Function to add payment method
		**
		***/	
		public function add_deposit($data){
			
			$email = $this->session->userdata('email');
			
			//insert into deposit table
			$query = $this->db->insert('deposits', $data);
			
			if ($query){
				//create new transaction
				$deposit_date = $this->session->flashdata('deposit_date');
				
				$deposit_amount = '';
				
				if($this->input->post('voucher_amount') != ''){
					$deposit_amount = $this->input->post('voucher_amount');
				}else{
					$deposit_amount = $this->input->post('deposit_amount');
				}
				//remove non-numbers from post
				$amount = preg_replace("/[^\d-.]+/","", $deposit_amount);
	
				$number = '';
				$transaction = '';
				
				if($this->input->post('card_number') != ''){
					$number = $this->input->post('card_number');
					$transaction = $number;
				}else{
					$number = $this->input->post('voucher_number');
					$transaction = 'XXXX-XXXX-XXXX-'.substr($number,-4);
				}
				
				//generate random reference number
				$reference = mt_rand(100000000, 999999999);
				
				//obtain users ip address
				$ip_address = $this->ip();
				
				//data for db
				$data = array(
					'reference' => $reference,
					'amount' => '+ $'.number_format($amount, 2),
					'transaction' => $transaction,
					'note' => 'Deposit',
					'ip_address' => $ip_address,
					'user_email' => $email,
					'date' => $deposit_date,
				);
				$this->db->insert('transactions', $data);
				
				//update users balance
				$user = $this->Users->get_user($email);
						
				$account_balance = '';
						
				foreach($user as $u){
					$account_balance = $u->account_balance;
				}
				//$account_balance = $this->input->post('account_balance');
				$new_balance = $amount + $account_balance;
				
				$d = array(
					'account_balance' => $new_balance,
				);
				$this->db->where('email_address', $email);
				$this->db->update('users', $d);
				
				return true;
			}else {
				return false;
			}
		}

		/****
		** Function to get payment by id
		****/
		public function get_payment_by_id($id){

			$this->db->limit(1, 0);
			$this->db->where('id', $id);
			$q = $this->db->get('deposits');
			
			if($q->num_rows() > 0){
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}

		}	
				

		/* Function to ensure the username is unique 
		* 
		*/	
		public function unique_user($email){
			
			$this->db->where('email_address', $email);
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
		}


		
			
			
}