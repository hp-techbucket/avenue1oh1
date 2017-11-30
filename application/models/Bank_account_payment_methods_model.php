<?php

class Bank_account_payment_methods_model extends MY_Model {
    
    const DB_TABLE = 'bank_account_payment_methods';
    const DB_TABLE_PK = 'id';

    
    /**
     * Bank Name.
     * @var string 
     */
    public $bank_name;
 
     /**
     * Bank address.
     * @var string
     */
    public $bank_location; 

    /**
     * Account name.
     * @var string
     */
    public $account_name;
    
     /**
     * Account Number.
     * @var int
     */
    public $account_number;

    /**
     * Sort Code.
     * @var int 
     */
    public $sort_code;

    /**
     * Bank's SWIFT/BIC code.
     * @var string 
     */
    public $swift_bic;

    /**
     * Username.
     * @var string 
     */
    public $username;

    /**
     * Date added.
     * @var string 
     */
    public $date_added;

	

	public function get_bank_details($username){
				
		$this->db->where('username', $username);
		$bank_details = $this->db->get('bank_account_payment_methods');
				
		if($bank_details->num_rows() > 0){
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
			foreach ($bank_details->result() as $row){
					$data[] = $row;
			}
			return $data;  
		}else{
			return false;
		}
	}			


	/***
	** Function to add bank details
	**
	***/	
	public function add_bank_details($data){
			
		$query = $this->db->insert('bank_account_payment_methods', $data);
		if ($query){
			return true;
		}else {
			return false;
		}
	}
				
		
	/**
	* Function to update bank details in db
	*
	*/	
	public function update_bank_details($data){
			
		$username = $this->session->userdata('username');
		$id = $this->input->post('id');
			
		$this->db->where('id', $id);
		$this->db->where('username', $username);
		$query = $this->db->update('bank_account_payment_methods', $data);
			
		if ($query){				
			return true;	
		}else {
			return false;
		}			
	}
		     		
 		/***
		** Function to see if bank details already exists
		**
		***/	
		public function isUnique_bank_details($bank_name,$account_name,$account_number){
			
			$username = $this->session->userdata('username');
			
			$this->db->where('bank_name', $bank_name);
			$this->db->where('account_name', $account_name);
			$this->db->where('account_number', $account_number);
			$this->db->where('username', $username);
			$results = $this->db->get('bank_account_payment_methods');
				
			if($results->num_rows() == 0){
				return true;
			}else {
				return false;
			}
		}
								       
	
	
	
	
	
	
}

