
		
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
			$form1 = array(
				'name' => 'filter-form',
				'id' => 'filter-form1',
				'class' => 'filter-form',
				'role' => 'form',
			);
			
			echo form_open('collections/filter_search',$form1);
		?>
					
<div class="filter-container">
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2 col-sm-6 col-xs-6">
				<div class="filter-heading">
					<span class="filter-title"><?php echo html_escape($pageTitle);?></span>
				</div>
			</div>
			<div class="col-md-2 col-sm-6 col-xs-6">
				<div class="filter-heading">
					<span class="products-count"><?php echo html_escape($count);?> </span> PRODUCT(S)
				</div>
			</div>
			<div class="col-md-4 col-md-offset-4 col-sm-12 col-xs-12">
				<ul class="list-inline right-menu">
					
					<li class="dropdown">
						<a href="#" class="sort-by-btn btn btn-default dropdown-toggle" data-toggle="dropdown" >SORT BY <span class="caret"></span></a>
						<ul class="dropdown-menu sort-menu" role="menu">
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="featured" class="sort-by"> Featured</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="price-ascending" class="sort-by"> Price, low to high</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="price-descending" class="sort-by">  Price, high to low</a>
							</li>
							<li class="divider"></li>
							<li class="active">
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="name-ascending" class="sort-by" checked="checked"> Name, A-Z</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="name-descending" class="sort-by"> Name, Z-A</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="created-ascending" class="sort-by"> Date, new to old</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="created-descending" class="sort-by">  Date, old to new</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="sort-radio-box"><input type="radio" name="sort-by" value="best-selling" class="sort-by"> Best Selling</a>
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
				
			</div>
		</div>
	
	</div>
	
</div>
		
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
		<input type="hidden" name="gender" id="gender" value="">
		<input type="hidden" name="category" id="category" value="all">
	</div>
</div>

		<?php
			echo form_close();
		?>
 
 
<div class="products-container">

	<div class="container">
		<div class="row">
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
						<div class="sidebar-body">
							<?php echo $categories_menu; ?>
						</div>
					</div>
					
	<?php
		$form2 = array(
			'name' => 'filter-form',
			'id' => 'filter-form2',
			'class' => 'filter-form',
			'role' => 'form',
		);
		echo form_open('collections/filter_search',$form2);
	?>
		
					<div class="sidebar-section">
						<div class="sidebar-header">
							BRANDS
						</div>
						<div class="sidebar-body">
							<?php echo $brands; ?>
						</div>
					</div>
					
					<div class="sidebar-section">
						<div class="sidebar-header">
							COLORS
						</div>
						<div class="sidebar-body">
							<?php echo $colours; ?>
						</div>
					</div>
					
					<div class="sidebar-section">
						<div class="sidebar-header">
							SIZES
						</div>
						<div class="sidebar-body">
							<?php echo $sizes; ?>
						</div>
						
					</div>
				<input type="hidden" name="gender" id="gender" value="">
				<input type="hidden" name="category" id="category" value="all">	
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
			<div class="col-md-9">
			
			<div id="notif-message"></div>
			
				<div class="products-display">
					<?php
					//	$this->db->from('products');
						//$this->db->where('LOWER(gender)','female');
					//	$this->db->order_by('id');
					//	$result = $this->db->get();
						if($products_array) {
							//item count initialised
							$x = 0;
							//start row
							echo '<div id="" class="row list-group products">';
							//get items from array
							foreach($products_array as $product){
								echo '<div class="item grid-group-item col-md-4 col-sm-6 col-xs-12">';
								
								//product quantity
								
								$product_image = '';
								$filename = FCPATH.'uploads/products/'.$product->id.'/'.$product->image;
								if(file_exists($filename)){
									$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive group list-group-image" />';
								}
								else if($product->image == '' || $product->image == null || !file_exists($filename)){
									$product_image = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive group list-group-image" />';
								}
								else{
									$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->image.'" class="img-responsive group list-group-image" />';
								}
								//item-wrapper
								//width:100%;
								//
								$disabled_link = '';
								if($product->quantity_available < 1){
									$disabled_link = 'disabled';
								}
					?>	
							<div class="item-wrapper">
								<div class="thumbnail">
									
									<a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($product->id));?>/<?php echo url_title(strtolower(html_escape($product->name)));?>" title="<?php echo url_title(strtolower(html_escape($product->name)));?>">
										<?php echo $product_image;?>
									
									</a>
									
									<div class="caption-wrap">
										<div class="caption">
											<h4 class="group inner list-group-item-heading"><a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($product->id));?>/<?php echo url_title(strtolower(html_escape($product->name)));?>" title="<?php echo ucwords(html_escape($product->name));?>"><?php echo ucwords(html_escape($product->name));?></a></h4>
											<p class="price group inner list-group-item-text">$<?php echo html_escape(number_format($product->price, 2)) ;?> </p>
										</div>
										<div class="product-details">
											<p class="details"><?php echo substr($product->description, 0, 30).'...';?> </p>
										</div>
										<div class="social-sharing-btns">
											<ul class="list-inline">
												<li>
													<a href="javascript:;" class="social-wrapper link">
														<div class="social-icon">
															<i class="fa fa-share-alt" aria-hidden="true"></i>
														</div>
													</a>
												</li>
												<li>
													<a href="javascript:void(0)" onclick="addToWishlist(<?php echo html_escape($product->id);?>,'<?php echo html_escape($product->name);?>','<?php echo html_escape($product->price);?>','<?php echo current_url();?>')" class="btn-wishlist" title="Add to wishlist">
														<div class="social-icon">
															<i class="fa fa-heart-o" aria-hidden="true"></i>
														</div>
													</a>
												
												</li>
												<li>
												<?php
													$atts = array('class' => 'add_to_cart_form', 'id' => 'add_to_cart_form', 'name' => 'add_to_cart_form', 'role' => 'form');
													echo form_open('store/add_cart_item', $atts);
												?>
												<input type="hidden" name="quantity_available" id="quantityAvailable" value="<?php echo html_escape($product->quantity_available); ?>" >
												<input type="hidden" name="quantity" id="pQty" value="1" >
												<input type="hidden" name="productID" id="product_id" value="<?php echo html_escape($product->id); ?>" >
												<input type="hidden" name="product_price" id="product_price" value="<?php echo html_escape($product->price);?>">
												<input type="hidden" name="product_name" id="product_name" value="<?php echo html_escape($product->name);?>">
													<a href="#" class="<?php echo $disabled_link; ?> cart-toggle" id="<?php echo html_escape($product->id); ?>" title="Add to cart">
														<div class="social-icon">
															<i class="fa fa-shopping-cart" aria-hidden="true"></i>
														</div>
													</a>
												<?php
													echo form_close();
												?>
												</li>
											</ul>
										</div>
									</div>
								</div>
								
							</div>
							
						</div>
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
								<div class="alert alert-default" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only"></span>Not found!
								</div>
							</div>
						</div>
						<?php
						}
						?>
				
				</div>
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

