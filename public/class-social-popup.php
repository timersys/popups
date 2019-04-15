<?php
/**
 * Popups.
 *
 * @package   Popups
 * @author    Damian Logghe <info@timersys.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Public Class of the plugin
 * @package Popups
 * @author  Damian Logghe <info@timersys.com>
 */
class SocialPopup {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = SPU_VERSION;

	/**
	 * Popups to use acrros files
	 *
	 * @since 1.7
	 *
	 * @var string
	 */
	const PLUGIN_NAME = 'Popups';

	/**
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'spu';

	/**
	 * Plugins settings
	 * @var array
	 */
	protected $spu_settings = array();

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Plugin info accesible everywhere
	 * @var array
	 *
	 * @since  1.0.0
	 */
	public $info;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// vars
		$this->info = array(
			'dir'				=> SPU_PLUGIN_DIR,
			'url'				=> SPU_PLUGIN_URL,
			'hook'				=> SPU_PLUGIN_HOOK,
			'version'			=> self::VERSION,
			'upgrade_version'	=> '1.6.4.3',
			'wpml_lang'	        => defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : '',
		);
		// Load plugin text domain
		$this->load_plugin_textdomain();

		$this->load_dependencies();

		$this->spu_settings = apply_filters('spu/settings_page/opts', get_option( 'spu_settings' ) );
		//Register cpt
		add_action( 'init', array( $this, 'register_cpt' ) );

		// Add noindex to cpt
		add_action('wp_head', array($this, 'add_no_index') );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Register public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if( empty($this->spu_settings['ajax_mode'] ) ) {
			//print boxes
			add_action( 'wp_footer', array( $this, 'print_boxes' ), 1 );
		}
		add_action( 'init', array( $this, 'register_spu_ajax' ), 11 );

		//FILTERS
		add_filter('spu/get_info', array($this, 'get_info'), 1, 1);

		//spu content function
		add_filter( 'spu/popup/content', 'wptexturize') ;
		add_filter( 'spu/popup/content', 'convert_smilies' );
		add_filter( 'spu/popup/content', 'convert_chars' );
		add_filter( 'spu/popup/content', 'wpautop' );
		add_filter( 'spu/popup/content', 'shortcode_unautop' );
		add_filter( 'spu/popup/content', 'do_shortcode', 11 );

