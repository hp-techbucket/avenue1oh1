
		
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


<?php
	$form = array(
		'name' => 'filter-form',
		'id' => 'filter-form1',
		'class' => 'filter-form',
		'role' => 'form',
	);
						
	echo form_open('collections/filter_search',$form);
?>
<!-- .filter-container-->					
<div class="filter-container">

	<!-- .container-fluid-->
	<div class="container-fluid">
	
		<!-- .row-->
		<div class="row">
		
			<!-- .col-md-2 .col-sm-6 .col-xs-6-->
			<div class="col-md-2 col-sm-6 col-xs-6">
				<div class="filter-heading">
					<span class="filter-title"><?php echo html_escape($pageTitle);?></span>
				</div>
			</div>
			<!-- /.col-md-2 .col-sm-6 .col-xs-6-->
			
			<!-- /.col-md-2 .col-sm-6 .col-xs-6-->
			<div class="col-md-2 col-sm-6 col-xs-6">
				<div class="filter-heading">
					<span class="products-count"><?php echo html_escape($count);?> </span> PRODUCT(S)
				</div>
			</div>
			<!-- /.col-md-2 .col-sm-6 .col-xs-6-->
			
			<!-- .col-md-4 .col-md-offset-4 .col-sm-12 .col-xs-12-->
			<div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12">
			
				<!-- .list-inline .right-menu-->
				<ul class="list-inline right-menu">
					
					<li class="dropdown">
						<a href="#" class="sort-by-btn btn btn-default dropdown-toggle" data-toggle="dropdown" >SORT BY <span class="caret"></span></a>
						<ul class="dropdown-menu sort-menu" role="menu">
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="featured" class="sort-by"> Featured</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="price-ascending" class="sort-by"> Price, low to high</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="price-descending" class="sort-by">  Price, high to low</a>
							</li>
							<li class="divider"></li>
							<li class="active">
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="name-ascending" class="sort-by" checked="checked"> Name, A-Z</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="name-descending" class="sort-by"> Name, Z-A</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="created-ascending" class="sort-by"> Date, new to old</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="created-descending" class="sort-by">  Date, old to new</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort_by" value="best-selling" class="sort-by"> Best Selling</a>
							</li>
						</ul>
					</li>
					
					<li><a href="#" class="btn btn-primary filter-btn">FILTERS <i class="fa fa-angle-down" aria-hidden="true"></i></a></li>
					
					<li><span class="display-label">DISPLAY: </span></li>
					
					<li>
						<div class="btn-group">
							<a href="#" id="list" class="btn btn-default btn-sm" title="List" data-toggle="tooltip" data-placement="top">
								<i class="fa fa-list-ul fa-fw fa-lg" aria-hidden="true"></i>
							</a> 
							<a href="#" id="grid" class="btn btn-default btn-sm active"title="Grid" data-toggle="tooltip" data-placement="top" >
								<i class="fa fa-th-large fa-fw fa-lg" aria-hidden="true"></i>
							</a>
						</div>
					</li>	
				</ul>
				<!-- /.list-inline .right-menu-->
			</div>
			<!-- /.col-md-4 .col-md-offset-4 .col-sm-12 .col-xs-12-->
			
		</div>
		<!-- /.row-->
	</div>
	<!-- /.container-fluid-->
 	
</div>
<!-- /.filter-container-->
			
<div class="filter-box">
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="filter-column">
					<h4 class="title">COLLECTIONS</h4>
					<?php echo $categories; ?>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="filter-column">
					<h4 class="title">BRANDS</h4>
					<?php echo $brands; ?>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="filter-column">
					<h4 class="title">COLORS</h4>
					<?php echo $colours; ?>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<div class="filter-column">
					<h4 class="title">SIZES</h4>
					<?php echo $sizes; ?>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="gender" id="gender1" value="<?php echo html_escape(strtolower($gender)); ?>">
		<input type="hidden" name="category_name" id="category1" value="<?php echo html_escape(strtolower($category)); ?>">
		<input type="hidden" name="type" id="type1" value="<?php echo html_escape(strtolower($type)); ?>">
		<input type="hidden" name="type" id="function" value="<?php echo html_escape(strtolower($function)); ?>">
		
	</div>
