

<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper" class="chichi-wrapper">

            <div class="container-fluid">
			<div id="load">Please wait ...</div>
			<audio id="notif_audio"><source src="<?php echo base_url('assets/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('assets/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('assets/sounds/notify.wav');?>" type="audio/wav"><embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/sounds/notify.mp3');?>" /></audio>
						

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
								<?php
									echo form_open('quiz/start');
								?>
								<p><?php echo form_error('category');?></p>
							
								<div id="question-wrapper" align="center">
									<h3>Select a Quiz Category</h3>
								</div>
								
								<div id="med-quiz-wrapper" align="center">
									<?php echo $category;?>
									<br/><br/>
									<button type="submit" class="btn btn-primary btn-block" name="Start">Start <i class="fa fa-step-forward" aria-hidden="true"></i></button>
								</div>
							</div>
						</div>
                <!-- /.row -->
				</div>
		
				

<?php   
		}
	}								
?>

<?php echo br(25); ?>

            </div>
            <!-- /.container-fluid -->



