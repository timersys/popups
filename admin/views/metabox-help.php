<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>

<p><?php _e( 'You have three social shortcodes to use that will print a Facebook like, a Google+ Follow and a Twitter follow. Check the available options and default values:', $this->plugin_slug );?></p>
<p><strong>Facebook:</strong></p>
<pre>
[spu-facebook href="" layout="" show_faces="" share="" action="" width=""]
</pre>
<a href="fb-opts" onclick="jQuery('#fb-opts').slideToggle();return false;"><?php _e( 'View Facebook Options', $this->plugin_slug );?></a>
<ul id="fb-opts" style="display:none;">
	<li><b>href:</b> <?php _e( 'Your facebook page url', $this->plugin_slug );?></li>
	<li><b>layout:</b> <?php _e( 'standard, box_count, button - Default: button_count', $this->plugin_slug );?></li>
	<li><b>show_faces:</b> <?php _e( 'true - Default: False', $this->plugin_slug );?></li>
	<li><b>share:</b> <?php _e( 'true - Default: False', $this->plugin_slug );?></li>
	<li><b>action:</b> <?php _e( 'recommend - Default: Like', $this->plugin_slug );?></li>
	<li><b>width:</b></li>
</ul>
<p><strong>Google+:</strong></p>
<pre>
[spu-google url="" size="" annotation=""]
</pre>
<a href="go-opts" onclick="jQuery('#go-opts').slideToggle();return false;"><?php _e( 'View Google+ Options', $this->plugin_slug );?></a>
<ul id="go-opts" style="display:none;">
	<li><b>url:</b> <?php _e( 'Your Google+ url', $this->plugin_slug );?></li>
	<li><b>size:</b> <?php _e( 'small, standard, tall Default: medium', $this->plugin_slug );?></li>
	<li><b>annotation:</b> <?php _e( 'inline, none - Default: bubble', $this->plugin_slug );?></li>
</ul>
<p><strong>Twitter:</strong></p>
<pre>
[spu-twitter user="" show_count="" size="" lang="" text=""]
</pre>
<a href="tw-opts" onclick="jQuery('#tw-opts').slideToggle();return false;"><?php _e( 'View Twitter Options', $this->plugin_slug );?></a>
<ul id="tw-opts" style="display:none;">
	<li><b>user:</b> <?php _e( 'Your Twitter user - Default chifliiiii', $this->plugin_slug );?></li>
	<li><b>show_count:</b> <?php _e( 'false Default: true', $this->plugin_slug );?></li>
	<li><b>size:</b> <?php _e( 'large - Default: ""', $this->plugin_slug );?></li>
	<li><b>lang:</b> </li>
	<li><b>text:</b> <?php _e( 'The button text - Default: Follow @chifliiiii', $this->plugin_slug );?></li>
</ul>
