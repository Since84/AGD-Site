/* DYNAMITE CARDGALLERY js */

(function($){
	
	$.widget("dynamite.cardgallery",{

		options: {
			development : false,
			devItems : 12,
			animationSpeed : 500
		},

		_create: function() {
			var self = this;
			var activeProjectId = $(self.element).data('pid');
			var activeProjectElem = $(self.element).find( '[data-id='+ activeProjectId +']' );
			this.options.pagename = $( this.element ).find('.dBio').attr('data-page');
			
			$(".dCard")
				.mouseover(function(){
					$(this).addClass('flipped');
				})
				.mouseout(function(){
					$(this).removeClass('flipped');
				});
			$(".dContainer")
				.on('click', function(){
					var id = $(this).data('id');

					switch( self.options.pagename )
					{
					case 'team':
					  self.openMember(this);
					  break;
					case 'projects':
					  $(this).addClass('active');
					  self.openProject(this);
					  break;
					case 'feature':
					  window.location = '/dev/?page_id=114&pid=' + id;
					  break;
					default:
					  self.openProject(this);
					}
					
				});
			if ( activeProjectId != '' ) { 
				$(activeProjectElem).addClass('active');
				self.openProject(activeProjectElem);
			}



		},
		runIsotope: function(){
		$(this.element).isotope({
	        itemSelector: '.testBlock'
	      });
		}, 
		openMember: function(elem) {
			var self = this;

			var thisPosition = $(elem).position();
			
			this.options.startPosition = { 
					top: thisPosition.top, 
					left: thisPosition.left, 
					display: 'block',
					width: $(elem).width(),
					height: $(elem).height()
				}

			this.options.openPosition = { 
					top: 0, 
					left: 0,
					height: '100%',
					width: '100%'
				}

			self._getBio(elem);

			$('.dBio')
				.addClass('open')
				.css(this.options.startPosition)
				.animate( this.options.openPosition, this.options.animationSpeed )
				.unbind();
		},
		_closeMember: function(){
			var $bioDiv = $(this.element).find('.dBio ');

			$bioDiv
				.animate(this.options.startPosition, this.options.animationSpeed, function(){
					$bioDiv.removeClass('open');
					$bioDiv.removeAttr('style');
				})
				.empty();

			$('.closed').removeClass('closed');
		},
		openProject: function(elem) {
			var self = this;
			var $bioDiv = $(self.element).find('.dBio ');

			self.options.openPosition = { 
					display: 'block',
					height: '500'
				}
			self.options.closedPosition = { 
					display: 'block',
					height: '0px',
					opacity: '0'
				}
			self._getProject(elem);

			if( $bioDiv.hasClass('open') ) {
				self._closeProject('open');
				$bioDiv
					.animate( self.options.openPosition, self.options.animationSpeed, function(){
						$(this).animate({opacity: 1}, self.options.animationSpeed, function(){
							$(this).addClass('open');
							$(this).unbind();
						})
					} )
			} else {
				$bioDiv.animate( self.options.openPosition, self.options.animationSpeed, function(){
					$(this).addClass('open');
					$(this).unbind();
				} )
			}
				
		},
		_closeProject: function(elem){
			var self = this;
			var $bioDiv = $(this.element).find('.dBio ');
			
			$bioDiv
				.animate(self.options.closedPosition, self.options.animationSpeed, function(){
					$bioDiv
						.removeClass('open')
						.empty()
						.unbind();
					$(elem).parent('.dContainer').removeClass('active');
					$(this).parent().removeAttr('style')
				})

			$('.closed').removeClass('closed');
		},
		_getBio: function(elem) {
			var self = this;
			var data = {
				action: 'member_bio',
				memberId: $(elem).attr('data-id')
			};
			$.post(ajaxurl, data, function(response) {
				$(self.element).find('.dBio').append(response);
				$('.dBio').find('.close').unbind().on('click', function(){
					self._closeMember(this);
				});
			});
		},
		_getProject: function(elem) {
			var self = this;
			var data = {
				action: 'project_profile',
				projectId: $(elem).attr('data-id')
			};
			$.post(ajaxurl, data, function(response) {
				$(self.element).find('.dBio')				
					.promise().done(function(){
						$(this).append(response)
						$(this).animate({opacity: 1}, self.options.animationSpeed );
						$('.dBio').find('.close')
							.unbind()
							.on('click', function(){
								 self._closeProject(this);
						});
					});
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

