<?php

class Addresses_model extends MY_Model {
    
    const DB_TABLE = 'addresses';
    const DB_TABLE_PK = 'id';


	var $table = 'addresses';
	
    var $column_order = array(null, 'first_name','last_name','user_email','company_name','address_line_1','address_line_2','city','postcode','state','country','phone','date_added'); //set column field database for datatable orderable
	
    var $column_search = array('first_name','last_name','user_email','company_name','address_line_1','address_line_2','city','postcode','state','country','phone','date_added'); //set column field database for datatable searchable 
	
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
     * User email.
     * @var string
     */
    public $user_email;
    
     /**
     * User company name.
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
     * User phone.
     * @var string
     */
    public $phone;
		
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
		
		
	
		/**
		* Function to insert address
		*  
		*/	
		public function add_address($data){
				
			$this->db->insert($this->table, $data);
			$insert_id = $this->db->insert_id();
			if ($insert_id){
				return true;
			}else {
				return false;
			}
				
		}
	
		/**
		* Function to update address
		* variable $id
		*/	
		public function update_address($data, $id){

			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}

		/**
		* Function to check that the address 
		* exists in the database
		*/	
		public function unique_address($where){
		
			/*$where = array(
				'address_line_1' => $address_line_1,
				'address_line_2' => $address_line_2,
				'city' => $city,
				'postcode' => $postcode,
				'state' => $state,
				'country' => $country,
				'phone' => $phone,
				'user_email' => $email,
			);
			*/
			
			$this->db->where($where);
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
			
		}			
										
		/****
		** Function to get users addresses from the database
		**	variable $email
		****/
		function get_addresses($email){
			
			$this->db->where('user_email', $email);
			$q = $this->db->get($this->table);
			
			if($q->num_rows() > 0){

			  foreach ($q->result() as $row){
				$data[] = $row;
			  }
			  return $data;
			}

		}			
			
			
			
			
			
			
			


	
    
}

