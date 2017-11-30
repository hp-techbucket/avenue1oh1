	
	<?php   
		if(!empty($users))
		{
			foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
			{	

	?>
	<div class="collection-banner">
		<div class="banner-wrapper">
			<div class="collection-banner-caption">
				<div class="collection-banner-header">
					<?php echo $pageTitle;?>
				</div>
				<div class="collection-banner-text">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<a href="<?php echo base_url();?>account/" title="Account" class="">Account</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<?php echo $pageTitle;?>
				</div>
			</div>	
		</div>
	</div>
	
	<br/>
	
	<div class="container">
		<div class="row">
			
			<div class="col-md-8 col-md-offset-2" align="center">
				<div class="alert alert-success">
					<h3>Reference: 
						<strong><?php echo $payment_data["txn_id"]; ?></strong>
					</h3>
					<p>Hello <?php echo $user->first_name; ?>, you have paid <strong>$<?php echo $payment_data["payment_gross"]; ?></strong>!</p>
					<p>Payment Status : 
						<strong><?php echo $payment_data["payment_status"]; ?></strong>
					</p>
        
				</div>
				<div class="table-responsive" align="center">
					<table class="table ">
						<thead>
							<tr>
								<th>Product</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>	
						<?php
						$cartTotal = '';
						foreach($_SESSION["cart_array"] as $each){
													
							$item_id = $each['product_id'];
																
							$query = $this->db->get_where('products', array('id' => $item_id));
																
							$pname = '';
							$pprice = '';
							$details = '';
							if($query){
								foreach ($query->result() as $row){
									
									$pname = $row->name;
									$pprice = $row->price;
									$details = $row->description;
								}							
							}
							$pricetotal = $pprice * $each['quantity'];
							$pricetotal = sprintf("%01.2f", $pricetotal);
							$cartTotal = $pricetotal + $cartTotal;
							
						
						?>
						
							<tr>
								<td>
									<p class="text-primary"><strong><?php echo $pname; ?></strong></p>
									<p>Item Price: $<?php echo $pprice; ?></p>
									<p>Quantity:<?php echo $each['quantity']; ?></p>
								</td>
								<td><strong>$<?php echo $pricetotal; ?></strong></td>
							</tr>
							
						<?php
						}
						$cartTotal = sprintf("%01.2f", $cartTotal);
						?>
							
							<tr>
								<td>
									<p class="text-primary"><strong>Sub Total</strong></p>
									<p>Tax</p>
									<p>Shipping and handling</p>
								</td>
								<td>
									<p class="text-primary"><strong>$<?php echo $cartTotal; ?></strong></p>
									<p>$<?php echo $payment_data["tax"]; ?></p>
									<p>$<?php echo $payment_data["mc_shipping"] + $payment_data["mc_handling"]; ?></p>
								</td>
							</tr>
							<tr>
								<td><strong>Total Amount</strong></td>
								<td><strong>$<?php echo $payment_data["payment_gross"]; ?></strong></td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>

	<div class="breadcrumb-container">
		<div class="container">
			<div class="custom-breadcrumb">
				<span class="breadcrumb">
					<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i> 
					<a href="<?php echo base_url();?>account/" title="Account" class="">Account</a> 
					<i class="fa fa-angle-right" aria-hidden="true"></i>
					<?php echo html_escape($pageTitle);?>
				</span>
				<span class="pull-right"><?php echo date('l, F d, Y', time());?></span>
			</div>
		</div>
	</div>

	
	<?php   
			}
		}								
	?>
			
			