$(document).on('ready', function() {
	$('#administrative-tools').on('click', 'li.admin-tool a', function(e) {
		e.preventDefault();
		var $this   = $(this),
			thisurl = $(this).attr('href');
			action  = $this.data('action'),
			target  = $this.data('target'),
			$target = $(target);

		if(!action) {
			document.location.href = thisurl;
		}

		switch(action) {
			case 'contract':
				$target
					.removeClass('expanded')
					.addClass('contracted');
			break;
			case 'expand':
				$target
					.removeClass('contracted')
					.addClass('expanded');
			break;
		}
	});

	$('div.config-nav-menu').on('click', 'a', function(e) {
		e.preventDefault();
	    $('html, body').animate({
	        scrollTop: $($.attr(this, 'href')).offset().top - 100
	    }, 500);
	    return false;
	});
});