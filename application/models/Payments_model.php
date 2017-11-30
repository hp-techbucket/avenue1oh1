<?php

class Payments_model extends MY_Model {
    
		const DB_TABLE = 'payments';
		const DB_TABLE_PK = 'id';


		var $table = 'payments';
		
		var $column_order = array(null, 'reference','total_amount','payment_method','customer_email','payment_date'); //set column field database for datatable orderable
		
		var $column_search = array('reference','total_amount','payment_method','customer_email','payment_date'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
		
		
		/**
		 * Reference ID.
		 * @var int 
		 */
		public $reference;
		
		
		/**
		 * amount paid.
		 * @var string 
		 */
		public $total_amount;
		
		
		/**
		 * payment method.
		 * @var string 
		 */
		public $payment_method;

		
		/**
		 * email address of the customer.
		 * @var string 
		 */
		public $customer_email;
	
		/**
		 * payment date.
		 * @var string 
		 */
		public $payment_date;


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
			$this->db->where('customer_email', $email);	
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
			$this->db->where('customer_email', $email);	
			$query = $this->db->get($this->table);
			return $query->num_rows();
		}	
							
				
	
	/**
		* Function to add shipping 
		* to the database
		* @param $array
		*/		
		public function insert_payment($data){
			
			$query  = $this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			
			if ($query ){
				return true;
			}else {
				return false;
			}
		}

		
		
		public function count_payments($email){
				
			$this->db->where('customer_email', $email);
			$count_payments = $this->db->get($this->table);
				
			if($count_payments->num_rows() > 0)	{
					
				$count = $count_payments->num_rows();
				return $count;
			}else {
					
				return false;
			}			
				
		}			


		public function get_payments($email, $limit, $start){
				
			$this->db->limit($limit, $start);
			$this->db->where('customer_email', $email);
			$this->db->order_by('payment_date','DESC');
			$payments = $this->db->get($this->table);
				
			if($payments->num_rows() > 0){
					
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				foreach ($payments->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
				  
			}else{
				return false;
			}
		}		

			
		

		
		
}