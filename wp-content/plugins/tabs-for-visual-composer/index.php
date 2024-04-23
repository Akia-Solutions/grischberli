<?php 

	/*
	Plugin Name: Tabs for WPBakery Page Builder
	Description: Easy way to display your content in tabs.
	Plugin URI: http://webdevocean.com
	Author: labibahmed
	Author URI: http://webdevocean.com/
	Version: 1.2
	License: GPL2
	Text Domain: wdo-tabs
	*/
	
	include 'plugin.class.php';
	if (class_exists('VC_WDO_Tabs')) {
	    $obj_init = new VC_WDO_Tabs;
	}

 ?>