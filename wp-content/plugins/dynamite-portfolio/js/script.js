/* DYNAMITE feature js */

(function($){
	
	$.widget("dynamite.featureGlider",{

		options: {
			speed: 500,
			keyboardPaging: true,
			slideClass: '.featured-slide',
			sliderClass: '.featured-slide-container',
			sliderWindowClass: '.featured-slide-window',
			slideWidth: '400px'
		},

		_create: function() {
			var self = this;
			self.options.nextButton = $(self.element).find('.next.paging');
			self.options.prevButton = $(self.element).find('.prev.paging');
			self.options.slideWidth = $(self.options.slideClass).width();

			self.options.nextButton.on('click', function(){ self.nextSlide() });
			self.options.prevButton.on('click', function(){ self.prevSlide() });

			$( self.options.slideClass ).last().insertBefore( $( self.options.slideClass ).first() );
			$( self.options.slideClass + '.active' ).removeClass('active');
			$( $(self.options.slideClass).first() ).addClass('active');
			self.nextSlide();

			var waitForFinalEvent = (function () {
			  var timers = {};
			  return function (callback, ms, uniqueId) {
			    if (!uniqueId) {
			      uniqueId = "Don't call this twice without a uniqueId";
			    }
			    if (timers[uniqueId]) {
			      clearTimeout (timers[uniqueId]);
			    }
			    timers[uniqueId] = setTimeout(callback, ms);
			  };
			})();


			$(window).resize(function(){
				self.resizeGallery();
				waitForFinalEvent(function(){
					console.log("RESIZE");
					self.resizeContainer();
				}, 500, "sliderReposition" );
			})

			imagesLoaded( '.dGallery', function(){
				self.resizeGallery();
			});

		},
		resizeGallery: function(){
			var self = this;
			var gallery = $(self.element).find('.dGallery');

			gallery.each(function() {
        		var newHeight = 0, 
        		$this = $( this );

		        $.each( $this.children(), function() {
		            newHeight += $( this ).height();
		        });
		        $this.height( newHeight );
		    });
		},
		resizeContainer: function(){
			var self = this;

			var activeSlidePosition = $( self.options.slideClass + '.active' ).offset().left;
			var sliderWindowPosition = $( self.options.sliderWindowClass ).offset().left;
			var pagerWidth = $('.paging').width();

			var slideDistance = activeSlidePosition - sliderWindowPosition - pagerWidth;
			console.log(slideDistance);

			if ( Math.abs( slideDistance ) > 3 ) {
				$( self.options.sliderClass ).animate({left : "-=" + slideDistance });
			}



			// var dContainer = $(self.element).find(self.options.sliderClass);
			// var dWindow = $(self.element).find(self.options.sliderWindowClass);

			// var slideClass = (self.options.slideClass);
			// var slideCount = dContainer.find( slideClass ).length;

			// var newWidth = ( slideCount * dWindow.width() ) + 50;

			// dContainer.width( newWidth );
		},
		nextSlide: function(elem){
			var self = this;
			console.log("Slide Width" , self.options.slideWidth);
			if ( !$( self.options.sliderClass ).is(':animated') ) {

				var activeSlide = $( '.active' + self.options.slideClass );
				var nextSlide = activeSlide.next();
				var firstSlide = $( self.options.slideClass ).first();
				var shiftSlide = false;
				var pagerSpacing = $( self.options.sliderClass ).parents('.featured-slider').find('.paging').width() ;
				console.log(pagerSpacing);

				if ( nextSlide.is(':last-child') ) {
					$( self.options.sliderClass ).css( 'left', "+=" + self.options.slideWidth );
					firstSlide.insertAfter( nextSlide );
				}

				var sliderPosition 	= $( self.options.sliderClass ).position().left;
				var slidePosition 	= nextSlide.width();
				var slideDistance =  sliderPosition - slidePosition - pagerSpacing;


					$( self.options.sliderClass ).animate({ left: "-=" + self.options.slideWidth }, self.options.speed, function(){
						if ( shiftSlide ) { firstSlide.remove(); }
					});

				activeSlide.removeClass('active');
				nextSlide.addClass('active');
			}

		},
		prevSlide: function(elem){
			var self = this;

		if ( !$( self.options.sliderClass ).is(':animated') ) {

			var activeSlide = $( '.active' + self.options.slideClass );
			var prevSlide = activeSlide.prev();
			var lastSlide = $( self.options.slideClass ).last(); 
			var shiftSlide = false;
			var pagerSpacing = $( self.options.sliderClass ).parents('.featured-slider').find('.paging').width() ;
			console.log(pagerSpacing);

			if ( prevSlide.is(':first-child') ) {
				shiftSlide = true;
				cloneSlide = lastSlide.clone();
				cloneSlide.insertBefore(lastSlide);
				lastSlide.insertBefore( prevSlide );
				$( self.options.sliderClass ).css( 'left', '-=' + self.options.slideWidth );
			}

			var slideDistance = activeSlide.width() + 5;

			var sliderPosition 	= $( self.options.sliderClass ).position().left;
			var slidePosition 	= prevSlide.position().left;
			var slideDistance =  sliderPosition + slidePosition - pagerSpacing;
			console.log( "SLIDER :" + sliderPosition);
			console.log( "SLIDE :" + slidePosition);

			$( self.options.sliderClass ).animate({ left: "+=" + self.options.slideWidth }, self.options.speed, function(){
				if ( shiftSlide ) { cloneSlide.remove(); }
			} );

			activeSlide.removeClass('active');
			prevSlide.addClass('active');

		}
			
		},
		scrollToSlide: function(slide) {
			var self = this; 
			var sliderPosition 	= $( self.options.sliderClass ).position().left;
			var slidePosition 	= slide.position().left;

			var slideDistance = slidePosition + ( sliderPosition );

		}

	})

})(jQuery);

jQuery(document).ready(function(){
	jQuery('.dGlider').featureGlider();
})