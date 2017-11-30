
		
        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $pageTitle;?></h3>
					</div>
					
				</div>

				<div class="clearfix"></div>
				
				
				<!-- breadcrumb -->
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<ol class="breadcrumb">
							<li>
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
									<i class="fa fa-home"></i> Dashboard
								</a>
							</li>	
							
							<li class="active">
								<i class="fa fa-list-alt"></i> <?php echo $pageTitle;?>
							</li>
							
						</ol>
					</div>
				</div>
				<!-- /breadcrumb -->
				
				
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $pageTitle;?></h2>
							   
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
							
					<div class="nav-tabs-custom">

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#products" aria-controls="products" role="tab" data-toggle="tab"><h4><i class="fa fa-list-alt"></i> Products</h4></a>
							</li>
							
							<li role="presentation">
								<a href="#options" aria-controls="options" role="tab" data-toggle="tab"><h4><i class="fa fa-filter" aria-hidden="true"></i> Product Options</h4></a>
							</li>	
											
						</ul>
						<!-- /Nav tabs -->
								
						<!-- Tab panes -->
						<div class="tab-content">
						
							<!-- .tab-pane #active-users -->
							<div role="tabpanel" class="tab-pane active" id="products">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addProductModal" title="Add Product"><i class="fa fa-plus"></i> Add Product</a>
								</li>											
							</ol>
							<br/>
							<div class="notif"></div>
							<div class="errors"></div>
							<br/>
									
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'products',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<?php echo nbs(2);?> 
											<?php echo img('assets/images/icons/crookedArrow.png');?> 
											<a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" >
											<i class="fa fa-trash-o"></i> Delete
											</a>
										</div>
										<div class="col-xs-4">
										<?php 
											$message = '';
											if($this->session->flashdata('product_added') != ''){
												$message = $this->session->flashdata('product_added');
											}	
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
											if($this->session->flashdata('product_updated') != ''){
												$message = $this->session->flashdata('product_updated');
											}	
											
											echo $message;
											
										?>
											
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- products-table -->
										<table id="products-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>Image</th>
													<th>Name</th>
													<th>Category</th>
													<th>Price</th>
													<th>Quantity</th>
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /products-table -->
										
										<!-- Multi Delete Modal -->
										<div class="modal fade" id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												Delete Records?
												<div id="delete-errors"></div>
											  </div>
											  <div class="modal-body">
												<strong>Are you sure you want to permanently delete the selected records?</strong>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												
												<input type="button" onclick="multiDelete()" class="btn btn-danger" value="Delete">
											  </div>
											</div>
										  </div>
										</div>		
										<?php 	
													
											//close the form
											echo form_close();	
										?>		
	
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
								
							</div>
							<!-- /tab-pane -->
							
							
							<!-- .tab-pane #options -->
							<div role="tabpanel" class="tab-pane" id="options">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addOptionModal" title="Add Product Options"><i class="fa fa-plus"></i> Add Product Options</a>
								</li>											
							</ol>
							<br/>
							<div class="notif"></div>
							<div class="errors"></div>
							<br/>
									
										
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'product_options',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<?php echo nbs(2);?> 
											<?php echo img('assets/images/icons/crookedArrow.png');?> 
											<a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" >
											<i class="fa fa-trash-o"></i> Delete
											</a>
										</div>
										<div class="col-xs-4">
										<?php 
											$message = '';
											
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
											
											echo $message;
											
										?>
											
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- product-options-table -->
										<table id="product-options-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>Product ID</th>
													<th>Product</th>
													<th>Size</th>
													<th>Colour</th>
													<th>Quantity</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /product-options-table -->
										
										<!-- Multi Delete Modal -->
										<div class="modal fade" id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												Delete Records?
												<div id="delete-errors"></div>
											  </div>
											  <div class="modal-body">
												<strong>Are you sure you want to permanently delete the selected records?</strong>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												
												<input type="button" onclick="multiDelete()" class="btn btn-danger" value="Delete">
											  </div>
											</div>
										  </div>
										</div>		
										<?php 	
													
											//close the form
											echo form_close();	
										?>		
	
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->

							</div>
							<!-- /tab-pane #options -->
							
							
						</div>
						<!-- /Tab panes -->
								
					</div>
					<!-- /nav-tabs-custom -->
							
				</div>
				<!-- /x_content -->
				
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->


		
		<!-- ADD product images -->
		<form action="<?php echo base_url('admin/upload_product_images');?>" id="upload_product_images" name="upload_product_images" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addImagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 align="center">
								Images For <span id="header"></span>
							</h3>
						</div>
						<div class="modal-body">
							<div class="form_errors"></div>
							<div id="alert-msg"></div>
							
							<legend>Product Images (<span id="images_count"></span>)</legend>
							
							<div class="edit_gallery">
								<span id="gallery-edit"></span>
							</div>
							
							
							<legend>Select Files to Upload:</legend>

							
							<div class="input_fields_wrap">
								<div class="form-group">
									
									<span class="btn btn-default btn-file">
										Choose Image <input type="file" name="product_images[]" onchange="getFilename(this)" id="product_images" class="prod_images" multiple/>
									</span>
									
									<a href="#" class="remove_field"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>
									<?php echo nbs(2); ?>
									<span class="image_name" for="product_images"></span>
								</div>
							</div>
							
							<p><a href="#" class="upload_more_button"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
							
							<div class="form-group">
								<input type="hidden" name="prod_id" id="prod_id">
								<input type="button" class="btn btn-primary btn-block" onclick="javascript:uploadProductImages();" value="Upload">
							</div>
				  
					
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							
						</div>
					</div>
				</div>
			</div>	
		</form>		
		<!-- Add Product images -->	
	
		

		<!-- ADD Product -->
		<form action="<?php echo base_url('admin/add_product');?>" id="addProductForm" name="addProductForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Product</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="scrollable">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
										</div>
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="product_image" id="product_image">
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Category</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$category = '<select name="product_category" class="form-control">';
								$category .= '<option value="0">Select Category</option>';
								$category .= '<optgroup label="Male">';
								$this->db->from('male_categories');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										$category .= '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';			
									}
								}
								$category .= '</optgroup>';
								$category .= '<optgroup label="Female">';
								$this->db->from('female_categories');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										$category .= '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';			
									}
								}
								$category .= '</optgroup>';
								$category .= '</select>';
								echo $category;
										
							?>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Gender</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select name="product_gender" class="form-control" id="pGender">
									<option value="0">Select Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>	
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Colour</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							<?php
								$product_colour = '<select name="product_colour" class="form-control">';
								$product_colour .= '<option value="0">Select Colour</option>';
								
								$this->db->from('colours');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										$product_colour .= '<option value="'.$row['colour_name'].'">'.$row['colour_name'].'</option>';			
									}
								}
								$product_colour .= '</select>';
								echo $product_colour;
											
							?>		
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Size</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="product_size" class="form-control" id="pSize" placeholder="Product Size">
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Brand</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
								$product_brand = '<select name="product_brand" class="form-control">';
								$product_brand .= '<option value="0">Select Brand</option>';
								
								$this->db->from('brands');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										$product_brand .= '<option value="'.$row['brand_name'].'">'.$row['brand_name'].'</option>';			
									}
								}
								$product_brand .= '</select>';
								echo $product_brand;
											
							?>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="product_name" class="form-control" id="pName" placeholder="Product Name">
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Price</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">$</div>
										<input type="text" name="product_price" class="form-control" id="pPrice" onkeypress="return allowNumbersOnly(event)" placeholder="10" required>
									<div class="input-group-addon">.00</div>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Sale</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select name="sale" class="form-control" id="sle">
									<option value="No" select="selected">No</option>
									<option value="Yes">Yes</option>
								</select>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Sale Price</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">$</div>
										<input type="text" name="sale_price" class="form-control" id="salePrice" onkeypress="return allowNumbersOnly(event)" placeholder="10" required>
									<div class="input-group-addon">.00</div>
								</div>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Description</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea name="product_description" class="form-control" id="pDescription" placeholder="Product Description"></textarea>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Quantity</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="number" name="product_quantity_available" class="form-control" id="pQuantity">
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								
							</div>	
						</div>
																																	
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addProduct();" value="Add Product">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Product -->
		
		
		<!-- View Product -->
		<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 align="center" class="text-primary" id="productName"></h3>
					</div>
					<div class="modal-body">
							
						<div class="container col-md-12">
							
							<br/>
							
							<div class="row">
								<div class="col-xs-5">
									
									<div class="product-image">
										<span id="thumbnail" ></span>
									</div>
									
									<br/>
							
									<div class="product_gallery">
										<span id="image_gallery" ></span>
									</div>
									
									
								</div>
								<div class="col-xs-7">
									<div class="row">
										<div class="col-xs-12">
											
										</div>
									</div><!-- end row-->
									<div class="row">
										<div class="col-xs-12">
											<p><span class="label label-primary" id="productCategory"></span>
											<span class="monospaced" id="product_ref"></span></p>
										</div>
									</div><!-- end row -->
									
									<div class="row">
										<div class="col-xs-6">
											<span class="rating-box"></span>
										</div>
										
									</div><!-- end row -->
									
									<div class="row">
										<div class="col-xs-12 bottom-rule">
											<h2 class="product-price text-success" id="productPrice"></h2>
										</div>
									</div><!-- end row -->
									
									<hr/>

									<div class="row">
										<div class="col-xs-6 text-center">
											<span class="monospaced status"></span>
										</div>
										
									</div><!-- end row -->
									<hr/>
									
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
											<br/>
											<p class="top-10" id="p_description"></p>
											
											<p>
												<span class="label label-primary text-default" id="p_category">
												</span> 
												<span class="label label-default text-default" id="productGender"></span>
											</p>
											
										</div>
										<div role="tabpanel" class="tab-pane top-10" id="features">
											<br/>
											<p><strong>Brand: </strong><span id="product-brand"></span></p>
											<p><strong>Size: </strong><span id="product-size"></span></p>
											<p><strong>Colour: </strong><span id="product-colour"></span></p>
											
										</div>
										<div role="tabpanel" class="tab-pane" id="notes">
											<br/>
											<p><strong>Available Quantity: </strong><span id="productQuantity"></span></p>
											<p><strong>Date Added: </strong><span id="dateAdded"></span><p>
										</div>
										<div role="tabpanel" class="tab-pane" id="reviews">
											<br/>
											<span class="rating-box"></span>
										</div>
									</div>
									
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

		<!-- Edit Product -->
		<form action="<?php echo base_url('admin/update_product');?>" id="updateProductForm" name="updateProductForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="full_name"></h3>
				  </div>
				  <div class="modal-body">
					<div class="scrollable">
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Update Image</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-preview thumbnail p-thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px;">
									</div>
									<div>
										<span class="btn btn-primary btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="new_product_image" id="new_product_image" >
										</span>
										<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							</div>
								
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<span id="select_category"></span>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Gender</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select name="product_gender" class="form-control" id="product_gender">
									<option value="0">Select Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Colour</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<span id="select_colour"></span>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="hidden" name="productID" id="productID">
								<input type="text" name="product_name" class="form-control" id="product_name">	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Size</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="product_size" class="form-control" id="product_size">	
								<span id="select_size"></span>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Brand</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<span id="select_brand"></span>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Description</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea name="product_description" class="form-control" id="product_description" rows="8"></textarea>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Price</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">$</div>
										<input type="text" name="product_price" class="form-control" id="product_price" onkeypress="return allowNumbersOnly(event)" placeholder="10" required>
									<div class="input-group-addon">.00</div>
								</div>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product Quantity</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="product_quantity_available" class="form-control" id="product_quantity_available">	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Sale</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select name="sale" class="form-control" id="sale">
									<option value="No">No</option>
									<option value="Yes">Yes</option>
								</select>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Sale Price</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">$</div>
										<input type="text" name="sale_price" class="form-control" id="sale_price" onkeypress="return allowNumbersOnly(event)" placeholder="0">
									<div class="input-group-addon">.00</div>
								</div>		
							</div>	
						</div>
														
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				
					<input type="button" class="btn btn-primary" onclick="javascript:updateProduct();" value="Update Product">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Product -->
		


		<!-- ADD Product Option -->
		<form action="<?php echo base_url('admin/add_product_option');?>" id="addProductOptionForm" class="form-horizontal form-label-left input_mask" name="addProductOptionForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Product Option</h3>
				  </div>
				  <div class="modal-body">
				  
				  <div class="form_errors"></div>
				  
					<div class="">
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select name="product_id" id="product_id" class="form-control select2">
									<option value="0">Select Product</option>
								<?php
									$this->db->from('products');
									$this->db->order_by('id');
									$result = $this->db->get();
									if($result->num_rows() > 0) {
										foreach($result->result_array() as $row){
											echo '<option value="'.$row['id'].'">'.$row['name'].' ('.$row['id'].')</option>';			
										}
									}
				
								?>
								</select>
								
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								
								<?php
									echo $select_size;
								?>
								</select>
								
							</div>	
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Colour</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								
								<?php
									echo $select_colour;
								?>
								</select>
								
							</div>	
						</div>
														
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="number" name="quantity" class="form-control" id="quantity">
							</div>	
						</div>
								
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addProductOption();" value="Add Option">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Product Option -->
					

		<!-- Edit Product Option -->
		<form action="<?php echo base_url('admin/update_product_option');?>" id="updateProductOptionForm" name="updateProductOptionForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editOptionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="category"></h3>
				  </div>
				  <div class="modal-body">
				  
					<div class="form-errors"></div>
				  
					<div class="scrollable">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Product</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="hidden" name="optionID" id="optionID">
								<span id="prodID"><span>
							</div>	
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<span id="size-select"><span>	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Colour</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<span id="color-select"><span>
							</div>	
						</div>	
														
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="number" name="quantity" class="form-control" id="qty">
							</div>	
						</div>
									
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				
					<input type="button" class="btn btn-primary" onclick="javascript:updateProductOption();" value="Update Option">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Product Option -->
		
																				