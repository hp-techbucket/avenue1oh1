				
		
		$(document).ready(function() {

			var selected = $('#select-shipping-address').val();
			if(selected == 'new_address'){
				$('.textinput input').val('');
				$('select#shipping_country').val('0');
				$('select#shipping_state').val('0');
			}
			
			$('#select-shipping-address').on('change', function() {
				
				
				//alert(this.value);
				var value = this.value;
				var arr = '';
				var model = '';
				var id = '';
				var url = '';
				
				if(value == 'new_address'){
					$('.textinput input').val('');
					$('select#shipping_country').val('0');
					$('select#shipping_state').val('0');
					return;
					
				}else{
					arr = value.split("-");
					model = arr[0];
					id = arr[1];
					//alert('Model: '+ model +' ID:'+ id);
				}
				
				if(model == 'default_address'){
					url = baseurl+"account/default_address_details";
				}
				
				if(model == 'addresses'){
					url = baseurl+"account/address_details";
				}
				
				
				var dataString = { 
					id : this.value,
				};	
				
				//$('.states').find("option:eq(0)").html("Please wait..");
				
				
				$.ajax({
					
					type: "POST",
					url: url,
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							$( "#first_name" ).val(data.first_name);
							$( "#last_name" ).val(data.last_name);
							$( "#company" ).val(data.company_name);
							var address = data.address_line_1;
							if(data.address_line_2 != ''){
								address += ', '+ data.address_line_2;
							}
							$( "#shipping_address" ).val(address);
							$( "#shipping_city" ).val(data.city);
							$( "#shipping_zip" ).val(data.postcode);
							//$( "#shipping_state" ).val(data.state);
							$( "#shipping_state" ).html(data.select_states);
							//$( "#shipping_country" ).val(data.country_id);
							$( "#shipping_country" ).html(data.select_country);
							$( "#contact_phone" ).val(data.phone);
							
							
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
					
			//GET STATES BASED ON COUNTRY SELECTED
			$('#shipping_country').on('change', function() {
				
				//$('select').siblings("label").css('opacity','0');
				//$(this).siblings("label").addClass("invisible");
				//$(this).siblings("label").removeClass("float-to-top");
				//alert( this.value );
				
				//$('#shipping_state').html("Please wait..");
				//$('select[name=shipping_state] > option:contains(Select State)').html("Please wait..");
				$('select[name=shipping_state] > option:contains("Select State")').html('Please wait..');
				//$( "#load" ).show();
				
				var dataString = { 
					id : this.value
				};	
				
				//$('.states').find("option:eq(0)").html("Please wait..");
				
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"location/get_shipping_states",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							//$("#shipping_state").siblings("label").addClass("invisible");
							//$("#shipping_state").siblings("label").removeClass("float-to-top");
							setTimeout(function() { 
								$('#shipping_state').find("option:eq(0)").html("Select State");
								$("#shipping_state").html(data.options);
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
			
			
		
			//VALIDATE FORM
			$('#contact_information_form').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					first_name: {
						validators: {
							notEmpty: {
								message: 'Please enter a first name!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					last_name: {
						validators: {
							notEmpty: {
								message: 'Please enter a last name!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					checkout_email: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					},
					shipping_address: {
						validators: {
							notEmpty: {
								message: 'Please enter a street address!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					shipping_city: {
						validators: {
							notEmpty: {
								message: 'Please enter a City!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					shipping_zip: {
						validators: {
							notEmpty: {
								message: 'Please enter a Postal code!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					shipping_state: {
						validators: {
							notEmpty: {
								message: 'Please enter a State!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					shipping_country: {
						validators: {
							notEmpty: {
								message: 'Please enter a Country!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					}
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#contact_information_form").data('bootstrapValidator').resetForm();
					checkoutSubmit();
				}
			});
			
			
			
		});	
		
		function getStates() {
			alert( this.value );
		
		}
		
		//function to submit checkout information
		function checkoutSubmit() { 
		
			//var form_el = $('.main_content').find('input').closest('form');
			var form_id = $('.main_content').find('form').attr('id');
			//var form_id = form_el.attr('id');
			var form = new FormData(form_id);
			//var form = new FormData(document.getElementById('contact_information_form'));
			
			var validate_url = $('.main_content').find('form').attr('action');
			//var validate_url = $('#contact_information_form').attr('action');
			
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
						
						$( "#load" ).hide();
						//$("input").val('');
						
						var next_step = data.step;
						var previous_step = data.previous_step;
						var url = '';
						
						if(next_step == 'shipping_method'){
							url = baseurl+'checkout/shipping_method';
						}
						
						if(next_step == 'payment_method'){
							url = baseurl+'checkout/payment-method';
						}
						
						window.location.href = url;

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
	
		
		$('input.floatLabel').next().addClass('empty');
		$('select.floatLabel').next().addClass('empty');
		$("select.floatLabel").next().css('left','20px');
		
		$(function(){
   
			/*$(".floatLabel").bind("checkval",function(){
				var label = $(this).siblings("label");
				//var label = $(this).next();
				if(this.value !== ""){
					
				  label.addClass("float-to-top");
				  label.css('font-size','0.8em');
				  //$(this).css('padding-top','15px');
				} else {
				  label.removeClass("float-to-top");
				  label.css('font-size','1em');
				}
			}).on("keyup",function(){
				$(this).trigger("checkval");
			}).on("focus",function(){
			  }).trigger("checkval");
			
			*/
			  if ($(".textinput input").val() != "") {
					$(".textinput input").addClass('filled');
				  } else {
					$(".textinput input").removeClass('filled');
				}
			$(".textinput input").on('change keyup keypress',function() {
				if ($(this).val() != "") {
					$(this).addClass('filled');
				} else {
					$(this).removeClass('filled');
				}
			});
				
				
		});

		/*
		$('input.floatLabel').keyup(function () {
		  if ($(this).val().trim() !== '') {
			$(this).next().removeClass('empty');
			$(this).next().addClass('active');
		  } else {
			$(this).next().addClass('empty');
			$(this).next().removeClass('active');
		  }
		});
		
		function floatLabel(inputType){
			
			$(inputType).each(function(){
				var $this = $(this);
				var text_value = $(this).val();

				// on focus add class "active" to label
				$this.focus(function(){
					$this.next().addClass("active");
				});

				// on blur check field and remove class if needed
				$this.blur(function(){
					if($this.val() === '' || $this.val() === 'blank'){
						$this.next().removeClass();
						//$( "select" ).next().css('top','8px');
						 
					}
				});
						
				// Check input values on postback and add class "active" if value exists
				if(text_value!=''){
					$this.next().addClass("active");
					//$( "input" ).css('padding-top','15px');
					//$( "select" ).next().css('top','-2px');
					//$( "select" ).next().css('left','13px');
				}
			});
		
			// Automatically remove floatLabel class from select input on load
			//$( "select" ).next().removeClass();
			
		}
		// Add a class of "floatLabel" to the input field
		floatLabel(".floatLabel");
		*/
	
	
	