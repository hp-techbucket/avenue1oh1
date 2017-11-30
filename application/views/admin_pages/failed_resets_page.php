
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
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/login_list/'" title="Active Logins" ><i class="fa fa-sign-in"></i> Active Logins</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/failed_logins/'" title="Failed Logins" ><i class="fa fa-exclamation-triangle"></i> Failed Logins</a>
                            </li>

                            <li class="active">
                                <i class="fa fa-exclamation-circle"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	<div>	
	<?php 
	$message = '';
	if($this->session->flashdata('failed_reset_deleted') != ''){
		$message = $this->session->flashdata('failed_reset_deleted');
	}	
	echo $message;						
	?>	
	</div>				
					
<p><?php echo nbs(2);?> <?php echo img('assets/images/crookedArrow.png');?> <button class="btn btn-danger" data-toggle="modal" data-target="#myModal" id="deleteButton" ><i class="fa fa-trash-o"></i> Delete</button></p>   								
                          
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
								'onClick' => 'checkAll(this.checked)',
							);	
							$hidden = array('table' => 'failed_resets',);	
							echo form_hidden($hidden);								
						?>	
			
			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>IP Address</th>
										<th>Email</th>
										<th>Security Answer</th>
										<th>Attempt Time</th>
										
									</tr>
								</thead>
								<tbody>
	<?php
							if($failed_resets_array){
								
								foreach($failed_resets_array as $failed_reset){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $failed_reset->id,
										'checked' => false,
									);		
																				
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										<td><?php echo html_escape($failed_reset->id); ?></td>
										<td><?php echo html_escape($failed_reset->ip_address) ; ?></td>
										<td><?php echo html_escape($failed_reset->email_address) ; ?></td>
										<td><?php echo html_escape($failed_reset->security_answer) ; ?></td>
										<td><?php echo date("F j, Y, g:i a", strtotime($failed_reset->attempt_time)); ?></td>
										
									</tr>		
											
												
	<?php
								}
							}else {
?>
								  <tr>
									<td colspan="7" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No Failed Resets</div>
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

