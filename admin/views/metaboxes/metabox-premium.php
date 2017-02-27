<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
?>
<?php

$today 		= strtotime(date("Y-m-d H:i:s"));
$blackbegin = strtotime("2014-11-28");
$blackend 	= strtotime("2014-12-02");
if($today > $blackbegin && $today < $blackend) : ?>
	<div class="alert-premium">
		<p><strong>Happy Black Friday!</strong> Get any Timersys Plugin with a 40% discount using the <code>BLACKFRIDAY</code> coupon code </p>
	</div>	
<?php endif;?>
	
<p><?php _e( 'Take the best WordPress Popups plugin to the next level with Popups Premium extension.', 'popups' );?></p>
<h2><?php _e( 'Popups Premium Features:', 'popups' );?></h2>
<ul>
	<li><?php _e( 'Beautiful optin forms for popular mail providers', 'popups' );?></li>
	<li><?php _e( 'Currently supporting MailChimp, Aweber, Postmatic, Mailpoet, Constant Contact, ActiveCampaign, Newsletter plugin', 'popups' );?></li>
	<li><?php _e( 'A/B testing. Explore which popup perform better for you.', 'popups' );?></li>
	<li><?php _e( 'Track impressions and Conversions of social likes and forms submissions like Contact Form 7, Gravity forms, etc', 'popups' );?></li>
	<li><?php _e( 'Track impressions and Conversions in Google Analytics ande define custom events', 'popups' );?></li>
	<li><?php _e( 'Exit Intent technology', 'popups' );?></li>
	<li><?php _e( 'New popup positions: top/bottoms bars , fullscreen mode, after post content', 'popups' );?></li>
	<li><?php _e( '8 New animations effects', 'popups' );?> - <a href="https://timersys.com/popups/?utm_source=Plugin&utm_medium=demo-button&utm_campaign=Popups%20Premium">Online demo</a></li>
	<li><?php _e( 'Exit Intent technology', 'popups' );?></li>
	<li><?php _e( 'New trigger methods', 'popups' );?></li>
	<li><?php _e( 'More Display Rules: Show after N(numbers) of pages viewed', 'popups' );?></li>
	<li><?php _e( 'More Display Rules: Show popup at certain time', 'popups' );?></li>
	<li><?php _e( 'More Display Rules: Show popup at certain day', 'popups' );?></li>
	<li><?php _e( 'More Display Rules: Show/hide if another popup already converted', 'popups' );?></li>
	<li><?php _e( 'Timer for auto closing', 'popups' );?></li>
	<li><?php _e( 'Ability to disable close button', 'popups' );?></li>
	<li><?php _e( 'Ability to disable Advanced close methods like esc or clicking outside of the popup', 'popups' );?></li>
	<li><?php _e( 'Premium support', 'popups' );?></li>
</ul>
<p><strong>Hurry up and get your copy!</strong> Take advantage of this <span style="color:red">launch offer</span> before the price goes up. We have a <strong>lot of new features</strong> to be added soon!</p>
<p style="text-align:center">
	<a class="button-primary" href="https://timersys.com/downloads/popups-premium/?utm_source=Plugin&utm_medium=buy-button&utm_campaign=Popups%20Premium"><?php _e( 'Buy Now!', 'popups' );?></a>
</p>