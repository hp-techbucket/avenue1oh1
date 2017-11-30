<?php

class Orders_model extends MY_Model {
    
    const DB_TABLE = 'orders';
    const DB_TABLE_PK = 'id';



	var $table = 'orders';
	
    var $column_order = array(null, 'reference','total_price','tax','shipping_n_handling_fee','payment_gross','num_cart_items','customer_email','billing_address_name','billing_address_street','billing_address_zip','billing_address_city','billing_address_state','billing_address_country','shipping_address_name','shipping_address_street','shipping_address_zip','shipping_address_city','shipping_address_state','shipping_address_country','customer_contact_phone','payment_status','shipping_status','order_date'); //set column field database for datatable orderable
	
    var $column_search = array('reference','total_price','tax','shipping_n_handling_fee','payment_gross','num_cart_items','customer_email','billing_address_name','billing_address_street','billing_address_zip','billing_address_city','billing_address_state','billing_address_country','shipping_address_name','shipping_address_street','shipping_address_zip','shipping_address_city','shipping_address_state','shipping_address_country','customer_contact_phone','payment_status','shipping_status','order_date'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 
    
	
	/**
     * Unique Reference.
     * @var string 
     */
    public $reference;

	
	/**
     * Total Order Price.
     * @var string 
     */
    public $total_price;


	/**
     * Total tax.
     * @var string 
     */
    public $tax;

	
	/**
     * Total Shipping and Handling fee.
     * @var string 
     */
    public $shipping_n_handling_fee;

	
	/**
     * Total Order Payment.
     * @var string 
     */
    public $payment_gross;
	
		
	/**
     * Total number of items in cart.
     * @var string 
     */
    public $num_cart_items;

	
	/**
     * Customer Email Address.
     * @var string 
     */
    public $customer_email;

	
	/**
     * Customer Billing Address Name.
     * @var string 
     */
    public $billing_address_name;

	
	/**
     * Customer Billing Address street.
     * @var string 
     */
    public $billing_address_street;

	
	/**
     * Customer Billing Address zip.
     * @var string 
     */
    public $billing_address_zip;

	
	/**
     * Customer Billing Address city.
     * @var string 
     */
    public $billing_address_city;

	
	/**
     * Customer Billing Address state.
     * @var string 
     */
    public $billing_address_state;

	
	/**
     * Customer Billing Address country.
     * @var string 
     */
    public $billing_address_country;


	
	/**
     * Customer Shipping Address Name.
     * @var string 
     */
    public $shipping_address_name;

	
	/**
     * Customer Shipping Address street.
     * @var string 
     */
    public $shipping_address_street;

	
	/**
     * Customer Shipping Address zip.
     * @var string 
     */
    public $shipping_address_zip;

	
	/**
     * Customer Shipping Address city.
     * @var string 
     */
    public $shipping_address_city;

	
	/**
     * Customer Shipping Address state.
     * @var string 
     */
    public $shipping_address_state;

	
	/**
     * Customer Shipping Address country.
     * @var string 
     */
    public $shipping_address_country;
						
	/**
     * Payment Status.
     * @var string 
     */
    public $payment_status;

	
	/**
     * Shipping Status.
     * @var string 
     */
    public $shipping_status;

	
	/**
     * Order Datetime.
     * @var string 
     */
    public $order_date;



		
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
		* Function to add order 
		* to the database
		* @param $array
		*/		
		public function insert_order($data){
			
			$query  = $this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}

		
		/****
		** Function to get all records from the database
		****/
		public function get_orders($limit, $offset){
			
			$this->db->limit($limit, $offset);
			$this->db->order_by('id','DESC');
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

		
		/****
		** Function to get all records from the database
		****/
		public function get_order($id=null){
			
			$this->db->where('id', $id);
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){
			  foreach ($q->result() as $row){
				$data[] = $row;
			  }
			  return $data;
			}
			return false;
		}
				
		/**
		* Function to update
		* the order
		* variable $id
		*/	
		public function update_order($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}
			

		/* Function to ensure the reference is unique 
		* 
		*/	
		public function is_unique_reference($reference){
			
			$this->db->where('reference', $reference);
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
		}


		
		/****
		** Function to get order by referenceID from the database
		****/
		public function get_order_by_reference($ref=null){
			
			//$this->db->limit($limit, $offset);
			$this->db->where('order_reference',$ref);
			$this->db->order_by('id','ASC');
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
				



	
	
	
}