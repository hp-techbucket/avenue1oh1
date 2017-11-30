	
		/*
		**============================START BRAND FUNCTIONS===============***\\	
		*/ 
		
		//function to handle add Brand
		function addBrand() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addBrandForm'));

			var url = $('#addBrandForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					if(data.success == true){
						
						$("#addBrandModal").modal('hide');
						
						$("#bName").val('');
						
						$( "#load" ).hide();  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			return false;
		}	

		//function to edit Brand details
		function editBrand(id) {
					
			$( "#load" ).show();
			
			var url = baseurl+"admin/brand_details";
			
			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						document.updateBrandForm.brandID.value = data.id;
						
						$('#brand').html(data.headerTitle);
						$('#brand_name').val(data.brand_name);
						
						
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}	
					
		//function to handle update Brand
		function updateBrand() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateBrandForm'));
			var url = $('#updateBrandForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					$("#brandID").val('');
					$("#brand_name").val('');
						  
					if(data.success == true){
						
						$("#editBrandModal").modal('hide');
						$("#load").hide();
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form-errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
		
		}		

		/*
		**============================END BRAND FUNCTIONS===============***\\	
		*/ 
		
	
		/*
		**============================START COLOUR FUNCTIONS===============***\\	
		*/ 
		
		//function to handle add Colour
		function addColour() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addColourForm'));

			var url = $('#addColourForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					if(data.success == true){
						
						$("#addColourModal").modal('hide');
						
						$("#cName").val('');
						
						$( "#load" ).hide();  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			return false;
		}	

		//function to edit colour details
		function editColour(id) {
					
			$( "#load" ).show();
			
			var url = baseurl+"admin/colour_details";
			
			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						document.updateColourForm.colourID.value = data.id;
						
						$('#colour').html(data.headerTitle);
						$('#colour_name').val(data.colour_name);
						
						
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}	
					
		//function to handle update colour
		function updateColour() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateColourForm'));
			var url = $('#updateColourForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					$("#colourID").val('');
					$("#colour_name").val('');
						  
					if(data.success == true){
						
						$("#editColourModal").modal('hide');
						$("#load").hide();
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form-errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
		
		}		
	
		/*
		**============================END COLOUR FUNCTIONS===============***\\	
		*/ 
		
		
		
			
		/*
		**============================START CONTACT US MESSAGE FUNCTIONS===============***\\	
		*/ 
		
		//Contact us message form 
		//bootstrap validator	
		 $(document).ready(function() {
			
			$('.contact_us_form').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					contact_us_name: {
						validators: {
							notEmpty: {
								message: 'Please enter your full name!'
							}
						}
					},
					contact_us_telephone: {
						validators: {
							notEmpty: {
								message: 'Please enter your telephone number!'
							}
						}
					},
					contact_us_email: {
						validators: {
							notEmpty: {
								message: 'Please enter your email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address!'
							}
						}
					},
					contact_us_message: {
						validators: {
							stringLength: {
								min: 10,
								max: 200,
								message:'Please enter at least 10 characters and no more than 200'
							},
							notEmpty: {
								message: 'Please enter your message!'
							}
						}
					}
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$(".contact_us_form").data('bootstrapValidator').resetForm();
					contactUsMessage();
				}
			});
		});
		
		//function to handle submit contact us form
		function contactUsMessage() { 
		
			$(".error-message").hide();
			var error = '';
			var isFormValid = true; 
			$( "#load" ).show();
			
			//validate form before submit
			
				if ($("#contact_us_message").val().trim() === '') {
							
					$(this).css('border-color','red');     
					
					$(".error-message").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-exclamation-triangle"></i> Please enter your message!');
					isFormValid = false;
					
				}else{
					$(this).css('border-color','#B2B2B2');
				}
			
			if(!isFormValid){
					$(".error-message").show();
					$( "#load" ).hide();
					return isFormValid;
			} 
			
			var dataString = { 
				contact_us_name : $("#contact_us_name").val(),
				contact_us_telephone : $("#contact_us_telephone").val(),
				contact_us_email : $("#contact_us_email").val(),
				contact_us_company : $("#contact_us_company").val(),
				contact_us_message : $("#contact_us_message").val()
			};
			var form = $('.contact_us_form').get(0);
			//var form = new FormData(document.getElementById('contact_us_form'));
			var validate_url = $(".contact_us_form").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: new FormData(form),
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
					
						$("#contact_us_name").val('');
						$("#contact_us_telephone").val('');
						$("#contact_us_email").val('');
						$("#contact_us_company").val('');
						$("#contact_us_message").val('');
							  
						$("#response-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('#response-message').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						$(".error-message").hide();
						$("#response-message").html(data.notif+'<br/>'+data.errors);
						//$('html, body').animate({scrollTop: 350}, 700);
						//$("#response-errors").html(data.errors);
						//$("#response-message").append();
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}	
		
		//view contact us message
		function viewContactMessage(id){
			
			if(id === '')
				return;
			
			var dataString = { 
				id : id
			};		

			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/contact_us_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						$("#headerTitle").html(data.headerTitle);
						$("#contact_name").html(data.contact_name);
						$("#contact_telephone").html(data.contact_telephone);
						$("#contact_email").html(data.contact_email);
						$("#contact_company").html(data.contact_company);
						$("#contact_message").html(data.contact_message);
						$("#ip_address").html(data.ip_address);
						$("#opened").html(data.opened);
						$("#contact_us_date").html(data.contact_us_date);				

					}else{
						alert('false');
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		/*
		**============================END CONTACT US MESSAGE FUNCTIONS===============***\\	
		*/ 
		
		
		/*
		**============================START SIZES FUNCTIONS===============***\\	
		*/ 
			
		//function to handle add Size
		function addSize() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addSizeForm'));

			var url = $('#addSizeForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					if(data.success == true){
						
						$("#addSizeModal").modal('hide');
						
						$("#s_EU").val('');
						$("#s_UK").val('');
						$("#s_US").val('');
						$("#sModel").val('');
						
						$("#load").hide();  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			return false;
		}	

				
		//function to pass gender to hidden
		//input
		$(document).ready(function() {
		
			$('.men-sizes').on("click", function(e){ //
				e.preventDefault(); 
				var model = 'male_sizes';
				alert(model);
				$("#sModel").val(model);
			});
			
			$('.men-shoe-sizes').on("click", function(e){ //
				e.preventDefault(); 
				var model = 'male_shoe_sizes';
				alert(model);
				$("#sModel").val(model);
			});
			
			$('.women-sizes').on("click", function(e){ //
				e.preventDefault(); 
				var model = 'female_sizes';
				alert(model);
				$("#sModel").val(model);
			});
			
			$('.women-shoe-sizes').on("click", function(e){ //
				e.preventDefault(); 
				var model = 'female_shoe_sizes';
				alert(model);
				$("#sModel").val(model);
			});
			
			
		});	
		
		
		
		//function to edit Size details
		function editSize(id,model) {
					
			$( "#load" ).show();
			
			var url = '';
			
			if(model == 'male_sizes'){
				url = baseurl+"admin/male_size_details";
			}

			if(model == 'male_shoe_sizes'){
				url = baseurl+"admin/male_shoe_size_details";
			}

			if(model == 'female_sizes'){
				url = baseurl+"admin/female_size_details";
			}

			if(model == 'female_shoe_sizes'){
				url = baseurl+"admin/female_shoe_size_details";
			}

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						document.updateSizeForm.sizeID.value = data.id;
						$('#headerTitle').val(data.headerTitle);
						$('#size_EU').val(data.size_EU);
						$('#size_UK').val(data.size_UK);
						$('#size_US').val(data.size_US);
						
						$('#sizeModel').val(data.model);
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}	
					
		//function to handle update Size
		function updateSize() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateSizeForm'));
			var url = $('#updateSizeForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					$("#sizeID").val('');
					$("#size_EU").val('');
					$("#size_UK").val('');
					$("#size_US").val('');
					$("#sizeModel").val('');
							  
					if(data.success == true){
						
						$("#editSizeModal").modal('hide');
						$("#load").hide();
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form-errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
		
		}		

		/*
		**============================END SIZES FUNCTIONS===============***\\	
		*/ 
		


		//*****************START PAGE METADATA FUNCTIONS*************//	

		
				 		
  		//function to view Page Metadata details
		function viewPageMetadata(id) {
			
			if(id === '')
				return;
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/page_metadata_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#view-page").html(data.page);
						$("#view-keywords").html(data.keywords);
						$("#view-description").html(data.description);
						
						
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//function to add new Page Metadata
		//via ajax
		function addPageMetadata() { 

			var form = new FormData(document.getElementById('addMetadataForm'));
			
			var validate_url = $('#addMetadataForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
						$("#addMetadataModal").modal('hide');
						
						$("#page").val('');
						$("#keywords").val('');
						$("#description").val('');
							  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		
		//ajax function to edit Page Metadata details
		//
		function editPageMetadata(id){
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/page_metadata_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#page_metadata_id").val(data.id);
						
						$("#edit-header").html(data.headerTitle);
						$("#u-page").val(data.page);
						$("#u-keywords").val(data.keywords);
						
						$("#u-description").val(data.description);
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//function to submit edited details
		//to db via ajax
		function updatePageMetadata(){
			
			var form = new FormData(document.getElementById('updateMetadataForm'));
			
			//get text from wysi editor
			//var editor = $("#metadata-description").html();
			
			//insert into hidden textarea 
			//$("#u-description").val(editor);
			
			var validate_url = $('#updateMetadataForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						$("#editModal").modal('hide');
						$('#u-page').val('');
						$('#u-keywords').val('');
						$('#u-description').val('');
						$("#page_metadata_id").val('');

						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		//*****************END PAGE METADATA FUNCTIONS*************//		
			
			
		//*****************START ORDER FUNCTIONS*************//	

		
				 		
  		//function to view Order details
		function viewOrder(ref) {
			
			if(ref === '')
				return;
					
			$( "#load" ).show();

			var dataString = { 
				reference : ref
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/order_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#view-details").html(data.order_details);
						
						
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
				
		//function to add new Order 
		//via ajax
		function addOrder() { 

			var form = new FormData(document.getElementById('addOrderForm'));
			
			var validate_url = $('#addOrderForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
						$("#addOrderModal").modal('hide');
						
						$("#total_price").val('');
						$(".customer_email").val('0');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		
		
		//ajax function to edit Order details
		//
		function editOrder(id){
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/order_edit",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#shipping_id").val(data.id);
						
						$("#edit-header").html(data.headerTitle);
						$("#totalPrice").val(data.total_price);
						$("#paymentStatus").val(data.payment_status);
						$("#shippingStatus").val(data.shipping_status);
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//function to submit edited details
		//to db via ajax
		function updateOrder(){
			
			var form = new FormData(document.getElementById('updateOrderForm'));
			
			var validate_url = $('#updateOrderForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						$("#editModal").modal('hide');
						
						$("#shipping_id").val('');
					
						$("#shipping_status").val('');
						$("#shipping_note").val('');
						$("#c_email").val('');
						$("#shippingDate").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}

		//*****************END ORDER FUNCTIONS*************//	



		//*****************START SHIPPING FUNCTIONS*************//		 		
  		//function to view Shipping details
		function viewShipping(id) {
			
			if(id === '')
				return;
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/shipping_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#view-details").html(data.details);
						
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//function to add new Shipping 
		//via ajax
		function addShipping() { 

			var form = new FormData(document.getElementById('addShippingForm'));
			
			var validate_url = $('#addShippingForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
						$("#addShippingModal").modal('hide');
						
						$("#reference").val('');
						$("#status").val('');
						$("#note").val('');
						$("#customer_email").val('');
						$("#shipping_date").val('');
							  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		
						
		//function to pass gender to hidden
		//input
		$(document).ready(function() {
		
			$('.reference').on("change", function(){ //
				//e.preventDefault(); 
				//alert($(this).val());
				var dataString = { 
					reference : $(this).val()
				};	
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"admin/customer_details",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							$("#customer_email").val(data.customer_email);
						}
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						alert(error);
					},

				});	
			});
		
		});	
		
		
		
		//ajax function to edit Shipping details
		//
		function editShipping(id){
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/shipping_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#shipping_id").val(data.id);
						
						$("#edit-header").html(data.headerTitle);
						$("#shipping_status").val(data.shipping_status);
						$("#shipping_note").val(data.note);
						$("#c_email").val(data.customer_email);
						$("#shippingDate").val(data.update_shipping_date);
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//function to submit edited details
		//to db via ajax
		function updateShipping(){
			
			var form = new FormData(document.getElementById('updateShippingForm'));
			
			//get text from wysi editor
			//var editor = $("#metadata-description").html();
			
			//insert into hidden textarea 
			//$("#u-description").val(editor);
			
			var validate_url = $('#updateShippingForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						$("#editModal").modal('hide');
						
						$("#shipping_id").val('');
					
						$("#shipping_status").val('');
						$("#shipping_note").val('');
						$("#c_email").val('');
						$("#shippingDate").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		//*****************END SHIPPING FUNCTIONS*************//		
			

		