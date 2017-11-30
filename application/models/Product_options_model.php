<?php

class Product_options_model extends MY_Model {
    
    const DB_TABLE = 'product_options';
    const DB_TABLE_PK = 'id';


	var $table = 'product_options';
	
    var $column_order = array(null, 'product_id','size','colour','quantity'); //set column field database for datatable orderable
	
    var $column_search = array('product_id','size','colour','quantity'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 
      
    	
	/**
     * product id.
     * @var int 
     */
    public $product_id;

	/**
     * product size.
     * @var string 
     */
    public $size;

	/**
     * product colour.
     * @var string 
     */
    public $colour;

	/**
     * product quantity.
     * @var int 
     */
    public $quantity;

 
		
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
	
    function get_datatables(){
		
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered(){
		
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all(){
		
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }	
			
			
	/**
	* Function to add the item 
	* to the products options table in the database
	* @param $string Activation key
	*/		
	public function insert_option($data){

		$query  = $this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();
		
		if ($insert_id){
			return $insert_id;
		}else {
			return false;
		}
	}

		
	/****
	** Function to get product sizes from the database
	****/
	public function get_product_sizes($product_id){
		
		
		$this->db->select("size");
		$this->db->group_by('size');
		$this->db->from($this->table);		
		$this->db->where('product_id', $product_id);
		$this->db->order_by('id','DESC');
		
		$q = $this->db->get();
			
		if($q->num_rows() > 0){
				
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
		
		
	/****
	** Function to get product colours from the database
	****/
	public function get_product_colours($product_id){
		
		
		$this->db->select("colour");
		$this->db->group_by('colour');
		$this->db->from($this->table);		
		$this->db->where('product_id', $product_id);
		$this->db->order_by('id','DESC');
		
		$q = $this->db->get();
			
		if($q->num_rows() > 0){
				
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
				
	/****
	** Function to get product from the database
	****/
	public function get_product_option($product_id){
			
		$this->db->where('product_id', $product_id);
		$this->db->order_by('id','DESC');
		$q = $this->db->get($this->table);
			
		if($q->num_rows() > 0){
				
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
		
  
	/**
	* Function to count product option
	* @var string
	*/			
	public function count_product_option($product_id){
		
		$this->db->select("*");
		$this->db->group_by('product_id');
		$this->db->from($this->table);		
		$this->db->where('product_id', $product_id);
		
		$count_product_options = $this->db->get();
		
		if($count_product_options->num_rows() > 0)	{
					
			$count = $count_product_options->num_rows();
			return $count;
		}else {
			return false;
		}				
	}
	/**
	* Function to update
	* the product_options
	* variable array $data int $id
	*/	
	public function update_option($data, $id){
			
		$this->db->where('id', $id);
		$query = $this->db->update($this->table, $data);
			
		if ($query){	
			return true;
		}else {
			return false;
		}			
			
	}
		
  
	/**
	* Function to count quantity_available
	* @var int
	*/			
	public function count_quantity_available($product_id){
		
		$this->db->select_sum("quantity","total");	
		$this->db->where('product_id', $product_id);
		
		$query = $this->db->get($this->table);
		$result = $query->result();

		return $result[0]->total;		
	}		
		
	/****
	** Function to get all records from the database
	****/
	public function get_product_options(){
			
		$this->db->order_by('id','DESC');
		$q = $this->db->get($this->table);
			
		if($q->num_rows() > 0){
				
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
				 
	/**
	* Function to count categories
	* @var string
	*/			
	public function count_product_options(){
			
		$count_product_options = $this->db->get($this->table);
		if($count_product_options->num_rows() > 0)	{
					
			$count = $count_product_options->num_rows();
			return $count;
		}else {
			return false;
		}				
	}		

		
	/****
	** Function to get option from the database
	****/
	public function get_option($sizes = '', $colours = ''){
		
		$this->db->select("product_id");
		$this->db->group_by('product_id');
		$this->db->from($this->table);	
		if(!empty($sizes)){
			$this->db->where_in('size',$sizes);
		}
			
		if(!empty($colours)){
			$this->db->where_in('colour',$colours);
		}
		$this->db->order_by('product_id','ASC');
		
		$q = $this->db->get();
			
		if($q->num_rows() > 0){
				
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($q->result_array() as $row){
				$data[] = $row;
			}
			//return $data;
			//convert array from multidimensional array
			//to single array
			//first convert to a string
			////$string_version = implode(', ', array_column($data, 'product_id'));
			$string_version = implode(', ', array_map('implode',$data));
			//convert string to array
			$new_array = explode(',', $string_version);
			return $new_array;
		}
		return false;
	}
		

		
	
	
}