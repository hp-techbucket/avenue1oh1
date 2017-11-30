<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $pageTitle; ?>">
    <meta name="author" content="">
	<?php echo link_tag('assets/images/logo/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <title>Avenue 1-OH-1 | <?php echo $pageTitle; ?></title>
	<?php echo link_tag('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
			
    <!-- Custom CSS -->
    <?php echo link_tag('assets/css/sb-admin.css'); ?>
	<?php echo link_tag('assets/css/style.css'); ?>
	
    <!-- Custom Fonts -->
    <?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="<?php echo $pageID;?>">
<div id="load">Please wait ...</div>
	<audio id="notif_audio"><source src="<?php echo base_url('assets/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('assets/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('assets/sounds/notify.wav');?>" type="audio/wav"><embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/sounds/notify.mp3');?>" /></audio>

<?php   


	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	

?>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand home" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'">Account Dashboard</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
		
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="badge" id="unread_messages"><?php echo $messages_unread ;?></span> <i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
					<?php
						//check messages array for messages to display			
						if(!empty($header_messages_array)){			
							//obtain each row of message
							foreach ($header_messages_array as $message){			

		?>					
                        <li class="message-preview">
							<a data-toggle="modal" data-target="#myModal" class="detail-message" id="<?php echo $message->id;?>">	
								<div class="media">
									<div class="pull-left">
										<img class="media-object" src="http://placehold.it/50x50" width="20" height="20" alt="">
									</div>
									<div class="media-body">
										<h5 class="media-heading"><strong><?php echo $message->sender_name;?></strong>
										</h5>
										<p class="small text-muted"><i class="fa fa-clock-o"></i> <?php echo date("F j, Y", strtotime($message->date_sent));?></p>
										<p class="ellipsis"><?php echo $message->message_details;?></p>
									</div>
								</div>
							</a>
                        </li>
		<?php
							}		
						}
						//	close the message form
		?> 
                        <li class="message-footer">
                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/messages/'">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-cc-paypal"></i> Payment <span class="label label-primary">just now</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-comment"></i> Comment <span class="label label-primary">4 minutes ago</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-money"></i> Bid <span class="label label-primary">23 minutes ago</span></a>
                        </li>
                        <li class="divider"></li>	
                        <li>
                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/alerts/'">View All</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user->admin_name ; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/profile/'"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/messages/'" title="<?php echo $messages_unread ;?> Unread Messages"><i class="fa fa-fw fa-envelope"></i> Inbox <span class="badge"><?php echo $messages_unread ;?></span></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/settings/'"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/logout/'" title="Log Out"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse ">

                <ul class="nav navbar-nav side-nav">							
                    <li>
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard" ><i class="fa fa-fw fa-dashboard"></i> Admin Dashboard</a>
                    </li>	
					
					<li>
						<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/products/'" title="Products" ><i class="fa fa-list-alt"></i> Products</a>
					</li>
          			<li>
						<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/product_categories/'" title="Product Categories" ><i class="fa fa-folder" aria-hidden="true"></i> Product Categories</a>
					</li>		
                    <li>
                        <a href="javascript:void(0)" id="messageMenu" data-toggle="collapse" data-target="#collapseMenu"><i class="fa fa-envelope"></i> Messages <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="collapseMenu" class="collapse">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/messages/'" title="Private Inbox" ><i class="fa fa-inbox"></i> Private Inbox <span class="badge" id="unread_messages"><?php echo $messages_unread ;?></span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/sent_messages/'" title="Sent" ><i class="fa fa-paper-plane"></i> Sent</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/all_messages/'" title="All Messages" ><i class="fa fa-envelope-o"></i> All Messages</a>
                            </li>							
                        </ul>
                    </li>
					<li>
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/admin_users/'" title="Manage Admins" ><i class="fa fa-users"></i> Manage Admins</a>
                    </li>
                    	
					
                    <li>
						<a href="javascript:void(0)" id="messageMenu" data-toggle="collapse" data-target="#userMenu"><i class="fa fa-users"></i> Manage Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="userMenu" class="collapse">

                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/users/'" title="Users" ><i class="fa fa-list"></i> Users</a>
                            </li>
							
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/temp_users/'" title="Temp Users" ><i class="fa fa-user"></i> Temp Users</a>
                            </li>		
	
							<li>
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/user_modifications/'" title="User Modifications" ><i class="fa fa-cogs"></i> User Modifications</a>
							</li>										
                        </ul>
                    </li>					

                <li>
                    <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/alerts/'" title="Alerts" ><i class="fa fa-bell"></i> Alerts</a>
                </li>						
							
				<li>
                    <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/login_list/'" title="Manage Logins" ><i class="fa fa-sign-in"></i> Manage Logins</a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/security_questions/'" title="Security Questions" ><i class="fa fa-lock"></i> Security Questions</a>
                </li>
				<li>
                    <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/questions/'" title="Quiz Questions" ><i class="fa fa-question-circle" aria-hidden="true"></i> Quiz Questions</a>
                </li>
				<li>
                    <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/question_categories/'" title="Question Categories" ><i class="fa fa-folder" aria-hidden="true"></i> Question Categories</a>
                </li>
				<li>
                    <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/answers/'" title="Quiz Answers" ><i class="fa fa-reply" aria-hidden="true"></i> Quiz Answers</a>
                </li>
                    <li>
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/contact_us/'"><i class="fa fa-envelope"></i> Contact Us</a>
                    </li>	

                    <li>
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/settings/'"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/logout/'"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<?php   
		}
	}								
?>

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Message Detail</h3>
				  </div>
				  <div class="modal-body message-preview">

						<div class="table-responsive">
							<table class="table table-striped" >
								<thead>
									<tr>
										<th width="25%" align="left">From</th>
										<th width="50%" align="center">Subject</th>
										<th width="25%" align="left">Date</th>
									</tr>
								</thead>					
								<tbody>
									<tr>
										<td align="left"><span id="show_name"></span></td>
										<td align="left">
											<u><span id="show_subject"></span></u><br/><br/>
											<span id="show_message"></span>
											<br/><br/>
										</td>
										<td align="left"><span id="show_date"></span></td>
									</tr>
								</tbody>
							</table>
						</div>	
				  </div>

				</div>
			  </div>
			</div>	
			
	
			