	
		
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

 


<div class="container-fluid store-container">

	<div class="text-center" align="center">	
		<?php 
				$message = '';
				if($this->session->flashdata('product_added') != ''){
					$message = $this->session->flashdata('product_added');
				}	
				echo $message;					
			?>	
	</div>		
	<div class="container-fluid">
		<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pageTitle;?> <small></small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->
	</div>
	
	
	<div class="container">
		<div class="well well-sm">
			<strong><?php echo $display_option;?></strong>
			<div class="btn-group">
				<a href="#" id="list" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-th-list"></span>List
				</a> 
				<a href="#" id="grid" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-th"></span>Grid
				</a>
			</div>
			<div class="pull-right">
				<form class="form-inline" role="form" action="<?php echo base_url('store/products');?>" method="get">
					<div class="form-group">
						<div class="col-xs-6">
							<input type="text" class="form-control" name="search" placeholder="Search">
						</div>
					</div>
					<button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
				</form>
			</div>
			<span class="pull-right">
						
				<?php
					echo form_open('store/products');
					echo $category;	
				?>
				<button type="submit" class="btn btn-default btn-show-category" style="display:none;"></button>
				<?php	
					echo form_close();								
				?>
			</span>
		</div>	
	</div>	
			<div class="container">
				<div id="products" class="row list-group">
						<?php 
								if($products_array){
									foreach($products_array as $product){ 
									
										$thumbnail = '';
										$filename = FCPATH.'uploads/products/'.$product->id.'/'.$product->image;
										
										if(file_exists($filename)){
											$thumbnail = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->id.'.jpg" class="img-responsive img-rounded" />';
										}
										
										else if($product->image == '' || $product->image == null || !file_exists($filename)){
											$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" />';
										}
										
										else{
											$thumbnail = '<img src="'.base_url().'uploads/products/'.$product->id.'/'.$product->image.'" class="img-responsive img-rounded" />';
										}
										
										$description = $product->description;
										$breaks = array("<br />","<br>","<br/>");  
										$description = str_ireplace($breaks, "\r\n", $description);
							?>
							
                    <div class="item col-xs-4 col-lg-4">
					
						<div class="thumbnail">
							<div class="image-thumbnail view_product" title="<?php echo ucwords($product->name); ?>" data-toggle="modal" data-target="#viewModal" id="<?php echo html_escape($product->id);?>" >
							<?php echo $thumbnail; ?>
							</div>
							<div class="caption">
								<h4 class="group inner list-group-item-heading text-primary">
									<a data-toggle="modal" data-target="#viewModal" class="view_product"  id="<?php echo html_escape($product->id);?>" title="<?php echo ucwords($product->name); ?>"><?php echo ucwords($product->name); ?> <i class="fa fa-search" aria-hidden="true"></i></a>
								</h4>
								<p class="group inner list-group-item-text">
									<?php echo html_escape($description);?>
								</p>
								<div class="price-quantity-box">
									<div class="row">
										<div class="col-xs-3 col-md-3">
											<p class="lead">
												$<?php echo html_escape(number_format($product->price, 0)) ; ?>
												<input type="hidden" name="price" id="price_<?php echo html_escape($product->id);?>" value="<?php echo html_escape($product->price);?>">
											</p>
										</div>
										
										 
										<div class="col-xs-9 col-md-9">
											
											<div>
												<label id="item_quantity" for="quantity">Quantity:</label>
												<input type="text" name="quantity" class="cart_quantity" id="cart_quantity_<?php echo html_escape($product->id);?>" onkeypress="return allowNumbersOnly(event)" value="1" maxlength="2" required>
															
												<span class="pull-right">
													<button class="inc" id="<?php echo html_escape($product->id);?>" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
															
													<button class="dec" id="<?php echo html_escape($product->id);?>" type="button"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
												</span>
											</div>
						
										</div>
										
									</div>
								</div>
								<p class="pull-right">
									<button type="button" class="btn btn-success add_to_cart btn-responsive" data-toggle="modal" data-target="#addToCartModal" id="<?php echo html_escape($product->id);?>">Add to cart</button>
								</p>
							</div>
						
						</div>
						
					</div>
							
						<?php 
									}
								}
							?>			
                </div>		
			<div class="row">
				<div class="col-md-12 text-center">
					<?php echo $pagination; ?>
				</div>
			</div>
	</div>			
			
