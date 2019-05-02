=== Popups - WordPress Popup ===
Contributors: timersys
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4T6L69EV9G2Q
Tags:  popup,twitter,google+,facebook,Popups,twitter follow,facebook like,mailchimp,Activecampaign,Mailpoet,Postmatic,Infusionsoft,mailerlite,constant contact,aweber,google plus,social boost,social splash,postmatic,mailpoet,facebook popup,scroll popups,popups,wordpress popup,wp popups,cf7,gf,gravity forms,contact form 7,ifs,infusion soft,subscribe,login popup,ajax login popups,popupmaker
Requires at least: 3.6
Tested up to: 5.1.1
Stable tag: 1.9.3.7
Requires PHP: 5.3
Text Domain: popups
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Popup plugin that works! Most complete free popup plugin with display filters, scroll triggered popups, compatible with social networks, Gravity Forms, Ninja Forms, Contact form 7, Mailpoet, Mailchimp for WP, Postmatic, etc

== Description ==

The new Popups plugin can display multiple popups. Is the perfect solution to show important messages such as EU Cookie notice, increase your social followers, add call to actions, increase your mailing lists by adding a form like mailchimp or to display any other important message in a simple popup.

https://www.youtube.com/watch?v=S_MfZne6X2I&t=3s

It's compatible with the major form plugins like (read FAQ):

