<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>

<p><?php _e( 'My name is', $this->plugin_slug );?> <a href="http://twitter.com/chifliiiii">Damian Logghe</a>. <?php _e( 'I develop WordPress plugins and themes.', $this->plugin_slug );?></p>
<p><?php printf(__( 'Take a look at my <a href="%s">site</a> to see my other plugins or hire me. Subscribe to get updates!', $this->plugin_slug ), 'http://wp.timersys.com/');?></p>
<h4><?php _e( 'Other plugins I built:', $this->plugin_slug );?></h4>
<ul>
	<li> <a href="http://wordpress.org/plugins/wpfavs/" target="_blank">Wp Favs</a> - <?php _e( 'Install multiple plugins and create collections', $this->plugin_slug );?></li>
	<li> <a href="http://wordpress.org/plugins/twitter-like-box-reloaded/" target="_blank">Twitter like Box</a> - <?php _e( 'Like Facebook like box but for Twitter', $this->plugin_slug );?></li>
	<li> <a href="http://wordpress.org/plugins/wp-social-invitations" target="_blank">Wordpress Social Invitations</a> - <?php _e( 'Invite your network friends and import contacts', $this->plugin_slug );?></li>
</ul>	
