<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;?>
<div class="spu-admin-options">
<h3>Position</h3>
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
				<option value="top-bar" <?php selected($opts['css']['position'], 'top-bar'); ?>><?php _e( 'Top Bar', 'popups' ); ?></option>
				<option value="bottom-bar" <?php selected($opts['css']['position'], 'bottom-bar'); ?>><?php _e( 'Bottom Bar', 'popups' ); ?></option>
				<?php do_action( 'spu/metaboxes/positions', $opts );?>
			</select>
		</td>
		<td colspan="2"></td>
	</tr>
	<tr><th colspan="2"><?php if( ! defined('SPUP_VERSION') ) echo sprintf( __( 'On  <a href="%s">Premium version</a> there are more cool positions and popup styles.','popups'), 'https://timersys.com/plugins/popups-premium/?utm_source=Plugin&utm_medium=options_position&utm_campaign=Popups%20Premium');?></th></tr>
	<?php do_action( 'spu/metaboxes/after_position_options', $opts );?>
</table>
<h3>Trigger</h3>
<table class="form-table">
	<tr valign="top">
		<th><label for="spu_trigger"><?php _e( 'Trigger action', 'popups' ); ?></label></th>
		<td class="spu-sm">
			<select id="spu_trigger" name="spu[trigger]" class="widefat">

					<option value="seconds" <?php selected($opts['trigger'], 'seconds'); ?>><?php _e( 'seconds after page load', 'popups' ); ?></option>
					<option value="percentage" <?php selected($opts['trigger'], 'percentage'); ?>>% <?php _e( 'of page height', 'popups' ); ?></option>
					<option value="pixels" <?php selected($opts['trigger'], 'pixels'); ?>><?php _e( 'Scrolled down pixels', 'popups' ); ?></option>
					<option value="manual" <?php selected($opts['trigger'], 'manual'); ?>><?php _e( 'Manual Triggering', 'popups' ); ?></option>
					<?php do_action( 'spu/metaboxes/trigger_options', $opts );?>
			</select>
		</td>
		<td>
			<input type="number" class="spu-trigger-number" name="spu[trigger_number]" min="0" value="<?php echo esc_attr($opts['trigger_number']); ?>"  />
			<?php do_action( 'spu/metaboxes/trigger_values', $opts );?>
		</td>
	</tr>
	<tr>
		<td style="margin:0;padding:0"></td><td style="position: relative;top: -15px;margin:0;padding:0 0 0 10px"><p class="help"><?php _e( 'Choose how the popup will be triggered on the page', 'popups' ); ?></p></td>
	</tr>
	<tr><th colspan="2"><?php if( ! defined('SPUP_VERSION') ) echo sprintf( __( 'On  <a href="%s">Premium version</a> you can use exit intent trigger technology, or attach to any element that appears in the viewport.','popups'), 'https://timersys.com/plugins/popups-premium/?utm_source=Plugin&utm_medium=options_trigger&utm_campaign=Popups%20Premium');?></th></tr>
	<?php do_action( 'spu/metaboxes/after_trigger_options', $opts );?>
</table>
<h3><?php _e( 'Cookies', 'popups');?></h3>
	<p><?php _e( 'We use PHP cookies to prevent popups opening for users after they closed it.', 'popups');?></p>
