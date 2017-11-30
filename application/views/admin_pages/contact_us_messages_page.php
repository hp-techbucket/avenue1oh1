
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
                            <?php echo $pageTitle;?> <small>(<?php if($count == ''){ echo '0 messages' ;}else{ echo $count .' messages';}?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li class="active">
                                <i class="fa fa-envelope"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
 	<div>	
	<?php 
	$message = '';
	if($this->session->flashdata('message_deleted') != ''){
		$message = $this->session->flashdata('message_deleted');
	}	
	echo $message;						
	?>	
	</div>				
					
<p><?php echo nbs(2);?> <?php echo img('assets/images/icons/crookedArrow.png');?> <button class="btn btn-danger" data-toggle="modal" data-target="#myModal" id="deleteB" ><i class="fa fa-trash-o"></i> Delete</button></p>   								
                         
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
							$hidden = array('table' => 'contact_us',);	
							echo form_hidden($hidden);							
						?>	
			
			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Name</th>
										<th>Telephone</th>
										<th>Email</th>
										<th>Subject</th>
										<th>Message</th>
										<th>View</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
	<?php
							if($contact_us_array){
								
								foreach($contact_us_array as $contact_us){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $contact_us->contact_us_id,
										'checked' => false,
									);		
																				
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										<td><?php echo $contact_us->contact_us_id; ?></td>
										<td><?php echo $contact_us->contact_name ; ?></td>
										<td><?php echo $contact_us->contact_telephone ; ?></td>
										<td><?php echo $contact_us->contact_email ; ?></td>
										<td><?php echo $contact_us->contact_subject ; ?></td>
										<td><div class="ellipsis"><?php echo $contact_us->contact_message ; ?></div></td>
										<td><?php echo date("F j, Y, g:i a", strtotime($contact_us->contact_us_date)); ?></td>
										<td>
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/view/contact_us/<?php echo $contact_us->contact_us_id; ?>'" class="btn btn-info" title="Click to View"><i class="fa fa-eye"></i></a></td>
										<td>
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/delete/contact_us/<?php echo $contact_us->contact_us_id; ?>'" class="btn btn-danger" title="Click to Delete"><i class="fa fa-trash"></i></a>
										</td>
									</tr>						
	<?php
								}
							}else {
?>
              <tr>
                <td colspan="10" align="center"><div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only"></span> No messages yet!</div>
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


