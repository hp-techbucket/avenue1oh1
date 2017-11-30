<?php

class Male_categories_model extends MY_Model {
    
    const DB_TABLE = 'male_categories';
    const DB_TABLE_PK = 'id';


	var $table = 'male_categories';
	
    var $column_order = array(null, 'category_name'); //set column field database for datatable orderable
	
    var $column_search = array('category_name'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'asc'); // default order 
    
	
	/**
     * category of the product.
     * @var string 
     */
    public $category_name;


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
	* to the male categories table in the database
	* @param $string Activation key
	*/		
	public function insert_category($data){

		$query  = $this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();
		
		if ($insert_id){
			return true;
		}else {
			return false;
		}
	}
		
  
	public function get_categories(){
		
		$this->db->from($this->table);
		$this->db->order_by('id');
		$result = $this->db->get();
		$return = array();
		
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
				$return[$row['category_name']] = $row['category_name'];
			}
		}
		
		return $return;
	}


		 /**
		 * Function to count categories
		 * @var string
		 */			
		public function count_categories(){
			
			$count_categories = $this->db->get($this->table);
			if($count_categories->num_rows() > 0)	{
					
				$count = $count_categories->num_rows();
				return $count;
			}else {
				return false;
			}				
		}
		
		
		/****
		** Function to get all records from the database
		****/
		public function get_all_categories(){
			
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
		** Function to get_category_by_name from the database
		****/
		public function get_category_by_name($name){
			
			$this->db->where('LOWER(category_name)',strtolower($name));
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
		* the category
		* variable array $data int $id
		*/	
		public function update_category($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}



		
	
	
}