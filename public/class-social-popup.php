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
	const VERSION = '1.0.0';

	/**
	 * Popups to use acrros files
	 *
	 * @since 1.7
	 *
	 * @var string
	 */
	const PLUGIN_NAME = 'Popups';

	/**
	 * @TODO - Rename "plugin-name" to the name your your plugin
	 *
	 * Unique identifier for your plugin.
	 *
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
	var $info;

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
		);	

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Register public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

		//check for matches
		add_action( 'wp_enqueue_scripts', array( $this, 'check_for_matches' ) );

		//print boxes
		add_action( 'wp_footer', array( $this, 'print_boxes' ) );

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
		add_shortcode( 'spu-twitter', array( $this, 'twitter_shortcode' ) );
		add_shortcode( 'spu-google', array( $this, 'google_shortcode' ) );
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
			$post_content ='<h1 style="text-align: center;">Support us!</h1>
<p style="text-align: center;">If you like this site please help and make click on any of these buttons!</p>
<p style="text-align: center;">[spu-facebook][spu-google][spu-twitter]</p>';
			$defaults = array(
			  'post_status'           => 'draft', 
			  'post_type'             => 'spucpt',
			  'post_content'		  => $post_content,
			  'post_title'			  => 'Popups Example'
			);
			wp_insert_post( $defaults, $wp_error );
		}
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

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}



	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function register_scripts() {
		wp_register_style( 'spu-public-css', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
		wp_register_script( 'spu-public', plugins_url( 'assets/js/min/public-ck.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
		
		wp_register_script( 'spu-facebook', 'http://connect.facebook.net/'.get_bloginfo('language').'/all.js#xfbml=1', array('jquery'), self::VERSION, FALSE);
		wp_register_script( 'spu-twitter', 'http://platform.twitter.com/widgets.js', array('jquery'), self::VERSION, FALSE);
		wp_register_script( 'spu-google', 'https://apis.google.com/js/plusone.js', array('jquery'), self::VERSION, FALSE);
	}

	/**
	 * load and print SPU popup when rules matches
	 *
	 * @since    1.0.0
	 */
	public function check_for_matches() {

		global $wpdb;
		global $spu_matches;
		global $total_shortcodes;

		include_once( SPU_PLUGIN_DIR . 'public/includes/class-spu-rules.php' );
		
		$spu_rules = new Spu_Rules();

		$matches = $facebook = $twitter = $google = false;

		//Grab all popups ids
		$spu_ids = $wpdb->get_results( "SELECT ID, post_content FROM $wpdb->posts WHERE post_type='spucpt' AND post_status='publish'");
		foreach( $spu_ids as $spu ) {
			
			$rules = get_post_meta( $spu->ID, 'spu_rules' ,true );

			$match = $spu_rules->check_rules( $rules );
			if( $match ) {
				$matches = true;
				$spu_matches[] = $spu->ID;
				
				$total_shortcodes[$spu->ID] = 0;

				//if we have matches we check for shortcodes to add scripts later
				if( has_shortcode( $spu->post_content, 'spu-facebook' ) ){
					$facebook = true;
					$total_shortcodes[$spu->ID]++;
				}				
				if( has_shortcode( $spu->post_content, 'spu-twitter' ) ){
					$twitter = true;
					$total_shortcodes[$spu->ID]++;
				}			
				if( has_shortcode( $spu->post_content, 'spu-google' ) ){
					$google = true;
					$total_shortcodes[$spu->ID]++;
				}
			}
		}

		if( $matches ) {

			
			wp_enqueue_script('spu-public');
			wp_enqueue_style('spu-public-css');
			wp_localize_script( 'spu-public', 'spuvar', array( 'is_admin' => current_user_can( 'administrator' ) ) );

			if( $facebook ){
				wp_enqueue_script( 'spu-facebook' );
			}
			if( $twitter ){
				wp_enqueue_script( 'spu-twitter' );
			}	

			if( $google ){
				wp_enqueue_script( 'spu-google' );
			}	
		}
		
	
	}


	/**
	 * [facebook_shortcode description]
	 * @param  {[type]} $content [description]
	 * @param  {[type]} $atts    [description]
	 * @return {[type]}          [description]
	 */
	function facebook_shortcode( $atts, $content ) {
		
		extract( shortcode_atts( array(
			'href' 			=> 'https://www.facebook.com/pages/Timersys/146687622031640',
			'layout' 	 	=> 'button_count', // standard, box_count, button_count, button
			'show_faces' 	=> 'false', // true
			'share'	 		=> 'false', // true
			'action' 		=> 'like', // recommend
			'width'			=> '',
		), $atts ) );
		

		return '<div class="spu-facebook spu-shortcode"><div class="fb-like" data-width="'.$width.'" data-href="'.$href.'" data-layout="'.$layout.'" data-action="'.$action.'" data-show-faces="'.$show_faces.'" data-share="'.$share.'"></div></div>';

	}

	/**
	 * [twitter_shortcode description]
	 * @param  [type] $content [description]
	 * @param  [type] $atts    [description]
	 * @return [type]          [description]
	 */
	function twitter_shortcode( $atts, $content ) {

		extract( shortcode_atts( array(
			'user' 			=> 'chifliiiii',
			'show_count' 	=> 'true', // false
			'size' 			=> '', // large
			'lang' 			=> '',
			'text'	 		=> 'Follow @chifliiiii', 
		), $atts ) );
	
		return '<div class="spu-twitter spu-shortcode"><a href="https://twitter.com/'.$user.'" class="twitter-follow-button" data-show-count="'.$show_count.'" data-size="'.$size.'"></a></div>';

	}

	/**
	 * [google_shortcode description]
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	function google_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'size' 			=> 'medium', //small standard tall
			'annotation' 	=> 'bubble', //inline none
			'url' 			=> 'https://plus.google.com/u/0/103508783120806246698/posts', //inline none
		), $atts ) );
		
		return '<div class="spu-google spu-shortcode"><div class="g-plusone" data-callback="googleCB" data-onendinteraction="closeGoogle" data-recommendations="false" data-annotation="'.$annotation.'" data-size="'.$size.'" data-href="'.$url.'"></div></div>';
	
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
	 * @param  int $spu_id post id of the popup
	 * @return echo the popup
	 */
	function print_boxes(  ) {

		global $spu_matches;
		global $total_shortcodes;

		//if we dont' have matches stop here
		if( empty( $spu_matches) )
			return;
		// Include Helper class
		include_once( SPU_PLUGIN_DIR . 'includes/class-spu-helper.php' );

		foreach ($spu_matches as $spu_id ) {

			?><!-- Popups v<?php echo self::VERSION; ?> - http://wordpress.org/plugins/social-popup/--><?php
			$box = get_post( $spu_id );

			// has box with this id been found?
			if ( ! $box instanceof WP_Post || $box->post_status !== 'publish' ) {
				return; 
			}

			$opts 		= Spu_Helper::get_box_options( $box->ID );
			$css 		= $opts['css'];
			$content 	= $box->post_content;

			// run filters on content
			$content = apply_filters( 'spu/popup/content', $content, $box );

			$auto_hide_small_screens = apply_filters('spu/popup/auto_hide_small_screens', true, $box->ID );
			?>
			<style type="text/css">
				#spu-<?php echo $box->ID; ?> {
					background: <?php echo ( !empty( $css['background_color'] ) ) ? esc_attr($css['background_color']) : 'white'; ?>;
					<?php if ( !empty( $css['color'] ) ) { ?>color: <?php echo esc_attr($css['color']); ?>;<?php } ?>
					<?php if ( !empty( $css['border_color'] ) && !empty( $css['border_width'] ) ) { ?>border: <?php echo esc_attr($css['border_width']) . 'px' ?> solid <?php echo esc_attr($css['border_color']); ?>;<?php } ?>
					max-width: <?php echo ( !empty( $css['width'] ) ) ?  esc_attr( $css['width'] ) : 'auto'; ?>;
				}
				#spu-bg-<?php echo $box->ID; ?> {
					opacity: <?php echo ( !empty( $css['bgopacity'] ) ) ? esc_attr($css['bgopacity']) : 0; ?>;
				}

				<?php if($auto_hide_small_screens) { ?>
					@media only screen and (max-width: 480px) {
						#spu-<?php echo $box->ID; ?> { display: none !important; }
					}
				<?php } ?>
			</style>
			<div class="spu-bg" id="spu-bg-<?php echo $box->ID; ?>"></div>
			<div class="spu-box spu-<?php echo esc_attr( $opts['css']['position'] ); ?> spu-total-<?php echo $total_shortcodes[$box->ID];?>" id="spu-<?php echo $box->ID; ?>" 
			 data-box-id="<?php echo $box->ID ; ?>" data-trigger="<?php echo esc_attr( $opts['trigger'] ); ?>"
			 data-trigger-number="<?php echo esc_attr( absint( $opts['trigger_number'] ) ); ?>" 
			 data-animation="<?php echo esc_attr($opts['animation']); ?>" data-cookie="<?php echo esc_attr( absint ( $opts['cookie'] ) ); ?>" data-test-mode="<?php echo esc_attr($opts['test_mode']); ?>" 
			 data-auto-hide="<?php echo esc_attr($opts['auto_hide']); ?>" data-bgopa="<?php echo esc_attr($css['bgopacity']);?>" data-advanced-close="true"
			 style="left:-99999px">
				<div class="spu-content"><?php echo $content; ?></div>
				<span class="spu-close">&times;</span>
			</div>
			<?php

			?> <!-- / Popups Box -->
			<?php

		} //endforeach
		echo '<div id="fb-root" class=" fb_reset"></div>';

	}

}
