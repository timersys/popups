<?php
/**
 * Uninstall file. If selected all data from popups plugin will be deleted
 */
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) exit();

$opts = get_option( 'spu_settings' );

if( isset( $opts['unistall']) && '1' == $opts['unistall'] ) {
	// delete settings
	delete_option('spu_settings');
	delete_option('spu-version');
	// delete popups
	global $wpdb;
	// IF wpml is active and spucpt is translated get correct ids for language
	$ids = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type='spucpt'");
	if( !empty( $ids ) ) {
		foreach( $ids as $p ) {
			wp_delete_post( $p->ID, true);
		}
	}
}