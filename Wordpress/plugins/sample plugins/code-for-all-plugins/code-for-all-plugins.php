<?php
/*
Plugin Name:       Code for All Plugins
Description:       Example plugin for the video tutorial series, "WordPress: Plugin Development", available at Lynda.com.
Plugin URI:        https://profiles.wordpress.org/specialk
Contributors:      (list of wordpress.org usernames)
Author:            Tahir
Author URI:        https://bytebunch.com/
Donate link:       https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=GR8NLRVEVE2P6&lc=US&item_name=Clan%20BvO&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags:              example, boilerplate
Version:           1.0
Stable tag:        1.0
Requires at least: 4.5
Tested up to:      4.8
Text Domain:       code-for-all-plugins
Domain Path:       /languages
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// constant for plugin directory path
define('CODE_FOR_ALL_PLUGINS_URL', plugin_dir_url(__FILE__));
define('CODE_FOR_ALL_PLUGINS_ABS', plugin_dir_path( __FILE__ ));
define('CODE_FOR_ALL_PLUGINS_FILE', plugin_basename(__FILE__));

//initialize the plugin with main class.
if(!class_exists('CodeForAllPlugins')){
	include_once CODE_FOR_ALL_PLUGINS_ABS.'includes/classes/CodeForAllPlugins.php';
	$CodeForAllPlugins = new CodeForAllPlugins();
}
