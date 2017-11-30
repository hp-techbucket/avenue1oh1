
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
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>						
                            <li class="active">
                                <i class="fa fa-exclamation-triangle"></i> <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-12" align="center">
						<div class="alert alert-error"><h3><i class="fa fa-exclamation-circle"></i> You are not authorised for that action!</h3></div>
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


