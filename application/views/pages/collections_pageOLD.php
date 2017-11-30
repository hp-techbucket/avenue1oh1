
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
	


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<br/>
			<div class="collection-nav text-center">
				<h4><a href="#" class="women-col"><i class="fa fa-venus" aria-hidden="true"></i> WOMEN</a> | <a href="#" class="men-col"><i class="fa fa-mars" aria-hidden="true"></i> MEN</a></h4>
			</div>
		</div>
	</div>	
	
	<div class="row">
		<div class="col-md-12 collection-section">
			
				<div id="women-col" class="collection-header">
					COLLECTIONS - WOMEN
				</div>
				
				<!-- .collection-display-->
				<div class="collection-display">
				<?php
					$where = array();
					$this->db->from('female_categories');
					$this->db->order_by('category_name');
					$result = $this->db->get();
					if($result->num_rows() == 0) {
						//item count initialised
						$x = 0;
						//start row
						echo '<div class="row">';
						//get items from array
						foreach($result->result_array() as $row){
							echo '<div class="col-md-4 col-sm-6 col-xs-12">';
							$where['gender'] = 'female';
							$where['category'] = ucwords($row['category_name']);
							//count the category
							//$category_count = $this->Products->count_products_by_category('female', $row['category_name']);
							$category_count = $this->Products->count_products($where);
							
							if($category_count == '' || $category_count == null){
								$category_count = 0;
							}
							
							$count_message = '';
							if($category_count < 1){
								$count_message = 'Out of Stock';
							}else if($category_count == 1){
								$count_message = $category_count.' product';
							}else{
								$count_message = $category_count.' products';
							}
				?>	
						<a href="<?php echo base_url(); ?>collections/women/<?php echo strtolower(html_escape($row['category_name']))?>" >
							<!-- col-sm-12 -->
							<div class="col-sm-12">
								<div class="collection-thumbnail"><!-- Collection Thumbnail -->
									<div class="layer">
										<img src="<?php echo base_url(); ?>assets/images/collections/women/<?php echo strtolower(html_escape($row['category_name']))?>.jpg" class="img-responsive" alt="collection-<?php echo strtolower(html_escape($row['category_name']))?>" width="300" height="380">
										<div class="collection-caption">
											SHOP THE COLLECTION
										</div>
									</div>
								</div><!-- Collection Thumbnail -->
							</div>
							<!-- col-sm-12 -->
						</a>
						
							<div class="col-sm-12">
								<div class="caption">
									<h4><a href="<?php echo base_url(); ?>collections/women/<?php echo strtolower(html_escape($row['category_name'])) ;?>" title="Browse our <?php echo strtoupper(html_escape($row['category_name'])) ;?> collection"><?php echo strtoupper(html_escape($row['category_name'])) ; ?> (<span class="category-count"><?php echo html_escape($count_message) ;?></span>)</a></h4>
									
								</div>
						
							</div>
							
					</div>
					<?php
							$x++;
							if($x % 3 == 0){
								echo '</div><br/><div class="row">';
							}
						}
							echo '</div><br/>';				
					}else{
					?>
						<div class="row">
							<div class="col-sm-12">
								<div class="alert alert-default" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only"></span>None!
								</div>
							</div>
						</div>
						<?php
						}
						?>
				
				</div>
				<!-- /.collection-display-->
				
				<div class="view-more-button" align="center">
					<button class="btn btn-custom-orange show-more" id="show-more"><i class="fa fa-angle-down" aria-hidden="true"></i> SHOW MORE</button>
							
				</div>
			
		</div>		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="collection-wrapper">
				<div id="men-col" class="collection-header">
					COLLECTIONS - MEN
				
				</div>
				
				<!-- .collection-display-->
				<div class="collection-display">
				<?php
					$this->db->from('male_categories');
					$this->db->order_by('category_name');
					$result = $this->db->get();
					if($result->num_rows() == 0) {
						//item count initialised
						$x = 0;
						//start row
						echo '<div class="row">';
						//get items from array
						foreach($result->result_array() as $row){
							echo '<div class="col-md-4 col-sm-6 col-xs-12">';
							$where['gender'] = 'female';
							$where['category'] = ucwords($row['category_name']);
							//count the category
							//$category_count = $this->Products->count_products_by_category('male', $row['category_name']);
							$category_count = $this->Products->count_products($where);
							
							if($category_count == '' || $category_count == null){
								$category_count = 0;
							}
							
							$count_message = '';
							if($category_count < 1){
								$count_message = 'Out of Stock';
							}else if($category_count == 1){
								$count_message = $category_count.' product';
							}else{
								$count_message = $category_count.' products';
							}
							
				?>	
						<a href="<?php echo base_url(); ?>collections/men/<?php echo strtolower(html_escape($row['category_name']))?>" >
							<!-- col-sm-12 -->
							<div class="col-sm-12">
								<div class="collection-thumbnail"><!-- Collection Thumbnail -->
									<div class="layer">
										<img src="<?php echo base_url(); ?>assets/images/collections/men/<?php echo strtolower(html_escape($row['category_name']))?>.jpg" class="img-responsive" alt="collection-<?php echo strtolower(html_escape($row['category_name']))?>" width="300" height="380">
										<div class="collection-caption">
											SHOP THE COLLECTION
										</div>
									</div>
								</div><!-- Collection Thumbnail -->
							</div>
							<!-- col-sm-12 -->
						</a>
							
							<div class="col-sm-12">
								<div class="caption">
									<h4><a href="<?php echo base_url(); ?>collections/men/<?php echo strtolower(html_escape($row['category_name'])) ;?>" title="Browse our <?php echo strtoupper(html_escape($row['category_name'])) ;?> collection"><?php echo strtoupper(html_escape($row['category_name'])) ; ?> (<span class="category-count"><?php echo html_escape($count_message) ;?></span>)</a></h4>
									
								</div>
						
							</div>
					</div>
					<?php
							$x++;
							if($x % 3 == 0){
								echo '</div><br/><div class="row">';
							}
						}
							echo '</div><br/>';				
					}else{
					?>
						<div class="row">
							<div class="col-sm-12">
								<div class="alert alert-default" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only"></span>None!
								</div>
							</div>
						</div>
					<?php
					}
					?>
				
				</div>
				<!-- /.collection-display-->
				
				
				<div class="view-more-button" align="center">
					<button class="btn btn-custom-orange show-more"><i class="fa fa-angle-down" aria-hidden="true"></i> SHOW MORE</button>
							
				</div>
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

