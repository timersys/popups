<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;?>

<table class="form-table">
	
	<?php do_action( 'spu/metaboxes/before_display_options', $opts );?>
	<tr valign="top">
		<th><label for="spu_position"><?php _e( 'Box Position', $this->plugin_slug ); ?></label></th>
		<td>
			<select id="spu_position" name="spu[css][position]" class="widefat">
				<option value="centered" <?php selected($opts['css']['position'], 'centered'); ?>><?php _e( 'Centered', $this->plugin_slug ); ?></option>
				<option value="top-left" <?php selected($opts['css']['position'], 'top-left'); ?>><?php _e( 'Top Left', $this->plugin_slug ); ?></option>
				<option value="top-right" <?php selected($opts['css']['position'], 'top-right'); ?>><?php _e( 'Top Right', $this->plugin_slug ); ?></option>
				<option value="bottom-left" <?php selected($opts['css']['position'], 'bottom-left'); ?>><?php _e( 'Bottom Left', $this->plugin_slug ); ?></option>
				<option value="bottom-right" <?php selected($opts['css']['position'], 'bottom-right'); ?>><?php _e( 'Bottom Right', $this->plugin_slug ); ?></option>
				<?php do_action( 'spu/metaboxes/positions', $opts );?>
			</select>
		</td>
		<td colspan="2"></td>
	</tr>
	<tr valign="top">
		<th><label for="spu_trigger"><?php _e( 'Trigger action', $this->plugin_slug ); ?></label></th>
		<td class="spu-sm">
			<select id="spu_trigger" name="spu[trigger]" class="widefat">
				
					<option value="seconds" <?php selected($opts['trigger'], 'seconds'); ?>><?php _e( 'seconds after page load', $this->plugin_slug ); ?></option>
					<option value="percentage" <?php selected($opts['trigger'], 'percentage'); ?>>% <?php _e( 'of page height', $this->plugin_slug ); ?></option>
					<?php do_action( 'spu/metaboxes/trigger_options', $opts );?>
			</select>
		</td>
		<td>
			<input type="number" class="spu-trigger-number" name="spu[trigger_number]" min="0" value="<?php echo esc_attr($opts['trigger_number']); ?>"  />
			<?php do_action( 'spu/metaboxes/trigger_values', $opts );?>
		</td>
	</tr>
	<tr valign="top" class="auto_hide">
		<th><label for="spu_auto_hide"><?php _e( 'Auto-hide?', $this->plugin_slug ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_auto_hide_1" name="spu[auto_hide]" value="1" <?php checked($opts['auto_hide'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_auto_hide_0" name="spu[auto_hide]" value="0" <?php checked($opts['auto_hide'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'Hide box again when visitors scroll back up? Only works when Trigger action is set to % of page height', $this->plugin_slug ); ?></p>
		</td>
		
	</tr>
	<tr valign="top">
	<th><label><?php _e( 'Animation', $this->plugin_slug ); ?></label></th>
		<td colspan="3">
			<select id="spu_animation" name="spu[animation]" class="widefat">
				<option value="fade" <?php checked($opts['animation'], 'fade'); ?> > <?php _e( 'Fade In', $this->plugin_slug ); ?></option>
				<option value="slide" <?php checked($opts['animation'], 'slide'); ?> > <?php _e( 'Slide In', $this->plugin_slug ); ?></option>
				<?php do_action( 'spu/metaboxes/animations', $opts );?>
			</select>
			<p class="help"><?php _e( 'Slide will only apply when popup is on the corners', $this->plugin_slug ); ?></p>
		</td>
	</tr>
	
	<tr valign="top">
		<th><label for="spu_cookie"><?php _e( 'Cookie expiration days', $this->plugin_slug ); ?></label></th>
		<td colspan="3">
			<input type="number" id="spu_cookie" name="spu[cookie]" min="0" step="1" value="<?php echo esc_attr($opts['cookie']); ?>" />
			<p class="help"><?php _e( 'After closing the box, how many days should it stay hidden?', $this->plugin_slug ); ?></p>
		</td>
		
	</tr>
	<tr valign="top">
		<th><label for="spu_test_mode"><?php _e( 'Enable test mode?', $this->plugin_slug ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_test_mode_1" name="spu[test_mode]" value="1" <?php checked($opts['test_mode'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_test_mode_0" name="spu[test_mode]" value="0" <?php checked($opts['test_mode'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'If test mode is enabled, the box will show up regardless of whether a cookie has been set. (To admins only)', $this->plugin_slug ); ?></p>
		</td>
	</tr>
	<?php do_action( 'spu/metaboxes/after_display_options', $opts );?>
</table>

<h3 class="spu-title"><?php _e( 'Appearance', $this->plugin_slug ); ?></h3>
<table class="form-table">
	<?php do_action( 'spu/metaboxes/before_appearance_options', $opts );?>
	<tr valign="top">
		<th><label for="spu_bgopacity"><?php _e( 'Background opacity', $this->plugin_slug ); ?></label></th>
		<td colspan="3">
			<input type="number" id="spu_bgopacity" name="spu[css][bgopacity]" min="0" step="0.1" max="1" value="<?php echo esc_attr($opts['css']['bgopacity']); ?>" />
			<p class="help"><?php _e( 'Leave at 0 for no background. Max value is 1', $this->plugin_slug ); ?></p>
		</td>
		
	</tr>
	<tr valign="top">
		<td>
			<label class="spu-label" for="spu-background-color"><?php _e( 'Background color', $this->plugin_slug ); ?></label>
			<input id="spu-background-color" name="spu[css][background_color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['background_color']); ?>" />
		</td>
		<td>
			<label class="spu-label" for="spu-color"><?php _e( 'Text color', $this->plugin_slug ); ?></label>
			<input id="spu-color" name="spu[css][color]" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['color']); ?>" />
		</td>
		<td>
			<label class="spu-label" for="spu-width"><?php _e( 'Box width', $this->plugin_slug ); ?></label>
			<input id="spu-width" name="spu[css][width]" id="spu-box-width" type="text" class="small" value="<?php echo esc_attr($opts['css']['width']); ?>" />
		</td>
	</tr>
	<tr valign="top">
		<td>
			<label class="spu-label" for="spu-border-color"><?php _e( 'Border color', $this->plugin_slug ); ?></label>
			<input name="spu[css][border_color]" id="spu-border-color" type="text" class="spu-color-field" value="<?php echo esc_attr($opts['css']['border_color']); ?>" />
		</td>
		<td>
			<label class="spu-label" for="spu-border-width"><?php _e( 'Border width', $this->plugin_slug ); ?></label>
			<input name="spu[css][border_width]" id="spu-border-width" type="number" min="0" max="25" value="<?php echo esc_attr($opts['css']['border_width']); ?>" /> px
		</td>
		<td></td>
	</tr>
	<?php do_action( 'spu/metaboxes/after_appearance_options', $opts );?>
</table>

<?php wp_nonce_field( 'spu_options', 'spu_options_nonce' ); ?>