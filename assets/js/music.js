var audio,seeking=false, seekto;
var seekslider;
var current = 0;
var len = $('.playlist li').length;
var randomLi = Math.floor(Math.random() * (len - current)) + current;

//autoplay audio only on chichi page
if($("#chichi").length > 0 || $("#yay").length > 0){
    $(document).ready(function(){
		initAudio($('.playlist li').eq(randomLi));
    });
}

//Hide Pause Initially
$('.pause').hide();
$('#pause-button').hide();
$('#audio-hide').hide();
	
//Initializer - Play First Song
//initAudio($('.playlist li:first-child'));




function initAudio(element){
	var song = element.attr('song');
    var title = element.text();
    var cover = element.attr('cover');
    var artist = element.attr('artist');
	seekslider = document.getElementById("seekslider");
	
	//Create a New Audio Object
	audio = new Audio(baseurl+'assets/media/sounds/' + song);
	
	if(!audio.currentTime || audio.currentTime == 0){
		$('.current-duration').html('0.00');
	}
	if(!audio.duration){
		$('.total-duration').html('0.00');
	}
	$('.audio-player #title').text(title);
    $('.audio-player #artist').text(artist);
	
	$('.playlist li').removeClass('active');
    element.addClass('active');
	
	audio.volume = parseFloat( $('.volume').val() / 10);
	
	//seekslider = $("#seekslider").val();
	//seekslider = document.getElementById("seekslider");
	
	/*seekslider.addEventListener("mousedown", function(event){ 
		seeking=true; 
		seek(event); 
	});
	
	seekslider.addEventListener("mousemove", function(event){ 
		seek(event); 
	});
	
	seekslider.addEventListener("mouseup",function(){ 
		seeking=false; 
	});*/
	//loop through playlist
	//audio.addEventListener('ended', playNext);
	
	audio.addEventListener('ended', function() {
		
		$('#play-button').show();
		$('#pause-button').hide();
		//seekslider.attr("value", 0);
		this.currentTime = 0;
		//this.play();
		var next = $('.playlist li.active').next();
		//var next = Math.floor(Math.random() * $('.playlist li').length + 1);
		//var nextLi = $('.playlist li.active').get(next);
		//var next = $('.playlist li.active').eq(randomLi);
		//var next = $('.playlist li:nth-child('+randomLi+')');
		
		if (next.length == 0) {
			next = $('.playlist li:first-child');
		}
		initAudio(next);
		audio.play();
		showDuration();
	}, false);
	
	//autostart player
	audio.play();
	//icon controls
	$('#play-button').hide();
	$('#pause-button').show();
	//player controls
	$('.play').hide();
	$('.pause').show();
	$('.current-duration').fadeIn(400);
	showDuration();
	
}

//Play Button
$('.play').click(function(){
	audio.play();
	$('.play').hide();
	$('.pause').show();
	$('.current-duration').fadeIn(400);
	showDuration();
	//icon controls
	$('#play-button').hide();
	$('#pause-button').show();
});
//icon controls
$('#play-button').click(function(){
	audio.play();
	$('#play-button').hide();
	$('#pause-button').show();
	//player controls
	$('.play').hide();
	$('.pause').show();
	$('.current-duration').fadeIn(400);
	showDuration();
});

//Pause Button
$('.pause').click(function(){
	audio.pause();
	$('.pause').hide();
	$('.play').show();
	//icon controls
	$('#pause-button').hide();
	$('#play-button').show();
});
//icon controls
$('#pause-button').click(function(){
	audio.pause();
	$('#pause-button').hide();
	$('#play-button').show();
	//player controls
	$('.pause').hide();
	$('.play').show();

});		

//Stop Button
$('.stop').click(function(){
	audio.pause();		
	audio.currentTime = 0;
	$('.current-duration').html('0.00');
	$('.pause').hide();
	$('.play').show();
	//$('.current-duration').fadeOut(400);
});

