(function( $ ) {
	'use strict';


    tinymce.create('tinymce.plugins.SPU', {
        init : function(ed, url) {
            ed.addButton('spu_button', {
                title : 'Add Popup',
                cmd : 'spu_button',
                image : url+'/popup.png'
            });
            ed.addCommand('spu_button', function() {

                jQuery('#spu_editor').dialog({
                    height: 500,
                    width: '600px',
                    buttons: {
                        "Insert Shortcode": function() {

                            var spu_id = jQuery('#spu-posts').val();
							var str = "";

                            str = '[spu popup="'+spu_id+'"';
                            var selected_text = ed.selection.getContent();
                            if (selected_text) {

                                str += "]" + selected_text + "[/spu]";

                            } else {

                                str += "]YOUR TEXT OR IMG HERE[/spu]";

                            }


                            var Editor = tinyMCE.get('content');
                            Editor.focus();
                            Editor.selection.setContent(str);


                            jQuery( this ).dialog( "close" );
                        },
                        Cancel: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                }).dialog('open');

            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : 'Popups Button',
                author : 'Damian Logghe',
                authorurl : 'https://timersys.com',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }
    });
    tinymce.PluginManager.add('spu', tinymce.plugins.SPU);
})( jQuery );
