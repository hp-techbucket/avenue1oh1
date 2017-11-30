
		
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
								<i class="fa fa-file"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="javascript:void(0)" data-toggle="modal" data-target="#addMetadataModal" title="Add Page Metadata"><i class="fa fa-plus"></i> Add Page Metadata</a>
							</li>
																			
						</ol>
					</div>
				</div>
				<!-- /breadcrumb -->
				
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<!-- .x_panel -->
						<div class="x_panel">
							<div class="x_title">
								<h2><?php echo $pageTitle;?></h2>
							   
								<div class="clearfix"></div>
							</div>
							
							<!-- .x_content -->
							<div class="x_content">
								
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'page_metadata',);	
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
										if($this->session->flashdata('added') != ''){
											$message = $this->session->flashdata('added');
										}	
										if($this->session->flashdata('deleted') != ''){
											$message = $this->session->flashdata('deleted');
										}
										if($this->session->flashdata('updated') != ''){
											$message = $this->session->flashdata('updated');
										}	
										echo $message;
													
									?>
										<div class="notif"></div>
										<div class="errors"></div>
									</div>
								</div>
							</div>
							<!-- /delete button container -->
										
							<!-- container -->
							<div class="container">
								<!-- table-responsive -->
								<div class="table-responsive" >
									<!-- page-metadata-table -->
									<table id="page-metadata-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>
													<input type="checkbox" name="checkBox" id="checkBox">
												</th>
												<th>Page</th>
												<th>Keywords</th>
																						
												<th>#Edit</th>
															
											</tr>
										</thead>
										<tbody>
										</tbody>
										 
									</table>
									<!-- /page-metadata-table -->
																
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
												
										//	close the form
										echo form_close();	
									?>		

								</div>
								<!-- /table-responsive -->
							</div>
							<!-- /container -->
													
								
							</div>
							<!-- /x_content -->
							
						</div>
						<!-- /x_panel -->
						
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->


		
	<!-- View Page Metadata -->
	<div class="modal fade" id="viewPageMetadataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
					<div class="med-scrollable">
						<div class="container col-md-12">
						
							<h3>Page</h3>
							<p><span id="view-page"></span></p>
							<br/>
							
							<h3>Keywords</h3>
							<p><span id="view-keywords"></span></p>
							<br/>
							
							<h3>Description</h3>
							<p><span id="view-description"></span></p>
							
							
						</div>
					</div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Page Metadata -->	
	



		<!-- ADD Page Metadata -->
		
			<div class="modal fade" id="addMetadataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 align="center">Add New Page Metadata</h3>
						</div>
						<div class="modal-body">
							<div class="form_errors"></div>
						
						<form action="<?php echo base_url('admin/add_page_metadata'); ?>" id="addMetadataForm" name="addMetadataForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
						
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Page</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<input type="text" class="form-control" name="page" id="page" placeholder="Page">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Keywords</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<input type="text" class="form-control tags-input" name="keywords" id="keywords" placeholder="Keywords">
									
								</div>
							</div>
						  
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Description</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<textarea class="form-control wysi-editor" name="description" id="description" placeholder="Description"></textarea>
								</div>
							</div>
						  
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
							<input type="button" class="btn btn-success" onclick="javascript:addPageMetadata();" value="Add New Metadata">
							
						</div>
						</form>
					</div>
				</div>
			</div>	
				
		<!-- Add PageMetadata -->
		



		<!-- Edit Modal -->
		
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="edit-header" align="center"></h3>
				  </div>
					<div class="modal-body">
					
							
						<form action="<?php echo base_url('admin/update_page_metadata'); ?>" id="updateMetadataForm" name="updateMetadataForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Page</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="text" class="form-control" name="page" id="u-page" placeholder="Page">
								<input type="hidden" name="page_metadata_id" id="page_metadata_id">
							</div>
						</div>
					  
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Keywords</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="text" class="form-control" name="keywords" id="u-keywords" placeholder="Keywords">
								
							</div>
						</div>
					  
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Description</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
							
							<textarea class="form-control" name="description" style="" id="u-description"></textarea>
							
							
							</div>
						</div>
					  
					</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updatePageMetadata();" value="Update">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Modal -->
			


