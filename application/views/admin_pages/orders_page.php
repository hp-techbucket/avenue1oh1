
		
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
								<i class="fa fa-th-list"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="#addOrderModal" title="Add Order"><i class="fa fa-plus"></i> Add Order</a>
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
								$hidden = array('model' => 'orders',);	
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
									<!-- orders-table -->
									<table id="orders-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>
													<input type="checkbox" name="checkBox" id="checkBox">
												</th>
												<th>Reference</th>
												<th>Total Price</th>
												<th>Customer</th>	
												<th>Payment</th>
												<th>Shipping</th>
												<th>Date</th>
												<th>#Edit</th>		
											</tr>
										</thead>
										<tbody>
										</tbody>
										 
									</table>
									<!-- /orders-table -->
																
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


		
	<!-- View Order -->
	<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
					
					<div id="view-details"></div>
					<br/>
							
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Order -->	
	


	<!-- ADD ORDER -->
	<!-- .modal -->
	<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Order</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<form action="<?php echo base_url('admin/add_order'); ?>" id="addOrderForm" name="addOrderForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
					
					<!-- .form group -->
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Total Price</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="input-group">
								<div class="input-group-addon">
									$
								</div>
								<input type="number" name="total_price" id="total_price" class="form-control">
								<div class="input-group-addon">
									.00
								</div>
							</div>
							<!-- /.input group -->
						</div>		
					</div>
					<!-- /.form group -->
					
					<!-- .form group -->
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Customer Email</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
						<?php
							$select_email = '<select name="customer_email" class="form-control customer_email">';
							$select_email .= '<option value="0">Select User</option>';
										
							$this->db->from('users');
							$this->db->order_by('id');
							$result = $this->db->get();
							if($result->num_rows() > 0) {
								foreach($result->result_array() as $row){
									$select_email .= '<option value="'.$row['email_address'].'">'.$row['first_name'].''.$row['last_name'].' ('.$row['email_address'].')</option>';			
								}
							}
										
							$select_email .= '</select>';
							echo $select_email;
												
						?>		
						</div>
					</div>
					<!-- /.form group -->
					
					<!-- .form group -->
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Payment Status</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<select name="payment_status" class="form-control" id="payment_status">
								<option value="No">No</option>
								<option value="Yes">Paid</option>
							</select>	
						</div>
					</div>
					<!-- /.form group -->
					
					<!-- .form group -->
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 col-xs-12">Shipping Status</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<select name="shipping_status" class="form-control" id="shipping_status">
								<option value="No">No</option>
								<option value="Yes">Shipped</option>
							</select>	
						</div>
					</div>
					<!-- /.form group -->
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					<input type="button" class="btn btn-success" onclick="javascript:addOrder();" value="Add Order">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Add Order -->
		

	<!-- Edit Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="edit-header" align="center"></h3>
				</div>
				<div class="modal-body">
				
					<form action="<?php echo base_url('admin/update_order'); ?>" id="updateOrderForm" name="updateOrderForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Total Price</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<div class="input-group">
								<div class="input-group-addon">
									$
								</div>
								<input type="number" name="total_price" id="totalPrice" class="form-control" readonly>
								<div class="input-group-addon">
									.00
								</div>
							</div>
							<!-- /.input group -->
						</div>		
					</div>
					<!-- /.form group -->
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Payment Status</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<select name="payment_status" class="form-control" id="paymentStatus">
								<option value="No">No</option>
								<option value="Yes">Paid</option>
							</select>		
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-12">Shipping Status</label>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<select name="shipping_status" class="form-control" id="shippingStatus">
								<option value="No">No</option>
								<option value="Yes">Shipped</option>
							</select>	
						</div>
					</div>
					  
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateOrder();" value="Update">
				</div>
			</div>
		</div>
	</div>	
	</form>		
	<!-- /Edit Modal -->
			



		
		