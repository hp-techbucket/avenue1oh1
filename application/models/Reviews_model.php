<?php

class Reviews_model extends MY_Model {
		
		const DB_TABLE = 'reviews';
		const DB_TABLE_PK = 'id';


		var $table = 'reviews';
		
		var $column_order = array(null, 'product_id','rating','reviewer_email','comment','review_date'); //set column field database for datatable orderable
		
		var $column_search = array('product_id','rating','reviewer_email','comment','review_date'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
		
	
		/**
		 * product id.
		 * @var int 
		 */
		public $product_id;

		/**
		 * rating.
		 * @var int 
		 */
		public $rating;

		/**
		 * reviewer email.
		 * @var string 
		 */
		public $reviewer_email;

		/**
		 * comment.
		 * @var string 
		 */
		public $comment;

		/**
		 * review date.
		 * @var date 
		 */
		public $review_date;

		
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
		

		 /**
		 * Function to count reviews
		 * @var string
		 */			
		public function count_reviews(){
			
			$count_reviews = $this->db->get('reviews');
			if($count_reviews->num_rows() > 0)	{
					
				$count = $count_reviews->num_rows();
				return $count;
			}else {
				return false;
			}				
		}
		
		
		/****
		** Function to get all records from the database
		****/
		public function get_reviews(){
			
			$this->db->order_by('id','DESC');
			$q = $this->db->get('reviews');
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
			return false;
		}

		/**
		* Function to add the item 
		* to the products table in the database
		* @param $string Activation key
		*/		
		public function insert_review($data){

			$query  = $this->db->insert('reviews', $data);
			
			if ($query ){
				return true;
			}else {
				return false;
			}
		}
		
		/**
		* Function to update
		* the review
		* variable array $data int $id
		*/	
		public function update_review($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update('reviews', $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}

		
		/****
		** Function to get product reviews from the database
		****/
		public function get_product_reviews($id){
			
			$this->db->where('product_id', $id);
			$q = $this->db->get('reviews');
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
			return false;
		}

		 /**
		 * Function to count product reviews
		 * @var string
		 */			
		public function count_product_reviews($id){
			
			$this->db->where('product_id', $id);
			$count_reviews = $this->db->get('reviews');
			if($count_reviews->num_rows() > 0)	{
					
				$count = $count_reviews->num_rows();
				return $count;
			}else {
				return false;
			}				
		}

		
		/****
		** Function to get average product ratings from the database
		****/
		public function get_product_rating($id){
			$this->db->select_avg('rating','overall');
			$this->db->from('reviews');
			$this->db->where('product_id', $id);
			$q = $this->db->get();
			
			if($q->num_rows() > 0){
				return $q->result();
			 
			}
			return false;
		}
		

						
		
		
	
}