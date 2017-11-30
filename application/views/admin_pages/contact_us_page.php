
		
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
								<i class="fa fa-envelope"></i> <?php echo $pageTitle;?>
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
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'contact_us',);	
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
									</div>
								</div>
								<!-- /delete button container -->
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- contact-us-table -->
										<table id="contact-us-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													<th>Name</th>
													<th>Company</th>
													<th>Telephone</th>
													<th>Email</th>
													<th>Date</th>
													
													<th>View</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /contact-us-table -->
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->
		
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
	
		<!-- View Modal -->
			<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="headerTitle" align="center"></h3>
					</div>
					<div class="modal-body">
						<table class="table" style="width: 100%">
							<tr>
								<td width="20%">
									<span><strong>Name</strong></span>
								</td>
								<td width="80%">
									<span id="contact_name"></span>	
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>Company</strong></span>
								</td>
								<td>
									<span id="contact_company"></span>
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>Telephone</strong></span>
								</td>
								<td>
									<span id="contact_telephone"></span>
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>Email</strong></span>
								</td>
								<td>
									<span id="contact_email"></span>
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>Message</strong></span>
								</td>
								<td>
									<span id="contact_message"></span>
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>IP Address</strong></span>
								</td>
								<td>
									<span id="ip_address"></span>
								</td>
							</tr>
							
							<tr>
								<td>
									<span><strong>Date</strong></span>
								</td>
								<td>
									<span id="contact_us_date"></span>
								</td>
							</tr>
						</table>
						
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				  </div>
				</div>
			  </div>
			</div>	
		<!-- View Modal -->

			
	