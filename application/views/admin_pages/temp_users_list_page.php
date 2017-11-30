
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
                            <?php echo $pageTitle;?> <small>(<?php if($count == ''){ echo '0 records' ;}else{ echo $count .' records';} ?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/users/'" title="User Lists"><i class="fa fa-users"></i> User Lists</a>
                            </li>	

                            <li class="active">
                                <i class="fa fa-users"></i> <?php echo $pageTitle;?>
                            </li>							
						
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
						<div>	
							<?php 
								$message = '';

								if($this->session->flashdata('temp_user_deleted') != ''){
									$message = $this->session->flashdata('temp_user_deleted');
								}	
								echo $message;
								
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
									'onClick' => 'checkAll(this.checked)',
									
								);		

								$hidden = array('table' => 'temp_users',);	
								echo form_hidden($hidden);	
																
							?>	
							<?php echo nbs(1); ?>
						</div>		
						
<p><?php echo nbs(2);?> <?php echo img('assets/images/crookedArrow.png');?> <a class="btn btn-danger" data-toggle="modal" data-target="#myModal" id="deleteButton" ><i class="fa fa-trash-o"></i> Delete</a></p>                
                <div class="row">
                    <div class="col-lg-12" >			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Name</th>
										<th>Location</th>
									
										<th>Activation</th>
										<th>Joined</th>
										
									</tr>
								</thead>
								<tbody>
							<?php
							if($temp_users_array){
								
								foreach($temp_users_array as $user){	
								
								$data_checkbox = array(
														
									'name' => 'cb[]',
									'id'   => 'cb',
									'value' => $user->temp_user_id,
									'checked' => false,
								);	
								
							?>			
													
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										<td><?php echo $user->temp_user_id; ?></td>
										<td><?php echo $user->first_name .' '.$user->last_name ; ?></td>
										<td><?php echo $user->location ; ?></td>
										
										<td><?php echo $user->activation_key ; ?></td>
										<td><?php echo date("F j, Y", strtotime($user->date_created)) ; ?></td>

									</tr>	

									
				<?php
				
					}
				}else {
?>
								  <tr>
									<td colspan="6" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No temp users listed yet!</div>
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
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Delete Users?
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected users?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="submit" class="btn btn-danger" name="userDelete"  value="OK">
				  </div>
				</div>
			  </div>
			</div>		
			
			<div class="row">
				<div class="col-md-12 text-center">
					<?php echo $pagination; ?>
				</div>
			</div>			
				
<?php 	
			
	//	close the form
	echo form_close();
	echo br(15);				
?>

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


