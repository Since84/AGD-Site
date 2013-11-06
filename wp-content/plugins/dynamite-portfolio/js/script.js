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

			$( self.options.slideClass ).last().insertBefore( $( self.options.slideClass ).first() );
			$( self.options.slideClass + '.active' ).removeClass('active');
			$( $(self.options.slideClass).first() ).addClass('active');
			self.resizeContainer();
			self.nextSlide();
		},
		resizeContainer: function(){
			// var self = this;
			// var dContainer = $(self.element).find(self.options.sliderClass);
			// var dWindow = $(self.element).find(self.options.sliderWindowClass);

			// var slideClass = (self.options.slideClass);
			// var slideCount = dContainer.find( slideClass ).length;

			// var newWidth = ( slideCount * dWindow.width() ) + 50;

			// dContainer.width( newWidth );
		},
		nextSlide: function(elem){
			var self = this;

		if ( !$( self.options.sliderClass ).is(':animated') ) {

			var activeSlide = $( '.active' + self.options.slideClass );
			var nextSlide = activeSlide.next();
			var firstSlide = $( self.options.slideClass ).first();
			var shiftSlide = false;

			if ( nextSlide.is(':last-child') ) {
				$( self.options.sliderClass ).css( 'left', $( self.options.sliderClass ).position().left + firstSlide.width() - 40 );
				firstSlide.insertAfter( nextSlide );
			}

			var sliderPosition 	= $( self.options.sliderClass ).position().left;
			var slidePosition 	= nextSlide.width();
			var slideDistance =  sliderPosition - slidePosition - 40;


			$( self.options.sliderClass ).animate({ left: slideDistance }, self.options.speed, function(){
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

			if ( prevSlide.is(':first-child') ) {
				shiftSlide = true;
				cloneSlide = lastSlide.clone();
				cloneSlide.insertBefore(lastSlide);
				lastSlide.insertBefore( prevSlide );
				$( self.options.sliderClass ).css( 'left', $( self.options.sliderClass ).position().left - cloneSlide.width() - 40 );
			}

			var slideDistance = activeSlide.width() + 5;

			var sliderPosition 	= $( self.options.sliderClass ).position().left;
			var slidePosition 	= prevSlide.position().left;
			var slideDistance =  sliderPosition + slidePosition - 40;
			console.log( "SLIDER :" + sliderPosition);
			console.log( "SLIDE :" + slidePosition);

			$( self.options.sliderClass ).animate({ left: slideDistance }, self.options.speed, function(){
				if ( shiftSlide ) { cloneSlide.remove(); }
			} );

			activeSlide.removeClass('active');
			prevSlide.addClass('active');

		}
			
		},
		scrollToSlide: function(slide) {
			var self = this; 
			var sliderPosition 	= $( self.options.sliderClass ).position().left + 40;
			var slidePosition 	= slide.position().left;

			var slideDistance = slidePosition + ( sliderPosition );

		}

	})

})(jQuery);

jQuery(document).ready(function(){
	jQuery('.dGlider').featureGlider();
})