<?php

/*
 *	Last Modified:	2011-07-20
 *
 *
 *	----------------------------------
 *	CHANGELOG
 *	----------------------------------
 *	2011-07-20
 		- Updated fb_likebutton() and fb_sendbutton() to accept $post as the first parameter
 		- Fixed fb_likebutton() bug where send was not properly showing up when using "1" instead of a a true boolean
 		- Added new method fb_loginbutton()
 *	2011-07-18
 		- Fixed fb_commentcount() returne XML warning check
 *	2011-06-01
 		- Fixed fb_commentcount() bug returning incorrect href attribute
 *	2011-04-29
 		- New method fb_sendbutton()
 		- Updated fb_likebutton()
 			- Added new parameter 'send'
 *	2011-04-14
 		- Fixed currentURI property
 		- Fixed fb_comments() bug where the href/xid is not parsing correctly
 		- Fixed 'numposts' and 'num_posts' difference between the Legacy and New comment box
 *
 */

class UprisingCreative_FacebookTools {

	private $ns = 'uprisingcreative_';
	private $token = '';
	
	private $pluginFile;
	private $pluginPath;
	
	private $currentURI = '';
	
	public function UprisingCreative_FacebookTools($pluginFile) {
		$this->pluginFile = $pluginFile;
		$this->pluginPath = dirname($pluginFile);
		add_action('wp_footer',array(&$this,'load_sdk'));
		add_action('wp_head',array(&$this,'add_opengraphmeta'));
		//Set Token
		$this->token = $this->setToken();
		$this->currentURI = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}

	public function add_opengraphmeta() {
		global $post;
		if(!get_option($this->ns.'fbtools_disable_opengraph')) {
			$app_id = get_option($this->ns.'fbtools_app_id');
			$title = wp_title(null,0);
			$desc = (isset($post->post_excerpt) && strlen($post->post_excerpt)) ? $post->post_excerpt : get_bloginfo('description');
			$sitename = get_bloginfo('name');
			$site = get_bloginfo('home');
			$image = $this->get_thumbnail_src($post->ID,'full');
			$html = <<<EOD
		<meta property="og:title" content="{$post->post_title}" />
	    <meta property="og:type" content="website" />
	    <meta property="og:url" content="{$this->currentURI}" />
	    <meta property="og:site_name" content="{$sitename}" />
		<meta property="og:image" content="{$image}" />
	    <meta property="og:description" content="{$desc}" />
		<meta property="fb:app_id" content="{$app_id}" />
EOD;
			echo $html;
		}
	}

	public function get_thumbnail_src($post_id,$size) {
		$thumb_id = get_post_meta($post_id,'_thumbnail_id',false);
		if($thumb_id && is_array($thumb_id) && count($thumb_id)) {
			$thumb = wp_get_attachment_image_src($thumb_id[0],$size);
		}
		return (isset($thumb[0])) ? $thumb[0] : '';
	}

	private function setToken() {
		$url = 'https://graph.facebook.com/oauth/access_token?client_id='.get_option($this->ns.'fbtools_app_id').'&client_secret='.get_option($this->ns.'fbtools_api_secret').'&grant_type=client_credentials';
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		return substr($res,13);
	}

	public function load_sdk() {
		$app_id = get_option($this->ns.'fbtools_app_id'); ?>
<div id="fb-root"></div>
<script type="text/javascript" language="javascript">
  window.fbAsyncInit = function() {
    FB.init({
		appId: '<?=$app_id;?>',
		status: true,
		cookie: true,
		xfbml: true
	});
  };
  
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js#appId=<?=$app_id;?>&xfbml=1';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>


<?php
	}

