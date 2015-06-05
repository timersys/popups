<?php
/**
 * Popups.
 *
 * @package   SocialPopup_Admin
 * @author    Damian Logghe <info@timersys.com>
 * @license   GPL-2.0+
 * @link      http://wp.timersys.com
 * @copyright 2014 Timersys
 */


define( 'SPU_ADMIN_DIR' , plugin_dir_path(__FILE__) );


/**
 * Admin Class of the plugin
 *
 * @package SocialPopup_Admin
 * @author  Damian Logghe <info@timersys.com>
 */
class SocialPopup_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Plugins settings
	 * @var array
	 */
	protected $spu_settings = array();

	/**
	 * Premium version is enabled
	 *
	 * @since    1.1
	 *
	 * @var      bool
	 */
	protected $premium = false;

	/**
	 * Helper function
	 *
	 * @since    1.1
	 *
	 * @var      bool
	 */
	protected $helper = '';
	
	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {


		$plugin = SocialPopup::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// helper funcs
		$this->helper = new Spu_Helper;

		//settings name
		$this->options_name		= $this->plugin_slug .'_settings';
        
        //load settings
		$this->spu_settings 	= $plugin->get_settings();

		//premium version ?
		$this->premium 			= defined('SPUP_PLUGIN_HOOK');

		//Register cpt
		add_action( 'init', array( $this, 'register_cpt' ) );

		// add settings page
		add_action('admin_menu' , array( $this, 'add_settings_menu' ) );

		//Add our metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		//Save metaboxes
		add_action( 'save_post_spucpt', array( $this, 'save_meta_options' ), 20 );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add an action link pointing to the options page.
		add_filter( 'plugin_action_links_' . SPU_PLUGIN_HOOK, array( $this, 'add_action_links' ) );

		//Filters for rules
		add_filter('spu/get_post_types', array($this, 'get_post_types'), 1, 3);
		add_filter('spu/get_taxonomies', array($this, 'get_taxonomies'), 1, 3);

		//AJAX Actions	
		add_action('wp_ajax_spu/field_group/render_rules', array( $this->helper, 'ajax_render_rules' ) );

		//Tinymce
		add_filter( 'tiny_mce_before_init', array($this, 'tinymce_init') );
		add_action( 'admin_init', array( $this, 'editor_styles' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {


		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	

	/**
	 * Register custom post types
	 * @return void
	 */
	function register_cpt() {

		$name = 'Popups v' . SocialPopup::VERSION;
		if( class_exists('PopupsP') ){
			$name .= ' - Premium v'. PopupsP::VERSION;
		}
		$labels = array(
			'name'               => $name,
			'singular_name'      => _x( 'Popups', 'post type singular name', $this->plugin_slug ),
			'menu_name'          => _x( 'Popups', 'admin menu', $this->plugin_slug ),
			'name_admin_bar'     => _x( 'Popups', 'add new on admin bar', $this->plugin_slug ),
			'add_new'            => _x( 'Add New', 'Popups', $this->plugin_slug ),
			'add_new_item'       => __( 'Add New Popups', $this->plugin_slug ),
			'new_item'           => __( 'New Popups', $this->plugin_slug ),
			'edit_item'          => __( 'Edit Popups', $this->plugin_slug ),
			'view_item'          => __( 'View Popups', $this->plugin_slug ),
			'all_items'          => __( 'All Popups', $this->plugin_slug ),
			'search_items'       => __( 'Search Popups', $this->plugin_slug ),
			'parent_item_colon'  => __( 'Parent Popups:', $this->plugin_slug ),
			'not_found'          => __( 'No Popups found.', $this->plugin_slug ),
			'not_found_in_trash' => __( 'No Popups found in Trash.', $this->plugin_slug )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'spucpt' ),
			'capability_type'    => 'post',
			'capabilities' => array(
		        'publish_posts' 		=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'edit_posts' 			=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'edit_others_posts' 	=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'delete_posts' 			=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'delete_others_posts' 	=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'read_private_posts' 	=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'edit_post' 			=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'delete_post' 			=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		        'read_post' 			=> apply_filters( 'spu/settings_page/roles', 'manage_options'),
		    ),
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'				 => 'dashicons-share-alt',
			'supports'           => array( 'title', 'editor' )
		);

		register_post_type( 'spucpt', $args );
	
	}

	/**
	 * Add menu for Settings page of the plugin
	 * @since  1.1
	 * @return  void
	 */
	public function add_settings_menu() {

		add_submenu_page('edit.php?post_type=spucpt', 'Settings', 'Settings', apply_filters( 'spu/settings_page/roles', 'manage_options'), 'spu_settings', array( $this, 'settings_page' ) );
	
	}



	/**
	 * Settings page of the plugin
	 * @since  1.1
	 * @return  void
	 */	
	public function settings_page() {

		$defaults = apply_filters( 'spu/settings_page/defaults_opts', array(
			'aff_link'         => '',
			'ajax_mode'        => '1',
			'debug'            => '',
			'safe'             => '',
			'shortcodes_style' => '',
			'facebook'         => '',
			'google'           => '',
			'twitter'          => '',
			'spu_license_key'  => '',
			'ua_code'          => '',
			'mc_api'           => '',
		));
		$opts = apply_filters( 'spu/settings_page/opts', get_option( 'spu_settings', $defaults ) );


		if ( isset( $_POST['spu_nonce'] ) && wp_verify_nonce( $_POST['spu_nonce'], 'spu_save_settings' ) ) {
			$opts = esc_sql( @$_POST['spu_settings'] );
			update_option( 'spu_settings' , $opts );
		}


		include 'views/settings-page.php';

	}

	/**
	 * Register the metaboxes for our cpt and remove others
	 */
	public function add_meta_boxes() {

		if( !$this->premium ) {

			add_meta_box(
				'spu-premium',
				__( 'Popups Premium', $this->plugin_slug ),
				array( $this, 'popup_premium' ),
				'spucpt',
				'normal',
				'core'
			);

		}

		add_meta_box(
			'spu-help',
			'<i class="spu-icon-info spu-icon"></i>' . __( 'PopUp Shortcodes', $this->plugin_slug ),
			array( $this, 'popup_help' ),
			'spucpt',
			'normal',
			'core'
		);		

		add_meta_box(
			'spu-rules',
			'<i class="spu-icon-eye spu-icon"></i>' . __( 'PopUp Display Rules', $this->plugin_slug ),
			array( $this, 'popup_rules' ),
			'spucpt',
			'normal',
			'core'
		);		

		add_meta_box(
			'spu-options',
			'<i class="spu-icon-gears spu-icon"></i>' . __( 'Display Options', $this->plugin_slug ),
			array( $this, 'popup_options' ),
			'spucpt',
			'normal',
			'core'
		);

		add_meta_box(
			'spu-support',
			__( 'Need support?', $this->plugin_slug ),
			array( $this, 'metabox_support' ),
			'spucpt',
			'side'
		);

		add_meta_box(
			'spu-donate',
			__( 'Donate & support', $this->plugin_slug ),
			array( $this, 'metabox_donate' ),
			'spucpt',
			'side'
		);

		add_meta_box(
			'spu-links',
			__( 'About the developer', $this->plugin_slug ),
			array( $this, 'metabox_links' ),
			'spucpt',
			'side'
		);
	}

	/**
	 * Include the metabox view for popup premium
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function popup_premium( $post, $metabox ) {

		include 'views/metaboxes/metabox-premium.php';
	}

	/**
	 * Include the metabox view for popup help
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function popup_help( $post, $metabox ) {

		include 'views/metaboxes/metabox-help.php';
	}	
	/**
	 * Include the metabox view for popup rules
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function popup_rules( $post, $metabox ) {

		$groups = apply_filters('spu/metaboxes/get_box_rules', $this->helper->get_box_rules( $post->ID ), $post->ID);

		include 'views/metaboxes/metabox-rules.php';
	}	
	/**
	 * Include the metabox view for popup options
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function popup_options( $post, $metabox ) {
		
		$opts = apply_filters('spu/metaboxes/get_box_options', $this->helper->get_box_options( $post->ID ), $post->ID );

		include 'views/metaboxes/metabox-options.php';
	}

	/**
	 * Include the metabox view for donate box
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function metabox_donate( $post, $metabox ) {
		
		$donate_metabox = apply_filters( 'spu/metaboxes/donate_metabox', dirname(__FILE__) . '/views/metaboxes/metabox-donate.php' );
		
		include $donate_metabox;
	}
	/**
	 * Include the metabox view for support box
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function metabox_support( $post, $metabox ) {
		
		$support_metabox = apply_filters( 'spu/metaboxes/support_metabox', dirname(__FILE__) . '/views/metaboxes/metabox-support.php' );
		
		include $support_metabox;
	}

	/**
	 * Include the metabox view for links box
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function metabox_links( $post, $metabox ) {
		
		$links_metabox = apply_filters( 'spu/metaboxes/links_metabox', dirname(__FILE__) . '/views/metaboxes/metabox-links.php' );
		
		include $links_metabox;
	}

	/**
	 * Saves popup options and rules
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function save_meta_options( $post_id ) {
		// Verify that the nonce is set and valid.
		if ( !isset( $_POST['spu_options_nonce'] ) || ! wp_verify_nonce( $_POST['spu_options_nonce'], 'spu_options' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// same for ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        	return $post_id;
		}
		// same for cron
    	if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
       	 	return $post_id;
    	}
    	// same for posts revisions
    	if ( wp_is_post_revision( $post_id ) ) {
        	return $post_id; 
    	}

		// can user edit this post?
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$opts = $_POST['spu'];
		unset( $_POST['spu'] );

		$post = get_post($post_id);

		// sanitize settings
		$opts['css']['width']	 	 = sanitize_text_field( $opts['css']['width'] );
		$opts['css']['bgopacity']	 = sanitize_text_field( $opts['css']['bgopacity'] );
		$opts['css']['border_width'] = absint( sanitize_text_field( $opts['css']['border_width'] ) );
		$opts['cookie'] 			 = absint( sanitize_text_field( $opts['cookie'] ) );
		$opts['trigger_number'] 	 = absint( sanitize_text_field( $opts['trigger_number'] ) );

		// Check for social shortcodes and update post meta ( we check later if we need to enqueue any social js)
		$total_shortcodes =0;
		if( has_shortcode( $post->post_content, 'spu-facebook' ) || has_shortcode( $post->post_content, 'spu-facebook-page' ) ){
			$total_shortcodes++;
			update_post_meta( $post_id, 'spu_fb', true );
		} else {
			delete_post_meta( $post_id, 'spu_fb');
		}
		if( has_shortcode( $post->post_content, 'spu-twitter' ) ){
			$total_shortcodes++;
			update_post_meta( $post_id, 'spu_tw', true );
		} else {
			delete_post_meta( $post_id, 'spu_tw');
		}
		if( has_shortcode( $post->post_content, 'spu-google' ) ){
			$total_shortcodes++;
			$opts['google'] = true;
			update_post_meta( $post_id, 'spu_google', true );
		} else {
			delete_post_meta( $post_id, 'spu_google');
		}
		// save total shortcodes (for auto styling)
		if( $total_shortcodes ){
			update_post_meta( $post_id, 'spu_social', $total_shortcodes );
		} else {
			delete_post_meta( $post_id, 'spu_social' );
		}
		if( has_shortcode( $post->post_content, 'gravityform' ) ) {
			preg_match('/\[gravityform id="([0-9]+)".*\]/i', $post->post_content, $matches);
			if( !empty( $matches[1] ) )
				update_post_meta( $post_id, 'spu_gravity', $matches[1]);
		} else {
			delete_post_meta( $post_id, 'spu_gravity' );
		}

		// save box settings
		update_post_meta( $post_id, 'spu_options', apply_filters( 'spu/metaboxes/sanitized_options', $opts ) );

		// Start with rules
		if( isset($_POST['spu_rules']) && is_array($_POST['spu_rules']) )
		{
			// clean array keys
			$groups = array_values( $_POST['spu_rules'] );
			foreach($groups as $group_id => $group )
			{
				if( is_array($group) )
				{
					// clean array keys
					$groups_a[] = array_values( $group );

				}
			}

			update_post_meta( $post_id, 'spu_rules', apply_filters( 'spu/metaboxes/sanitized_rules', $groups_a ) );
			unset( $_POST['spu_rules'] );
		}

	}
	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @TODO:
	 *
	 * - Rename "Plugin_Name" to the name your plugin
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		global $pagenow;

		$post_type = isset($_GET['post_type']) ? $_GET['post_type'] : get_post_type();

		if (  $post_type !== 'spucpt' || !in_array( $pagenow, array( 'post-new.php', 'post.php', 'edit.php' ) ) ) {
			return;
		}
		wp_enqueue_style( 'spu-admin-css', plugins_url( 'assets/css/admin.css', __FILE__ ) , '', SocialPopup::VERSION );
		wp_enqueue_style( 'wp-color-picker' );
	
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @TODO:
	 *
	 * - Rename "Plugin_Name" to the name your plugin
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		global $pagenow, $post;

		if ( get_post_type() !== 'spucpt' || !in_array( $pagenow, array( 'post-new.php', 'edit.php', 'post.php' ) ) ) {
			return;
		}

		$box_id = isset( $post->ID ) ? $post->ID : '';

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'spu-admin-js', plugins_url( 'assets/js/admin.js', __FILE__ ) , '', SocialPopup::VERSION );
		wp_localize_script( 'spu-admin-js', 'spu_js', 
				array( 
					'admin_url' => admin_url( ), 
					'nonce' 	=> wp_create_nonce( 'spu_nonce' ),
					'l10n'		=> array (
							'or'	=> __('or', $this->plugin_slug )
						),
					'opts'      => $this->helper->get_box_options($box_id)
				) 
		);

		wp_localize_script( 'spup-admin-js' , 'spup_js' ,
				array(
					'opts'      => $this->helper->get_box_options($box_id),
					'spinner'   => SPU_PLUGIN_URL . 'public/assets/img/ajax-loader.gif'

				)
		);
	}




	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'edit.php?post_type=spucpt' ) . '">' . __( 'Add a Popup', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * Return available posts types. Used in filters
	 * @param  array $post_types custom post types
	 * @param  array  $exclude    cpt to explude
	 * @param  array  $include    cpts to include
	 * @return array  Resulting cpts
	 */
	function get_post_types( $post_types, $exclude = array(), $include = array() ) 	{
	
		// get all custom post types
		$post_types = array_merge($post_types, get_post_types());
		
		
		// core include / exclude
		$spu_includes = array_merge( array(), $include );
		$spu_excludes = array_merge( array( 'spucpt', 'acf', 'revision', 'nav_menu_item' ), $exclude );
	 
		
		// include
		foreach( $spu_includes as $p )
		{					
			if( post_type_exists($p) )
			{							
				$post_types[ $p ] = $p;
			}
		}
		
		
		// exclude
		foreach( $spu_excludes as $p )
		{
			unset( $post_types[ $p ] );
		}
		
		
		return $post_types;
		
	}

	/**
	 * Get taxonomies. Used in filters rules
	 *
	 * @param  array $choices [description]
	 * @param  boolean $simple_value [description]
	 *
	 * @return array [type]                [description]
	 */
	function get_taxonomies( $choices, $simple_value = false ) {	
		
		// vars
		$post_types = get_post_types();
		
		
		if($post_types)
		{
			foreach($post_types as $post_type)
			{
				$post_type_object = get_post_type_object($post_type);
				$taxonomies = get_object_taxonomies($post_type);
				if($taxonomies)
				{
					foreach($taxonomies as $taxonomy)
					{
						if(!is_taxonomy_hierarchical($taxonomy)) continue;
						$terms = get_terms($taxonomy, array('hide_empty' => false));
						if($terms)
						{
							foreach($terms as $term)
							{
								$value = $taxonomy . ':' . $term->term_id;
								
								if( $simple_value )
								{
									$value = $term->term_id;
								}
								
								$choices[$post_type_object->label . ': ' . $taxonomy][$value] = $term->name; 
							}
						}
					}
				}
			}
		}
		
		return $choices;
	}

	/**
	 * Load tinymce style on load
	 * @param  [type] $args [description]
	 * @return [type]       [description]
	 */
	public function tinymce_init($args) {

		if( get_post_type() !== 'spucpt') {
			return $args;
		}

		$args['setup'] = 'function(ed) { if(typeof SPU_ADMIN === \'undefined\') { return; } ed.onInit.add(SPU_ADMIN.onTinyMceInit);if(typeof SPUP_ADMIN === \'undefined\') { return; } ed.onInit.add(SPUP_ADMIN.onTinyMceInit); }';

		return $args;
	}

	/**
	 * Add the stylesheet for optin in editor
	 * @since 1.2.3.6
	 */
	function editor_styles() {
		$post_type = isset($_GET['post']) ? get_post_type($_GET['post']) : '';

		if( 'spucpt' == $post_type || get_post_type() == 'spucpt' || (isset( $_GET['post_type']) && $_GET['post_type'] == 'spucpt') ) {
			add_editor_style( SPU_PLUGIN_URL . 'admin/assets/css/editor-style.css' );
		}
	}
}
