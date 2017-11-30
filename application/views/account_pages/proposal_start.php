

<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper" class="chichi-wrapper">

            <div class="container-fluid">
			<div id="load">Please wait ...</div>
			<audio id="notif_audio"><source src="<?php echo base_url('assets/media/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('assets/media/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('assets/media/sounds/notify.wav');?>" type="audio/wav"><embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/media/sounds/notify.mp3');?>" /></audio>
						

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" align="center">
                             <?php echo $pageTitle;?> <small></small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->


                <div class="container-fluid">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2" align="center">
								
								<div id="question-wrapper" align="center">
									<h3>Are you Ms Chituwa Kasiana Mary Chibambo?</h3>
								</div>
								
								<div id="sm-quiz-wrapper" align="center">
									
									<br/>
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>quiz/chichi/'" class="btn btn-primary" name="Yes">Yes</a>
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'" class="btn btn-danger" name="No">No</a>
								</div>
							</div>
						</div>
                <!-- /.row -->
				</div>
		
				

<?php   
		}
	}								
?>

<?php echo br(20); ?>

            </div>
            <!-- /.container-fluid -->
