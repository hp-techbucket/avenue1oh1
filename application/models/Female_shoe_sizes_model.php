<?php

class Female_shoe_sizes_model extends MY_Model {
    
    const DB_TABLE = 'female_shoe_sizes';
    const DB_TABLE_PK = 'id';


	var $table = 'female_shoe_sizes';
	
    var $column_order = array(null, 'size_EU','size_UK','size_US'); //set column field database for datatable orderable
	
    var $column_search = array('size_EU','size_UK','size_US'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'asc'); // default order 
    
	
	/**
     * Size EUROPE.
     * @var string 
     */
    public $size_EU;
	
	/**
     * Size UK.
     * @var string 
     */
    public $size_UK;
	
	/**
     * Size US.
     * @var string 
     */
    public $size_US;




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
	* Function to add the item 
	* to the male sizes table in the database
	* @param $string
	*/		
	public function insert_size($data){

		$query  = $this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();
		
		if ($insert_id){
			return true;
		}else {
			return false;
		}
	}
		
  
	public function get_sizes(){
		
		$this->db->from($this->table);
		$this->db->order_by('id');
		$result = $this->db->get();
		$return = array();
		
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
				$return[$row['size_US']] = $row['size_US'];
			}
		}
		
		return $return;
	}


		 /**
		 * Function to count sizes
		 * @var string
		 */			
		public function count_sizes(){
			
			$count_sizes = $this->db->get($this->table);
			if($count_sizes->num_rows() > 0)	{
					
				$count = $count_sizes->num_rows();
				return $count;
			}else {
				return false;
			}				
		}
		
		
		/****
		** Function to get all records from the database
		****/
		public function get_all_sizes(){
			
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
			return false;
		}
		
		/****
		** Function to get_category_by_size from the database
		****/
		public function get_category_by_size($size){
			
			$this->db->where('size_US',$size);
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
				
		/**
		* Function to update
		* the size
		* variable array $data int $id
		*/	
		public function update_size($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}



		
	
	
}