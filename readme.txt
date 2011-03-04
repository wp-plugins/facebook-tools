{\rtf1\ansi\ansicpg1252\cocoartf1038\cocoasubrtf350
{\fonttbl\f0\fmodern\fcharset0 Courier;\f1\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
\margl1440\margr1440\vieww20980\viewh11100\viewkind0
\deftab720
\pard\pardeftab720\ql\qnatural

\f0\fs24 \cf0 === Plugin Name ===\
Contributors: theuprising\
Donate link: http://theuprisingcreative.com/\
Tags: Facebook, connect, comments, fb, tools, social, network, media, like, api\
Requires at least: 3.0.2\
Tested up to: 3.02\
Stable tag: 1.0.1\
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardeftab720\ql\qnatural\pardirnatural

\f1 \cf0 \
Easily integrate Facebook Connect to your WordPress blog/site with simple template functions.\
\
\pard\pardeftab720\ql\qnatural

\f0 \cf0 == Description ==\
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardeftab720\ql\qnatural\pardirnatural

\f1 \cf0 \
Easily integrate Facebook Connect to your WordPress blog/site with simple template functions.\
See below for full list of features, and how to use the plugin.\
\
== Installation ==\
\
This plugin requires a Facebook API key. You can get one here: http://developers.facebook.com/\
\
\pard\pardeftab720\ql\qnatural

\f0 \cf0 1. Upload the plugin folder to the */wp-content/plugins/* directory\
1. Activate the plugin through the *Plugins* menu in WordPress\
1. Go to *Facebook Tools* menu and fill out your Facebook application information with obtained from Facebook.\
1. Make sure your template is calling *wp_head()* and *wp_footer()* to allow loading of the Facebook API library.\
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardeftab720\ql\qnatural\pardirnatural

\f1 \cf0 \
= Features =\
* Like Button\
* Comments\
\
= Like Button =\
\
Display the Facebook Like button on any page.\
\
*Note: The Open Graph description tag will default to the site's Tagline if their is no excerpt.*\
\
To use, add <?php fb_likebutton(); ?> within the Loop.\
\
= Comments =\
\
Display the Facebook comment box for the current page/post. To retrieve the comment count, please see Comment Count.\
\
To use, add <?php fb_comments(); ?> within the Loop.\
\
= Comment Count =\
\
Display the comment count for the current page/post.\
\
To use, add <?php fb_commentcount(); ?> within the Loop.\
\pard\pardeftab720\ql\qnatural
\cf0 \
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardeftab720\ql\qnatural\pardirnatural
\cf0 == Changelog ==\
\
= 1.0.1 =\
* Open Graph tags are now automatically added to the header.\
\
= 1.0 =\
* Plugin is now public!}