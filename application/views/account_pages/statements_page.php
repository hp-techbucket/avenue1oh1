
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
                                <i class="fa fa-exchange"></i> <?php echo $pageTitle;?> (<?php echo $count;?> records)
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
		               
                <div class="row">
                    <div class="col-lg-12" align="center">

						<div class="table-responsive" >
							<table class="table table-hover table-striped tableHeadB">
								<thead>
									<tr>
										<th >Ref</th>
										<th >Amount</th>
										<th >Description</th>
										<th >Date</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($statements_array){				
										foreach($statements_array as $statement){								
								?>							
											<tr>
												<td><?php echo $statement->reference; ?></td>
												<td><?php echo $statement->amount ; ?></td>
												<td><?php echo $statement->note ; ?> (<?php echo $statement->transaction ; ?>)</td>
												<td><?php echo date("F j, Y, H:i s", strtotime($statement->date)); ?></td>
											</tr>			
								<?php
										}
									}else {
								  ?>	
              
										  <tr id="no-message-notif">
											<td colspan="4" align="center"><div class="alert alert-danger" role="alert">
											  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											  <span class="sr-only"></span> No transactions yet!</div>
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


