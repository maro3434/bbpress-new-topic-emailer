<?php
/**
 * @package bbPress New Topic Emailer
 * @version 1.0
 */
/*
Plugin Name: bbPress New Topic Emailer
Plugin URI: http://UpTrending.com
Description: Register email addresses to be notified whenever a new topic is created in the specified bbPress Forum. Created for and in cooperation with Hortonworks http://hortonworks.com
Author: Matt Keys
Version: 1.0
Author URI: http://UpTrending.com
*/

/*  Copyright 2013  UpTrending  (email : matt@uptrending.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Path to this file
if ( !defined('HNTE_PLUGIN_FILE') ){
    define('HNTE_PLUGIN_FILE', __FILE__);
}

//Path to the plugin's directory
if ( !defined('HNTE_DIRECTORY') ){
    define('HNTE_DIRECTORY', dirname(__FILE__));
}

//Publicly Accessible path
if ( !defined('HNTE_PUBLIC_PATH') ){
    define('HNTE_PUBLIC_PATH', plugin_dir_url(__FILE__));
}

//Load the actual plugin
require 'core/init.php';
require 'core/admin.php';
require 'core/core.php';

?>