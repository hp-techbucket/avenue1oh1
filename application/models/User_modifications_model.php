<?php

class User_modifications_model extends MY_Model {
    
    const DB_TABLE = 'user_modifications';
    const DB_TABLE_PK = 'id';



	var $table = 'user_modifications';
	
    var $column_order = array(null, 'username','user_fullname','modified_by','details','date_modified'); //set column field database for datatable orderable
	
    var $column_search = array('username','user_fullname','modified_by','details','date_modified'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'asc'); // default order 
    
	
	/**
     * username.
     * @var string 
     */
    public $username;

	
	/**
     * user_fullname.
     * @var string 
     */
    public $user_fullname;

	
	/**
     * modified_by.
     * @var string 
     */
    public $modified_by;

	
	/**
     * details.
     * @var string 
     */
    public $details;

	
	/**
     * date_modified.
     * @var string 
     */
    public $date_modified;

	
		
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
		* Function to add user modifications 
		* to the database
		* @param $array
		*/		
		public function insert_user_modification($data){

			$query  = $this->db->insert('user_modifications', $data);
			$insert_id = $this->db->insert_id();
			
			if ($query ){
				return $insert_id;
			}else {
				return false;
			}
		}

		
		/****
		** Function to get all records from the database
		****/
		public function get_modifications($limit=10, $offset=0){
			
			$this->db->limit($limit, $offset);
			$this->db->order_by('id','DESC');
			$q = $this->db->get('user_modifications');
			
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


		
		/****
		** Function to get users records from the database
		****/
		public function get_user_modifications($username,$limit=10, $offset=0){
			
			$this->db->where('username',$username);
			$this->db->limit($limit, $offset);
			$this->db->order_by('id','DESC');
			$q = $this->db->get('user_modifications');
			
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




	
	
	
}