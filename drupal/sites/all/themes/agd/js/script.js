/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {
    //homepage animation
    function scroller () {
    	var $standout = $('.standout'),
    		$container = $('.slidenav'),
    	 	$slidenavLi = $('.slidenav li'),
		 	$slidenavSpan = $('.slidenav li span'),
		 	$slideImg = $('.slides img'),
		 	$arrow = $('.arrow'),
    		minScroll = '0%',
    		maxScroll = '95%',
    		speed = 8000,
    		timeout = 300,
    		fastSpeed = 10,
    		totalWidth = 495,
    		scrollWidth = totalWidth - ((100 - maxScroll.split('%')[0])/100 * totalWidth) - (minScroll.split('%')[0]/100 * totalWidth),
    		elementsWidth = [],
    		totalWidthNow = 0,
    		timers = new Array();
    		
    	 //fadin the top lines
    	 $('#line1').animate({'opacity': '1'}, 1000, function () {
			$('#line2').animate({'opacity': '1'});
		 });
		 $("#line1, #line2").fitText(1, { minFontSize: '27px', maxFontSize: '54px' });
		 $slidenavLi.click(function() {
		 	 var index = $slidenavLi.index($(this)),
		 	 	 padding = '40px';
		 	 	 var standoutHeight = $standout.height();
		 	 //clear active class and reset
		 	 $('.slidenav li').removeClass('active');
		 	 $(this).addClass('active');
			 for (var i = 0; i < timers.length; i++) {
				clearTimeout(timers[i]);
			 }
			 //give the images some room if they don't have it
			 if (!$('.storedAway').length) {
			 	$container.animate({ paddingBottom: '0px'}, fastSpeed, 'linear', function() {
			 		$('.slides').animate({ marginTop: '0px'}, fastSpeed, 'linear');
			 	});
			 	$standout.css('paddingBottom', padding);
			 }
			 else {
			 	//set image container to fixed height so viewport doesn't change
			 	$standout.css('height',standoutHeight);
			 }
			 $('.line_wrapper').slideUp().addClass('storedAway');
			 //show image if they click a new one
			 if (!$slideImg.eq(index).filter(':visible').length) {
				 $slideImg.filter(':visible').css({'position' : 'absolute','top' : '105px'}).hide('slide', {direction:'right'}, 'slow');
				 $slideImg.eq(index).css({'position':'static','top' : 'initial'}).effect('slide','slow', function() {
					//set the standout height back to auto so design stays liquid
					$standout.css('height','auto');
				 });
			 }
			 //move arrow
			 $arrow.stop(true,false).animate({ color: ($slidenavSpan.eq(index).css('color')) }, fastSpeed, function () {

			 	var arrowDistanceFromLeft = 0;
			 	if (index > 0) {
			 		console.log('index: ' + index);
			 		for (var i = 0; i < index; i++ ) {
			 			arrowDistanceFromLeft = elementsWidth[i];
			 			console.log(elementsWidth[i]);
			 		}
			 	};
				
				$arrow.animate({ left: arrowDistanceFromLeft + '%'}, fastSpeed, 'linear');
			 });
			 $slidenavSpan.css('text-decoration','none');
		 });
    		
		$container.find('li').each(function () {
			//get nav items width
			var childWidth = $(this).width();
			
			//get nav items width in percentages
			childWidth = (childWidth/scrollWidth) * 100;
			totalWidthNow = childWidth + totalWidthNow;
			if (totalWidthNow > maxScroll.split('%')[0]) {totalWidthNow = maxScroll.split('%')[0];}
			elementsWidth.push(totalWidthNow);
		});

	    function scrollIt () {
			 $.each(elementsWidth, function(i, val) {
				timers.push(
					setTimeout(function() {
						$arrow.animate({ color: ($slidenavSpan.eq(i).css('color')) }, fastSpeed, function () {
								$slidenavSpan.css('text-decoration','none');
								$slidenavSpan.eq(i).css('text-decoration','underline');
						})
						.animate({ left: elementsWidth[i] + '%'}, (speed/elementsWidth.length), 'linear', function () {
							if ($arrow.css('left') >= maxScroll ||  $arrow.css('left').slice(0, -2) >= scrollWidth) {
								$arrow.css({left: minScroll});
								scrollIt();
							}
						});
						
					}, i * timeout)
				);
			});
			
		}
		scrollIt();
	}

	$(document).ready(function() {

		//if on homepage start the scroller animation
		if ($('.front').length) {
			scroller();
		}

		/* form stuff */
		//hide labels
		$('.block-constant-contact input').on('focus', function() {
			var formID = $(this).attr('id');
			$('label[for="'+formID+'"]').fadeOut('fast');
		});
		//show label if no content
		$('.block-constant-contact input').on('blur', function() {
			var formID = $(this).attr('id');
			if (!$(this).val()) {
				$('label[for="'+formID+'"]').fadeIn();
			}
		});
		//hide label if autofilled
		$('.block-constant-contact input').on('change', function() {
			if ($(this).val()) {
				var formID = $(this).attr('id');
				$('label[for="'+formID+'"]').hide();
			}
		});
		//hide label if POST data is present
		$('.block-constant-contact input').each(function() {
			if ($(this).val()) {
				var formID = $(this).attr('id');
				$('label[for="'+formID+'"]').hide();
			}
		});

		//about us switcher
		$('#block-views-staff-images-block .field-name-field-staff-name').click(function() {
			var indexOfImage = $(this).index();
			var $elementToHide = $('.hiddenbios').is(':visible') ? $('.hiddenbios').not($('.hiddenbios').eq(indexOfImage)) : $('.field-name-body');
			$elementToHide.slideUp('slow', function() {
				$('.hiddenbios').eq(indexOfImage).slideDown();
			});
		});

		//make the portfolio links a easier to click
		$('.view-id-work .views-row').each(function() {
			var detailLink = $(this).find('a').attr('href');
			$(this).on('click', function() {
				window.location = detailLink;
			})
		});

		//swap portfolio images
		$('.extraimage').on('click', function() {
			var $mainImg = $('#mainimg img')
			var currentUrl = $mainImg.attr('src');
			var urlParts = currentUrl.split('/');
			console.log(urlParts[urlParts.length-1]);
			urlParts[urlParts.length-1] = $(this).data('filename');
			console.log(urlParts[urlParts.length-1]);
			$mainImg.attr('src', urlParts.join('/'));
		});

		/* form stuff */

		$formSelctor = $('.webform-client-form .webform-component-textfield input, .webform-client-form .webform-component-textarea textarea')
		//hide labels
		$formSelctor.on('focus', function() {
			var formID = $(this).attr('id');
			$('label[for="'+formID+'"]').fadeOut('fast');
		});
		//show label if no content
		$formSelctor.on('blur', function() {
			var formID = $(this).attr('id');
			if (!$(this).val()) {
				$('label[for="'+formID+'"]').fadeIn();
			}
		});
		//hide label if autofilled
		$formSelctor.on('change', function() {
			if ($(this).val()) {
				var formID = $(this).attr('id');
				$('label[for="'+formID+'"]').hide();
			}
		});
		//hide label if POST data is present
		$formSelctor.each(function() {
			if ($(this).val()) {
				var formID = $(this).attr('id');
				$('label[for="'+formID+'"]').hide();
			}
		});

	});


})(jQuery, Drupal, this, this.document);
