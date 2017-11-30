<?php

class Temp_users_model extends MY_Model {
    
    const DB_TABLE = 'temp_users';
    const DB_TABLE_PK = 'id';
	

	var $table = 'temp_users';
	
    var $column_order = array(null, 'first_name','last_name','email_address','password','date_created','activation_key'); //set column field database for datatable orderable
	
    var $column_search = array('first_name','last_name','email_address','password','date_created','activation_key'); //set column field database for datatable searchable 
	
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
     * Date created.
     * @var string 
     */
    public $date_created;

    /**
     * User last login.
     * @var string 
     */
    public $last_login;

    /**
     * User last login.
     * @var string 
     */
    public $activation_key;

 
			
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
			
			$query = $this->db->get($this->table);
			return $query->num_rows();
			//$this->db->from($this->table);
			//return $this->db->count_all_results();
		}	
		

		/**
		* Function to add the user 
		* to the temp table in the database
		* @param $string Activation key
		*/		
		public function add_temp_user($activation_key){
			
			//array of all post variables
			$data = array(

				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				//'address' => $this->input->post('address'),
				
				'email_address' => $this->input->post('email_address'),
				
				'password' => md5($this->input->post('password')),		
				'date_created' => date('Y-m-d H:i:s'),	
				'activation_key' => $activation_key,
				
			);
			
			$query = $this->db->insert('temp_users', $data);
			if ($query){
				
				return true;
			}else {
				return false;
			}
			
		}

				
		/**
		* Function to validate that the activation key
		* exists in the database
		* @param $string Activation key
		*/			
		public function is_valid_key($activation_key){
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			//check for code 24 hour expiration
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);			
			
			$this->db->where('activation_key', $activation_key);
			$this->db->where("date_created BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);
			
			$query = $this->db->get('temp_users');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				//if key expired delete record
				//$this->db->where('activation_key', $activation_key);
				//$this->db->delete('temp_users');
				if($this->is_expired_key($activation_key)){
					$this->db->where('activation_key', $activation_key);
					$this->db->delete('temp_users');	
				}		
				return false;
			}			
		}

		public function is_expired_key($key){
			
			$this->db->where('activation_key', $key);
			$temp_users = $this->db->get('temp_users');
			$date_created = '';
			if($temp_users){
				$row = $temp_users->row();
				$date_created = $row->date_created;
			}
			
			$max_date = date('Y-m-d H:i:s', time());
			$max_date = strtotime($max_date);
			$min_date = strtotime($date_created);
			$time_diff = $max_date - $min_date;
			
			if ($time_diff > 86400){
				return true;
			}else {			
				return false;
			}			
		}


				
		/**
		* Function to add the user 
		* to the users table in the database
		* @param $string Activation key
		*/		
		public function add_user($activation_key){
			
			$this->db->where('activation_key', $activation_key);
			$temp_users = $this->db->get('temp_users');
			
			if($temp_users){
				$row = $temp_users->row();
				
				//array of all the row values returned
				$data = array(
					
					'first_name' => $row->first_name,
					'last_name' => $row->last_name,
					'email_address' => $row->email_address,
					'password' => $row->password,						
					'date_created' => $row->date_created,
					
				);
				
				//create default address data
				//and store in db
				$default = array(

					'first_name' => $row->first_name,
					'last_name' => $row->last_name,
					//'address' => $this->input->post('address'),
					
					'user_email' => $row->email_address,
					
				);
			
				$did_add_user = $this->db->insert('users', $data);
			}
			if ($did_add_user){
				
				
				$this->db->where('activation_key', $activation_key);
				$this->db->delete('temp_users');
				
				//store default address
				$this->db->insert('default_address', $default);
				return true;
				
			}else {
					return false;
			}
		}

		
		/**
		* Function to add the user 
		* to the users table in the database
		* @param $string Activation key
		*/		
		public function activate_user($code){
			
			$this->db->where('activation_code', $code);
			$temp_users = $this->db->get('temp_users');
			
			if($temp_users){
				$row = $temp_users->row();
				
				//array of all the row values returned
				$data = array(
					
					'first_name' => $row->first_name,
					'last_name' => $row->last_name,
					'address' => $row->address,
					'city' => $row->city,
					'postcode' => $row->postcode,
					'state' => $row->state,
					'country' => $row->country,
					'email_address' => $row->email_address,
					'mobile' => $row->mobile,
					'username' => $row->username,
					'password' => $row->password,
					'account_balance' => 0,							
					'date_created' => $row->date_created,
					
				);
				
				$did_add_user = $this->db->insert('users', $data);
			}
			if ($did_add_user){
				
				$this->db->where('activation_code', $code);
				$this->db->delete('temp_users');
				return true;
				
			}else {
					return false;
			}
		}



		
			
			
}