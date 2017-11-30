<?php

class Sizes_model extends MY_Model {
    
    const DB_TABLE = 'sizes';
    const DB_TABLE_PK = 'id';

	

	var $table = 'sizes';
	
    var $column_order = array(null, 'size_EU','size_UK','size_US'); //set column field database for datatable orderable
	
    var $column_search = array('size_EU','size_UK','size_US'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'asc'); // default order 
    
	
	/**
     * EU Size.
     * @var string 
     */
    public $size_EU;
	
	/**
     * UK Size.
     * @var string 
     */
    public $size_UK;
	
	/**
     * US Size.
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
		* Function to add sizes
		* to the database
		* @param $array
		*/		
		public function insert_size($data){

			$query  = $this->db->insert('sizes', $data);
			$insert_id = $this->db->insert_id();
			
			if ($query ){
				return $insert_id;
			}else {
				return false;
			}
		}
		
  
	public function get_sizes(){
		
		$this->db->from('sizes');
		$this->db->order_by('id');
		$result = $this->db->get();
		$return = array();
		
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
				$return[$row['size_EU']] = $row['size_EU'];
			}
		}
		//for dropdown or select input
		return $return;
	}


		/**
		* Function to update
		* the size 
		* variable $id
		*/	
		public function update_size($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update('sizes', $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}
			




	
	
	
}