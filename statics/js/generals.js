$(document).on('ready', function() {
	if($(window).scrollTop() > 50) {
		$('a.scroll-up').fadeIn();
	} else {
		$('a.scroll-up').fadeOut();
	}

	$(document).on('click', 'a.scroll-up', function(e) {
		e.preventDefault();
	    $('html, body').animate({
	        scrollTop: $($.attr(this, 'href')).offset().top - 100
	    }, 500);
	    return false;
	});
});

$(window).on('scroll', function(e) {
	if($(window).scrollTop() > 50) {
		$('a.scroll-up').fadeIn();
	} else {
		$('a.scroll-up').fadeOut();
	}
});