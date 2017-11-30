
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
                            <?php echo $pageTitle;?> <small>(<?php if($count == ''){ echo '0 records' ;}else if($count == 1){ echo '1 record' ;}else{ echo $count .' records';} ?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/payments/'" title="Payments" ><i class="fa fa-money"></i> Payments</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/card_payment_methods/'" title="Card Payment Methods" ><i class="fa fa-credit-card"></i> Card Payment Methods</a>
                            </li>							
                            <li class="active">
                                <i class="fa fa-cc-paypal"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	<div>	
	<?php 
	$message = '';
	if($this->session->flashdata('deleted') != ''){
		$message = $this->session->flashdata('deleted');
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
							
							$hidden = array('table' => 'payment_methods',);	
							echo form_hidden($hidden);	
								
							
						?>	
			
			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Type</th>
										<th>PayPal Email</th>
										<th>User Email</th>
										<th>Date Added</th>
									</tr>
								</thead>
								<tbody>
	<?php
							if($paypal_payment_methods_array){
								
								foreach($paypal_payment_methods_array as $paypal){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $paypal->id,
										'checked' => false,
									);		
																				
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										<td><?php echo $paypal->id; ?></td>
										<td><?php echo $paypal->type ; ?></td>
										<td><?php echo $paypal->PayPal_email ; ?></td>
										<td><?php echo $paypal->user_email ; ?></td>										
										<td><?php echo date("F j, Y", strtotime($paypal->date_added)); ?></td>
					
									</tr>											
	<?php
								}
							}else {
?>
								  <tr>
									<td colspan="11" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No PayPal payment methods!</div>
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

