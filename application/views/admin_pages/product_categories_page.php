
		
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
								<a href="#categories" aria-controls="categories" role="tab" data-toggle="tab"><h4><i class="fa fa-mars" aria-hidden="true"></i> Men</h4></a>
							</li>
							<li role="presentation">
								<a href="#categories2" aria-controls="categories2" role="tab" data-toggle="tab"><h4><i class="fa fa-venus" aria-hidden="true"></i> Women</h4></a>
							</li>
								
						</ul>
						<!-- /Nav tabs -->
								
						<!-- Tab panes -->
						<div class="tab-content">
							
							<!-- .tab-pane #male categories -->
							<div role="tabpanel" class="tab-pane active" id="categories">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addCategoryModal" title="Add Category" class="men"><i class="fa fa-plus"></i> Add Category</a>
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
								$hidden = array('model' => 'male_categories',);	
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
										<!-- male-categories-table -->
										<table id="male-categories-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>#</th>
													<th>Category</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /male-categories-table -->
										
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
							<!-- /male tab-pane -->
							
								
							<!-- .tab-pane #female categories -->
							<div role="tabpanel" class="tab-pane" id="categories2">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addCategoryModal"  class="women" title="Add Category"><i class="fa fa-plus"></i> Add Category</a>
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
								$hidden = array('model' => 'female_categories',);	
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
										<!-- female-categories-table -->
										<table id="female-categories-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>#</th>
													<th>Category</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /female-categories-table -->
										
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
							<!-- /female tab-pane -->
							
							
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




		<!-- ADD Product Category -->
		<form action="<?php echo base_url('admin/add_product_category');?>" id="addProductCategoryForm" class="form-horizontal form-label-left input_mask" name="addProductCategoryForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Product Category</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="">

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								
								<input type="text" name="category_name" class="form-control" id="cName" placeholder="Product Name">
								<input type="hidden" name="category_model" id="cModel">
							</div>	
						</div>
								
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addProductCategory();" value="Add Category">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Product Category -->
					

		<!-- Edit Product Category -->
		<form action="<?php echo base_url('admin/update_product_category');?>" id="updateProductCategoryForm" name="updateProductCategoryForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="category"></h3>
				  </div>
				  <div class="modal-body">
					<div class="form-errors"></div>
				  
					<div class="">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="hidden" name="categoryID" id="categoryID">
								<input type="hidden" name="category_model" id="categoryModel">
								<input type="text" name="category_name" class="form-control" id="category_name">	
							</div>	
						</div>							
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				
					<input type="button" class="btn btn-primary" onclick="javascript:updateProductCategory();" value="Update Category">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Product Category -->
		

																				