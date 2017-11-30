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
	 
		public function count_all(){
			
			$this->db->from($this->table);
			return $this->db->count_all_results();
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
		
		/****
		** Function to get all records from the database
		****/
		public function get_products($where = '', $sizes = '', $colours = '', $sort_by = ''){
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
			
			//$product_ids = '';
			
			if($sizes != '' || $colours != ''){
				$product_ids = $this->Product_options->get_option($sizes, $colours);
				$this->db->where_in('id',$product_ids);
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
		 * Function to count products
		 * @var string
		 */			
		public function count_products($where = '', $sizes = '', $colours = ''){
			
			//$product_ids = '';
			
			if($sizes != '' || $colours != ''){
				$product_ids = $this->Product_options->get_option($sizes, $colours);
				$this->db->where_in('id',$product_ids);
			}
			
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
		public function get_products_filter($where2 = '', $sizes = '', $colours = '', $sort_by = ''){
			$column = 'products.name';
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
					$column = 'products.date_added';
				}
					
				if($column == 'best'){
					$column = 'products.id';
					$order = 'ASC';
				}
					
			}
			if($sort_by == 'featured'){
				$column = 'products.id';
				$order = 'ASC';
			}	

			
			$this->db->select("*");
			
			//$this->db->from('product_options');
			$this->db->from($this->table);
			
			if(!empty($where2)){
				$this->db->where($where2);
			}
			
			$this->db->join('product_options', 'product_options.product_id = products.id');
			$this->db->group_by('product_options.product_id');
			if(!empty($sizes)){
				$this->db->where_in('product_options.size',$sizes);
			}
			
			if(!empty($colours)){
				$this->db->where_in('product_options.colour',$colours);
			}
			
			$q = $this->db->get();
			
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
		 * Function to count products
		 * @var string
		 */			
		public function count_products_filter($where2 = '', $sizes = '', $colours = ''){
			
			
			
			$this->db->select("*");
			
			//$this->db->from('product_options');
			$this->db->from($this->table);
			
			if(!empty($where2)){
				$this->db->where($where2);
			}
			
			$this->db->join('product_options', 'product_options.product_id = products.id');
			$this->db->group_by('product_options.product_id');
			if(!empty($sizes)){
				$this->db->where_in('product_options.size',$sizes);
			}
			
			if(!empty($colours)){
				$this->db->where_in('product_options.colour',$colours);
			}
			
			$count_cart = $this->db->get();
			if($count_cart->num_rows() > 0)	{
					
				$count = $count_cart->num_rows();
				return $count;
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
					$like2[] = "gender LIKE '%" . $this->db->escape($value) . "%'";
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
				$this->db->or_like('LOWER(gender)',strtolower($keyword));
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
					$like2[] = "gender LIKE '%" . $this->db->escape($value) . "%'";
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
				$this->db->or_like('LOWER(gender)',strtolower($keyword));
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
		* Function to get products by type
		* @var string
		*/			
		public function get_products_by_type($type = '', $where = '', $sort_by = ''){
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
		public function count_products_by_type($type = '', $where = ''){
			
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
		* Function to get products by type
		* @var string
		*/			
		public function get_products_by_type_filter($where = '', $type = '', $sort_by = ''){
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
		public function count_products_by_type_filter($where = '', $type = ''){
			
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


	


		
	
	
		
	
}