	public function fb_comments($post,$params=array()) {
		##	Set Defaults
		$width = (strlen($params['width'])) ? $params['width'] : get_option($this->ns.'fbtools_comments_width');
		$numposts = (strlen($params['numposts'])) ? $params['numposts'] : get_option($this->ns.'fbtools_comments_numposts');
		$migrated = (strlen($params['migrated'])) ? $params['migrated'] : get_option($this->ns.'fbtools_comments_migrated');
		$colorscheme = (strlen($params['colorscheme'])) ? $params['colorscheme'] : get_option($this->ns.'fbtools_comments_colorscheme');

		$paramstr = '';
		if($width) { $paramstr .= ' width="'.$width.'"'; }
		if($migrated) {
			$href = (!empty($params['href'])) ? $params['href'] : $this->currentURI;
			if(strlen($numposts)) { $paramstr .= ' num_posts="'.$numposts.'"'; }
			##	Get New Comment Box Settings
			$paramstr .= ' href="'.urlencode($href).'"';
			$paramstr .= ' colorscheme="'.$colorscheme.'"';
		}
		else {
			$href = (!empty($params['xid'])) ? $params['xid'] : (($post->ID) ? get_permalink($post->ID) : $this->currentURI);
			if(strlen($numposts)) { $paramstr .= ' numposts="'.$numposts.'"'; }
			##	Get Legacy Comment Box Settings
			$reverse = (!empty($params['reverse'])) ? (($params['reverse']=="on" || $params['reverse']===1) ? 1 : 0) : get_option($this->ns.'fbtools_comments_reverse');
			$css =(!empty($css)) ? $css : get_option($this->ns.'fbtools_comments_css');
			if($reverse) { $paramstr .= ' reverse="'.$reverse.'"'; }
			if($css) { $paramstr .= ' css="'.get_bloginfo('template_directory').'/'.$css.'?'.time().'"'; }
		}
		$paramstr .= ' xid="'.urlencode($link).'"';
		return '<fb:comments '.$paramstr.'></fb:comments>';
	}
	
	public function fb_query($fql) {
		##	Process an FQL Query
		$url = 'https://api.facebook.com/method/fql.query?access_token='.$this->token.'&query='.urlencode($fql);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}
	
	public function fb_graph($method,$format='array') {
		##	Process an FQL Query
		$url = 'https://graph.facebook.com/'.$method;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		switch($format) {
			case "json":
				return $res;
				break;
			case "object":
				return json_decode($res);
				break;
			default:
				return (array) json_decode($res);
				break;
		}
	}

	public function fb_commentcount($post,$params) {
		##	Set Defaults
		$link = (!empty($params['xid'])) ? $params['xid'] : (($post->ID) ? get_permalink($post->ID) : $this->currentURI);
		$migrated = (!empty($params['migrated'])) ? $params['migrated'] : get_option($this->ns.'fbtools_comments_migrated');
		##	FQL Query
		$fql = 'SELECT count FROM comments_info WHERE app_id = \''.get_option($this->ns.'fbtools_app_id').'\' AND xid = \''.urlencode($link).'\'';
		if($migrated) {
			##	Get New Comment Box Settings
			$href = (!empty($params['href'])) ? $params['href'] : (($post->ID) ? get_permalink($post->ID) : $this->currentURI);
			$fql = 'SELECT commentsbox_count FROM link_stat WHERE url = \''.urlencode($href).'\'';
		}
		$res = $this->fb_query($fql);
		if($res) {
			$xml = new SimpleXMLElement($res);
			$count = 0;
			if($migrated) { $count = (isset($xml->link_stat->commentsbox_count)) ? (string) $xml->link_stat->commentsbox_count : 0; }
			else { $count = (isset($xml->comments_info)) ? (string) $xml->comments_info->count : 0; }
			return $count;
		}
		else { return 0; }
	}

	public function fb_likebutton($post,$params=array()) {
		## Set Defaults
		$href = (!empty($params['href'])) ? $params['href'] : (($post->ID) ? get_permalink($post->ID) : $this->currentURI);
		$layout = (!empty($params['layout'])) ? $params['layout'] : get_option($this->ns.'fbtools_likebutton_layout');
		$width = (!empty($params['width'])) ? $params['width'] : get_option($this->ns.'fbtools_likebutton_width');
		$colorscheme = (!empty($params['colorscheme'])) ? $params['colorscheme'] : get_option($this->ns.'fbtools_likebutton_colorscheme');
		$action = (!empty($params['action'])) ? $params['action'] : get_option($this->ns.'fbtools_likebutton_action');
		$send = (!empty($params['send'])) ? $params['send'] : get_option($this->ns.'fbtools_likebutton_send');
			//Change integer flag to a boolean string
			$send = ($send) ? 'true' : 'false';

		$paramstr = '';
		if($href) { $paramstr .= ' href="'.$href.'"'; }
		if($layout) { $paramstr .= ' layout="'.$layout.'"'; }
		if($width) { $paramstr .= ' width="'.$width.'"'; }
		if($colorscheme) { $paramstr .= ' colorscheme="'.$colorscheme.'"'; }
		if($action) { $paramstr .= ' action="'.$action.'"'; }
		if($send) { $paramstr .= ' send="'.$send.'"'; }
		return '<fb:like '.$paramstr.'></fb:like>';
	}

