/* DYNAMITE CARDGALLERY js */

(function($){
	
	$.widget("dynamite.cardgallery",{

		options: {
			development : false,
			devItems : 12
		},

		_create: function() {
			var self = this;

			// this.runIsotope();

			$(".dCard")
				.mouseover(function(){
					$(this).addClass('flipped');
				})
				.mouseout(function(){
					$(this).removeClass('flipped');
				});
			$(".dContainer")
				.on('click', function(){
					self.openProject(this);
				});
			

		},
		runIsotope: function(){
		$(this.element).isotope({
	        itemSelector: '.testBlock'
	      });
		}, 
		openProject: function(elem) {
			var self = this;

			var thisPosition = $(elem).position();
			
			var startPosition = { 
					top: thisPosition.top, 
					left: thisPosition.left, 
					display: 'block',
					width: $(elem).width(),
					height: $(elem).height()
				}

			var openPosition = { 
					top: 0, 
					left: 0,
					height: '100%',
					width: '100%'
				}

			self._getBio(elem);

			$('.dBio')
				.css(startPosition)
				.animate(openPosition, 500)
				.unbind()
				.click(function(){
					$(this).animate(startPosition, 500, function(){
						$(this).removeAttr('style');
					});
				});
			
			// $('.dBio').animate({
			// 	top: 0,
			// 	left: 0
			// }, 500);

			$('.open').click(function(){
				$(this).removeClass('open');
				$('.closed').removeClass('closed');
			});
		},
		_getBio: function(elem) {

			var data = {
				action: 'member_bio',
				memberId: $(elem).attr('data-id')
			};
			$.post(ajaxurl, data, function(response) {
				console.log( response );
			});
		},
		_devSet: function() {
			var testBlock = "" +
			"<div class='testBlock dContainer'>" +
				"<div class='dCard'>" +
				    "<figure class='front'>Front</figure>" +
				    "<figure class='back'>Back</figure>" +
				"</div>" +
			"</div>"; 

			for ( var i = 0; i < this.options.devItems; i++ ) {
				$( this.element ).append( testBlock );
			}
		}

	});

	$(document).ready(function(){
		$('#dFolio').cardgallery({
			development: true,
		});
	})

})(jQuery);

