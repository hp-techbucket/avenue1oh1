<div class="container-fluid store-container">
	<div class="text-center" align="center">
		<?php 
			$message = '';
			if($this->session->flashdata('product_updated') != ''){
				$message = $this->session->flashdata('product_updated');
			}	
			echo $message;					
		?>	
	</div>
	<div class="container-fluid">
		<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo $pageTitle;?> <small></small>
                        </h1>
                       
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-8">
						<div class="cart_list">
							<h3></h3>
							<div id="cart_content">
								<div class="table-responsive" align="center">
									<table frame="box" class="table table-hover table-striped">
										<thead>
											<tr>
												<th width="10%">Product</th>
												
												<th width="40%">Description</th>
												<th width="10%">Unit Price</th>
												<th width="20%">Qty</th>
												
												<th width="10%">Sub-Total</th>
												<th width="10%">Remove</th>
											</tr>
										</thead>
										<tbody>
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
														foreach ($query->result() as $row)
														{
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
													$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
													<input type="hidden" name="amount_' . $x . '" value="' . $price . '">
													<input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
													$product_id_array .= "$item_id-".$each_item['quantity'].","; 
													
													$thumbnail = '';
													$filename = FCPATH.'uploads/products/'.$item_id.'/'.$product_image;
													
													if(file_exists($filename)){
														$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$item_id.'.jpg" class="img-responsive img-rounded" width="100" height="100" />';
													}
													
													else if($product->image == '' || $product->image == null || !file_exists($filename)){
														$thumbnail = '<img src="'.base_url().'assets/images/icons/no-default-thumbnail.png" class="img-responsive img-rounded" width="100" height="100" />';
													}
													else{
														$thumbnail = '<img src="'.base_url().'uploads/products/'.$item_id.'/'.$product_image.'" class="img-responsive img-rounded" width="100" height="100" />';
													}
											?>
												<tr>
													<td><?php echo $thumbnail; ?></td>
													<td><?php echo $details; ?></td>
													<td>$<?php echo $price; ?></td>
													<td>
														
														<form class="form-inline" id="update_cart_form" action="<?php echo base_url('store/update_cart'); ?>" method="post" enctype="multipart/form-data">
															<div class="form-group">
																<input type="text" name="quantity" id="quantity" value="<?php echo $each_item['quantity']; ?>" size="1" maxlength="2" />
																<input name="item_to_adjust" id="item_to_adjust" type="hidden" value="<?php echo $item_id; ?>" />
																<input name="index" id="index" type="hidden" value="<?php echo $i; ?>" />
															</div>
															<button name="adjustBtn<?php echo $item_id; ?>" type="submit" class="btn btn-default">Update</button>
														</form>
														
													</td>
													
													<td>$<?php echo $pricetotal; ?></td>
													
													<form action="<?php echo base_url('store/remove_item'); ?>" method="post" enctype="multipart/form-data">
													<td>
													<button name="deleteBtn<?php echo $item_id; ?>" class="btn btn-danger" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
													<input name="index_to_remove" type="hidden" value="<?php echo $i; ?>" />
													</td>
													</form>
												</tr>
											
											<?php
													$i++;
												}
												$cartTotal = sprintf("%01.2f", $cartTotal);
												$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
																	<input type="hidden" name="notify_url" value="storescripts/my_ipn.php">
																	<input type="hidden" name="return" value="checkout_complete.php">
																	<input type="hidden" name="rm" value="2">
																	<input type="hidden" name="cbt" value="Return to The Store">
																	<input type="hidden" name="cancel_return" value="paypal_cancel.php">
																	<input type="hidden" name="lc" value="US">
																	<input type="hidden" name="currency_code" value="USD">
																	<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">';
												
											?>	
											<tr>
												<td colspan="6">
													<h3 align="right">Total: $<?php echo $cartTotal; ?></h3>
												</td>
											</tr>							
											<tr>
												<td colspan="3"><a title="Continue Shopping" class="btn btn-success btn-block" href="javascript:void(0)" onclick="location.href='<?php echo base_url('store/products/');?>'">Continue Shopping</a></td>
												<td><a title="Empty Cart" class="btn btn-danger btn-block" href="javascript:void(0)" onclick="location.href='<?php echo base_url('store/empty_cart');?>?cmd=emptycart'">Empty Cart</a></td>
												<td>
												<?php echo form_open('store/checkout'); ?>
													<button type="submit" class="btn btn-primary btn-block">Checkout</button>
												<?php echo form_close(); ?>
												</td>
												<td>
												 
												<?php echo $pp_checkout_btn; ?>
												
												</td>
											</tr>
											<?php  
											}else{
											?>
											<tr>
												
												<td colspan="6" align="center"><div class="alert alert-danger" role="alert">
												  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
												  <span class="sr-only"></span> Your cart is empty!</div>
												</td>
												
											</tr>	
											
											<?php  
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                </div>
				
			
				
				
    </div>


	  
</div>	