<?php

class Paypal_payment_methods_model extends MY_Model {
    
    const DB_TABLE = 'paypal_payment_methods';
    const DB_TABLE_PK = 'id';

    
    /**
     * Type.
     * @var string 
     */
    public $type;
 
     /**
     * PayPal email.
     * @var string
     */
    public $PayPal_email; 

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

	
	

		public function get_paypal($username){

			$this->db->where('username', $username);
			$payments = $this->db->get('paypal_payment_methods');
				
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


		public function get_paypal_info($id,$username){
			
			$this->db->where('id', $id);	
			$this->db->where('type', 'PayPal');
			$this->db->where('username', $username);
			$payments = $this->db->get('paypal_payment_methods');
				
			if($payments->num_rows() > 0){
				foreach ($payments->result() as $row)
				{
					$data[] = $row;
				}
				return $data;
			}else{
				return false;
			}
		}	
		
		
		
		/**
		* Function to update paypal in db
		*
		*/	
		public function update_paypal($data){
			
			$username = $this->session->userdata('username');
			$id = $this->input->post('id');
			
			$this->db->where('id', $id);
			$this->db->where('username', $username);
			$query = $this->db->update('paypal_payment_methods', $data);
			
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
		public function paypal_deposit($amount, $data1, $data2){
			
			$email = $this->session->userdata('email');
			
			//insert into deposit table
			$query = $this->db->insert('deposits', $data1);
			
		//	$insert_id = $this->db->insert_id();

			if ($query){

				//insert transaction in db
				$this->db->insert('transactions', $data2);
				
				//get users details
				$user = $this->Users->get_user($email);
				
				//update users balance
				//$account_balance = $this->input->post('account_balance');
				$account_balance = '';
				
				foreach($user as $u){
					$account_balance = $u->account_balance;
				}

				$new_balance = $amount + $account_balance;
				
				$update = array(
					'account_balance' => $new_balance,
				);
				$this->db->where('email_address', $email);
				$this->db->update('users', $update);
				
				return true;
			}else {
				return false;
			}
		}
			

		/* Function to ensure the reference is unique 
		* 
		*/	
		public function unique_reference($reference){
			
			$this->db->where('reference', $reference);
			
			$query = $this->db->get($this->table);
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
		}

			
	
	
	
	
	
}

