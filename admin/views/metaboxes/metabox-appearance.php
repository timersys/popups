<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;?>

<div class="spu-admin-options">

	<?php do_action( 'spu/metaboxes/before_appearance_options', $opts );?>
	<h3>Overlay</h3>
	<table class="form-table">
		<tr>
			<th><label  class="spu-label" for="spu_bgopacity"><?php _e( 'Overlay opacity', 'popups' ); ?></label></th>
			<td>
				<input type="number" id="spu_bgopacity" name="spu[css][bgopacity]" min="0" step="0.1" max="1" value="<?php echo esc_attr($opts['css']['bgopacity']); ?>" />
				<p class="spu-help"><?php _e( 'Leave at 0 for no background. Max value is 1', 'popups' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu_bgcolor"><?php _e( 'Overlay color', 'popups' ); ?></label></th>
			<td>
				<input id="spu_bgcolor" name="spu[css][overlay_color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['overlay_color']); ?>" />
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_overlay_appearance', $opts );?>
		<tr><th colspan="2"><?php if( ! defined('SPUP_VERSION') ) echo sprintf( __( 'On  <a href="%s">Premium version</a> you can have full screen popups, or sticky popups, insert optin forms inside yours post and much more!','popups'), 'https://timersys.com/plugins/popups-premium/?utm_source=Plugin&utm_medium=appearance_overlay&utm_campaign=Popups%20Premium');?></th></tr>
	</table>
	<h3>Popup Background</h3>
	<table class="form-table">
		<tr>
			<th><label class="spu-label" for="spu-background-color"><?php _e( 'Background color', 'popups' ); ?></label></th>
			<td>
				<input id="spu-background-color" name="spu[css][background_color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['background_color']); ?>" />
			</td>
		</tr>
		<tr>
			<th><label  class="spu-label" for="spu_background_opacity"><?php _e( 'Background opacity', 'popups' ); ?></label></th>
			<td>
				<input type="number" id="spu_background_opacity" name="spu[css][background_opacity]" min="0" step="0.1" max="1" value="<?php echo esc_attr($opts['css']['background_opacity']); ?>" />
				<p class="spu-help"><?php _e( 'Leave at 0 for no background. Max value is 1', 'popups' ); ?></p>
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_background_appearance', $opts );?>
		<tr><th colspan="2"><?php if( ! defined('SPUP_VERSION') ) echo sprintf( __( 'Check <a href="%s">Premium version</a> to add background images or choose a pre made optin theme!','popups'), 'https://timersys.com/plugins/popups-premium/?utm_source=Plugin&utm_medium=appearance_bg&utm_campaign=Popups%20Premium');?></th></tr>
	</table>
	<h3>Popup Box</h3>
	<table class="form-table">
		<tr class="hide-for-optins">
			<th><label class="spu-label" for="spu-width"><?php _e( 'Box width', 'popups' ); ?></label></th>
			<td>
				<input id="spu-width" name="spu[css][width]" id="spu-box-width" type="text" class="small" value="<?php echo esc_attr($opts['css']['width']); ?>" />
				<p class="spu-help"><?php _e( 'Max size the responsive popup will grow. You can use % or px.', 'popups' ); ?></p>
			</td>
		</tr>
		<tr class="hide-for-optins">
			<th><label class="spu-label" for="spu-padding"><?php _e( 'Padding', 'popups' ); ?></label></th>
			<td>
				<input id="spu-padding" name="spu[css][padding]" id="spu-box-padding" type="number" class="small" value="<?php echo esc_attr($opts['css']['padding']); ?>" />px
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-color"><?php _e( 'Text color', 'popups' ); ?></label></th>
			<td>
				<input id="spu-color" name="spu[css][color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['color']); ?>" />
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_box_appearance', $opts );?>
	</table>
	<h3>Popup Shadow</h3>
	<table class="form-table">
		<tr>
			<th><label class="spu-label" for="spu-shadow-color"><?php _e( 'Shadow Color', 'popups' ); ?></label></th>
			<td>
				<input id="spu-shadow-color" name="spu[css][shadow_color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['shadow_color']); ?>" />
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-shadow-type"><?php _e( 'Shadow Type', 'popups' ); ?></label></th>
			<td>
				<select name="spu[css][shadow_type]" id="spu-shadow-type">
					<option value="inset" <?php selected('inset',esc_attr($opts['css']['shadow_type']));?>>Inset</option>
					<option value="outset"  <?php selected('outset',esc_attr($opts['css']['shadow_type']));?>>Outset</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-shadow-x"><?php _e( 'X Offset', 'popups' ); ?></label></th>
			<td>
				<input id="spu-shadow-x" name="spu[css][shadow_x_offset]" type="number" step="1" class="small" value="<?php echo esc_attr($opts['css']['shadow_x_offset']); ?>" />px
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-shadow-y"><?php _e( 'Y Offset', 'popups' ); ?></label></th>
			<td>
				<input id="spu-shadow-y" name="spu[css][shadow_y_offset]" type="number" step="1" class="small" value="<?php echo esc_attr($opts['css']['shadow_y_offset']); ?>" />px
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-shadow-blur"><?php _e( 'Blur', 'popups' ); ?></label></th>
			<td>
				<input id="spu-shadow-blur" name="spu[css][shadow_blur]" type="number" step="1" class="small" value="<?php echo esc_attr($opts['css']['shadow_blur']); ?>" />px
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-shadow-spread"><?php _e( 'Spread', 'popups' ); ?></label></th>
			<td>
				<input id="spu-shadow-spread" name="spu[css][shadow_spread]" type="number" step="1" class="small" value="<?php echo esc_attr($opts['css']['shadow_spread']); ?>" />px
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_shadow_appearance', $opts );?>
	</table>
	<h3>Border</h3>

	<table class="form-table">
		<tr>
			<th><label class="spu-label" for="spu-border-color"><?php _e( 'Border color', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][border_color]" id="spu-border-color" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['border_color']); ?>" />
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-border-width"><?php _e( 'Border width', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][border_width]" id="spu-border-width" type="number" min="0" max="25" value="<?php echo esc_attr($opts['css']['border_width']); ?>" /> px
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-border-radius"><?php _e( 'Border radius', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][border_radius]" id="spu-border-radius" type="number" min="0" max="25" value="<?php echo esc_attr($opts['css']['border_radius']); ?>" /> px
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-border-type"><?php _e( 'Border type', 'popups' ); ?></label></th>
			<td>
				<select name="spu[css][border_type]" id="spu-border-type">
					<option value="none" <?php selected('none',esc_attr($opts['css']['border_type']));?>>None</option>
					<option value="solid"  <?php selected('solid',esc_attr($opts['css']['border_type']));?>>Solid</option>
					<option value="dotted"  <?php selected('dotted',esc_attr($opts['css']['border_type']));?>>Dotted</option>
					<option value="dashed"  <?php selected('dashed',esc_attr($opts['css']['border_type']));?>>Dashed</option>
					<option value="double"  <?php selected('double',esc_attr($opts['css']['border_type']));?>>Double</option>
					<option value="groove"  <?php selected('groove',esc_attr($opts['css']['border_type']));?>>Groove</option>
					<option value="inset"  <?php selected('inset',esc_attr($opts['css']['border_type']));?>>Inset</option>
					<option value="outset"  <?php selected('outset',esc_attr($opts['css']['border_type']));?>>Outset</option>
					<option value="ridge"  <?php selected('ridge',esc_attr($opts['css']['border_type']));?>>Ridge</option>
				</select>
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_border_appearance', $opts );?>
	</table>
	<h3>Close</h3>
	<table class="form-table">
		<tr>
			<th><label class="spu-label" for="spu-close-color"><?php _e( 'Color', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][close_color]" id="spu-close-color" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['close_color']); ?>" />
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-close-color"><?php _e( 'Hover Color', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][close_hover_color]" id="spu-close-color" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['close_hover_color']); ?>" />
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-close-color"><?php _e( 'Shadow Color', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][close_shadow_color]" id="spu-close-color" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['close_shadow_color']); ?>" />
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-close-size"><?php _e( 'Size', 'popups' ); ?></label></th>
			<td>
				<input name="spu[css][close_size]" id="spu-close-size" type="text" class="" value="<?php echo esc_attr($opts['css']['close_size']); ?>" />
				<p class="spu-help"><?php _e( 'You can use px, em or rem units', 'popups' ); ?></p>
			</td>
		</tr>
		<tr>
			<th><label class="spu-label" for="spu-border-radius"><?php _e( 'Position', 'popups' ); ?></label></th>
			<td>
				<select name="spu[css][close_position]" id="spu-border-type">
					<option value="top_right" <?php selected('top_right',esc_attr($opts['css']['close_position']));?>>Top right</option>
					<option value="top_left"  <?php selected('top_left',esc_attr($opts['css']['close_position']));?>>Top Left</option>
					<option value="bottom_right"  <?php selected('bottom_right',esc_attr($opts['css']['close_position']));?>>Bottom Right</option>
					<option value="bottom_left"  <?php selected('bottom_left',esc_attr($opts['css']['close_position']));?>>Bottom Left</option>
				</select>
			</td>
		</tr>
		<?php do_action( 'spu/metaboxes/after_close_appearance', $opts );?>
	</table>
	<h3>CSS</h3>
	<table class="form-table">
		<tr>
			<th><label class="spu-label" for="spu-custom-css"><?php _e( 'Custom CSS', 'popups' ); ?></label></th>
			<td>
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
	</table>
	<?php do_action( 'spu/metaboxes/after_appearance_options', $opts );?>
</div>