* Gravity Forms
* Ninja Forms
* Contact form 7
* USP Forms
* Infusion Soft
* Jetpack
* Mailpoet
* Mailchimp for WP
* Postmatic
* Any generic form
* Facebook Login popups using the [Facebook login pro plugin](https://timersys.com/facebook-login/)

There are multiple display filters that can be combined:

* Show popup on specific pages, templates, posts, etc
* Filter user from search engines
* Filter users that never commented
* Filter users that arrived via another page on your site
* Filter users via roles
* Show popup depending on referrer
* Show popup to logged / non logged users
* Show or not to mobile, desktop and tablet users
* Show or not to bots / crawlers like Google
* Show or not depending on query strings EG: utm_source=email
* Show depending on post type, post template, post name, post format, post status and post taxonomy
* Show depending on page template, if page is parent, page name, page type
* Geotarget popups using the [Geotargeting plugin](https://timersys.com/geotargeting/)

 = Need it in another language? Help us [translate Popup Plugin](https://www.transifex.com/projects/p/popups/) =

= Available Settings =

* Choose from 5 different popup locations
* Trigger popup after X seconds , after scrolling % of page, after scrolling X pixels
* Auto hide the popup if the user scroll up
* Change font color, background, borders, etc
* You can also configure background opacity.
* Days until popup shows again
* Ajax mode to make popups cache compatible
* Shortcodes for social networks available

> <strong>Premium Version</strong><br>
>
> Check the **new premium version** available in ([https://timersys.com/popups/](https://timersys.com/popups/?utm_source=readme%20file&utm_medium=readme%20links&utm_campaign=Popups%20Premium))
>
> * Beautiful optin forms for popular mail providers
> * Currently supporting MailChimp, Aweber, Postmatic, Mailpoet, Constant Contact, Newsletter plugin, Activecampaign, InfusionSoft, etc
> * New popup positions: top/bottoms bars , fullscreen mode, after post content
> * A/B testing. Explore which popup perform better for you
> * More Display Rules: Show after N(numbers) of pages viewed
> * More Display Rules: Show popup at certain time / day or date
> * More Display Rules: Show/hide if another popup already converted
> * Track impressions and Conversions of social networks and forms like CF7 or Gravity forms
> * Track impressions and Conversions in Google Analytics ande define custom events
> * Data sampling for heavy traffic sites
> * Background images
> * 8 New animations effects
> * Exit Intent technology
> * More trigger methods
> * Timer for auto closing
> * Ability to disable close button
> * Ability to disable Advanced close methods like esc or clicking outside of the popup
> * Premium support
>

= Plugin's Official Site =

Popups ([https://timersys.com/free-plugins/social-popup/](https://timersys.com/free-plugins/popups/))

= Github =

Fork me in https://github.com/timersys/popups/

= Available Languages =

* French
* Russian
* Serbo-Croatian - Borisa - http://www.webhostinghub.com/
* Spanish - Andrew Kurtis - http://www.webhostinghub.com/
* German
* Slovak - J�n "Fajo" Fajc�k

= Beautiful WordPress Emails  =
Now you can send html email in WordPress with [https://wordpress.org/plugins/email-templates/](https://wordpress.org/plugins/email-templates/)

= Install Multiple plugins at once with WpFavs  =

Bulk plugin installation tool, import WP favorites and create your own lists ([http://wordpress.org/extend/plugins/wpfavs/](http://wordpress.org/extend/plugins/wpfavs/))

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

= How to open a popup by pressing a link or button ? =
Check the following gist (https://gist.github.com/timersys/d68690a85aed14a02318)

= How can I include a custom link inside of the popup ? =
By default any link you enter will be used as a conversion link. By that we mean that if the link is clicked the popup will be closed as the user already performed the desired action.
To avoid that you can add the class attribute .spu-not-close to the link

= Popups plugin is compatible with Gravity Forms ? =
Yes, you need to configure your form to use ajax when inserting it

= Popups plugin is compatible with Ninja Forms ? =
Yes, you need to configure your form to use ajax. Go to the setting of the created form and enable AJAX. Then you need to disable AJAX on popups settings page.

= Mailchimp4wp form it's compatible? =
Yes, you need to disable AJAX on popups settings page

= Jetpack form it's compatible? =
Yes, you need to disable AJAX on popups settings page

= Popups plugin is compatible with USP Forms ? =
Yes, you need to add to the usp form shortcode the class spu-disable-ajax like : [usp_form class="spu-disable-ajax"]

= How can I change other styles of the popup like padding, rounded corners, etc ? =
You can modify everything with css. If your popup id is 120 you can add some css like for example:
`#spu-120{ ---your css here--- }`

= Can I give other roles permissions to edit popups ? =
You need to add [this code](https://gist.github.com/timersys/03067ac7594fdce288ca) to your functions.php

= If I have multiple Gravity forms on my page, form is not working =
On certain occasions multiple GF instances can cause problems. There is a plugin that fixes that https://wordpress.org/plugins/gravity-forms-multiple-form-instances/

= How to make Popups plugin compatible with Maxbuttons Plugin (https://es.wordpress.org/plugins/maxbuttons/) =
 Check the following gists ( https://gist.github.com/timersys/e3648ba93955ddef4087 )

= Can I attach my custom js events to popups plugin? =
Yes you can attach to any of this events . id = Popup id
`jQuery(document).on('spu.box_close',function(e,id){ ... });
 jQuery(document).on('spu.box_open',function(e,id){ ... });
 jQuery(document).on('spu.form_submitted',function(e,id){ ... });`

= How to edit the content of my popup only on certain pages ? =
You can filter the content by using the [following function](https://gist.github.com/timersys/d3c34d736fd3188f1293)

= Can I remove js for Facebook, Twitter or Google if I already loaded mine? =
Yes you can remove them in the settings page of the plugin

= Popup is not showing, why ? =
Check your page source code. At the bottom of your page search for an html comment that looks something like :

`<!-- Popups v1.1 - http://wordpress.org/plugins/social-popup/-->`
If you see that comment, then the error is probably a javascript error. Check your browser console for problems.

If you are not seeing that code instead, the problem is that one of the display rules you configured is preventing it to show. Double check your display rules.

If you have cache be sure to enable AJAX mode in the plugin settings page

== Changelog ==

= 1.9.3.7 =
* Cookies in days/hours
* Fix popup showing in search results
* Fixed issue to make it compatible with WP3.6
* Fixed iframes to work not only with youtube/vimeo

= 1.9.3.6 =
* Disable Gutenberg entirely for popups premium full support
* Added slovak language

= 1.9.3.5 =
* Gutenberg support
* Minor bugfixes

= 1.9.3.4 =
* Update for new contact form 7

= 1.9.3.3 =
* Fixed page/post parent rule issue
* More forms compatibility

= 1.9.3.2 =
* Ninja forms fix
* Added new display rule "custom url"
* Added new display rule "keyword in url"
* Basic css removed to make it more compatible with themes

= 1.9.3.1 =
* Fixed security vulnerability. Thanks DefenseCode and their ThunderScan tool

= 1.9.3 =
* New Bottom and top bar positions
* New conversion and close button
* Improved posts display rules for sites with thousands of posts
* Javascript new resize method

= 1.9.2 =
* Added support for Visual Form Builder
* Added cookie name support, so users can reset cookies for popups
* Fix for woocommerce follow up emails
* Fix for popup showing for a milisecond on certain themes
* updated ID rule to accept multiple values
* Added vimeo, youtube auto play support
* Removed debug mode and safe mode, to make it less complicate

= 1.9.1.1 =
* Hotfix for draft popups showing
= 1.9.1 =
* Added ninja forms 3 compatibility (thanks https://github.com/cr0ybot)
* Fixed compatibility with latest WPML version
* Fixed preview mode when post is draft
* Fixed issue with gravity forms and language sites

= 1.9.0.1 =
* Fixed problem with popup being removed on close

= 1.9 =
* Added German language
* Fixed messages not showing for mailchinp for wordpress
* Fixed preview mode with ajax mode turned on
* Fixed browser rule
* Fixed taxonomies archives rule
* Improved performance with rules
* Youtube/vimeo videos are automatically removed when popup it's closed
* Updated CF7 events

= 1.8 =
* Redesigned popups admin pages
* Added lot of new appearance options
* New rule to match browsers
* Added popups preview
* Removed freemius

= 1.7.3 =
* Improved how post id is detected
* Rule match category also check on category pages now
* Updated freemius library
* Polylang plugin support
* Added special classes for not closig the popup when clicked
= 1.7.2 =
* Added french language
* Query string rule is wide match now
* New trigger method , X amount of pixels


= 1.7.1.1 =
* Added freemius insights
* Changed some assets

= 1.7.1 =
* Added new google+ version
* Added fractional time support for cookies
* Removed session start that was causing issues with varnish cache
* Fixed problem with shortcode popup
* Fixed takeover popup bug
* Fixed bug with referral not working fine on certian urls
* Fixed undefined errors php warnings
* Fixed incompatibility with underscores library


= 1.7.0.1 =
* Left some debug code on previous release that can cause issues

= 1.7 =
* Fixed referrer issue
* Added popup button to easily add popups on posts/pages

= 1.6.0.1 =
* Fixed bug with manual triggering popup making all page cursor pointer

= 1.6 =
* Fixed unistall routine that was not deleting data
* Update mobile detect class
* Added crawlers detect class
* Added crawlers/bot display rule
* Added query string display rule
* Added new cookie field to distinguish between conversion and impression
* Fixed jquery attached events not firing
* Improved queries

= 1.5.1 =
* Fixed grey screen of death that happened to some users. Sorry guys :(

= 1.5 =
* Added new rule to match Desktop devices
* Added custom CSS box for popups
* Added trigger class so popups can be triggered by applying that class to any element
* Changed styling on rules
* Fixed mc4wp ajax submission
* PHP Undefined notices fixes

= 1.4.6.1 =
* Fixed bug where manual trigger was not saving properly
* Fixed bug that was preventing social shortcodes to display properly

= 1.4.6 =
* Added manual trigger option on display options
* Fixed bug with session check
* Fixed bug with border when no color was choosen
* Now operators can be modified upon rules
* Changes for premium version

= 1.4.5.1 =
* Missing commit that only affect premium version

= 1.4.5 =
* Fixed undefined js error
* Fixed redeclared class error for Mobile Detect class
* Several css and text fixes. Pull request by lucpse
* Added switch ON/OFF button for popups
* Removed unnedded buttons / action from admin
* Custom status now show in display rules

= 1.4.4 =
* Added WpGlobus Support
* Added new rule for search pages
* Fixed db error with wpml plugin
* Added support for Newsletter plugin
* Rearranged appearence into a new box
* Ninja forms small fix
* Fixed support link in backend

= 1.4.3.1 =
* Removed "powered by" by default.

= 1.4.3 =

* Fixed bug with close on conversion and social networks
* Css Fixes

= 1.4.2 =

* Added Facebook Login plugin support
* Minor code edits for premium version
* Fixed bug with Mailchimp for Wordpress plugin [mc4wp_form]
* Popup fires later for better shortcodes support
* Updates in language packs
* Now users can have custom links inside of popup that does not count as conversion (read faq)

= 1.4.1 =

* Now you can delete all data on uninstall
* Now tags can be used as display rule ( In taxonomy)
* Any link inside popup is treated as custom conversion
* Added support for USP Forms
* Fixed bug when removing styles
* Fixed bug when settings were not being saved on certain occassions
* Fixed bug with manually triggered popups
* Lang files updates

= 1.3.4 =

* Added support for usp forms
* Added option to delete all data after uninstall
* Now you can target popups by posts tags using taxonomy rule
* Any link you place inside popup is treatead as conversion when clicked
* Update popups admin screen
* Fixed bug with ninja forms
* Fixed bug with manually triggered popups
* Fixed several other bugs ( js events, settings not saving, etc)
* Updated FAQ and readme

= 1.3.3 =

* Updated languages and added transifex
* Updated FAQ
* Fixed bug with facebook page
* Removed plugin version from facebook url to avoid some errors
* Fixed call popups with custom links
* Fixed bug when automatic shortcode style is disabled
* Improved code so other plugins can create custom rules fields


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
* Added geotargeting support in popups using [Geotargeting plugin](https://timersys.com/geotargeting/)
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

== Upgrade Notice ==

= 1.9.3.1 =
This version fixes a security related bug.  Upgrade immediately.