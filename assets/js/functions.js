	

		/*function stickIt() {
			
			 var orgElementPos = $('.original').offset();
			  orgElementTop = orgElementPos.top;               

			if ($(window).scrollTop() >= (orgElementTop)) {
				// scrolled past the original position; now only show the cloned, sticky element.

				// Cloned element should always have same left position and width as original element.     
				orgElement = $('.original');
				coordsOrgElement = orgElement.offset();
				leftOrgElement = coordsOrgElement.left;  
				widthOrgElement = orgElement.css('width');
				$('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
				//$('.cloned').find('.navbar-info').hide();
				//alert('Clone');
				$('.original').css('visibility','hidden');
			} else {
				// not scrolled past the menu; only show the original menu.
				//$('.cloned').hide();
				//$('.navbar-info').show();
				alert('Original');
				//$('.original').find('.navbar-info').css('visibility','visible');
				$('.original').css('visibility','visible');
			}
		}*/
		
		$(document).ready(function() {
		
			//Initialize Select2 Elements
			$(".select2").select2();
			
			   //Date picker
				$('.datepicker').datepicker({
				  autoclose: true,
				  format: 'yyyy-mm-dd'
				});

			
		});

				
		//disable delete button
		$('#deleteButton').attr('disabled', 'disabled');
			
		//checkbox function
		$('#checkBox').click(function() {
			//check all checkboxes and enable delete button
			if ($(this).is(':checked')) {
				$('#deleteButton').removeAttr('disabled');
				$("input:checkbox").prop('checked', $(this).prop("checked"));
			//	$('#cb').each(function() { //loop through each checkbox
			//		this.checked = true;  //select all checkboxes with class "cb"               
			//	});
			} else {
				$('#deleteButton').attr('disabled', 'disabled');
				$("input:checkbox").prop('checked', false);
			//$('#cb').each(function() { //loop through each checkbox
			//	this.checked = false; //deselect all checkboxes with class "cb"                       
				//
				//}); 
			}
		});		 
		
		//function to enable delete button
		//once checkbox is checked
		function enableButton(obj){
			if ($(obj).is(':checked')) {
				$('#deleteButton').removeAttr('disabled');
			} else {
				$('#deleteButton').attr('disabled', 'disabled');
			}
		}
		
	
		//function to handle multi delete
		function multiDelete() { 
			
			$( "#load" ).show();
			
			var $item = $('#multi_delete_form').find('input[name="cb[]"]');
			
			if(!$item.is(':checked')){
				$("#multiDeleteModal").modal('hide');
				$(".notif").html('Please select an item');
			}
			
			var form = new FormData($('#multi_delete_form').get(0));

			var form_url = $('#multi_delete_form').attr('action');
			
			$.ajax({
				type: "POST",
				url: form_url,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					if(data.success == true){
						
						$("#multiDeleteModal").modal('hide');  
						$(".notif").html(data.notif);
						
						//remove deleted rows dynamically
						$('table tr').has('input[name="cb[]"]:checked').remove();
						
						//get the number of deleted rows
						var deleted_count = data.deleted_count;
						
						//old number of rows displayed
						var old_count = $("#record-count").html();
						
						//substract deleted from old number
						var new_count = old_count - deleted_count;
						
						//change value displayed
						$("#record-count").html(new_count);
						
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$("#load").hide();
						$(".notif").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$("#load").hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}



		$(document).ready(function() {	
		
		
			//INITIALISE TOOLTIP 
			$('[data-toggle="tooltip"]').tooltip();   
						
			/* 
			* Function for scroll to top button
			*/	
			var amountScrolled = 300;

			$(window).scroll(function() {
				if ( $(window).scrollTop() > amountScrolled ) {
					$('#scroll-top').fadeIn('slow');
				} else {
					$('#scroll-top').fadeOut('slow');
				}
			});
			
			//SCROLL TO TOP BUTTON
			$('#scroll-top').click(function() {
				$('html, body').animate({
					scrollTop: 0
				}, 700);
				return false;
			});
			
			//SCROLL TO DOWN BUTTON FOR MOBILE DEVICES
			$("#go-to-menu").click(function() {
				$('html, body').animate({
					scrollTop: $("#footer-menu").offset().top
				}, 2000);
			});


		});	
		
		$(document).ready(function() {	
					
				
			//show and hide search box	
			$(".search-icon").click(function (e) { 
				
				//alert('Search');		
					
				$('.search-box').slideToggle(600);
				$(".search-input").focus();
				
				
				var $this = $(this);
				if (!$this.hasClass('active')) {
					$this.addClass('active');
				}
				//$("html, body").animate({
				//	scrollTop: $(".search-box").offset().top
				//}, 600);
				
				e.preventDefault();
								
			});
				

			//close profile box	
			$(".close-search-box").click(function (e) { 
				e.preventDefault();
				$('.search-box').slideUp(600);	
							
			});

	
		});	
	
	
	//function to handle submit contact us form
	function contactUsMessage() { 
	
		var error = '';
		var isFormValid = true; 
		$( "#load" ).show();
		
		//validate form before submit
		$("input[type=text],input[type=tel],textarea").each(function() {

			if ($(this).val().trim() === '') {
			        	
				$(this).css('border-color','red');     
			    error = '<p>All fields must be filled!</p>';
			    isFormValid = false;
				
			}else{
				$(this).css('border-color','#B2B2B2');
			}
		});
		
		if(!isFormValid){
				$(".error-message").show();
				$(".error-message").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-exclamation-triangle"></i> The form has errors!');
				$(".error-message").append('<br/>');
				$(".error-message").append(error);
				$( "#load" ).hide();
				return isFormValid;
		} 
		

		var dataString = { 
			contact_us_name : $("#contact_us_name").val(),
			contact_us_telephone : $("#contact_us_telephone").val(),
			contact_us_email : $("#contact_us_email").val(),
			contact_us_subject : $("#contact_us_subject").val(),
			contact_us_message : $("#contact_us_message").val()
		};
		
		$.ajax({
			type: "POST",
			url: baseurl+"main/contact_us_validation",
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){

				
				
				if(data.success == true){
					
					$("#contact_us_name").val('');
					$("#contact_us_telephone").val('');
					$("#contact_us_email").val('');
					$("#contact_us_subject").val('');
					$("#contact_us_message").val('');
					$( "#load" ).hide();
					
					$("#response-message").html(data.notif);
					
				}else if(data.success == false){
					$( "#load" ).hide();
					$(".error-message").hide();
					$("#response-message").html(data.notif);
					//$("#response-errors").html(data.errors);
					$("#response-message").append(data.errors);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
	
	}	

	
	function commaSeparateNumber(val){
		while (/(\d+)(\d{3})/.test(val.toString())){
			val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
		}
		return val;
	}	
	
	function allowNumbersOnly(e) {
			//$('.depositNote').text('Please enter a deposit more than $10.00');
		  var charCode = (e.which) ? e.which : e.keyCode;
		  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			e.preventDefault();
		  }
	}			
			
	
		function getLabel(id) { 
			var label = $('label[for="'+id+'"]');

				if(label.length <= 0) {
				    var parentElem = $(this).parent(),
				        parentTagName = parentElem.get(0).tagName.toLowerCase();
				
				    if(parentTagName == "label") {
				        label = parentElem;
				    }
				}
			return label;
		}
		
		
		//validate credit card
		function validateCard() { 
			$(this).validateCreditCard(function(result){
			
				$('.error-message').empty();
				var label = $('label[for="'+$(this).attr('id')+'"]');

				if(label.length <= 0) {
				    var parentElem = $(this).parent(),
				        parentTagName = parentElem.get(0).tagName.toLowerCase();
				
				    if(parentTagName == "label") {
				        label = parentElem;
				    }
				}
				label.find('.fa').remove();
				if(result.card_type == null || result.valid == false || result.length_valid == false || result.luhn_valid == false){
					$('.log').hide(600);
					$('.error-message').show(600);
					$('.error-message').append('<p> <i class="fa fa-exclamation-triangle"></i> Please enter a valid card number!</p>');	
					$(this).css('border-color','#ff0000');
					label.find('.fa').remove();
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					//$(this).css({"border-color": "#ff0000", "border-width": "2px"});
					$('label[for="card_type"]').find('.fa').remove();
					$('label[for="card_type"]').append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					return false;
				}else{
					//change border color
					$(this).css('border-color','#00802b');
					//$(this).css({"border-color": "#00802b", "border-width": "2px"});
					//label.append(' <span style="color:#00802b"><i class="fa fa-check-circle"></i></span>');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
					
					
					$('.img').addClass('opacity'); //add opacity to the non-selected cc icons
					var type = result.card_type.name;
					
					$('.'+type).removeClass('opacity');//remove opacity from the selected cc icon
					
					$('[name=card_types]').val(type);
					$('#card_type').val(type);
					
					if(type == 'diners_club_carte_blanche' || type == 'diners_club_international' ){
						$('.diners').removeClass('opacity');
						//$("#cc_type").val(type);
						$('[name=card_types]').val('diners');
						$('#card_type').val('diners');
					}
					if(type == 'visa_electron'){
						$('.visa').removeClass('opacity');
						//$("#cc_type").val(type);
						$('[name=card_types]').val('visa');
						$('#card_type').val('visa');
					}
					$('[name=card_types]').css('border-color','#00802b');
					$('label[for="card_type"]').find('.fa').remove();
					$('label[for="card_type"]').append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
					$('.error-message').hide(600);
					$('.log').html('<div class="alert alert-success alert-dismissable text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> The credit card is valid! <strong>Type:</strong> '+type+'</div>');	
					
						
					
				}	
			});		

		}
	
	
	//function to handle add PayPal
	function addPayPal() { 

		var form = new FormData(document.getElementById('addpaypalForm'));
		var dataString = { 
			paypal_email : $("#paypal_email").val(),
		};
		
		$.ajax({
			type: "POST",
			url: baseurl+"payment/add_paypal",
			data: dataString,
			dataType: "json",
			success: function(data){

				//$("#addUserModal").modal('hide');
				
				$("#paypal_email").val('');
				
				if(data.success == true){
				
					//$(".addPayPalDiv").hide();
					
					$('.addPayPalDiv').addClass('addDiv');
					$('.addPayPalDiv').removeClass('addPayPalDiv');
					
					//window.location.reload(true);	
					$( "#load" ).hide();
					$("#notif").html(data.notif);
					$("#success").html(data.notif);
					
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000); 
					//window.location.reload(true);
			
				}else if(data.success == false){
					$( "#load" ).hide();
					$("#success").html(data.notif);
					$("#paypal_email").val(data.paypal_email);
					$("#paypal_email").addClass('inputError');
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert('Error: ' + status + ' ' + error);
			},
		});
		return false;
	}	

	//function to handle Paypal Deposit
	function paypalDeposit() {
		/*var isFormValid = true;
		
		$("input[type=text],input[type=password]").each(function () {
			if ($.trim($(this).val()).length == 0){
				$(this).css('border-color','red');
				isFormValid = false;
			}else{
				$(this).css('border-color','#B2B2B2');
			}
		});
		if(!isFormValid){
			$(".form_errors").html('<div class="alert alert-danger text-center"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please fill in all the required fields!</div>');
			$( "#load" ).hide();
			return isFormValid;
		}*/
		var url = $('#paypalDepositForm').attr('action');
		var form = new FormData(document.getElementById('paypalDepositForm'));

		$.ajax({
			type: "POST",
			url: baseurl+url,
			data: form,
			cache : false,
			contentType: false,
            processData: false,
			success: function(data){

				$(".newDeposit").val('');
				$("#paypal_id").val('');
				
				$("#paypaldepositModal").modal('hide'); 
				$( "#load" ).hide();
				
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
		return false;
	}	


	
	//function to handle edit paypal
	function editPayPal() { 
		
		$( "#load" ).show();
		
		var url = $('#editPayPalForm').attr('action');
		var form = new FormData(document.getElementById('editPayPalForm'));
		
		var dataString = { 
			id : $("#paypalID").val(),
			paypal_email : $("#masked_paypal_email").val(),
		};
		
		$.ajax({
			type: "POST",
			url: baseurl+'payment/update_paypal',
			//data: form,
			data: dataString,
			dataType: "json",
			success: function(data){
				
				$("#editPayPalModal").modal('hide');
				
				$("#masked_paypal_email").val('');
				$("#paypalID").val('');

				if(data.success == true){
					
					$( "#load" ).hide();		  
					$("#notif").html(data.notif);

					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);

				}else if(data.success == false){
					$( "#load" ).hide();		  
					$("#alert-message").html(data.notif);
					setTimeout(function() {  
						window.location.reload(true);
					}, 2000);
					//window.location.reload(true);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
			},
		});
	
	}	
	
	
	//function to remove PayPal
	function removePayPal() { 
		
		$( "#load" ).show();
		var dataString = { 
			id : $("#paypID").val(),
			model : 'paypal_payment_methods'
		};

		$.ajax({
			type: "POST",
			url: baseurl+"payment/remove",
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){

				
				$("#removePayPalModal").modal('hide');

				$("#paypID").val('');
				$("#model").val('');

				if(data.success == true){
					$( "#load" ).hide();
					$("#notif").html(data.notif); 
							  
					setTimeout(function() { 
						window.location.reload(true);
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
		

	//function to handle card Deposit
	function cardDeposit() {

			//var form = new FormData(document.getElementById('cardDepositForm'));
			var url = $('#cardDepositForm').attr('action');
			
			var dataString = { 
				
				card_number : $('#card_number').val(),
				id : $('#card_id').val(),
				cvc : $('#cvc_card').val(),
				deposit_amount : $('.depositAmount').val(),
			};	
						
			$.ajax({
				type: "POST",
				url: baseurl+url,
				data: dataString,
				//data: form,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$(".card_errors").html('<div class="alert alert-success text-center"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Deposit successfully!</div>');
						$("#deposit-success").html(data.notif);
						//alert($(".depositAmount").val());
						$("#card_id").val('');
						$("#card_name").val('');
						$("#card_number").val('');
						$("#expiry_m").val('');
						$("#expiry_y").val('');
						$("#card_cvc").val('');
						$(".depositAmount").val('');
					
						$("#carddepositModal").modal('hide');
						
						$( "#load" ).hide();	
						$("#deposit-success").html(data.notif);
						
						setTimeout(function() { 
							window.location.reload(true);
						}, 2000);
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".card_errors").html(data.notif);
					}else{
						$( "#load" ).hide();
						$(".card_errors").html('<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Unknown errors!</div>');
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					 alert('Error: ' + status + ' ' + error);
					//alert(error);
					//location.reload();
				},
		});
		return false;
	}	

	
	//function to handle add Credit Card
	function addCreditCard() { 
		
		
		var url = $('#addCreditCardForm').attr('action');
		
		var city = $.trim($(".cities").val());
		
		if(city.length == 0){
			city = $.trim($("#billing_city").val());
		}
			
		var dataString = { 
			card_type : $("#card_type").val(),
			name_on_card : $("#name_on_card").val(),
			card_number : $("#card_number").val(),
			expiry_month : $("#expiry_month").val(),
			expiry_year : $("#expiry_year").val(),
			card_billing_street_address : $("#card_billing_street_address").val(),
			card_billing_city : city,
			card_billing_postcode : $("#card_billing_postcode").val(),
			card_billing_state : $(".states").val(),
			card_billing_country : $("#country_id").val(),
		};

		$.ajax({
			type: "POST",
			url: baseurl+'payment/add_credit_card',
			data: dataString,
			dataType: "json",
			success: function(data){
				
				
				
				//$("#addUserModal").modal('hide');

				if(data.success == true){
				
					$("#name_on_card").val('');
					$("#card_number").val('');
					$("#expiry_month").val('');
					$("#expiry_year").val('');
					$("#card_billing_street_address").val('');
					$("#billing_city").val('');
					$(".cities").val('');
					$("#card_billing_postcode").val('');
					$(".states").val('');
					$("#country_id").val('');
					
					//$(".addCCDiv").hide();
					$('.addCCDiv').addClass('addDiv');
					$('.addCCDiv').removeClass('addCCDiv');
					$( "#load" ).hide();
					
					//window.location.reload(true);		  
					$("#notif").html(data.notif);
					$("#success").html(data.notif);
					
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000); 
					
				}else if(data.success == false){
					$( "#load" ).hide();
					$("#success").html(data.notif);
					//$("#").addClass('inputError');
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				// alert('Error: ' + status + ' ' + error);
			},
		});
		return false;
	}	

	
	//function to handle edit card
	function editCard() { 
		
		$( "#load" ).show();
		
		var masked_card = $('#cardNo').val();
		var card_no = $('#card_n').val();
		var new_card;
		var type;
		//var isFormValid = true;
		
		if(masked_card.substr(masked_card.length - 4) != card_no.substr(card_no.length - 4)){
			var result = $('#cardNo').validateCreditCard();
			if(result.card_type == null || result.valid == false || result.length_valid == false || result.luhn_valid == false){
				$('.log').html('<div class="alert alert-error text-center" role="alert"> <i class="fa fa-exclamation-triangle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a valid credit card number!</div>');
				$( "#load" ).hide();
				return false;		
			}else{
				type = result.card_type.name;
				
			}
		}else{
			card_no = $('#cardNo').val();
		}
		
		//if(result.card_type.name != null){
		//	$('.log').html('<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+ result.card_type.name +'</div>');
		//}
		
	//	if(!isFormValid){
	//		$(".form_errors").html('<div class="alert alert-danger text-center"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please fill in all the required fields!</div>');
		//	$( "#load" ).hide();
		//	return isFormValid;
	//	}
		var url = $('#editCardForm').attr('action');
		//var form = new FormData(document.getElementById('editCardForm'));
		var dataString = { 
			id : $("#cardID").val(),
			name_on_card : $("#name_on_card").val(),
			card_number : card_no,
			expiry_month : $("#expiry_month").val(),
			expiry_year : $("#expiry_year").val(),
			card_billing_street_address : $("#card_billing_street_address").val(),
			card_billing_city : $("#card_billing_city").val(),
			card_billing_postcode : $("#card_billing_postcode").val(),
			card_billing_state : $("#card_billing_state").val(),
			card_billing_country : $("#card_billing_country").val(),
		};
		$.ajax({
			type: "POST",
			url: baseurl+url,
			data: dataString,
			//data: form,
			dataType: "json",
			cache : false,
			//contentType: false,
			//processData: false,
			success: function(data){

				
				
				$("#editcardModal").modal('hide');
				
				$("#cardNo").val('');
				$("#cardID").val('');
				$("#cardName").val('');
				$("#card_billing_street_address").val('');
				$("#card_billing_city").val('');
				$("#card_billing_postcode").val('');
				$("#card_billing_state").val('');
				$("#card_billing_country").val('');

				if(data.success == true){
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
				
	
	//function to remove card
	function removeCard() { 
		
		$( "#load" ).show();
		var dataString = { 
			id : $("#cdID").val(),
			model : 'card_payment_methods'
		};

		$.ajax({
			type: "POST",
			url: baseurl+"payment/remove",
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){

				
				$("#removecardModal").modal('hide');

				$("#cdID").val('');
				$("#model").val('');

				if(data.success == true){
					$( "#load" ).hide();
					$("#notif").html(data.notif);
							  
					setTimeout(function() { 
						window.location.reload(true);
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


	//function to handle card Deposit
	function cashDirectDeposit() {

			var url = $('#cashDirectForm').attr('action');
			
			var dataString = { 
				
				voucher_number : $('#voucher_number').val(),
				voucher_amount : $('#voucher_amount').val(),
			};	
						
			$.ajax({
				type: "POST",
				//url: baseurl+url,
				url: baseurl+"payment/cashdirect",
				data: dataString,
				//data: form,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
			
					
	
					if(data.success == true){
						
						 
						$('#voucher_number').val('');
						$('#voucher_amount').val('');
					
						$("#cashdirectModal").modal('hide');
						$( "#load" ).hide();
						$("#cashdeposit-success").html(data.notif);
						//window.location.reload(true);	
						setTimeout(function() { 
							window.location.reload(true);
						}, 2000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".cashdirect_errors").html(data.notif);
					}else{
						$( "#load" ).hide();
						$(".cashdirect_errors").html('<div class="alert alert-success text-center" role="alert"> <i class="fa fa-check-circle"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Unknown errors!</div>');
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					 alert('Error: ' + status + ' ' + error);
					//alert(error);
					//location.reload();
				},
		});
		return false;
	}		
			
		function toggleAnswer() {
			var upass = document.getElementById('security_answer');
			var toggleBtn = document.getElementById('toggleBtn');
			if(upass.type == "password"){
				upass.type = "text";
				toggleBtn.value = "Hide";
			} else {
				upass.type = "password";
				toggleBtn.value = "Show";
			}
		} 	

		$('#upass').on('keyup', function(e) {
			if($(this).val().trim().length > 0){
				$(".show-password-wrap").show();
			}else{
				$(".show-password-wrap").hide();
			}
			
		});
		
		$('.show-password').on('click', function(e) {
			e.preventDefault();
			var upass = document.getElementById('upass');
			if(upass.type == "password"){
				upass.type = "text";
				$(".show-password").html("Hide");
			} else {
				upass.type = "password";
				$(".show-password").html("Show");
			}
		});
		
		function togglePassword(e) {
			
			var upass = document.getElementById('upass');
			var toggleBtn = document.getElementById('toggleBtn');
			if(upass.type == "password"){
				upass.type = "text";
				toggleBtn.value = "Hide";
				//$(".show-password").html("Hide");
			} else {
				upass.type = "password";
				toggleBtn.value = "Show";
				//$(".show-password").html("Show");
			}
		}

				
		function passwordToggle() {
			var upass = document.getElementById('current_password');
			var toggleBtn = $('.toggleBtn');
			if(upass.type == "password"){
				upass.type = "text";
				$('.toggleText').html('Hide Password');
			} else {
				upass.type = "password";
				$('.toggleText').html('Show Password');
			}
		}
				
		
		$(document).ready(function() {
			
			//disable login button
			$('.btn-signin').attr('disabled', 'disabled');
			
			//disable login button
			$('.btn-continue').attr('disabled', 'disabled');
			
			//forgotten password input function
			$(".reset-email").on('keyup paste change',function () {
				
				//forgotten password
				if($(".reset-email").val().length > 1){
					//enable forgotten password button
					$('.btn-continue').removeAttr('disabled');
				}
				return;
			});
			
			//login input function
			$("#login-email,.login-password").on('keyup paste change',function () {
				
				//login
				if($("#login-email").val().length > 1 && $(".login-password").val().length > 1){
					//enable login button
					$('.btn-signin').removeAttr('disabled');
				}
				return;
			});
			
			//login input function
			$("#email,#password").on('keyup paste change',function () {
				
				//login
				if($("#email").val().length > 1 && $("#password").val().length > 1){
					//enable login button
					$('.btn-signin').removeAttr('disabled');
				}
				return;
			});
									
			$('#reset_form').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					}
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#reset_form").data('bootstrapValidator').resetForm();
					forgotPassword();
				}
			});
			
			
			$('#login_form').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					},
					password: {
						validators: {
							
							notEmpty: {
								message: 'Please enter a password!'
							}
						}
					}
					
				}/*,
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#login_form").data('bootstrapValidator').resetForm();
					customerLogin();
				}*/
			});
			
			
			/*callback: {
								message: 'The value cannot be the same as placeholder',
								callback: function(value, validator, $field) {
									return value != $field.attr('placeholder');
								}
							}*/
			
			$('#signup_form').bootstrapValidator({
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
					email_address: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					},
					password: {
						validators: {
							
							notEmpty: {
								message: 'Please enter a password!'
							}
						}
					},
					confirm_password: {
						validators: {
							notEmpty: {
								message: 'Please confirm your password'
							},
							identical: {
								field: 'password',
								message: 'Passwords do not match'
							}
						}
					}
					
				}/*,
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					//$("#signup_form").data('bootstrapValidator').resetForm();
					form.data('bootstrapValidator').resetForm();
					//customerSignup();
					//$("#signup_form").submit();
					
				}*/
			});
			
			
			
		});	
		
			
		//function to signup new user
		function customerSignup() { 

			$( "#load" ).show();
			$("#signup_form").submit();
			/*var form = new FormData(document.getElementById('signup_form'));
			
			var validate_url = $('#signup_form').attr('action');
			
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
						$("input").val('');
						
						$(".signup-box").html(data.notif);
	
						setTimeout(function() { 
							//$("#notif").slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;*/
		}	
				
		
			
		//function to login user
		function customerLogin() { 

			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('login_form'));
			
			var validate_url = $('#login_form').attr('action');
			
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

					
					if(data.success == true && data.set_security == false){
						
						$( "#load" ).hide();
						$("input").val('');
						window.location.href = baseurl+'account/set-security';
						//$(".login-box").html(data.notif);
	
						setTimeout(function() { 
							//$("#notif").slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 2000); 

					}else if(data.success == true && data.set_security == true){
						$( "#load" ).hide();
						$("input").val('');
						window.location.href = baseurl+'account/dashboard';
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
				
			
		//function to login user
		function forgotPassword() { 

			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('reset_form'));
			
			var validate_url = $('#reset_form').attr('action');
			
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

					
					if(data.success == true ){
						
						$( "#load" ).hide();
						$("input").val('');
						
						$(".forgot-password-box").html(data.notif);
	
						setTimeout(function() { 
							//$("#notif").slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
				


		//function to display clicked image
		//as main image
		function changeImage(a) {
			document.getElementById("main-img").src=a;
			$("#main-img").parent().attr("href", a);
		}
		

  		//function to switch image from mini to huge
		function switchImage(m) {
			//alert(m);
			var dataString = { 
				image_name : m
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/image_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$("#thumbnail").html(data.thumbnail);
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

									
		$(document).ready(function() {
			//$('a[rel*=facebox]').facebox();
			
			$("a.grouped_elements").fancybox();
			
			$("a#single_image").fancybox();
			
			$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
			
			//$('.fade').fadeInScroll();
		});

	//FADE IN FUNCTION
	var $animation_elements = $('.fade');
	var $window = $(window);

	function check_if_in_view() {
		
		var window_height = $window.height();
		var window_top_position = $window.scrollTop();
		var window_bottom_position = (window_top_position + window_height);
		 
		$.each($animation_elements, function() {
			var $element = $(this);
			var element_height = $element.outerHeight();
			var element_top_position = $element.offset().top;
			var element_bottom_position = (element_top_position + element_height);
		 
			//check to see if this current container is within viewport
			if ((element_bottom_position >= window_top_position) &&
				(element_top_position <= window_bottom_position)) {
			  $element.addClass('in-view');
			} //else {
			 // $element.removeClass('in-view');
			//}
		});
	}

	$window.on('scroll resize', check_if_in_view);
	$window.trigger('scroll');
	
	
	
	$(function(){  // $(document).ready shorthand
		$('#myCarousel').fadeIn('slow');
	});
	
	//window fade in function
	$(document).ready(function() {
    	 /* Every time the window is scrolled ... */
		$(window).scroll( function(){
			
			/* Check the location of each desired element */
			$('.fade2').each( function(i){
				
				//var bottom_of_object = $(this).position().top + $(this).outerHeight();
				//var bottom_of_object = $(this).offset().top + $(this).outerHeight();
				//var bottom_of_window = $(this).scrollTop() + $(this).innerHeight();
			
				//var bottom_of_window = $(window).scrollTop() + $(window).height();
				
				/* Adjust the "200" to either have a delay or that the content starts fading a bit before you reach it  */
				
				/* If the object is completely visible in the window, fade it in */
				/*if( bottom_of_window > bottom_of_object ){
					
					$(this).animate({'opacity':'1'},1500);
						
				}*/
				
				/* If the element is completely within bounds of the window, fade it in */
				 // if (bottom_of_object < bottom_of_window) { //object comes into view (scrolling down)
					/*if ($(this).css("opacity")==0) {
						//$(this).fadeTo(500,1);
						$(this).animate({'opacity':'1'},500);
					}*/
					
				//  }
				//var imagePos = $(this).offset().top;
				//var topOfWindow = $(window).scrollTop();
				//if (imagePos < topOfWindow+600) {
				//	$(this).animate({'opacity':'1'},1000);
				//}
			}); 
		
		});		
	
	});	

	
	function fadeBlocksIn() {
		$('.fade3').each(function (i) {

			var top_of_object = $(this).position().top;
			var bottom_of_window = $(window).scrollTop() + $(window).innerHeight();

			//bottom_of_window = bottom_of_window – 50;

			if (top_of_object < bottom_of_window) {
				$(this).animate({ 'opacity': '1' }, 500);
			}
		});
	}

	$(function() {
		fadeBlocksIn();

		$(window).scroll(function() {
			fadeBlocksIn();
		});
	});
	
	