var spu = {	
	// module
	rules			:	null
};

SPU_ADMIN = (function ( $ ) {


	$(document).ready(function(){

		spu.rules.init();
        var color_field = $('#spu-appearance input.spu-color-field'),
			spu_optin	= $('#spu_optin');
		// Only run if there is no optin being used in premium version
		if( color_field.length && (  ! spu_optin.length || spu_optin.val() == '' ) ){
            color_field.wpColorPicker({ change: applyStyles, clear: applyStyles });
        }
		$("#spu-appearance :input").not(".spu-color-field").change(applyStyles);

		//Toogle trigger boxes on init
		checkTriggerMethod( $("#spu_trigger").val() );
		
		//Toogle trigger boxes on change
		$("#spu_trigger").change(function(){
			checkTriggerMethod( $(this).val() );
		})

	});

	function checkTriggerMethod( val ) {
		if( val == 'percentage' || val == 'visible') {
			$('tr.auto_hide').fadeIn('fast');
		} else {
			$('tr.auto_hide').fadeOut('fast');
		}
	}

	// functions
	function getPxValue($el, retval) 
	{
		if($el.val()) {
			return parseInt($el.val());
		} else {
			return (retval !== undefined) ? retval + "px" : 0;
		}
	}

	function getColor($el, retval)
	{
		if($el.val().length > 0) {
			return $el.wpColorPicker('color');
		} else {
			return (retval !== undefined) ? retval : '';
		}
	}

	function applyStyles() 
	{
		var $editor = $("#content_ifr").contents().find('html');
        $editor.trigger('spu_tinymce_init');
		$editor.css({
			'background': '#9C9B9B;'
		});

        // if there is no optin mode load defaults
        if (typeof spup_js == "undefined" || $('#spu_optin').val() == '') {
            // remove any field that could be there after deactivating premium version
            $editor.find(".spu-fields-container").remove();
            $editor.find("#tinymce").css({
                'padding': '25px',
                'background-color': getColor($("#spu-background-color")),
                'border-color': getColor($("#spu-border-color")),
                'border-width': getPxValue($("#spu-border-width")),
                'border-style': 'solid',
                'width': $("#spu-width").val(),
                'color': getColor($("#spu-color")),
                'height': 'auto',
                'min-width': '200px',
                'max-width': '100%',
                'margin': '8px auto 0;'
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
				$tr.find('td.value').html( div );
				
				
				// load rules html
				$.ajax({
					url: ajaxurl,
					data: ajax_data,
					type: 'post',
					dataType: 'html',
					success: function(html){
		
						div.replaceWith(html);
		
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

			
			if( siblings == 0 )
			{
				// remove group
				this.remove_group( $tr.closest('.rules-group') );
			}
			else
			{
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
			$group2.find('h4').text( spu_js.l10n.or );
			
			
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
			applyStyles();

		}
	}
}(jQuery));	