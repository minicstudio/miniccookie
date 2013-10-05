var miniccookie_height;

$(document).ready(function(){
	// Place after the body
	$('#miniccookie').prependTo('body');
	// Get height
	miniccookie_height = $('#miniccookie').height();
	// Hide with margin
	$('#miniccookie').css({
		'margin-top' : -miniccookie_height+'px',
	});
	// Close button click
	$('#miniccookie-close-button').click(function(){
		$('#miniccookie').animate({'margin-top': -miniccookie_height+'px'}, 300);
	});

	$(window).load(function(){
		// Animate down on window load
		$('#miniccookie').animate({'margin-top': 0}, 300);

		if(autohide){
			setTimeout(function(){
				$('#miniccookie').animate({'margin-top': -miniccookie_height+'px'}, 300);
			}, time)
		}
	});
});