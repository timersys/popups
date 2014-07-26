jQuery(window).load(function() {
	window.SPU = (function($) {

		var windowHeight 	= $(window).height();
		var isAdmin 		= spuvar.is_admin;
		var $boxes 			= [];


		//remove paddings and margins from first and last items inside box
		$(".spu-content").children().first().css({
			"margin-top": 0,
			"padding-top": 0
		}).end().last().css({
			'margin-bottom': 0,
			'padding-bottom': 0
		});

		// loop through boxes
		$(".spu-box").each(function() {


			// vars
			var $box 			= $(this);
			var triggerMethod 	= $box.data('trigger');
			var timer 			= 0;
			var testMode 		= (parseInt($box.data('test-mode')) === 1);
			var id 				= $box.data('box-id');
			var autoHide 		= (parseInt($box.data('auto-hide')) === 1);
			var advancedClose   = (parseInt($box.data('advanced-close')) === 1);
			var secondsClose    = parseInt($box.data('seconds-close'));

			if ( advancedClose ) {
				//close with esc
				$(document).keyup(function(e) {
					if (e.keyCode == 27) {
						toggleBox( id, false );
					}
				});
				//close on ipads // iphones
				var ua = navigator.userAgent,
				event = (ua.match(/iPad/i) || ua.match(/iPhone/i)) ? "touchstart" : "click";
				
				$('body').on(event, function (ev) {
					console.log(event.target);
					toggleBox( id, false );
				});
				//not on the box
				$('.spu-box' ).on(event, function(event) {
					event.stopPropagation();
				});
			}
			// Seconds left to close
			// if( secondsClose > 0 )
			// {
			// 	spu_count= defaults.s_to_close;
			// 	spu_counter = setInterval(function(){spu_timer(defaults)}, 1000);
			// }

			//hide boxes and remove left-99999px we cannot since beggining of facebook won't display
			$box.hide().css('left','');

			// add box to global boxes array
			$boxes[id] = $box;


			if(triggerMethod == 'seconds') {
				var triggerSeconds = parseInt( $box.data('trigger-number'), 10 );
			} else {
				var triggerPercentage = ( triggerMethod == 'percentage' ) ? ( parseInt( $box.data('trigger-number'), 10 ) / 100 ) : 0.8;
				var triggerHeight = ( triggerPercentage * $(document).height() );
			}

			// functions that check % of height
			var triggerHeightCheck = function() 
			{
				if(timer) { 
					clearTimeout(timer); 
				}

				timer = window.setTimeout(function() { 
					var scrollY = $(window).scrollTop();
					var triggered = ((scrollY + windowHeight) >= triggerHeight);

					// show box when criteria for this box is matched
					if( triggered ) {

						// remove listen event if box shouldn't be hidden again
						if( ! autoHide ) {
							$(window).unbind('scroll', triggerHeightCheck);
						}
						//if is a centered popup, center it
						if( $box.hasClass('spu-centered') ) {

							centerBox( id );
							
						}
						toggleBox( id, true );
					} else {
						toggleBox( id, false );
					}

				}, 100);
			}
			// function that show popup after X secs
			var triggerSecondsCheck = function() 
			{
				if(timer) { 
					clearTimeout(timer); 
				}

				timer = window.setTimeout(function() { 
					//if is a centered popup, center it
					if( $box.hasClass('spu-centered') ) {

						centerBox( id );
							
					}
					toggleBox( id, true );					

				}, triggerSeconds * 1000);
			}

			// show box if cookie not set or if in test mode
			var cookieValue = readCookie( 'spu_box_' + id );

			if( cookieValue == undefined || ( isAdmin && testMode ) ) {
				
				if(triggerMethod == 'seconds') {
					triggerSecondsCheck();
				} else {
					$(window).bind( 'scroll', triggerHeightCheck );
					// init, check box criteria once
					triggerHeightCheck();
				}	

				// shows the box when hash refers to a box
				if(window.location.hash && window.location.hash.length > 0) {

					var hash = window.location.hash;
					var $element;

					if( hash.substring(1) === $box.attr( 'id' ) ) {
						setTimeout(function() {
							toggleBox( id, true );
						}, 100);
					}
				}
			}	/* end check cookie */

			$box.find(".spu-close").click(function() {

				// hide box
				toggleBox( id, false );

				if(triggerMethod == 'percentage') {
					// unbind 
					$(window).unbind( 'scroll', triggerHeightCheck );
				}	

				// set cookie
				var days = parseInt( $box.data('cookie') );
				if( days > 0 ) {
					createCookie( 'spu_box_' + id, true, days );
				}
				
			});
			
			// add link listener for this box
			$('a[href="#' + $box.attr('id') +'"]').click(function() { toggleBox(id, true); return false; });

		});
		//function that center popup on screen
		function centerBox( id ) {
			var $box 			= $boxes[id];
			var windowWidth 	= $(window).width();
			var windowHeight 	= $(window).height();
			var popupHeight 	= $box.height();
			var popupWidth 		= $box.width();
			$box.css({
				"position": "fixed",
				"top": windowHeight / 2 - popupHeight / 2,
				"left": windowWidth / 2 - popupWidth / 2
			});
		}

		//function that show/hide box
		function toggleBox( id, show ) {
			var $box 	= $boxes[id];
			var $bg	 	= $('#spu-bg-'+id);
			var $bgopa 	= $box.data('bgopa');

			// don't do anything if box is undergoing an animation
			if( $box.is( ":animated" ) ) {
				return false;
			}

			// is box already at desired visibility?
			if( ( show === true && $box.is( ":visible" ) ) || ( show === false && $box.is( ":hidden" ) ) ) {
				return false;
			}

			// show box
			var animation = $box.data('animation');

			if( animation === 'fade' ) {
				$box.fadeToggle( 'slow' );
			} else {
				$box.slideToggle( 'slow' );
			}
			if( show === true && $bgopa > 0 ){
				$bg.fadeIn();
			} else {
				$bg.fadeOut();
			}

			return show;
		}

	return {
		show: function( box_id ) {
			return toggleBox( box_id, true );
		},
		hide: function( box_id ) {
			return toggleBox( box_id, false );
		}
	}

	})(window.jQuery);

});
/**
 * Cookie functions
 */
function createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else var expires = "";
	document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}
