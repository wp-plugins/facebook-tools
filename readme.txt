=== Plugin Name ===
Contributors: theuprising
Donate link: http://theuprisingcreative.com/
Tags: Facebook, connect, comments, fb, tools, social, network, media, like, api
Requires at least: 3.0.2
Tested up to: 3.2.1
Stable tag: 1.2.1

Easily integrate Facebook social plugins to your WordPress blog/site with simple template functions.

== Description ==

Easily integrate Facebook social plugins to your WordPress blog/site with simple template functions.
See below for full list of features, and how to use the plugin.

= Features =
* Auto Insertion of OpenGraph tags
* Like Button
* Send Button
* Comments Box
* Retrieve Facebook Comments

= More Information =

For more information, please read the Facebook documentations at http://developers.facebook.com/docs/plugins/

= Like Button =

Display the Facebook Like button on any page.

*Note: The Open Graph description tag will default to the site's Tagline if their is no excerpt.*

To use, add `<?php fb_likebutton(); ?>` within the Loop.

*Parameters*

* $href			(string)	Defaults to the current post/page's permalink if not set
* $layout		(string)	Choices: 'standard', 'button_count', 'box_count'
* $width		(integer)	Width of the like button (in pixels)
* $colorscheme	(string)	Choices: 'light', 'dark'
* $action		(string)	Choices: 'like', 'recommend'
* $send			(boolean)	Include the send button?

= Send Button =

Display the Facebook Send button on any page.

*Note: The Open Graph description tag will default to the site's Tagline if their is no excerpt.*

To use, add `<?php fb_sendbutton(); ?>` within the Loop.

*Parameters*

* $href			(string)	Defaults to the current post/page's permalink if not set
* $font			(string)	Choices: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana' 
* $colorscheme	(string)	Choices: 'light', 'dark'
* $ref			(string)	A label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_).

= Comments =

Display the Facebook comment box for the current page/post. To retrieve the comment count, please see Comment Count.

To use, add `<?php fb_comments(); ?>` within the Loop.

*Parameters*

* $xid			(string)	A unique identifier for the current object
* $width		(integer)	Width of the comment box (in pixels)
* $numposts		(integer)	Number of posts to display
* $migrated		(boolean)	True to display the new comment box, false to display the old comment box
* $reverse		(boolean)	Reverse the comments order (legacy only)
* $css			(string)	Location of the custom CSS for the comment box (legacy only)

= Comment Count =

Display the comment count for the current page/post.

To use, add `<?php fb_commentcount(); ?>` within the Loop.

*Parameters*

* $xid			(string)	A unique identifier for the current object
* $return		(boolean)	Return the raw count number (Default: false)

= Get Comments =

Retrieve all comments in a standard PHP object

To use, add `<?php fb_get_comments(); ?>` within the Loop.

*Parameters*

* $xid			(string)	A unique identifier for the current object
* $migrated		(boolean)	True to fetch results from the new comment box object, false to fetch from the legacy comment box

== Installation ==

This plugin requires a Facebook API key. You can get one here: http://developers.facebook.com/

1. Upload the plugin folder to the */wp-content/plugins/* directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Go to *Facebook Tools* menu and fill out your Facebook application information with obtained from Facebook.
1. Make sure your template is calling *wp_head()* and *wp_footer()* to allow loading of the Facebook API library.

== Changelog ==

= 1.2.1 =
* Fixed fb_commentcount() bug returning the incorrect href attribute
* Added a new parameter to fb_commentcount() to allow for returning the count instead of directly echoing it out.
* Fixed fb_likebutton() "send" bug
* Updated/fixed the fb_likebutton() and fb_sendbutton() to fall back on the current item in The Loop if no pass "href" attribute is passed in the parameters.
* Fixed the XML warning for fb_commentcount()

= 1.2.0 =
* Added the new Facebook Send button. (See instructions for usage example)
* Updated the Like button to include the new "send" parameter

= 1.1.1 =
* Added the ability to disable the automatic insertion of the Open Graph tags (in Facebook Tools > Facebook Tools panel).

= 1.1 =
* Organized plugin folder
* Fixed some PHP/WP error and warning messages
* Template functions now accept parameters to override the default settings
* New template function called fb_get_comments() which return an object containing all comments (used within the Loop)
* Added a new parameter/setting for the new dark color scheme in the new Comments box that was announced on April 13, 2011.

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