<?php

class Wishlist_model extends MY_Model {
    
    const DB_TABLE = 'wishlist';
    const DB_TABLE_PK = 'id';


	var $table = 'wishlist';
	
    var $column_order = array(null, 'product_id','product_price','customer_email','date_added'); //set column field database for datatable orderable
	
    var $column_search = array('product_id','product_price','customer_email','date_added'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 
    

    /**
     * product ID.
     * @var INT 
     */
    public $product_id;

    /**
     * product price.
     * @var decimal 
     */
    public $product_price;

    /**
     * customer email.
     * @var string 
     */
    public $customer_email;

    /**
     * date_added.
     * @var string 
     */
    public $date_added;

		
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
		* Function to insert wishlist
		*  
		*/	
		public function add_wishlist($data){
				
			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
				
		}
	

		/**
		* Function to check that the wishlist 
		* exists in the database
		*/	
		public function unique_wishlist($id='',$email=''){
			
			$this->db->where('product_id', $id);
			$this->db->where('customer_email', $email);
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
			
		}			
										
		/****
		** Function to get users wishlist from the database
		**	variable $username
		****/
		function get_wishlist($email){
			
			$this->db->where('customer_email', $email);
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){

			  foreach ($q->result() as $row){
				$data[] = $row;
			  }
			  return $data;
			}

		}			
			
			
			
			
			
			
			


	
    
}

