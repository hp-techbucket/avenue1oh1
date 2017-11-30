<?php

class Products_model extends MY_Model {
		
		const DB_TABLE = 'products';
		const DB_TABLE_PK = 'id';


		var $table = 'products';
		
		var $column_order = array(null, 'reference_id','category','gender','colour','size','brand','name','price','sale','sale_price','description','image','quantity_available','date_added'); //set column field database for datatable orderable
		
		var $column_search = array('reference_id','category','gender','colour','size','brand','name','price','sale','sale_price','description','quantity_available','date_added'); //set column field database for datatable searchable 
		
		var $order = array('id' => 'desc'); // default order 
		  
    
		/**
		 * product reference_id.
		 * @var string 
		 */
		public $reference_id;

		/**
		 * product category.
		 * @var string 
		 */
		public $category;

		/**
		 * product gender.
		 * @var string 
		 */
		public $gender;

		/**
		 * product colour.
		 * @var string 
		 */
		public $colour;

		/**
		 * product size.
		 * @var string 
		 */
		public $size;

		/**
		 * product brand.
		 * @var string 
		 */
		public $brand;

		/**
		 * product name.
		 * @var string 
		 */
		public $name;

		/**
		 * product price.
		 * @var string 
		 */
		public $price;

		/**
		 * product sale.
		 * @var string 
		 */
		public $sale;

		/**
		 * product sale price.
		 * @var string 
		 */
		public $sale_price;

		/**
		 * product description.
		 * @var string 
		 */
		public $description;

		/**
		 * product image.
		 * @var string
		 */
		public $image;

		/**
		 * product quantity.
		 * @var int 
		 */
		public $quantity_available;

		/**
		 * date_added.
		 * @var date 
		 */
		public $date_added;

			
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
		 * Function to count products
		 * @var string
		 */			
		public function count_products($where = ''){
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			$count_cart = $this->db->get('products');
			if($count_cart->num_rows() > 0)	{
					
				$count = $count_cart->num_rows();
				return $count;
			}else {
				return false;
			}				
		}
		
		
		/****
		** Function to get all records from the database
		****/
		public function get_products($where = '', $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}	


