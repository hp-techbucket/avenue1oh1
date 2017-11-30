
		
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide store-carousel" data-ride="carousel" align="center">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
		
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="<?php echo base_url('assets/images/banners/collection_slider_img_1ecb9.jpg');?>" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h3>Awesome dresses and outfits</h3>
              
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="<?php echo base_url('assets/images/banners/collection_slider_img_2ecb9.jpg');?>" alt="Second slide">
		  <div class="container">
            <div class="carousel-caption">
              <h3>Awesome accessories on display</h3>
             
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="<?php echo base_url('assets/images/banners/collection_slider_img_3ecb9.jpg');?>" alt="Third slide">
		   <div class="container">
            <div class="carousel-caption">
              <h3>Awesome footwear</h3>
             
            </div>
          </div>
        </div>
		
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->

		
<div class="filter-container">
	
	<div class="container-fluid" align="center">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="filter-heading">
					<span class="filter-title"><?php echo html_escape($pageTitle);?></span>
					<span class="products-count"><?php echo html_escape($count);?> </span> PRODUCT(S)
				</div>
			</div>
			
		</div>
	
	</div>
	
</div>
 
<div class="products-container">

	<div class="container">
		<div class="row">
			<div class="col-md-3 sidebar-wrapper">
				<div class="">
					<div class="sidebar-section">
						<div class="sidebar-header" data-toggle="collapse" data-target="#shipping-tab">
							FREE SHIPPING
						</div>
						<p id="shipping-tab">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pharetra, ligula non mollis pretium, lectus libero sodales augue, interdum auctor mauris dui non risus. Nulla facilisi. Nunc rutrum diam in elit sagittis eget viverra erat viverra. Morbi imperdiet aliquet libero vel rhoncus. Integer.</p>
					</div>
					
					
				</div>
			</div>	
			<div class="col-md-9">

				<!-- .products-display-->
				<div class="products-display">
						<?php
					
							if($products_array) {
								//item count initialised
								$x = 0;
								//start row
								echo '<div class="row list-group products">';
								//get items from array
								foreach($products_array as $product){
									//echo '<div class="item grid-group-item col-md-4 col-sm-6 col-xs-12">';
									
									//product quantity
									$pinterest_url = '';
									$product_image = '';
									$filename = FCPATH.'uploads/products/'.$product->id.'/'.$product->image;
									if(file_exists($filename)){
										$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive group list-group-image" />';
										
									}
									else if($product->image == '' || $product->image == null || !file_exists($filename)){
										$product_image = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive group list-group-image" />';
										//$pinterest_image = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png"/>';
									}
									else{
										$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->image.'" class="img-responsive group list-group-image" />';
										
									}
									//item-wrapper
									//width:100%;
									$pinterest_image_url = base_url().'uploads/products/'.$product->id.'/'.$product->image.'?v='.time();
									$product_link = base_url().'collections/product/'.html_escape($product->id).'/'.url_title(strtolower(html_escape($product->name)));
									$disabled_link = '';
									$current_stock = '';
									
									$quantity_available = $this->Product_options->count_quantity_available($product->id);
									//$product->quantity_available
									if($quantity_available < 1){
										$quantity_available = 0;
										$disabled_link = 'disabled';
										$current_stock = 'Out of Stock';
									}else{
										$current_stock = $quantity_available .' units left';
									}
									
									//$gender
									$gender = strtolower($product->gender);
									
									//category
									$category == strtolower($product->category);
									
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
									$select_size = '<select name="product_size"  class="form-control select2 input-sm" id="product_size">';
									
									if($product_sizes_array) {
										foreach($product_sizes_array as $option){
											$select_size .= '<option value="'.$option->size.'">'.$option->size.' UK</option>';
											
										}
									}
									
									$select_size .= '</select>';
									
						?>	
							<!-- .item .grid-group-item .col-md-4 .col-sm-6 .col-xs-12-->
							<div class="item grid-group-item col-md-4 col-sm-6 col-xs-12">
								
								<!-- .card-->
								<div class="card">
									
									<!-- .background-overlay .product-wrapper-->
									<div class="background-overlay product-wrapper"></div>
									
									<!-- .card-wrapper-->
									<div class="card-wrapper">
										
										<!-- .card-image-->
										<div class="card-image">
										
										  <!-- image-->
											<a href="<?php echo $product_link; ?>" title="<?php echo ucwords(html_escape($product->name));?>">
												<?php echo $product_image;?>
											
											</a>
											<!-- /image-->
										</div>
										<!-- /.card-image-->
										
										<!-- .card-content-->
										<div class="card-content">
										
										 <!-- .caption-wrap-->
											<div class="caption-wrap">
											
												<!-- .caption-->
												<div class="caption">
													<h4 class="group inner list-group-item-heading"><a href="<?php echo $product_link; ?>" title="<?php echo ucwords(html_escape($product->name));?>"><?php echo ucwords(html_escape($product->name));?></a></h4>
													
													<p class="price">$<?php echo html_escape(number_format($product->price, 2)) ;?> </p>
													
													<p class="stock"><b><?php echo html_escape($current_stock) ;?> </b></p>
												</div>
												<!-- .caption-->
												
												<br/>
												
												<!-- .product-details-->
												<div class="product-details">
													<p class="details list-group-item-text"><?php echo $product->description;?> </p>
												</div>
												<!-- /.product-details-->
												
												<!-- .social-sharing-btns-->
												<div class="social-sharing-btns">
													<ul class="list-inline">
														<li>
															<div class="social-icon share-icon">
																<i class="fa fa-share-alt" aria-hidden="true"></i>
															</div>
																
														</li>
														<li>
															<a href="javascript:void(0)" onclick="addToWishlist(<?php echo html_escape($product->id);?>,'<?php echo html_escape($product->name);?>','<?php echo html_escape($product->price);?>','<?php echo current_url();?>')" class="btn-wishlist" title="Add to wishlist" data-toggle="tooltip" data-placement="top">
																<div class="social-icon">
																	<i class="fa fa-heart-o" aria-hidden="true"></i>
																</div>
															</a>
														</li>
														<li>
														
															<a href="#" class="<?php echo $disabled_link; ?>" title="Add to cart" onclick="showOptions(this, event)" data-toggle="tooltip" data-placement="top">
																<div class="social-icon">
																	<i class="fa fa-shopping-cart" aria-hidden="true"></i>
																</div>
															</a>
														
														</li>
														
													</ul>
												</div>
												<!-- /.social-sharing-btns-->
												
												<!-- .social-wrapper .link-->
												<div class="social-wrapper link">
																						
													<!-- .sharing-icons-->
													<div class="sharing-icons">
														<div class="icon-list">
															<a target="_blank" href="//www.facebook.com/sharer.php?u=<?php echo $product_link; ?>" class="" title="Share on Facebook" data-toggle="tooltip" data-placement="top">
																<i class="fa fa-facebook" aria-hidden="true"></i>
															</a>
														</div>
														<div class="icon-list">
															<a target="_blank" href="//twitter.com/share?url=<?php echo $product_link; ?>&amp;text=<?php echo ucwords(html_escape($product->name));?>" class="" title="Share on Twitter" data-toggle="tooltip" data-placement="top">
																<i class="fa fa-twitter" aria-hidden="true"></i>
															</a>
														</div>
														<div class="icon-list">
															<a target="_blank" href="//pinterest.com/pin/create/button/?url=<?php echo $product_link; ?>&amp;media=<?php echo $pinterest_image_url; ?>&amp;description=<?php echo ucwords(html_escape($product->name));?>" class="" title="Share on Pinterest" data-toggle="tooltip" data-placement="top">
																<i class="fa fa-pinterest-p" aria-hidden="true"></i>
															</a>
														</div>
													</div>
													<!-- /.sharing-icons-->
													
												</div>
												<!-- /.social-wrapper /.link-->
												
											</div>
											<!-- /.caption-wrap-->
										</div>
										<!-- /.card-content-->
									
									</div>
									<!-- /.card-wrapper-->
									
									<!-- .product-options-wrapper-->
									<div class="product-options-wrapper">
									
										<!-- .product-options-->
										<div class="product-options">
											<h3 class="text-center">
												<a href="#" class="close-product-options">
													X
												</a>
											</h3>
											
											<!-- .product-options-form-->
											<div class="product-options-form animated bounceInRight">
											<?php
												//$this->session->unset_userdata('cart_array');
												$disabled = '';
												if($product->quantity_available < 1){
													$disabled = 'disabled';
												}
												$atts = array('class' => 'add_to_cart_form', 'id' => 'add_to_cart_form', 'name' => 'add_to_cart_form', 'role' => 'form');
												
												echo form_open('cart/add_cart_item', $atts);
											?>
												<div class="form-group">
													<label for="product_size">Size</label>
													<?php echo $select_size; ?>
														
												</div>	
													
												<div class="form-group">
													<label for="product_color">Color</label>
													<?php echo $select_colour; ?>
														
												</div>
													
												<div class="form-group">
													<label for="quantity">Quantity</label>
													<div class="input-group">
															
														<div class="input-group-btn">
															<button type="button" class="btn btn-default plus-minus" data-type="minus" data-field="quantity" disabled="disabled"><i class="fa fa-minus" aria-hidden="true"></i></button>
														</div>
															
														<input type="text" name="quantity" id="pQty" class="form-control input-quantity" onkeypress="return allowNumbersOnly(event)" value="1" size="1" maxlength="2" />
															
														<div class="input-group-btn">
															<button type="button" class="btn btn-default plus-minus" data-type="plus" data-field="quantity"><i class="fa fa-plus" aria-hidden="true"></i></button>
														</div>
													</div>
														
												</div>	
													
												<input type="hidden" name="quantity_available" id="quantityAvailable" value="<?php echo html_escape($product->quantity_available); ?>" >
												
												<input type="hidden" name="productID" id="product_id" value="<?php echo html_escape($product->id); ?>" >
												<input type="hidden" name="product_price" id="product_price" value="<?php echo html_escape($product->price);?>">
												<input type="hidden" name="product_name" id="product_name" value="<?php echo html_escape($product->name);?>">
													
												
												<div class="btn-wrap <?php echo $disabled;?>" onclick="javascript:addToCart(this);" >
													<a class="btn-label">$<?php echo html_escape(number_format($product->price, 2)) ;?></a>
													<span class="btn-text">ADD TO CART</span>
												</div>
												
												<!-- .option-caption-->
												<div class="option-caption">
													<h4 class="group inner list-group-item-heading"><a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($product->id));?>/<?php echo url_title(strtolower(html_escape($product->name)));?>" title="<?php echo ucwords(html_escape($product->name));?>"><?php echo ucwords(html_escape($product->name));?></a></h4>
													<p class="price group inner list-group-item-text">$<?php echo html_escape(number_format($product->price, 2)) ;?> </p>
												</div>
													<!-- .caption-->
													<?php
														echo form_close();
													?>
											</div>
											<!-- /.product-options-form-->	
											
										</div>
										<!-- /.product-options-->
									
									</div>
									<!-- /.product-options-wrapper-->
								
								</div>
								<!-- /.card-->
								
							</div>
							<!-- /.item /.grid-group-item /.col-md-4 /.col-sm-6 /.col-xs-12-->
							
							<?php
									//$x++;
									//if($x % 3 == 0){
										//echo '</div><br/><div class="row list-group products" >';
									//}
								}
									echo '</div><br/>';				
							}else{
							?>
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-danger" role="alert">
										<h4 class="text-danger text-center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only"></span><?php echo $search; ?> not found!</h4>
										
									</div>
								</div>
							</div>
							<?php
							}
							?>
						
					</div>
					<!-- /.products-display-wrapper-->
					
					
				
				<div class="row">
					<div class="col-xs-12">
						<div class="text-center">
							<button class="btn btn-custom-orange btn-more"><i class="fa fa-angle-right" aria-hidden="true"></i> LOAD MORE</button>
						</div>
					</div>
				</div>
				<br/>
			</div>
		</div>
	</div>
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

