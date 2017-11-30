
<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">
			
			
				<div>	
				<?php 
				$message = '';
				if($this->session->flashdata('category_added') != ''){
					$message = $this->session->flashdata('category_added');
				}
				if($this->session->flashdata('category_updated') != ''){
					$message = $this->session->flashdata('category_updated');
				}		
				if($this->session->flashdata('deleted') != ''){
					$message = $this->session->flashdata('deleted');
				}		
				echo $message;						
				?>	
				</div>				
		
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pageTitle;?> <small>(<?php if($count == ''){ echo '0 categories' ;}else{ echo $count .' categories';} ?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li class="active">
                                <i class="fa fa-question-circle"></i> <?php echo $pageTitle;?>
                            </li>
                            <li>
								<a data-toggle="modal" data-target="#addCategoryModal" title="Add Category"><i class="fa fa-plus"></i> Add Category</a>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<div class="row">
                    <div class="col-lg-12">
						<div id="notif"></div>		
						<div id="errors"></div>		<br/>	
					</div>
                </div>					
			
<p><?php echo nbs(2);?> <?php echo img('assets/images/icons/crookedArrow.png');?> <button class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" ><i class="fa fa-trash-o"></i> Delete</button></p>   								
                          
                <div class="row">
                    <div class="col-lg-12">
						
						<?php 
							//define form attributes
							$attributes = array('name' => 'myform');
												
							//start message form
							echo form_open('admin/multi_delete', $attributes);
							//Title bar checkbox property setting
							$data = array(
								'name' => 'checkBox',
								'id' => 'checkBox',
								'value' => 'accept',
								'checked' => false,
								
							);		
							$hidden = array('table' => 'question_categories',);	
							echo form_hidden($hidden);	
															
						?>	
			
			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Category</th>
										<th>Edit</th>
										
									</tr>
								</thead>
								<tbody class="category-tbody">
	<?php
							if($categories_array){
								
								foreach($categories_array as $category){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $category->id,
										'checked' => false,
									);		
									 											
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										
										<td><?php echo $category->id; ?></td>
										<td><?php echo $category->category; ?></td>
										<td><a data-toggle="modal" data-target="#editModal" class="btn btn-warning edit_category" id="<?php echo html_escape($category->id);?>" title="Click to Edit"><i class="fa fa-pencil"></i></td>
									</tr>										
	<?php					
								}
							}else {
?>
								  <tr>
									<td colspan="3" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No categories!</div>
									</td>
								  </tr>

    <?php
       }
    ?>							
								</tbody>
							</table>
						</div>	
                    </div>
                </div>
                <!-- /.row -->
				
			<!-- Modal -->
			<div class="modal fade" id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Delete Category(ies)?
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected category(ies)?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="submit" class="btn btn-danger" name="categoryDelete"  value="OK">
				  </div>
				</div>
			  </div>
			</div>					
				
<?php 	
			
	//	close the form
	echo form_close();	
?>	
  
<?php echo br(15); ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php   
		}
	}								
?>



		<!-- ADD Category -->
		<form action="admin/add_category" id="addCategoryForm" name="addCategoryForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Category</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					
					<div class="row">
						<div class="col-lg-12">

							<div>
								<?php echo form_label('Please enter a new category below:', 'category'); ?><br/>
								<input type="text" value="<?php echo set_value('category'); ?>" id="category" name="category" placeholder="Enter a new category">
								<?php echo form_error('category'); ?>
								<?php echo br(2); ?>
								<input type="button" class="btn btn-primary" onclick="javascript:addCategory();" value="Add New Category">
								
							</div>	
													
						</div>
					</div>
					<!-- /.row -->					
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Category -->
		
		
		
		<!-- Edit Category -->
		<form action="javascript:updateCategory();" id="updateCategoryForm" name="updateCategoryForm" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="name"></h3>
				  </div>
				  <div class="modal-body">
					<div class="scrollable">
						<table class="table table-striped">
				
							<tr>
								<td align="right"><label>Category:</label>
								<input type="hidden" name="categoryID" id="categoryID">
								</td>
								<td align="left"><input type="text" name="category" id="category_name"></td>
							</tr>	
							
						</table>						
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateCategory();" value="Update Question">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Category -->