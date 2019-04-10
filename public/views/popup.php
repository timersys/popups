<?php
/**
 * Popup view
 *
 * @package   Popups
 * @author    Damian Logghe <info@timersys.com
 * @license   GPL-2.0+
 * @link      https://timersys.com
 * @copyright 2014 Timersys
 */

?><!-- Popups v<?php echo self::VERSION; ?> - https://wordpress.org/plugins/popups/ --><?php
$box = get_post( $spu_id );
$helper = new Spu_Helper;

// has box with this id been found?
if ( ! $box instanceof WP_Post  ) {
	return;
}

$opts 		= $helper->get_box_options( $box->ID );
$css 		= $opts['css'];
$content 	= $box->post_content;
$data_attrs	= '';
$box_class  = '';
$width 		= !empty( $css['width'] )  ?  $css['width']  : '';

// run filters on content
$content = apply_filters( 'spu/popup/content', $content, $box );

// Qtranslate support
if ( function_exists('qtrans_useCurrentLanguageIfNotFoundShowAvailable') ) {
	$content = qtrans_useCurrentLanguageIfNotFoundShowAvailable( $content );
}
// WPGlobus support
if ( class_exists('WPGlobus') ) {
	$content = WPGlobus_Core::text_filter( $content, WPGlobus::Config()->language );
}
do_action( 'spu/popup/before_popup', $box, $opts, $css);

