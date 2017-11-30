
		
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
							echo '<div class="row">';
							//get items from array
							foreach($products_array as $product){
								echo '<div class="col-md-4 col-sm-6 col-xs-12">';
								
								//product quantity
								$quantity_available = $product->quantity_available;
								if($quantity_available == '' || $quantity_available == null){
									$quantity_available = 0;
								}
								$product_image = '';
								$filename = FCPATH.'uploads/products/'.$product->id.'/'.$product->image;
								if(file_exists($filename)){
									$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive" />';
								}
								else if($product->image == '' || $product->image == null || !file_exists($filename)){
									$product_image = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive" />';
								}
								else{
									$product_image = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->image.'" class="img-responsive" />';
								}
								
					?>	
							<div class="item-wrapper">
								<div class="thumbnail">
									<a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($product->id));?>/<?php echo url_title(strtolower(html_escape($product->name)));?>">
										<img src="<?php echo base_url().'uploads/products/'.html_escape($product->id).'/'.$product->image;?>" alt="" style="width:100%;">
									
									</a>
									<div class="caption">
										<h4><a href="<?php echo base_url(); ?>collections/product/<?php echo strtolower(html_escape($product->id));?>/<?php echo url_title(strtolower(html_escape($product->name)));?>" title="<?php echo ucwords(html_escape($product->name));?>"><?php echo ucwords(html_escape($product->name));?></a></h4>
										<span class="price">$<?php echo html_escape(number_format($product->price, 2)) ;?> </span>
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
												<a href="javascript:;" class="btn-wishlist" title="Add to wishlist">
													<div class="social-icon">
														<i class="fa fa-heart-o" aria-hidden="true"></i>
													</div>
												</a>
											</li>
											<li>
												<a href="javascript:;" class="cart-toggle" title="Add to cart">
													<div class="social-icon">
														<i class="fa fa-shopping-cart" aria-hidden="true"></i>
													</div>
												</a>
											</li>
										</ul>
									</div>
								</div>
								
							</div>
						</div>
						<?php
								$x++;
								if($x % 3 == 0){
									echo '</div><br/><div class="row" >';
								}
							}
								echo '</div><br/>';				
						}else{
						?>
						<div class="row">
							<div class="col-sm-12">
								<div class="alert alert-default" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only"></span>Can't find "<i><?php echo $search; ?></i>"!
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

