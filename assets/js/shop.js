
		
		$(function() {
			$("form#add_to_cartForm div").append('');
		});
		
		function test(){
			alert('This is just a test!!!');
		}
		//var filterProducts = function()
		//
	
	$(document).ready(function() {

		$('#list').click(function(event){
			event.preventDefault();
			$('#products .item').addClass('list-group-item');
			$('#products .item').removeClass('grid-group-item');
		});
		$('#grid').click(function(event){
			event.preventDefault();
			$('#products .item').removeClass('list-group-item');
			$('#products .item').addClass('grid-group-item');
		});
		

		$(".inc").on("click", function() {

			  var $button = $(this);
			  //var id = $button.attr('for');
			  var id = $button.attr('id');
			  var oldValue = $('#cart_quantity_'+id).val();
			  //var oldValue = $button.parent().find("input").val();
				
			  var newVal = parseFloat(oldValue) + 1;
			  $('#cart_quantity_'+id).val(newVal);
			  //$button.parent().find("input").val(newVal);

		});	
		
			
			
		$("#inc").on("click", function() {

			  var $button = $(this);
			  var id = $('#p_id').val();
			  var oldValue = $('.p-qty').val();
			 
			  var newVal = parseFloat(oldValue) + 1;
			  $(".p-qty").val(newVal);
			  $('#cart_quantity_'+id).val(newVal);
			  //$button.parent().find("input").val(newVal);

		});	
		
		$(".dec").on("click", function() {

				var $button = $(this);
				var id = $button.attr('id');
				var oldValue = $('#cart_quantity_'+id).val();
				//var oldValue = $button.parent().find("input").val();

			   // Don't allow decrementing below zero
				if (oldValue > 0) {
				  var newVal = parseFloat(oldValue) - 1;
				} else {
				  newVal = 0;
				}
		  
				$('#cart_quantity_'+id).val(newVal);
				//$button.parent().find("input").val(newVal);

		});		
		
		$("#dec").on("click", function() {

				var $button = $(this);
				var id = $('#p_id').val();
				var oldValue = $('.p-qty').val();
				
			   // Don't allow decrementing below zero
				if (oldValue > 0) {
				  var newVal = parseFloat(oldValue) - 1;
				} else {
				  newVal = 0;
				}

				$(".p-qty").val(newVal);
				$('#cart_quantity_'+id).val(newVal);
		});			
		

		//function to edit product details
		$('.add_images').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
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
						document.upload_product_images.prod_id.value = data.id;
						
						$("#header").html(data.name);
						
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
		
	
		$("#show_category").change(function (){

			//if ($.trim($(this).val()) == "All"){
			//	return false;
			//}else{
				$(".btn-show-category").click();
			//}
		});			
						

		//function to add product to cart
		$('.add_to_cart').click(function() {
					
			$( "#load" ).show();

			var dataString = { 
				id : $(this).attr('id')
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/product_details",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					$( "#load" ).hide();

					if(data.success == true){
						
						$("#hTitle").html(data.headerTitle +' ('+ data.product_reference +')');
						$("#mini-thumbnail").html(data.mini_thumbnail);
						$("#product-name").html(data.name);
						$("#product_id").val(data.id);
						
						
						var qty = $('#cart_quantity_'+data.id).val();
						var price = $('#price_'+data.id).val();
						
						$("#cart_quantity").val(qty);
						$("#product-price").val(price);
						
					} 
						  
				},error: function(xhr, status, error) {
						alert(error);
				},

			});					
		});	 
		
		
		
		$("#cart").on("click", function() {
			$(".shopping-cart").fadeToggle( "fast");
		});
	
		$(document).click(function(e) {

			// check that your clicked
			// element has no id=info
			// and is not child of info
			if (e.target.id != 'cart' && !$('#cart').has(e.target).length) {
				$(".shopping-cart").hide();
			}
		});
		
		/*$(document).mouseup(function (e){
			var container = $("#cart");
			if (!container.is(e.target) // if the target of the click isn't the container...
				&& container.has(e.target).length === 0) // ... nor a descendant of the container
			{
				$(".shopping-cart").hide();
			}
		});*/
					
			//AUTO CHECK RADIO BUTTON ON CLICK
			$(".sort-menu li").click(function(e) {
				
				e.preventDefault();
				var form = $(this).find('input:radio').closest('form');
				//var formUrl = form.attr('action');
				var $item = $(this).find('input:radio');
				
				//var radio = $(this).find('input:radio');
				//var form = $(this).find('input:radio').closest('form');
				//var form = $(this).closest('form');
				var value = '';
				if(!$item.is(':checked')){
					$item.prop("checked", true);
					value = $item.val();
					if (!$item.parent().parent().hasClass('active')) {
						$(".sort-menu li").removeClass('active');
						$item.parent().parent().addClass('active');
					}
					
				}
				
				/*var url = window.location.href;     // Returns full URL
				//var segments = url.split( '/' );
				var segments = window.location.pathname.split( '/' );
				var func = segments[4];
				var param1 = segments[5];
				var param2 = segments[6];
				
				
				var count = (location.pathname.split('/').length - 1) - (location.pathname[location.pathname.length - 1] == '/' ? 1 : 0);
				
				var splits = url.replace('http://', '').split('/');
				var web = splits[0]+'/'+splits[1]+'/'+splits[2]+'/'+splits[3];
				
				alert('\n\nCount : '+count+'\n\nWeb : http://'+web+'\n\nFunction : '+func+'\n\nParam1 : '+param1+'\n\nParam2 : '+param2);
				//window.location.href = url+"?sort_by="+value;
				
				window.location.href = web+'/'+func+'/'+param1+"/?sort_by="+value;
				
				//window.location.replace(url+"/"+value);
				
				$.post(url,//Required URL of the page on server
				{ // Data Sending With Request To Server
				sort_by:value,param1:param1,param2:param2,
				},
				//function(data,status) {// Required Callback Function
				// 	alert(value);
				//$('#subj_line_'+msgID).addClass('msgRead');
			   //alert("*----Received Data----*\n\nResponse : " + data+"\n\nStatus : " + status); // This line was just for testing
				//}
				);*/
				//alert('Val: '+value+'<br/> URL: '+url);
				//form.submit();
				filterProducts(form);
				//alert(value);
				//test();
				//alert('URL: '+formUrl);
				
				
			});
		
			$(".brands li").click(function(e) {
				e.preventDefault();
				
				//clear all radios
				$(".brands li").removeClass('active');
				$(".brands li").find('input:radio').prop("checked", false);
				
				var radio = $(this).find('input:radio');
				
				if(radio.is(':checked')){
					radio.prop("checked", false);
					$(this).removeClass('active');
					
				}else{
					radio.prop("checked", true);
					$(this).addClass('active');
					var value = $(this).find('input:radio').val();
					var form = $(this).find('input:radio').closest('form');
					var formUrl = form.attr('action');
					//alert(value+' Form: '+formUrl);
					
					//form.submit();
					filterProducts(form);
				}
				
			});
		
			//handle collections filter menu
			//navigate to url		
			$(".filter-column #categories li").click(function(e) {
				
				e.preventDefault();
				//var gender = $(this).find('#gender').val().trim().toLowerCase();
				var gender;
				var category;
				var url;
				
				if($(this).find('input:checkbox').is(':checked')){
					$(this).find('input:checkbox').prop("checked", false);
				}else{
					$(this).find('input:checkbox').prop("checked", true);
				}
				var value = $(this).find('input:checkbox').val();
				//var value = $(this).find('input:checkbox').attr("id").split("-");
				//var url = $(this).find('input:checkbox').attr("href");
				 if (value.indexOf('-') !== -1 ) {
					
					var val = value.split("-");
					gender = val[0].toLowerCase();
					category = val[1].toLowerCase();
					url = baseurl+'collections/'+gender+'/'+category;
				 }else{
					 url = baseurl+'collections/all';
				 /*if(value == 'All Products'){
					url = baseurl+'collections/all';
					if(gender != '' || gender.length > 1){
						url = baseurl+'collections/'+gender+'/all';
					}else{
						
					}
				 }*/
				}
				//var url = baseurl+''+gender+'/'+category;
				
				var $item = $(this);
				if (!$item.hasClass('active')) {
					$(".filter-column #categories li").removeClass('active');
					$item.addClass('active');
				}
				window.location.href = url;
				//alert('Gender: '+gender+' Cat: '+category);
				//e.preventDefault();
			});
			
			//handle collections side menu	
			$(".sidebar-section #cat-menu2 li").click(function(e) {
				
				e.preventDefault();
				
				var value = $(this).find('a').attr("id").split("-");
				var url = $(this).find('a').attr("href");
				
				var gender = value[0];
				var category = value[1];
				
				var $item = $(this);
				if (!$item.hasClass('active')) {
					$(".sidebar-section #cat-menu li").removeClass('active');
					$item.addClass('active');
				}
				window.location.href = url;
				//alert('Gender: '+gender+' Cat: '+category);
				//e.preventDefault();
			});
			
							
			//SIDE MENU CATEGORY FILTER
			$(".category-menu li").click(function(e) {
				e.preventDefault();
				
				//clear all radios
				$(".category-menu li").removeClass('active');
				$(".category-menu li").find('input:radio').prop("checked", false);
				
				var radio = $(this).find('input:radio');
				
				if(radio.is(':checked')){
					radio.prop("checked", false);
					$(this).removeClass('active');

				}else{
					radio.prop("checked", true);
					$(this).addClass('active');
					
					//var value = $(this).find('input:radio').val();
					var form = $(this).find('input:radio').closest('form');
					//alert('Category: '+value);
					
					//form.submit();
					filterProducts(form);
				}
				
			});
			
			
			//Stop event propagation from within the .filter-box area
			/* Click outside to hide the dropdown */
			$(document).on("click", function () {
				$(".filter-box").hide();
			});
			
			//Then prevent those clicks on .filter-box
			//from bubbling up to the document
			$(".filter-box").on("click", function (event) {
				event.stopPropagation();
			});
			//show and hide filter box
			$(".filter-btn").on("click", function (event) {
				//alert('click');
				//stop any clicks on your button from traveling up to the document
				event.stopPropagation();
				event.preventDefault();	
				$('.filter-box').slideToggle(600);		
				$(this).find('i').toggleClass("fa-angle-down fa-angle-up");
				var $this = $(this);
				if (!$this.hasClass('active')) {
					$this.addClass('active');
				}
				/*if ($('.filter-box').is(":hidden")) {
					$(".filter-box").hide();
					$(".filter-box").slideDown("fast"); 
					//$(this).next().show(600);
				} else { 
					//$(".filter-box").slideUp(600); 
					$(".filter-box").hide();
				} */
				//$("html, body").animate({
				//	scrollTop: $(".filter-container").offset().top
				//}, 600);
			});
			
			
			


			//close filter box	
			$(".close-filter-box").click(function (e) { 
				e.preventDefault();
				$('.filter-box').slideUp(600);	
				$(".filter-btn").removeClass("fa-angle-up").addClass("fa-angle-down");	
								
			});

			//$(".sort-radio-box input:radio").prop("checked", true).trigger("click");
			$(document).on('click', '.right-menu .dropdown-menu', function (e) {
			  e.stopPropagation();
			});
			
			//PRODUCT THUMBNAIL HOVER ACTIONS
			$('.products-container').on('mouseenter', '.grid-group-item .item-wrapper', function() {
				//$(this).next('.show').fadeIn(800);
				$(this).find('.social-sharing-btns').show();
				$(this).find('.caption').hide();
			}).on('mouseleave', '.grid-group-item .item-wrapper', function() {
				//$(this).next('.show').delay(800).fadeOut(800);
				$(this).find('.caption').show();
				$(this).find('.social-sharing-btns').hide();
			});
			
			$('.products-container').on('mouseenter', '.grid-group-item .card', function() {
				//$(this).next('.show').fadeIn(800);
				$(this).find('.social-sharing-btns').show();
				$(this).find('.social-sharing-btns ul').show();
				$(this).find('.caption').hide();
			}).on('mouseleave', '.grid-group-item .card', function() {
				//$(this).next('.show').delay(800).fadeOut(800);
				$(this).find('.caption').show();
				$(this).find('.social-sharing-btns').hide();
				$(this).find('.social-sharing-btns ul').hide();
			});
			/*
			$('.products-container .item-wrapper').hover(
			  function() {
				$(this).find('.social-sharing-btns').show();
				$(this).find('.caption').hide();
			  }, function() {
				$(this).find('.caption').show();
				$(this).find('.social-sharing-btns').hide();
			  }
			);
			*/				
			//PRODUCT SIZE OPTIONS FILTER
			$(".sizes li").click(function(e) {
				e.preventDefault();
				
				var all_input = $(this).find('input');
				if(all_input.hasClass("all-sizes")){
					//clear all checkboxes
					$(".sizes li").removeClass('active');
					$(".sizes li").find('input:checkbox').prop("checked", false);
				
				}
				
				//clear all checkboxes
				//$(".sizes li").removeClass('active');
				//$(".sizes li").find('input:checkbox').prop("checked", false);
				
				var checkbox = $(this).find('input:checkbox');
				
				if(checkbox.is(':checked')){
					checkbox.prop("checked", false);
					$(this).removeClass('active');

				}else{
					$(".all-sizes").parent().removeClass('active');
					$(".all-sizes").prop("checked", false);
					
					checkbox.prop("checked", true);
					$(this).addClass('active');
					
					//alert('Size: '+value);
					
					//form.submit();
					
				}
				
					//var value = $(this).find('input:checkbox').val();
					var form = $(this).find('input:checkbox').closest('form');
					filterProducts(form);
			});
							
			//PRODUCT COLOR OPTIONS FILTER
			$(".color-list li").click(function(e) {
				e.preventDefault();
				var all_box = $(this).find('div');
				if(all_box.hasClass("all-colours")){
					//clear all checkboxes
					$(".color-list li").removeClass('active');
					$(".color-list li").find('input:checkbox').prop("checked", false);
				
				}
				
				var checkbox = $(this).find('input:checkbox');
				
				if(checkbox.is(':checked')){
					checkbox.prop("checked", false);
					$(this).removeClass('active');

				}else{
					
					//var all_parent = $(".color-list li").find('.all-colours').parent();
					$(".all-colours").parent().removeClass('active');
					$(".all-colours").find('input:checkbox').prop("checked", false);
					//if(all_parent.hasClass("active")){
					//	all_parent.removeClass('active');
					//}
					checkbox.prop("checked", true);
					$(this).addClass('active');
					
				}
				
					//var value = $(this).find('input:checkbox').val();
					var form = $(this).find('input:checkbox').closest('form');
					//alert('Color: '+value);
					
					//form.submit();
					filterProducts(form);
			});
					
			//show and hide search box	
			$(".sidebar-header").click(function (e) { 
				
				//alert('Search');		
					
				$(this).next().slideToggle(600);
				
				e.preventDefault();
								
			});
			
				
				
			//REDUCE QUANTITY	
			$(".minus-qty").click(function (e) { 
				
				e.preventDefault();
				
				var oldValue = $("#pQty").val().trim();
				var qty_available = $("#q_available").html();
				var newVal;
				
				 // Don't allow decrementing below zero
				if (oldValue > 1) {
					newVal = parseFloat(oldValue) - 1;
				}else {
					newVal = 1;
					
				}
				$("#pQty").val(newVal);
					
								
			});
					
			//ADD QUANTITY	
			$(".plus-qty").click(function (e) { 
				
				var oldValue = $("#pQty").val().trim();
				var qty_available = $("#q_available").html();
				//var qty_left;
				var newVal;
				
				if(oldValue > 99){
					return;
				}else if(oldValue == qty_available){
					//qty_left = parseFloat(qty_available - oldValue);
					//$("#q_available").html(qty_left);
					return;
				}
				else{
					newVal = parseFloat(oldValue) + 1;
					//qty_left = parseFloat(qty_available) - 1;
					
					//qty_left = parseFloat(qty_available) - newVal;
					//$("#q_available").html(qty_left);
					
				}
				$("#pQty").val(newVal);
				 				
			});
			
			
			//*********STARR**********//
			$(".stars").starrr();
			
				
			$('.stars-existing').starrr({
			  rating: $('.stars-count-existing').html(),
			  readOnly: true
			});

			$('.stars').on('starrr:change', function (e, value) {
				$('.stars-count').html(value);
				$('.rating').val(value);
				alert($('.rating').val());
			});
			
			$(".stars-existing").click(function (e) { 
				e.preventDefault();
			});
			//*********STARR**********//
			
			//NEXT AND PREVIOUS	
			
			/*$('.product-nav-control').hover(
			  function() {
				var id = $(this).attr('id');
				var img = $("img."+id);
				//alert(id);
				$(img).show();
			  }, function() {
				var id = $(this).attr('id');
				var img = $("img."+id);
				//alert(id);
				$(img).hide();
			  }
			);*/
				
			$('.product-nav-control').mouseover(function() {
				var thumb = $(this).parent().find('img');
				if (!$(thumb).is(":hidden")) {
					$(thumb).hide();
				}
				var id = $(this).attr('id');
				var img = $("a."+id+" img");
				//alert(id);
				$(img).show();
			});
			  
			$('.next-prev-nav').mouseleave(
			  function() {
				$('img',this).hide();
			  }
			);
			
			/*$(".product-nav-control").click(function (e) { 
				
				e.preventDefault();
				var url = $(this).attr('href');
				window.location.href = url;
				
			});*/
	
			//function to count the number
			// of characters in the comment box
			$("#comment-length").html((500));
			//var limit = $("#comment-length").html();
			$('#review-comment').on('change keypress keyup paste', function (e) {
				
				if($(this).val().length >= 500){
					//$('#review-comment').val($('#review-comment').val().substring(0, 10));
					e.preventDefault();
					$("#comment-length").html((0));
					return false;
				}else{
					$("#comment-length").html((500 - ($(this).val().length)));
				}
				
			});
			
			$('.cart .dropdown-menu').on({
				"click":function(e){
				  e.stopPropagation();
				}
			});
							
			//function to handle remove item from cart
			$('.remove-item').on('click', function (e) { 
			
				//$( "#load" ).show();
				
				// Get the product ID and the index 
				var id = $(this).attr('id').split("-");
				var index = id[0];
				var product_id = id[1];
				
				var $that = $(this);
				
				//alert('Index: '+index+' Product ID: '+product_id);
				
				var url = baseurl+'cart/item_remove';
				var dataString = { 
					index_to_remove : index,
					product_id : product_id
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
							
							//$that.parent().parent().parent().remove();
							
							$(".cart-notif").html(data.notif);
							
							$("html, body").animate({ scrollTop: 0 }, "slow");
							
							$('#cart_contents').html(data.cart_count);
							refreshCart();
							
							
							setTimeout(function() { 
								//$(".cart-notif").slideUp({ opacity: "hide" }, "slow");
								//window.location.reload(true);
							}, 3000);
							
							
						}else if(data.success == false){

							$( "#load" ).hide();
							
							$(".cart-notif").html(data.notif);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
						//location.reload();
					},
				});
			
			});
			
					
			//SCROLL TO COLLECTION HEADER
			$(".collection-nav a").on('click', function(e) {
				
				e.preventDefault();
				
				var id = $(this).attr('class');
				
				//alert(id);
				
				$('html, body').animate({
					scrollTop: $('#'+id).offset().top - 100
				}, 2000);
			});
		
			
	
	});	

							
			//function to handle remove item from cart
			function removeItem(obj,i,id){ 
			
				//$( "#load" ).show();
				
				// Get the product ID and the index 
				//var id = $(this).attr('id').split("-");
				var index = i;
				var product_id = id;
				
				var $that = $(obj);
				
				//alert('Index: '+index+' Product ID: '+product_id);
				
				var url = baseurl+'cart/item_remove';
				var dataString = { 
					index_to_remove : index,
					product_id : product_id
				};
				
				$.ajax({
					type: "POST",
					url: url,
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){
						
						refreshCart();
						
						if(data.success == true){
							
							$( "#load" ).hide();
							
							//$that.parent().parent().parent().remove();
							
							$(".notif").html(data.notif);
							
							$("html, body").animate({ scrollTop: 0 }, "slow");
							
							$('#cart_contents').html(data.cart_count);
							
							
							
							setTimeout(function() { 
								//$(".cart-notif").slideUp({ opacity: "hide" }, "slow");
								//window.location.reload(true);
							}, 3000);
							
							
						}else if(data.success == false){

							$( "#load" ).hide();
							
							$(".cart-notif").html(data.notif);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
						//location.reload();
					},
				});
			
			}
					
		//open rating tab on click
		//rating
		function showRating(tab){
			$("html, body").animate({
				scrollTop: $(".nav-pills").offset().top - 150
			}, 600);
			$('.nav-pills a[href="#' + tab + '"]').tab('show');
			
		}
		

	  
		$(document).ready(function() {
			
			//get window width
			var contentWidth = $('body').width();
			
			$(window).on('resize', function(){
				  updateContainer();
			});
			
			
			//HANDLE SHOW MORE BUTTON ALL PRODUCTS PAGE
			var divRow = $(".products-display-wrapper .row .item");
			var btnMore = $(".btn-more");
			var rowLength = divRow.length;
			var currentIndex;
			
			divRow.hide();
			//divRow.slideUp(600);
			
			//divRow.slice(0, 1).slideDown(600);
			
			//laptop view
			if(contentWidth > 1024){
				currentIndex = 3;
				divRow.slice(0, 3).show(); 
			}
			//tablet view
			if(contentWidth > 767 && contentWidth < 1024){
				currentIndex = 2;
				divRow.slice(0, 2).show(); 
			}
			//mobile hd and ld view
			if(contentWidth <= 767){
				currentIndex = 2;
				divRow.slice(0, 2).show(); 
			}
			
			moreButtonAction();
			
		
			if(rowLength > 1){
				btnMore.show();
			}else{
				btnMore.hide();
			}
			
			
			
			$(document).on('click', '.btn-more', function (e) {
			 e.preventDefault();
				//$(".products-display-wrapper .row .item").slice(currentIndex, //currentIndex + 1).show();
				//currentIndex + 3).slideDown(600);
				//currentIndex += 3;
				//laptop view
				if(contentWidth > 1024){
					$(".products-display-wrapper .row .item").slice(currentIndex, currentIndex + 3).slideDown(600);
					currentIndex += 3;
				}
				//tablet view
				if(contentWidth > 767 && contentWidth < 1024){
					$(".products-display-wrapper .row .item").slice(currentIndex, currentIndex + 2).slideDown(600);
					currentIndex += 2;
				}
				//mobile hd and ld view
				if(contentWidth <= 767){ 
					$(".products-display-wrapper .row .item").slice(currentIndex, currentIndex + 2).slideDown(600);
					currentIndex += 2;
				}
			
				
				moreButtonAction();
			});
			
			//btnMore.click('',function (e) { 
			
			
			$(document).on('load', '.products-display-wrapper .row .item', function (e) {
				$(".products-display-wrapper .row .item").hide();
				//$(".products-display-wrapper .row .item").slice(0, 3).show(); 
				//laptop view
				if(contentWidth > 1024){
					$(".products-display-wrapper .row .item").slice(0, 3).show();
				}
				//tablet view
				if(contentWidth > 767 && contentWidth < 1024){
					$(".products-display-wrapper .row .item").slice(0, 2).show();
				}
				//mobile hd and ld view
				if(contentWidth <= 767){ 
					$(".products-display-wrapper .row .item").slice(0, 2).show();
				}
			});
			
			
	
		});	
		
		function updateContainer() {
			
			var contentWidth = $('body').width();
			
			//HANDLE SHOW MORE BUTTON ALL PRODUCTS PAGE
			var divRow = $(".products-display-wrapper .row .item");
			var btnMore = $(".btn-more");
			var rowLength = divRow.length;
			var currentIndex;
			
			divRow.hide();
			
			//laptop view
			if(contentWidth > 1024){
				currentIndex = 3;
				divRow.slice(0, 3).show(); 
			}
			//tablet view
			if(contentWidth > 767 && contentWidth < 1024){
				currentIndex = 2;
				divRow.slice(0, 2).show(); 
			}
			//mobile hd and ld view
			if(contentWidth <= 767){
				currentIndex = 2;
				divRow.slice(0, 2).show(); 
			}
			
			if(rowLength > 1){
				btnMore.show();
			}else{
				btnMore.hide();
			}
			
			moreButtonAction();
			
		}
		
		//SHOW MORE BUTTON
		function moreButtonAction() {
			var currentLength = $(".products-display-wrapper .row .item:visible").length;
			var totalLength = $(".products-display-wrapper .row .item").length;
			var rowLength = $(".products-display-wrapper .row .item").length;
			
			if (totalLength < 2 || currentLength >= rowLength) {
				$(".btn-more").hide();            
			}
			else {
				$(".btn-more").show();   
			}
			
		}

		
				
		$(document).ready(function() {
		
			//get window width
			var contentWidth = $('body').width();
			
			$(window).on('resize', function(){
				  //updateContainer();
			});
			
			$('.collection-display').each(function () {
				
				var btnMore = $(this).next().find(".show-more");
				var rowLength = $(this).find('.row .collection-item').length;
				
				$(this).find('.row .collection-item').hide();
				$(this).find('.row .collection-item').slice(0, 3).show();
				
				showMoreAction();
				
				//btnMore.hide();	
				if(rowLength > 3){
					btnMore.show();
				}else{
					btnMore.hide();
				}
			
			});
			
			//HANDLE SHOW MORE BUTTON COLLECTION PAGE
		/*	var divRow = $(".collection-display .row .collection-item");
			var btnMore = $(".show-more");
			var rowLength = divRow.length;
			
			divRow.hide();
			//divRow.slideUp(600);
			
			//divRow.slice(0, 1).slideDown(600);

			//moreButtonAction();
			
		
			if(rowLength > 1){
				btnMore.show();
			}else{
				btnMore.hide();
			}
			
			*/
			$(document).on('click', '.show-more', function (e) {
			 e.preventDefault();
				var $table = $(this).parent().prev();
				$table.find('.row .collection-item').slideDown(600);
				
				//var btn = $(this).parent().find(".show-less");
				//$(this).hide();
				showMoreAction();
			});
			
				
			
			//$(document).on('click', '.collection-section .show-more', function (e) {
			//  e.stopPropagation();
			//});
			
			/*$(".show-more").click(function (e) {
				//alert('More');
				e.preventDefault();
				//var $table = $(this).parent().parent().parent().prev('div').find('table');
				var $table = $(this).parent().parent().find(".collection-display");
				$table.find('.row').slideDown(600);
				
				//var btn = $(this).parent().find(".show-less");
				$(this).hide();
				//btn.show();
				
			});		*/	
			
	
		});	
		
		
		//SHOW MORE BUTTON
		function showMoreAction() {
			
			/*
			var currentLength = $(".collection-display .row .collection-item:visible").length;
			var totalLength = $(".collection-display .row .collection-item").length;
			var rowLength = $(".collection-display .row .collection-item").length;
			
			if (totalLength < 3 || currentLength >= rowLength) {
				$(".show-more").hide();            
			}
			else {
				$(".show-more").show();   
			}
			*/
			$('.collection-display').each(function () {
				
				var btnMore = $(this).next().find(".show-more");
				
				var currentLength = $(this).find(".row .collection-item:visible").length;
				var totalLength = $(this).find(".row .collection-item").length;
				var rowLength = $(this).find(".row .collection-item").length;
			
				if (totalLength < 3 || currentLength >= rowLength) {
					btnMore.hide();            
				}
				else {
					btnMore.show();   
				}
			
			
			});
			
		}
		
				
			
		$(document).ready(function() {
			
			/*$(".share-icon").hover(function(){
				$(this).closest(".social-sharing-btns").next().find('.sharing-icons').show();
			},function(){
				$(this).closest(".social-sharing-btns").next().find('.sharing-icons').hide();
			});*/
			$(".share-icon").hover(function(){
				$(this).closest(".social-sharing-btns").next().find('.sharing-icons').show();
			});
			$(".social-icon").not('.share-icon').hover(function(){
				$(this).closest(".social-sharing-btns").next().find('.sharing-icons').hide();
			});
			
			//$('.share-icon').mouseover(function() {
			//	var icons = $(this).closest(".social-sharing-btns").next().find('.sharing-icons');
			//	if (!$(icons).is(":hidden")) {
				//	$(icons).hide();
			//	}
				
				//alert(id);
			//	icons.show();
			//});
			  
			$('.thumbnail').mouseleave(
			  function() {
				//$('img',this).hide();
				$(this).find('.sharing-icons').hide();
			  }
			);
			  
			$('.card-content').mouseleave(
			  function() {
				//$('img',this).hide();
				$(this).find('.sharing-icons').hide();
			  }
			);
			
			$('.social-sharing-btns').on('mouseenter', '.share-icon', function() {
				//$(this).closest(".social-sharing-btns").next().find('.sharing-icons').show();
				//$(".sharing-icons").show(); 
				//$(this).find('.social-sharing-btns').show();
				//$(this).find('.caption').hide();
			}).on('mouseleave', '.grid-group-item .item-wrapper', function() {
				//$('.sharing-icons').hide(); 
				
			});
			
			
			$(".cart-toggle").click(function (e) {
				//alert('More');
				
				e.preventDefault();
				var form = $(this).siblings('input').closest('form');
				
				var id =  form.find('#product_id').val();
				var qty =  form.find('#pQty').val();
				var quantityAvailable =  form.find('#quantityAvailable').val();
				var price =  form.find('#product-price').val();
				var product_name =  form.find('#product_name').val();
				var colour =  form.find('#product-colour').val();
				var size =  form.find('#product-size').val();
				var url = form.attr('action');
				
				if(qty > quantityAvailable){
					$("#notif-message").html('This item is available in limited quantity ! You cannot select more than '+ quantityAvailable+' units');
				}else{
					//alert('ID: '+id+' Name: '+product_name);
					addToCart(id,qty,price,product_name,colour,size,url);
				}
				
			});			
					
			//$(".cart-overlay").hide();		
			//$(".shopping-bag").hide();	
			
			$(document).on('click', '.shopping-bag', function(e){
				
				
				//var myClass = $(this).attr("class");
				//alert(myClass);
				e.stopPropagation();
				//$('.shopping-bag').show();
			});		
	
			$(document).on('click', '.cart-overlay', function(e){

				e.preventDefault();
				$(this).hide();
				$(this).next().hide();
			});
		
			
			$(".product-options-toggle").click(function (e) {
				//alert('More');
				e.preventDefault();
				$('.product-options').hide();
				$('.item-wrapper').show();
				$(this).closest(".item-wrapper").prev().fadeIn(500);
				//$(this).closest(".item-wrapper").prev('.item-wrapper-overlay').fadeIn(500);				
				//$(this).closest(".item-wrapper").css({ opacity: 0.5 });;
				//$(this).closest(".item-wrapper").addClass("transparent-black-bg");
				//$(this).closest(".item-wrapper").css('background-color','#000');
				//$(this).closest(".item-wrapper").css('opacity','0.5');
				//$(this).closest(".item-wrapper").hide();
				//$(this).closest(".item-wrapper").next().show();
				setTimeout(function() { 
					$(this).closest(".item-wrapper").hide();
					$(this).closest(".item-wrapper").next().show();
				}, 1000);
				//$('.item-wrapper').hide();
				//$('.product-options').show();
				
			});			
		
			
			$(document).on('click', '.add-product-options', function(e){
				//alert('More');
				e.preventDefault();
				$('.product-options').hide();
				//$('.item-wrapper').show();
				$('.card-wrapper').show();
				//$(this).closest(".item-wrapper").prev().fadeIn(5);
				$(this).closest(".card-wrapper").prev().fadeIn(5);
				//$(this).closest(".item-wrapper").prev('.item-wrapper-overlay').fadeIn(500);				
				//$(this).closest(".item-wrapper").css({ opacity: 0.5 });;
				//$(this).closest(".item-wrapper").addClass("transparent-black-bg");
				//$(this).closest(".item-wrapper").css('background-color','#000');
				//$(this).closest(".item-wrapper").css('opacity','0.5');
				//$(this).closest(".item-wrapper").hide();
				//$(this).closest(".item-wrapper").next().show();
				setTimeout(function() {
					/*$(this).closest(".item-wrapper").prev().hide();
					$(this).closest(".item-wrapper").hide();
					$(this).closest(".item-wrapper").next().find('.product-options').show();
					*/
					$(this).closest(".card-wrapper").prev().hide();
					$(this).closest(".card-wrapper").hide();
					$(this).closest(".card-wrapper").next().find('.product-options').show();
				}, 500);
			});
			
			$(document).on('click', '.close-product-options', function(e){	
				//alert('More');
				e.preventDefault();
				$(this).closest(".product-options").hide();
				$(this).closest(".product-options").parent().prev().show();
				$('.card-content').show();
				//$('.product-options').hide();
				//$('.item-wrapper').show();
				
			});			
			

		});
						
			
			function toggleOptions(obj, e) {
				//alert('More');
				e.preventDefault();
				$('.product-options').hide();
				$('.item-wrapper').show();
				$(obj).closest(".item-wrapper").prev().fadeIn(5);
				//$(this).closest(".item-wrapper").prev('.item-wrapper-overlay').fadeIn(500);				
				//$(this).closest(".item-wrapper").css({ opacity: 0.5 });;
				//$(this).closest(".item-wrapper").addClass("transparent-black-bg");
				//$(this).closest(".item-wrapper").css('background-color','#000');
				//$(this).closest(".item-wrapper").css('opacity','0.5');
				//$(this).closest(".item-wrapper").hide();
				//$(this).closest(".item-wrapper").next().show();
				setTimeout(function() {
					$(obj).closest(".item-wrapper").prev().hide();
					$(obj).closest(".item-wrapper").hide();
					$(obj).closest(".item-wrapper").next().find('.product-options').show();
				}, 500);
				//$('.item-wrapper').hide();
				//$('.product-options').show();
				
			}			
			
			
			function showOptions(obj, e) {
				//alert('More');
				e.preventDefault();
				$('.product-options').hide();
				$('.card-wrapper').show();
				$('.card-content').show();
				//var $item = $(obj).closest(".item");
				
				$(obj).closest(".card-wrapper").prev().fadeIn(5);
				if ($(obj).closest(".item").is( ".grid-group-item" ) ) {
					setTimeout(function() {
						$(obj).closest(".card-wrapper").prev().hide();
						$(obj).closest(".card-wrapper").hide();
						//$(obj).closest(".card-content").hide();
						$(obj).closest(".card-wrapper").next().find('.product-options').show();
					}, 500);
				}else{
					setTimeout(function() {
						$(obj).closest(".card-wrapper").prev().hide();
						$(obj).closest(".card-content").hide();
						//$(obj).closest(".card-content").hide();
						$(obj).closest(".card-wrapper").next().find('.product-options').show();
					}, 500);
				}
				//$(this).closest(".item-wrapper").prev('.item-wrapper-overlay').fadeIn(500);				
				//$(this).closest(".item-wrapper").css({ opacity: 0.5 });;
				//$(this).closest(".item-wrapper").addClass("transparent-black-bg");
				//$(this).closest(".item-wrapper").css('background-color','#000');
				//$(this).closest(".item-wrapper").css('opacity','0.5');
				//$(this).closest(".item-wrapper").hide();
				//$(this).closest(".item-wrapper").next().show();
				
				//$('.item-wrapper').hide();
				//$('.product-options').show();
				
			}			
			
		function addToWishlist(id,name,price,url){
			
			$("#notif-message").html('');
			
			//alert('URL:'+ url);
			$( "#load" ).show();
			
			var dataString = { 
				product_id : id,
				product_name : name,
				product_price : price,
				url : url
			};
			
			$.ajax({
				type: "POST",
				url: baseurl+'collections/add_to_wishlist',
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					
					if(data.success == true){
						$( "#load" ).hide();
						
						$("html, body").animate({ scrollTop: 0 }, "slow");
						
						$("#notif-message").html(data.notif);
						setTimeout(function() { 
							$("#notif-message").slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 3000);
						
						
					}else if(data.success == false){
						$( "#load" ).hide();
						
						//var url = window.location.href;     // Returns full URL
						//var url = data.current_url;
						
						$("#notif-message").html(data.notif);
						setTimeout(function() { 
							//$("#notif-message").slideUp({ opacity: "hide" }, "slow");
							//window.location.replace(baseurl+'login?redirectURL='+data.current_url);
							window.location.href = baseurl+'login?redirectURL='+url;
						}, 3000);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}
		

		//function addToCart(id,qty,price,product_name,colour,size,url)
		//function to handle submit add to cart form
		function addToCart(obj) { 
			
			var form = $(obj).closest('form');
				
			var id =  form.find('#product_id').val();
			var qty =  form.find('#pQty').val();
			var quantityAvailable =  form.find('#quantityAvailable').val();
			var price =  form.find('#product_price').val();
			var product_name =  form.find('#product_name').val();
			var colour =  form.find('#product_color').val();
			var size =  form.find('#product_size').val();
			var url = form.attr('action');
			//var form = $(obj).siblings('input').closest('form');
			//var id = $(this).attr('id');
			//var product_name =  form.find('#product_name').val();
			//alert(product_name);
			
			//var form = $(obj).prev('input:hidden').closest('form');
			//var form = $(obj).closest('form');
			
			$( "#load" ).show();
			// Get the product ID and the quantity $(obj).find
			
			
			var dataString = { 
				product_id : id,
				cart_quantity : qty,
				product_price : price,
				product_name : product_name,
				colour : colour,
				size : size
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
						$('#cart_quantity').val('');
						$('#product-price').val('');	
						$('#product-colour').val('');
						$('#product-size').val('');
						$("html, body").animate({ scrollTop: 0 }, "slow");
						
						$('#cart_contents').html(data.cart_count);

						var qty = $('#q_available').html();
						var newQty = qty - data.qty;
						$('#q_available').html(newQty);
						$("#notif-message").html(data.notif);
						
						//update display of cart content
						getCart();
						
						//$('.your-cart').html(data.shopping_cart);
						//$('ul li.cart').addClass('open');
						//$('.cart-overlay').show();
						//$('.shopping-bag').show();
						//$('.shopping-bag').show('slide',{direction:'right'},1000);
						
						setTimeout(function() { 
							
							
							
							$("#notif-message").slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
							//$('ul li.cart').removeClass('open');
						}, 600);
						
						
					}else if(data.success == false){

						$("#notif-message").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}	
		
		
	//function to handle submit contact us form
	//updateCart(id)
	function updateCart(obj) { 
	
		var error = '';
		var isFormValid = true; 
		
		
		var form = $(obj).closest('form');
				
		var item =  form.find('#item_to_adjust').val();
		var qty =  form.find('#quantity').val();
		var index =  form.find('#index').val();
		var size =  form.find('#product_size').val();
		var colour =  form.find('#product_colour').val();
		
		alert('ITEM ID: '+item+'; QTY: '+qty+'; INDEX: '+index+'; Color: '+colour+'; Size: '+size);
		
		$( "#load" ).hide();
		
		//var form = $(this).closest('form');
		//form.find('#product_name').val()
		//var item = $(this).siblings().find('#item_to_adjust').val();
		//var item = $('#item_to_adjust'+id).val();
		//var qty = $('#quantity'+id).val();
		//var index = $('#index'+id).val();
		
		//alert('ITEM: '+item+'; QTY: '+qty+'; INDEX: '+index);
		
		// Get the product ID and the quantity 
		var url = $('#update_cart_form').attr('action');
		var dataString = { 
			item_to_adjust : item,
			quantity : qty,
			colour : colour,
			size : size,
			index : index
		};
		
		$.ajax({
			type: "POST",
			url: url,
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){

				
				if(data.success == true){
					
					$(".notif").html(data.notif);
					
					//$("html, body").animate({ scrollTop: 0 }, "slow");	
					$('html, body').animate({
						scrollTop: $(".collection-banner-caption").offset().top
					}, 2000);
					
					setTimeout(function() { 
						$( "#load" ).hide();
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


				
			function getCart() {
				//$('.your-cart').show();
				//alert('More');
				//$('#shoppingBag').html('More');
				
			//	$(this).parent().toggleClass('open class');
			//	e.preventDefault();
				//$('.cart-cover').show("fast");
				
				//$('.shopping-bag').show('slide',{direction:'right'},1000);
				var dataString = { 
					url : baseurl+'cart/get_cart'
				};
				
				$.ajax({
					type: "POST",
					url: baseurl+'cart/get_cart',
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							//$('#shoppingBag').html('T');
							
							//$('.shopping-bag').css('visibility', 'visible');
							//$('.shopping-bag').show();
							
							$('.cart-overlay').show();
							$('.shopping-bag').show();
							
							$('.cart-loading').show();
						
							setTimeout(function() { 
								$('.cart-loading').hide();
								$('.your-cart').html(data.shopping_cart);

							}, 600);
							
							
							//$('.shopping-bag').show('slide',{direction:'right'},600);
						}else if(data.success == false){
							
							//$('#shoppingBag').html('F');
							$('.your-cart').html(data.shopping_cart);
							$('.cart-overlay').show();
							$('.shopping-bag').show();
							//$('.shopping-bag').show('slide',{direction:'right'},600);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
						//location.reload();
					},
				});
			}			
				

				
			function refreshCart() {
				
				var dataString = { 
					url : baseurl+'cart/get_cart'
				};
				
				$.ajax({
					type: "POST",
					url: baseurl+'cart/get_cart',
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							
							$('.your-cart').html(data.shopping_cart);
							
						}else if(data.success == false){
							
							$('.your-cart').html(data.shopping_cart);
							
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
						//location.reload();
					},
				});
			}			
					
		
			
		//function to submit review
		//to db via ajax
		function submitReview(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('review_form'));
			
			var validate_url = $('#review_form').attr('action');
			
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
						
						$('.rating').val('');
						$("#review-name").val('');
						$("#review-email").val('');
						$("#review-comment").val('');
						
						$( "#load" ).hide();
						
						$("#notif").html(data.notif);
						
						setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							$("html, body").animate({ scrollTop: 0 }, "slow");
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						/*setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							
						}, 8000);*/
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
	
				
		//function to pass gender to hidden
		//input
		$(document).ready(function() {
		
			$('.men').on("click", function(e){ //
				e.preventDefault(); 
				var gender = 'male';
				alert(gender);
				$("#cModel").val(gender);
			});
			
			$('.women').on("click", function(e){ //
				e.preventDefault(); 
				var gender = 'female';
				alert(gender);
				$("#cModel").val(gender);
			});
			
		});	
		
		

		
		$(document).ready(function() {
				//search job listings function			
			//$('.colour_name,.sort-by,.col-size,.brand-name').change(filterProducts);
			//$('input').change(filterProducts);
			// trigger the event
		//	$(".colour_name,.sort-by,.col-size,.brand-name").trigger("change");
			//$("input").trigger("change");	
			
			//
			//***********GRID AND LIST PRODUCT TOGGLE***********//// 
			//
			//***********LIST PRODUCT TOGGLE***********//// 
			$('#list').click(function(event){
				event.preventDefault();
				var $this = $(this);
				if (!$this.hasClass('active')) {
					$('.btn-group a').removeClass('active');
					$this.addClass('active');
				}
				//alert('List');
				$('.products .item').addClass('list-group-item');
				$('.products .item').removeClass('grid-group-item');
				//$('.product-details').show();
				//$('.caption').show();
				//$('.social-sharing-btns').show();
				
			});
			
			//***********GRID PRODUCT TOGGLE***********//// 
			$('#grid').click(function(event){
				event.preventDefault();
				var $this = $(this);
				if (!$this.hasClass('active')) {
					$('.btn-group a').removeClass('active');
					$this.addClass('active');
				}
				//alert('Grid');
				$('.products .item').removeClass('list-group-item');
				$('.products .item').addClass('grid-group-item');
			});
	
			//
			//***********END GRID AND LIST PRODUCT TOGGLE***********//// 
			//
			
			
$(".sort-menu li a").click(function() {
   $(".sort-by-btn").dropdown("toggle");
});
			
		
		});
					
	
	function filterProducts(obj){
			
			
			var gender = $(obj).find('[name=gender]').val();
			var id = $(obj).attr('id');
			var url = $(obj).attr('action');
			
			//var sort = $(obj).find('input[name=sort-by]:checked').val();
			var sort = $('input[name=sort_by]:checked').val();
			
			//alert('Gender: '+gender+', ID: '+id+' Sort: '+sort);
			
			//e.preventDefault();
			//var form = $(this).find('input:radio').closest('form');
			//var form = $(this).closest('form');
			//var gender = $('#gender1').val();
			//var id = $(obj).attr('id');
			//var gender = $(obj).find('[name=gender]').val();
			//var gender = form.find('input:hidden').val();
			var loader = baseurl+'assets/images/gif/plz_wait.gif';
			$(".products-display-wrapper").html('<center><img src="'+loader+'"></center>');
			
			/*
			var categoriesArray = [];
			$(form).find('#categories :input:checked').each(function(){
				var category = $(this).val();
				categoriesArray.push(category);
						
			});
			
			var brandsArray = [];
			$(form).find('.brands :input:checked').each(function(){
				var brand = $(this).val();
				brandsArray.push(brand);
						
			});
			
			var colorsArray = [];
			$(form).find('.color-list :input:checked').each(function(){
				var color = $(this).val();
				colorsArray.push(color);
						
			});
			
			var sizesArray = [];
			$(form).find('.sizes :input:checked').each(function(){
				var size = $(this).val();
				 if (size.indexOf('-') !== -1 ) {
					
					var value = size.split("-");
					gender = value[0];
					size = value[1];
					       
				 }
				sizesArray.push(size);
						
			});
			*/
			//find the form name
			//var filterForm = this.form;
			//alert('Form: '+id);
			
			//if(gender != '' || gender.length > 0){
			//	alert(gender);
			//}
			
			
			//get values from form
			var form = new FormData(document.getElementById(id));
			
		/*	var dataString = { 
					brands : brandsArray,
					colours : colorsArray,
					sizes : sizesArray,
					gender : gender,
					sort_by : $(form).find(".sort-by").val(),
				};*/
			//var validate_url = baseurl+'collections/filter_search';	
			var validate_url = url;	
			//var validate_url = $('#'+id).attr('action');
			
			
			//alert(validate_url);
			
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
					
					//alert('Ajax Function');
					
					if(data.success == true){
						
					//	alert('True');
						$(".filter-title").html(data.title);
						$(".products-count").html(data.count);
						$("html, body").animate({
							scrollTop: $(".products-display-wrapper").offset().top - 150
						}, 600);
						setTimeout(function() { 
							$(".products-display-wrapper").html(data.product_display);
						}, 300);	
								
					}else if(data.success == false){
						//alert('False');
						$( "#load" ).hide();
						$(".filter-title").html(data.title);
						//$(".job_listings").css("visibility", "visible");
						$(".products-count").html(data.count);
						$("html, body").animate({
							scrollTop: $(".products-display-wrapper").offset().top - 150
						}, 600);
						$(".products-display-wrapper").html(data.product_display);
						
					}
								
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
			
			return; 
			
		}
		
		$(document).ready(function(){ // this will be called when the DOM is ready
		
				
				
			//REDUCE OR ADD QUANTITY	
			$(".plus-minus").click(function (e) { 
				
				e.preventDefault();
				
				var quantityAvailable = parseInt($(this).closest('form').find('input[name="quantity_available"]').val());
				var fieldName = $(this).attr('data-field');
				var type = $(this).attr('data-type');
				var input = $(this).closest('form').find('input[name="quantity"]');
				//var oldValue = $("#pQty").val().trim();
				//var qty_available = $("#q_available").html();
				var newVal;
				
				var currentVal = parseInt(input.val());
				if (!isNaN(currentVal)) {
					if(type == 'minus') {
						if(currentVal > 1) {
							//input.val(currentVal - 1).change();
							newVal = parseInt(currentVal) - 1;
							input.trigger("change");
						} 
						if(parseInt(input.val()) == 1) {
							$(this).attr('disabled', true);
							newVal = 1;
						}
					} 
					else if(type == 'plus') {

						if(currentVal < quantityAvailable) {
							newVal = parseInt(currentVal) + 1;
							input.trigger("change");
						}
						if(parseInt(input.val()) == quantityAvailable) {
							$(this).attr('disabled', true);
							newVal = quantityAvailable;
						}

					}
					input.val(newVal);
				}
				
			});
			
			//search job listings function			
			//$('#search_keywords,#search_location,.filter_job_types').change(filterJobSearch);
			
			//if($(".input-quantity").val().trim() != ''){
			//	$(".input-quantity").trigger("change");
			//}
			//quantityChange
			$(".input-quantity").on('keyup paste change', quantityChange);
			
			
			
			$('#product_price,#pPrice').on("keyup change paste", function() {
				
				if($(this).val().length != 0 ){
					var price = commaSeparateNumber($(this).val());
					$(this).val(price);					
				}
			});	
			
			
			var inp = $("input[name='quantity']");
			var val = parseInt(inp.val());
			if(val > 1){
				$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
			}
			//minus and plus
			$('.btn-number').click(function(e){
				e.preventDefault();
				
				
				var quantityAvailable = parseInt($(this).parent().siblings("input#quantityAvailable").val());
				var fieldName = $(this).attr('data-field');
				var type = $(this).attr('data-type');
				//$(this).siblings('input').
				//var input = $("input[name='"+fieldName+"']");
				var input = $(this).parent().siblings('input[name="quantity"]');
				
				var currentVal = parseInt(input.val());
				if (!isNaN(currentVal)) {
					if(type == 'minus') {
						if(currentVal > 1) {
							input.val(currentVal - 1).change();
						} 
						if(parseInt(input.val()) == 1) {
							$(this).attr('disabled', true);
						}
					} else if(type == 'plus') {

						if(currentVal < quantityAvailable) {
							input.val(currentVal + 1).change();
						}
						if(parseInt(input.val()) == quantityAvailable) {
							$(this).attr('disabled', true);
						}

					}
				} else {
					input.val(0);
				}
			});
			
			$('.input-number').focusin(function(){
			   $(this).data('oldValue', $(this).val());
			});
			$('.input-number').change(function() {
				
				var quantityAvailable = parseInt($(this).siblings("input#quantityAvailable").val());
				
				minValue =  1;
				maxValue =  quantityAvailable;
				valueCurrent = parseInt($(this).val());
				
				name = $(this).attr('name');
				if(valueCurrent >= minValue) {
					$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
				} else {
					alert('Sorry, the minimum value was reached');
					$(this).val($(this).data('oldValue'));
				}
				if(valueCurrent <= maxValue) {
					$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
				} else {
					alert('Sorry, the maximum value was reached');
					$(this).val($(this).data('oldValue'));
				}
				
				
			});	
			
			$(".input-number").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});		
					
						
			

		});	
	
	var quantityChange = function () {
					
		var quantityAvailable = parseInt($(this).closest('form').find('input[name="quantity_available"]').val());
				
		minValue =  1;
		maxValue =  quantityAvailable;
		valueCurrent = parseInt($(this).val());
				
		name = $(this).attr('name');
		if(valueCurrent >= minValue) {
			$(".plus-minus[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
					//alert('Sorry, the minimum value was reached');
					$(this).val(valueCurrent);
		}
		if(valueCurrent <= maxValue) {
					$(".plus-minus[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
		} else {
			//alert('Sorry, the maximum value was reached');
			$(this).val(valueCurrent);
		}
					
	}
		
	
	//function to remove wishlist item
	function deleteWishListItem(id) { 
		
		$( "#load" ).show();
		
		var dataString = { 
			id : id,
		};

		$.ajax({
			type: "POST",
			url: baseurl+"account/delete_wishlist",
			data: dataString,
			dataType: "json",
			cache : false,
			success: function(data){

				if(data.success == true){
					$( "#load" ).hide();
					
					if($('#'+id).hasClass('btn-circle')){
						$('#'+id).parent().parent().parent().remove();
					}
					$('html, body').animate({
						scrollTop: $(".collection-banner-text").offset().top
					}, 2000);	
					$("#notif-message").html(data.notif);
					setTimeout(function() { 
						$("#notif-message").fadeOut("slow");
					}, 2000);
							  
					setTimeout(function() { 
						window.location.reload(true);
					}, 2000);
				}else if(data.success == false){
					$( "#load" ).hide();
					$('html, body').animate({
						scrollTop: $(".collection-banner-text").offset().top
					}, 2000);	
					$("#notif-message").html(data.notif);
					setTimeout(function() { 
						$("#notif-message").fadeOut("slow");
					}, 2000);
				}
					
			},error: function(xhr, status, error) {
				$( "#load" ).hide();
				//alert(error);
				//location.reload();
			},
		});
	
	}		

			