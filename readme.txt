=== Plugin Name ===
Contributors: antonparamonov
Donate link: http://blog.paramonovav.com/en/plugins/plugins-for-wordpress/
Author: Anton Paramonov
Author URI: http://paramonovav.com/
Tags: xmlrpc, emoji, generator, feeds, global, security, wlwmanifest, pingback, rsd, shortlink
Requires at least: 3.5
Tested up to: 4.2
Stable tag: 1.6.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows administrators to globally disable XML-RPC, new emoji functionality in WordPress 4.2, wp generator, wlwmanifest, RSD EditURI and rss/feeds on their site.

== Description ==

Pretty simple plugin for disable:

*	the XML-RPC on a WordPress site running 3.5 or above
*	new emoji functionality in WordPress 4.2
*	Posts and Comments general feeds

And remove:

*	Wordpress genarator meta tag from HTML source page
*	link to wlwmanifest file from HTML source page (Windows Live Writer)
*	link to RSD EditURI from HTML source page
*	X-Pingback from HTTP headers and pingback_url in HTML source page
*	shortlink from HTTP headers and HTML source page

Translated on English, Russian and Ukraine languages.

== Installation ==

1. Upload the disable-xml-rpc directory to the `/wp-content/plugins/` directory in your WordPress installation
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin settings can be accessed via the 'Settings' menu in the administration area (either your site administration for single-site installs, or your network administration for network installs).

== Frequently Asked Questions ==

= How do I know if the plugin is working? =

There are two easy methods for checking if XML-RPC is off. First, try using an XML-RPC client, like the official WordPress mobile apps. Or you can try the XML-RPC Validator, written by Danilo Ercoli of the Automattic Mobile Team - the tool is available at [http://xmlrpc.eritreo.it/](http://xmlrpc.eritreo.it/) with a blog post about it at [http://daniloercoli.com/2012/05/15/wordpress-xml-rpc-endpoint-validator/](http://daniloercoli.com/2012/05/15/wordpress-xml-rpc-endpoint-validator/).

== Screenshots ==

1. YaBlog Plugin Settings

== Changelog ==

= 1.6.5 =
* Compatible with php 5.x

= 1.6.4 =
* new translation on Russian and Ukraine languages
* more settings

= 1.5.0 =
* Initial release

== Upgrade Notice ==

= 1.6.4 =
new translation on Russian and Ukraine languages and more options and settings

= 1.5.0 =
Initial release