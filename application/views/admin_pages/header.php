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
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<!-- JQuery UI CSS -->
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	<?php echo link_tag('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	
	<!-- Font Awesome -->
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	
    <!-- Datatables -->
	<link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet">	
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">	
	<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">
	
	
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.3/jquery.tagsinput.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
	
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap3-wysihtml5.min.css">
	
	
  
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker3.css">
	
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">
	
	<!-- starrr -->
	<link href="<?php echo base_url(); ?>assets/css/starrr.css?<?php echo time(); ?>" rel="stylesheet">
	
	<!-- Animate.css style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
   
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.css">
  
    <!-- Custom Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.min.css?<?php echo time(); ?>" media="all"/>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/admin.css?<?php echo time(); ?>" media="all"/>
	
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
    
  </head>
  
  <body id="<?php echo $pageID;?>" class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('home/');?>" class="site_title"><i class="fa fa-paw"></i> <span>GSI</span></a>
            </div>

            <div class="clearfix"></div>


<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{	

?>			
			
            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo base_url('uploads/admins');?>/<?php echo $user->id;?>/<?php echo $user->avatar;?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $user->admin_name;?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
				<div class="menu_section">
					<h3>General</h3>
					<ul class="nav side-menu">
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
								<i class="fa fa-home"></i> Dashboard 
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox');?>'" title="Messages">
								<i class="fa fa-envelope"></i> Messages 
								
							</a>
							
						</li>
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/admin_users/'" title="Manage Admins" >
								<i class="fa fa-users"></i> Manage Admins
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/users/'" title="Manage Users" >
								<i class="fa fa-users"></i> Manage Users</a>
						</li>
							
						
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/products/'" title="Products" ><i class="fa fa-list-alt"></i> Products</a>
						</li>
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/product_categories/'" title="Product Categories" ><i class="fa fa-folder" aria-hidden="true"></i> Product Categories</a>
						</li>		
						
																			
						<li>
							<a title="Transactions">
							<i class="fa fa-exchange" aria-hidden="true"></i> Transactions 
							<span class="fa fa-chevron-down"></span>
							</a>
							<ul class="nav child_menu">
								<li>
									<a href="javascript:void(0)" id="orders-link" onclick="location.href='<?php echo base_url();?>admin/orders/'" title="Orders" ><i class="fa fa-th-list" aria-hidden="true"></i> Orders</a>
								</li>		
								<li>
									<a href="javascript:void(0)" id="payments-link" onclick="location.href='<?php echo base_url();?>admin/payments'" title="Payments" ><i class="fa fa-money"></i> Payments</a>
								</li>
								<li>
									<a href="javascript:void(0)" id="shipping-link" onclick="location.href='<?php echo base_url();?>admin/shipping/'" title="Shipping Status"><i class="fa fa-truck" aria-hidden="true"></i> Shipping Status</a>
								</li>	
								
								<li>
									 <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/invoices'" title="Manage Invoices" ><i class="fa fa-files-o"></i> Manage Invoices</a>
								</li>
								
								<li>
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/cards'" title="Manage Cards" ><i class="fa fa-credit-card"></i> Manage Cards</a>
								</li>
								
							</ul>
						</li>
					</ul>
				</div>
			
				<div class="menu_section">
					<h3>Misc</h3>
					<ul class="nav side-menu">
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/brands/'" title="Brands"><i class="fa fa-black-tie"></i> Brands</a>
						</li>	
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/sizes/'" title="Sizes"><i class="fa fa-list-alt"></i> Sizes</a>
						</li>	
					  
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/contact_us/'" title="Contact Us"><i class="fa fa-envelope"></i> Contact Us</a>
						</li>	
					  
						<li>
							<a title="Manage Logins" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/logins/'">
								<i class="fa fa-sign-in"></i> Logins
							</a>
						</li>
						
						<li>
							<a title="Security Questions" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/security_questions/'">
								<i class="fa fa-lock"></i> Security Questions
							</a>
							
						</li>
						
				
						<li>
							<a title="Manage Quiz Questions">
							<i class="fa fa-question-circle" aria-hidden="true"></i> Manage Quiz Questions 
							<span class="fa fa-chevron-down"></span>
							</a>
							<ul class="nav child_menu">
						   
								<li>
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/questions/'" title="Quiz Questions" ><i class="fa fa-question-circle" aria-hidden="true"></i> Quiz Questions</a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/question_categories/'" title="Question Categories" ><i class="fa fa-folder" aria-hidden="true"></i> Question Categories</a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/answers/'" title="Quiz Answers" ><i class="fa fa-reply" aria-hidden="true"></i> Quiz Answers</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/site_activities/'" title="Site Activities"><i class="fa fa-list"></i> Site Activities</a>
						</li>	
						
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/page_metadata/'" title="Page Metadata"><i class="fa fa-file"></i> Page Metadata </a>
						</li>
	
					</ul>
				</div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/settings/'" data-toggle="tooltip" data-placement="top" title="Settings">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
				</a>
				<a data-toggle="tooltip" data-placement="top" title="Alerts">
					<i class="fa fa-bell"></i>
				</a>
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/profile/'" data-toggle="tooltip" data-placement="top" title="Profile">
					<i class="fa fa-fw fa-user"></i>
				</a>
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/logout/'" data-toggle="tooltip" data-placement="top" title="Logout">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
				</a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url('uploads/admins');?>/<?php echo $user->id;?>/<?php echo $user->avatar;?>" alt=""><?php echo $user->admin_name;?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
						<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/profile/'" title="Profile">
						<i class="fa fa-fw fa-user"></i> Profile
						</a>
					</li>
                    <li>
                      <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/settings/'" title="Settings">
                        <i class="fa fa-fw fa-gear"></i>
                        <span>Settings</span>
                      </a>
                    </li>
                    
                    <li>
						<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/logout/'" title="Log Out">
						<i class="fa fa-fw fa-sign-out "></i> Log Out
						</a>
					</li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green messages-unread"><?php echo $messages_unread;?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                   <?php
						//check messages array for messages to display			
						if(!empty($header_messages_array)){			
							//obtain each row of message
							foreach ($header_messages_array as $message){			

					?>					 
					
					<li>
                      <a data-toggle="modal" data-target="#previewModal" class="detail-message" id="<?php echo $message->id;?>">
                        <span class="image"><img src="<?php echo base_url('assets/images/img/img.jpg');?>" alt="Profile Image" /></span>
                        <span>
                          <span><?php echo $message->sender_name;?></span>
                          <span class="time"><?php echo $this->misc_lib->time_elapsed_string(strtotime($message->date_sent));?></span>
                        </span>
                        <span class="message ellipsis">
                          <?php echo $message->message_details;?>
                        </span>
                      </a>
                    </li>
     <?php
							}		
						}
						//	close the message form
		?>                
                   
                    <li>
                      <div class="text-center">
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox');?>'" title="See All Alerts" >
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

 <?php
		}		
	}
						
?>  

			<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
			
	              		