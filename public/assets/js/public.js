jQuery(window).load(function() {

	/*!
	 * jQuery Cookie Plugin v1.4.0
	 * https://github.com/carhartl/jquery-cookie
	 *
	 * Copyright 2013 Klaus Hartl
	 * Released under the MIT license
	 */
	(function($) {

		if($.cookie) { return; }

		var pluses = /\+/g;

		function encode(s) {
			return config.raw ? s : encodeURIComponent(s);
		}

		function decode(s) {
			return config.raw ? s : decodeURIComponent(s);
		}

		function stringifyCookieValue(value) {
			return encode(config.json ? JSON.stringify(value) : String(value));
		}

		function parseCookieValue(s) {
			if (s.indexOf('"') === 0) {
				s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
			}

			try {
				s = decodeURIComponent(s.replace(pluses, ' '));
				return config.json ? JSON.parse(s) : s;
			} catch(e) {}
		}

		function read(s, converter) {
			var value = config.raw ? s : parseCookieValue(s);
			return $.isFunction(converter) ? converter(value) : value;
		}

		var config = $.cookie = function (key, value, options) {

			// Write
			if (value !== undefined && !$.isFunction(value)) {
				options = $.extend({}, config.defaults, options);

				if (typeof options.expires === 'number') {
					var days = options.expires, t = options.expires = new Date();
					t.setTime(+t + days * 864e+5);
				}

				return (document.cookie = [
					encode(key), '=', stringifyCookieValue(value),
					options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
					options.path    ? '; path=' + options.path : '',
					options.domain  ? '; domain=' + options.domain : '',
					options.secure  ? '; secure' : ''
				].join(''));
			}

			// Read
			var result = key ? undefined : {};
			var cookies = document.cookie ? document.cookie.split('; ') : [];

			for (var i = 0, l = cookies.length; i < l; i++) {
				var parts = cookies[i].split('=');
				var name = decode(parts.shift());
				var cookie = parts.join('=');

				if (key && key === name) {
					result = read(cookie, value);
					break;
				}

				if (!key && (cookie = read(cookie)) !== undefined) {
					result[name] = cookie;
				}
			}

			return result;
		};

		config.defaults = {};

		$.removeCookie = function (key, options) {
			if ($.cookie(key) === undefined) {
				return false;
			}

			$.cookie(key, '', $.extend({}, options, { expires: -1 }));
			return !$.cookie(key);
		};

	})(jQuery);

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
			var $box = $(this);
			var triggerMethod = $box.data('trigger');
			var animation = $box.data('animation');
			var timer = 0;
			var testMode = (parseInt($box.data('test-mode')) === 1);
			var id = $box.data('box-id');
			var autoHide = (parseInt($box.data('auto-hide')) === 1);

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
							$(window).unbind('scroll', checkBoxCriteria);
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
					centerBox( id );
					toggleBox( id, true );					

				}, triggerSeconds * 1000);
			}

			// show box if cookie not set or if in test mode
			var cookieValue = $.cookie( 'spu_box_' + id );

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
				var boxCookieTime = parseInt( $box.data('cookie') );
				if(boxCookieTime > 0) {
					$.cookie('spu_box_' + id, true, { expires: boxCookieTime, path: '/' });
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

