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
	<meta name="theme-color" content="#ffffff">
    <title>Avenue 1-OH-1 | <?php echo $pageTitle; ?></title>

    <!-- Bootstrap core CSS -->
	<?php echo link_tag('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'); ?>
	<?php echo link_tag('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	<?php echo link_tag('assets/css/style.css'); ?>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
  </head>

  <body id="<?php echo $pageID; ?>">
  <div id="load">Please wait ...</div>
	<audio id="notif_audio"><source src="<?php echo base_url('assets/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('assets/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('assets/sounds/notify.wav');?>" type="audio/wav"><embed hidden="true" autostart="true" loop="false" src="<?php echo base_url('assets/sounds/notify.mp3');?>" /></audio>

  
  
    <div class="navbar-wrapper">
      
        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">
				<img alt="Brand" src="<?php echo base_url('assets/images/logo/av101.PNG');?>" width="60" height="35">
			  
			  </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
               <ul class="nav navbar-nav">
                <li><a title="Home" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>'">Home</a></li>
                <li><a title="About" href="javascript:void(0)" onclick="location.href='<?php echo base_url('main/about/');?>'">About</a></li>
                <li><a title="Contact" href="javascript:void(0)" onclick="location.href='<?php echo base_url('main/contact_us/');?>'">Contact</a></li>
				<li><a title="Gallery" href="javascript:void(0)" onclick="location.href='<?php echo base_url('main/gallery/');?>'">Gallery</a></li>
              </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li>
					<a title="Store" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>store/'"><i class="fa fa-building"></i> Store</a>
				</li>
				<li><a href="#" id="cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge" id="cart_contents"><?php echo $cart_count ;?></span> <b class="caret"></b></a></li>
				<li><a title="Login" href="javascript:void(0)" onclick="location.href='<?php echo base_url('main/social/');?>'"><i class="fa fa-fw fa-sign-in"></i> Login</a></li>
				
			  </ul>
            </div>
          </div>
        </nav>

    </div>


	<div class="cart-container">
		<div class="shopping-cart">
			<div class="scrollable-cart">
				
				<?php
				$cartTotal = "";
				$pp_checkout_btn = '';
				$product_id_array = '';
				if(!empty($_SESSION["cart_array"])){
					$i = 0;
					foreach($_SESSION["cart_array"] as $each_item){
															
						$item_id = $each_item['product_id'];
															
						$query = $this->db->get_where('products', array('id' => $item_id));
															
						$product_name = '';
						$product_image = '';
						$price = '';
						$details = '';
						if($query){
							foreach ($query->result() as $row){
								$product_image = $row->image;
								$product_name = $row->name;
								$price = $row->price;
								$details = $row->description;
							}							
						}
						$pricetotal = $price * $each_item['quantity'];
						$pricetotal = sprintf("%01.2f", $pricetotal);
						$cartTotal = $pricetotal + $cartTotal;
															
						// Dynamic Checkout Btn Assembly
						$x = $i + 1;
						
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
							<span class="item-quantity">Quantity: <?php echo $each_item['quantity'] ; ?></span>
						</div>
					</div>
					  
					  
				<?php
						$i++;
					}
					$cartTotal = '$'.sprintf("%01.2f", $cartTotal);
				?>
				
				
				<div class="row shopping-cart-header">
					<div class="col-xs-12">
						<i class="fa fa-shopping-cart cart-icon"></i><span class="cart-badge"><?php echo $cart_count ;?></span>
						<div class="shopping-cart-total">
							<span class="lighter-text">Total:</span>
							<span class="main-color-text"><?php echo $cartTotal; ?></span>
						</div>
					</div>
				</div> <!--end shopping-cart-header -->
			<?php  
				}
			?>
				
				
			</div>
			<div class="row cart-buttons">
				<div class="col-xs-6">
					<a title="View Cart" href="javascript:void(0)" onclick="location.href='<?php echo base_url('store/cart/');?>'" class="btn btn-success btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> View Cart</a>
				</div>
				<div class="col-xs-6">
					<a title="Checkout" href="javascript:void(0)" onclick="location.href='<?php echo base_url('store/checkout/');?>'" class="btn btn-primary btn-block">Checkout</a>
				</div>
			</div>
		</div> <!--end shopping-cart -->
	</div> <!--end container -->
		