var audio;


//Hide Pause Initially
$('#pause').hide();
$('.pause').hide();
$('#pause-button').hide();
$('#audio-hide').hide();
	
//Initializer - Play First Song
initAudio($('#playlist li:first-child'));
initAudio2($('.playlist li:first-child'));
	
function initAudio(element){
	var song = element.attr('song');
    var title = element.text();
    var cover = element.attr('cover');
    var artist = element.attr('artist');

	//Create a New Audio Object
	audio = new Audio(baseurl+'assets/media/sounds/' + song);
	
	if(!audio.currentTime){
		$('#duration').html('0.00');
	}

	$('#audio-player .title').text(title);
    $('#audio-player .artist').text(artist);
	
	//Insert Cover Image
	$('img.cover').attr('src',baseurl+'assets/images/img/covers/' + cover);
	
	$('#playlist li').removeClass('active');
    element.addClass('active');
}
	
function initAudio2(element){
	var song = element.attr('song');
    var title = element.text();
    var cover = element.attr('cover');
    var artist = element.attr('artist');

	//Create a New Audio Object
	audio = new Audio(baseurl+'assets/media/sounds/' + song);
	
	if(!audio.currentTime){
		$('.duration').html('0.00');
	}

	$('.audio-player #title').text(title);
    $('.audio-player #artist').text(artist);
	
	$('.playlist li').removeClass('active');
    element.addClass('active');
	/*audio.play();
	$('.play').hide();
	$('.pause').show();
	$('.duration').fadeIn(400);
	showDuration2();
	*/
}

//Play Button
$('#play').click(function(){
	audio.play();
	$('#play').hide();
	$('#pause').show();
	$('#duration').fadeIn(400);
	showDuration();
});

$('.play').click(function(){
	audio.play();
	$('.play').hide();
	$('.pause').show();
	$('.duration').fadeIn(400);
	showDuration2();
	$('#play-button').hide();
	$('#pause-button').show();
});

$('#play-button').click(function(){
	audio.play();
	$('#play-button').hide();
	$('#pause-button').show();
	$('.play').hide();
	$('.pause').show();
	$('.duration').fadeIn(400);
	showDuration2();
	
	
});

//Pause Button
$('#pause').click(function(){
	audio.pause();
	$('#pause').hide();
	$('#play').show();
});

$('.pause').click(function(){
	audio.pause();
	$('.pause').hide();
	$('.play').show();
	$('#pause-button').hide();
	$('#play-button').show();
});

$('#pause-button').click(function(){
	audio.pause();
	$('#pause-button').hide();
	$('#play-button').show();
	$('.pause').hide();
	$('.play').show();

});		

//Stop Button
$('#stop').click(function(){
	audio.pause();		
	audio.currentTime = 0;
	$('#pause').hide();
	$('#play').show();
	$('#duration').fadeOut(400);
});
$('.stop').click(function(){
	audio.pause();		
	audio.currentTime = 0;
	$('.pause').hide();
	$('.play').show();
	$('.duration').fadeOut(400);
});

//Next Button
$('#next').click(function(){
    audio.pause();
    var next = $('#playlist li.active').next();
    if (next.length == 0) {
        next = $('#playlist li:first-child');
    }
    initAudio(next);
	audio.play();
	showDuration();
});

$('.next').click(function(){
    audio.pause();
    var next = $('.playlist li.active').next();
    if (next.length == 0) {
        next = $('.playlist li:first-child');
    }
    initAudio2(next);
	audio.play();
	showDuration2();
});

//Prev Button
$('#prev').click(function(){
    audio.pause();
    var prev = $('#playlist li.active').prev();
    if (prev.length == 0) {
        prev = $('#playlist li:last-child');
    }
    initAudio(prev);
	audio.play();
	showDuration();
});

$('.prev').click(function(){
    audio.pause();
    var prev = $('.playlist li.active').prev();
    if (prev.length == 0) {
        prev = $('.playlist li:last-child');
    }
    initAudio2(prev);
	audio.play();
	showDuration2();
});

//Playlist Song Click
$('#playlist li').click(function () {
    audio.pause();
    initAudio($(this));
	$('#play').hide();
	$('#pause').show();
	$('#duration').fadeIn(400);
	audio.play();
	showDuration();
});

$('.playlist li').click(function () {
    audio.pause();
    initAudio2($(this));
	$('.play').hide();
	$('.pause').show();
	$('.duration').fadeIn(400);
	audio.play();
	showDuration2();
});

//Volume Control
$('#volume').change(function(){
	audio.volume = parseFloat(this.value / 10);
});

$('.volume').change(function(){
	audio.volume = parseFloat(this.value / 10);
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
		//Get hours and minutes
		var s = parseInt(audio.currentTime % 60);
		var m = parseInt((audio.currentTime / 60) % 60);
		//Add 0 if seconds less than 10
		if (s < 10) {
			s = '0' + s;
		}
		$('#duration').html(m + '.' + s);	
		var value = 0;
		if (audio.currentTime > 0) {
			value = Math.floor((100 / audio.duration) * audio.currentTime);
		}
		$('#progress').css('width',value+'%');
	});
}

function showDuration2(){
	$(audio).bind('timeupdate', function(){
		//Get hours and minutes
		var s = parseInt(audio.currentTime % 60);
		var m = parseInt((audio.currentTime / 60) % 60);
		//Add 0 if seconds less than 10
		if (s < 10) {
			s = '0' + s;
		}
		$('.duration').html(m + '.' + s);	
		var value = 0;
		if (audio.currentTime > 0) {
			value = Math.floor((100 / audio.duration) * audio.currentTime);
		}
		$('.inline-progress').css('width',value+'%');
	});
}

function run(interval, frames) {
    var int = 1;
    
    function func() {
        document.body.id = "b"+int;
        int++;
        if(int === frames) { int = 1; }
    }
    
    var swap = window.setInterval(func, interval);
}

run(1000, 5); //milliseconds, frames