<table class="form-table">
	<tr valign="top">
		<th><label for="spu_name_conversion_cookie"><?php _e( 'Conversion cookie name', 'popups' ); ?></label></th>
		<td colspan="3">
			<input type="text" id="spu_name_conversion_cookie" name="spu[name-convert-cookie]" value="<?php echo esc_attr($opts['name-convert-cookie']); ?>" />
			<p class="help"><?php _e( 'The name that the popup will use for convertion cookie. Changing this name will reset the cookie, so all users will see popup again.', 'popups' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th><label for="spu_duration_conversion_cookie"><?php _e( 'Conversion cookie Duration', 'popups' ); ?></label></th>
		<td colspan="3">
			<input type="number" id="spu_duration_conversion_cookie" name="spu[duration-convert-cookie]" min="0" value="<?php echo esc_attr($opts['duration-convert-cookie']); ?>" />
			<select name="spu[type-convert-cookie]">
				<option value="h" <?php selected(esc_attr($opts['type-convert-cookie']),'h'); ?>><?php _e('Hours','popups'); ?></option>
				<option value="d" <?php selected(esc_attr($opts['type-convert-cookie']),'d'); ?>><?php _e('Days','popups'); ?></option>
			</select>
			<p class="help"><?php _e( 'When a user do a conversion like for example a click or form submission, how many days/hours should it stay hidden?', 'popups' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th><label for="spu_name_closing_cookie"><?php _e( 'Closing cookie name', 'popups' ); ?></label></th>
		<td colspan="3">
			<input type="text" id="spu_name_closing_cookie" name="spu[name-close-cookie]" value="<?php echo esc_attr($opts['name-close-cookie']); ?>" />
			<p class="help"><?php _e( 'The name that the popup will use for closing cookie. Changing this name will reset the cookie, so all users will see popup again.', 'popups' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th><label for="spu_duration_close_cookie"><?php _e( 'Closing cookie duration', 'popups' ); ?></label></th>
		<td colspan="3">
			<input type="number" id="spu_duration_close_cookie" name="spu[duration-close-cookie]" min="0"  value="<?php echo isset( $opts['duration-close-cookie'] ) ? esc_attr($opts['duration-close-cookie']) : esc_attr($opts['duration-convert-cookie']); ?>" />
			<select name="spu[type-close-cookie]">
				<option value="h" <?php selected(esc_attr($opts['type-close-cookie']),'h'); ?>><?php _e('Hours','popups'); ?></option>
				<option value="d" <?php selected(esc_attr($opts['type-close-cookie']),'d'); ?>><?php _e('Days','popups'); ?></option>
			</select>
			<p class="help"><?php _e( 'After closing the popup, how many days/hours should it stay hidden?', 'popups' ); ?></p>
		</td>
	</tr>
	<?php do_action( 'spu/metaboxes/after_cookie_options', $opts );?>
</table>
<h3>Close options</h3>
<table class="form-table">
	<tr valign="top" class="conversion_close">
		<th><label for="spu_conversion_close"><?php _e( 'Close on conversion?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_conversion_close_1" name="spu[conversion_close]" value="1" <?php checked($opts['conversion_close'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_conversion_close_0" name="spu[conversion_close]" value="0" <?php checked($opts['conversion_close'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'If you have a form or social shortcode, by default popup will close on submission/conversion', 'popups' ); ?></p>
		</td>
	</tr>
	<?php do_action( 'spu/metaboxes/after_close_options', $opts );?>
</table>
<h3>Other options</h3>
<table class="form-table">
	<tr valign="top" class="auto_hide">
		<th><label for="spu_auto_hide"><?php _e( 'Auto-hide?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_auto_hide_1" name="spu[auto_hide]" value="1" <?php checked($opts['auto_hide'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_auto_hide_0" name="spu[auto_hide]" value="0" <?php checked($opts['auto_hide'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php _e( 'Hide box again when visitors scroll back up?', 'popups' ); ?></p>
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
	<tr valign="top">
		<th><label><?php _e( 'Animation', 'popups' ); ?></label></th>
		<td colspan="3">
			<select id="spu_animation" name="spu[animation]" class="widefat">
				<option value="fade" <?php selected($opts['animation'], 'fade'); ?> > <?php _e( 'Fade In', 'popups' ); ?></option>
				<option value="slide" <?php selected($opts['animation'], 'slide'); ?> > <?php _e( 'Slide In', 'popups' ); ?></option>
				<?php do_action( 'spu/metaboxes/animations', $opts );?>
				<option value="disable" <?php selected($opts['animation'], 'disable'); ?> > <?php _e( 'Disable animations', 'popups' ); ?></option>
			</select>
			<p class="help"><?php _e( 'Slide will only apply when popup is on the corners', 'popups' ); ?></p>
		</td>
	</tr>
	<tr><th colspan="2"><?php if( ! defined('SPUP_VERSION') ) echo sprintf( __( 'On  <a href="%s">Premium version</a> you have 8 new animations to play with!','popups'), 'https://timersys.com/plugins/popups-premium/?utm_source=Plugin&utm_medium=options_trigger&utm_campaign=Popups%20Premium');?></th></tr>
	<tr valign="top" class="powered_link">
		<th><label for="spu_powered_link"><?php _e( 'Show powered by link?', 'popups' ); ?></label></th>
		<td colspan="3">
			<label><input type="radio" id="spu_powered_link_1" name="spu[powered_link]" value="1" <?php checked($opts['powered_link'], 1); ?> /> <?php _e( 'Yes' ); ?></label> &nbsp;
			<label><input type="radio" id="spu_powered_link_0" name="spu[powered_link]" value="0" <?php checked($opts['powered_link'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
			<p class="help"><?php echo sprintf(__( 'Shows a "powered by" link below your popup. If your affiliate link is set in the <a href="%s">settings</a>, it will be used.', 'popups' ), admin_url('edit.php?post_type=spucpt&page=spu_settings')); ?></p>
		</td>
	</tr>
	<?php do_action( 'spu/metaboxes/after_other_options', $opts );?>
</table>
	<?php do_action( 'spu/metaboxes/after_options', $opts );?>
</div>
	<?php wp_nonce_field( 'spu_options', 'spu_options_nonce' ); ?>
