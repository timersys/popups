<?php
/**
 * Popup view
 *
 * @package   Popups
 * @author    Damian Logghe <info@timersys.com
 * @license   GPL-2.0+
 * @link      http://wp.timersys.com
 * @copyright 2014 Timersys
 */

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

// Qtranslate support 
if ( function_exists('qtrans_useCurrentLanguageIfNotFoundShowAvailable') ) {
	$content = qtrans_useCurrentLanguageIfNotFoundShowAvailable( $content );
}


do_action( 'spu/popup/before_popup', $box, $opts, $css);

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
</style>
<div class="spu-bg" id="spu-bg-<?php echo $box->ID; ?>"></div>
<div class="spu-box spu-<?php echo esc_attr( $opts['css']['position'] ); ?> spu-total-<?php echo $total_shortcodes[$box->ID];?> <?php echo isset( $total_shortcodes['google'] ) ? 'spu-gogl' : '';?>" id="spu-<?php echo $box->ID; ?>" 
 data-box-id="<?php echo $box->ID ; ?>" data-trigger="<?php echo esc_attr( $opts['trigger'] ); ?>"
 data-trigger-number="<?php echo esc_attr( absint( $opts['trigger_number'] ) ); ?>" 
 data-spuanimation="<?php echo esc_attr($opts['animation']); ?>" data-cookie="<?php echo esc_attr( absint ( $opts['cookie'] ) ); ?>" data-test-mode="<?php echo esc_attr($opts['test_mode']); ?>" 
 data-auto-hide="<?php echo esc_attr($opts['auto_hide']); ?>" data-bgopa="<?php echo esc_attr($css['bgopacity']);?>" data-total="<?php echo $total_shortcodes[$box->ID];?>"
 style="left:-99999px" <?php echo apply_filters( 'spu/popup/data_attrs', $data_attrs, $opts);?>>
	<div class="spu-content"><?php echo $content; ?></div>
	<span class="spu-close">&times;</span>
	<span class="spu-timer"></span>
</div>
<!-- / Popups Box -->
<?php
do_action( 'spu/popup/after_popup', $box, $opts, $css);