

<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper" class="chichi-wrapper">

            <div class="container-fluid">
			
			<div id="load">Please wait ...</div>

			<audio id="notif_audio">
				<source src="<?php echo base_url('assets/sounds/notify.ogg');?>" type="audio/ogg">
				<source src="<?php echo base_url('assets/sounds/notify.mp3');?>" type="audio/mpeg">
				<source src="<?php echo base_url('assets/sounds/notify.wav');?>" type="audio/wav">
				<embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/sounds/notify.mp3');?>" />
			</audio>
			

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
							<div class="col-lg-5">
								<div class="img-display">
									<ul class="bjqs">
										<li><img src="<?php echo base_url('assets/images/chichi/1.jpg');?>" /></li>
										<li><img src="<?php echo base_url('assets/images/chichi/2.jpg');?>" /></li>
										<li><img src="<?php echo base_url('assets/images/chichi/3.jpg');?>" /></li>
										<li><img src="<?php echo base_url('assets/images/chichi/4.jpg');?>" /></li>
										<li><img src="<?php echo base_url('assets/images/chichi/5.jpg');?>" /></li>
									</ul>
								</div>
								<br/>
								
							</div>
							<div class="col-lg-7">
								<div class="jumbotron">
									<div id="proposal-message">
										<p>
										Ms Chituwa Kasiana Mary Chibambo, little did we know on the first day we met at Euston station what would happen next. It's been almost a year since but it feels like it was years ago. In that time we have had great times as well as some not so great times. Even during not so great times we always bounced back with better understanding of each other.  
										</p>
										<p>
										People do say that when you are with person who is "The One", you will know. Even though it might sound cheesy, I do believe it to be very true. That moment when your mind, body and soul let you know that indeed this person is "The One" and you can envisage a lifetime with them by your side. 
										</p>
										<p>
										I understand that you might want to be hearing all of this face to face on the London Eye or over a romantic dinner at some really fancy restaurant or at home and all that lol :) but this is what I can give at the moment...heartfelt written words that will try to convey how I feel instead of some maybe mumbling and jumbling lol :).
										</p>
										<p>
										When I am with you, everything else including all my problems fade away. You are an amazing, beautiful and strong woman. From the very first day I saw you, I have known that I would be happier with you in my life and than without you. I can only imagine how beautiful my life would be, with you as my partner for life and some beautiful babies lol ;) 
										</p>
										<p>
										We do have a lot of good times ahead of us God willing and we can share them together if you want. I am not perfect nor can I promise you a perfect life but I do promise to make you happy in every way I can. I will be the shoulder for you to lean on, 24/7, 365 days. 
										</p>
										<p>
										Click the link below:
										</p>
									</div>
									<div class="bonus-question-header">
										<h3 align="center"><a href="javascript:void(0)" >Click here <i class="fa fa-plus-square" aria-hidden="true"></i></a></h3>
									</div>
									
									<?php
										echo form_open('quiz/chichi_validation');
										$hidden = array('question' => $question,);	
										echo form_hidden($hidden);
									?>
									<p><?php echo form_error('answer');?></p>
									<div class="bonus-question-view">
										<div id="question-wrapper" align="center">
											<h4><?php echo $question?></h4>
										</div>
										<div id="q-wrapper" align="center">
											<div class="quiz-photos" class="text-center" align="center">
												<img class="media-object" src="<?php echo base_url(); ?>assets/images/gif/Excited-GIFS.gif" width="230" height="210" alt="option_1_image">
												<br/><br/>
												 <input type="radio" name="answer" id="" value="Yes" /> Yes
											</div>
											<div class="quiz-photos" class="text-center" align="center">
												<img class="media-object" src="<?php echo base_url(); ?>assets/images/gif/no-baby-no-gif.gif" width="230" height="210" alt="option_2_image">
												<br/><br/>
												<input type="radio" name="answer" id="" value="No" /> No
											</div>
											<?php echo br(5); ?>
											<button style="display:none;" type="submit" class="btn btn-primary next-btn" name="Next">Next <i class="fa fa-step-forward" aria-hidden="true"></i></button>
										</div>
									</div>
									<?php echo form_close();?>	
								</div>
								
								
							</div>
						</div>
                <!-- /.row -->
				
						<div class="row">
							<div class="col-lg-7 col-lg-offset-5">
							
								
								
							</div>
						</div>
						<!-- /.row -->
						
				</div>				
				
                

<?php   
		}
	}								
?>


<?php echo br(12); ?>

            </div>
            <!-- /.container-fluid -->
