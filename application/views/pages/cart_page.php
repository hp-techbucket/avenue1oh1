
	<div class="collection-banner">
		<div class="banner-wrapper">
			<div class="collection-banner-caption">
				<div class="collection-banner-header">
					<?php echo $pageTitle;?>
				</div>
				<div class="collection-banner-text">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo $pageTitle;?>
				</div>
			</div>	
		</div>
	</div>
	
	<br/>
	
	<div class="notif"></div>
	
	
	<div class="container">
	<?php 
		$cartTotal = "";
		$pp_checkout_btn = '';
		$product_id_array = '';
		if(!empty($_SESSION["cart_array"])){
			$i = 0;		
		
	?>
				
		<div class="row">
			<div class="col-md-9 col-sm-8">
			<?php
			foreach($_SESSION["cart_array"] as $each_item){
													
				$item_id = $each_item['product_id'];
													
				$query = $this->db->get_where('products', array('id' => $item_id));
													
				$product_name = '';
				$product_image = '';
				$price = '';
				$details = '';
				$quantity_available = '';
				
				
				if($query){
					foreach ($query->result() as $row){
						$product_image = $row->image;
						$product_name = $row->name;
						$price = $row->price;
						$details = $row->description;
						$quantity_available = $row->quantity_available;
					}							
				}
				
				//product colour
				$product_colour = '';
				if($each_item['colour'] != '' || $each_item['colour'] != null){
					$product_colour = ucwords($each_item['colour']);
				}
					//
					
				//product size
				$product_size = '';
				if($each_item['size'] != '' || $each_item['size'] != null){
					$product_size = $each_item['size'];
				}
				
					
				//product title
				$product_title = $product_name .' - '.$product_size.' / '.$product_colour;
					
				
				$pricetotal = $price * $each_item['quantity'];
				$pricetotal = sprintf("%01.2f", $pricetotal);
				$cartTotal = $pricetotal + $cartTotal;
													
				// Dynamic Checkout Btn Assembly
				$x = $i + 1;
				$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '"><input type="hidden" name="amount_' . $x . '" value="' . $price . '"><input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
				$product_id_array .= "$item_id-".$each_item['quantity'].","; 
													
				$thumbnail = '';
				$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
													
				if(file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive img-rounded" width="150" height="150" />';
				}
				else if($product->image == '' || $product->image == null || !file_exists($filename)){
					$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="150" height="150" />';
				}
				else{
					$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive img-rounded" width="150" height="150" />';
				}
				
			?>
			
			<div class="row row-with-border">
				<div class="col-md-2 col-sm-4">
				
					<a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($item_id));?>/<?php echo url_title(strtolower(html_escape($product_name)));?>" title="<?php echo ucwords(html_escape($product_title));?>">
						<div class="cart-image-container">
							<?php echo $thumbnail ; ?>
							<div class="image-overlay"></div>
						</div>
					</a>
				</div>
				<div class="col-md-8 col-sm-6">
					<div class="product-title2">
						<b><a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($item_id));?>/<?php echo url_title(strtolower(html_escape($product_name)));?>" title="<?php echo ucwords(html_escape($product_title));?>"><?php echo ucwords(html_escape($product_title));?></a></b>
					</div>
					<div class="product-price2">
						<h4><span class='money'><?php echo $each_item['quantity']; ?> X $<?php echo $price; ?></span></h4>
					</div>
					
					<form class="" id="update_cart_form" action="<?php echo base_url('cart/update_cart'); ?>" method="post" enctype="multipart/form-data">
						<div class="">
							<div class="col-xs-4">
								<div class="input-group">
									
									<div class="input-group-btn">
										<button type="button" class="btn btn-default btn-number"  <?php if ($each_item['quantity'] == '1'){ ?> disabled="disabled" <?php  } ?>  data-type="minus" data-field="quantity"><i class="fa fa-minus" aria-hidden="true"></i></button>
									</div>
									
									<input type="text" name="quantity" id="quantity" class="form-control input-number cart-input" onkeypress="return allowNumbersOnly(event)" value="<?php echo $each_item['quantity']; ?>" size="1" maxlength="2" />
									<input type="hidden" name="quantity_available" id="quantityAvailable" value="<?php echo html_escape($quantity_available); ?>" >
									<div class="input-group-btn">
										<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quantity"><i class="fa fa-plus" aria-hidden="true"></i></button>
									</div>
								</div>
							</div>
							<input name="item_to_adjust" id="item_to_adjust" type="hidden" value="<?php echo $item_id; ?>" />
							<input name="index" id="index" type="hidden" value="<?php echo $i; ?>" />
							<input type="hidden" name="product_colour" id="product_colour" value="<?php echo html_escape($product_colour);?>">
							<input type="hidden" name="product_size" id="product_size" value="<?php echo html_escape($product_size);?>">
						</div>
						<button name="adjustBtn<?php echo $item_id; ?>" onclick="updateCart(this);" type="button" class="btn btn-white">UPDATE</button>
					</form>
				</div>
				<div class="col-md-2 col-sm-2">
					<form action="<?php echo base_url('cart/remove_item'); ?>" method="post" enctype="multipart/form-data">
						<div>
						<input name="index_to_remove" type="hidden" value="<?php echo $i; ?>" />
							<button title="Remove" class="btn btn-danger btn-circle" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
							
						</div>
					</form>
				</div>
			</div>
			
			<?php
			$i++;
			}
			
			$cartTotal = sprintf("%01.2f", $cartTotal);
			
			
			?>
			
				<div class="row">
					
					<div class="col-xs-6">
						
						
					</div>
					<div class="col-xs-6">
						
					</div>
				</div>
				
				<br/>
			</div>
			<div class="col-md-3 col-sm-4">
				<div class="cart-header">SUBTOTAL</div>
				<div class="total-amt">$<?php echo $cartTotal; ?></div>
				
				<?php echo form_open('checkout'); ?>
					<p>Special instructions for seller:</p>
					<div class="form-group">
						<textarea rows="5" name="shipping-instructions" class="form-control shipping-instructions"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block"><span class="pull-left"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> PROCESS TO CHECK OUT</button>
					</div>
					
					
					
				<?php echo form_close(); ?>
				<div class="form-group">
					<a title="Continue Shopping" class="btn btn-success btn-block" href="javascript:void(0)" onclick="location.href='<?php echo base_url('collections/all/');?>'"><span class="pull-left"><i class="fa fa-cart-plus" aria-hidden="true"></i></span> CONTINUE SHOPPING</a>		
				</div>
				
				<div class="form-group">
					<a href="#" title="Empty Cart" class="btn btn-danger btn-block" data-toggle="modal" data-target="#emptyCartModal" ><span class="pull-left"><i class="fa fa-trash" aria-hidden="true"></i></span> EMPTY CART</a>	
				</div>
				<div class="row">
					<div class="col-xs-12">
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						
					</div>
				</div>
				
					
					
					
				<br/>
				
				
				
			</div>
		</div>
		
	<?php 
		}else{
	?>
		<div class="row">
			<div class="col-md-12 text-center">
			<h4>Your shopping cart is empty.</h4>
			</div>
			
		</div>
		
	<?php 
		}
	?>
						
	</div>

	<div class="breadcrumb-container">
		<div class="container">
			<div class="custom-breadcrumb">
				<span class="breadcrumb">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo html_escape($pageTitle);?>
				</span>
				<span class="pull-right"><?php echo date('l, F d, Y', time());?></span>
			</div>
		</div>
	</div>

		
			<!-- Empty Cart Modal -->
			<div class="modal fade" id="emptyCartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="text-danger text-center">Empty Cart?</h3>
					<div id="delete-errors"></div>
				  </div>
				  <div class="modal-body text-center">
					<strong>Do you wish to empty your shopping cart?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a title="Empty Cart" class="btn btn-danger" href="javascript:void(0)" onclick="location.href='<?php echo base_url('cart/empty_cart');?>?cmd=emptycart'">EMPTY CART</a>
					
				  </div>
				</div>
			  </div>
			</div>		