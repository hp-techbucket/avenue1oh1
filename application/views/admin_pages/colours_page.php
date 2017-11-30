
		
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
								<i class="fa fa-paint-brush"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="#addColourModal" title="Add Colour" ><i class="fa fa-plus"></i> Add Colour</a>
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
							
					<div class="notif"></div>
					
					<br/>
												
				<?php
					//start multi delete form
					$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
					echo form_open('admin/multi_delete',$delete_form_attributes);
					//hidden item - model name
					$hidden = array('model' => 'colours',);	
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
							<!-- colours-table -->
							<table id="colours-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>
											<input type="checkbox" name="checkBox" id="checkBox">
										</th>		
										<th>#</th>
										<th>Colour</th>
										<th>#Edit</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								 
							</table>
							<!-- /Colours-table -->
						</div>
						<!-- /table-responsive -->
					</div>
					<!-- /table container -->
									
				</div>
				<!-- /x_content -->
				
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
	



		<!-- ADD Colour -->
		<form action="<?php echo base_url('admin/add_colour');?>" id="addColourForm" class="form-horizontal form-label-left input_mask" name="addColourForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addColourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Colour</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="">

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Colour Name</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								
								<input type="text" name="colour_name" class="form-control" id="cName" placeholder="Colour Name">
								
							</div>	
						</div>
								
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addColour();" value="Add Colour">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Colour -->
					

		<!-- Edit Colour -->
		<form action="<?php echo base_url('admin/update_colour');?>" id="updateColourForm" name="updateColourForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editColourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="colour"></h3>
				  </div>
				  <div class="modal-body">
					<div class="form-errors"></div>
				  
					<div class="">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="hidden" name="colourID" id="colourID">
								
								<input type="text" name="colour_name" class="form-control" id="colour_name">	
							</div>	
						</div>							
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				
					<input type="button" class="btn btn-primary" onclick="javascript:updateColour();" value="Update Colour">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Colour -->
		

																				