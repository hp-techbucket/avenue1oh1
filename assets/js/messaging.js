	
	
	$(document).ready(function() {
		
			
			//search mail call
			$("#search").on('paste change', searchMail);
			
			
			//messaging editor
			$('.message_details').wysihtml5();//compose
			$('#message_editor').wysiwyg();//reply

			
			$('.private-message').click(function() {
				$('.messaging-box').show(300);
				$('.widget-user').hide(300);
			});
			
			$('.cancel-message').click(function() {
				$('.messaging-box').hide();
				$('.widget-user').show(300);
			});
			
		

		
	});
	
	
	
				
		//SEARCH MAIL ajax function		
		var searchMail = function () {
				
				//e.preventDefault();
				
				var search = $(this).val();
				var displayString = '';
				var form,validate_url;
				
				$('#display_option').html('<strong>Showing All</strong>');
				
				if($('#hidden').val() == 'inbox'){
					if(search.length < 1){
						
						return;
					}
					
				//$('#display_option').html('Showing Results for <strong><em>'+search+'</em></strong> <a href="'+base_url+'message/inbox">Show All</a>';
					//get values from form
					form = new FormData(document.getElementById('inbox_search_form'));
					validate_url = $('#inbox_search_form').attr('action');
				}
				
				if($('#hidden').val() == 'sent'){
					if(search.length < 1){
						
						return;
					}
					
					//$('#display_option').html('Showing Results for <strong><em>'+search+'</em></strong> <a href="'+base_url+'message/sent">Show All</a>';
					//get values from form
					form = new FormData(document.getElementById('sent_search_form'));
					validate_url = $('#sent_search_form').attr('action');
				}
				
				
				
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
							
							$(".count").html(data.count);
							$("#display_option").html(data.display_option);
							$(".current").html(data.current);
							$(".pagnums").html(data.pagination);
							$(".message-tbody").html(data.messages_display);
							//$(".message-tbody").html(data.messages_display);
							

						}else if(data.success == false){
							$( "#load" ).hide();
							$("#display_option").html(data.display_option);
							$(".current").html(data.current);
							$(".pagnums").html(data.pagination);
							$(".count").html(data.count);
							$(".message-tbody").html(data.messages_display);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						alert(error);
					},
				});
				
				return; 
				
		}

		
		
		/*
		**	START MESSAGING FUNCTIONS	
		*/ 
		//function to handle submit new message form
		function sendMessage() { 
				
			$("#alerts").hide();
				
			var isFormValid = true; 
			//$( "#load" ).show();
				
			//validate form before submit
				
			if ($("#address_book").val().trim() === '') {
								
				//$(this).css('border-color','red');     
						
				$("#alerts").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-triangle"></i> Please select a recipient!</div>');
				isFormValid = false;
						
			}
					//else{
					//	$(this).css('border-color','#B2B2B2');
				//	}
				
			if(!isFormValid){
				$("#alerts").show();
				//$( "#load" ).hide();
				return isFormValid;
			} 

			var str = $("#address_book").val();
			//str = str.replace(/[^a-zA-Z 0-9]+/g, '');
			var words = str.split(" - ");
			var receiverName = words[0];
			var receiverUsername = words[1];
			
			var dataString = { 
				sender_name : $("#sender_n").val(),
				sender_username : $("#sender_u").val(),
				message_subject : $("#subject").val(),
				message_details : $("#editor").html(),
				receiver_name : receiverName,
				receiver_username : receiverUsername
			};
			
			var validate_url = $("#messageForm").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						//$('.compose').slideDown();
						$('#compose').click();
						
						$("#sender_name").val(''),
						$("#sender_username").val(''),
						$("#subject").val(''),
						$("#editor").text('')
							  
						$("#response-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						//setTimeout(function() { 
							//$("#response-message").hide(600);
						//	$('#response-message').slideUp({ opacity: "hide" }, "slow");
						//}, 5000);
						
						setTimeout(function() {
							$("#response-message").fadeTo(500, 0).slideUp(500, function(){
								$(this).remove(); 
							});
						}, 3000);
						
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
			
		$(document).ready(function(){
				
				//function to view full message display
				$('.view-message').click(function() {
							
					$( "#load" ).show();

					var dataString = { 
						id : $(this).attr('id')
					};				
					$.ajax({
						
						type: "POST",
						url: baseurl+"message/detail",
						data: dataString,
						dataType: "json",
						cache : false,
						success: function(data){

							$( "#load" ).hide();

							if(data.success == true){
								
								$(".reply_message").attr("id",data.id);
								$(".del_message").attr("id",data.id);
								
								$("#message_date").html(data.date_sent);
								$("#message_subject").html(data.subject);
								
								$("#sender_name").html(data.name);
								$("#sender_username").html(data.username);
								$("#receiver_name").html(data.sender_name);
								$("#receiver_username").html(data.sender_username);
								$("#message_details").html('<br/>'+data.message+'<br/><br/><br/>');
								
								$(".messages-unread").html(data.count_unread);				
								//window.location.href = baseurl+"message/inbox/"+data.id;
								
								jQuery.ajax({
										
									type: "POST",
									url: baseurl+"message/inbox/",
									dataType: 'json',
									data: {message_id: data.id},
									success: function(data){
										window.location.reload(true);
									}
								});
								
							} 
								  
						},error: function(xhr, status, error) {
								alert(error);
						},

					});					
				});	

				//function for dynamic ajax reply message display
				$('.reply_message').click(function() {
							
					$( "#load" ).show();

					var dataString = { 
						id : $(this).attr('id')
					};				
					$.ajax({
						
						type: "POST",
						url: baseurl+"message/detail",
						data: dataString,
						dataType: "json",
						cache : false,
						success: function(data){

							$( "#load" ).hide();

							if(data.success == true){
								
								$("#headerTitle").html(data.headerTitle);
								$("#replying_to").html(data.replying_to);
								$("#messageID").val(data.message_id);
								$("#senderName").val(data.sender_name);
								$("#senderUsername").val(data.sender_username);
								$("#receiverName").val(data.receiver_name);
								$("#receiverUsername").val(data.receiver_username);
								$("#email_to").val(data.email_to);
								$("#messageSubject").val(data.message_subject);
								$("#message_editor").html(data.message_details);
											

							} 
								  
						},error: function(xhr, status, error) {
								alert(error);
						},

					});					
				});	
					

		});
					
		
		
		//function for dynamic ajax new message
		//using ajax to get recipient and sender details
		//direct messaging
		function sendDirectMessage(id,model) {
							
			$( "#load" ).show();
			$(".error-message").html('');
			
			//alert('ID: '+id+' Model: '+model);
			
			var dataString = { 
				id : id,
				model : model
			};				
			$.ajax({
						
				type: "POST",
				url: baseurl+"message/new_message_detail",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					$( "#load" ).hide();

					if(data.success == true){
						
						$(".form-group").show();
						$(".btn-primary").show();	
						
						$("#messageTitle").html(data.messageTitle);
						$("#email_to").val(data.email_to);
						$("#sender_name").val(data.sender_name);
						$("#sender_username").val(data.sender_username);
						$("#receiver_name").val(data.receiver_name);
						$("#receiver_username").val(data.receiver_username);
								

					} 
					if(data.success == false){
						//$("#messageModal").hide();
						//$(".close-modal").click();
						//$(".form-group").remove();
						$(".form-group").hide();
						//$(".btn-primary").remove();
						$(".btn-primary").hide();
						$(".modal-body").html(data.notif);
					} 			  
				},error: function(xhr, status, error) {
					alert(error);
				},

			});	
			//*/			
		}
		
					
		//function to submit new message
		function submitMessage() { 
				
			$("#alerts").hide();
			
			var form = new FormData(document.getElementById('message_form'));
			
			var validate_url = $('#message_form').attr('action');
			
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

						$("#load").hide();
						$("#messageModal").hide();
						$(".close-modal").click();
						
						$("#sender_name").val(''),
						$("#sender_username").val(''),
						$("#message_subject").val(''),
						$("#headerTitle").html(''),
						$("#email_to").val(''),
						$("#message_details").val(''),
						$("#receiver_name").val(''),
						$("#receiver_username").val('')
						
						$("#notif").html(data.notif);
						$(".feedback-message").html(data.notif);
						
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('#notif').slideUp({ opacity: "hide" }, "slow");
							$('.feedback-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
					
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}		
					
		//function to submit reply message
		function submitReply() { 
				
			$("#alerts").hide();
			
			var dataString = { 
				message_id : $("#messageID").val(),
				sender_name : $("#senderName").val(),
				sender_username : $("#senderUsername").val(),
				message_subject : $("#messageSubject").val(),
				message_details : $("#message_editor").html(),
				receiver_name : $("#receiverName").val(),
				receiver_username : $("#receiverUsername").val()
			};
			
			var validate_url = $("#reply_form").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						$("#load").hide();
						$("#replyModal").hide();
						$(".close-modal").click();
						
						$("#senderName").val(''),
						$("#senderUsername").val(''),
						$("#messageSubject").val(''),
						$("#headerTitle").html(''),
						$("#replying_to").html(''),
						$("#editor2").html(''),
						$("#receiverName").val(''),
						$("#receiverUsername").val('')
						
						$("#alert-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('#alert-message').slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
						//setTimeout(function() {
						//	$("#response-message").fadeTo(500, 0).slideUp(500, function(){
						//		$(this).remove(); 
						//	});
						//}, 3000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						$(".error-message").html(data.notif);
						$("#response-message").html(data.notif);
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
	
		$('.disabled').prop('disabled', true);
		
		$('.mailbox-messages').on("click", '.messageToggle', function(event) { 
		
			event.preventDefault();
			
			//var id = $(this).attr('id');
			//markAsRead(id);
			
			if ($(this).next().is(":hidden")) {
				$(".messageDiv").hide();
				$(this).next().slideDown("fast"); 
				//$(this).next().show(600);
			} else { 
				$(this).next().slideUp(600); 
			} 
		});
		/*	
		$(".messageToggle").click(function () { 
			if ($(this).next().is(":hidden")) {
				$(".messageDiv").hide();
				$(this).next().slideDown("fast"); 
				//$(this).next().show(600);
			} else { 
				$(this).next().hide(); 
			} 
		});
		
		*/
		
		//mark inbox message as read
		function markAsRead(msgID) {
		
			$('#subj_line_'+msgID).addClass('msgRead');
			
			$(msgID).addClass('msgRead');
			
			var id = msgID;
			
			if(id === '')
				return;
			jQuery.ajax({
					
				type: "POST",
				url: baseurl+"message/mark_as_read/"+id,
				dataType: 'json',
				data: {message_id: id},
				cache : false,
				success: function(data){
					
					if(data.success == true){
						$('#inbox-count').html(data.count_sent_messages);
					}
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		}	
		
		
		//multiple messaging
		//function to handle submit new message form
		function newMessage() { 
			
			$(".error-message").html('');
			
			var addressBook = $("#address_book").val().trim();
			var message = $(".messageDetails").val().trim();
			var validate_url = '';
			var dataString = {};
			
			//alert(addressBook);
		
			if(addressBook == '0'){
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a recipient!</div>');
				return;
			}
			
			if(message.length < 3){
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a longer message!</div>');
				return;
			}	
			
			if(addressBook != 'users'){
				var user = addressBook.split(" - ");
				var receiverName = user[0];
				var receiverUsername = user[1];
				
				validate_url = baseurl+'message/new_message_validation';
				dataString = { 
					sender_name : $("#name").val(),
					sender_username : $("#username").val(),
					message_subject : $("#message_subject").val(),
					message_details : $(".messageDetails").val(),
					receiver_name : receiverName,
					receiver_username : receiverUsername
				};
			}
			if(addressBook == 'users'){
				validate_url = $("#mailer_message_form").attr('action');
				dataString = { 
					sender_name : $("#name").val(),
					sender_username : $("#username").val(),
					message_subject : $("#message_subject").val(),
					message_details : $(".messageDetails").val(),
					model : addressBook,
					
				};
			}
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$("#load").hide();
						$(".close-modal").click();
						$("#mailerModal" ).hide();
						$("#messageModal" ).hide();
						$("#name").val('');
						$("#username").val('');
						$("#message_subject").val('');
						$(".messageDetails").val('');
							  
						$("#success-message").html(data.notif);
						$(".success-message").html(data.notif);
						setTimeout(function() { 
							//$("#success-message").hide(600);
							$('#success-message').slideUp({ opacity: "hide" }, "slow");
							$('.success-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			
			//*/
		
		}	
			
		
		//function to handle submit new message form
		function submitNewMessage() { 
			
			$(".error-message").html('');
			
			var addressBook = $("#address_book").val().trim();
			var message = $(".messageDetails").val().trim();
			var validate_url = baseurl+'message/new_message_validation';
			
			//$(".feedback-message")
			var user = addressBook.split(" - ");
				var receiverName = user[0];
				var receiverUsername = user[1];
			
			if(addressBook == '0'){
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a recipient!</div>');
				return;
			}
			
			if(message.length < 3){
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a longer message!</div>');
				return;
			}	
				
			var dataString = { 
					sender_name : $("#name").val(),
					sender_username : $("#username").val(),
					message_subject : $("#message_subject").val(),
					message_details : $(".messageDetails").val(),
					receiver_name : receiverName,
					receiver_username : receiverUsername
				};
			//alert(addressBook);
		
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$("#load").hide();
						$(".close-modal").click();
						$("#messageModal" ).hide();
						$("#name").val('');
						$("#username").val('');
						$("#message_subject").val('');
						$(".messageDetails").val('');
						
						$(".success-message").html(data.notif);
						setTimeout(function() { 
							
							$('.success-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			
			//*/
		
		}	
					
	
		/*
		**	END MESSAGING FUNCTIONS	
		*/ 
		

			
	
	//function to handle submit reply
	function submitMessage() { 
		
		$( "#load" ).show();

		var dataString = { 
			model : $("#model").val(),
			sender_name : $("#sender_name").val(),
			sender_username : $("#sender_username").val(),
			receiver_name : $("#receiver_name").val(),
			receiver_username : $("#receiver_username").val(),
			message_subject : $("#messageSubject").val(),
			message_details : $("#messageDetails").val()
		};
		
		$.ajax({
			type: "POST",
			url: baseurl+"admin/send_message_validation",
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){
				
				$("#message_id").val('');
				$("#sender_name").val('');
				$("#sender_username").val('');
				$("#receiver_name").val('');
				$("#receiver_username").val('');
				$("#messageSubject").val('');
				$("#messageDetails").val('');

				if(data.success == true){
					
					$("#messageModal").modal('hide');
					$( "#load" ).hide();
					
					$("#notif").html(data.notif);
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);
					//window.location.reload(true);
					
				//	var socket = io('http://localhost:8080');
					//var socket = io.connect( 'http://'+window.location.hostname+':3000' );
					
				//	socket.emit('new_count_message', { 
				//		new_count_message: data.new_count_message
				//	});
				

				}else if(data.success == false){
					$( "#load" ).hide();		  
					$("#errors").html(data.notif);
					
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
	
	}	
	
	//function to populate the hidden message values
	//before reply form submit
	function replyBoxHidden(id,sName,sEmail,rName,rEmail) {
		document.reForm.message_id.value = id;
		document.reForm.sender_name.value = sName;
		document.reForm.sender_email.value = sEmail;
		document.reForm.receiver_name.value = rName;
		document.reForm.receiver_email.value = rEmail;
	}

		function markAsRead(msgID) {

		  $(".subjectToggle").click(function () {

				$('#subj_line_'+msgID).addClass('msgRead');
				var id = msgID;
				if(id === '')
				  return;
				jQuery.ajax(
					{
					 type: "POST",
					 url: baseurl+"message/mark_as_read/"+id,
					 dataType: 'json',
					 data: {message_id: id},
					 success: function(data){
					 $('.tags_found').html(data);
					}
				});
						
			});
		}		
	
	
	//function to handle submit reply
	function submitReply() { 
		
		$( "#load" ).show();
	
		var dataString = { 
			message_id : $("#message_id").val(),
			sender_name : $("#sender_name").val(),
			sender_username : $("#sender_username").val(),
			receiver_name : $("#receiver_name").val(),
			receiver_username : $("#receiver_username").val(),
			message_subject : $("#message_subject").val(),
			message_details : $(".customTextArea").val()
		};

		$.ajax({
			type: "POST",
			url: baseurl+"message/send_message_validation",
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){

				if(data.success == true){
				
					$("#message_id").val('');
					$("#sender_name").val('');
					$("#sender_username").val('');
					$("#receiver_name").val('');
					$("#receiver_username").val('');
					$("#message_subject").val('');
					$(".customTextArea").val('');
						
					$("#replyModal").modal('hide');
					$( "#load" ).hide();	  
					$("#notif").html(data.notif);
					setTimeout(function() {  
						window.location.reload(true);
					}, 2000);
					//window.location.reload(true);
					
					//var socket = io('http://localhost:8080');
					//var socket = io.connect( 'http://'+window.location.hostname+':3000' );
					
					//socket.emit('new_count_message', { 
					//	new_count_message: data.new_count_message
					//});

					//socket.emit('test', { 
					//	test: 'This is just a test!'
					//});					

				}else if(data.success == false){
					$( "#load" ).hide();		  
					
					$("#notif").html(data.notif);
					setTimeout(function() {  
						window.location.reload(true);
					}, 2000);
					
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
	
	}		
	
