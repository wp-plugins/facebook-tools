=== Plugin Name ===
Contributors: theuprising
Donate link: http://theuprisingcreative.com/
Tags: Facebook, connect, comments, fb, tools, social, network, media, like, api
Requires at least: 3.0.2
Tested up to: 3.02
Stable tag: 1.0.5

Easily integrate Facebook Connect to your WordPress blog/site with simple template functions.

== Description ==

Easily integrate Facebook Connect to your WordPress blog/site with simple template functions.
See below for full list of features, and how to use the plugin.

= Features =
* Auto insertion of OpenGraph tags
* Like Button
* Comments Box

= Like Button =

Display the Facebook Like button on any page.

*Note: The Open Graph description tag will default to the site's Tagline if their is no excerpt.*

To use, add `<?php fb_likebutton(); ?>` within the Loop.

= Comments =

Display the Facebook comment box for the current page/post. To retrieve the comment count, please see Comment Count.

To use, add `<?php fb_comments(); ?>` within the Loop.

= Comment Count =

Display the comment count for the current page/post.

To use, add `<?php fb_commentcount(); ?>` within the Loop.

== Installation ==

This plugin requires a Facebook API key. You can get one here: http://developers.facebook.com/

1. Upload the plugin folder to the */wp-content/plugins/* directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Go to *Facebook Tools* menu and fill out your Facebook application information with obtained from Facebook.
1. Make sure your template is calling *wp_head()* and *wp_footer()* to allow loading of the Facebook API library.

== Changelog ==

= 1.0.5 =
* Fixed fb_commentcount() bug on category pages.

= 1.0.4 =
* Updated the *Facebook Tools* to allow switching between the legacy and new comment box. This update fixes the *fb_commentcount()* template function.
* Added the ability to load stylesheet for legacy comment box.

= 1.0.3 =
* Updated readme.txt (fixed PHP sample code)

= 1.0.2 =
* Fixed Plugin update and readme.txt file.

= 1.0.1 =
* Open Graph tags are now automatically added to the header.

= 1.0 =
* Plugin is now public!