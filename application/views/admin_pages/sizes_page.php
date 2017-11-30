
		
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
								<a href="#men-sizes" aria-controls="men-sizes" role="tab" data-toggle="tab"><h4><i class="fa fa-mars" aria-hidden="true"></i> Men Clothing</h4></a>
							</li>
							
							<li role="presentation">
								<a href="#male-shoe-sizes" aria-controls="male-shoe-sizes" role="tab" data-toggle="tab"><h4><i class="fa fa-mars" aria-hidden="true"></i> Men Shoes</h4></a>
							</li>
							<li role="presentation">
								<a href="#women-sizes" aria-controls="women-sizes" role="tab" data-toggle="tab"><h4><i class="fa fa-venus" aria-hidden="true"></i> Women Clothing</h4></a>
							</li>
							<li role="presentation">
								<a href="#women-shoe-sizes" aria-controls="women-shoe-sizes" role="tab" data-toggle="tab"><h4><i class="fa fa-venus" aria-hidden="true"></i> Women Shoes</h4></a>
							</li>	
						</ul>
						<!-- /Nav tabs -->
								
						<!-- Tab panes -->
						<div class="tab-content">
							
							<!-- .tab-pane #male sizes -->
							<div role="tabpanel" class="tab-pane active" id="men-sizes">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addSizeModal" title="Add Size" class="men-sizes"><i class="fa fa-plus"></i> Add Size</a>
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
								$hidden = array('model' => 'male_sizes',);	
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
										<!-- male-sizes-table -->
										<table id="male-sizes-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>#</th>
													<th>Size EU</th>
													<th>Size UK</th>
													<th>Size US</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /male-sizes-table -->
										
						
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
							<!-- /male sizes tab-pane -->
							
							<!-- .tab-pane #male shoes sizes-->
							<div role="tabpanel" class="tab-pane" id="male-shoe-sizes">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addSizeModal" title="Add Size" class="men-shoe-sizes"><i class="fa fa-plus"></i> Add Size</a>
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
								$hidden = array('model' => 'male_shoe_sizes',);	
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
										<!-- male-shoe-sizes-table -->
										<table id="male-shoe-sizes-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>#</th>
													<th>Size EU</th>
													<th>Size UK</th>
													<th>Size US</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /male-shoe-sizes-table -->
										
						
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
							<!-- /male shoe sizes tab-pane -->
								
							<!-- .tab-pane #female sizes -->
							<div role="tabpanel" class="tab-pane" id="women-sizes">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addSizeModal"  class="women-sizes" title="Add Size"><i class="fa fa-plus"></i> Add Size</a>
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
								$hidden = array('model' => 'female_sizes',);	
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
										<!-- female-sizes-table -->
										<table id="female-sizes-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>#</th>
													<th>Size EU</th>
													<th>Size UK</th>
													<th>Size US</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /female-sizes-table -->
										
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
							<!-- /female sizes tab-pane -->
								
							<!-- .tab-pane #female shoe sizes -->
							<div role="tabpanel" class="tab-pane" id="women-shoe-sizes">
							
							<ol class="breadcrumb">
								<li>
									<a href="#" data-toggle="modal" data-target="#addSizeModal"  class="women-shoe-sizes" title="Add Shoe Size"><i class="fa fa-plus"></i> Add Shoe Size</a>
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
								$hidden = array('model' => 'female_shoe_sizes',);	
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
										<!-- female-shoe-sizes-table -->
										<table id="female-shoe-sizes-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>#</th>
													<th>Size EU</th>
													<th>Size UK</th>
													<th>Size US</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /female-shoe-sizes-table -->

						
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
							<!-- /female shoe sizes tab-pane -->

							
							
							
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



		<!-- ADD Size -->
		<form action="<?php echo base_url('admin/add_size');?>" id="addSizeForm" class="form-horizontal form-label-left input_mask" name="addSizeForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addSizeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add Size</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="">

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size EU</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								
								<input type="text" name="size_EU" class="form-control" id="s_EU" placeholder="Size EU">
								<input type="hidden" name="size_model" id="sModel">
							</div>	
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size UK</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="size_UK" class="form-control" id="s_UK" placeholder="Size UK">
							</div>	
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size US</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="size_US" class="form-control" id="s_US" placeholder="Size US">
							</div>	
						</div>
						
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addSize();" value="Add Size">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Size -->
					

		<!-- Edit Size -->
		<form action="<?php echo base_url('admin/update_size');?>" id="updateSizeForm" name="updateSizeForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editSizeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				  </div>
				  <div class="modal-body">
					<div class="form-errors"></div>
				  
					<div class="">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size EU</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="hidden" name="sizeID" id="sizeID">
								<input type="hidden" name="size_model" id="sizeModel">
								<input type="text" name="size_EU" class="form-control" id="size_EU">	
							</div>	
						</div>	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size UK</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="size_UK" class="form-control" id="size_UK">	
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Size US</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="size_US" class="form-control" id="size_US">	
							</div>	
						</div>							
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				
					<input type="button" class="btn btn-primary" onclick="javascript:updateSize();" value="Update Size">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Size -->
		

																				