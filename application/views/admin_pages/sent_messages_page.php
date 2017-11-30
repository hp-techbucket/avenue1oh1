
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
                            <?php echo $pageTitle;?> <small>(<?php if($count_sent_messages == ''){ echo '0 sent messages' ;}else{ echo $count_sent_messages .' sent messages';} ?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>	
                            <li>
                                <i class="fa fa-envelope"></i> Messages
                            </li>							
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/messages/'" title="Private Inbox" ><i class="fa fa-inbox"></i> Private Inbox</a>
                            </li>								
                            <li class="active">
                                <i class="fa fa-paper-plane"></i> <?php echo $pageTitle;?> 
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
  
	
					<div align="center"><?php echo $display_option;?></div>
	
					<div class="row">
						<div class="col-lg-6 col-lg-offset-6 text-right">
							<form class="form-inline" role="form" action="<?php echo base_url('admin/sent_messages');?>" method="get">
								<div class="form-group">
									<div class="col-sm-12">
									  <input type="text" class="form-control" name="search" placeholder="Search">
									</div>
									
								</div>
								<button type="submit" class="btn btn-default">Search</button>
							</form>
						</div>
					</div>
					<br/>
   						
  
                <div class="row">
                    <div class="col-lg-12">
<?php 

		//define form attributes
		$attributes = array('name' => 'myform');
							
		//start message form
		echo form_open('admin/multi_delete', $attributes);
						
		//Title bar checkbox property setting
		$data = array(
			'name' => 'toggleAll',
			'id' => 'toggleAll',
			'value' => 'accept',
			'checked' => false,
			'onClick' => 'checkAll(this.checked)',
			'style' => 'margin-left:30%',
		);
		
		$hidden = array('table' => 'sent_messages',);	
		echo form_hidden($hidden);	
				
									
	?>		
<p><?php echo nbs(5);?> <?php echo img('assets/images/icons/crookedArrow.png');?> <a class="btn btn-danger" data-toggle="modal" data-target="#myModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</a></p>           
	
					<div class="table-responsive">
                        <table frame="box" class="table table-hover table-striped" >
                            <thead>
					
                                <tr>
									<th width="4%" align="left"><?php echo form_checkbox($data);?></th>
									<th width="4%" align="left"></th>
									<th width="15%" align="left">To</th>
									<th width="30%" align="left">Subject</th>
									<th width="47%" align="left">Date Sent</th>
                                </tr>
                            </thead>					
							<tbody>		
<?php
					
						//check messages array for messages to display			
						if(!empty($sent_messages)){
							
							//obtain each row of message
							foreach ($sent_messages as $message){			

								//check if message has been read
								$textWeight = 'msgRead';

								//message replied
								$replied = '<i class="fa fa-reply" aria-hidden="true"></i>';

								//set the message checkbox properties
								$data_checkbox = array(
									'name' => 'cb[]',
									'id'   => 'cb',
									'value' => $message->id,
									'checked' => false,	
									'style' => 'margin:10px',
								);
								
?>		

						<tr>
							<td width="4%" align="left"><?php echo form_checkbox($data_checkbox) ; ?></td>
							<td width="4%" align="left"><?php echo $replied; ?></td>
							<td width="38%" align="left"><?php echo $message->receiver_name; ?></td>
							<td width="34%" align="left"><span class="subjectToggle" style="padding:3px;">
										<a class="<?php echo $textWeight; ?>" id="subj_line_<?php echo $message->id; ?>" onclick="markAsRead(<?php echo $message->id; ?>); " style="cursor:pointer; "><?php echo stripslashes($message->message_subject); ?></a>
										</span>		
										<div class="hiddenDiv"><br/><?php echo 
											stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)); ?>
											<br/><br/><br/>
										</div></td>
							<td width="20%" align="left"><?php echo date("F j, Y", strtotime($message->date_sent)); ?></td>
								
						</tr>
<?php 
							}
						}else {
?>
								  <tr>
									<td colspan="5" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No Messages</div>
									</td>
								  </tr>

    <?php
       }
    ?>				

							</tbody>
						</table>
					</div>
					
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Delete Message
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected message(s)?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="submit" class="btn btn-primary" name="deleteSnt" value="OK">
				  </div>
				</div>
			  </div>
			</div>					
<?php 
					
				//	close the message form
				echo form_close();
				
 ?>						
                    </div>
                </div>
                <!-- /.row -->

    <div class="row">
        <div class="col-md-12 text-center">
            <?php echo $pagination; ?>
        </div>
    </div>
	
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


