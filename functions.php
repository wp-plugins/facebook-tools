<?php

function fb_get_comments($xid=null,$migrated=null) {
	##	ATTRIBUTES
	##		@xid				The unique XID of the comment box
	##		@migrated			Use new or legacy comment box object
	##			@href			(alias of xid)
	global $post, $thePlugin;
	##	Get Arguments
	$args = func_get_args();
	$params = array();
	if(is_array($args) && is_array($args[0])) {
		$params = array_merge($params,$args[0]);
	}
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
	if(is_array($args) && is_array($args[0])) {
		$params = array_merge($params,$args[0]);
	}
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

function fb_commentcount($xid=null) {
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
	echo $thePlugin->fb_commentcount($post,$params);
}

function fb_likebutton($href=null,$layout=null,$width=null,$colorscheme=null,$action=null) {
	##	http://developers.facebook.com/docs/reference/plugins/like/
	##
	##	ATTRIBUTES
	##		@href				The URL to like. (Default: current post page in the Loop)
	##		@layout				standard, button_count, box_count
	##		@width				Width in pixels
	##		@colorscheme		light, dark
	##		@action				like, recommend
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
	}
	echo $thePlugin->fb_likebutton($params);
}

?>