
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
                                <i class="fa fa-reply"></i> <?php echo $pageTitle;?>
                            </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	<div>	
	<?php 
	$message = '';	
	if($this->session->flashdata('answer_deleted') != ''){
		$message = $this->session->flashdata('answer_deleted');
	}		
	echo $message;						
	?>	
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
							$hidden = array('table' => 'answers',);	
							echo form_hidden($hidden);	
															
						?>	
			
			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Question (ID)</th>
										<th>Answer</th>
										<th>User</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody class="question-tbody">
	<?php
							if($quiz_answers_array){
								
								foreach($quiz_answers_array as $answer){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $answer->id,
										'checked' => false,
									);		
									
									//obtain users full name from the db using username
									$fullname = '';
									$query = $this->db->get_where('users', array('username' => $answer->username)); 
									if($query){
										foreach ($query->result() as $row)
										{
											$fullname = $row->first_name.' '.$row->last_name;
										}							
									}	
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										
										<td><?php echo $answer->id; ?></td>
										<td><?php echo $answer->question .' ('.$answer->question_id .')'; ?></td>
										<td><?php echo $answer->answer; ?></td>
										<td><?php echo $fullname .' ('.$answer->username.')'; ?></td>
										<td><?php echo date('F j, Y', strtotime($answer->time_answered)); ?></td>
									</tr>										
	<?php					
								}
							}else {
?>
								  <tr>
									<td colspan="6" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No answers!</div>
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
					Delete Answer(s)?
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected answer(s)?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="submit" class="btn btn-danger" name="answerDelete"  value="OK">
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