		//Register shortcodes
		add_shortcode( 'spu-facebook', array( $this, 'facebook_shortcode' ) );
		add_shortcode( 'spu-facebook-page', array( $this, 'facebook_page_shortcode' ) );
		add_shortcode( 'spu-twitter', array( $this, 'twitter_shortcode' ) );
		add_shortcode( 'spu-google', array( $this, 'google_shortcode' ) );
		add_shortcode( 'spu-close', array( $this, 'close_shortcode' ) );
		add_shortcode( 'spu', array( $this, 'popup_link_shortcode' ) );

	}
	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
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
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

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
		$name = apply_filters( 'spu/display/title', $name );
		$labels = array(
			'name'               => $name,
			'singular_name'      => _x( 'Popups', 'post type singular name', 'popups' ),
			'menu_name'          => _x( 'Popups', 'admin menu', 'popups' ),
			'name_admin_bar'     => _x( 'Popups', 'add new on admin bar', 'popups' ),
			'add_new'            => _x( 'Add New', 'Popups', 'popups' ),
			'add_new_item'       => __( 'Add New Popups', 'popups' ),
			'new_item'           => __( 'New Popups', 'popups' ),
			'edit_item'          => __( 'Edit Popups', 'popups' ),
			'view_item'          => __( 'View Popups', 'popups' ),
			'all_items'          => __( 'All Popups', 'popups' ),
			'search_items'       => __( 'Search Popups', 'popups' ),
			'parent_item_colon'  => __( 'Parent Popups:', 'popups' ),
			'not_found'          => __( 'No Popups found.', 'popups' ),
			'not_found_in_trash' => __( 'No Popups found in Trash.', 'popups' )
		);

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'publicly_queryable'	=> true,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'query_var'				=> true,
			'exclude_from_search'   => true,
			'rewrite'				=> array( 'slug' => 'spucpt' ),
			'capability_type'		=> 'post',
			'capabilities'			=> array(
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
			'has_archive'			=> false,
			'hierarchical'			=> false,
			'menu_position'			=> null,
			'menu_icon'				=> 'dashicons-share-alt',
			'supports'				=> array( 'title', 'editor','author' ),
			'show_in_rest'	=> true
		);

		register_post_type( 'spucpt', $args );

	}


	function add_no_index() {
		global $post;

		if( get_post_type() == 'spucpt' && is_single() )
			echo '<meta name="robots" content="noindex, nofollow" />';
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// If there are not popups created let's create a default one
		global $wpdb;

		$spus = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type='spucpt'");


		if ( empty( $spus) ) {
			$post_content ='<h2 style="text-align:center">Welcome!</h2><p style="text-align:center">This is popup preview that you can fill with any content you want.</p><p style="text-align:center">The plugin include some shortcodes, you can read more about them at the bottom of this page. The main 3 sections to configure the popup are:</p><p>Appearance: Where you edit the look and feel of the popup.<br>Display Rules: Here you choose on which page to display the popup (Set to all by default)<br>Display options: Some important settings about the plugin, being the more important trigger action.</br></p>';
			$defaults = array(
			  'post_status'           => 'draft',
			  'post_type'             => 'spucpt',
			  'post_content'		  => $post_content,
			  'post_title'			  => 'Popups Example'
			);
			wp_insert_post( $defaults, $wp_error );
		}

		$upgrader = new SocialPopup_Upgrader();
		$upgrader->upgrade_plugin();

		update_option('spu-version', SPU_VERSION);

		do_action( 'spu/activate' );

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = 'popups';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );

	}



	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function register_scripts() {

		$js_url = plugins_url( 'assets/js/public.js', __FILE__ );
		$handle = 'spu-public';

		$opts = $this->spu_settings;

		wp_register_style( 'spu-public-css', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );

		wp_register_script( $handle, $js_url, array( 'jquery' ), self::VERSION, true );

		wp_register_script( 'spu-facebook', '//connect.facebook.net/'.get_locale().'/sdk.js#xfbml=1&version=v2.3', array('jquery'), null, FALSE);

		wp_register_script( 'spu-twitter', '//platform.twitter.com/widgets.js', array('jquery'), self::VERSION, FALSE);

		wp_register_script( 'spu-google', '//apis.google.com/js/platform.js', array('jquery'), self::VERSION, FALSE);

	}

	/**
	 * load and print SPU popup when rules matches
	 *
	 * @since    1.0.0
	 */
	public function check_for_matches() {

		$spu_matches = false;

		$spu_rules = new Spu_Rules();

		//Grab all popups ids
		$spu_ids = $this->get_spu_ids();

		if( !empty($spu_ids) ) {
			foreach ( $spu_ids as $spu ) {
				$rules = !empty($spu->spu_rules) ? unserialize($spu->spu_rules) : array();
				$match = $spu_rules->check_rules( $rules );
				if ( $match ) {
					$spu_matches[$spu->ID] = $spu->ID;
				}
			}
			// check if we are viewing a popup, and only show that one (preview mode)
			$viewing_id = defined('DOING_AJAX') && isset($_REQUEST['pid']) ? $_REQUEST['pid'] : get_queried_object_id();
			foreach ( $spu_ids as $spu ) {
				if (  $spu->ID == $viewing_id ) {
					$spu_matches = array();
					$spu_matches[$spu->ID] = $spu->ID;
				}
			}
		}
		return apply_filters( 'spu/check_for_matches', $spu_matches, $spu_ids, $spu_rules );
	}

	/**
	 * Return array of popups ids
	 */
	function get_spu_ids() {
		global $wpdb;
		// IF wpml is active and spucpt is translated get correct ids for language
		if( function_exists('icl_object_id') ) {
			$spu_ids = $this->get_wpml_ids();
			if(!empty($spu_ids)) {
				return $spu_ids;
			}
		}
		// IF polylang is active and spucpt is translated get correct ids for language
		if( function_exists('pll_current_language') ) {
			$spu_ids = $this->get_polylang_ids();
			if(!empty($spu_ids)) {
				return $spu_ids;
			}
		}
		$post_status = isset( $_REQUEST['is_preview'] ) && $_REQUEST['is_preview'] == '1' ? "AND (post_status='publish' OR  post_status='draft')" : "AND post_status='publish'";
		return $wpdb->get_results( "SELECT ID, post_content, MAX(CASE WHEN pm1.meta_key = 'spu_rules' then pm1.meta_value ELSE NULL END) as spu_rules,
        MAX(CASE WHEN pm1.meta_key = 'spu_ab_parent' then pm1.meta_value ELSE NULL END) as spu_ab_parent
        FROM $wpdb->posts p LEFT JOIN $wpdb->postmeta pm1 ON ( pm1.post_id = p.ID)  WHERE post_type='spucpt' {$post_status} GROUP BY p.ID");
	}

	/**
	 * Function that enqueue all needed scritps and styles
	 * @since   1.3
	 */
	public function enqueue_scripts() {
		$handle = 'spu-public';

		$opts = $this->spu_settings;

		if( isset($this->info['wpml_lang']) && !empty($this->info['wpml_lang']) )
			$ajax_url = '/?spu_action=spu_load&lang='.$this->info['wpml_lang'];
		else
			$ajax_url = '/?spu_action=spu_load';

		wp_enqueue_script($handle);
		wp_enqueue_style('spu-public-css');
		wp_localize_script( $handle, 'spuvar',
			array(
				'is_admin' 						=> current_user_can( apply_filters( 'spu/capabilities/testmode', 'administrator' ) ),
				'disable_style' 				=> isset( $this->spu_settings['shortcodes_style'] ) ? esc_attr( $this->spu_settings['shortcodes_style'] ) : '',
				'ajax_mode'						=> isset( $this->spu_settings['ajax_mode'] ) ? esc_attr( $this->spu_settings['ajax_mode'] ) :'',
				'ajax_url'						=> admin_url('admin-ajax.php'),
				'ajax_mode_url'					=> site_url($ajax_url),
				'pid'						    => get_queried_object_id(),
				'is_front_page'				    => is_front_page(),
				'is_category'				    => is_category(),
				'site_url'				        => site_url(),
				'is_archive'				    => is_archive(),
				'is_search'				        => is_search(),
				'is_preview'				    => (get_post_type() == 'spucpt'),
				'seconds_confirmation_close'	=> apply_filters( 'spu/spuvar/seconds_confirmation_close', 5 ),
			)
		);
		$this->enqueue_social_shortcodes();
	}

	/**
	 * Function that runs the different checks to see if social is enqueue or not
	 * @since   1.3
	 */
	private function enqueue_social_shortcodes(){
		global $wpdb,$spuvar_social;

		$opts = $this->spu_settings;
		$spuvar_social = array();

		$handle = 'spu-public';

		// Check if any popup have facebook, then enqueue js
		if( $fb = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'spu_fb' " ) ) {
			// Check if defined or remove js in options
			if(  !defined( 'SPU_UNLOAD_FB_JS')  && empty( $opts['facebook'] ) )
				wp_enqueue_script( 'spu-facebook');

			$spuvar_social['facebook'] 	= true;

		}

		if( $fb = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key ='spu_tw' " ) ) {
			if( ! defined( 'SPU_UNLOAD_TW_JS')  && empty( $opts['twitter'] ) )
				wp_enqueue_script( 'spu-twitter');

			$spuvar_social['twitter'] 	= true;

		}

		if( $fb = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key ='spu_google' " ) ) {
			if( ! defined( 'SPU_UNLOAD_GO_JS')  && empty( $opts['google'] ) )
				wp_enqueue_script( 'spu-google');

			$spuvar_social['google'] 	= true;
		}
		wp_localize_script( $handle, 'spuvar_social', $spuvar_social);


		//also include gravity forms if needed
		if( $gf = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key ='spu_gravity' " ) ) {
			if( function_exists('gravity_form_enqueue_scripts'))
				gravity_form_enqueue_scripts($gf, true);
		}
	}

	/**
	 * [facebook_shortcode description]
	 *
	 * @param $atts
	 * @param $content
	 *
	 * @internal param $ $content [description] $content [description]
	 * @internal param $atts    [description] $atts    [description]
	 * @return string          [description]
	 */
	function facebook_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'href' 			=> apply_filters( 'spu/social/fb_href', 'https://www.facebook.com/pages/Timersys/146687622031640' ),
			'layout' 	 	=> 'button_count', // standard, box_count, button_count, button
			'show_faces' 	=> 'false', // true
			'share'	 		=> 'false', // true
			'action' 		=> 'like', // recommend
			'width'			=> '',
		), $atts ) );

		$layout = strtolower( trim( $layout ) );
		$action = strtolower( trim( $action ) );

		// to avoid problems
		if( 'standard' != $layout && 'box_count' != $layout && 'button_count' != $layout && 'button' != $layout ) {
			$layout = 'button_count';
		}
		if( 'like' != $action && 'recommend' != $action ) {
			$action = 'like';
		}

		return '<div class="spu-facebook spu-shortcode"><div class="fb-like" data-width="'.strtolower( trim( $width ) ).'" data-href="'. $href .'" data-layout="'.$layout.'" data-action="'.$action.'" data-show-faces="'.strtolower( trim( $show_faces ) ).'" data-share="'.strtolower( trim( $share ) ).'"></div></div>';

	}

	/**
	 * Shortcode for facebook page
	 *
	 * @param $atts
	 * @param $content
	 *
	 * @internal param $ $content [description] $content [description]
	 * @internal param $atts    [description] $atts    [description]
	 * @return string          [description]
	 */
	function facebook_page_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'href' 			=> apply_filters( 'spu/social/fb_href', 'https://www.facebook.com/pages/Timersys/146687622031640' ),
			'name' 	 	    => apply_filters( 'spu/social/fb_name', 'Timersys' ),
			'show_faces' 	=> 'true', // false
			'hide_cover' 	=> 'false', // true
			'width'			=> '500',
		), $atts ) );

		return '<div class="spu-facebook-page"><div class="fb-page" data-href="'. $href .'" data-width="'.strtolower( trim( $width ) ).'" data-hide-cover="'.strtolower( trim( $hide_cover ) ).'" data-show-facepile="'.strtolower( trim( $show_faces ) ).'" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="'. $href .'"><a href="'. $href .'">'.esc_attr( $name ).'</a></blockquote></div></div></div>';

	}

	/**
	 * [twitter_shortcode description]
	 * @param  string $content [description]
	 * @param  array $atts    [description]
	 * @return string          [description]
	 */
	function twitter_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'user' 			=> apply_filters( 'spu/social/tw_user', 'chifliiiii' ),
			'show_count' 	=> 'true', // false
			'size' 			=> '', // large
			'lang' 			=> '',
		), $atts ) );

		return '<div class="spu-twitter spu-shortcode"><a href="https://twitter.com/'.$user.'" class="twitter-follow-button" data-show-count="'.strtolower( trim( $show_count ) ).'" data-size="'.strtolower( trim( $size ) ).'" data-lang="'.$lang.'"></a></div>';

	}

	/**
	 * [google_shortcode description]
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @return string          [description]
	 */
	function google_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'type' 			=> 'g-plusone', //small standard tall
			'size' 			=> 'medium', //small standard tall
			'annotation' 	=> 'bubble', //inline none
			'url' 			=> apply_filters( 'spu/social/gp_url', 'https://plus.google.com/u/0/103508783120806246698/posts' ),
		), $atts ) );

		$size 		= strtolower( trim( $size ) );
		$annotation = strtolower( trim( $annotation ) );

		//to avoid problems
		if( 'medium' != $size && 'small' != $size && 'standard' != $size && 'tall' != $size ) {
			$size = 'medium';
		}
		if( 'bubble' != $annotation && 'inline' != $annotation && 'none' != $annotation ) {
			$annotation = 'bubble';
		}
		if( 'g-plusone' != $type && 'g-follow' != $type  ) {
			$type = 'g-plusone';
		}

		return '<div class="spu-google spu-shortcode"><div class="'.$type.'" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="'.$annotation.'" data-size="'.$size.'" data-href="'.$url.'"></div></div>';

	}

	function close_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'class' 		=> 'button-primary btn-primary',
			'text' 			=> 'Close',
            'conversion'    => false
		), $atts ) );
        $button_class = ! $conversion || $conversion == 'false' ? 'spu-close-popup ' : 'spu-close-convert ';

		return '<button class="'.$button_class.$class.'">'.$text.'</button>';
	}

	/**
	 * Returns plugin info
	 * @param  string $i info name
	 * @return mixed one all or none
	 */
	function get_info( $i )
	{
		// vars
		$return = false;


		// specific
		if( isset($this->info[ $i ]) )
		{
			$return = $this->info[ $i ];
		}


		// all
		if( $i == 'all' )
		{
			$return = $this->info;
		}


		// return
		return $return;
	}

	/**
	 * Print the actual popup
	 * @return mixed echo popup html
	 */
	function print_boxes(  ) {

		do_action('spu/print_boxes');

		$spu_matches = $this->check_for_matches();

		//if we have matches continue
		if( ! empty( $spu_matches) ) {

			foreach ($spu_matches as $spu_id ) {

				include( 'views/popup.php');

			} //endforeach
			echo '<div id="fb-root" class=" fb_reset"></div>';

		}

	}

	/**
	 * Return plugin settings
	 * @return array
	 * @since  1.1
	 */
	function get_settings() {

		return $this->spu_settings;

	}

	/**
	 * Load necessary files
	 * @since  1.2.3
	 */
	private function load_dependencies(){
		// Include Helper class
		require_once( SPU_PLUGIN_DIR . 'includes/class-spu-helper.php' );
		// Include Rules Class
		require_once( SPU_PLUGIN_DIR . 'public/includes/class-spu-rules.php' );
	}

	/**
	 * Custom ajax hook. Wp_ajax won't let us do_shortcode for example
	 * @return  mixed Prints all spus
	 */
	function register_spu_ajax() {

	  	if ( empty( $_REQUEST['spu_action'] ) || $_REQUEST['spu_action'] != 'spu_load' )
    		return;

	  	define( 'DOING_AJAX', TRUE );

  		$this->print_boxes();

  		die();
	}


	/**
	 * Return popups for current language
	 * @return bool | array of ids
	 */
	protected function get_polylang_ids( ) {
		global $wpdb;
		$post_status = isset( $_REQUEST['is_preview'] ) && $_REQUEST['is_preview'] == '1'  ? "AND (post_status='publish' OR  post_status='draft')" : "AND post_status='publish'";

		$sql = "SELECT description
			FROM $wpdb->posts p
			LEFT JOIN $wpdb->term_relationships as tr ON p.ID = tr.object_id
			LEFT JOIN $wpdb->term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
			WHERE post_type='spucpt' {$post_status} AND tt.taxonomy = 'post_translations'
			GROUP BY p.ID";

			$ids = array();
			$popups = $wpdb->get_results( $sql );
			if( !empty($popups) ) {
				$current  = pll_current_language();
				foreach ($popups as $p) {
					$langs = unserialize($p->description);

					if( isset($langs[$current]) )
						$ids[] = $langs[$current];
				}
			}

			if( !empty($ids)){
				$sql = "SELECT DISTINCT ID, post_content,
				MAX(CASE WHEN pm1.meta_key = 'spu_rules' then pm1.meta_value ELSE NULL END) as spu_rules,
				MAX(CASE WHEN pm1.meta_key = 'spu_ab_parent' then pm1.meta_value ELSE NULL END) as spu_ab_parent
				FROM $wpdb->posts p
				LEFT JOIN $wpdb->postmeta pm1 ON ( pm1.post_id = p.ID)
				WHERE post_type='spucpt' {$post_status} AND ID IN (".implode(',',array_unique($ids)).")
				GROUP BY p.ID";
				return  $wpdb->get_results( $sql );
			}

		return false;
	}
	/**
	 * Return popups for current language
	 * @return bool | array of ids
	 */
	protected function get_wpml_ids( ) {
		global $wpdb;
		$wpml_settings = get_option( 'icl_sitepress_settings', true);

		if ( ! empty( $wpml_settings['custom_posts_sync_option']['spucpt'] ) ) {
			$post_status = isset( $_REQUEST['is_preview'] ) && $_REQUEST['is_preview'] == '1' ? "AND (post_status='publish' OR  post_status='draft')" : "AND post_status='publish'";
			$lang_code = isset( $_GET['lang'] ) ? $_GET['lang'] : ICL_LANGUAGE_CODE;
			$sql = "SELECT DISTINCT ID, post_content,
			MAX(CASE WHEN pm1.meta_key = 'spu_rules' then pm1.meta_value ELSE NULL END) as spu_rules,
			MAX(CASE WHEN pm1.meta_key = 'spu_ab_parent' then pm1.meta_value ELSE NULL END) as spu_ab_parent
			FROM $wpdb->posts p
			LEFT JOIN $wpdb->postmeta pm1 ON ( pm1.post_id = p.ID)
			LEFT JOIN {$wpdb->prefix}icl_translations as b ON p.ID = b.element_id
			WHERE post_type='spucpt' {$post_status} AND b.language_code = '" . esc_sql( $lang_code ) . "'
			GROUP BY p.ID";

			$ids = $wpdb->get_results( $sql );
			if( !empty($ids) )
				return $ids;
		}

		return false;
	}

	/**
	 * Popup button
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function popup_link_shortcode($atts, $content ) {
		return '<a href="#" class="spu-open-'.$atts['popup'].'">'.do_shortcode( $content ).'</a>';
	}

}
