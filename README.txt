=== Popups - Wordpress Popups ===
Contributors: timersys
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4T6L69EV9G2Q
Tags:  twitter,google+, facebook,Popups, twitter follow, facebook like, google plus,social boost, social splash, popup, facebook popup, scroll popups, popups, wordpress popup, wp popups
Requires at least: 3.6
Tested up to: 4.0
Stable tag: 1.2
Text Domain: spucpt
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Increase your followers ratio 40% with the new Popups - Multiple popup options, scroll triggered popups with multiple options

== Description ==

The new Popups plugin can display multiple popups. Is the perfect solution to increase your social followers, your mailing lists by adding a form like mailchimp or to display any important message in a simple popup. 


There are multiple display filters that can be combined:

* Show popup on specific pages, templates, posts, etc
* Filter user from search engines
* Filter users that never commented
* Filter users that arrived via another page on your site
* Filter users via roles
* Show popup to logged / non logged users
* Show or not to mobile and tablet users
* Show depending on post type, post template, post name, post format, post status and post taxonomy
* Show depending on page template, if page is parent, page name, page type

= Available Settings =

* Choose from 5 different popup locations
* Trigger popup after X seconds or after scrolling % of page
* Auto hide the popup if the user scroll up
* Change font color, background, borders, etc
* You can also configure background opacity.
* Days until popup shows again

> <strong>Premium Version</strong><br>
> 
> Check the **new premium version** available in ([http://wp.timersys.com/popups/](http://wp.timersys.com/popups/))
>
> * 8 New animations effects
> * Exit Intent technology
> * New trigger methods
> * Timer for auto closing
> * Ability to disable close button
> * Ability to disable Advanced close methods like esc or clicking outside of the popup
> * Premium support
> 

= Plugin's Official Site =

Popups ([http://wp.timersys.com/free-plugins/social-popup/](http://wp.timersys.com/free-plugins/popups/))

= Github = 

Fork me in https://github.com/timersys/popups/

= Install Multiple plugins at once with WpFavs  =

Bulk plugin installation tool, import WP favorites and create your own lists ([http://wordpress.org/extend/plugins/wpfavs/](http://wordpress.org/extend/plugins/wpfavs/))

= Increase your twitter followers  =

Increase your Twitter followers with Twitter likebox Plugin ([http://wordpress.org/extend/plugins/twitter-like-box-reloaded/](http://wordpress.org/extend/plugins/twitter-like-box-reloaded/))

= Wordpress Social Invitations  =

Enhance your site by letting your users send Social Invitations ([http://wp.timersys.com/wordpress-social-invitations/](http://wp.timersys.com/wordpress-social-invitations/?utm_source=social-popup&utm_medium=readme))

== Installation ==

1. Unzip and Upload the directory 'social-popup' to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to Popups menu and add as many popups as needed

== Screenshots ==

1. Popups Front end with default settings
2. Popups Back end - visual editor
3. Popups Back end - display rules and options
4. Popups Back end - appearance

== Frequently Asked Questions ==

= Can I remove js for Facebook, Twitter or Google if I already loaded mine? =
Yes you can add the ([following codes](https://gist.github.com/timersys/8453614472d07122098b)) into your functions.php

= Can I use the uncommpresed popups JS in my site ? =
Yes if you need to debug you can use uncompressed javascript by addings ([this code](https://gist.github.com/timersys/60823b62cd1050dab032)) to your functions.php

== Changelog ==

= 1.2 =

* Fixed permissions to edit popups settings
* Update Mobile detect class
* Added safe mode
* Added js to fix facebook width bug "failed to resize in 45s"
* Added qTranslate support
* Fixed bug when disabling shortcodes js in settings page
* General js fixes

= 1.1.1 =

* Sorry!! fixed bug in settings page and js file

= 1.1 =

* Added settings page
* Added option to disable auto style of shortcodes
* Plugin compatible with Popups Premium 
* Minor bugfixes
* Js improvement


= 1.0.7 = 

* Fixed bug with alignment in mobile devices
* Fixed bug in new aligning method for shortcodes

= 1.0.6 = 

* Fixed locale problem with facebook js
* Fixed lang setting for Twitter Shortcode
* Removed text attribute of Twitter Shortcode because is not longer supported by Twitter
* Changed method for aligning shortcodes for better compatibility


= 1.0.5 = 

* Changed to only admins users can edit/create popups
* Fixed error that facebook layout were not working properly
* Added the ability to remove JS from facebook, twitter, and google by using variables

= 1.0.4 = 

* Fixed bug that cookies where not set when user closes the box by clicking outside or with ESC key

= 1.0.3 = 

* Fixed bug with popup on mobiles devices
* Css fixed for better alignment of social networks
* Added filters and actions for a future premium version of the plugin

= 1.0.2 = 

* Added checks for shortcode values to avoid problems
* Changed style of Popup shortcodes help box to avoid problems
* Now popups can be closed with esc and clicking outside of the boxes
* Fixed the delete rule button that was missing
* Fixed Javascript error when editing popups

= 1.0.1 = 

* Fixed mobile/tablets display rule and splitted in two new rules
* Changed cookie script to a small one
* Now public js is server minified
* Removed min-width from the popup

= 1.0.0 = 

* Recoded from scratch. This is a totally new plugin
* Multiple popups are available now handled with custom post types
