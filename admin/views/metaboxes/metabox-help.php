<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>

<p><?php _e( 'You have three social shortcodes to use that will print a Facebook like, a Google+ Follow and a Twitter follow. Check the available options and <strong>configure them with your social accounts</strong>:', $this->plugin_slug );?></p>

<p><strong>New Facebook page:</strong></p>
<p>
[spu-facebook-page href="" name="" show_faces="" hide_cover="" width=""]
</p>
<a href="fb-opts" onclick="jQuery('#fbpage-opts').slideToggle();return false;"><?php _e( 'View Facebook Page Options', $this->plugin_slug );?></a>
<ul id="fbpage-opts" style="display:none;">
	<li><b>href:</b> <?php _e( 'Your facebook page url', $this->plugin_slug );?></li>
	<li><b>name:</b> <?php _e( 'Your page name', $this->plugin_slug );?></li>
	<li><b>show_faces:</b> <?php _e( 'true|false <b>Default value:</b> true', $this->plugin_slug );?></li>
	<li><b>hide_cover:</b> <?php _e( 'true|false <b>Default value:</b> false', $this->plugin_slug );?></li>
	<li><b>width:</b></li>
</ul>

<p><strong>Facebook:</strong></p>
<p>
[spu-facebook href="" layout="" show_faces="" share="" action="" width=""]
</p>
<a href="fb-opts" onclick="jQuery('#fb-opts').slideToggle();return false;"><?php _e( 'View Facebook Options', $this->plugin_slug );?></a>
<ul id="fb-opts" style="display:none;">
	<li><b>href:</b> <?php _e( 'Your facebook page url', $this->plugin_slug );?></li>
	<li><b>layout:</b> <?php _e( 'standard, box_count, button <b>Default value:</b> button_count', $this->plugin_slug );?></li>
	<li><b>show_faces:</b> <?php _e( 'true <b>Default value:</b> false', $this->plugin_slug );?></li>
	<li><b>share:</b> <?php _e( 'true <b>Default value:</b> false', $this->plugin_slug );?></li>
	<li><b>action:</b> <?php _e( 'recommend <b>Default value:</b> like', $this->plugin_slug );?></li>
	<li><b>width:</b></li>
</ul>
<p><strong>Google+:</strong></p>
<p>
[spu-google url="" size="" annotation=""]
</p>
<a href="go-opts" onclick="jQuery('#go-opts').slideToggle();return false;"><?php _e( 'View Google+ Options', $this->plugin_slug );?></a>
<ul id="go-opts" style="display:none;">
	<li><b>url:</b> <?php _e( 'Your Google+ url', $this->plugin_slug );?></li>
	<li><b>size:</b> <?php _e( 'small, standard, tall <b>Default value:</b> medium', $this->plugin_slug );?></li>
	<li><b>annotation:</b> <?php _e( 'inline, none <b>Default value:</b> bubble', $this->plugin_slug );?></li>
</ul>
<p><strong>Twitter:</strong></p>
<p>
[spu-twitter user="" show_count="" size="" lang=""]
</p>
<a href="tw-opts" onclick="jQuery('#tw-opts').slideToggle();return false;"><?php _e( 'View Twitter Options', $this->plugin_slug );?></a>
<ul id="tw-opts" style="display:none;">
	<li><b>user:</b> <?php _e( 'Your Twitter user <b>Default chifli</b>iiii', $this->plugin_slug );?></li>
	<li><b>show_count:</b> <?php _e( 'false <b>Default value:</b> true', $this->plugin_slug );?></li>
	<li><b>size:</b> <?php _e( 'large <b>Default value:</b> ""', $this->plugin_slug );?></li>
	<li><b>lang:</b> </li>
</ul>
<h3 style="padding-left:0;margin: 20px 0;"><strong><?php _e('Other available Shortcodes:', $this->plugin_slug );?><strong></h3>
<p><strong>Close Button:</strong></p>
<p>
[spu-close class="" text="" align=""]
</p>
<a href="close-opts" onclick="jQuery('#close-opts').slideToggle();return false;"><?php _e( 'View Close shortcode Options', $this->plugin_slug );?></a>
<ul id="close-opts" style="display:none;">
	<li><b>class:</b> <?php _e( 'Pass a custom class to style your button', $this->plugin_slug );?></li>
	<li><b>text:</b> <?php _e( 'Button label - <b>Default value:</b> Close', $this->plugin_slug );?></li>
	<li><b>align:</b> <?php _e( 'left, right, center, none - <b>Default value:</b> center', $this->plugin_slug );?></li>
</ul>