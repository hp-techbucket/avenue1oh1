	
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
				<div class="box box-success">
					<div class="alert alert-success">
						<h3>Reference: 
							<strong><?php echo $reference; ?></strong>
						</h3>
						<p>Hello <?php echo $user->first_name; ?>, you have successfully completed your order!</p>
					</div>
					<div class="table-responsive" align="center">
						<table class="table ">
							<thead>
								<tr>
									<th>Product</th>
									<th>Costs</th>
								</tr>
							</thead>
							<tbody>	
								<?php echo $order_table; ?>
							</tbody>
						</table>
					</div>	
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
			
			