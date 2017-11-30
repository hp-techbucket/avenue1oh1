
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
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li class="active">
                                <i class="fa fa-bell"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-12">
					
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-bell-o fa-fw"></i> Notifications</h3>
							</div>
							<div class="panel-body">
								<div class="list-group">
									<a href="#" class="list-group-item">
										<span class="badge">just now</span>
										<i class="fa fa-fw fa-calendar"></i> Calendar updated
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">4 minutes ago</span>
										<i class="fa fa-fw fa-comment"></i> Commented on a post
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">23 minutes ago</span>
										<i class="fa fa-fw fa-truck"></i> Order 392 shipped
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">46 minutes ago</span>
										<i class="fa fa-fw fa-money"></i> Invoice 653 has been paid
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">1 hour ago</span>
										<i class="fa fa-fw fa-user"></i> A new user has been added
									</a>
									<a href="#" class="list-group-item">
										<span class="badge">2 hours ago</span>
										<i class="fa fa-fw fa-check"></i> Completed task: "pick up dry cleaning"
									</a>										
								</div>
								<div class="list-group">
									<?php echo $activity_group; ?>		
								</div>						
							</div>
						</div>		
						
                    </div>
                </div>
                <!-- /.row -->
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


