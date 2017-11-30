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
	
	<!-- Facebox.css style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/facebox.css">
   
   <!-- Fancybox.css style -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
   
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
							<a title="My Wishlist" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/wishlist/'">My Wishlist</a>
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
		
	<!-- .navbar-wrapper-->	
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
                    <ul class="dropdown-menu custom-nav" role="menu">
						<li class="">
							<a title="Wishlist" href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/wishlist/');?>'"><i class="fa fa-list-alt" aria-hidden="true"></i> Wishlist</a>
						</li>
						<li class="divider"></li>
						<?php  
							if($this->session->userdata('logged_in')){ 
						
						?>
						<li class="">
							<a title="My Account" href="javascript:void(0)" onclick="location.href='<?php echo base_url('account');?>'"><i class="fa fa-fw fa-dashboard"></i> My Account</a>
						</li>
						<li class="divider"></li>
						<li class="">
							<a title="Logout" href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/logout/');?>'"><i class="fa fa-fw fa-power-off"></i> Logout</a>
						</li>
						<?php
							} else{ 
						
						?>
						<li class="">
							<a title="Login" href="javascript:void(0)" onclick="location.href='<?php echo base_url('login');?>'"><i class="fa fa-fw fa-sign-in"></i> Login</a>
						</li>
						<li class="divider"></li>
						<li class="">
							<a title="Register" href="javascript:void(0)" onclick="location.href='<?php echo base_url('signup/');?>'"><i class="fa fa-fw fa-user-plus" aria-hidden="true"></i> Register</a>
						</li>
						
						<?php 
						
						} 
						
						?>
                    </ul>
			</li>
			
			<li class="custom-nav">
				<a title="Search" href="#" class="search-icon"><i class="fa fa-search" aria-hidden="true"></i></a>
			</li>
				
				 <!--shopping cart-->				
				<li class="cart">
					
					<a href="#" class="cart-toggle"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge" id="cart_contents"><?php echo $cart_count ;?></span></a>
				
				</li>
				 <!--shopping cart dropdown-->
			  </ul>
            </div>
          </div>
        </nav>
	
    </div>
	<!-- /.navbar-wrapper-->	
			
		<div class="cart-overlay"></div>	
			<div class="shopping-bag">
				
				<h4 class="text-center"><b><i class="fa fa-shopping-cart"></i> Your Cart</b>
				</h4>
				
				<br/>
				
				<div class="cart-notif"></div>
									
				<div class="your-cart container-smallest">
					<?php
						//get cart items
						$shopping_cart = '';
						$cartTotal = "";
						$pp_checkout_btn = '';
						$product_id_array = '';
						
						//$shopping_cart .= '<h4 class="text-center">';
						//$shopping_cart .= '<b><i class="fa fa-shopping-cart"></i> Your Cart</b>';
						//$shopping_cart .= '</h4>';
						//$shopping_cart .= '<div class="cart-notif"></div>';
						
						$shopping_cart .= '<div class="shopping-cart container-smallest">';
						
						if(!empty($_SESSION["cart_array"])){
							$i = 0;
							foreach($_SESSION["cart_array"] as $eachItem){
								
								$item_id = $eachItem['product_id'];
								$productName = '';
								$product_image = '';
								$price = '';
								$details = '';
								$product_qty = '';
								$product_details = $this->Products->get_product($item_id);
								if($product_details){
									foreach($product_details as $product){
										$productName = $product->name;
										$product_image = $product->image;
										$price = $product->price;
										$details = $product->description;
									}
								}
								//total quantity
								$product_qty = $eachItem['quantity'];
								//item price
								$pricetotal = $price * $eachItem['quantity'];
																
								//format item price
								$pricetotal = sprintf("%01.2f", $pricetotal);
																
								//total cart amount
								$cartTotal = $pricetotal + $cartTotal;
																
								//product thumbnail
								$thumbnail = '';
																
								$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
																
								if(file_exists($filename)){
																	
									$thumbnail = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($item_id)).'/'.url_title(strtolower(html_escape($productName))).'" title="'.ucwords(html_escape($productName)).'"><img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive" alt="item'.$item_id.'"/></a>';
																	
								}else if($product_image == '' || $product_image == null || !file_exists($filename)){
																	
									$thumbnail = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($item_id)).'/'.url_title(strtolower(html_escape($productName))).'" title="'.ucwords(html_escape($productName)).'"><img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded"  alt="item'.$item_id.'" /></a>';
																	
								}else{
																	
									$thumbnail = '<a href="'.base_url().'collections/product/'.strtolower(html_escape($item_id)).'/'.url_title(strtolower(html_escape($productName))).'" title="'.ucwords(html_escape($productName)).'"><img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive img-rounded" alt="item'.$item_id.'" /></a>';
																	
								}
								
								$shopping_cart .= '<div class="row shopping-cart-items">';
								$shopping_cart .= '<div class="col-md-3 col-xs-6">'.$thumbnail.'</div>';
								$shopping_cart .= '<div class="col-xs-7">';
								$shopping_cart .= '<h5><b><a href="'.base_url().'collections/product/'.strtolower(html_escape($item_id)).'/'.url_title(strtolower(html_escape($productName))).'" title="'.ucwords(html_escape($productName)).'">'.ucwords(html_escape($productName)).'</a></b>';
								$shopping_cart .= '</h5>';
								$shopping_cart .= '<p>'.$product_qty.' X $'.$price.'</p>';
								$shopping_cart .= '</div>';
								$shopping_cart .= '<div class="col-xs-2"><span class="pull-right"><a href="#" title="Remove Item" class="remove-item" id="'.$i.'-'.$item_id.'"><i class="fa fa-times" aria-hidden="true"></i></a></span></div>';
								$shopping_cart .= '</div>';
								$shopping_cart .= '<hr/>';
								$i++;
							}
							//format total cart amount
							$cartTotal = '$'.sprintf("%01.2f", $cartTotal);
							
							$shopping_cart .= '<div class="row shopping-cart-header">';
							$shopping_cart .= '<div class="col-xs-7"><h4 class="text-center"><b>SUBTOTAL :</b></h4></div>';
							$shopping_cart .= '<div class="col-xs-5"><div class="shopping-cart-total text-left"><h4 class="lighter-text">'.$cartTotal.'</h4></div></div>';
							$shopping_cart .= '</div>';
							$shopping_cart .= '<div class="cart-buttons">';
							$shopping_cart .= '<p><a title="VIEW SHOPPING BAG" href="javascript:void(0)" onclick="location.href='.base_url('cart/').'" class="btn btn-white btn-block">VIEW SHOPPING BAG <i class="fa fa-shopping-bag"></i>('. count($_SESSION["cart_array"]).')</a></p>';
							$shopping_cart .= '<p><a title="Checkout" href="javascript:void(0)" onclick="location.href='.base_url('checkout/').'" class="btn btn-orange btn-block"><i class="fa fa-chevron-right" aria-hidden="true"></i> CHECKOUT</a></p>';
							$shopping_cart .= '</div>';
							
						}else{
							$shopping_cart .= '<div class="row shopping-cart-items"><div class="col-xs-12 text-center">Your cart is empty</div></div>';
						}
						$shopping_cart .= '</div>';
						
								echo $shopping_cart;					
							?>
						
				</div>
				
			</div><!--end shopping-cart -->
		
	
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
