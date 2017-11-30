
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
                            <li class="active">
                                <i class="fa fa-credit-card"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	<div>	
	<?php 
	$message = '';
	if($this->session->flashdata('payment_method_deleted') != ''){
		$message = $this->session->flashdata('payment_method_deleted');
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
										<th>Name on Card</th>
										<th>Card Number</th>
										<th>Expiry Month</th>
										<th>Expiry Year</th>
										<th>CVV</th>
										
										<th>User Email</th>
										<th>Date Added</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>
	<?php
							if($payment_methods_array){
								
								foreach($payment_methods_array as $payment_method){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $payment_method->payment_method_id,
										'checked' => false,
									);		
																				
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										<td><?php echo $payment_method->payment_method_id; ?></td>
										<td><?php echo $payment_method->type ; ?></td>
										<td><?php echo $payment_method->name_on_card ; ?></td>
										<td><?php echo $payment_method->card_number; ?></td>
										<td><?php echo $payment_method->expiry_month ; ?></td>
										<td><?php echo $payment_method->expiry_year ; ?></td>
										<td><?php echo $payment_method->card_cvc; ?></td>
										
										<td><?php echo $payment_method->user_email ; ?></td>										
										<td><?php echo date("F j, Y, g:i a", strtotime($payment_method->date_added)); ?></td>
										<td>
										<a data-toggle="modal" data-target="#viewModal" class="btn btn-default view_cc_details"  id="<?php echo html_escape($payment_method->payment_method_id);?>" title="View Credit Card details"><i class="fa fa-search"></i></a>
										</td>
									</tr>											
	<?php
								}
							}else {
?>
								  <tr>
									<td colspan="11" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No payment methods!</div>
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



		<!-- View Hand -->
			<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" ><span id="header"></span></h3>
				  </div>
				  <div class="modal-body">
					<div class="scrollable">
						<table class="table table-striped">

							<tr>
								<td width="45%" align="right"><strong>Type:</strong></td>
								<td width="55%" align="left"><span id="card_type" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>Name on Card:</strong></td>
								<td align="left"><span id="name_on_card" ></span></td>
							</tr>						
							<tr>
								<td align="right"><strong>Card Number:</strong></td>
								<td align="left"><span id="card_number" ></span></td>
							</tr>	

							<tr>
								<td align="right"><strong>Expiry:</strong></td>
								<td align="left"><span id="expiry_date" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>CVV:</strong></td>
								<td align="left"><span id="cvv" ></span></td>
							</tr>			
							<tr>
								<td align="right"><strong>Billing Street Address:</strong></td>
								<td align="left"><span id="billing_street_address" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>Billing City:</strong></td>
								<td align="left"><span id="billing_city" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>Billing Postcode:</strong></td>
								<td align="left"><span id="billing_postcode" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>Billing State:</strong></td>
								<td align="left"><span id="billing_state" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>Billing Country:</strong></td>
								<td align="left"><span id="billing_country" ></span></td>
							</tr>	
							<tr>
								<td align="right"><strong>Email Address:</strong></td>
								<td align="left"><span id="user_email" ></span></td>
							</tr>		
							<tr>
								<td align="right"><strong>Date Added:</strong></td>
								<td align="left"><span id="date_added" ></span></td>
							</tr>								
						</table>						
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>		
	<!-- /View Hand -->
		