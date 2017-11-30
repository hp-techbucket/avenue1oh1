<?php

class Store_model extends MY_Model {
	
		// Insert customer details in "customer" table in database.
		public function insert_product($data){
		
			$query = $this->db->insert('products', $data);
			$insert_id = $this->db->insert_id();
			if ($query ){
				return $insert_id;
			}else {
				return false;
			}
		}
		
			
		// Insert customer details in "customer" table in database.
		public function insert_customer($data){
		
			$query = $this->db->insert('customers', $data);
			$insert_id = $this->db->insert_id();
			if ($query ){
				return $insert_id;
			}else {
				return false;
			}
		}

		// Insert order date with users username in "orders" table in database.
		public function insert_order($data){
		
			$query = $this->db->insert('orders', $data);
			$insert_id = $this->db->insert_id();
			if ($query ){
				return $insert_id;
			}else {
				return false;
			}
		}

		// Insert ordered product detail in "order_detail" table in database.
		public function insert_order_detail($data){
		
			$query = $this->db->insert('order_detail', $data);
			if ($query ){
				return true;
			}else {
				return false;
			}
		}

				
		
		
	
}