
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
                            <?php echo $pageTitle;?> <small></small>
                        </h1>
                        <ol class="breadcrumb">
							<li>
                                 <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>					
                            <li class="active">
                                <i class="fa fa-money"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				
					<div align="center"><?php echo $display_option;?></div>
	
					<div class="row">
						<div class="col-lg-6 col-lg-offset-6 text-right">
							<form class="form-inline" role="form" action="<?php echo base_url('account/payments');?>" method="get">
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
                    <div class="col-lg-12" align="center">

						<div class="table-responsive" >
							<table class="table table-hover table-striped custom-table-header text-center">
								<thead>
									<tr>
										<th>Ref</th>
										<th>Amount</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($my_payments_array){				
										foreach($my_payments_array as $payment){								
								?>							
											<tr>
												<td><?php echo $payment->reference_id; ?></td>
												<td><?php echo number_format($payment->amount, 0) ; ?></td>
												<td><?php echo date("F j, Y", strtotime($payment->date_paid)); ?></td>
											</tr>			
								<?php
										}
									}else {
								  ?>	
              
										  <tr id="no-message-notif">
											<td colspan="3" align="center"><div class="alert alert-danger" role="alert">
											  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											  <span class="sr-only"></span> No Payments yet!</div>
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
<?php echo br(25); ?>

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


