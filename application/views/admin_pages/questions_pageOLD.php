
<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pageTitle;?> <small>(<?php if($count == ''){ echo '0 questions' ;}else{ echo $count .' questions';} ?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li class="active">
                                <i class="fa fa-question-circle"></i> <?php echo $pageTitle;?>
                            </li>
                            <li>
								<a data-toggle="modal" data-target="#addQuestionModal" title="Add Question"><i class="fa fa-plus"></i> Add Question</a>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	<div>	
	<?php 
		$message = '';
		if($this->session->flashdata('question_added') != ''){
			$message = $this->session->flashdata('question_added');
		}	
		if($this->session->flashdata('question_deleted') != ''){
			$message = $this->session->flashdata('question_deleted');
		}	
		if($this->session->flashdata('deleted') != ''){
			$message = $this->session->flashdata('deleted');
		}		
		echo $message;						
	?>	
	</div>	
	
<div id="notif"></div>			
<div id="errors"></div>

<div align="center"><?php echo $display_option;?></div>
	
					<div class="row">
						<div class="col-lg-6 col-lg-offset-6 text-right">
							<form class="form-inline" role="form" action="<?php echo base_url('admin/questions');?>" method="get">
								<div class="form-group">
									<div class="col-sm-12">
									  <input type="text" class="form-control" name="search" placeholder="Search">
									</div>
									
								</div>
								<button type="submit" class="btn btn-default">Search</button>
							</form>
						</div>
					</div>
					<br/>
   								
                          
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
							$hidden = array('table' => 'questions',);	
							echo form_hidden($hidden);	
															
						?>	
<p><?php echo nbs(2);?> <?php echo img('assets/images/icons/crookedArrow.png');?> <a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" ><i class="fa fa-trash-o"></i> Delete</a></p>                
                			
						<div class="table-responsive" align="center">
							<table frame="box" id="question-table" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Question</th>
										<th>Category</th>
										<th>Image 1</th>
										<th>Option 1</th>
										<th>Image 2</th>
										<th>Option 2</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody class="question-tbody">
	<?php
							if($questions_array){
								
								foreach($questions_array as $question){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $question->id,
										'checked' => false,
									);		
									 											
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										
										<td><?php echo $question->id; ?></td>
										<td><?php echo $question->question; ?></td>
										<td><?php echo $question->category; ?></td>
										<td><img class="media-object" src="<?php echo base_url(); ?>uploads/questions/<?php echo $question->id; ?>/<?php echo $question->option_1_image; ?>" width="25" height="20" alt="option_1_image"></td>
										<td><?php echo $question->option_1; ?></td>
										<td><img class="media-object" src="<?php echo base_url(); ?>uploads/questions/<?php echo $question->id; ?>/<?php echo $question->option_2_image; ?>" width="25" height="20" alt="option_1_image"></td>
										<td><?php echo $question->option_2; ?></td>
										<td>
											<a data-toggle="modal" data-target="#editModal" class="btn btn-warning edit_question"  id="<?php echo html_escape($question->id);?>" title="Click to Edit"><i class="fa fa-pencil"></i></a>
										</td>
									</tr>										
	<?php					
								}
							}else {
?>
								  <tr>
									<td colspan="9" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No questions!</div>
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
					Delete Question(s)?
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected question(s)?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="submit" class="btn btn-danger" name="questionDelete"  value="OK">
				  </div>
				</div>
			  </div>
			</div>					
				
<?php 	
			
	//	close the form
	echo form_close();	
?>	
    <div class="row">
        <div class="col-md-12 text-center">
            <?php echo $pagination; ?>
        </div>
    </div>

		
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
 


		<!-- ADD Question -->
		<form action="admin/add_question"  id="addQuestionForm" name="addQuestionForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Question</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
				  
				  <p>Please enter a new question below:</p>
				  <br/>
				  
					<table class="table table-striped">

							<tr>
							
								<td colspan="3">
									
									<input type="text" class="form-control" value="<?php echo set_value('question'); ?>" id="question" name="question" placeholder="Enter a Question">					
							
								</td>
							</tr>
							<tr>
							
								<td colspan="3">
									<select name="category" id="category_dd" class="form-control">
										<option value="Random">Random</option>
										<option value="Fiesty">Fiesty</option>
										<option value="Romance">Romance</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="15%">
									<label for="option_1">Option 1:</label>
								</td>
								<td width="45%">
									<input type="text" class="form-control" value="<?php echo set_value('option_1'); ?>" id="option_1" name="option_1" placeholder="Option 1">
								</td>
								<td width="40%">
									<span class="btn btn-default btn-file">
										Image 1 <input type="file" name="image_1" id="option_1_image">
									</span>
									<span class="image_1_name" for="option_1_image">
									</span>
								</td>
							</tr>
							<tr>
								<td width="15%">
									<label for="option_2">Option 2:</label>
								</td>
								<td width="45%">
									<input type="text" class="form-control" value="<?php echo set_value('option_2'); ?>" id="option_2" name="option_2" placeholder="Option 2">
								</td>
								<td width="40%">
									<span class="btn btn-default btn-file">
										Image 2 <input type="file" name="image_2" id="option_2_image">
									</span>
									<span class="image_2_name" for="option_2_image">
									</span>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<input type="button" class="btn btn-primary" onclick="javascript:addQuestion();" value="Add New Question">			
								</td>
							</tr>
					</table>		
				
					
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Question -->
		
		
		<!-- Edit Question -->
		<form action="javascript:updateQuestion();" id="updateQuestionForm" name="updateQuestionForm" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				  </div>
				  <div class="modal-body">
					<div class="scrollable">
						<table class="table table-striped">
						
							<tr>
								<td align="right"><label for="full_question">Question:</label>
								<input type="hidden" name="questionID" id="questionID">
								</td>
								<td align="left"><input type="text" name="full_question" id="full_question"></td>
							</tr>	
							
							<tr>
								<td align="right"><label for="category">Current Category:</label>
								
								</td>
								<td align="left">
									<div id="category"></div>
								</td>
							</tr>
							<tr>
								<td align="right"><label for="edit_option_1">Option 1:</label></td>
								<td align="left"><input type="text" name="edit_option_1" id="edit_option_1"></td>
							</tr>
							<tr>
								<td align="right"><label for="edit_option_1_image">Image 1:</label></td>
								<td align="left">
									<span class="btn btn-default btn-file">
										Image 1 <input type="file" name="edit_option_1_image" id="edit_option_1_image">
									</span>
									<span for="edit_option_1_image"></span>
									<input type="hidden" name="old_image_1" id="old_image_1">
								</td>
							</tr>
							<tr>
								<td align="right"><label for="edit_option_2">Option 2:</label></td>
								<td align="left"><input type="text" name="edit_option_2" id="edit_option_2"></td>
							</tr>
							<tr>
								<td align="right"><label for="edit_option_2_image">Image 2:</label></td>
								<td align="left">
									<span class="btn btn-default btn-file">
										Image 2 <input type="file" name="edit_option_2_image" id="edit_option_2_image">
									</span>
									<span for="edit_option_2_image"></span>
									<input type="hidden" name="old_image_2" id="old_image_2">
								</td>
							</tr>
							
						</table>						
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateQuestion();" value="Update Question">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit User -->