
<div class="product-view">

	<div class="container">
		<div class="row">
			<div class="col-md-1 col-sm-3 col-xs-3">
				<?php echo $product_gallery;?>
			</div>
			<div class="col-md-5 col-sm-9 col-xs-9">
				<?php echo $product_image;?>
			</div>
			<div class="col-md-4 col-sm-9 col-xs-9 p-details">
				<p class="breadcrumb-nav">
					<a href="<?php echo base_url();?>" class="" title="HOME">HOME</a>
						/
					<a href="<?php echo base_url();?>collections/all" class="" title="ALL PRODUCTS">ALL PRODUCTS</a>
				</p>
				<br/>
				<h5 class="product-title"><?php echo html_escape($pageTitle);?></h5>
				
				<p class="product-reference"><?php echo html_escape($reference_id);?></p>
				
				<div class="reviews">
					
					<a onclick="showRating('reviews')" href="javascript:void(0)">
						<?php echo $rating_box; ?>
					</a>
				</div>
				
				<div class="product-price">
					<?php echo $price;?>	
					
				</div>
						
				<div class="product-colour">
					<span>Colour</span>
					<?php echo $colours;?>	
				</div>
						
				<div class="product-sizes">
					<span>Size</span>
					<?php echo $sizes;?>	
				</div>
				<div id="notif-message"></div>	
				<div class="quantity">
					<p>Quantity available: ONLY <span id="q_available"><?php echo html_escape($quantity_available);?></span> LEFT</p>
					<p>Quantity</p>
					<?php
					$disabled = '';
					if($quantity_available < 1){
						$disabled = 'disabled';
					}
					$atts = array('class' => 'add_to_cart_form', 'id' => 'add_to_cart_form', 'name' => 'add_to_cart_form', 'role' => 'form');
					echo form_open('store/add_cart_item', $atts);
				?>
					<div class="form-group quantity-form">
						<div class="input-group">
							<div class="input-group-addon">
								<button type="button" class="minus-qty"><i class="fa fa-minus" aria-hidden="true"></i></button>
							</div>
							<input type="text" name="quantity" id="pQty"  onkeypress="return allowNumbersOnly(event)"value="1" class="form-control" >	
							<div class="input-group-addon">
								<button type="button" class="plus-qty"><i class="fa fa-plus" aria-hidden="true"></i></button>
							</div>
						</div>
															  
					</div>
					<input type="hidden" name="productID" id="product_id" value="<?php echo html_escape($product_id); ?>" >
					<input type="hidden" name="product_price" id="product_price" value="<?php echo html_escape($price);?>">
					<input type="hidden" name="product_name" id="product_name" value="<?php echo html_escape($product_name);?>">
				</div>
				<button type="button" onclick="javascript:addToCart(this);" class="btn btn-block btn-sm btn-custom-orange <?php echo $disabled;?>">ADD TO CART</button>
				<?php
						echo form_close();
					?>
				<br/><br/>
				 <ul class="list-inline custom-inline">
					<li>
						<div class="share sharing-buttons">
						  <i class="fa fa-share fa-fw fa-2x" aria-hidden="true"></i><br/>
						  <span>SHARE</span>

							<div class="sharing-bubble fixed">
								<div class="social-icons" data-permalink="">
								
								
								</div>
							</div>
						</div>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>collections/fit-guide" class="size" target="_blank">
						  <i class="fa fa-file-text-o fa-fw fa-2x" aria-hidden="true"></i><br/>
						  <span>FIT GUIDE</span>
						</a>
					</li>
			</div>
			<div class="col-md-2 col-sm-3 col-xs-3 p-nav">
				<div class="next-prev-nav">
					<?php echo $previous_link;?>
					<div class="next-prev-nav-thumbnail">
						<?php echo $previous_thumbnail;?>
					</div>	
						
					<?php echo $next_link;?>
					<div class="next-prev-nav-thumbnail">
						<?php echo $next_thumbnail;?>
					</div>	
						
				</div>
				
			</div>
		</div>
		
	</div>
	
	<div class="container details-container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="pill" href="#details">DETAILS</a></li>
					<li><a data-toggle="pill" href="#shipping">SHIPPING & RETURNS</a></li>
					<li><a data-toggle="pill" href="#reviews">CUSTOMER REVIEWS</a></li>
					
				</ul>
				  
				<div class="tab-content">
					<div id="details" class="tab-pane fade in active">
					 
					  <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
					</div>
					<div id="shipping" class="tab-pane fade">
					  
					  <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
					</div>
					<div id="reviews" class="tab-pane fade">
						<div class="row">
							<div class="col-sm-6 col-xs-12">
									<span class="pull-left">
										<?php
											echo $rating_box;
										?>
									</span>
							</div>
							<div class="col-sm-6 col-xs-12">
									<span class="pull-right">
										<a href="#review-form" data-toggle="collapse">Write a review</a>
									</span>
							</div>
						</div>
						
						<div id="notif"></div>
						
						<div id="review-form" class="collapse">
							
							<?php
								$attrs = array('class' => 'review_form form_horizontal', 'id' => 'review_form', 'name' => 'review_form', 'role' => 'form');
								echo form_open('main/submit_review', $attrs);
							?>
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="review-name">Name</label>
										<input type="text" id="review-name" name="review_name" value="<?php echo set_value('review-name'); ?>" class="form-control" placeholder="Enter your name" >			  
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="review-email">Email</label>
										<input type="text" id="review-email" name="review_email" value="<?php echo set_value('review-email'); ?>" class="form-control" placeholder="john.doe@example.com" >			  
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<div class="form-group">
										<label for="name">Comment (<span id="comment-length"></span>)</label>
										<textarea id="review-comment" name="review_comment" class="form-control" style="height:100%;" rows="5" placeholder="Write your comments here" ></textarea>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<label for="review-rating">Rating</label>
									<?php
											echo $new_rating;
										?>
								</div>
								
							</div>
							
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									<input type="hidden" name="pID" id="pID" value="<?php echo $product_id; ?>" >
									<button type="button" onclick="submitReview();" class="btn btn-primary">SUBMIT REVIEW</button>
									
								</div>
								
							</div>
							
							<?php
								echo form_close();
							?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
			
			
			
			
	

</div>


