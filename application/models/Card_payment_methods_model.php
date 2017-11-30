<?php

class Card_payment_methods_model extends MY_Model {
    
    const DB_TABLE = 'card_payment_methods';
    const DB_TABLE_PK = 'id';

    
    /**
     * Type.
     * @var string 
     */
    public $type;
 
     /**
     * Name on card.
     * @var string
     */
    public $name_on_card; 

    /**
     * Card number.
     * @var int
     */
    public $card_number;
    
     /**
     * Expiry month.
     * @var int
     */
    public $expiry_month;

    /**
     * Expiry year.
     * @var int 
     */
    public $expiry_year;

    /**
     * card_billing street address.
     * @var string 
     */
    public $card_billing_street_address;

    /**
     * card billing city.
     * @var string 
     */
    public $card_billing_city;

    /**
     * card billing postcode.
     * @var string 
     */
    public $card_billing_postcode;

    /**
     * card billing state.
     * @var string 
     */
    public $card_billing_state;

    /**
     * card billing country.
     * @var string 
     */
    public $card_billing_country;

    /**
     * username.
     * @var string 
     */
    public $username;

    /**
     * Date added.
     * @var string 
     */
    public $date_added;

	
		
		/**
		* Function to check that the id and cvc 
		* exists in the database
		*/	
		public function valid_cvc($cvc){
			
			$username = $this->session->userdata('username');
			
			$this->db->where('id', $this->input->post('id'));
			$this->db->where('card_cvc', $cvc);
			$this->db->where('username', $username);
			
			$query = $this->db->get('card_payment_methods');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}
			


		public function get_payment_methods($username){
				
			$this->db->where('username', $username);
			$payments = $this->db->get('card_payment_methods');
				
			if($payments->num_rows() > 0){
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				foreach ($payments->result() as $row)
				{
					$data[] = $row;
				}
				return $data;  
			}else{
				return false;
			}
		}			


		public function get_card_info($id,$username){
			
			$this->db->where('id', $id);	
			$this->db->where('username', $username);
			$payments = $this->db->get('card_payment_methods');
				
			if($payments->num_rows() > 0){
					
				  // we will store the results in the form of class methods by using $q->result()
				  // if you want to store them as an array you can use $q->result_array()
				foreach ($payments->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
				  
			}else{
				return false;
			}
		}	
		

		/***
		** Function to add payment method
		**
		***/	
		public function add_cc($data){
			
			$query = $this->db->insert('card_payment_methods', $data);
			if ($query){
				return true;
			}else {
				return false;
			}
		}

		/***
		** Function to add payment method
		**
		***/	
		public function isUnique_cc($cc){
			
			$this->db->where('card_number', $cc);
			$results = $this->db->get('card_payment_methods');
				
			if($results->num_rows() == 0){
				return true;
			}else {
				return false;
			}
		}
								
		
		/**
		* Function to update paypal in db
		*
		*/	
		public function update_card($data){
			
			$username = $this->session->userdata('username');
			$id = $this->input->post('id');
			
			$this->db->where('id', $id);
			$this->db->where('username', $username);
			$query = $this->db->update('card_payment_methods', $data);
			
			if ($query){				
				return true;	
			}else {
				return false;
			}			
		}
		     		
        
	
	
	
	
	
	
}

