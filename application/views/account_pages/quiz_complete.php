

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
                        <h1 class="page-header text-center">
                             <?php echo $pageTitle;?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

				
				<div class="container">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<div class="jumbotron">
									<h3 align="center">You have completed the "<?php echo $category; ?>" quiz </h3>
									<br/><br/>
									<div class="progress">
										<div class="progress-bar progress-bar-success active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
											100% Complete
											<br/>
										</div>
									</div>
									<h3 align="center">See results below or <a class="btn btn-warning" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>quiz/'" title="Play Again" ><i class="fa fa-play" aria-hidden="true"></i> Play Again</a></h3>
									<h3 align="center"><a class="btn btn-default" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>quiz/chichi_start/'" title="Chituwa Chibambo, go to bonus round" >Chituwa Chibambo, go to bonus round <i class="fa fa-step-forward" aria-hidden="true"></i></a></h3>
								</div>
							</div>
						</div>
                <!-- /.row -->
				</div>

                <div class="container-fluid">
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<div class="panel panel-default">
									<div class="panel-heading result-header">
										<h1 class="panel-title" align="center"><a href="javascript:void(0)" >Result <i class="fa fa-plus-square" aria-hidden="true"></i></a></h1>
									</div>
									<div class="panel-body">
										<div class="list-group result-view">
											<ol class="custom-size">
											<?php
											if(!empty($answers_array)){
												foreach($answers_array as $answer){
											?>
												<li><?php echo $answer->question; ?> <strong>Your answer:</strong> <em><?php echo $answer->answer; ?></em></li>	
												<br/>
										<?php   
												}
											}								
										?>												
											</ol>
										</div>			
									</div>
								</div>	
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