?>
<style type="text/css">
#spu-<?php echo $box->ID; ?> .spu-close{
	font-size: <?php echo esc_attr($css['close_size']); ?>;
	color:<?php echo esc_attr($css['close_color']); ?>;
	text-shadow: 0 1px 0 <?php echo esc_attr($css['close_shadow_color']); ?>;
}
#spu-<?php echo $box->ID; ?> .spu-close:hover{
	color:<?php echo esc_attr($css['close_hover_color']); ?>;
}
#spu-<?php echo $box->ID; ?> {
	background-color: <?php echo ( !empty( $css['background_color'] ) ) ? esc_attr($css['background_color']) : 'white'; ?>;
	background-color: <?php echo ( !empty( $css['background_color'] ) ) ? Spu_Helper::hex2rgba(esc_attr($css['background_color']),esc_attr($css['background_opacity'] )) : 'white'; ?>;
	color: <?php echo esc_attr($css['color']); ?>;
	padding: <?php echo esc_attr($css['padding']); ?>px;
	<?php if ( $css['border_type'] != 'none' ) {
		?>border: <?php echo esc_attr($css['border_width']) . 'px' ?> <?php echo esc_attr($css['border_type']) ?> <?php echo esc_attr($css['border_color']); echo !empty( $opts['optin'] ) ? ' !important':'';?>;
	<?php } ?>
	border-radius: <?php echo esc_attr($css['border_radius']) . 'px' ?>;
	-moz-border-radius: <?php echo esc_attr($css['border_radius']) . 'px' ?>;
	-webkit-border-radius: <?php echo esc_attr($css['border_radius']) . 'px' ?>;
	-moz-box-shadow: <?php echo $css['shadow_type'] == 'inset' ? 'inset' : ''?> <?php echo esc_attr($css['shadow_x_offset']) . 'px' ?> <?php echo esc_attr($css['shadow_y_offset']) . 'px' ?> <?php echo esc_attr($css['shadow_blur']) . 'px' ?> <?php echo esc_attr($css['shadow_spread']) . 'px' ?> <?php echo esc_attr($css['shadow_color'])?>;
	-webkit-box-shadow: <?php echo $css['shadow_type'] == 'inset' ? 'inset' : ''?> <?php echo esc_attr($css['shadow_x_offset']) . 'px' ?> <?php echo esc_attr($css['shadow_y_offset']) . 'px' ?> <?php echo esc_attr($css['shadow_blur']) . 'px' ?> <?php echo esc_attr($css['shadow_spread']) . 'px' ?> <?php echo esc_attr($css['shadow_color'])?>;
	box-shadow: <?php echo $css['shadow_type'] == 'inset' ? 'inset' : ''?> <?php echo esc_attr($css['shadow_x_offset']) . 'px' ?> <?php echo esc_attr($css['shadow_y_offset']) . 'px' ?> <?php echo esc_attr($css['shadow_blur']) . 'px' ?> <?php echo esc_attr($css['shadow_spread']) . 'px' ?> <?php echo esc_attr($css['shadow_color'])?>;
	<?php echo ( empty( $opts['optin'] ) || $opts['optin'] == 'custom' ) ? 'width: ' . esc_attr( $width ) : ''; ?>;

}
#spu-bg-<?php echo $box->ID; ?> {
	opacity: <?php echo ( !empty( $css['bgopacity'] ) ) ? esc_attr($css['bgopacity']) : 0; ?>;
	background-color: <?php echo  esc_attr($css['overlay_color'])?>;
}
<?php echo isset( $css['custom_css'] ) ? $css['custom_css'] : '';?>
<?php do_action( 'spu/popup/popup_style', $box, $opts, $css);?>
</style>
<div class="spu-bg" id="spu-bg-<?php echo $box->ID; ?>"></div>
<div class="spu-box <?php echo apply_filters( 'spu/popup/box_class', $box_class, $opts, $css, $box );?> spu-<?php echo esc_attr( $opts['css']['position'] ); ?> spu-total-<?php echo get_post_meta($box->ID, 'spu_social',true);?> <?php echo get_post_meta($box->ID, 'spu_google',true) ? 'spu-gogl' : '';?>" id="spu-<?php echo $box->ID; ?>"
 data-box-id="<?php echo $box->ID ; ?>" data-trigger="<?php echo esc_attr( $opts['trigger'] ); ?>"
 data-trigger-number="<?php echo esc_attr( absint( $opts['trigger_number'] ) ); ?>"
 data-spuanimation="<?php echo esc_attr($opts['animation']); ?>" data-tconvert-cookie="<?php echo esc_attr( $opts['type-convert-cookie'] ); ?>" data-tclose-cookie="<?php echo esc_attr( $opts['type-close-cookie'] ); ?>" data-dconvert-cookie="<?php echo esc_attr( absint ( $opts['duration-convert-cookie'] ) ); ?>" data-dclose-cookie="<?php echo esc_attr( absint ( $opts['duration-close-cookie'] ) ); ?>" data-nconvert-cookie="<?php echo esc_attr( $opts['name-convert-cookie'] ); ?>" data-nclose-cookie="<?php echo esc_attr( $opts['name-close-cookie'] ); ?>" data-test-mode="<?php echo esc_attr($opts['test_mode']); ?>"
 data-auto-hide="<?php echo esc_attr($opts['auto_hide']); ?>" data-close-on-conversion="<?php echo $opts['conversion_close'] == 1 ?'1':''; ?>" data-bgopa="<?php echo esc_attr($css['bgopacity']);?>" data-total="<?php echo get_post_meta($box->ID, 'spu_social',true);?>"
 style="left:-99999px !important;right:auto;" data-width="<?php echo esc_attr(str_replace('px', '', $width)); ?>" <?php echo apply_filters( 'spu/popup/data_attrs', $data_attrs, $opts, $box );?>>
	<div class="spu-content"><?php echo $content; ?></div>
	<span class="spu-close spu-close-popup <?php echo esc_attr($css['close_position']); ?>"><i class="spu-icon spu-icon-close"></i></span>
	<span class="spu-timer"></span>
	<?php if( $opts['powered_link'] == '1' ) {
		$aff_link = !empty($this->spu_settings['aff_link']) ? $this->spu_settings['aff_link'] : 'https://timersys.com/popups/';
		?>
		<p class="spu-powered">Powered by <a href="<?php echo $aff_link;?>" target="_blank">WordPress Popup</a></p>
	<?php } ?>
</div>
<!-- / Popups Box -->
<?php
do_action( 'spu/popup/after_popup', $box, $opts, $css);
