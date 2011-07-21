<?php
/*
Plugin Name: Facebook Tools
Plugin URI: http://www.theuprisingcreative.com/
Description: Add Facebook support to your WordPress blog.
Version: 1.2.1
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

define('UPRISINGCREATIVE_FACEBOOKTOOLS_PLUGIN_FILE',__FILE__);
define('UPRISINGCREATIVE_FACEBOOKTOOLS_PLUGIN_PATH',dirname(__FILE__));

include('uprisingcreative.facebooktools.php');
include('functions.php');

$thePlugin = new UprisingCreative_FacebookTools(UPRISINGCREATIVE_FACEBOOKTOOLS_PLUGIN_FILE);

##	Add Menus
add_action('admin_menu','uprising_fbtools_add_menus');

function uprising_fbtools_add_menus() {
	add_menu_page('Facebook Tools','Facebook Tools',6,'facebook-tools/admin/settings_default','uprising_fbtools_admin_settings_default');
	add_submenu_page('facebook-tools/admin/settings_default','Facebook Tools - Comments','Comments',6,'facebook-tools/admin/settings_comments','uprising_fbtools_admin_settings_comments');
	add_submenu_page('facebook-tools/admin/settings_default','Facebook Tools - Like Button','Like Button',6,'facebook-tools/admin/settings_likebutton','uprising_fbtools_admin_settings_likebutton');
	add_submenu_page('facebook-tools/admin/settings_default','Facebook Tools - Send Button','Send Button',6,'facebook-tools/admin/settings_sendbutton','uprising_fbtools_admin_settings_sendbutton');
	add_action('admin_init','uprising_fbtools_register_settings');
}

##	Register Settings
function uprising_fbtools_register_settings() {
	//General
	register_setting('uprisingcreative_fbtools_settings','uprisingcreative_fbtools_app_id');
	register_setting('uprisingcreative_fbtools_settings','uprisingcreative_fbtools_api_key');
	register_setting('uprisingcreative_fbtools_settings','uprisingcreative_fbtools_api_secret');
	register_setting('uprisingcreative_fbtools_settings','uprisingcreative_fbtools_facebook_url');
	register_setting('uprisingcreative_fbtools_settings','uprisingcreative_fbtools_disable_opengraph');
	//Comments
	register_setting('uprisingcreative_fbtools_comments_settings','uprisingcreative_fbtools_comments_numposts');
	register_setting('uprisingcreative_fbtools_comments_settings','uprisingcreative_fbtools_comments_reverse');
	register_setting('uprisingcreative_fbtools_comments_settings','uprisingcreative_fbtools_comments_migrated');
	register_setting('uprisingcreative_fbtools_comments_settings','uprisingcreative_fbtools_comments_width');
	register_setting('uprisingcreative_fbtools_comments_settings','uprisingcreative_fbtools_comments_css');
	register_setting('uprisingcreative_fbtools_comments_settings','uprisingcreative_fbtools_comments_colorscheme');
	//Like
	register_setting('uprisingcreative_fbtools_likebutton_settings','uprisingcreative_fbtools_likebutton_href');
	register_setting('uprisingcreative_fbtools_likebutton_settings','uprisingcreative_fbtools_likebutton_send');
	register_setting('uprisingcreative_fbtools_likebutton_settings','uprisingcreative_fbtools_likebutton_layout');
	register_setting('uprisingcreative_fbtools_likebutton_settings','uprisingcreative_fbtools_likebutton_width');
	register_setting('uprisingcreative_fbtools_likebutton_settings','uprisingcreative_fbtools_likebutton_colorscheme');
	register_setting('uprisingcreative_fbtools_likebutton_settings','uprisingcreative_fbtools_likebutton_action');
	//Send
	register_setting('uprisingcreative_fbtools_sendbutton_settings','uprisingcreative_fbtools_sendbutton_href');
	register_setting('uprisingcreative_fbtools_sendbutton_settings','uprisingcreative_fbtools_sendbutton_font');
	register_setting('uprisingcreative_fbtools_sendbutton_settings','uprisingcreative_fbtools_sendbutton_colorscheme');
	register_setting('uprisingcreative_fbtools_sendbutton_settings','uprisingcreative_fbtools_sendbutton_ref');
}

##	Admin Pages
function uprising_fbtools_admin_settings_default() {
	include('admin/settings_default.php');
}
function uprising_fbtools_admin_settings_comments() {
	include('admin/settings_comments.php');
}
function uprising_fbtools_admin_settings_likebutton() {
	include('admin/settings_likebutton.php');
}
function uprising_fbtools_admin_settings_sendbutton() {
	include('admin/settings_sendbutton.php');
}

?>