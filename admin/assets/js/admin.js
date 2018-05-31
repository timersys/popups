var spu = {
	// module
	rules			:	null
};

SPU_ADMIN = (function ( $ ) {

	var spu_editor = '';
	$(document).ready(function(){

		spu.rules.init();
        var color_field = $('#spu-appearance input.spu-color-field'),
			spu_optin	= $('#spu_optin');
		// Only run if there is no optin being used in premium version
		if( color_field.length && (  ! spu_optin.length || spu_optin.val() == '' ) ){
            color_field.wpColorPicker({ change: applyStyles, clear: applyStyles });
        }
		$("#spu-appearance input,#spu-appearance select").not(".spu-color-field").change(applyStyles);

		//Toogle trigger boxes on init
		checkTriggerMethod( $("#spu_trigger").val() );

		//Toogle trigger boxes on change
		$("#spu_trigger").change(function(){
			checkTriggerMethod( $(this).val() );
		})

		/**
		 * Updates on position change
		 */
		$('#spu_position').on('change', function(){
			var $editor     = SPU_ADMIN.spu_editor,
				val         = $(this).val();
			//update editor
			$editor.alterClass('spu-position-*', 'spu-position-'+ val )
			if( val == 'top-bar' || val == 'bottom-bar') {
				$editor.find('.spu-box-container *:not("p, .spu-fields-container, .spu-fields-container *")').remove();
			}
		});

	});

	/**
	 * When tinyMcr loads
	 */
	function TinyMceOptin() {
		SPU_ADMIN.spu_editor = $("#content_ifr").contents().find('html #tinymce');
		
		// add position class
		SPU_ADMIN.spu_editor.addClass(' spu-position-' + spu_js.opts.css.position).removeClass('wp-autoresize');
		applyStyles();
	}

	function checkTriggerMethod( val ) {
		if( val == 'pixels' || val == 'percentage' || val == 'visible') {
			$('tr.auto_hide').fadeIn('fast');
		} else {
			$('tr.auto_hide').fadeOut('fast');
		}/*TODO I should fix premium so these values are not even considered here*/
		if( val == 'manual' || val == 'trigger-click' || val == 'visible' || val == 'exit-intent') {
			$('.spu-trigger-number').fadeOut('fast');
		} else {
			$('.spu-trigger-number').fadeIn('fast');
		}
	}

	// functions
	function getPxValue($el, retval) {
		if($el.val()) {
			return parseInt($el.val());
		} else {
			return (retval !== undefined) ? retval + "px" : 0;
		}
	}

	function getColor($el, retval) {
		if($el.val().length > 0) {
			return $el.wpColorPicker('color');
		} else {
			return (retval !== undefined) ? retval : '';
		}
	}

	function applyStyles() {
		var $editor = $("#content_ifr").contents().find('html');
        $editor.trigger('spu_tinymce_init');
		$editor.css({
			'background': spu_hexToRgb(getColor($("#spu_bgcolor")),$("#spu_bgopacity").val())
		});

        // if there is no optin mode load defaults
        if (typeof spup_js == "undefined" || $('#spu_optin').val() == '') {
            // remove any field that could be there after deactivating premium version
            $editor.find(".spu-fields-container").remove();
            $editor.find("#tinymce").attr('style', 'padding: ' + getPxValue($("#spu-padding")) + 'px !important');
            $editor.find("#tinymce").css({
                'background-color': spu_hexToRgb(getColor($("#spu-background-color")),$("#spu_background_opacity").val()),
                'border-color': getColor($("#spu-border-color")),
                'border-width': getPxValue($("#spu-border-width")),
                'border-style': $("#spu-border-type").val(),
                'width': $("#spu-width").val(),
                'color': getColor($("#spu-color")),
                'height': 'auto',
                'min-width': '200px',
                'max-width': '100%',
                'margin': '8px auto 0;',
                'box-shadow': ($("#spu-shadow-type").val() == 'inset' ? 'inset' : '') +' '+ $("#spu-shadow-x").val() + 'px ' + $("#spu-shadow-y").val() + 'px ' + $("#spu-shadow-blur").val() + 'px ' + $("#spu-shadow-spread").val() + 'px ' + getColor($("#spu-shadow-color"))
        });
            
            var img_src = $('#spu_bgimage').val();
            $editor.find("#tinymce").css({
                'background-image': 'url("'+img_src+'")',
                'background-size' : 'cover'
            });
        }
	}


	/*
	*  Rules
	*
	*  Js for needed for rules
	*
	*  @since: 1.0.0
	*  Thanks to advanced custom fields plugin for part of this code
	*/
	spu.rules = {
		$el : null,
		init : function(){

			// vars
			var _this = this;

			// $el
			_this.$el = $('#spu-rules');

			// add rule
			_this.$el.on('click', '.rules-add-rule', function(){
				_this.add_rule( $(this).closest('tr') );
				return false;
			});

			// remove rule
			_this.$el.on('click', '.rules-remove-rule', function(){
				_this.remove_rule( $(this).closest('tr') );
				return false;
			});

			// add rule
			_this.$el.on('click', '.rules-add-group', function(){
				_this.add_group();
				return false;
			});

			// change rule
			_this.$el.on('change', '.param select', function(){

				// vars
				var $tr = $(this).closest('tr'),
					rule_id = $tr.attr('data-id'),
					$group = $tr.closest('.rules-group'),
					group_id = $group.attr('data-id'),
					val_td   = $tr.find('td.value'),
					ajax_data = {
						'action' 	: "spu/field_group/render_rules",
						'nonce' 	: spu_js.nonce,
						'rule_id' 	: rule_id,
						'group_id' 	: group_id,
						'value' 	: '',
						'param' 	: $(this).val()
					};

				// add loading gif
				var div = $('<div class="spu-loading"><img src="'+spu_js.admin_url+'/images/wpspin_light.gif"/> </div>');
				val_td.html( div );

				// load rules html
				$.ajax({
					url: ajaxurl,
					data: ajax_data,
					type: 'post',
					dataType: 'html',
					success: function(html){
						val_td.html(html);
					}
				});

				// Operators Rules
				var operator_td =  $tr.find('td.operator'),
					ajax_data = {
						'action' 	: "spu/field_group/render_operator",
						'nonce' 	: spu_js.nonce,
						'rule_id' 	: rule_id,
						'group_id' 	: group_id,
						'value' 	: '',
						'param' 	: $(this).val()
					};

				operator_td.html( div );
				$.ajax({
					url: ajaxurl,
					data: ajax_data,
					type: 'post',
					dataType: 'html',
					success: function(html){
						operator_td.html(html);
					}
				});
			});
		},
		add_rule : function( $tr ){

			// vars
			var $tr2 = $tr.clone(),
				old_id = $tr2.attr('data-id'),
				new_id = 'rule_' + ( parseInt( old_id.replace('rule_', ''), 10 ) + 1);

			// update names
			$tr2.find('[name]').each(function(){

				$(this).attr('name', $(this).attr('name').replace( old_id, new_id ));
				$(this).attr('id', $(this).attr('id').replace( old_id, new_id ));
			});

			// update data-i
			$tr2.attr( 'data-id', new_id );

			// add tr
			$tr.after( $tr2 );

			return false;
		},
		remove_rule : function( $tr ){

			// vars
			var siblings = $tr.siblings('tr').length;

			if( siblings == 0 )	{
				// remove group
				this.remove_group( $tr.closest('.rules-group') );
			} else {
				// remove tr
				$tr.remove();
			}
		},
		add_group : function(){

			// vars
			var $group = this.$el.find('.rules-group:last'),
				$group2 = $group.clone(),
				old_id = $group2.attr('data-id'),
				new_id = 'group_' + ( parseInt( old_id.replace('group_', ''), 10 ) + 1);

			// update names
			$group2.find('[name]').each(function(){

				$(this).attr('name', $(this).attr('name').replace( old_id, new_id ));
				$(this).attr('id', $(this).attr('id').replace( old_id, new_id ));

			});

			// update data-i
			$group2.attr( 'data-id', new_id );

			// update h4
			$group2.find('h4').html( spu_js.l10n.or ).addClass('rules-or');

			// remove all tr's except the first one
			$group2.find('tr:not(:first)').remove();

			// add tr
			$group.after( $group2 );
		},
		remove_group : function( $group ){
			$group.remove();
		}
	};

	return {
		onTinyMceInit: function() {
			TinyMceOptin();
		}
	}
}(jQuery));