			if(!empty($where)){
				$this->db->where($where);
			}
			
						
			//$this->db->order_by('id','DESC');
			//$this->db->where('quantity_available >', 0);
			$this->db->order_by($column,$order);
			$q = $this->db->get('products');
			
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

				
		/**
		* Function to get all products by filter
		* @var string
		*/			
		public function products_filter($where, $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			//$this->db->where('LOWER(category)',strtolower($category));
			//$this->db->where('LOWER(colour)',strtolower($colours));
			//$this->db->where('LOWER(brand)',strtolower($brands));
			//$this->db->where('LOWER(size)',strtolower($sizes));
			//$this->db->limit($limit, $offset);
			//$this->db->order_by('id','DESC');
			//$this->db->order_by('name','ASC');
			$this->db->order_by($column,$order);		
			$query = $this->db->get('products');
			if($query->num_rows() > 0){

				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count all products by filter
		 * @var string
		 */			
		public function count_products_filter($where){
			
			$this->db->where($where);
			//$this->db->where('LOWER(category)',strtolower($category));
			//$this->db->where('LOWER(colour)',strtolower($colours));
			//$this->db->where('LOWER(brand)',strtolower($brands));
			//$this->db->where('LOWER(size)',strtolower($sizes));
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}	
		
		
		/**
		* Function to add the item 
		* to the products table in the database
		* @param $string Activation key
		*/		
		public function insert_product($data){

			$query  = $this->db->insert('products', $data);
			$insert_id = $this->db->insert_id();
			
			if ($insert_id){
				return $insert_id;
			}else {
				return false;
			}
		}
		
		/**
		* Function to update
		* the product
		* variable array $data int $id
		*/	
		public function update_product($data, $id){
			
			$this->db->where('id', $id);
			$query = $this->db->update('products', $data);
			
			if ($query){	
				return true;
			}else {
				return false;
			}			
			
		}

		
		/****
		** Function to get product by id from the database
		****/
		public function get_product($id){
			
			$this->db->where('id', $id);
			$q = $this->db->get('products');
			
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


		/* Function to ensure the ref id is unique 
		* 
		*/	
		public function is_unique_ref($ref){
			
			$this->db->where('reference_id', $ref);
			
			$query = $this->db->get('products');
			
			if ($query->num_rows() == 0){
				return true;
			} else {
				return false;
			}
			
		}
		
		/**
		* Function to search products
		* @var string
		*/			
		public function search($keyword){
			
			if(is_array($keyword) && count($keyword) > 0){
				
				$like = array();
				$like2 = array();
				$like3 = array();
				$like4 = array();
				$like5 = array();
				
				//"(category LIKE '%".$value."%' OR colour LIKE '%".$value."%' OR brand LIKE '%".$value."%' OR name LIKE '%".$value."%' OR description LIKE '%".$value."%')"
				foreach($keyword as $value) {
					$like[] = "category LIKE '%" . $this->db->escape($value) . "%'";
					$like2[] = "colour LIKE '%" . $this->db->escape($value) . "%'";
					$like3[] = "brand LIKE '%" . $this->db->escape($value) . "%'";
					$like4[] = "name LIKE '%" . $this->db->escape($value) . "%'";
					$like5[] = "description LIKE '%" . $this->db->escape($value) . "%'";
				}
				$like_string = "(" . implode(' OR ', $like) . ")";
				$like_string2 = "(" . implode(' OR ', $like2) . ")";
				$like_string3 = "(" . implode(' OR ', $like3) . ")";
				$like_string4 = "(" . implode(' OR ', $like4) . ")";
				$like_string5 = "(" . implode(' OR ', $like5) . ")";
				
				$this->db->where($like_string);
				$this->db->where($like_string2);
				$this->db->where($like_string3);
				$this->db->where($like_string4);
				$this->db->where($like_string5);
				
			}else{
				$this->db->like('LOWER(category)',strtolower($keyword));
				$this->db->or_like('LOWER(colour)',strtolower($keyword));
				$this->db->or_like('LOWER(brand)',strtolower($keyword));
				$this->db->or_like('LOWER(name)',strtolower($keyword));
				$this->db->or_like('LOWER(description)',strtolower($keyword));
			}
			
			//$this->db->order_by('id','DESC');
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
		
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_search($keyword){
			
			if(is_array($keyword) && count($keyword) > 0){
				
				$like = array();
				$like2 = array();
				$like3 = array();
				$like4 = array();
				$like5 = array();
				
				//"(category LIKE '%".$value."%' OR colour LIKE '%".$value."%' OR brand LIKE '%".$value."%' OR name LIKE '%".$value."%' OR description LIKE '%".$value."%')"
				foreach($keyword as $value) {
					$like[] = "category LIKE '%" . $this->db->escape($value) . "%'";
					$like2[] = "colour LIKE '%" . $this->db->escape($value) . "%'";
					$like3[] = "brand LIKE '%" . $this->db->escape($value) . "%'";
					$like4[] = "name LIKE '%" . $this->db->escape($value) . "%'";
					$like5[] = "description LIKE '%" . $this->db->escape($value) . "%'";
				}
				$like_string = "(" . implode(' OR ', $like) . ")";
				$like_string2 = "(" . implode(' OR ', $like2) . ")";
				$like_string3 = "(" . implode(' OR ', $like3) . ")";
				$like_string4 = "(" . implode(' OR ', $like4) . ")";
				$like_string5 = "(" . implode(' OR ', $like5) . ")";
				
				$this->db->where($like_string);
				$this->db->where($like_string2);
				$this->db->where($like_string3);
				$this->db->where($like_string4);
				$this->db->where($like_string5);
				
			}else{
				$this->db->like('LOWER(category)',strtolower($keyword));
				$this->db->or_like('LOWER(colour)',strtolower($keyword));
				$this->db->or_like('LOWER(brand)',strtolower($keyword));
				$this->db->or_like('LOWER(name)',strtolower($keyword));
				$this->db->or_like('LOWER(description)',strtolower($keyword));
			}
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}
		
		/**
		* Function to search questions
		* @var string
		*/			
		public function search_products($keyword = '', $limit = 100, $offset = 0){
			
			if($keyword != ''){
				$this->db->like('LOWER(name)',strtolower($keyword));
				$this->db->or_like('LOWER(reference_id)',strtolower($keyword));
				$this->db->or_like('LOWER(category)',strtolower($keyword));
				$this->db->or_like('LOWER(gender)',strtolower($keyword));
				$this->db->or_like('LOWER(price)',strtolower($keyword));
			}
			
			$this->db->limit($limit, $offset);
			$this->db->order_by('id','DESC');
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
					
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count search result
		 * @var string
		 */			
		public function count_search_products($keyword = ''){
			
			
			if($keyword != ''){
				$this->db->like('LOWER(name)',strtolower($keyword));
				$this->db->or_like('LOWER(reference_id)',strtolower($keyword));
				$this->db->or_like('LOWER(category)',strtolower($keyword));
				$this->db->or_like('LOWER(gender)',strtolower($keyword));
				$this->db->or_like('LOWER(price)',strtolower($keyword));
			}
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}


				
		/**
		* Function to get products by category
		* @var string
		*/			
		public function get_products_by_category($gender = '', $category = '', $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
			if($category != ''){
				$this->db->where('LOWER(category)',strtolower($category));
			}
					
			
			if($gender != ''){
				$this->db->where('LOWER(gender)',strtolower($gender));
			}
			
			//$this->db->limit($limit, $offset);
			//$this->db->order_by('id','DESC');
			//$this->db->order_by('name','ASC');
			$this->db->order_by($column,$order);
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
		
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count products by category
		 * @var string
		 */			
		public function count_products_by_category($gender = '', $category = ''){
			
			if($category != ''){
				$this->db->where('LOWER(category)',strtolower($category));
			}
				
			if($gender != ''){
				$this->db->where('LOWER(gender)',strtolower($gender));
			}
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}						
		
		/**
		* Function to get all products by gender
		* @var string
		*/			
		public function get_all_products_by_gender($where = '', $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			
			//$this->db->limit($limit, $offset);
			//$this->db->order_by('id','DESC');
			//$this->db->order_by('name','ASC');
			$this->db->order_by($column,$order);		
			$query = $this->db->get('products');
			if($query->num_rows() > 0){

				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count all products by gender
		 * @var string
		 */			
		public function count_all_products_by_gender($where = ''){
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}	


		/**
		* Function to get products by sale
		* @var string
		*/			
		public function get_products_by_sale($gender = '', $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
			$this->db->where('sale','Yes');
			if($gender != ''){
				$this->db->where('LOWER(gender)',strtolower($gender));
			}
				
			//$this->db->limit($limit, $offset);
			//$this->db->order_by('id','DESC');
			//$this->db->order_by('name','ASC');
			$this->db->order_by($column,$order);		
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
		
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count products by sale
		 * @var string
		 */			
		public function count_products_by_sale($gender = ''){
			
			$this->db->where('sale','Yes');
			if($gender != ''){
				$this->db->where('LOWER(gender)',strtolower($gender));
			}
				
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}	
				
		/**
		* Function to get products by type
		* @var string
		*/			
		public function get_products_by_type($where = '', $type = '', $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
			
			if($type == 'clothing'){
				
				$this->db->where('category','Shirts');
				$this->db->or_where('category','Dresses');
				$this->db->or_where('category','Pants');
				$this->db->or_where('category','Lingeries');
				$this->db->or_where('category','Tops');
			}
			
			if($type == 'bags-and-shoes'){
				$string1 = 'Bags';
				$string1 = $this->db->escape($string1);
				$string2 = 'Shoes';
				$string2 = $this->db->escape($string2);
				//$this->db->where("(category = $string1 OR category = $string2)");
				$this->db->where('category','Bags');
				$this->db->or_where('category','Shoes');
			}
			
			if($type == 'sale'){
				$this->db->where('sale','Yes');
			}
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			//$this->db->limit($limit, $offset);
			//$this->db->order_by('id','DESC');
			//$this->db->order_by('name','ASC');
			$this->db->order_by($column,$order);
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
		
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count products by type
		 * @var string
		 */			
		public function count_products_by_type($where = '', $type = ''){
			
			if($type == 'clothing'){
				
				$this->db->where('category','Shirts');
				$this->db->or_where('category','Dresses');
				$this->db->or_where('category','Pants');
				$this->db->or_where('category','Lingeries');
				$this->db->or_where('category','Tops');
			}
			
			if($type == 'bags-and-shoes'){
				$string1 = 'Bags';
				$string1 = $this->db->escape($string1);
				$string2 = 'Shoes';
				$string2 = $this->db->escape($string2);
				//$this->db->where("(category = $string1 OR category = $string2)");
				$this->db->where('category','Bags');
				$this->db->or_where('category','Shoes');
			}
			
			if($type == 'sale'){
				$this->db->where('sale','Yes');
			}
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}						

				
		/**
		* Function to get categorys by filter
		* @var string
		*/			
		public function category_filter($where, $type = '', $sort_by = ''){
			$column = 'name';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
			
			if($type == 'clothing'){
				
				$this->db->where('category','Shirts');
				$this->db->or_where('category','Dresses');
				$this->db->or_where('category','Pants');
				$this->db->or_where('category','Lingeries');
				$this->db->or_where('category','Tops');
				
				
			}
			
			if($type == 'bags-and-shoes'){
				$string1 = 'Bags';
				$string1 = $this->db->escape($string1);
				$string2 = 'Shoes';
				$string2 = $this->db->escape($string2);
				//$this->db->where("(category = $string1 OR category = $string2)");
				$this->db->where('category','Bags');
				$this->db->or_where('category','Shoes');
			}
			
			if($type == 'sale'){
				$this->db->where('sale','Yes');
			}
			
			if(!empty($where)){
				$this->db->where($where);
			}
			
			$this->db->order_by($column,$order);		
			$query = $this->db->get('products');
			if($query->num_rows() > 0){

				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}					

		 /**
		 * Function to count category_filter by type
		 * @var string
		 */			
		public function count_category_filter($where, $type = ''){
			
			if($type == 'clothing'){
				
				$this->db->where('category','Shirts');
				$this->db->or_where('category','Dresses');
				$this->db->or_where('category','Pants');
				$this->db->or_where('category','Lingeries');
				$this->db->or_where('category','Tops');
			}
			
			if($type == 'bags-and-shoes'){
				$string1 = 'Bags';
				$string1 = $this->db->escape($string1);
				$string2 = 'Shoes';
				$string2 = $this->db->escape($string2);
				//$this->db->where("(category = $string1 OR category = $string2)");
				$this->db->where('category','Bags');
				$this->db->or_where('category','Shoes');
			}
			
			if($type == 'sale'){
				$this->db->where('sale','Yes');
			}
			
			$this->db->where($where);
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return $count;
			}else {
				return false;
			}			
				
		}	
		
		/****
		** Function to get all records from the database
		****/
		public function get_product_images($id,$limit=10,$start=0){
			
			$this->db->limit($limit, $start);
			$this->db->where('product_id', $id);
			$q = $this->db->get('product_images');
			
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

		 /**
		 * Function to count product images
		 * @var string
		 */			
		public function count_product_images($id){
			
			$this->db->where('product_id', $id);
			$q = $this->db->get('product_images');
			if($q->num_rows() > 0)	{
					
				$count = $q->num_rows();
				return $count;
			}else {
				return false;
			}				
		}
				

		 /**
		 * Function to delete product images
		 * @var string
		 */			
		public function delete_image($id,$path){
			
			/*$this->db->where('id', $id);
			$this->db->where('id', $image_id);
			$path = './uploads/portfolio/'.$each.'/';
			unlink("uploads/portfolio/".$id);
			$query = $this->db->delete('portfolio_images');
			
			if ($query){	
				return true;
			}else {
				return false;
			}		*/	
			$this->db->delete('product_images', array('id' => $id));

			if($this->db->affected_rows() >= 1){
				if(unlink($path))
				return TRUE;
			} else {
				return FALSE;
			}
			
		}


		 /**
		 * Function to count search result
		 * @var string
		 */			
		 public function count_filter($gender,$category,$brands,$colours,$sizes){
			
			//$array = array('LOWER(gender)' => strtolower($gender), 'LOWER(category)' => strtolower($category), 'LOWER(brand)' => strtolower($brands), 'LOWER(colour)' => strtolower($colours), 'size' => $sizes);	
			
			//$this->db->where($array);
			$this->db->where('LOWER(gender)',strtolower($gender));
			$this->db->where('LOWER(category)',strtolower($category));
			$this->db->where('LOWER(brand)',strtolower($brands));
			$this->db->where('LOWER(colour)',strtolower($colours));
			$this->db->where('LOWER(size)',strtolower($sizes));
			
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return (int)$count;
			}else {
				return false;
			}			
				
		}
		public function count_filter2($gender=null,$category,$brands,$colours,$sizes){
					
			if($gender != '' && $gender != null){
				
				$this->db->where('LOWER(gender)', strtolower($gender));
			}
			if($category != '' && $category != null){
				if($category != 'all' && $category != 'sale'){
					$this->db->where('LOWER(category)', strtolower($category));
				}
			}
			
			/*if(is_array($brands) && count($brands) > 0){
				$this->db->where_in('brand', $brands);
			}*/
			if($brands != '' && $brands != null){
				$this->db->where('LOWER(brand)', strtolower($brands));
			}
			//if(is_array($colours) && count($colours) > 0){
				//$this->db->where_in('colour', $colours);
				//$like = explode(',', $colours);
				/*$statements = array();

				foreach($colours as $val) {
					$color = '';
					if( strpos($val, '-' ) !== false ) {
						$split = explode('-', $value, 2);
						$g = $split[0];
						$color = $split[1];
						
					}else{
						$color = $val;
					}
					$this->db->where('colour', $color);*/
					//$statements[] = "colour LIKE '%" . $val . "%'";
				//}
				//$string = "(" . implode(' OR ', $statements) . ")";
				//$this->db->where($string, FALSE);
			//}
			if($colours != '' && $colours != null){
				$this->db->where('LOWER(colour)', strtolower($colours));
			}
			//if(is_array($sizes) && count($sizes) > 0){
				//$this->db->where_in('size', $sizes);
				/*$string_array = implode(',', $sizes);
				$array_like = explode(',', $string_array);
				$like_statements = array();
				$like = '';
				$size = ''; 
				$lastElement = end($array_like);
				foreach($array_like as $value) {
					$size = '';
					if( strpos($value, '-' ) !== false ) {
						$split = explode('-', $value, 2);
						$gen = $split[0];
						$size = $split[1];
						
					}else{
						$size = $value;
					}
					$this->db->where('size', $size);
					if( strpos($value, '-' ) !== false ) {
						$split = explode('-', $value, 2);
						$gen = $split[0];
						$size = $split[1];
						
					}else{
						$size = $value;
					}
					$like_statements[] = "size LIKE '%" . $size . "%'";
					if($size == $lastElement){
						$like .= "size LIKE '%" . $size . "%'";
					}else{
						$like .= "size LIKE '%" . $size . "%' OR ";
					}
					*/
			//	}
				
				//$like_string = "(" . implode(' OR ', $like_statements) . ")";
				//$this->db->where($like, NULL, FALSE);
			
			//}
			if($sizes != '' && $sizes != null){
				$this->db->where('size', $sizes);
			}
			//$this->db->where_in('job_type', $checked);
			$count_products = $this->db->get('products');
				
			if($count_products->num_rows() > 0)	{
					
				$count = $count_products->num_rows();
				return (int)$count;
			}else {
				return false;
			}			
				
		}
		
		 /**
		 * Function to search result
		 * @var string
		 */			
		public function filter($gender,$category,$brands,$colours,$sizes,$sort_by){
			
			$column = 'id';
			$order = 'ASC';
			
			if( strpos($sort_by, '-' ) !== false ) {
				$sort = explode('-', $sort_by, 2);
				$column = $sort[0];
				$order = $sort[1];
						
				if($order == 'ascending'){
					$order = 'ASC';
				}else{
					$order = 'DESC';
				}
					
				if($column == 'created'){
					$column = 'date_added';
				}
					
				if($column == 'best'){
					$column = 'id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'id';
				$order = 'ASC';
			}
				
			/*if($sort_by != '' && $sort_by != null){
				
				if( strpos($sort_by, '-' ) !== false ) {
					$sort = explode('-', $sort_by, 2);
					$column = $sort[0];
					$order = $sort[1];
						
					if($order == 'ascending'){
						$order = 'ASC';
					}else{
						$order = 'DESC';
					}
					
					if($column == 'created'){
						$column = 'date_added';
					}
					
					if($column == 'best'){
						$column = 'id';
						$order = 'ASC';
					}
					
				}
				if($sort_by == 'featured'){
					$column = 'id';
					$order = 'ASC';
				}
				
			
			}*/
			//$array = array('LOWER(gender)' => strtolower($gender), 'LOWER(category)' => strtolower($category), 'LOWER(brand)' => strtolower($brands), 'LOWER(colour)' => strtolower($colours), 'size' => $sizes);	
			
			//$this->db->where($array);
			$this->db->where('LOWER(gender)',strtolower($gender));
			$this->db->where('LOWER(category)',strtolower($category));
			$this->db->where('LOWER(brand)',strtolower($brands));
			$this->db->where('LOWER(colour)',strtolower($colours));
			$this->db->where('LOWER(size)',strtolower($sizes));
			
			$this->db->order_by($column,$order);
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
			
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}	
		
		public function filter2($gender=null,$brands,$colours,$sizes,$sort_by){
			
			$column = 'id';
			$order = 'ASC';
			if($sort_by != '' && $sort_by != null){
				
				if( strpos($sort_by, '-' ) !== false ) {
					$sort = explode('-', $sort_by, 2);
					$column = $sort[0];
					$order = $sort[1];
						
					if($order == 'ascending'){
						$order = 'ASC';
					}else{
						$order = 'DESC';
					}
					
					if($column == 'created'){
						$column = 'date_added';
					}
					
					if($column == 'best'){
						$column = 'id';
						$order = 'ASC';
					}
					
				}
				if($sort_by == 'featured'){
					$column = 'id';
					$order = 'ASC';
				}
				
			
			}
			
			if($gender != '' && $gender != null){
				$this->db->where('LOWER(gender)', strtolower($gender));
			}
			/*if(is_array($brands) && count($brands) > 0){
				$this->db->where_in('brand', $brands);
			}*/
			if($brands != '' && $brands != null){
				$this->db->where('LOWER(brand)', strtolower($brands));
			}
			/*if(is_array($colours) && count($colours) > 0){
				$this->db->where_in('colour', $colours);
				foreach($colours as $val) {
					$color = '';
					if( strpos($val, '-' ) !== false ) {
						$split = explode('-', $val, 2);
						$g = $split[0];
						$color = $split[1];
						
					}else{
						$color = $val;
					}
					$this->db->where('colour', $color);
					//$statements[] = "colour LIKE '%" . $val . "%'";
				}
			}*/
			if($colours != '' && $colours != null){
				$this->db->where('LOWER(colour)', strtolower($colours));
			}
			//if(is_array($sizes) && count($sizes) > 0){
				//$this->db->where_in('size', $sizes);
				//$array_like = explode(',', $sizes);
				//$like_statements = array();
				/*$string_array = implode(',', $sizes);
				$array_like = explode(',', $string_array);
				$like_statements = array();
				$like = '';
				$size = ''; 
				$lastElement = end($array_like);
				
				foreach($array_like as $value) {
					
					$size = '';
					if( strpos($value, '-' ) !== false ) {
						$split = explode('-', $value, 2);
						$gen = $split[0];
						$size = $split[1];
						
					}else{
						$size = $value;
					}
					$this->db->where('size', $size);
					if( strpos($value, '-' ) !== false ) {
						$split = explode('-', $value, 2);
						$gen = $split[0];
						$size = $split[1];
						
					}else{
						$size = $value;
					}
					$like_statements[] = "size LIKE '%" . $size . "%'";
					if($size == $lastElement){
						$like .= "size LIKE '%" . $size . "%'";
					}else{
						$like .= "size LIKE '%" . $size . "%' OR ";
					}
					*/
				//}
				 
				//$like_string = "(" . implode(' OR ', $like_statements) . ")";
				//$this->db->where($like, NULL, FALSE);
				
				//$this->db->where($like_string, FALSE);
			
			//}
			if($sizes != '' && $sizes != null){
				$this->db->where('size', $sizes);
			}
			$this->db->order_by($column,$order);
			$query = $this->db->get('products');
			if($query->num_rows() > 0){
					
				// we will store the results in the form of class methods by using $q->result()
				// if you want to store them as an array you can use $q->result_array()
				foreach ($query->result() as $row){
					$data[] = $row;
				}
				return $data;
			}
			return false;
		}	
	


		
	
	
		
	
}