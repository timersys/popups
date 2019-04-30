<?php
/**
 * Popups.
 *
 * @package   SocialPopup_Admin
 * @author    Damian Logghe <info@timersys.com>
 * @license   GPL-2.0+
 * @link      https://timersys.com
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

		// add settings page
		add_action('admin_menu' , array( $this, 'add_settings_menu' ) );

		//Add our metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		//Save metaboxes
		add_action( 'save_post', array( $this, 'save_meta_options' ), 20, 2 );

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
		add_action('wp_ajax_spu/field_group/render_operator', array( $this->helper, 'ajax_render_operator' ) );
		add_action('wp_ajax_spu_enable_ajax_notice_handler', array( $this, 'ajax_notice_handler' ) );

		//Tinymce
		add_filter( 'tiny_mce_before_init', array($this, 'tinymce_init'), 9999 );
		add_action( 'admin_init', array( $this, 'editor_styles' ) );
		add_action( 'init',  array( $this, 'register_tiny_buttons' ) );

		//Columns in cpt
		add_filter( 'manage_edit-spucpt_columns' ,  array( $this, 'set_custom_cpt_columns'), 10, 2 );
		add_action( 'manage_spucpt_posts_custom_column' ,  array( $this, 'custom_columns'), 10, 2 );
		add_action( 'admin_init' ,  array( $this, 'toggle_on_popup') );

		add_action( 'admin_init' ,  array( $this, 'extra_checks') );

		add_filter('use_block_editor_for_post_type', array( $this, 'disable_gutenberg' ), 10, 2 );
		add_filter('gutenberg_can_edit_post_type', array( $this, 'disable_gutenberg' ), 10, 2 );

		$this->set_rules_fields();
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
	 * Add menu for Settings page of the plugin
	 * @since  1.1
	 * @return  void
	 */
	public function add_settings_menu() {

		add_submenu_page('edit.php?post_type=spucpt', __( 'Settings', 'popups' ), __( 'Settings', 'popups' ), apply_filters( 'spu/settings_page/roles', 'manage_options'), 'spu_settings', array( $this, 'settings_page' ) );

	}



	/**
	 * Settings page of the plugin
	 * @since  1.1
	 * @return  void
	 */
	public function settings_page() {

		$defaults = apply_filters( 'spu/settings_page/defaults_opts', array(
			'aff_link'			=> '',
			'ajax_mode'			=> '0',
			'shortcodes_style'	=> '',
			'facebook'			=> '',
			'google'			=> '',
			'twitter'			=> '',
			'spu_license_key'	=> '',
			'ua_code'			=> '',
			'mc_api'			=> '',
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


		add_meta_box(
			'spu-video',
			'<i class="spu-icon-info spu-icon"></i>' . __( 'Help video', 'popups' ),
			array( $this, 'metabox_video' ),
			'spucpt',
			'normal',
			'core'
		);

		add_meta_box(
			'spu-appearance',
			'<i class="spu-icon-magic spu-icon"></i>' . __( 'PopUp Appearance', 'popups' ),
			array( $this, 'popup_appearance' ),
			'spucpt',
			'normal',
			'core'
		);

		add_meta_box(
			'spu-rules',
			'<i class="spu-icon-eye spu-icon"></i>' . __( 'PopUp Display Rules', 'popups' ),
			array( $this, 'popup_rules' ),
			'spucpt',
			'normal',
			'core'
		);

		add_meta_box(
			'spu-options',
			'<i class="spu-icon-gears spu-icon"></i>' . __( 'Display Options', 'popups' ),
			array( $this, 'popup_options' ),
			'spucpt',
			'normal',
			'core'
		);
		if( !$this->premium ) {

			add_meta_box(
				'spu-premium',
				__( 'Popups Premium', 'popups' ),
				array( $this, 'popup_premium' ),
				'spucpt',
				'normal',
				'core'
			);

		}
		add_meta_box(
			'spu-help',
			'<i class="spu-icon-info spu-icon"></i>' . __( 'PopUp Shortcodes', 'popups' ),
			array( $this, 'popup_help' ),
			'spucpt',
			'normal',
			'core'
		);
		
		add_meta_box(
			'spu-support',
			__( 'Need support?', 'popups' ),
			array( $this, 'metabox_support' ),
			'spucpt',
			'side'
		);

		add_meta_box(
			'spu-donate',
			__( 'Donate & support', 'popups' ),
			array( $this, 'metabox_donate' ),
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
	 * Include the metabox view for popup appearance
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function popup_appearance( $post, $metabox ) {

		$opts = apply_filters('spu/metaboxes/get_box_options', $this->helper->get_box_options( $post->ID ), $post->ID );

		include 'views/metaboxes/metabox-appearance.php';
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
	 * Include the metabox view for help video
	 * @param  object $post    spucpt post object
	 * @param  array $metabox full metabox items array
	 * @since 1.1
	 */
	public function metabox_video( $post, $metabox ) {

		$video_metabox = apply_filters( 'spu/metaboxes/video_metabox', dirname(__FILE__) . '/views/metaboxes/metabox-video.php' );

		include $video_metabox;
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
	 * Saves popup options and rules
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function save_meta_options( $post_id, $post ) {
		static $spu_save = 0;

		if ( $post->post_type != 'spucpt' )
			return $post_id;

		// For some reason sometimes this hook run twice, until I can find the reason and reproduce error
		// let's use a static var to prevent this
		if( $spu_save > 0 )
			return $post_id;

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
		$opts['css']['bgopacity']	            = sanitize_text_field( $opts['css']['bgopacity'] );
		$opts['css']['overlay_color']           = sanitize_text_field( $opts['css']['overlay_color'] );
		$opts['css']['background_color']        = sanitize_text_field( $opts['css']['background_color'] );
		$opts['css']['background_opacity']      = sanitize_text_field( $opts['css']['background_opacity'] );
		$opts['css']['width']	 	            = sanitize_text_field( $opts['css']['width'] );
		$opts['css']['padding']	 	            = absint( sanitize_text_field( $opts['css']['padding'] ) );
		$opts['css']['color']	 	            = sanitize_text_field( $opts['css']['color'] );
		$opts['css']['shadow_color']            = sanitize_text_field( $opts['css']['shadow_color'] );
		$opts['css']['shadow_type']             = sanitize_text_field( $opts['css']['shadow_type'] );
		$opts['css']['shadow_x_offset']         = absint( sanitize_text_field( $opts['css']['shadow_x_offset'] ) );
		$opts['css']['shadow_y_offset']         = absint( sanitize_text_field( $opts['css']['shadow_y_offset'] ) );
		$opts['css']['shadow_blur']             = absint( sanitize_text_field( $opts['css']['shadow_blur'] ) );
		$opts['css']['shadow_spread']           = absint( sanitize_text_field( $opts['css']['shadow_spread'] ) );
		$opts['css']['border_color']            = sanitize_text_field( $opts['css']['border_color'] );
		$opts['css']['border_width']            = absint( sanitize_text_field( $opts['css']['border_width'] ) );
		$opts['css']['border_radius']           = absint( sanitize_text_field( $opts['css']['border_radius'] ) );
		$opts['css']['border_type']             = sanitize_text_field( $opts['css']['border_type'] );
		$opts['css']['close_color']             = sanitize_text_field( $opts['css']['close_color'] );
		$opts['css']['close_hover_color']       = sanitize_text_field( $opts['css']['close_hover_color'] );
		$opts['css']['close_size']              = sanitize_text_field( $opts['css']['close_size'] );
		$opts['css']['close_position']          = sanitize_text_field( $opts['css']['close_position'] );
		$opts['css']['close_shadow_color']      = sanitize_text_field( $opts['css']['close_shadow_color'] );
		$opts['css']['position']                = sanitize_text_field( $opts['css']['position'] );

		$opts['name-convert-cookie'] 			= sanitize_text_field( $opts['name-convert-cookie'] ) ;
		$opts['name-close-cookie'] 			    = sanitize_text_field( $opts['name-close-cookie'] );
		$opts['type-convert-cookie'] 			= sanitize_text_field( $opts['type-convert-cookie'] ) ;
		$opts['type-close-cookie'] 			    = sanitize_text_field( $opts['type-close-cookie'] );
        $opts['duration-convert-cookie']        = absint( sanitize_text_field( $opts['duration-convert-cookie'] ) );
        $opts['duration-close-cookie']          = absint( sanitize_text_field( $opts['duration-close-cookie'] ) );
		// add popup ID to make the unique
        $opts['name-convert-cookie']    = $opts['name-convert-cookie'] == 'spu_conversion' ? 'spu_conversion_'.$post_id :  $opts['name-convert-cookie'] ;
        $opts['name-close-cookie']      = $opts['name-close-cookie'] == 'spu_closing' ? 'spu_closing_'.$post_id :  $opts['name-close-cookie'];

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
		$spu_save++;
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
		wp_enqueue_script( 'ace_code_highlighter_js',  plugins_url( 'assets/js/ace.js', __FILE__ ) , '', '1.0.0', true );
		wp_enqueue_script( 'ace_mode_js', plugins_url( 'assets/js/mode-css.js', __FILE__ ) , array( 'ace_code_highlighter_js' ), '1.0.0', true );
		wp_enqueue_script( 'worker_css_js', plugins_url( 'assets/js/worker-css.js', __FILE__ ) , array( 'jquery', 'ace_code_highlighter_js' ), '1.0.0', true );
		wp_enqueue_script( 'spu-admin-js', plugins_url( 'assets/js/admin.js', __FILE__ ) , '', SocialPopup::VERSION );

		wp_localize_script( 'spu-admin-js', 'spu_js',
				array(
					'admin_url' => admin_url( ),
					'nonce' 	=> wp_create_nonce( 'spu_nonce' ),
					'l10n'		=> array (
							'or'	=> '<span>'.__('OR', 'popups' ).'</span>'
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
				'settings' => '<a href="' . admin_url( 'edit.php?post_type=spucpt' ) . '">' . __( 'Add a Popup', 'popups' ) . '</a>'
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
		$spu_excludes = array_merge( array( 'spucpt', 'acf', 'revision', 'nav_menu_item','custom_css', 'customize_changeset', 'oembed_cache', 'wpvqgr_quiz_trivia', 'wpvqgr_quiz_perso', 'wpvqgr_user', 'popup', 'popup_theme', 'page_rating', 'sa_slider', 'faq', 'opanda-item', 'amn_smtp' ), $exclude );

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
						if( 'nav_menu' == $taxonomy ) continue;
						$terms = get_terms($taxonomy, array('hide_empty' => true));
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
		$func = '';
		// dirty hax, WPML replace our function so let's try to get theirs and add to ours
        // same with follow up emails by woocommerce
		if( array_key_exists('setup', $args) && strpos($args['setup'], 'function(ed)') !== false) {
            if( $pos = strpos($args['setup'], 'function(ed){') !== false ) {
                if( $pos < 15 ){
                    $func .= rtrim(substr_replace($args['setup'],'',$pos,strlen('function(ed){')),'}');
                }
            }
            if( $pos = strpos($args['setup'], 'function(ed) {') !== false ) {
                if( $pos < 15 ){
                    $func .= rtrim(substr_replace($args['setup'],'',$pos,strlen('function(ed) {')),'}');
                }
            }

		}

		$args['setup'] = 'function(ed) { 
		    if(typeof SPU_ADMIN === \'undefined\') { 
		        return; 
		    } 
		    ed.onInit.add(SPU_ADMIN.onTinyMceInit);
		    if(typeof SPUP_ADMIN === \'undefined\') { 
		        return; 
		    } 
		    ed.onInit.add(SPUP_ADMIN.onTinyMceInit);
		    '.$func.'
		}';

		return $args;
	}

	/**
	 * Add the stylesheet for optin in editor
	 * @since 1.2.3.6
	 */
	function editor_styles() {
		global $pagenow;
		$post_type = isset($_GET['post']) ? get_post_type($_GET['post']) : '';

		if( 'spucpt' == $post_type || get_post_type() == 'spucpt' || (isset( $_GET['post_type']) && $_GET['post_type'] == 'spucpt') ) {
			add_editor_style( SPU_PLUGIN_URL . 'admin/assets/css/editor-style.css' );
		}
		// Add html for shortcodes popup
		if( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) {
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			add_action( 'in_admin_footer', array($this, 'add_editor' ),100 );

		}
	}

	function get_rules_choices() {
		$choices = array(
			__("User", 'popups' ) => array(
				'user_type'		    =>	__("User role", 'popups' ),
				'logged_user'	    =>	__("User is logged", 'popups' ),
				'left_comment'	    =>	__("User never left a comment", 'popups' ),
				'search_engine'	    =>	__("User came via a search engine", 'popups' ),
				'same_site'		    =>	__("User did not arrive via another page on your site", 'popups' ),
			),
			__("Post", 'popups' ) => array(
				'post'			=>	__("Post", 'popups' ),
				'post_id'		=>	__("Post ID", 'popups' ),
				'post_type'		=>	__("Post Type", 'popups' ),
				'post_category'	=>	__("Post Category", 'popups' ),
				'post_format'	=>	__("Post Format", 'popups' ),
				'post_status'	=>	__("Post Status", 'popups' ),
				'taxonomy'		=>	__("Post Taxonomy", 'popups' ),
			),
			__("Page", 'popups' ) => array(
				'page'			=>	__("Page", 'popups' ),
				'page_type'		=>	__("Page Type", 'popups' ),
				'page_parent'	=>	__("Page Parent", 'popups' ),
				'page_template'	=>	__("Page Template", 'popups' ),
			),
			__("Other", 'popups' ) => array(
				'referrer'		=>	__("Referrer", 'popups' ),
				'query_string'	=>	__("Query String", 'popups' ),
				'keyword_url'	=>  __("Url contains keyword", 'popups' ),
				'custom_url'	=>	__("Custom Url", 'popups' ),
				'mobiles'		=>	__("Mobile Phone", 'popups' ),
				'tablets'		=>	__("Tablet", 'popups' ),
				'desktop'		=>	__("Desktop", 'popups' ),
				'crawlers'		=>	__("Bots/Crawlers", 'popups' ),
				'browser'		=>	__("Browser", 'popups' ),
			)
		);
		// allow custom rules rules
		return apply_filters( 'spu/metaboxes/rule_types', $choices );
	}

	/**
	 * Hook each rule to a field to print
	 */
	private function set_rules_fields() {

		// User
		add_action('spu/rules/print_user_type_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_logged_user_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_left_comment_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_search_engine_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_same_site_field', array('Spu_Helper', 'print_select'), 10, 2);

		// Post
		add_action('spu/rules/print_post_type_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_post_id_field', array('Spu_Helper', 'print_textfield'), 10, 1);
		add_action('spu/rules/print_post_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_post_category_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_post_format_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_post_status_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_taxonomy_field', array('Spu_Helper', 'print_select'), 10, 2);

		// Page
		add_action('spu/rules/print_page_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_page_type_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_page_parent_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_page_template_field', array('Spu_Helper', 'print_select'), 10, 2);

		//Other
		add_action('spu/rules/print_mobiles_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_desktop_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_tablets_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_crawlers_field', array('Spu_Helper', 'print_select'), 10, 2);
		add_action('spu/rules/print_referrer_field', array('Spu_Helper', 'print_textfield'), 10, 1);
		add_action('spu/rules/print_query_string_field', array('Spu_Helper', 'print_textfield'), 10, 1);
		add_action('spu/rules/print_keyword_url_field', array('Spu_Helper', 'print_textfield'), 10, 1);
		add_action('spu/rules/print_custom_url_field', array('Spu_Helper', 'print_textfield'), 10, 1);
		add_action('spu/rules/print_browser_field', array('Spu_Helper', 'print_textfield'), 10, 1);
	}

	/**
	 * Add custom columns to spu cpt
	 *
	 * @param [type] $columns [description]
	 *
	 * @since  1.3.3
	 * @return array|int
	 */
	public function set_custom_cpt_columns( $columns ){

		unset( $columns['date'] );
		$spu_switch = array( 'spu_switch' => __( 'On / Off', 'popups' ) );
		$columns = array_slice($columns, 0, 1, true) + $spu_switch + array_slice($columns, 1, count( $columns ) - 1, true) ;
		$columns['spu_id']              = __( 'ID', 'popups' );
		$columns['spu_trigger_class']   = __( 'Trigger class', 'popups' );

		return $columns;
	}
	/**
	 * Add callbacks for custom colums
	 * @param  array $column  [description]
	 * @param  int $post_id [description]
	 * @return echo html
	 * @since  1.3.3
	 */
	function custom_columns( $column, $post_id ) {
		global $wpdb;

		switch ( $column ) {
			case 'spu_id' :
				echo '#spu-'.$post_id;
				break;
			case 'spu_switch' :
				echo '<a href="'. wp_nonce_url( admin_url('edit.php?post_type=spucpt&post='. $post_id . '&spu_action=spu_toggle_on'), 'spu_toggle_on', 'spu_nonce') .'"><i class="spu-icon spu-icon-';
				echo get_post_status( $post_id ) == 'publish' ? 'toggle-on' : 'toggle-off';
				echo '"></i></a>';
				break;
			case 'spu_trigger_class':
				echo '.spu-open-' . $post_id;
				break;
		}
	}

	/**
	 * Catch the toggle on/off action and change post status
	 * Redirect to clear url once is completed
	 */
	function toggle_on_popup() {
		//checks
		if ( ! isset( $_GET['spu_action'] ) || $_GET['spu_action'] != 'spu_toggle_on' )
			return;
		if ( !isset( $_GET['spu_nonce'] ) || !wp_verify_nonce($_GET['spu_nonce'], 'spu_toggle_on') )
			return;
		if ( empty( $_GET['post'] ) )
			return;
		$post_id        = esc_attr( $_GET['post'] );
		$post_status    = get_post_status( $post_id );

		$post = array(
			'ID'            => $post_id,
			'post_status'   => $post_status != 'publish' ? 'publish' : 'draft'
		);
		wp_update_post( $post );
		wp_safe_redirect( admin_url('edit.php?post_type=spucpt') );
		exit;
	}

	/**
	 * Add filters for tinymce buttons
	 */
	public function register_tiny_buttons() {
		add_filter( "mce_external_plugins", array( $this, "add_button" ) );
    	add_filter( 'mce_buttons', array( $this, 'register_button' ) );
	}

	/**
	 * Add buton js file
	 * @param [type] $plugin_array [description]
	 */
	function add_button( $plugin_array ) {

    	$plugin_array['spu'] = plugins_url( 'assets/js/spu-tinymce.js' , __FILE__ );
   	 	return $plugin_array;

	}

	/**
	 * Register button
	 * @param  [type] $buttons [description]
	 * @return [type]          [description]
	 */
	function register_button( $buttons ) {
	    array_push( $buttons, '|', 'spu_button' ); // dropcap', 'recentposts
	    return $buttons;
	}

	/**
	 * Add popup editor for
	 */
	function add_editor() {

		include 'includes/tinymce-editor.php';

	}

	/**
	 * Save into db the dimissed notice
	 * @return [type] [description]
	 */
	function ajax_notice_handler() {
		update_option( 'spu_enabled_cache', TRUE );
		die();
	}

	/**
	 * Extra checks needed on admin init
	 */
	public function extra_checks(){
		// second check it's because on 1.9 by mistake was not added SPUP_VERSION
		if( ( defined('SPUP_VERSION') && version_compare(SPUP_VERSION, '1.9.1', '<') ) || ( defined( 'SPUP_PLUGIN_FILE') && ! defined('SPUP_VERSION') ) ){
			deactivate_plugins( array('popups-premium/popups-premium.php'));
			update_option('spu_pair_plugins',true);
			add_action( 'admin_notices', array('SocialPopup_Notices','pair_plugins' ));
		}
	}

	/**
	*	Disabled Gutenberg for Popup CPT
	*/
	public function disable_gutenberg($current_status, $post_type) {
		
		if ($post_type === 'spucpt') {
			return false;
		}
		
		return $current_status;
	}
}