( function( global, $ ) {
	var editor,
		syncCSS = function() {
			$( '#spu-custom-css' ).val( editor.getSession().getValue() );
		},
		loadAce = function() {
			if(! $('#custom_css').length )
				return;
			editor = ace.edit( 'custom_css' );
			global.safecss_editor = editor;
			editor.getSession().setUseWrapMode( true );
			editor.setShowPrintMargin( false );
			editor.getSession().setValue( $( '#spu-custom-css' ).val() );
			editor.getSession().setMode( "ace/mode/css" );
			jQuery.fn.spin&&$( '#custom_css_container' ).spin( false );
			$( '#post' ).submit( syncCSS );
		};
	if ( $.browser.msie&&parseInt( $.browser.version, 10 ) <= 7 ) {
		$( '#custom_css_container' ).hide();
		$( '#spu-custom-css' ).show();
		return false;
	} else {
		$( global ).load( loadAce );
	}
	global.aceSyncCSS = syncCSS;
} )( this, jQuery );
function spu_hexToRgb(hex, alpha) {
    hex   = hex.replace('#', '');
    var r = parseInt(hex.length == 3 ? hex.slice(0, 1).repeat(2) : hex.slice(0, 2), 16);
    var g = parseInt(hex.length == 3 ? hex.slice(1, 2).repeat(2) : hex.slice(2, 4), 16);
    var b = parseInt(hex.length == 3 ? hex.slice(2, 3).repeat(2) : hex.slice(4, 6), 16);
    if ( alpha ) {
        return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + alpha + ')';
    }
    else {
        return 'rgb(' + r + ', ' + g + ', ' + b + ')';
    }
}
/**
 * jQuery alterClass plugin
 *
 * Remove element classes with wildcard matching. Optionally add classes:
 *   $( '#foo' ).alterClass( 'foo-* bar-*', 'foobar' )
 *
 * Copyright (c) 2011 Pete Boere (the-echoplex.net)
 * Free under terms of the MIT license: http://www.opensource.org/licenses/mit-license.php
 *
 */
(function ( $ ) {
	$.fn.alterClass = function ( removals, additions ) {

		var self = this;
		if ( removals.indexOf( '*' ) === -1 ) {
			// Use native jQuery methods if there is no wildcard matching
			self.removeClass( removals );
			return !additions ? self : self.addClass( additions );
		}

		var patt = new RegExp( '\\s' +
		removals.
			replace( /\*/g, '[A-Za-z0-9-_]+' ).
			split( ' ' ).
			join( '\\s|\\s' ) +
		'\\s', 'g' );

		self.each( function ( i, it ) {
			var cn = ' ' + it.className + ' ';
			while ( patt.test( cn ) ) {
				cn = cn.replace( patt, ' ' );
			}
			it.className = $.trim( cn );
		});

		return !additions ? self : self.addClass( additions );
	};
})( jQuery );