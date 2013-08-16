(function ($) {

	function validate() {
		var going = $('.vegas-bool-option.selected').data('value'),
			name = $('.vegas-rsvp-name').val(),
			email = $('.vegas-rsvp-email').val(),
			valid = /\S+@\S+\.\S+/.test(email),
			size = $('.vegas-rsvp-size').val();
		if (!$('.vegas-bool-option').hasClass('selected')) {
			$('.vegas-bool .error').show();
		}
		if (!name.length) {
			$('.vegas-form .error:eq(0)').show();
		}
		if (!email.length || !valid) {
			$('.vegas-form .error:eq(1)').show();
		}
		if (!size.length) {
			$('.vegas-form .error:eq(2)').show();
		}
		if (going && !$('.vegas-hotel').hasClass('selected')) {
			$('.vegas-hotels .error').show();
		}
		if ($('.error').is(':visible')) {
			var top = $('.error:visible:eq(0)').offset().top - 30;
			$('body, html').animate({scrollTop: top}, 300);
			return false;
		} else {
			return true;
		}
	}

	$('.vegas-bool-option').click(function () {
		var error = $(this).parent().find('.error');
		$('.vegas-bool-option').removeClass('selected');
		$(this).addClass('selected');
		if ($(this).data('value')) {
			$('.vegas-toggle:hidden').slideDown();
		} else {
			$('.vegas-toggle:visible').slideUp();
		}
		if (error.is(':visible')) {
			error.slideUp();
		}
	});

	$('.vegas-rsvp-input').blur(function () {
		var error = $(this).prev('.error');
		if (error.is(':visible')) {
			error.slideUp();
		}
	});

	$('.vegas-hotel').click(function () {
		var error = $(this).parent().find('.error');
		$('.vegas-hotel').removeClass('selected');
		$(this).addClass('selected');
		if (error.is(':visible')) {
			error.slideUp();
		}
	});

	$('[href^="//"]').on('click', function (e) {
		window.open($(this).attr('href'));
		return false;
	});

	$('.vegas-submit-button').click(function () {
		var rsvp = {
			going: $('.vegas-bool-option.selected').data('value'),
			name: $('.vegas-rsvp-name').val(),
			email: $('.vegas-rsvp-email').val(),
			plus: null,
			size: null,
			hotel: null
		}
		if (rsvp.going) {
			rsvp.plus = $('.vegas-rsvp-plus').val();
			rsvp.size = $('.vegas-rsvp-size').val();
			rsvp.hotel = $('.selected .vegas-hotel-name').html();
		}
		if (validate()) {
			$.ajax({
				url: '/rsvp',
				type: 'post',
				data: rsvp,
				dataType: 'json',
				success: function (response) {
					console.log('New guest id: '+ response, rsvp);
					$('.vegas-rsvp, .vegas-header').fadeOut(function () {
						if (rsvp.going) {
							$('.vegas-going').show();
						} else {
							$('.vegas-not-going').show();
						}
						$('.vegas-success').fadeIn();
					});
				}
			});
		}
	});

})(jQuery);
