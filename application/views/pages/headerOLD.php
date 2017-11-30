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
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url('assets/images/logo/apple-icon-57x57.png'); ?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url('assets/images/logo/apple-icon-60x60.png'); ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url('assets/images/logo/apple-icon-72x72.png'); ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/images/logo/apple-icon-76x76.png'); ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url('assets/images/logo/apple-icon-114x114.png'); ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url('assets/images/logo/apple-icon-120x120.png'); ?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url('assets/images/logo/apple-icon-144x144.png'); ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url('assets/images/logo/apple-icon-152x152.png'); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/images/logo/apple-icon-180x180.png'); ?>">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url('assets/images/logo/android-icon-192x192.png'); ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('assets/images/logo/favicon-32x32.png'); ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url('assets/images/logo/favicon-96x96.png'); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/images/logo/favicon-16x16.png'); ?>">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo base_url('assets/images/logo/ms-icon-144x144.png'); ?>">
	<meta name="theme-color" content="#ffffff">
    <title>Avenue 1-OH-1 | <?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
	<?php echo link_tag('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); ?>
	
	<?php echo link_tag('assets/css/bootstrapValidator.min.css'); ?>
	
	<?php echo link_tag('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	
	<!-- Font Awesome style -->
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
	
	<!-- starrr -->
	<link href="<?php echo base_url(); ?>assets/css/starrr.css?<?php echo time(); ?>" rel="stylesheet">
	
	<!-- Animate.css style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
   
	<?php echo link_tag('assets/css/hover-min.css'); ?>
	
	<!-- Custom Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css?<?php echo time();?>" media="all"/>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
	
  </head>

	<body id="<?php echo $pageID; ?>">
 
	<div id="load"></div>
		
		<div class="search-box">
			<div class="container-fluid">
				<!--.container-->
				<div class="container">
					
					<form action="<?php echo base_url('collections/search'); ?>" id="search-form" name="search-form" class="search-form" method="get" enctype="multipart/form-data">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6 col-xs-6">
								<div class="input-group">
									<div class="input-group-addon">
										<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
									</div>
									<input type="text" name="keywords" value="<?php echo set_value('keywords'); ?>" class="form-control search-input" placeholder="Search here" id="">	
													
								</div>
							</div>
							<div class="col-sm-6 col-xs-6">
								<span class="pull-right times-box"><a href="#" class="close-search-box"><i class="fa fa-times" aria-hidden="true"></i></a></span>
							</div>
						</div>
					</div>
					</form>
					
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</div>
  
    <div class="">
		<nav class="navbar navbar-info navbar-xs">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".top-navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>	  
				</div>
				<div id="navbar2" class="navbar-collapse collapse top-navbar">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a title="About us" href="javascript:void(0)" onclick="location.href='<?php echo base_url('about/');?>'">About us</a>
						</li>
						<li>
							<a title="Blog" href="javascript:void(0)" onclick="location.href='<?php echo base_url('blog/');?>'">Blog</a>
						</li>
						<li>
							<a title="Contact Us" href="javascript:void(0)" onclick="location.href='<?php echo base_url('contact-us/');?>'">Contact Us</a>
						</li>
						<li>
							<a title="FAQ" href="javascript:void(0)" onclick="location.href='<?php echo base_url('faq/');?>'">FAQ</a>
						</li>
						<li>
							<a title="My Wishlist" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>my-wishlist/'">My Wishlist</a>
						</li>
						<li>
							<a title="Newsletter Signup" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>newsletter-signup/'">Newsletter Signup</a>
						</li>
						<li>
							<div class="social-icons">
								<a title="Signup" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>signup/'"><i class="fa fa-user" aria-hidden="true"></i></a>
								<a title="Facebook" href="http://www.facebook.com/avenueoneohone"><i class="fa fa-facebook" aria-hidden="true"></i></a>
								<a title="Twitter" href="http://www.twitter.com/avenueoneohone"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<a title="Instagram" href="http://www.instagram.com/avenueoneohone"><i class="fa fa-instagram" aria-hidden="true"></i></a>
							</div>
						</li>
					</ul>
						  
				</div><!-- #navbar-->
			</div><!-- .container-->
		</nav><!-- .navbar .navbar-default .navbar-custom-->
    </div><!-- .container-->
		
		
	<div class="navbar-wrapper">
      
        <nav class="navbar navbar-white">
          <div class="container">
			<div class="navbar-header pull-left">
              <a class="navbar-brand" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>'">
				<img alt="Brand" src="<?php echo base_url('assets/images/logo/Avenue101-logo.JPG');?>" width="105" height="72">
			  </a>
            </div>
            <div class="navbar-header pull-right">
              <button type="button" id="go-to-menu" class="navbar-toggle" data-toggle="collapse" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse main-navbar">
              <ul class="nav navbar-nav custom-nav">
                <li class="custom-nav">
					<a title="HOME" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>'">HOME</a>
				</li>
				
                <li class="custom-nav dropdown">
				
						<a href="<?php echo base_url();?>collections" >CATALOG <span class="caret"></span></a>
						
                        <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
							<div class="container-large">
								<div class="cat-box">
									<div class="cat-header"><b>CLOTHING</b></div>
									<div class="cat-image">
										<img src="<?php echo base_url();?>assets/images/banners/mega_menu1_img_1ecb9.jpg" class="img-responsive" width="250" height="140" title="" alt=""/>
									</div>	
								</div>
								<div class="cat-box">
									<div class="cat-header"><b>BAGS & SHOES</b></div>
									<div class="cat-image">
										<img src="<?php echo base_url();?>assets/images/banners/mega_menu1_img_2ecb9.jpg" class="img-responsive" width="250" height="140" title="" alt=""/>
									</div>
								</div>
								<div class="cat-box">
									<div class="cat-header"><b>SALE</b></div>
									<div class="cat-image">
										<img src="<?php echo base_url();?>assets/images/banners/mega_menu1_img_4ecb9.jpg" class="img-responsive" width="250" height="140" title="" alt=""/>
									</div>
								</div>
								
							</div>
                        </ul>
				</li>
				
                <li class="dropdown">
					
						<a href="<?php echo base_url();?>collections/all">SHOP <span class="caret"></span></a>
						
                        <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
							<div class="container-smallest category-box">
							
								<div class="row">
									<div class="col-lg-6">
										
										<ul class="custom-list">
											<li><a href="<?php echo base_url(); ?>collections/men/all"><b>MEN</b></a></li>
											<li><a href="<?php echo base_url(); ?>collections/men/shirts">Shirts</a></li>
											<li><a href="<?php echo base_url(); ?>collections/men/pants">Pants</a></li>
											<li><a href="<?php echo base_url(); ?>collections/men/shoes">Shoes</a></li>
											<li><a href="<?php echo base_url(); ?>collections/men/accessories">Accessories</a></li>
											<li><a href="<?php echo base_url(); ?>collections/men/sales">Sales</a></li>
										</ul>
										
									</div>
									<div class="col-lg-6">
										
										<ul class="custom-list">
											<li><a href="<?php echo base_url(); ?>collections/women/all"><b>WOMEN</b></a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/dresses">Dresses</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/tops">Tops</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/pants">Pants</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/shoes">Shoes</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/bags">Bags</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/lingeries">Lingeries</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/accessories">Accessories</a></li>
											<li><a href="<?php echo base_url(); ?>collections/women/sales">Sales</a></li>
										</ul>
										
									</div>
								</div>
								
							</div>
                        </ul>
				</li>
				
				<li class="custom-nav"><a title="LOOKBOOK" href="javascript:void(0)" onclick="location.href='<?php echo base_url('lookbook/');?>'">LOOKBOOK</a></li>
              </ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
						<li class="">
							<a title="Wishlist" href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/wishlist/');?>'">Wishlist</a>
						</li>
						<li class="divider"></li>
						<li class="">
							<a title="My Account" href="javascript:void(0)" onclick="location.href='<?php echo base_url('account');?>'">My Account</a>
						</li>
						<li class="divider"></li>
						<li class="">
							<a title="Logout" href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/logout/');?>'">Logout</a>
						</li>
						
                    </ul>
			</li>
						
			<li class="dropdown cart">
					
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge" id="cart_contents"><?php echo $cart_count ;?></span></a>
                <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
					<div class="container-smallest">
								
						<div class="row">
							<div class="col-lg-8 col-lg-offset-2">
								<div class="">
									<h3 class="text-center">
									<b><i class="fa fa-shopping-cart"></i> Cart</b>
									</h3>
									<div class="cart-notif"></div>
									<div class="">
									<?php
										$cartTotal = "";
										$pp_checkout_btn = '';
										$product_id_array = '';
										if(!empty($_SESSION["cart_array"])){
											$i = 0;
											foreach($_SESSION["cart_array"] as $each_item){
												$item_id = $each_item['product_id'];
												$product_name = '';
												$product_image = '';
												$price = '';
												$details = '';
												$product_qty = '';
												$product_details = $this->Products->get_product($item_id);
												if($product_details){
													foreach($product_details as $product){
														$product_name = $product->name;
														$product_image = $product->image;
														$price = $product->price;
														$details = $product->description;
													}
												}
												//total quantity
												$product_qty = $each_item['quantity'];
												//item price
												$pricetotal = $price * $each_item['quantity'];
												
												//format item price
												$pricetotal = sprintf("%01.2f", $pricetotal);
												
												//total cart amount
												$cartTotal = $pricetotal + $cartTotal;
												
												//product thumbnail
												$thumbnail = '';
												$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
												if(file_exists($filename)){
													$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive img-rounded" width="50" height="60" alt="item'.$item_id.'"/>';
												}else if($product->image == '' || $product->image == null || !file_exists($filename)){
													$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="50" height="60" alt="item'.$item_id.'" />';
												}else{
													$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive img-rounded" width="50" height="60" alt="item'.$item_id.'" />';
												}
												
									?>
											<div class="row shopping-cart-items">
												<div class="col-xs-3">
													<?php echo $thumbnail ; ?>
												</div>
												<div class="col-xs-9">
													<span class="item-name"><?php echo $product_name ; ?></span>
													<span class="item-price">$<?php echo $price ; ?></span>
													<span class="item-quantity">Quantity: <?php echo $product_qty ; ?></span>
													<br/><span><a href="#" class="remove-item" id="<?php echo $i; ?>-<?php echo $item_id; ?>">Remove: <i class="fa fa-times" aria-hidden="true"></i></a></span>
												</div>
											</div>
									<?php
												$i++;
											}
											//format total cart amount
											$cartTotal = '$'.sprintf("%01.2f", $cartTotal);
										
									?>
									
										<div class="row shopping-cart-header">
											<div class="col-xs-4 col-xs-offset-3">
												
													<i class="fa fa-shopping-cart cart-icon"></i><span class="cart-badge"><?php echo $cart_count ;?></span>
											</div>
											<div class="col-xs-5">
												
												<div class="shopping-cart-total text-left">
													<span class="lighter-text">Total:</span>
													<span class="main-color-text"><?php echo $cartTotal; ?></span>
												</div>
											</div>
										</div> <!--end shopping-cart-header -->
									
									</div>
									<div class="row cart-buttons">
										<div class="col-xs-6">
											<a title="View Cart" href="javascript:void(0)" onclick="location.href='<?php echo base_url('cart/');?>'" class="btn btn-success btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> View Cart</a>
										</div>
										<div class="col-xs-6">
											<a title="Checkout" href="javascript:void(0)" onclick="location.href='<?php echo base_url('checkout/');?>'" class="btn btn-primary btn-block">Checkout</a>
										</div>
									</div>
											
									<?php
										}else{	
									?>
										<div class="row shopping-cart-items">
											<div class="col-xs-12 text-center">
												Your cart is empty
											</div>
											
										</div>
									<?php
										}	
									?>
									
								</div> <!--end shopping-cart -->
							</div>
						</div>
					</div>
				</ul>
				</li>
				
				<li class="custom-nav">
					<a title="Search" href="#" class="search-icon"><i class="fa fa-search" aria-hidden="true"></i></a>
				</li>
				
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sign-in" aria-hidden="true"></i><span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-lr animated slideInRight" role="menu">
						<div class="container-smallest">
						<div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <h3 class="text-center"><b>Log In</b></h3>
								<?php
									
									$emailError = '';
									$passError = '';
									
									$login_form = array(
										'id' => 'login_form',
										'class' => 'login-form',
										'autocomplete' => 'off',
										
									);
									echo form_open('login/validation',$login_form);
									
									if(form_error('email')){
										$emailError = 'input-error';
									}
									if(form_error('password')){
										$passError = 'input-error';
									}
									echo form_error('email');
									echo form_error('password');
								?>
                               
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control <?php echo $emailError;?>" placeholder="Email" value="" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control <?php echo $passError;?>" placeholder="Password" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-7">
                                                <input type="checkbox" name="remember" id="remember">
                                                <label for="remember"> Remember Me</label>
                                            </div>
                                            <div class="col-xs-5 pull-right">
												<button type="submit" class="btn btn-primary btn-block btn-signin">Log In <i class="fa fa-sign-in" aria-hidden="true"></i></button>
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="text-center">
                                            <a href="javascript:void(0)" onclick="location.href='<?php echo base_url('forgot-password/');?>'" title="Forgot Password?" class="forgot-password login-o">Forgot Password?</a>
											
                                        </div>
                                    </div>
                                    
                                <?php echo form_close(); ?>
                            </div>
							</div>
							</div>
                        </ul>
				</li>
			  </ul>
            </div>
          </div>
        </nav>

    </div>

<?php 
	$wishlist = '';
	if($this->session->flashdata('logged_in') != ''){
		$wishlist = $this->session->flashdata('logged_in');
	}	
	if($this->session->flashdata('wishlist') != ''){
		$wishlist = $this->session->flashdata('wishlist');
	}	
	echo $wishlist;
?>
