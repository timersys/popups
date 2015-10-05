<?php 
/**
 * Settings page template
 * @since  1.1
 */
?>
<div class="wrap">
	<h2>Popups <?php echo SocialPopup::VERSION;
		if( class_exists('PopupsP') ){
			echo ' - Premium v', PopupsP::VERSION;
		}
		?></h2>
	<form name="spu-settings" method="post">
		<table class="form-table">
			<?php do_action( 'spu/settings_page/before' ); ?>
			<tr valign="top" class="">
				<th><label for="add_link"><?php _e( 'Affiliate link', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="text" id="add_link" name="spu_settings[aff_link]" value="<?php  echo @$opts['aff_link'];?>" class="regular-text" />
						<p class="help"><?php echo sprintf(__( 'You can earn money by promoting the plugin! Join <a href="%s">our affiliate program</a> and paste your affiliate link here to earn 35&#37; in commissions . Once entered, it will replace the default "Powered by" on the popups.', 'popups' ) , 'https://wp.timersys.com/affiliates/'); ?></p>
				</td>
			</tr>
			<tr valign="top" class="">
				<th><label for="ajax_mode"><?php _e( 'Ajax mode?', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="ajax_mode" name="spu_settings[ajax_mode]" value="1" <?php checked(@$opts['ajax_mode'], 1); ?> />
					<p class="help"><?php _e( 'Load popups using ajax. Compatible with cache plugins, but might not work with all plugins', 'popups' ); ?></p>
				</td>
			</tr>

			<tr valign="top" class="">
				<th><label for="debug"><?php _e( 'Enable Debug mode?', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="debug" name="spu_settings[debug]" value="1" <?php checked(@$opts['debug'], 1); ?> />
					<p class="help"><?php _e( 'Will use uncompressed js', 'popups' ); ?></p>
				</td>

			</tr>
			<tr valign="top" class="">
				<th><label for="safe"><?php _e( 'Enable safe mode?', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="safe" name="spu_settings[safe]" value="1" <?php checked(@$opts['safe'], 1); ?> /> 
					<p class="help"><?php _e( 'Will move all popups to top of the screen.', 'popups' ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Remove shortcodes style', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[shortcodes_style]" value="1" <?php checked(@$opts['shortcodes_style'], 1); ?> /> 
					<p class="help"><?php _e( 'By default the plugin will apply some style to shortcodes. Check here if you want to manually style them', 'popups' ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Unload Facebook javascript', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[facebook]" value="1" <?php checked(@$opts['facebook'], 1); ?> /> 
					<p class="help"><?php _e( 'If you use your own Facebook script, check this', 'popups' ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Unload Google javascript', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[google]" value="1" <?php checked(@$opts['google'], 1); ?> /> 
					<p class="help"><?php _e( 'If you use your own Google script, check this', 'popups' ); ?></p>
				</td>
				
			</tr>
			<tr valign="top" class="">
				<th><label for="style"><?php _e( 'Unload Twitter javascript', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="style" name="spu_settings[twitter]" value="1" <?php checked(@$opts['twitter'], 1); ?> /> 
					<p class="help"><?php _e( 'If you use your own Twitter script, check this', 'popups' ); ?></p>
				</td>
				
			</tr>
			<?php do_action( 'spu/settings_page/after' ); ?>

			<tr valign="top" class="">
				<th><label for="uninstall"><?php _e( 'Delete all data on Uninstall', 'popups' ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="uninstall" name="spu_settings[uninstall]" value="1" <?php checked(@$opts['uninstall'], 1); ?> />
						<p class="help"><?php _e( 'When you uninstall the plugin all popups, settings and stats will be deleted from your db', 'popups' ); ?></p>
				</td>

			</tr>
			<tr><td><input type="submit" class="button-primary" value="<?php _e( 'Save settings', 'popups' );?>"/></td>
			<?php wp_nonce_field('spu_save_settings','spu_nonce'); ?>
		</table>
	</form>
</div>