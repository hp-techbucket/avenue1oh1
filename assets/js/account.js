	
		//ACCOUNT DASHBOARD							
		$(document).ready(function() {
			
			$("#defaultAdd").val('default');
			$("#addressID").val('');
			
			//add active class to first child of menu
			$("ul.nav-account li:eq(0)").addClass("active");
			$("ul.nav-account li:eq(0)").addClass("arrow-box-right");
			
			$("ul.nav-account").on("click", "li", function(e) {
				e.preventDefault();
				
				if(!$(this).is(':last-child')){
					
					$(".nav-account li").removeClass('active');
					$(".nav-account li").removeClass('arrow-box-right');
				
					$(this).addClass('active');	
					$(this).addClass('arrow-box-right');
				}
				
				
					
			});
			
			//$("ul.nav-stacked").not(".nav-account").on("click", "li", function(e) 
			$("ul.nav-stacked").on("click", "li", function(e) {
				e.preventDefault();
				//$("ul.nav-stacked:not(.nav-account) li").removeClass('active');
				//$("ul.nav-stacked:not(.nav-account) li").removeClass('arrow-box-right');
				
				$(".nav-stacked li").removeClass('active');
				$(".nav-stacked li").removeClass('arrow-box-right');
				
				//$(this).addClass('active');	
				//$(this).addClass('arrow-box-right');
				
				if(!$(this).hasClass('menu-link')){
					
					$(this).addClass('active');	
					$(this).addClass('arrow-box-right');
				}
			});
			
			$("ul.nav-stacked").on("hover", "li", function(e) {
				e.preventDefault();
				//$("ul.nav-stacked:not(.nav-account) li").removeClass('active');
				//$("ul.nav-stacked:not(.nav-account) li").removeClass('arrow-box-right');
				
				//$(this).addClass('active');	
				//$(this).addClass('arrow-box-right');
				
				if(!$(this).hasClass('menu-link')){
					
					$(".nav-account li").removeClass('active');
					$(".nav-account li").removeClass('arrow-box-right');
				
					$(this).addClass('active');	
					$(this).addClass('arrow-box-right');
				}
			});
			
			$("#edit-address").click(function (e) {
				
				e.preventDefault();
				$('.verify-password').hide();
				$('.add-address-form').slideToggle(600);	
			});
					
			$(".add-address-tab").click(function (e) {
				
				e.preventDefault();
				
				$("#defaultAdd").val('');
				$('button.btn-1').html('<i class="fa fa-angle-right" aria-hidden="true"></i> ADD ADDRESS');
				$('#address_default').attr('checked', false);
				//clear address form
				$("#addressID").val('');
				$('#first_name').val('');
				//$('input').val('');
				//$("#first_name").val('');
				$("#last_name").val('');
				$("#company_name").val('');
				$("#phone").val('');
				$("#address_line_1").val('');
				$("#address_line_2").val('');
				$("#city").val('');
				$("#postcode").val('');
				$("#country").val('');
				$('[name=country]').val('0');
				$('[name=state]').val('');
				$("#state").val('');
				$('.states').html('<option value="0" selected="selected">Select State</option>');
				$('.default-address').hide();
				$('.verify-password').hide();
				//$('.add-address-form').slideToggle(600);	
				
				$('.add-address-form').show(300);
				
			});
			
			 
			$(document).on('click', '.add-address-link', function (e) {
				//e.stopPropagation();
				e.preventDefault();
				//$("#addressID").val('');
				//$("#defaultAdd").val('');
				$('.verify-password').hide();
				$('.add-address-form').slideToggle(600);	
			});
			
			
			$(".change-password-tab").click(function (e) {
					
				e.preventDefault();
				$('.default-address').hide();
				$('.add-address-form').hide();
				$('.verify-password').slideToggle(600);	
				
			});
			
			$(".orders-tab").click(function (e) { 
				
				e.preventDefault();
				$('#transactions').hide();
				$('#order-history').slideToggle(600);	
			});
			
			$(".transactions-tab").click(function (e) {
					
				e.preventDefault();
				$('#order-history').hide();
				$('#transactions').slideToggle(600);	
			});
			
			
			//$(document).on('change', '#country', function (e) {
					
			//});
			
			$('#country').on('change', function() {
				
				//alert( this.value );
				
				//$( "#load" ).show();
				
				var dataString = { 
					id : this.value
				};	
				
				//$('.states').find("option:eq(0)").html("Please wait..");
				
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"location/get_states",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							$('.states').html('<option value="0" selected="selected">Please wait..</option>');
							setTimeout(function() { 
								$(".states").html(data.options);
							}, 600);
				
							
						}else{
							$( "#load" ).hide();
							$("#errors").html('Errors!');
						}   
										  
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
					},

				});		
			});													
			
			$('#address_default').click(function() {
				if ($(this).is(":checked")){
					// it is checked
					$(this).val('1');
				}else{
					$(this).val('0');
				}
			});
			

	
		});
		
		
		
				 		
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
				url: baseurl+"account/order_details",
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
		
			
  		//function to toggleAddressForm
		function toggleAddressForm() {
		
			$('.default-address').hide();
			
			$('.add-address-form').hide();
			$('.verify-password').hide();
			$('html, body').animate({
				scrollTop: $(".collection-banner-text").offset().top
			}, 2000);				
		} 		
			
  		//function to get default user details
		function defaultUserDetails() {
			
			$("#defaultAdd").val('default');
			$("#addressID").val('');
			$('button.btn-1').html('<i class="fa fa-angle-right" aria-hidden="true"></i> UPDATE ADDRESS');
			
			$('.address_default').attr('checked', true);	
			
			$('.default-address').show();
			
			$('.add-address-form').hide();
			$('.verify-password').hide();
			
			//alert(m);
			var dataString = { 
				email : $("#email").val()
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"account/user_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						
						var fname = ucwords(data.first_name);
						var lname = ucwords(data.last_name);
						
						$("#user-name").html(fname+' '+lname+' (Default)');
						var address_line_2 = '';
						var address = '<a href="#" class="add-address-link">Add Address</a>';
						
						if(data.address_line_2 != ''){
							address_line_2 = data.address_line_2+'<br/>';
						}
						
						if(data.address_line_1 != ''){
							address = data.address_line_1+'<br/> '+address_line_2+' '+data.city+', '+data.state+', '+data.country+'<br/> '+data.postcode;
						}
						
						$("#user-address").html(address);
						
						$("#user-phone").html(data.phone);
						
						$('.default-address').show();
						$('#delete-button').hide();
						
						$("#first_name").val(data.first_name);
						$("#last_name").val(data.last_name);
						$("#company_name").val(data.company_name);
						$("#phone").val(data.phone);
						$("#address_line_1").val(data.address_line_1);
						$("#address_line_2").val(data.address_line_2);
						$("#city").val(data.city);
						$("#postcode").val(data.postcode);
						//$("#country").val(data.country);
						$('[name=country]').val(data.country_id);
						$("#state").val(data.state);
						$('.states').html(data.select_states);
						
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
			
  		//function to get default address
		function getDefaultAddress(id) {
			
			$("#defaultAdd").val('default');
			$("#addressID").val('');
			$('button.btn-1').html('<i class="fa fa-angle-right" aria-hidden="true"></i> UPDATE ADDRESS');
			
			$('.address_default').prop('checked', true);	
			
			$('.default-address').show();
			
			$('.add-address-form').hide();
			$('.verify-password').hide();
			
			//alert(m);
			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"account/default_address_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						
						var fname = ucwords(data.first_name);
						var lname = ucwords(data.last_name);
						
						$("#user-name").html(fname+' '+lname+' (Default)');
						var address_line_2 = '';
						var address = '<a href="#" class="add-address-link">Add Address</a>';
						
						if(data.address_line_2 != ''){
							address_line_2 = data.address_line_2+'<br/>';
						}
						
						if(data.address_line_1 != ''){
							address = data.address_line_1+'<br/> '+address_line_2+' '+data.city+', '+data.state+', '+data.country+'<br/> '+data.postcode;
						}
						
						$("#user-address").html(address);
						
						$("#user-phone").html(data.phone);
						
						$('.default-address').show();
						$('#delete-button').hide();
						
						$("#first_name").val(data.first_name);
						$("#last_name").val(data.last_name);
						$("#company_name").val(data.company_name);
						$("#phone").val(data.phone);
						$("#address_line_1").val(data.address_line_1);
						$("#address_line_2").val(data.address_line_2);
						$("#city").val(data.city);
						$("#postcode").val(data.postcode);
						//$("#country").val(data.country);
						$('[name=country]').val(data.country_id);
						$("#state").val(data.state);
						$('.states').html(data.select_states);
						
						$('.address_default').prop('checked', true);
						
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
				
		
  		//function to get default address details
		function getAddressDetails(id) {
			
			$("#defaultAdd").val('');
			$("#addressID").val('');
			$('button.btn-1').html('<i class="fa fa-angle-right" aria-hidden="true"></i> UPDATE ADDRESS');
			
			$('#address_default').attr('checked', false);
			
			$('.default-address').show();
			
			$('.add-address-form').hide();
			$('.verify-password').hide();
			
			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"account/address_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						
						var fname = ucwords(data.first_name);
						var lname = ucwords(data.last_name);
						
						if(data.default_set == true){
							$("#user-name").html(fname+' '+lname);
						}else{
							$("#user-name").html(fname+' '+lname+' (Default)');
						}
						
						var address_line_2 = '';
						var address = '<a href="#" class="add-address-link">Add Address</a>';
						
						if(data.address_line_2 != ''){
							address_line_2 = data.address_line_2+'<br/>';
						}
						
						if(data.address_line_1 != ''){
							address = data.address_line_1+'<br/> '+address_line_2+' '+data.city+', '+data.state+', '+data.country+'<br/> '+data.postcode;
						}
						
						$("#user-address").html(address);
						
						$("#user-phone").html(data.phone);
						
						$('#delete-button').show();
						
						//add/edit form
						$("#first_name").val(data.first_name);
						$("#last_name").val(data.last_name);
						$("#company_name").val(data.company_name);
						$("#phone").val(data.phone);
						$("#address_line_1").val(data.address_line_1);
						$("#address_line_2").val(data.address_line_2);
						$("#city").val(data.city);
						$("#postcode").val(data.postcode);
						//$("#country").val(data.country);
						$('[name=country]').val(data.country_id);
						$("#state").val(data.state);
						$('.states').html(data.select_states);
						
						if(data.id == id){
							$("#addressID").val(data.id);
						}
						
						//alert('Address ID: '+$("#addressID").val());
						
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
		
						
		
  		//function to get delete address
		function submitAddress() {
			
			//$('.add-address-form').hide();
			//alert(m);
			var d = $("#defaultAdd").val().trim();
			var addressID = $("#addressID").val().trim();
			
			//alert($('#address_default').val());
			
			
			//if ($('#address_default').is(":checked")){
					// it is checked
				//	$(this).val('1');
			//}else{
				//	$(this).val('0');
			//}
			
			//alert('Default: '+d+'; Address ID: '+addressID);
			
			
			var form = new FormData(document.getElementById('addAddressForm'));
			
			var url;
			
			if(d == 'default'){
				url = baseurl+'account/update-address';
			}
			
			if(addressID != ''){
				url = baseurl+'account/update-address';
			}
			if(d == '' && addressID == ''){
				url = $('#addAddressForm').attr('action');
			}
			
			//alert('URL: '+url);
			
			
			$.ajax({
				type: "POST",
				url: url,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					if(data.success == true){
						$('html, body').animate({
							scrollTop: $(".collection-banner-text").offset().top
						}, 2000);	
						$(".floating-alert-box").html(data.notif);
						
						setTimeout(function() { 
							$(".floating-alert-box").fadeOut("slow");
							//$(".floating-alert-box").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else{
						$( "#load" ).hide();
						$(".form-errors").html(data.notif);
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});	
				
		} 	
		
		
  		//function to get delete secondary address
		function deleteAdd() {
			
			alert($("#addressID").val());
			
			var add_id = $("#addressID").val();
			
			//post
			var dataString = { 
				id : add_id
			};				
			
			$.ajax({
				
				type: "POST",
				url: baseurl+"account/address_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						
						if(data.id == add_id){
							$("#addID").val(data.id);
							var fname = ucwords(data.first_name);
							var lname = ucwords(data.last_name);
						
							$("#address-name").html(fname+' '+lname);
						}
						
						
					}else{
						$( "#load" ).hide();
						$(".floating-alert-box").html('Error');
						setTimeout(function() { 
							$(".floating-alert-box").fadeOut("slow");
						}, 2000); 
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});				
		} 	
				
		
  		//function to get delete address
		function deleteAddress() {
			
			//$('.add-address-form').hide();
			//alert(m);
			
			var url = $('#deleteAddressForm').attr('action');
			
			var dataString = { 
				id : $("#addID").val()
			};				
			$.ajax({
				
				type: "POST",
				url: url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$(".floating-alert-box").html(data.notif);
						
						setTimeout(function() { 
							//$(".floating-alert-box").slideUp({ opacity: "hide" }, "slow");
							$(".floating-alert-box").fadeOut("slow");
							window.location.reload(true);
						}, 2000); 
						
					}else{
						$( "#load" ).hide();
						$('html, body').animate({
							scrollTop: $(".collection-banner-text").offset().top
						}, 2000);	
						$(".floating-alert-box").html(data.notif);
						setTimeout(function() { 
							$(".floating-alert-box").fadeOut("slow");
						}, 2000);
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		} 	

				
				
		
		$(document).ready(function() {
						
			//VERIFY PASSWORD SUBMIT VALIDATION
			$('#verifyPasswordForm').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					current_password: {
						validators: {
							notEmpty: {
								message: 'Please enter your current password!'
							}
						}
					}
					
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#verifyPasswordForm").data('bootstrapValidator').resetForm();
					verifyPassword();
				}
			});
			
					
			//VERIFY NEW PASSWORD SUBMIT VALIDATION
			$('#changePasswordForm').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					new_password: {
						validators: {
							notEmpty: {
								message: 'Please enter a new password!'
							}
						}
					},
					confirm_password: {
						validators: {
							notEmpty: {
								message: 'Please confirm your new password'
							},
							identical: {
								field: 'new_password',
								message: 'Passwords do not match'
							}
						}
					}
					
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#changePasswordForm").data('bootstrapValidator').resetForm();
					changePassword();
				}
			});
			
		
		});	
				
  		//function to verify user password
		function verifyPassword() {
			
			$(".form-errors").html('');
			
			var validate_url = $('#verifyPasswordForm').attr('action');
			
			var dataString = { 
				current_password : $("#current_password").val()
			};
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				//data: form,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){

					if(data.success == true){
						$("#current_password").val('');
						$(".verify-password").hide(300);
						$(".password-change").show(300);
					}else{
						$( "#load" ).hide();
						//$(".form-errors").html('Errors!');
						$('html, body').animate({
							scrollTop: $(".collection-banner-text").offset().top
						}, 2000);	
						$(".form-errors").html(data.notif);
						
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		

		
  		//function to change user password
		function changePassword() {
			
			$(".form-errors").html('');
			
			var validate_url = $('#changePasswordForm').attr('action');
			
			var form = new FormData(document.getElementById('changePasswordForm'));
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					if(data.success == true){
						$(".password-change").hide(300);
						$("#new_password").val('');
						$("#confirm_password").val('');
						//$(".verify-password").hide(300);
						$(".password-notif").html(data.notif);
						
						setTimeout(function() { 
							$(".password-notif").slideUp({ opacity: "hide" }, "slow");
							window.location.href = baseurl+'account/logout';
						}, 5000); 
						
					}else{
						$( "#load" ).hide();
						//$(".form-errors").html('Errors!');
						$('html, body').animate({
							scrollTop: $(".collection-banner-text").offset().top
						}, 2000);	
						$(".form-errors").html(data.notif);
						
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}

			
		
		function ucwords(str){
			//var word = str.toLowerCase().replace(/\b[a-z]/g);
			//return word.toUpperCase();
			//return (str + '').toLowerCase().replace(/\b[a-z]/g, function (letter) {
			//	return letter.toUpperCase();
			//});
			return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
				return $1.toUpperCase();
			});
		}
		
		function capitalizeFirstLetter(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		}
		
		function capitalize(str) {
			strVal = '';
			str = str.split(' ');
			for (var chr = 0; chr < str.length; chr++) {
				strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
			}
			return strVal
		}
		
		
		
		


		
	