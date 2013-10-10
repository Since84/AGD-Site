/* DYNAMITE feature js */

(function($){
	
	$.widget("dynamite.featureGlider",{

		options: {
			speed: 500,
			keyboardPaging: true,
			slideClass: '.featured-slide',
			sliderClass: '.featured-slide-container',
			sliderWindowClass: '.featured-slide-window'
		},

		_create: function() {
			var self = this;
			self.options.nextButton = $(self.element).find('.next.paging');
			self.options.prevButton = $(self.element).find('.prev.paging');

			self.options.nextButton.on('click', function(){ self.nextSlide() });
			self.options.prevButton.on('click', function(){ self.prevSlide() });

			$(self.options.slideClass).first().addClass('active');
			self.resizeContainer();
		},
		resizeContainer: function(){
			var self = this;
			var dContainer = $(self.element).find(self.options.sliderClass);
			var dWindow = $(self.element).find(self.options.sliderWindowClass);

			var slideClass = (self.options.slideClass);
			var slideCount = dContainer.find( slideClass ).length;

			var newWidth = ( slideCount * dWindow.width() ) + 50;

			dContainer.width( newWidth );
		},
		nextSlide: function(elem){
			var self = this;

			var activeSlide = $( '.active' + self.options.slideClass );
			var nextSlide = activeSlide.next();
			console.log(nextSlide, 'NEXT');
			if ( nextSlide.length != 0 ){

				var slideDistance = activeSlide.width() + 5;

				$( self.options.sliderClass ).animate({ left: "-=" + slideDistance }, self.options.speed );

				activeSlide.removeClass('active');
				nextSlide.addClass('active');

			}


		},
		prevSlide: function(elem){
			var self = this;
			var activeSlide = $( '.active' + self.options.slideClass );
			var prevSlide = activeSlide.prev();
			console.log(prevSlide, 'PREV');
			if ( prevSlide.length != 0 ){
				var slideDistance = activeSlide.width() + 5;

				$( self.options.sliderClass ).animate({ left: "+=" + slideDistance }, self.options.speed );
				
				activeSlide.removeClass('active');
				prevSlide.addClass('active');

			}
		}

	})

})(jQuery);

jQuery(document).ready(function(){
	jQuery('.dGlider').featureGlider();
})