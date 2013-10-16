/* DYNAMITE CARDGALLERY js */

(function($){
	
	$.widget("dynamite.cardgallery",{

		options: {
			development : false,
			devItems : 12
		
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
					  $(this).find('.dCard').addClass('active');
					  self.openProject(this);
					  break;
					case 'feature':
					  window.location = '/dev/our-work?pid=' + id;
					  break;
					default:
					  self.openProject(this);
					}
					
				});
			
			if ( activeProjectId != undefined ) { 
				$(activeProjectElem).find('.dCard').addClass('active');
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
				.animate( this.options.openPosition, 500 )
				.unbind();
		},
		_closeMember: function(){
			console.log('here');
			var $bioDiv = $(this.element).find('.dBio ');

			$bioDiv
				.animate(this.options.startPosition, 500, function(){
					$bioDiv.removeClass('open');
					$bioDiv.removeAttr('style');
				})
				.empty();

			$('.closed').removeClass('closed');
		},
		openProject: function(elem) {
			var self = this;
			var $bioDiv = $(this.element).find('.dBio ');

			this.options.openPosition = { 
					display: 'block',
					height: '500px'
				}
			this.options.closedPosition = { 
					display: 'block',
					height: '0px'
				}

			$bioDiv
				.animate( this.options.openPosition, 500, function(){
					$(this).addClass('open');
					$(this).unbind();
				} )

			self._getProject(elem);
				
		},
		_closeProject: function(elem){
			$(elem).parent('.dContainer').find('.dCard').removeClass('active');
			var $bioDiv = $(this.element).find('.dBio ');

			$bioDiv
				.animate(this.options.closedPosition, 500, function(){
					$bioDiv.removeClass('open');
					$(this).parent().removeAttr('style')
				})
				.empty()
				.unbind();

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
				$('.dBio').find('.close').unbind();
				$('.dBio').find('.close').on('click', function(){
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
				$(self.element).find('.dBio').append(response);
				$('.dBio').find('.close').unbind();
				$('.dBio').find('.close').on('click', function(){
					 self._closeProject(this);
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

