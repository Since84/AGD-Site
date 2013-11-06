(function ($) {

	$.fn.animateX = function animate(from, to, duration, callback) {
		if (((to - from) / duration) == 0) {
			return;
		}

		var start = new Date();

		this.each(function (i, j) {
			var cont = function (s, f, t, d, c) {
				var p = ((new Date()) - start) * ((t - f) / d);
				if (p != 0) {
					var v = f + p;
					v = (p > 0)
		? ((v < t) ? v : t)
		: ((v > t) ? v : t);
					callback(v, j);
				}
				if (v != t) setTimeout(function () { cont(s, f, t, d, c); }, 1);
			}

			cont(start, from, to, duration, callback);
		});
	};

})(jQuery);

jQuery(document).ready(function($) {
	// Connect Page From Drawer
	$('.lower-content .open-close').on('click', function(){
		$(this).parent().toggleClass('open');
	})
	$(".main-content .blog").smoothDivScroll({});

});

