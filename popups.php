<?php
/**
 * Popups
 *
 * @package   socialpopup
 * @author    Damian Logghe <info@timersys.com>
 * @license   GPL-2.0+
 * @link      http://www.timersys.com/plugins-wordpress/social-popup/
 * @copyright 2014 Damian Logghe
 *
 * @socialpopup
 * Plugin Name:       Popups - WordPress Popup
 * Plugin URI:        http://www.timersys.com/free-plugins/social-popup/
 * Version: 		  1.7.3
 * Description: 	  Most complete free Popups plugin, scroll triggered popups, compatible with social networks, Gravity Forms, Ninja Forms, Contact form 7, Mailpoet, Mailchimp for WP, Postmatic, etc
 * Author: 			  Damian Logghe
 * Author URI:        https://timersys.com
 * Text Domain:       popups
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Create a helper function for easy SDK access.
function pop_fs() {
    global $pop_fs;

    if ( ! isset( $pop_fs ) ) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $pop_fs = fs_dynamic_init( array(
            'id'                  => '990',
            'slug'                => 'popups',
            'type'                => 'plugin',
            'public_key'          => 'pk_6e3112a0da9c3f6324200f829bead',
            'is_premium'          => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => array(
                'slug'           => 'edit.php?post_type=spucpt',
                'account'        => false,
				'contact'        => false,
            ),
        ) );
    }

    return $pop_fs;
}

// Init Freemius.
pop_fs();
// Signal that SDK was initiated.
do_action( 'pop_fs_loaded' );

function pop_fs_custom_connect_message_on_update(
	$message,
	$user_first_name,
	$plugin_title,
	$user_login,
	$site_link,
	$freemius_link
) {
	return sprintf(
		__fs( 'hey-x' ) . '<br>' .
		__( 'Please help us improve %2$s! If you opt-in, some data about your usage (no private data) of %2$s will be sent to us. If you skip this, that\'s okay! %2$s will still work just fine.', 'popups' ),
		$user_first_name,
		'<b>' . $plugin_title . '</b>',
		'<b>' . $user_login . '</b>',
		$site_link,
		$freemius_link
	);
}

pop_fs()->add_filter('connect_message_on_update', 'pop_fs_custom_connect_message_on_update', 10, 6);


/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

define( 'SPU_VERSION' , '1.7.3' );
define( 'SPU_PLUGIN_DIR' , plugin_dir_path(__FILE__) );
define( 'SPU_PLUGIN_URL' , plugin_dir_url(__FILE__) );
define( 'SPU_PLUGIN_HOOK' , basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-spu-upgrader.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-social-popup.php' );
// Include Helper class
require_once( SPU_PLUGIN_DIR . 'includes/class-spu-helper.php' );
// Dependencies
require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'SocialPopup', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SocialPopup', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace SocialPopup with the name of the class defined in
 *   `class-plugin-name.php`
 */
add_action( 'plugins_loaded', array( 'SocialPopup', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/


if ( is_admin() ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-social-popup-admin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/includes/class-spu-notices.php' );

	$spu_notices = new SocialPopup_Notices();

	add_action( 'plugins_loaded', array( 'SocialPopup_Admin', 'get_instance' ) );

	if( get_option('spu_plugin_updated') && !get_option('spu_rate_plugin') )
		add_action( 'admin_notices', array( $spu_notices, 'rate_plugin') );

	if( defined('WP_CACHE') && !get_option('spu_enabled_cache') )
			add_action( 'admin_notices', array( $spu_notices, 'enabled_cache') );

}
// Uninstall now handled on freemius
pop_fs()->add_action('after_uninstall', 'pop_fs_uninstall_cleanup');
function pop_fs_uninstall_cleanup(){
	$opts = get_option( 'spu_settings' );

	if( isset( $opts['uninstall']) && '1' == $opts['uninstall'] ) {
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
}
