$(document).ready(function() {
	
	var $BODY=$("body");
	var e=function(){var e=$BODY.outerHeight()};
	
	$("#home a:contains('Home')").parent().addClass('active');
	$("#about a:contains('About')").parent().addClass('active');
	$("#contact a:contains('Contact')").parent().addClass('active');
	$("#gallery a:contains('Gallery')").parent().addClass('active');
	$("#login a:contains('Login')").parent().addClass('active');
	
	//$("#cart a:contains('<i class='fa fa-shopping-cart'></i></a>')").parent().addClass('active');
	$("#store a:contains(' Store')").parent().addClass('active');
	$("#cart a:contains(' Cart ')").parent().addClass('active');
	//$("#cart").find('.fa-shopping-cart').parent().parent().addClass('active');
	$("#dashboard a:contains('Dashboard')").parent().addClass('active');
	$("#settings a:contains(' Settings')").parent().addClass('active');
	$("#profile a:contains(' Profile')").parent().addClass('active');
	$("#contact_us a:contains(' Contact Us')").parent().addClass('active');
	$("#alerts a:contains(' Alerts')").parent().addClass('active');
	$("#user_modifications a:contains(' User Modifications')").parent().addClass('active');
	//$("#logins a:contains('<i class=\"fa fa-sign-in\"></i> Logins')").parent().addClass('active');
	
	$("#logins i.fa-sign-in").parent() .parent().addClass('active');
	
	$("#failed_logins a:contains(' Manage Logins')").parent().addClass('active');
	$("#failed_resets a:contains(' Manage Logins')").parent().addClass('active');
	$("#questions a:contains(' Quiz Questions')").parent().addClass('active');
	
	//$("#orders a:contains(' Transactions')").parent().addClass('active');
	
	$("#orders").find('a#orders-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
	$("#payments a:contains(' Transactions')").parent().addClass('active');
	
	//$("#shipping a:contains(' Transactions')").parent().addClass('active');
	$("#shipping").find('a#shipping-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
	
	//$("#payments a:contains(' Transactions')").parent().addClass('active');
	
	$("#payments").find('a#payments-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
	
	
	$("#admin_users a:contains(' Manage Admins')").parent().addClass('active');
	$("#inbox a:contains('Messages')").parent().addClass('active');
	$("#sent a:contains('Messages')").parent().addClass('active');
		
	$("#messages a:contains(' Messages ')").parent().addClass('active');
	$("#sent_messages a:contains(' Messages ')").parent().addClass('active');
	$("#security_questions a:contains(' Security Questions')").parent().addClass('active');
	$("#quiz_answers a:contains(' Quiz Answers')").parent().addClass('active');
	$("#users a:contains('Manage Users')").parent().addClass('active');
	$("#question_categories a:contains(' Question Categories')").parent().addClass('active');
	$("#products_list a:contains(' Products')").parent().addClass('active');
	$("#product_categories a:contains(' Product Categories')").parent().addClass('active');
	$("#brands a:contains(' Brands')").parent().addClass('active');
	$("#sizes a:contains(' Sizes')").parent().addClass('active');
	
	
	//$('.item-wrapper-overlay').hide();
	$("#load").hide();
	
	$(".result-header").click(function () { 
		$('.result-view').slideToggle(600);
		$("i",this).toggleClass("fa-plus-square fa-minus-square");		
	});
	
	$(".bonus-question-header").click(function () { 
		$('.bonus-question-view').slideToggle(300);
		$('#proposal-message').slideToggle(300);
		$("i",this).toggleClass("fa-plus-square fa-minus-square");	
		$("html, body").animate({ scrollTop: 0 }, "slow");	
	});
	
	//handles audio big button displays
	$("#audio-show").click(function () { 
		//$('#audio-container').slideToggle(600);
		$('#audio-show').hide();	
		$('#audio-hide').show();
		$('#audio-container').show(600);	
	});
	$("#audio-hide").click(function () { 
		//$('#audio-container').slideToggle(600);
		$('#audio-hide').hide();
		$('#audio-show').show();
		$('#audio-container').hide(600);	
	});	


	
	//function to split question into options
		$('#question').change(function() {
			var str = $(this).val();
			str = str.replace(/[^a-zA-Z 0-9]+/g, '');
			var words = str.split(" or ");
			for (var i = 0; i < words.length - 1; i++) {
				$('#option_1').val(words[0]);
				$('#option_2').val(words[1]);
			}
		});	
		
		//function to generate user name
		$('#fname,#mname,#lname,#dob').change(function() {
			//get values from form input
			var fname = $.trim($('#fname').val());
			var mname = $.trim($('#mname').val());
			var lname = $.trim($('#lname').val());
			var dob = $.trim($('#dob').val());
			
			//check if values have been entered
			//only then perform function
			if(fname.length != 0 && lname.length != 0 && dob.length != 0 ){
				
				//get first character of first name and convert to lowercase
				var firstLetter_fname = fname.charAt(0).toLowerCase();
				
				//get first character of middle name and convert to lowercase
				var firstLetter_mname = mname.substring(0,1).toLowerCase();
				
				//get first character of last name and convert to lowercase
				var firstLetter_lname = lname.charAt(0).toLowerCase();
				
				//split date into year, month and day
				var dates = dob.split("-");
				var year = dates[0];
				var month = dates[1];
				var day = dates[2];
				
				//get last two characters of year value
				var lastTwoCharacteresOfYear = year.slice(-2);
				
				//concatenate to form username
				var username = firstLetter_fname +''+firstLetter_mname +''+firstLetter_lname +''+ month +''+lastTwoCharacteresOfYear;
				
				//change username form value
				$('#username').val(username);
			
			}
			
		});	
		
		
		$(".user-profile").hover(function(){
			$(".edit-profile",this).fadeToggle();
		});
		
		$(".edit-profile").click(function(){
			$(this).parent().next().slideToggle();

		});
		
		//$("#header_banner").hover(function(){
		//	$('.changeBanner').fadeToggle();
		//});
		
		$(".banner-change-icon").click(function(){
			$('#bannerUpload').click();
		});

		$('#bannerUpload').change(function() {
			if($('#bannerUpload').val()){
				$('#bannerForm').submit();
			}
		});

		$('#uploadPhoto').change(function() {
			if($(this).val()){
				$('#uploading').show();
				setTimeout(function() { 
					$('#userProfileForm').submit();
				}, 2000);
			}
		});
		
		
		$(".change-password").click(function () { 
			if($('.update-security').is(":hidden") == false){
				$('.update-security').hide(600);
			}
			$('.update-password').slideToggle(600);			
		});	
			
		$(".change-security").click(function () { 
			if($('.update-password').is(":hidden") == false){
				$('.update-password').hide(600);
			}
			$('.update-security').slideToggle(600);			
		});		

		$('[type=file]').change(function() {
			$('.fileinput-preview').show();
				
		});
		//function to display image name on select
		$('#option_1_image,#option_2_image,#edit_option_1_image,#edit_option_2_image,#uploadPhoto,#userPhotoUpload,#product_image,#new_product_image').change(function() {
					
			var img_name = $(this).val().replace(/C:\\fakepath\\/i, '');
			
			var span = $('span[for="'+$(this).attr('id')+'"]');
			//$(this).parent().after('<span>'+img_name+'</span>');
			//$('<span>').html(img_name).insertAfter($(this));
			span.html(img_name);
		});	
		//function to display image name on select
		$('input[type=file]').change(function() {
					
			var img_name = $(this).val().replace(/C:\\fakepath\\/i, '');
			
			var span = $('span[for="'+$(this).attr('id')+'"]');
			//$(this).parent().after('<span>'+img_name+'</span>');
			//$('<span>').html(img_name).insertAfter($(this));
			span.html(img_name);
		});	
		
		$('#option_image').change(function() {
					
			var img_name = $(this).val().replace(/C:\\fakepath\\/i, '');
			$('.image_2_name').html(img_name);
		});	
		
		$('.quiz-photos').click(function() {
			$('.quiz-photos').find('img').css('border-color','#e6e6e6');
			$(this).find('img').css('border', "solid 4px #cca300");
			//$("img",this).toggleClass('img-border');
			//$(this).css({"border-color": "#006666", "border-width": "2px"})
			$(this).find('input:radio')[0].checked = true;     
			var selected = $(this).find('input[name=answer]:checked');
			var selectedVal = selected.val();
			//var selected = $("input[name=answer]:checked").val();
			$('#selectedVal').html(selectedVal);
			setTimeout(function() { 
				$('.next-btn').click();
			}, 100);
		});
		$('#card-deposit-logo').click(function() {
			$('#card-deposit-show').show();
			$('#cash-deposit-show').hide();
			$('#paypal-deposit-show').hide();
		});	
		
		$('#cash-deposit-logo').click(function() {
			$('#cash-deposit-show').show();
			$('#card-deposit-show').hide();
			$('#paypal-deposit-show').hide();
		});	
		
		$('#paypal-deposit-logo').click(function() {
			$('#paypal-deposit-show').show();
			$('#cash-deposit-show').hide();
			$('#card-deposit-show').hide();
		});	
		
		$('#card-withdrawal-logo').click(function() {
			$('#card-withdrawal-show').show();
			$('#paypal-withdrawal-show').hide();
		});	
		
		$('#paypal-withdrawal-logo').click(function() {
			$('#paypal-withdrawal-show').show();
			$('#card-withdrawal-show').hide();
		});	

		
		//function to view admin details
		$('.withdrawal-btn').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				username : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/payment_methods_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						$("#cards-withdrawal").html(data.card_details);
						$("#paypal-account").val(data.masked_PayPal);
						$("#paypal_id").val(data.paypal_id);
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					}   						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
						alert(error);
				},

			});					
		});	
		
	
		$('#user-cards').on('change', function() {
			
			//alert( this.value );
			
			//$( "#load" ).show();

			var dataString = { 
				id : this.value
			};	

			$.ajax({
				
				type: "POST",
				url: baseurl+"payments/card_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					
					if(data.success == true){
						$( "#load" ).hide();
						
						$("#card_name").val(data.name_on_card);
						$("#expiry_m").val(data.expiry_month);
						$("#expiry_y").val(data.expiry_year);
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					}  
									  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});		
		});		
		

	$(".newDeposit").click(function (e){
		depositAlert(); 
	});			

	//$('#cardNo').change(validateCard);

		//$('#card_number').change(validateCard);
		
		//function to view admin details
		$('.view_card_details').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/card_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						
						$("#card_type").html(data.type);
						$("#name_on_card").html(data.name_on_card);
						$("#card_number").html(data.card_number);
						$("#expiry_date").html(data.expiry_month+'/'+data.expiry_year);
						$("#cvv").html(data.card_cvc);
						$("#billing_street_address").html(data.billing_street_address);
						$("#billing_city").html(data.admin_billing_city);	
						$("#billing_postcode").html(data.billing_postcode);
						$("#billing_state").html(data.billing_state);
						$("#billing_country").html(data.billing_country);
						$("#user_email").html(data.user_email);
						$("#date_added").html(data.date_added);
						$("#billing_city").html(data.admin_date_created);						

					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					}   						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});	

			
		//function to confirm card deposit
		$('.card_deposit').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/card_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						
						//populate the hidden fields
						$("#card_name").val(data.name_on_card);
						$("#card_number").val(data.masked_card);
						$("#card_id").val(data.id);
						$("#expiry_m").val(data.expiry_m);
						$("#expiry_y").val(data.expiry_y);
					
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					}    				  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});				
						
		//function to edit card
		$('.edit_card').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/card_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						
						//populate the hidden fields
						$("#cardID").val(data.id);
						$("#cardNo").val(data.masked_card);
						$("#card_n").val(data.card_number);
						$("#cardName").val(data.name_on_card);
						$("#card_billing_street_address").val(data.billing_street_address);
						$("#card_billing_city").val(data.billing_city);
						$("#card_billing_postcode").val(data.billing_postcode);
						$("#card_billing_state").val(data.billing_state);
						$("#card_billing_country").val(data.billing_country);
						
						$("#e_month").html(data.expiry_month);
						$("#e_year").html(data.expiry_year); 
						//$("#card_cvc").val(data.card_cvc); 

					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					}   				  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});				
					
		
		//function to remove paypal account
		$('.remove_card').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/card_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						
						$( "#load" ).hide();
						
						$("#cdID").val(data.id);
						$("#card").html(data.masked_card);
						$("#ccHead").html(data.masked_card);
						$("#cardNo").val(data.card_number);
						//populate the hidden fields
						//document.flagPostForm.post_id.value = data.id;
						
					}else{
						$( "#load" ).hide();
						$("#ccHead").html('Errors!');
					}    
									  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});			

		$(".paypalDeposit").click(function (e){
			
			e.preventDefault();
			if ($.trim($(".newDeposit").val()).length == 0){
				$(".form_errors").html('<div class="alert alert-danger text-center"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Amount cannot be blank!</div>');	
				$(".newDeposit").css('border-color','red');
				return false;
					
			}else{
				$(".newDeposit").css('border-color','#B2B2B2');
				$("#paypalDepositForm").submit();
			}
		});			

		$(".editPayPal").click(function (){

			if ($.trim($("#masked_paypal_email").val()).length == 0){
				$(".form_errors").html('<div class="alert alert-danger text-center"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Amount cannot be blank!</div>');	
				$(".#masked_paypal_email").css('border-color','red');
				return false;
					
			}else{
				$("#masked_paypal_email").css('border-color','#B2B2B2');
				//editPayPal();
				$("#editPayPalForm").submit();
			}
		});			
				
		//function to confirm paypal deposit
		$('.paypal_deposit').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/paypal_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						//populate the hidden fields
						$("#paypal_id").val(data.id);
						$("#phead").html(data.masked_PayPal);
					}else{
						$( "#load" ).hide();
						$("#phead").html('Errors!');
					}   				  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});				
						
		//function to edit paypal
		$('.edit_paypal').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/paypal_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						//populate the hidden fields
						$("#paypalID").val(data.id);
						$("#masked_paypal_email").val(data.masked_PayPal);

					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					}  				  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});				
				
		
		//function to remove paypal account
		$('.remove_paypal').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"payment/paypal_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
						
						$("#paypID").val(data.id);
						$("#email").html(data.masked_PayPal);
						$("#paypalhead").html(data.masked_PayPal);
						$("#email").css('font-weight','bold');
						$("#email").css('color','red');
						$("#paypEmail").val(data.PayPal_email);
						//populate the hidden fields
						//document.flagPostForm.post_id.value = data.id;
						
					}else{
						$( "#load" ).hide();
						$("#paypalhead").html('Errors!');
					} 
									  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		});				
	

});
		
		//$('input[type=password]').dPassword();
		//$("input[type=password]").mobilePassword();

    //Bind Key Press event with password field    
    //$("#security_answer").keypress(function() {
      //  setTimeout(function() {
            //maskPassword(e)
      //  }, 500);
   // });
   
  

		$(document).ready(function() {
			
			$("#load").hide();
			
			$(".paypalDiv").click(function () { 
				$('.paypalDepositDiv').slideToggle(600);
				$('.ccListDiv').hide(600);
				$('.cashDepositDiv').hide(600);
				$("i",this).toggleClass("fa-angle-double-down fa-angle-double-up");
				$('i','.ccDiv').removeClass('fa-angle-double-up').addClass("fa-angle-double-down");
			});
			
			$(".ccDiv").click(function () { 
				$('.ccListDiv').slideToggle(600);
				$('.paypalDepositDiv').hide(600);
				$('.cashDepositDiv').hide(600);
				$("i",this).toggleClass("fa-angle-double-down fa-angle-double-up");
				$('i','.paypalDiv').removeClass('fa-angle-double-up').addClass("fa-angle-double-down");
				
						
			});
			
			$(".cashDiv").click(function () { 
				$('.ccListDiv').hide(600);
				$('.ccDiv').find('i').addClass("fa-angle-double-down");
				$('.ccDiv').find('i').removeClass("fa-angle-double-up");
				$('.paypalDepositDiv').hide(600);
				$('.paypalDiv').find('i').addClass("fa-angle-double-down");
				$('.paypalDiv').find('i').removeClass("fa-angle-double-up");
				$('.cashDepositDiv').slideToggle(600);
				
			});
			
			$(".addCCButton").click(function () { 
				if($('.addPayPalDiv').is(":hidden") == false){
					$('.addPayPalDiv').hide(600);
				}			
				$('.addCCDiv').slideToggle(600);			
			});
			$(".addPPButton").click(function () { 
				if($('.addCCDiv').is(":hidden") == false){
					$('.addCCDiv').hide(600);
				}			
				$('.addPayPalDiv').slideToggle(600);			
			});		
			
			$(".passButton").click(function () { 
				if($('.changeSecurityInfoDiv').is(":hidden") == false){
					$('.changeSecurityInfoDiv').hide(600);
				}
				$('.updatePasswordDiv').slideToggle(600);			
			});	
			
			$(".securButton").click(function () { 
				if($('.updatePasswordDiv').is(":hidden") == false){
					$('.updatePasswordDiv').hide(600);
				}
				$('.changeSecurityInfoDiv').slideToggle(600);			
			});	


			
			$('#country_id').on('change', function() {
				
				//alert( this.value );
				
				//$( "#load" ).show();

				var dataString = { 
					id : this.value
				};	
				
				$('.states').find("option:eq(0)").html("Please wait..");
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"location/get_states",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							$(".states").html(data.options);
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

		
			$('.states').on('change', function() {
				//alert( this.value );
				
				//$( "#load" ).show();

				var dataString = { 
					id : this.value
				};	

				$('.cities').find("option:eq(0)").html("Please wait..");
							
				$.ajax({
					
					type: "POST",
					url: baseurl+"location/get_cities",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						

						if(data.success == true){
							$( "#load" ).hide();
							$(".cities").html(data.options);
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
			
			
			$('.manual_city_entry').on('click', function() {
				//e.preventDefault();
				//$('#city').replaceWith('');
				if($('.billing_city').is(":hidden") == false){
					$('.billing_city').hide();
					$('.cities').show();
				}else{
					
					$('.billing_city').show();
					$('.cities').hide();
				}	
				//$('#billing_city').show();
				//if($('#billing_city').is(":hidden") == false){
				//	$('#billing_city').hide(600);
				//}else{
					//$('.cities').replaceWith('<input type="text" name="card_billing_city" id="billing_city" placeholder="London" required>');
					//$('#billing_city').show(600);
				//}
			});			

		});	

	$(document).ready(function() {	
	
		$("#load").hide();
	
		$('.error-message').hide();
		
		$('#name_on_card, #cvv, #house_and_street_address, #house_and_street_address_2, #card_billing_city, #card_billing_postcode, #card_billing_state').on('input', function() {
		
			$('.error-message').empty();
			var id = $(this).attr('id');
			var label = getLabel(id);
			//var label = $(this).getLabel();
			$(this).css('border-color','#B2B2B2');
				                
			label.css('color','black');
			label.find('.fa').remove();
			
		});	
		
			
		$('#name_on_card').on('change paste keyup',function(){
				
		  		var id = $(this).attr('id');
				var label = getLabel(id);
				//var label = $(this).getLabel();
				label.find('.fa').remove();
				var alertExist = label.find('i');

				var nameExp = /^[a-zA-Z. ]+$/;		
					
				if(!$(this).val().trim().match(nameExp) && $.trim($(this).val()).length != 0){
					$(this).css('border-color','red');
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					$('.error-message').show();
					$(".error-message").append('<p><i class="fa fa-exclamation-triangle"></i> Please enter a valid name!</p>');
				}else{
					$('.error-message').hide();
					$(this).css('border-color','#00802b');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
				}		
										
				
		});
		
		$('#card_billing_street_address, #card_billing_city, #card_billing_postcode, #card_billing_state').donetyping(function(){
				
		  		var id = $(this).attr('id');
				var label = getLabel(id);
				//var label = $(this).getLabel();
				label.find('.fa').remove();
				
		  		var addExp = /[A-Za-z0-9\-\\,. ]+/;

				if(!$(this).val().trim().match(addExp) && $(this).val().trim().length != 0){
						
					$(this).css('border-color','red');
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					$('.error-message').show();
					$(".error-message").append('<p><i class="fa fa-exclamation-triangle"></i> Please enter a valid address!</p>');
						       
				}else{
					$('.error-message').hide();
					$(this).css('border-color','#00802b');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
				}		

		});
		
				
		$('#cvv').donetyping(function(){
				
		  		var id = $(this).attr('id');
				var label = getLabel(id);
				//var label = $(this).getLabel();
				label.find('.fa').remove();
				var alertExist = label.find('i');

		  		var cvvMin = 3;
		  		var cvvMax = 4;
		  		
		
				if($(this).val().length != 0 && ($(this).val().length < cvvMin || $(this).val().length > cvvMax)){
						
					$(this).css('border-color','red');
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');    
					$('.error-message').show();
					$(".error-message").append('<p><i class="fa fa-exclamation-triangle"></i> Please enter a valid CVV!</p>');
						       
				}else{
					$('.error-message').hide();
					$(this).css('border-color','#00802b');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
					
				}		
									
				
		});
		$('#card_billing_country').change(function(){
				
		  		var id = $(this).attr('id');
				var label = getLabel(id);
				//var label = $(this).getLabel();
				label.find('.fa').remove();
				if ($(this).val() == '0') {
					$(this).css('border-color','red');
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					$('.error-message').show();
					$(".error-message").append(' Please select a country!');
					return false;
				}else{
					$('.error-message').hide();
					$(this).css('border-color','#00802b');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
					
				}	
		});
		
		
		$('#expiry_month').change(function(){
				$('.error-message').empty();
		  		var id = $(this).attr('id');
				var label = getLabel(id);
				//var label = $(this).getLabel();
				label.find('.fa').remove();
				$('label[for="expiry_year"]').find('.fa').remove();
				
				var currentYear = new Date().getFullYear();
				var currentMonth = new Date().getMonth() + 1;
				
				var inputYear = $('[name=expiry_year]').val();
				var inputMonth = $('[name=expiry_month]').val();
				
				var inputDate = new Date(inputYear, inputMonth);
				var currentDate = new Date(currentYear, currentMonth);
				
				
				if (inputDate < currentDate) {
					$(this).css('border-color','red');
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					$('#expiry_year').css('border-color','red');
					$('label[for="expiry_year"]').append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					$('.error-message').show();
					$(".error-message").append('<p> Please select a valid expiry month and year!</p>');
					return false;
				}
				
					$('.error-message').hide();
					$(this).css('border-color','#00802b');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
					$('#expiry_year').css('border-color','#00802b');
					$('label[for="expiry_year"]').append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
		});
		
		
		$('#expiry_year').change(function(){
				
		  		var id = $(this).attr('id');
				var label = getLabel(id);
				//var label = $(this).getLabel();
				
				label.find('.fa').remove();
				
				if ($(this).val() == '0') {
					$(this).css('border-color','red');
					label.append(' <i class="fa fa-exclamation-triangle"></i>').css('color','#ff0000');
					$('.error-message').show();
					$(".error-message").append(' Please select an expiry year!');
					return false;
				}
				
					$('.error-message').hide();
					$(this).css('border-color','#00802b');
					label.append(' <i class="fa fa-check-circle"></i>').css('color','#00802b');
		});	
				
		/*$(".textinput input").change(function() {
		  if ($(this).val() != "") {
			$(this).addClass('filled');
		  } else {
			$(this).removeClass('filled');
		  }
		});*/
	
	});	

		


	
//
// $('#element').donetyping(callback[, timeout=1000])
// Fires callback when a user has finished typing. This is determined by the time elapsed
// since the last keystroke and timeout parameter or the blur event--whichever comes first.
//   @callback: function to be called when even triggers
//   @timeout:  (default=1000) timeout, in ms, to to wait before triggering event if not
//              caused by blur.
// Requires jQuery 1.7+
//
;(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 5e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too preemptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);

	$(function() {
		
		$('.img-display').bjqs({
			'showmarkers' : false,
			'showcontrols' : false,
			'height' : 400,
			'width' : 400,
			'responsive' : true
		});
		var image
		var body = $('.chichi-wrapper');
		var backgrounds = new Array(
			'url('+baseurl+'assets/images/backgrounds/image1.jpg)',
			'url('+baseurl+'assets/images/backgrounds/image2.jpg)',
			'url('+baseurl+'assets/images/backgrounds/image3.jpg)',
			'url('+baseurl+'assets/images/backgrounds/image4.jpg)',
			'url('+baseurl+'assets/images/backgrounds/image6.jpg)',
			'url('+baseurl+'assets/images/backgrounds/image7.jpg)'
		);
		var current = 0;

		function nextBackground() {
			body.css({
				'background':backgrounds[current = ++current % backgrounds.length],
				'background-repeat':'no-repeat center center fixed',
				'background-size':'cover'
		});

			setTimeout(nextBackground, 10000);
		}
		setTimeout(nextBackground, 10000);
		body.css('background', backgrounds[0]);
	});

			$(function() {
				/* 
				 * just for this demo:
				 */
				$('#showcode').toggle(
					function() {
						$(this).addClass('up').removeClass('down').next().slideDown();
					},
					function() {
						$(this).addClass('down').removeClass('up').next().slideUp();
					}
				);
				$('#panel').toggle(
					function() {
						$(this).addClass('show').removeClass('hide');
						$('#overlay').stop().animate( { left : - $('#overlay').width() + 20 + 'px' }, 300 );
					},
					function() {
						$(this).addClass('hide').removeClass('show');
						$('#overlay').stop().animate( { left : '0px' }, 300 );
					}
				);
				
				var $container 	= $('#am-container'),
					$imgs		= $container.find('img').hide(),
					totalImgs	= $imgs.length,
					cnt			= 0;
				
				$imgs.each(function(i) {
					var $img	= $(this);
					$('<img/>').load(function() {
						++cnt;
						if( cnt === totalImgs ) {
							$imgs.show();
							$container.montage({
								minw : 100,
								alternateHeight : true,
								alternateHeightRange : {
									min	: 50,
									max	: 350
								},
								margin : 8,
								fillLastRow : true
							});
							
							/* 
							 * just for this demo:
							 */
							$('#overlay').fadeIn(500);
						}
					}).attr('src',$img.attr('src'));
				});	
				
			});
			
			
			
			
			
			
			