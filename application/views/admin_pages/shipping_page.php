
		
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
								<i class="fa fa-truck"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="#addShippingModal" title="Add Shipping"><i class="fa fa-plus"></i> Add Shipping</a>
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
								$hidden = array('model' => 'shipping_status',);	
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
									<!-- shipping-table -->
									<table id="shipping-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												
												<th>
													<input type="checkbox" name="checkBox" id="checkBox">
												</th>
												<th>#</th>
												<th>Reference</th>
												<th>Status</th>
												<th>Customer</th>
												<th>Date</th>								
												<th>#Edit</th>
															
											</tr>
										</thead>
										<tbody>
										</tbody>
										 
									</table>
									<!-- /shipping-table -->
																
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


		
	<!-- View Shipping -->
	<div class="modal fade" id="viewShippingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
					<div id="view-details"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Shipping -->	
	



		<!-- ADD Shipping -->
		
			<div class="modal fade" id="addShippingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 align="center">Add New Shipping</h3>
						</div>
						<div class="modal-body">
							<div class="form_errors"></div>
						
						<form action="<?php echo base_url('admin/add_shipping'); ?>" id="addShippingForm" name="addShippingForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
						
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Reference</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									
									<?php
										$select_reference = '<select name="reference" class="form-control reference">';
										$select_reference .= '<option value="0">Select Reference</option>';
										
										$this->db->from('orders');
										$this->db->order_by('id');
										$result = $this->db->get();
										if($result->num_rows() > 0) {
											foreach($result->result_array() as $row){
												$select_reference .= '<option value="'.$row['reference'].'">'.$row['reference'].'</option>';			
											}
										}
										
										$select_reference .= '</select>';
										echo $select_reference;
												
									?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Status</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<select name="status" class="form-control" id="status">
										<option value="0">Shipping Pending</option>
										<option value="1">Shipped</option>
									</select>
									
								</div>
							</div>
						  
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Note</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<textarea class="form-control wysi-editor" name="note" id="note" placeholder="Note"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Customer</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<input type="text" class="form-control" name="customer_email" id="customer_email" placeholder="john-doe@example.com">
									
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12">Shipping Date</label>
								<div class="col-md-10 col-sm-10 col-xs-12">
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="shipping_date" id="shipping_date" class="form-control datepicker">
									</div>
									<!-- /.input group -->
								</div>
								
							</div>
							<!-- /.form group -->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
							<input type="button" class="btn btn-success" onclick="javascript:addShipping();" value="Add Shipping">
							
						</div>
						</form>
					</div>
				</div>
			</div>	
				
		<!-- Add Shipping -->
		



		<!-- Edit Modal -->
		
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="edit-header" align="center"></h3>
				  </div>
					<div class="modal-body">
					
							
						<form action="<?php echo base_url('admin/update_shipping'); ?>" id="updateShippingForm" name="updateShippingForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Status</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<select name="status" class="form-control" id="shipping_status">
									<option value="0">Shipping Pending</option>
									<option value="1">Shipped</option>
								</select>
								<input type="hidden" name="shipping_id" id="shipping_id">	
							</div>
						</div>
						  
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Customer</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="text" name="customer_email" id="c_email" readonly>
							</div>
						</div>
						  
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Note</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<textarea class="form-control wysi-editor" name="note" id="shipping_note" placeholder="Note"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2 col-sm-2 col-xs-12">Shipping Date</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" name="shipping_date" id="shippingDate" class="form-control datepicker">
								</div>
								<!-- /.input group -->
							</div>
								
						</div>
						<!-- /.form group -->
					  
					</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateShipping();" value="Update">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Modal -->
			


