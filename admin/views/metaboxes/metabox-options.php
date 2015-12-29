<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;?>

<table class="form-table">
	
	<?php do_action( 'spu/metaboxes/before_display_options', $opts );?>
	<tr valign="top">
		<th><label for="spu_position"><?php _e( 'Box Position', 'popups' ); ?></label></th>
		<td>
			<select id="spu_position" name="spu[css][position]" class="widefat">
				<option value="centered" <?php selected($opts['css']['position'], 'centered'); ?>><?php _e( 'Centered', 'popups' ); ?></option>
				<option value="top-left" <?php selected($opts['css']['position'], 'top-left'); ?>><?php _e( 'Top Left', 'popups' ); ?></option>
				<option value="top-right" <?php selected($opts['css']['position'], 'top-right'); ?>><?php _e( 'Top Right', 'popups' ); ?></option>
				<option value="bottom-left" <?php selected($opts['css']['position'], 'bottom-left'); ?>><?php _e( 'Bottom Left', 'popups' ); ?></option>
				<option value="bottom-right" <?php selected($opts['css']['position'], 'bottom-right'); ?>><?php _e( 'Bottom Right', 'popups' ); ?></option>
				<?php do_action( 'spu/metaboxes/positions', $opts );?>
			</select>
		</td>
		<td colspan="2"></td>
	</tr>
	<tr valign="top">
		<th><label for="spu_trigger"><?php _e( 'Trigger action', 'popups' ); ?></label></th>
		<td class="spu-sm">
			<select id="spu_trigger" name="spu[trigger]" class="widefat">
				
					<option value="seconds" <?php selected($opts['trigger'], 'seconds'); ?>><?php _e( 'seconds after page load', 'popups' ); ?></option>
					<option value="percentage" <?php selected($opts['trigger'], 'percentage'); ?>>% <?php _e( 'of page height', 'popups' ); ?></option>
					<?php do_action( 'spu/metaboxes/trigger_options', $opts );?>
			</select>
		</td>
		<td>
			<input type="number" class="spu-trigger-number" name="spu[trigger_number]" min="0" value="<?php echo esc_attr($opts['trigger_number']); ?>"  />
			<?php do_action( 'spu/metaboxes/trigger_values', $opts );?>
		</td>
	</tr>
	<tr valign="top" class="auto_hide">
		<th><label for="spu_auto_hide"><?php _e( 'Auto-hide?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_auto_hide_1" name="spu[auto_hide]" value="1" <?php checked($opts['auto_hide'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_auto_hide_0" name="spu[auto_hide]" value="0" <?php checked($opts['auto_hide'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'Hide box again when visitors scroll back up?', 'popups' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
	<th><label><?php _e( 'Animation', 'popups' ); ?></label></th>
		<td colspan="3">
			<select id="spu_animation" name="spu[animation]" class="widefat">
				<option value="fade" <?php selected($opts['animation'], 'fade'); ?> > <?php _e( 'Fade In', 'popups' ); ?></option>
				<option value="slide" <?php selected($opts['animation'], 'slide'); ?> > <?php _e( 'Slide In', 'popups' ); ?></option>
				<?php do_action( 'spu/metaboxes/animations', $opts );?>
			</select>
			<p class="help"><?php _e( 'Slide will only apply when popup is on the corners', 'popups' ); ?></p>
		</td>
	</tr>
	
	<tr valign="top">
		<th><label for="spu_cookie"><?php _e( 'Cookie expiration days', 'popups' ); ?></label></th>
		<td colspan="3">
			<input type="number" id="spu_cookie" name="spu[cookie]" min="0" step="1" value="<?php echo esc_attr($opts['cookie']); ?>" />
			<p class="help"><?php _e( 'After closing the box, how many days should it stay hidden?', 'popups' ); ?></p>
		</td>
		
	</tr>
	<tr valign="top">
		<th><label for="spu_test_mode"><?php _e( 'Enable test mode?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_test_mode_1" name="spu[test_mode]" value="1" <?php checked($opts['test_mode'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_test_mode_0" name="spu[test_mode]" value="0" <?php checked($opts['test_mode'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'If test mode is enabled, the box will show up regardless of whether a cookie has been set. (To admins only)', 'popups' ); ?></p>
		</td>
	</tr>
	<tr valign="top" class="conversion_close">
		<th><label for="spu_conversion_close"><?php _e( 'Close on conversion?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_conversion_close_1" name="spu[conversion_close]" value="1" <?php checked($opts['conversion_close'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_conversion_close_0" name="spu[conversion_close]" value="0" <?php checked($opts['conversion_close'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'If you have a form or social shortcode, by default popup will close on submission/conversion', 'popups' ); ?></p>
		</td>
	</tr>
	<tr valign="top" class="powered_link">
		<th><label for="spu_powered_link"><?php _e( 'Show powered by link?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_powered_link_1" name="spu[powered_link]" value="1" <?php checked($opts['powered_link'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_powered_link_0" name="spu[powered_link]" value="0" <?php checked($opts['powered_link'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php echo sprintf(__( 'Shows a "powered by" link below your popup. If your affiliate link is set in the <a href="%s">settings</a>, it will be used.', 'popups' ), admin_url('edit.php?post_type=spucpt&page=spu_settings')); ?></p>
		</td>
	</tr>
	<?php do_action( 'spu/metaboxes/after_display_options', $opts );?>
</table>
<?php wp_nonce_field( 'spu_options', 'spu_options_nonce' ); ?>