</div>

		
 <!-- .products-container-->
<div class="products-container">
	
	<!-- .container-->
	<div class="container">
		
		<!-- .row-->
		<div class="row">
		
			<!-- .col-md-3 .sidebar-wrapper-->
			<div class="col-md-3 sidebar-wrapper">
				<div class="">
					
					
					<div class="sidebar-section">
						<div class="sidebar-header" data-toggle="collapse" data-target="#shipping-tab">
							FREE SHIPPING
						</div>
						<p id="shipping-tab" class="collapse">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pharetra, ligula non mollis pretium, lectus libero sodales augue, interdum auctor mauris dui non risus. Nulla facilisi. Nunc rutrum diam in elit sagittis eget viverra erat viverra. Morbi imperdiet aliquet libero vel rhoncus. Integer.</p>
					</div>
					
					<div class="sidebar-section">
						<div class="sidebar-header">
							CATEGORIES
						</div>
						<div id="category-tab" class="sidebar-body">
							<?php echo $categories_menu; ?>
						</div>
					</div>
				
					<div class="sidebar-section">
						<div class="sidebar-header">
							BRANDS
						</div>
						<div id="brands-tab" class="sidebar-body">
							<?php echo $brands; ?>
						</div>
					</div>
					
					<div class="sidebar-section">
						<div class="sidebar-header" >
							COLORS
						</div>
						<div id="colors-tab" class="sidebar-body">
							<?php echo $colours; ?>
						</div>
					</div>
					
					<div class="sidebar-section">
						<div class="sidebar-header">
							SIZES
						</div>
						<div id="sizes-tab" class="sidebar-body">
							<?php echo $sizes; ?>
						</div>
						
					</div>
					
		<?php
			echo form_close();
		?>
				<div class="sidebar-section">
						<div class="sidebar-header">
							KEYWORDS
						</div>
						<div class="sidebar-search">
							<form action="<?php echo base_url('collections/search'); ?>" id="search-form" name="search-form" class="search-form" method="get" enctype="multipart/form-data">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="input-group">
											
											<input type="text" name="keywords" value="<?php echo set_value('keywords'); ?>" class="form-control" placeholder="Looking for..." id="">	
											<div class="input-group-addon">
												<button type="submit" class=""><i class="fa fa-search" aria-hidden="true"></i></button>
											</div>				
										</div>
									</div>
								
								</div>
							</div>
							</form>
						</div>
					</div>	
				</div>
			</div>
			<!-- /.col-md-3 .sidebar-wrapper-->
			
			<!-- .col-md-9-->
			<div class="col-md-9">
			
				<div id="notif-message"></div>
				
				<!-- .products-display-wrapper-->
				<div class="products-display-wrapper">
						<?php
					
							if($products_array) {
								//item count initialised
								$x = 0;
								//start row
								echo '<div id="" class="row list-group products">';
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
										<h4 class="text-danger text-center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only"></span>Not found!</h4>
									</div>
								</div>
							</div>
							<?php
							}
							?>
						
					</div>
					<!-- /.products-display-wrapper-->
					
					
				
				
				<!-- load more row-->
				<div class="row">
					<div class="col-xs-12">
						<div class="text-center">
							<button class="btn btn-custom-orange btn-more"><i class="fa fa-angle-right" aria-hidden="true"></i> LOAD MORE</button>
						</div>
					</div>
				</div>
				<!-- /load more row-->
				
				<br/>
			</div>
			<!-- /.col-md-9-->
			
		</div>
		<!-- /.row-->
		
	</div>
	<!-- .container-->
	
</div>
<!-- /.products-container-->

<!-- .breadcrumb-container-->
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
<!-- /.breadcrumb-container-->
