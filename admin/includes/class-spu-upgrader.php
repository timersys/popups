<?php

/*
*  Upgrader Class
*
*  @description: Upgrade rutines and upgrade messages
*  @since 1.3.1
*  @version 1.0
*/

class SocialPopup_Upgrader {

	public function upgrade_plugin() {
		global $wpdb;
		$current_version = get_option('spu-version');

		if( !get_option('spu_plugin_updated') ) {
			// show feedback box if updating plugin
			if ( empty( $current_version ) ) {
				$total = $wpdb->get_var( "SELECT count(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'spucpt'" );
				if ( $total > 0 ) {
					update_option( 'spu_plugin_updated', true );
				}
			} elseif ( ! empty( $current_version ) && version_compare( $current_version, SPU_VERSION, '<' ) ) {
				update_option( 'spu_plugin_updated', true );
			}
		}
	}
}