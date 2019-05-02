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
 * Version: 		  1.9.3.7
 * Description: 	  Most complete free Popups plugin, scroll triggered popups, compatible with social networks, Gravity Forms, Ninja Forms, Contact form 7, Mailpoet, Mailchimp for WP, Postmatic, etc
 * Author: 			  timersys
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

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

define( 'SPU_VERSION' , '1.9.3.6' );
define( 'SPU_PLUGIN_DIR' , plugin_dir_path(__FILE__) );
define( 'SPU_PLUGIN_URL' , plugin_dir_url(__FILE__) );
define( 'SPU_PLUGIN_HOOK' , basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

require_once( SPU_PLUGIN_DIR . 'admin/includes/class-spu-upgrader.php' );
require_once( SPU_PLUGIN_DIR . 'public/class-social-popup.php' );
// Include Helper class
require_once( SPU_PLUGIN_DIR . 'includes/class-spu-helper.php' );
// Dependencies
require_once( SPU_PLUGIN_DIR . 'vendor/autoload.php' );

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

	if( get_option('spu_pair_plugins')  && !get_option('spu_pair_plugins_dismiss') )
		add_action( 'admin_notices', array( 'SocialPopup_Notices', 'pair_plugins') );
}
