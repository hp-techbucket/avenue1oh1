		
		
	/*
	**	DATATABLE FUNCTIONS	
	**  DISPLAY ALL TABLES
	**  WITH SEARCH AND PAGINATION
	*/ 
	$(document).ready(function() {
		 			 			 			
			
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
					"url": baseurl+"account/orders_datatable",
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
		 			 			 			
			
			//transactions table
			var table = $('#transactions-table').DataTable({ 
		 
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
					"url": baseurl+"account/transactions_datatable",
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

		 			 			 			
			
			//wishlist table
			var table = $('#wishlist-table').DataTable({ 
		 
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
					"url": baseurl+"account/wishlist_datatable",
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


	});				
		
		