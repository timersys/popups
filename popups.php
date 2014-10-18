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
 * Plugin Name:       Popups
 * Plugin URI:        http://www.timersys.com/free-plugins/social-popup/
 * Version: 		  1.2
 * Description: 	  This plugin will display a popup or splash screen when a new user visit your site showing a Google+, twitter and facebook follow links. This will increase you followers ratio in a 40%. Popup will be close depending on your settings. Check readme.txt for full details.
 * Author: 			  Damian Logghe
 * Author URI:        http://wp.timersys.com
 * Text Domain:       spu
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

define( 'SPU_PLUGIN_DIR' , plugin_dir_path(__FILE__) );
define( 'SPU_PLUGIN_URL' , plugin_dir_url(__FILE__) );
define( 'SPU_PLUGIN_HOOK' , basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );


require_once( plugin_dir_path( __FILE__ ) . 'public/class-social-popup.php' );

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

	add_action( 'plugins_loaded', array( 'SocialPopup_Admin', 'get_instance' ) );

}