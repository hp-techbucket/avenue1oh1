<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {
	
	public function index()
	{
		$this->products();
	}

	
	public function cart(){
		
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
			$data['pageTitle'] = 'Your Shopping Cart';
			
			//assign page ID
			$data['pageID'] = 'cart';
						
			$this->load->view('pages/header', $data);
				
			$this->load->view('pages/cart_page', $data);
				
			$this->load->view('pages/footer');
		//}
			
	
	}		
		/**
		* Function to handle display
		* product details
		* 
		*/	
		public function product_details(){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$product_id = html_escape($this->input->post('id'));
			$id = preg_replace('#[^0-9]#i', '', $product_id); // filter everything but numbers
			
			$detail = $this->db->select('*')->from('products')->where('id',$id)->get()->row();
			
			if($detail){

					$data['id'] = $detail->id;
					
					$data['headerTitle'] = ucwords($detail->name);			
					$category = '<select name="product_category" class="form-control">';
					
					$this->db->from('product_categories');
					$this->db->order_by('id');
					$result = $this->db->get();
					if($result->num_rows() > 0) {
						foreach($result->result_array() as $row){
							$default = ($row['category_name'] == $detail->category)?'selected':'';
							$category .= '<option value="'.$row['category_name'].'" '.$default.'>'.$row['category_name'].'</option>';			
						}
					}
				
					$category .= '</select>';
					
					$data['select_category'] = $category;
					
					$select_gender = '<select name="product_category" class="form-control">';
					$select_gender .= '<option value="0" >Select Gender</option>';
					$select_gender .= '<option value="Male" >Male</option>';
					$select_gender .= '<option value="Female" >Female</option>';
					$select_gender .= '</select>';
					
					$data['select_gender'] = $select_gender;
					
					$thumbnail = '';
					$mini_thumbnail = '';
					$filename = FCPATH.'uploads/products/'.$detail->id.'/'.$detail->image;
					
					if(file_exists($filename)){
						$thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->id.'.jpg" class="img-responsive img-rounded" width="240" height="250" />';
						$mini_thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->id.'.jpg" class="img-responsive img-rounded" width="140" height="150" />';
					}
					
					else if($detail->image == '' || $detail->image == null){
						$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="280" height="280" />';
						$mini_thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="140" height="150" />';
					}
					
					else{
						$thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->image.'" class="img-responsive img-rounded" width="270" height="280" />';
						$mini_thumbnail = '<img src="'.base_url().'uploads/products/'.$detail->id.'/'.$detail->image.'" class="img-responsive img-rounded" width="140" height="150" />';
					}	
					$data['thumbnail'] = $thumbnail;
					$data['mini_thumbnail'] = $mini_thumbnail;
					$data['name'] = ucwords($detail->name);
					$data['category'] = $detail->category;
					
					$gender = $detail->gender;
					if($gender == '' || $gender == '0' || $gender == null){
						$gender = '0';
					}
					$data['gender'] = $gender;
					$data['product_reference'] = $detail->reference_id;
					$data['price'] = number_format($detail->price, 2);
					$data['description'] = stripslashes(wordwrap(nl2br($detail->description), 54, "\n", true));
					$data['quantity_available'] = $detail->quantity_available;

					$data['date_added'] = date("F j, Y", strtotime($detail->date_added));
					
					$data['model'] = 'products';
					$data['success'] = true;
					
					
			}else {
				$data['success'] = false;
			}
			
			echo json_encode($data);
			
		}

	
	
	public function get_cart(){
		
			if(isset($_SESSION["cart_array"])){
				
				$shopping_cart = '<div class="shopping-cart container-smallest">';
				$cartTotal = '';
				$i = 0;
				
				foreach($_SESSION["cart_array"] as $eachItem){
					
					$item_id = $eachItem['product_id'];
					$productName = '';
					$product_image = '';
					$price = '';
					$details = '';
					$product_qty = '';
					$product_details = $this->Products->get_product($item_id);
					if($product_details){
						foreach($product_details as $product){
							$productName = $product->name;
							$product_image = $product->image;
							$price = $product->price;
							$details = $product->description;
						}
					}
					
					//product colour
					$product_colour = '';
					if($eachItem['colour'] != '' || $eachItem['colour'] != null){
						$product_colour = ucwords($eachItem['colour']);
					}
					//
					
					//product size
					$product_size = '';
					if($eachItem['size'] != '' || $eachItem['size'] != null){
						$product_size = ucwords($eachItem['size']);
					}
					$product_size = $eachItem['size'];
					
					//product title
					$product_title = $productName .' - '.$product_size.' / '.$product_colour;
					
					//total quantity
					$product_qty = $eachItem['quantity'];
					//item price
					$pricetotal = $price * $eachItem['quantity'];
													
					//format item price
					$pricetotal = sprintf("%01.2f", $pricetotal);
													
					//total cart amount
					$cartTotal = $pricetotal + $cartTotal;
													
					//product thumbnail
					$thumbnail = '';
													
					$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
													
					if(file_exists($filename)){
														
						$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive" alt="item'.$item_id.'"/>';
														
					}else if($product_image == '' || $product_image == null || !file_exists($filename)){
														
						$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive"  alt="item'.$item_id.'" />';
														
					}else{
														
						$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive" alt="item'.$item_id.'" />';
														
					}
					
					$shopping_cart .= '<div class="row shopping-cart-items custom-gutter">';
					$shopping_cart .= '<div class="col-md-3 col-xs-4"><a href="'.base_url().'collections/product/'.strtolower(html_escape($item_id)).'/'.url_title(strtolower(html_escape($productName))).'" title="'.ucwords(html_escape($product_title)).'"><div class="image-container">'.$thumbnail.'<div class="image-overlay"></div></div></a></div>';
					$shopping_cart .= '<div class="col-md-8 col-xs-6">';
					$shopping_cart .= '<h5><a href="'.base_url().'collections/product/'.strtolower(html_escape($item_id)).'/'.url_title(strtolower(html_escape($productName))).'" title="'.ucwords(html_escape($product_title)).'">'.ucwords(html_escape($product_title)).'</a>';
					$shopping_cart .= '</h5>';
					$shopping_cart .= '<p><span class="small">'.$product_qty.'</span> X <span class="item-price">$'.$price.'</span></p>';
					$shopping_cart .= '</div>';
					$shopping_cart .= '<div class="col-md-1 col-xs-2"><span class="pull-right"><a href="#" title="Remove Item" onclick="removeItem(this,'.$i.','.$item_id.');" id="'.$i.'-'.$item_id.'"><i class="fa fa-times" aria-hidden="true"></i></a></span></div>';
					$shopping_cart .= '</div>';
					$shopping_cart .= '<hr class="style-custom"/>';
					$i++;
				}
				//format total cart amount
				$cartTotal = '$'.sprintf("%01.2f", $cartTotal);
				
				$shopping_cart .= '<div class="row shopping-cart-header">';
				$shopping_cart .= '<div class="col-xs-7"><h4 class="text-center">SUBTOTAL :</h4></div>';
				$shopping_cart .= '<div class="col-xs-5"><div class="shopping-cart-total text-left"><h4 class="price-text">'.$cartTotal.'</h4></div></div>';
				$shopping_cart .= '</div>';
				$shopping_cart .= '<div class="cart-buttons">';
				
				$shopping_cart_link = base_url().'cart';
				$checkout_link = base_url().'checkout';
				$paypal_checkout = base_url().'paypal/payment/';
				$emptycart = base_url('store/empty_cart').'?cmd=emptycart';
				
				$shopping_cart .= '<p><a title="VIEW SHOPPING BAG" href="javascript:void(0)" onclick="location.href=\''.$shopping_cart_link.'\'" class="btn btn-white btn-block">VIEW SHOPPING BAG <i class="fa fa-shopping-bag"></i>('. count($_SESSION["cart_array"]).')</a></p>';
				$shopping_cart .= '<p><a title="Checkout" href="javascript:void(0)" onclick="location.href=\''.$checkout_link.'\'" class="btn btn-orange btn-block"><i class="fa fa-chevron-right" aria-hidden="true"></i> CHECKOUT</a></p>';
				$shopping_cart .= '<p><a title="Empty Cart" class="btn btn-danger btn-block" href="javascript:void(0)" onclick="location.href=\''.$emptycart.'\'">EMPTY CART</a></p>';
				//$shopping_cart .= '<p align="center"><a href="javascript:void(0)" onclick="location.href=\''.$paypal_checkout.'\'"><input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/gold-rect-paypalcheckout-34px.png" name="submit" alt="PayPal Checkout!"></a></p>';
				$shopping_cart .= '</div>';
				$shopping_cart .= '</div>';
				$data['shopping_cart'] = $shopping_cart;
				$data['success'] = true;	
			
				
			}else{
				
				$shopping_cart = '<div class="shopping-cart container-smallest">';
				$shopping_cart .= '<div class="row shopping-cart-items"><div class="col-xs-12 text-center"><h4>Your shopping cart is empty.</h4></div></div>';
				$shopping_cart .= '</div>';
				$data['shopping_cart'] = $shopping_cart;
				$data['success'] = false;	
			
			}
			
				
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
			
			
	}

	
	public function cart_add_item(){
		
		if($this->input->post('product_id') && $this->input->post('cart_quantity')){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('product_id'));
			$quantity = html_escape($this->input->post('cart_quantity'));
			$product_name = html_escape($this->input->post('product_name'));
			$colour = html_escape($this->input->post('colour'));
			$size = html_escape($this->input->post('size'));
			
			$pid = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
			
			
			
			//prepare array for the session variable
			$new_product = array(0 => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
			
			if(isset($_SESSION["cart_array"])) //if we have the session
			{
				$product_id = '';
				$product_quantity = '';
				$product_colour = '';
				$product_size = '';
				$found = false; //set found item to false
				$i = 0;
				$index = 0;
				
				foreach ($_SESSION["cart_array"] as $cart_itm) //loop through session array
				{
					$i++;
					if($cart_itm["product_id"] == $pid){ //the item exist in array
						//same item same size and colour
						$product_id = $cart_itm["product_id"];
						$product_quantity = $cart_itm["quantity"];
						$product_colour = $cart_itm["colour"];
						$product_size = $cart_itm["size"];
						$index = $i;
						$found = true;
					}/*else{
						$product[] = array("product_id" => $cart_itm["product_id"], "quantity" => $new_quantity, "colour" => $cart_itm["colour"], "size" => $cart_itm["size"]);
					}*/
				}
				if ($found == false) {
					array_push($_SESSION["cart_array"], array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
				}else{
					
					if($product_colour == $colour && $product_size == $size){
						
						array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $product_id, "quantity" => $product_quantity + $quantity, "colour" => $product_colour, "size" => $product_size)));
				
					}
					
					if($product_colour == $colour && $product_size != $size){
						
						array_push($_SESSION["cart_array"], array("product_id" => $product_id, "quantity" => $quantity, "colour" => $product_colour, "size" => $size));
					}
					
					//same item, same size but different colour
					if($product_colour != $colour && $product_size == $size){
						
						array_push($_SESSION["cart_array"], array("product_id" => $product_id, "quantity" => $quantity, "colour" => $colour, "size" => $product_size));
						
								
					}
				}
				
			}else{
				//create a new session var if does not exist
				$_SESSION["cart_array"] = array(0 => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
				//$_SESSION["cart_array"] = $new_product;
			}
			
			$data['success'] = true;	
			
			$data['qty'] = $quantity;
			$data['cart_count'] = count($_SESSION["cart_array"]);
			
			$data['notif'] = '<div class="alert alert-success text-center floating-alert-box" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($product_name).' has been added to cart!</div>';
		}
		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);	
	}
	
	
	//OLD VERSION NO PRODUCT OPTIONS
	public function add_cart_item(){
		
		if($this->input->post('product_id') && $this->input->post('cart_quantity')){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('product_id'));
			$quantity = html_escape($this->input->post('cart_quantity'));
			$product_name = html_escape($this->input->post('product_name'));
			$colour = ucwords(html_escape($this->input->post('colour')));
			$size = html_escape($this->input->post('size'));
			
			$pid = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
			
			$product_quantity = '';
			$product_colour = '';
			$product_size = '';
			$wasFound = false;
			$i = 0;
			
			// If the cart session variable is not set or cart array is empty
			if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
				// RUN IF THE CART IS EMPTY OR NOT SET
				$_SESSION["cart_array"] = array(0 => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
			}else {
				// RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
				foreach ($_SESSION["cart_array"] as $each_item) {
					$product_colour = ucwords($each_item["colour"]);
					$product_size = $each_item["size"];
					$i++;
					while (list($key, $value) = each($each_item)) {
						
						if ($key == "product_id" && $value == $pid && $product_colour == $colour && $product_size == $size) {
							
							// That item is in cart already so let's adjust its quantity using array_splice()
							  //array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $pid, "quantity" => $each_item['quantity'] + $quantity)));
							  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $pid, "quantity" => $each_item['quantity'] + $quantity, "colour" => $product_colour, "size" => $product_size)));
							
							$wasFound = true;
							  
						} // close if condition
						
					} // close while loop
				} // close foreach loop
				if ($wasFound == false) {
					array_push($_SESSION["cart_array"], array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
				}
			}
			//redirect('store/cart');
			$this->session->set_flashdata('product_added', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".floating-alert-box").fadeOut("slow"); }, 5000);</script><div class="floating-alert-box text-center"><i class="fa fa-check-circle"></i> '.ucwords($product_name).' added to cart!</div>');
			
			$data['success'] = true;	
			
			$data['qty'] = $quantity;
			$data['cart_count'] = count($_SESSION["cart_array"]);
			
			$data['notif'] = '<div class="alert alert-success text-center floating-alert-box" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($product_name).' has been added to cart!</div>';
			

		}
		
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);		
	}

	//TEST VERSION
	public function add_item(){
		
		if($this->input->post('product_id') && $this->input->post('cart_quantity')){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			//escaping the post values
			$pid = html_escape($this->input->post('product_id'));
			$quantity = html_escape($this->input->post('cart_quantity'));
			$product_name = html_escape($this->input->post('product_name'));
			$colour = html_escape($this->input->post('colour'));
			$size = html_escape($this->input->post('size'));
			
			$pid = preg_replace('#[^0-9]#i', '', $pid); // filter everything but numbers
			$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
			
			
			
			//prepare array for the session variable
			$new_product = array(0 => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
			
			if(isset($_SESSION["cart_array"])) //if we have the session
			{
				$found = false; //set found item to false
				$i = 0;
				
				foreach ($_SESSION["cart_array"] as $cart_itm) //loop through session array
				{
					$product_colour = $cart_itm['colour'];
					$product_size = $cart_itm['size'];
					
					$i++;
					
					if($cart_itm["product_id"] == $pid){ //the item exist in array
						//same item same size and colour
						
						if($product_colour == $colour && $product_size == $size){
							
							//$new_quantity = $cart_itm["quantity"] + $quantity;
							
							$product[] = array("product_id" => $cart_itm["product_id"], "quantity" => $new_quantity, "colour" => $cart_itm["colour"], "size" => $cart_itm["size"]);
							//array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $pid, "quantity" => $cart_itm['quantity'] + $quantity, "colour" => $product_colour, "size" => $product_size)));
							
						}
						//same item but different size or colour
						if($product_colour == $colour && $product_size != $size){
							//$cart_index = count($_SESSION["cart_array"]);
								
							//$_SESSION["cart_array"] = array($cart_index => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
							array_push($_SESSION["cart_array"], array("product_id" => $pid, "quantity" => $quantity, "colour" => $product_colour, "size" => $size));
						}
						if($product_colour != $colour && $product_size == $size){
							//$cart_index = count($_SESSION["cart_array"]);
								
							//$_SESSION["cart_array"] = array($cart_index => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
							array_push($_SESSION["cart_array"], array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $product_size));
						}
						//$product[] = array("product_id" => $cart_itm["product_id"], "quantity" => $cart_itm["quantity"], "colour" => $cart_itm["colour"], "size" => $cart_itm["size"]);
						$found = true;
					}
				}
				if ($found == false) {
					array_push($_SESSION["cart_array"], array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
				}
				/*if($found == false) //we didn't find item in array
				{
					//add new user item in array
					$_SESSION["cart_array"] = array_merge($product, $new_product);
				}else{
					//found user item in array list, and increased the quantity
					$_SESSION["cart_array"] = $product;
				}*/

			}else{
				//create a new session var if does not exist
				$_SESSION["cart_array"] = array(0 => array("product_id" => $pid, "quantity" => $quantity, "colour" => $colour, "size" => $size));
				//$_SESSION["cart_array"] = $new_product;
			}
			
			$data['success'] = true;	
			
			$data['qty'] = $quantity;
			$data['cart_count'] = count($_SESSION["cart_array"]);
			
			$data['notif'] = '<div class="alert alert-success text-center floating-alert-box" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '.ucwords($product_name).' has been added to cart!</div>';
		}
		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);	
	}
	
	
	
	public function update_cart(){
		
		if($this->input->post('item_to_adjust') && $this->input->post('item_to_adjust') != ""){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			// execute some code
			$item_to_adjust = html_escape($this->input->post('item_to_adjust'));
			$quantity = html_escape($this->input->post('quantity'));
			$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
			$colour = ucwords(html_escape($this->input->post('colour')));
			$size = html_escape($this->input->post('size'));
			
			if ($quantity >= 100) { 
				$quantity = 99; 
			}
			if ($quantity < 1){ 
				// Access the array and run code to remove that array index
				$key_to_remove = html_escape($this->input->post('index'));
				if (count($_SESSION["cart_array"]) <= 1) {
					unset($_SESSION["cart_array"]);
				} else {
					unset($_SESSION["cart_array"]["$key_to_remove"]);
					sort($_SESSION["cart_array"]);
				} 
			}
			if ($quantity == ""){ 
				$quantity = 1; 
			}
			$product_id = '';
			$product_quantity = '';
			$product_colour = '';
			$product_size = '';
			$wasFound = false;
			$index = 0;
			$i = 0;
			foreach ($_SESSION["cart_array"] as $each_item) {
				$product_colour = ucwords($each_item["colour"]);
				$product_size = $each_item["size"];	
				$i++;
				while (list($key, $value) = each($each_item)) {
					if ($key == "product_id" && $value == $item_to_adjust && $product_colour == $colour && $product_size == $size) {
						
						// That item is in cart already so let's adjust its quantity using array_splice()
						//array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $item_to_adjust, "quantity" => $quantity)));
						array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $item_to_adjust, "quantity" => $quantity, "colour" => $product_colour, "size" => $product_size)));
					} // close if condition
				} // close while loop
			} // close foreach loop	
			
			//if($wasFound == true){
			//	array_splice($_SESSION["cart_array"], $i-1, 1, array(array("product_id" => $item_to_adjust, "quantity" => $quantity, "colour" => $product_colour, "size" => $product_size)));
			//}
			
			$this->session->set_flashdata('product_updated', '<script type="text/javascript" language="javascript">setTimeout(function() { $(".floating-alert-box").fadeOut("slow"); }, 5000);</script><div class="floating-alert-box text-center"><i class="fa fa-check-circle"></i> Item updated!</div>');
			$data['success'] = true;	
			$data['notif'] = '<div class="alert alert-success text-center floating-alert-box" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-check-circle"></i> Item updated!</div>';
			//redirect('store/cart');			
		}
		
		
		// Encode the data into JSON
		$this->output->set_content_type('application/json');
		$data = json_encode($data);

		// Send the data back to the client
		$this->output->set_output($data);
		//echo json_encode($data);		
	}

	
	public function remove_item(){
		
		if($this->input->post('index_to_remove') != ""){
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			// Access the array and run code to remove that array index
			$key_to_remove = html_escape($this->input->post('index_to_remove'));
			if (count($_SESSION["cart_array"]) <= 1) {
				unset($_SESSION["cart_array"]);
			} else {
				unset($_SESSION["cart_array"]["$key_to_remove"]);
				sort($_SESSION["cart_array"]);
			}
			
			redirect('store/cart');
			
		}else{
			redirect('store/cart');
		}
	}

	
	public function item_remove(){
		
		if($this->input->post('index_to_remove') != ""){
			
			$cart_array = 0;
			
			//escaping the post values
			$this->input->post(NULL, TRUE); // returns all POST items with XSS filter
			
			// Access the array and run code to remove that array index
			$key_to_remove = html_escape($this->input->post('index_to_remove'));
			if (count($_SESSION["cart_array"]) <= 1) {
				unset($_SESSION["cart_array"]);
				$cart_array = 0;
			} else {
				unset($_SESSION["cart_array"]["$key_to_remove"]);
				sort($_SESSION["cart_array"]);
				$cart_array = count($_SESSION["cart_array"]);
			}
			
			//redirect('store/cart');
			$data['success'] = true;	
			$data['cart_count'] = $cart_array;
			$data['notif'] = '<div class="alert alert-success text-center floating-alert-box" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Item has been removed from cart!</div>';

		}else{
			$data['success'] = false;
			$data['notif'] = '<div class="alert alert-danger text-danger text-center floating-alert-box" role="alert"> <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Item not removed from cart!</div>';
		}
			// Encode the data into JSON
			$this->output->set_content_type('application/json');
			$data = json_encode($data);

			// Send the data back to the client
			$this->output->set_output($data);
			//echo json_encode($data);	
	}


	
	public function empty_cart(){
		
		//escaping the get values
		$this->input->get(NULL, TRUE); // returns all GET items with XSS filter
		
		if($this->input->get('cmd') && $this->input->get('cmd') == "emptycart"){
			
			$this->session->unset_userdata('cart_array');
			redirect('store/cart');
			
		}
	}

	
	
		/**
		* Function to process payment 
		* validation
		*/		
		public function paypal_payment(){
			
			if($this->session->userdata('logged_in')){
				
				$data = array(
					//'maskedPaypal' => $this->Users->email_mask($object->PayPal_email),
					'business_email' => 'paypal@avenue1oh1.com',
				);		
				
				$this->session->set_userdata($data);
				
				$email = $this->session->userdata('email');
				
				if(isset($_SESSION["cart_array"])){
					
					$this->session->set_flashdata('paypal_processing', '1');
						
					redirect('paypal/payment-processing');
				
				}
				
				//$data['success'] = true;
				//echo json_encode($data);
			
			}else{
				$this->session->set_flashdata('notice', '<div class="alert alert-danger text-danger text-center" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please login to continue your checkout!</div>');
				$cart_url = base_url().'store/cart';
				//$url = 'login?redirectURL='.urlencode(current_url());
				$url = 'login?redirectURL='.urlencode($cart_url);
				redirect($url);
				//redirect('login');
			}				
		}	
		
		
	
	public function paypal_processing(){
		
		if($this->session->userdata('logged_in')){
			
			if($this->session->flashdata('paypal_processing')){		
			
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
				$data['page_redirect'] = '<script type="text/javascript" language="javascript">setTimeout(function() {$("#paypalForm").submit();}, 5000);</script>';
				
					
				
				//assign page title name
				$data['pageTitle'] = 'PayPal Payment';
				
				//assign page ID
				$data['pageID'] = 'payment_processing';
							
				$this->load->view('pages/header', $data);
					
				$this->load->view('account_pages/payment_processing_page', $data);
					
				$this->load->view('pages/footer');
				
			}else{
				redirect('cart');
			}
			
		 
		}else {
			
			redirect('login');
		} 		
	
	}
		

	public function cc($id){

		if($this->session->userdata('logged_in')){ 
			//assign page title name
			$data['pageTitle'] = 'CC';
					
			//assign page ID
			$data['pageID'] = 'cc';
								
			//load header
			$this->load->view('pages/template-header', $data);
					
			//load main body
			$this->load->view('pages/cc_page', $data);
					
			//load main footer
			$this->load->view('pages/footer');

		}else {
			$url = 'main/login?redirectURL='.urlencode(current_url());
			redirect($url);
			//redirect('home/login/?redirectURL=dashboard');
		} 		

	}


	
	
}
