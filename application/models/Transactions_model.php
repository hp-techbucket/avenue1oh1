<?php

class Transactions_model extends MY_Model {
    
		const DB_TABLE = 'transactions';
		const DB_TABLE_PK = 'id';

		var $table = 'transactions';
		
		var $column_order = array(null,'reference','amount','transaction','description','ip_address','email','status','transaction_date'); //set column field database for datatable orderable
		
		var $column_search = array('reference','amount','transaction','description','ip_address','email','status','transaction_date'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
				
		
		/**
		 * Reference of the transaction.
		 * @var int 
		 */
		public $reference;

		
		/**
		 * amount
		 * @var string 
		 */
		public $amount;

		
		/**
		 * transaction (card number or paypal).
		 * @var string 
		 */
		public $transaction;

		
		/**
		 * transaction description.
		 * @var string 
		 */
		public $description;

		
		/**
		 * ip address.
		 * @var string 
		 */
		public $ip_address;
		
		/**
		 * users email.
		 * @var string 
		 */
		public $email;

		
		/**
		 * status.
		 * @var string 
		 */
		public $status;
		
		/**
		 * transaction date.
		 * @var string 
		 */
		public $transaction_date 	;

		

			
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
		
			
		private function _get_user_datatables_query()
		{
			$email = $this->session->userdata('email');
			
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
			$this->db->where('email', $email);	
		}
		
		function get_user_datatables()
		{
			$this->_get_user_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
	 
		function count_user_filtered()
		{
			$this->_get_user_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
	 
		public function count_user_all()
		{
			$email = $this->session->userdata('email');
			
			$this->db->where('email', $email);	
			$query = $this->db->get($this->table);
			return $query->num_rows();
		}				
				
		
				
		
		/***
		** Function to add transaction
		**
		***/	
		public function insert_transaction($data){
			
			//insert into transactions table
			$query = $this->db->insert('transactions', $data);
			
		//	$insert_id = $this->db->insert_id();

			if ($query){
				
				return true;
			}else {
				return false;
			}
		}
					
		
		public function count_transactions($email){
				
			$this->db->where('email', $email);
			$count_transactions = $this->db->get($this->table);
				
			if($count_transactions->num_rows() > 0)	{
					
				$count = $count_transactions->num_rows();
				return $count;
			}else {
					
				return false;
			}			
				
		}			


		public function get_all_transactions($limit=7, $start=0){
				
			$this->db->limit($limit, $start);
			$this->db->order_by('transaction_date','DESC');
			$reviews = $this->db->get($this->table);
				
			if($reviews->num_rows() > 0){
					
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				foreach ($reviews->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
				  
			}else{
				return false;
			}
		}		


		public function get_transactions($email, $limit, $start){
				
			$this->db->limit($limit, $start);
			$this->db->where('email', $email);
			$this->db->order_by('transaction_date','DESC');
			$reviews = $this->db->get($this->table);
				
			if($reviews->num_rows() > 0){
					
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				foreach ($reviews->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
				  
			}else{
				return false;
			}
		}		

		public function update_transaction($id = '',$reference=''){
		
			$this->db->where('id', $id);
			$this->db->where('reference', $reference);
			$query = $this->db->update($this->table, $data);
				
			if ($query){
				return true;
			}else {
				return false;
			}			
		}
		
		/* Function to count transactions 
		* from the past 24 hours or 1 day
		*/						
		public function count_new_transactions(){
			
			$date = date("Y-m-d H:i:s",time());
			$date = strtotime($date);
			$min_date = strtotime("-1 day", $date);
			
			$max_date = date('Y-m-d H:i:s', time());
			$min_date = date('Y-m-d H:i:s', $min_date);
			
			$this->db->select('*');
			$this->db->from('transactions');
			//$this->db->where('email_address', $email_address);
			
			$this->db->where("transaction_date BETWEEN '$min_date' AND '$max_date'", NULL, FALSE);

			$query = $this->db->get();
			
			if($query->num_rows() > 0)	{
					
				$count = $query->num_rows();
				return $count;
			}else {
					
				return false;
			}			
				
		}
		
		
		
		/****
		** Function to get_transaction_by_reference from the database
		****/
		public function get_transaction_by_reference($ref=null){
			
			
			$this->db->where('order_reference',$ref);
			
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){
		
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
			return false;
		}
		
		

		/* Function to check that the reference 
		* doesnt exist in the database
		*/	
		public function is_unique_reference($ref){
			
			$this->db->where('reference', $ref);
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
			
		}

		
		
		
}