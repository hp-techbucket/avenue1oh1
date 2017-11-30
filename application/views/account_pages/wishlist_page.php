
	<div class="collection-banner">
		<div class="banner-wrapper">
			<div class="collection-banner-caption">
				<div class="collection-banner-header">
					<?php echo $pageTitle;?>
				</div>
				<div class="collection-banner-text">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<a href="<?php echo base_url();?>account/" title="Account" class="">Account</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo $pageTitle;?>
				</div>
			</div>	
		</div>
	</div>
	
	<br/>
	
	<div class="container">
	
	<?php   
		if(!empty($users))
		{
			foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
			{	
			
	?>
		
		<div class="row">
			
			<div class="">
			
				<h3 class="text-primary" align="center"><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $pageTitle;?></h3>
				
				<p>Your wishlist allows you to save products that you might want to buy in the future. Simply click the "Add to WishList" button on a product details page, and the product will be added to your wishlist. Your wishlist can be viewed at anytime by visiting this page. Whenever you're ready to purchase an item in your wishlist, simply click the product's "Add to cart" button on this page. Best Wishes!</p>
				
				<div id="notif-message"></div>
				
				<!-- table-responsive -->
				<div class="table-responsive" >
					<table id="wishlist-table" frame="" class="display table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>PRODUCT IMAGE</th>
								<th>PRODUCT NAME</th>
								<th>UNIT PRICE</th>
								<th align="center">STOCK</th>
								<th align="center">ADD TO CART</th>
								<th align="center">REMOVE</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
												 
					</table>
				</div>
				<!-- /table-responsive -->
										
			</div>
		</div>
		
	<?php   
			}
		}								
	?>
			
			
	</div>

	<div class="breadcrumb-container">
		<div class="container">
			<div class="custom-breadcrumb">
				<span class="breadcrumb">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<a href="<?php echo base_url();?>account/" title="Account" class="">Account</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<?php echo $pageTitle;?>
				</span>
				<span class="pull-right"><?php echo date('l, F d, Y', time());?></span>
			</div>
		</div>
	</div>

