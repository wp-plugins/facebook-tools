<?php

/*
 *	Last Modified:	2011-07-20
 *
 *
 *	----------------------------------
 *	CHANGELOG
 *	----------------------------------
 *	2011-07-20
 		- Updated fb_likebutton() and fb_sendbutton() to read from the current permalink if a post is present
 		- Added new function fb_loginbutton()
 *	2011-06-30
 		- Added a new parameter to fb_commentcount() called @return (default:false) which will return the count rather than echoing it out.
 *
 */

function fb_get_comments($xid=null,$migrated=null) {
	##	ATTRIBUTES
	##		@xid				The unique XID of the comment box
	##		@migrated			Use new or legacy comment box object
	##			@href			(alias of xid)
	global $post, $thePlugin;
	##	Get Arguments
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) { $params = array_merge($params,$args[0]); }
	else {
		$params['xid'] = $xid;
		$params['href'] = $xid; //alias
		$params['migrated'] = $migrated;
	}
	return $thePlugin->fb_get_comments($post,$params);
}

function fb_comments($xid=null,$width=null,$numposts=null,$migrated=null,$reverse=null,$css=null) {
	##	ATTRIBUTES
	##		@xid				The XID of the Page to fetch comment count from. (Default: current post page in the Loop)
	##			@href			(alias of xid)
	##		@width				Width in pixels
	##		@numposts			The number of comments to show
	##		@migrated			Use new or legacy comment box
	##		@colorscheme		(New) Specify 'dark' to use the new dark color scheme
	##		@reverse			(Legacy) reverse the comments/form order
	##		@css				(Legacy) custom css file location
	global $post, $thePlugin;
	##	Get Arguments
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) { $params = array_merge($params,$args[0]); }
	else {
		$params['xid'] = $xid;
		$params['href'] = $xid; //alias
		$params['width'] = $width;
		$params['numposts'] = $numposts;
		$params['migrated'] = $migrated;
		$params['colorscheme'] = $colorscheme;
		$params['reverse'] = $reverse;
		$params['css'] = $xss;
	}
	echo $thePlugin->fb_comments($post,$params);
}

function fb_commentcount($xid=null,$return=false) {
	##	ATTRIBUTES
	##		@xid		The XID of the Page to fetch comment count from. (Default: current post page in the Loop)
	global $post, $thePlugin;
	##	Get Arguments
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) { $params = array_merge($params,$args[0]); }
	else {
		$params['xid'] = $xid;
	}
	$count = $thePlugin->fb_commentcount($post,$params);
	if($params['return']) { return $count; }
	else { echo $count; }
}

function fb_likebutton($href=null,$layout=null,$width=null,$colorscheme=null,$action=null,$send=false) {
	##	http://developers.facebook.com/docs/reference/plugins/like/
	##
	##	ATTRIBUTES
	##		@href				The URL to like. (Default: current post page in the Loop)
	##		@layout				standard, button_count, box_count
	##		@width				Width in pixels
	##		@colorscheme		Options: 'light', 'dark'
	##		@action				like, recommend
	##		@send				Specify whether or not to include the Send button (1 or 0)
	global $post, $thePlugin;
	##	Get Arguments
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) { $params = array_merge($params,$args[0]); }
	else {
		$params['href'] = $href;
		$params['layout'] = $layout;
		$params['width'] = $width;
		$params['colorscheme'] = $colorscheme;
		$params['action'] = $action;
		$params['send'] = $send;
	}
	echo $thePlugin->fb_likebutton($post,$params);
}

function fb_sendbutton($href=null,$font=null,$colorscheme=null,$ref=null) {
	##	http://developers.facebook.com/docs/reference/plugins/send/
	##
	##	ATTRIBUTES
	##		@href				the URL to send. (Default: current post page in the Loop)
	##		@font				Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
	##		@colorscheme		Options: 'light', 'dark'
	##		@ref				a label for tracking referrals; must be less than 50 characters and can contain alphanumeric characters and some punctuation (currently +/=-.:_).=
	global $post, $thePlugin;
	##	Get Arguments
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) { $params = array_merge($params,$args[0]); }
	else {
		$params['href'] = $href;
		$params['font'] = $font;
		$params['colorscheme'] = $colorscheme;
		$params['ref'] = $ref;
	}
	echo $thePlugin->fb_sendbutton($post,$params);
}

function fb_loginbutton($showFaces=null,$width=null,$maxRows=null,$perms=null) {
	##	DEVELOPER NOTE: THIS FUNCTION IS NOT YET FULLY SUPPORTED (IN DEVELOPMENT)
	##
	##	http://developers.facebook.com/docs/reference/plugins/login/
	##
	##	ATTRIBUTES
	##		@showFaces
	##		@width
	##		@maxRows
	##		@perms
	global $thePlugin;
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) { $params = array_merge($params,$args[0]); }
	else {
		$params['show-faces'] = $showFaces;
		$params['width'] = $width;
		$params['max-rows'] = $maxRows;
		$params['perms'] = $perms;
	}
	echo $thePlugin->fb_loginbutton($params);
}

function fb_registerbutton() {
	
}

?>