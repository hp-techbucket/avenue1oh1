<?php

class Answers_model extends MY_Model {
		
		const DB_TABLE = 'answers';
		const DB_TABLE_PK = 'id';

		/**
		 * Question ID.
		 * @var string 
		 */
		public $question_id;
		
		/**
		 * Question.
		 * @var string 
		 */
		public $question;
		
		/**
		 * Username.
		 * @var string 
		 */
		public $username;

			/**
		 * Answer.
		 * @var string 
		 */
		public $answer;

			/**
		 * category.
		 * @var string 
		 */
		public $category;

		/**
		 * Date.
		 * @var datetime 
		 */
		public $time_answered;
		
	  
		public function get_answers(){
			
			$this->db->limit($limit, $start);			
			$this->db->order_by('time_answered','DESC');
			$answers = $this->db->get('answers');
					
			if($answers->num_rows() > 0){
						
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($answers->result() as $row){
						$data[] = $row;
				}
				return $data;
					  
			}else{
				return false;
			}
		}

			
		function get_answer($id){
			
			$this->db->where('question_id', $id);
			$q = $this->db->get('answers');
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}
			
		function get_user_answers($username, $category){
			
			$this->db->where('username', $username);
			$this->db->where('category', $category);
			$q = $this->db->get('answers');
			
			if($q->num_rows() > 0){
				
			  // we will store the results in the form of class methods by using $q->result()
			  // if you want to store them as an array you can use $q->result_array()
			  foreach ($q->result() as $row)
			  {
				$data[] = $row;
			  }
			  return $data;
			}
		}

		/**
		* Function to check if the user 
		* is answering question for the first time
		*  
		*/			
		public function first_time_answer(){
			
			$username = $this->session->userdata('username');
			
			//$answer = $this->input->post('answer');
			$id = $this->input->post('question_id');

			//$this->db->where('answer', $answer);
			$this->db->where('question_id', $id);
			$this->db->where('username', $username);
			
			$query = $this->db->get('answers');
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
		}
		
		/* Function to check that the memorable answer 
		* exists in the database
		*/	
		public function answer_exists(){
			
			$username = $this->session->userdata('username');
			$answer = $this->input->post('answer');
			$id = $this->input->post('question_id');
			
			
			$this->db->like('LOWER(answer)', strtolower($answer));
			$this->db->where('question_id', $id);
			$this->db->where('username', $username);
			
			$query = $this->db->get('answers');
			
			if ($query->num_rows() == 1){
				return true;
			} else {
				return false;
			}
			
		}			
		
				
		/**
		* Function to add the answer 
		* to the answers table in the database
		* @param $data array
		*/		
		public function insert_answer($data){

			$query  = $this->db->insert('answers', $data);
			
			if ($query ){
				return true;
			}else {
				return false;
			}
		}
		
				/**
		* Function to add the answer 
		* to the proposal_answer table in the database
		* @param $data array
		*/		
		public function insert_proposal_answer($data){

			$query  = $this->db->insert('proposal_answer', $data);
			
			if ($query ){
				return true;
			}else {
				return false;
			}
		}
		
		/**
		* Function to update
		* the answer
		* variable array $data, int $id
		*/	
		public function update_answer($data, $id){
			
			$this->db->where('question_id', $id);
			$query = $this->db->update('answers', $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}		
		
		
	
}