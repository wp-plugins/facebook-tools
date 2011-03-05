<?php
/*
Plugin Name: Facebook Tools
Plugin URI: http://www.theuprisingcreative.com/
Description: Add Facebook support to your WordPress blog.
Version: 1.0.4
Author: The Uprising Creative
Author URI: http://www.theuprisingcreative.com/
License: GPL2

Copyright (C) 2011 The Uprising Creative

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

class UprisingCreative_FacebookTools {

	private $ns = 'uprisingcreative_';
	private $token = '';
	
	private $currentURI = '';
	
	public function UprisingCreative_FacebookTools() {
		add_action('wp_footer',array(&$this,'load_sdk'));
		add_action('wp_head',array(&$this,'add_opengraphmeta'));
		//Set Token
		$this->token = $this->setToken();
		$this->currentURI = get_bloginfo('home').$_SERVER['REQUEST_URI'];
	}

	public function add_opengraphmeta() {
		global $post;
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

	public function get_thumbnail_src($post_id,$size) {
		$thumb_id = get_post_meta($post_id,'_thumbnail_id',false);
		$thumb = wp_get_attachment_image_src($thumb_id[0],$size);
		return (isset($thumb[0])) ? $thumb[0] : '';
	}

	public function add_menus() {		
		add_menu_page('Facebook Tools','Facebook Tools','administrator',__FILE__,array(&$this,'settings_default'),plugins_url('/images/icon.png', __FILE__));
		add_submenu_page(__FILE__,'Facebook Tools - Comments','Comments','administrator',dirname(__FILE__).'/fbtools-comments.php',array(&$this,'settings_comments'));
		add_submenu_page(__FILE__,'Facebook Tools - Like Button','Like Button','administrator',dirname(__FILE__).'/fbtools-likebutton.php',array(&$this,'settings_likebutton'));
		add_action('admin_init',array(&$this,'register_settings'));
	}
	
	public function register_settings() {
		//General
		register_setting($this->ns.'fbtools_settings',$this->ns.'fbtools_app_id');
		register_setting($this->ns.'fbtools_settings',$this->ns.'fbtools_api_key');
		register_setting($this->ns.'fbtools_settings',$this->ns.'fbtools_api_secret');
		register_setting($this->ns.'fbtools_settings',$this->ns.'fbtools_facebook_url');
		//Comments
		register_setting($this->ns.'fbtools_comments_settings',$this->ns.'fbtools_comments_numposts');
		register_setting($this->ns.'fbtools_comments_settings',$this->ns.'fbtools_comments_reverse');
		register_setting($this->ns.'fbtools_comments_settings',$this->ns.'fbtools_comments_migrated');
		register_setting($this->ns.'fbtools_comments_settings',$this->ns.'fbtools_comments_width');
		register_setting($this->ns.'fbtools_comments_settings',$this->ns.'fbtools_comments_css');
		//Like
		register_setting($this->ns.'fbtools_likebutton_settings',$this->ns.'fbtools_likebutton_href');
		register_setting($this->ns.'fbtools_likebutton_settings',$this->ns.'fbtools_likebutton_layout');
		register_setting($this->ns.'fbtools_likebutton_settings',$this->ns.'fbtools_likebutton_width');
		register_setting($this->ns.'fbtools_likebutton_settings',$this->ns.'fbtools_likebutton_colorscheme');
		register_setting($this->ns.'fbtools_likebutton_settings',$this->ns.'fbtools_likebutton_action');
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
	
	public function settings_default() { ?>
		<div class="wrap">
			<h2>Facebook Tools - General Settings</h2>
			<form method="post" action="options.php">
			<?php settings_fields($this->ns.'fbtools_settings'); ?>
			<?php do_settings_fields($this->ns.'fbtools_settings'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">App ID</th>
					<td><input type="text" name="<?php echo $this->ns; ?>fbtools_app_id" value="<?php echo get_option($this->ns.'fbtools_app_id'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">API Key</th>
					<td><input type="text" name="<?php echo $this->ns; ?>fbtools_api_key" value="<?php echo get_option($this->ns.'fbtools_api_key'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">API Secret</th>
					<td><input type="text" name="<?php echo $this->ns; ?>fbtools_api_secret" value="<?php echo get_option($this->ns.'fbtools_api_secret'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Facebook URL</th>
					<td><input type="text" name="<?php echo $this->ns; ?>fbtools_facebook_url" value="<?php echo get_option($this->ns.'fbtools_facebook_url'); ?>" /></td>
				</tr>
			</table>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
			</form>
		</div>
	<?php
	}
	
	public function settings_comments() { ?>
		<div class="wrap">
			<h2>Facebook Tools - Comments</h2>
			<form method="post" action="options.php" name="form">
			<?php settings_fields($this->ns.'fbtools_comments_settings'); ?>
			<?php do_settings_fields($this->ns.'fbtools_comments_settings'); ?>
            <h3>Global Settings</h3>
            <table class="form-table">
				<tr valign="top">
					<th scope="row">Use New Comment Box</th>
					<td>
                    	<input type="checkbox" name="<?php echo $this->ns; ?>fbtools_comments_migrated" <?php echo (get_option($this->ns.'fbtools_comments_migrated')) ? "checked=\"checked\"" : ""; ?> />
                        Check this box to use the new and improved comment box. <a href="http://developers.facebook.com/blog/post/472" target="_blank">Read more</a>
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Number of Comments</th>
					<td>
                    	<input type="text" name="<?php echo $this->ns; ?>fbtools_comments_numposts" value="<?php echo get_option($this->ns.'fbtools_comments_numposts'); ?>" />
                        The number of comments to show by default. Default: 10.
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Width</th>
					<td>
                    	<input type="text" name="<?php echo $this->ns; ?>fbtools_comments_width" value="<?php echo get_option($this->ns.'fbtools_comments_width'); ?>" />
                        The width of the plugin in pixels. Minimum width: 500px.
                    </td>
				</tr>
            </table>
            <h3>Legacy Comments Box</h3>
            <p>All settings below only take effect if "Use New Comment Box" is unchecked under Global Settings.</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Reverse Order</th>
					<td>
                    	<input type="checkbox" name="<?php echo $this->ns; ?>fbtools_comments_reverse" <?php echo (get_option($this->ns.'fbtools_comments_reverse')) ? "checked=\"checked\"" : ""; ?> />
                        Changes the order of comments and comment area to allow greater customization.
                    </td>
				</tr>
				<tr valign="top">
					<th scope="row">Stylesheet</th>
					<td>
                    	<input type="text" name="<?php echo $this->ns; ?>fbtools_comments_css" value="<?php echo get_option($this->ns.'fbtools_comments_css'); ?>" />
						The name of your stylesheet that is located in your theme folder. (Example: facebook.css)
                    </td>
				</tr>
			</table>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
			</form>
		</div>
	<?php
	}

	public function settings_likebutton() { ?>
		<div class="wrap">
			<h2>Facebook Tools - Like Button</h2>
			<form method="post" action="options.php">
			<?php settings_fields($this->ns.'fbtools_likebutton_settings'); ?>
			<?php do_settings_fields($this->ns.'fbtools_likebutton_settings'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">URL</th>
					<td>
                    	<input type="text" name="<?php echo $this->ns; ?>fbtools_likebutton_href" value="<?php echo get_option($this->ns.'fbtools_likebutton_href'); ?>" />
                        The URL to like. The XFBML version defaults to the current page.
                    </td>
				</tr>
                <tr valign="top">
                	<th scope="row">Layout</th>
                    <td>
                    	<?php $options = array('standard','button_count','box_count'); ?>
                    	<select name="<?php echo $this->ns; ?>fbtools_likebutton_layout">
                        	<?php foreach($options as $option) : ?>
                        	<option value="<?php echo $option; ?>" <?php echo (get_option($this->ns.'fbtools_likebutton_layout')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <ul style="font-size:11px;">
                            <li>standard - Displays social text to the right of the button and friends' profile photos below. Minimum width: 225 pixels. Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).</li>
							<li>button_count - Displays the total number of likes to the right of the button. Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.</li>
							<li>box_count - Displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.</li>
						</ul>
                    </td>
                </tr>
				<tr valign="top">
					<th scope="row">Width</th>
					<td>
                    	<input type="text" name="<?php echo $this->ns; ?>fbtools_likebutton_width" value="<?php echo get_option($this->ns.'fbtools_likebutton_width'); ?>" />
                        The width of the Like button. (in pixels)
                    </td>
				</tr>
                <tr valign="top">
                	<th scope="row">Action</th>
                    <td>
                    	<?php $options = array('like','recommend'); ?>
                    	<select name="<?php echo $this->ns; ?>fbtools_likebutton_action">
                        	<?php foreach($options as $option) : ?>
                        	<option value="<?php echo $option; ?>" <?php echo (get_option($this->ns.'fbtools_likebutton_action')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                        The verb to display on the button.
                    </td>
                </tr>
                <tr valign="top">
                	<th scope="row">Color Scheme</th>
                    <td>
                    	<?php $options = array('light','dark'); ?>
                    	<select name="<?php echo $this->ns; ?>fbtools_likebutton_colorscheme">
                        	<?php foreach($options as $option) : ?>
                        	<option value="<?php echo $option; ?>" <?php echo (get_option($this->ns.'fbtools_likebutton_colorscheme')==$option) ? 'selected="selected"' : ''; ?>><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                        The color scheme for the like button.
                    </td>
                </tr>
			</table>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" /></p>
			</form>
		</div>
    <?php }

	public function load_sdk() {
		$app_id = get_option($this->ns.'fbtools_app_id'); ?>
<div id="fb-root"></div>
<script type="text/javascript" language="javascript">
  window.fbAsyncInit = function() {
    FB.init({
		appId: '<?php echo $app_id; ?>',
		status: true,
		cookie: true,
		xfbml: true
	});
  };
  
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js#appId=<?php echo get_option($this->ns.'fbtools_app_id');?>&xfbml=1';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>


<?php
	}

	public function fb_comments($post) {
		$params = '';
		if($width=get_option($this->ns.'fbtools_comments_width')) { $params .= ' width="'.$width.'"'; }
		if($numposts=get_option($this->ns.'fbtools_comments_numposts')) { $params .= ' numposts="'.$numposts.'"'; }
		if($migrated=get_option($this->ns.'fbtools_comments_migrated')) {
			$params .= ' href="'.$this->currentURI.'"';
		}
		else {
			$params .= ' xid="'.urlencode($this->currentURI).'"';
			if($reverse=get_option($this->ns.'fbtools_comments_reverse')) { $params .= ' reverse="'.(($reverse=="on")?1:0).'"'; }
			if($css=get_option($this->ns.'fbtools_comments_css')) { $params .= ' css="'.get_bloginfo('template_directory').'/'.$css.'?'.time().'"'; }
		}
		return '<fb:comments '.$params.'></fb:comments>';
	}

	public function fb_commentcount($post) {
		$migrated = get_option($this->ns.'fbtools_comments_migrated');
		$fql = 'SELECT count FROM comments_info WHERE app_id = \''.get_option($this->ns.'fbtools_app_id').'\' AND xid = \''.urlencode($this->currentURI).'\'';
		if($migrated) { $fql = 'SELECT commentsbox_count FROM link_stat WHERE url = \''.$this->currentURI.'\''; }
		$url = 'https://api.facebook.com/method/fql.query?access_token='.$this->token.'&query='.urlencode($fql);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		$xml = new SimpleXMLElement($res);
		$count = 0;
		if($migrated) { $count = (isset($xml->link_stat->commentsbox_count)) ? (string) $xml->link_stat->commentsbox_count : 0; }
		else { $count = (isset($xml->comments_info)) ? (string) $xml->comments_info->count : 0; }
		return $count;
	}

	public function fb_likebutton() {
		$params = '';
		if($href=get_option($this->ns.'fbtools_likebutton_href')) { $params .= ' href="'.$href.'"'; }
		if($layout=get_option($this->ns.'fbtools_likebutton_layout')) { $params .= ' layout="'.$layout.'"'; }
		if($width=get_option($this->ns.'fbtools_likebutton_width')) { $params .= ' width="'.$width.'"'; }
		if($colorscheme=get_option($this->ns.'fbtools_likebutton_colorscheme')) { $params .= ' colorscheme="'.$colorscheme.'"'; }
		if($action=get_option($this->ns.'fbtools_likebutton_action')) { $params .= ' action="'.$action.'"'; }
		return '<fb:like '.$params.'></fb:like>';
	}

}

$thePlugin = new UprisingCreative_FacebookTools();
add_action('admin_menu',array(&$thePlugin,'add_menus'));

//Template functions
function fb_comments() {
	global $post, $thePlugin;
	echo $thePlugin->fb_comments($post);
}

function fb_commentcount() {
	global $post, $thePlugin;
	echo $thePlugin->fb_commentcount($post);
}

function fb_likebutton() {
	global $post, $thePlugin;
	echo $thePlugin->fb_likebutton();
}

?>