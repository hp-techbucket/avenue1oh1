		
		
		
		/*
		**	DATATABLE FUNCTIONS	
		**  DISPLAY ALL TABLES
		**  WITH SEARCH AND PAGINATION
		*/ 
		$(document).ready(function() {
		 
			//admin users table
			var table = $('#admin-users-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/admin_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  
 		 	
			//users table
			var table = $('#active-users-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/active_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  
 		 	
			//temp users table
			var table = $('#temp-users-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/temp_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  
 		 	 		 	
			//suspended users table
			var table = $('#suspended-users-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/suspended_users_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				//"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				
				responsive: true
				
			});
  					
			
			//products table
			var table = $('#products-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/products_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
			
			
			//product categories table
			var table = $('#product-categories-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/product_categories_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
			
			
			//male categories table
			var table = $('#male-categories-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/male_categories_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
			
			
			//female categories table
			var table = $('#female-categories-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/female_categories_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
						
						
			//projects table
			var table = $('#product-options-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/product_options_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
			
			 			 			
			
			//orders table
			var table = $('#orders-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/orders_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
			
			
			// payments table
			var table = $('#payments-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/payments_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
			
			// shipping table
			var table = $('#shipping-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/shipping_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});					
										
			
			
			//contact us table
			var table = $('#contact-us-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/contact_us_datatable",
					"type": "POST"
				},
				
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
			$('#c-us-table tbody').on( 'click', 'tr', function () {
				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			} );
			
			//mark message as read
			$('#contact-us-table').on( 'click', 'tr', function () {
				//alert($('#cb',this).val());
				//var id = $('#cb',this).val();
				
				$("span",this).addClass('msgRead');
				
			});
			
	
			
			//logins table
			var table = $('#logins-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/logins_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">',
				responsive: true
			});
	
			
			//failed logins table
			var table = $('#failed-logins-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/failed_logins_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});
	
			
			//failed resets table
			var table = $('#failed-resets-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/failed_resets_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});
			
			
			
			//subscription list table
			var table = $('#subscription-list-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/subscription_list_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});		


			
			//inbox-messages table
			var table = $('#inbox-messages-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"message/inbox_datatables",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});	
			
			//sent-messages table
			var table = $('#sent-messages-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"message/sent_datatables",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
			
			//site activities table
			var table = $('#site-activities-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/site_activities_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
			
			//men sizes table
			var table = $('#male-sizes-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/male_sizes_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
			
			//men shoe sizes table
			var table = $('#male-shoe-sizes-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/male_shoe_sizes_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
																								
			
			//women sizes table
			var table = $('#female-sizes-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/female_sizes_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
			
			//women shoe sizes table
			var table = $('#female-shoe-sizes-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/female_shoe_sizes_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
											
					
			//password resets table
			var table = $('#password-resets-table').DataTable({ 
		 
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/password_resets_datatables",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});
			
						
			
			//page metadata table
			var table = $('#page-metadata-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/page_metadata_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});		
			
		
			
			//brands table
			var table = $('#brands-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/brands_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
		
			
			//colours table
			var table = $('#colours-table').DataTable({ 
			
				"language": {
				   "emptyTable": "<div class=\"alert alert-default\"><i class=\"fa fa-ban\"></i> No records yet!</div>", // 
				   "loadingRecords": "Please wait...", // default Loading...
				   "zeroRecords": "No matching records found!"
				},
				
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
		 
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": baseurl+"admin/colours_datatable",
					"type": "POST"
				},
		 
				//Set column definition initialisation properties.
				"columnDefs": [
				{ 
					"targets": [ 0 ], //first column / numbering column
					"orderable": false, //set not orderable
				},
				],
				
				//"dom":' <"search"f><"top"l>rt<"bottom"ip><"clear">'
				"sDom": 'T<"clear">lfrtip<"clear spacer">T',
				responsive: true
				
			});																			
			
						
							

			//new $.fn.dataTable.FixedHeader( table );
			//$("div.toolbar").html('<button>Delete</button>');

			/*
			**	END DATATABLE FUNCTIONS	
			*/ 
					
		});	
		
		
		
		
	