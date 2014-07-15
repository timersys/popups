<?php

/*
*  Upgrade (NOT USED for now)
*
*  @description: Upgrade rutines and upgrade messages
*  @since 1.0.0
*  @version 1.0
*/

class Spu_Upgrade {

	/**
	*  __construct
	*
	*  @description:
	*  @since 1.0
	*/

	function __construct()
	{
		// actions
		add_action('admin_menu', array($this,'admin_menu'), 11);

	}


	/**
	*  admin_menu
	*  @since 1.0
	**/

	function admin_menu()
	{
		// dont run on plugin activate!
		if( isset($_GET['action']) && $_GET['action'] == 'activate-plugin' )
		{
			return;
		}

		// vars
		$new_version = apply_filters('spu/get_info', 'version');
		$old_version = get_option('spu_version', false);

		// update info
		global $pagenow;

		if( $pagenow == 'plugins.php' )
		{
			$hook = apply_filters('spu/get_info', 'hook');

			add_action( 'in_plugin_update_message-' . $hook, array($this, 'in_plugin_update_message'), 10, 2 );
		}


	
	}





	/**
	 * Shows update changelog message
	 * @param  [type] $plugin_data [description]
	 * @param  [type] $r           [description]
	 * @return [type]              [description]
	 */
	function in_plugin_update_message( $plugin_data, $r )
	{
		// vars
		$version = apply_filters('spu/get_info', 'version');
		#$readme = wp_remote_fopen( 'http://plugins.svn.wordpress.org/advanced-custom-fields/trunk/readme.txt' );
		$readme = wp_remote_fopen( 'http://local.dev.192.168.1.200.xip.io/testdrive/README.txt' );
		$regexp = '/== Changelog ==(.*)= ' . $version . ' =/sm';
		$o = '';


		// validate
		if( !$readme )
		{
			return;
		}


		// regexp
		preg_match( $regexp, $readme, $matches );


		if( ! isset($matches[1]) )
		{
			return;
		}


		// render changelog
		$changelog = explode('*', $matches[1]);
		array_shift( $changelog );


		if( !empty($changelog) )
		{
			$o .= '<div class="acf-plugin-update-info">';
			$o .= '<h3>' . __("What's new", 'acf') . '</h3>';
			$o .= '<ul>';

			foreach( $changelog as $item )
			{
				$item = explode('http', $item);

				$o .= '<li>' . $item[0];

				if( isset($item[1]) )
				{
					$o .= '<a href="http' . $item[1] . '" target="_blank">' . __("credits",'acf') . '</a>';
				}

				$o .= '</li>';


			}

			$o .= '</ul></div>';
		}

		echo $o;


	}



}

new Spu_Upgrade();

?>