<?php
	echo br(1);				
?>

</div>			
			<form action="<?php echo base_url('store/add_cart_item'); ?>" name="add_to_cart_form" id="add_to_cart_form"  method="post" enctype="multipart/form-data">
				<!-- Modal -->
				<div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Add <span id="product-name"></span> to Cart?</h3>
					  </div>
					  <div class="modal-body">
						<strong>Add item to cart?</strong>
						<input type="hidden" id="product_id" name="product_id" >
						<input type="hidden" id="cart_quantity" name="cart_quantity" >
						<input type="hidden" id="product-price" >
						
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
						<input type="button" onclick="javascript:addToCart();" class="btn btn-success" name="add_to_cart"  value="OK">
					  </div>
					</div>
				  </div>
				</div>	
			</form>
	 
			
		<!-- View Product -->
			<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					
				  </div>
				  <div class="modal-body">
					<div class="container col-md-12">
					
						<div class="row">
							<div class="col-xs-6">
								<span id="thumbnail" ></span>
							</div>
							<div class="col-xs-6">
								<div class="row">
									<div class="col-xs-12">
										<h3 align="center" class="text-primary" id="productName"></h3>
									</div>
								</div><!-- end row-->
								<div class="row">
									<div class="col-xs-12">
										<span class="label label-primary" id="productCategory"></span>
										<span class="monospaced" id="product_ref"></span>
									</div>
								</div><!-- end row -->
								<div class="row">
									<div class="col-xs-12">
										<p class="description" id="productDescription"></p>
									</div>
								</div><!-- end row -->
								<div class="row">
									<div class="col-xs-6">
										  <span class="sr-only">Four out of Five Stars</span>
										  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
										  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
										  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
										  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
										  <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
										  <span class="label label-success">61</span>
									</div>
									<div class="col-xs-6">
										<span class="monospaced">Write a Review</span>
									</div>
								</div><!-- end row -->
								
								<div class="row">
									<div class="col-xs-12 bottom-rule">
										<h2 class="product-price text-success" id="productPrice"></h2>
									</div>
								</div><!-- end row -->
								
								<hr/>

								<div class="row add-to-cart">
									<form action="<?php echo base_url('store/add_cart_item'); ?>" name="add_to_cart_form" id="add_to_cart_form"  method="post" enctype="multipart/form-data">
									<div class="col-xs-6 product-qty">
										<span id="inc" class="btn btn-default btn-lg btn-qty">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
										</span>
										<input class="btn btn-default btn-lg btn-qty p-qty"/>
										<input type="hidden" id="p_id">
										<span id="dec" class="btn btn-default btn-lg btn-qty">
											<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
										</span>
									</div>
									<div class="col-xs-6">
										
										<button type="button" onclick="javascript:addToCart();" class="btn btn-lg btn-primary">Add to Cart</button>
									</div>
									</form>
								</div><!-- end row -->

								<div class="row">
									<div class="col-xs-6 text-center">
										<span class="monospaced status"></span>
									</div>
									
								</div><!-- end row -->
								<hr/>
								
								<div class="row">
									<div class="col-xs-12 top-10">
										<p>To order by telephone, <a href="tel:07448495666">please call 07448495666</a></p>
									</div>
								</div><!-- end row -->
								
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a>
									</li>
									<li role="presentation">
										<a href="#features" aria-controls="features" role="tab" data-toggle="tab">Features</a>
									</li>
									<li role="presentation">
										<a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Notes</a>
									</li>
									<li role="presentation">
										<a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="description">
										<p class="top-10" id="p_description"></p>
										<p><span class="label label-primary text-default" id="p_category"></span> <span class="label label-default text-default" id="productGender"></span></p>
										
									</div>
									<div role="tabpanel" class="tab-pane top-10" id="features">
									  ...
									</div>
									<div role="tabpanel" class="tab-pane" id="notes">
									  ...
									</div>
									<div role="tabpanel" class="tab-pane" id="reviews">
									  ...
									</div>
								</div>
								<p></p>
								
								
								
							</div>
						</div>
						
						
									
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				  </div>
				</div>
			  </div>
			</div>	
		<!-- View Product -->
		
			<div class="modal fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Alert</h3>
				  </div>
				  <div class="modal-body">
					<span id="notif-message"></span>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>		