	public function fb_sendbutton($post,$params=array()) {
		## Set Defaults
		$href = (!empty($params['href'])) ? $params['href'] : (($post->ID) ? get_permalink($post->ID) : $this->currentURI);
		$font = (!empty($params['font'])) ? $params['font'] : get_option($this->ns.'fbtools_sendbutton_font');
		$colorscheme = (!empty($params['colorscheme'])) ? $params['colorscheme'] : get_option($this->ns.'fbtools_sendbutton_colorscheme');
		$ref = (!empty($params['ref'])) ? $params['ref'] : get_option($this->ns.'fbtools_sendbutton_ref');
		$paramstr = '';
		if($href) { $paramstr .= ' href="'.$href.'"'; }
		if($font) { $paramstr .= ' font="'.$font.'"'; }
		if($colorscheme) { $paramstr .= ' colorscheme="'.$colorscheme.'"'; }
		if($ref) { $paramstr .= ' ref="'.$ref.'"'; }
		return '<fb:send '.$paramstr.'></fb:send>';
	}
	
	public function fb_get_comments($post,$params=array()) {
		##		http://developers.facebook.com/docs/reference/fql/comment/
		##		http://developers.facebook.com/docs/reference/fql/link_stat/
		$link = (!empty($params['xid'])) ? $params['xid'] : (($post->ID) ? get_permalink($post->ID) : $this->currentURI);
		$migrated = (!empty($params['migrated'])) ? $params['migrated'] : get_option($this->ns.'fbtools_comments_migrated');
		##	FQL Query
		$fql = 'SELECT fromid, text, time, username, id FROM comment WHERE xid = \''.urlencode($link).'\'';
		if($migrated) {
			$href = (!empty($params['href'])) ? $params['href'] : $this->currentURI;
			$fql = 'SELECT fromid, text, time, username, id FROM comment WHERE object_id IN (SELECT comments_fbid FROM link_stat WHERE url = \''.urlencode($href).'\')';
		}
		$res = $this->fb_query($fql);
		$xml = new SimpleXMLElement($res);
		## 	Put Comments into Array
		$comments = array();
		if(isset($xml->comment)) {
			foreach($xml->comment as $comment) {
				$item = array(
					'text' => (string) $comment->text,
					'time' => (int) $comment->time,
					'commenter' => $this->fb_graph((int) $comment->fromid),
					'commenter_photo' => (string) 'https://graph.facebook.com/'.(int) $comment->fromid.'/picture'
				);
				array_push($comments,$item);
			}
		}
		return $comments;
	}
	
	public function fb_loginbutton($post,$params=array()) {
		## Set Defaults
		$showFaces = (!empty($params['show-faces'])) ? $params['show-faces'] : 'false';
		$width = (!empty($params['width'])) ? $params['width'] : 200;
		$maxRows = (!empty($params['max-rows'])) ? $params['max-rows'] : 1;
		$perms = (!empty($params['perms'])) ? $params['perms'] : '';

		$paramstr = '';
		if($showFaces) { $paramstr .= ' show-faces="'.$showFaces.'"'; }
		if($width) { $paramstr .= ' width="'.$width.'"'; }
		if($maxRows) { $paramstr .= ' max-rows="'.$maxRows.'"'; }
		if($perms) { $paramstr .= ' ref="'.$perms.'"'; }
		return '<fb:login-button '.$paramstr.'></fb:login-button>';
	}

}

?>