//Next Button
$('.next').click(function(){
    audio.pause();
    var next = $('.playlist li.active').next();
    if (next.length == 0) {
        next = $('.playlist li:first-child');
    }
    initAudio(next);
	audio.play();
	$('.play').hide();
	$('.pause').show();
	$('#play-button').hide();
	$('#pause-button').show();
	showDuration();
});

function playNext(){
	var next = $('#playlist li.active').next();
    if (next.length == 0) {
        next = $('#playlist li:first-child');
    }
    initAudio(next);
	audio.play();
	$('.play').hide();
	$('.pause').show();
	$('#play-button').hide();
	$('#pause-button').show();
	showDuration();
}

//Prev Button
$('.prev').click(function(){
    audio.pause();
    var prev = $('.playlist li.active').prev();
    if (prev.length == 0) {
        prev = $('.playlist li:last-child');
    }
    initAudio(prev);
	audio.play();
	$('.play').hide();
	$('.pause').show();
	$('#play-button').hide();
	$('#pause-button').show();
	showDuration();
});

//Playlist Song Click
$('.playlist li').click(function () {
    audio.pause();
    initAudio($(this));
	$('.play').hide();
	$('.pause').show();
	$('.duration').fadeIn(400);
	audio.play();
	showDuration();
	//icon controls
	$('#play-button').hide();
	$('#pause-button').show();
});

//Volume Control
$('.volume').change(function(){
	audio.volume = parseFloat(this.value / 10);
});

$("#seek").bind("change mousedown mousemove mouseup", function() {
        //audio.currentTime = parseInt(this.value);
		audio.currentTime = $(this).val();
		$(this).attr("max", audio.duration);
 });

$('#vol-off-button').click(function () {
   audio.volume = parseFloat(0);
   $('.volume').val(audio.volume);
});

$('#vol-up-button').click(function () {
   audio.volume = parseFloat(1);
   $('.volume').val(10);
});
	
//Time Duration
function showDuration(){
	$(audio).bind('timeupdate', function(){
		
		//var nt = this.currentTime * (100 / this.duration);
		//seekslider.value = nt;
		
		var totalDurationMins = parseInt((this.duration / 60) % 60);
	    var totalDurationSecs = parseInt(this.duration % 60);
		if(totalDurationSecs < 10){ 
			totalDurationSecs = "0"+totalDurationSecs; 
		}
		if(totalDurationMins < 10){ 
			totalDurationMins = "0"+totalDurationMins; 
		}
		
		//Get hours and minutes
		var s = parseInt(this.currentTime % 60);
		var m = parseInt((this.currentTime / 60) % 60);
		//Add 0 if seconds less than 10
		if (s < 10) {
			s = '0' + s;
		}
		$('.current-duration').html(m + '.' + s);

		$('.total-duration').html(totalDurationMins + '.' + totalDurationSecs);
		
		var value = 0;
		if (this.currentTime > 0) {
			value = Math.floor((100 / this.duration) * this.currentTime);
		}
		$('.inline-progress').css('width',value+'%');
		seekslider.value = value;
		
		var val = ($('#seekslider').val() - $('#seekslider').attr('min')) / ($('#seekslider').attr('max') - $('#seekslider').attr('min'));
    
		$('#seekslider').css('background-image',
                '-webkit-gradient(linear, left top, right top, '
                + 'color-stop(' + val + ', #94A14E), '
                + 'color-stop(' + val + ', #C5C5C5)'
                + ')'
                );
		//curtime = parseInt(this.currentTime, 10);
		//$("#seek").attr("value", curtime);
		//$("#seek").attr("value", this.currentTime);
	});
}


	function seek(event){
		
			if(seeking){
				audio.currentTime = parseInt(seekslider.value);
				//seekslider.value = event.clientX - this.offsetLeft;
				//seekto = audio.duration * (seekslider.value / 100);
				//audio.currentTime = seekto;
			}
	}

