
		
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
								<i class="fa fa-sign-in"></i> <?php echo $pageTitle;?>
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
								<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4><i class="fa fa-list-alt"></i> Logins</h4></a>
							</li>
							<li role="presentation">
								<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4><i class="fa fa-list-alt"></i> Failed Logins</h4></a>
							</li>
							<li role="presentation">
								<a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"><h4><i class="fa fa-list-alt"></i> Failed Resets</h4></a>
							</li>	
											
						</ul>
						<!-- /Nav tabs -->
								
						<!-- Tab panes -->
						<div class="tab-content">
						
							<!-- .tab-pane #tab1 -->
							<div role="tabpanel" class="tab-pane active" id="tab1">
							<br/>
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'logins',);	
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
											<div id="notif"></div>
											<div id="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
								
								<!-- container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- logins-table -->
										<table id="logins-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													<th>IP</th>
													<th>Username</th>
													<th>Password</th>
													<th>Date</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /logins-table -->
										
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
								<!-- /container -->
							</div>
							<!-- /tab-pane #tab1 -->
							
							
							<!-- .tab-pane #tab2 -->
							<div role="tabpanel" class="tab-pane" id="tab2">
							<br/>
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'failed_logins',);	
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
											<div id="notif"></div>
											<div id="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
								
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- failed-logins-table -->
										<table id="failed-logins-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													
													</th>
													<th>IP</th>
													<th>Username</th>
													<th>Password</th>
													<th>Date</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /failed-logins-table -->
										
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
							<!-- /tab-pane #tab2-->
							
							
							<!-- .tab-pane #tab3 -->
							<div role="tabpanel" class="tab-pane" id="tab3">
							<br/>
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'failed_resets',);	
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
											<div id="notif"></div>
											<div id="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
								
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- failed-resets-table -->
										<table id="failed-resets-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													
													</th>
													<th>IP Address</th>
													<th>Email</th>
													<th>Security Answer</th>
													<th>Date</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /failed-resets-table -->

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
							<!-- /tab-pane #tab3 -->
							
							
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

										