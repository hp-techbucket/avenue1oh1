<?php

class Questions_model extends MY_Model {
    
    const DB_TABLE = 'questions';
    const DB_TABLE_PK = 'id';


	var $table = 'questions';
	
    var $column_order = array(null, 'question','category','option_1','option_1_image','option_2','option_2_image'); //set column field database for datatable orderable
	
    var $column_search = array('question','category','option_1','option_1_image','option_2','option_2_image'); //set column field database for datatable searchable 
	
    var $order = array('id' => 'desc'); // default order 
    
	
	/**
     * Quiz question.
     * @var string 
     */
    public $question;
	
	/**
     * Question category.
     * @var string 
     */
    public $category;
	
	/**
     * Question option_1.
     * @var string 
     */
    public $option_1;
	
	/**
     * Question option_1_image.
     * @var string 
     */
    public $option_1_image;
	
	/**
     * Question option_2.
     * @var string 
     */
    public $option_2;
	
	/**
     * Question option_2_image.
     * @var string 
     */
    public $option_2_image;


	
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
	* Function to add question 
	* to the database
	* @param $array
	*/		
	public function insert_question($data){
			
		$query  = $this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();
			
		if ($insert_id){
			return $insert_id;
		}else {
			return false;
		}
	}
	
  
	public function get_questions(){
		
		$this->db->from($this->table);
		$this->db->order_by('id');
		$result = $this->db->get();
		$return = array();
		
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row) {
				$return[$row['question']] = $row['question'];
			}
		}
		
		return $return;
	}
	
	public function get_question($id){  
	
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        return $this->db->get()->result_array();
    }	
	
	public function get_q($id){  
	
        $this->db->where('id', $id);
		$questions = $this->db->get($this->table);
        
		if($questions->num_rows() > 0){
					
			// we will store the results in the form of class methods by using $q->result()
			// if you want to store them as an array you can use $q->result_array()
			foreach ($questions->result() as $row){
					$data[] = $row;
			}
			return $data;	
			
		}else{
			return false;
		}
    }	

		/**
		* Function to update
		* the question
		* variable SESSION stored $username
		*/	
		public function update_question($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update($this->table, $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}
		

		 /**
		 * Function to count questions
		 * @var string $category
		 */			
		public function count_questions($category){
			
			$this->db->where('category', $category);
			$count_questions = $this->db->get($this->table);
				
			if($count_questions->num_rows() > 0)	{
					
				$count = $count_questions->num_rows();
				return $count;
			}else {
					
				return false;
			}				
		}
		
		
		 /**
		 * Function to count questions
		 * @var string
		 */			
		public function current_count($first_id, $id){
			
			//$this->db->select_min('id');
			//$this->db->from('questions');
			$this->db->where("id BETWEEN '$first_id' AND '$id'", NULL, FALSE);
			$count_questions = $this->db->get($this->table);
				
			if($count_questions->num_rows() > 0)	{
					
				$count = $count_questions->num_rows();
				return $count;
			}else {
					
				return false;
			}			
				
		}
	
	
		
		
		
	
}