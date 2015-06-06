=== Popups - WordPress Popup ===
Contributors: timersys
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4T6L69EV9G2Q
Tags:  popup,twitter,google+, facebook,Popups, twitter follow, facebook like, google plus,social boost, social splash, postmatic, mailpoet, facebook popup, scroll popups, popups, wordpress popup, wp popups, cf7, gf, gravity forms, contact form 7, ifs, infusion soft, subscribe
Requires at least: 3.6
Tested up to: 4.2.2
Stable tag: 1.3.2.2
Text Domain: spu
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Most complete free Popups plugin, scroll triggered popups, compatible with social networks, Gravity Forms, Ninja Forms, Contact form 7, Mailpoet, Mailchimp for WP, Postmatic, etc

== Description ==


The new Popups plugin can display multiple popups. Is the perfect solution to increase your social followers, your mailing lists by adding a form like mailchimp or to display any important message in a simple popup. 

It's compatible with the major form plugins like : Gravity Forms, Ninja Forms, Contact form 7, Jetpack, Mailpoet, Mailchimp for WP, Postmatic, etc

There are multiple display filters that can be combined:

* Show popup on specific pages, templates, posts, etc
* Filter user from search engines
* Filter users that never commented
* Filter users that arrived via another page on your site
* Filter users via roles
* Show popup depending on referrer
* Show popup to logged / non logged users
* Show or not to mobile and tablet users
* Show depending on post type, post template, post name, post format, post status and post taxonomy
* Show depending on page template, if page is parent, page name, page type
* Geotarget popups using the [Geotargeting plugin](http://wp.timersys.com/geotargeting/)

= Available Settings =

* Choose from 5 different popup locations
* Trigger popup after X seconds or after scrolling % of page
* Auto hide the popup if the user scroll up
* Change font color, background, borders, etc
* You can also configure background opacity.
* Days until popup shows again
* Ajax mode to make popups cache compatible
* Shortcodes for social networks available
* Compatible with Gravity Forms, Infusion Soft, Contact form 7, Ninja forms jetpack forms and much more

> <strong>Premium Version</strong><br>
> 
> Check the **new premium version** available in ([https://wp.timersys.com/popups/](http://wp.timersys.com/popups/?utm_source=readme%20file&utm_medium=readme%20links&utm_campaign=Popups%20Premium))
>
> * Beautiful optin forms for popular mail providers like
> * Currently supporting MailChimp, Aweber, Postmatic, Mailpoet
> * Track impressions and Conversions of social networks and forms like CF7 or Gravity forms
> * Track impressions and Conversions in Google Analytics
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

= Available Languages = 

* Serbo-Croatian - Borisa - http://www.webhostinghub.com/
* Spanish - Andrew Kurtis - http://www.webhostinghub.com/

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

= 1.3.2.2 =
* new Facebook page js was not being loaded if you didn't have another popup with fb shortcode

= 1.3.2.1 =
* Comit failed and minified file wasn't uploaded

= 1.3.2 =
* Added support for postmatic forms
* Fixed Centering of shortcodes
* Added new facebook page shortcode

= 1.3.1.2 =
* Hotfix with problems in ajax mode. Sorry :)
* Added Imagesloaded library

= 1.3.1.1 =
* Plugin now disabled ajax on forms that are not compatible with it
* Added some visuals on backend
* Code changes for premium version
* Fixed bug when multiple images are use in a post

= 1.3.1 =
* Fixed bug popup not closing when using conversion close option
* Changed ajax mode to be on by default

= 1.3.0.3 =
* Social providers not loading on https sites
* Fixed bug preventing popups to show on non ajax mode

= 1.3.0.2 =
* Fixed bug preventing to save settings
* Fixed bug with popups not closing

= 1.3.0.1 =

* New editor style only show on popups now
* Fixed bug with optin in premium version

= 1.3 =

* Added new option to keep popup open on conversion
* Added spanish language
* Added "powered by" link with affiliate support
* Improved popups style in admin area
* User can now remove ajax from generic form by added .spu-disable-ajax class
* Fixed bug when not using social shortcodes
* Updated core to work with latest premium version

= 1.2.3.5 =

* Added IFS (infusion soft) support
* Added display rule - Post ID
* Added display rule - Categories / Archives
* Now both version are shown if you use premium

= 1.2.3.4 =

* Added referrer display rule
* Fixed spuvar_social undefined when not using wordpress jquery
* Fixed wpml support in ajax mode
* Added trigger events in javascript so devs can hook in
* Added geotargeting support in popups using [Geotargeting plugin](http://wp.timersys.com/geotargeting/)
* Fixed undefined variable in admin

= 1.2.3.3 =

* Added Serbo-Croatian language
* Removed track function from premium plugin that was causing error on form submission
* Fixed error that was preventing form submission in ajax mode

= 1.2.3.2 =

* Improved popup center
* Improved popup in mobile for different effects / positions / popup sizes
* WPML compatibility ( Sitepress Multilanguage )
* Fixed javascript error preventing some basics functions as closing popup on fb like


= 1.2.3.1 =

* Hotfix- Bug with ajax mode & testmode preventing plugin to work. Please update

= 1.2.3 =

* Added Ajax mode in settings page to make popups compatible with cache plugins
* Added a close button shortcode
* Fixed bug with settings page
* Fixed bug detecting triggered clicks on iphone 6
* Some other minor bugfixes

= 1.2.2.2 =

* Improved and fixed generic form compatiblity and m4wp

= 1.2.2.1 =

* Fixed bug when images where used on popup
* Fixed bug with size of popup not working fine

= 1.2.2 =

* Fixed compability with events calendar
* Fixed compability with [mc4wp] (Mail chimp for WordPress)
* Fixed bug with popup auto dissapearing by programatically clicks of themes/plugins
* Fixed popup in mobile to let users scroll it
* Fixed bug with contact form 7 plugin support
* Small bugfixes

= 1.2.1 =

* Added support for Contact Form 7, Gravity Forms and most of other generic forms
* Added function to close popup when user actually follow/like
* Fixed undefined notices



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
