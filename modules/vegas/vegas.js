(function ($) {

	$('.vegas-bool-option').click(function () {
		$('.vegas-bool-option').removeClass('selected');
		$(this).addClass('selected');
	});

	$('.vegas-hotel').click(function () {
		$('.vegas-hotel').removeClass('selected');
		$(this).addClass('selected');
	});

})(jQuery);
