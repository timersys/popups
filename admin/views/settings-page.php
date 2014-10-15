<?php 
/**
 * Settings page template
 * @since  1.1
 */
?>
<div class="wrap">
	<h2>Popups <?php echo SocialPopup::VERSION;?></h2>
	<form name="spu-settings" method="post">
		<table class="form-table">
			<?php do_action( 'spu/settings_page/before' ); ?>
			<tr valign="top" class="">
				<th><label for="debug"><?php _e( 'Enable Debug mode?', $this->plugin_slug ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="debug" name="spu_settings[debug]" value="1" <?php checked($opts['debug'], 1); ?> /> 
					<p class="help"><?php _e( 'Will use uncompressed js', $this->plugin_slug ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="safe"><?php _e( 'Enable safe mode?', $this->plugin_slug ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="safe" name="spu_settings[safe]" value="1" <?php checked($opts['safe'], 1); ?> /> 
					<p class="help"><?php _e( 'Will move all popups to top of the screen.', $this->plugin_slug ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Remove shortcodes style', $this->plugin_slug ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[shortcodes_style]" value="1" <?php checked($opts['shortcodes_style'], 1); ?> /> 
					<p class="help"><?php _e( 'By default the plugin will apply some style to shortcodes. Check here if you want to manually style them', $this->plugin_slug ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Unload Facebook javascript', $this->plugin_slug ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[facebook]" value="1" <?php checked($opts['facebook'], 1); ?> /> 
					<p class="help"><?php _e( 'If you use your own Facebook script, check this', $this->plugin_slug ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Unload Google javascript', $this->plugin_slug ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[google]" value="1" <?php checked($opts['google'], 1); ?> /> 
					<p class="help"><?php _e( 'If you use your own Google script, check this', $this->plugin_slug ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Unload Twitter javascript', $this->plugin_slug ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[twitter]" value="1" <?php checked($opts['twitter'], 1); ?> /> 
					<p class="help"><?php _e( 'If you use your own Twitter script, check this', $this->plugin_slug ); ?></p>
				</td>
				
			</tr>
			<?php do_action( 'spu/settings_page/after' ); ?>
			<tr><td><input type="submit" class="button-primary" value="<?php _e( 'Save settings', $this->plugin_slug );?>"/></td>
			<?php wp_nonce_field('spu_save_settings','spu_nonce'); ?>
		</table>
	</form>
</div>