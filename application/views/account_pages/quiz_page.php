

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

				<div class="container">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<h5 align="center">Question <?php echo $page_count ; ?> of <?php echo $question_count; ?></h5>
								
								<div class="progress">
									<div class="progress-bar progress-bar-success active" role="progressbar" aria-valuenow="<?php echo $percentage_completed ; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentage_completed ; ?>%">
										
									</div><?php echo nbs(1); ?><strong><?php echo $percentage_completed ; ?>%</strong>
								</div>
							</div>
						</div>
                <!-- /.row -->
				</div>
				
				
				<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<h5 align="center">Click on image or checkbox to answer</h5>
							</div>
						</div>
                <!-- /.row -->
				</div>				
				
				<?php
					echo form_open('quiz/answer_validation');
					
					$hidden = array('question' => $question,'question_id' => $question_id,'category' => $category,);	
					echo form_hidden($hidden);
				?>
               
                <div class="container-fluid">
						<div class="row">
							<div class="col-lg-12" align="center">
							<p><?php echo form_error('answer');?></p>
							
								<div id="question-wrapper" align="center">
									<h4><?php echo $question?></h4>
								</div>
								<div id="quiz-wrapper" align="center">
									<div class="quiz-photos" class="text-center" align="center">
										<img class="media-object" src="<?php echo base_url(); ?>uploads/questions/<?php echo $question_id; ?>/<?php echo $option_1_image; ?>" width="230" height="260" alt="option_1_image">
										<br/><br/>
										 <?php echo $option_1; ?>
									</div>
									<div class="quiz-photos" class="text-center" align="center">
										<img class="media-object" src="<?php echo base_url(); ?>uploads/questions/<?php echo $question_id; ?>/<?php echo $option_2_image; ?>" width="230" height="260" alt="option_2_image">
										<br/><br/>
										<?php echo $option_2; ?>
									</div>
									<?php echo br(20); ?>
									<button style="display:none;" type="submit" class="btn btn-primary next-btn" name="Next">Next <i class="fa fa-step-forward" aria-hidden="true"></i></button>
								</div>
							
							</div>
						</div>
                <!-- /.row -->
				</div>
				
				<?php echo form_close();?>			
				
				<?php echo br(1); ?>



<?php   
		}
	}								
?>

            </div>
            <!-- /.container-fluid -->


