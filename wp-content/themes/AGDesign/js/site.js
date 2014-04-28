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
		$(this).parent().siblings().removeClass('open');
	});
	$(".main-content .blog").smoothDivScroll({});

	if( !$('body').hasClass('home') ){
		var $container = $('.dGallery');
		$container.imagesLoaded(function(){
			$container.isotope({
				itemSelector: '.dContainer',
			    masonry: {
			      // columnWidth: 200
			    }
			    // sortBy: 'number',
			    // getSortData: {
			    //   number: function( $elem ) {
			    //     var number = $elem.hasClass('element') ? 
			    //       $elem.find('.number').text() :
			    //       $elem.attr('data-number');
			    //     return parseInt( number, 10 );
			    //   },
			    //   alphabetical: function( $elem ) {
			    //     var name = $elem.find('.name'),
			    //         itemText = name.length ? name : $elem;
			    //     return itemText.text();
			    //   }
			});		
		})
	}


  $(".top-menu a").on("click", function(){
  		var filter = $(this).parent().attr('data-filter');
  		$container.isotope({filter:filter});
  		$(".top-menu .active").removeClass('active');
  		$(this).parent().addClass('active');
  		return false;
  })

  //Category Selector for 'Our Work' page.
  var active = $('.active').text();

  $(".work-selected-category").text(active);

  $(".top-menu .work-selected-category").click(function(){
  		$(this).parent().toggleClass('on');
  })

  $(".top-menu .btn li").on('click', function(){
  		var category = $(this).text();
  		
  		$('.work-selected-category').text(category);
  })

	//sticky subnav
   var stickyElement = $('.top-menu');
   if ( stickyElement.length && stickyElement.children().length ) {
	   var stickyElementLocation = stickyElement.offset().top;
	   var stickyElementHeight = stickyElement.height();
       $(window).scroll(function(){
       	var windowTopPosition = $(window).scrollTop();
           if ( windowTopPosition >= stickyElementLocation ) {
               stickyElement.addClass('sticky');
               $('body').css({'paddingTop':stickyElementHeight});
           } else {
               stickyElement.removeClass('sticky');
               $('body').css({'paddingTop':0});
           }
       });
    }

    $('.sidr-menu-button').sidr({
      name: 'sidr-main',
      source: '#menu-main-nav, footer.container',
      side: 'right',
      body: 'html'
    });

});

