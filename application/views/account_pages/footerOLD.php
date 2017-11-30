
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-2">
				<div id="play-button">
					<i class="fa fa-play-circle fa-3x" aria-hidden="true"></i>
				</div>
				<div id="pause-button">
					<i class="fa fa-pause fa-3x" aria-hidden="true"></i>
				</div>

					
				<div id="player-view-control">
					<a id="audio-show" title="Show Music Player">Show Music Player <i class="fa fa-plus-square" aria-hidden="true"></i></a>
					<a id="audio-hide" title="Hide Music Player">Hide Music Player <i class="fa fa-plus-square" aria-hidden="true"></i></a>
				</div>
			</div>
			<div class="col-lg-4">
				<div id="audio-container">
					<div class="audio-player">
						<div class="audio-info">
							<span id="artist"></span> - <span id="title"></span>
						</div>
						<div class="vol-container">
							<div id="vol-off"><a id="vol-off-button"><i class="fa fa-volume-off" aria-hidden="true"></i></a></div>
							<div id="vol-control"><input class="volume" type="range" min="0" max="10" value="5" /></div>
							<div id="vol-up"><a id="vol-up-button"><i class="fa fa-volume-up" aria-hidden="true"></i></a></div>
						</div>
						 <div class="audio-buttons" align="center">
							<button class="prev"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
							<button class="play"><i class="fa fa-play" aria-hidden="true"></i></button>
							<button class="pause"><i class="fa fa-pause" aria-hidden="true"></i></button>
							<button class="stop"><i class="fa fa-stop" aria-hidden="true"></i></button>
							<button class="next"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
						 </div>
						 <div class="clearfix"></div>

						<div class="timer-container">
							<span id="slider"><input id="seekslider" type="range" min="0" max="100" value="0" step="1"></span>
							<div class="music-timer">
								<span class="current-duration"></span> / 
								<span class="total-duration"></span>
							</div>
							<div class="clearfix"></div>
						</div>

						 <div class="clearfix"></div>
						 
						 <ul id="" class="playlist hidden">
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
	</div>
	<?php echo br(5); ?>

        </div>
        <!-- /#page-wrapper -->




	<!-- JQuery scripts
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="http://code.jquery.com/jquery-1.12.0.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<script src="<?php echo base_url('assets/js/jquery.easing.min.js'); ?>" type="text/javascript"></script>
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
	<!-- Datatable -->
	<script src="<?php echo base_url('assets/js/u-dataTables.js'); ?>"></script>
	
	<!-- My custom scripts
    ================================================== -->
	<script src="<?php echo base_url('assets/js/jQuery.dPassword.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.creditCardValidator.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/script.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/music.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bjqs-1.3.js'); ?>" type="text/javascript"></script>
	
</body>
</html>	 
