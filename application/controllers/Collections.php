<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collections extends CI_Controller {

		

		/**
		 * Index Page for this controller.
		 *
		 */
		public function index(){
			
			//set cart count
			$data['cart_count'] = 0;
				
			//check if cart session is set
			if($this->session->userdata('cart_array')){ 
				
				//count cart items
				$cart_count = count($this->session->userdata('cart_array'));
				if($cart_count == '' || $cart_count == null){
						$cart_count = 0;
				}
				$data['cart_count'] = $cart_count;
				
				//get cart items
				$data['cart_array'] = $this->session->userdata('cart_array');
			}
			
			//assign page title name
			$data['pageTitle'] = 'Collections';
			
			//assign page ID
			$data['pageID'] = 'collections';
					
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/collections_page', $data);
			
			$this->load->view('pages/footer');
		}
			

		/**
		 * Function to Filter Products.
		 *
		 */	
		public function filter_search(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//get items from post
			$type = html_escape($this->input->post('type'));
			$type = trim($type);
			
			$sort_by = html_escape($this->input->post('sort_by'));
			$sort_by = trim($sort_by);
			
			//$product_ids = $this->Product_options->get_option($filter_sizes, $filter_colours);
			
			$products_array = ''; 
			
			$count = 0;
			
			//initialise the where array for db query
			$where = array();
			$where2 = array();
			
			//GET FILTER GENDER
			$filter_gender = html_escape($this->input->post('gender'));
			$filter_gender = trim($filter_gender);
			
			if($filter_gender != '' && $filter_gender != null){
				if($filter_gender == 'men'){
					$collection = 'male';
				}else if($filter_gender == 'women'){
					$collection = 'female';
				}else{
					$collection = $filter_gender;
				}
				$where['gender'] = $collection;
				$where2['products.gender'] = $collection;
			}
			
			//GET FILTER COLOURS
			$filter_colours = html_escape($this->input->post('colours'));	
			//$filter_colours = trim($filter_colours);
			
			if($filter_colours != '' && $filter_colours != null){
				//$where['colour'] = $filter_colours;
				$where2['products.colour'] = $filter_colours;
			}
			
			//GET FILTER CATEGORY
			$filter_category = html_escape($this->input->post('category'));
			$filter_category = trim($filter_category);
			$category_gender = '';
			$category_name = '';
			//$category = '';
			
			//check if sizes contains the dash
			if( strpos($filter_category, '-' ) !== false ) {
				$cat = explode('-', $filter_category);
				$category_gender = $cat[0];
				$category_name = $cat[1];
				
				if($category_gender == 'men'){
					$collection = 'male';
				}else if($category_gender == 'women'){
					$collection = 'female';
				}else{
					$collection = $category_gender;
				}
				$where['gender'] = $collection;
				
				$filter_gender = $category_gender;
				$filter_category = $category_name;
			}
			
			
			if($filter_category != '' && $filter_category != 'all' && $filter_category != 'category' && $filter_category != 'sale' && $filter_category != null){
				$where['category'] = ucwords($filter_category);
				$where2['products.category'] = ucwords($filter_category);
			}
			
			//GET FILTER SALE
			if($filter_category == 'sale'){
				$where['sale'] = 'Yes';
				$where2['products.sale'] = 'Yes';
			}
			
			//GET FILTER BRAND
			$filter_brands = html_escape($this->input->post('brands'));
			$filter_brands = trim($filter_brands);
			
			if($filter_brands != '' && $filter_brands != 'all'){
				$where['brand'] = $filter_brands;
				$where2['products.brand'] = $filter_brands;
			}
			
			//GET FILTER SIZES
			$filter_sizes = html_escape($this->input->post('sizes'));
			//$filter_sizes = trim($filter_sizes);
			$size_gender = '';
			$size_cat = '';
			$size_item = '';
			//check if sizes contains the dash
			/*if( strpos($filter_sizes, '-' ) !== false ) {
				$size = explode('-', $filter_sizes);
				if(count($size) == 2){
					$size_gender = $size[0];
					$size_item = $size[1];
				}
				if(count($size) == 3){
					$size_gender = $size[0];
					$size_cat = $size[1];
					$size_item = $size[2];
				}
				$filter_sizes = $size_item;
			}
			*/
			
			//CHECK IF ARRAY IS EMPTY
			
			//$where = "gender='$gender' AND category='$category' AND brand='$brands' AND colour='$colours' AND sizes='$sizes'";
			
			$function = html_escape($this->input->post('function'));
			$function = trim($function);	
			
			if($function == '' || $function == null){
				
				if($type != '' && $type != null){
					//$where['gender'] = '';
					//$filter_gender = '';
					//$filter_category = 'category';
					//$count = $this->Products->count_filter($gender,$category,$brands,$colours,$sizes);
					$count = $this->Products->count_products_by_type($type, $where);
							
					//$count = $this->Products->count_products();
							
					if($count == '' || $count == null){
						$count = 0;
					}
					$data['count'] = $count;
						
					$products_array = $this->Products->get_products_by_type($type, $where, $sort_by);
						
				}else{
					//$filter_gender = 'all';
					//$filter_category = 'all';
					//$count = $this->Products->count_filter($gender,$category,$brands,$colours,$sizes);
					//$count = $this->Products->count_products_filter($where2, $filter_sizes, $filter_colours);
					$count = $this->Products->count_products($where, $filter_sizes, $filter_colours);
					
					if($count == '' || $count == null){
						$count = 0;
					}
					$data['count'] = $count;
						
					//$products_array = $this->Products->products_filter($where, $sort_by);
					$products_array = $this->Products->get_products($where, $filter_sizes, $filter_colours, $sort_by);
					//$products_array = $this->Products->get_products_filter($where2, $filter_sizes, $filter_colours, $sort_by);
					
					//$products_array = $this->Products->get_products($sort_by);	
				}
				
					
			}else{
				
				//, $category,$colours,$brands,$colours,$sizes
				//$count = $this->Products->count_all_products_by_gender($gender);
				//$count = $this->Products->count_products_filter($where);
				$count = $this->Products->count_products($where, $filter_sizes, $filter_colours);
				if($count == '' || $count == null){
					$count = 0;
				}
				$data['count'] = $count;
					
				//$products_array = $this->Products->get_all_products_by_gender($gender,$sort_by);
				//$products_array = $this->Products->products_filter($where, $sort_by);
				$products_array = $this->Products->get_products($where, $filter_sizes, $filter_colours, $sort_by);
			}
			
			$data['title'] = 'FILTER - '.strtoupper($filter_gender);
			
			$product_display = '';
			
			if($products_array){
				
				$data['products_array'] = $products_array;
				
				//item count initialised
				$x = 0;
				
				//start row
				$product_display = '<div class="row list-group products">';
				
				//get items from array
				foreach($products_array as $product){
					
					
					//product quantity
					$quantity_available = $product->quantity_available;
					
					$product_id = $product->id;
					
					if($quantity_available == '' || $quantity_available == null){
						$quantity_available = 0;
					}
					
					
					$product_image = '';
					//$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive group list-group-image" />';
					
					$filename = FCPATH.'uploads/products/'.$product_id.'/'.$product->image;
					if(file_exists($filename)){
						$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product_id.'.jpg" class="img-responsive group list-group-image" />';
					}
					else if($product->image == '' || $product->image == null || !file_exists($filename)){
						$product_image = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive group list-group-image" />';
					}
					else{
						$product_image = '<img src="'.base_url().'uploads/products/'.$product_id.'/'.$product->image.'" class="img-responsive group list-group-image" />';
					}
					
					//$gender
					$gender = strtolower($product->gender);
					
					//category
					$category = strtolower($product->category);
					
					
					$pinterest_image_url = base_url().'uploads/products/'.$product_id.'/'.$product->image.'?v='.time();
					$product_link = base_url().'collections/product/'.html_escape($product_id).'/'.url_title(strtolower(html_escape($product->name)));
					$disabled_link = '';
					$current_stock = '';
					$disabled = '';	
					
					if($quantity_available < 1){
						$quantity_available = 0;
						$disabled = 'disabled';
						$disabled_link = 'disabled';
						$current_stock = 'Out of Stock';
					}else{
						$current_stock = $quantity_available .' units left';
					}
					
					
					//get array of available colours and sizes
					$product_sizes_array = $this->Product_options->get_product_sizes($product->id);
					$product_colours_array = $this->Product_options->get_product_colours($product->id);
					
					$select_colour = '';
					$select_size = '';
					//COLOURS SELECT
					$select_colour = '<select name="product_color" class="form-control select2 input-sm" id="product_color">';
					//$this->db->from('colours');
					//$this->db->order_by('id');
					//$result = $this->db->get();
					if($product_colours_array) {
						foreach($product_colours_array as $option){
							$select_colour .= '<option value="'.$option->colour.'">'.ucwords($option->colour).'</option>';
							
						}
					}
					
					$select_colour .= '</select>';
					
					
					//SIZES SELECT
					$select_size = '<select name="product_size" class="form-control select2 input-sm" id="product_size">';
					
					if($product_sizes_array) {
						foreach($product_sizes_array as $option){
							$select_size .= '<option value="'.$option->size.'">'.$option->size.'</option>';
							
						}
					}
					
					$select_size .= '</select>';
					
					//.item .grid-group-item
					$product_display .= '<div class="item grid-group-item col-md-4 col-sm-6 col-xs-12">';
					
					//.card
					$product_display .= '<div class="card">';
					
					//background-overlay
					$product_display .= '<div class="background-overlay product-wrapper"></div>';//background-overlay
					
					//.card-wrapper
					$product_display .= '<div class="card-wrapper">';
					
					//.card-image
					$product_display .= '<div class="card-image">';
					//image
					$product_display .= '<a href="'.$product_link.'" title="'.ucwords(html_escape($product->name)).'">'.$product_image.'</a>';//image
					$product_display .= '</div>';//.card-image
					
					//.card-content
					$product_display .= '<div class="card-content">';
					
					//.caption-wrap
					$product_display .= '<div class="caption-wrap">';
					
					//.caption
					$product_display .= '<div class="caption">';
					$product_display .= '<h4 class="group inner list-group-item-heading"><a href="'.$product_link.'" title="'.ucwords(html_escape($product->name)).'">'.ucwords(html_escape($product->name)).'</a></h4>';
					$product_display .= '<p class="price">$'.html_escape(number_format($product->price, 2)).'</p>';
					$product_display .= '<p class="stock"><b>'.html_escape($current_stock).'</b></p>';
					$product_display .= '</div>';
					//.caption
					
					$product_display .= '<br/>';
					
					//.product-details
					$product_display .= '<div class="product-details">
											<p class="details">'.substr($product->description, 0, 30).'...</p>
										</div>';//.product-details
					
					//.social-sharing-btns
					$product_display .= '<div class="social-sharing-btns">';
					$product_display .= '<ul class="list-inline">';
					$product_display .= '<li><div class="social-icon share-icon">
															<i class="fa fa-share-alt" aria-hidden="true"></i>
														</div></li>';
					$product_display .= '<li><a href="javascript:void(0)" onclick="addToWishlist('.$product_id.',\''.html_escape($product->name).'\',\''.html_escape($product->price).'\',\''.current_url().'\');" class="btn-wishlist" title="Add to wishlist">
					<div class="social-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
					</a></li>';
					$product_display .= '<li><a href="#" class="'.$disabled_link.'"  title="Add to cart" onclick="toggleOptions(this, event)">
					<div class="social-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div></a></li>';
					$product_display .= '</ul></div>';//.social-sharing-btns
					
					//.social-wrapper link
					$product_display .= '<div class="social-wrapper link">';
					
					//.sharing-icons
					$product_display .= '<div class="sharing-icons">';
					//.icon-list
					$product_display .= '<div class="icon-list"><a target="_blank" href="//www.facebook.com/sharer.php?u='.$product_link.'" class="" title="Share on Facebook" data-toggle="tooltip" data-placement="top"><i class="fa fa-facebook" aria-hidden="true"></i></a></div>';//.icon-list
					
					//.icon-list
					$product_display .= '<div class="icon-list"><a target="_blank" href="//twitter.com/share?url='.$product_link.'&amp;text='.ucwords(html_escape($product->name)).'" class="" title="Share on Twitter" data-toggle="tooltip" data-placement="top"><i class="fa fa-twitter" aria-hidden="true"></i></a></div>';//.icon-list
					
					//.icon-list
					$product_display .= '<div class="icon-list"><a target="_blank" href="//pinterest.com/pin/create/button/?url='.$product_link.'&amp;media='.$pinterest_image_url.'&amp;description='.ucwords(html_escape($product->name)).'" class="" title="Share on Pinterest" data-toggle="tooltip" data-placement="top"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></div>';//.icon-list
					
					$product_display .= '</div>';//.sharing-icons
					
					$product_display .= '</div>';//.social-wrapper link
					
					$product_display .= '</div>';
					//.caption-wrap
					
					$product_display .= '</div>';
					//.card-content
					
					$product_display .= '</div>';//.card-wrapper
					
					//.product-options-wrapper
					$product_display .= '<div class="product-options-wrapper">';
					
					//.product-options
					$product_display .= '<div class="product-options">';
					
					$product_display .= '<h3 class="text-center"><a href="#" class="close-product-options">X</a></h3>';
					
					//.product-options-form
					$product_display .= '<div class="product-options-form animated bounceInRight">';
					
					//form attributes
					$atts = array('class' => 'add_to_cart_form', 'id' => 'add_to_cart_form', 'name' => 'add_to_cart_form', 'role' => 'form');
					
					//open form
					$product_display .= form_open('cart/add_cart_item', $atts);
					
					//.form-group select_size
					$product_display .= '<div class="form-group">';
					$product_display .= '<label for="product_size">Size</label>';
					$product_display .= $select_size;
					$product_display .= '</div>';
					//.form-group select_size
					
					//.form-group select_colour
					$product_display .= '<div class="form-group">';
					$product_display .= '<label for="product_color">Color</label>';
					$product_display .= $select_colour;
					$product_display .= '</div>';
					//.form-group select_colour
					
					//.form-group quantity
					$product_display .= '<div class="form-group">';
					
					//.label
					$product_display .= '<label for="quantity">Quantity</label>';
					
					//.input-group
					$product_display .= '<div class="input-group">';
					
					//.input-group-btn
					$product_display .= '<div class="input-group-btn">
															<button type="button" class="btn btn-default plus-minus" data-type="minus" data-field="quantity" disabled="disabled"><i class="fa fa-minus" aria-hidden="true"></i></button>
														</div>';//.input-group-btn
					//.input-group-btn									
					$product_display .= '<input type="text" name="quantity" id="pQty" class="form-control input-quantity" onkeypress="return allowNumbersOnly(event)" value="1" size="1" maxlength="2" />';//.input-group-btn
					
					//.input-group-btn
					$product_display .= '<div class="input-group-btn">
															<button type="button" class="btn btn-default plus-minus" data-type="plus" data-field="quantity"><i class="fa fa-plus" aria-hidden="true"></i></button>
														</div>';//.input-group-btn
														
					$product_display .= '</div>';//.input-group
					
					$product_display .= '</div>';
					//.form-group quantity
					
					//.input hidden
					$product_display .= '<input type="hidden" name="quantity_available" id="quantityAvailable" value="'.html_escape($quantity_available).'" >';
					$product_display .= '<input type="hidden" name="productID" id="product_id" value="'.html_escape($product_id).'" >';
					$product_display .= '<input type="hidden" name="product_price" id="product_price" value="'.html_escape($product->price).'">';
					$product_display .= '<input type="hidden" name="product_name" id="product_name" value="'.html_escape($product->name).'">';//.input hidden
					
					//.btn-wrap
					$product_display .= '<div class="btn-wrap '.$disabled.'" onclick="javascript:addToCart(this);" ><a class="btn-label">$'.html_escape(number_format($product->price, 2)).'</a><span class="btn-text">ADD TO CART</span></div>';//.btn-wrap
					
					
					//.option-caption
					$product_display .= '<div class="option-caption">';
					
					//.list-group-item-heading
					$product_display .= '<h4 class="group inner list-group-item-heading"><a href="'.$product_link.'" title="'.ucwords(html_escape($product->name)).'">'.ucwords(html_escape($product->name)).'</a></h4>';//.list-group-item-heading
					
					//.price
					$product_display .= '<p class="price group inner list-group-item-text">$'.html_escape(number_format($product->price, 2)).'</p>';//.price
					
					$product_display .= '</div>';//.option-caption
					
					$product_display .= form_close(); //close form
					
					$product_display .= '</div>';//.product-options-form
					
					$product_display .= '</div>';//.product-options
					
					$product_display .= '</div>';//.product-options-wrapper
					
					$product_display .= '</div>';//.card
					
					$product_display .= '</div>';//.item .grid-group-item
					
					
					/////////////////////OLD TEMPLATE////////////////////////
					/*
					$product_display .= '<div class="background-overlay product-wrapper"></div>';
					$product_display .= '<div class="item-wrapper">';
					$product_display .= '<div class="img-overlay"></div>';
					$product_display .= '<div class="thumbnail">';
					$product_display .= '<a href="'.$product_link.'" title="'.ucwords(html_escape($product->name)).'">'.$product_image.'</a>';
					$product_display .= '<div class="caption-wrap">';
					$product_display .= '<div class="caption">';
					$product_display .= '<h4 class="group inner list-group-item-heading"><a href="'.$product_link.'" title="'.ucwords(html_escape($product->name)).'">'.ucwords(html_escape($product->name)).'</a></h4>';
					$product_display .= '<p class="price group inner list-group-item-text">$'.html_escape(number_format($product->price, 2)).'</p>';
					$product_display .= '<p class="stock small group inner list-group-item-text"><b>'.html_escape($current_stock).'</b></p>';
					$product_display .= '</div>';
					$product_display .= '<div class="product-details">
											<p class="details">'.substr($product->description, 0, 30).'...</p>
										</div>';
					$product_display .= '<div class="social-sharing-btns">';
					$product_display .= '<ul class="list-inline">';
					$product_display .= '<li><div class="social-icon share-icon">
															<i class="fa fa-share-alt" aria-hidden="true"></i>
														</div></li>';
					$product_display .= '<li><a href="javascript:void(0)" onclick="addToWishlist('.$product_id.',\''.html_escape($product->name).'\',\''.html_escape($product->price).'\',\''.current_url().'\');" class="btn-wishlist" title="Add to wishlist">
					<div class="social-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></div>
					</a></li>';
					$product_display .= '<li><a href="#" class="'.$disabled_link.'"  title="Add to cart" onclick="toggleOptions(this, event)">
					<div class="social-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div></a></li>';
					$product_display .= '</ul></div>';
					$product_display .= '<div class="social-wrapper link"><div class="sharing-icons">';
					$product_display .= '<div class="icon-list"><a target="_blank" href="//www.facebook.com/sharer.php?u='.$product_link.'" class=""><i class="fa fa-facebook" aria-hidden="true"></i></a></div>';
					$product_display .= '<div class="icon-list"><a target="_blank" href="//twitter.com/share?url='.$product_link.'&amp;text='.ucwords(html_escape($product->name)).'" class=""><i class="fa fa-twitter" aria-hidden="true"></i></a></div>';
					$product_display .= '<div class="icon-list"><a target="_blank" href="//pinterest.com/pin/create/button/?url='.$product_link.'&amp;media='.$pinterest_image_url.'&amp;description='.ucwords(html_escape($product->name)).'" class=""><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></div>';
					$product_display .= '</div></div></div></div></div>';
					$product_display .= '<div class="product-options-wrapper">';
					$product_display .= '<div class="product-options">';
					$product_display .= '<h3 class="text-center"><a href="#" class="close-product-options">X</a></h3>';
					$product_display .= '<div class="product-options-form animated bounceInRight">';
					$atts = array('class' => 'add_to_cart_form', 'id' => 'add_to_cart_form', 'name' => 'add_to_cart_form', 'role' => 'form');
					$product_display .= form_open('cart/add_cart_item', $atts);
					$product_display .= '<div class="form-group">';
					$product_display .= '<label for="product_size">Size</label>'.$select_size;
					$product_display .= '</div>';
					$product_display .= '<div class="form-group">';
					$product_display .= '<label for="product_color">Color</label>'.$select_colour;
					$product_display .= '</div>';
					$product_display .= '<div class="form-group">';
					$product_display .= '<label for="quantity">Quantity</label>';
					$product_display .= '<div class="input-group">';
					$product_display .= '<div class="input-group-btn">
															<button type="button" class="btn btn-default plus-minus" data-type="minus" data-field="quantity" disabled="disabled"><i class="fa fa-minus" aria-hidden="true"></i></button>
														</div>';
					$product_display .= '<input type="text" name="quantity" id="pQty" class="form-control input-quantity" onkeypress="return allowNumbersOnly(event)" value="1" size="1" maxlength="2" />';
					$product_display .= '<div class="input-group-btn">
															<button type="button" class="btn btn-default plus-minus" data-type="plus" data-field="quantity"><i class="fa fa-plus" aria-hidden="true"></i></button>
														</div>';
					$product_display .= '</div>';
					$product_display .= '</div>';
					$product_display .= '<input type="hidden" name="quantity_available" id="quantityAvailable" value="'.html_escape($quantity_available).'" ><input type="hidden" name="productID" id="product_id" value="'.html_escape($product_id).'" ><input type="hidden" name="product_price" id="product_price" value="'.html_escape($product->price).'"><input type="hidden" name="product_name" id="product_name" value="'.html_escape($product->name).'">';
					
					$product_display .= '<div class="btn-wrap '.$disabled.'" onclick="javascript:addToCart(this);" ><a class="btn-label">$'.html_escape(number_format($product->price, 2)).'</a><span class="btn-text">ADD TO CART</span></div>';
					$product_display .= '<div class="option-caption">';
					$product_display .= '<h4 class="group inner list-group-item-heading"><a href="'.$product_link.'" title="'.ucwords(html_escape($product->name)).'">'.ucwords(html_escape($product->name)).'</a></h4>';
					$product_display .= '<p class="price group inner list-group-item-text">$'.html_escape(number_format($product->price, 2)).'</p>';
					$product_display .= '</div>';
					$product_display .= form_close();
					$product_display .= '</div></div></div></div>';
					*/////////////////////////////////////////
					
							//$x++;
							//if($x % 3 == 0){
							//	$product_display .= '</div><br/><div class="row" >';
						//	}
				}
				
				$product_display .= '</div><br/>';
				$data['product_display'] = $product_display;
				$data['success'] = true;
				
			}else{
				//$string_brands = implode(',', $brands);
				//$string_colours = implode(',', $colours);
				//$string_sizes = implode(',', $sizes);
				$string_size = $filter_sizes;
				if(is_array($filter_sizes)){
					$string_size = implode(', ', $filter_sizes);
				}
				
				$string_colours = $filter_colours;
				if(is_array($filter_colours)){
					$string_colours = implode(', ', $filter_colours);
				}
				
				$string_category = $filter_category;
				if(is_array($filter_category)){
					$string_category = implode(', ', $filter_category);
				}
								
					
					//Filters (<b>Gender:</b> '.$filter_gender.' <b>Cat:</b> '.$string_category.' <b>Brand:</b> '.$filter_brands.' <b>Colour:</b> '.$string_colours.' <b>Size:</b> '.$string_size.' <b>Sort:</b> '.$sort_by.')
					
					$product_display = '<div class="row">';
					$product_display .= '<div class="col-sm-12">';
					$product_display .= '<div class="alert alert-danger" role="alert">';
					$product_display .= '<h4 class="text-danger text-center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
					$product_display .= '<span class="sr-only"></span>Listings not found! Filters (<b>Gender:</b> '.$filter_gender.' <b>Cat:</b> '.$string_category.' <b>Brand:</b> '.$filter_brands.' <b>Colour:</b> '.$string_colours.' <b>Size:</b> '.$string_size.' <b>Sort:</b> '.$sort_by.') </h4>';
					$product_display .= '</div>';
					$product_display .= '</div>';
					$product_display .= '</div>';
					//$product_display .= '';
					
					$data['product_display'] = $product_display;
					
					$data['count'] = 0;
					$data['success'] = false;
			}
				
			echo json_encode($data);
			
		}
	

		
	
	/**
	 * Products Page.
	 *
	 */
	public function products($gender = '', $category = 'all')
	{
		
		//set cart count
		$data['cart_count'] = 0;
			
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
		}
		
		//escaping the values
		$gender = html_escape($gender);
		$gender = trim($gender);
		
		$category = html_escape($category);
		$category = trim($category);
		
		$data['gender'] = $gender;
		$data['type'] = '';
		$data['function'] = 'products';
		
		//initialise the where array for db query
		$where = array();
		
		if($gender != '' && $gender != null){
			if($gender == 'men'){
				$collection = 'male';
			}else{
				$collection = 'female';
			}
			$where['gender'] = $collection;
		}
			
		//ALL PRODUCTS BY GENDER
		if($category == 'all'){
			
			//DISPLAY OPTION
			$data['display_option'] = '<strong>ALL PRODUCTS</strong>';
			//GET COUNT OF PRODUCTS
			$count = $this->Products->count_products($where);
			if($count == '' || $count == null){
				$count = 0;
			}
			$data['count'] = $count;
			
			//GET ALL PRODUCTS
			$data['products_array'] = $this->Products->get_products($where);	
			
		}
		//SALE PRODUCTS BY GENDER
		if($gender != '' && $category == 'sale'){
			
			$where['sale'] = 'Yes';
			
			$collection = '';
			if($gender == 'men'){
				$collection = 'male';
			}
			if($gender == 'women'){
				$collection = 'female';
			}
			//DISPLAY OPTION
			$data['display_option'] = '<strong>SALES - '.strtoupper($gender).'</strong>';
			//GET COUNT OF PRODUCTS
			$count = $this->Products->count_products($where);
			if($count == '' || $count == null){
				$count = 0;
			}
			$data['count'] = $count;
			
			//GET ALL PRODUCTS
			$data['products_array'] = $this->Products->get_products($where);	
			
		}
		// PRODUCTS BY GENDER AND CATEGORY
		if($gender != '' && $category != '' && $category != 'all' && $category != 'sale' ){
			
			$collection = '';
			$where['category'] = ucwords($category);
			$where['sale'] = '';
			
			if($gender == 'men'){
				$collection = 'male';
			}
			if($gender == 'women'){
				$collection = 'female';
			}
			//DISPLAY OPTION
			$data['display_option'] = '<strong>'.strtoupper($category).' - '.strtoupper($gender).' </strong>';
			
			//GET COUNT OF PRODUCTS
			//$count = $this->Products->count_products_by_category($collection, $category);
			$count = $this->Products->count_products($where);
			if($count == '' || $count == null){
				$count = 0;
			}
			$data['count'] = $count;
			
			//GET ALL PRODUCTS
			$data['products_array'] = $this->Products->get_products($where);
			//$data['products_array'] = $this->Products->get_products_by_category($collection, $category);
			
		}
		
		
		//CATEGORIES radio
		$categories = '<ul id="category-menu" class="list-unstyled list-styled category-menu">';
		
		//if all is checked, auto select
		if($category == 'all'){
			$categories .= '<li class="active"><input type="radio" id="all-main" checked="checked"><label for="all-main">'.nbs(2).'All Products</label><li>';
		}else{
			$categories .= '<li><input type="radio" id="all-main" ><label for="all-main">'.nbs(2).'All Products</label><li>';
		}
		//if sale is checked, auto select
		if($category == 'sale'){
			$categories .= '<li class="active"><input type="radio" name="category"  id="sale-main" value="sale" checked="checked"><label for="sale-main">'.nbs(2).'Sale</label><li>';
		}else{
			$categories .= '<li><input type="radio" name="category" id="sale-main" value="sale" ><label for="sale-main">'.nbs(2).'Sale</label><li>';
		}
		
		if($gender == 'women'){
			$this->db->from('female_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					//get default checked item
					
					if($category != 'all'){
						$checked = (strtolower($row['category_name']) == strtolower($category))?'checked':'';
						$categories .= '<li><input type="radio" name="category" class="cat" value="women-'.$row['category_name'].'" '.$checked.'><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label><li>';
					}
					if($category == 'all'){
						
						$categories .= '<li><input type="radio" name="category"  class="cat" value="women-'.$row['category_name'].'" ><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label><li>';
					}
				}
			}
		}
		if($gender == 'men'){
			$this->db->from('male_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					//get default checked item
					$checked = '';
					if($category != 'all'){
						$checked = (strtolower($row['category_name']) == strtolower($category))?'checked':'';
						$categories .= '<li><input type="radio" name="category" class="cat" value="men-'.$row['category_name'].'" '.$checked.'><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label><li>';
					}
					if($category == 'all'){
						
						$categories .= '<li><input type="radio" name="category" class="cat" value="men-'.$row['category_name'].'" ><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label><li>';
					}
				}
			}
		}
		
		
		$categories .= '</ul>';
		$data['categories'] = $categories;
			
		//SIDE MENU with the checkbox
		$categories_menu = '<ul id="categories" class="list-unstyled list-styled categories">';
		
		//if all is checked, auto select
		if($category == 'all'){
				
				$categories_menu .= '<li class="active"><input type="radio" id="all-side"  checked="checked"><label for="all-side">'.nbs(2).'All Products</label><li>';
				//<a href="'.base_url().'collections/'.strtolower($gender).'/all" class="category-name" id="'.strtolower($gender).'-all">All Products</a>
		}else{
				$categories_menu .= '<li><input type="radio" id="all-side"><label for="all-side">'.nbs(2).'All Products</label><li>';
				//<a href="'.base_url().'collections/'.strtolower($gender).'/all" class="category-name" id="'.strtolower($gender).'-all">All Products</a>
		}
		//if sale is checked, auto select
		if($category == 'sale'){
			$categories_menu .= '<li class="active"><input type="radio" name="category"  id="sale-side" value="sale" checked="checked"><label for="sale-side">'.nbs(2).'Sale</label><li>';
			//<a href="'.base_url().'collections/'.strtolower($gender).'/sale" class="sales" id="'.strtolower($gender).'-sale">Sale</a>
		}else{
			$categories_menu .= '<li><input type="radio" name="category" id="sale-side" value="sale"><label for="sale-side">'.nbs(2).'Sale</label><li>';
			//<a href="'.base_url().'collections/'.strtolower($gender).'/sale" class="sales" id="'.strtolower($gender).'-sale">Sale</a>
		}	
		
		if($gender == 'women'){
			$this->db->from('female_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
						
					//get default active item
					if($category != 'all'){
						$active = '';
						if(strtolower($row['category_name']) == strtolower($category)){
							$active = 'active';
						}
						$categories_menu .= '<li class="'.$active.'"><input type="radio" name="category" class="cat" value="'.strtolower($gender).'-'.strtolower($row['category_name']).'"><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label></li>';
					}
					if($category == 'all'){
						
						$categories_menu .= '<li class=""><input type="radio" name="category" class="cat" value="'.strtolower($gender).'-'.strtolower($row['category_name']).'"><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label></li>';
						//<a href="'.base_url().'collections/'.strtolower($gender).'/'.strtolower($row['category_name']).'" class="category-name" id="'.strtolower($gender).'-'.strtolower($row['category_name']).'">'.strtoupper($row['category_name']).'</a>
					}
						
				}
			}
		}
		if($gender == 'men'){
			$this->db->from('male_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
						
					//get default active item
					if($category != 'all'){
						$active = '';
						if(strtolower($row['category_name']) == strtolower($category)){
							$active = 'active';
						}
						$categories_menu .= '<li class="'.$active.'"><input type="radio" name="category" class="cat" value="'.strtolower($gender).'-'.strtolower($row['category_name']).'"><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label></li>';
						//<a href="'.base_url().'collections/'.strtolower($gender).'/'.strtolower($row['category_name']).'" class="category-name" id="'.strtolower($gender).'-'.strtolower($row['category_name']).'">'.strtoupper($row['category_name']).'</a>
					}
					if($category == 'all'){
						
						$categories_menu .= '<li class=""><input type="radio" name="category" class="cat" value="'.strtolower($gender).'-'.strtolower($row['category_name']).'"><label for="cat">'.nbs(2).''.strtoupper($row['category_name']).'</label></li>';
						//<a href="'.base_url().'collections/'.strtolower($gender).'/'.strtolower($row['category_name']).'" class="category-name" id="'.strtolower($gender).'-'.strtolower($row['category_name']).'">'.strtoupper($row['category_name']).'</a>
					}
							
				}
			}
		}
		
		$categories_menu .= '</ul>';
		$data['categories_menu'] = $categories_menu;
		
		
		//BRANDS radio
		$brands = '<ul id="brand-options" class="list-unstyled list-styled brands">';
		
		//auto select all, 
		$brands .= '<li class="active"><input type="radio" id="brand-all" checked="checked"><label for="brand-all">'.nbs(2).'All</label></li>';
		
		$this->db->from('brands');
		$this->db->order_by('brand_name');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$brands .= '<li><input type="radio" class="brand-name" name="brands" value="'.$row['brand_name'].'"><label for="brand-name">'.nbs(2).''.ucwords($row['brand_name']).'</label></li>';
			}
		}
		
		$brands .= '</ul>';
		$data['brands'] = $brands;
		
		//COLOURS radio
		$colours = '<ul id="color-options" class="list-inline color-list list-unstyled list-styled">';
		
		$this->db->from('colours');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$background_image = base_url().'assets/images/img/'.strtolower($row['colour_name']).'.png?'.time();
				$colours .= '<li><div class="color-box" title="'.ucwords($row['colour_name']).'" id="'.strtolower($row['colour_name']).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($row['colour_name']).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="checkbox" class="colour_name" name="colours[]" value="'.$row['colour_name'].'"></div></li>';
			}
		}
		
		//auto select all, 
		$colours .= '<li class="active"><div class="color-box all-colours" title="None" id="none" data-toggle="tooltip" data-placement="top" style="background-color:none; "><input type="checkbox" class="colour_name"></div></li>';
		
		$colours .= '</ul>';
		$data['colours'] = $colours;
		
		//SIZES checkbox
		$sizes = '<ul id="size-options" class="list-unstyled list-styled sizes">';
		
		//auto select all, 
		$sizes .= '<li class="active"><input type="checkbox" class="all-sizes col-size" checked="checked"><label for="all-sizes">'.nbs(2).'All</label></li>';
		
		if($gender == 'women'){
			if($category == 'shoes'){
				$this->db->from('female_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$sizes .= '<li><input type="checkbox" class="col-size main-size" name="sizes[]" value="'.$row['size_UK'].'"><label for="main-size">'.nbs(2).'UK '.ucwords($row['size_UK']).'</label></li>';
					}
				}
			}else{
				$this->db->from('female_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$sizes .= '<li><input type="checkbox" class="col-size main-size" name="sizes[]" value="'.$row['size_UK'].'"><label for="main-size">'.nbs(2).'UK '.ucwords($row['size_UK']).'</label></li>';
					}
				}
			}
			
		}
		if($gender == 'men'){ 
			if($category == 'shoes'){
				$this->db->from('male_shoe_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$sizes .= '<li><input type="checkbox" class="col-size main-size" name="sizes[]" value="'.$row['size_UK'].'"><label for="main-size">'.nbs(2).'UK '.ucwords($row['size_UK']).'</label></li>';
					}
				}
			}else{
				$this->db->from('male_sizes');
				$this->db->order_by('id');
				$result = $this->db->get();
				if($result->num_rows() > 0) {
					foreach($result->result_array() as $row){
						$sizes .= '<li><input type="checkbox" class="col-size main-size" name="sizes[]" value="'.$row['size_UK'].'"><label for="main-size">'.nbs(2).'UK '.ucwords($row['size_UK']).'</label></li>';
					}
				}
			}
		}
		
		$sizes .= '</ul>';
		$data['sizes'] = $sizes;
		
		$data['category'] = $category;
		
		//assign page title name
		$data['pageTitle'] = strtoupper($category).' - '.strtoupper($gender);
		
		//assign page ID
		$data['pageID'] = 'shop';
				
		$this->load->view('pages/header', $data);
		
		$this->load->view('pages/products_page', $data);
		
		$this->load->view('pages/footer');
	}
	
	
	/**
	 * All Product Page.
	 *
	 */
	public function all(){
		
		//set cart count
		$data['cart_count'] = 0;
		
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
		}
		
		$data['type'] = '';
		$data['gender'] = '';
		$data['category'] = 'all';
		$data['function'] = '';
		
		//DISPLAY OPTION
		$pageTitle = 'ALL PRODUCTS';
		
		//GET COUNT OF PRODUCTS
		$count = $this->Products->count_products();
		if($count == '' || $count == null){
			$count = 0;
		}
		$data['count'] = $count;
			
		$data['products_array'] = $this->Products->get_products();
			
		//CATEGORIES radio
		$categories = '<ul id="categories" class="list-unstyled list-styled category-menu">';
		
		//if all is checked, auto select
		$categories .= '<li class="active"><div class="radio radio-primary"><input type="radio" id="all-main" checked="checked"><label for="all-main">'.nbs(2).'All Products</label></div></li>';
		
		$this->db->from('female_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories .= '<li><div class="radio radio-primary"><input type="radio" name="category"   class="cat" value="women-'.$row['category_name'].'"><label for="cat">'.nbs(2).'WOMEN - '.strtoupper($row['category_name']).'</label></div></li>';
			}
		}
		$this->db->from('male_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories .= '<li><div class="radio radio-primary"><input type="radio" name="category" class="cat" value="men-'.$row['category_name'].'"><label for="cat">'.nbs(2).'MEN - '.strtoupper($row['category_name']).'</label></div></li>';
			}
		}
		
		$categories .= '</ul>';
		$data['categories'] = $categories;
		
		//SIDE MENU without the radio
		$categories_menu = '<ul id="category-menu" class="list-unstyled list-styled category-menu">';
		//auto select
		$categories_menu .= '<li class="active"><div class="radio radio-primary"><input type="radio" id="all-side"  checked="checked"><label for="all-side">'.nbs(2).'All Products</label></div></li>';
		
		$this->db->from('female_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories_menu .= '<li class=""><div class="radio radio-primary"><input type="radio" name="category"  class="cat" value="women-'.$row['category_name'].'"><label for="cat">'.nbs(2).'WOMEN - '.strtoupper($row['category_name']).'</label></div></li>';
					
			}
		}
		$this->db->from('male_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories_menu .= '<li class=""><div class="radio radio-primary"><input type="radio" name="category"   class="cat" value="men-'.$row['category_name'].'">'.nbs(2).'MEN - '.strtoupper($row['category_name']).'</label></div></li>';
					
			}
		}
		
		$categories_menu .= '</ul>';
		$data['categories_menu'] = $categories_menu;
		
		//BRANDS radio
		$brands = '<ul id="brand-options" class="list-unstyled list-styled brands">';
		
		//auto select all, 
		$brands .= '<li class="active"><div class="radio radio-primary"><input type="radio" id="brand-all" checked="checked"><label for="brand-all">'.nbs(2).'All</label></div></li>';
		
		$this->db->from('brands');
		$this->db->order_by('brand_name');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$brands .= '<li><div class="radio radio-primary"><input type="radio" name="brands" class="brand-name" value="'.$row['brand_name'].'"><label for="brand-name">'.nbs(2).''.ucwords($row['brand_name']).'</label></div></li>';
			}
		}
		
		$brands .= '</ul>';
		$data['brands'] = $brands;
		
		//COLOURS checkbox
		$colours = '<ul id="color-options" class="list-inline color-list list-unstyled list-styled">';
		
		
		$this->db->from('colours');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$background_image = base_url().'assets/images/img/'.strtolower($row['colour_name']).'.png?'.time();
				$colours .= '<li><div class="color-box" title="'.ucwords($row['colour_name']).'" id="'.strtolower($row['colour_name']).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($row['colour_name']).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="checkbox" class="colour_name" name="colours[]" value="'.$row['colour_name'].'"></div></li>';
			}
		}
		$colours .= '<li class="active"><div class="color-box all-colours" title="None" id="none" data-toggle="tooltip" data-placement="top" style="background-color:none; "><input type="checkbox" class="colour_name" ></div></li>';
		
		$colours .= '</ul>';
		$data['colours'] = $colours;
		
		//SIZES checkbox
		$sizes = '<ul id="size-options" class="list-unstyled list-styled sizes">';
		
		//auto select all		
		$sizes .= '<li class="active"><div class="checkbox checkbox-primary"><input type="checkbox" class="all-sizes col-size" checked="checked"><label for="all-sizes">'.nbs(2).'All</label></div></li>';
		
		$this->db->from('female_sizes');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$sizes .= '<li><div class="checkbox checkbox-primary"><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' WOMEN - Clothing - '.ucwords($row['size_US']).'</label></div></li>';
			}
		}
		
		$this->db->from('female_shoe_sizes');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$sizes .= '<li><div class="checkbox checkbox-primary"><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' WOMEN - Shoes - '.ucwords($row['size_US']).'</label></div></li>';
			}
		}
			
		$this->db->from('male_sizes');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$sizes .= '<li><div class="checkbox checkbox-primary"><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' MEN - Clothing - '.ucwords($row['size_US']).'</label></div></li>';
			}
		}
		$this->db->from('male_shoe_sizes');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$sizes .= '<li><div class="checkbox checkbox-primary"><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' MEN - Shoes - '.ucwords($row['size_US']).'</label></div></li>';
			}
		}
		
		$sizes .= '</ul>';
		$data['sizes'] = $sizes;
		
		//DISPLAY OPTION
		$data['display_option'] = '<strong>'.$pageTitle.'</strong>';
			
		//assign page title name
		$data['pageTitle'] = $pageTitle;
		
		//assign page ID
		$data['pageID'] = 'shop';
				
		$this->load->view('pages/header', $data);
		
		//$this->load->view('pages/all_products_page', $data);
		$this->load->view('pages/products_page', $data);
		
		$this->load->view('pages/footer');
	}
	
	
	/**
	 * category Page.
	 *
	 */
	public function category($string = ''){
		
		//set cart count
		$data['cart_count'] = 0;
		
		
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
		}
		
		//escaping the values
		$type = html_escape($string);
		$type = trim($type);
		$pageTitle = strtoupper($type);
			
		$data['type'] = $type;
		$data['gender'] = '';
		$data['category'] = 'category';
		$data['function'] = '';
		
		//DISPLAY OPTION
		if($type == 'bags-and-shoes'){
			$pageTitle = 'BAGS & SHOES';
	
		}
		
		if($type != '' || $type != null){
				
			//GET COUNT OF PRODUCTS
			$count = $this->Products->count_products_by_type($type);
			if($count == '' || $count == null){
				$count = 0;
			}
			$data['count'] = $count;
				
			//GET ALL PRODUCTS
			$data['products_array'] = $this->Products->get_products_by_type($type);	
		}
		//CATEGORIES radio
		$categories = '<ul id="categories" class="list-unstyled categories list-styled category-menu">';
		
		//if all is checked, auto select
		$categories .= '<li class="active"><input type="radio" id="all-main" checked="checked"><label for="all-main">'.nbs(2).'All Products</label></li>';
		
		$this->db->from('female_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories .= '<li><input type="radio" name="category" class="cat" value="women-'.$row['category_name'].'"><label for="cat">'.nbs(2).'WOMEN - '.strtoupper($row['category_name']).'</label></li>';
			}
		}
		$this->db->from('male_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories .= '<li><input type="radio" name="category" class="cat"  value="men-'.$row['category_name'].'"><label for="cat">'.nbs(2).'MEN - '.strtoupper($row['category_name']).'</label></li>';
			}
		}
		
		$categories .= '</ul>';
		$data['categories'] = $categories;
		
		//SIDE MENU with the radio
		$categories_menu = '<ul id="category-menu" class="list-unstyled list-styled category-menu">';
		
		//auto select
		$categories_menu .= '<li class="active"><input type="radio" id="all-side" checked="checked"><label for="all-side">'.nbs(2).'All Products</label></li>';
		//<a href="#" class="category-name">All Products</a>
		
		$this->db->from('female_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories_menu .= '<li class=""><input type="radio" name="category"  class="cat" value="women-'.$row['category_name'].'"><label for="cat">'.nbs(2).'WOMEN - '.strtoupper($row['category_name']).'</label></li>';
					
			}
		}
		$this->db->from('male_categories');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$categories_menu .= '<li class=""><input type="radio" name="category"  class="cat" value="men-'.$row['category_name'].'"><label for="cat">'.nbs(2).'MEN - '.strtoupper($row['category_name']).'</label></li>';
					
			}
		}
		
		$categories_menu .= '</ul>';
		$data['categories_menu'] = $categories_menu;
		
		//BRANDS radio
		$brands = '<ul id="brand-options" class="list-unstyled list-styled brands">';
		
		//auto select all, 
		$brands .= '<li class="active"><input type="radio" id="brand-all"  checked="checked"><label for="brand-all">'.nbs(2).'All</label></li>';
		
		$this->db->from('brands');
		$this->db->order_by('brand_name');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$brands .= '<li><input type="radio" name="brands" class="brand-name" value="'.$row['brand_name'].'"><label for="brand-name">'.nbs(2).''.ucwords($row['brand_name']).'</label></li>';
			}
		}
		
		$brands .= '</ul>';
		$data['brands'] = $brands;
		
		//COLOURS checkbox
		$colours = '<ul id="color-options" class="list-inline color-list list-unstyled list-styled">';
		$this->db->from('colours');
		$this->db->order_by('id');
		$result = $this->db->get();
		if($result->num_rows() > 0) {
			foreach($result->result_array() as $row){
				$background_image = base_url().'assets/images/img/'.strtolower($row['colour_name']).'.png?'.time();
				$colours .= '<li><div class="color-box" title="'.ucwords($row['colour_name']).'" id="'.strtolower($row['colour_name']).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($row['colour_name']).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="checkbox"  class="colour_name" name="colours[]" value="'.$row['colour_name'].'"></div></li>';
			}
		}
		//auto select all, 
		$colours .= '<li class="active"><div class="color-box all-colours" title="None" id="none" data-toggle="tooltip" data-placement="top" style="background-color:none; "><input type="checkbox" class="colour_name" ></div></li>';

		$colours .= '</ul>';
		$data['colours'] = $colours;
		
		//SIZES radio
		$sizes = '<ul id="size-options" class="list-unstyled list-styled sizes">';
		
		//auto select all		
		$sizes .= '<li class="active"><input type="checkbox" class="all-sizes col-size" checked="checked"><label for="all-sizes">'.nbs(2).'All</label></li>';

		if($type == 'bags-and-shoes'){
			
			$this->db->from('female_shoe_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' WOMEN - Shoes - '.ucwords($row['size_US']).'</label></li>';
				}
			}
			
			$this->db->from('male_shoe_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' MEN - Shoes - '.ucwords($row['size_US']).'</label></li>';
				}
			}
		
			
		}
		else if($type == 'clothing'){
			
			$this->db->from('female_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' WOMEN - Clothing - '.ucwords($row['size_US']).'</label></li>';
				}
			}
			
			$this->db->from('male_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' MEN - Clothing - '.ucwords($row['size_US']).'</label></li>';
				}
			}
		
			
		}else{
			
			$this->db->from('female_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' WOMEN - Clothing - '.ucwords($row['size_US']).'</label></li>';
				}
			}
			$this->db->from('female_shoe_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' WOMEN - Shoes - '.ucwords($row['size_US']).'</label></li>';
				}
			}
			
			$this->db->from('male_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' MEN - Clothing - '.ucwords($row['size_US']).'</label></li>';
				}
			}
			$this->db->from('male_shoe_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="checkbox" name="sizes[]" class="main-size" value="'.$row['size_US'].'"><label for="main-size">'.nbs(2).' MEN - Shoes - '.ucwords($row['size_US']).'</label></li>';
				}
			}
		}
		$sizes .= '</ul>';
		$data['sizes'] = $sizes;
		
		//DISPLAY OPTION
		$data['display_option'] = '<strong>'.$pageTitle.'</strong>';
			
		//assign page title name
		$data['pageTitle'] = $pageTitle;
		
		//assign page ID
		$data['pageID'] = 'shop';
				
		$this->load->view('pages/header', $data);
		
		//$this->load->view('pages/all_products_page', $data);
		$this->load->view('pages/products_page', $data);
		
		$this->load->view('pages/footer');
	}
	
	

	/**
	 * View Product Page.
	 *
	 */
	public function view_product($id = '', $name = '')
	{
		//set cart count
		$data['cart_count'] = 0;
			
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
		}
		
		//escaping the values
		$pid = html_escape($id);
		$name = html_escape($name);
		$name = trim($name);
			
		$id = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
		
		$product_details = $this->Products->get_product($id);
		
		if($product_details){
			
			$thumbnail = '';
			$product_id = '';
			
			foreach($product_details as $product){
				
				$product_id = $product->id;
				
				
				$filename = FCPATH.'uploads/products/'.$product->id.'/'.$product->image;
				
				if(file_exists($filename)){
					$thumbnail = '<a id="single_image" href="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" rel="facebox"><img alt="" id="main-img" src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive"/></a>';
				}
				else if($product->image == '' || $product->image == null){
					$thumbnail = '<a id="single_image" href="'.base_url().'assets/images/icons/no-default-thumbnail.png" rel="facebox"><img alt="" id="main-img" src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive"/></a>';
				}
				else{
					$thumbnail = '<a id="single_image" href="'.base_url().'uploads/products/'.$product->id.'/'.$detail->image.'" rel="facebox"><img alt="" id="main-img" src="'.base_url().'uploads/products/'.$product->id.'/'.$detail->image.'" class="img-responsive" /></a>';
				}
				$data['reference_id'] = $product->reference_id;
				$data['category'] = $product->category;
				$data['gender'] = $product->gender;
				
				
				//get array of available colours and sizes
				$product_colours_array = $this->Product_options->get_product_colours($product->id);
				
				$product_sizes_array = $this->Product_options->get_product_sizes($product->id);
				
				//$colour = $product->colour;
				//COLOURS checkbox
				$colours = '<ul id="color-options" class="list-inline color-list list-unstyled list-styled">';
					
				if($product_colours_array){
					
					foreach($product_colours_array as $c){
						$background_image = base_url().'assets/images/img/'.strtolower($c->colour).'.png?'.time();
						$colours .= '<li><div class="color-box" title="'.ucwords($c->colour).'" id="'.strtolower($c->colour).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($c->colour).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="radio" class="" name="colours" value="'.$c->colour.'"></div></li>'; 
										
					}
					
					//check if product colour has more than one value
					//by the presence of a comma
					/*if(strpos($colour, ',') !== false ){
						//convert to an array
						$colourArray = explode(',', $colour);
						foreach($colourArray as $c){
							$background_image = base_url().'assets/images/img/'.strtolower($c).'.png?'.time();
							$colours .= '<li><div class="color-box" title="'.ucwords($c).'" id="'.strtolower($c).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($c).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="radio" class="" name="colours" value="'.$c.'"></div></li>';  
						}
					}else{
						$background_image = base_url().'assets/images/img/'.strtolower($colour).'.png?'.time();
						$colours .= '<li><div class="color-box" title="'.ucwords($colour).'" id="'.strtolower($colour).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($colour).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="radio" class="" id="product-colour" name="colours" value="'.$colour.'"></div></li>';  
					}*/
					
				}else{
					$colours .= '<li>N/A</li>';
					
				}
				$colours .= '</ul>';
				$data['colours'] = $colours;
				
		
				//$size = $product->size;
				//SIZES checkbox
				$sizes = '<ul id="size-options" class="list-inline size-list list-unstyled list-styled">';
					
				if($product_sizes_array){
					foreach($product_sizes_array as $s){
						$sizes .= '<li><div class="size-box" title="Size '.ucwords($s->size).'" id="'.strtolower($s->size).'" data-toggle="tooltip" data-placement="top">'.$s->size.'<input type="checkbox" class="col-size" name="sizes" value="'.$s->size.'"></div></li>'; 
					}
					//check if product size has more than one value
					//by the presence of a comma
					/*if( strpos($size, ',') !== false ){
						//convert to an array
						$sizeArray = explode(',', $size);
						foreach($sizeArray as $s){
							$sizes .= '<li><div class="size-box" title="Size '.ucwords($s).'" id="'.strtolower($s).'" data-toggle="tooltip" data-placement="top">'.$s.'<input type="checkbox" class="col-size" name="sizes" value="'.$s.'"></div></li>'; 
						}
						 
					}else{
						$sizes .= '<li><div class="size-box" title="Size '.ucwords($size).'" id="'.strtolower($size).'" data-toggle="tooltip" data-placement="top"><input type="checkbox" class="col-size" id="product-size" name="sizes" value="'.$size.'"></div></li>';   
					}*/
					
				}else{
					$sizes .= '<li>N/A</li>';
				}
				$sizes .= '</ul>';
				$data['sizes'] = $sizes;
				
				
				$data['brand'] = $product->brand;
				$product_name = ucwords($product->name);
				$data['price'] = '$'.number_format($product->price, 2);
				
				$sale = $product->sale;
				$data['description'] = $product->description;
				
				$quantity_available = $this->Product_options->count_quantity_available($product->id);
								
				if($quantity_available < 1){
					$quantity_available = 0;
				}
				
				//$data['quantity_available'] = $product->quantity_available;
				$data['quantity_available'] = $quantity_available;
				$date_added = date("F j, Y", strtotime($product->date_added));
				$data['date_added'] = $date_added;
				
				$limit=4;
				$start=0;
				$product_images = $this->Products->get_product_images($product->id,$limit,$start);
					
				//start product gallery view
				$gallery = '';
					
				if(!empty($product_images)){
					$a = 1;
					foreach($product_images as $images){
						//product gallery view
						//$gallery .= '';
						$gallery .= '<span href="#" class="gallery-img" title="'.$product_name.' '.$a.'" onclick="changeImage(\''.base_url().'uploads/products/'.$product->id.'/'.$images->image_name.'\')"><img src="'.base_url().'uploads/products/'.$product->id.'/'.$images->image_name.'" id="'.$images->id.'" class="img-responsive"/></span>';
						//$gallery .= '</div>';
						$a++;	
					}
				}
					
				//end portfolio gallery view
				//$gallery .= '</div>';
				$data['product_gallery'] = $gallery;
					
				
			}
			$data['product_image'] = $thumbnail;
			$data['product_name'] = $product_name;
			
			//get previous product
			$data['previous_link'] = '';
			$data['previous_thumbnail'] = '';
			if($id > 1){
				$previous = $this->db->select_max('id')->from('products')->where("id < $id")->get()->row();
				if(!empty($previous)){
					$previous_id = $previous->id;
					$previous_name = '';
					$previous_details = $this->Products->get_product($previous_id);
					if($previous_details){
						foreach($previous_details as $p){
							$previous_name = $p->name;
							
						}
					}
					$data['previous_id'] = $previous_id;
					$data['previous_name'] = $previous_name;
					
					$data['previous_link'] = '<a class="product-nav-control" href="'.base_url().'collections/product/'.$previous_id.'/'.url_title(strtolower($previous_name)).'" title="'.$previous_name.'" id="previous-item"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
					$data['previous_thumbnail'] = '<a class="previous-item" href="'.base_url().'collections/product/'.$previous_id.'/'.url_title(strtolower($previous_name)).'" title="'.$previous_name.'" ><img src="'.base_url().'uploads/products/'.$previous_id.'/'.$previous_id.'.jpg" class="img-responsive img-thumbnail"></a>';
				}else{
					$data['previous_link'] = '<a href="javascript:;" class="product-nav-control disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
					$data['previous_thumbnail'] = '';
				}
			
			}else{
				$data['previous_link'] = '<a href="javascript:;" class="product-nav-control disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
				$data['previous_thumbnail'] = '';
			}
			
			$data['next'] = 0;
			$data['next_link'] = '';
			$data['next_thumbnail'] = '';
			
			$next = $this->db->select_min('id')->from('products')->where("id > $id")->get()->row();	
			if(!empty($next)){
				$next_id = $next->id;
				$next_name = '';
				$next_details = $this->Products->get_product($next_id);
				if($next_details){
					foreach($next_details as $n){
						$next_name = $n->name;
						
					}
				}
				$data['next_id'] = $next_id;
				$data['next_name'] = $next_name;
				$data['next_link'] = '<a class="product-nav-control" href="'.base_url().'collections/product/'.$next_id.'/'.url_title(strtolower($next_name)).'" title="'.$next_name.'" id="next-item"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
				$data['next_thumbnail'] = '<a class="next-item" href="'.base_url().'collections/product/'.$next_id.'/'.url_title(strtolower($next_name)).'" title="'.$next_name.'"><img src="'.base_url().'uploads/products/'.$next_id.'/'.$next_id.'.jpg" class="img-responsive img-thumbnail"></a>';
				
			}else{
				$data['next_link'] = '<a href="javascript:;" class="product-nav-control disabled"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
				$data['next_thumbnail'] = '';
			}
			
			//count reviews
			$count_reviews = $this->Reviews->count_product_reviews($id);
			if($count_reviews == '' || $count_reviews == null || $count_reviews < 1 ){
				$count_reviews = 0 .'reviews';
			}
			else if($count_reviews == 1){
				$count_reviews = '1 review';
			}else{
				$count_reviews = $count_reviews .' reviews';
			}
			//get product ratings
			$rating = $this->db->select_avg('rating')->from('reviews')->where('product_id', $id)->get()->result();
			//$res = $this->db->select_avg('rating','overall')->where('product_id', $id)->get('reviews')->result_array();
			
			$data['rating'] = $rating[0]->rating;
			
			$rating_box = '';
			$new_rating = '<div class="starrr stars"></div> <span class="stars-count">0</span> star(s)<input type="hidden" name="rating" class="rating"/>';
			if($rating[0]->rating == '' || $rating[0]->rating == null || $rating[0]->rating < 1){
				$ratings = 0;
				$rating_box = '<div class="starrr stars-existing"  data-rating="'.round($rating[0]->rating).'"></div> <span class="">No reviews yet</span>';
				
			}else{
				$rating_box = '<div class="starrr stars-existing" data-rating="'.round($rating[0]->rating).'"></div> <span class="stars-count-existing">'.round($rating[0]->rating).'</span> star(s) (<span class="review-count">'.$count_reviews.'</span>)';
			}
			$data['rating_box'] = $rating_box;
			$data['new_rating'] = $new_rating;
			$data['product_id'] = $product_id;
			
			//assign page title name
			$data['pageTitle'] = strtoupper($product_name);
			
			//assign page ID
			$data['pageID'] = 'shop';
					
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/view_product_page', $data);
			
			$this->load->view('pages/footer');
		}
		
	}

	
	
	/**
	 * Search Product Page.
	 *
	 */
	public function search(){
		
		if($this->input->get('keywords')){
			//set cart count
			$data['cart_count'] = 0;
				
			//check if cart session is set
			if($this->session->userdata('cart_array')){ 
				
				//count cart items
				$cart_count = count($this->session->userdata('cart_array'));
				if($cart_count == '' || $cart_count == null){
						$cart_count = 0;
				}
				$data['cart_count'] = $cart_count;
				
				//get cart items
				$data['cart_array'] = $this->session->userdata('cart_array');
			}
					
			//escaping the get values
			$this->input->get(NULL, TRUE); // returns all GET items with XSS filter
				
			$string = html_escape($this->input->get('keywords'));
			$string = trim($string);
			$search = $string;
			$keywords = '';
			
			if( strpos($search, ' ' ) !== false ) {
				$keywords = explode(' ', $search);
			}else{
				$keywords = $search;	
			}
				
			//DISPLAY OPTION
			$data['display_option'] = '<strong>SEARCH RESULTS</strong>';
			
			$data['search'] = $search;
			
			//GET COUNT OF PRODUCTS
			$count = $this->Products->count_search($keywords);
			if($count == '' || $count == null){
				$count = 0;
			}
			$data['count'] = $count;
			
			$data['products_array'] = $this->Products->search($keywords);
			
			//CATEGORIES checkbox
			$categories = '<ul id="categories" class="list-unstyled list-styled">';
			$this->db->from('female_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$categories .= '<li><input type="checkbox" name="category[]" value="women-'.$row['category_name'].'">'.nbs(2).'WOMEN - '.strtoupper($row['category_name']).'</li>';
				}
			}
			$this->db->from('male_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$categories .= '<li><input type="checkbox" name="category[]" value="men-'.$row['category_name'].'">'.nbs(2).'MEN - '.strtoupper($row['category_name']).'</li>';
				}
			}
			//if all is checked, auto select
			$categories .= '<li class="active"><input type="checkbox" name="category[]" value="All Products" checked="checked">'.nbs(2).'All Products</li>';
			$categories .= '</ul>';
			$data['categories'] = $categories;
			
			//SIDE MENU without the checkbox
			$categories_menu = '<ul id="cat-menu" class="list-unstyled list-styled">';
			$this->db->from('female_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$categories_menu .= '<li class=""><a href="'.base_url().'collections/women/'.strtolower($row['category_name']).'" class="category-name" id="women-'.strtolower($row['category_name']).'">WOMEN - '.strtoupper($row['category_name']).'</a></li>';
						
				}
			}
			$this->db->from('male_categories');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$categories_menu .= '<li class=""><a href="'.base_url().'collections/men/'.strtolower($row['category_name']).'" class="category-name" id="male-'.strtolower($row['category_name']).'">MEN - '.strtoupper($row['category_name']).'</a></li>';
						
				}
			}
			//auto select
			$categories_menu .= '<li class="active"><a href="#" class="category-name">All Products</a></li>';
			
			$categories_menu .= '</ul>';
			$data['categories_menu'] = $categories_menu;
			
			//BRANDS radio
			$brands = '<ul id="brand-options" class="list-unstyled list-styled brands">';
			$this->db->from('brands');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$brands .= '<li><input type="radio" name="brands" class="brand-name" value="'.$row['brand_name'].'">'.nbs(2).''.ucwords($row['brand_name']).'</li>';
				}
			}
			
			$brands .= '</ul>';
			$data['brands'] = $brands;
			
			//COLOURS radio
			$colours = '<ul id="color-options" class="list-inline color-list list-unstyled list-styled">';
			$this->db->from('colours');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$background_image = base_url().'assets/images/img/'.strtolower($row['colour_name']).'.png?'.time();
					$colours .= '<li><div class="colours-box" title="'.ucwords($row['colour_name']).'" id="'.strtolower($row['colour_name']).'" data-toggle="tooltip" data-placement="top" style="background-color:'.strtolower($row['colour_name']).'; background-image: url('.$background_image.'); background-position: center; background-repeat:no-repeat; background-size:cover;"><input type="radio" class="colour_name" name="colours" value="'.$row['colour_name'].'"></div></li>';
				}
			}
			
			$colours .= '</ul>';
			$data['colours'] = $colours;
			
			//SIZES radio
			$sizes = '<ul id="size-options" class="list-unstyled list-styled sizes">';
			$this->db->from('female_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="radio" name="sizes" value="female-clothing'.$row['size_US'].'">'.nbs(2).' W - Clothing - '.ucwords($row['size_US']).'</li>';
				}
			}
			$this->db->from('female_shoe_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="radio" name="sizes" value="female-shoes'.$row['size_US'].'">'.nbs(2).' W - Shoes - '.ucwords($row['size_US']).'</li>';
				}
			}
			
			$this->db->from('male_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="radio" name="sizes" value="male-clothing'.$row['size_US'].'">'.nbs(2).' Men - Clothing - '.ucwords($row['size_US']).'</li>';
				}
			}
			$this->db->from('male_shoe_sizes');
			$this->db->order_by('id');
			$result = $this->db->get();
			if($result->num_rows() > 0) {
				foreach($result->result_array() as $row){
					$sizes .= '<li><input type="radio" name="sizes" value="male-shoes'.$row['size_US'].'">'.nbs(2).' M - Shoes - '.ucwords($row['size_US']).'</li>';
				}
			}
			
			$sizes .= '</ul>';
			$data['sizes'] = $sizes;
			
			//assign page title name
			$data['pageTitle'] = 'SEARCH RESULTS';
			
			//assign page ID
			$data['pageID'] = 'search';
					
			$this->load->view('pages/header', $data);
			
			$this->load->view('pages/search_products_page', $data);
			
			$this->load->view('pages/footer');
				
		
		}else{
			redirect('collections/all');
		}
	
	}
	
	

	/**
	 * Fit Guide Page.
	 *
	 */
	public function fit_guide()
	{
		//set cart count
		$data['cart_count'] = 0;
			
		//check if cart session is set
		if($this->session->userdata('cart_array')){ 
			
			//count cart items
			$cart_count = count($this->session->userdata('cart_array'));
			if($cart_count == '' || $cart_count == null){
					$cart_count = 0;
			}
			$data['cart_count'] = $cart_count;
			
			//get cart items
			$data['cart_array'] = $this->session->userdata('cart_array');
		}
		
		//assign page title name
		$data['pageTitle'] = 'Fit guide';
		
		//assign page ID
		$data['pageID'] = 'fit_guide';
				
		$this->load->view('pages/header', $data);
		
		$this->load->view('pages/fit_guide_page', $data);
		
		$this->load->view('pages/footer');
	}
		
	
	
	public function add_to_wishlist(){
		
		if($this->session->userdata('logged_in')){
			
			//escaping the post values
			$id = html_escape($this->input->post('product_id'));
			$product_id = preg_replace('#[^0-9]#i', '', $id); // filter everything but numbers
			$product_name = html_escape($this->input->post('product_name'));
			$product_price = html_escape($this->input->post('product_price'));
			
			$email = $this->session->userdata('email');
			
			$wishlist = array(
				'product_id' => $product_id,
				'product_price' => $product_price,
				'customer_email' => $email,
				'date_added' => date('Y-m-d H:i:s'),
			);
			if($this->Wishlist->unique_wishlist($product_id,$email)){
				
				$this->Wishlist->add_wishlist($wishlist);
				
				//$this->session->set_flashdata('wishlist', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".floating-alert-box").fadeOut("slow"); }, 5000);</script><div class="floating-alert-box text-center text-success"> You have added '.ucwords($product_name).' to your wishlist!</div>');
				
				$data['success'] = true;	
			
				$data['notif'] = '<div class="alert alert-success text-center floating-alert-box" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> You have added '.ucwords($product_name).' to your wishlist!</div>';
			
			}else{
				
				//$this->session->set_flashdata('wishlist', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".floating-alert-box").fadeOut("slow"); }, 5000);</script><div class="floating-alert-box text-center text-danger"> You already have '.ucwords($product_name).' in your wishlist!</div>');
				
				$data['success'] = true;	
			
				$data['notif'] = '<div class="alert text-danger text-center floating-alert-box" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> You already have '.ucwords($product_name).' in your wishlist!</div>';
			
			}
			
			
		}		
		else {
			
				$webpage = html_escape($this->input->post('url'));
			
				//$this->session->set_flashdata('logged_in', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".floating-alert-box").fadeOut("slow"); }, 5000);</script><div class="alert alert-danger floating-alert-box text-center"> Please login to add item to your wishlist!</div>');
				//$url = 'login?redirectURL='.urlencode(current_url());
				//redirect($url);
				//$data['current_url'] = $url;
				$data['success'] = false;
				//$url = base_url().'login?redirectURL='.urlencode($webpage);
				$url = base_url().'login';
				//$data['notif'] = '<div class="alert alert-danger text-danger text-center floating-alert-box" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please login to add item to your wishlist! <a href="javascript:void(0);" onclick="location.href=\''.$url.'\'" title="LOGIN">LOGIN</a></div>';
				$data['notif'] = '<div class="alert alert-danger text-danger text-center floating-alert-box" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please login to add item to your wishlist!</div>';
				//redirect('home/login/?redirectURL=dashboard');
		} 	
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);			
	}

						
	
	
	
	
	
	
	
		
	
	
}
