<?php

/**
 * Class that handle all admin notices
 *
 * @since      1.3.1
 * @package    SocialPopup
 * @subpackage SocialPopup/Admin/Includes
 * @author     Damian Logghe <info@timersys.com>
 */
class SocialPopup_Notices {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.3.1
	 */
	public function __construct( ) {

		if( isset( $_GET['spu_notice'])){
			update_option('spu_'.esc_attr($_GET['spu_notice']), true);
		}
	}


	public function rate_plugin(){
		?><div class="updated notice">
		<h3><i class=" dashicons-before dashicons-share-alt"></i>WordPress Popups Plugin</h3>
			<p><?php echo sprintf(__( 'We noticed that you have been using our plugin for a while and we would like to ask you a little favour. If you are happy with it and can take a minute please <a href="%s" target="_blank">leave a nice review</a> on WordPress. It will be a tremendous help for us!', 'spu' ), 'https://wordpress.org/support/view/plugin-reviews/popups?filter=5' ); ?></p>
		<ul>
			<li><?php echo sprintf(__('<a href="%s" target="_blank">Leave a nice review</a>'),'https://wordpress.org/support/view/plugin-reviews/popups?filter=5');?></li>
			<li><?php echo sprintf(__('<a href="%s">No, thanks</a>'), '?spu_notice=rate_plugin');?></li>
		</ul>
		</div><?php
	}
}