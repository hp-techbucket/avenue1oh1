

<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">
<div id="load">Please wait ...</div>
<audio id="notif_audio"><source src="<?php echo base_url('assets/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('assets/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('assets/sounds/notify.wav');?>" type="audio/wav"><embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/sounds/notify.mp3');?>" /></audio>
			

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo $pageTitle;?> <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i>  <?php echo $pageTitle;?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
			<div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 text-right">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-clock-o fa-fw"></i>  <strong>Last Login: </strong><?php if($user->last_login == '0000-00-00 00:00:00'){echo 'Never';}else{echo date("F j, Y, g:i a", strtotime($user->last_login));} ?>
						</div>
                    </div>
                </div>
                <!-- /.row -->
			</div>

                
                <div class="container-fluid">
						<div class="row">
							<div class="col-lg-6 col-xs-6">
						
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title"><i class="fa fa-bell-o fa-fw"></i> Announcements</h3>
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
										</div>	
										<div class="list-group">
											<?php echo $activity_group; ?>		
										</div>											
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-xs-6">
								<div class="panel panel-default">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Got a friend?</h3>
										</div>
										<div class="panel-body">
																									
										</div>	
								</div>	
							</div>
						</div>
                <!-- /.row -->
				</div>
				<?php echo br(2); ?>


<?php echo br(15); ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php   
		}
	}								
?>


