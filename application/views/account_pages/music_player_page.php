

<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">
			<div id="load">Please wait ...</div>
			<audio id="notif_audio"><source src="<?php echo base_url('assets/media/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('assets/media/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('assets/media/sounds/notify.wav');?>" type="audio/wav"><embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/media/sounds/notify.mp3');?>" /></audio>
						

			<audio autoplay loop>
			  <source src="<?php echo base_url('assets/media/sounds/face-the-sun.mp3');?>" type="audio/mpeg"> <!-- works on IE9+, FF3.5+, Chrome4+ -->
			  <source src="<?php echo base_url('assets/media/sounds/face-the-sun.ogg');?>" type="audio/ogg"> <!-- still needed for Safari 5.1.7, MP3 to OGG online converter here: http://audio.online-convert.com/convert-to-ogg -->
			</audio>	

	
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo $pageTitle;?> <small></small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->


                <div class="container-fluid">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2" align="center">
												
								<div id="container">
									<div id="audio-image">
										<img class="cover" />
									</div>
									<div id="audio-player">
										<div id="audio-info">
											<span class="artist"></span> - <span class="title"></span>
										</div>
										 <input id="volume" type="range" min="0" max="10" value="5" />
										 <br>
										 <div id="audio-buttons">
											 <span>
												<button id="prev"></button>
												<button id="play"></button>
												<button id="pause"></button>
												<button id="stop"></button>
												<button id="next"></button>
											</span>
										 </div>
										
										 <div class="clearfix"></div>
										 <div id="tracker">
											<div id="progressBar">
												<span id="progress"></span>
											</div>
											
											<span id="duration"></span>
										 </div>
										 <div class="clearfix"></div>
										 <ul id="playlist" class="hidden">
											<li song="Wale - The Matrimony (Feat.Usher).mp3" cover="theads_tonb.jpg" artist="Wale">The Matrimony (Feat.Usher).mp3</li>
											<li song="Musiq Soulchild - So Beautiful.mp3" cover="Musiq-Soulchild-Aijuswanaseing-Cover.jpg" artist="Musiq Soulchild">So Beautiful.mp3</li>
											<li song="Musiq Soulchild - Aimewitue.mp3" cover="MS_I_Do_V6_PROOF.jpg" artist="Musiq Soulchild">Aimewitue.mp3</li>
											<li song="The Weeknd - Face the sun.mp3" cover="tumblr_md56ku0f4S1rw4zmjo1_1280.png" artist="The Weeknd">Face the sun.mp3</li>
											<li song="Adele - Hello.mp3" cover="adele-25-cover.jpg" artist="Adele">Hello.mp3</li>
										</ul>
									</div>

								</div>				

							</div>
						</div>
                <!-- /.row -->
				</div>
		
				

<?php echo br(25); ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


<?php   
		}
	}								
?>


