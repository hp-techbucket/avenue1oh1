

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
                        <h1 class="page-header text-center">
                             <?php echo $pageTitle;?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="container-fluid">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2" align="center">
								<img class="media-object" src="<?php echo base_url(); ?>assets/images/gif/no.gif" width="530" height="410" alt="All Good!">
							</div>
						</div>
                <!-- /.row -->
				</div>
		
				

<?php   
		}
	}								
?>

<?php echo br(5); ?>

            </div>
            <!-- /.container-fluid -->

 

