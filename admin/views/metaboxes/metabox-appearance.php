<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;?>

<table class="form-table">

		<?php do_action( 'spu/metaboxes/before_appearance_options', $opts );?>
		<tr valign="top">
			<td colspan="3" class="spu-bg-opacity">
				<label for="spu_bgopacity"><?php _e( 'Background opacity', 'popups' ); ?></label>
				<input type="number" id="spu_bgopacity" name="spu[css][bgopacity]" min="0" step="0.1" max="1" value="<?php echo esc_attr($opts['css']['bgopacity']); ?>" />
				<p class="help"><?php _e( 'Leave at 0 for no background. Max value is 1', 'popups' ); ?></p>
			</td>

		</tr>
		<tr valign="top" class="spu-appearance">
			<td class="spu-border-width">
				<label class="spu-label" for="spu-background-color"><?php _e( 'Background color', 'popups' ); ?></label>
				<input id="spu-background-color" name="spu[css][background_color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['background_color']); ?>" />
			</td>
			<td class="spu-text-color">
				<label class="spu-label" for="spu-color"><?php _e( 'Text color', 'popups' ); ?></label>
				<input id="spu-color" name="spu[css][color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['color']); ?>" />
			</td>
			<td class="spu-box-width">
				<label class="spu-label" for="spu-width"><?php _e( 'Box width', 'popups' ); ?></label>
				<input id="spu-width" name="spu[css][width]" id="spu-box-width" type="text" class="small" value="<?php echo esc_attr($opts['css']['width']); ?>" />
			</td>
		</tr>
		<tr valign="top" class="spu-appearance">
			<td class="spu-border-color">
				<label class="spu-label" for="spu-border-color"><?php _e( 'Border color', 'popups' ); ?></label>
				<input name="spu[css][border_color]" id="spu-border-color" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['border_color']); ?>" />
			</td>
			<td class="spu-border-width">
				<label class="spu-label" for="spu-border-width"><?php _e( 'Border width', 'popups' ); ?></label>
				<input name="spu[css][border_width]" id="spu-border-width" type="number" min="0" max="25" value="<?php echo esc_attr($opts['css']['border_width']); ?>" /> px
			</td>
			<td></td>
		</tr>
		<tr class="spu-appearance">
			<td colspan="3">
				<label class="spu-label" for="spu-custom-css"><?php _e( 'Custom CSS', 'popups' ); ?></label>
				<div id="custom_css_container">
					<div name="custom_css" id="custom_css" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 200px; position: relative;"></div>
				</div>
				<?php
				if( !isset( $opts['css']['custom_css'] ) ) {
					$popup_id = get_the_id();
					$opts['css']['custom_css'] = "/*
* Add custom CSS for this popup
* Be sure to start your rules with #spu-{$popup_id} { } and use !important when needed to override plugin rules
*/";
				}
				?>
				<textarea name="spu[css][custom_css]" id="spu-custom-css" style="display: none;"><?php echo esc_attr($opts['css']['custom_css']); ?></textarea>
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_appearance_options', $opts );?>
	</table>