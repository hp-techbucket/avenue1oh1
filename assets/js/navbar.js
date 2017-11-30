

		$(document).ready(function() {	

			
			$(window).on('scroll',function() {
				$('.navbar-info').show();
				
				var navbar = $('.navbar-wrapper').find('.navbar-white');
				
				//FLOAT NAVBAR ONCE USER SCROLLS
				if ($(this).scrollTop() > 200) {
					
					navbar.addClass('navbar-fixed-top');
					navbar.css('opacity','0.8');
					$('.navbar-wrapper').find('.navbar-info').hide();
					
					navbar.hover(
						function() {
							navbar.css('opacity','1');
						},
						function() {
						   navbar.css('opacity','0.8');
						}
					);
					
				} else {
					
					navbar.removeClass('navbar-fixed-top');
					navbar.css('opacity','1');
					$('.navbar-wrapper').find('.navbar-info').show();
					
				}
			});
			
			/*
			//FLOATING NAVBAR ACTIONS
			//CLONE ORIGINAL NAVBAR
			$('.navbar-wrapper').addClass('original').clone().insertAfter('.navbar-wrapper').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','50').removeClass('original').hide();
			$('.cloned').find('.navbar-brand img').css('width','95px').css('height','65px');
			//$('.cloned').find('.navbar-nav li a').css('padding','25px');
			 var orgElementPos = $('.original').offset();
			  //orgElementTop = orgElementPos.top;        
			    
			$(window).scroll(function() {
				$('.navbar-info').show();
				
				//GET WINDOW WIDTH
				var contentWidth = $(window).width();
				
				//FLOAT NAVBAR ONCE USER SCROLLS
				if ($(this).scrollTop() > 200) {
					orgElement = $('.original');
					coordsOrgElement = orgElement.offset();
					leftOrgElement = coordsOrgElement.left;  
					widthOrgElement = orgElement.css('width');
					$('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
					var navbar = $('.cloned').find('.navbar-white');
					navbar.css('opacity','0.8');
					$('.cloned').find('.navbar-info').hide();
					
					navbar.hover(
						function() {
							navbar.css('opacity','1');
						},
						function() {
						   navbar.css('opacity','0.8');
						}
					);
					//RESPONSIVE LOGO OPTION FOR MOBILE DEVICES
					if(contentWidth < 480){
						$('.cloned').find('img').css('width','95%').css('height','95%');
					}
					$('.original').css('visibility','hidden');
					
				} else {
					//$('.original').find('.navbar-info').css('visibility','visible');
					//$('.navbar-info').show();
					$('.cloned').hide();
					$('.original').css('visibility','visible');
				}
			});
			*/
						
			// Create a clone of the menu, right next to original.
		//	$('.navbar-wrapper').addClass('original').clone().insertAfter('.navbar-wrapper').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();
			
		//	scrollIntervalID = setInterval(stickIt, 100);

		});	
		