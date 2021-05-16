$(document).ready(function () {
	$(".scroll-down").click(function (a) {
		a.preventDefault();
		a = $(this).attr("class");
		$(this);
		$("html, body").animate({
			scrollTop: $("." + a).offset().top + 40
		}, 700, "easeInSine")
	});
	$(".carousel").carousel({
		interval: 6E3
	})
});
$(window).scroll(function () {
	$(".slide-block").each(function (a) {
		var d = $(this),
			h = $(this).offset().top,
			c = $(window).scrollTop();
		h < c + 600 && setTimeout(function () {
			d.addClass("slideUp").delay(1E3)
		}, 500 * a)
	});
	$(".h-block").each(function (a) {
		var d = $(this),
			h = $(this).offset().top,
			c = $(window).scrollTop();
		h < c + 600 && setTimeout(function () {
			d.addClass("slideLeft").delay(1E3)
		}, 500 * a)
	})
});