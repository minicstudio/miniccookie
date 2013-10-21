var miniccookie_height;

$(document).ready(function(){
	// Place after the body
	$('#miniccookie').prependTo('body');

	// Hide with margin
	$('#miniccookie').css({
		'margin-top' : -'1500px',
	});

	// Close button click
	$('#miniccookie-close-button').click(function(){
		$('#miniccookie').animate({'margin-top': -miniccookie_height+'px'}, 300);
	});
});
$(window).load(function(){
	// Get height
	miniccookie_height = $('#miniccookie').height();

	$('#miniccookie')
		// Fix margin
		.css({'margin-top' : -miniccookie_height+'px'})
		// Animate down on window load
		.animate({'margin-top': 0}, 300);

	if(autohide){
		setTimeout(function(){
			$('#miniccookie').animate({'margin-top': -miniccookie_height+'px'}, 300);
		}, time)
	}
});