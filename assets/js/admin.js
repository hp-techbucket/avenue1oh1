
		/*
		**	ADMIN USERS FUNCTIONS	
		*/ 
		
		//function to add new admin
		function addAdmin() { 

			var form = new FormData(document.getElementById('addAdminForm'));
			
			var validate_url = $('#addAdminForm').attr('action');
			
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
						$("#addAdminModal").modal('hide');
						
						$("#name_of_admin").val('');
						$("#admin_username").val('');
						$("#admin_password").val('');
							  
						$("#notif").html(data.notif);
	
						setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$("#errors").html(data.upload_error);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		
		
		//Function to view admin user details
		function viewAdmin(id){
			
			var dataString = { 
				id : id
			};		

			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/admin_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						$("#headerTitle").html(data.admin_name);
						$("#thumbnail").html(data.thumbnail);
						$("#adminUserName").html(data.admin_username);
						$("#adminName").html(data.admin_name);
						$("#accessLevel").html(data.access_level);
						
						$("#lastLogin").html(data.last_login);
						$("#dateJoined").html(data.date_created);				

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

		//Function to edit admin user details
		function editAdmin(id){
			
			var dataString = { 
				id : id
			};		

			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/admin_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						//populate the hidden fields
						document.updateAdminForm.adminID.value = data.id;
						//$("#adminID").val(data.id);
						
						$("#name").html(data.admin_name);
						$("#admin_name").html(data.admin_name);
						$(".u-thumbnail").html(data.update_thumbnail);
						$("#username").html(data.admin_username);
						$("#a_level").html(data.select_access_level);
						$("#old_password").val(data.admin_password);			

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
		
				
		//function to submit edited details
		//to db via ajax
		function updateAdmin(){
			
			var form = new FormData(document.getElementById('updateAdminForm'));
			
			var validate_url = $('#updateAdminForm').attr('action');
			
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
						$("#adminID").val('');
						$('#new_password').val('');
						$("#old_password").val('');
						
						$("#notif").html(data.notif);
						
						setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		/*
		**	END ADMIN USERS FUNCTIONS	
		*/ 
			
	
		
			
		//function to handle add question
		function addProduct() { 
		
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addProductForm'));
			
			var url = $('#addProductForm').attr('action');
			
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

						$('input[name=product_image]').fieldValue('');
						$(".product_image_name").val('');
						$('[name=product_category]').val('0');
						$('[name=product_gender]').val('0');
						$('[name=product_colour]').val('0');
						$('#pSize').val('');
						$('[name=product_brand]').val('0');
						$("#pName").val('');
						$("#pPrice").val('');
						$("#salePrice").val('');
						$("#pDescription").val('');
						
						$("#pQuantity").val('');
											
						$("#addProductModal").modal('hide');
						$( "#load" ).hide();	
						
						$(".notif").html(data.notif);
						$(".errors").html(data.upload_error);
						//window.location.reload(true);
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 3000); 
						//window.location.reload(true);
						

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
					//location.reload();
				},
			});
			return false;
		}	     
			
  		//function to view product details
		function viewProduct(id) {
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/product_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle +' ('+ data.product_reference +')');
						$("#thumbnail").html(data.thumbnail);
						$("#image_row").html(data.image_row);
						$("#image_gallery").html(data.product_gallery);
						$("#rating-box").html(data.rating_box);
						$(".rating-box").html(data.rating_star);
						/*if(data.rating == '' || data.rating < 1){
							$(".rating-box").html('<div class="starrr stars-existing" data-rating="'+data.rating+'"></div><span class="">No reviews yet</span>');
						}else{
							$(".rating-box").html('<div class="starrr stars-existing" data-rating="'+data.rating+'"></div><span class="stars-count-existing">'+data.rating+'</span> star(s) <span class="label label-success">'+data.count_reviews+'</span>');
						}*/
						
						$("#rating-box2").html(data.rating_box);
						$("#productRef").html(data.product_reference);
						$("#productName").html(data.name);
						$("#productCategory").html(data.category);
						$("#p_category").html(data.category);
						$("#productDescription").html(data.description);
						$("#p_description").html(data.description);
						$(".status").html(data.quantity_status);
						$("#product_ref").html(' ('+data.product_reference+')');
						$("#productGender").html(data.gender);
						$("#product-colour").html(data.colour);
						$("#product-size").html(data.size);
						$("#product-brand").html(data.product_brand);
						
						$("#sale").html(data.sale);
						$("#sale_price").html(data.sale_price);
						
						$("#productPrice").html('$ '+data.price);
						$("#productQuantity").html(data.quantity_available);
						$("#dateAdded").html(data.date_added);
						
						$("#p_id").val(data.id);
						//$("span").attr('id', data.id);
						
						var qty = $('#cart_quantity_'+data.id).val();
						
						$(".p-qty").val(qty);
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




		
		//function to edit product details
		function editProduct(id) {
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/product_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						document.updateProductForm.productID.value = data.id;
						$(".p-thumbnail").html(data.mini_thumbnail);
						$("#product_name").val(data.name);
						//$("#userID").val(data.id);
						$("#select_category").html(data.select_category);
						$('[name=product_category]').val(data.category);
						$("#product_category_name").val(data.category);
						$("#select_colour").html(data.select_colour);
						$('#product_gender').val(data.gender);
						$('#product_size').val(data.product_size);
						$('#select_size').html(data.select_size);
						$("#select_brand").html(data.select_brand);
						$("#product_description").val(data.description);
						$("#product_price").val(data.price);
						$('#sale').val(data.sale);
						$("#sale_price").val(data.sale_price);
						$("#product_quantity_available").val(data.quantity);
						
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
					
		
		//function to handle update Product
		function updateProduct() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateProductForm'));
			var url = $('#updateProductForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					if(data.success == true){

						//$('input[name=new_product_image]').fieldValue('');
						$('.new_product_image_name').val('');
						$('[name=product_category]').val('');
						$("#productID").val('');
						$("#product_name").val('');
						$('[name=product_gender]').val('');
						$('[name=product_colour]').val('');
						$('[name=product_brand]').val('');
						$('#product_size').val('');
						$("#product_description").val('');
						$("#product_price").val('');
						$("#product_quantity_available").val('');
						$('#sale').val('');
						$("#sale_price").val('');
						$("#editProductModal").modal('hide');
						$( "#load" ).hide();
						
						$("#notif").html(data.notif);
						$("#errors").html(data.upload_error);
						setTimeout(function() { 
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
		
		}		
 
  		
		//function to remove or add more images
		function editImages(id) {
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/product_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						//document.upload_product_images.product_id.value = data.id;
						
						$("#header").html(data.headerTitle);
						$("#prod_id").val(data.id);
						$("#gallery-edit").html(data.image_group);
						$("#images_count").html(data.images_count);
						
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
		
		//function for multiple file upload display
		$(document).ready(function() {
			var max_fields      = 10; //maximum input boxes allowed
			var wrapper         = $(".input_fields_wrap"); //Fields wrapper
			var add_button      = $(".upload_more_button"); //Add button ID
			
			var x = 1; //initial upload file box count
			$(add_button).click(function(e){ //on add input button click
				e.preventDefault();
				if(x < max_fields){ //max input box allowed
					x++; //text box increment
					$(wrapper).append('<div class="form-group"><span class="btn btn-default btn-file">Choose Image <input type="file" name="product_images[]" onchange="getFilename(this)" id="product_images" multiple/></span><a href="#" class="remove_field"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>&nbsp;&nbsp;<span class="image_name" for="product_images"></span></div>'); //add input box
				}
			});
			
			//function to remove file input box
			$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
				e.preventDefault(); $(this).parent('div').remove(); x--;
			});
			

		});	
		

			
		
		//function for filename display for multiple file upload
		function getFilename(obj){
			var filename = $(obj).val().replace(/C:\\fakepath\\/i, '');
			$(obj).parent().parent().find('.image_name').html(filename);
		}
		
		//function filename display for multiple file upload
		function displayFilename(obj){
			var filename = $(obj).val().replace(/C:\\fakepath\\/i, '');
			$(obj).parent().parent().find('.image_name').html(filename);
		}
		
	
			
		//function to upload product Images to db
		function uploadProductImages() { 
		
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('upload_product_images'));
			
			var validate_url = $('#upload_product_images').attr('action');
			
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

						//$('input[type=file]').fieldValue('');
						//$("#portfolio_id").val('');
						
						//$("html, body").animate({ scrollTop: 0 }, "slow");					
						//$("#addImagesModal").modal('hide');
						$( "#load" ).hide();	
						
						$(".image_name").html('');
						
						$("#alert-msg").html(data.notif);
						$("#gallery-edit").html(data.image_group);
						$("#images_count").html(data.images_count);
						
						//window.location.reload(true);
						//setTimeout(function() { 
							//$("#alert-msg").hide(600);
						//	$('#alert-msg').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						//}, 5000);
						
						$(".image_name").html('');
						$(".upload-gallery").html('');
						
						$(".input_fields_wrap").html('<div class="form-group"><span class="btn btn-default btn-file">Choose Image <input type="file" name="product_images[]" onchange="getFilename(this)" id="product_images" multiple/></span><a href="#" class="remove_field"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>&nbsp;&nbsp;<span class="image_name" for="product_images"></span></div>'); 

					}else if(data.success == false){
						
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$("#errors").html(data.upload_error);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
					//location.reload();
				},
			});
			return false;
		}	
	
		
		//function to delete individual Product image
		function deleteProductImage(obj,pid,id,path) { 
			
			$(obj).parent().parent('div').remove(); 
			
			$("#alert-msg").html('');
			
			$( "#load" ).show();
			//var form = new FormData(document.getElementById('deleteUserForm'));
			var dataString = { 
				product_id : pid,
				id : id,
				path : path
			};
			
			//alert($("#id").val()+', '+$("#email").val()+', '+$("#user_model").val());
			
			$.ajax({
				type: "POST",
				url: baseurl+"admin/delete_product_images",
				data: dataString,
				//data: form,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){

					if(data.success == true){
						
						$("#alert-msg").html(data.notif);
						$("#gallery-edit").html(data.image_group);
						$("#images_count").html(data.images_count);
						//window.location.reload(true);
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('#alert-msg').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						
						$("#alert-msg").html(data.notif);
						
						setTimeout(function() { 
							$('#alert-msg').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}		
	
		//function to handle add Category
		function addProductCategory() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addProductCategoryForm'));

			var url = $('#addProductCategoryForm').attr('action');
			
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
						
						$("#addCategoryModal").modal('hide');
						
						$("#cName").val('');
						$("#cModel").val('');
						
						$( "#load" ).hide();  
						$("#notif").html(data.notif);
						$("#errors").html(data.upload_error);
						setTimeout(function() { 
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			return false;
		}	
		
		//function to edit product category details
		function editCategory(id,model) {
					
			$( "#load" ).show();
			
			var url = baseurl+"admin/female_category_details";
			
			if(model == 'male'){
				url = baseurl+"admin/male_category_details";
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
						document.updateProductCategoryForm.categoryID.value = data.id;
						
						$('#category_name').val(data.category_name);
						
						$('#categoryModel').val(data.model);
						
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
					
		//function to handle update Category
		function updateProductCategory() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateProductCategoryForm'));
			var url = $('#updateProductCategoryForm').attr('action');
			
			//var gender = $('#categoryModel').val();
			
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					$("#categoryID").val('');
					$("#category_name").val('');
					$("#categoryModel").val('');
							  
					if(data.success == true){
						
						$("#editCategoryModal").modal('hide');
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


	
			
		//function to handle add product option
		function addProductOption() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addProductOptionForm'));

			var url = $('#addProductOptionForm').attr('action');
			
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
						
						$("#addOptionModal").modal('hide');
						
						$("#product_id").val('0');
						$('#sze').val('0');
						$('#color').val('0');
						$('#quantity').val('');
						
						$( "#load" ).hide();  
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


		
		//function to edit product option details
		function editProductOption(id) {
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/product_option_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						document.updateProductOptionForm.optionID.value = data.id;
						$('#prodID').html(data.select_product_id);
						$('#size-select').html(data.select_size);
						$('#color-select').html(data.select_colour);
						$('#qty').val(data.quantity);
						
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
					
		//function to handle update Product Option
		function updateProductOption() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateProductOptionForm'));
			var url = $('#updateProductOptionForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					$("#optionID").val('');
					$("#pID").val('');
					$("#s_size").val('');
					$("#s_colour").val('');
					$("#qty").val('');
							  
					if(data.success == true){
						
						$("#editOptionModal").modal('hide');
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


	
	//function to handle update question
	function updateQuestion() { 
		
		$( "#load" ).show();
		
		var form = new FormData(document.getElementById('updateQuestionForm'));
		
		$.ajax({
			type: "POST",
			url: baseurl+"admin/update_question",
			data: form,
			cache : false,
			contentType: false,
			processData: false,
			
			success: function(data){

				if(data.success == true){

					$('input[name=edit_option_1_image]').fieldValue('');
					$('input[name=edit_option_2_image]').fieldValue('');
					$("#questionID").val('');
					$("#full_question").val('');
					
					$("#edit_option_1").val('');
					$("#edit_option_2").val('');
					$("#old_image_1").val('');
					$("#old_image_2").val('');		
											
					$("#editModal").modal('hide');
					$( "#load" ).hide();
					$("#notif").html(data.notif);
					$("#errors").html(data.upload_error);
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);

				}else if(data.success == false){
					$( "#load" ).hide();
					$("#notif").html(data.notif);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
			},
		});
	
	}		
		
//function to handle add question
	function addQuestion() { 

		var form = new FormData(document.getElementById('addQuestionForm'));
		var dataString = { 
			image_1 : $('input[name=image_1]').fieldValue(),
			image_2 : $('input[name=image_2]').fieldValue(),
			question : $("#question").val(),
			category : $("#category_dd").val(),
			option_1 : $("#option_1").val(),
			option_2 : $("#option_2").val()
		};
		var url = $('#addQuestionForm').attr('action');
		//var url = "admin/add_question";
		
		$.ajax({
			type: "POST",
			url: baseurl+url,
			//data: dataString,
			data: form,
			//dataType: "json",
			cache : false,
			contentType: false,
            processData: false,
			success: function(data){

				if(data.success == true){

					$('input[name=image_1]').fieldValue('');
					$('input[name=image_2]').fieldValue('');
					$("#question").val('');
					$("#category_dd").val('');
					$("#option_1").val('');
					$("#option_2").val('');
									
					$("#addQuestionModal").modal('hide');
					$( "#load" ).hide();
					//window.location.reload(true);		  
					$("#notif").html(data.notif);
					$("#errors").html(data.upload_error);
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);
					
					//$( ".question-tbody" ).append('<tr><td><input type"checkbox" name="cb[]" id="cb" value="'+data.id+'" checked="false"></td><td>'+data.id+'</td><td>'+data.question+'</td><td>'+data.option_1_image+'</td><td>'+data.option_1+'</td><td>'+data.option_2_image+'</td><td>'+data.option_2+'</td></tr>');
				  

				}else if(data.success == false){
					$( "#load" ).hide();		  
					//window.location.reload(true);
					//$("#alert-msg").html(data.errors);
					$("#alert-msg").html(data.notif);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
		return false;
	}	

		
//function to handle add security question
	function addSQuestion() { 
	
		$( "#load" ).show();
		
		var form = new FormData(document.getElementById('addSQuestionForm'));

		var url = $('#addSQuestionForm').attr('action');
		//var url = "admin/add_security_question";
		
		$.ajax({
			type: "POST",
			url: baseurl+url,
			//data: dataString,
			data: form,
			//dataType: "json",
			cache : false,
			contentType: false,
            processData: false,
			success: function(data){

				$("#question").val('');
				$("#option_1").val('');
				$("#option_2").val('');
				
				if(data.success == true){
					
					
					$("#addQuestionModal").modal('hide');
					$( "#load" ).hide();
					//window.location.reload(true);		  
					$("#notif").html(data.notif);
					$("#errors").html(data.upload_error);
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);

				}else if(data.success == false){
					$( "#load" ).hide();
					$("#alert-msg").html(data.notif);

				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
		return false;
	}	

	
	//function to handle update question
	function updateSQuestion() { 
		
		$( "#load" ).show();
		
		var form = new FormData(document.getElementById('updateSQuestionForm'));
		
		$.ajax({
			type: "POST",
			url: baseurl+"admin/update_security_question",
			data: form,
			//data: formData,
			cache : false,
			contentType: false,
			processData: false,
			
			success: function(data){

				$("#squestionID").val('');
				$("#full_squestion").val('');
				
				if(data.success == true){
					
					$("#editModal").modal('hide');
					$( "#load" ).hide();
					$("#notif").html(data.notif);
					$("#errors").html(data.upload_error);
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);

				}else if(data.success == false){
					$( "#load" ).hide();
					$("#notif").html(data.notif);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
			},
		});
	
	}		

	
	//function to handle update user
	function updateUser() { 
		
		$( "#load" ).show();
		
		var form = new FormData(document.getElementById('updateUserForm'));

		$.ajax({
			type: "POST",
			url: baseurl+"admin/update_user",
			data: form,
			//data: formData,
			cache : false,
			contentType: false,
			processData: false,
			
			success: function(data){

				if(data.success == true){

					$('input[name=uploadPhoto]').fieldValue('');
					$("#id").val('');
					$("#first_name").val('');
					$("#last_name").val('');
					$("#user_address").val('');
					$("#user_city").val('');
					$("#user_postcode").val('');
					$("#user_state").val('');
					$("#user_country").val('');
					$("#user_mobile").val('');
					$("#email_address").val('');
					$("#username_n").val('');
					$("#old_password").val('');
					$("#new_password").val('');
					$(".birthday").val('');
					$("#acct_bal").val('');
					$("#security_question").val('');
					$("#security_answer").val('');
					$("#tag_line").val('');
					$("#profile_description").val('');
					$("#totalRating").val('');
					$("#noOfRaters").val('');		  
						
					$("#editModal").modal('hide');
					$( "#load" ).hide();
					
					$("#notif").html(data.notif);
					$("#errors").html(data.upload_error);
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);

				}else if(data.success == false){
					$( "#load" ).hide();
					$("#notif").html(data.notif);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
			},
		});
	
	}
	
	
	
	
	//function to handle add user
	function addUser() { 

		var form = new FormData(document.getElementById('addUserForm'));

		$.ajax({
			type: "POST",
			url: baseurl+"admin/adduser",
			//data: dataString,
			data: form,
			//dataType: "json",
			cache : false,
			contentType: false,
            processData: false,
			success: function(data){

				
				if(data.success == true){
					
					$('input[name=newUserPhoto]').fieldValue('');
					$("#fName").val('');
					$("#lName").val('');
					$("#userAddress").val('');
					$("#userCity").val('');
					$("#userPostcode").val('');
					$("#userState").val('');
					$("#userCountry").val('');
					$("#userMobile").val('');
					$("#user_email").val('');
					$("#username").val('');
					$("#password").val('');
					$(".userBirthday").val('');
						
					$("#addUserModal").modal('hide');
					$( "#load" ).hide();
							  
					$("#notif").html(data.notif);
					$("#errors").html(data.upload_error);
					setTimeout(function() { 
						
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

	
	
	
	//function to handle user delete
	function deleteUser() { 
		
		$( "#load" ).show();
		//var form = new FormData(document.getElementById('deleteUserForm'));
		var dataString = { 
			id : $("#id").val(),
			email : $("#email").val(),
			model : $("#user_model").val()
		};
		
		//alert($("#id").val()+', '+$("#email").val()+', '+$("#user_model").val());
		
		$.ajax({
			type: "POST",
			url: baseurl+"admin/delete",
			data: dataString,
			//data: form,
			dataType: "json",
			cache : false,
			//contentType: false,
            //processData: false,
			success: function(data){

				$("#name").val('');
				$("#email").val('');
				$("#model").val('');

				if(data.success == true){
					
					$("#deleteModal").modal('hide');
			
					window.location.reload(true);		  
					//$("#notif").html(data.notif);
					setTimeout(function() { 
						$( "#load" ).hide(); 
						//window.location.reload(true);
					}, 2000);
				}else if(data.success == false){
					$( "#load" ).hide();
					$("#notif").html(data.notif);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
	
	}	


		
		$('.tags-input').tagsInput({
			  width: 'auto'
		});
					

	